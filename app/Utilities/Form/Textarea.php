<?php
namespace Project\Utilities\Form;

use Project\Core\Entity;

class Textarea extends Field{
    
    public function field(): string{
        return sprintf('<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute ?? '',
            $this->entity->hasError($this->attribute) ? ' is-invalid' : '',
            $this->entity->{$this->attribute}
        );
    }
}