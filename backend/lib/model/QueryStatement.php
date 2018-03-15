<?php

namespace lib\model;

use \lib\mysql\Mysql as Mysql;

/**
 * Description of QueryStatement
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 22, 2015
 */
class QueryStatement extends \lib\model\Query
{
    /**
     * @var array
     */
    protected $fetch_assoc = [];

    /**
     * @param $column
     * @return \QueryStatement
     */
    public function groupBy($column)
    {
        $this->query_statement->setGroupBy($column);
        return $this;
    }

    /**
     * @param $expression
     * @return \QueryStatement
     */
    public function setHaving($expression)
    {
        $this->query_statement->setHaving($expression);
        return $this;
    }

    /**
     * @param $column
     * @param string $order
     * @return \QueryStatement
     */
    public function setFirstSort($column, $order = Mysql::ASC)
    {
        $this->query_statement->setFirstSort($column, $order);
        return $this;
    }

    /**
     * @param $column
     * @param string $order
     * @return \QueryStatement
     */
    public function orderBy($column, $order = Mysql::ASC)
    {
        $this->query_statement->setOrderBy($column, $order);
        return $this;
    }
    
    /**
     * 
     * @param string $column
     * @param array $values
     * @param string $order
     * 
     * @return \lib\model\QueryStatement
     */
    public function orderByFilter($column, $values = [], $order = Mysql::ASC)
    {
        $this->query_statement->setOrderByField($column, $values, $order);
        return $this;
    }

    /**
     * @return \QueryStatement
     */
    public function cleanSelect()
    {
        $this->query_statement->cleanSelect();
        for($i = count($this->fetch_assoc); $i > 0; $i--){
            array_pop($this->fetch_assoc);
        }
        return $this;
    }

    /**
     * @param $column
     * @param $alias
     * @return \QueryStatement
     */
    public function setDistinct($column, $alias = null)
    {
        $this->query_statement->setDistinct($column, $alias);
        $this->addSelectClause($column, $alias);
        return $this;
    }

    /**
     * @param $column
     * @param $alias
     * @return \QueryStatement
     */
    public function countDistinct($column, $alias = null)
    {
        $this->query_statement->countDistinct($column, $alias);
        $this->addSelectClause($column, $alias);
        return $this;
    }

    /**
     * @param $column
     * @param $alias
     * @return \QueryStatement
     */
    public function setSelect($column, $alias = null)
    {
        //echo var_dump($this->columns) .' -> ';
        $this->columns[] = $column;
        $this->query_statement->setSelect($column, $alias);
        $this->model->addColumn($column);
        $this->addSelectClause($column, $alias);
        return $this;
    }

    /**
     * @param $expression
     * @param $alias
     * @return \QueryStatement
     */
    public function setCustomSelect($expression, $alias)
    {
        $this->columns[] = $alias;
        $this->query_statement->setCustomSelect($expression, $alias);
        $this->model->addColumn($alias);
        $this->fetch_assoc = array_merge($this->fetch_assoc, [$alias]);
        return $this;
    }

    /**
     * @param $fields
     * @param $search
     * @param string $modifier
     * @param $value
     * @return \QueryStatement
     */
    public function match($fields, $search, $modifier = Mysql::SEARCH_BOOLEAN, $value = null)
    {
        $expression = "MATCH (".  implode(',', $fields).") AGAINST ('$search' $modifier)";
        $this->query_statement->setCustomSelect($expression, 'score');
        $expression = "MATCH(".  implode(',', $fields).") AGAINST ('$search' $modifier)";
        if($value != null){
            $expression .= " > '$value'";
        }
        $this->query_statement->where($expression);
        $this->fetch_assoc = array_merge($this->fetch_assoc, ['score']);
        $this->orderBy('score', Mysql::DESC);
        return $this;
    }


    /**
     * @param $field
     * @param $alias
     * @return \QueryStatement
     */
    public function setSum($field, $alias)
    {
        $this->setCustomSelect('SUM(' . $field . ')', $alias);
        return $this;
    }

    /**
     * @param $field
     * @param $alias
     * @return \QueryStatement
     */
    public function setMax($field, $alias)
    {
        $this->setCustomSelect('MAX(' . $field . ')', $alias);
        return $this;
    }

    /**
     * @param $field
     * @param $alias
     * @return \QueryStatement
     */
    public function setMin($field, $alias)
    {
        $this->setCustomSelect('MIN(' . $field . ')', $alias);
        return $this;
    }

    /**
     * @param $alias
     * @return \QueryStatement
     */
    public function setCount($alias)
    {
        $this->setCustomSelect('COUNT(*)', $alias);
        return $this;
    }

    /**
     * @param int $row_count
     * @param int $offset
     * @return \QueryStatement
     */
    public function limit($row_count = 1, $offset = 0)
    {
        $this->query_statement->setLimit($row_count, $offset);
        return $this;
    }

    /**
     * @param $table
     * @param $join
     * @param $relation
     * @param $alias
     * @return \QueryStatement
     */
    public function join($table, $join, $relation, $alias = null)
    {
        $this->query_statement->joinTable($table, $join, ['left'=>$relation[0],'right'=>$relation[1]], $alias);
        return $this;
    }

    /**
     * @param $table
     * @param $relation
     * @param $alias
     * @return \QueryStatement
     */
    public function leftJoin($table, $relation, $alias = null)
    {
        $this->join($table, Mysql::LEFT_JOIN, $relation, $alias);
        return $this;
    }

    /**
     * @param $table
     * @param $relation
     * @param $alias
     * @return \QueryStatement
     */
    public function innerJoin($table, $relation, $alias = null)
    {
        $this->join($table, Mysql::INNER_JOIN, $relation, $alias);
        return $this;
    }

    /**
     * @param $table
     * @param $relation
     * @param $alias
     * @return \QueryStatement
     */
    public function rightJoin($table, $relation, $alias = null)
    {
        $this->join($table, Mysql::RIGHT_JOIN, $relation, $alias);
        return $this;
    }

    /**
     * @param $table
     * @param $column
     * @param $value
     * @param string $operator
     * @return \QueryStatement
     */
    public function addJoinCondition($table, $column, $value, $operator = Mysql::EQUAL)
    {
        $this->query_statement->addJoinCondition($table, $column, $value, $operator);
        return $this;
    }

    /**
     * @param $leftcol
     * @param $rightcol
     * @param string $operator
     * @return \QueryStatement
     */
    public function setJoinCondition($leftcol, $rightcol, $operator = Mysql::EQUAL)
    {
        $this->query_statement->setJoinCondition($leftcol, $rightcol, $operator);
        return $this;
    }

    /**
     * @param $column
     * @param $alias
     */
    protected function addSelectClause($column, $alias = null)
    {
        $col = (null != $alias)? $alias : $column;
        $this->fetch_assoc = array_merge($this->fetch_assoc, [$col]);
    }

}
