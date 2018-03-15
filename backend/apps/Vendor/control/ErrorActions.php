<?php

namespace apps\Vendor\control;

/**
 * Description of ErrorActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 26, 2015
 */
class ErrorActions extends \lib\control\Controller {

    /**
     *
     */
    public function ajaxAction(){
        $this->setView('error'); 
        
    }

    /**
     *
     */
    public function pageAction(){
        $this->setView('errorpage');
        $this->set('heading','Error Page');
        $this->set('nav_home','/');
    }

    /**
     * @param $tag
     * @param $data
     */
    public function haveError($data){
        $this->setView('errorpage');
        $this->set('errors', $data);
        $this->set('messages', '');
    }

    /**
     *
     */
    public function embedAction(){
        $this->setView('error');
        $this->set('error', 'EMBED NOT FOUND');
    }

}
