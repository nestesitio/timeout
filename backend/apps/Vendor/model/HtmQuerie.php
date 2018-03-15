<?php

namespace apps\Vendor\model;

use \model\querys\HtmQuery;
use \model\models\HtmPage;
use \model\models\HtmApp;
use \apps\Vendor\model\Page;
use \lib\mysql\Mysql;

/**
 * Description of HtmQuery
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 17, 2016
 */
class HtmQuerie {

    private $query;
    
   /**
    * 
    * @return \apps\Vendor\model\HtmQuery
    */
    public static function startQuery(){
        $obj = new HtmQuerie();
        return $obj;
    }
    
    function __construct() {
        $this->query = HtmQuery::start(ONLY)->selectStat()->selectOrd()->groupById();
        $this->query->joinHtmApp()->selectName()->selectSlug()->endUse();
        $this->query->joinHtmPage()->endUse();
    }
    
    public function getMedia($genre){
        $this->query->joinHtmHasMedia(Mysql::LEFT_JOIN)
                    ->joinMedia(Mysql::LEFT_JOIN)->filterByGenre($genre)
                    ->selectSource()->selectLink()
                    ->endUse()
                ->endUse();

        return $this;
    }
    
    /**
     * 
     * @param string $app
     * @param string $slug
     * 
     * @return \apps\Vendor\model\HtmQuery
     */
    public function filterBySlug($app, $slug){
        $this->query->filterByColumn(HtmApp::FIELD_SLUG, $app);
        $this->query->filterByColumn(HtmPage::FIELD_SLUG, $slug);
        return $this;
    }
    
    /**
     * 
     * @param string $lang
     * @return \apps\Vendor\model\HtmQuerie
     */
    public function filterByLang($lang){
        $this->query->filterByColumn(HtmPage::FIELD_LANGS_TLD, $lang);
        return $this;
    }
    
    /**
     * 
     * @param string $value
     * @return \apps\Vendor\model\HtmQuery
     */
    public function filterByApp($value){
        $this->query->filterByColumn(HtmApp::FIELD_SLUG, $value);
        return $this;
    }
    
    
    /**
     * 
     * @param integer $id
     * @return \apps\Vendor\model\HtmQuery
     */
    public function filterById($id){
        $this->query->filterById($id);
        return $this;
    }
    
    /**
     * 
     * @param string $var
     * @param string $value
     * @return \apps\Vendor\model\HtmQuerie
     */
    public function filterByVar($var, $value){
        $this->query->joinHtmHasVars()
                ->joinHtmVars()->filterByVar($var)->filterByValue($value)->endUse()
                ->endUse();
        return $this;
    }
    
    /**
     * 
     * @param string $var
     * @return \apps\Vendor\model\HtmQuerie
     */
    public function joinVars($var){
        $this->query->joinHtmHasVars(Mysql::LEFT_JOIN)
                ->joinHtmVars(Mysql::LEFT_JOIN)->filterByVar($var)->selectValue()->endUse()
                ->endUse();
        return $this;
    }


    /**
     * 
     * @return \apps\Vendor\model\HtmQuerie
     */
    public function orderByOrd(){
        $this->query->orderByOrd();
        return $this;
    }


    /**
     * 
     * @return \apps\Vendor\model\Page[]
     */
    public function getPages(){
        $pages = [];
        $results = $this->query->find();
        if ($results != false) {
            foreach ($results as $result) {
                $pages[] = Page::initialize($result);
            }
        }
        return $pages;
    }
    
    /**
     * 
     * @return \apps\Vendor\model\Page
     */
    public function getPage(){
        $result = $this->query->findOne();
        if($result == false){
            echo ($this->query->toString());
        }else{
            return Page::initialize($result);
        }
        
    }
    
    public function toString(){
        return $this->query->toString();
    }

}
