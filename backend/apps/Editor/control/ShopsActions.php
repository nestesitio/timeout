<?php

namespace apps\Editor\control;

use \lib\register\Vars;
use \apps\Editor\tools\Tools;
use \lib\form\input\InputText;
use \lib\form\input\TextAreaInput;
use \apps\Editor\tools\EditorTools;
use \lib\form\input\SelectInput;
use \lib\form\input\FileInput;
use \lib\loader\BootInFolder;

/**
 * Description of ShopsActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 23, 2017
 */
class ShopsActions extends \apps\Editor\control\Editor {
    
    public function shopsAction(){
        $this->setView('shops/shops');
        $post = get_post(Vars::getId());
        $this->set('zone-shop-data-id', $post->ID);
        $this->set('zone-shop-disable','');
        $this->set('canonical', Vars::getCanonical());
        $this->edit($post);
    }

    public function editShopsAction(){
        $this->setView('shops/edit-shop');
        $post = get_post(Vars::getId());
        $this->set('zone-shop-data-id', $post->ID);
        $this->set('zone-shop-disable','');
        $this->set('canonical', Vars::getCanonical());
        $this->edit($post);
        
    }
    
    public function undoShopsAction(){
        $post = get_post(Vars::getId());
        $this->set('zone-shop-data-id', $post->ID);
        $this->setView('shops/shop');
        $meta = get_post_meta($post->ID);
        $this->set('zone-shop-space-number',  $meta['space-number'][0]);
        $this->set('zone-shop-title', str_replace('<br/>', '', $post->post_title));
        
        $src = wp_get_attachment_url(get_post_thumbnail_id($post));
        $this->set('zone-shop-image-filename',  strrchr($src, '/'));
        $this->set('zone-shop-image',  '<img src="' . $src . '" />');
        
        $this->set('zone-shop-pop-excerpt', Tools::getPopularExcerpt1024($post->post_content));
        $this->set('zone-shop-disable','disabled');
        $this->set('canonical', Vars::getCanonical());
    }
    
    public function saveShopsAction(){
        $post = $this->savePage('comer-e-beber', Vars::getId());
        Vars::setId($post->ID);
        
        EditorTools::updateMeta($post->ID, 'space-number', 'post-space-number');
        EditorTools::updateMeta($post->ID, 'category', 'post-category');
        EditorTools::updateMeta($post->ID, 'description', 'post-description');
        EditorTools::updateMeta($post->ID, 'content_0_title', 'post-recipe-title');
        EditorTools::updateMeta($post->ID, 'content_0_description', 'post-recipe-description');
        EditorTools::updateMeta($post->ID, 'content_0_ingredients', 'post-recipe-ingredients');
        

        $this->editShopsAction();
    }
    
    private function getIcons(){
        $arr = [];
        $arr['porco-1']="Carne Porco";
        $arr['wine-1'] = "Vinho a Copo"; 
        $arr['queque-1'] = "Sobremesa"; 
        $arr['bottle-2'] = "Garrafeira"; 
        $arr['manjerico-1'] = "Flores"; 
        $arr['pera-2'] = "Fruta"; 
        $arr['galinha-1'] = "Galinha"; 
        $arr['abobora-2'] = "Vegetais"; 
        $arr['vaca-1'] = "Carne de Vaca"; 
        $arr['icecream-1'] = "Gelados"; 
        $arr['shop'] = "Compras"; 
        $arr['panela-1'] = "Especialidade"; 
        $arr['faca-1'] = "Chef"; 
        $arr['peixe-1'] = "Peixe"; 
        return $arr;
    }
    
