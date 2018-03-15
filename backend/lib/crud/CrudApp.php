<?php

namespace lib\crud;

use \lib\crud\CrudTools;
use \lib\coreutils\ModelTools;
use \lib\db\PdoMysql;
use PDO;

use \model\querys\HtmAppQuery;
use \model\models\Htm;
use \model\models\HtmPage;
use \apps\Vendor\model\HtmPageQueries;

/**
 * Description of CrudApp
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 27, 2015
 */
class CrudApp
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $app;
    /**
     * @var mixed
     */
    private $model;
    /**
     * @var
     */
    private $table;
    /**
     * @var
     */
    private $constrains;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $area = 'backend';
    /**
     * @var
     */
    private $folder;

    /**
     * CrudApp constructor.
     * @param $app
     * @param $name
     * @param $table
     */
    public function __construct($app, $name, $table = null)
    {
        $this->app = ucfirst(strtolower($app));
        echo "App is " . $this->app . "\n";
        $this->name = ucfirst(strtolower($name));
        
        if (null != $table) {
            $this->table = $table;

            $this->model = ModelTools::buildModelName($table);
            $this->pdo = PdoMysql::getConn();
        }
    }

    /**
     * @return $this
     */
    public function createFolders($subfolders = [])
    {
        $this->folder = ROOT . DS . 'apps' . DS . $this->app;
        if (!is_dir($this->folder)) {
            if (mkdir($this->folder) == true) {
                echo "Generate backend app " . $this->app . " ... \n";
                echo " \n";
            } else {
                echo "Generated app " . $this->app . " failed ... \n";
            }
        }else{
            echo "Generated app " . $this->app . " already created ... \n";
        }
        $subfolders = ['config', 'control', 'model', 'view', 'tools'];
        foreach ($subfolders as $fold) {
            if (!is_dir($this->folder . DS . $fold)) {
                 if (mkdir($this->folder . DS . $fold) == true) {
                     echo "folder " . $this->app . DS . $fold . ", ";
                 }
            }
        }
        echo " \n";
        return $this;
    }

    /**
     *
     */
    private function savePage()
    {
        $app = HtmAppQuery::start()
                ->filterBySlug(strtolower($this->app))
                ->filterByName(ucfirst($this->app))->findOneOrCreate();

        $slug = strtolower($this->name);
        $page = HtmPageQueries::start()->filterBySlug($slug)->filterByHtmHtmAppId($app->getId())->findOne();
        if ($page == false) {
            $htm = new Htm();
            $htm->setHtmAppId($app->getId());
            if($this->area == 'admin'){
                $htm->setStat('backend');
            }
            $htm->save();
            $htmpage = new HtmPage();
            $htmpage->setHtmId($htm->getId());
            $htmpage->setSlug(strtolower($this->name));
            $htmpage->setTitle($this->name);
            $htmpage->save();
        }
    }

    /**
     * @param String $area
     * @param String $file
     */
    public function execute($area, $file = null)
    {
        $this->area = $area;
        //$this->savePage();
        if ($file == null || $file == 'actions') {
            $this->createActions($area);
        }
        if ($file == null || $file == 'view') {
            $this->createView();
        }
        if ($area == 'admin') {
            if ($file == null || $file == 'models' || $file == 'form') {
                $this->createForm();
            }
            if ($file == null || $file == 'models' || $file == 'model') {
                $this->createModel();
            }
        }
        if ($area == 'cms' || $area == 'admin') {
            if ($file == null || $file == 'config') {
                $this->createConfig();
            }
        }

    }

    /**
     * @param $constrains
     */
    public function setConstrains($constrains)
    {
        $this->constrains = $constrains;
    }

    /**
     *
     */
    private function createConfig()
    {
        $file = $this->folder . DS . 'config' . DS . strtolower($this->name) . '.xml';
        if (is_file($file)) {
            echo "Config File " . strtolower($this->name) . '.xml' . " exists, deleting.... \n";
            unlink($file);
        }
        $xml = new \lib\crud\CrudConfig($file, $this->app, $this->name, $this->table);
        $xml->create();
    }

    /**
     *
     */
    private function createActions()
    {
        $tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'tpl_apps' . DS . 'actions_' . $this->area . '.tpl';
        
        $file = $this->folder . DS . 'control' . DS . $this->name . 'Actions.php';
        if (is_file($file)) {
            echo "Action File " . $this->name . 'Actions.php' . " exists, delete it to write \n";
        } else {
            CrudTools::copyFile($tpl, $file, $this->name);
            $string = file_get_contents($file);
            $string = $this->replace(file_get_contents($file));

            file_put_contents($file, $string);
        }
    }

    /**
     *
     */
    private function createModel()
    {
        $tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'tpl_apps' . DS . 'actions_model.tpl';
        $file = $this->folder . DS . 'model' . DS . $this->name . 'Queries.php';

        if (is_file($file)) {
            echo "Model File " . $this->name . 'Query.php' . " exists, delete it to write \n";
        } else {
            CrudTools::copyFile($tpl, $file, $this->name);
            $string = $this->replace(file_get_contents($file));

            foreach($this->constrains as $constrain){
                if($constrain['TABLE_NAME'] == $this->table){
                    $string = $this->writeJoin($string, $constrain['REFERENCED_TABLE_NAME']);
                }
                if($constrain['REFERENCED_TABLE_NAME'] == $this->table){
                    $string = $this->writeJoin($string, $constrain['TABLE_NAME']);
                }
            }

            $string = str_replace('#$query->join->endUse();', '', $string);
            file_put_contents($file, $string);
        }
    }

    /**
     *
     */
    private function createForm()
    {
        $tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'tpl_apps' . DS . 'actions_form.tpl';
        $file = $this->folder . DS . 'model' . DS . $this->name . 'Form.php';
        if (is_file($file)) {
            echo "Form File " . $this->name . 'Form.php' . " exists, delete it to write \n";
        }else{
            CrudTools::copyFile($tpl, $file, $this->name);
            $string = $this->replace(file_get_contents($file));

            file_put_contents($file, $string);
        }


    }

    /**
     * @param $string
     * @param $table
     * @return mixed
     */
    private function writeJoin($string, $table)
    {
        echo $table . "\n";
        $fstr = '#$query->join->endUse();';
        $join = str_replace(['->join', '#'], ['->join' . CrudTools::crudName($table) . '()', ''], $fstr);
        echo $join . "\n";
        $query = "SHOW FULL COLUMNS FROM " . $table;
        $sth = $this->pdo->prepare($query);
        $sth->execute();
        $table_fields = $sth->fetchAll(PDO::FETCH_ASSOC);
        foreach ($table_fields as $field){
            if($field['Comment'] == 'ignore'){
                continue;
            }
            $sel = '->select'.ModelTools::buildModelName($field['Field']).'()';
            $join = str_replace('->endUse()', $sel . '->endUse()', $join);
        }
        $string = str_replace($fstr, $join . "\n\t" . $fstr, $string);
        return $string;
    }

    /**
     *
     */
    private function createView()
    {
        $tpl = ROOT . DS . 'layout' . DS . 'core' . DS . 'tpl_' . $this->area . '.htm';
        $file = $this->folder . DS . 'view' . DS  . strtolower($this->name) . '.htm';
        if (!is_file($file)) {
            CrudTools::copyFile($tpl, $file, $this->name);
        }else{
            echo "View file index.htm exists, delete it to write \n";
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    private function replace($string)
    {
        $tags = ['%$nameApp%', '%$slugApp%', '%$modelName%', '%$fileName%'];
        $vars = [$this->app, strtolower($this->app), $this->model, strtolower($this->name)];
        return str_replace($tags, $vars, $string);
    }

}
