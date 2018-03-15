<?php

namespace lib\url;

/**
 * Description of MenuRender
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @Mar 7, 2016
 */
class MenuRender extends \lib\url\UrlHref
{
    /**
     * @var string
     */
    protected $string = '';
    /**
     * @var array
     */
    private $list = [];

    /**
     * MenuRender constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $title
     */
    public function setToogle($title)
    {
        $this->string .= '<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
        $this->string .= $title;
        $this->string .= '</a>';
    }

    /**
     * @param $class
     */
    public function setDropdown($class)
    {
        $this->string .= '<ul class="' . $class . '">$ul</ul>';
    }

    /**
     * @param $url
     * @param $title
     * @param array $params
     */
    public function addItem($url, $title, $params=[])
    {
        $this->list[] = self::renderMenuItem($url, $title, $params);
    }

    /**
     *
     */
    public function addDivider()
    {
        $this->list[] = '<li class="divider"></li>';
    }

    /**
     * @return string
     */
    public function renderString()
    {
        foreach($this->list as $list){
            $this->string = str_replace('$ul', $list . '$ul', $this->string);
        }
        $this->string = str_replace('$ul', '', $this->string);
        return $this->string;
    }


    /**
     * 
     * @return string
     */
    public function output(){
        return $this->string;
    }

}
