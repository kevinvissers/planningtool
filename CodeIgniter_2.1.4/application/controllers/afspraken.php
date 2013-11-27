<?php
/**
 * Afspraken extends CI_Controller 
 * 
 * Via deze controller worden de afspraken beheerd
 * 
 * PHP version 5
 *
 *
 * @package    PlanningTool
 * @author     Kevin Vissers <kevin.vissers@student.khlim.be>
 * @author     Bart Bollen <bart.bollen@student.khlim.be>
 * @copyright  2013
 * @license    
 * 
 */
class Afspraken extends CI_Controller {
    public function toevoegen(){
        if ( ! file_exists('application/views/pages/afspraakFormulier.php'))
	{
            show_404();
	}
        
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');

        $menuConfig = array(
            'currentController' => 'afspraken',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => 3
        );
        
        if(isset($_POST['nieuweAfspraakSubmit']))
        {
            $arrNieuweAfspraak = array(
                'klantID' => $_POST['klantID']                
            );
        }
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //afspraken model
        $this->load->model('Afspraken_model');
        $this->load->model('Klanten_model');
        
        $data['afspraakFormulier'] = $this->Afspraken_model->ToevoegenFormulierTonen();
        $data['klantenTabel'] = $this->Klanten_model->KlantenTabelTonen();
        
        //title: titel van de webpagina
        $data['title'] = 'Afspraak toevoegen';
        //script: javascript/jquery
        if(!isset($data['script']))
        {
            $data['script'] = '';
        }
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();
        if($blnPermission){
            //header laden
            $this->load->view('templates/header', $data);
            //inhoud laden
            $this->load->view('pages/afspraakFormulier', $data);
            //footer laden
            $data['device'] = $this->helper_library->CreateFooter();
            $this->load->view('templates/footer', $data);
        }else{
            //redirect('login', 'refresh');
            header('Location: '.site_url().'/login');
        }
        
    }
    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //redirect('login', 'refresh');
        header('Location: '.site_url().'/login');
    }
}
?>
