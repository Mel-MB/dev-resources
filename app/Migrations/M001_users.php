<?php


class M001_users{
    public function up() {
        $db = Project\Core\Application::$app->db;
        $SQL = 
            "CREATE TABLE `users` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `username` char(50) DEFAULT NULL,
                `email` char(255) DEFAULT NULL,
                `password` varchar(500) DEFAULT NULL,
                `job` varchar(50) DEFAULT NULL,
                `own_website` varchar(150) DEFAULT NULL,
                `github` varchar(150) DEFAULT NULL,
                `linkedin` varchar(150) DEFAULT NULL,
                `discord` varchar(30) DEFAULT NULL,
                `codepen` varchar(150) DEFAULT NULL,
                `role` tinyint(1) unsigned NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;";

        $db->pdo->exec($SQL);
    }
    
}