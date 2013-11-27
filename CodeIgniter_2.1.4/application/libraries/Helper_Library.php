<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Helper_Library
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		27/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Menu_Library class has the following properties and methods:
 * methods: Init, CreateFooter
 *
 */
class Helper_Library {
    private $CI;
    public function __construct(){
        $this->CI = get_instance();
    }
    public function CreateFooter(){
        $this->CI->load->library('user_agent');
        $strUser = (getenv("username") == null ? $this->input->ip_address() : getenv("username"));
        if ($this->CI->agent->is_browser()){
            //$agent = $this->agent->browser().' '.$this->agent->version();
            $strFooter = '<i class="fi-monitor size-12">&nbsp;&nbsp;'.$this->CI->agent->browser().' - '.$strUser.'</i>';
        }elseif ($this->CI->agent->is_mobile()){
            //$agent = $this->agent->mobile();
            $strFooter = '<i class="fi-mobile size-12">&nbsp;&nbsp;'.$this->CI->agent->mobile().'</i>';
        }else{
            $strFooter = '';
        }
        return $strFooter;
    }
    public function Init(){
        $arrData = array(
            "modalId" => '',
            "modalTitle" => '',
            "inhoudModal" => '',
            "script" => '',
            "afspraak" => '<li class="size-14">geen afspraak geselecteerd</li>',
            "title" => 'Titel',
            "style" => '',
            "menu" => '',
            "kalender" => '',
            "device" => '',
            "afspraakFormulier" => '',
             "modalId" => '',
            "modalTitle" => '',
            "inhoudModal" => '',
            "script" => '',
            "afspraak" => '<li class="size-14">geen afspraak geselecteerd</li>',
            "title" => 'Titel',
            "style" => '',
            "menu" => '',
            "kalender" => '',
            "device" => '',
            "modalId" => '',
            "modalTitle" => '',
            "inhoudModal" => '',
            "script" => '',
            "afspraak" => '<li class="size-14">geen afspraak geselecteerd</li>',
            "title" => 'Titel',
            "style" => '',
            "menu" => '',
            "kalender" => '',
            "device" => '',
            "afspraakFormulier" => '',
            "gebruikerFormulier" => ''
        );
        return $arrData;
    }
}
?>
