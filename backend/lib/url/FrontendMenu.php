<?php

namespace lib\url;

use \lib\url\MenuRender;


/**
 * Description of FrontendMenu
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 30, 2016
 */
class FrontendMenu extends \lib\url\Menu {
    
    
    
    public static function renderScrollMenu(){
        
        $obj = new FrontendMenu();
        $obj->getFrontendScrolMenu();
        
        return $obj->renderMenu();
    }
    
    
    public function getFrontendScrolMenu(){
        $this->menu = '';
        $pages = \apps\Vendor\model\HtmPageQueries::getFrontendMenus('anchor')->find();
        //$this->menu .= '<li class="hidden"><a href="#page-top"></a></li>';
        foreach($pages as $page){
            if($page->getSlug() == 'index'){
                continue;
            }
            $anchor = $page->getHtm()->getHtmHasVars()->getHtmVars()->getValue();
            $btn = $this->renderItem('#' . $anchor, $page->getMenu(), [MenuRender::CLASS_A=>'page-scroll']);
            
            $this->menu .= $btn;
        }
    }
    
    

}
