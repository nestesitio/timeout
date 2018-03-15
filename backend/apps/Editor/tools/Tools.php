<?php

namespace apps\Editor\tools;

/**
 * Description of Tools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 20, 2017
 */
class Tools {

    public static function getPopularExcerpt1024($content) {
        $excerpt = $content;
        $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);
        $excerpt = substr($excerpt, 0, 120);
        $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
        $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
        $excerpt = $excerpt . ' [...]';
        return $excerpt;
    }

}
