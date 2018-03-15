<?php

namespace lib\form;

/**
 * Description of FormMerged
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 23, 2015
 */
class FormMerged extends \lib\form\Form
{
    /**
     * @var array
     */
    protected $forms = [];

    /**
     * @param bool $fk_merge
     */
    protected function merge($fk_merge = true)
    {
        foreach ($this->forms as $table=>$form){
            $this->forminputs[$table] = $form->getFormInputs($table);
            $this->formlabels[$table] = $form->getFormLabels($table);
            $fks = $this->models[$table]->getForeignKeys();
            foreach (array_keys($this->forminputs[$table]) as $field) {
                #$this->fk[HtmPage::HTM_PAGE_HTM_ID] = ['table'=>'htm', 'field'=>'id'];
                if ($fk_merge == true && isset($fks[$field]) && isset($this->forms[$fks[$field]['table']])) {
                    $form->setFieldInput($table, $field, \lib\form\input\HiddenInput::create($field));
                    $this->setFieldInput($table, $field, \lib\form\input\HiddenInput::create($field));
                }
            }
        }
    }


    /**
     * @return \lib\form\FormMerged
     */
    public function validate()
    {
        foreach ($this->forms as $table=>$form){

            $fks = $this->models[$table]->getForeignKeys();
            foreach (array_keys($this->forminputs[$table]) as $field) {

                #$this->fk[HtmPage::HTM_PAGE_HTM_ID] = ['table'=>'htm', 'field'=>'id'];
                if (isset($fks[$field]) && isset($this->forms[$fks[$field]['table']])) {
                    $value = $this->getFkValue($fks[$field]);
                    if($value === null){
                        $this->forms[$table]->setNullValues($table, $field);
                    }
                }
            }
            $this->forms[$table]->validate();
            

            $this->processerrors += $form->getErrors();
            $this->models[$table] = $form->getModels($table);
            $this->forminputs[$table] = $form->getFormInputs($table);
        }
        $this->customValidate();
        return $this;
    }

    /**
     * @param $table
     * @param $field
     * @return \lib\form\FormMerged
     */
    public function unsetFieldInput($table, $field)
    {
        unset($this->forminputs[$table][$field]);
        return $this;
    }



}
