<?php
namespace lib\mysql;
use \lib\mysql\Mysql as Mysql;
/**
 * Description of SelectStatement
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 2, 2014
 */
class SelectStatement extends \lib\mysql\MysqlStatement
{
    /**
     * @var array
     */
    protected $fetch_assoc = [];
    /**
     * @var array
     */
    protected $select_expr = [];

    /**
     * @var array
     */
    private $offset = ['offset'=>0];


    /**
     * SelectStatement constructor.
     */
    public function __construct()
    {
        $this->statement[0] = 'SELECT';
    }

    /**
     * @return array
     */
    public function getFetchAssoc()
    {
        return $this->fetch_assoc;
    }

    /**
     * @return mixed
     */
    public function getStatementString()
    {
        if(count($this->select_expr) > 0){
            $this->statement['select_expr'] = implode(', ', $this->select_expr);
        }
        if(count($this->table_references) > 0){
            $this->statement['table_references'] = 'FROM ' . implode(' ', $this->table_references);
        }
        if(count($this->where_condition) > 0){
            $this->statement['where_condition'] = 'WHERE ' . implode(' AND ', $this->where_condition);
        }
        if(count($this->group_condition) > 0){
            $this->statement['group_condition'] = 'GROUP BY ' . implode(', ', $this->group_condition);
        }
        if(count($this->having_condition) > 0){
            $this->statement['having_condition'] = 'HAVING ' . implode(', ', $this->having_condition);
        }
        if(count($this->order_expr) > 0){
            $this->statement['order_expr'] = 'ORDER BY ' . implode(', ', $this->order_expr);
        }
        if(count($this->limit_expr) > 0){
            $this->statement['limit_expr'] = $this->limit_expr[0];
        }
        #echo implode(' ', $this->statement) . '<hr />';
        return implode(' ', $this->statement);
    }

    /**
     *
     */
    public function countAll()
    {
        $this->cleanSelect();
        $this->cleanLimit();
        $this->select_expr[] = ' COUNT(*) AS rows';
        $this->fetch_assoc[] = 'rows';

    }

    /**
     * @param $expression
     */
    public function getOnly($expression)
    {
        $this->cleanSelect();
        $this->cleanLimit();
        $this->select_expr[] = $expression . ' AS result';
        $this->fetch_assoc[] = 'result';

    }

    /**
     *
     */
    public function cleanGroup()
    {
        unset($this->group_condition);
        $this->group_condition = [];

    }

    /**
     *
     */
    public function cleanSelect()
    {
        unset($this->select_expr);
        $this->select_expr = [];

    }

    /**
     *
     */
    public function cleanLimit()
    {
        unset($this->limit_expr);
        $this->limit_expr[] = '';

    }

    /**
     * @param $column
     * @param $alias
     */
    public function setDistinct($column, $alias = null)
    {
        $this->select_expr[] = (null != $alias)? 'DISTINCT ' . $column . ' AS '. $alias : 'DISTINCT ' . $column;

    }

    /**
     * @param $column
     * @param $alias
     */
    public function countDistinct($column, $alias = null)
    {
        $this->select_expr[] = (null != $alias)? 'COUNT(DISTINCT ' . $column . ') AS '. $alias : 'COUNT(DISTINCT ' . $column . ')';

    }

    /**
     * @param $column
     * @param $alias
     */
    public function setSelect($column, $alias = null)
    {
        $this->select_expr[] = (null != $alias)? $column . ' AS '. $alias : $column;
        $this->fetch_assoc[] = (null != $alias)? $alias : $column;

    }

    /**
     * @param $expression
     * @param $alias
     */
    public function setCustomSelect($expression, $alias)
    {
        $this->select_expr[] = $expression . ' AS '. $alias;
        $this->fetch_assoc[] = $alias;

    }

    /**
     * @param $expression
     * @param $alias
     * @param $value
     * @return $this
     */
    public function setConcatCondition($expression, $alias, $value = null)
    {
        //$this->query_statement->where($column, $operator, $value, $wildcard);
        $this->where_condition[] = 'CONCAT(' . $expression . ') LIKE "' . $value . '"';
        $this->select_expr[] = 'CONCAT(' . $expression . ') AS '. $alias;
        $this->fetch_assoc[] = $alias;
        return $this;
    }


    /**
     * @param $table
     * @param string $join
     * @param array $relation
     * @param $alias
     */
    public function joinTable($table, $join = Mysql::INNER_JOIN, $relation = [], $alias = null)
    {
        $alias = (null == $alias)? '': $alias;
        $this->table_references[$table] = $join . ' ' .  $table . ' '. $alias . ' ON ('
                . $relation['left'] . '=' . $relation['right'] . ')';

    }


    /**
     * @param $table
     * @param $column
     * @param $value
     * @param string $operator
     */
    public function addJoinCondition($table, $column, $value, $operator = Mysql::EQUAL)
    {
        $condition = ' AND ';
        if($value == Mysql::ISNULL || $value == Mysql::ISNOTNULL){
            $condition .= $column . ' ' . $value . ')';
        }elseif(is_array($value)){
            $operator = Mysql::IN;
            $condition .= $column . " IN ('" . implode("', '", $value) . "'))";
        }else{
            $condition .= $this->buildCondition($column, $operator, $value) . ')';
        }
        $join = str_replace(')', $condition, $this->table_references[$table]);
        $this->table_references[$table] = $join;

    }


    /**
     * @param $column
     */
    public function setGroupBy($column)
    {
        $this->group_condition[$column] = $column;

    }

    /**
     * @param $expression
     */
    public function setHaving($expression)
    {
        $this->having_condition[] = $expression;

    }

    /**
     * @param $column
     * @param string $order
     */
    public function setFirstSort($column, $order = Mysql::ASC)
    {
        if(count($this->order_expr)>0){
            unset($this->order_expr[$column]);
            $this->order_expr = array_merge([$column => $column . ' ' . $order], $this->order_expr);
        }else{
            $this->setOrderBy($column, $order);
        }

    }


    /**
     * @param $column
     * @param string $order
     */
    public function setOrderBy($column, $order = Mysql::ASC)
    {
        $this->order_expr[$column] = $column . ' ' . $order;

    }
    
    /**
     * 
     * @param string $column
     * @param array $values
     */
    public function setOrderByField($column, $values = [], $order = Mysql::ASC)
    {
        $sequence = "'" . implode("','", $values) . "'";
        $this->order_expr[$column] = 'FIELD(' . $column . ', ' . $sequence . ') ' . $order;
    }

    /**
     * @param int $row_count
     * @param int $offset
     */
    public function setLimit($row_count = 1, $offset = 0)
    {
        $this->limit_expr[0] = ($offset == 0)? 'LIMIT ' . $row_count : 'LIMIT ' . $offset . ', ' . $row_count;
        $this->offset['limit'] = $row_count;
        $this->offset['offset'] = $offset;

    }

    /**
     * @return array
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     *
     */
    public function setCalcFoundRows()
    {
        $this->statement[0] = 'SELECT SQL_CALC_FOUND_ROWS';
    }

}
