<?php
namespace Project\Utilities\Form;

use Project\Core\Entity;

class TagInput extends Field{
    public function __construct(Entity $entity){
        parent::__construct($entity,'tags');
    }
    public function field(): string{
        return '<div id="tags"></div>';
    }
}