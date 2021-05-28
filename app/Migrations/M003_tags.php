<?php


class M003_tags{
    public function up() {
        $db = Project\Core\Application::$app->db;
        $SQL = 
            "CREATE TABLE `tags` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` char(20) NOT NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;";

        $db->pdo->exec($SQL);
    }
    
}