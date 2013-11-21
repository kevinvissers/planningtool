<?php

/**
 * Afspraken_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @author              Bart Bollen <bart.bollen@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Afspraken_model class has the following properties and methods:
 * properties:  
 * methods: Toevoegen, Bewerken, Verwijderen, Tonen
 *
 */
class Afspraken_model extends CI_Model{
    /********************* METHODS ********************/
/**
 * @access	public
 */     
    function __construct()
    {
        parent::__construct();
    }
    /**
     * @author 		Kevin Vissers, Bart Bollen
     * @access 		public
     * @param           date $dateDatum datum
     * @param           time $dateTimeStartTijd starttijd
     * @param           time $dateTimeEindTijd eindtijd
     * @param           string $strOmschrijving omschrijving afspraak
     * @param           string $strKlantID klantID
     * @param           boolean $blnActief afspraak actief
     * @param           integer $intGebruikersID gebruikersID
     * @return          string Bevat informatie over de query 
     *
     */
    public function Toevoegen($dateDatum, $datetimeStartTijd, $datetimeEindTijd, $strOmschrijving, $strKlantID, $blnActief, $intGebruikersID) {
        //insert 
        $this->load->database();        
        try{
            $data = array(
                'datum' => $dateDatum,
                'klantID' => $strKlantID,
                'startTijd' => $datetimeStartTijd,
                'eindTijd' => $datetimeEindTijd,
                'omschrijving' => $strOmschrijving,
                'actief' => $blnActief,
                'gebruikersID' => $intGebruikersID
            );
            $this->db->insert('afspraken', $data); 
            return "data succesvol toegevoegd aan afspraken.";
        }catch (PDOException $exc) {
            return $exc->getMessage();
        }
    }
    
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param           integer $intID afspraakid
     * @param           date $dateDatum datum
     * @param           time $dateTimeStartTijd starttijd
     * @param           time $dateTimeEindTijd eindtijd
     * @param           string $strOmschrijving omschrijving afspraak
     * @param           string $strKlantID klantID
     * @param           boolean $blnActief afspraak actief
     * @param           integer $intGebruikersID gebruikersID
     * @return          string Bevat informatie over de query 
     *
     */
    public function Bewerken($intID, $dateDatum, $datetimeStartTijd, $datetimeEindTijd, $strOmschrijving, $strKlantID, $blnActief, $intGebruikersID) {
        //update 
        $this->load->database(); 
        try{
            $data = array(
                    'datum' => $dateDatum,
                    'klantID' => $strKlantID,
                    'startTijd' => $datetimeStartTijd,
                    'eindTijd' => $datetimeEindTijd,
                    'omschrijving' => $strOmschrijving,
                    'actief' => $blnActief,
                    'gebruikersID' => $intGebruikersID
                );
            $this->db->where('ID', $intID);
            $this->db->update('afspraken', $data); 
            return "data succesvol bijgewerkt.";
        }  catch (PDOException $exc){
            return $exc->getMessage();
        }
    }
    
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param           integer $intID afspraakid
     * @return          string Bevat informatie over de query 
     *
     */
    public function Verwijderen($intID){
        //delete
        $this->load->database(); 
        try{
            $this->db->delete('afspraken', array('ID' => $intID)); 
            return "data succesvol verwijderd.";
        }catch(PDOException $exc){
            return $exc->getMessage();
        }
    }
    
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param           integer $intID afspraakid
     * @return          array alle info over geselecteerde afspraak
     *
     */
    private function Tonen($intID){
        //return array
        $this->load->database(); 
        try{
            $query = $this->db->query('SELECT * FROM afspraken WHERE ID='.$intID.' ORDER BY startTijd');

            $resultaat = $query->result();
            return $resultaat;
        }catch(PDOException $exc){
            return "error: <br />".$exc->getMessage();
        }
    }
    
