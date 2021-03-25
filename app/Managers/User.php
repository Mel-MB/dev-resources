<?php
namespace Project\Managers;

use Project\Core\Application;
use Project\Entities\User as UserEntity;
Use \Project\Managers\Social;


class User extends Manager{
    const TABLE_NAME = 'users';

    protected static function tableName():string{
        return self::TABLE_NAME;
    }

    public static function selectEditable($user_id){
        // Select user data
        $user = self::prepare("SELECT pseudo, email, promotion, job FROM `users` WHERE id= ?");
        $user->execute([$user_id]);
        $user_data= $user->fetch();
        // Select social networks filled by user
        $user_socials = Social::selectByUser($user_id);
        if($user_socials){
            foreach($user_socials as $social){
                $user_data['socials'][$social['type']] = $social['url'];
            }
        }
        return $user_data;
    }
    
    public function update($user_data,$socials_data){
        try {
            $db= Application::$app->db->pdo;
        
            //Start SQL transaction
            $db->beginTransaction();

            //Update user data
            $user_update = $db->prepare("UPDATE `users` SET pseudo= :username, email= :email, promotion= :promotion, job= :job WHERE id= :id");
            $user_update->execute($user_data);
            
            $user_socials = Social::selectByUser($user_data['id']);

            foreach($socials_data as $type => $url){
                
                if($user_socials){
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