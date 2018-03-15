<?php

namespace apps\Vendor\model;

use \model\querys\MediaQuery as HtmMediaQuery;
use \model\models\HtmHasMedia;
use \apps\Vendor\model\Media;
use \lib\mysql\Mysql;

/**
 * Description of MediaQuery
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 25, 2016
 */
class MediaQuery {

    private $query;
    
    /**
     * 
     * @param int $htm
     * @return HtmMediaQuery
     */
    public static function getListForPage($htm){
        $query = HtmMediaQuery::start()
                ->joinHtmHasMedia(Mysql::LEFT_JOIN)
                ->selectHtmId()->selectOrd()
                ->orderByHtmId(Mysql::DESC)->orderByOrd()
                ->endUse()
                ->addJoinCondition(HtmHasMedia::TABLE, HtmHasMedia::FIELD_HTM_ID ,$htm);
	
        
        return $query;
    }
    
    /**
     * 
     * @param int $htm
     * @return HtmMediaQuery
     */
    public static function getMediaOfPage($htm){
        $query = HtmMediaQuery::start()
                ->joinHtmHasMedia()
                ->selectHtmId()->selectOrd()
                ->orderByHtmId(Mysql::DESC)->orderByOrd()
                ->endUse()
                ->addJoinCondition(HtmHasMedia::TABLE, HtmHasMedia::FIELD_HTM_ID ,$htm);
	
        
        return $query;
    }
    
   /**
    * 
    * @return \apps\Vendor\model\MediaQuery
    */
    public static function startQuery(){
        $obj = new MediaQuery();
        return $obj;
    }
    
    function __construct() {
        $this->query = HtmMediaQuery::start()->groupById();
        $this->query->joinHtmHasMedia(Mysql::LEFT_JOIN)
                ->selectOrd()->selectHtmId()
                ->endUse();
    }
    
    /**
     * 
     * @param integer $id
     * @return \apps\Vendor\model\MediaQuery
     */
    public function filterById($id){
        $this->query->filterById($id);
        return $this;
    }
    
    
    /**
     * 
     * @param string $genre
     * @return \apps\Vendor\model\MediaQuery
     */
    public function filterByGenre($genre){
        $this->query->filterByGenre($genre);
        return $this;
    }
    
    /**
     * 
     * @return \apps\Vendor\model\Media[]
     */
    public function getMedias(){
        $objects = [];
        $results = $this->query->find();
        foreach($results as $result){
            $objects[] = Media::initialize($result);
        }
        return $objects;
    }
    
    /**
     * 
     * @return \apps\Vendor\model\Media
     */
    public function getMedia(){
        $result = $this->query->findOne();
        return Media::initialize($result);
    }

}
