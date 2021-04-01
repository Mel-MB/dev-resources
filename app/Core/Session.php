<?php
namespace Project\Core;

class Session{

    public function __construct(){
        session_start();
    }

    public function set(string $key, string $value): void{
        $_SESSION[$key] = $value;
    }

    public function get(string $key){
        return $_SESSION[$key] ?? false;
    }
    public function login(int $id, string $username, string $email): void{
        $this->set('id', $id);
        $this->set('username', $username);
        $this->set('email', $email);
    }
    
    public function remove(string $key = null): void{
        if($key){
            unset($_SESSION[$key]);
        }else{
            session_unset();
        }
    }

    public function hasFlashes(): bool{
        return isset($_SESSION['flash']);
    }

    public function setFlash(string $type, $message): void{
       $_SESSION['flash'][$type] = $message;
    }

    public function getFlashes(){
        $flash = $_SESSION['flash'];
        $this->remove('flash');
        return $flash;
    } 
}