<?php

namespace lib\control;

/**
 * Description of FormatData
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 23, 2015
 */
class FormatData
{
    /**
     * @var array
     */
    private $formats = [];

    /**
     * @param $results
     * @param $configs
     * @return mixed
     */
    public static function format($results, $configs)
    {
        $formats = new FormatData($configs);
        return $formats->formatResults($results);

    }

    /**
     * FormatData constructor.
     * @param $configs
     */
    public function __construct($configs)
    {
        $this->formats = $this->getFormats($configs);
    }

    /**
     * @param $configs
     * @return array
     */
    private function getFormats($configs)
    {
        $formats = [];
        foreach ($configs->getIndexes() as $index) {
            if ($configs->getIndexedValue($index, 'convert') != null) {
                $formats[$index]['xmlconvert'] = $this->getXmlListValues($configs->getIndexedValue($index, 'convert'));
            }
        }
        return $formats;
    }

    /**
     * @param $results
     * @return mixed
     */
    public function formatResults($results)
    {
        foreach ($results as $obj) {
            foreach ($this->formats as $column => $format) {
                if (null != $obj->getColumnValue($column)) {
                    $value = $this->formatValue($obj->getColumnValue($column), $format);
                    $obj->setColumnValue($column, $value);
                }
            }
        }
        return $results;
    }

    /**
     * @param $value
     * @param $formats
     * @return mixed
     */
    private function formatValue($value, $formats)
    {
        $newvalue = $value;
        /* $format = array(1) { ["xmlconvert"]=> array(3) {
         * ["seller"]=> string(8) "Vendedor" ["team"]=> string(6) "Equipa" ["company"]=> string(12) "Distribuidor" } }*/
        foreach($formats as $format => $values){
            if($format == 'xmlconvert'){
                $newvalue = $values[$value];
            }
        }
        return $newvalue;
    }

    /**
     * @param $file
     * @return array
     */
    public function getXmlListValues($file)
    {
        if(!empty($file)){
            $values = \lib\xml\XmlSimple::getConvertedList('model/enum/' . $file);

        }
        return $values;
    }

}
