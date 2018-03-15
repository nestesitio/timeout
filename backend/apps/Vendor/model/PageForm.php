<?php

namespace apps\Vendor\model;

use \model\models\Htm;
use \model\forms\HtmForm;
use \model\models\HtmPage;
use \model\forms\HtmPageForm;

use \apps\Vendor\model\HtmPageQueries;
use \lib\register\Vars;


/**
 * Used to insert pages in CMS system
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 16, 2015
 */
class PageForm extends \lib\form\FormMerged {


    /**
     * @return PageForm
     */
    public static function initialize(){
        $form = new PageForm();
        $form->setQueue();
        return $form;
    }

    /**
     * @return $this
     */
    public function setQueue() {
        $this->queue = [Htm::TABLE, HtmPage::TABLE];
        
        $this->models[Htm::TABLE] = new Htm();
        $this->models[HtmPage::TABLE] = new HtmPage();
        
        $this->forms[Htm::TABLE] = $this->getHtmForm();
        $this->forms[HtmPage::TABLE] = HtmPageForm::initialize();
        
        $this->merge();
        #$this->setFieldLabel(Htm::TABLE, HtmPage::FIELD_LANGS_TLD, 'Idioma');
        #$this->setDefault(Htm::TABLE, Htm::HTM_STAT, 'public');
        
        return $this;
    }

    /**
     * @return HtmForm
     */
    private function getHtmForm(){
        $form = HtmForm::initialize();
        $input = $form->getHtmAppIdInput();
        $input->setModel(\model\querys\HtmAppQuery::start()->orderByName());
        $form->setHtmAppIdInput($input);
        
        
        return $form;
    }

    /**
     *
     */
    protected function customValidate() {
        $id = Vars::getId();
        if(!empty($id)){
            $tld = $this->getInputValue(HtmPage::TABLE, HtmPage::FIELD_LANGS_TLD);
            $htm = HtmPageQueries::getPageFromAnotherLang($id, $tld);
            if($htm != false){
                $id = $htm->getColumnValue(HtmPage::FIELD_HTM_ID);
            }
        }
    }
    
    
    
    
    

}
