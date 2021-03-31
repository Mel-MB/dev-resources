<?php

namespace Project\Utilities\Form;

use Project\Core\Entity;

class Form{
    public string $id;

    private function __construct($id){
        $this->id = $id;
    }

    public static function begin(string $method, string $id, string $action = ''): object{
        echo sprintf('<form action="%s" id="%s" method="%s">', $action, $id, $method);
        return new Form($id);
    }
    public static function end(): string{
        return '</form>';
    }
    public static function input(Entity $entity, string $attribute, string $input_type){
        return new Input($entity, $attribute,$input_type);
    }
    public static function textarea(Entity $entity, string $attribute){
        return new Textarea($entity, $attribute);
    }
    public static function tagInput(Entity $entity){
        return new TagInput($entity);
    }
}