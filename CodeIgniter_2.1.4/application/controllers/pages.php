<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Pages extends CI_Controller {
    //wordt niet meer gebruikt!
    public function view($page = 'home')
    {
        if ( ! file_exists('application/views/pages/'.$page.'.php'))
	{
		// Whoops, we don't have a page for that!
		show_404();
	}
        
        $this->load->helper('url');
        $this->load->model('Kalender');
        
        $conf = array(
            'start_day' => 'Monday',
            'show_next_prev' => true,
            'day_type' => 'abr',
            'next_prev_url'   => 'http://localhost/CodeIgniter_2.1.4/index.php/home'
        );
        
        $conf['template'] = $this->Kalender->Template();
        
        if((($this->uri->segment(2) == "2013")&&($this->uri->segment(3) == "10"))||($this->uri->segment(2) == null))
        {
            $data = array(
                   3  => 'http://localhost/CodeIgniter_2.1.4/index.php/about/2013/03/',
                   7  => 'http://localhost/CodeIgniter_2.1.4/index.php/about/2013/07/',
                   13 => 'http://localhost/CodeIgniter_2.1.4/index.php/about/2013/13/',
                   26 => 'http://localhost/CodeIgniter_2.1.4/index.php/about/2013/26/'
                 );
        }
        //$year = null;
        //$month = null;
        
        $this->load->library('calendar', $conf);
        
        $year=  $this->uri->segment(4); //2
        $month=  $this->uri->segment(5); //3
        $day=  $this->uri->segment(6); //4
        
        if ($year==null) {
            $year = date('Y');
            //$year = "2013";
        }
        
        if ($month==null) {
            $month = date('Y');
            //$month = "10";
        }
        
        if ($day==null) {
            $day = date('Y');
            //$day = "15";        
        }    

        $calendarPreference = array (
                        'start_day'    => 'monday',
                        'month_type'   => 'short',
                        'day_type'     => 'abr',
                        'date'     => date(mktime(0, 0, 0, $month, $day, $year)),
                        'url' => 'home/',
                    );        
        $this->load->library('calendar_week', $calendarPreference);

        // I need to feed my calndar week with some data
        // for the example data are empty
        $weeks = $this->calendar_week->get_week();
        $arr_Data = array();
        for ($i=0;$i<count($weeks);$i++){
            $arr_Data[$weeks[$i]] = '';
        }
        $arr_Data[$weeks[0]] = '<a href="#"><span class="tijdstip" align="center">15.00</span> Afspraak</a>';
        
	$data['title'] = ucfirst($page); // Capitalize the first letter
        //$data['kalender'] = $this->calendar->generate($this->uri->segment(2), $this->uri->segment(3), $data);
        $data['kalender'] = $this->calendar->generate($this->uri->segment(4), $this->uri->segment(5), $data);
        $data['kalender2'] = $this->calendar_week->generate($arr_Data);

	$this->load->view('templates/header', $data);
	$this->load->view('pages/'.$page, $data);
	$this->load->view('templates/footer', $data);
    }
}
?>
