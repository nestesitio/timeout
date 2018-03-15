<?php

namespace apps\Vendor\model;

/**
 * Description of Media
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 25, 2016
 */
class Media {
    

    /**
     * 
     * @param \model\models\Htm $model
     * @return \apps\Vendor\model\Page
     */
    public static function initialize($model){
        $page = new Media($model);
        return $page;
    }

    function __construct() {
        
    }

}
