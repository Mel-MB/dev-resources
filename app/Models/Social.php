<?php

namespace Project\Models;

class Social extends Manager {
    const TABLE_NAME = 'socials';

    public static function create($type, $url,$user_id){
        //Create social
        $social = self::dbConnect()->prepare('INSERT INTO `socials`(type,url,user_id) VALUES(?,?,?)');
        $social->execute([$type,$url,$user_id]);

        return $social;
    }
    
    public static function selectByUser($user_id){
        $db =self::dbConnect();

        //Check if user already registered social(s) 
        $query = $db->prepare("SELECT count(*) FROM `socials` WHERE user_id=?");
        $query->execute([$user_id]);
        $user_has_socials = $query->fetch()['0'];

        // Get all socials linked to this user
        if($user_has_socials){
            $query_socials = $db->prepare("SELECT * FROM `socials` WHERE `user_id`=?");
            $query_socials->execute([$user_id]);
            $user_socials = $query_socials->fetchAll();
        }

        return $user_socials ?? null;
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