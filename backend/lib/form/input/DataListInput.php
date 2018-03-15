<?php

namespace lib\form\input;

/**
 * Description of DataListInput
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Mar 19, 2015
 */
class DataListInput extends \lib\form\input\SelectInput
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return DataListInput
     */
    public static function create($field = null)
    {
        $obj = new DataListInput($field, $field);
        return $obj;
    }

    /**
     * @return string
     */
    public function parseDataListInput()
    {
        if($this->model !=  null){
            $this->parseModel();
        }
        $this->attributes();
        $idlist = $this->elemid . '_list';
        $datalist = '';

        if (isset($this->options)) {
            $datalist .= '<datalist id="' . $idlist . '">';
            foreach ($this->options as $key => $value) {
                $datalist .= '<option value="' . $value . '">';
                if($key == $this->value){
                    $this->value = $value;
                }
            }
            $datalist .= '</datalist>';
        }
        $this->attributes['value'] = 'value="' . $this->value . '"';
        $this->input = '<input list="' . $idlist . '" ' . implode(' ', $this->attributes) . ' />';
        $this->input .= $datalist;
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'"><span class="glyphicon glyphicon-refresh"></span></a>';
        return $this->input;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        return $this->parseDataListInput();
    }



}
