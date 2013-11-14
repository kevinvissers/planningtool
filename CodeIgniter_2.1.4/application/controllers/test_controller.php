<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test_controller
 *
 * @author Kevin
 */
class Test_controller extends CI_Controller {
    public function index(){
        $this->load->model('Afspraken_model');
        //$this->load->model('Kalender_model');
        //$data['berichtje'] = $this->Afspraken_model->Toevoegen('2013/12/12', '09:30', '13:00', 'omschrijving enzo', '1', true, 1);
        
        $data['berichtje'] = '';
        /*$data['resultaat'] = $this->Kalender_model->ToonAfspraken(2, 11, 2013);
        
        foreach ($this->Kalender_model->ToonAfspraken(2, 11, 2013) as $row)
        {
           $timestamp = strtotime($row->datum);
           $day = date('d', $timestamp);
           $day = ltrim($day, '0');
           $data['berichtje'] = $data['berichtje'].$day.'<br />';
        }*/
        $data['resultaat'] = '';
        $this->load->view('templates/testView', $data);
    }
}

?>
