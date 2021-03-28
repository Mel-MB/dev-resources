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
    
    public function remove(string $key): void{
        unset($_SESSION[$key]);
    }

    public function hasFlashes(): bool{
        return isset($_SESSION['flash']);
    }

    public function setFlash(string $type, string $message): void{
       $_SESSION['flash'][$type] = $message;
    }

    public function getFlashes(){
        $flash = $_SESSION['flash'];
        $this->remove('flash');
        return $flash;
    } 
}