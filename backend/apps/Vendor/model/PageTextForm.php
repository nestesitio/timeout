<?php
namespace apps\Vendor\model;

use \lib\register\Vars;
use \model\models\Htm;
use \model\models\HtmPage;
use \lib\form\input\HiddenInput;
use \lib\form\form\FormRender;

#use \lib\register\Vars;

/**
 * Used to edit pages in CMS system,
 * contains rich text editor
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 24, 2015
 */
class PageTextForm extends \apps\Vendor\model\CmsForm {


    /**
     * @param $app
     * @return PageTextForm
     */
    public static function initialize($app) {
        $form = new PageTextForm();
        $form->declaration($app);
        
        return $form;
    }

    /**
     * @param $app
     * @return $this
     */
    public function declaration($app) {
        $this->app = $app;
        
        $this->queue = [Htm::TABLE, HtmPage::TABLE];
        
        $this->models[Htm::TABLE] = new Htm();
        $this->models[HtmPage::TABLE] = new HtmPage();
        
        $this->forms[Htm::TABLE] = $this->declareHtmForm();
        $this->forms[HtmPage::TABLE] = $this->declareHtmPageForm();
	
        $this->merge();
        
        return $this;
    }
    

    /**
     * @return \model\forms\HtmPageForm
     */
    private function declareHtmPageForm(){
        $form = \model\forms\HtmPageForm::initialize();
        $input = HiddenInput::create(HtmPage::FIELD_HTM_ID)->setDefault(0);
	$form->setHtmIdInput($input);
        $input = HiddenInput::create(HtmPage::FIELD_SLUG)->setValue('index');
	$form->setSlugInput($input);
       $input = $form->getTitleInput()
                ->setDataAttribute('data-function', 'exportValue')
                ->setDataAttribute('data-export', FormRender::renderName(HtmPage::FIELD_MENU, Vars::getCanonical()));
       $form->setTitleInput($input);
       
       $input = $form->getMenuInput()
                ->setDataAttribute('data-function', 'exportValue')
                ->setDataAttribute('data-export', FormRender::renderName(HtmPage::FIELD_HEADING, Vars::getCanonical()));
       $form->setMenuInput($input);  
       
       $input = $form->getHeadingInput()
                ->setDataAttribute('data-function', 'exportValue')
                ->setDataAttribute('data-export', FormRender::renderName(HtmPage::FIELD_TITLE, Vars::getCanonical()));
       $form->setHeadingInput($input);             
        
        return $form;
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
     * @return \model\forms\HtmPageForm
     */
    public function getHtmPageForm(){
        return $this->forms[HtmPage::TABLE];
    }
    
    

    /**
     *
     */
    protected function customValidate() {
        $title = $this->getValidatedValue(HtmPage::TABLE, HtmPage::FIELD_TITLE);
        $slug = $this->getValidatedValue(HtmPage::TABLE, HtmPage::FIELD_SLUG);
        
        if($slug == false || $slug == 'index'){
            $slug = \lib\tools\StringTools::slugify($title);
            $this->rePostValue(HtmPage::TABLE, HtmPage::FIELD_SLUG, $slug);
        }
    }

}
