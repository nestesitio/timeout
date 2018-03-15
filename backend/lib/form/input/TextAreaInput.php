<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lib\form\input;

/**
 * Description of TextAreaInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Mar 1, 2015
 */
class TextAreaInput extends \lib\form\Input
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return TextAreaInput
     */
    public static function create($field = null)
    {
        $obj = new TextAreaInput($field, $field);
        return $obj;
    }
    
    private $rows = 4;
    
    /**
     * 
     * @param int $rows
     * @return \lib\form\input\TextAreaInput
     */
    public function setRows($rows){
        $this->rows = $rows;
        return $this;
    }


    /**
     * @return string
     */
    public function parseInput()
    {
        $this->attributes();
        /*' <textarea rows="4" cols="50">
At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
</textarea> '*/
        $this->input = '<textarea rows="' . $this->rows . '" ' . implode(' ', $this->attributes) . '>' . $this->value . '</textarea>';
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }
    
    public function getHtmlValue(){
        $value = filter_input(INPUT_POST, $this->getPostKey(), FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW);
        //$value = strip_tags($value, $allowable_tags);
        return $value;
    }

}
