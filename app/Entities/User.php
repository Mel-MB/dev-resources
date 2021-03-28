<?php

namespace Project\Entities;

use Project\Core\{Application,Entity, Manager};

class User extends Entity{
    // Db Columns
    public int $id                  = 0;
    public string $username         ='';
    public string $email            ='';
    public string $promotion        = '';
    public string $job              = '';
    public string $own_website      = '';
    public string $github           = '';
    public string $dicord           = '';
    public string $linkedin         = '';
    public string $codepen          = '';
    public string $password         = '';
    // Usage property
    public string $passwordConfirm  = '';

    // Manager related properties
    private static Manager $manager;
    private const TABLE_NAME        = 'users';
    private const PRIMARY_KEY       = 'id';
        
    public function __construct(){
        if(!self::$manager){
            self::$manager = new Manager(self::TABLE_NAME, self::PRIMARY_KEY);
        }
    }

    //Object specific behaviours
    public function create(): bool{
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return self::$manager->create($this->tableize($this,$this->requiredAttributes()));
    }
    public function connect(): bool{
        $db_record = self::$manager->selectOne(['username' => $this->username]);

        if($db_record && password_verify($this->password, $db_record->password)){
            Application::$app->session->set('user',$db_record->id);
            Application::$app->login(self::newInstanceFromObject($db_record));
            return true;
        }
    }
    public function update(): bool{
        // Check if any changes were made on unique attributes
        foreach(self::uniqueAttributes() as $attribute){
            if($this->{$attribute} !== Application::$app->user->{$attribute}){
                if(self::$manager->selectOne([$attribute => $this->{$attribute}])){
                    Application::$app->session->setFlash('error','Un compte exite déjà avec votre '.$this->labels()[$attribute].'.');
                    return false;
                }
            }
        }
        // Update db record
        return self::$manager->update($this)
        
    }

    //Manager related methods
    protected static function uniqueAttributes(): array {
        return ['username', 'email'];
    }
    protected static function requiredAttributes(): array {
        return ['username', 'email', 'promotion', 'password'];
    }
    protected static function allAttributes(): array {
        return self::requiredAttributes() + ['job', 'own_website','github','linkedin','discord','codepen'];
    }
        
    // Form handdling
    protected function labels(): array{
        return [
            'username' => 'Pseudo',
            'email' => 'Email',
            'promotion' => 'Année de certification',
            'password' => 'Mot de passe',
            'passwordConfirm' => 'Confirmation du mot de passe',
            'job' => 'Poste actuel',
            'own_website' => 'Portfolio ou site personnel',
            'github' => 'Profil github',
            'linkedin' => 'Profil linkedin',
            'discord' => 'Compte discord',
            'codepen' => 'Profil codepen',
        ];
    }
}
