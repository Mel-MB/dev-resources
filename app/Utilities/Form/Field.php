<?php

namespace Project\Utilities\Form;

use Project\Core\Entity;

abstract class Field{
    protected Entity $entity;
    protected string $placeholder;
    public string $attribute;

    public function __construct(Entity $entity, string $attribute, string $placeholder = ''){
        $this->entity = $entity;
        $this->attribute = $attribute;
        $this->placeholder = $placeholder;
        
        if(is_array($this->entity->{$this->attribute})){
            $this->entity->{$this->attribute} = implode(', ',$this->entity->{$this->attribute});
        }
    }
    
    public function __toString(){
        return sprintf('
        <div class="field">
            <label>%s</label>
            %s
            <p class="invalid-feedback">
                %s
            </p>
        </div>
        ', $this->entity->getLabel($this->attribute),
        $this->field(),
        $this->entity->getFirstError($this->attribute)
        );
    }

    abstract function field(): string;
}