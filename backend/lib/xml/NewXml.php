<?php

namespace lib\xml;

use DOMDocument;
use DOMElement;

/**
 * Description of NewXml
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 24, 2014
 */
class NewXml extends \lib\xml\Xml
{
    /**
     * NewXml constructor.
     * @param string $node
     */
    public function __construct($node = 'doc')
    {
        $this->xml = new DOMDocument('1.0', 'UTF-8');
        $this->xml->appendChild(new DOMElement($node));
    }

}
