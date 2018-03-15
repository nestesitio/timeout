<?php

namespace apps\Editor\tools;

use \lib\register\Vars;
use \apps\Editor\tools\WpQueries;

/**
 * Description of WpPost
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 19, 2017
 */
class WpPost extends \apps\Editor\tools\WpQueries {

    public static function savePage($post_type = 'page', $id = null, $status = 'draft'){
        $id = ($id == null)? 0 : $id;
        if (Vars::getPosts('post-title') != false) {
            $post_id = self::getPostId($id, Vars::getPosts('post-title'), $post_type, $status);

            if (is_wp_error($post_id)) {
                $errors = $id->get_error_messages();
                foreach ($errors as $error) {
                    echo $error . '<br />';
                }
                die('ERROR SAVING ...');
            }


            if (Vars::getPosts('post-status') != false) {
                self::updatePostColumn($post_id, 'post_status', $status);
            }
            

            EditorTools::updateMeta($post_id, 'header', 'post-header');
            EditorTools::updateMeta($post_id, 'text-title', 'post-text-title');
        }

        return WpQueries::getPagebyId($post_id);
        
    }
    
    public static function updatePostValue($post_id, $column, $key){
        $value = Vars::getRequests($key);
        if($value != false){
            self::updatePostColumn($post_id, $column, $value);
        }
    }


    public static function updatePostColumn($post_id, $column, $value){
        global $wpdb;
        
        self::$querystr = "UPDATE $wpdb->posts SET $wpdb->posts.$column = '$value' "
                    . "WHERE $wpdb->posts.id = '$post_id'";
        $result = $wpdb->query( self::$querystr);
            
        return $result;
    }
    
    /**
     * 
     * @param int $id
     * @param string $title
     * @param string $post_type
     * @return int
     */
    public static function getPostId($id, $title, $post_type, $post_status = 'draft'){
        $post = ['ID' => $id, 'post_title' => $title, 'post_type' => $post_type, 'post_status' => $post_status];
        if(Vars::getPosts('post-text') != false){
            $post['post_content'] = Vars::getPosts('post-text') ;
        }
        
        if($id == 0){
            //insert post
            $id = wp_insert_post($post, true);
            self::translatePage($post_type, $id);
        }else{
            // Update the post into the database
            $id = wp_update_post($post, true);
        }
        return $id;
    }
    
    public static function translatePage($post_type, $id){
        require_once(ABSPATH . "wp-content" . '/plugins/sitepress-multilingual-cms/inc/wpml-api.php');
        $lang = (Vars::getLang() == 'pt') ? 'pt-pt' : 'en';
        $_POST['icl_post_language'] = $language_code = $lang;
        $result = wpml_add_translatable_content( 'post_' . $post_type, $id, $language_code );
        if($result == 7){
            $result = wpml_update_translatable_content('post_' . $post_type, $id, $language_code);
        }
    }

}
