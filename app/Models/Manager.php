<?php

namespace Project\Models;

class Manager{
    protected function dbConnect(){
        try{
            $db = new \PDO('mysql:host=localhost;dbname=kercode;charset=utf8','root','');
            return $db;
        }catch(\PDOException $e){
            die('Erreur: '.$e->getMessage());
        }
    }
}
