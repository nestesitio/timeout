<?php

namespace lib\control;

use \lib\register\Monitor;
use \lib\register\Vars;
use \lib\filter\QueryFilter;
use \lib\bkegenerator\DataGrid;
use \lib\bkegenerator\DataEdit;
use \lib\form\Form;
use \lib\model\QuerySelect;
use \lib\model\Model;
use lib\parser\CSVParser;
use \lib\control\GridIt;
use \lib\bkegenerator\Config;

/**
 * Description of ControllerAdmin
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Mar 30, 2015
 */
class ControllerAdmin extends \lib\control\Controller
{
    /**
     * Get the array results from query.
     *
     * @param \lib\model\QuerySelect $query
     * @param Config $configs
     *
     * @return array $results
     */
    protected function getQueryToList(QuerySelect $query, $configs = null)
    {
        $query->setCalcFoundRows();
        $results = $query->find();
        $total = $query->calcFoundRows()->getFoundRows();
        $this->set('numrows', $query->getCount());
        $this->set('total', $total);
        $this->set('pagination', \lib\filter\Pagination::renderPagination($total));

        if(null != $configs){
            $results = \lib\control\FormatData::format($results, $configs);
        }
        return $results;
    }


    /**
     * @param String $xmlfile
     * @param QuerySelect $query
     * @param String $view The path to template file
     *
     * @return array $results
     */
    protected function buildDataGrid($xmlfile, QuerySelect $query, $view = null)
    {
        /* Generation or processing of template datagrid */
        $tpl = (null == $view)? '/layout/core/datagrid.htm' : $view;
        $this->setView($tpl);
        Monitor::setMonitor(Monitor::BOOKMARK, 'buildDataGrid');

        $grid = GridIt::create($xmlfile, $this);
        $this->view->setOutput($grid->setGrid($this->view->getOutput()));
        $query = QueryFilter::filter($query, $grid->getFilters());
        return $this->getQueryToList($query, $grid->getFields());

    }

    /**
     * @param String $xmlfile
     * @param QuerySelect $query
     * @param boolean $filter Put false if you don't need filterage
     *
     * @return array $results
     */
    protected function buildDataList($xmlfile,QuerySelect $query, $filter = true)
    {
        /* Generation or processing of template datalist */
        $this->setView('/layout/core/datalist.htm');
        Monitor::setMonitor(Monitor::BOOKMARK, 'buildDataList');

        $grid = GridIt::create($xmlfile, $this);
        $this->view->setOutput($grid->setGrid($this->view->getOutput()));
        if($filter == true){
            $query = QueryFilter::filter($query, $grid->getFilters());
        }
        
        return $this->getQueryToList($query, $grid->getFields());

    }

    /**
     * Build the list included in template.
     *
     * @param \lib\model\QuerySelect $query
     * @param DataGrid $configs
     * @param String $var Define the variable for while
     *
     * @return array $results
     */
    protected function buildIncludedList(QuerySelect $query, $configs, $var = null)
    {
        $query = QueryFilter::filter($query, $configs);
        $results = $this->getQueryToList($query);
        $this->set('page' . $var, $this->get('pagination'));
        return $results;
    }


    /**
     * @param String $xmlfile
     * @param QuerySelect $query
     * @param String $view The path to template file
     */
    protected function buildDataSubList($xmlfile, QuerySelect $query, $view = null)
    {
        /* Generation or processing of template datagrid */
        $tpl = (null == $view)? '/layout/core/datasublist.htm' : $view;
        $this->setView($tpl);
        $grid = GridIt::create($xmlfile, $this);
        $grid->configureGrid($this->view->getOutput(), 'list');
        $this->view->setOutput($grid->getHtml());
        $query = QueryFilter::filter($query, $grid->getFilters());
        $results = $this->getQueryToList($query, $grid->getFields());
        $this->renderList($results);


    }


    /**
     *
     * @param mixed $results
     * @param String $var
     */
    protected function renderList($results, $var = null)
    {
        $var = ($var == null)? 'list': $var;
        $this->renderCollection($results, $var);
        $this->set('canonical', Vars::getCanonical());
        $this->set('app', Vars::getApp());
    }


    /**
     * @param Form $form
     * @param String $xmlfile
     */
    protected function renderFilters(\lib\form\Form $form, $xmlfile)
    {
        $this->renderUrl('action', 'list_' . Vars::getCanonical());
        $config = new DataEdit($xmlfile, $this);
        $configs = $config->getConfigs('filter');
        $form = QueryFilter::renderFilters($form, Vars::getCanonical(), $configs);
        $this->set('filters', $form->renderInputs(Vars::getCanonical(), $configs));
    }

    /**
     * Render form for template.
     *
     * @param \lib\form\Form $form
     * @param String $xmlfile The path to xml file
     * @param String $action The url for process form
     * @param Array $querystring Querystrig to complete the url action
     *
     */
    protected function renderForm(Form $form, $xmlfile, $action = null, $querystring = [])
    {

        if($action == null){
            $action = 'bind_' . Vars::getCanonical();
        }
        $this->setView('/layout/core/edit.htm');
        $this->renderUrl('action', $action, $querystring);
        
        $this->runFormTasks($form, $xmlfile, $action);

    }
    
    protected function renderFileForm(Form $form, $xmlfile, $action = null, $multiple = null, $querystring = []){
        if($action == null){
            $action = 'bind_' . Vars::getCanonical();
        } 
        $view = ($multiple == null)?'/layout/core/fileinput.htm':'/layout/core/filenultiinput.htm';
        $this->setView($view);
        $this->renderUrl('action', $action, $querystring);
        
        $this->runFormTasks($form, $xmlfile, $action);
    }
    
