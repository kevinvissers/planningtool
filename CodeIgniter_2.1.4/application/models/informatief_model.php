<?php

/**
 * Informatief_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Informatief_model class has the following properties and methods:
 * properties:  $title, $menu, $header, $banner, $content, $footer, $style
 * methods: initialize, setBackground
 *
 */
class Informatief_model extends CI_Model {
        /********************* PROPERTIES ********************/
/**
 * @access	public
 */
    public $title = '';
    public $menu = '<ul><li>item1</li><li>item2</li><li>item2</li></ul>';
    public $header = '<h1 align="center">Dit is de hoofding</h1>';
    public $banner = '<h2 align="center">Hier kan een afbeelding komen</h2>';
    public $content = '<p align="center">Dit is de inhoud van de pagina</p>';
    public $footer = '<span class="right author">Designed by Kev!n</span>';
    public $style = '';
    
    /********************* METHODS ********************/
/**
 * @access	public
 */      
    function __construct()
    {
        parent::__construct();
    }
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param           array $config configuratie
     * @return          none
     *
     */  
    public function initialize($config = array()) {
        if (count($config) > 0) {
            if(array_key_exists('title', $config)){
                $this->title = $config['title'];
            }
            if(array_key_exists('header', $config)){
                $this->header = $config['header'];
            }
            if(array_key_exists('menu', $config)){
                $this->menu = $config['menu'];
            }
            if(array_key_exists('banner', $config)){
                $this->banner = $config['banner'];
            }
            if(array_key_exists('content', $config)){
                $this->content = $config['content'];
            }
            if(array_key_exists('footer', $config)){
                $this->footer = $config['footer'];
            }
            if(array_key_exists('style', $config)){
                $this->style = $config['style'];
            }
        }       
    }
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param           string $backgroundColor achtergrondkleur(naam of rgb-waarde)
     * @param           string $backgroundImage link naar achtergrond afbeelding
     * @return          none
     *
     */
    public function setBackground($backgroundColor, $backgroundImage = null){
        if($backgroundImage != null){
            $this->style = $this->style.'body{background-color: '.$backgroundColor.';background-image: url('.$backgroundImage.');}';
        }else{
            $this->style = $this->style.'body{background-color: '.$backgroundColor.';}';
        }
    }
}

?>
