<?php


class M003_tags{
    public function up() {
        $db = Project\Core\Application::$app->db;
        $SQL = 
            "CREATE TABLE `posts_tags` (
                `post_id` int(10) unsigned NOT NULL,
                `tag_id` int(10) unsigned DEFAULT NULL,
                KEY `post_tags_fk0` (`post_id`) USING BTREE,
                KEY `post_tags_fk1` (`tag_id`),
                CONSTRAINT `post_tags_fk0` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `post_tags_fk1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $db->pdo->exec($SQL);
    }
    
}