<?php

namespace lib\coreutils;

/**
 * Description of ModelTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 14, 2015
 */
/**
 * Class ModelTools
 * @package lib\coreutils
 */
class ModelTools
{
    /**
     * @param $name
     * @return mixed
     */
    public static function buildModelName($name)
    {
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        return str_replace(' ', '', $name);
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function buildModelQuery($table)
    {
        $class = '\\model\\querys\\' . self::buildModelName($table) . 'Query';
        return $class::create();
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function buildModelForm($table)
    {
        $class = '\\model\\forms\\' . self::buildModelName($table) . 'Form';
        return new $class();
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function buildModel($table)
    {
        $class = '\\model\\models\\' . self::buildModelName($table);
        return new $class();
    }



}
