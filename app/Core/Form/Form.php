<?php

namespace Project\Core\Form;

use Project\Entities\Entity;

class Form{

    public static function begin($action, $method){
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new Form();
    }
    public static function end(){
        return '</form>';
    }
    public static function field(Entity $entity, $attribute){
        return new Field($entity, $attribute);
    }
}