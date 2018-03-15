<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\WpQueries;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\ShopTools;
use \apps\Editor\tools\WpMeta;

/**
 * Description of EatshopActions
*
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 17, 2017
 */
class EatshopActions extends \apps\Editor\control\Editor {

    public function eatshopAction(){
        $this->setView('shops/eatshop');
        $this->languageMenu('eatshop');
        
        $this->showTop('eatshop');
        
        $this->listShop();

        
        $this->footerEditor();

        
    }
    
    public function listEatshopAction(){

        $this->setView('shops/list-shops');
        $this->listShop();

    }
    
    private function listShop(){
        /*
         * SELECT wp_posts.ID FROM wp_posts 
         * LEFT JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id) 
         * LEFT JOIN wp_icl_translations ON (wp_posts.ID = wp_icl_translations.element_id) 
         * WHERE wp_icl_translations.language_code='pt-pt'AND wp_posts.post_type = 'comer-e-beber' 
         * AND wp_posts.post_parent = '0' AND wp_postmeta.meta_key = 'space-number' 
         * ORDER BY wp_postmeta.meta_value + 0 ASC
         */
        $args = ['post'=>['post_type' => 'comer-e-beber', 'post_parent' => '0'], 
            'metakey'=>['space-number'=>null]];
        $posts = WpMeta::getPostsOrderByMetaAsNum($args);
        
        $shops = ShopTools::getShopData($posts);
        /*
        if(Vars::getRequests('filter') != false){
            $list = [];
            foreach($shops as $shop){
                
            }
        }
         * 
         */
        
        
        $this->set('list', $shops);
    }


    
    
    private function showTop($zone){
        $slug = (Vars::getLang() == 'pt')? 'comer-e-beber-pt': 'comer-e-beber-en';
        $post = WpQueries::getPage(['post'=>['post_name'=>$slug, 'post_status'=>'publish']]);

        if(null != $post){
           $this->showZone($post, $zone); 
           
        }else{
            $this->set('zone-eatshop-id', '0');
            $this->set('data-id', '0');
            $this->set('canonical', Vars::getCanonical());
        }
        
    }
    
    public function editEatshopAction(){
        $zone = 'eatshop';
        $this->setView('shops/top-' . $zone);
        if(Vars::getId() == 0) {
            $this->newZone($zone);
        } else {
            $post = WpQueries::getPagebyId(Vars::getId());
            $this->editZone($post, $zone);
        }
    }
    
    public function undoEatshopAction(){
        $zone = 'eatshop';
        $this->setView('shops/top-' . $zone);
        $this->showTop($zone);
    }
    
    public function saveEatshopAction(){
        $post = $this->savePage('page', Vars::getId());
        Vars::setId($post->ID);
        
        $slug = (Vars::getLang() == 'pt')? 'comer-e-beber-pt': 'comer-e-beber-en';
        wp_update_post(['ID' => $post->ID, 'post_name' => $slug], true);
        
        EditorTools::updateMeta($post->ID, 'module-title', 'post-header');
        EditorTools::updateMeta($post->ID, 'module-subtitle', 'post-text-title');

        $this->editEatshopAction();
    }
    
    public function uploadEatshopAction(){
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

}
