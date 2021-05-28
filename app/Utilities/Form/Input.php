<?php
namespace Project\Utilities\Form;

use Project\Core\Entity;

class Input extends Field{
    public const TYPE_TEXT ='text';
    public const TYPE_PASSWORD ='password';
    public const TYPE_EMAIL ='email';
    public const TYPE_NUMBER ='number';
    private string $type;

    public function __construct(Entity $entity, string $attribute,string $input_type = null, string $placeholder = '&nbsp;'){
        parent::__construct($entity,$attribute, $placeholder);       
        $this->type = $input_type??self::TYPE_TEXT;
    }

    public function field(): string{
        return sprintf("<input type='%s' name='%s' placeholder='%s' class='form-control%s' value='%s'>",
            $this->type,
            $this->attribute ?? '',
            $this->placeholder,
            $this->entity->hasError($this->attribute) ? ' is-invalid' : '',
            $this->type !== self::TYPE_PASSWORD ? $this->entity->{$this->attribute} : ''
        );
    }
}