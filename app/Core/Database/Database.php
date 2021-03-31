<?php
namespace Project\Core\Database;

use Project\Core\Application;

class Database{
    public static \PDO $pdo;

    public function __construct(array $config){
        try{
            self::$pdo = new \PDO($config['dsn'],$config['user'],$config['password']);
            // configure pdo fetch return values
            self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            // configure pdo to display throw errors
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            die('Erreur: '.$e->getMessage());
        }
    }

    public function applyMigrations(){
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR.'/app/migrations');

        $migrationsToApply = array_diff($files, $appliedMigrations);
        $newMigrations = [];

        foreach($migrationsToApply as $migration){
            if($migration === '.' ||$migration === '..'){
                continue;
            }
            require_once Application::$ROOT_DIR.'/app/migrations/'.$migration;
            $className = pathinfo($migration,PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[]= $migration;
        }

        if(!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            $this->log("All migrations are already applied");
        }
    }

    private function createMigrationsTable(){
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS migrations(
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration varchar(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
        ");
    }

    private function getAppliedMigrations(){
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        //Return resulst is as single dimensions arrays
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function saveMigrations(array $migrations){
        $str = implode(",", array_map(fn($m)=>"('$m')",$migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }

    private function log($message){
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}