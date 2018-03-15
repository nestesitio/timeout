<?php

namespace apps\Vendor\model;

use \model\querys\MediaQuery;
use \lib\mysql\Mysql;


/**
 * Description of FilesQuery
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2015-01-27 17:17
 * Updated @%$dateUpdated% *
 */
class FilesQuery extends \model\querys\MediaQuery {

    /**
    * Create and return the common query to this class
    *
    * @return \model\querys\MediaQuery;
    */
    public static function get(){
        $query = MediaQuery::start()
                ->joinHtmHasMedia(Mysql::LEFT_JOIN)->selectHtmId()->selectOrd()->endUse();
	
        
        return $query;
    }

    

}
