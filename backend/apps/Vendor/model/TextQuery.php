<?php

namespace apps\Vendor\model;

use \model\querys\HtmTxtQuery;

/**
 * Description of TextQuery
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2015-01-27 17:17
 * Updated @%$dateUpdated% *
 */
class TextQuery extends \model\querys\HtmTxtQuery {

    /**
    * Create and return the common query to this class
    *
    * @return \model\querys\HtmTxtQuery;
    */
    public static function get(){
        $query = HtmTxtQuery::start();
        $query->joinHtmPage()->selectId()->selectHtmId()->selectLangsTld()->selectHtmLayoutId()->selectTitle()->selectSlug()->selectMenu()->selectHeading()->selectUpdatedAt()->endUse();
	
        
        return $query;
    }

    

}
