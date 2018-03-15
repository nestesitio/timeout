<?php

namespace apps\Editor\tools;

use \lib\register\Vars;
use \lib\loader\BootInFolder;
use \lib\form\input\FileInput;
use \lib\form\input\SelectInput;
use \apps\Editor\tools\WpQueries;
use \lib\media\Image;
use \lib\form\input\DateInput;

/**
 * Description of EditorTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 2, 2016
 */
class EditorTools {

    
    public static function setFileUploadInput($post, $var = null, $attach_id = null){
        $upload_url = DS . BootInFolder::getFolder() . '/editor/upload_' . Vars::getCanonical() . 
                DS . Vars::getId() . DS . '?js=1';
        //echo $upload_url . '; ';
        if(Vars::getRequests('zone') != false){
            $upload_url .= '&zone=' . Vars::getRequests('zone');
        }
        if($var != null){
            $upload_url .= '&var=' . $var;
        }
        if($attach_id != null){
            $upload_url .= '&$attach=' . $attach_id;
        }
        $input = FileInput::create('post-image')
                ->setAllowed(['jpg', 'jpeg', 'gif', 'png'])
                ->setuploadUrl($upload_url)
                ->setValue(get_the_post_thumbnail_url($post));
        
        return $input->parseInput();
    }
    
    
    public static function getPostSelectPage($args, $zone, $id){
        $options = WpQueries::listPages($args );
        
        $data_action = DS . BootInFolder::getFolder() .'/editor/changepage_' . Vars::getCanonical() . '/id/?zone=' . $zone;
        
        $input = SelectInput::create('change-' . $zone . '-post')
                ->setDataFunction('changePage')
                ->setDataAttribute('data-layer', 'zone-' . $zone)
                ->setDataAttribute('data-action', $data_action)
                ->setIndexedValuesList($options);
        if($id != null){
            $input->setValue($id);
        }
        return $input->parseInput();
    }
    
    /**
     * 
     * @param int $id The id fo post / page
     * @param string $meta_key The name for metadata / custom field
     * @param string $post_var The name of form input
     * 
     * @return int|bool Meta ID if the key didn't exist, true on successful update, 
     *                  false on failure.
     */
    public static function updateMeta($id, $meta_key, $post_var){
        $value = Vars::getRequests($post_var);
        if($value == false){
            $value = Vars::getPosts($post_var);
        }
        
        if($value !== false){
            return update_post_meta($id, $meta_key, $value);
        }
        return null;
    }
    
    /**
     * 
     * @param int $id The id fo post / page
     * @param string $meta_key The name for metadata / custom field
     * @param string $value The value to update
     * 
     * @return int|bool Meta ID if the key didn't exist, true on successful update, 
     *                  false on failure.
     */
    public static function updateMetaValue($id, $meta_key, $value){
        
        return update_post_meta($id, $meta_key, $value);

    }
    
    public static function mediaCategory($post_id){
        $category = get_post_custom_values('category', $post_id)[0];
    }
    
    public static function saveImage($link, $post_id, $desc = "TimeOut Market"){
        ///wp-content/uploads/editor/20150225_181333.jpg-> 1523|1124
        //{"upload":"ok","result":1641}
        $url = 'https://' . Vars::getDomain() . $link;
        self::requireIncludesMedia();
        $file_array['name'] = basename($url);
        $file_array['tmp_name'] = download_url($url);
        
        $id = media_handle_sideload( $file_array, $post_id, $desc );
        //update_attached_file($attach_id, $url);
        
        return $id;
        
    }
    
    /**
     * 
     * @param string $key   Index of the {@link $_FILES} array that the file was sent. Required.
     * @param int    $post_id   The post ID of a post to attach the media item to. Required, but can
     * @return int|WP_Error ID of the attachment or a WP_Error object on failure
     */
    public static function insertImage($key, $post_id){
        self::requireIncludesMedia();
        //@return int|WP_Error ID of the attachment or a WP_Error object on failure.
        $result = wp_handle_upload($key, $post_id);
        if ( is_wp_error($result) ) {
            $err = $result->get_error_code();
        }
        return $result;
        
    }
    
    private static function requireIncludesMedia(){
        if (!function_exists('media_handle_upload')) {
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }
    }

    /**
     * 
     * @param string $post_var
     * @param array $params
     * @return string|bool The path of the image
     */
    public static function processImage($post_var, $params){
        
        $image = new Image($_FILES[$post_var]["tmp_name"]);
        $result = self::testImageDimensions($image, $params);
        if($result != false){
            return $result;
        }
        
        self::$action = new \lib\media\UploadFile();
        self::$action->setFolder($params['folder'] . '/');
        self::$action->execute();
        
        return self::$action->getResult();
    }
    
    private static $action = null;
    
    public static function deleteImage(){
        self::$action->delete();
    }
    
