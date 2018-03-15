<?php
namespace lib\bkegenerator;

use \lib\xml\XmlFile;
use \lib\register\Monitor;
use \lib\register\Vars;


/**
 * Description of DataConfig
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 18, 2014
 */
class DataConfig
{
    /**
     * @var XmlFile
     */
    protected $x_conf;
    /**
     * @var
     */
    protected $html;
    /**
     * @var null
     */
    protected $extended = null;
    /**
     * @var
     */
    protected $tag;
    /**
     * @var int|null
     */
    protected $identification = null;
    /**
     * @var null
     */
    protected $var = null;
    /**
     * @var array
     */
    protected $querystring = [];
    /**
     * @var array
     */
    protected $condition = [];

    /**
     * DataConfig constructor.
     * @param String $xmlfile The path to xml file that contains params to bkgenerator
     * @param object $obj The class that called DataConfig
     */
    public function __construct($xmlfile, $obj = null)
    {
        $file = \lib\control\ControlTools::validateFile($obj, $xmlfile, 'config', 'xml');
        $this->x_conf = new XmlFile($file);
        $this->identification = $this->x_conf->queryXPath('grid', 'atr', 'identification');
    }

    /**
     * @param int $index
     */
    public function setCondition($index)
    {
        $this->condition[$index] = true;
    }

    /**
     * @param $path
     * @return bool
     */
    protected function getCondition($path)
    {
        $index = $this->x_conf->queryXPath($path, 'atr', 'condition');
        if(!empty($index) && !isset($this->condition[$index])){
            return false;
        }
        return true;
    }


    /**
     * @param $query
     * @return array
     */
    protected function getnodes($query)
    {
        $nodes = $this->x_conf->arrayXPath($query);
        return $nodes;
    }

    /**
     * @param $html
     * @return \lib\bkegenerator\DataConfig
     */
    public function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }


    /**
     * @param $file
     * @param $id
     */
    public function getContentsFile($file, $id)
    {
        $this->var = $id;
        $this->tag = '{@insert ('.$id.')}';
        if (file_exists(ROOT . $file)) {
            $this->html =  file_get_contents(ROOT . $file); // get contents of buffer

        }
    }

    /**
     * Get the whole html as string
     * @param String $extended
     * @return mixed
     */
    public function getHtml($extended = null)
    {
        Monitor::setMonitor(Monitor::BOOKMARK, ' DataConfig return HTML');
        if($extended != null){
            $this->html = str_replace($this->tag, $this->html, $extended);
        }
        return $this->html;
    }

    /**
     * @param $querystring
     */
    public function setQueryString($querystring)
    {
        $this->querystring = $querystring;
    }

    /**
     * @param $path
     * @return string
     */
    protected function findVars($path)
    {
        $str = '';
        $arr = $this->x_conf->nodeXPath($path . '/vars', ['var','value','get','id','str']);
        foreach($arr as $line){
            if(!empty($line['get']) && Vars::getRequests($line['get']) != false){
                $str .= ' data-' . $line['var'] . '="' .  Vars::getRequests($line['get']) . '"';
            }elseif(!empty($line['id']) && Vars::getId() != false){
                $str .= ' data-' . $line['var'] . '="' .  Vars::getId() . '"';
            }elseif(!empty($line['value'])){
                $str .= ' data-' . $line['var'] . '="{$item.' . $line['value'] . '}"';
            }elseif(!empty($line['str'])){
                $str .= ' data-' . $line['var'] . '="' . $line['str'] . '"';
            }
        }
        return $str;
    }

    /**
     * @param $path
     * @return array
     */
    public function getParams($path)
    {
        $values = [];
        $nodes = $this->x_conf->nodeXPath($path, ['var', 'str']);
        foreach($nodes as $node){
            $values[$node['var']] = $node['str'];
        }
        return $values;
    }

    /**
     * @param $path
     * @return int
     */
    protected function findLabel($path)
    {
        $value = $this->x_conf->queryXPath($path . "/label[@lang='" . \lib\lang\Language::getLang() . "']");
        if (empty($value)) {
            $key = $this->x_conf->queryXPath($path . '/label', NULL, 'key');
            return \lib\lang\Labels::getLabel($key);
        }else{
            return $value;
        }

    }


}
