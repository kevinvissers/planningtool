<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * VerifyLogin extends CI_Controller 
 * 
 * Deze controller controlleerd de aanmeld gegevens
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
class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('User_model','',TRUE);
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.&nbsp; User redirected to login page
     //$this->load->view('login_view');
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
        $this->load->view('templates/header', $data);
        $this->load->view('templates/login', $data);
        $this->load->view('templates/footer', $data);
   }
   else
   {
     //Go to private area
     //redirect('kalender/maandOverzicht', 'refresh');
     header('Location: '.site_url().'/kalender/maandOverzicht');
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.&nbsp; Validate against database
   $username = $this->input->post('username');

   //query the database
   $result = $this->User_model->login($username, $password);

   if($result)
   {
        $sess_array = array();
        foreach($result as $row)
        {
            $sess_array = array(
                'id' => $row->gebruikersID,
                'username' => $row->gebruikersNaam
            );
            $this->session->set_userdata('logged_in', $sess_array);
        }
        return TRUE;
   }
   else
   {
        $this->form_validation->set_message('check_database', 'Invalid username or password');
        return false;
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

