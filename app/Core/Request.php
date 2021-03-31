<?php
namespace Project\Core;

class Request {

    //Translate requested path to url
    public static function getUrl(){
        //Get requested path : if none specified return main domain
        $uri = $_SERVER['REQUEST_URI'] ;
        if(!$uri) return '/';

        // Remove traditionnal $_GET params for security (app does not use it)
        $position = strpos($uri,'?');
        if ($position !== false) {
            $uri = substr($uri, 0, $position);
        }
        // GET the passed params
        if(preg_match_all('/\/([^\/]*)/',$uri,$sections)){
            if(sizeof($sections[1]) === 1) return $sections[1][0];
            $i= 2;
            $params= [];
            while($i === $sections[1][$i]){
                $param = htmlspecialchars($sections[1][$i]);
                //remove invalid chars that might be passed in url   
                $params[gettype($param)] = $param;
            }
        }
        return [$uri, $params ?? null];
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
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}
