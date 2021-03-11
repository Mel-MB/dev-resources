<?php
namespace Project\Models;
Use \Project\Models\Social;


class User extends Manager{
    const TABLE_NAME = 'users';


    public static function create($pseudo, $promotion,$email,$password){
        $request = self::dbConnect()->prepare("INSERT INTO `users`(`email`,`password`,`pseudo`,`promotion`) VALUES (?,?,?,?)");
        $request->execute(array($email,$password,$pseudo, $promotion));
        return $request;
    }

    public static function selectByEmail($email){
        $request =  self::dbConnect()->prepare('SELECT * FROM `users` WHERE `email`=?');
        $request->execute(array($email));
        
        $result = $request->fetch();

        return $result;
    }
    public function update($user_data,$socials_data){
        try {
            $db= $this->dbConnect();
        
            //Start SQL transaction
            $db->beginTransaction();

            //Update user data
            $user_update = $db->prepare("UPDATE `users` SET pseudo= :username, email= :email, promotion= :promotion, job= :job WHERE id= :id");
            $user_update->execute($user_data);

            //Check if user already registered social(s) 
            $query = $db->prepare("SELECT count(*) FROM `user_socials` WHERE user_id=?");
            $query->execute([$user_data['id']]);
            $user_has_socials = $query->fetch()['0'];

            if($user_has_socials){
                $query_socials = $db->prepare("SELECT * FROM `user_socials` WHERE `user_id`=?");
                $user_socials = $query_socials->execute([$user_data['id']])->fetchAll();

                //Loop on socials linked to this user
                foreach($user_socials as $us){
                    $social = Social::selectByID($us['id']);

                    // Check if registered social matchs with given data
                    if(in_array($social['type'],$socials_data)){
                        // Update the row on matched data
                        $matching_data = $socials_data[$social['type']];
                        $s = new Social;
                        $updated_social = $s->update($social['id'],$matching_data);
                    }else{
                        // Create missing rows
                        foreach($socials_data as $type => $url){
                            // Check if user filled the url
                            if($url){
                                $social = Social::create($type,$url,$user_data['id']);
                            }
        
                        } 
                    }
                }
            }else{

                foreach($socials_data as $type => $url){
                    // Check if user filled the url
                    if($url){
                        $social = Social::create($type,$url,$user_data['id']);
                    }

                }
            }            
            $result = $db->commit();
          
          } catch (\Exception $e) {
            $db->rollBack();
            $result = "Erreur: " . $e->getMessage();
          }
       
        
        return $result;

    }
}