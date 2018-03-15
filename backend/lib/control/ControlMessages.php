<?php

namespace lib\control;


use \lib\tools\MemoryTools;
use \lib\session\SessionUser;
use \lib\loader\Configurator;
use \apps\User\model\UserGroupModel;
use \lib\register\Monitor;

/**
 * Description of ControlMessages
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 15, 2014
 */
class ControlMessages extends \lib\control\Controller
{
    /**
     * @var string
     */
    private $dev_messages = '';
    /**
     * @var string
     */
    private $user_messages = '';


    /**
     * @param $html
     * @param bool $extend
     * @return string
     */
    public static function write($html, $extend = true)
    {
        $messages = '';
        $flags = 0;

        $controller = new ControlMessages();

        if (SessionUser::getUserGroup() == UserGroupModel::GROUP_DEVELOPER ||
                Configurator::getDeveloperMode() == true) {

            $flags = $controller->processDevelopMessages();

            if ($flags > 0) {
                $controller->setView('layout' . DS . 'core' . DS . 'messages.htm');
                $controller->set('dev_messages', $controller->getMonitor());
                $controller->set('user_messages', $controller->getUserMessages());
                $messages = $controller->dispatch();
            }
            
            if ($extend != true) {
                $html .= '<div class="submessages">' . $messages . '</div>';
            }
        }
        $html = str_replace('{@debug-list}', $messages, $html);
        return $html;
    }

    public static function testOutput()
    {
        $controller = new ControlMessages();
        $controller->processDevelopMessages();
        return $controller->getMonitor();
    }

    /**
     * @return string
     */
    public function getMonitor()
    {
        return $this->dev_messages;
    }

    /**
     * @return string
     */
    public function getUserMessages()
    {
        return $this->user_messages;
    }

    /**
     * @return mixed
     */
    public function messagesAction()
    {
        return $this->getDevelopMessages();
    }


    /**
     * @return int
     */
    public function processDevelopMessages()
    {
        $flag = 0;

        $errors = Monitor::getErrorMessages();
        
        foreach ($errors as $error) {
            $this->dev_messages .= '<div class="dev_errors alert alert-warning"><b>ERROR: </b>' . $error['message'] . '</div>';
            $flag++;
        }
        $msgs = Monitor::getMonitor();
        foreach ($msgs as $msg) {
            $this->dev_messages .= $msg->write();
            $flag++;
        }
        $this->dev_messages .= $this->getMemoryTest();
        return $flag;
    }

    /**
     * @return string
     */
    private function getMemoryTest()
    {
        $type = \lib\register\Monitor::MEMORY;
        $string = '<div class="dm ' . $type . '"><b>' . $type . ':</b> ';
        $string .= ' Memory: ' . MemoryTools::getMemoryUsage() . ' Kb';
        $string .= ' in ' . ini_get('memory_limit') .' available; ';
        $string .= ' Time: ' . MemoryTools::getTimeExecution() . ' of ' . ini_get('max_execution_time') . ' sec';

        return '</div>' . $string;
    }

}
