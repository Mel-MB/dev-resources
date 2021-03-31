<?php

namespace Project\Models;

use Project\Core\Database\Model;

class Post extends Model {
    private const TABLE_NAME                = 'posts';
    protected const PRIMARY_KEY             = 'id';
    protected const FOREIGN_KEYS            = ['user_id' => ['users' => 'id']];
    protected const RELATIONNAL_TABLE       = [
        'tableName' => 'posts_tags',
        'foreignKeys'=> [
            'post_id' => ['posts' => 'id'],
            'tag_id' => ['tags' => 'id'],
        ]
    ];

    public function __construct(string $tableName = null){
        self::$tableName = self::TABLE_NAME;
        self::$primarykey = self::PRIMARY_KEY;
        self::$foreignKeys = self::FOREIGN_KEYS;
    }    
    
    public function insert(array $entity){
        try {
            //Start SQL transaction
            Application::$app->db::$pdo->beginTransaction();

            //Check for tags
            $user_socials = Social::selectByUser($user_data['id']);

            foreach($socials_data as $type => $url){
                
                if($user_socials){
                    //Loop on socials linked to this user
                    foreach($user_socials as $social){
                        // Check if registered social matchs with given data
                        if($social['type'] === $type){
                            // Update the row on matched data
                            $matching_data = $socials_data[$social['type']];
                            $s = new Social;
                            $updated_social = $s->update($social['id'],$matching_data);
                            // Go to the next iteration of the parent loop
                            continue 2;   
                        }
                    }
                }else{
                    // Check if user filled the url
                    if($url){
                        $social = Social::create($type,$url,$user_data['id']);
                    }
                }


            $post = self::prepare("UPDATE `users` SET pseudo= :username, email= :email, promotion= :promotion, job= :job WHERE id= :id");
            $post->execute($user_data);
            
                
            }
            
            $result = $db->commit();
          
          } catch (\Exception $e) {
            $db->rollBack();
            $result = "Erreur: " . $e->getMessage();
          }
       
        
        return $result;

    }
    public static function selectFromFK($user_id){
        $request = self::dbConnect()->prepare('SELECT * FROM `posts` WHERE user_id= ? ORDER BY id DESC');
        $request->execute([$user_id]);

        $result= $request->fetchAll();
        return $result;
    }
    public static function selectAll(){
        $request = self::prepare('SELECT p.*, u.pseudo FROM `posts` AS p INNER JOIN `users` AS u ON u.id = p.user_id ORDER BY p.id DESC');

        $result = $request->fetchAll();
        return $result;
    }
    public function update($post_id, $content){
        $request = $this->db->prepare('UPDATE `posts` SET content= :content WHERE id= :id');
        $request->execute([
            'content' => $content,
            'id' => $post_id
        ]);
        return $request;
    }
}