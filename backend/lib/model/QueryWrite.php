<?php

namespace lib\model;


use \lib\register\Monitor;

/**
 * Description of QueryWrite
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 5, 2014
 */
class QueryWrite extends \lib\model\Query implements \lib\model\Write
{
    /**
     * @var int
     */
    protected $lastid = 0;
    /**
     * @var int
     */
    protected $rowschanged = 0;
    /**
     * @var int
     */
    protected $inserted = 0;


    /**
     * @return null
     */
    public function save()
    {
        $table = $this->model->getTableName();
        $values = $this->model->getModelValues();
        $keys = $this->model->getPrimaryKey();
        
        $fields = $data = $params = $udpates = [];
        if(null != $this->model->getAutoIncrement()){
            //one primary key with auto-increment
            $updates[] = $this->model->getAutoIncrement() . '= LAST_INSERT_ID('.$this->model->getAutoIncrement().')';
        }elseif(count($keys) == 2){
            //more than one primary key
            foreach($keys as $key){
                $updates[] = $key . ' = ' . $values[$key];
            }
        }
        foreach(array_keys($values) as $col){

            $fields[] = $col;
            if(in_array($col, $keys) && null != $this->model->getAutoIncrement()){
                $id = ($values[$col] == 'NULL')? $this->getIncrementId($table, $col) : $values[$col];
                $params[$col] = $id;
            }else{
                $updates[] = $col . ' = :' . $col;
                $params[$col] = utf8_decode($values[$col]);
            }
            $data[] = ':'.$col;
        }

        $start_time = microtime(true);
        $query = 'INSERT INTO ' . $table;
        $query .= ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $data) . ')';
        if(isset($updates)){
            $query .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', $updates);
        }
        $this->executeQuery($query, $params);
        $this->register($query, $params, $start_time, $table);


        if(null != $this->model->getAutoIncrement()){
            $this->model->setColumnValue($this->model->mergeToAlias($this->model->getAutoIncrement()), $this->getLastId());
        }
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $table = $this->model->getTableName();
        $keys = $this->model->getPrimaryKey();
        $values = $this->model->getModelValues();
        foreach(array_keys($values) as $col){
            if(in_array($col, $keys)){
                $data[] = $col . ' = :'.$col;
                $params[$col] = $values[$col];
            }
        }
        $query = 'DELETE FROM ' . $table . ' WHERE ' . implode(' AND ', $data);
        $this->executeQuery($query, $params);
        return  $this->pdostmt->rowCount();
    }

    /**
     * @param $query
     * @param $params
     * @param $start_time
     * @param $table
     */
    private function register($query, $params, $start_time, $table = null)
    {
        $this->lastid = $this->pdo->lastInsertId();
        $this->setRowsChanged($this->pdostmt->rowCount());
        $this->setQueryInfo($query, $params, $start_time);
        Monitor::setMonitor(Monitor::QUERY, 'id ' .  $this->lastid . ' inserted');
        Monitor::setMonitor(Monitor::QUERY, $this->rowschanged . ' rows changed on ' . $table);
    }

    /**
     * @return int
     */
    public function getInsertId()
    {
        return $this->inserted;
    }


    /**
     * @param $rows
     */
    private function setRowsChanged($rows)
    {
        if($rows == 1){
            $this->rowschanged = 0;
            $this->inserted = $this->lastid;
            Monitor::setUserMessages(null, '1 row inserted');
        }elseif($rows == 2){
            $this->rowschanged = 1;
            Monitor::setUserMessages(null, $this->rowschanged . ' row updated');
        }else{
           $this->rowschanged = $rows;
           Monitor::setUserMessages(null, $this->rowschanged . ' rows changed');
        }
    }

    /**
     * @param $query
     * @param $params
     * @param $start_time
     */
    private function setQueryInfo($query, $params, $start_time)
    {
        $end_time = microtime(true);
        $this->querytime = number_format($end_time - $start_time, 9);
        $this->writeQueryMessage($query, $params);
    }

    /**
     * @return int
     */
    public function getLastId()
    {
        return $this->lastid;
    }

    /**
     * @return int
     */
    public function getRowsChanged()
    {
        return $this->rowschanged;
    }




}
