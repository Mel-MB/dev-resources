<?php
namespace Project\Core\Database;
use  Project\Core\{Application,Entity};

abstract class Model{
    protected static string $tableName;
    protected static string $primaryKey;

    public function __construct(string $tableName, string $primarykey = null, array $foreignKeys = null, object $relationnalTable = null){
        self::$tableName = $tableName;
        if($primarykey) self::$primaryKey = $primarykey;
    }
    
    public function insert(array $entity){
        $tableName  = self::$tableName;
        $attributes = array_keys($entity);
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $request = self::prepare(
            "INSERT INTO $tableName (".implode(',',$attributes).") 
            VALUES (".implode(',',$params).")");
        $request->execute($entity);
        return true;
    }
    
    public static function selectOne(array $where){
        $tableName = get_called_class()::$tableName;
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        
        $request = self::prepare("SELECT * FROM  $tableName  WHERE  $sql_condition");
        $request->execute($where);
        return $request->fetchObject();
        
    }
    public static function selectAll(){
        $tableName = get_called_class()::$tableName;
        
        $request = self::prepare("SELECT * FROM $tableName");
        $request->execute();
        
        return $request->fetchAll();
    }

    public function updateWhere(array $entity,array $where){
        $tableName = self::$tableName;
        $attributes = array_keys($entity);
        $data = implode(", ", self::arrayToSqlAssoc($entity));
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));

        $request = self::prepare("UPDATE $tableName SET $data WHERE $where");
        $request->execute($entity);
        return $request;
    }

    public static function deleteOn($where): bool{
        $class = get_called_class();
        $tableName = $class::$tableName;

        if(is_array($where)){
            $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        }elseif(is_string($where)){
            $primaryKey = $class::$primaryKey;
            $sql_condition = "$primaryKey = :$where";
            $where[$primaryKey] = $where;
        }else{
            return false;
        }
        
        $query = "DELETE FROM $tableName WHERE $sql_condition";
        $request = self::prepare($query);
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
        return array_map(fn($attr) => "$attr = :$attr", $attributes);
    }
    protected static function prepare($request){
        return Application::$app->db::$pdo->prepare($request);
    }

}
