<?php

namespace lib\model;
use \lib\mysql\SelectStatement;
use PDO;


/**
 * Description of QuerySelect
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 25, 2014
 */
class QuerySelect extends \lib\model\QueryStatement
{
    /**
     * @var int
     */
    private $foundrows = 0;
    /**
     * @var
     */
    private $params;
    /**
     * @var null
     */
    private $primary_class = null;
    /**
     * @var
     */
    protected $results;

    /**
     * QuerySelect constructor.
     * @param $model
     * @param string $merge
     */
    public function __construct($model, $merge = ALL)
    {
        parent::__construct($model, $merge);

    }

    /**
     *
     */
    public function startPrimary()
    {
        $this->query_statement = new SelectStatement();
        foreach($this->columns as $column){
            $this->query_statement->setSelect($column);
        }
        $this->query_statement->setTableReference($this->model->getTableName());
        /* if ($merge == true || $merge == ALL) {$joins = $this->model->getTableJoins();foreach ($joins as $table => $relation) {$statement->joinTable($table, $relation['join'], ['left' => $relation['left'], 'right' => $relation['right']]);}
        }**/
        $this->fetch_assoc = $this->query_statement->getFetchAssoc();
    }

    /**
     * @param QuerySelect $merge
     */
    public function startJoin(\lib\model\QuerySelect $merge)
    {
        $this->query_statement = $merge->getStatement();
        $this->fetch_assoc = $merge->getFetchAssociation();
        $this->primary_class = $merge;
    }

    /**
     * @return null
     */
    protected function completeMerge()
    {
        if(!is_object($this->primary_class)){
            echo 'Not primary class for ' . get_called_class();
            die();
        }
        $this->primary_class->setStatement($this->query_statement);
        $this->primary_class->setFetchAssociation($this->fetch_assoc);
        $this->primary_class->addColumns($this->columns);
        return $this->primary_class;
    }


    /**
     * @param $statement
     */
    public function setStatement($statement)
    {
        $this->query_statement = $statement;
    }

    /**
     * @param $fetch
     */
    public function setFetchAssociation($fetch)
    {
        $this->fetch_assoc = $fetch;
    }

    /**
     * @return array
     */
    public function getFetchAssociation()
    {
        return $this->fetch_assoc;
    }


    /**
     * @return mixed
     */
    public function toString()
    {
        $this->params = $this->query_statement->getParams();
        $this->select($this->query_statement->getStatementString(), $this->params);
        return $this->string;
    }

     /**
     * Completes query and return a collection of model objects
     *
     * @return \lib\model\Model[]
     */
    public function find()
    {
        #return a collection of models
        return $this->getResults($this->query_statement->getStatementString());
    }

     /**
     * Completes query. If result is 0 create object
     *
     * @@return \lib\model\Model
     */
    public function findOneOrCreate()
    {
        $this->query_statement->setLimit(1);
        $result = $this->getResults($this->query_statement->getStatementString());
        if(count($result) !== 0){
            return $result[0];
        }else{
            $this->model->convertToFields();
            $query = new \lib\model\QueryWrite($this->model);
            return $query->save();
        }
    }
    
     /**
     * Completes query. If result is 0 create object
     *
     * @@return \lib\model\Model
     */
    public function toogleOne()
    {
        $this->query_statement->setLimit(1);
        $result = $this->getResults($this->query_statement->getStatementString());
        if(count($result) !== 0){
            return $result[0]->delete();
        }else{
            $this->model->convertToFields();
            $query = new \lib\model\QueryWrite($this->model);
            return $query->save();
        }
    }

     /**
     * Completes query and return numrows.
     *
     * @return Integer
     */
    public function findCount()
    {
        $this->query_statement->countAll();
        $this->fetch_assoc = ['rows'];
        $result = $this->getResults($this->query_statement->getStatementString());
        return (!empty($result))? $result[0]->getColumnValue('rows') : 0;

    }

     /**
     * Completes query and return only one value.
     *
     * @return String
     */
    public function findValue($field, $function)
    {
        $expresssion = $function . '(' . $field . ')';
        $this->query_statement->getOnly($expresssion);
        $this->fetch_assoc = ['result'];
        $result = $this->getResults($this->query_statement->getStatementString());
        return (!empty($result))? $result[0]->getColumnValue('result') : 0;

    }

     /**
     * Completes query with limit 1.
     *
     * @return \lib\model\Model
     */
    public function findOne()
    {
        $this->query_statement->setLimit(1);
        $result = $this->getResults($this->query_statement->getStatementString());
        #return a model
        return (!empty($result))? $result[0] : false;
    }

