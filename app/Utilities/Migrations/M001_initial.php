<?php


class M001_initial{
    public function up() {
        $db = Project\Core\Application::$app->db;
        $SQL = 
            "CREATE TABLE `users` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username` CHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `email` CHAR(255) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `tags` VARCHAR(250) NULL DEFAULT NULL,
                `password` VARCHAR(500) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `job` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `own_website` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `github` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `linkedin` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `discord` VARCHAR(30) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `codepen` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                `role` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`) USING BTREE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB
            AUTO_INCREMENT=15;";

        $db->pdo->exec($SQL);
    }
    public function down() {
        $db = Project\Core\Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}