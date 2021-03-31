<?php

namespace Project\Entities;

use Project\Core\{Application,Entity};
use Project\Models\User as UserModel;

class User extends Entity{
    // Db Columns
    public int $id                      = 0;
    public string $username             = '';
    public string $email                = '';
    public string $promotion            = '';
    public string $job                  = '';
    public string $own_website          = '';
    public string $github               = '';
    public string $discord              = '';
    public string $linkedin             = '';
    public string $codepen              = '';
    protected string $password          = '';
    // Usage property
    protected string $passwordConfirm   = '';

    // Manager related properties
    protected static $model             = UserModel::class;
    
    public function __construct(){
        if(!Application::$app->isGuest()){
            $this->id = Application::$app->session->get('id');
        } 
    }

    //Object specific behaviours
    public function connect(): bool{
        $db_record = self::$model::selectOne(['username' => $this->username]);

        if($db_record && password_verify($this->password, $db_record->password)){
            Application::$app->session->login($db_record->id, $db_record->username, $db_record->email);
            return true;
        }
        return false;
    }
    public function create(): bool{
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return self::$model::insert($this->entityToArray(self::$model::requiredAttributes()));
    }
    public function update(){
        // Check if any changes were made on unique attributes
        foreach(self::$model::uniqueAttributes() as $attribute){
            if($this->{$attribute} !== Application::$app->session->get($attribute)){
                if(self::$model::selectOne([$attribute => $this->{$attribute}])){
                    Application::$app->session->setFlash('error','Un compte exite déjà avec votre nouveau '.$this->labels()[$attribute].'.');
                    return false;
                }
                Application::$app->session->set($attribute, $this->{$attribute});
            }
        }
        // Update db record
        return self::$model::updateWhere($this->entityToArray(self::$model::editableAttributes()),['id'=> $this->id]);
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
