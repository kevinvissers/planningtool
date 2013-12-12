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
    public function Toevoegen($data) {
        //insert 
        $this->load->database();        
        try
        {            
            $this->db->insert('afspraken', $data); 
            return '<br><br>
                <div data-alert class="alert-box success radius">
                        Uw afspraak werd vastegelegd !
                        <a href="#" class="close">&times;</a>
                    </div>';
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
    public function Bewerken($intID, $data) {
        //update 
        $this->load->database(); 
        try
        {
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
            $this->db->select('*');
            $this->db->from('afspraken');
            $this->db->where('ID', $intID);
            
            $query = $this->db->get();
            
            $resultaat = $query->result();
            return $resultaat;
        }catch(PDOException $exc){
            return "error: <br />".$exc->getMessage();
        }
    }
    
    public function EigenschappenTonen($intID){
        
        try{
            $arrGegevens = $this->allegegevens($intID);
            
            $this->db->select('*');
            $this->db->from('aanmeldgegevens');
            $this->db->where('gebruikersID', $arrGegevens['gebruikersID']);
            $objGebruiker = $this->db->get();

            $strGebruiker = $objGebruiker->result_array();
            
            /*$this->db->select('*')->from('aanmeldgegevens')->where('gebruikersID', 3);
            $objUitvoerder = $this->db->get();
            
            $strUitvoerder = $objGebruiker->result_array();
            
            print_r($strUitvoerder);*/
            
            $arrResultaat = array();
            $arrResultaat['modalId'] = 'afspraakEigenschappenDialog';
            $arrResultaat['modalTitle'] = date('d-m-Y', strtotime($arrGegevens['datum']));
            $arrResultaat['inhoudModal'] = '<form method="POST" >
                <input type="hidden" name="id" value="'.$intID.'" />
	<div class="row">	
		<div class="large-4 columns">
			<p class="labelfontbold">Klantgegevens:</p>
		</div>
                <div class="large-8 columns">
			<p class="labelfont">'.$arrGegevens['voornaam'].' '.$arrGegevens['achternaam'].'</p>
		</div>
	</div>
	<div class="row">
		<div class="large-4 columns">
		</div>
		<div class="large-8 columns">
			<p class="labelfont">'.$arrGegevens['straat'].' '.$arrGegevens['huisnummer'].'</p>
		</div>
	</div>
	<div class="row">
		<div class="large-4 columns">
		</div>
		<div class="large-8 columns">
			<p class="labelfont">'.$arrGegevens['postcode'].' '.$arrGegevens['gemeente'].'</p>
		</div>
	</div>
        	<div class="row">
		<div class="large-4 columns">
		</div>
		<div class="large-8 columns">
			<p class="labelfont">T: '.$arrGegevens['telefoon'].' - GSM: '.$arrGegevens['gsm'].'</p>
		</div>
	</div>
        <div class="row">
		<div class="large-4 columns">
			<p class="labelfontbold">Datum:</p>
		</div>
		<div class="large-8 columns">
			<p class="labelfont">'.date('d-m-Y', strtotime($arrGegevens['datum'])).'</p>
		</div>
	</div>
	<div class="row">
		<div class="large-4 columns">
			<p class="labelfontbold">Tijd:</p>
		</div>
		<div class="large-8 columns">
			<p class="labelfont">'.$arrGegevens['startTijd'].' - '.$arrGegevens['eindTijd'].'</p>
		</div>
	</div>
	<div class="row">
		<div class="large-4 columns">
			<p class="labelfontbold">Omschrijving:</p>
		</div>
		<div class="large-8 columns">
			<p class="labelfont">'.$arrGegevens['omschrijving'].'</p>
		</div>
	</div>
	<div class="row">
		<div class="large-4 columns">
			<p class="labelfontbold">Toegevoegd door:</p>
		</div>
		<div class="large-8 columns">
			<p class="labelfont">'.$strGebruiker[0]['gebruikersNaam'].'</p>
		</div>
	</div>
        <!--<div class="row">
            <div class="large-4 columns">
                <p class="labelfontbold">Uitvoerder:</p>
            </div>
            <div class="large-8 columns">
                <p></p>
            </div>-->
	<div class="row">
		<div class="large-3 columns">
			<a class="small button" href="'.site_url().'/afspraken/bewerken?id='.$intID.'">Wijzigen</a>
		</div>
		<div class="large-3 columns">
			<h6><input type="submit" class="small button" name="verwijderen" value="Verwijderen" id="verwijderen" /></h6>
		</div>
		<div class="large-3 columns">
			<h6><a href="'.site_url().'/materialen/tonen/'.$intID.'">Materiaallijst...</a></h6>
		</div>
                <div class="large-3 columns">
			<h6><a href="'.site_url().'/werkbon/index/'.$intID.'" target="_blank">Werkbon</a></h6>
		</div>
	</div>
</form>';
        
            return $arrResultaat;
        
        }  catch (PDOException $exObject){
            return $exObject->getMessage();
        }
        
    }
    public function ToevoegenFormulierTonen($intKlantID,$strKlntVoornaam,$strKlantAchternaam) {
        $this->db->select('*');
        $this->db->from('aanmeldgegevens');
        $query = $this->db->get();
        
                
        $arrResultaat = '<form method="post" name="frmAfspraakToevoegen" class="custom">
            <fieldset>
                <legend>Afspraak Toevoegen</legend>
                
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtKlantnaam">Klantnaam</label>
                    <input type="text" placeholder="Klantnaam" id="txtKlantnaam" value="'.$strKlantAchternaam.'&nbsp;'.$strKlntVoornaam.'" readonly required>
                    <input type="hidden" name="klantID" id="hiddenKlantID" value="'.$intKlantID.'">
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <label for="datepicker">Datum</label>
                    <input type="text" id="datepicker" name="datum" placeholder="Datum" required>
                </div>
            </div>
            
            <div class="row">
                <div class="large-6 columns">
                    <label for="Starttijd">Starttijd</label>
                    <input type="text" id="Starttijd" name="starttijd" placeholder="00:00" required>
                </div>
                <div class="large-6 columns">
                    <label for="Eindtijd">Eindtijd</label>
                    <input type="text" id="Eindtijd" name="eindtijd" placeholder="00:00" required>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="ddSelectUitvoerder">Uitvoerder :</label>
                    <select class="large" name="ddSelectUitvoerder" id="ddSelectUitvoerder">
                        <option>Kies een uitvoerder</option>';
            foreach ($query->result() as $row){ 
                $arrResultaat .= '<option value="'.$row->gebruikersID.'">'.$row->gebruikersNaam.'</option>';     
            }
            $arrResultaat .='</select>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="opmerking">Opmerking</label>
                    <textarea placeholder="Beschrijving van de afspraak" id="opmerking" name="opmerking"></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="large-10 columns">
                    <label for=""switchActief>Afspraak actief :</label>
                </div>
                <div class="large-2 columns">
                    <div class="small-12 switch tiny">
                        <input id="nee" name="switchActief" type="radio" value="0">
                        <label for="a" onclick=""> Nee</label>

                        <input id="ja" name="switchActief" type="radio" value="1" checked>
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
            $gegevens['klantID'] = $row->klantID;
            $gegevens['datum'] = $row->startTijd;
            $gegevens['startTijd'] = $row->startTijd;
            $gegevens['eindTijd'] = $row->eindTijd;
            $gegevens['omschrijving'] = $row->omschrijving;
            $gegevens['actief'] = $row->actief;
            $gegevens['gebruikersID'] = $row->gebruikersID;
            $gegevens['iduitvoerder'] = $row->iduitvoerder;
        }

        $timestamp = strtotime($row->startTijd);
        $gegevens['startTijd'] = date("G:i", $timestamp);
        $timestamp = strtotime($row->eindTijd);
        $gegevens['eindTijd'] = date("G:i", $timestamp);

        //$arrKlantEigenschappen = $this->db->query('SELECT * FROM klanten WHERE klantID='.$gegevens['klantID']);
        
        $this->db->select('*');
        $this->db->from('klanten');
        $this->db->join('gemeente', 'gemeente.idgemeente = klanten.idgemeente');
        $this->db->where('klanten.klantID', $gegevens['klantID']);
        
        $arrKlantEigenschappen = $this->db->get();
        
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
    
    public function BewerkFormulier($intAfspraakID){
        $arrAfspraakEigenschappen = $this->allegegevens($intAfspraakID);
        
        $startDate = date_create($arrAfspraakEigenschappen['datum']);
        
        //alle gebruikers selecteren die niet als huidige uitvoerder zijn aangeduid
        $this->db->select('*');
        $this->db->from('aanmeldgegevens');
        $this->db->where_not_in('gebruikersID', $arrAfspraakEigenschappen['iduitvoerder']);
        $query = $this->db->get();
        
        //uitvoerder selecteren
        $this->db->select('*');
        $this->db->from('aanmeldgegevens');
        $this->db->where('gebruikersID', $arrAfspraakEigenschappen['iduitvoerder']);
        $currentUser = $this->db->get();
        
                
        $strHtml = '<form method="post" name="frmAfspraakToevoegen" class="custom">
            <fieldset>
                <legend>Afspraak bewerken</legend>  
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtKlantnaam">Klantnaam</label>
                    <input type="hidden" name="klantID" id="hiddenKlantID" value="'.$arrAfspraakEigenschappen['klantID'].'">
                    <input type="text" placeholder="Klantnaam" id="txtKlantnaam" value="'.$arrAfspraakEigenschappen['achternaam'].' '.$arrAfspraakEigenschappen['voornaam'].'" readonly required>
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <label for="datepicker">Datum</label>
                    <input type="text" id="datepicker" name="datum" placeholder="Datum" value="'.date_format($startDate, 'm/d/Y').'" required>
                </div>
            </div>
            
            <div class="row">
                <div class="large-6 columns">
                    <label for="Starttijd">Starttijd</label>
                    <input type="text" id="Starttijd" name="starttijd" placeholder="00:00" value="'.$arrAfspraakEigenschappen['startTijd'].'" required>
                </div>
                <div class="large-6 columns">
                    <label for="Eindtijd">Eindtijd</label>
                    <input type="text" id="Eindtijd" name="eindtijd" placeholder="00:00" value="'.$arrAfspraakEigenschappen['eindTijd'].'" required>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="ddSelectUitvoerder">Uitvoerder :</label>
                    <select class="large" name="ddSelectUitvoerder" id="ddSelectUitvoerder">';
            foreach ($currentUser->result() as $rij){ 
                $strHtml .='
                <option value="'.$rij->gebruikersID.'">'.$rij->gebruikersNaam.'</option>';
            }
            foreach ($query->result() as $row){ 
                $strHtml .= '<option value="'.$row->gebruikersID.'">'.$row->gebruikersNaam.'</option>';
            }
            $strHtml .='</select>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="opmerking">Opmerking</label>
                    <textarea placeholder="Beschrijving van de afspraak" id="opmerking" name="opmerking">'.$arrAfspraakEigenschappen['omschrijving'].'</textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="large-10 columns">
                    <label for=""switchActief>Afspraak actief :</label>
                </div>
                <div class="large-2 columns">';
                    if ($arrAfspraakEigenschappen['actief'] == '1')
                    {
                        $strHtml .='<div class="small-12 switch tiny">
                        <input id="nee" name="switchActief" type="radio" value="0">
                        <label for="a" onclick=""> Nee</label>

                        <input id="ja" name="switchActief" type="radio" value="1" checked>
                        <label for="a1" onclick="">Ja </label>

                        <span></span>
                      </div>';
                    }
                    else
                    {
                        $strHtml .='<div class="small-12 switch tiny">
                        <input id="nee" name="switchActief" type="radio" value="0" checked>
                        <label for="a" onclick=""> Nee</label>

                        <input id="ja" name="switchActief" type="radio" value="1">
                        <label for="a1" onclick="">Ja </label>

                        <span></span>
                      </div>';
                    }
                    
                $strHtml .='</div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>            

            <div class="row">
                <div class="large-12 columns">
                    <button type="submit" class="small button" name="bewerkAfspraakSubmit">Opslaan</button>
                </div>
            </div>
            
            </fieldset>
            </form>';
        
        return $strHtml;
    }
            
}

?>
