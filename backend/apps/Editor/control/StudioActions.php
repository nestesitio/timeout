<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\WpQueries;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\EventsTools;
use \lib\form\input\FileInput;

/**
 * Description of StudioActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 13, 2017
 */
class StudioActions extends \apps\Editor\control\Editor {

    public function studioAction(){
        $this->setView('events/studio');
        $this->languageMenu('studio');
        
        $this->showTop('studio');
        
        $this->listStudio();

        
        $this->footerEditor();

        
    }
    
    public function listStudioAction(){
        $this->listStudio();
    }
    
    private function listStudio(){

        $args = ['post'=>['post_type' => 'estudio', 'post_parent' => '0'], 
            'metakey'=>['date'=>null], 
            'ordermeta'=>'DESC'];
        $posts = WpQueries::getPages($args, false);

        $this->set('list', EventsTools::getEventData($posts, 'studio', null));
    }


    
    
    private function showTop($zone){
        $slug = (Vars::getLang() == 'pt')? 'estudio-pt-time-out': 'estudio-en-time-out';
        $post = WpQueries::getPage(['post'=>['post_name'=>$slug, 'post_status'=>'publish']]);

        if(null != $post){
           $this->showZone($post, $zone); 
           $src = wp_get_attachment_url(get_field('logo', $post->ID));
           $this->set('zone-' . $zone . '-logo',  
                   '<img src="' . $src . '" alt="' . $post->post_title . '" />');
        }else{
            $this->set('zone-studio-id', '0');
            $this->set('data-id', '0');
            $this->set('canonical', Vars::getCanonical());
        }
        
    }
    
    public function editStudioAction(){
        $zone = 'studio';
        $this->setView('events/top-' . $zone);
        if(Vars::getId() == 0) {
            $this->newZone($zone);
            
        } else {
            $post = WpQueries::getPagebyId(Vars::getId());
            $this->editZone($post, $zone);
            $attachment_id = get_field('image-detail', Vars::getId());
            $upload_url = $this->getUploadUrl('logo') . '&field=logo&attach=';
            $upload_url .= (is_int($attachment_id))? $attachment_id : 0;
            $input = FileInput::create('post-logo')
                ->setuploadUrl($upload_url)
                ->setValue(wp_get_attachment_url($attachment_id));
            $this->set('zone-' . $zone . '-logo', $input->parseInput());
            $input = \lib\form\input\HiddenInput::create('post-title')->setValue($post->post_title);
            $this->set('zone-' . $zone . '-title',$input->parseInput());
        }
    }
    
    public function undoStudioAction(){
        $zone = 'studio';
        $this->setView('events/top-' . $zone);
        $this->showTop($zone);
    }
    
    public function saveStudioAction(){
        $zone = 'studio';
        $this->setView('events/top-' . $zone);
        $post = $this->savePage('page', Vars::getId());
        wp_set_post_categories($post->ID, [get_category_by_slug('homepage')->term_id]);
        
        $slug = (Vars::getLang() == 'pt')? 'estudio-pt-time-out': 'estudio-en-time-out';
        wp_update_post(['ID' => $post->ID, 'post_name' => $slug], true);
        
        EditorTools::updateMeta($post->ID, 'header', 'post-header');
        EditorTools::updateMeta($post->ID, 'text-title', 'post-text-title');
        EditorTools::updateMeta($post->ID, 'list-title', 'post-list-title');
        EditorTools::updateMeta($post->ID, 'list-header', 'post-list-header');

        $this->showTop($zone);
    }
    
    public function uploadStudioAction(){
        $this->setEmptyView();
        $params = \apps\Editor\tools\ZoneTools::getZoneImageArgs(Vars::getRequests('zone'));
        $upload = EditorTools::processImage(self::$post_image, $params);
        if(is_array($upload)){
            $this->json = $upload;
        }else{
            $attachment_id = EditorTools::saveImage($upload, Vars::getId(), get_post(Vars::getId())->post_title);
            set_post_thumbnail(Vars::getId(), $attachment_id);
            $this->json = ['upload'=>'ok', 'result'=>$attachment_id];
            EditorTools::deleteImage();
        }
        
        echo json_encode($this->json);
    }
    
    public function upllogoAcademyAction(){
        $this->setEmptyView();
        $params = \apps\Editor\tools\ZoneTools::getZoneImageArgs(Vars::getRequests('zone'));
        $upload = EditorTools::processImage(self::$post_image, $params);
        if(is_array($upload)){
            $this->json = $upload;
        }else{
            $attachment_id = EditorTools::saveImage($upload, Vars::getId(), get_post(Vars::getId())->post_title);
            set_post_thumbnail(Vars::getId(), $attachment_id);
            $this->json = ['upload'=>'ok', 'result'=>$attachment_id];
            EditorTools::deleteImage();
        }
        
        echo json_encode($this->json);
    }
    
    public function upllogoStudioAction() {
        $this->setEmptyView();
        $upload = EditorTools::processImage('post-logo', ['folder'=>'/wp-content/uploads/editor']);
        $attachment_id = null;
            
        if(is_array($upload)){
            $this->json = $upload;
        }else{
            $attachment_id = Vars::getRequests('attach');
            $desc = get_post(Vars::getId())->post_title;
            if ($desc == false) {
                $desc = 'Time Out Academy';
            }
            $attachment_id = EditorTools::saveImage($upload, Vars::getId(), $desc);
            $this->json = ['upload'=>'ok', 'result'=>$attachment_id];

            EditorTools::deleteImage();
        }
        if ($attachment_id != null) {
            update_field('logo', $attachment_id, Vars::getId());
        }
        //update_attached_file($attachment_id, $url);

        echo json_encode($this->json);
    }

}
