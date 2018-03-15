<?php
namespace lib\bkegenerator;

use \lib\register\Monitor;
use \lib\session\SessionUser;
use \lib\filter\SessionFilter;
use \lib\bkegenerator\Config;
use \lib\register\Vars;

/**
 * Description of DataGrid
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 18, 2014
 */
class DataGrid extends \lib\bkegenerator\DataConfig
{
    /**
     *
     */
    public function execute()
    {
        $this->renderLabels();
        $this->renderButtons();
        $this->doList();
    }

    /**
     *
     */
    public function doList()
    {
        Monitor::setMonitor(Monitor::BOOKMARK, 'do the List');
        $this->setPaging();
        $this->renderColumns();
        $this->renderTools();
        $id = $this->x_conf->queryXPath('grid', 'atr', 'identification') . '_{$item.'
                . $this->x_conf->queryXPath('grid', 'atr', 'fieldid') . '}';

        $this->html = str_replace('{$item.identification}', $id, $this->html);
        if(null != $this->var){
            $this->html = str_replace('{@while ($item in $list):}', '{@while ($item in $' . $this->var . '):}', $this->html);
            $this->html = str_replace('{@while ($item in $pagination):}', '{@while ($item in $page' . $this->var . '):}', $this->html);
        }
    }


    /**
     * @return \lib\bkegenerator\Config
     */
    public function getFilters()
    {
        $config = new Config();
        $nodes = $this->getnodes('show/fields/*');
        foreach($nodes as $node){
            $path = 'show/fields/' . $node;
            $config->setIndex($this->x_conf->queryXPath($path, 'atr', 'field'));
            $config->setConfigValue('type', $this->x_conf->queryXPath($path, 'atr', 'type'));
            $config->setConfigValue('range', $this->x_conf->queryXPath($path, 'atr', 'range'));
            $config->setConfigValue('default', $this->x_conf->queryXPath($path, 'atr', 'default'));
            $config->setConfigValue('sort', $this->x_conf->queryXPath($path, 'atr', 'sort'));
            $config->setConfigValue('convert', $this->x_conf->queryXPath($path, 'atr', 'convert'));
        }
        if(null == $this->identification){
            $this->identification = $this->x_conf->queryXPath('grid', 'atr', 'identification');
        }
        $config->setIdentification($this->identification);
        return $config;
    }


    /*
     *
     */
    /**
     *
     */
    private function setPaging()
    {
        $paging = $this->x_conf->queryXPath('grid', 'atr', 'paging');

        if(!empty($paging)){
            SessionFilter::setControllerLimit($this->identification, $paging);
        }
    }

    /*
     *
     */
    /**
     *
     */
    private function renderButtons()
    {
        $btn_tpl = '<!--{$buttons}-->';
        $btn = '';
        if (strpos($this->html, '{$buttons}')) {
            $nodes = $this->getnodes('grid/buttons/*');
            foreach($nodes as $node){
                $path = 'grid/buttons/' . $node;
                if(SessionUser::getAuth($this->x_conf->queryXPath($path, 'atr', 'auth')) == false){
                    continue;
                }else if($this->getCondition($path) == false){
                    continue;
                }

                $btn .= $this->renderBtn($path, $btn_tpl);

            }

        }
        $this->html = str_replace($btn_tpl, $btn, $this->html);
    }

    /**
     * @param $path
     * @param $btn_tpl
     * @return string
     */
    private function renderBtn($path, $btn_tpl)
    {
        $target = $this->x_conf->queryXPath($path, 'atr', 'target');
        $url = $this->x_conf->queryXPath($path, 'atr', 'url');
        $class = 'btn-action btn btn-xs btn-default ' . $this->x_conf->queryXPath($path, 'atr', 'brand');
        if (!empty($url)) {
            $btn = '<a href="' . $url . '"  class="btn btn-xs btn-default">';
        }elseif (!empty($target)) {
            $btn = '<a href="/' . Vars::getApp();
            $btn .= '/' . $this->x_conf->queryXPath($path, 'atr', 'action');
            $btn .= '/' . Vars::getId();
            $btn .= $this->findVars($path);
            $btn .= '" target="' . $target . '"  class="btn btn-xs btn-default">';
        } else {
            $btn = '<a data-action="' . $this->x_conf->queryXPath($path, 'atr', 'action') . '"';
            $btn .= $this->findVars($path);
            $btn .= ' data-id="' . Vars::getId() . '" class="' . $class . '">';
            foreach ($this->querystring as $key => $value) {
                $btn = str_replace('<a ', '<a data-' . $key . '="' . $value . '"', $btn);
            }
        }

        $btn .= '<span class="' . $this->x_conf->queryXPath($path, 'atr', 'class') . '"></span> ';
        $btn .= $this->findLabel($path) . '</a>' . $btn_tpl;
        return $btn;
    }

