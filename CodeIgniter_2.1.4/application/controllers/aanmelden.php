<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*   test dit is hier by gevult met git
 *  /
/**
 * Description of aanmelden
 *
 * @author Kevin
 */
class Aanmelden extends CI_Controller {
     public function login(){
         $menuConfig['active'] = true;
         //library voor het tonen van hoofdmenu
        $this->load->library('Menu_Library', $menuConfig);
        //url helper -> voor de "base_url()" functie
        $this->load->helper('url');
        
        if(isset($_POST['aanmelden'])){
            if(($_POST['gebruiker']=='admin')&&($_POST['wachtw']=='eloict')){
                redirect('/kalender/maandOverzicht');
            }           
        }
         
        //put your code here
        //$data bevat de inhoud van de webpagina
        //title: titel van de webpagina
        $data['title'] = 'maand overzicht';
        //style: css opmaak
        $data['style'] = '.no-close .ui-dialog-titlebar-close {
                display: none;
            }';
        //script: javascript/jquery
        $data['script'] = '';
        //menu: bevat het hoofdmenu
        $data['menu'] = $this->menu_library->ToonMenu();

        //header laden
        $this->load->view('templates/header', $data);
        //aanmeldpagina laden
        $this->load->view('templates/login'); 
        //footer laden
        $this->load->view('templates/footer', $data);
     }
}

?>
