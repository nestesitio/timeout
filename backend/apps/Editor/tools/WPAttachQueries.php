<?php

namespace apps\Editor\tools;


/**
 * Description of WPAttachQueries
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Dec 20, 2016
 */
class WPAttachQueries extends \apps\Editor\tools\WpQueries {

    public static function getImagesForPost($post_id, $limit = null){
        $attachments = [];
        
        $args['post'] = ['post_type'=>'attachment', 'post_mime_type'=>'image/jpeg', 'post_parent'=>$post_id];
        $args['metakey'] = ['_wp_attached_file'=>null];
        if($limit != null){
            $args['limit'] = $limit;
        }
        
        $pageposts = self::query($args, false);
        
        if(null != $pageposts){
            foreach ($pageposts as $post) {
                $attachments[] = get_post($post->ID);
            }
        }
        return $attachments;
    }

}
