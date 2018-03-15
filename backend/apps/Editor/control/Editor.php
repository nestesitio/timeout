<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \WP_Post;
use \apps\Editor\tools\WpQueries;
use \lib\form\input\InputText;
use \lib\form\input\TextAreaInput;
use \lib\form\input\DateInput;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\ZoneTools;



/**
 * Description of Editor
 * 
 * https://codex.wordpress.org/Function_Reference
 * https://developer.wordpress.org/reference/classes/wp_post/
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Nov 29, 2016
 */
class Editor extends \lib\control\ControllerAdmin {

    protected function languageMenu($local){
        $lang = Vars::getLang();
        //<a href="#pt">pt</a>
        $pt = ($lang != 'pt')? '<a href="/backend/editor/'.$local.'/pt">pt</a>':'<a class="active">PT</a>';
        $this->set('lang-pt', $pt);
        
        $en = ($lang != 'en')? '<a href="/backend/editor/'.$local.'/en">en</a>':'<a class="active">EN</a>';
        $this->set('lang-en', $en);
    }
    
    
    protected function showZone(WP_Post $post, $zone){
        
        $this->set('zone-' . $zone . '-header', get_field('header', $post->ID));
        $this->set('zone-' . $zone . '-title', $post->post_title);
        $this->set('zone-' . $zone . '-text-title', get_field('text-title', $post->ID));
        $this->set('zone-' . $zone . '-text', $post->post_content);
        
        $this->set('zone-' . $zone . '-list-header', get_field('list-header', $post->ID)); 
        $this->set('zone-' . $zone . '-list-title', get_field('list-title', $post->ID)); 

        
        $category = get_field('category', $post->ID);
        if($category == 'newsletter-form'){
            
        }else{
            $this->setImage(get_the_post_thumbnail_url($post), $zone);
        }
        
        $this->set('zone-' . $zone . '-more-info', get_field('more-info', $post->ID));
        $this->set('zone-' . $zone . '-info-local', get_field('info-local', $post->ID));
        $email = get_field('info-email', $post->ID);
        $this->set('zone-' . $zone . '-info-email',  '<a href="'.$email.'">' . $email . '</a>');
        $this->set('zone-' . $zone . '-info-tel', get_field('info-tel', $post->ID));
        
        $this->set('canonical', Vars::getCanonical());
        $this->set('zone-' . $zone . '-id', $post->ID);
        
        $this->set('zone-' . $zone . '-disable','disabled');
        $this->set('zone-' . $zone . '-switcher', ZoneTools::switchZone($zone, $post->ID));
        
    }
    
    protected function editCalendar($zone){
        if(Vars::getId() == 0) {
            $this->newZone($zone);
        }else{
            $post = get_post(Vars::getId());
            $this->editZone($post, $zone);
        }
        
        $args = ['post'=>['post_type'=>  $this->getType($zone), 'post_status'=>'publish'], 'metakey'=>['date' => null]];
        $event_id = $this->setEvent($zone, $args, Vars::getRequests($zone));
        $this->set('zone-' . $zone . '-select', EditorTools::getPostSelectPage($args, $zone, $event_id));
        $this->set('zone-' . $zone . '-disable','');
        $this->set('canonical', Vars::getCanonical());
        
    }
    
    protected function showCalendar($zone, $args, $id = null){
        $this->setZone($zone);
        $event_id = $this->setEvent($zone, $args, $id);
        $this->set('zone-' . $zone . '-select', EditorTools::getPostSelectPage($args, $zone, $event_id));
        $this->set('zone-' . $zone . '-disable','disabled');
        $this->set('canonical', Vars::getCanonical());
    }
    
