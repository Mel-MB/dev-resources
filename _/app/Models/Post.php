<?php

namespace Project\Models;

use Exception;
use Project\Core\Application;
use Project\Core\Database\Model;

class Post extends Model {
    protected static string $table_name                = 'posts';
    public static string $primary_key                  = 'id';
    public static array $foreign_keys                  = ['user_id' => ['users' => 'id']];
    protected static string $relationnal_table         = Posts_Tags::class;   
    

    // Show
    public static function selectOne(array $where){
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));

        $request = self::prepare("
        SELECT p.*, u.username, t.name AS tags 
        FROM `posts` p
        INNER JOIN `users` u ON u.id = p.user_id
        INNER JOIN posts_tags pt ON p.id = pt.post_id
        JOIN tags t ON pt.tag_id = t.id
        WHERE p.$sql_condition
        ORDER BY p.id DESC");
        
        $request->execute($where);
        $result = $request->fetchAll(\PDO::FETCH_GROUP);

        $post = self::visualise($result);
        return $post[0];
    }
    public static function selectAll(){
        $request = self::prepare('
            SELECT p.*, u.username, t.name AS tags 
            FROM `posts` p 
            INNER JOIN `users` u ON u.id = p.user_id
            INNER JOIN posts_tags pt ON p.id = pt.post_id
            JOIN tags t ON pt.tag_id = t.id
            ORDER BY p.id DESC');
        $request->execute();
        $result = $request->fetchAll(\PDO::FETCH_GROUP);
        return $result ? self::visualise($result) : [];

    }
    public static function selectByUser(int $user_id){
        $request = self::prepare('
        SELECT p.*, t.name AS tags 
        FROM `posts` p
        INNER JOIN posts_tags pt ON p.id = pt.post_id
        JOIN tags t ON pt.tag_id = t.id
        WHERE p.user_id = ?
        ORDER BY p.id DESC');
        $request->execute([$user_id]);
        $result = $request->fetchAll(\PDO::FETCH_GROUP);
        
        return $result ? self::visualise($result) : [];
    }
    public static function getPostIdByTag(string $name){
        $request = self::prepare('
        SELECT post_id 
        FROM posts_tags 
        WHERE tag_id = (
            SELECT id 
            FROM tags 
            WHERE name = ?
        )');
        $request->execute([$name]);
        $result = $request->fetchAll();
        
        return $result ?? [];
    }
    // Insert
    public static function insert(array $entity){
        try {
            //Start SQL transaction
            Application::$app->db::$pdo->beginTransaction();
            // create the post
            $request = self::prepare("INSERT INTO `posts` (content, user_id) VALUES (?,?)");
            $request->execute([$entity['content'],$entity['user_id']]);
            
            $post_id = Application::$app->db::$pdo->query('SELECT LAST_INSERT_ID()');
            $posts = $post_id->fetch(\PDO::FETCH_ASSOC);
            
            // Link it to tags
            foreach($entity['tags'] as $tag){
                //Check for existing tag
                $record = Tag::selectOne(["name" => $tag]);
                // Register tag
                if(!$record){
                    Tag::insert(["name" => $tag]);
                    $record = Tag::selectOne(["name" => $tag]);
                }
                // link the tag to this post
                self::$relationnal_table::insert(['post_id' => $posts['LAST_INSERT_ID()'],'tag_id' => $record->id]);
            }

            $result = Application::$app->db::$pdo->commit();
          
          } catch (\Exception $e) {
            Application::$app->db::$pdo->rollBack();
            $result = "Erreur: " . $e->getMessage();
          }
          return $result;
    }
    // Update
    public static function updateWhere(array $entity,array $where){
        $sql_condition = implode(" AND ", self::arrayToSqlAssoc($where));
        $entity_tags = $entity['tags'];
        unset($entity['tags']);
        $data = implode(", ", self::arrayToSqlAssoc($entity));

        try {
            //Start SQL transaction
            Application::$app->db::$pdo->beginTransaction();

            // update post content

            Application::$app->db::$pdo->query('SET @update_id := 0;');
            $request = self::prepare("
                UPDATE `posts` 
                SET $data, id = (SELECT @update_id := id) 
                WHERE $sql_condition LIMIT 1;"
            );
            $request->execute($where + $entity);

            // retrieve post id
            $updated = Application::$app->db::$pdo->query('SELECT @update_id;');
            $temp = $updated->fetch(\PDO::FETCH_ASSOC);

            $tagsRecord = self::$relationnal_table::selectWhere(["post_id" => $temp['@update_id']]);
            $tags = array_map(fn($x) => Tag::selectOne(["id" => $x->tag_id]),$tagsRecord);
            foreach($tags as $tag){
                // Checked for removed tag
                if (!in_array($tag->name, $entity_tags)){
                    self::$relationnal_table::deleteOn(["tag_id" => $tag->id]);
                }
            }
            foreach($entity_tags as $post_tag){
                //Check for added tag
                if(!in_array($post_tag, array_map(fn($tag) => $tag->name, $tags))){
                    //Check for existing tag
                    $record = Tag::selectOne(["name" => $post_tag]);
                    // Register tag
                    if(!$record){
                        Tag::insert(["name" => $post_tag]);
                        $record = Tag::selectOne(["name" => $post_tag]);
                    }
                    // link the tag to this post
                    self::$relationnal_table::insert(['post_id' => $temp['@update_id'],'tag_id' => $record->id]);
                }
            }
            
            return Application::$app->db::$pdo->commit();
            
        } catch (\Exception $e) {
            Application::$app->db::$pdo->rollBack();
            throw new \Exception("Erreur: " . $e->getMessage()) ;
        }
        
    }
    // Search
    public static function find($value){
        $request = self::prepare('
            SELECT p.*, u.username, t.name AS tags 
            FROM `posts` p 
            INNER JOIN `users` u ON u.id = p.user_id
            INNER JOIN posts_tags pt ON p.id = pt.post_id
            JOIN tags t ON pt.tag_id = t.id
            WHERE p.content LIKE :query OR t.name LIKE :query
            ORDER BY p.id DESC'
        );
        $request->execute(['query' => "%$value%"]);
        $result = $request->fetchAll(\PDO::FETCH_GROUP);
        return $result ? self::visualise($result) : [];
    }
    // Database visualisation
    private static function visualise(array $postsRecords){
        $posts = [];
        foreach($postsRecords as $post_id=>$data){
            $tags = [];

            // regroup tags into 1 array
            foreach($data as $post){
                $tags[] = $post->tags;
                $data[0]->tags = $tags;
                $data[0]->id = $post_id;
            }
            $posts[] = $data[0];
        }
        return $posts;
    }
    
    // Entity Interaction methods
    public static function requiredAttributes(): array {
        return ['title','content', 'tags', 'user_id'];
    }
    public static function linkAttributes(): array {
        return ['link', 'linkTitle','linkDomain','linkIcon'];
    }
    public static function editableAttributes(): array {
        return array_merge(self::requiredAttributes(), self::linkAttributes());
    }
}