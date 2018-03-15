<?php

namespace lib\xml;

/**
 * Description of XmlTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 25, 2015
 */
class XmlTools
{
    /**
     * @param $xml
     * @param bool $root
     *
     * @return array
     */
    public static function xml2Array($xml, $root = true)
    {
        if (!$xml->children()) {
            return trim((string) $xml);
        }

        $array = [];
        foreach ($xml->children() as $element => $node) {
            $totalElement = count($xml->{$element});

            if (!isset($array[$element])) {
                $array[$element] = "";
            }
            $attributes = $node->attributes();

            // Has attributes
            if ($attributes != null) {
                $data = ['attributes' => []];
                if (!count($node->children())) {
                    $data['value'] = (string) trim($node);
                } else {
                    $data = array_merge($data, self::xml2Array($node, false));
                }
                foreach ($attributes as $attr => $value) {
                    $data['attributes'][$attr] = (string) trim($value);
                }

                if ($totalElement > 1) {
                    $array[$element][] = $data;
                } else {
                    $array[$element] = $data;
                }
                // Just a value
            } else {
                if ($totalElement > 1) {
                    $array[$element][] = self::xml2Array($node, false);
                } else {
                    $array[$element] = self::xml2Array($node, false);
                }
            }
        }

        if ($root) {
            return array($xml->getName() => $array);
        } else {
            return $array;
        }
    }

}
