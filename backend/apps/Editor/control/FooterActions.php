<?php

namespace apps\Editor\control;

use \apps\Editor\tools\EditorTools;
use \lib\register\Vars;
use \lib\form\input\InputText;
/*
use \apps\Editor\tools\WpQueries;

 * 
 */

/**
 * Description of FooterActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 19, 2016
 */
class FooterActions extends \apps\Editor\control\Editor {
    
    private function getPage(){
        $post = get_page_by_path('footer');
        if (null == $post) {
            $post = ['post_title' => 'Footer', 'post_name' => 'footer', 'post_type' => 'page', 'post_status' => 'publish'];
            
            $id = wp_insert_post($post, true);
            \apps\Editor\tools\WpPost::translatePage('page', $id);
            $post = get_post($id);
        }
        return $post;
    }
    
    private function process($tag){
        $value = $this->getJEditableValue();
        $post = $this->getPage();
        EditorTools::updateMetaValue($post->ID, $tag, $value);
        echo nl2br($value);
    }

    public function addressFooterAction(){
        $this->process('address');
    }
    
    public function telFooterAction(){
        $this->process('tel');
    }
    
    public function emailFooterAction(){
        $this->process('email');
    }
    
    public function copyFooterAction(){
        $this->process('copy');
    }
    
    public function socialFooterAction(){
        $this->setView('footer-social');
        $social = Vars::getRequests('social');
        $this->set('icon', 'icon icon-' . $social);
        $this->set('social', $social);
        $post = $this->getPage();
        $input = InputText::create('post-social-link')->setValue(get_field('link-' . $social, $post->ID));
        $this->set('input-link',$input->parseInput());
    }
    
    public function updatesocialFooterAction(){
        $social = Vars::getRequests('social');
        $post = $this->getPage();
        $value = Vars::getPosts('post-social-link');
        if(strpos($value, $social)){
            EditorTools::updateMetaValue($post->ID, 'link-' . $social, $value);
        }else{
            $this->set('warnings', 'Data is not valid');
        }
        
        $this->socialFooterAction();
    }
    
    
    
    

}
