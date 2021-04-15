<?php

namespace Project\Models;

use Project\Core\Database\Model;

class Tag extends Model{
    protected static string $table_name                = 'tags';
    public static string $primary_key                  = 'id';
    protected static string $relationnal_table         = Posts_Tags::class; 

    public static function selectTop5(){
        $request = self::prepare("
            SELECT t.* , COUNT(pt.post_id)
            FROM `tags` t
            INNER JOIN posts_tags pt ON t.id = pt.tag_id
            GROUP BY t.id
            ORDER BY COUNT(pt.post_id) DESC LIMIT 5;
        ");
        $request->execute();
        $result = $request->fetchAll();
        
        return $result ?? [];
    } 
    public static function requiredAttributes(): array {
        return ['name'];
    }
    public static function editableAttributes(): array {
        return [];
    }
}