    protected function setEvent($zone, $args, $id = null){
        $this->set($zone . '-event-id', '0');
        if (null != $id) {
            $post = get_post($id);
        } else {
            $post = WpQueries::getPageByMetaKey('highlight', $zone, $this->getType($zone));
            if (null == $post) {
                $post = WpQueries::getLastPost($args, $id);
                
            }
        }
        
        if (null != $post) {
            $this->set('zone-' . $zone . '-event-title', $post->post_title);
            $this->setImage(get_the_post_thumbnail_url($post), $zone);

            $meta = get_post_meta($post->ID);
            $this->set('zone-' . $zone . '-category', $meta['category'][0]);
            //20161023 -> 23/10
            $date = substr($meta['date'][0], -2) . '/' . substr($meta['date'][0], 4, 2);
            $this->set('zone-' . $zone . '-date', '<span>' . $date . '</span>');
            $this->set('zone-' . $zone . '-hour', '<span>' . $meta['hour'][0] . '</span>');
            $this->set('zone-' . $zone . '-duration', '<span>' . $meta['duration'][0] . '</span>');
            $this->set('zone-' . $zone . '-price', '<span>' . $meta['price'][0] . ' €</span>');
            //REPLACE-ZONE-event-id
            $this->set($zone . '-event-id', $post->ID);
            $this->set('zone-' . $zone . '-text', $post->post_content); 
            
            return $post->ID;
        }
        return null;
    }


    protected function setZone($zone){
        $post = WpQueries::getPageByMetaKey('home-zone', $zone);
        if(null != $post){
           $this->showZone($post, $zone); 
        }else{
            $this->set('zone-' . $zone . '-id', '0');
        }
        
    }
    
    protected static $post_image = 'post-image';
    
