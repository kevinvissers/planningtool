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
            $objResult = $this->db->get_where('gemeente',array('gemeente' => $arrGemeente['gemeente']));
                        
            if($objResult->num_rows() >0)
            {
                foreach ($objResult->result() as $row)
                {
                    $arrGegevens['idgemeente'] = $row->Idgemeente;
                }
                $this->db->insert('klanten',$arrGegevens);
            }
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
}

?>
