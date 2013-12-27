<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Werkbon extends CI_Controller{
    public function index($intAfspraakid){
        $arrGegevens = array();
        $arrMaterialen = array();
        
        $this->load->model('werkbon_model');
        $arrGegevens = $this->werkbon_model->SelectAll($intAfspraakid);
        $arrMaterialen = $this->werkbon_model->geneerMateriaallijst($intAfspraakid);
        
        $strHtml = '<html>
            <head>
                <title>Werkbon</title>
            </head>
            <body>
                <h3>Klantgegevens</h3>
                <table style="margin-left: 15px;">
                    <fieldset>
                        <legend>Klantgegevens</legend>
                        <tr>
                            <td>'.$arrGegevens['naam'].'</td>
                            <td>'.$arrGegevens['voornaam'].'</td>
                        </tr>
                        <tr>
                            <td>'.$arrGegevens['straat'].'</td>
                            <td>'.$arrGegevens['nummer'].'</td>
                        </tr>
                        <tr>
                            <td>'.$arrGegevens['postcode'].'</td>
                            <td>'.$arrGegevens['gemeente'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">'.$arrGegevens['telefoon'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">'.$arrGegevens['gsm'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">'.$arrGegevens['email'].'</td>
                        </tr>
                    </fieldset>
                </table>
                <h3>Afspraak eigenschappen</h3>
                <table style="margin-left: 15px;">
                    <fieldset>
                        <legend>Afspraak eigenschappen</legend>
                        <tr>
                            <td>'.$arrGegevens['datum'].'</td>
                            <td>'.$arrGegevens['startTijd'].' - '.$arrGegevens['eindTijd'].'</td>
                        </tr>
                        <tr>
                            <td colspan="2">'.$arrGegevens['omschrijving'].'</td>
                        </tr>
                        <tr>
                            <td>Uitgevoerd door:</td>
                            <td>'.$arrGegevens['uitvoerder'].'</td>
                        </tr>
                    </fieldset>
                </table>
                <h3>Materiaallijst</h3>
                <table style="margin-left: 15px;">
                    <fieldset>
                        <legend>Materiaallijst</legend>';
        
        foreach ($arrMaterialen as $key => $value) {
            $strHtml .= '<tr>';
                foreach ($value as $naam => $waarde) {
                    $strHtml .= '<td>'.$waarde.'</td>';
                }
            $strHtml .= '</tr>';
        }
        
        $strHtml .='</fieldset>
                </table>
            </body>
        </html>';

        $this->load->library('mpdf');
        
        //$stylesheet = file_get_contents(base_url().'css/pdf.css');
	//$this->mpdf->WriteHTML($stylesheet,1);
        
        $this->mpdf->SetTitle('Werkbon');
        $this->mpdf->SetAuthor('Kevin Vissers');
        $this->mpdf->SetHeader('Patrick Derwael|Werkbon|{DATE j-m-Y}');
        $this->mpdf->SetFooter('|{PAGENO}/{nb}|');

        $this->mpdf->WriteHTML($strHtml);
        $this->mpdf->Output();
    }
    public function test(){
        $this->load->model('werkbon_model');
        $this->werkbon_model->SelectAll(6);
    }
}
?>