    /**
     * 
     * @param WP_Post $post
     * @param string $zone
     */
    protected function editZone(WP_Post $post, $zone){
        $input = InputText::create('post-header')->setValue(get_field('header', $post->ID));
        $this->set('zone-' . $zone . '-header', $input->parseInput());
        
        $input = InputText::create('post-title')->setValue($post->post_title);
        $this->set('zone-' . $zone . '-title',$input->parseInput());
        
        $input = InputText::create('post-text-title')->setValue(get_field('text-title', $post->ID));
        $this->set('zone-' . $zone . '-text-title',$input->parseInput());
        
        $input = InputText::create('post-list-header')->setValue(get_field('list-header', $post->ID));
        $this->set('zone-' . $zone . '-list-header',$input->parseInput());
        
        $input = InputText::create('post-list-title')->setValue(get_field('list-title', $post->ID));
        $this->set('zone-' . $zone . '-list-title',$input->parseInput());
        
        $input = TextAreaInput::create('post-text')->setRows(6)->setValue($post->post_content);
        $this->set('zone-' . $zone . '-text', $input->parseInput());
        
        $category = get_field('category', $post->ID);
        if($category == 'newsletter-form'){
            $this->set('zone-' . $zone . '-image-filename',  '');
        }else{
            $this->set('zone-' . $zone . '-image-filename',  EditorTools::showImageArgs(ZoneTools::getZoneImageArgs($zone)) . EditorTools::setFileUploadInput($post));
        }
        
        $input = InputText::create('post-more-info')->setValue(get_field('more-info', $post->ID));
        $this->set('zone-' . $zone . '-more-info', $input->parseInput());
        $input = InputText::create('post-info-local')->setValue(get_field('info-local', $post->ID));
        $this->set('zone-' . $zone . '-info-local', $input->parseInput());
        $input = InputText::create('post-info-email')->setValue(get_field('info-email', $post->ID));
        $this->set('zone-' . $zone . '-info-email', $input->parseInput());
        $input = InputText::create('post-info-tel')->setValue(get_field('info-tel', $post->ID));
        $this->set('zone-' . $zone . '-info-tel', $input->parseInput());
        
        $this->set('zone-' . $zone . '-status', $this->getStatusSelector($post->post_status));
        
        $this->set('zone-' . $zone . '-id', $post->ID);
        $this->set('canonical', Vars::getCanonical());
        $this->set('zone-' . $zone . '-disable','');
    }
    
    
    /**
     * 
     * @param string $zone
     * @param int $id
     */
    protected function editEvent($zone, $id = null){
        $post = WpQueries::getPagebyId($id);
        $id = $post->ID;
        
        $this->editZone($post, $zone);
        
        $meta = get_post_meta($id);
        $input = InputText::create('post-category')->setValue($meta['category'][0]);
        $this->set('zone-' . $zone . '-header',$input->parseInput());
        
        //20161023 -> 23/10
        $date = substr($meta['date'][0], 0, 4) . '-' . substr($meta['date'][0], 4, 2) . '-' . substr($meta['date'][0], 6, 2);
        $input = DateInput::create('post-date')->setFormatOnlyDate()->setValue($date);
        $this->set('zone-' . $zone . '-date',$input->parseInput());
        
        $date = get_post_meta( $id, '_expiration-date');
        $this->set('zone-' . $zone . '-expire', EditorTools::getExpirateInput($date[0]));
        
        $input = InputText::create('post-hour')->setValue($meta['hour'][0]);
        $this->set('zone-' . $zone . '-hour',$input->parseInput());
        
        $input = InputText::create('post-duration')->setValue($meta['duration'][0]);
        $this->set('zone-' . $zone . '-duration',$input->parseInput());
        
        $input = InputText::create('post-price')->setValue($meta['price'][0]);
        $this->set('zone-' . $zone . '-price',$input->parseInput());
        
        $input = InputText::create('post-tickets')->setValue(get_field('link', $id));
        $this->set('zone-' . $zone . '-tickets', $input->parseInput());
        
        $input = \lib\form\input\ColorInput::create('post-color')->setValue(get_field('color', $id));
        $this->set('zone-' . $zone . '-color', $input->parseInput());
        
        $value = ($post->post_status == 'draft')? '' : 'disabled';
        $this->set('delete-disable', $value);
    }
    
    
    protected function getStatusSelector($value = null){
        $input = \lib\form\input\SelectInput::create('post-status');
        if(null != $value){
            $input->setValue($value);
        }else{
            $input->setValue('draft');
        }
        $input->setValuesList(['publish', 'draft']);
        return $input->parseInput(false);
    }
    
    
    /**
     * 
     * @param inte $id
     * @return \WP_Post
     */
    protected function savePage($post_type = 'page', $id = null){
        $id = ($id == null)? 0 : $id;
        $status = (Vars::getPosts('post-status') != false)? Vars::getPosts('post-status') : 'publish';
        $post = ['ID' => $id, 
            'post_title' => Vars::getPosts('post-title'),
            'post_content' => Vars::getPosts('post-text'),
            'post_status' => $status,
            'post_type' => $post_type
            ];
        if($id == 0){
            //insert post
            $id = wp_insert_post($post, true);
            \apps\Editor\tools\WpPost::translatePage($post_type, $id);
        }else{
            // Update the post into the database
            $id = wp_update_post($post, true);
        }
        
        
        if (is_wp_error($id)) {
            $errors = $id->get_error_messages();
            foreach ($errors as $error) {
                echo $error . '<br />';
            }
            die('ERROR SAVING ...');
        }

        EditorTools::updateMeta($id, 'header', 'post-header');
        EditorTools::updateMeta($id, 'text-title', 'post-text-title');
        EditorTools::updateMeta($id, 'more-info', 'post-more-info');
        EditorTools::updateMeta($id, 'info-local', 'post-info-local');
        EditorTools::updateMeta($id, 'info-email','post-info-email');
        EditorTools::updateMeta($id, 'info-tel','post-info-tel');
        
        return WpQueries::getPagebyId($id);
        
    }
    

