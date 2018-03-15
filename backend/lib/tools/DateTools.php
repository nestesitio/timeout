<?php

namespace lib\tools;

use \DateTime;

/**
 * Description of DateTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 25, 2015
 */
class DateTools
{
    /**
     * @var array
     */
    public static $formats = ['YEAR', 'QUARTER', 'MONTH', 'WEEK'];

    /**
     * @param $date
     * @return string
     */
    public static function convertToSqlDate($date)
    {
        $format = '0000-00-00 00:00:00';
        $string = '';
        for($i = 0; $i < strlen($format); $i++){
            $string .= (substr($date, $i, 1) == '')? substr($format, $i, 1) : substr($date, $i, 1);
        }
        $newdate = DateTime::createFromFormat('Y-m-d H:i:s', $string);

        return $newdate->format('Y-m-d H:i:s');
    }

    /**
     * @return array
     */
    public static function formatsForSql()
    {
        return ['YEAR' => '%Y', 'QUARTER' => '%b-%y', 'MONTH' => '%b-%y', 'WEEK' => '%u-%b-%y'];
    }

    /**
     * @param $field
     * @param $group
     * @return string
     */
    public static function sqlFormat($field, $group)
    {
        if($group == 'YEAR'){
            return 'DATE_FORMAT('.$field .', "%Y")';
        }
        if($group == 'QUARTER'){
            return 'CONCAT(QUARTER('.$field.'), "T ",DATE_FORMAT('.$field .', "%Y"))';
        }
        if($group == 'TRIMESTER'){
            return 'CONCAT(DATE_FORMAT('.$field .', "%Y"), "-", QUARTER('.$field.'))';
        }
        if($group == 'MONTH'){
            return 'DATE_FORMAT('.$field .', "%b-%y")';
        }
        if($group == 'WEEK'){
            return 'DATE_FORMAT('.$field .', "%u-%b-%y")';
        }

    }
    
    public static function getTest($field, $group){
        if($group == 'YEAR'){
            return 'YEAR('.$field.')';
        }
        if($group == 'QUARTER'){
            return "CONCAT(YEAR(".$field."), '-', QUARTER(".$field ."))";
        }
        if($group == 'MONTH'){
            return 'DATE_FORMAT('.$field .', "%Y-%m")';
        }
        if($group == 'WEEK'){
             return 'DATE_FORMAT('.$field .', "%Y-%m-%u")';
        }
    }

    /**
     * @param $field
     * @param $group
     * @return string
     */
    public static function sqlOrder($field, $group)
    {
        if($group == 'YEAR'){
            return 'YEAR('.$field.')';
        }
        if($group == 'QUARTER'){
            return 'CONCAT(YEAR('.$field.'), QUARTER('.$field .'))';
        }
        if($group == 'MONTH'){
            return 'CONCAT(YEAR('.$field.'), MONTH('.$field .'))';
        }
        if($group == 'WEEK'){
            return 'CONCAT(YEAR('.$field.'), WEEK('.$field .'))';
        }

    }


}