    private static function testImageDimensions(Image $image, $params){
        if(isset($params[Image::MIN_RATIO]) && $image->ratio < $params[Image::MIN_RATIO]){
            return ['upload'=>'Error: Aspect ratio is less than required'];
        }
        if(isset($params[Image::MIN_WIDTH]) && $image->width < $params[Image::MIN_WIDTH]){
            return ['upload'=>'Error: Width is less than required (min: ' . $params[Image::MIN_WIDTH] . 'px)'];
        }
        if(isset($params[Image::MIN_HEIGHT]) && $image->heigth < $params[Image::MIN_HEIGHT]){
            return ['upload'=>'Error: Heigth is less than required (min: ' . $params[Image::MIN_HEIGHT] . 'px)'];
        }
        if(isset($params[Image::MAX_RATIO]) && $image->ratio > $params[Image::MAX_RATIO]){
            return ['upload'=>'Error: Aspect ratio exceded'];
        }
        if(isset($params[Image::MAX_WIDTH]) && $image->width > $params[Image::MAX_WIDTH]){
            return ['upload'=>'Error: Image width limit of (' . $params[Image::MAX_WIDTH] . ') exceded'];
        }
        if(isset($params[Image::MAX_HEIGHT]) && $image->heigth > $params[Image::MAX_HEIGHT]){
            return ['upload'=>'Error: Image heigth limit of (' . $params[Image::MAX_HEIGHT] . ') exceded'];
        }
        
        return false;
    }
    
    public static function getPageData($posts = [], $id = null){
        $data = [];
        $i = 0;
        foreach($posts as $post){
            $data[$i]['id'] = $post->ID;
            $data[$i]['data-id'] = $post->ID;
            $data[$i]['title'] = nl2br($post->post_title);
            $data[$i]['status'] = $post->post_status;
            $data[$i]['permalink'] = get_the_permalink($post->ID);
            $data[$i]['src'] = wp_get_attachment_url(get_post_thumbnail_id($post));
            $value = get_post_meta($post->ID, 'date', true);
            $data[$i]['date'] = substr($value, -2) . '/' . substr($value, 4, 2) . '/' . substr($value, 0, 4);
            $data[$i]['active'] = ($i == 0 && $id == null)? 'active' : '';
            if($id == $data[$i]['id']){
                $data[$i]['active'] = 'active';
            }

            $data[$i]['num'] = $i;
            
            $data[$i]['link'] = get_field('link', $post->ID);
            
            $i++;
        }
        
        return $data;
    }
    
    public static function saveExpire(){
        $id = Vars::getId();
        $ts = get_gmt_from_date(Vars::getPosts('post-expire-date'),'U');
        $result = update_post_meta($id, '_expiration-date', $ts);
        //a:2:{s:10:"expireType";s:5:"draft";s:2:"id";i:1364;}
        //a:2:{s:10:"expireType";s:5:"draft";s:2:"id";i:1361;}
        //a:2:{s:10:"expireType";s:5:"draft";s:2:"id";i:1411;}
        $opts = 'a:2:{s:10:"expireType";s:5:"draft";s:2:"id";i:'.$id.';}';
        update_post_meta($id, '_expiration-date-options', $opts);
	update_post_meta($id, '_expiration-date-status','saved');
        return $result;
        
    }
    
    public static function getExpirateInput($date = null) {
        $input = DateInput::create('post-expire-date')->setFormatOnlyDate();
        if ($date != null) {
            $date = date('Y-m-d', $date);
            //$date = get_date_from_gmt($date);
            $input->setValue($date);
        }
        return $input->parseInput();
    }
    
    public static function showImageArgs($args){
        $string = '';
        if(isset ($args[Image::MIN_WIDTH]) || isset($args[Image::MIN_HEIGHT])){
            $string .= 'Minimum dim: ';
            $arr = [Image::MIN_WIDTH=>'width', Image::MIN_HEIGHT=>'height'];
            foreach($arr as $key=>$label){
                $string .= (isset($args[$key]))? $args[$key] . 'px ' : 'not limited ';
                $string .= $label;
                $string .= $key == Image::MIN_WIDTH? ' x ' : '';
            }
            $string .= '<br /> ';
        }
        if(isset ($args[Image::MAX_WIDTH]) || isset($args[Image::MAX_HEIGHT])){
            $string .= 'Maximum dim: ';
            $arr = [Image::MAX_WIDTH=>'width', Image::MAX_HEIGHT=>'height'];
            foreach($arr as $key=>$label){
                $string .= (isset($args[$key]))? $args[$key] . 'px ' : 'not limited ';
                $string .= $label;
                $string .= $key == Image::MAX_WIDTH? ' x ' : '';
            }
            $string .= '<br /> ';
        }
        if(isset ($args[Image::MIN_RATIO]) || isset($args[Image::MAX_RATIO])){
            $string .= 'Aspect ratio: <br />';
            if(isset ($args[Image::MIN_RATIO])){
                $string .= 'Min aspect ratio: ' . self::calculateratio($args[Image::MIN_RATIO]) . '<br />';
            }
            if(isset ($args[Image::MAX_RATIO])){
                $string .= 'Max aspect ratio: ' . self::calculateratio($args[Image::MAX_RATIO]) . '<br />';
            }
        }
        
        return '<span class="image-args">'. $string. '</span>';
    }
    
    private static function calculateratio($ratio){
        if($ratio == 1){
            return '1:1';
        }elseif($ratio > 1){
            if($ratio <= 1.2){
                return '6:5';
            }elseif($ratio <= 1.5){
                return '4:3';
            }
            return ' panoramic';
        }elseif(null != $ratio){
            if($ratio <= 0.8){
                return '5:6';
            }elseif($ratio <= 1.5){
                return '3:4';
            }
            return ' skyscrapper';
        }
        return ' not defined';
    }

}
