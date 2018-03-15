<?php

namespace apps\Editor\tools;

use \lib\register\Vars;
use \apps\Editor\tools\EditorTools;
use \apps\Editor\tools\Tools;

/**
 * Description of ShopTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 20, 2017
 */
class ShopTools {

    public static function getShopData($posts = [], $id = null){
        $data = [];
        $i = 0;
        foreach($posts as $post){
            
            $data[$i]['id'] = $post->ID;
            $data[$i]['data-id'] = $post->ID;
            $data[$i]['title'] = str_replace('<br/>', '', $post->post_title);
            //$data[$i]['title'] = htmlentities($post->post_title);
            $data[$i]['text'] = $post->post_content;
            $data[$i]['status'] = $post->post_status;
            $data[$i]['permalink'] = get_the_permalink($post->ID);
            $src = wp_get_attachment_url(get_post_thumbnail_id($post));
            $data[$i]['src'] = $src;
            $data[$i]['image'] = '<img src="' . $src . '" />';
            $value = get_post_meta($post->ID, 'date', true);
            $data[$i]['date'] = substr($value, -2) . '/' . substr($value, 4, 2) . '/' . substr($value, 0, 4);
            $data[$i]['active'] = ($i == 0 && $id == null)? 'active' : '';
            if($id == $data[$i]['id']){
                $data[$i]['active'] = 'active';
            }

            $data[$i]['num'] = $i;
            
            $meta = get_post_meta($post->ID);
            $data[$i]['category'] = $meta['category'][0];
            $data[$i]['space-number'] = $meta['space-number'][0];
            $data[$i]['pop-excerpt'] = Tools::getPopularExcerpt1024($post->post_content);
            
            $data[$i]['disable'] = 'disabled';
            
            
            $i++;
        }
        
        return $data;
    }

}
