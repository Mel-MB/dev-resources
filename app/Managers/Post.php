<?php

namespace Project\Managers;

class Post extends Manager {
    const TABLE_NAME = 'posts';

    public function __construct(){
        $this->db = self::dbConnect();
    }
    public static function create($content, $user_id){
        $request = self::dbConnect()->prepare('INSERT INTO `posts`(content,user_id) VALUES( :content, :userId)');
        $request->execute([
            'content' => $content,
            'userId' => $user_id
        ]);
        return $request;
    }
    public static function allPosts(){
        $request = self::dbConnect()->query('SELECT p.*, u.pseudo FROM `posts` AS p INNER JOIN `users` AS u ON u.id = p.user_id ORDER BY p.id DESC');

        $result = $request->fetchAll();
        return $result;
    }
    public static function user_posts($user_id){
        $request = self::dbConnect()->prepare('SELECT * FROM `posts` WHERE user_id= ? ORDER BY id DESC');
        $request->execute([$user_id]);

        $result= $request->fetchAll();
        return $result;
    }
    public function update($post_id, $content){
        $request = $this->db->prepare('UPDATE `posts` SET content= :content WHERE id= :id');
        $request->execute([
            'content' => $content,
            'id' => $post_id
        ]);
        return $request;
    }
}