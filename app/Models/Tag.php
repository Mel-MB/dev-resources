<?php

namespace Project\Models;

use Project\Core\Database\Model;

class Tag extends Model{
    protected static Model $relationnalTable;
    
    private const TABLE_NAME                = 'tags';
    protected const PRIMARY_KEY             = 'id';
    protected const RELATIONNAL_TABLE_NAME  = [
        'tableName' => 'posts_tags',
        'foreignKeys'=> [
            'post_id' => ['posts' => 'id'],
            'tag_id' => ['tags' => 'id'],
        ]
    ];

    public function __construct(string $tableName = null){
        self::$tableName = self::TABLE_NAME;
        self::$primaryKey = self::PRIMARY_KEY;
        self::$relationnalTable = new Manager(self::RELATIONNAL_TABLE['tableName'],self::RELATIONNAL_TABLE['foreignKeys']);
    }

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