    private function edit($post){
        $meta = get_post_meta($post->ID);
        
        $input = InputText::create('post-space-number')->setValue($meta['space-number'][0]);
        $this->set('zone-shop-space-number', $input->parseInput());
        
        $input = SelectInput::create('post-floor')->setValue($meta['piso_value'][0])
                ->setValuesList(['0' => 'Floor 0', '1' => 'Floor 1'])->unsetMultiple();
        $this->set('zone-shop-floor', $input->parseInput(false, false));
        
        $input = SelectInput::create('post-category')->setValue($meta['category'][0])
                ->setValuesList(['eat', 'drink', 'shop']);
        $this->set('zone-shop-category', $input->parseInput());
        
        $input = InputText::create('post-title')->setValue(str_replace('<br/>', '', $post->post_title));
        $this->set('zone-shop-title',$input->parseInput());
        
        $this->set('zone-shop-image-filename',  EditorTools::setFileUploadInput($post));
        
        $input = TextAreaInput::create('post-text')->setRows(10)->setValue($post->post_content);
        $this->set('zone-shop-text', $input->parseInput());
        
        $attachment_id = get_field('image-detail', Vars::getId());
        $upload_url = DS . BootInFolder::getFolder() . '/editor/upload_' . Vars::getCanonical() . 
                DS . Vars::getId() . DS . '?js=1&field=image-detail&attach=' . $attachment_id;
        $input = FileInput::create('post-shop-image-detail')
                ->setuploadUrl($upload_url)
                ->setValue(wp_get_attachment_url($attachment_id));
        $this->set('zone-shop-image-detail', $input->parseInput());
        
        $input = SelectInput::create('post-recipe-icon')->setValue($meta['content_0_icon'][0])
                ->setValuesList($this->getIcons());
        $this->set('zone-shop-recipe-icon', $input->parseInput(false, false));
        
        $input = InputText::create('post-description')->setValue(get_post_custom_values('description', $post->ID)[0]);
        $this->set('zone-shop-description',$input->parseInput());
        
        $input = InputText::create('post-recipe-title')->setValue(get_post_custom_values('content_0_title', $post->ID)[0]);
        $this->set('zone-shop-recipe-title',$input->parseInput());
        
        $input = TextAreaInput::create('post-recipe-description')->setRows(10)->setValue(get_post_custom_values('content_0_description', $post->ID)[0]);
        $this->set('zone-shop-recipe-description', $input->parseInput());
        
        $input = TextAreaInput::create('post-recipe-ingredients')->setRows(10)->setValue(get_post_custom_values('content_0_ingredients', $post->ID)[0]);
        $this->set('zone-shop-recipe-ingredients', $input->parseInput());
        
        
        $attachment_id = get_field('content_0_image', Vars::getId());
        $upload_url = DS . BootInFolder::getFolder() . '/editor/upload_' . Vars::getCanonical() . 
                DS . Vars::getId() . DS . '?js=1&field=recipe-image&attach=' . $attachment_id;
        $input = FileInput::create('post-shop-recipe-image')
                ->setuploadUrl($upload_url)
                ->setValue(wp_get_attachment_url($attachment_id));
        $this->set('zone-shop-recipe-image', $input->parseInput());
        
        
        $this->set('zone-shop-status', $this->getStatusSelector($post->post_status));
        $this->set('zone-shop-id', $post->ID);
        $this->set('canonical', Vars::getCanonical());
        $this->set('zone-shop-disable','');
    }
    
    
    public function uploadShopsAction(){
        $this->setEmptyView();
        $field = Vars::getRequests('field');
        $attachment_id = Vars::getRequests('field');
        $params = \apps\Editor\tools\ZoneTools::getZoneImageArgs(Vars::getRequests('zone'));
        $post_var = ($field == false)? self::$post_image: 'post-shop-' . $field;
        $upload = EditorTools::processImage($post_var, $params);
        if(is_array($upload)){
            $this->json = $upload;
        }else{
            $attachment_id = EditorTools::saveImage($upload, Vars::getId(), get_post(Vars::getId())->post_title);
            if($field != false){
                $field = ($field == 'recipe-image')?'content_0_image': $field;
                update_field( $field, $attachment_id, Vars::getId());
            }else{
               set_post_thumbnail(Vars::getId(), $attachment_id); 
            }
            
            $this->json = ['upload'=>'ok', 'result'=>$attachment_id];
            EditorTools::deleteImage();
        }
        
        echo json_encode($this->json);
    }

}
