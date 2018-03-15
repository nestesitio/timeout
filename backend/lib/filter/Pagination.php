<?php

namespace lib\filter;

use \lib\register\Vars as Vars;
use \lib\filter\SessionFilter as SessionFilter;

/**
 * Description of Pagination
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Feb 2, 2015
 */
class Pagination
{
    /**
     * Pagination constructor.
     */
    private function __construct() {}

    /**
     *
     */
    const PAGINATION = 25;
    /**
     *
     */
    const MAX_LI = 6;

    /**
     * @param int $total_rows
     * @return array
     */
    public static function renderPagination($total_rows)
    {
        $pages = [];
        $action = Vars::getCanonical();
        $index = SessionFilter::getControllerPaging($action);

        $total_pages = 0;
        $pagination = (SessionFilter::getControllerLimit($action) != false)? SessionFilter::getControllerLimit($action): Pagination::PAGINATION;

        if ($total_rows > 0 && $pagination < $total_rows) {
            $total_pages = ceil($total_rows / $pagination);
            $maxpages = $total_pages;

            $start = 1;
            if ($total_pages > Pagination::MAX_LI) {
                $maxpages = Pagination::MAX_LI;
                $ini = $index - floor($maxpages / 2);
                if ($ini > 1) {
                    $start = $ini;
                }
            }

            $i = 0;
            if ($start > 1) {
                $pages[$i++] = self::getFast($action, 'page-first', '1 <', 1);
                $pages[$i++] = self::getFast($action, 'page-pre', '<', $index - 1);
            }
            for ($p = $start; $p < ($maxpages + $start); $p++) {
                if ($p < $total_pages + 1) {
                    $pages[$i++] = self::getPage($p, $index, $action);
                }
            }
            if ($p - 1 < $total_pages) {
                $pages[$i++] = self::getFast($action, 'page-next', '>', $index + 1);
                $pages[$i++] = self::getFast($action, 'page-last', '> ' . $total_pages, $total_pages);
            }
        }
        return $pages;
    }

    /**
     * @param int $p
     * @param int $index
     * @param String $action
     *
     * @return array
     */
    private static function getPage($p, $index, $action)
    {
        $arr = [];
        $arr['class'] = ($p == $index)? 'page-number active disabled' : 'page-number';
        $arr['action'] = Vars::getApp() . '/list_' . $action;
        $arr['label'] = $p;
        $arr['id'] = $p;

        return $arr;
    }

    /**
     * @param $action
     * @param $option
     * @param $label
     * @param $id
     *
     * @return array
     */
    private static function getFast($action, $option, $label, $id)
    {
        $arr = [];
        $arr['class'] = $option;
        $arr['action'] = Vars::getApp() . '/list_' . $action;
        $arr['label'] = $label;
        $arr['id'] = $id;

        return $arr;
    }

}
