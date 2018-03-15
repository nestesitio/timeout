<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\WpQueries;
use \apps\Editor\tools\EditorTools;
use \lib\form\input\InputText;
use \lib\form\input\TextAreaInput;

/**
 * Description of ThemarketActions
*
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 17, 2017
 */
class ThemarketActions extends \apps\Editor\control\Editor {

    public function themarketAction(){
        $this->setView('pages/themarket');
        $this->languageMenu('themarket');
        
        $this->showTop('themarket');

        $this->footerEditor();

        
    }
    
    public function listThemarketAction(){
        $this->listTransportation();
    }
    
    
    private function showTop($zone){
        $slug = (Vars::getLang() == 'pt')? 'conceito': 'concept';
        $post = WpQueries::getPage(['post'=>['post_name'=>$slug, 'post_status'=>'publish']]);

        if(null != $post){
           $this->showZone($post, $zone); 
           $video = get_post_custom_values('video', $post->ID)[0];
           $this->set('zone-' . $zone . '-video', $video);
           $this->set('zone-' . $zone . '-title', nl2br(get_post_custom_values('title', $post->ID)[0]));
           $this->set('zone-' . $zone . '-left-column', nl2br(get_post_custom_values('left-column', $post->ID)[0]));
           $this->set('zone-' . $zone . '-right-column', nl2br(get_post_custom_values('right-column', $post->ID)[0]));
           
        }else{
            $this->set('zone-themarket-id', '0');
            $this->set('data-id', '0');
            $this->set('canonical', Vars::getCanonical());
        }
        
    }
    
    public function editThemarketAction(){
        $zone = 'themarket';
        $this->setView('pages/top-concept');
        if(Vars::getId() == 0) {
            $this->newZone($zone);
        } else {
            $post = WpQueries::getPagebyId(Vars::getId());
            $this->editZone($post, $zone);
            $title = get_post_custom_values('title', $post->ID)[0];
            $title = str_replace('<br>', "\n", $title);
            $input = TextAreaInput::create('post-title')->setRows(3)->setValue($title);
            $this->set('zone-' . $zone . '-title',$input->parseInput());
            $value = get_post_custom_values('video', $post->ID)[0];
            $input = TextAreaInput::create('post-video')->setRows(2)
                    ->setValue(htmlentities($value));
            $this->set('zone-' . $zone . '-video', $input->parseInput());
            
            $input = TextAreaInput::create('left-column')->setRows(8)
                    ->setValue(get_post_custom_values('left-column', $post->ID)[0]);
            $this->set('zone-' . $zone . '-left-column',$input->parseInput());
            $input = TextAreaInput::create('right-column')->setRows(8)
                    ->setValue(get_post_custom_values('right-column', $post->ID)[0]);
            $this->set('zone-' . $zone . '-right-column',$input->parseInput());
        }
        
    }
    
    public function undoThemarketAction(){
        $zone = 'themarket';
        $this->setView('pages/top-concept');
        $this->showTop($zone);
    }
    
    public function saveThemarketAction(){
        $post = $this->savePage('page', Vars::getId());
        
        //update_post_meta($post->ID, 'video', filter_input(INPUT_POST, 'post-video'));
        EditorTools::updateMeta($post->ID, 'title', 'post-title');
        EditorTools::updateMeta($post->ID, 'left-column', 'left-column');
        EditorTools::updateMeta($post->ID, 'right-column', 'right-column');

        $this->editThemarketAction();
    }
    
    
    private function listGallery(){
        $args = ['post'=>['post_type' => 'gallery', 'post_parent' => '0']];
        $posts = WpQueries::getPages($args);
        
        $this->set('list', EditorTools::getPageData($posts, 'gallery', null));
    }
    
    public function editgalleryThemarketAction(){
        $zone = 'gallery';
        $this->setView('pages/edit-gallery');
        
        $post = WpQueries::getPagebyId(Vars::getId());
        $this->editZone($post, $zone);
        
        $input = InputText::create('post-link')->setValue(get_field('link', $post->ID));
        $this->set('zone-' . $zone . '-link', $input->parseInput());
        $this->set('data-id',Vars::getId());
    }
    
    public function addgalleryThemarketAction(){
        $zone = 'gallery';
        $this->setView('pages/edit-gallery');
        $this->set('data-id', '0');
        $this->newZone($zone);
        $input = InputText::create('post-link');
        $this->set('zone-' . $zone . '-link', $input->parseInput());
        
    }
    
    
    public function savegalleryThemarketAction(){
        $id = Vars::getId();
        $zone = 'gallery';
        $post = $this->savePage($zone, $id);
        Vars::setId($post->ID);
        $this->set('data-id', $post->ID);
        EditorTools::updateMeta($post->ID, 'link', 'post-link');
        
        $this->editgalleryThemarketAction();
        
        
    }
    
    public function undogalleryThemarketAction(){
        $id = Vars::getId();
        if($id == 0){
            $this->setEmptyView();
        }else{
            $this->showTransport($id);
        }
    }
    
    private function showTransport($id){
        $this->setView('pages/show-gallery');
        $post = get_post($id);
        $this->set('list', EditorTools::getPageData([$post], null));
    }
    
    public function uploadThemarketAction() {
        $this->setEmptyView();
        $params = \apps\Editor\tools\ZoneTools::getZoneImageArgs('gallery');
        $upload = EditorTools::processImage(self::$post_image, $params);
        if (is_array($upload)) {
            var_dump($upload);
            $this->json = $upload;
        } else {
            $attachment_id = EditorTools::saveImage($upload, Vars::getId(), get_post(Vars::getId())->post_title);
            set_post_thumbnail(Vars::getId(), $attachment_id);
            $this->json = ['upload' => 'ok', 'result' => $attachment_id];
            EditorTools::deleteImage();
        }

        echo json_encode($this->json);
    }

}
