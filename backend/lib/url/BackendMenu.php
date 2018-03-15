<?php

namespace lib\url;

use \lib\tools\StringTools;
use  \lib\url\MenuRender;

/**
 * Description of BackendMenu
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 14, 2016
 */
class BackendMenu extends \lib\url\Menu {

    private $links = [];
    
    
    
    
    /**
     * 
     * @param string|null $args
     * @return string
     */
    public static function render($args = null)
    {
        $obj = new BackendMenu();
        $obj->renderHeader();
        $obj->getBackendLinks();
        
        $apps = StringTools::argsToArray($args);
        $obj->groupLinks($apps);
        
        return $obj->renderMenu('nav', 'side-menu');
    }
    
    
    public static function renderFromXml(){
        $obj = new BackendMenu();
        $obj->renderHeader();
        $obj->getBackendLinks();
        
        $apps = $obj->getXml();
        $obj->groupLinks($apps);
        
        return $obj->renderMenu();
    }
    
    
    private function getXml(){
        $arr = [];
        $xml = new \lib\xml\XmlFile('config/menus.xml');
        $nodes = $xml->arrayXPath('backend/*', 'node');
        foreach($nodes as $node){
            foreach ($node->attributes as $attr) {
                if ($attr->name == 'app') {
                    $app = $attr->value;
                }elseif($attr->name == 'icon'){
                    $icon = $attr->value;
                }
            }
            $arr[$app] = $icon;
        }
        return $arr;
    }

    

    public function renderHeader(){
        $params = [MenuRender::CLASS_A=>'active', MenuRender::ICON_LEFT=>'fa-dashboard fa-fw'];
        $this->menu .= '<li>'.MenuRender::renderMenuItem('/backend', 'Dashboard', $params) .'</li>';
    }
    
    public function getBackendLinks(){
        $pages = \apps\Vendor\model\HtmPageQueries::getBackendPages()->find();
        foreach($pages as $page){
            $btn = MenuRender::renderMenuUrl(['app'=>$page->getHtm()->getHtmApp()->getSlug(),'canonical'=>$page->getSlug()], $page->getMenu());
            $this->links[$page->getHtm()->getHtmApp()->getSlug()][] = $btn;
        }
    }
    
    /**
     * 
     * @param array $apps
     */
    public function groupLinks($apps = []){
         $auths = $this->getAuths();
         
         foreach($apps as $app=>$icon){
             if (isset($auths[$app])) {
                 $this->menu .= '<li>';
                 //<a href="#"><i class="fa fa-gear fa-fw"></i> Configs<span class="fa arrow"></span></a>

                 $this->menu .= MenuRender::renderlink('#', $auths[$app], 
                         [MenuRender::ICON_LEFT => $icon . '  fa-fw', MenuRender::ICON_RIGHT=>'arrow']);
                 
                 $this->menu .= '<ul class="nav nav-second-level">';
                 $this->menu .= implode('', $this->renderMenuGroup($app));
                 $this->menu .= '</ul>';
                 $this->menu .= '</li>';
             }
         }
    }
    
    /**
     * 
     * @param string $key
     * @return array
     */
    protected function renderMenuGroup($key){
        $group = [];
        if (isset($this->links[$key])) {
            foreach ($this->links[$key] as $page) {
                $group[] = $page;
            }
        }
        return $group;
    }

    /**
     * 
     * @return array
     */
    protected function getAuths(){
        $auths = [];
        $apps = \apps\Configs\model\AppsQuery::getAppsAccess();
        foreach($apps as $app){
            $auths[$app->getSlug()] = $app->getName();
        }
        return $auths;
    }
    

}
