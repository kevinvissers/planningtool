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
            'userRole' => $session_data['userrole']
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
    
    public function Bewerken()
    {
        if ( ! file_exists('application/views/pages/afspraakFormulier.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $menuConfig = array(
            'currentController' => 'gebruiker',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => $session_data['userrole']
        );
        
        $this->load->library('Menu_Library', $menuConfig);
        $this->load->model('Klanten_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['title'] = 'Klant bewerken';
            
            if(isset($_POST['Bewerken'])){
                $data['klantenTabel'] = $this->Klanten_model->KlantTonen($_POST['klant_id']);
            }
            if(isset($_POST['updateKlant'])){
                $arrGegevens = array(
                    'klantID' => $_POST['klantID'],
                    'voornaam' => ucfirst($_POST['txtKlantVoornaam']),
                    'achternaam' => ucfirst($_POST['txtKlantAchternaam']),
                    'straat' => ucfirst($_POST['txtStraat']),
                    'huisnummer' => $_POST['txtHuisnummer'],
                    'idgemeente' => '',
                    'telefoon' => $_POST['txtTelefoon'],
                    'gsm' => $_POST['txtGsm'],
                    'email' => $_POST['txtEmail'],
                    'opmerking' => $_POST['txtOpmerking']
                );

                $arrGemeente = array(
                    'gemeente' => ucfirst($_POST['txtGemeente']),
                    'postcode' => $_POST['txtPostcode']
                );

                $resultaat = $this->Klanten_model->Bewerken($arrGegevens, $arrGemeente);
                $data['klantenTabel'] = $resultaat;
            }
                        
            $data['afspraakFormulier'] = $this->Klanten_model->SelectNaamForm();
            
            if(isset($_POST['searchKlant']))
            {
                $data['afspraakFormulier'] .= $this->Klanten_model->KlantenFilterTonen($_POST['txtSelectNaam'], $_POST['ddSelectItem']);
            }
                                    
            $this->load->view('templates/header', $data);
            $this->load->view('pages/afspraakFormulier', $data);
            $data['device'] = $this->helper_library->CreateFooter();
            $this->load->view('templates/footer', $data);
        }
        else
        {
            //redirect('login', 'refresh');
            header('Location: '.site_url().'/login');
        }
    }
    
    public function Tonen()
    {
        if ( ! file_exists('application/views/pages/klantenBestand.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $menuConfig = array(
            'currentController' => 'gebruiker',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => $session_data['userrole']
        );
        
        $this->load->library('Menu_Library', $menuConfig);
        $this->load->model('Klanten_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['title'] = 'Klant bewerken';
                                    
            $data['inhoud'] = $this->Klanten_model->AlleKlantenTonen();
                                                
            $this->load->view('templates/header', $data);
            $this->load->view('pages/klantenBestand', $data);
            $data['device'] = $this->helper_library->CreateFooter();
            $this->load->view('templates/footer', $data);
        }
        else
        {
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
