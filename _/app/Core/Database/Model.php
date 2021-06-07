<?php
namespace Project\Core\Database;
use  Project\Core\{Application,Entity};

abstract class Model{
    protected static string $table_name;
    public static string $primary_key;
    public static array $foreign_keys;

    // Show
    public static function selectOne(array $where){
        $table = get_called_class()::$table_name;
        
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        
        $request = self::prepare("SELECT * FROM  $table  WHERE  $sql_condition");
        $request->execute($where);
        return $request->fetchObject();   
    }
    public static function selectWhere(array $where){
        $table = get_called_class()::$table_name;
        
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        
        $request = self::prepare("SELECT * FROM  $table  WHERE  $sql_condition");
        $request->execute($where);
        return $request->fetchAll();   
    }
    public static function selectAll(){
        $table = get_called_class()::$table_name;
        
        $request = self::prepare("SELECT * FROM $table");
        $request->execute();
        
        return $request->fetchAll();
    }
    // Insert
    public static function insert(array $entity){
        $table = get_called_class()::$table_name;
        $attributes = array_keys($entity);
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $request = self::prepare(
            "INSERT INTO $table (".implode(',',$attributes).") 
            VALUES (".implode(',',$params).")");
        $request->execute($entity);
        return true;
    }
    // Update
    public static function updateWhere(array $entity,array $where){
        $table = get_called_class()::$table_name;
        $data = implode(", ", self::arrayToSqlAssoc($entity));
        $sql_condition = implode(" AND ", $where);
        
        $request = self::prepare("UPDATE $table SET $data WHERE $sql_condition");
        $request->execute($entity);
        return $request;
    }
    // Delete
    public static function deleteOn($where): bool{
        $class = get_called_class();
        $table = $class::$table_name;

        if(is_string($where) || is_int($where)){
            $primaryKey = $class::$primary_key;
            $where = [$primaryKey => $where];
        }
        if(is_array($where)){
            $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        }else{
            return false;
        }
        
        $request = self::prepare("DELETE FROM $table WHERE $sql_condition");
        $request->execute($where);
        
        return true;
    }

    
    // Entity Interaction methods
    public static function uniqueAttributes(): array{
        return [];
    }
    abstract static public function requiredAttributes(): array;
    abstract static public function editableAttributes(): array;
    
    // Sql helper methods
    protected static function arrayToSqlAssoc(array $attributes): array{
        return array_map(fn($attr) => "$attr = :$attr", array_keys($attributes));
    }
    protected static function prepare($request){
        return Application::$app->db::$pdo->prepare($request);
    }

}
