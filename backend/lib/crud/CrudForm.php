<?php

namespace lib\crud;

use \lib\coreutils\ModelTools as Tools;
use \lib\crud\CrudTools as CrudTools;

/**
 * Description of CrudForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 9, 2015
 */
class CrudForm
{
    /**
     * @var
     */
    private $form_str;
    /**
     * @var string
     */
    private $form;

    /**
     * @var
     */
    private $table;
    /**
     * @var
     */
    private $class;

    /**
     * @var array
     */
    private $fk = []; //foreign keys
    /**
     * @var null
     */
    private $composite_key = null;

    /**
     *
     */
    const SP =  "\n            ";


    /**
     * CrudForm constructor.
     * @param String $table The table name
     * @param String $class The class name
     * @param String $fk The foreign key
     * @param String $composite_key Primary key with more than one field
     */
    public function __construct($table, $class, $fk, $composite_key = null)
    {
        $this->form_str = file_get_contents(ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'form_input.tpl');
        $this->form = ROOT . DS . 'model' . DS . 'forms' . DS . $class . 'Form.php';

        $this->table = $table;
        $this->class = $class;
        $this->fk =  $fk;
        $this->composite_key = $composite_key;
        echo $this->class . "Form \n";

    }

    /**
     * @param $fields
     */
    public function writeFormMethods($fields)
    {
        $this->writeMethods($fields);
        $this->writeDeclare($fields);
        $this->writeValidate($fields);
    }

    /**
     * @param $fields
     */
    private function writeMethods($fields)
    {
        /*
         * fieldnames[] = $field['Field'];
            $fieldtypes[] = $field['Type'];
            $fieldkeys[] = $field['Key'];
         */
        foreach ($fields as $field) {
            if($field['Type'] == 'timestamp' || $field['Comment'] == 'ignore'){
                continue;
            }
            $string = file_get_contents($this->form);
            $str_a = substr($string, 0, strripos($string, '}') - 1);

            $type = CrudTools::getFieldType($field['Type']);

            $fstring = $this->writeMethod($this->form_str, $field, $type);
            $fstring = str_replace('%$method%', Tools::buildModelName($field['Field']), $fstring);
            $fstring = str_replace('%$column%', CrudTools::joinToString([$this->table, $field['Field']], '.'), $fstring);
            $fstring = str_replace('%$label%', CrudTools::setLabel($field['Field']), $fstring);
            $fieldconstant = $this->class . '::' . CrudTools::writeFieldConstantName($this->table, $field['Field']);
            $fstring = str_replace('%$field%', $fieldconstant, $fstring);
            $table = $this->class . '::TABLE';
            $fstring = str_replace('%$table%', $table, $fstring);

            $string = $str_a . $fstring . "\n\n}";
            file_put_contents($this->form, $string);
        }
    }

    /**
     * @param $fstring
     * @param $field
     * @param $type
     * @return bool
     */
    private function writeMethod($fstring, $field, $type)
    {
        $valmethod = $args = '';
        #echo $field['Field'] . " :  " . $type . "; ";
        if ($field['Key'] == 'PRI' && $this->composite_key == null) {
            $input = 'HiddenInput';
            $valmethod = 'PrimaryKey';
            $args = $this->writevalidatePKfield($field['Field']);
        }elseif($field['Key'] == 'PRI' && $type == 'varchar'){
            $input = 'InputText';
            $valmethod = 'PrimaryKey';
            $args = $this->writevalidatePKfield($field['Field']);
        } elseif ($type == 'set' || $type == 'enum') {
            $input = 'SelectInput';
            $valmethod = 'Values';
            $fstring = $this->writeSet($fstring, $field);
        } elseif (($field['Key'] == 'MUL' || ($field['Key'] == 'PRI')) && $field['Null'] == 'NO') {
            $input = 'SelectInput';
            $valmethod = 'Model';
            $result = $this->writeMul($fstring, $field['Field'], $field['Null'], $field['Default']);
            if($result == false){
                $input = 'InputText';
                $fstring = $this->writeVarcharInput($fstring, $field, $type);
            }else{
                $fstring = $result;
            }
        } elseif ($type == 'date' || $type == 'time' || $type == 'datetime' || $type == 'year') {
            $input = 'DateInput';
            $valmethod = 'Date';
            $fstring = $this->writeDateInput($fstring, $field);
        } elseif ($type == 'text' || $type == 'tinytext') {
            $input = 'TextAreaInput';
            $valmethod = 'Text';
            $fstring = str_replace(', %$args%', '', $fstring);
        } elseif ($type == 'tinyint') {
            $input = 'BooleanInput';
            $valmethod = 'Bool';
            $fstring = str_replace(', %$args%', '', $fstring);
        } else {
            $input = 'InputText';
            $fstring = $this->writeVarcharInput($fstring, $field, $type);
        }

        $fstring = str_replace('%$inputMethod%', $input, $fstring);
        $fstring = str_replace('%$valmethod%', $valmethod, $fstring);
        $fstring = str_replace('%$args%', $args, $fstring);
        return $fstring;
    }

    /**
     * @return string
     */
    private function writevalidatePKfield()
    {
        return '\\model\\querys\\' . Tools::buildModelName($this->table) . 'Query::start()';
    }

    /**
     * @param $fstring
     * @param $field
     * @return mixed
     */
    private function writeDateInput($fstring, $field)
    {
        $str = ":create('%\$field%');" . "\$input->setTimestamp('" . $field['Type'] . "');";
        $fstring = str_replace(":create('%\$field%');", $str, $fstring);
        $fstring = str_replace(', %$args%', '', $fstring);
        $fstring = str_replace('$this->getInputValue', '$this->getInputDate', $fstring);
        return $fstring;
    }

