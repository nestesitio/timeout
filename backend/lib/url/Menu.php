<?php

namespace lib\url;

use \lib\url\MenuRender;

/**
 * Description of Menu
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Oct 3, 2016
 */
class Menu {

    protected $menu;
    
    /**
     * MenuRender constructor.
     */
    public function __construct()
    {
        $this->menu = '';
    }

    /**
     * 
     * @return string
     */
    public function renderSideMenu(){
        return '<ul class="nav" id="side-menu">' . 
                $this->menu . '</ul>';
    }
    
    /**
     * 
     * @return string
     */
    public function renderMenu($class = null, $id = null) {
        
        if($class == null && $id == null){
            return $this->menu;
        }else{
            $str = '<ul>';
            if(null != $class){
                $str = str_replace('<ul', '<ul class="'.$class.'"', $str);
            }
            if(null != $id){
                $str = str_replace('<ul', '<ul id="'.$id.'"', $str);
            }
            return $str . $this->menu . '</ul>';
        }
    }
    
    protected function renderItem($param_url, $title, $params = []){
        
        return \lib\url\UrlHref::renderMenuItem($param_url, $title, $params);
        
    }

}
