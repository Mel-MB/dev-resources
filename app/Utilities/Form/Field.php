<?php

namespace Project\Utilities\Form;

use Project\Core\Entity;

use function PHPSTORM_META\type;

class Field{
    private const TYPE_TEXT ='text';
    private const TYPE_PASSWORD ='password';
    private const TYPE_EMAIL ='email';
    private const TYPE_NUMBER ='number';

    private string $type;
    private Entity $entity;
    public string $attribute;

    public function __construct(Entity $entity, string $attribute){
        $this->type = self::TYPE_TEXT;
        $this->entity = $entity;
        $this->attribute = $attribute;
    }
    
    public function __toString(){
        //Magic function displays folloing string whenever instance is returned
        return sprintf('
        <div>
            <label>%s</label>
            <input type="%s" name="%s" value="%s" class="form-control%s">
            <p class="invalid-feedback">
                %s
            </p>
        </div>
        ', $this->entity->getLabel($this->attribute),
        $this->type,
        $this->attribute,
        $this->type !== self::TYPE_PASSWORD ? $this->entity->{$this->attribute} : '',
        $this->entity->hasError($this->attribute) ? ' is-invalid' : '',
        $this->entity->getFirstError($this->attribute)
        );
    }
    public function numberField(){
        $this->type = self::TYPE_NUMBER;
        return $this;
    }
    public function emailField(){
        $this->type = self::TYPE_EMAIL;
        return $this;
    }
    public function passwordField(){
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}