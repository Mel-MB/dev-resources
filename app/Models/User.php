<?php
namespace Project\Models;

class User extends Manager{
    public function __construct(){
        $this->db = self::dbConnect();
    }
    public function create($firstname, $name, $promotion,$email,$password){
        $request = $this->db->prepare("INSERT INTO `users`(`email`,`password`,`firstname`,`name`,`promotion`) VALUES (?,?,?,?,?)");
        $request->execute(array($email,$password,$firstname, $name, $promotion));
        return $request;
    }
    public function exists($email){
        $request = $this->db->prepare("SELECT count(*) FROM `users` WHERE `email`=?");
        $request->execute([$email]);
        $alreadyexists =$request->fetch()[0];

        return $alreadyexists;
    }
    public function retrieveData($email){
        $request = $this->db->prepare('SELECT * FROM `users` WHERE `email`=?');
        $request->execute(array($email));
        
        $result = $request->fetch();

        return $result;
    }
}