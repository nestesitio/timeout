<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\WpQueries;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\EventsTools;

/**
 * Description of CalendarActions
*
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 17, 2017
 */
class CalendarActions extends \apps\Editor\control\Editor {

    public function calendarAction(){
        $this->setView('events/calendar');
        $this->languageMenu('calendar');
        
        $this->showTop('calendar');
        
        $this->listShop();

        $this->footerEditor();

        
    }
    
    public function listCalendarAction(){
        $this->listCalendar();
    }
    
    private function listShop(){
        $args = ['post'=>['post_parent' => '0', 'post_status'=>'publish'], 
            'metakey'=>['date'=>null], 
            'ordermeta'=>'ASC'];
        $posts = WpQueries::getPages($args);
        $this->set('list', EventsTools::getEventData($posts, 'calendar', null));
    }


    
    
    private function showTop($zone){
        $slug = (Vars::getLang() == 'pt')? 'agenda-pt': 'agenda-en';
        $post = WpQueries::getPage(['post'=>['post_name'=>$slug, 'post_status'=>'publish']]);

        if(null != $post){
           $this->showZone($post, $zone); 
           
        }else{
            $this->set('zone-calendar-id', '0');
            $this->set('data-id', '0');
            $this->set('canonical', Vars::getCanonical());
        }
        
    }
    
    public function editCalendarAction(){
        $zone = 'calendar';
        $this->setView('events/top-' . $zone);
        if(Vars::getId() == 0) {
            $this->newZone($zone);
        } else {
            $post = WpQueries::getPagebyId(Vars::getId());
            $this->editZone($post, $zone);
        }
    }
    
    public function undoCalendarAction(){
        $zone = 'calendar';
        $this->setView('events/top-' . $zone);
        $this->showTop($zone);
    }
    
    public function saveCalendarAction(){
        $post = $this->savePage('page', Vars::getId());
        Vars::setId($post->ID);
        
        $slug = (Vars::getLang() == 'pt')? 'agenda-pt': 'agenda-en';
        wp_update_post(['ID' => $post->ID, 'post_name' => $slug], true);
        
        EditorTools::updateMeta($post->ID, 'header', 'post-header');
        EditorTools::updateMeta($post->ID, 'text-title', 'post-text-title');
        EditorTools::updateMeta($post->ID, 'list-title', 'post-list-title');
        EditorTools::updateMeta($post->ID, 'list-header', 'post-list-header');

        $this->editCalendarAction();
    }
    
    public function uploadCalendarAction(){
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
