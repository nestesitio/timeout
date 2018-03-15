<?php

namespace lib\view;

use \lib\view\Template;

/**
 * Description of View
 * A interface between Control and Template
 * 1. Controller declare new View() -> Template load file and parse extend
 * 2. Render data to template
 * 3. Parse template
 * 
 *
 * @author Luís Pinto / luis.nestesitio@gmail.com
 * Created @May 18, 2016
 */
class View
{
    /**
     * Define a class property to store the template
     * @var object
     */
    private $template;



    /**
     * Template loads child and parent files
     * 
     * @param object $file
     */
    public function __construct($file)
    {
        $this->template = new Template($file);
    }


    /**
     * Method to replace the template tags with entry data
     *
     *
     * @param type $tag
     * @param type $data
     * @return \lib\control\View
     */
        public function setData($tag, $data)
    {
            $this->template->addData($tag, $data);

            return $this;
    }
    
    
    /*
     * Public method to output the result of the templating engine
     */
    public function render()
    {
        $this->template->parseTemplate();
        return $this->template->getOutput();
    }

    /**
     * 
     * @return string The path to main layout
     */    
    public function getLayout()
    {
        return $this->template->getExtends();
    }
    
    public function getOutput(){
        return $this->template->getOutput();
    }
    
    public function setOutput($output){
        return $this->template->setOutput($output);
    }





}
