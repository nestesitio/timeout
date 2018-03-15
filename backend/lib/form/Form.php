<?php

namespace lib\form;

use \lib\form\form\FormRender;
use \lib\form\Input;
use \lib\form\form\FormValidator;

/**
 * Description of Form
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 23, 2015
 */
class Form extends \lib\form\form\FormProcessing
{
    /**
     * @var array
     */
    protected $queue = [];

    /**
     * @var array
     */
    protected $inputvalues = [];
    /**
     * @var array
     */
    protected $formlabels = [];

    /**
     * @var int
     */
    protected $primarykey = 0;

    /**
     * Form constructor.
     */
    public function __construct() {}


    /**
     * @param $table
     * @param $field
     * @param \lib\form\Input $input
     * @return mixed
     */
    public function setFieldInput($table, $field, Input $input)
    {
        $this->forminputs[$table][$field] = $input;
        return $this->forminputs[$table][$field];
    }

    /**
     * @param $table
     * @param $field
     * @return $this
     */
    public function unsetFieldInput($table, $field)
    {
        unset($this->forminputs[$table][$field]);
        return $this;
    }

    /**
     * @param $table
     * @param $field
     * @param $type
     * @return mixed
     */
    public function setInputType($table, $field, $type)
    {
        return $this->forminputs[$table][$field]->setInputType($type);
    }

    /**
     * @param $table
     * @param $field
     * @param $label
     * @return mixed
     */
    public function setFieldLabel($table, $field, $label)
    {
        $this->formlabels[$table][$field] = $label;
        return $this->formlabels[$table][$field];
    }

    /**
     * @param $table
     * @param $field
     * @param $value
     * @return mixed
     */
    public function setFieldValue($table, $field, $value)
    {
        return $this->forminputs[$table][$field]->setValue($value);
    }

    /**
     * @param $table
     * @param $field
     * @param $value
     * @return mixed
     */
    public function setDefault($table, $field, $value)
    {
        return $this->forminputs[$table][$field]->setDefault($value);
    }

    /**
     * @param $table
     * @param $field
     * @return $this
     */
    public function setMultipleField($table, $field)
    {
        $input = $this->forminputs[$table][$field];
        if($input->getInputType() == Input::TYPE_SELECT){
            $input->setMultiple();
        }
        return $this;
    }

    /**
     * @param $table
     * @param $field
     * @return null
     */
    public function getInputModel($table, $field)
    {
        $input = $this->forminputs[$table][$field];
        if($input->getInputType() == Input::TYPE_SELECT){
            return $input->getModel();
        }
        return null;

    }

    /**
     * @param $table
     * @param $field
     * @param $model
     * @return $this
     */
    public function setInputModel($table, $field, $model)
    {
        $input = $this->forminputs[$table][$field];
        if($input->getInputType() == Input::TYPE_SELECT){
            $input->setModel($model);
        }
        return $this;
    }

    /**
     * @param $table
     * @param $field
     * @param $query
     * @return $this
     */
    public function setQuery($table, $field, $query)
    {
        $this->forminputs[$table][$field]->setModel($query);
        return $this;
    }

    /**
     * @param $table
     * @param $field
     * @param $value
     * @return $this
     */
    public function setDataAttribute($table, $field, $value)
    {
        $this->forminputs[$table][$field]->setDataAttribute('data-link', $value);
        return $this;
    }

    /**
     * Get the inputs of the merged table in a array
     * @param String $table The table name as index of merged form
     *
     * @return array
     */
    public function getFormInputs($table = null)
    {
        return (null == $table)? $this->forminputs : $this->forminputs[$table];
    }

    /**
     * Get the input by the form para associated by table and field
     * @param String $table The table name as index of merged form
     * @param String $field
     * @return input|null
     */
    public function getInput($table, $field)
    {
        if(isset($this->forminputs[$table][$field])){
            return $this->forminputs[$table][$field];
        }else{
            return null;
        }
    }

    /**
     * @param String $table The table name as index of merged form
     * @return array|mixed
     */
    public function getFormLabels($table = null)
    {
        return (null == $table)? $this->formlabels : $this->formlabels[$table];
    }

