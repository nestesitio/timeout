<?php

namespace apps\Editor\tools;

use \lib\register\Vars;


/**
 * Description of WpMeta
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 19, 2017
 */
class WpMeta extends \apps\Editor\tools\WpQueries {

    public static function getMetaRow($key, $value = 'value', $post_id = null){
        global $wpdb;
        self::$querystr = '';
        
        self::$querystr = "SELECT $wpdb->postmeta.meta_id FROM  $wpdb->postmeta WHERE ";
        self::$querystr .= "$wpdb->postmeta.meta_key = '$key' ";
        if(null != $value){
            self::$querystr .= " AND $wpdb->postmeta.meta_value = '$value'";
        }
        if(null != $post_id){
            self::$querystr .= " AND $wpdb->postmeta.post_id = '$post_id'";
        }
        
        $results = $wpdb->get_results(self::$querystr  , OBJECT);
        if (!$results){
            return null;
        }
        return $results;
    }
    
    public static function updatePostInMeta($key, $value, $post_id){
        $meta = self::getMetaRow($key, $value)[0];
        global $wpdb;

        //array(1) { [0]=> object(stdClass)#5757 (1) { ["meta_id"]=> string(5) "23798" } }
        if (null != $meta){
            self::$querystr = "UPDATE $wpdb->postmeta SET $wpdb->postmeta.post_id = $post_id "
                    . "WHERE $wpdb->postmeta.meta_id = '$meta->meta_id'";
            $result = $wpdb->query( self::$querystr);
            
        }else{
            self::$querystr = "INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES "
                    . "('$post_id', '$key', '$value')";
            $result = $wpdb->query( self::$querystr);
        }
        return $result;
    }
    
    public static function startQuery($args, $langs = true){
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
        
        
        return self::$querystr;
    }
    
    public static function getPostsOrderByMetaAsNum($args, $order = 'ASC'){
        global $wpdb;
        $pages = [];
        self::startQuery($args);
        self::$querystr   .= "ORDER BY $wpdb->postmeta.meta_value + 0 $order";
        
        $pageposts = self::getResults();
        
        if(null != $pageposts){
            foreach ($pageposts as $post) {
                $pages[] = get_post($post->ID);
            }
        }

        return $pages;
    }
    

}
