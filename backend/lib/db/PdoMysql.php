<?php
namespace lib\db;

use PDO;
use \lib\loader\Configurator;


/**
 * Description of PdoMysql
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 21, 2014
 */
class PdoMysql
{
    /**
     * @var
     */
    private static $conn;

    /* Class Constructor - Create a new database connection if one doesn't exist
     * Set to private so no-one can create a new instance via ' = new DB();' */
    /**
     * PdoMysql constructor.
     */
    private function __construct() {}

    /* Like the constructor, we make __clone private so nobody can clone the instance  */
    /**
     *
     */
    private function __clone() {}


    /**
     * Returns DB instance or create initial connection
     * @return PDO
     */
    public static function getConn()
     {
        if (!self::$conn) {
            $args = Configurator::getDbConf();
            try {
                $dsn = 'mysql:dbname=' . $args['db'] . ';host=' . $args['host'];
                self::$conn = new PDO($dsn, $args['user'], $args['password']);
                //self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            } catch (\PDOException $err) 
            {
                if($err->getCode() == 1049){
                    die("Create database or correct name of database settings in config/config.xml file\n");
                }
                if($err->getCode() == 1045){
                    die("Create user or correct user and password of database settings in config/config.xml file\n");
                }
                die('ERROR: Database connection not available');
            }
        }

        return self::$conn;
    }
    
    public static function createDb($dbname){
        $args = Configurator::getDbConf();
            try {
                $dsn = 'mysql:host=' . $args['host'];
                self::$conn = new PDO($dsn, $args['user'], $args['password']);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->exec("CREATE DATABASE  IF NOT EXISTS " . $dbname . " 
                    DEFAULT CHARACTER SET utf8 
                    DEFAULT COLLATE utf8_general_ci;");
                
                return $dbname;
                
            } catch (\PDOException $err) 
            {
                if($err->getCode() == 1049){
                    die("Create database or correct name of database settings in config/config.xml file\n");
                }
                if($err->getCode() == 1045){
                    die("Create user or correct user and password of database settings in config/config.xml file\n");
                }
                die("DB ERROR: ". $err->getMessage());
            }
    }

}
