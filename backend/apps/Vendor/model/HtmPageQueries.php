<?php

namespace apps\Vendor\model;

use \lib\mysql\Mysql;
use \lib\session\SessionUser;
use \lib\lang\Language;
use \model\models\Htm;

/**
 * Description of HtmPageQueries
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 17, 2016
 */
class HtmPageQueries extends \model\querys\HtmPageQuery {

    /**
     * used in DBRouting
     * @param string $htmapp
     * @param string $canonical
     * 
     * @return \model\models\HtmPage
     */
    public static function getPageRoute($htmapp, $canonical){
        $result = self::start()
                ->joinHtm()->selectController()->joinHtmApp()->filterBySlug($htmapp)->joinUserGroupHasHtmApp()->joinUserGroup()
                ->joinUserBase()->filterById(SessionUser::getPlayer())->endUse()->endUse()->endUse()->endUse()->endUse()
                ->filterBySlug($canonical)->findOne();
        //filterById(SELECT hp.id FROM htm_page hp WHERE hp.htm_id=ht_page.htm_id ORDER BY CASE WHEN hp.langs_tld = '".Regist::vars('lg')."' THEN 1 WHEN hp.langs_tld = '".Regist::vars('lgInt')."' THEN 2 WHEN hp.langs_tld = '".Regist::vars('lgDef')."' THEN 3 END LIMIT 1))
        return $result;
    }

    /**
     * used in DBRouting
     * @param string $htmapp
     * @param string $canonical
     * 
     * @return \model\models\HtmPage
     */
    public static function getPageExists($htmapp, $canonical){
        $result = self::start()
                ->joinHtm()->joinHtmApp()->filterBySlug($htmapp)->endUse()->endUse()
                ->filterBySlug($canonical)->findOne();
        //filterById(SELECT hp.id FROM htm_page hp WHERE hp.htm_id=ht_page.htm_id ORDER BY CASE WHEN hp.langs_tld = '".Regist::vars('lg')."' THEN 1 WHEN hp.langs_tld = '".Regist::vars('lgInt')."' THEN 2 WHEN hp.langs_tld = '".Regist::vars('lgDef')."' THEN 3 END LIMIT 1))
        return $result;
    }
    
    /**
     * Completes query and return a collection of HtmPage objects
     * used by BackendMenuActions
     *
     * @return \model\querys\HtmPageQuery
     */
    public static function getBackendPages(){
        return self::start()->joinHtm()->filterByStat(Htm::STAT_BACKEND)->filterByOrd(0, Mysql::ALT_NOT_EQUAL)->orderByOrd()
                ->joinHtmApp()->selectSlug()
                ->joinUserGroupHasHtmApp()->joinUserGroup()
                ->joinUserBase()->filterById(SessionUser::getPlayer())->endUse()
                ->endUse()->endUse()->endUse()->endUse()
                ->orderByTitle();
        //filterById(SELECT hp.id FROM htm_page hp WHERE hp.htm_id=ht_page.htm_id ORDER BY CASE WHEN hp.langs_tld = '".Regist::vars('lg')."' THEN 1 WHEN hp.langs_tld = '".Regist::vars('lgInt')."' THEN 2 WHEN hp.langs_tld = '".Regist::vars('lgDef')."' THEN 3 END LIMIT 1))
    }
    
    /**
     * 
     * @return \model\querys\HtmPageQuery
     */
    public static function getFrontendMenus($var){
        return self::start()->filterByLangsTld(Language::getLang())
                ->joinHtm()
                ->joinHtmHasVars()->joinHtmVars()->selectValue()->filterByVar($var)->endUse()->endUse()
                ->filterByStat(Htm::STAT_PUBLIC)->filterByOrd(0, Mysql::ALT_NOT_EQUAL)
                ->orderByOrd()
                ->joinHtmApp()->selectSlug()->filterBySlug('home')
                ->endUse()->endUse();
                
    }
    


    /**
     * used by lib\url\Redirect
     * @param int $id
     * @return \model\models\HtmPage
     */
    public static function getPageById($id){
        return self::start()
                ->joinHtm()->joinHtmApp()->selectSlug()->endUse()->endUse()
                ->filterByHtmId($id)->findOne();
    }


    /**
     * used by apps\Vendor\model\PageForm
     * @param int $id
     * @param string $tld
     * @return \model\models\HtmPage
     */
    public static function getPageFromAnotherLang($id, $tld){
        return self::start()
                ->joinHtm()->joinHtmApp()->selectSlug()->endUse()->endUse()
                ->filterByHtmId($id)->filterByLangsTld($tld, Mysql::NOT_EQUAL)->findOne();
    }

}
