<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lib\tools;

/**
 * Description of ObTool
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 17, 2015
 */
class ObTool
{
    /**
     * @return mixed
     */
    public static function obStart()
    {
        set_time_limit(9640);
        ini_set('memory_limit', '3048M');
        $start_time = microtime(true);
        ob_start();
        ignore_user_abort(true);

        // Get the content of the output buffer
        ob_end_clean();// Close current output buffer
        self::outputLine("BEGIN");
        return $start_time;
    }

    /**
     * @param string $string
     */
    public static function outputLine($string = '')
    {
        echo " " . $string . "<br />";
        ob_flush();
        flush();
        usleep(1);
    }

    /**
     * @param $string
     */
    public static function output($string)
    {
        echo " " . $string;
    }

    /**
     * @param string $string
     */
    public static function obEnd($string = '')
    {
        self::outputLine($string);
        ob_end_flush();
    }

}
