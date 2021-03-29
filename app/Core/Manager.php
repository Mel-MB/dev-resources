<?php
namespace Project\Core;
use  Project\Core\{Application,Entity};

class Manager{
    private static string $tableName;
    public static string $primarykey;
    public static array $foreignKeys;

    public function __construct(string $tableName,string $primarykey,array $foreignKeys =[]){
        self::$tableName = $tableName;
        self::$primarykey = $primarykey;
        self::$foreignKeys = $foreignKeys;
    }
    
    public function create(array $entity){
        $tableName  = self::$tableName;
        $attributes = array_keys($entity);
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $request = self::prepare(
            "INSERT INTO $tableName (".implode(',',$attributes).") 
            VALUES (".implode(',',$params).")");
        $request->execute($entity);
            
        return true;
    }
    
    public function selectOne(array $where){
        $tableName = self::$tableName;
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        
        $request = self::prepare("SELECT * FROM  $tableName  WHERE  $sql_condition");
        $request->execute($where);
        return $request->fetchObject();
        
    }
    public function selectAll(){
        $tableName = $this->tableName;
        
        $request = self::prepare("SELECT * FROM $tableName");
        $request->execute();
        
        return $request->fetchAll();
    }

    public function update(array $entity,array $where){
        $tableName = self::$tableName;
        $data = implode(", ", self::arrayToSqlAssoc($entity));
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));

        $request = self::prepare("UPDATE $tableName SET $data WHERE $sql_condition");
        $request->execute($entity + $where);
        return $request;
    }
    /** Most probably a bad idea to keep the delete one public
     * TODO make it protected and implement a public function to define authorizations to delete
     *
     * in the Object class ?
     * in a specific controller ?
     **/
    public function delete($value){
        $tableName = $this->tableName;
        $primarykey = $this->primarykey;
        
        $query = "DELETE FROM $tableName WHERE $primarykey = ?";
        $request = self::prepare($query);
        $request->execute([$value]);
        
        return $request;
    }

    
    protected static function prepare($request){
        return Application::$app->db::$pdo->prepare($request);
    }

    protected static function arrayToSqlAssoc(array $array): array{
        $attributes = array_keys($array);
        return array_map(fn($attr) => "$attr = :$attr", $attributes);
    }

}
