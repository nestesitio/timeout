<?php

namespace apps\Vendor\control;

use \apps\Vendor\model\PagesQuery;
use \model\querys\LangsQuery;

/**
 * Description of CmsActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 23, 2016
 */
class CmsActions extends \lib\control\ControllerAdmin {

    protected $query;
    

    /**
     * @param $app_slug
     * @return \model\querys\HtmPageQuery
     */
    protected function queryPages($app_slug){
         $query = PagesQuery::getList($app_slug)
                ->setSelect('GROUP_CONCAT(DISTINCT htm_page.langs_tld ORDER BY htm_page.langs_tld DESC SEPARATOR ", ")', 'langs')
                 ->groupByHtmId();
         return $query;
    }
    
    
    /**
     * get all langs used in project
     * 
     * @return array
     */
    protected function queryLangs(){
        $results = LangsQuery::start()->find();
        $arr = [];
        foreach($results as $lang){
            $arr[$lang->getTld()] = $lang->getName();
        }
        return $arr;
    }
    
    /**
     * 
     * @param string $url The url to process media
     */
    protected function addInputMedia($url){
        $input = \lib\form\widgets\FileInput::create()->addClass('input-group-lg');
        $input->setuploadUrl($url);
        $this->set('file-input', $input->render());
    }
    
    protected function saveMedia(\lib\media\UploadFile $upload, $id = null){
        $media = ($id == null)? new \model\models\Media(): 
            \model\querys\MediaQuery::start()->filterById($id)->findOne(); 
        $media->setGenre($upload->getGenre());
        $media->setSource($upload->getResult());
        $media->save();
        return $media->getId();
    }
    
    
    public function bindImageAction($params = []) {
        $this->layout = false;
        $this->setEmptyView();
        $action = null;
        if(null != $_FILES){
            $action = new \lib\media\UploadFile();
            $action->setFolder($params['folder'] . '/');
            $action->execute($params['width'], $params['height']);
            $result = $action->getResult();
            if($result != false){
                $this->json['upload'] = 'ok';
                $this->json['result'] = $action->getResult();
            }else{
                $this->json['upload'] = 'error';
            }
        }else{
            $this->json['upload'] = 'false';
        }
        
        return $action;
    }

}
