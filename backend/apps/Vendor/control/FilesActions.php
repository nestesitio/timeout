<?php

namespace apps\Vendor\control;

use \lib\register\Vars;


use \apps\Vendor\model\FilesQuery;
use \model\models\Media;
use \model\querys\MediaQuery;
use \model\forms\MediaForm;
use \lib\session\SessionConfig;
use \lib\bkegenerator\DataConfig;
use \lib\form\widgets\FileInput;
use \apps\Vendor\tools\DataMime;

/**
 * Description of FilesActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2015-01-27 17:17
 * Updated @%$dateUpdated% *
 */
class FilesActions extends \lib\control\ControllerAdmin {

    /**
     *
     */
    public function imgFilesAction(){
        $this->setView('layout/core/list_img');

        $query = FilesQuery::get();
        /*
                ->filterByGenre(Media::GENRE_IMG)
                ->filterByPosition(Vars::getRequests('position'))
                ->filterByHtmId(Vars::getId());
         * 
         */
        \lib\session\SessionConfig::addId(Vars::getId());
        $this->listFiles($query);
        
        $this->set('data-position', Vars::getRequests('position'));
        $this->set('data-mime', DataMime::getDataMime('img'));
        
        $input = FileInput::create()->addClass('input-group-lg');
        $input->setuploadUrl('/core/bindimage_files');
        $this->set('file-input', $input->render());
        
    }
    
    /**
     *
     */
    public function bindimageFilesAction() {
        $this->layout = false;
        $this->setEmptyView();
        if(null != $_FILES){
            $arr['result'] = 'ok';
            $this->uploadFilesAction();
        }else{
            $arr['result'] = 'no files';
        }
        
        echo json_encode($arr);
    }
    
    /**
     *
     */
    public function bindFilesAction() {
        $this->setEmptyView();
        $arr = ['flag'=>'1'];
        if(null != $_FILES){
            $arr['result'] = 'ok';
        }
        
        echo json_encode($arr);
    }

    /**
     * @param $query
     */
    private function listFiles($query){
        $configs = $this->getConfigs(Vars::getPosts('position'));
        $this->set('action-remove', $configs['action-remove']);
        $this->set('data-insert', $configs['action-insert']);
        $this->set('data-id', Vars::getId());
        $this->set('data-position', Vars::getRequests('position'));
        //$results = $this->buildDataGrid('images', $query);
        $results = $this->getQueryToList($query);
        #here you can process the results
        $this->renderList($results);
        
    }

    /**
     *
     */
    public function removeimgFilesAction(){
        $this->setView('file_remove');
        $query = MediaQuery::start()->filterById(Vars::getId())->findOne();
        $result = \lib\media\UploadFile::removeFile($query->getUrl());
        if($result == true){
            $this->delFilesAction();
        }  else {
            Monitor::setUserMessages('file', 'File was not deleted...');
        }
        
        
    }

    /**
     * @param $node
     * @return array
     */
    private function getConfigs($node){
        $xml = SessionConfig::getXml();
        $configs = new DataConfig($xml);
        return $configs->getParams('configs/' . $node . '/*');
    }

    /**
     *
     */
    public function uploadFilesAction() {
        $configs = $this->getConfigs(Vars::getPosts('position'));
        var_dump(Vars::getPosts('position'));
        $this->id = SessionConfig::getId();
        $action = new \lib\media\UploadFile();
        $action->setFolder('userfiles/' . $configs['folder'] . '/');
        $action->execute($configs['width'], $configs['height']);
        $result = $action->getResult();
        if($result != false){
            $title = Vars::getPosts('title');
            $media = new Media();
            $media->setHtmId($this->id);
            $media->setGenre($configs['genre']);
            $media->setUrl($result);
            $media->setPosition(Vars::getPosts('position'));
            $media->setTitle($title);           
            $media->save();
            $name = $action->resolveName($title, $media->getId());
            $result = $action->rename($name);
            $media->setUrl($result);
            $media->save();
            echo json_encode(['url' => $result, 
                'id' => $media->getId(), 
                'action-remove' => $configs['action-remove'],
                'title' => $media->getTitle()]);
        }else{
            echo 'false';
        }
    }

    /**
     *
     */
    public function editFilesAction() {
        $query = FilesQuery::get()->filterById(Vars::getId())->findOne();
        $form = MediaForm::initialize()->setQueryValues($query);
        #more code about $form, $query, defaults and inputs    
        $this->renderForm($form, 'files');
    }



    /**
     *
     */
    public function showFilesAction(){
        $model = FilesQuery::get()->filterById(Vars::getId())->findOne();
        $this->renderValues($model, 'files');
    }

    /**
     *
     */
    public function delFilesAction() {
        $model = \model\querys\MediaQuery::start()->filterById(Vars::getId())->findOne();
        $this->deleteObject($model);
        
    }

    /**
     *
     */
    public function exportFilesAction(){
        $query = FilesQuery::get();
        $this->buildCsvExport($query);
    }

}
