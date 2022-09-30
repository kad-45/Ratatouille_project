<?php

namespace App\Classes\Core;

class Form
{
    private $html = "";
    public  $datas = [];
    public  $errors = [];

    public function __construct (array $datas = [], array $errors = [] ){

        $this->datas = $datas;
        $this->errors = $errors;
    }


    public function openForm(string $method = 'post', string $action = '#', array $attributes = []) :self {
        $this->html .= "<form action ='$action' method ='$method'";
        //on ajoute les attributs
        $this->html .= $attributes ? $this->addAttributes($attributes) .">" : ">";
        return $this;
    }

    public function closeForm (): self{
        $this->html .= '</form>';
        return $this;
    }

    public function addAttributes (array $attributes): string {
        $str = '';
        // liste des attributs
        $attr = ['readonly', 'disabled', 'checked', 'multiple', 'required', 'autofocus', 'formnovalidate', 'novalidate'];

        foreach ($attributes as $attribute => $value) {
            if(in_array($attribute,$attr) && $value == true){
                    $str .= " $attribute";
            }else {
                $str .= " $attribute= '$value'";
            }
        }
        return $str;
    }

    public function create() {
        return $this->html;
    }

    public static function isValid(array $form, array $fields) {
        // on parcourt les champs $field
        foreach ($fields as $field){
            // on verifie si le champ est manquant ou vide
            if(!isset($form[$field]) || empty($form[$field])){
                return false;
            }
        }
        return true;
    }

    public function addLabel(string $for, string $texte, array $attributs = []):self
    {
        // On cree le label
        $this->html .= "<label for='$for'";

        // On ajoute les attributs
        $this->html .= $attributs ? $this->addAttributes($attributs) : '';

        // On ajoute le texte
        $this->html .= ">$texte</label><p>";

        return $this;
    }



    public function addInput(string $type , string $name, array $attributes, string $error = null): self {
        $class = "valid";

       //creation de la balise
        $this->html .= "<div class='form-group'>";
        if($type !=="hidden") {
            $this->html .= "<label for='{$name}'>{$attributes['label']}</label>";
        }

        if(isset($attributes['value'])) {
            $value = $attributes['value'];
        }else{
            $value = $this->datas[$name];
        }

        $this->html .= "<input type='$type' name ='$name' value= '$value'";
        //On ajoute les attributs

        $this->html .= $attributes ? $this->addAttributes($attributes).'>': '>';

        $this->html .= "</div>";
        return $this;

    }


    public function addTextarea(string $name, string $value = '', array $attributes = [], $error = null):self
    {
        $this->html .= "<div class='form-group'>";
        $this->html .="<label for='{$name}'>{$attributes['label']}</label>";

        //creation de la balise
        $this->html .= "<textarea name='{$name}'";

        // On ajoute les attributs
        $this->html .= $attributes ? $this->addAttributes($attributes) : '';

        // On ajoute le texte
        $this->html .= ">{$value}</textarea></div>";

        return $this;
    }

    public function addSelect(string $name, array $options, array $attributes = [], $error = null):self
    {
        $this->html .= "<div class='form-group'>";
        $this->html .= "<label for='{$name}'>{$attributes['label']}</label>";
        // On crée la balise
        $this->html .= "<select name='{$name}'";

        // On rajoute les attributs
        $this->html .= $attributes ? $this->addAttributes($attributes).'>' : '>';

        // On rajoute les options
        //$selected = '';
        foreach($options as $option){
            //var_dump($option['id']);
            if($option ['id'] === $this->datas['category_id']) {
                //var_dump("jjjjjjjjjjj");
                $selected = "selected";

            }else{
                $selected = "";
            }
    
            $this->html .= "<option value='".$option['id']."' $selected >".$option['name']."</option>";
        }
        // On ferme le select

        $this->html .= '</select></div>';

        return $this;
    }

    public function addButton(string $texte, array $attributs = []):self
    {
        // On cree le bouton
        $this->html .= '<button ';

        // On rajoute les attributs
        $this->html .= $attributs ? $this->addAttributes($attributs) : '';

        // On rajoute le texte et on ferme
        $this->html .= ">$texte</button>";

        return $this;
    }


    public function addHtml(string $html): self
    {
        $this->html .= $html;
        return $this;
    }
    
}  