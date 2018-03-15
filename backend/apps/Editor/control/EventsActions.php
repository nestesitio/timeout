<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\EventsTools;
use \lib\form\input\InputText;
use \lib\form\input\DateInput;
use \lib\form\input\ColorInput;

/**
 * Description of Events
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 10, 2017
 */
class EventsActions extends \apps\Editor\control\Editor {

    public function eventsAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('events/list-' . $zone);
        $this->listEvents($zone);
    }
    
    public function deleteEventsAction(){
        
        $post = get_post(Vars::getId());
        if(null != $post && $post->post_status == 'draft'){
            $this->setEmptyView();
            wp_delete_post( $post->ID );
        }else{
            $this->undoEventsAction();
        }
        
    }
    
    public function editEventsAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('events/edit-' . $zone);
        $this->editEvent($zone, Vars::getId());
        $this->set('data-id',Vars::getId());
    }
    
    public function addEventsAction(){
        $zone = Vars::getRequests('zone');
        $this->setView('events/edit-' . $zone);
        $this->set('data-id', '0');
        $this->newZone($zone);
        $input = InputText::create('post-category');
        $this->set('zone-' . $zone . '-header', $input->parseInput());
        $input = DateInput::create('post-date')->setFormatOnlyDate();
        $this->set('zone-' . $zone . '-date', $input->parseInput());
        $input = InputText::create('post-hour');
        $this->set('zone-' . $zone . '-hour', $input->parseInput());
        $input = InputText::create('post-duration');
        $this->set('zone-' . $zone . '-duration', $input->parseInput());
        $input = InputText::create('post-price');
        $this->set('zone-' . $zone . '-price', $input->parseInput());
        $input = InputText::create('post-tickets');
        $this->set('zone-' . $zone . '-tickets', $input->parseInput());
        
        $this->set('zone-' . $zone . '-expire', EditorTools::getExpirateInput());
        
        $input = ColorInput::create('post-color');
        $this->set('zone-' . $zone . '-color', $input->parseInput());
        
        $this->set('delete-disable', 'disabled');
    }
    
    
    public function saveEventsAction(){
        $id = Vars::getId();
        $zone = Vars::getRequests('zone');
        $post_type = $this->getType($zone);
        $post = $this->savePage($post_type, $id);
        Vars::setId($post->ID);
        $this->set('data-id', $post->ID);
        EventsTools::saveCalendar();
        
        $this->editEventsAction();
        
        
    }
    
    public function undoEventsAction(){
        $id = Vars::getId();
        if($id == 0){
            $this->setEmptyView();
        }else{
            $this->showEvent($id);
        }
    }
    
    private function showEvent($id){
        $this->setView('events/show-event');
        $post = get_post($id);
        $this->set('list', EventsTools::getEventData([$post], null));
    }
    
    public function uploadEventsAction() {
        $this->setEmptyView();
        $params = \apps\Editor\tools\ZoneTools::getZoneImageArgs(Vars::getRequests('zone'));
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