    public function EigenschappenTonen($intID){
        
        try{
            $arrGegevens = $this->allegegevens($intID);

            $arrResultaat = array();
            $arrResultaat['modalId'] = 'afspraakEigenschappenDialog';
            $arrResultaat['modalTitle'] = $arrGegevens['datum'];
            $arrResultaat['inhoudModal'] = '<form method="post">
            <table>
                <tr>
                    <td>Tijd:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$arrGegevens['startTijd'].' - '.$arrGegevens['eindTijd'].'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Klantgegevens:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$arrGegevens['voornaam'].'</td>
                    <td>'.$arrGegevens['achternaam'].'</td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$arrGegevens['straat'].'</td>
                    <td>'.$arrGegevens['huisnummer'].'</td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$arrGegevens['postcode'].'</td>
                    <td>'.$arrGegevens['gemeente'].'</td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$arrGegevens['telefoon'].'</td>
                    <td>'.$arrGegevens['gsm'].'</td>
                </tr>
                <tr>
                    <td>Omschrijving:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$arrGegevens['omschrijving'].'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Toegevoegd door:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Gebruikersnaam</td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="submit" name="wijzigen" value="Wijzigen" id="wijzigen" /></td>
                    <td><input type="submit" name="verwijderen" value="Verwijderen" id="verwijderen" /></td>
                    <td><input type="submit" name="materiaallijst" value="Materiaallijst" id="materiaallijst" /></td>
                </tr>
            </table>
            </form>';
        
            return $arrResultaat;
        
        }  catch (PDOException $exObject){
            return $exObject->getMessage();
        }
        
    }
    public function ToevoegenFormulierTonen() {
        $arrResultaat = '<form method="post" name="frmAfspraakToevoegen" class="custom">
            <fieldset>
                <legend>Afspraak Toevoegen</legend>
                
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtKlantnaam">Klantnaam</label>
                    <input type="text" placeholder="Klantnaam" id="txtKlantnaam">
                    <input type="hidden" name="klantID" id="hiddenKlantID">
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <label for="datepicker">Datum</label>
                    <input type="text" id="datepicker" name="datum" placeholder="Datum">
                </div>
            </div>
            
            <div class="row">
                <div class="large-6 columns">
                    <label for="ddStarttijd">Starttijd</label>
                    <select id="ddStarttijd" class="medium" name="starttijd">
                        <option>Kies een starttijd...</option>
                        <option>04:00</option>
                        <option>05:00</option>
                        <option>06:00</option>
                        <option>07:00</option>
                        <option>08:00</option>
                        <option>09:00</option>
                        <option>10:00</option>
                        <option>11:00</option>
                        <option>12:00</option>
                        <option>13:00</option>
                        <option>14:00</option>
                        <option>15:00</option>
                        <option>16:00</option>
                        <option>17:00</option>
                        <option>18:00</option>
                        <option>19:00</option>
                        <option>20:00</option>
                    </select>
                </div>
                <div class="large-6 columns">
                    <label for="ddEindtijd">Eindtijd</label>
                    <select id="ddEindtijd" class="medium" name="eindtijd">
                        <option>Kies een eindtijd...</option>
                        <option>04:00</option>
                        <option>05:00</option>
                        <option>06:00</option>
                        <option>07:00</option>
                        <option>08:00</option>
                        <option>09:00</option>
                        <option>10:00</option>
                        <option>11:00</option>
                        <option>12:00</option>
                        <option>13:00</option>
                        <option>14:00</option>
                        <option>15:00</option>
                        <option>16:00</option>
                        <option>17:00</option>
                        <option>18:00</option>
                        <option>19:00</option>
                        <option>20:00</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <label for="opmerking">Opmerking</label>
                    <textarea placeholder="Beschrijving van de afspraak" id="opmerking"></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="large-10 columns">
                    <label for=""switchActief>Afspraak actief :</label>
                </div>
                <div class="large-2 columns">
                    <div class="small-12 switch tiny">
                        <input id="nee" name="switchActief" type="radio">
                        <label for="a" onclick=""> Nee</label>

                        <input id="ja" name="switchActief" type="radio" checked>
                        <label for="a1" onclick="">Ja </label>

                        <span></span>
                      </div>
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>            

            <div class="row">
                <div class="large-6 columns">
                    <button type="submit" class="small button" name="nieuweAfspraakSubmit">Opslaan</button>
                </div>
                <div class="large-6 columns" align="right">
                    <a href="#" class="small button" name="btnMateriaalToevoegen">Materiaal toevoegen...</a>
                </div>
            </div>
            
            </fieldset>
            </form>';
        return $arrResultaat;
    }
    public function toonInhoud($dag, $id){
        $arrAfspraken = explode(',', $id);
        $data['afspraak'] = '';
        if($arrAfspraken != null){
            foreach($arrAfspraken as $afspraakID){
                $arrGegevens = $this->allegegevens($afspraakID);
                $data['afspraak'] = $data['afspraak']."<li><a href='".$_SERVER['PHP_SELF']."?dag=".$dag."&id=".$id."&modal=".$afspraakID."'>".$arrGegevens['startTijd'].": ".$arrGegevens['voornaam']." ".$arrGegevens['achternaam']."</a></li>";             
            }
        }else{
            $arrGegevens = $this->allegegevens($afspraakID);
            $data['afspraak'] = $data['afspraak']."<li><a href='".$_SERVER['PHP_SELF']."?dag=".$dag."&id=".$id."&modal=".$afspraakID."'>".$arrGegevens['startTijd'].": ".$arrGegevens['voornaam']." ".$arrGegevens['achternaam']."</a></li>";
        }
        return $data['afspraak'];
    }
    private function allegegevens($intID){
        $arrAfspraakEigenschappen = $this->Tonen($intID);
        $gegevens = array();
        foreach ($arrAfspraakEigenschappen as $row) {
            $gegevens['datum'] = $row->datum;
            $gegevens['klantID'] = $row->klantID;
            $gegevens['startTijd'] = $row->startTijd;
            $gegevens['eindTijd'] = $row->eindTijd;
            $gegevens['omschrijving'] = $row->omschrijving;
            $gegevens['materiaalID'] = $row->materiaalID;
            $gegevens['actief'] = $row->actief;
            $gegevens['gebruikersID'] = $row->gebruikersID;
        }

        $timestamp = strtotime($row->startTijd);
        $gegevens['startTijd'] = date("G:i", $timestamp);
        $timestamp = strtotime($row->eindTijd);
        $gegevens['eindTijd'] = date("G:i", $timestamp);

        $arrKlantEigenschappen = $this->db->query('SELECT * FROM klanten WHERE klantID='.$gegevens['klantID']);

        foreach ($arrKlantEigenschappen->result() as $row)
        {
            $gegevens['voornaam'] = $row->voornaam;
            $gegevens['achternaam'] = $row->achternaam;
            $gegevens['straat'] = $row->straat;
            $gegevens['huisnummer'] = $row->huisnummer;
            $gegevens['postcode'] = $row->postcode;
            $gegevens['gemeente'] = $row->gemeente;
            $gegevens['telefoon'] = $row->telefoon;
            $gegevens['gsm'] = $row->gsm;
            $gegevens['opmerking'] = $row->opmerking;
        }
        return $gegevens;
    }
            
}

?>
