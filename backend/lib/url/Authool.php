<?php
namespace lib\url;

use \lib\session\SessionUser;
use \apps\User\model\UserGroupModel;
use \lib\loader\Configurator;
use \lib\tools\StringTools;

/**
 * Description of Authool
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 6, 2016
 */
class Authool extends \lib\url\MenuRender {

    const LINK_BACKEND = 'backend';
    const LINK_LOGIN = 'login';
    const LINK_DEBUG = 'debug';
    const LINK_USER = 'user';
    const LINK_USER_CARET = 'user-caret';

        /**
     * Load from template
     * {@load \lib\menu\Authool::render(backend=> , login=> , debug=>tool)}
     * 
     * @param string $args
     * @return mixed
     */
    public static function render($args = null){
        $links = StringTools::argsToArray($args);
        
        $menu = new Authool();
        $menu->build($links);
        return $menu->renderString();
        
        
    }
    
    
    
    public function build($links = []){
        foreach($links as $key => $label){
            
            if($key == self::LINK_BACKEND){
                $this->string .= self::checkBackendLink($label);
            }
            if($key == self::LINK_USER){
                $this->string .= ($label == 'caret')? 
                        '<li class="dropdown">' . self::caretMenu() . '</li>'
                        : self::userMenu();
            }
            if($key == self::LINK_LOGIN){
                $this->string .= self::navLogin($label);
            }
            if($key == self::LINK_DEBUG){
                $this->string .= self::toolDebug();
            }
        }
    }
    
    public static function navLogin($label){
        
        if(SessionUser::haveUser() == false){
            $params = [self::ICON_RIGHT => 'fa-sign-in', self::CLASS_LI=>'tools'];
            return self::renderMenuItem('/user/login', $label, $params);
        }else{
            $params = [self::ICON_LEFT=>'fa-sign-out fa-fw', self::CLASS_LI=>'tools'];
            return self::renderMenuItem('/user/logout_user', $label, $params);
        }
    }
    
    public static function checkBackendLink($label = 'Backend'){
        
         return (\lib\session\SessionUserTools::haveAccess('backend') == true)? 
                self::renderMenuItem(['app'=>'backend'], $label, [self::ICON_RIGHT => 'fa-tachometer']): '';
         
    }
    
    /**
     * @return string
     */
    public static function toolDebug(){
        if(SessionUser::getUserGroup() == UserGroupModel::GROUP_DEVELOPER ||
                Configurator::getDeveloperMode() == true){
            return self::renderButton('dev_button tools', 'fa fa-gear', '', '', 'dev_display');
        }
        return '';
    }
    
    /**
     * @return string
     */
    public static function userMenu($label = 'Profile'){
        if(SessionUser::haveUser() == true){
            $params = [self::ICON_RIGHT => 'fa-sign-in'];
            return self::renderMenuItem('/user/login', 'Login', $params);
        }else{
            $item = new MenuRender();
            $item->setToogle($label . ' <i class="fa fa-user fa-fw"></i>');
            $item->setDropdown('dropdown-menu dropdown-user');
            $params = [MenuRender::ICON_LEFT=>'fa-user fa-fw'];
            $item->addItem('/user/profile', $label . ' ', $params);
            if(SessionUser::getPlayer() != SessionUser::getUserId()){
                $params = [MenuRender::ICON_LEFT=>'fa-user fa-fw'];
                $item->addItem('/user/reset_user', 'User Reset', $params);
            }
            $item->addDivider();
            $params = [MenuRender::ICON_LEFT=>'fa-sign-out fa-fw'];
            $item->addItem('/user/logout_user', 'Logout', $params);
            
            return $item->renderString();
        }
    }
    
    /**
     * @return string
     */
    public static function caretMenu(){
        $item = new MenuRender();
        $item->setToogle('<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>');
        $item->setDropdown('dropdown-menu dropdown-user');
        if(SessionUser::haveUser() == false){
            $params = [MenuRender::ICON_LEFT=>'fa-sign-in fa-fw'];
            $item->addItem('/user/login', 'Login', $params);
        }else{
            $params = [MenuRender::ICON_LEFT=>'fa-user fa-fw'];
            $item->addItem('/user/profile', 'Perfil', $params);
            if(SessionUser::getPlayer() != SessionUser::getUserId()){
                $params = [MenuRender::ICON_LEFT=>'fa-user fa-fw'];
                $item->addItem('/user/reset_user', 'User Reset', $params);
            }
            $item->addDivider();
            $params = [MenuRender::ICON_LEFT=>'fa-sign-out fa-fw'];
            $item->addItem('/user/logout_user', 'Logout', $params);
        }
        
        return $item->renderString();
        
    }

}
