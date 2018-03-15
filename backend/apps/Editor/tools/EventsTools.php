<?php

namespace apps\Editor\tools;

use \lib\register\Vars;
use \apps\Editor\tools\EditorTools;

/**
 * Description of EventsTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 13, 2017
 */
class EventsTools {

    public static function getEventData($posts = [], $zone = null, $id = null){
        $data = [];
        $i = 0;
        foreach($posts as $post){
            
            $data[$i]['id'] = $post->ID;
            $data[$i]['data-id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
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
            $data[$i]['duration'] = $meta['duration'][0];
            $data[$i]['hour'] = $meta['hour'][0];
            $data[$i]['price'] = $meta['price'][0];
            
            $data[$i]['expire'] = date('Y-m-d', $meta['_expiration-date'][0]);
            
            $data[$i]['tickets'] = get_field('link', $post->ID);
            $data[$i]['color'] = get_field('color', $post->ID);
            
            $data[$i]['zone'] = $zone;
            $data[$i]['disable'] = 'disabled';
            
            
            $i++;
        }
        
        return $data;
    }
    
    public static function saveCalendar(){
        $id = Vars::getId();
        
        EditorTools::updateMeta($id, 'category', 'post-category');
        EditorTools::updateMeta($id, 'hour', 'post-hour');
        EditorTools::updateMeta($id, 'duration', 'post-duration');
        EditorTools::updateMeta($id, 'price', 'post-price');
        EditorTools::updateMeta($id, 'link', 'post-tickets');
        EditorTools::updateMeta($id, 'color', 'post-color');
        
        //string(19) "2016-10-23 00:00:00" -> 20161023 -> 23/10
        $date = str_replace('-', '', Vars::getPosts('post-date'));
        $value = substr($date, 0, 8);
        $date = substr($value, -2) . '/' . substr($value, 4, 2);
        update_post_meta($id, 'date', $value);
        EditorTools::saveExpire();
        
        
    }

}
