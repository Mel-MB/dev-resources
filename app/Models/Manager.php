<?php

namespace Project\Models;

class Manager{
    static $pdo = null;

    protected static function dbConnect(){
        if(!self::$pdo){
            try{
                self::$pdo = new \PDO("mysql:host=localhost;dbname=kercode;charset=utf8","root","");
                //configure pdo to display errors => Interesting on develop mode, best practice is to remove it on prod for securoty matters
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch(\PDOException $e){
                die('Erreur: '.$e->getMessage());
            }
        }
        return self::$pdo;
    }
}
