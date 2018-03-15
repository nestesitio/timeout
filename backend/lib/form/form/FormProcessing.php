<?php

namespace lib\form\form;


use \lib\register\Monitor;

/**
 * Description of FormProcessing
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 27, 2015
 */
class FormProcessing
{
    /**
     * @var array
     */
    protected $models = [];
    /**
     * @var array
     */
    protected $forminputs = [];
    /**
     * @var array
     */
    protected $nullvalues = [];
    /**
     * @var int
     */
    protected $processerrors = 0;
    /**
     * @var int
     */
    protected $primarykeyvalue = 0;
    /**
     * @var array
     */
    protected $validated = [];

    /**
     *
     */
    const VIRTUALTABLE = 'no_table';

    #validation
    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     *
     * @param $query
     * @return mixed
     */
    protected function validatePrimaryKey($table, $field, $query)
    {
        //$this->primarykey[$table] = $field;
        if (isset($this->validated[$table][$field])) {
            return $this->validated[$table][$field];
        }
        $value = FormValidator::validateId($field, $query);
        if($value === false){
            $this->processerrors++;
        }
        if($this->primarykey == 0){
           $this->primarykey = $field;
        }
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     *
     * @return mixed
     */
    protected function validateBool($table, $field)
    {
        if (isset($this->validated[$table][$field])) {
            return $this->validated[$table][$field];
        }
        $value = FormValidator::getValue($field);
        if($value === false){
            $value = 0;
        }elseif($value === '0'){
            $value = 0;
        }else{
            $value = 1;
        }
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param bool $required
     * @param int $maxlen
     * @param int $minlen
     *
     * @return mixed|null
     */
    protected function validateString($table, $field, $required, $maxlen = 0, $minlen = 0)
    {
        if (isset($this->validated[$table][$field])) {
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        $value = FormValidator::validateString($field, $this->formlabels[$table][$field], $required, $minlen, $maxlen);
        if($value == false && $required == true){
            $this->processerrors++;
        }
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     *
     * @return mixed|null
     */
    protected function validateDate($table, $field)
    {
        if (isset($this->validated[$table][$field])) {
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        $value = FormValidator::validateDate($field, $this->formlabels[$table][$field]);
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     */
    public function setNullValues($table, $field)
    {
        $this->nullvalues[$table][$field] = 0;
    }


    //$this->validatedValues['htm.htm_app_id'] = $this->validateModel('htm.htm_app_id', \model\querys\HtmAppQuery::start(),'id', true);
    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param $query
     * @param $index
     * @param $required
     * @param $default
     * @return mixed|null
     */
    protected function validateModel($table, $field, $query, $index, $required, $default = null)
    {   
        if (isset($this->validated[$table][$field])) {
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        if(isset($this->nullvalues[$table][$field])) {
            return $this->setValidatedValue($table, $field, 0);
        }
        if($this->forminputs[$table][$field]->isMultiple() == true){
            $value = FormValidator::validateMultipleModel($field, $this->formlabels[$table][$field], $query, $index, $required);
        }else{
            $value = FormValidator::validateModel($field, $this->formlabels[$table][$field], $query, $index, $required, $default);
        }

        if($value == false && $required == true){
            $this->processerrors++;
        }
        return (is_array($value))? $this->setMultipleModels($table, $field, $value) : $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param array $possible_values
     * @param bool $required
     * @param String $default
     *
     * @return mixed|null
     */
    protected function validateValues($table, $field, $possible_values, $required, $default = null)
    {
        if (isset($this->validated[$table][$field])) {
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        $value = FormValidator::validateValues($field, $this->formlabels[$table][$field], $possible_values, $required, $default);
        if ($value == false && $required == true) {
            $this->processerrors++;
        }
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     *
     * @return mixed|null
     */
    protected function validateText($table, $field)
    {
        if(isset($this->validated[$table][$field])){
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        $value = FormValidator::validateText($field, $this->formlabels[$table][$field]);
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param bool $required
     * @param int $max
     *
     * @return mixed|null
     */
    protected function validateInt($table, $field, $required, $max)
    {
        if(isset($this->validated[$table][$field])){
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        $value = FormValidator::validateInt($field, $this->formlabels[$table][$field], $required, $max);
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param bool $required
     * @param $format
     * @return mixed|null
     */
    protected function validateFloat($table, $field, $required, $format)
    {
        if(isset($this->validated[$table][$field])){
            return $this->validated[$table][$field];
        }elseif(!isset($this->forminputs[$table][$field])){
            return null;
        }
        $value = FormValidator::validateFloat($field, $this->formlabels[$table][$field], $required, $format);
        return $this->setValidatedValue($table, $field, $value);
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param String $value
     * @return bool
     */
    protected function validateUnique($table, $field, $value)
    {
        $column = FormValidator::getColumnName($field);
        foreach($this->models[$table]->getUniqueKey() as $key){
            if($column == $key){
                $model = $this->models[$table];
                $value = FormValidator::validateUnique($model, $field, $value, $this->formlabels[$table][$field]);
                if ($value == false) {
                    $this->processerrors++;
                }
            }
        }
        return $value;
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param array $values
     * @return mixed
     */
    private function setMultipleModels($table, $field, $values)
    {
        $models = [];
        for($i = 0; $i < count($values); $i++){
            if(is_array($this->models[$table]) && isset($this->models[$table][$i])){
                $models[$i] = $this->models[$table][$i];
            }elseif(is_array($this->models[$table]) && !isset($this->models[$table][$i])){
                $models[$i] = clone $this->models[$table][0];
            }elseif(!is_array($this->models[$table])){
                $models[$i] = clone $this->models[$table];
            }
            $models[$i]->setColumnValue($field, $values[$i]);
        }
        $this->models[$table] = $models;
        $this->forminputs[$table][$field]->setArray($values);
        return $values;
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param String $value
     *
     * @return mixed
     */
    private function setValidatedValue($table, $field, $value)
    {
        if(is_array($this->models[$table])){
            foreach($this->models[$table] as $model){
                $model->setColumnValue($field, $value);
            }
        }else{
            $this->models[$table]->setColumnValue($field, $value);
        }
        $this->forminputs[$table][$field]->setValue($value);
        $this->validated[$table][$field] = $value;
        #echo $field . '=' . $value . '<br />';
        return $value;
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     *
     * @return mixed
     */
    public function getValidatedValue($table, $field)
    {
        return $this->forminputs[$table][$field]->getValue();

    }


    /**
     * @param String $table The table name as index for merged form
     * @param \lib\model\Model $model
     *
     * @return \lib\form\Form
     */
    public function setModel($table, $model)
    {
        $this->models[$table] = $model;
        return $this;
    }

    /**
     * @param String $table The table name as index for merged form
     * @param String $field The field name as index for the array of inputs
     * @param String $value
     */
    public function rePostValue($table, $field, $value)
    {
        $this->setValidatedValue($table, $field, $value);
    }


    #save
    /**
     * @return bool
     */
    public function isvalid()
    {
        Monitor::setMonitor(Monitor::FORM, ' has ' . $this->processerrors . ' errors');
        if($this->processerrors > 0){
            return false;
        }
        return true;
    }

    /**
     *
     */
    public function save()
    {
        foreach ($this->models as $table=>$model){
            $fks = $model->getForeignKeys();
            foreach($model->getColumns($table) as $field){
                $column = $table . '.' . $field;
                if (isset($fks[$column])) {
                    $value = $model->getColumnValue($column);
                    $value = $this->getFkValue($fks[$column], $value);
                    $model->setColumnValue($column, $value);
                }
            }
            $this->models[$table] = $model->save();
            if($this->inserted == 0){
                $this->inserted = $model->getInsertId();
            }
            $key = (isset($this->forms[$table])) ? $this->forms[$table]->getPrimaryKey() : $this->getPrimaryKey();
            if ($this->primarykeyvalue == 0) {
                $this->primarykeyvalue = $model->getColumnValue($key);
                \lib\register\Vars::setId($this->primarykeyvalue);
            }
        }
    }

    /**
     * @var int
     */
    private $inserted = 0;

    /**
     * @return int
     */
    public function getInsertId()
    {
        return $this->inserted;
    }

    /**
     * @param String $table The table name as index for merged form
     * @return mixed
     */
    public function getModel($table = null)
    {
        if(null != $table){
            return $this->models[$table];
        }else{
            foreach($this->models as $model){
                return $model;
            }
        }
    }

    /**
     * @param array $fk
     * @param String $value
     * @return String|null
     */
    protected function getFkValue($fk, $value = null)
    {
        #$this->fk[HtmPage::HTM_PAGE_HTM_ID] = ['table'=>'htm', 'field'=>'id'];
        $table = $fk['table'];
        $field = $table . '.' . $fk['field'];
        if(isset($this->models[$table]) && isset($this->forminputs[$table][$field])){
            $value = $this->models[$table]->getColumnValue($field);
        }
        return $value;

    }

}
