<?php

namespace Project\Utilities\Form;

use Project\Core\Entity;

use function PHPSTORM_META\type;

abstract class Field{
    protected Entity $entity;
    public string $attribute;

    public function __construct(Entity $entity, string $attribute){
        $this->entity = $entity;
        $this->attribute = $attribute;
    }
    
    public function __toString(){
        return sprintf('
        <div>
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