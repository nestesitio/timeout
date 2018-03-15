<?php

namespace lib\control;

use \lib\bkegenerator\DataGrid;

/**
 * Description of GridIt
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 23, 2015
 */
class GridIt
{
    /**
     * @var DataGrid
     */
    private $grid;
    /**
     * @var \lib\bkegenerator\Config
     */
    private $filters;
    /**
     * @var \lib\bkegenerator\Config
     */
    private $fields;

    /**
     * GridIt constructor.
     * @param String $xmlfile
     * @param $obj
     */
    public function __construct($xmlfile, $obj)
    {
        $grid = new DataGrid($xmlfile, $obj);
        $this->filters = $grid->getFilters();
        $this->fields = $grid->getFields();
        $this->grid = $grid;
    }
    /**
     * Build the configuration from xml file.
     *
     * @param String $xmlfile
     * @param String $obj
     *
     * @return \lib\bkegenerator\DataGrid $grid
     */
    public static function create($xmlfile, $obj)
    {
        $grid = new GridIt($xmlfile, $obj);
        return $grid;
    }

    /**
     * @param $condition
     * @return $this
     */
    public function addCondition($condition)
    {
        if($condition != null){
            $this->grid->setCondition($condition);
        }
        return $this;
    }

    /**
     * @param $querystring
     * @return $this
     */
    public function addQueryString($querystring)
    {
        if(null != $querystring){
            $this->grid->setQueryString($querystring);
        }
        return $this;
    }



    /**
     * Build the configuration from xml file.
     *
     * @return \lib\bkegenerator\DataGrid $grid
     */
    public function get()
    {
        return $this->grid;
    }

    /**
     * Process all the html
     * (datagrid, datalist, edit, etc)
     *
     * @param String $output
     *
     * @return String
     */
    public function setGrid($output)
    {
        $this->grid->setHtml($output);
        /* process of html */
        $this->grid->execute();
        return $this->grid->getHtml();
    }

    /**
     * Process file and include in html
     * (datagrid, datalist, edit, etc)
     *
     * @param String $file
     * @param String $tag
     * @param String $html
     *
     * @return String
     */
    public function buildInclude($file, $tag, $html)
    {
        $this->grid->getContentsFile($file, $tag);
        $this->grid->execute();
        return $this->grid->getHtml($html);
    }

    /**
     * make configurations for the list from a xml file.
     *
     * @params \lib\bkegenerator\DataGrid $grid
     * @params String $var
     * @params String $view
     *
     * @return \lib\bkegenerator\Config $configs
     */
    public function configureGrid($output, $var, $view = null)
    {
        $tpl = (null == $view)? '/layout/core/grid.htm' : $view;
        $this->grid->buildIncluded($output, $tpl, $var);
        $this->grid->execute();
        return $this->grid->getHtml();
    }

    /**
     * @return \lib\bkegenerator\Config
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return \lib\bkegenerator\Config
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->grid->getHtml();
    }

}
