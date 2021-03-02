<?php
namespace Project\Models;

class UsersManager extends Manager{
    public function __construct(){
        $this->db = $this->dbConnect();
    }
    public function createUser($firstname, $name, $promotion,$email,$password){
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
    public function retrieveInfos($email){
        $request = $this->db->prepare('SELECT * FROM `users` WHERE `email`=?');
        $request->execute(array($email));

        return $request;
    }
}