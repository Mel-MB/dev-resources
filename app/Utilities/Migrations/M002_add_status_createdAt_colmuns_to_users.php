<?php

class M002_add_status_createdAt_columns_to_users{
    public function up() {
        $db = Project\Core\Application::$app->db;
        $SQL = "ALTER TABLE users 
        ADD COLUMN `status` TINYINT NOT NULL,
        ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP;";

        $db->pdo->exec($SQL);
    }
    public function down() {
        $db = Project\Core\Application::$app->db;
        $SQL = "ALTER TABLE users 
        DROP COLUMN `status`,
        DROP COLUMN `created_at`;";
        $db->pdo->exec($SQL);
    }
}