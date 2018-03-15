<?php

namespace apps\Vendor\model;

use \model\models\HtmHasVars;
use \model\forms\HtmHasVarsForm;
use \model\models\HtmVars;
use \model\models\Htm;
use \model\models\HtmTxt;


use \lib\form\input\HiddenInput;

/**
 * Description of CmsForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Sep 30, 2016
 */
class CmsForm extends \lib\form\FormMerged {
    
    protected $app;
    
    /**
     * @return \model\forms\HtmForm
     */
    protected function declareHtmForm(){
        $form = \model\forms\HtmForm::initialize();
        $query = \model\querys\HtmAppQuery::start(ONLY)->filterBySlug($this->app)->findOne();
        $input = HiddenInput::create(Htm::FIELD_HTM_APP_ID)->setValue($query->getId());
        $form->setHtmAppIdInput($input);
        
        $input = $form->getStatInput();
        $input->setValuesList([Htm::STAT_PUBLIC, Htm::STAT_PRIVATE])->setValue(Htm::STAT_PUBLIC);
        $form->setStatInput($input);
        $form->setOrdInput()->setDefault(1);
        
        return $form;
    }
    
    
    /**
     * 
     * @return \model\forms\HtmForm
     */
    public function getHtmForm(){
        return $this->forms[Htm::TABLE];
    }

     /**
      * 
      * @param string $var
      * @return \apps\Vendor\model\HtmForm
      */
    public function addHtmVars($var){
        $this->queue[] = HtmVars::TABLE;
        $this->queue[] = HtmHasVars::TABLE;
        
        $this->models[HtmVars::TABLE] = new HtmVars();
        $this->forms[HtmVars::TABLE] = $this->declareHtmVarsForm($var);
        
        $this->models[HtmHasVars::TABLE] = new HtmHasVars();
        $this->forms[HtmHasVars::TABLE] = $this->declareHtmHasVarsForm();
        
        $this->merge();
        return $this;
    }
    
    /**
     * @param string $var
     * 
     * @return \model\forms\HtmVarsForm
     */
    private function declareHtmVarsForm($var){
        $form = \model\forms\HtmVarsForm::initialize();
        
        $input = HiddenInput::create()->setValue($var);
        $form->setVarInput($input);
        
        return $form;
    }
    
    
    /**
     * 
     * @return \model\forms\HtmHasVarsForm
     */
    private function declareHtmHasVarsForm(){
        $form = HtmHasVarsForm::initialize();
        $input = HiddenInput::create()->setDefault(0);
	$form->setHtmIdInput($input);
        $input = HiddenInput::create()->setDefault(0);
        $form->setHtmVarsIdInput($input);
        return $form;
    }
    
    
    /**
     * 
     * @return HtmHasVarsForm
     */
    public function getHtmHasVarsForm(){
        return $this->forms[HtmHasVars::TABLE];
    }
    
    
    protected function repostWysihtmlValue(){
        $value = $this->getTxtForm()->getTxtInput()->getHtmlValue(); 
        
        $this->rePostValue(HtmTxt::TABLE, HtmTxt::FIELD_TXT, $value);
    }

}
