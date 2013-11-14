<?php

/**
 * Afspraken_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
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
     * @author 		Kevin Vissers
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
    public function Tonen($intID){
        //return array
        $this->load->database(); 
        try{
            //$resultaat = $this->db->get_where('afspraken', array('ID' => $intID));
            $query = $this->db->query('SELECT * FROM afspraken WHERE ID='.$intID);
            $resultaat = $query->result();
            return $resultaat;
        }catch(PDOException $exc){
            return "error: <br />".$exc->getMessage();
        }
    }
    
    public function EigenschappenTonen($intID){
        
        try{
            $arrAfspraakEigenschappen = $this->Tonen($intID);
            foreach ($arrAfspraakEigenschappen as $row) {
                $datum = $row->datum;
                $klantID = $row->klantID;
                $startTijd = $row->startTijd;
                $eindTijd = $row->eindTijd;
                $omschrijving = $row->omschrijving;
                $materiaalID = $row->materiaalID;
                $actief = $row->actief;
                $gebruikersID = $row->gebruikersID;
            }
            
            $timestamp = strtotime($row->startTijd);
            $startTijd = date("G:i", $timestamp);
            $timestamp = strtotime($row->eindTijd);
            $eindTijd = date("G:i", $timestamp);
            
            $arrKlantEigenschappen = $this->db->query('SELECT * FROM klanten WHERE klantID='.$klantID);

            foreach ($arrKlantEigenschappen->result() as $row)
            {
                $voornaam = $row->voornaam;
                $achternaam = $row->achternaam;
                $straat = $row->straat;
                $huisnummer = $row->huisnummer;
                $postcode = $row->postcode;
                $gemeente = $row->gemeente;
                $telefoon = $row->telefoon;
                $gsm = $row->gsm;
                $opmerking = $row->opmerking;
            }

            $arrResultaat = array();
            $arrResultaat['modalId'] = 'afspraakEigenschappenDialog';
            $arrResultaat['modalTitle'] = $datum;
            $arrResultaat['inhoudModal'] = '<form method="post">
            <table>
                <tr>
                    <td>Tijd:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$startTijd.' - '.$eindTijd.'</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Klantgegevens:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$voornaam.'</td>
                    <td>'.$achternaam.'</td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$straat.'</td>
                    <td>'.$huisnummer.'</td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$postcode.'</td>
                    <td>'.$gemeente.'</td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$telefoon.'</td>
                    <td>'.$gsm.'</td>
                </tr>
                <tr>
                    <td>Omschrijving:</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>'.$omschrijving.'</td>
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
        $arrResultaat = '<form method="post">
            <table>
            <tr>
            <td>Klantnaam</td>
            <td></td>
            </tr>
            <tr>
            <td><input type="text" name="klantnaam" /></td>
            <td><button name="klantToevoegen">Nieuw...</button></td>
            </tr>
            <tr>
            <td>Datum</td>
            <td></td>
            </tr>
            <tr>
            <td><input type="text" name="datum" /></td>
            </tr>
            <tr>
            <td>start tijd</td>
            <td>eind tijd</td>
            </tr>
            <tr>
            <td><input type="text" /></td>
            <td><input type="text" /></td>
            </tr>
            <tr>
            <td>Omschrijving</td>
            </tr>
            <tr>
            <td colspan="2">
            <textarea rows="4" cols="50"></textarea>
            </td>
            </tr>
            <tr>
            <td>Afpraak actief</td>
            <td><input type="checkbox" name="actief" value="actief" /></td>
            </tr>
            <tr>
            <td><input type="submit" value="Toevoegen" name="toevoegen" /></td>
            <td><input type="submit" value="Materiaallijst toevoegen" name="matlijsttoevoegen" /></td>
            <td></td>
            </tr>
            </table>
            </form>';
    }
            
}

?>
