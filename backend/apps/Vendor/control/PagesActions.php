<?php

namespace apps\Vendor\control;

use \lib\register\Vars;

use \apps\Vendor\model\PagesQuery;
use \model\forms\HtmPageForm;
use \apps\Vendor\model\PageTextForm;
use \apps\Vendor\tools\LangsRowTools;
use \apps\Vendor\model\TxtForm;
use \model\models\HtmPage;
use \lib\form\input\WysihtmlInput;

/**
 * Description of PagesActions
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2015-01-27 17:17
 * Updated @%$dateUpdated% *
 */
class PagesActions extends \apps\Vendor\control\CmsActions {
    
    



    /** 
     * 
     * @param string $xml_file
     * @param boolean $filter
     */
    protected function mainAction($xml_file, $filter = true){
        $this->setView('layout/core/datagrid-cms.htm');
        $langs = $this->queryLangs();
        
        $results = $this->buildDataGrid($xml_file, $this->query);
        
        $this->set('langs', LangsRowTools::renderLangsTemplate($langs, $this->txt_action));
        
        #here you can process the results
        $results = LangsRowTools::renderLangTools($results, $langs, $this->txt_action);
        $this->renderList($results);
        
        if($filter == true){
            $form = HtmPageForm::initialize()->prepareFilters();
            $this->renderFilters($form, $xml_file);
        }
        
    }


    /**
     * @param $app_slug
     * @param $xml_file
     */
    protected function listAction($xml_file){
        
        $results = $this->buildDataList($xml_file, $this->query);
        #here you can process the results
        $langs = $this->queryLangs();
        $results = LangsRowTools::renderLangTools($results, $langs, $this->txt_action);
        $this->renderList($results);
    }
    
    /**
     * 
     * @return \apps\Vendor\model\TxtForm
     */
    protected function geTxtForm($toolbar = WysihtmlInput::TOOLBAR_DEFAULT){
        return TxtForm::init(Vars::getId(), Vars::getRequests('lang'))
                ->setToolbar($toolbar);
    }
    
    /**
     * 
     * @param \apps\Vendor\model\TxtForm $form
     * @param string $xml_file
     */
    protected function txtAction($form, $xml_file = null){
        
        if($xml_file == null){
            $xml_file = 'apps/Vendor/config/txt';
        }
        
        $this->setView('apps/Vendor/view/edit_text');
        $query = PagesQuery::getLangs(Vars::getId())->find();
        
        
        $this->renderLangActions($query, Vars::getId(), $this->txt_action, Vars::getRequests('lang'));
        
        $page = PagesQuery::getPageByLang(Vars::getId(), Vars::getRequests('lang'))->findOne();
        if($page == false){
            $page = PagesQuery::getPageByLang(Vars::getId())->findOne();
            if($page != false){
                $form = $form->duplicate($page, Vars::getRequests('lang'));
            }
        }else{
            $form->setQueryValues($page);
        }
        
        $action = str_replace($this->app . '/', '', $this->bindtxt_action);
        
        $this->renderForm($form, $xml_file, $action, ['lang'=>Vars::getRequests('lang')]);
    }
    
    
    /**
     * 
     * @param \apps\Vendor\model\TxtForm $form
     * @param string $xml_file
     */
    public function bindTxtAction($form, $xml_file = null) {
        if($xml_file == null){
            $xml_file = 'apps/Vendor/config/txt';
        }
        
        $model = $this->buildProcess($form, $xml_file);
        if($model !== false){
            #$result is a model
            
            Vars::setId($model->getHtmId());
            $this->showTxtAction($xml_file);
        }
    }
    
    public function showTxtAction($xml_file){
        $this->setView('apps/Vendor/view/show_text');
        
        $query = PagesQuery::getLangs(Vars::getId())->find();
        
        $this->renderLangActions($query, Vars::getId(), $this->txt_action, Vars::getRequests('lang'));
        $this->set('datalang', Vars::getRequests('lang'));
        $model = PagesQuery::getPageByLang(Vars::getId(), Vars::getRequests('lang'))->findOne();
        $this->renderValues($model, $xml_file);
    }


    /**
     *
     */
    public function editPagesAction() {
        $query = PagesQuery::getList()->filterById(Vars::getId())->findOne();
        $form = PageTextForm::init('home')->setQueryValues($query);
        #more code about $form, $query, defaults and inputs    
        $this->renderForm($form, 'pages');
    }


    /**
     *
     */
    public function newPagesAction() {
        $form = HtmPageForm::initialize();
        #more code about $form and $query
        $this->renderForm($form, 'pages');
    }

    /**
     *
     */
    public function bindPagesAction() {
        $form = HtmPageForm::initialize()->validate();
        #more code for processing - example
        #$model = $form->getModels('table')->setColumnValue('field','value');
        #$form->setModel('table', $model);
        $model = $this->buildProcess($form, 'pages');
        if($model !== false){
            #$result is a model
            if($model->getAction() == HtmPage::ACTION_INSERT){
                #operations after inserted
                
            }elseif($model->getAction() == HtmPage::ACTION_UPDATE){
                 #operations after updated
                
            }
            
            $this->showPagesAction();
        }
    }

    /**
     *
     */
    public function showPagesAction(){
        $model = PagesQuery::getList()->filterById(Vars::getId())->findOne();
        $this->renderValues($model, 'pages');
    }

    /**
     *
     */
    public function delPagesAction() {
        $model = \model\querys\HtmPageQuery::start()->filterById(Vars::getId())->findOne();
        $this->deleteObject($model);
        
    }

    /**
     *
     */
    public function exportPagesAction(){
        $query = PagesQuery::getList();
        $this->buildCsvExport($query);
    }
    
    protected function listMediaActions($query, $action){
        $this->setView('layout/core/list_img');
        
        \lib\session\SessionConfig::addId(Vars::getId());
        $results = $this->getQueryToList($query);
        foreach($results as $media){
            $htm = $media->getHtmHasMedia()->getHtmId();
            $value = ($htm == NULL)? '' : 'media-choice';
            $media->setColumnValue('choice', $value);
        }
        #here you can process the results
        $this->renderList($results);
        $this->set('data-choice-action', $action);
        $this->set('htm-id', Vars::getId());
        
    }
    
    public function choiceMedia($htm = null, $media = null){
        if(null == $htm){
            $htm = Vars::getPosts('htm');
        }
        if(null == $media){
            $media = Vars::getPosts('media');
        }
        return \model\querys\HtmHasMediaQuery::start()
                ->filterByHtmId($htm)
                ->filterByMediaId($media)
                ->toogleOne();
    }
    
    
    
    public function choiceMediaAction($htm = null, $media = null){
        $this->layout = false;
        $this->setEmptyView();
        
        $result = $this->choiceMedia($htm, $media);
        
        if(null != $result){
            echo true;
        }
        
    }
    

}