    /**
     * @param $fstring
     * @param $field
     * @return mixed
     */
    private function writeSet($fstring, $field)
    {
        //$field['Field'], $field['Null'], $field['Default']
        $property = '\\model\\models\\' . $this->class . '::$' . $field['Field'] . 's';
        $str = '::create(%$field%);' . "\n\t";
        $str .= ($field['Null'] == 'NO') ? self::SP . '$input->setRequired(true);' : '';
        $str .= "\$input->setValuesList(" . $property. ');';
        $str .= ($field['Default'] != null)? "\n\t" . '$input->setDefault(' . CrudTools::joinToString($field['Default'], null, "'") . ');' : '';
        $fstring = str_replace('::create(%$field%);', $str, $fstring);

        $args['values'] = $property;
        echo $property . "\n";
        $args['bool'] =($field['Null'] == 'NO') ? 'true' : 'false';
        if($field['Default'] != null){
            $args['default'] = "'" . $field['Default']. "'";
        }
        $fstring = str_replace('%$args%', implode(', ', $args), $fstring);
        return $fstring;
    }

    /**
     * @param $fstring
     * @param $column
     * @param $null
     * @param $default
     * @return bool
     */
    private function writeMul($fstring, $column, $null, $default)
    {
        $x = 0;
        foreach ($this->fk as $fk) {
            if ($fk['column_name'] == $column) {
                $x++;
                $strset = '::create(%$field%);';
                $strset .= ($null == 'NO')? self::SP . '$input->setRequired(true);' : '';
                $indexname = '\\model\\models\\' . Tools::buildModelName($fk['ref_table']). '::' . CrudTools::writeFieldConstantName($fk['ref_table'], $fk['ref_column']);
                $strset .= self::SP . "\$input->setOptionIndex(" . $indexname . ");";
                $strset .= self::SP . '$input->addEmpty();';
                $strset .= self::SP . '$input->setModel(\\model\\querys\\' . Tools::buildModelName($fk['ref_table']) . 'Query::start());';
                $strset .= ($default != null)? self::SP . '$input->setDefault(' . CrudTools::joinToString($default, null, "'") . ');' : '';

                $fstring = str_replace('::create(%$field%);', $strset, $fstring);

                $args['query'] = '\\model\\querys\\' . Tools::buildModelName($fk['ref_table']) . 'Query::start()';
                $args['index'] = CrudTools::joinToString([$fk['ref_table'], $fk['ref_column']], '.', "'", "'");
                $args['bool'] = ($null == 'NO')? 'true' : 'false';

                $fstring = str_replace('%$args%', implode(', ', $args), $fstring);

            }
        }
        if($x == 0){
            return false;
        }
        return $fstring;

    }


    /**
     * @param $fstring
     * @param $field
     * @param $type
     * @return mixed
     */
    private function writeVarcharInput($fstring, $field, $type)
    {
        //$field['Field'], $field['Type'], $field['Null'], $field['Default']
        $strset = '::create(%$field%);';
        $strset .= ($field['Null'] == 'NO') ? self::SP . '$input->setRequired(true);' : '';
        $strset .= ($field['Default'] != null) ? self::SP . '$input->setDefault(' . CrudTools::joinToString($field['Default'], null, "'") . ');' : '';
        $lenght = $size = 0;

        if ($type == 'int') {
            $lenght = str_replace(['int(', ')'], ['', ''], $field['Type']);
            $size = $lenght;
            $strset .= "\$input->setMaxlength('$lenght');";
            $valmethod = 'Int';

        } elseif ($type == 'decimal'  || $type == 'float') {
            $lenght = str_replace(['decimal(','float(',')'], [''], $field['Type']);
            $size = $lenght;
            $lenght = intval($lenght) + floatval($lenght) + 1;
            $strset .= "\$input->setMaxlength('" . $lenght . "');";
            $valmethod = 'Float';
        }else{
            $size = $lenght = str_replace(['varchar(', ')'], ['', ''], $field['Type']);
            $strset .= "\$input->setMaxlength('$lenght');";
            $valmethod = 'String';
        }
        $args['bool'] = ($field['Null'] == 'NO') ? 'true' : 'false';
        $args['lenght'] = str_replace(',', '.', $size);

        $fstring = str_replace('::create(%$field%);', $strset, $fstring);
        $fstring = str_replace('%$valmethod%', $valmethod, $fstring);
        $fstring = str_replace('%$args%', implode(', ', $args), $fstring);
        return $fstring;
    }

    /**
     * @param $fields
     */
    private function writeDeclare($fields)
    {
        $string = file_get_contents($this->form);
        $original = "#\$this->set%\$method%Input();";
        foreach ($fields as $field) {
            if($field['Type'] == 'timestamp' || $field['Comment'] == 'ignore'){
                continue;
            }
            $str = str_replace(['#','%$method%'], ['',Tools::buildModelName($field['Field'])], $original);
            $string = str_replace($original, $str . "\n\t" . $original, $string);
        }
        $string = str_replace($original, '', $string);
        file_put_contents($this->form, $string);
    }


    /**
     * @param $fields
     */
    private function writeValidate($fields)
    {
        $string = file_get_contents($this->form);
        $original = '#$this->validate%$validateMethod%Input();';
        foreach ($fields as $field) {
            if ($field['Type'] == 'timestamp' || $field['Comment'] == 'ignore') {
                continue;
            }
            $str = str_replace(['#','%$validateMethod%'], ['',Tools::buildModelName($field['Field'])], $original);
            $string = str_replace($original, $str . "\n\t" . $original, $string);
        }
        $string = str_replace($original, '', $string);
        file_put_contents($this->form, $string);
    }


}
