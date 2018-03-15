<?php

namespace apps\Vendor\model;

use \model\models\Htm;
use \model\forms\HtmHasVarsForm;
use \lib\form\input\HiddenInput;


/**
 * Description of HtmForm
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @2015-01-27 17:17
 * Updated @%$dateUpdated% *
 */
class HtmForm extends \apps\Vendor\model\CmsForm {
    

    /**
    * Create and return the common query to this class
    *
    * @return \apps\Vendor\model\HtmForm;
    */
    public static function initialize($app){
        $form = new HtmForm();
        $form->setQueue($app);
        return $form;
    }
    
    public function setQueue($app) {
        $this->app = $app;
        
        $this->queue = [Htm::TABLE];
        
        $this->models[Htm::TABLE] = new Htm();
        
        
        $this->forms[Htm::TABLE] = $this->declareHtmForm();
        
        $this->merge();
        
        return $this;
    }
    
    
    
    /**
     * 
     * @param string $controller
     * @return \apps\Vendor\model\PageTextForm
     */
    public function setHtmController($controller){
        $form = $this->getHtmForm();
        $input = HiddenInput::create()->setValue($controller);
        $form->setControllerInput($input);
        $this->forms[Htm::TABLE] = $form;
        $this->merge();
        return $this;
    }
    
    
    /**
     * 
     * @return HtmHasVarsForm
     */
    public function getHtmHasVarsForm(){
        return $this->forms[HtmHasVars::TABLE];
    }
    
    /**
    * Set some defaults on the new form
    *
    * @return \apps\Vendor\model\HtmForm;
    */
    public function setSomeDefaults(){
        $form = $this->getHtmForm();
        
        return $this;
    }

    protected function customValidate() {
        
    }
    
    /**
    * Create and return the common query to this class
    *
    * @return \apps\Vendor\model\HtmForm;
    */
    public function validate(){
        parent::validate();
        return $this;
    }

}
