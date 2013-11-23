<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data = $this->_init();
        $menuConfig = array(
            'currentController' => 'login',
            'loggedIn' => false,
            'user' => '',
            'userRole' => 3
        );
        $this->load->library('Menu_Library', $menuConfig);
        
        $data['title'] = 'Aanmelden';
        $data['menu'] = $this->menu_library->ToonMenu();
        $data['device'] = $this->_footer();
        
        if($this->session->userdata('logged_in')){
            //redirect('kalender/maandOverzicht', 'refresh');
            header('Location: '.site_url().'/kalender/maandOverzicht');
        }else{
            $this->load->view('templates/header', $data);
            $this->load->view('templates/login', $data);
            $this->load->view('templates/footer', $data);
        }
    }
    private function _footer(){
        $this->load->library('user_agent');
        $strUser = (getenv("username") == null ? $this->input->ip_address() : getenv("username"));
        if ($this->agent->is_browser()){
            //$agent = $this->agent->browser().' '.$this->agent->version();
            $strFooter = '<i class="fi-monitor size-12">&nbsp;&nbsp;'.$this->agent->browser().' - '.$strUser.'</i>';
        }elseif ($this->agent->is_mobile()){
            //$agent = $this->agent->mobile();
            $strFooter = '<i class="fi-mobile size-12">&nbsp;&nbsp;'.$this->agent->mobile().'</i>';
        }else{
            $strFooter = '';
        }
        return $strFooter;
    }
    private function _init(){
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
            "device" => ''   
        );
        return $arrData;
    }
}


?>


