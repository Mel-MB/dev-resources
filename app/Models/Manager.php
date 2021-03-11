<?php

namespace Project\Models;

class Manager{
    static $pdo = null;

    protected static function dbConnect(){
        if(!self::$pdo){
            try{
                self::$pdo = new \PDO("mysql:host=localhost;dbname=kercode;charset=utf8","root","");
                //configure pdo to display errors => Interesting on develop mode, best practice is to remove it on prod for security matters
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }catch(\PDOException $e){
                die('Erreur: '.$e->getMessage());
            }
        }
        return self::$pdo;
    }
    public static function all(){
        $class= get_called_class();

        $query = "SELECT * FROM `".$class::TABLE_NAME."`";
        $request = self::dbConnect()->query($query);

        $results = $request->fetchAll();
        return $results;
    }
    public static function selectBy($db_column,$value){
        $request =  self::dbConnect()->prepare('SELECT * FROM `".$class::TABLE_NAME."` WHERE :column = :value');
        $request->execute([
            'column'=> $db_column,
            'value' => $value
        ]);
        
        $result = $request->fetch();

        return $result;
    }

    public static function alreadyExists($db_column,$value){
        $class= get_called_class();

        $request =  self::dbConnect()->prepare("SELECT count(*) FROM `".$class::TABLE_NAME."` WHERE :column = :value");
        $request->execute([
            'column'=> $db_column,
            'value' => $value
        ]);
        $alreadyexists =$request->fetch()[0];

        return $alreadyexists;
    }
    /** Most probably a bad idea to keep the delete one public
    * TODO make it protected and implement a public function to define authorizations to delete
    *
    * in the Object class ?
    * in a specific controller ?
    **/
    public static function delete($id){
        $class= get_called_class();

        $query = "DELETE FROM `".$class::TABLE_NAME."` WHERE id = ?";
        $request = self::dbConnect()->query($query);
        $request->execute([$id]);

        return $request;
    }

}
