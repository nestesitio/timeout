<?php

namespace apps\Home\control;

/**
 * Description of MenuActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 18, 2016
 */
class MenuActions extends \lib\control\ControllerAdmin {

    /**
     *
     */
    public function menuAction(){
        //$this->setView('backend');
        $this->setView('markets');
        
    }  
    
    public function backofficeMenuAction(){
        //$this->setView('backend');
        $this->setView('markets');
        
    }
    
    public function marketsMenuAction(){
        $this->setView('markets');
        
    }
    

}
