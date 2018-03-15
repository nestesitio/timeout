<?php

namespace lib\crud;

use \lib\coreutils\ModelTools as Tools;
use \lib\tools\StringTools;

/**
 * Description of CrudTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 9, 2015
 */
class CrudTools
{
    /**
     * @param $name
     * @return mixed
     */
    public static function setLabel($name)
    {
        $name = str_replace('_', ' ', $name);
        return ucwords($name);
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function crudName($name)
    {
        $name = str_replace('_', ' ', $name);
        return str_replace(' ', '', ucwords($name));
    }

    /**
     * @param $values
     * @param $glue
     * @param string $rdel
     * @param string $ldel
     * @return string
     */
    public static function joinToString($values, $glue, $rdel = '', $ldel = '')
    {
        if(empty($ldel)){
            $ldel = $rdel;
        }
        if(is_array($values)){
            return $rdel . implode($glue, $values) . $ldel;
        }else{
            return $rdel . $values . $ldel;
        }
    }

    /**
     * @param String $table
     * @param String $field
     * @param String $maintable
     * @return string
     */
    public static function writeFieldConstantName($table, $field, $maintable = null)
    {
        $str = ($maintable == null || $table == $maintable)? '' : StringTools::getStringAfterLastChar($table, '_') . '_';
        return 'FIELD_' . strtoupper($str) . strtoupper($field);
    }

    /**
     * @param String $table
     * @param String $field
     * @param String $maintable
     * @return string
     */
    public static function writeFieldConstant($table, $field, $maintable = null)
    {
        return 'const ' . self::writeFieldConstantName($table, $field, $maintable) . " = '" . $table . '.' . $field . "';";
    }


    /**
     * @param $table
     * @param $string
     * @param $primaryKeys
     * @param $uniqueKeys
     * @param $fieldnames
     * @param $increments
     * @return mixed
     */
    public static function writefieldNames($table, $string, $primaryKeys, $uniqueKeys, $fieldnames, $increments)
    {
        $string = preg_replace('/(Updated @).+/', 'Updated @%$dateUpdated%', $string);
        //writeFieldConstantName($table, $field)

        $string = preg_replace('/(\$this->columnNames\[\''.$table.'\']).+/',
                '$this->columnNames[\'%$tableName%\'] = [%$tableColumns%];', $string);
        $keys = ['primaryKey'=>'%$primaryKeys%', 'uniqueKey'=>'%$uniqueKeys%', 'inputnames'=>'%$inputNames%'];
        foreach($keys as $k=>$key){
            $string = preg_replace('/(\$this->' .$k . ').+/',
                '$this->' .$k . ' = [' .$key . '];', $string);
        }

        foreach($increments as $increment){
            $string = str_replace('%$incrementKey%', $increment, $string);
        }
        $string = str_replace("\$this->autoincrement = '%\$incrementKey%';", '', $string);

        $string = str_replace('%$dateUpdated%', date('Y-m-d H:i'), $string);
        $string = str_replace('%$tableName%', $table, $string);
        $keys = ['primaryKeys'=>$primaryKeys, 'uniqueKeys'=>$uniqueKeys, 'tableColumns'=>$fieldnames];
        foreach($keys as $k=>$arr){
            $string = str_replace('%$' . $k . '%', "'" . implode("', '",$arr) . "'", $string);
        }

        $glue = "', '" . $table . ".";
        $string = str_replace('%$inputNames%', "'" . $table . '.' . implode($glue, $fieldnames) . "'", $string);
        $string = str_replace('%$className%', Tools::buildModelName($table), $string);
        $string = str_replace('%$modelName%', Tools::buildModelName($table), $string);
        $string = str_replace('#%$fieldconstant%', 'const TABLE = ' . "'" . $table . "';" . "\n    " . '#%$fieldconstant%', $string);


        return $string;
    }

    /**
     * @param $tpl
     * @param $file
     * @param $class
     */
    public static function copyFile($tpl, $file, $class)
    {
        copy($tpl, $file);
        $string = file_get_contents($file);
        $string = str_replace('%$dateCreated%', date('Y-m-d H:i'), $string);
        $string = str_replace('%$className%', $class, $string);
        file_put_contents($file, $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function getFieldType($string)
    {
        $pos = strpos($string, '(');
        return ($pos === false)? $string : substr($string, 0, $pos);
    }

}