    private function runFormTasks(Form $form, $xmlfile, $action){
        $this->set('delaction', str_replace('bind','del',$action));

        $this->set('hiddenfields', $form->renderHiddenFields(Vars::getCanonical()));
        $config = new DataEdit($xmlfile, $this);
        $configs = $config->getConfigs('edit');
        $form = QueryFilter::getDefaults($form, $xmlfile, $configs);
        
        $this->set('inputs', $form->renderInputs(Vars::getCanonical(), $configs));
        $config->setHtml($this->view->getOutput())->renderButtons('edit');
        $this->view->setOutput($config->getHtml());
        
        $this->set('dataid', Vars::getId());
        $this->setUserMessage();

    }


     /**
     * Save the object. If data is not valid, repeat form and return false.
     * @param Form $form The form
     * @param String $xmlfile The path of xml file with configuration
     * @param String $view The path to template file Optional
     *
     * @return \lib\model\Model $model
     */
    protected function buildProcess(Form $form, $xmlfile, $view = null)
    {
        $result = $form->isvalid();
        if($result == false){
            Monitor::setMonitor(Monitor::FORMERROR, 'Repeat Form');
            $this->renderForm($form, $xmlfile, $view);
            return false;
        }else{
            $form->save();
            $model = $form->getModel();
            Monitor::setMonitor(Monitor::FORM, 'Model ' . $model->getTableName() . ' saved');
            return $model;
        }
    }

     /**
     * Save the object. If data is not valid, repeat form and return false.
     * @param Form $form The form
     * @param String $action The action to be done Optional
     * @param String $view The path to template file (Optional)
     *
     * @return \lib\model\Model $model
     */
    protected function buildMultipleProcess(Form $form, $action = null, $view = null)
    {
        $tpl = (null == $view)? '/layout/core/insert.htm' : $view;
        $this->setView($tpl);
        $result = $form->isvalid();
        if ($result == false) {
            Monitor::setMonitor(Monitor::FORMERROR, 'Repeat Form');
            return false;
        } else {
            $parts = $form->getModels();
            foreach ($parts as $models) {
                foreach ($models as $model) {
                    $model->save();
                }
            }
            if($action == null){
                $action = 'list_' . Vars::getCanonical();

            }
            $this->renderUrl('url', $action);
        }
        return true;
    }

    /**
     * @param $results
     * @param $id
     * @param $action
     * @param String $lang
     */
    protected function renderLangActions($results, $id, $action, $lang = null)
    {
        $itens = [];
        foreach ($results as $i=>$obj){
            $data = $obj->getToArray();
            $itens[$i]['lang'] = $data['langs.tld'];
            $itens[$i]['id'] = $id;
            $itens[$i]['action'] = $action;
            $itens[$i]['lang_tld'] = strtoupper($data['langs.tld']);
            $itens[$i]['class'] = ($data['langs.tld'] == $data['htm_page.langs_tld'])? 'primary' : 'default';
            if($lang == $data['langs.tld']){
                $itens[$i]['class'] = 'success selected';
            }
        }
        $this->set('langs', $itens);
    }

    /**
     * render de data for action showAction()
     * @param \lib\model\Model $model Object to be rendered to html
     * @param String $xmlfile The path to xml file with some configs
     * @param String $view The path to template file
     */
    protected function renderValues($model, $xmlfile, $view = null)
    {
        $tpl = (null == $view) ? '/layout/core/show.htm' : $view;
        $this->setView($tpl);

        $config = new DataEdit($xmlfile, $this);
        $config->setHtml($this->view->getOutput())->renderButtons('show');
        $this->view->setOutput($config->getHtml());
        $configs = $config->getConfigs('show');

        $fields = $configs->getIndexes();
        $values = [];
        if ($model != false) {
            foreach ($fields as $column) {
                $configs->setIndex($column);
                $values[$column]['label'] = $configs->getConfigValue('label');
                $values[$column]['value'] = $this->processValue2Show($model->getColumnValue($column), $configs->getConfigValue('convert'));
                $values[$column]['field'] = $column;
            }
        }
        $this->set('inputs', $values);

        $action = str_replace(['bind', 'show'], 'edit', Vars::getAction());
        $this->renderUrl('editaction', $action);

        $this->set('delaction', str_replace('edit', 'del', $action));
        $this->set('dataid', Vars::getId());
        $this->setUserMessage();
        $this->setCustomMessage();
    }

    /**
     * @param Model $model
     * @param String $view The path to template file
     */
    protected function deleteObject(Model $model, $view = null)
    {
        $tpl = (null == $view) ? '/layout/core/del.htm' : $view;
        $this->setView($tpl);
        $result = $model->delete();
        $this->setUserMessage();
        $this->set('dataid', (string) $result);
    }


    /**
     * Get the array results from query.
     *
     * @param \lib\model\QuerySelect $query
     * @param String $filename The file name to be downloaded
     * @param String $xmlfile The xml file with params
     *
     * @return array $results
     */
    protected function buildCsvExport($query, $filename, $xmlfile = null)
    {
        $this->layout = false;
        if (null != $xmlfile) {
            $config = GridIt::create($xmlfile, $this)->get();
            $query = QueryFilter::filter($query, $config->getFilters());
            CSVParser::outputConfigurate($filename, $config->getFields(), $this->getQueryToList($query, $config->getFields()));
        } else {
            $csv = new CSVParser($filename);
            $results = $query->find();
            foreach ($results as $result) {
                $csv->put($result->getToArray());
            }

            return $csv->close();
        }


        //return $this->dispatch();
    }


}
