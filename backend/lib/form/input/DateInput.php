<?php

namespace lib\form\input;

/**
 * Description of DateInput
 * http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/jquery.datePicker.js
 * http://2008.kelvinluck.com/projects/jquery-date-picker/
 *
 * http://eonasdan.github.io/bootstrap-datetimepicker/
 * Testes: http://jsfiddle.net/0Ltv25o8/230/
};
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 5, 2014
 */
class DateInput extends \lib\form\Input
{
    /**
     * @param String $field The db table field name for reerence to input
     * @return DateInput
     */
    public static function create($field = null)
    {
        $obj = new DateInput($field, $field);
        return $obj;
    }


    /**
     * @param $timestamp
     */
    public function setTimestamp($timestamp)
    {
        #DATE, DATETIME, TIME, OR TIMESTAMP
    }

    /**
     * @var string
     */
    private $dateformat = 'LL LT';

    const FORMAT_DATE = 'LL';
    const FORMAT_TIME = 'LT';

    /**
     * @param $format
     */
    public function setDataFormat($format)
    {
        /*options:
         * LT : 'H:mm', HH:mm',
         * ->10:38
         * LTS : 'LT:ss', HH:mm:ss' -> don't use
         * L : 'DD/MM/YYYY', DD/MM/YYYY',
         * -> 19/02/2015
         * LL : 'D [de] MMMM [de] YYYY', D MMMM YYYY',
         * -> 19 de fevereiro de 2015
         * LLL : 'D [de] MMMM [de] YYYY LT', D MMMM YYYY LT',
         * -> 19 de fevereiro de 2015 10:36
         * LLLL : 'dddd, D [de] MMMM [de] YYYY LT', dddd, D MMMM YYYY LT'
         * ->sexta-feira, 19 de fevereiro de 2015 10:36
         */
        $this->dateformat = $format;
    }
    
    public function setFormatOnlyDate(){
        $this->setDataFormat(self::FORMAT_DATE);
        return $this;
    }
    
     public function setFormatOnlyTime(){
        $this->setDataFormat(self::FORMAT_TIME);
        return $this;
    }

    /**
     * @return string
     */
    public function parseInput()
    {
        //$newticket['DateCreated'] = date('d-m-Y G:H', strtotime($phpDateVariable));
        if(!empty($this->value)){
            if(strpos($this->value,'&&')){
                list($val1, $val2) = explode('&&', $this->value);
                $this->value = $val1 . '&&' . $val2;
            }else{
                $this->value = date('Y-m-d H:i', strtotime($this->value));
            }
        }

        $this->attributes();
        unset($this->attributes['id']);



        $this->input = '<div id="' . $this->elemid . '" class="input-group date">';
        $this->input .= '<input '
                . ' data-formatime="' . $this->dateformat . '" ' .
                implode(' ', $this->attributes) . ' />';
        #span element with calendar icon
        $this->input .= ' <span class="input-group-addon">'
                . '<span class="glyphicon glyphicon-calendar"></span></span>'
                . '</div>';
        #reset input command
        $this->input .= '<a class="clear-input" data-id="'.$this->elemid.'">'
                . '<span class="glyphicon glyphicon-refresh"></span></a>';
        //echo $this->value . ' * <hr />';
        //echo $this->getValue() . '<hr />';
        return $this->input;
    }

}
