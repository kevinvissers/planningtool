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
        if ( ! file_exists('application/views/pages/row1row2.php'))
	{
            show_404();
	}
        
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        
        $this->load->model('Gebruiker_model');

        $menuConfig = array(
            'currentController' => 'afspraken',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => $session_data['userrole']
        );
        
        $resultaat = '';
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //afspraken model
        $this->load->model('Afspraken_model');
        $this->load->model('Klanten_model');
        
        if(isset($_POST['nieuweAfspraakSubmit']))
        {
            $arrGegevens = $this->Gebruiker_model->GetGebruikerGegevens($menuConfig['user']);
            $startDate = date_create($_POST['datum'].$_POST['starttijd']);
            $eindDate = date_create($_POST['datum'].$_POST['eindtijd']);
            $arrNieuweAfspraak = array(
                'klantID' => $_POST['klantID'],
                'startTijd' => date_format($startDate, 'Y-m-d H:i:s'),
                'eindTijd' => date_format($eindDate, 'Y-m-d H:i:s'),
                'omschrijving' => $_POST['opmerking'],
                'actief' => $_POST['switchActief'],
                'uitgevoerd' => '0',
                'gebruikersID' => $arrGegevens['gebruikersID'],
                'iduitvoerder' => $_POST['ddSelectUitvoerder']
            );
            $resultaat = $this->Afspraken_model->Toevoegen($arrNieuweAfspraak);
        }
        
        
        $data['afspraakFormulier'] = $this->Afspraken_model->ToevoegenFormulierTonen('', '', '');
        $data['klantenTabel'] = $this->Klanten_model->SelectNaamForm();
        $data['messages'] = $resultaat;
        
        if(isset($_POST['searchKlant']))
            {
                $data['klantenTabel'] .= $this->Klanten_model->KlantenFilterTonen($_POST['txtSelectNaam'], $_POST['ddSelectItem']);
            }
        
        if(isset($_POST['Bewerken']))
            {                
                $data['afspraakFormulier'] = $this->Afspraken_model->ToevoegenFormulierTonen($_POST['klant_id'], $_POST['klant_voornaam'], $_POST['klant_achternaam']);
            }
        
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
            $this->load->view('pages/row1row2', $data);
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
