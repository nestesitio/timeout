<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \lib\form\input\HiddenInput;
use \lib\form\input\TextAreaInput;
use \lib\form\input\FileInput;
use \apps\Editor\tools\EditorTools;
use \lib\media\Image;
use \apps\Editor\tools\WpQueries;

/**
 * Description of SliderActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 12, 2016
 */
class SliderActions extends \apps\Editor\control\Editor {
    
    
    private static $post_image_attached = 'post-image-attached';
    
    public function addSliderAction(){
        $this->setView('lisboa-home/header-slider-edit');
        $this->set('header-btn-disable','');
        $this->set('header-btn-edit-disable','disabled');
        
        $input = TextAreaInput::create('post-title')->setRows(2)->setValue('TITLE');
        $this->set('zone-header-title', $input->parseInput());
        
        $input = TextAreaInput::create('post-text')->setRows(10)->setValue('TEXT');
        $this->set('zone-header-text', $input->parseInput());
    }
    
    public function deleteSliderAction(){
        $id = Vars::getId();
        wp_delete_post( $id );
        $this->undoSliderAction();
    }
    
    public function editSliderAction(){
        $this->setView('lisboa-home/header-slider-edit');
        $this->set('header-btn-disable','');
        $this->set('header-btn-edit-disable','disabled');
        
        $post = get_post(Vars::getId());
        
        $upload_url = $this->getUploadUrl('image') . '&attach=' . get_post_thumbnail_id($post);
        $input = FileInput::create(self::$post_image)
                ->setuploadUrl($upload_url)
                ->setValue(get_the_post_thumbnail_url($post));
        $this->set('zone-header-image-filename', 
                EditorTools::showImageArgs($this->post_image_args) . $input->parseInput());
        
        $text = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $post->post_title);
        $input = TextAreaInput::create('post-title')->setRows(2)->setValue($text);
        $this->set('zone-header-title', $input->parseInput());
        
        $text = strip_tags(preg_replace('/\<br(\s*)?\/?\>/i', "\n", $post->post_content));
        $input = TextAreaInput::create('post-text')->setRows(10)->setValue($text);
        $this->set('zone-header-text', $input->parseInput());
        
        $attachment_id = get_field('image-detail', Vars::getId());      
        
        $upload_url = $this->getUploadUrl('detail') . '&field=image-detail&attach=';
        $upload_url .= (is_int(get_field('image-detail', Vars::getId())))?
                    get_field('image-detail', Vars::getId()) : 0;

        $input = FileInput::create(self::$post_image_attached)
                ->setuploadUrl($upload_url)
                ->setValue(wp_get_attachment_url($attachment_id));

        $this->set('zone-header-image-attached-filename', 
                EditorTools::showImageArgs($this->attach_image_args) . $input->parseInput());
        
        $this->set('zone-header-status', $this->getStatusSelector($post->post_status));

