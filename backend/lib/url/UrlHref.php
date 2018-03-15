<?php

namespace lib\url;

/**
 * Description of UrlHref
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 16, 2014
 */
class UrlHref
{
    /**
     *
     */
    const ICON_RIGHT = 'icon_right';
    /**
     *
     */
    const ICON_LEFT = 'icon_left';
    /**
     *
     */
    const CLASS_LI = 'class_li';
    /**
     *
     */
    const CLASS_A = 'class_a';
    /**
     *
     */
    const ALT = 'alt';
    /**
     *
     */
    const TARGET = 'target';

    /**
     * @param array $pieces
     * @return string
     */
    private static function renderRelativeHref($pieces = [])
    {
        if(isset($pieces['app'])){
            $url = '/' . $pieces['app'];
        }
        if(isset($pieces['canonical']) && $pieces['canonical'] != 'index'){
            $url .= '/' . $pieces['canonical'];
        }
        if(isset($pieces['action'])){
            $url .= '/' . $pieces['action'];
        }
        if(isset($pieces['lang'])){
            $url .= '/' . $pieces['lang'];
        }
        if(isset($pieces['id'])){
            $url .= '/' . $pieces['id'];
        }
        if(isset($pieces['get'])){
            $url .= '?';
            foreach($pieces['get'] as $key=>$value){
                $url .= '&' . $key . '=' . $value;
            }
        }

        if($url == '/home'){
            $url = '/';
        }

        return $url;
    }

    /**
     * @param $url
     * @return string
     */
    public static function renderUrl($url)
    {
        if(is_array($url)){
            return self::renderRelativeHref($url);
            
        }else{
            return $url;
        }

    }
    
    /**
     * 
     * @param mixed $param_url
     * @param string $title
     * @param array $params
     * @return string
     */
    public static function renderLink($param_url, $title, $params = []){
        $url = self::renderUrl($param_url);
        
        $str = '<a href="' . $url . '"';
        if(isset($params[self::CLASS_A])){
            $str .= ' class="fa '.$params[self::CLASS_A].'"';
        }
        $str .= '>';
        if(isset($params[self::ICON_LEFT])){
            $str .= '<i class="fa '.$params[self::ICON_LEFT].'"></i> ';
        }
        $str .= $title;
        if(isset($params[self::ICON_RIGHT])){
            $str .= ' <i class="fa '.$params[self::ICON_RIGHT].'"></i>';
        }

        return $str . '</a>';
    }

    /**
     * @param $param_url
     * @param $title
     * @param $param_target
     * @return string
     */
    public static function renderMenuUrl($param_url, $title, $param_target = null)
    {
        $url = self::renderUrl($param_url);
        $target = ($param_target == null)? '' : ' target="' . $target . '"';
        return '<li>
                    <a href="' . $url . '">' . $title . '</a>
                </li>';
    }


    /**
     * @param $param_url
     * @param $title
     * @param array $params
     * @return string
     */
    public static function renderMenuItem($param_url, $title, $params = [])
    {
        $string = '<li><a>'.$title.'</a></li>';
        
        if(isset($params[self::CLASS_LI])){
            $string = str_replace('<li>', '<li class="' . $params[self::CLASS_LI] .'">', $string);
        }
        
        if(isset($params[self::ICON_LEFT])){
            $string = str_replace('<a>', '<a> <i class="fa '.$params[self::ICON_LEFT].'"></i>', $string);
        }

        if(isset($params[self::ICON_RIGHT])){
            $string = str_replace('</a>', '<i class="fa '.$params[self::ICON_RIGHT].'"></i> </a>', $string);
        }
        
        if ($param_url != null) {
            $string = str_replace('<a>', '<a href="' . self::renderUrl($param_url) . '">', $string);
        }else{
            $string = str_replace('<a>', '<span>', $string);
            $string = str_replace('</a>', '</span>', $string);
        }
        
        if(isset($params[self::ALT]) && !empty($params[self::ALT])){
            $string = str_replace('<a', '<a title="' . $params[self::ALT] . '"', $string);
        }
        
        if (isset($params[self::CLASS_A])) {
            $class = (strpos($params[self::CLASS_A], 'fa')) ? 
                        'fa ' . $params[self::CLASS_A] : $params[self::CLASS_A];
            $string = str_replace('<a', '<a class="' . $class . '"', $string);
            
        }
        
        if(isset($params[self::TARGET])){
            $string = str_replace('<a', '<a target="' . self::TARGET . '"', $string);
        }
        
        
        
        return $string;
    }
    


    /**
     * @param $li
     * @param $a
     * @param string $title
     * @param $href
     * @param $id
     * @return string
     */
    public static function renderButton($li, $a, $title = '', $href = null, $id = null)
    {
        $button = '<li class="' .$li. '"><a class="' .$a. '"';
        if($href != null){
            $button .= ' href="' . $href . '"';
        }
        if($id != null){
            $button .= ' id="' . $id . '"';
        }
        return $button . '>' . $title . '</a></li>';
    }
    
    /**
     * 
     * @param string $app
     * @param string $canonical
     * @return string a relative url
     */
    public static function renderPageLink($app, $canonical){
        return self::renderRelativeHref(['app'=>$app, 'canonical'=>$canonical]);
    }



}
