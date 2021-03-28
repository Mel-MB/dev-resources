<?php
namespace Project\Core;
use  Project\Core\{Application,Entity};

abstract class Manager{
    private string $tableName;
    public string $primarykey;
    public array $foreignKeys;

    protected function __construct(string $tableName,string $primarykey,array $foreignKeys =[]){
        $this->tableName = $tableName;
        $this->primarykey = $primarykey;
        $this->foreignKeys = $foreignKeys;
    }
    
    public function create(object $sqlEntity){
        try{
            $tableName = $this->tableName;
            
            $request = self::prepare(
                "INSERT INTO $tableName (".implode(',',$sqlEntity->attributes).") 
                VALUES (".implode(',',$sqlEntity->params).")");
                $request->execute($sqlEntity->data);
                
            return true;
        }catch(\PDOException $e){
            var_dump($e->getMessage());
            return false;
        }
    }
    
    public function selectAll(){
        $tableName = $this->tableName;
        
        $request = self::prepare("SELECT * FROM $tableName");
        $request->execute();
        
        return $request->fetchAll();
        
    }
    
    public function selectOne(array $where){
        $tableName = $this->tableName;
        
        $attributes = array_keys($where);
        $sql_condition = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        
        
        $request =  self::prepare("SELECT * FROM  $tableName  WHERE  $sql_condition");
        $request->execute($where);
        return $request->fetchObject();
        
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

}
