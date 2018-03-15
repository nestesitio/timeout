<?php
namespace apps\Vendor\model;

use \model\models\HtmApp;
use \model\models\Htm;

/**
 * Description of Page
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Jan 8, 2015
 */
class Page extends \model\models\HtmPage {

    /**
     *
     */
    function initialize() {
        $this->columnNames[HtmApp::TABLE] = ['slug', 'name'];
        //$this->columnNames['htm_txt'] = ['desc'];
        $this->tableJoins[HtmApp::TABLE] = ['join' => 'INNER JOIN', 'left'=>Htm::FIELD_HTM_APP_ID, 'right'=>  HtmApp::FIELD_ID];
        //$this->tableJoins['htm_txt'] = ['join' => 'INNER JOIN', 'left'=>'htm_txt.htm_page_id', 'right'=>'htm_page.id'];
        unset($this->tableJoins['langs']);
        
    }

    /**
     * @param $value
     */
    function setHtmAppSlug($value) {
        $this->setColumnValue(HtmApp::FIELD_SLUG, $value);
    }

    /**
     * @return mixed|null
     */
    function getHtmAppSlug() {
        return $this->getColumnValue(HtmApp::FIELD_SLUG);
    }

    /**
     * @param $value
     */
    function setHtmAppName($value) {
        $this->setColumnValue(HtmApp::FIELD_NAME, $value);
    }

    /**
     * @return mixed|null
     */
    function getHtmAppName() {
        return $this->getColumnValue(HtmApp::FIELD_NAME);
    }

}
