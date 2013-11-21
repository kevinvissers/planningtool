<?php

class Afspraken extends CI_Controller {
/**
 * @access	public
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @author              Bart Bollen <bart.bollen@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 */ 
    public function toevoegen(){
        if ( ! file_exists('application/views/pages/maandOverzicht.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        
        $data = $this->_init();
        
        if(isset($_POST['nieuweAfspraakSubmit']))
        {
            $arrNieuweAfspraak = array(
                'klantID' => $_POST['klantID']                
            );
        }
        
        //configuratie voor hoofdmenu 
        $menuConfig['active'] = true;
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //url helper -> voor de "base_url()" functie
        $this->load->helper('url');
        //afspraken model
        $this->load->model('Afspraken_model');
        $this->load->model('Klanten_model');
        
        $data['afspraakFormulier'] = $this->Afspraken_model->ToevoegenFormulierTonen();
        $data['klantenTabel'] = $this->Klanten_model->KlantenTabelTonen();
        
        //title: titel van de webpagina
        $data['title'] = 'afspraak toevoegen';
        //style: css opmaak
        $data['style'] = '.no-close .ui-dialog-titlebar-close {
                display: none;
            }';
        //script: javascript/jquery
        if(!isset($data['script']))
        {
            $data['script'] = '';
        }
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();
        
        //header laden
        $this->load->view('templates/header', $data);
        //inhoud laden
	$this->load->view('pages/afspraakFormulier', $data);
        //footer laden
        $data['device'] = $this->_footer();
	$this->load->view('templates/footer', $data);
        
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
            "afspraakFormulier" => ''
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
