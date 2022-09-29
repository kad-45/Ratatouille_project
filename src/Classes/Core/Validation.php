<?php

namespace App\Classes\Core;

class Validation
{

    private $params;

    private $errors = [];

    public function __construct(array $params) {
        $this->params = $params;
    }

    public function isValid(array $fields): bool {
        //$fields = ['lastname' => [],
        foreach ($fields as $field => $values) {
            if(array_key_exists($field, $this->params)) {
                //$vlaues =['validRequired', 'validEmail', ...]
                foreach ($values as $value) {
                    //$this->validRequired($filed, $this->params[$field)
                    $this->$value($field, $this->params[$field]);
                }
            }
        }
        if(!empty($this->errors)){
            return false;
        }
        return true;

    }

    public function validFile(string $field, int $value) : self {
        if($value == 0) {
            $this->addError('img', "Le champ image doit être renseigner ");
        }
        return $this;
    }

    public function validRequired(string $field,  $values ) : self{
        if(is_array($values)){
            $errors = [];
            foreach ($values as $i => $val){
                if(is_null($val)|| empty($val)) {
                    $errors [$i] = "Ce champ est obligatoire";
                }
            }
            if(!empty($errors)){
                $this->addError($field, $errors);
            }
        }else {
            if (is_null($values) || empty($values)) {
                $this->addError($field, "Ce champ est obligatoire");
            }
        }
        return $this;
    }

    public function validEmail(string $field, string $value) : self{
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "Le champ $field doit être une adresse mail valide");
        }
        return $this;
    }

    public function validPhone(string $field, string $phone) : self{
        $pattern = '/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/';
        if (!preg_match($pattern, $phone, $matches)) {
            $this->addError($field, "Le champ $field doit être un N° de téléphone valide");
        }
    return $this;
    }


    public function validSize($field, $values): self {
        if(is_array($values)){
            $errors = [];

            foreach ($values as $i => $val){
                if(empty($val) || is_null($val)) {
                    $errors [$i] = "Ce champ est obligatoire"; 
                }
            }
            if(!empty($errors)){
                $this->addError($field, $errors);
            }
        }else {
            if (empty($values) || is_null($values)) {
                $this->addError($field, "Le champ $field doit être une valeur superieur à zéro");
            }
        }
        return $this;

    }

    public function getErrors(): array {
        return $this->errors;
    }

    private function addError(string $field, $rule) {
        $this->errors[$field] = $rule;
    }

}