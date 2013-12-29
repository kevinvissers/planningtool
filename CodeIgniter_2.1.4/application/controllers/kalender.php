<?php
/**
 * Kalender extends CI_Controller 
 * 
 * Deze controller genereerd de maand -en weekkalender
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
class Kalender extends CI_Controller {
/**
 * @access	public
 */ 
    public function maandOverzicht($jaar=null, $maand=null)
    {
        if ( ! file_exists('application/views/pages/maandOverzicht.php'))
	{
		show_404();
	}
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $menuConfig = array(
            'currentController' => 'kalender',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => $session_data['userrole']
        );

        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van het huidige jaar
        if ($jaar==null) {
            $jaar = date('Y');
        }  
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van de huidige maand
        if ($maand==null) {
            $maand = date('m');
        }

        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //kalender model -> houdt de template bij
        $this->load->model('Kalender_Model');
        //afspraken model
        $this->load->model('Afspraken_model');
        $this->load->model('Materiaal_model');
        
        //configuratie voor kalender
        $conf = array(
            'start_day' => 'Monday',
            'show_next_prev' => true,
            'day_type' => 'abr',
            'next_prev_url'   => site_url().'/kalender/maandOverzicht',
            'template' => $this->Kalender_Model->Template()
        );
        
        //library voor het tonen van de maand-kalender
        $this->load->library('calendar', $conf);
        
        if(((isset($_GET['dag']))&&(isset($_GET['id']))&&(isset($_GET['modal'])))){
            $intID = $_GET['modal'];
            $materiaalTabel = $this->Materiaal_model->TabelTonen($intID);
            //gegevens ophalen voor eigenschappenDialog (inhoud, title, id)
            $eigenschappenDialog = $this->Afspraken_model->EigenschappenTonen($intID,$materiaalTabel);
            $data['eigenschappen'] = $eigenschappenDialog['inhoudModal'];
        }
        //kijken of er een dag wordt geselecteerd
        if((isset($_GET['dag']))&&(isset($_GET['id']))){
            $dag = $_GET['dag'];
            $id = $_GET['id'];

            $data['afspraak'] = $this->Afspraken_model->toonInhoud($dag, $id);
        }
        
        //inhoud bevat de afspraken voor de huidige maand, deze worden opgehaald met ToonAfspraken
        $inhoud = array();
        
        $this->db->select('*');
        $this->db->like('startTijd', $jaar."-".$maand);
        $this->db->from('afspraken');
        $this->db->order_by('startTijd', "asc");
        $arrIets = $this->db->get();
        
        foreach ($arrIets->result() as $value) {
            $day = ltrim(date('d', strtotime($value->startTijd)), 0);
            if(array_key_exists($day, $inhoud)){
                 $inhoud[$day] = $inhoud[$day].','.$value->id;
            }else{
                 //array_push($inhoud, $_SERVER['PHP_SELF'].'?dag='.$day.'&id='.$afspraakID);
                 $inhoud[$day] = $_SERVER['PHP_SELF'].'?dag='.$day.'&id='.$value->id;
            }
        }

        $data['title'] = 'Maandoverzicht';
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();
        //kalender: bevat de kalender
        $data['kalender'] = $this->calendar->generate($jaar,$maand, $inhoud);
        if($blnPermission){
            if(isset($_POST['werkbon'])){
                header('Location: '.site_url().'/werkbon/index');
            }
            //header laden
            $this->load->view('templates/header', $data);
            $this->load->view('pages/maandOverzicht', $data);
            //footer laden
           $data['device'] = $this->helper_library->CreateFooter();
            $this->load->view('templates/footer', $data);
        }else{
            //redirect('login', 'refresh');
            header('Location: '.site_url().'/login');
        }     
    }
    public function weekOverzicht($jaar=null, $maand=null, $dag=null)
    {
        if ( ! file_exists('application/views/pages/weekOverzicht.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');
        
        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $menuConfig = array(
            'currentController' => 'kalender',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => $session_data['userrole']
        );
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van het huidige jaar
        if ($jaar==null) {
            $jaar = date('Y');
        }  
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van de huidige maand
        if ($maand==null) {
            $maand = date('m');
        }
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van de huidige dag
        if($dag == null){
            $dag = date('d');
        }
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //kalender model -> houdt de template bij
        $this->load->model('Kalender_Model');
        
        //configuratie voor kalender
        $conf = array (
                    'start_day'    => 'monday',
                    'month_type'   => 'short',
                    'day_type'     => 'abr',
                    'date'     => date(mktime(0, 0, 0, $maand, $dag, $jaar)),
                    'url' => 'kalender/weekOverzicht/',
                ); 
        
        //library voor het tonen van de maand-kalender
        $this->load->library('calendar_week', $conf);
        
        //bevat de afspraken voor de huidige maand
        $weeks = $this->calendar_week->get_week();
        $inhoud = array();
        for ($i=0;$i<count($weeks);$i++){
            $inhoud[$weeks[$i]] = '';
        }
        //$inhoud[$weeks[0]] = '<a href="#"><span class="tijdstip" align="center">15.00</span> Afspraak</a>';
        
        //$data bevat de inhoud van de webpagina
        //title: titel van de webpagina
        $data['title'] = 'Weekoverzicht';
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();
        //kalender: bevat de kalender
        $data['kalender'] = $this->calendar_week->generate($inhoud);
        if($blnPermission){
            //header laden
            $this->load->view('templates/header', $data);
            //inhoud laden
            $this->load->view('pages/weekOverzicht', $data);      
            $data['device'] = $this->helper_library->CreateFooter();
            $this->load->view('templates/footer', $data);
        }else{
            //redirect('login', 'refresh');
            header('Location: '.site_url().'/login');
        }
    }
      public function dagOverzicht($jaar=null, $maand=null,$dag = null){
        if ( ! file_exists('application/views/pages/dagOverzicht.php')) {show_404();}

        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');

        $this->load->library('Helper_Library');
        $data = $this->helper_library->Init();
        $menuConfig = array(
            'currentController' => 'kalender',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => $session_data['userrole']
        );
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van het huidige jaar
        if ($jaar==null) {$jaar = date('Y');}  
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van de huidige maand
        if ($maand==null) {$maand = date('m');}
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van de huidige dag
        if($dag ==null){$dag = date('d');}

        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);


        $this->load->library('Dag_Library');
        //kalender model -> houdt de template bij
        $this->load->model('Kalender_Model');
        //afspraken model
        $this->load->model('Afspraken_model');
        $this->load->model('Materiaal_model');
        $data['title'] = 'Dagoverzicht';
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();

        //kalender: bevat de kalender
        $arrAfspraken = $this->Kalender_Model->Afspraken($jaar,$maand,$dag);

        $data['kalender'] = $this->dag_library->GenerateView($jaar,$maand,$dag,$arrAfspraken);
        //$data['kalender']= $arrAfspraken["startTijd"];
        
        if(isset($_GET['id'])){
            $intID = $_GET['id'];
            $materiaalTabel = $this->Materiaal_model->TabelTonen($intID);
            //gegevens ophalen voor eigenschappenDialog (inhoud, title, id)
            $eigenschappenDialog = $this->Afspraken_model->EigenschappenTonen($intID,$materiaalTabel);
            $data['eigenschappen'] = $eigenschappenDialog['inhoudModal'];
        }
        
        if($blnPermission){
            //header laden
            $this->load->view('templates/header', $data);
            //inhoud laden
            $this->load->view('pages/dagOverzicht', $data);      
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
        //session_destroy();
        //redirect('login', 'refresh');
        header('Location: '.site_url().'/login');
    }
}

?>
