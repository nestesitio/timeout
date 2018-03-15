<?php

namespace lib\routing;

use \lib\register\Vars;
use \lib\session\SessionUser;
use \apps\User\model\UserGroupModel;
use \lib\loader\Configurator;
use \lib\register\Monitor;


/**
 * Description of ErrorPage
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 2, 2016
 */
class ErrorPage
{
    /**
     *
     */
    const ERROR_CONTROLLER = '\\apps\\Vendor\\control\\ErrorActions';

    public static function execute($extended)
    {
        $class = self::ERROR_CONTROLLER;
        $controller = new $class();
        if(Vars::getRequests('js') == false){
            $controller->pageAction();
        }else{
            $controller->ajaxAction();
        }

        //$msg = self::setMessage($page, $message);
        self::dev();
        $controller->haveError(Monitor::getErrorMessages());

        echo self::output($controller, $extended);
    }


    private static function output($controller, $extend)
    {
        $output = $controller->dispatch();
        $html = \lib\control\ControlMessages::write($output, $extend);

        return $html;
    }

    public function __construct() {}

    public static function dev()
    {
        if (SessionUser::getUserGroup() == UserGroupModel::GROUP_DEVELOPER ||
                Configurator::getDeveloperMode() == true) {
            Monitor::setErrorMessages(null, ['message'=>'App: ' . Vars::getApp()]);
            Monitor::setErrorMessages(null, ['message'=>'Action class: ' . Vars::getAction()]);
            Monitor::setErrorMessages(null, ['message'=>'Canonical: ' . Vars::getCanonical()]);
            Monitor::setErrorMessages(null, ['message'=>'View: ' . Vars::getView()]);
            Monitor::setErrorMessages(null, ['message'=>'Group: ' . SessionUser::getUserGroup()]);
        }
    }


}
