<?php


class M002_posts{
    public function up() {
        $db = Project\Core\Application::$app->db;
        $SQL = 
            "CREATE TABLE `posts` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `content` text,
                `publication` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `user_id` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id`),
                KEY `FK_post_user` (`user_id`) USING BTREE,
                CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
              ) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;";

        $db->pdo->exec($SQL);
    }
    
}