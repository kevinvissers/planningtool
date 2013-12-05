<?php
/**
 * Klanten_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @author              Bart Bollen <bart.bollen@student.khlim.be>
 * @version		1.0
 * @date		28/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Klanten_model class has the following properties and methods:
 * properties:  
 * methods: 
 *
 */
class Klanten_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    public function KlantenTabelTonen() 
    {
        $strHTML = '<div class="row">
                        <div class="large-12 columns">
                            <h6>Kies in onderstaande lijst een klant</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <label for="txtKlantZoeken">Zoek een klant</label>
                            <input type="text" placeholder="Klantnaam" id="txtKlantZoeken">
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <table>
                                <thead>
                                  <tr>
                                    <th>Klant</th>
                                    <th>Adres</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>Bart Bollen</td>
                                    <td>Aarschot</td>
                                  </tr>
                                  <tr>
                                    <td>Kevin Vissers</td>
                                    <td>Averbode</td>
                                  </tr>
                                  <tr>
                                    <td>Dylan Derwael</td>
                                    <td>Erges in Limburg</td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>';
        
        return $strHTML;
    }
    
    public function ToevoegFormulierTonen()
    {
        $arrResultaat = '<form method="post" name="frmKlantToevoegen" class="custom">
            <fieldset>
                <legend>Klant Toevoegen</legend>
                
            <div class="row">
                <div class="large-6 columns">
                    <label for="txtVoornaam">Voornaam</label>
                    <input type="text" placeholder="Voornaam" id="txtVoornaam" name="voornaam" required>
                </div>
                <div class="large-6 columns">
                    <label for="txtAchternaam">Achternaam</label>
                    <input type="text" placeholder="Achternaam" id="txtAchternaam" name="achternaam" required>
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>
            
            <div class="row">
                <div class="large-8 columns">
                    <label for="txtGemeente">Gemeente</label>
                    <input type="text" placeholder="Gemeente" id="txtGemeente" name="gemeente" required>
                </div>
                <div class="large-4 columns">
                    <label for="txtPostcode">Postcode</label>
                    <input type="text" placeholder="Postcode" id="txtPostcode" name="postcode" required>
                </div>
            </div>
            
            <div class="row">
                <div class="large-8 columns">
                    <label for="txtStraat">Straatnaam</label>
                    <input type="text" placeholder="Straatnaam" id="txtStraat" name="straat" required>
                </div>
                <div class="large-4 columns">
                    <label for="txtHuisnummer">Huisnummer</label>
                    <input type="text" placeholder="Huisnummer" id="txtHuisnummer" name="huisnummer" required>
                </div>
            </div>            
                 
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="large-6 columns">
                    <label for="txtTelefoon">Telefoon</label>
                    <input type="text" placeholder="Telefoon" id="txtTelefoon" name="telefoon">
                </div>
                <div class="large-6 columns">
                    <label for="txtGsm">GSM</label>
                    <input type="text" placeholder="GSM" id="txtGsm" name="gsm">
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtEmail">Email adres:</label>
                    <input type="email" placeholder="Email" id="txtEmail" name="email">
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <label for="opmerking">Opmerking</label>
                    <textarea placeholder="Beschrijving van de afspraak" id="opmerking" name="opmerking"></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>            

            <div class="row">
                <div class="large-6 columns">
                    <input type="submit" class="small button" name="nieuweKlantSubmit" value="Opslaan"/>
                </div>
            </div>
            
            </fieldset>
            </form>';
        return $arrResultaat;
    }
    
    public function Toevoegen($arrGegevens, $arrGemeente)
    {        
        try 
        {
            //Controleren of gemeente al bestaat, zoniet, de gemeente toe te voegen
            $objResult = $this->db->get_where('gemeente',array('gemeente' => $arrGemeente['gemeente']));
            
            //Als de gemeente bestaat, bestaat ook de array uit meerdere regels
            if($objResult->num_rows() >0)
            {
                foreach ($objResult->result() as $row)
                {
                    $arrGegevens['idgemeente'] = $row->Idgemeente;
                }
                $this->db->insert('klanten',$arrGegevens);
            }
            
            //Gemeente bestaat niet en wordt toegevoegd
            else
            {
                $this->db->insert('gemeente',$arrGemeente);
                
                $objResult2 = $this->db->get_where('gemeente',array('gemeente' => $arrGemeente['gemeente']));
                foreach ($objResult2->result() as $row)
                {
                    $arrGegevens['idgemeente'] = $row->Idgemeente;
                }
                $this->db->insert('klanten',$arrGegevens);
            }
            
            
            return '<br><br>
                <div data-alert class="alert-box success radius">
                        Uw klant werd toegevoegd !
                        <a href="#" class="close">&times;</a>
                    </div>';
        }
        catch (PDOException $ex)
        {
            return $ex->getMessage();
        }
    }
    
    public function Bewerken($arrKlantGegevens, $arrGemeente){
        
        //Controleren of gemeente al bestaat, zoniet, de gemeente toe te voegen
            $objResult = $this->db->get_where('gemeente',array('gemeente' => $arrGemeente['gemeente']));
            
            //Als de gemeente bestaat, bestaat ook de array uit meerdere regels
            if($objResult->num_rows() >0)
            {
                foreach ($objResult->result() as $row)
                {
                    $arrKlantGegevens['idgemeente'] = $row->Idgemeente;
                }
                $this->db->where('klantID', $arrKlantGegevens['klantID']);
                $this->db->update('klanten',$arrKlantGegevens);
            }
            
            //Gemeente bestaat niet en wordt toegevoegd
            else
            {
                $this->db->insert('gemeente',$arrGemeente);
                
                $objResult2 = $this->db->get_where('gemeente',array('gemeente' => $arrGemeente['gemeente']));
                foreach ($objResult2->result() as $row)
                {
                    $arrKlantGegevens['idgemeente'] = $row->Idgemeente;
                }
                $this->db->where('klantID', $arrKlantGegevens['klantID']);
                $this->db->update('klanten',$arrKlantGegevens);
            }
            
            return '<br><br>
                <div data-alert class="alert-box success radius">
                        Uw klant werd bewerkt !
                        <a href="#" class="close">&times;</a>
                    </div>';
    }
    
    public function KlantenFilterTonen($strStartWaarde, $strVeld){    
        $this->db->select('*'); 
        $this->db->from('klanten');
        $this->db->like($strVeld, $strStartWaarde, 'after');
        
        $query = $this->db->get();
        
        if($query->num_rows() >0)
        {
            $strHTML = '<fieldset>
                    <legend>Klanten</legend> 
                    <table>
                        <thead>
                          <tr>
                            <th>Gebruiker</th>
                            <th width="20%">Bewerken</th>
                          </tr>
                        </thead>
                        <tbody>';



            foreach ($query->result() as $row){ 
                $strHTML .= '<tr>
                                <td>
                                    '.$row->achternaam.'&nbsp'.$row->voornaam.'
                                </td>
                                <td align="center">
                                    <form form method="POST">
                                        <input type="hidden" name="klant_id" value="'.$row->klantID.'" >
                                        <button type="submit" class="small button" name="Bewerken"><i class="step fi-pencil size-18"></i></button>
                                    </form>
                                </td>
                            </tr>';     
            } 
            $strHTML .= '</tbody></table></fieldset>';
        }
        else
        {
            $strHTML = '<br><br>
                <div data-alert class="alert-box alert radius">
                        De klant die u zoekt bestaat nog niet.<br>
                        U kan een klant toevoegen via het menu-item "Klanten"
                        <a href="#" class="close">&times;</a>
                    </div>';
        }
        
        
        return $strHTML;
    }
    
    public function KlantTonen($intKlantID){
        $this->db->select('*');
        $this->db->where('klantID', $intKlantID);
        $this->db->from('klanten');
        $this->db->join('gemeente', 'klanten.idgemeente = gemeente.Idgemeente');

        $query = $this->db->get();
        foreach ($query->result() as $row)
        {            
            $strHTML = '<form method="post" name="frmGebruikerToevoegen" class="custom">
            <fieldset>
                <legend>Klant bewerken</legend>
            <div class="row">
                <div class="large-12 columns">
                    <input type="hidden" value="'.$row->klantID.'" name="klantID"/>
                    <label>KlantID : '.$row->klantID.'</label>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="txtKlantAchternaam">Achternaam</label>
                    <input type="text" value="'.$row->achternaam.'" name="txtKlantAchternaam" id="txtKlantAchternaam" required />
                </div>
                <div class="large-6 columns">
                    <label for="txtKlantnaam">Voornaam</label>
                    <input type="text" value="'.$row->voornaam.'" name="txtKlantVoornaam" id="txtKlantVoornaam" required />
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="txtStraat">Straat</label>
                    <input type="text" value="'.$row->straat.'" name="txtStraat" id="txtStraat" required />
                </div>
                <div class="large-6 columns">
                    <label for="txtHuisnummer">Huisnummer</label>
                    <input type="text" value="'.$row->huisnummer.'" name="txtHuisnummer" id="txtHuisnummer" required />
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="txtGemeente">Gemeente</label>
                    <input type="text" value="'.$row->gemeente.'" name="txtGemeente" id="txtGemeente" required />
                </div>
                <div class="large-6 columns">
                    <label for="txtPostcode">Postcode</label>
                    <input type="text" value="'.$row->postcode.'" name="txtPostcode" id="txtPostcode" required />
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="txtTelefoon">Telefoon</label>
                    <input type="text" value="'.$row->telefoon.'" name="txtTelefoon" id="txtTelefoon" required />
                </div>
                <div class="large-6 columns">
                    <label for="txtGsm">GSM</label>
                    <input type="text" value="'.$row->gsm.'" name="txtGsm" id="txtGsm" required />
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtEmail">Email</label>
                    <input type="text" value="'.$row->email.'" name="txtEmail" id="txtEmail" required />
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtOpmerking">Email</label>
                    <textarea name="txtOpmerking" id="txtOpmerking" required>'.$row->opmerking.'</textarea>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>            
            <div class="row">
                <div class="large-6 columns">
                    <button type="submit" class="small button" name="updateKlant">Opslaan</button>
                </div>
            </div>
            </fieldset>
            </form>';
        }
        return $strHTML;
    }    
    
    public function SelectNaamForm()
    {
        $strHtml = '<form method="post" name="frmSelectGebruiker" class="custom">
                        <fieldset>
                         <div class="row">
                            <div class="large-8 columns">
                                <input type="text" placeholder="Klantgegeven" name="txtSelectNaam" id="txtSelectNaam"/>
                            </div>
                            <div class="large-4 columns" align="right">
                                <button type="submit" class="small button" name="searchKlant"><i class="fi-magnifying-glass size-21"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-8 columns">
                                <select class="large" name="ddSelectItem">
                                    <option value="achternaam">Achternaam</option>
                                    <option value="voornaam">Voornaam</option>
                                    <option value="straat">Straat</option>
                                    <option value="telefoon">Telefoon</option>
                                    <option value="gsm">Gsm</option>
                                    <option value="email">E-mail</option>
                                </select>
                            </div>
                        </div>
                        </fieldset>
                    </form>';
        
        return $strHtml;
    }
    
    public function AlleKlantenTonen()
    {
        $this->db->select('*'); 
        $this->db->from('klanten');
        
        $query = $this->db->get();
        
        $strHTML = '<table>
                        <thead>
                          <tr>
                            <th>Klant ID</th>
                            <th>Achternaam</th>
                            <th>Voornaam</th>
                            <th>Straat</th>
                            <th>Nr°</th>
                            <th>Gemeente</th>
                            <th>Postcode</th>
                            <th>Telefoon</th>
                            <th>Gsm</th>
                            <th>E-mail</th>                            
                          </tr>
                        </thead>
                        <tbody>';
        foreach ($query->result() as $row)
        { 
            $this->db->select('*'); 
            $this->db->from('gemeente');
            $this->db->where('Idgemeente', $row->idgemeente);
            $queryGemeente = $this->db->get();
            
            
            $strHTML .= '<tr>
                            <td>
                                '.$row->klantID.'
                            </td>
                            <td>
                                '.$row->achternaam.'
                            </td>
                            <td>
                                '.$row->voornaam.'
                            </td>
                            <td>
                                '.$row->straat.'
                            </td>
                            <td>
                                '.$row->huisnummer.'
                            </td>';
            
                            foreach ($queryGemeente->result() as $rij)
                            {
                                $strHTML .='<td>
                                                '.$rij->gemeente.'
                                            </td>
                                            <td>
                                                '.$rij->postcode.'
                                            </td>';
                            }
            
            $strHTML .= '<td>
                                '.$row->telefoon.'
                            </td>
                            <td>
                                '.$row->gsm.'
                            </td>
                            <td>
                                '.$row->email.'
                            </td>
                        </tr>';     
        } 
        $strHTML .= '</tbody></table>';
        
        return $strHTML;
    }
}

?>
