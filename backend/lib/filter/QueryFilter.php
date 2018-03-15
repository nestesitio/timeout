<?php

namespace lib\filter;

use \lib\register\Vars;
use \lib\filter\SessionFilter;
use \lib\bkegenerator\Config;
use \lib\model\QuerySelect;
use \lib\mysql\Mysql;
use \lib\form\form\FormRender;
use \lib\session\Session;

/**
 * Description of QueryFilter
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 31, 2015
 */
class QueryFilter
{
    /**
     * @var QuerySelect
     */
    private $query;
    /**
     * @var string
     */
    private $controller;


    /**
     * @param $query
     * @param $config
     *
     * @return QuerySelect
     */
    public static function filter($query, $config)
    {
        $clear = Vars::getRequests('clear-filters');
        if($clear == 1){
            \lib\session\Session::unsetFilter(Vars::getCanonical(), 'filter');
            \lib\session\Session::unsetFilter(Vars::getCanonical(), 'sort');
            \lib\session\Session::unsetFilter(Vars::getCanonical(), 'paging');
        }
        $obj = new QueryFilter($query);
        $obj->setLimit();
        $obj->setSort($config);
        $obj->setFilters($config);
        return $obj->getQuery();
    }

    /**
     * @param $query
     * @param $config
     *
     * @return QuerySelect
     */
    public static function report($query, $config)
    {
        $obj = new QueryFilter($query);
        $obj->setFilters($config);
        return $obj->getQuery();
    }

    /**
     * QueryFilter constructor.
     * @param QuerySelect $query
     */
    public function __construct(QuerySelect $query)
    {
        $this->query = $query;
        $this->controller = Vars::getCanonical();
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    private static function extractValue($value)
    {
        if (strpos($value, '&&')) {
            $values = explode('&&', $value);
            foreach($values as $value){
                if(!empty($value) && $value != '0000-00-00 00:00:00'){
                    return $value;
                }
            }
        }
        return $value;
    }

    /**
     * @param \lib\form\Form $form
     * @param String $actionclass
     * @param Config $config
     *
     * @return \lib\form\Form
     */
    public static function getDefaults(\lib\form\Form $form, $actionclass, Config $config)
    {
        $filters = SessionFilter::getFilters($actionclass, $config);
        foreach($filters as $field => $value){
            $value = self::extractValue($value);
            $table = FormRender::getTableByColumn($field);
            $input = $form->getInput($table, $field);
            if($input != null){
                $form->setDefault($table, $field, $value);
            }
        }
        return $form;
    }

        //public static function renderFilters($fields, \lib\form\Form $form, $actionclass, $filtertypes) {

    /**
     * @param \lib\form\Form $form
     * @param $actionclass
     * @param Config $config
     *
     * @return \lib\form\Form
     */
    public static function renderFilters(\lib\form\Form $form, $actionclass, Config $config)
    {
        $filters = SessionFilter::getFilters($actionclass, $config);
        $fields = $config->getIndexes();
        foreach($fields as $field){
            $config->setIndex($field);
            $table = FormRender::getTableByColumn($field);
            $input = $form->getInput($table, $field);
            $xval = $config->getConfigValue('filter');
            if($input == null && !empty($xval)){
                $class = "\lib\\form\input\\" . $config->getConfigValue('type');
                if (!class_exists($class)) {
                    echo $class . 'Class not found for <b>' . $field . '</b> in QueryFilter. Review '.$actionclass.' config or the model form<br />';
                    die();
                } else {
                    $input = $class::create($field);
                    $form->setFieldInput($table, $field, $input);
                    $form->renameInput($table, $field, 'filter_');
                }

            }
            if(isset($filters[$field])){
                 $form->setFieldValue($table, $field, $filters[$field]);
            }

        }
        return $form;
    }

    /**
     * @param Config $config
     */
    public function setFilters(Config $config)
    {
        $columns = $this->query->getColumns();
        //\lib\session\Session::unsetFilter(Vars::getCanonical(), 'filter');
        $filters = SessionFilter::getFilters($this->controller, $config, $columns);
        foreach($filters as $key => $value){
            $config->setIndex($key);
            if ($value === '0' || !empty($value)) {
                $range = $config->getConfigValue('range');
                if (!empty($range)) {
                    if ($range == 'multiple') {
                        $this->query->filterByColumn($key, explode('&&', $value), Mysql::IN);
                    } elseif ($range == 'like') {
                        $this->query->filterByColumn($key, $value, Mysql::LIKE, '%');
                    } elseif ($range == 'range') {
                        $values = explode('&&', $value);
                        $val['min'] = (!isset($values[0]) || $values[0] == 0) ? null : $values[0];
                        $val['max'] = (!isset($values[1]) || $values[1] == 0) ? null : $values[1];
                        $this->query->filterByColumn($key, $val, Mysql::BETWEEN);
                    }
                } elseif (strpos($value, '&&')) {
                    $this->query->filterByColumn($key, explode('&&', $value), Mysql::IN);
                } else {
                    $value = $this->extractValue($value);
                    $this->query->filterByColumn($key, $value);
                }
            }
        }
    }

    /**
     * @param $field
     * @return array|bool|mixed
     */
    public static function getFilterPost($field)
    {
        //sellerinvoice_filter_group
        $key = Vars::getCanonical() . '_filter_' . $field;
        $post = Vars::getPosts($key);
        if($post != false){
            Session::setSessionFilter(Vars::getCanonical(), 'filter', $post, $field);
            return $post;
        }else{
            $filters = Session::getSessionFilter(Vars::getCanonical(), 'filter');
            if(isset($filters[$field])){
                return $filters[$field];
            }
        }
        return false;
    }

    /**
     * @param Config $config
     */
    public function setSort(Config $config)
    {
        $sorts = SessionFilter::getSorts($this->controller);
        $i = 0;
        $columns = $this->query->getColumns();
        foreach($sorts as $field=>$sort){
            if (in_array($field, $columns)) {
                if ($i++ == 0) {
                    $this->query->setFirstSort($field, $sort);
                } else {
                    $this->query->orderBy($field, $sort);
                }
            }
        }
        $fields = $config->getIndexes();
        foreach($fields as $field){
            $config->setIndex($field);
            if($config->getConfigValue('sort') != null){
                $this->query->orderBy($field, $config->getConfigValue('sort'));
            }
        }

    }

    /**
     *
     */
    public function setLimit()
    {
        $limit = SessionFilter::getControllerLimit($this->controller);
        /*if limit is set for generator grid, set limit on query*/
        if($limit != null){
            $page = SessionFilter::getControllerPaging($this->controller);
            $offset = ($page - 1) * $limit;
            $this->query->limit($limit, $offset);
        }
    }


    /**
     * @return QuerySelect
     */
    public function getQuery()
    {
        return $this->query;
    }

}
