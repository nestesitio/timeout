<?php

namespace apps\Editor\control;

use \apps\Editor\tools\WpQueries;
use \lib\register\Vars;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\WpPost;



/**
 * Description of Lisboa
 * 
 * /wp-content/themes/timeout/page-home.php
 * /wp-content/themes/timeout/template-parts/content-archive-academy-studio.php
 * http://www.timeoutmarket.com/
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 26, 2016
 */
class LisboaActions extends \apps\Editor\control\Editor {

    public function lisboaAction(){
        $this->setView('lisboa-home/home');
        $this->languageMenu('lisboa');
        
        $this->sliderEditor();
        
        $this->setZone('middle-east');
        $this->setZone('middle-north-west');
        $this->setZone('middle-south-west');

        $this->setZone('bottom-north-west');
        $this->setZone('bottom-south-west');
        
        $args = ['post'=>['post_type'=>'academia', 'post_status'=>'publish'], 'metakey'=>['date' => null]];
        $this->showCalendar('academy', $args);
        $args = ['post'=>['post_type'=>'estudio', 'post_status'=>'publish'], 'metakey'=>['date' => null]];
        $this->showCalendar('studio', $args);
        
        $this->footerEditor();

        
    }
    
    public function editLisboaAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('lisboa-home/zone-' . $zone);
        if ($zone == 'academy' || $zone == 'studio') {
            $this->editCalendar($zone);
        } elseif(Vars::getId() == 0) {
            $this->newZone($zone);
        } else {
            $post = WpQueries::getPageByMetaKey('home-zone', $zone);
            $this->editZone($post, $zone);
        }
    }
    
    public function undoLisboaAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('lisboa-home/zone-' . $zone);
        if ($zone == 'academy' || $zone == 'studio') {
            $args = ['post'=>['post_type'=>  $this->getType($zone), 'post_status'=>'publish'], 'metakey'=>['date' => null]];
            $this->showCalendar($zone, $args, Vars::getRequests($zone));
        } elseif(Vars::getId() != 0) {
            $post = WpQueries::getPagebyId(Vars::getId());
            $this->showZone($post, $zone);
        }else{
            $this->setZone($zone);
        }
    }
    
    public function saveLisboaAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('lisboa-home/zone-' . $zone);

        $post = WpPost::savePage('page', Vars::getId(), 'publish');
        wp_set_post_categories($post->ID, [get_category_by_slug('homepage')->term_id]);
        
        EditorTools::updateMeta($post->ID, 'home-zone', 'zone');
        
        if ($zone == 'academy' || $zone == 'studio') {
            \apps\Editor\tools\WpMeta::updatePostInMeta('highlight', $zone, Vars::getRequests($zone));

            $args = ['post'=>['post_type'=>  $this->getType($zone), 'post_status'=>'publish'], 'metakey'=>['date' => null]];
            $this->showCalendar($zone, $args, Vars::getRequests($zone));
        }else{
            $this->showZone($post, $zone);
        }

        
    }
    
    
    public function uploadLisboaAction(){
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
    
    public function switchzoneLisboaAction(){
        $post = WpQueries::getPageByMetaKey('home-zone', Vars::getRequests('zone'));
        update_post_meta($post->ID, 'home-zone', Vars::getRequests('source'));
        update_post_meta(Vars::getId(), 'home-zone', Vars::getRequests('zone'));
        
        $this->setView('lisboa-home/zone-' . Vars::getRequests('zone'));
        $this->setZone(Vars::getRequests('zone')); 
    }
    
    public function showLisboaAction(){
        
        $this->setView('lisboa-home/zone-' . Vars::getRequests('zone'));
        $this->setZone(Vars::getRequests('zone')); 
    }
    
    
    public function changepageLisboaAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('lisboa-home/zone-' . $zone);
        $type = $this->getType($zone);
        $args = ['post'=>['post_type'=>$type, 'post_status'=>'publish'], 'metakey'=>['date' => null]];
        $this->showCalendar($zone, $args, Vars::getId());
    }
    
    
    
}