        $input = HiddenInput::create('post-id')->setValue(Vars::getId());
        $this->set('zone-header-id', $input->parseInput());
        $this->set('slider-id', Vars::getId());
        
    }
    
    private $post_image_args = ['folder'=>'/wp-content/uploads/editor', 
                   Image::MAX_WIDTH=>1950, Image::MAX_HEIGHT=>null, 
                   Image::MIN_WIDTH=>1500, Image::MIN_HEIGHT=>600, 
                   Image::MIN_RATIO=>1.2];
    
    function uplimageSliderAction() {
        $attachment_id = $this->uploadSliderAction(self::$post_image, $this->post_image_args);
        if($attachment_id != null){
            set_post_thumbnail(Vars::getId(), $attachment_id);
        }
        echo json_encode($this->json);
    }
    
    private $attach_image_args = ['folder'=>'/wp-content/uploads/editor', 
                   Image::MAX_WIDTH=>1000, Image::MAX_HEIGHT=>null, 
                   Image::MIN_WIDTH=>400, Image::MIN_HEIGHT=>null];
    
    function upldetailSliderAction() {
        $attachment_id = $this->uploadSliderAction(self::$post_image_attached, $this->attach_image_args);
        if($attachment_id != null){
            update_field( 'image-detail', $attachment_id, Vars::getId());
        }
        //update_attached_file($attachment_id, $url);
        
        echo json_encode($this->json);
    }
    
    public function uploadSliderAction($var, $params){
        $this->setEmptyView();
        $upload = EditorTools::processImage($var, $params);
        $attachment_id = null;
            
        if(is_array($upload)){
            $this->json = $upload;
        }else{
            $attachment_id = Vars::getRequests('attach');
            $desc = get_post(Vars::getId())->post_title;
            if ($desc == false) {
                $desc = 'TimeOut Market';
            }
            if ($attachment_id == false) {
                $attachment_id = EditorTools::saveImage($upload, Vars::getId(), $desc);
                $this->json = ['upload'=>'ok', 'result'=>$attachment_id];
                /*
                $attachment_id = EditorTools::insertImage($var, Vars::getId());
                $this->json = ['upload'=>'ok', 'result'=>$attachment_id];
                if ( is_wp_error($attachment_id) ) {
                    $this->json = ['upload'=>'Error loading image'];
                    $attachment_id = null;
                }
                 * 
                 */
            }else{
                $attachment_id = EditorTools::saveImage($upload, Vars::getId(), $desc);
                $this->json = ['upload'=>'ok', 'result'=>$attachment_id];
            }
            EditorTools::deleteImage();
        }
        //{"upload":"ok","result":"/uploads/ary_papel.jpg","id":"5"}
        
        return $attachment_id;
        
    }
    
    
    
    public function undoSliderAction(){
        $this->setView('lisboa-home/header-slider');
        $this->sliderEditor();
    }
    
    private function insertSlider(){
        $args = ['post'=>['post_type' => 'highlights', 'post_status' => 'publish'], 'orderby'=>['menu_order'=>'ASC'], 'limit'=>5];
        $posts = WpQueries::getPages($args);
        $order = count($posts) + 1;
        $id = wp_insert_post(
                ['post_title' => Vars::getPosts('post-title'), 
                    'post_content' => Vars::getPosts('post-text'),
                    'post_status' => 'draft',
                    'post_type' => 'highlights',
                    'menu_order' => $order]);
        Vars::setId($id);
        $this->editSliderAction();
    }
    
    public function saveSliderAction(){
        if(Vars::getPosts('post-id') == false){
            return $this->insertSlider();
        }
        // Update post 37
        $post = [
            'ID' => Vars::getPosts('post-id'),
            'post_title' => Vars::getPosts('post-title'),
            'post_content' => Vars::getPosts('post-text'),
            'post_status' => Vars::getPosts('post-status'),
            ];

        // Update the post into the database
        $id = wp_update_post($post);
        Vars::setId($id);

        $this->editSliderAction();
    }
    
    public function sortSliderAction(){
        // /js/personal/slider-sort.js -> sliderSort(element, url);
        $this->layout = false;
        $this->setEmptyView();
        
        $args = ['post'=>['post_type' => 'highlights', 'post_status' => 'publish'], 'orderby'=>['menu_order'=>'ASC'], 'limit'=>5];
        $posts = WpQueries::getPages($args);
        $pos = Vars::getRequests('pos');
        $from = Vars::getRequests('from');
        foreach($posts as $post){
            if($post->ID == Vars::getId()){
                echo wp_update_post(['ID'=>$post->ID, 'menu_order'=>(string) $pos]);
                if($pos == 0){
                    $lang = (Vars::getLang() == 'pt') ? 'en' : 'pt-pt';
                    $id = wpml_object_id_filter($post->ID, 'page', false, $lang);
                    wp_update_post(['ID'=>$id, 'menu_order'=>(string) $pos]);
                }
            }else{
                $n = $post->menu_order;
                if($from < $pos && 
                        $post->menu_order > $from && $post->menu_order <= $pos){
                    $n--;
                }elseif($from > $pos && 
                        $post->menu_order < $from && $post->menu_order >= $pos){
                    $n++;
                }
                wp_update_post(['ID'=>$post->ID, 'menu_order'=>$n]);
            }
        }
    }
    
    

}
