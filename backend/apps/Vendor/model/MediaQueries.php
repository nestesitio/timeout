<?php

namespace apps\Vendor\model;

use \model\querys\MediaQuery;
use \model\models\Media;
use \model\models\MediaInfo;
use \model\models\MediaCollection;
use \lib\mysql\Mysql;

/**
 * Description of MediaQueries
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 27, 2016
 */
class MediaQueries {
    
    private $query = null;
    
    public static function starQuery(){
        $query = new MediaQueries();
        return $query;
    }
    

    public static function getMediasByGenre($genre){
        $query = new MediaQueries();
        return $query->filterByGenre($genre);
        
    }
    
    /**
     * 
     * @return \apps\Vendor\model\MediaQueries
     */
    public static function getBanners($lang = null){
        $query = new MediaQueries();
        if(null != $lang){
            $query->filterBylang($lang);
        }
        $query->filterByGenre(Media::GENRE_BANNER);
        return $query;
        
    }
    
    function __construct() {
        $this->query = MediaQuery::start();
        $this->query->joinMediaInfo(Mysql::LEFT_JOIN)
                ->selectTitle()->selectAuthor()->selectSummary()->selectLangsTld()
                ->joinMediaCollection(Mysql::LEFT_JOIN)->selectSlug()->endUse()
                ->endUse();
        return $this;
    }
    
    /**
     * 
     * @param string $value
     * @return \apps\Vendor\model\MediaQueries
     */
    public function filterByGenre($value){
        $this->query->filterByGenre($value);
        return $this;
    }
    
    /**
     * 
     * @param int $id
     * @return \apps\Vendor\model\MediaQueries
     */
    public function filterByMediaInfo($id){
        $this->query->filterByColumn(MediaInfo::FIELD_ID, $id);
        return $this;
    }
    
    public function filterByMediaCollectionSlug($value){
        $this->query->filterByColumn(MediaCollection::FIELD_SLUG, $value);
        return $this;
    }
    
    public function filterBylang($value){
        $this->query->filterByColumn(MediaInfo::FIELD_LANGS_TLD, $value);
        return $this;
    }
    
    public function filterByPage($id){
        $this->query->joinHtmHasMedia()->filterByHtmId($id)->endUse();
        return $this;
    }
    
    /**
     * 
     * @return \model\models\Media[]
     */
    public function get(){
        $results = $this->query->find();
        //echo ($this->query->toString());

        return $results;
    }
    
    /**
     * 
     * @return \model\models\Media
     */
    public function getOne(){
        $result = $this->query->findOne();
        //echo ($this->query->toString());

        return $result;
    }
    
    /**
    * Create and return query
    *
    * @return \model\querys\MediaInfoQuery;
    */
    public static function getSliders($slug){
        $query = \model\querys\MediaInfoQuery::start();
	$query->joinMediaCollection()->filterBySlug($slug)->selectId()->selectSlug()->selectName()->endUse();
	$query->joinMedia(Mysql::LEFT_JOIN)->selectId()->selectGenre()->selectLink()->selectDate()->selectCreated()->endUse();
	
        
        return $query;
    }

}
