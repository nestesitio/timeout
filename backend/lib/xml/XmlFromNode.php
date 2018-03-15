<?php

namespace lib\xml;

use DOMXPath;

/**
 * Description of XmlFromNode
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2014
 */
class XmlFromNode extends \lib\xml\Xml
{
    /**
     * XmlFromNode constructor.
     * @param Xml $xml
     * @param $path
     */
    public function __construct(Xml $xml, $path)
    {
        $xpath = new DOMXPath($xml);
        if (empty($path)) {
            return false;
        } else {
            $items = $xpath->query($path);
            foreach ($items as $item) {
                $newxml = new \lib\xml\NewXml('doc');
                $this->xml = $newxml->getXml();
                $this->xml->importNode($item);
                return $xml;
            }
        }
    }

    /**
     * @param $node
     */
    private function importNode($node)
    {
        // Import the node, and all its children, to the document
        $node = $this->xml->importNode($node, true);
        // And then append it to the "<root>" node
        $this->xml->documentElement->appendChild($node);
    }

}
