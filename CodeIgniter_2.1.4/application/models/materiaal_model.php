<?php

/**
 * Materiaallijst_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Materiaallijst_model class has the following properties and methods:
 * properties:  
 * methods: 
 *
 */
class Materiaal_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    public function Tonen($intAfspraakID){
        $objResult = $this->_Select($intAfspraakID);
        $strHTML = '<div class="row">
                        <div class="large-4 columns">
                            Beschrijving
                        </div>
                        <div class="large-4 columns">
                            Aantal
                        </div>
                        <div class="large-4 columns">
                            Eenheid
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <hr>
                        </div>
                    </div>';
        foreach ($objResult->result() as $row) {
            $strHTML .= '<div class="row">';
            $strHTML .= '<div class="large-4 columns">'.$row->materiaalNaam.'</div>
                        <div class="large-4 columns">'.$row->aantal.'</div>
                        <div class="large-4 columns">'.$row->eenheid.'</div>';
            $strHTML .= '</div>';
        }
        $strHTML .= '<div class="row">
                        <div class="large-12 columns">
                            <hr>
                        </div>
                    </div>
            <div class="row">
                <div class="large-6 columns">
                    <a href="'.site_url().'/materialen/toevoegen/'.$intAfspraakID.'">Toevoegen</a>
                </div>
            </div>';
        return $strHTML;
    }
    public function ToevoegFormulier($intAfspraakID){
        $strHTML = '<form method="post" name="frmKlantToevoegen" class="custom">
            <fieldset>
                <legend>Materiaal Toevoegen</legend>
                
            <div class="row">
                <div class="large-12 columns">
                    <label for="txtNaam">Naam</label>
                    <input type="hidden" name="afspraakid" value="'.$intAfspraakID.'" >
                    <input type="text" placeholder="Naam" id="txtNaam" name="naam" required >
                </div>
            </div>
            
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>
            
            <div class="row">
                <div class="large-8 columns">
                    <label for="txtAantal">Aantal</label>
                    <input type="text" placeholder="Aantal" id="txtAantal" name="aantal" required>
                </div>
                <div class="large-4 columns">
                    <label for="txtEenheid">Eenheid</label>
                    <input type="text" placeholder="Eenheid" id="txtEenheid" name="eenheid" required>
                </div>
            </div>           
                 
            <div class="row">
                <div class="large-12 columns">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="large-6 columns">
                    <input type="submit" class="small button" name="materiaalToevoegen" value="Toevoegen"/>
                </div>
            </div>
            
            </fieldset>
            </form>';
        return $strHTML;
    }
    public function Toevoegen($arrMaterialen,$arrMateriaallijst, $intAfspraakID){
        return $this->_Insert($arrMaterialen, $arrMateriaallijst, $intAfspraakID);
    }
    public function Bewerken($arrGegevens, $intAfspraakID){
        
    }
    public function Verwijderen($intMateriaalID, $intAfspraakID){
        
    }
    private function _Select($intAfspraakID){
        $this->db->select('*');
        $this->db->from('materiaallijst');
        $this->db->where('afspraakid', $intAfspraakID);
        $this->db->join('materialen','materiaallijst.materiaalid = materialen.materiaalID');
        
        return $this->db->get();
    }
    private function _Insert($arrMaterialen,$arrMateriaallijst, $intAfspraakID){
        try{
            $this->db->insert('materialen', $arrMaterialen);
            $intMateriaalID = $this->db->insert_id();
            $arrMateriaallijst['afspraakid'] = $intAfspraakID;
            $arrMateriaallijst['materiaalid'] = $intMateriaalID;
            $this->db->insert('materiaallijst', $arrMateriaallijst);
            return true;
        }catch(PDOException $ex){
            return $ex->getMessage();
        }
    }
    private function _Update($arrMaterialen,$arrMateriaallijst, $intAfspraakID,$intIdMateriaalLijst){
        
    }
    private function _Delete($intMateriaalID){
        
    }
}

?>
