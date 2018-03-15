<?php

namespace lib\bkegenerator;

use \lib\session\SessionUser;
use \lib\bkegenerator\Config;

/**
 * Description of DataEdit
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 5, 2015
 */
class DataEdit extends \lib\bkegenerator\DataConfig
{

    /**
     * @param $action
     * @return \lib\bkegenerator\Config
     */
    public function getConfigs($action)
    {
        $config = new Config();
        $nodes = $this->getnodes('show/fields/*');
        foreach($nodes as $node){
            $path = 'show/fields/' . $node;
            $criteria = $this->x_conf->queryXPath($path, 'atr', $action);
            if($criteria != 'false'){
                $config->setIndex($this->x_conf->queryXPath($path, 'atr', 'field'));
                $config->setConfigValue($action, $this->x_conf->queryXPath($path, 'atr', $action));
                $config->setConfigValue('field', $this->x_conf->queryXPath($path, 'atr', 'field'));
                $config->setConfigValue('label', $this->findLabel($path));
                $config->setConfigValue('type', $this->x_conf->queryXPath($path, 'atr', 'type'));
                if($action != 'edit'){
                    $config->setConfigValue('range', $this->x_conf->queryXPath($path, 'atr', 'range'));
                }else{
                    $config->setConfigValue('data-link', $this->x_conf->queryXPath($path, 'atr', 'data-link'));
                    $config->setConfigValue('data-range', $this->x_conf->queryXPath($path, 'atr', 'data-range'));
                }
                $config->setConfigValue('convert', $this->x_conf->queryXPath($path, 'atr', 'convert'));

            }
        }
        if(null == $this->identification){
            $this->identification = $this->x_conf->queryXPath('grid', 'atr', 'identification');
        }
        $config->setIdentification($this->identification);
        return $config;
    }


    /**
     * @param $mode
     */
    public function renderButtons($mode)
    {
        $btn_tpl = '<!--{$buttons}-->';
        if (strpos($this->html, '{$buttons}')) {
            $nodes = $this->getnodes('show/buttons/*');
            foreach($nodes as $node){
                $path = 'show/buttons/' . $node;
                if($this->getCondition($path) == false){
                    continue;
                }
                $auth = $this->x_conf->queryXPath($path, 'atr', 'auth');
                if(SessionUser::getAuth($auth) == false || ($mode == 'edit' && $node == 'editform')){
                    continue;
                }elseif(SessionUser::getAuth($auth) == false || ($mode == 'show' && ($node == 'saveform' || $node == 'resetform'))){
                    continue;
                }

                $btn = '<a class="' . $node . ' btn btn-xs btn-primary" data-id="{$dataid}">';
                $action = $this->x_conf->queryXPath($path, 'atr', 'action');
                if(!empty($action)){
                    $btn = str_replace('>', ' data-action="' . $action . '">', $btn);
                }
                $layer = $this->x_conf->queryXPath($path, 'atr', 'layer');
                if(!empty($layer)){
                    $btn = str_replace('>', ' data-layer="' . $layer . '">', $btn);
                }
                $btn .= '<span class="' . $this->x_conf->queryXPath($path, 'atr', 'class') . '"></span> ';
                $btn .= $this->findLabel($path) . '</a>' . $btn_tpl;
                $this->html = str_replace($btn_tpl, $btn, $this->html);
            }

        }
    }
    /*
     * <a class="saveform btn btn-xs btn-primary"><span class="glyphicon glyphicon-save"></span> Gravar</a>
        <a class="resetform btn btn-xs btn-primary"><span class="glyphicon glyphicon-refresh"></span> Limpar</a>
        <a class="delform btn btn-xs btn-primary" data-action="{$delaction}" data-id="{$dataid}"><span class="glyphicon glyphicon-trash"></span> Apagar</a>
        <a class="closeform btn btn-xs btn-primary"><span class="glyphicon glyphicon-remove"></span> Fechar</a>
     * <a class="editform btn btn-xs btn-primary" data-action="{$editaction}" data-id="{$dataid}"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
     */

}
