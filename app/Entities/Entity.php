<?php
namespace Project\Entities;

abstract class Entity{
    public const RULE_REQUIRED = 'required';
    public const RULE_ALPHANUM = 'alphanum';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_YEAR = 'year';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public $errors = [];

    public function populate($data){
        foreach($data as $key => $value){
            //check if data key matches called class property
            if(property_exists($this,$key)){
                // affect object property with associated value
                $this->{$key} = $value;
            }
        }
    }
    
    abstract public function requiredAttributes(): array;
    abstract public function allAttributes(): array;

    abstract public function rules(): array;

    abstract public function labels(): array;

    
    public function getLabel($attribute) {
        return $this->labels()[$attribute] ?? $attribute;
    }


    public function validate(){
        foreach ($this->rules() as $attribute => $rules){
            //Assert value of the attribute
            $value = $this->{$attribute};
            //With the specified rules
            foreach($rules as $rule){
                $ruleName = $rule;

                if(is_array($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_ALPHANUM && !preg_match('/^[a-zA-Z0-9_]+$/',$value)){
                    $this->addError($attribute, self::RULE_ALPHANUM);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_YEAR && !preg_match('/^\d{4}$/',$value)){
                    $this->addError($attribute, self::RULE_YEAR);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;

                    $alreadyExists = $className::alreadyExists($uniqueAttr, $value);
                    if($alreadyExists){
                        $this->addError($attribute, self::RULE_UNIQUE, ['field'=> $attribute]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addError(string $attribute, string $ruleName, $params=[]){
        $message = $this->errorMessages()[$ruleName] ?? '';

        foreach($params as $key => $value){
            $message = str_replace(":{$key}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    private function errorMessages(){
        return[
            self::RULE_REQUIRED => 'Ce champs est obligatoire',
            self::RULE_ALPHANUM => 'Seuls les caratères alphanumériques sont authorisés',
            self::RULE_EMAIL => "L'adresse email doit être valide",
            self::RULE_YEAR => "Merci de spécifier une année au format YYYY",
            self::RULE_MIN => "Taille minimale requise: :min caractères",
            self::RULE_MAX => "Taille maximale acceptée: :max caractères",
            self::RULE_MATCH => "Ce champs doit être identique à :match",
            self::RULE_UNIQUE => "Un compte exite déjà pour ce :field",
        ];
    }

    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute){
        return $this->errors[$attribute][0] ?? false;
    }

}