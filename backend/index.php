<?php
if(gethostbyname(gethostname()) == '127.0.1.1'){
    error_reporting(E_ALL);
    ini_set('display_errors', "1");
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)) . DS . 'backend');
define('HTMROOT', getcwd());

require_once (ROOT . DS . 'lib' . DS . 'register' . DS . 'Registry.php');
require_once (ROOT . DS . 'lib' . DS . 'loader' . DS . 'SplClassLoader.php');
//register and load classes
$loader = new \lib\loader\SplClassLoader;
$loader->registerDir('lib');
$loader->registerDir('apps');
$loader->registerDir('tools');

$loader->register();

\lib\session\Session::start();

if ( !isset($wp_did_header) ) {
	$wp_did_header = true;

	// Load the WordPress library.
	require_once( '../lisboa/wp-load.php' );
        $level = \tools\wp\WpRoles::getLevel();

}

\lib\loader\BootInFolder::run('backend', $level);

if (current_user_can('editor') == 1 || current_user_can('administrator') == 1) {
    //echo 'fixe';
}else{
    //echo 'no login';
}