<?php
/**
 * Gebruiker extends CI_Controller 
 * 
 * Deze controller genereerd de gebruiker instellingen
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

class Gebruiker extends CI_Controller{
    
    public function Toevoegen(){
        if ( ! file_exists('application/views/pages/gebruikerFormulier.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        $data = $this->_init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $menuConfig = array(
            'currentController' => 'gebruiker',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => 3
        );
        
        $this->load->library('Menu_Library', $menuConfig);
        $this->load->model('Gebruiker_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['gebruikerFormulier'] = $this->Gebruiker_model->AanmaakFormulier();
            $data['title'] = 'Gebruiker toevoegen';
            if(isset($_POST['toevoegen'])){
                $arrGebruiker = array(
                    'gebruikersNaam' =>$_POST['user'],
                    'wachtwoord' => MD5($_POST['pass']),
                    'idfunctie' => $_POST['type']
                );
                $data['gebruikerFormulier'] = $this->Gebruiker_model->Aanmaken($arrGebruiker);
            }

            $this->load->view('templates/header', $data);
            $this->load->view('pages/gebruikerFormulier', $data);
            $data['device'] = $this->_footer();
            $this->load->view('templates/footer', $data); 
        }else{
            header('Location: '.site_url().'/login');
        }  
    }
    public function Bewerken(){
        if ( ! file_exists('application/views/pages/gebruikerFormulier.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        $data = $this->_init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $menuConfig = array(
            'currentController' => 'gebruiker',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => 3
        );
        
        $this->load->library('Menu_Library', $menuConfig);
        $this->load->model('Gebruiker_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['title'] = 'Gebruiker bewerken';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/gebruikerFormulier', $data);
            $data['device'] = $this->_footer();
            $this->load->view('templates/footer', $data);          
        }else{
            header('Location: '.site_url().'/login');
        }
    }
    public function Verwijderen(){
        if ( ! file_exists('application/views/pages/gebruikerFormulier.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        $data = $this->_init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $menuConfig = array(
            'currentController' => 'gebruiker',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => 3
        );
        
        $this->load->library('Menu_Library', $menuConfig);
        $this->load->model('Gebruiker_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['title'] = 'Gebruiker bewerken';

            $this->load->view('templates/header', $data);
            $this->load->view('pages/gebruikerFormulier', $data);
            $data['device'] = $this->_footer();
            $this->load->view('templates/footer', $data);            
        }else{
            header('Location: '.site_url().'/login');
        }
    }
    public function Code(){
        $this->load->library('encrypt');
        $this->load->model('Gebruiker_model');
        $strHTML = '<form method="POST">
                <label for "user">Gebruikersnaam</label>
                <input type="email" name="user" required /><br />
                <input type="submit" name="reset" value="Reset wachtwoord" />
                </form>';
        if(isset($_POST['reset'])){
            $userName = $_POST['user'];
            $code = $this->Gebruiker_model->GenereerNieuwWachtwoord();
            $code2 = $code . $userName;
            $key = $this->config->item('encryption_key');
            $encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $code2, MCRYPT_MODE_CBC, md5(md5($key))));
            $url = urlencode($encoded);
            //mail url naar gebruiker 
            $strHTML = '<a href="http://localhost/CodeIgniter_2.1.4/index.php/gebruiker/reset/'.$url.'">Klik hier om een nieuw wachtwoord in te stellen</a>';
        }
        echo $strHTML;
    }
    public function Reset($code=null){
        if($code != null){
            $key = $this->config->item('encryption_key');
            $this->load->library('encrypt');
            $this->load->model('Gebruiker_model');
            $decCode = urldecode($code);
            $hihi = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($decCode), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
            $ww = substr($hihi, 0, 8);
            $mail = substr($hihi, 8);
            //echo $mail;
            $strForm = '<form method="POST">
                <input type="email" name="user" value="username" required /><br />
                <input type="password" name="pass1" required /><br />
                <input type="password" name="pass2" required /><br />
                <input type="submit" name="change" value="Change password" />
                </form>';

            if(isset($_POST['change'])){
                $ww1 = $_POST['pass1'];
                $ww2 = $_POST['pass2'];
                $user = $_POST['user'];   
                if(($ww1 ==$ww2)&&($user == $mail)){
                    $strForm = $this->Gebruiker_model->WachtwoordWijzigen($user, $ww1);
                }else{
                    $strForm = "Oeps, er is iets mis gelopen!";
                }
            }
            echo $strForm;
        }else{
            echo "Verkeerd gebruik van functie.";
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //redirect('login', 'refresh');
        header('Location: '.site_url().'/login');
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
            "device" => '',
            "afspraakFormulier" => '',
            "gebruikerFormulier" => ''
        );
        return $arrData;
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