    /**
     *
     */
    private function renderTools()
    {
        $btn_tpl = '<!--<li class="row_tool">{$column_tools}</li>-->';
        $tpl_tpl = '<!--<li class="row_tool">{$template_tools}</li>-->';

        $ul = '';
        $ul_hidden = '';

        if (strpos($this->html, '{$column_tools}')) {
            $nodes = $this->getnodes('grid/tools/*');
            foreach($nodes as $node){
                $path = 'grid/tools/' . $node;
                if(SessionUser::getAuth($this->x_conf->queryXPath($path, 'atr', 'auth')) == false){
                    continue;
                }else if($this->getCondition($path) == false){
                    continue;
                }
                $str = $this->renderCommand($path, $node);
                $ul_hidden .= $str['hidden'];
                $ul .= $str['ul'];

            }


        }
        $this->html = str_replace($btn_tpl, $ul, $this->html);
        $this->html = str_replace($tpl_tpl, $ul_hidden, $this->html);
    }

    /**
     * @param $path
     * @param $node
     * @return array
     */
    private function renderCommand($path, $node)
    {
        $tool = new \lib\bkegenerator\DataTool();

        $link = $this->x_conf->queryXPath($path, 'atr', 'link');
        $action = $this->x_conf->queryXPath($path, 'atr', 'action');
        $editable = $this->x_conf->queryXPath($path, 'atr', 'editable');
        $file = $this->x_conf->queryXPath($path, 'atr', 'file');
        if($node == 'langs'){
             return $tool->getLangTools();
        }elseif (!empty($file)) {
              $tool->setFileAction($action, $this->x_conf->queryXPath($path, 'atr', 'id'));
        }elseif (!empty($link)) {
            $tool->setLink($link, $this->x_conf->queryXPath($path, 'atr', 'id'), $this->x_conf->queryXPath($path, 'atr', 'target'));
        } elseif(!empty($editable)) {
            $tool->setEditable($editable, $this->x_conf->queryXPath($path, 'atr', 'id') , $this->x_conf->queryXPath($path, 'atr', 'select'));
        } else {
            $tool->setRowAction($action, $this->x_conf->queryXPath($path, 'atr', 'id'));
        }
        $tool->setLabel($this->findLabel($path));
        $tool->setVars($this->findVars($path));
        
        $tool->complete($node, $this->x_conf->queryXPath($path, 'atr', 'class'), $editable);

        return $tool->render();
    }



    /**
     * <span class="order dropup">
     */
    private function renderLabels()
    {
        $th_tpl = '<!--<td class="{$class}">{$column_label}</td>-->';
        $th = '';
        $nodes = $this->getnodes('grid/columns/*');
        foreach ($nodes as $node) {
            $path = 'grid/columns/' . $node;
            $class = $this->x_conf->queryXPath($path, 'atr', 'class');
            $th .= '<td class="' . $class . '">';
            $th .= $this->findLabel($path);
            if($class != 'id'){
                $sort = Vars::getApp() . '/list_{$canonical}';
                if($this->x_conf->queryXPath($path, 'atr', 'sort') == 'true'){
                    $th .= '<a class="btn-sort" data-field="' . $this->x_conf->queryXPath($path, 'atr', 'field') . '"'
                            . ' data-action="' . $sort . '">'
                            . '<span class="glyphicon glyphicon-sort"></span></a>';
                }
            }

            $th .= '</td>';
        }
        $this->html = str_replace($th_tpl, $th, $this->html);
    }

    /**
     *
     */
    private function renderColumns()
    {
        $ul_tpl = '<!--<li>{$column_data}</li>-->';
        $tpl_tpl = '<!--<li>{$template_column}</li>-->';

        $ul = '';
        $ul_hidden = '';

        $nodes = $this->getnodes('grid/columns/*');
        foreach ($nodes as $node) {
            $path = 'grid/columns/' . $node;
            $class = $this->x_conf->queryXPath($path, 'atr', 'class');
            $field = $this->x_conf->queryXPath($path, 'atr', 'field');
            $title = ($this->x_conf->queryXPath($path, 'atr', 'title') != 'false')? ' title="{$item.' . $field . '}"' : '';
            $ul .= '<li' . $title . ' data-field="' . $field . '" class="col ' . $class . '">';
            if($class != 'id'){
                $ul .= '{$item.' . $this->x_conf->queryXPath($path, 'atr', 'field') . '}';
            }else{
                $ul .= ':';
            }
            $ul .= '</li>';

            $ul_hidden .= '<li data-field="' . $field . '" class="col ' . $class . '"></li>';

        }
        $this->html = str_pad($this->html, strlen($ul), ' ');
        $this->html = str_replace($ul_tpl, $ul, $this->html);
        $this->html = str_pad($this->html, strlen($ul_hidden), ' ');
        $this->html = str_replace($tpl_tpl, $ul_hidden, $this->html);
        $this->html = rtrim($this->html);



    }

    /**
     * @return \lib\bkegenerator\Config
     */
    public function getFields()
    {
        $config = new Config();
        $nodes = $this->getnodes('grid/columns/*');
        foreach($nodes as $node){
            $path = 'grid/columns/' . $node;
            $config->setIndex($this->x_conf->queryXPath($path, 'atr', 'field'));
            $config->setConfigValue('head', $this->findLabel($path));
            $config->setConfigValue('field', $this->x_conf->queryXPath($path, 'atr', 'field'));
            $config->setConfigValue('convert', $this->x_conf->queryXPath($path, 'atr', 'convert'));
        }
        return $config;
    }


}
