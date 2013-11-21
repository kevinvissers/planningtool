<?php
/**
 * Klanten_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @author              Bart Bollen <bart.bollen@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
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
}

?>
