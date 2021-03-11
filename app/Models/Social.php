<?php

namespace Project\Models;

class Social extends Manager {
    const TABLE_NAME = 'socials';

    public static function create($type, $url,$user_id){
        try {
            $db= self::dbConnect();
        
            //Start SQL transaction
            $db->beginTransaction();

            //Create social
            $social = $db->prepare('INSERT INTO `socials`(type,url) VALUES(?,?)');
            $social->execute([$type,$url]);

            $social_id = $db->lastInsertId();

            //Link the new social to user
            $user_social = $db->prepare('INSERT INTO `user_socials`(user_id,social_id) VALUES(?,?)');
            $user_social->execute([
                'u_id'=>$user_id,
                's_id'=>$social_id
                ]);

            $result = $db->commit();

        } catch (\Exception $e) {
            $db->rollBack();

            $result = "Erreur: " . $e->getMessage();
        }
        return $result;
    }

    public function update($id,$url){
        $request = $this->dbConnect()->prepare('UPDATE `socials` SET `url`= :url WHERE id= :id');
        $request->execute([
            'url' => $url,
            'id' => $id
        ]);
        return $request;
    }

}