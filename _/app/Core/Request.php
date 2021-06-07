<?php
namespace Project\Core;

class Request {

    //Translate requested path to url
    public static function getUrl(): string{
        //Get requested path : if none specified return main domain
        $uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        if(!$uri) return '/';

        // Remove traditionnal $_GET params for security (app does not use it)
        $position = strpos($uri,'?');
        if ($position) {
            $uri = substr($uri, 0, $position);
        }
        return $uri;
    }

    //Get server request method
    public static function method(): string{
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public static function isPost(): bool{
        return self::method() === 'post';
    }
    public static function isAjax(): bool{
      return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']??'') === 'xmlhttprequest';
    }

    // Sanitize data parameters on server request
    public static function getData(){
        $data = [];
        if (self::isPost()){
            foreach($_POST as $key => $value){
                //remove invalid chars that might be passed in inputs
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_FLAG_NO_ENCODE_QUOTES);
            }
        }
        return $data;
    }
}
