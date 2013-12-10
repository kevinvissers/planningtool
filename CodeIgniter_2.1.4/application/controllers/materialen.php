<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class materialen extends CI_Controller {
    public function Tonen($intAfspraakId){
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
        $this->load->model('Materiaal_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['title'] = 'Materiaallijst tonen';
            
            $data['inhoud'] = $this->Materiaal_model->Tonen($intAfspraakId);
                                                
            $this->load->view('templates/header', $data);
            $this->load->view('pages/klantenBestand', $data);
            $data['device'] = $this->helper_library->CreateFooter();
            $this->load->view('templates/footer', $data);
        }
        else
        {
            header('Location: '.site_url().'/login');
        }
    }
    public function Toevoegen($intAfspraakId){
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
        $this->load->model('Materiaal_model');
        
        if($blnPermission){
            $data['menu'] = $this->menu_library->ToonMenu();
            $data['title'] = 'Materiaal toevoegen';
            $data['inhoud'] = $this->Materiaal_model->ToevoegFormulier($intAfspraakId);
            
            if(isset($_POST['materiaalToevoegen'])){
                $arrMaterialen = array(
                    "materiaalNaam" => $_POST['naam']
                );
                $arrMateriaallijst = array(
                    "aantal" => $_POST['aantal'],
                    "eenheid" => $_POST['eenheid']
                );
                $stat = $this->Materiaal_model->Toevoegen($arrMaterialen, $arrMateriaallijst, $intAfspraakId);
                
                if($stat){
                    $data['inhoud'] = $this->Materiaal_model->Tonen($intAfspraakId);
                }else{
                    $data['inhoud'] = $stat;
                }
            }
                                                
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
}
?>
