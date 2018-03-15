<?php

namespace lib\crud;

use \lib\crud\CrudTools as CrudTools;
use \lib\db\PdoMysql as PdoMysql;
use PDO;
use \lib\coreutils\ModelTools as Tools;

/**
 * Description of CrudModel
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 11, 2014
 */
class CrudModel
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var
     */
    private $setget_str;
    /**
     * @var
     */
    private $filter_str;
    /**
     * @var
     */
    private $join_str;
    /**
     * @var
     */
    private $merge_str;

    /**
     * @var string
     */
    private $model;
    /**
     * @var string
     */
    private $query;
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
    private $constrains = [];
    /**
     * @var array
     */
    private $fk = []; //foreign keys


    /**
     * CrudModel constructor.
     * @param $table
     * @param $class
     */
    public function __construct($table, $class)
    {
        $this->pdo = PdoMysql::getConn();
        $this->setget_str = file_get_contents(ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'model_get_set.tpl');
        $this->filter_str = file_get_contents(ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'query_filter.tpl');
        $this->join_str = file_get_contents(ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'query_join.tpl');
        $this->merge_str = file_get_contents(ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'model_join.tpl');
        $this->form_str = file_get_contents(ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'form_input.tpl');

        $this->model = ROOT . DS . 'model' . DS . 'models' . DS . $class . '.php';
        $this->query = ROOT . DS . 'model' . DS . 'querys' . DS . $class . 'Query.php';
        $this->form = ROOT . DS . 'model' . DS . 'forms' . DS . $class . 'Form.php';

        $this->table = $table;
        $this->class = $class;
    }

    /**
     *
     */
    public function crud()
    {
        echo $this->class . " \n";

        $primaryKeys = $uniqueKeys = $fieldnames = $methods = $fieldtypes = $fieldkeys = $increments = [];

        $sth = $this->pdo->prepare("SHOW FULL COLUMNS FROM " . $this->table);
        $sth->execute();
        $table_fields = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($table_fields as $field){
            if($field['Comment'] == 'ignore'){
                continue;
            }
            $fieldnames[] = $field['Field'];
            $fieldtypes[] = $field['Type'];
            $fieldkeys[] = $field['Key'];
            $methods[] = Tools::buildModelName($field['Field']);
            if($field['Key']=='PRI'){
                $primaryKeys[] = $field['Field'];
                if($field['Extra'] == 'auto_increment'){
                    $increments[] = $field['Field'];
                }
            }elseif($field['Key']=='UNI'){
                $uniqueKeys[] = $field['Field'];
            }
            //echo $field['Field']. " ->" . $field['Type'] . "\n";
        }
        $composite_key = (count($increments)==0)? $primaryKeys : null;

        $this->writeMethods($table_fields, $fieldnames, $fieldtypes, $methods, $composite_key);
        $files = [$this->model, $this->query, $this->form];
        foreach($files as $file){
            $str = file_get_contents($file);
            $str = CrudTools::writefieldNames($this->table, $str, $primaryKeys, $uniqueKeys, $fieldnames, $increments);
            $str = $this->emptyTrash($str);
            file_put_contents($file, $str);
        }


    }

    /**
     * @param $table_fields
     * @param $fieldnames
     * @param $fieldtypes
     * @param $methods
     * @param $composite_key
     */
    private function writeMethods($table_fields, $fieldnames, $fieldtypes, $methods, $composite_key)
    {
        $this->writeModelMethods($this->table, $fieldnames, $fieldtypes, $methods);
        $this->writeQueryMethods($this->table, $fieldnames, $fieldtypes, $methods);
        $this->writeConstants($this->table, $fieldnames);
        $this->setJoins();
        $form = new CrudForm($this->table, $this->class, $this->fk, $composite_key);
        $form->writeFormMethods($table_fields);
        $this->setToString($this->table);
        $this->writeJoins();
    }

    /**
     * @param $string
     * @return mixed
     */
    private function emptyTrash($string)
    {
        $trash[] = "\$this->uniqueKey = [''];";
        $trash[] = "#\$this->columnNames['%\$tableJoinName%'] = [%\$tableJoinColumns%];";
        $trash[] = "#\$this->tableJoins['%\$tableJoinName%'] = ['join' => 'INNER JOIN', 'left'=>'%\$joinTableName%.%\$joinColumnName%', 'right'=>'%\$tableJoinName%.%\$referencedColumn%'];\n";
        $trash[] = '#%$fieldconstant%';
        $trash[] = "#\$this->fk[%\$fkField%] = ['table'=>'%\$consTable%', 'field'=>'%\$consField%'];";
        $string = str_replace($trash, '', $string);
        return $string;
    }


    /**
     *
     */
    private function setJoins()
    {
        $str_join = "#\$this->tableJoins['%\$tableJoinName%'] = ['join' => Mysql::INNER_JOIN, 'left'=>'%\$joinTableName%.%\$joinColumnName%', 'right'=>'%\$tableJoinName%.%\$referencedColumn%'];";
        $str_table = "#\$this->fk[%\$fkField%] = ['table'=>'%\$consTable%', 'field'=>'%\$consField%'];";
        foreach($this->constrains as $i=>$constrain){
            $join = $str_join;
            if($constrain['TABLE_NAME'] == $this->table){

                $jointable = $constrain['REFERENCED_TABLE_NAME'];

                $string = file_get_contents($this->model);

                $string = preg_replace('/[\r|\n|\s]+(\$this->tableJoins\[\''.$jointable.'\']).+/', '', $string);

                $original = ['%$tableJoinName%','%$joinTableName%','%$referencedColumn%','%$joinColumnName%','#'];
                $replace = [$jointable, $this->table, $constrain['REFERENCED_COLUMN_NAME'],$constrain['COLUMN_NAME'],''];
                $join = str_replace($original, $replace, $join);
                $string = str_replace($str_join, $join . "\n\t" . $str_join, $string);

                $fk = $str_table;
                $original = ['%$fkField%','%$consTable%','%$consField%','#'];
                $replace = [$this->class . '::' . CrudTools::writeFieldConstantName($constrain['TABLE_NAME'], $constrain['COLUMN_NAME'], $this->table), $jointable, $constrain['REFERENCED_COLUMN_NAME'], ''];
                $str = str_replace($original, $replace, $fk);
                $string = str_replace($str_table, $str . "\n\t" . $str_table, $string);

                file_put_contents($this->model, $string);

                $this->mergeColumns($constrain['REFERENCED_TABLE_NAME']);
                $this->fk[$i]['ref_table'] = $constrain['REFERENCED_TABLE_NAME'];
                $this->fk[$i]['column_name'] = $constrain['COLUMN_NAME'];
                $this->fk[$i]['ref_column'] = $constrain['REFERENCED_COLUMN_NAME'];
            }

        }
    }

    /**
     * @param $table
     */
    private function mergeColumns($table)
    {
        $fieldnames = $methods = $fieldtypes = [];
        $query = "SHOW FULL COLUMNS FROM " . $table;
        $sth = $this->pdo->prepare($query);
        $sth->execute();
        $table_fields = $sth->fetchAll(PDO::FETCH_ASSOC);
        echo count($table_fields) . " fields  in " . $table . "\n";
        foreach ($table_fields as $field){
            if($this->validation($table, $field['Field']) == false){
                continue;
            }
            if($field['Key'] != 'PRI'){
                $fieldnames[] = $field['Field'];
                $fieldtypes[] = $field['Type'];
                $methods[] = Tools::buildModelName($table.'_'.$field['Field']);
            }
        }
        if (count($fieldnames) > 0) {
            /*
            $fieldnames = array_unique($fieldnames);
            $string = file_get_contents($this->model);

            $str = "#\$this->columnNames['%\$tableJoinName%'] = [%\$tableJoinColumns%];";
            $string = preg_replace('/[\r|\n|\s]+(\$this->columnNames\[\'' . $table . '\']).+/', '', $string);

            $join = str_replace('%$tableJoinName%', $table, $str);
            $join = str_replace('%$tableJoinColumns%', "'" . implode("', '", $fieldnames) . "'", $join);
            $join = str_replace('#', '', $join);

            $string = str_replace($str, $join . "\n        " . $str, $string);
            file_put_contents($this->model, $string);

            //$this->writeModelMethods($table, $fieldnames, $fieldtypes, $methods);
            //$this->writeQueryMethods($table, $fieldnames, $fieldtypes, $methods);
            //$this->writeConstants($table, $fieldnames, $this->table);
             *
             */
        }
    }

    /**
     * @param $table
     * @param $fieldname
     * @return bool
     */
    private function validation($table, $fieldname)
    {
        if($table != $this->table){
            if($fieldname == 'password' || $fieldname == 'username' ){
                return false;
            }
        }
        if(strpos($fieldname, 'oldid') !== false){
            return false;
        }
        return true;
    }


    /**
     * @param $table
     * @param $fieldnames
     * @param $fieldtypes
     * @param $methods
     */
    private function writeQueryMethods($table, $fieldnames, $fieldtypes, $methods)
    {
        foreach ($fieldnames as $i => $column) {
            if($this->validation($table, $column) == false){
                continue;
            }
            $string = file_get_contents($this->query);

            if (!strpos($string, 'filterBy' . $methods[$i])) {
                $type = CrudTools::getFieldType($fieldtypes[$i]);
                $str_a = substr($string, 0, strripos($string, '}')-1);

                $fstring = $this->filter_str;
                $fieldconstant = $this->class . '::' . CrudTools::writeFieldConstantName($table, $column, $this->table);

                $fstring = str_replace('%$method%', $methods[$i], $fstring);

                if(strpos($type,'date') !== false || strpos($type,'time') !== false){
                    $fstring = str_replace(', $operator = Mysql::EQUAL', ', $operator = Mysql::BETWEEN', $fstring);
                    $fstring = str_replace('($values', '($min = null, $max = null', $fstring);
                    $fstring = str_replace('$values', '$min, $max', $fstring);
                    $fstring = str_replace('$this->filterByColumn', '$this->filterByDateColumn', $fstring);

                }
                $fstring = str_replace('%$tableColumn%', $fieldconstant , $fstring);

                $string = $str_a . "\n" . $fstring . "\n}";
                file_put_contents($this->query, $string);
            }
        }
    }


    /**
     *
     */
    private function writeJoins()
    {
        $tables = [];
        foreach($this->constrains as $constrain){
            if(!in_array($constrain['REFERENCED_TABLE_NAME'], $tables) && $constrain['TABLE_NAME'] == $this->table){
                $tables[] = $constrain['REFERENCED_TABLE_NAME'];
                $this->writeJoin(
                        $constrain['REFERENCED_TABLE_NAME'],
                        $constrain['COLUMN_NAME'],
                        $constrain['REFERENCED_COLUMN_NAME']);
            }

            if(!in_array($constrain['TABLE_NAME'], $tables) && $constrain['REFERENCED_TABLE_NAME'] == $this->table){
                $tables[] = $constrain['TABLE_NAME'];
                $this->writeJoin($constrain['TABLE_NAME'],
                        $constrain['REFERENCED_COLUMN_NAME'],
                        $constrain['COLUMN_NAME']);
            }
        }
    }

    /**
     * @param $referenced_table
     * @param $leftcol
     * @param $rightcol
     */
    private function writeJoin($referenced_table, $leftcol, $rightcol)
    {
        $string = file_get_contents($this->query);
        $str_a = substr($string, 0, strripos($string, '}')-1);
        $fstring = $this->join_str;

        $class = CrudTools::crudName($referenced_table);
        $fstring = str_replace('%$tableJoin%', $class, $fstring);
        $fstring = str_replace('%$table%', $class . '::TABLE', $fstring);

        $fieldconstant = $this->class . '::' . CrudTools::writeFieldConstantName($this->table, $leftcol);
        $fstring = str_replace('%$leftcol%', $fieldconstant, $fstring);

        $fieldconstant = $class . '::' . CrudTools::writeFieldConstantName($referenced_table, $rightcol);
        $fstring = str_replace('%$rightcol%', $fieldconstant, $fstring);

        $string = $str_a . "\n" . $fstring . "\n}";
        file_put_contents($this->query, $string);

        ###################

        $string = file_get_contents($this->model);
        $str_a = substr($string, 0, strripos($string, '}')-1);
        $fstring = $this->merge_str;

        $class = CrudTools::crudName($referenced_table);
        $fstring = str_replace('%$tableJoin%', $class, $fstring);

        $string = $str_a . "\n" . $fstring . "\n}";
        file_put_contents($this->model, $string);
    }

    /**
     * @param $string
     * @param $str_a
     * @param $column
     * @param $fieldtype
     * @return string
     */
    private function writeEnum($string, $str_a, $column, $fieldtype)
    {
        $strtype = str_replace(['set(','enum(',')'],['',''],$fieldtype);
        $values = explode(',', $strtype);
        $property = 'public static $' . $column . 's = [' . implode(', ',$values) . '];';
        if (strpos($string, 'public static $' . $column) !== false) {
            $str_a = preg_replace('/(public static \$' . $column . ').+/', $property, $str_a);
        } else {
            foreach($values as $val){
                $const = strtoupper($column) . '_' . str_replace(["'",'-'],['','_'],strtoupper($val));
                $str_a .= "\n    const " . $const . ' = ' . $val . ';';
            }
            $str_a .= "\n    " . $property . "\n\n\n";
        }
        $string = $str_a . "}";
        \lib\crud\CrudEnum::writeEnum($this->table . '.' . $column, $values);
        return $string;
    }


    /**
     * @param $table
     * @param $fieldnames
     * @param $fieldtypes
     * @param $methods
     */
    private function writeModelMethods($table, $fieldnames, $fieldtypes, $methods)
    {
        foreach ($fieldnames as $i => $column) {
            if($this->validation($table, $column) == false){
                continue;
            }
            $string = file_get_contents($this->model);
            $str_a = substr($string, 0, strripos($string, '}')-1);
            if((strpos($fieldtypes[$i],'set') === 0 || strpos($fieldtypes[$i],'enum') === 0)
                    && $table == $this->table){
                $string = $this->writeEnum($string, $str_a, $column, $fieldtypes[$i]);
                file_put_contents($this->model, $string);
                $string = file_get_contents($this->model);
                $str_a = substr($string, 0, strripos($string, '}')-1);

            }


            if (!strpos($string, 'set' . $methods[$i]) && !strpos($string, 'enum' . $methods[$i])) {
                $fstring = $this->setget_str;
                $type = CrudTools::getFieldType($fieldtypes[$i]);
                $fstring = str_replace('%$method%', $methods[$i], $fstring);
                if(strpos($type,'date') !== false || strpos($type,'time') !== false){
                    $fstring = str_replace('$this->setColumnValue', '$this->setColumnDate', $fstring);
                }


                $fieldconstant = $this->class . '::' . CrudTools::writeFieldConstantName($table, $column, $this->table);
                $fstring = str_replace('%$tableColumn%', $fieldconstant, $fstring);

                $string = $str_a . $fstring . "\n\n}";
                file_put_contents($this->model, $string);
            }
        }
    }

    /**
     * @param String $table
     * @param String $fieldnames
     * @param String $maintable
     */
    private function writeConstants($table, $fieldnames, $maintable = null)
    {
        $fieldnames = array_unique($fieldnames);
        $tpl = '#%$fieldconstant%';
        $string = file_get_contents($this->model);
        foreach($fieldnames as $field){
            if($this->validation($table, $field) == false){
                continue;
            }
            $string = str_replace($tpl, CrudTools::writeFieldConstant($table, $field, $maintable) . "\n    " . $tpl, $string);
        }
        $string = str_replace($tpl, "\n    " . $tpl, $string);
        file_put_contents($this->model, $string);
    }


    /**
     * @param $table
     */
    private function setToString($table)
    {
        $string = file_get_contents($this->model);
        $query = "SHOW FULL COLUMNS FROM " . $table;
        $sth = $this->pdo->prepare($query);
        $sth->execute();
        $table_fields = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($table_fields as $field){
            if($field['Comment'] == 'to-string' || strpos($field['Type'],'varchar')===0 && $field['Key'] != 'MUL'){
                $str = 'return $this->get'.Tools::buildModelName($field['Field']).'();';
                $string = str_replace('return $this->get%$toString%();', $str, $string);
            }
        }
        $str = 'return "";';
        $string = str_replace('return $this->get%$toString%();', $str, $string);
        file_put_contents($this->model, $string);
    }

    /**
     * @param $constrains
     */
    public function setConstrains($constrains)
    {
        $this->constrains = $constrains;
    }

}
