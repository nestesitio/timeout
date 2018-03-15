<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\WpQueries;
use \apps\Editor\tools\EditorTools;
use \lib\form\input\InputText;

/**
 * Description of GethereActions
*
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 17, 2017
 */
class GethereActions extends \apps\Editor\control\Editor {

    public function gethereAction(){
        $this->setView('pages/gethere');
        $this->languageMenu('gethere');
        
        $this->showTop('gethere');
        
        $this->listTransportation();

        $this->footerEditor();

        
    }
    
    public function listGethereAction(){
        $this->listTransportation();
    }
    
    
    private function showTop($zone){
        $slug = (Vars::getLang() == 'pt')? 'como-chegar-pt': 'como-chegar-en';
        $post = WpQueries::getPage(['post'=>['post_name'=>$slug, 'post_status'=>'publish']]);

        if(null != $post){
           $this->showZone($post, $zone); 
           $this->set('zone-' . $zone . '-footer-title', get_post_custom_values('module-footer-title', $post->ID)[0]);
           
        }else{
            $this->set('zone-gethere-id', '0');
            $this->set('data-id', '0');
            $this->set('canonical', Vars::getCanonical());
        }
        
    }
    
    public function editGethereAction(){
        $zone = 'gethere';
        $this->setView('pages/top-' . $zone);
        if(Vars::getId() == 0) {
            $this->newZone($zone);
        } else {
            $post = WpQueries::getPagebyId(Vars::getId());
            $this->editZone($post, $zone);
        }
        $input = InputText::create('post-footer-title');
        if(Vars::getId() != 0) {
             $input->setValue(get_post_custom_values('module-footer-title', $post->ID)[0]);
        }
        $this->set('zone-' . $zone . '-footer-title',$input->parseInput());
        
    }
    
    public function undoGethereAction(){
        $zone = 'gethere';
        $this->setView('pages/top-' . $zone);
        $this->showTop($zone);
    }
    
    public function saveGethereAction(){
        $post = $this->savePage('page', Vars::getId());
        Vars::setId($post->ID);
        
        $slug = (Vars::getLang() == 'pt')? 'como-chegar-pt': 'como-chegar-en';
        wp_update_post(['ID' => $post->ID, 'post_name' => $slug], true);
        
        EditorTools::updateMeta($post->ID, 'module-title', 'post-header');
        EditorTools::updateMeta($post->ID, 'module-footer-title', 'post-footer-title');

        $this->editGethereAction();
    }
    
    
    private function listTransportation(){
        $args = ['post'=>['post_type' => 'transport', 'post_parent' => '0']];
        $posts = WpQueries::getPages($args);
        
        $this->set('list', EditorTools::getPageData($posts, 'transport', null));
    }
    
    public function edittransportGethereAction(){
        $zone = 'transport';
        $this->setView('pages/edit-transport');
        
        $post = WpQueries::getPagebyId(Vars::getId());
        $this->editZone($post, $zone);
        
        $input = InputText::create('post-link')->setValue(get_field('link', $post->ID));
        $this->set('zone-' . $zone . '-link', $input->parseInput());
        $this->set('data-id',Vars::getId());
    }
    
    public function addtransportGethereAction(){
        $zone = 'transport';
        $this->setView('pages/edit-transport');
        $this->set('data-id', '0');
        $this->newZone($zone);
        $input = InputText::create('post-link');
        $this->set('zone-' . $zone . '-link', $input->parseInput());
        
    }
    
    
    public function savetransportGethereAction(){
        $id = Vars::getId();
        $zone = 'transport';
        $post = $this->savePage($zone, $id);
        Vars::setId($post->ID);
        $this->set('data-id', $post->ID);
        EditorTools::updateMeta($post->ID, 'link', 'post-link');
        
        $this->edittransportGethereAction();
        
        
    }
    
    public function undotransportGethereAction(){
        $id = Vars::getId();
        if($id == 0){
            $this->setEmptyView();
        }else{
            $this->showTransport($id);
        }
    }
    
    private function showTransport($id){
        $this->setView('pages/show-transport');
        $post = get_post($id);
        $this->set('list', EditorTools::getPageData([$post], null));
    }
    
    public function uploadGethereAction() {
        $this->setEmptyView();
        $params = \apps\Editor\tools\ZoneTools::getZoneImageArgs('transport');
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
