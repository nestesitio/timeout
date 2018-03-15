<?php

namespace apps\Vendor\control;

use \lib\url\UrlHref;


/**
 * Description of MenuActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 26, 2015
 */
class MenuActions extends \lib\control\Controller {

    /**
     *
     */
    public function navAction(){
        
        $this->set('nav_home', UrlHref::renderUrl('/'));
        $this->set('nav_news', UrlHref::renderUrl(['app'=>'news']));
        
        return $this->dispatch();
    }

    /**
     *
     */
    public function navtopAction(){
        
        $this->set('nav_home', UrlHref::renderUrl('/'));
        $this->set('nav_backend', UrlHref::renderMenuUrl(['app'=>'backend'], 'Backend'));
        
        return $this->dispatch();
    }


    /**
     *
     */
    public function headerAction(){
        
        return $this->dispatch();
    }

}
