<?php
/**
 * Gebruikers_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		24/11/2013
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
    public function AanmaakFormulier(){
        $strHTML = '<form method="post" name="frmGebruikerToevoegen" class="custom">
            <fieldset>
                <legend>Gebruiker Toevoegen</legend>   
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtKlantnaam">Gebruikersnaam (email)</label>
                    <input type="email" placeholder="gebruikersnaam" name="user" required />
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="datepicker">Wachtwoord</label>
                    <input type="text" name="pass" placeholder="Wachtwoord" value="'.$this->GenereerNieuwWachtwoord().'" readonly>
                </div>
            </div>
            
            <div class="row">
                <div class="large-6 columns">
                    <label for="ddStarttijd">Account type</label>
                    <select class="medium" name="type">
                        <option value="4">standaard account</option>
                        <option value="3">administrator account</option>
                        <option value="5">bezoeker account</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>            
            <div class="row">
                <div class="large-6 columns">
                    <button type="submit" class="small button" name="toevoegen">Opslaan</button>
                </div>
            </div>
            </fieldset>
            </form>';
        return $strHTML;
    }
    public function Aanmaken($arrNieuweGebruikersGegevens){
        try{
            $exists = $this->db->get_where('aanmeldgegevens', array('gebruikersNaam' => $arrNieuweGebruikersGegevens['gebruikersNaam']));
            //return print_r($exists->result_array());
            if($exists->result_array() ==null){
                $query = $this->db->query("INSERT INTO `aanmeldgegevens`(`gebruikersNaam`, `wachtwoord`, `idfunctie`) VALUES ('".$arrNieuweGebruikersGegevens['gebruikersNaam']."','".$arrNieuweGebruikersGegevens['wachtwoord']."',".$arrNieuweGebruikersGegevens['idfunctie'].")");
                return "Gebruiker succesvol toegevoegd.";               
            }else{
                return "Gebruiker bestaat al!";
            }
        }catch(PDOException $ex){
            return $ex->getMessage();
        }
    }
    public function WachtwoordWijzigen($strGebruikersNaam, $strNieuwWachtwoord, $strOudWachtwoord=null){
        try{
            $data = array(
                   'wachtwoord' => md5($strNieuwWachtwoord)
                );

            $this->db->where('gebruikersNaam', $strGebruikersNaam);
            if($strOudWachtwoord!=null){
                $this->db->where('wachtwoord', md5($strOudWachtwoord));
            }
            $this->db->update('aanmeldgegevens', $data); 
            return 'Wachtwoord succesvol gewijzigd.';
        }catch(PDOException $ex){
            return $ex->getMessage();
        }
    }
    public function WachtwoordVergeten($strGebruikersNaam){
        $strNieuwWachtwoord = $this->GenereerNieuwWachtwoord();
        $this->MailNieuwWachtwoord($strGebruikersNaam, $strNieuwWachtwoord);
        $strNieuwWachtwoord = md5($strNieuwWachtwoord);
        $this->VergetenWachtwoordWijzigen($strGebruikersNaam, $strNieuwWachtwoord);
        return '<p>Het nieuwe wachtwoord is doorgemaild naar '.$strGebruikersNaam.'.<br />U kan dit wachtwoord wijzigen.</p>';
    }
    public function Bewerken($arrGebruikersGegevens){
        $this->db->where('gebruikersID', $arrGebruikersGegevens['gebruikersID']);
        $this->db->update('aanmeldgegevens',$arrGebruikersGegevens);
    }
    public function Tonen($intGebruikersID){
        $this->db->select('*');
        $this->db->where('gebruikersID', $intGebruikersID);
        $this->db->from('aanmeldgegevens');
        $this->db->join('functiegebruiker', 'aanmeldgegevens.idfunctie = functiegebruiker.idfunctie');

        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            echo $row->gebruikersID;
            echo $row->gebruikersNaam;
            echo $row->functienaam;
            
            $strHTML = '<form method="post" name="frmGebruikerToevoegen" class="custom">
            <fieldset>
                <legend>Gebruiker Bewerken</legend>   
            <div class="row">
                <input type="hidden" name="userid" value="'.$row->gebruikersID.'" >
                <div class="large-12 columns">
                    <label for="txtKlantnaam">Gebruikersnaam (email)</label>
                    <input type="email" placeholder="gebruikersnaam" value="'.$row->gebruikersNaam.'" name="user" required />
                </div>
            </div>
            
            <div class="row">
                <div class="large-6 columns">
                    <label for="ddStarttijd">Account type</label>
                    <select class="medium" name="type">
                        <option value="4">standaard account</option>
                        <option value="3">administrator account</option>
                        <option value="5">bezoeker account</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>            
            <div class="row">
                <div class="large-6 columns">
                    <button type="submit" class="small button" name="update">Opslaan</button>
                </div>
            </div>
            </fieldset>
            </form>';
        }
        
        return $strHTML;
    }
    public function GenereerNieuwWachtwoord(){
        //$this->load->library('encrypt');
        //$msg = "kevin";
        //$strNieuwWachtwoord = $this->encrypt->encode($msg);
        $strNieuwWachtwoord = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&@#"),0,8);
        //$strNieuwWachtwoord = md5(uniqid(rand(), true));
        //$strNieuwWachtwoord = uniqid(rand(7,10), true);
        //$strNieuwWachtwoord = substr(str_shuffle( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ), 0, 1).substr( md5( time() ), 1);
        return $strNieuwWachtwoord;
    }
    private function MailNieuwWachtwoord($strGebruikersNaam, $strNieuwWachtwoord){

    }
    private function VergetenWachtwoordWijzigen($strGebruikersNaam, $strNieuwWachtoord){
        
    }
    /**
 * @access	public
 */
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param 		string $strUserName
     * @return 		array
     *
     */ 
    public function getUserCredentials($strUserName){
        try {
            $this->load->database();
            $query = $this->db->query("SELECT `aanmeldgegevens`.`gebruikersID` , `aanmeldgegevens`.`wachtwoord` , `functiegebruiker`.`userrole`
                                        FROM aanmeldgegevens
                                        LEFT JOIN `planner`.`functiegebruiker` ON `aanmeldgegevens`.`idfunctie` = `functiegebruiker`.`idfunctie`
                                        WHERE `aanmeldgegevens`.`gebruikersNaam` = '".$strUserName."'");

            $resultaat = $query->result_array();
            return $resultaat;
        }catch (PDOException $e){
            $strErrorMessage = $e->getMessage();
            return $strErrorMessage;
        }
   }
    public function AlleGebruikersTonen(){
        $strHTML = '<fieldset>
                <legend>Selecteer gebruiker</legend> ';
        
        $this->db->select('*'); 
        $this->db->from('aanmeldgegevens'); 

        $query = $this->db->get();

        foreach ($query->result() as $row){ 
            $strHTML .= '<form method="POST" name="frmAlleGebruikersTonen" class="custom">
             
            <div class="row">
                <div class="large-12 columns">
                    <div class="large-6 columns">
                        <label>'.$row->gebruikersNaam.'</label>
                    </div>
                    <div class="large-3 columns">
                        <input type="hidden" name="userid" value="'.$row->gebruikersID.'" >
                        <input type="submit" class="small button" name="Bewerken" value="Bewerken" >
                    </div>
                    <div class="large-3 columns">
                        <input type="submit" class="small button" name="Verwijderen" value="Verwijderen" >
                    </div>
                </div>
            </div>
            </form>';     
        } 
        $strHTML .= '</fieldset>';
        return $strHTML;
    }
    public function Verwijderen($intGebruikersID){
        $this->db->delete('aanmeldgegevens', array('gebruikersID' => $intGebruikersID));
    }
}
?>
