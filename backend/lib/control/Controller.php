<?php

/**
 * Description of Controller
 * created in 7/Nov/2014
 * @author $luispinto@nestesitio.net
 * Sequence in Router:
 * //prepare controller and action
 * $controller = new $class();
 * $controller->$action();
 * //prepare View
 * //if Action defined view ->
 *  - $this->setView();
 * $template = $controller->getTemplate();
 * //else here we define view ->
 * $extend = $controller->setView($template);
 *  - $this->view = new View($file);
 * $output = $controller->dispatch();
 *  - $this->view->parse();
 *  - $this->renderData();
 *  - return $this->view->display();
 */

namespace lib\control;

use \lib\control\ControlTools;
use \lib\register\Monitor;
use \lib\register\Vars;
use \lib\loader\Configurator;
use \lib\view\View;
use \lib\url\UrlHref;

class Controller
{
    /**
     * @var null
     */
    private $template = null;
    /**
     * @var null
     */
    private $extended = null;
    /**
     * @var null
     */
    protected $view = null;
    /**
     * @var string
     */
    protected $app;
    /**
     * @var string
     */
    protected $content_type = '';
    /**
     * @var array
     */
    private $tags = [];
    /**
     * @var
     */
    protected $model;
    /**
     * @var bool
     */
    protected $id = true;
    /**
     * @var bool
     */
    public $messages = true;
    /**
     * @var bool
     */
    public $layout = true;
    /**
     *
     * @var array
     */
    protected $json = [];


    /**
     * @return array|bool|mixed
     */
    protected function getJEditableValue()
    {
        $this->layout = false;
        $this->setView('layout/core/empty.htm');
        $value = Vars::getPosts('value');
        return $value;
    }
    
    /**
     * Passes data to template engine
     *
     * @param $tag
     * @param $data
     */
    protected function set($tag, $data)
    {
        Monitor::setDataDevMessage($tag, $data);
        $this->tags[$tag] = $data;
    }

    /**
     * @param $tag
     * @return mixed
     */
    protected function get($tag)
    {
        return $this->tags[$tag];
    }
    
    /**
     *
     * @param string $filename
     * @return boolean
     */
    public function setView($filename)
    {
        if ($this->template == null) {
            $file = ControlTools::validateFile($this, $filename, 'view', 'htm');
            if($file == null){
                Monitor::setErrorMessages(null, ['message'=>'No valid template found for ' . get_class($this)]);
                echo 'No valid template ( ' .$filename. ' ) found for ' . get_class($this);
                return false;
            }

            $this->view = new View($file);
            $this->template = $file;
            $this->extended = $this->view->getLayout();

        }

        return true;
    }


    /**
     *
     */
    public function dispatch()
    {
        /* parse the tags in view
         * after eventual generate of template
         * by class that extends DataConfig*/
        if (true == $this->layout) {
            //$this->view->parse();
            //inject data in view
            $this->renderData();
            //display
            return $this->view->render();
        }else{
            return;
        }
    }

    /**
     * @param array $results
     * @return array
     */
    protected function getCollection($results)
    {
        $itens = [];
        foreach ($results as $i=>$obj){
            $itens[$i] = $obj->getToArray();
        }
        return $itens;
    }

    /**
     * @param $results
     * @param $tag
     */
    protected function renderCollection($results, $tag)
    {
        Monitor::setMonitor(Monitor::BOOKMARK, get_class($this) . ' - renderCollection with ' . count($results) . ' row for tag ' . $tag);
        $itens = $this->getCollection($results);
        $this->set($tag, $itens);
        return $itens;
    }


    /**
     *
     */
    private function renderData()
    {
        Monitor::setMonitor(Monitor::BOOKMARK, get_class($this) . ' - renderData');
        foreach($this->tags as $tag=>$data){
            $this->view->setData($tag, $data);
        }
    }

    /**
     * @param String $filename
     */
    public function resetView($filename)
    {
        $this->template = null;
        $this->setView($filename);
    }

    /***
     *
     */
    protected function setEmptyView()
    {
        $this->messages = false;
        $this->setView('/layout/core/empty.htm');
    }

    /***
     * @return String
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return mixed
     */
    public function getExtended()
    {
        return $this->extended;
    }

    /**
     * @param $mime
     */
    public function setHeaderContentType($mime)
    {
        if(empty($this->content_type)){
            $this->content_type = $mime;
        }
    }

    /**
     * @param $mime
     * @return \lib\control\Controller.php
     */
    public function setHeader($mime)
    {
        if(empty($this->content_type)){
            $this->content_type = $mime;
        }
        return $this;
    }

    /**
     *
     */
    public function writeHeader()
    {
        header($this->content_type);
    }

    /**
     * @param int $memory
     */
    protected function addMemory($memory = 2512)
    {
        ini_set('memory_limit', $memory . 'M');
        set_time_limit(99640);
    }


    /**
     * Controller constructor.
     */
    public function __construct()
    {
        Monitor::setMonitor(Monitor::CONTROL, get_class($this));
        $this->app = \lib\register\Vars::getApp();
        $this->configSet();
    }


    private function configSet()
    {
        $defaults = Configurator::geHtmlConf();
        $this->set('sitetitle', $defaults['title']);
        $this->set('h1', '');
    }
    
    /**
     *
     */
    protected function setUserMessage()
    {
        $this->set('usermsg', Monitor::getUserMessages());
    }

    /**
     *
     */
    protected function setCustomMessage()
    {
        $this->set('custommsg', Monitor::getCustomMessages());
    }

    /**
     * @param $message
     */
    protected function writeMessage($message)
    {
        Monitor::setMessages($message);
        $this->set('usermsg', Monitor::getUserMessages());
    }

    /**
     *
     */
    protected function ob()
    {
        $this->layout = false;
        $this->setEmptyView();
        $this->start_time = \lib\tools\ObTool::obStart();
    }
    
    /**
     * @param $tag
     * @param $action
     * @param array $querystring
     */
    protected function renderUrl($tag, $action, $querystring = [])
    {
        $id = ($this->id == true)? Vars::getId() : $this->id;
        $url = UrlHref::renderUrl(['app'=> $this->app, 'action'=>$action, 'id'=>$id, 'get'=>$querystring]);
        $this->set($tag, $url);
        Monitor::setMonitor(Monitor::FORM, 'Form Action:' . $url);
        $this->set('app', $this->app);
    }
    
    /**
     * @param $value
     * @param $file
     * @return string
     */
    protected function processValue2Show($value, $file)
    {
        if(!empty($file)){
            $value = \lib\xml\XmlSimple::getConvertedValue('model/enum/' . $file, $value);

        }
        if(is_string($value)){
            $value = nl2br($value);
        }
        return $value;
    }
    

}
