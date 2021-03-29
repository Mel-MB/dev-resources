<?php

namespace Project\Entities;

use Project\Core\{Application,Entity, Manager};

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
    public string $password             = '';
    // Usage property
    public string $passwordConfirm      = '';

    // Manager related properties
    protected static Manager $manager;
    private const TABLE_NAME            = 'users';
    protected const PRIMARY_KEY         = 'id';
        
    public function __construct(){
        self::$manager = new Manager(self::TABLE_NAME, self::PRIMARY_KEY);
        if(!Application::$app->isGuest()){
            $this->id = Application::$app->session->get('id');
        } 
    }

    //Object specific behaviours
    public function create(): bool{
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return self::$manager->create($this->entityToArrayOn($this->requiredAttributes()));
    }
    public function connect(): bool{
        $db_record = self::$manager->selectOne(['username' => $this->username]);

        if($db_record && password_verify($this->password, $db_record->password)){
            Application::$app->session->login($db_record->id, $db_record->username, $db_record->email);
            return true;
        }
        return false;
    }
    public function update(): bool{
        // Check if any changes were made on unique attributes
        foreach(self::uniqueAttributes() as $attribute){
            if($this->{$attribute} !== Application::$app->session->get($attribute)){
                if(self::$manager->selectOne([$attribute => $this->{$attribute}])){
                    Application::$app->session->setFlash('error','Un compte exite déjà avec votre nouveau '.$this->labels()[$attribute].'.');
                    return false;
                }
                Application::$app->session->set($attribute, $this->{$attribute});
            }
        }
        // Update db record
        return self::$manager->update($this->entityToArrayOn($this->editableAttributes()),['id'=> $this->id]);
    }
    public function delete($valueOnPk = null): void{
        $attribute = self::PRIMARY_KEY;
        $valueOnPk = Application::$app->session->get('id');
        
        self::$manager->delete([$attribute => $valueOnPk]);
    }
    //Manager related methods
    protected static function uniqueAttributes(): array {
        return ['username', 'email'];
    }
    protected static function requiredAttributes(): array {
        return ['username', 'email', 'promotion', 'password'];
    }
    protected static function editableAttributes(): array {
        return ['username', 'email', 'promotion','job', 'own_website','github','linkedin','discord','codepen'];
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
