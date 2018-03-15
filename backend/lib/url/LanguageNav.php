<?php

namespace lib\url;

use \lib\register\Vars;
use \lib\lang\Language;
use \lib\mysql\Mysql;

/**
 * Description of LanguageNav
 * <ul class="nav navbar-nav nav-langs">
 *  <li>
 *   <a href="#pt">PT</a>
 *  </li>
 * </ul>
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 3, 2016
 */
class LanguageNav extends \lib\url\Menu {

    public static function getSwitcher(){
        
        $obj = new LanguageNav();
        
        $obj->buildSwitcher();
        
       return $obj->renderMenu();
    }
    
    public function buildSwitcher(){
        $langs = \model\querys\LangsQuery::start()->orderByOrd(Mysql::DESC)->find();
        foreach($langs as $lang){
            $href = NULL;
            if(Language::getLang() != $lang->getTld()){
                $href = ['app'=>  Vars::getApp(), 'canonical'=>  Vars::getCanonical(), 'lang'=>$lang->getTld()];
            }
            $this->menu .= $this->renderItem($href, strtoupper($lang->getTld()));
        }
    }

}
