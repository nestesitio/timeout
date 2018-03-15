<?php

namespace lib\xml;

use DOMDocument;

use \lib\register\Monitor;

/**
 * Description of XmlFile
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2014
 */
class XmlFile extends \lib\xml\Xml
{
    /**
     * XmlFile constructor.
     * @param $file
     */
    public function __construct($file)
    {
        if (strpos($file, '.xml') && is_file(ROOT . DS . $file)) {
            $this->xml = new DOMDocument();
            $this->xml->preserveWhiteSpace = FALSE;
            $this->xml->formatOutput = true;
            $this->xml->load(ROOT . DS . $file);
            Monitor::setMonitor(Monitor::XML, $file);
        }else{
            Monitor::setErrorMessages(null, 'Xml file is not valid: ' . $file);
        }
    }

    /**
     *
     * @param string $file Path to the XML file
     * @return \lib\xml\Xml
     */
    public static function getXmlFromFile($file)
    {
        $obj = new XmlFile($file);
        return $obj->getXml();
    }

    /**
     *
     * @param string $file Path to the XML file
     * @return object | null
     */
    public static function getXmlSimpleFromFile($file)
    {
        if (strpos($file, '.xml') && is_file(ROOT . DS . $file)) {
            return simplexml_load_file(ROOT . DS . $file);
        }else{
            Monitor::setErrorMessages(null, 'Xml file is not valid: ' . $file);
            return null;
        }
    }

}
