<?php

/**
 * Werkbon_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Werkbon_model class has the following properties and methods:
 * properties:  
 * methods: 
 *
 */
class Werkbon_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    public function SelectAll($intAfspraakID){
        $arrGegevens = array(
            'naam' => '',
            'voornaam' => '',
            'straat' => '',
            'nummer' => '',
            'postcode' => '',
            'gemeente' => '',
            'telefoon' => '',
            'gsm' => '',
            'email' => '',
            'datum' => '',
            'startTijd' => '',
            'eindTijd' => '',
            'omschrijving' => '',
            'uitvoerder' => ''
        );  
        
        $this->db->select('*');
        $this->db->from('afspraken');
        $this->db->join('klanten','klanten.klantID = afspraken.klantID');
        $this->db->join('aanmeldgegevens','aanmeldgegevens.gebruikersID = afspraken.iduitvoerder');
        //$this->db->join('materiaallijst','materiaallijst.afspraakid = afspraken.id');
        //$this->db->join('functiegebruiker', 'aanmeldgegevens.idfunctie = functiegebruiker.idfunctie');
        $this->db->where('afspraken.id',$intAfspraakID);
        $objResult = $this->db->get();       
        /*foreach($objResult->result_array() as $key => $value){
            foreach ($value as $key2 => $value2) {
                echo $key2." : ";
                echo $value2.'<br>';   
                
                $result[$key2] = $value2;
            }
        }*/
        foreach($objResult->result() as $row){
            //echo $value;
            $arrGegevens['naam'] = $row->achternaam;
            $arrGegevens['voornaam'] = $row->voornaam;
            $arrGegevens['straat'] = $row->straat;
            $arrGegevens['postcode'] = $row->postcode;
            $arrGegevens['gemeente'] = $row->gemeente;
            $arrGegevens['telefoon'] = $row->telefoon;
            $arrGegevens['gsm'] = $row->gsm;
            $arrGegevens['email'] = $row->email;
            
            $timestamp = strtotime($row->startTijd);
            $arrGegevens['datum'] = date('d-m-Y', $timestamp);
            
            $timestamp = strtotime($row->startTijd);
            $arrGegevens['startTijd'] = date('G:i', $timestamp);
            
            $timestamp = strtotime($row->eindTijd);
            $arrGegevens['eindTijd'] = date('G:i', $timestamp);
            
            $arrGegevens['omschrijving'] = $row->omschrijving;
            $arrGegevens['uitvoerder'] = $row->gebruikersNaam;
        }
        
        return $arrGegevens;
    }
    public function geneerMateriaallijst($intAfspraakID){
        $arrMaterialen = array();
        
        $this->db->select('*');
        $this->db->from('materiaallijst');
        $this->db->where('afspraakid', $intAfspraakID);
        $this->db->join('materialen','materiaallijst.materiaalid = materialen.materiaalID');
        
        $objResult = $this->db->get();
        foreach ($objResult->result() as $row) {
            array_push($arrMaterialen, array($row->materiaalNaam,$row->aantal,$row->eenheid));   
        }
        return $arrMaterialen;
    }
}

?>
