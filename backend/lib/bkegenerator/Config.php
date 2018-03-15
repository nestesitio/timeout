<?php

namespace lib\bkegenerator;

/**
 * Description of Config
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 7, 2015
 */
class Config
{
    /**
     * @var array
     */
    private $configs = [];
    /**
     * @var array
     */
    private $indexes = [];
    /**
     * @var int
     */
    private $current = 0;
    /**
     * @var
     */
    private $identification;

    /**
     * Config constructor.
     */
    public function __construct() {}

    /**
     * Get count for configs
     *
     * @return int
     */
    public function getNum()
    {
        return count($this->configs);
    }

    /**
     * Set value for identification
     * @param String $identification The id string for the grid
     *
     * @return void
     */
    public function setIdentification($identification)
    {
        $this->identification = $identification;
    }

    /**
     * Get value for identification
     *
     * @return String
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * Set the current index for array configs
     * @param Int $index The current index
     *
     * @return \lib\bkegenerator\Config
     */
    public function setIndex($index)
    {
        $this->indexes[$index] = $index;
        $this->current = $index;
        return $this;
    }

    /**
     * Set the value for current index in array configs
     * @param String $attr The attribute in the xml node of the config file
     * @param String $value The value for the attribute
     *
     * @return \lib\bkegenerator\Config
     */
    public function setConfigValue($attr, $value)
    {
        $this->configs[$this->current][$attr] = $value;
        return $this;
    }

     /**
     * Get value for the array index (configs[])
     * @param Int $index The current index
     *
     * @return Array Or null if the index does not exist
     */
    public function getConfigValue($index)
    {
        return (isset($this->configs[$this->current][$index]))? $this->configs[$this->current][$index] :null;
    }

     /**
     * Get the array indexes
     *
     * @return array $indexes[]
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

     /**
     * Get value for the array index (configs[]) and change the current array index
      * 
     * @param Int $index The current index
     * @param String $key The sub index is the attribute for the xml node
     *
     * @return String
     */
    public function getIndexedValue($index, $key)
    {
        $this->setIndex($index);
        return $this->getConfigValue($key);
    }


}
