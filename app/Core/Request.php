<?php
namespace Project\Core;

class Request {

    //Translate requested path to url
    public function getUrl(){
        //Get requested path : if none specified return main domain
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        //Check for parameters 
        $position = strpos($path,'?');

        if ($position !== false) {
            $path = substr($path, 0, $position);
        }
        return $path;
    }

    //Get server request method
    public function method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isGet(){
        return $this->method() === 'get';
    }
    public function isPost(){
        return $this->method() === 'post';
    }

    // Sanitize data parameters on server request
    public function getData(){
        $data = [];
        if ($this->isGet()){
            foreach($_GET as $key => $value){
                //remove invalid chars that might be passed in url
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()){
            foreach($_POST as $key => $value){
                //remove invalid chars that might be passed in inputs
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}