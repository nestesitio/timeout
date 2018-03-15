<?php
namespace lib\mysql;

use \lib\mysql\Mysql as Mysql;

/**
 * Description of MysqlStatement
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 26, 2014
 */
class MysqlStatement
{
    /**
     * @var array
     */
    protected $statement = [];
    /**
     * @var array
     */
    protected $table_references = [];
    /**
     * @var array
     */
    protected $where_condition = [];
    /**
     * @var array
     */
    protected $group_condition = [];
    /**
     * @var array
     */
    protected $having_condition = [];
    /**
     * @var array
     */
    protected $order_expr = [];
    /**
     * @var array
     */
    protected $limit_expr = [];

    /**
     * @var array
     */
    protected $params = [];


    /**
     * @param $table
     * @param string $alias
     * @return $this
     */
    public function setTableReference($table, $alias = '')
    {
        array_unshift($this->table_references, $table . ' '. $alias);
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param $column
     * @param $operator
     * @param $value
     * @param $wildcard
     * @return string
     */
    protected function buildCondition($column, $operator, $value, $wildcard = null)
    {
        $col = str_replace('.', '_', $column);
        $param = ($wildcard == '%') ? '%' . $value . '%' : $value;
        $this->params[$col] = $param;
        return $column . $operator . ':' . $col;
    }

    /**
     * @param $leftcol
     * @param $rightcol
     * @param string $operator
     */
    public function setJoinCondition($leftcol, $rightcol, $operator = Mysql::EQUAL)
    {
        $this->where_condition[] = $leftcol . $operator . $rightcol;
    }


    /**
     * @param $column
     * @param $operator
     * @param $value
     * @param $wildcard
     * @return $this
     */
    public function setCondition($column, $operator, $value, $wildcard = null)
    {
        //$this->query_statement->where($column, $operator, $value, $wildcard);
        $this->where_condition[] = $this->buildCondition($column, $operator, $value, $wildcard);
        return $this;
    }

    /**
     * @param $column
     * @param $operator
     * @param string $expression
     * @return $this
     */
    public function setExpressionCondition($column, $operator, $expression = '')
    {
        $this->where_condition[] = $column . $operator . $expression ;
        return $this;
    }

    /**
     * @param $expression
     * @return $this
     */
    public function where($expression)
    {
        $this->where_condition[] = $expression ;
        return $this;
    }

    /**
     * @param $array
     * @return $this
     */
    public function whereOr($array)
    {
        $parts = [];
        foreach($array as $column=>$value){
            if(is_array($value)){
                $parts[] = $column . Mysql::IN . "('" . implode("', '", $value) . "')";
            }else{
                $parts[] = $column . Mysql::EQUAL . "'" . $value . "'";
            }
        }
        $this->where_condition[] = "(" . implode(" OR ", $parts) . ")";
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastWhere()
    {
        return end($this->where_condition);
    }

    /**
     * @return mixed
     */
    public function getAndPopLastWhere()
    {
        return array_pop($this->where_condition);
    }

    /**
     * @param $expression
     * @param string $operator
     */
    public function joinWhere($expression, $operator = Mysql::LOGICAL_OR)
    {
        $condition = $this->getAndPopLastWhere();
        $this->where_condition[] = '(' . $condition . " $operator " . $expression . ')';

    }

    /**
     * @param $column
     * @param array $values
     * @param string $clause
     * @return $this
     */
    public function setArrayCondition($column, $values = [], $clause = Mysql::IN)
    {
        if($clause == Mysql::BETWEEN){
            $this->where_condition[] = $column . $clause . "'" . implode("' AND '", $values) . "'";
        }else{
            $this->where_condition[] = $column . $clause . "('" . implode("', '", $values) . "')";
        }
        return $this;
    }

    /**
     * @param $column
     * @param $null
     * @return $this
     */
    public function whereIsNullOrNot($column, $null = null)
    {
        $condition = $column;
        $condition .= ($null == null)? Mysql::ISNULL : $null;
        $this->where_condition[] = $condition;
        return $this;
    }


}