    protected function uploadFileZone($params = []){
        $this->layout = false;
        $this->setEmptyView();
        $action = null;
        if(null != $_FILES){
            $action = new \lib\media\UploadFile();
            $action->setFolder($params['folder'] . '/');
            $action->execute($params['width'], $params['height']);
            $result = $action->getResult();
            if($result != false){
                $this->json['upload'] = 'ok';
                $this->json['result'] = $action->getResult();
            }else{
                $this->json['upload'] = 'error';
            }
        }else{
            $this->json['upload'] = 'false';
        }
        
        return $result;
    }
    
    
    
    
    private function setImage($img_url, $zone){
        $img = '<img src=" ' . $img_url . '" />';
        $this->set('zone-' . $zone . '-image', $img);
        $this->set('zone-' . $zone . '-image-filename', strrchr($img_url, '/'));
    }
    
    
    /**
     * 
     * @param string $zone
     */
    protected function newZone($zone){
        $input = InputText::create('post-header');
        $this->set('zone-' . $zone . '-header', $input->parseInput());
        
        $input = InputText::create('post-title');
        $this->set('zone-' . $zone . '-title',$input->parseInput());
        
        $input = InputText::create('post-text-title');
        $this->set('zone-' . $zone . '-text-title',$input->parseInput());
        
        $input = TextAreaInput::create('post-text')->setRows(6);
        $this->set('zone-' . $zone . '-text', $input->parseInput());
        
        $input = InputText::create('post-list-header');
        $this->set('zone-' . $zone . '-list-header',$input->parseInput());
        
        $input = InputText::create('post-list-title');
        $this->set('zone-' . $zone . '-list-title',$input->parseInput());
        
        $this->set('zone-' . $zone . '-status', $this->getStatusSelector());
        
        $this->set('zone-' . $zone . '-image-filename',  '');
        
        $this->set('zone-' . $zone . '-id', '0');
        $this->set('canonical', Vars::getCanonical());
        $this->set('zone-' . $zone . '-disable','');
    }
    
    protected function sliderEditor(){
        
        $args = ['post'=>['post_type' => 'highlights'], 'orderby'=>['post_status'=>'DESC', 'menu_order'=>'ASC']];
        $posts = WpQueries::getPages($args);
        $this->set('sliders', EditorTools::getPageData($posts));
        $this->set('header-btn-disable', 'disabled');
    }
    
    protected function footerEditor(){
        $post = get_page_by_path('footer');
        $this->set('footer-address', nl2br(get_field('address', $post->ID)));
        $this->set('footer-tel', get_field('tel', $post->ID));
        $this->set('footer-email', get_field('email', $post->ID));
        $this->set('footer-copy', nl2br(get_field('copy', $post->ID)));
        $links = [];
        $arr = ['facebook', 'instagram', 'youtube'];
        $i = 0;
        foreach($arr as $social){
            $link = get_field('link-' . $social, $post->ID);
            $links[$i]['data-action'] = '/backend/editor/social_footer/?js=1'
                    . '&social='.$social.'&link=' . $link;
            $links[$i]['status'] = (null == $link)? 'no-data' : '';
            $links[$i]['icon'] = 'icon-' . $social;
            $links[$i]['href'] = $link;
            
            $i++;
        }
        $this->set('footlinks', $links);
        
    }
    
    protected function getType($zone){
        if($zone == 'studio'){
            $type = 'estudio';
        }elseif($zone == 'academy'){
            $type = 'academia';
        }
        return $type;
    }
    
    protected function listEvents($zone){
        
        if($zone == 'studio'){
            $title = (Vars::getLang() == 'pt')? 'Estúdio' : 'Studio';
        }elseif($zone == 'academy'){
            $title = (Vars::getLang() == 'pt')? 'Academia' : 'Academy';
        }
        $type = $this->getType($zone);
        
        $this->set('title', $title);
        
        $args = ['post'=>['post_type' => $type, 'post_parent' => '0'], 
            'metakey'=>['date'=>null], 
            'ordermeta'=>'DESC'];
        $posts = WpQueries::getPages($args);
        $this->set('list', EditorTools::getPageData($posts));
        $this->set('zone-studio-disable', 'disabled');
    }
    
    protected function getUploadUrl($var){
        return DS . \lib\loader\BootInFolder::getFolder() . '/editor/upl' . $var.'_' . Vars::getCanonical()
                . DS . Vars::getId() . DS . '?js=1';
    }

}
