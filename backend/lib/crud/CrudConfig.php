<?php

namespace lib\crud;

use DOMDocument;
use \lib\db\PdoMysql as PdoMysql;
use PDO;
use \lib\coreutils\ModelTools as ModelTools;
use \lib\tools\StringTools as StringTools;

/**
 * Description of CrudConfig
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 27, 2015
 */
class CrudConfig
{
    /**
     * @var
     */
    private $pdo;

    /**
     * @var
     */
    private $file;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $app;
    /**
     * @var
     */
    private $table;

    /**
     * @var array
     */
    private $fields;
    /**
     * @var
     */
    private $columns;

    /**
     * CrudConfig constructor.
     * @param $file
     * @param $app
     * @param $name
     * @param $table
     */
    public function __construct($file, $app, $name, $table)
    {
        $this->file = $file;
        $this->name = strtolower($name);
        $this->app = strtolower($app);
        $this->table = $table;

        $this->fields = $this->getFields($table);
        $this->columns = ModelTools::buildModel($table)->getColumns();
    }



    /**
     *
     */
    public function create()
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;

        $root = $doc->createElement("root");
        $doc->appendChild($root);

        #show
        $show = $doc->createElement('show');
        $node = $this->getFieldsNode($doc, 'fields', 'Fields for render');
        $show->appendChild($node);
        $node = $this->getCommandsNode($doc, 'buttons', 'Commands for form and show');
        $show->appendChild($node);
        $root->appendChild($show);

        #grid
        $grid = $doc->createElement('grid');
        $grid->setAttribute('identification', $this->name);
        $grid->setAttribute('paging', 25);
        $grid->setAttribute('fieldid', $this->table . '.id');

        $node = $this->getColsNode($doc, 'columns', 'Columns for grid');
        $grid->appendChild($node);

        $node = $this->getToolsNode($doc, 'tools', 'buttons in row');
        $grid->appendChild($node);

        $node = $this->getButtonsNode($doc, 'buttons', 'buttons ion top');
        $grid->appendChild($node);

        $root->appendChild($grid);
        //$root->appendChild( $doc->createTextNode($company_name));

