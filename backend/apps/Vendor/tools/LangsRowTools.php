<?php

namespace apps\Vendor\tools;

use \lib\bkegenerator\DataTool;

/**
 * Description of LangsRowTools
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jul 13, 2016
 */
class LangsRowTools {

    public static function renderLangsTemplate($langs, $action_url){
        $str = '';
        foreach($langs as $tld => $lang){
            
            $tool = new DataTool();
            $tool->setLangAction($action_url, 0, $lang);
            $tool->setFlag($tld);
            $tool->haveNoLang();
            $str .= $tool->getUl();
        }
        
        return $str;
    }
    
    /**
     * @param $results
     * @param $langs
     * @return mixed
     */
    public static function renderLangTools($results, $langs, $action_url){
        foreach($results as $row){
            $result = $row->getColumnValue('langs');
            $str = '';
            foreach($langs as $tld=>$lang){
                $tool = new DataTool();
                $tool->setLangAction($action_url, $row->getHtmId(), $lang);
                $tool->setFlag($tld);
                if(strpos($result, $tld) === false){
                    $tool->haveNoLang();
                }
                $str .= $tool->getUl();
            }
            $row->setColumnValue('langs', $str);
        }
        
        return $results;
    }

}
