<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login extends CI_Controller 
 * 
 * Deze controller genereerd de login
 * 
 * PHP version 5
 *
 *
 * @package    PlanningTool
 * @author     Kevin Vissers <kevin.vissers@student.khlim.be>
 * @copyright  2013
 * @license    
 * 
 */
class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $menuConfig = array(
            'currentController' => 'login',
            'loggedIn' => false,
            'user' => '',
            'userRole' => 3
        );
        $this->load->library('Menu_Library', $menuConfig);
        
        $data['title'] = 'Aanmelden';
        $data['menu'] = $this->menu_library->ToonMenu();
        $data['device'] = $this->helper_library->CreateFooter();
        
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
}


?>


