<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kalender
 *
 * @author Kevin
 */
class Kalender extends CI_Controller {
    public function maandOverzicht($jaar=null, $maand=null)
    {
        if ( ! file_exists('application/views/pages/maandOverzicht.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        //variabele die aanduid of gebruiker is aangemeld of niet
        $blnLogin = false;
        $blnLoginActive = false;
        
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van het huidige jaar
        if ($jaar==null) {
            $jaar = date('Y');
        }  
        //als deze parameter niet wordt meegegeven in de url krijgt deze de waarde van de huidige maand
        if ($maand==null) {
            $maand = date('m');
        }
        //kijken of gebruiker zich aanmeld
                
        //configuratie voor hoofdmenu 
        $menuConfig['active'] = true;
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //url helper -> voor de "base_url()" functie
        $this->load->helper('url');
        //kalender model -> houdt de template bij
        $this->load->model('Kalender_Model');
        //afspraken model
        $this->load->model('Afspraken_model');
        
        //configuratie voor kalender
        $conf = array(
            'start_day' => 'Monday',
            'show_next_prev' => true,
            'day_type' => 'abr',
            'next_prev_url'   => base_url().'index.php/kalender/maandOverzicht',
            'template' => $this->Kalender_Model->Template()
        );
        
        //library voor het tonen van de maand-kalender
        $this->load->library('calendar', $conf);
        
        if(isset($_POST['aanmelden'])){
            if(($_POST['gebruiker'] == 'admin')&&($_POST['wachtw']== 'eloict')){
                $blnLogin = true;
            }
        }
        if(((isset($_GET['dag']))&&(isset($_GET['id']))&&(isset($_GET['modal'])))){
            //gegevens ophalen voor eigenschappenDialog (inhoud, title, id)
            $eigenschappenDialog = $this->Afspraken_model->EigenschappenTonen($_GET['modal']);
            // id voor jQuery toewijzen
            $data['modalId'] = $eigenschappenDialog['modalId'];
            // datum toewijzen aan titel
            $data['modalTitle'] = $eigenschappenDialog['modalTitle'];
            // inhoud toewijzen
            $data['inhoudModal'] = $eigenschappenDialog['inhoudModal'];
            // dialog openen
            $data['script'] = '$(function() {
                $( "#afspraakEigenschappenDialog" ).dialog({
                    autoOpen: true,
                    width: "auto",
                    modal:true
                });
            });';
        }
        //kijken of er een dag wordt geselecteerd
        if((isset($_GET['dag']))&&(isset($_GET['id']))){
            //dag opslaan
            $dag = $_GET['dag'];
            //afspraken opslaan in array
            $arrAfspraken = explode(',', $_GET['id']);
            
            $data['afspraak'] = '';
            //kijken of er 1 of meerdere afspraken zijn (1 afspraak -> array = null)
            //arrAfspraken bevat de afspraak id's
            if($arrAfspraken != null){
                //voor elke afspraak in de array de bijhorende gegevens opvragen
                foreach($arrAfspraken as $afspraakID){
                    // eigenschappen-knop toevoegen
                    $data['afspraak'] = $data['afspraak']."<li><a href='".'/index.php'.$_SERVER['PHP_SELF']."?dag=".$_GET['dag']."&id=".$_GET['id']."&modal=".$afspraakID."'>Eigenschappen</a></li>";             
                }
            }else{
                //eigenschappen-knop toevoegen
                $data['afspraak'] = $data['afspraak']."<li><a href='".'/index.php'.$_SERVER['PHP_SELF']."?dag=".$_GET['dag']."&id=".$_GET['id']."&modal=".$afspraakID."'>Eigenschappen</a></li>";
            }
        }else{
            //afspraken: bevat alle info over de afspraak
            $data['afspraak'] = '<p align="center">Geen afspraak geselecteerd</p>';
        }
        
        //inhoud bevat de afspraken voor de huidige maand, deze worden opgehaald met ToonAfspraken
        $inhoud = array();
        foreach ($this->Kalender_Model->ToonAfspraken($maand, $jaar) as $row)
        {
            //afspraakID
            $afspraakID = $row->ID;
            //datum omvormen naar timestamp
            $timestamp = strtotime($row->datum);
            //dag uit timestamp filteren
            $day = date('d', $timestamp);
            //voorafgaande "0" verwijderen
            $day = ltrim($day, '0');
            
            //$inhoud[$day] = $_SERVER['PHP_SELF'].'?dag='.$day;
            if(array_key_exists($day, $inhoud)){
                 $inhoud[$day] = $inhoud[$day].','.$afspraakID;
            }else{
                 //array_push($inhoud, $_SERVER['PHP_SELF'].'?dag='.$day.'&id='.$afspraakID);
                 $inhoud[$day] = '/index.php'.$_SERVER['PHP_SELF'].'?dag='.$day.'&id='.$afspraakID;
            }
        }
        
        //$data['arrayding'] = $inhoud;
        //$data bevat de inhoud van de webpagina
        //title: titel van de webpagina
        $data['title'] = 'maand overzicht';
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
        //kalender: bevat de kalender
        $data['kalender'] = $this->calendar->generate($jaar,$maand, $inhoud);
        
        //header laden
        $this->load->view('templates/header', $data);
        //inhoud laden
	$this->load->view('pages/maandOverzicht', $data);
        //aanmeldpagina laden
        if((!$blnLogin)&&($blnLoginActive)){
            $this->load->view('templates/login');
        }  
        //dialog laden, als dit nodig is
        if(isset($_GET['modal'])){
            $this->load->view('templates/emptyModal');
        }
        //footer laden
	$this->load->view('templates/footer', $data);
    }
    public function weekOverzicht($jaar=null, $maand=null, $dag=null)
    {
        if ( ! file_exists('application/views/pages/weekOverzicht.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        //variabele die aanduid of gebruiker is aangemeld of niet
        $blnLogin = false;
        $blnLoginActive = false;
        
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
        
        //kijken of gebruiker zich aanmeld
        if(isset($_POST['aanmelden'])){
            if(($_POST['gebruiker'] == 'admin')&&($_POST['wachtw']== 'eloict')){
                $blnLogin = true;
            }
        }
        
        //configuratie voor hoofdmenu 
        $menuConfig['active'] = true;
        
        //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //url helper -> voor de "base_url()" functie
        $this->load->helper('url');
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
        $data['title'] = 'week overzicht';
        //style: css opmaak
        $data['style'] = '.no-close .ui-dialog-titlebar-close {
                display: none;
            }';
        //script: javascript/jquery
        $data['script'] = '';
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();
        //kalender: bevat de kalender
        $data['kalender'] = $this->calendar_week->generate($inhoud);
        
        //header laden
        $this->load->view('templates/header', $data);
        //inhoud laden
	$this->load->view('pages/weekOverzicht', $data);
        //aanmeldpagina laden
        if((!$blnLogin)&&($blnLoginActive)){
            $this->load->view('templates/login');
        }       
        //footer laden
	$this->load->view('templates/footer', $data);
    }
}

?>
