<?php

namespace lib\url;

use \apps\Vendor\model\HtmPageQueries;
use \lib\url\UrlHref;

/**
 * Description of Redirect
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Apr 8, 2015
 */
class Redirect
{
    /**
     * @param $url
     */
    public static function redirectToUrl($url)
    {
        header('Location:' . $url);
    }

    /**
     * @param $id
     */
    public static function redirectByPageNumber($id)
    {
        $page = HtmPageQueries::getPageById($id);
        if ($page != false) {
            $url = UrlHref::renderUrl(['app' => $page->getHtm()->getHtmApp()->getSlug(), 'canonical' => $page->getSlug()]);
            header('Location:' . $url);
        } else {
            header('Location: /');
        }
    }

    /**
     * @param string $url
     */
    public static function redirectByRoute($url)
    {
        if($url == false){
            $url = '/';
        }
        header('Location:' . $url);
    }

    /**
     *
     */
    public static function redirectHome()
    {
        header('Location: /');
    }

    /**
     *
     */
    public static function redirectLogin()
    {
        $url = UrlHref::renderUrl(['app' => 'user', 'canonical' => 'login']);
        header('Location:' . $url);
    }

}
