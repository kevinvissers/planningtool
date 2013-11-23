<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Gebruiker extends CI_Controller{
    
    public function Toevoegen(){
        if ( ! file_exists('application/views/pages/maandOverzicht.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        $blnPermission = $this->session->userdata('logged_in') ? true : false;
        $session_data = $this->session->userdata('logged_in');

        $menuConfig = array(
            'currentController' => 'gebruiker',
            'loggedIn' => $blnPermission,
            'user' => $session_data['username'],
            'userRole' => 3
        );
        
        if($blnPermission){
            echo "U bent aangemeld als ".$session_data['username'];
        }else{
            header('Location: '.site_url().'/login');
        }  
    }
    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        //session_destroy();
        //redirect('login', 'refresh');
        header('Location: '.site_url().'/login');
    }
}
?>
