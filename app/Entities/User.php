<?php

namespace Project\Entities;

use Project\Entities\{Entity};
use Project\Managers\User as UserManager;

class User extends Entity{
    public int $id = 0;
    public string $username ='';
    public string $email ='';
    public string $promotion = '';
    public string $job = '';
    public string $own_website = '';
    public string $github = '';
    public string $dicord = '';
    public string $linkedin = '';
    public string $codepen = '';
    public string $password = '';
    public string $passwordConfirm = '';
    private object $session;
   
    public function requiredAttributes(): array {
        return ['username', 'email', 'promotion', 'password'];
    }
    public function allAttributes(): array {
        return $this->requiredAttributes() + ['job', 'own_website','github','linkedin','discord','codepen'];
    }

    public function labels(): array{
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
    public function rules(): array{
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min'=>3], [self::RULE_MAX, 'max'=>18], [self::RULE_UNIQUE, 'class'=> 'Project\Managers\User']],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class'=> 'Project\Managers\User']],
            'promotion' => [self::RULE_REQUIRED, self::RULE_YEAR],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min'=>8]],
            'passwordConfirm' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=> 'password']],
        ];
    }

    public function connect($user){
        $this->session->write('auth', $user);
    }

    public function register(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        UserManager::create($this);
    }

    public function login($db, $username, $password){
        $user = $db->query('SELECT * FROM users WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL', ['username' => $username])->fetch();
        if(password_verify($password, $user->password)){
            $this->connect($user);
            return $user;
        }else{
            return false;
        }
    }

    public function restrict(){
        if(!$this->session->read('auth')){
            $this->session->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            header('Location: login.php');
            exit();
        }
    }
}