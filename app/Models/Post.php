<?php

namespace Project\Models;

class Post extends Manager {
    public function __construct(){
        $this->db = self::dbConnect();
    }
    public function create($link, $content, $user_email){
        $request = $this->db->prepare('INSERT INTO `posts`(link,content,user_id) VALUES( :link, :content, (SELECT `id` FROM `users` WHERE `email`= :userEmail))');
        $request->execute([
            'link' => $link,
            'content' => $content,
            'userEmail' => $user_email
        ]);
        return $request;
    }
    public function retrievePosts(){
        $request = $this->db->query('SELECT p.*, u.name, u.firstname FROM `posts` AS p INNER JOIN `users` AS u ON u.id = p.user_id ORDER BY p.id DESC');

        $result = $request->fetchAll();
        return $result;
    }
    public function retrievePost($id){
        $request = $this->db->prepare('SELECT * FROM `posts` WHERE id= ?');
        $request->execute([$id]);

        $result= $request->fetch();
        return $result;
    }
    public function user_posts($user_id){
        $request = $this->db->prepare('SELECT * FROM `posts` WHERE user_id= ? ORDER BY id DESC');
        $request->execute([$user_id]);

        $result= $request->fetchAll();
        return $result;
    }
    public function update($id, $link, $content){
        $request = $this->db->prepare('UPDATE `posts` SET link= :link, content= :content WHERE id= :id');
        $request->execute([
            'link' => $link,
            'content' => $content,
            'id' => $id
        ]);
        return $request;
    }
    public function delete($id){
        $request = $this->db->prepare('DELETE FROM `posts` WHERE id= ?');
        $request->execute([$id]);

        return $request;
    }
}