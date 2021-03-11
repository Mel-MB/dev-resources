<?php

namespace Project\Controllers;
Use Project\Models\User;

class ValidationController {

    private $data;
    private $errors = [];

    public function __construct($data){
        $this->data = $data;
        foreach($this->data as $key=>$field){
            $method = $this::keyToMethod($key);
            if(is_callable([$this,$method])){
                $this->$method($field);
            }
        }
    }
    private static function keyToMethod($key){
        return 'is_'.$key;
    }
    private function getField($key){
        if (!isset($this->data[$key])) {
            return null;
        }
        return $this->data[$key];
    }

    private function is_username($field){
        if (!preg_match('/^[a-zA-Z0-9_]+$/',$this->getField('username'))) {
            $this->errors['username'] = 'Le pseudo doit être composé uniquement de caractères alfanumériques (espaces non authorisés)';
            return false;
        }
        return true;
    }
    private function is_promotion($field){
        if (!preg_match('/^\d{4}$/',$this->getField('promotion'))) {
            $this->errors['promotion'] = 'Veuillez entrer une année en 4 chiffres';
            return false;
        }else if (!($this->getField('promotion') <= date('Y')+1)) {
            $this->errors['promotion'] = "Cette année n'est pas valide";
            return false;
        }
        return true;
    }
    private function is_email($field){
        if (!filter_var($this->getField('email'), FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "L'email saisi n'est pas valide";
            return false;
        }
        return true;
    }
    private function is_password($field){
        if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',$this->getField('password'))) {
            $this->errors['password'] = "Le mot de passe doit être composé d'au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial";
            return false;
        }
        return true;
    }
    
    public function is_unique(){
        if (User::alreadyExists('pseudo',$this->getField($this->data['username']))) {
            $this->errors['username'] = "Ce pseudo est déjà pris";
            return false;
        }
        if (User::alreadyExists('email',$this->getField($this->data['email']))) {
            $this->errors['email'] = "Cet email est déjà utilisé pour un autre compte";
            return false;
        }
        return true;
    }

    public function is_valid(){
        return empty($this->errors);
    }

    public function get_errors(){
        return $this->errors;
    }

}