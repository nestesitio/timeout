<?php

namespace apps\Vendor\tools;

/**
 * Description of DataMime
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Aug 23, 2016
 */
class DataMime {

    /**
     * @param $genre
     * @return string
     */
    public static function getDataMime($genre = 'img'){
        if($genre == 'img'){
            return 'image/*';
        }
        if($genre == 'txt'){
            return 'text/plain';
        }
        if($genre == 'pdf'){
            return '.pdf';
        }
        if($genre == 'csv'){
            return '.csv';
        }
        if($genre == 'xml'){
            return '.xml';
        }
    }

}
