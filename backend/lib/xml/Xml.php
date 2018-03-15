<?php

namespace lib\xml;

use DOMXPath;
use \lib\register\Monitor;


/**
 * Description of Xml
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2014
 */
class Xml
{
    /**
     * @var
     */
    protected $xml;

    /**
     * @param $string
     * @return string
     */
    public static function xmlString($string)
    {
        return "<doc>" . utf8_encode($string) . "</doc>";
    }

    /**
     * @return mixed
     */
    public function saveString()
    {
        return $this->xml->saveXML();
    }

    /**
     * @return mixed
     */
    protected function getXml()
    {
        return $this->xml;
    }

    /**
     * Get the attribute value of a xml node
     * @param \DOMElement $item The node
     * @param string $atr The attribute
     *
     * @return string
     */
    public static function getAtribute($item, $atr)
    {
        if (!is_null($item->attributes)) {
            foreach ($item->attributes as $attr) {
                if ($attr->name == $atr) {
                    return utf8_decode($attr->value);
                }
            }
            return '';
        }
    }

    /**
     *
     * @param string $query XPath expression
     * @param string $attr The attribute
     *
     * @return string
     */
    public function getValue($query, $attr = null)
    {
        $xpath = new DOMXPath($this->xml);
        $items = $xpath->query($query);
        foreach ($items as $item) {
            if ($attr != null) {
                return utf8_encode(self::getAtribute($item, $attr));
            }else{
                return $item->nodeValue;
            }
        }
        return '';
    }

    /**
     * @param $query XPath expression
     * @param string $what
     * @param string $atr
     * @return array
     */
    public function arrayXPath($query, $what = 'name', $atr = '')
    {
        $arr = [];
        $xpath = new DOMXPath($this->xml);

        $items = $xpath->query($query);
        foreach ($items as $item) {
            switch ($what) {
                case('name'):$arr[] = $item->nodeName;
                    break;
                case('node'):$arr[] = $item;
                    break;
                case('value'):
                    if (!empty($atr) && !is_null($item->attributes)) {
                        $k = $this->Atributes($item, $atr);
                        $value = utf8_decode($item->nodeValue);
                        if ($k === 0) {
                            $k = 0;
                        } elseif (empty($k)) {
                            $k = $value;
                        }
                        $arr[$k] = $value;
                    } else {
                        $arr[] = utf8_decode($item->nodeValue);
                    }
                    break;
                default:
                    $val = self::getAtribute($item, $atr);
                    if (!empty($val)) {
                        $arr[] = $val;
                    }
                    break;
            }
        }
        return $arr;
    }

    /**
     * @param $query XPath expression
     * @param array $attr
     * @return array
     */
    public function nodeXPath($query, $attr = [])
    {
        $arr = [];
        $xpath = new DOMXPath($this->xml);
        $items = $xpath->query($query);
        foreach ($items as $i => $item) {
            foreach ($attr as $atr) {
                $arr[$i][$atr] = self::getAtribute($item, $atr);
            }
        }
        return $arr;
    }

    /**
     * @param $path XPath expression
     * @param string $what
     * @param string $atr
     * @return int
     */
    public function queryXPath($path, $what = 'value', $atr = '')
    {
        $xpath = new DOMXPath($this->xml);

        $items = $xpath->query($path);
        if (gettype($items) != 'object') {
            Monitor::setErrorMessages(null, 'XML Error: ' . gettype($items) . '->' . $path);
        }
        foreach ($items as $item) {
            if ($what == 'name') {
                return $item->nodeName;
            } elseif ($what == 'parent') {
                //$Node=$item->parentNode;
                $name = $item->nodeName;
                return str_replace(strrchr($path, '/' . $name), '', $path);
            } elseif ($what == 'atr' || $what == null) {
                return utf8_encode(self::getAtribute($item, $atr));
            } else {
                $value = utf8_decode($item->nodeValue);
                if (empty($value)) {
                    return 1;
                } else {
                    return utf8_encode($value);
                }
            }
        }
    }

    /**
     * @param $path XPath expression
     * @param $lang
     * @return mixed
     */
    protected function findLabel($path, $lang)
    {
        $value = $this->xml->queryXPath($path . "/label[@lang='" . $lang . "']");
        if (empty($value)) {
            $value = $this->xml->queryXPath($path . "/label[@lang='" . 'en' . "']");
        }
        if (empty($value)) {
            $value = $this->xml->queryXPath($path . "/label[@lang='" . $lang . "']");
        }
        return $value;
    }

}