        $doc->save($this->file);
    }

    /**
     * @param $doc
     * @param $parentname
     * @param $comment
     * @return mixed
     */
    private function getCommandsNode($doc, $parentname, $comment)
    {
        $parent = $doc->createElement($parentname);
        $parent->setAttribute('comment', $comment);
        $tools['saveform'] = 'glyphicon glyphicon-save';
        $tools['editform'] = 'glyphicon glyphicon-pencil';
        $tools['delform'] = 'glyphicon glyphicon-trash';
        $tools['closeform'] = 'glyphicon glyphicon-remove';
        $labels = ['save','edit','delete','close'];
        $actions = ['edit','edit','del',''];
        $i = 0;
        foreach($tools as $tool=>$class){
            $node = $doc->createElement($tool);
            $node->setAttribute('class', $class);
            if(!empty($actions[$i])){
                $node->setAttribute('action', $this->app . '/' . $actions[$i] . '_' . $this->name);
            }
            ($tool == 'closeform')? $node->setAttribute('auth', '9') : $node->setAttribute('auth', '1');
            $node = $this->putLabelKey($doc, $node, $labels[$i++]);
            $parent->appendChild($node);
        }

        return $parent;
    }

    /**
     * @param $doc
     * @param $parentname
     * @param $comment
     * @return mixed
     */
    private function getButtonsNode($doc, $parentname, $comment)
    {
        $parent = $doc->createElement($parentname);
        $parent->setAttribute('comment', $comment);
        $tools = ['insert'=>'glyphicon glyphicon-plus', 'export'=>'glyphicon glyphicon-export'];
        foreach($tools as $tool=>$class){
            $node = $doc->createElement($tool);
            if($tool == 'export'){
                $node->setAttribute('url', '/' . $this->app . '/' . $tool . '_' . $this->name);
            }elseif($tool == 'insert'){
                $node->setAttribute('url', '/' . $this->app . '/new_' . $this->name);
            }else{
                $node->setAttribute('action', $this->app . '/' . $tool . '_' . $this->name);
            }

            $node->setAttribute('class', $class);
            $node->setAttribute('auth', '1');
            $node = $this->putLabelKey($doc, $node, $tool);
            $parent->appendChild($node);
        }
        return $parent;
    }

    /**
     * @param $doc
     * @param $parentname
     * @param $comment
     * @return mixed
     */
    private function getToolsNode($doc, $parentname, $comment)
    {
        $parent = $doc->createElement($parentname);
        $parent->setAttribute('comment', $comment);
        $tools = ['edit'=>'fa-pencil', 'show'=>'fa-eye', 'del'=>'fa-trash-o'];
        foreach($tools as $tool=>$class){
            $node = $doc->createElement($tool);
            $node->setAttribute('action', $this->app . '/' . $tool . '_' . $this->name);
            $node->setAttribute('class', $class);
            $node->setAttribute('id', $this->table . '.id');
            $node->setAttribute('auth', '1');
            $node = $this->putLabelKey($doc, $node, $tool);
            $parent->appendChild($node);
        }
        return $parent;
    }

    /**
     * @param $doc
     * @param $node
     * @param $name
     * @return mixed
     */
    private function putLabelKey($doc, $node, $name)
    {
        $label = $doc->createElement('label');
        $label->setAttribute('key', $name);
        $node->appendChild($label);
        
        return $node;
    }

    /**
     * @param $doc
     * @param $parentname
     * @param $comment
     * @return mixed
     */
    private function getColsNode($doc, $parentname, $comment)
    {
        $parent = $doc->createElement($parentname);
        $parent->setAttribute('comment', $comment);
        foreach ($this->columns as $table=>$columns){
            foreach ($columns as $col) {
                if (strpos($col, 'oldid') !== false) {
                    continue;
                }
                $flag = 1;
                echo "\n Column: " . $col . ": ";
                foreach($this->fields as $field){
                    //echo ", " . $field['Field'];
                    if($field['Field'] == $col && $field['Key'] == 'MUL'){
                        $flag = 0;
                    }
                }
                if ($flag == 1) {
                    $node = $doc->createElement($this->getNodeName($table, $col));
                    $node->setAttribute('field', $table . '.' . $col);
                    $node->setAttribute('class', StringTools::getStringAfterLastChar($col, '_'));
                    $node->setAttribute('sort', 'true');
                    $node = $this->putLabelKey($doc, $node, $col);
                    $parent->appendChild($node);
                }
            }
        }
        echo "\n";
        return $parent;
    }


    #nodes for show, edit and filter
    /**
     * @param $doc
     * @param $parentname
     * @param $comment
     * @return mixed
     */
    private function getFieldsNode($doc, $parentname, $comment)
    {
        $parent = $doc->createElement($parentname);
        $parent->setAttribute('comment', $comment);
        foreach (array_keys($this->columns) as $table) {
            if ($table != $this->table) {
                $x = 0;
                foreach ($this->fields as $col) {
                    if ($col['Comment'] == 'ignore') {
                        continue;
                    }
                    if (strpos($col['Type'], 'varchar') === 0 && $x++ == 0) {
                        $node = $doc->createElement($this->getNodeName($table, $col['Field']));
                        $node->setAttribute('field', $table . '.' . $col['Field']);
                        $node->setAttribute('show', 'true');
                        $node = $this->putLabelKey($doc, $node, $table . ' ' . $col['Field']);
                        $parent->appendChild($node);
                    }
                }
            }
        }
        foreach ($this->fields as $field){
            $node = $this->buildFieldNode($doc, $field, $this->table );
            $parent->appendChild($node);
        }

        return $parent;
    }

    /**
     * @param $doc
     * @param $field
     * @param $table
     * @return mixed
     */
    private function buildFieldNode($doc, $field, $table)
    {
        $node = $doc->createElement($this->getNodeName($table, $field['Field']));
        $node->setAttribute('field', $table . '.' . $field['Field']);
        if ($field['Key'] == 'PRI') {
            $node->setAttribute('show', 'false');
            $node->setAttribute('filter', 'false');
        } elseif ($field['Key'] == 'MUL' && strpos($field['Type'], 'set') == false && strpos($field['Type'], 'enum') == false) {
            $node->setAttribute('range', 'multiple');
            $node->setAttribute('show', 'false');
            $node->setAttribute('filter', 'true');
        } elseif (strpos($field['Type'], 'date') === 0 || strpos($field['Type'], 'time') === 0 || strpos($field['Type'], 'year') === 0) {
            $node->setAttribute('range', 'range');
            $node->setAttribute('show', 'true');
            $node->setAttribute('filter', 'true');
            $node->setAttribute('type', 'DateInput');
        } else {
            $node->setAttribute('show', 'true');
            $node->setAttribute('filter', 'true');
        }
        $node = $this->putLabelKey($doc, $node, $field['Field']);
        return $node;
    }

    /**
     * @param $table
     * @param $name
     * @return mixed
     */
    private function getNodeName($table, $name)
    {
        $name = str_replace('_', '', $table) . str_replace('_', '', $name);
        return strtolower($name);
    }

    /**
     * @param $table
     * @return array
     */
    private function getFields($table)
    {
        $this->pdo = PdoMysql::getConn();
        $sth = $this->pdo->prepare("DESCRIBE " . $table);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }

}
