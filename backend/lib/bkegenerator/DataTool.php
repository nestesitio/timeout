<?php

namespace lib\bkegenerator;

/**
 * Description of DataTool
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 30, 2015
 */
class DataTool
{
    /**
     * @var string
     */
    private $ul;
    /**
     * @var string
     */
    private $ul_hidden;
    
    private $class = 'row-action';
    
    private $label = '';

    /**
     * DataTool constructor.
     */
    public function __construct()
    {
        $this->ul_hidden = '<li class="row_tool">';
        $this->ul = '<li class="row_tool">';
    }

    /**
     * @param String $link
     * @param int $id
     * @param String $window
     */
    public function setLink($link, $id, $window = null)
    {
        $this->ul_hidden .= '<a href="' . $link . '"';
        $this->ul .= '<a href="' . $link . '{$item.' . $id . '}' . '"';
        if($window == 'blank'){
            $this->ul .= ' target="_blank"';
        }
    }


    /**
     * @param $editable
     * @param $id
     * @param $select
     */
    public function setEditable($editable, $id, $select)
    {
        $this->ul_hidden .= '<a ';
        $this->ul .= '<a data-edit="' . $editable . '" data-id="{$item.' . $id . '}"';
        if (!empty($select)) {
            $this->ul .= ' data-select="' . $select . '"';
        }
    }

    /**
     * @param $action
     * @param $val
     */
    public function setRowAction($action, $val)
    {
        $this->ul_hidden .= '<a data-action="' . $action . '"';
        $this->ul .= '<a data-action="' . $action . '"';
        if (!empty($val)) {
            $this->ul .= ' data-id="{$item.' . $val . '}"';
        }
    }

    /**
     * @param $action
     * @param $val
     */
    public function setLangAction($action, $val, $lang)
    {
        $str = '<a title="Text ' . $lang . '" '
                . 'class="row-action fa" data-action="' . $action . '" data-command="edit"';
        $this->ul_hidden .= $str;
        $this->ul .= $str;
        if (!empty($val)) {
            $this->ul .= ' data-id="' . $val . '"';
        }
        $this->ul_hidden .= '>';
        $this->ul .= '>';
        $this->close();
        //echo htmlentities($this->ul).'<br />';
    }

    /**
     * @param $file
     * @param $val
     */
    /**
     * 
     * @param string $action
     * @param string $file
     * @param type $val
     */
    public function setFileAction($action, $val)
    {
        $this->ul_hidden .= '<a data-action="' . $action . '"';
        $this->ul .= '<a data-action="' . $action . '"';
        if (!empty($val)) {
            $this->ul .= ' data-id="{$item.' . $val . '}"';
        }
        $this->class = 'modal-action';
    }

    /**
     * @param $flag
     */
    public function setFlag($flag)
    {
       $this->ul = str_replace('class="row-action fa"', 'class="row-action flag-icon flag-icon-' . $flag . '"', $this->ul);
       $this->ul = str_replace('>', ' data-lang="'.$flag.'">', $this->ul);
    }

    /**
     *
     */
    public function haveNoLang()
    {
       $this->ul = str_replace('<a', '<a style="opacity: 0.4;"', $this->ul);
    }

    /**
     * @param $label
     */
    public function setLabel($label)
    {
        $this->ul .= ' title="' . $label . '"';
        $this->label = $label;
    }

    /**
     * @param $vars
     */
    public function setVars($vars)
    {
        $this->ul .= $vars;
    }

    /**
     * @param $node
     * @param $class
     * @param $editable
     */
    public function complete($node, $class, $editable)
    {

        $this->ul .= ' data-command="' . $node . '"';
        $this->ul_hidden .= ' data-command="' . $node . '"';
        $this->ul .= ' class="' . $this->class . ' fa ' . $class . '">';
        $this->ul_hidden .= ' class="' . $this->class . ' fa ' . $class . '">';
        if(!empty($editable)){
            $this->ul .= '<div class="row-editable" style="display:none"></div>';
        }
        $this->close();
    }
    
    public function modal(){
        $this->ul = str_replace('>', ' data-title="' . $this->label . '">', $this->ul);
        $this->ul_hidden = str_replace('>', ' data-title="' . $this->label . '">', $this->ul_hidden);
        
        $this->close();
    }

    /**
     *
     */
    public function close()
    {
        $this->ul .= '</a></li>';
        $this->ul_hidden .= '</a></li>';
    }


    /**
     * @return array
     */
    public function getLangTools()
    {
        return ['ul' => '{$item.langs}', 'hidden' => '{$langs}'];
    }

    /**
     * @return string
     */
    public function getHidden()
    {
        return $this->ul_hidden;
    }

    /**
     * @return string
     */
    public function getUl()
    {
        return $this->ul;
    }


    /**
     * @return array
     */
    public function render()
    {
        return ['ul' => $this->ul, 'hidden' => $this->ul_hidden];
    }

}
