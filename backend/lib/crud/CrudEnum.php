<?php

namespace lib\crud;

use DOMDocument;
use \lib\db\PdoMysql as PdoMysql;
use PDO;
use \lib\coreutils\ModelTools as ModelTools;
use \lib\tools\StringTools as StringTools;

/**
 * Description of CrudEnum
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 1, 2015
 */
class CrudEnum
{
    /**
     * @param $file
     * @param $values
     */
    public static function writeEnum($file, $values)
    {
        $obj = new CrudEnum($file, $values);
        $obj->create();
    }

    /**
     * @var string
     */
    private $file;
    /**
     * @var array
     */
    private $values = [];
    /**
     * @var array
     */
    private $langs = ['en','pt'];

    /**
     * CrudEnum constructor.
     * @param $file
     * @param $values
     */
    public function __construct($file, $values)
    {
        $this->file = 'model' . DS . 'enum' . DS . $file . '.xml';
        $this->values = $values;

    }

    /**
     *
     */
    public function create()
    {
        if (is_file($this->file)) {
            echo "Enum File " . $this->file . '.xml' . " exists, delete it first.... \n";
        } else {
            $doc = new DOMDocument('1.0', 'UTF-8');
            $doc->formatOutput = true;

            $root = $doc->createElement("root");
            $doc->appendChild($root);

            foreach($this->values as $value){
                $value = str_replace("'", '', $value);
                $node = $doc->createElement('value');
                $node->setAttribute('index', $value);
                foreach ($this->langs as $lang) {
                    $label = $doc->createElement('label');
                    $label->setAttribute('lang', $lang);
                    $label->appendChild($doc->createTextNode(CrudTools::setLabel($value)));
                    $node->appendChild($label);
                }
                $root->appendChild($node);
            }

            $doc->save($this->file);
        }
    }



}
