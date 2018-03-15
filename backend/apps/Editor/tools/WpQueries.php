<?php


namespace apps\Editor\tools;

use \lib\register\Vars;

/**
 * Description of WpQueries
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 2, 2016
 */
class WpQueries {
    
    protected static $querystr = '';
    
    public static function query($args, $langs = true){
        global $wpdb;
        self::$querystr = '';

        $lang = (Vars::getLang() == 'en') ? 'en' : Vars::getLang() . '-' . Vars::getLang();

        self::$querystr = "SELECT $wpdb->posts.ID FROM $wpdb->posts ";
        if (array_key_exists('metakey', $args)) {
            self::$querystr .= "LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) ";
        }

        if($langs == true){
            self::$querystr .= "LEFT JOIN wp_icl_translations ON ($wpdb->posts.ID = wp_icl_translations.element_id) "
                . "WHERE wp_icl_translations.language_code='$lang'";
        }else{
            self::$querystr .= "WHERE ";
        }

        self::$querystr = self::where($wpdb, $args, self::$querystr);
        
        if(array_key_exists('orderby', $args)){
            self::$querystr   .= "ORDER BY";
            foreach($args['orderby'] as $key=>$value){
                self::$querystr   .= " $wpdb->posts.$key $value, ";
            }
            self::$querystr   = substr(self::$querystr, 0, -2) . " ";
        }elseif(array_key_exists('ordermeta', $args)){
            self::$querystr   .= "ORDER BY $wpdb->postmeta.meta_value " . $args['ordermeta'];
        }
        if(array_key_exists('limit', $args)){
            self::$querystr   .= " LIMIT " . $args['limit'];
        }
        //echo '<hr />QUERY: <br />' . self::$querystr  ;
        
        $pageposts = $wpdb->get_results(self::$querystr  , OBJECT);
        if (!$pageposts){
            return [];
        }
        return $pageposts;
    }
    
    public static function getResults(){
        global $wpdb;
        $pageposts = $wpdb->get_results(self::$querystr  , OBJECT);
        if (!$pageposts){
            return [];
        }
        return $pageposts;
    }
    
    protected static function where($wpdb, $args, $string){
        if (is_array($args) && array_key_exists('post', $args)) {
            foreach ($args['post'] as $key => $value) {
                if(is_array($value)){
                    $string .= "AND $wpdb->posts.$key IN ('".  implode("','", $value)."')";
                }else{
                    $string .= "AND $wpdb->posts.$key = '$value' ";
                }
            }
        }
        
        if (is_array($args) && array_key_exists('metakey', $args)) {
            foreach ($args['metakey'] as $key => $value) {
                $string .= "AND $wpdb->postmeta.meta_key = '$key' ";
                if ($value != null) {
                    $string .= "AND $wpdb->postmeta.meta_value = '$value'";
                }
            }
        }
        
        $string = str_replace ("WHERE AND", "WHERE", $string);
        
        return $string;
    }
    
    /**
     * Warning: array_key_exists() expects parameter 2 to be array, 
     * null given in /var/www/timeout/backend/apps/Editor/tools/WpQueries.php 
     * p on line 69
     * @param array $args
     * @param int $id
     * @return \WP_Post
     */
    public static function getLastPost($args, $id = null){
        if($id == null){ 
            //$args = [''=>['post_type' => 'academia'], 'meta_key' => 'date'];
            $pageposts = self::query(
                    array_merge($args, ['orderby'=>['post_date' => 'DESC'], 'limit'=>1])
                    );
            foreach ($pageposts as $post) {
                return get_post($post->ID);
            }
        }else{
            $post = get_post($id);
        }
        return $post;
    }
    
    /**
     * Get array of posts with pair id => title
     * 
     * @param array $args The arguments for query
     * @return array with key value pair
     */
    public static function listPages($args = []){
        $options = [];
        $pageposts = self::query($args);
        
        if(null != $pageposts){
            foreach ($pageposts as $post) {
                $page = get_post($post->ID);

                $options[$page->ID] = $page->post_title;
            }
        }
        
        return $options;
    }
    
    /**
     * 
     * @param array $args The arguments for query
     * @return array An array of posts
     */
    public static function getPages($args = [], $langs = true){
        $pages = [];
        $pageposts = self::query($args, $langs);
        
        if(null != $pageposts){
            foreach ($pageposts as $post) {
                $pages[] = get_post($post->ID);
            }
        }
        return $pages;
    }

    /**
     * 
     * @param type $key
     * @param type $value
     * @return type
     */
    public static function getPageByMetaKey($key, $value, $type = 'page'){
        
        $pageposts = self::query([
            'metakey'=>[$key => $value], 
            'post'=>['post_type'=>$type, 'post_status'=>'publish']
            ]);
        
        foreach ($pageposts as $post){
            return get_post($post->ID);
        }  
        
    }
    
    /**
     * 
     * @param int $id
     * @return \WP_Post
     */
    public static function getPagebyId($id){
        return get_post($id);
        
    }
    
    
    public static function getPage($args = []){
        
        $pageposts = self::query($args);
        //'post_type'=>'page', 'post_status'=>'publish'
        
        if(null != $pageposts){
            foreach ($pageposts as $post) {
                return get_post($post->ID);
            }
        }
        return null;


    }
    
    /**
     * 
     * @param array $args
     * @param int $id
     * @return \WP_Post
     */
    public static function getPost($args, $id = null){
        if($id == null){
            $post = self::getPage(array_merge($args, ['limit'=>1]));
        }else{
            $post = get_post($id);
        }
        return $post;
    }
    

}
