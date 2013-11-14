<?php

/**
 * Gebruikers_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Gebruikers_model class has the following properties and methods:
 * properties:  strGebruikersNaam, strWachtwoord, intGebruikersID, $strGebruikersFunctie
 * methods: GebruikerAanmaken, WachtwoordWijzigen, GebruikerWijzigen, GebruikerTonen
 *
 */
class Gebruiker_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    public function Aanmaken($arrNieuweGebruikersGegevens){
    }
    public function WachtwoordWijzigen($intGebruikersID, $strNieuwWachtwoord, $strOudWachtwoord){
        
    }
    public function WachtwoordVergeten($strGebruikersNaam){
        $strNieuwWachtwoord = $this->GenereerNieuwWachtwoord();
        $this->MailNieuwWachtwoord($strGebruikersNaam, $strNieuwWachtwoord);
        return '<p>Het nieuwe wachtwoord is doorgemaild naar '.$strGebruikersNaam.'.<br />U kan dit wachtwoord wijzigen.</p>';
    }
    public function Bewerken($arrGebruikersGegevens){
        
    }
    public function Tonen($intGebruikersID){
        
    }
    private function GenereerNieuwWachtwoord(){
        return $strNieuwWachtwoord;
    }
    private function MailNieuwWachtwoord($strGebruikersNaam, $strNieuwWachtwoord){
        
    }
}
?>
