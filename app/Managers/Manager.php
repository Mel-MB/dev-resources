<?php

namespace Project\Managers;

use Project\Core\Application;
use Project\Entities\Entity;

abstract class Manager{
    protected abstract static function tableName():string;
       
    protected static function prepare($request){
        return Application::$app->db::$pdo->prepare($request);
    }
    protected static function tableize(Entity $entity, array $attributes){
        $tableName = get_called_class()::tableName();

        $sql_params = array_map(fn($attr) =>":$attr", $attributes);
        $sql_data = [];
        foreach($attributes as $attribute){
            $sql_data[$attribute] = $entity->{$attribute};
        };

        return (object)['tableName' => $tableName,'params' => $sql_params,'data' => $sql_data];
    }
    public static function create(Entity $entity){
        try{
            $attributes = $entity->requiredAttributes();
            $table = self::tableize($entity,$attributes);
            
            $request = self::prepare(
                "INSERT INTO $table->tableName (".implode(',',$attributes).") 
                VALUES (".implode(',',$table->params).")");
            $request->execute($table->data);

            return true;
        }catch(\PDOException $e){
            die('Erreur: '.$e->getMessage());
        }
    }

    public static function all(){
        $tableName = self::tableName();

        $query = "SELECT * FROM $tableName";
        $request = self::prepare($query);
        $request->execute();

        $results = $request->fetchAll();
        return $results;
    }

    public static function alreadyExists($db_column,$value){
        $tableName = get_called_class()::tableName();

        $request =  self::prepare("SELECT * FROM  $tableName  WHERE  $db_column  = :value");
        $request->execute([
            'value' => $value
        ]);
        $alreadyexists = $request->fetchObject();

        return $alreadyexists;
    }
    public static function selectBy($db_column,$value){
        $class= get_called_class();

        $request =  self::prepare('SELECT * FROM `'.$class::TABLE_NAME.'` WHERE '.$db_column.' = :value');
        $request->execute([
            'value' =>  $value,
        ]);
        
        $result = $request->fetch();

        return $result;
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
        $request = self::prepare($query);
        $request->execute([$id]);

        return $request;
    }

}