    /**
     * @param $table
     * @param $field
     * @return array|bool|mixed
     */
    protected function getInputValue($table, $field)
    {
        if(isset($this->validated[$table][$field])){
            return $this->validated[$table][$field];
        }
        $value = FormValidator::getValue($field);
        if($value != false){
            return $value;
        }
        if(!isset($this->forminputs[$table][$field])){
            echo 'index \'' . $field . '\' not exists for index \'' . $table . '\' in ' . get_called_class();
            die();
        }
        return $this->forminputs[$table][$field]->getValue();
    }

    /**
     * @param $table
     * @param $field
     * @return array|bool|mixed
     */
    protected function getInputDate($table, $field)
    {
        if(isset($this->validated[$table][$field])){
            return $this->validated[$table][$field];
        }
        $value = FormValidator::getValue($field);
        if($value != false){
            if(is_array($value)){
                if(!isset($value['min'])){
                    $value['min'] = null;
                }
                if(!isset($value['max'])){
                    $value['max'] = null;
                }

            }
            return $value;
        }
        return $this->forminputs[$table][$field]->getValue();
    }


    #fullfill input values from query
    /**
     * @param \lib\model\Model $model
     * @return $this
     */
    public function setQueryValues(\lib\model\Model $model = null)
    {
        if(null != $model){
            if(method_exists($model,'exec')){
                die("Error: execute query first by find() or findOne()");
            }
            $columns = $model->getFields();
            foreach($this->forminputs as $table=>$forminputs){
                if(isset($this->models[$table])){
                    $fks = $this->models[$table]->getForeignKeys();
                }

                foreach($forminputs as $field=>$input){
                    if (array_key_exists($field, $columns)) {
                        $value = $model->getColumnValue($field);

                        $input->setValue($value);
                        if(isset($fks[$field])){
                            $this->duplicateValue($fks[$field], $value, $input);
                        }
                    }
                }
            }
        }
        return $this;
    }

    /**
     * @param $fk
     * @param $value
     * @param $this_input
     */
    private function duplicateValue($fk, $value, $this_input)
    {
        #$this->fk[HtmPage::HTM_PAGE_HTM_ID] = ['table'=>'htm', 'field'=>'id'];
        $table = $fk['table'];
        $field = $table . '.' . $fk['field'];
        if(isset($this->forminputs[$table][$field])){
            $input = $this->forminputs[$table][$field];
            if($input->getValue() == null){
                $input->setValue($value);
            }else{
                $this_input->setValue($input->getValue());
            }
        }
    }

    #render form
    /**
     * render the part of inputs type hidden
     * @param String $actionclass That will be part of input names
     *
     * @return string
     */
    public function renderHiddenFields($actionclass = null)
    {
        return FormRender::renderHiddenFields($this->queue, $this->forminputs, $actionclass);
    }

    /**
     * @param $actionclass
     * @param $config
     * @return array
     */
    public function renderInputs($actionclass, $config)
    {
        #echo $this->forminputs['client_prp']['client_prp.pact']->getInputType() . '<br />';
        #echo $this->getClientPrpForm()->getPactInput()->getInputType() . '<br />';
        return FormRender::renderInputs($this->forminputs, $this->formlabels, $actionclass, $config);
    }

    #return for merged forms
    /**
     * @return int
     */
    public function getErrors()
    {
        return $this->processerrors;
    }

    /**
     * @param String $table The table name as index of merged form
     * @return array
     */
    public function getModels($table = null)
    {
        return (null == $table)? $this->models : $this->models[$table];
    }


    /**
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->primarykey;
    }

    #filters
    /**
     * @return $this
     */
    public function prepareFilters()
    {
        foreach($this->forminputs as $form){
            foreach($form as $input){
                $input->emptyValue();
                $name = 'filter_' . $input->getName();
                $input->setName($name)->setId($name);
                $input->setRequired(false);
            }
        }
        return $this;
    }

    /**
     * @param $table
     * @param $field
     * @param $prefix
     */
    public function renameInput($table, $field, $prefix)
    {
        $input = $this->forminputs[$table][$field];
        $name = $prefix . $input->getName();
        $input->setName($name)->setId($name);
        $input->setRequired(false);
    }

}
