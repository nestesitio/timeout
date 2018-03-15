<?php

namespace lib\register;

/**
 * Description of Monitor
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 17, 2014 as DevMessages
 * Created @Feb 4, 2015
 */
/**
 * Class Monitor
 * @package lib\register
 */
class Monitor extends \lib\register\Registry
{
    /**
     *
     */
    const QUERY = 'QUERY';
    /**
     *
     */
    const VIEW = 'VIEW';
    /**
     *
     */
    const DATA = 'Data';
    /**
     *
     */
    const TPL = 'TEMPLATE';
    /**
     *
     */
    const TPL_WARN = 'TEMPLATE-WARNING';
    /**
     *
     */
    const XML = 'XML-FILE';
    /**
     *
     */
    const NODE = 'XML-NODE';
    /**
     *
     */
    const CONTROL = 'CONTROLLER';
    /**
     *
     */
    const ACTION = 'ACTION';
    /**
     *
     */
    const METHOD = 'METHOD';
    /**
     *
     */
    const FORM = 'FORM';
    /**
     *
     */
    const FORMERROR = 'FORM-ERROR';
    /**
     *
     */
    const BOOKMARK = 'BOOKMARK';
    /**
     *
     */
    const PAGID = 'PAGE ID';
    /**
     *
     */
    const ROUTE = 'ROUTE';
    /**
     *
     */
    const DB = 'DATABASE';
    /**
     *
     */
    const MEMORY = 'MEMORY-USAGE';
    /**
     *
     */
    const SESSION = 'SESSION';

    /**
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $message;

    /**
     * Monitor constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param $type
     * @param $message
     * @return Monitor
     */
    public static function create($type, $message)
    {
        $msg = new Monitor($type);
        $msg->setMessage($message);
        return $msg;
    }

    /**
     * @return string
     */
    public function write()
    {
        $class = 'dev_' . strtolower($this->type);
        $br = ($this->type == self::QUERY)? '<br />' : '';
        return '<div class="dm '.$class.'"><b>' . $this->type . ':</b> ' . $br . $this->message . '</div>';

    }

}
