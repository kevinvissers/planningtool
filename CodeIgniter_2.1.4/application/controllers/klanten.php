<?php
/**
 * Afspraken extends CI_Controller 
 * 
 * Via deze controller worden de klanten beheerd
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
class Klanten extends CI_Controller {
    public function toevoegen(){
        if ( ! file_exists('application/views/pages/klantFormulier.php'))
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
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        
        $this->load->model('Klanten_model');     
                
        //title: titel van de webpagina
        $data['title'] = 'Klant toevoegen';
        
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();
        if($blnPermission){
            
            $data['klantFormulier'] = $this->Klanten_model->ToevoegFormulierTonen();
            
            if(isset($_POST['nieuweKlantSubmit']))
            {
                $arrGegevens = array(
                    'voornaam' => ucfirst($_POST['voornaam']),
                    'achternaam' => ucfirst($_POST['achternaam']),
                    'straat' => ucfirst($_POST['straat']),
                    'huisnummer' => $_POST['huisnummer'],
                    'idgemeente' => '',
                    'telefoon' => $_POST['telefoon'],
                    'gsm' => $_POST['gsm'],
                    'email' => $_POST['email'],
                    'opmerking' => $_POST['opmerking']
                );

                $arrGemeente = array(
                    'gemeente' => ucfirst($_POST['gemeente']),
                    'postcode' => $_POST['postcode']
                );

                $resultaat = $this->Klanten_model->Toevoegen($arrGegevens, $arrGemeente);
                $data['detailView'] = $resultaat;
            }
            
            //header laden
            $this->load->view('templates/header', $data);
            //inhoud laden
            $this->load->view('pages/klantFormulier', $data);
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
