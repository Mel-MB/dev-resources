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

    public function update($id,$url){
        $request = $this->dbConnect()->prepare('UPDATE `socials` SET `url`= :url WHERE id= :id');
        $request->execute([
            'url' => $url,
            'id' => $id
        ]);
        return $request;
    }

}