     /**
     * Convert results to a collection of the model
     *
     * @return array $collection
     */
    private function getResults($query)
    {
        $collection = [];
        $this->params = $this->query_statement->getParams();
        $className = get_class($this->model);
        $results = $this->select($query, $this->params);
        foreach ($results as $row) {
            $item = $this->getRow($className, $row);

            array_push($collection,$item);


        }
        return $collection;
    }

     /**
     * Convert row from result query to a model
     * @param String $className The name of the model class
     * @param array $row The row from a query
     *
     * @return \lib\model\Model $item
     */
    private function getRow($className, $row)
    {
        $item = new $className();
        foreach($row as $i => $value){

            if(!isset($this->fetch_assoc[$i])){
                die('no fetch for ' . $i . ' and ' . $value);
            }
            $column = $this->fetch_assoc[$i];
            //utf8_encode($value)
            if(!mb_check_encoding ($value, 'UTF-8')){
                $value  = utf8_encode($value);
            }


            $item->setColumnValue($column, $value);
        }
        return $item;
    }

    /* reset the mysql statement */
    /**
     * @return SelectStatement
     */
    protected function prepareStatement()
    {
        $statement = new SelectStatement();
        foreach($this->columns as $column){
            $statement->setSelect($column);
        }
        $statement->setTableReference($this->model->getTableName());
        /*
        if ($merge == true || $merge == ALL) {
            $joins = $this->model->getTableJoins();
            foreach ($joins as $table => $relation) {
                $statement->joinTable($table, $relation['join'], ['left' => $relation['left'], 'right' => $relation['right']]);
            }
        }
         *
         */
        $this->fetch_assoc = $statement->getFetchAssoc();
        return $statement;

    }


    /**
     * Pass a custom query and condition
     * @param String $query ('SELECT * FROM TABLE WHERE name=:user OR age<:age',array(name=>'Bond',age=>25))
     * @param array $params The array to bindParams to the specified variable name
     *
     * @return array containing all of the result set row
     */
    private function select($query, $params = [])
    {
        #echo $query.'<hr />';

        $start_time = microtime(true);
        $this->pdostmt = $this->pdo->prepare($query);
        $this->bindValues($params);
        //echo $this->writeQueryMessage($query, $params) . '<hr />';
        if ($this->pdostmt->execute() == false) {
            echo $this->writeQueryMessage($query, $params) . '<hr />';
        }
        $this->querytime = number_format(microtime(true) - $start_time, 6);

        /** Returns an array containing all of the result set rows */
        $result = $this->pdostmt->fetchAll(PDO::FETCH_NUM);

        $this->count = count($result);
        if($this->count == 0 && $this->query_statement->getOffset()['offset'] > 0){
            $limit = $this->query_statement->getOffset()['limit'];
            $offset = $this->query_statement->getOffset()['offset'] - $limit;
            $this->query_statement->cleanLimit();
            $this->query_statement->setLimit($limit, $offset);
            return $this->select($this->query_statement->getStatementString(), $params);
        }

        $this->writeQueryMessage($query, $params);
        return $result;
    }

    /**
     *
     */
    public function setCalcFoundRows()
    {
        $this->query_statement->setCalcFoundRows();
    }

    /**
     * @return $this
     */
    public function calcFoundRows()
    {
        $c = $this->pdo->prepare('SELECT FOUND_ROWS() AS t;');
        $c->execute();
        $totals = $c->fetchAll();
        $this->foundrows = $totals[0]['t'];
        return $this;
    }

    /**
     * @return $this
     */
    public function setFoundRows()
    {
        $this->query_statement->countAll();
        $c = $this->pdo->prepare($this->query_statement->getStatementString());
        foreach ($this->params as $field => $value) {
            $value = utf8_decode($value);
            $c->bindValue(':' . $field, $value);
        }
        $start_time = microtime(true);
        $c->execute();
        $this->querytime = number_format(microtime(true) - $start_time, 9);
        $totals = $c->fetchAll();
        $this->foundrows = $totals[0][0];
        $this->writeQueryMessage($this->query_statement->getStatementString(), $this->params, $this->foundrows);
        return $this;
    }


    /**
     * @return int
     */
    public function getFoundRows()
    {
        /*this function only return after find()
         * or other function that pdo execute of main the query
         * otherwise returns 0*/
        return $this->foundrows;
    }




}
