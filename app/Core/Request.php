<?php
namespace Project\Core;

class Request {

    //Translate requested path to url
    public static function getUrl(){
        //Get requested path : if none specified return main domain
        $uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        if(!$uri) return '/';

        // Remove traditionnal $_GET params for security (app does not use it)
        $position = strpos($uri,'?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        return $uri;
    }

    //Get server request method
    public function method(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function isPost(){
        return $this->method() === 'post';
    }

    // Sanitize data parameters on server request
    public function getData(){
        $data = [];
        if ($this->isPost()){
            foreach($_POST as $key => $value){
                //remove invalid chars that might be passed in inputs
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
            }
        }
        return $data;
    }
}
