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
    public static function selectEditable($id){ 
        $request = self::dbConnect()->prepare(
            "SELECT 
                u.pseudo AS pseudo,
                u.email AS email,
                u.promotion AS promotion,
                u.job AS job

            FROM `users` AS u
            INNER JOIN `socials` AS s ON u.id = s.user_id
            WHERE u.id= ?"
        );
        $request->execute([$id]);

        $result= $request->fetch();
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
            $query = $db->prepare("SELECT count(*) FROM `socials` WHERE user_id=?");
            $query->execute([$user_data['id']]);
            $user_has_socials = $query->fetch()['0'];

            if($user_has_socials){
                $query_socials = $db->prepare("SELECT * FROM `socials` WHERE `user_id`=?");
                $query_socials->execute([$user_data['id']]);
                $user_socials = $query_socials->fetchAll();
            }


            foreach($socials_data as $type => $url){
                
                if($user_has_socials){
                    //Loop on socials linked to this user
                    foreach($user_socials as $social){
                        // Check if registered social matchs with given data
                        if($social['type'] === $type){
                            // Update the row on matched data
                            $matching_data = $socials_data[$social['type']];
                            $s = new Social;
                            $updated_social = $s->update($social['id'],$matching_data);
                            // Go to the next iteration of the parent loop
                            continue 2;   
                        }
                    }
                    // Check if user filled the url
                    if($url){
                        $social = Social::create($type,$url,$user_data['id']);
                    }
                    
                }else{
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