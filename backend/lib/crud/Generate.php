<?php

namespace lib\crud;

use \lib\db\PdoMysql;

/**
 * Description of Generate
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 9, 2014
 */
class Generate
{
    /**
     * @var \PDO
     */
    private $pdo;


    /**
     * Generate constructor.
     */
    public function __construct()
    {
        echo "Building \n";
    }

    /**
     *
     */
    public function buildModel()
    {
        $this->pdo = PdoMysql::getConn();
        
        echo "Generate models ... \n";
        array_map('unlink', glob(ROOT . DS . 'model' . DS . 'models' . DS . '*'));
        array_map('unlink', glob(ROOT . DS . 'model' . DS . 'querys' . DS . '*'));
        array_map('unlink', glob(ROOT . DS . 'model' . DS . 'forms' . DS . '*'));
        $table_tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'model_map.tpl';

        $modelmap = ROOT . DS . 'model' . DS . 'models' . DS . 'ModelMap.php';
        CrudTools::copyFile($table_tpl, $modelmap, 'ModelMap');

        $query = "SHOW TABLES";
        $sth = $this->pdo->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        foreach ($results as $row) {
            $table = $row[0];
            if (strpos($table, 'sf_') === 0) {
                continue;
            }
            echo "\n ** " . $table . " ->";
            $this->modelMap($modelmap, $table);
            $this->fetchCrud($table);
        }
    }

    private function fetchCrud($table) {
        $model_tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'model.tpl';
        $query_tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'query.tpl';
        $form_tpl = ROOT . DS . 'layout' . DS . 'crud' . DS . 'templates' . DS . 'form.tpl';

        $class = \lib\coreutils\ModelTools::buildModelName($table);

        $file = ROOT . DS . 'model' . DS . 'models' . DS . $class . '.php';
        CrudTools::copyFile($model_tpl, $file, $class);

        $file = ROOT . DS . 'model' . DS . 'querys' . DS . $class . 'Query.php';
        CrudTools::copyFile($query_tpl, $file, $class);

        $file = ROOT . DS . 'model' . DS . 'forms' . DS . $class . 'Form.php';
        CrudTools::copyFile($form_tpl, $file, $class);

        $crud = new \lib\crud\CrudModel($table, $class);
        $crud->setConstrains($this->getConstrains());
        $crud->crud();
    }


    /**
     * @return array
     */
    private function getConstrains()
    {
        $constrains = [];
        $conf = \lib\loader\Configurator::getDbConf();
        $db = $conf['db'];
        $query = "SELECT
            i.TABLE_NAME, i.CONSTRAINT_TYPE, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME, k.COLUMN_NAME
            FROM information_schema.TABLE_CONSTRAINTS i
            LEFT JOIN information_schema.KEY_COLUMN_USAGE k ON i.CONSTRAINT_NAME = k.CONSTRAINT_NAME
            WHERE i.CONSTRAINT_TYPE = 'FOREIGN KEY'
            AND i.TABLE_SCHEMA = '$db' GROUP BY i.TABLE_NAME, k.COLUMN_NAME";
        $sth = $this->pdo->prepare($query);
        $sth->execute();
        $results = $sth->fetchAll();
        $i = 0;
        foreach ($results as $row) {
            $constrains[$i]['TABLE_NAME'] = $row[0];
            $constrains[$i]['CONSTRAINT_TYPE'] = $row[1];
            $constrains[$i]['REFERENCED_TABLE_NAME'] = $row[2];
            $constrains[$i]['REFERENCED_COLUMN_NAME'] = $row[3];
            $constrains[$i]['COLUMN_NAME'] = $row[4];
            $i++;
        }

        return $constrains;

    }

    /**
     * @param $file
     * @param $table
     */
    private function modelMap($file, $table)
    {
        $str = file_get_contents($file);
        $tpl = '#%$tableconstant%';
        $const = "const " . strtoupper($table) . " = '$table';";
        $str = str_replace($tpl, $const . "\n    " . $tpl, $str);
        file_put_contents($file, $str);
    }

    /**
     *
     * @param string $app The name of app folder
     * @param string $name The name of action file
     * @param string $model The name of the db table
     */
    public function buildApp($app, $name)
    {
        $crud = new \lib\crud\CrudApp($app, $name);
        
        $crud->createFolders()->execute('app');

    }

    /**
     * @param string $app The name of app folder
     * @param string $name The name of action file
     * @param string $model The name of the db table
     * @param String $area
     * @param String $file
     */
    public function buildAdmin($app, $name, $model, $area = 'admin', $file = null)
    {
        
        $crud = new \lib\crud\CrudApp($app, $name, $model);
        $crud->setConstrains($this->getConstrains());
        $crud->createFolders()->execute($area, $file);

    }
    
    
    public function buildCms($app, $name, $model = 'htm', $area = 'cms', $file = null) {
        $crud = new \lib\crud\CrudApp($app, $name, $model);
        $crud->createFolders()->execute($area, $file);
    }
    
    private function stdin($request, $password = false){
        echo $request . ": ";
        if($password == true){
            system('stty -echo');
        }
        $value = trim(fgets(STDIN));
        system('stty echo');
        echo "\n";
        return $value;
    }

    public function buildDataBase() {
        $dbname = $this->stdin("Please type database name");

        $args = \lib\loader\Configurator::getDbConf();
        $password = $this->stdin("Please type database password");
        // add a new line since the users CR didn't echo
        echo "\n";
        if (trim($password) == $args['password']) {
            $db = PdoMysql::createDb($dbname);
            echo ("database $db created \n");
            if (file_exists(ROOT . DS . 'manual/mvc.sql')) {
                echo "dumping database...\n";
                $command = 'mysql'
                        . ' --host=' . $args['host']
                        . ' --user=' . $args['user']
                        . ' --password=' . $args['password']
                        . ' --database=' . $dbname
                        . ' --execute="SOURCE ' . ROOT . DS . 'manual/mvc.sql' . '"';
                shell_exec($command);
            }else{
                echo "sql file not found \n";
            }
            
        }else{
            echo "wrong password\n";
        }
        

        
    }

}
