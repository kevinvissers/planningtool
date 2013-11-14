<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
    class Calendar_week {
     
            var $CI;
            var $lang;
            //var $local_time;
            var $template           = '';
            var $start_day          = 'sunday';
            var $month_type         = 'long';
            var $day_type           = 'abr';
            var $week_days = Array();
            var $date = '';
            var $url                = '/show_week/';
     
            /**
             * Constructor
             *
             * Loads the calendar language file and sets the default time reference
             *
             * @access      public
             */
            function Calendar_week($config = array()){
                    $this->CI =& get_instance();
                   
                    if ( ! in_array('calendar_lang'.EXT, $this->CI->lang->is_loaded, TRUE)) {
                            $this->CI->lang->load('calendar');
                    }
                   
                    if (count($config) > 0) {
                            $this->initialize($config);
                    }
                   
                    if ($this->date==null){
                            $this->date = date(mktime());
                    }
                   
                    $this->set_week();
                   
                    log_message('debug', "Calendar_week Class Initialized");
            }
           
            /**
             * Initialize the user preferences
             *
             * Accepts an associative array as input, containing display preferences
             *
             * @access      public
             * @param       array   config preferences
             * @return      void
             */    
            function initialize($config = array()) {
                    foreach ($config as $key => $val) {
                            if (isset($this->$key)) {
                                    $this->$key = $val;
                            }
                    }
            }
           
            function set_range(){
                    switch ($this->start_day){
                            case 'sunday':
                                    return range(0,6);
                                    break;
     
                            case 'monday':
                                    return range(1,7);
                                    break;
                            case 'tuesday':
                                    return range(2,8);
                                    break;
     
                            case 'wednesday':
                                    return range(3,9);
                                    break;
     
                            case 'thursday':
                                    return range(4,10);
                                    break;
     
                            case 'friday':
                                    return range(5,11);
                                    break;
     
                            case 'saturday':
                                    return range(6,12);
                                    break;                         
                    }
                    return range(0,6);
            }
           
            function set_week() {
                    $week_days = $this->set_range();
                    $week_day = date('w',$this->date);
           
               foreach($week_days as $key=>$day) {
                  if($day == $week_day) {
                      $week_days[$key] = $this->date;
                  } elseif($day < $week_day) {
                     $week_days[$key] = strtotime('-'.$week_day+$day.' day',$this->date);
                  } elseif($day > $week_day) {
                     $week_days[$key] = strtotime('+'.$day-$week_day.' day',$this->date);
                  }
               }
               
               $this->week_days = $week_days;
            }
           
            function get_week(){
                    return $this->week_days ;
            }
           
            // --------------------------------------------------------------------
     
            /**
             * Generate the calendar
             *
             * @access      public
             * @return      string
             */
            function generate($data=''){
                    $days = $this->get_day_names();
                    $months = $this->get_month_name();
                   
                    $tmpHeader = '';
                    $tmpContent = '';
     
                    for ($i=0;$i<count($this->week_days);$i++){
                            if ( (date('l', $this->week_days[$i])=='Saturday') || (date('l', $this->week_days[$i])=='Sunday') ){
                                    $tmpHeader .= '<td class="week_hoofding">'.$days[date('w', $this->week_days[$i])].' '.date('d', $this->week_days[$i]).' ' . $months[date('n', $this->week_days[$i])-1] .'</td>';
                                    $tmpContent .= '<td class="week_inhoud"><div class="container" style="background: #ccc;"></div></td>';                             
                            } else {
                                    $tmpHeader .= '<td class="week_hoofding">'.$days[date('w', $this->week_days[$i])].' '.date('d', $this->week_days[$i]).' ' . $months[date('n', $this->week_days[$i])-1] .'</td>';
                                    $tmpContent .= '<td class="week_inhoud"><div class="container">'.$data[$this->week_days[$i]].'</div></td>';
                            }
                    }
                   
                    $before = strtotime('-4 day',$this->week_days[0]);
                    $after = strtotime('+1 day',$this->week_days[count($this->week_days)-1]);
                   
                    $template = '<span id="displayCalendarBefore">
                                    <a href="' . site_url("/kalender/weekOverzicht/" . date('Y',$before).'/'.date('m',$before).'/'.date('d',$before)) . '">vorige</a>
                            </span>
                            <span id="calendar">
                                    <table>
                                            <tr class="calendarDay">'.$tmpHeader.'</tr>
                                            <tr class="calendarDetail">'.$tmpContent.'</tr>
                                    </table>
                            </span>
                            <span id="displayCalendarAfter">
                                    <a href="' . site_url("/kalender/weekOverzicht/" . date('Y',$after).'/'.date('m',$after).'/'.date('d',$after)) . '">volgende</a>
                            </span>';
                    return $template ;
            }      
           
            /**
             * Get Month Name
             *
             * Generates a textual month name based on the numeric
             * month provided.
             *
             * @access      public
             * @param       integer the month
             * @return      string
             */
            function get_month_name() {
                    if ($this->month_type == 'short') {
                            $month_names = array('01' => 'cal_jan', '02' => 'cal_feb', '03' => 'cal_mar', '04' => 'cal_apr', '05' => 'cal_may', '06' => 'cal_jun', '07' => 'cal_jul', '08' => 'cal_aug', '09' => 'cal_sep', '10' => 'cal_oct', '11' => 'cal_nov', '12' => 'cal_dec');
                    } else {
                            $month_names = array('01' => 'cal_january', '02' => 'cal_february', '03' => 'cal_march', '04' => 'cal_april', '05' => 'cal_may', '06' => 'cal_june', '07' => 'cal_july', '08' => 'cal_august', '09' => 'cal_september', '10' => 'cal_october', '11' => 'cal_november', '12' => 'cal_december');
                    }
                   
                    $months = array();
                    foreach ($month_names as $val) {                       
                            $months[] = ($this->CI->lang->line($val) === FALSE) ? ucfirst($val) : $this->CI->lang->line($val);
                    }
           
                    return $months;
            }      
           
            /**
             * Get Day Names
             *
             * Returns an array of day names (Sunday, Monday, etc.) based
             * on the type.  Options: long, short, abrev
             *
             * @access      public
             * @param       string
             * @return      array
             */
            function get_day_names($day_type = '')
            {
                    if ($day_type != '')
                            $this->day_type = $day_type;
           
                    if ($this->day_type == 'long') {
                            $day_names = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
                    } elseif ($this->day_type == 'short') {
                            $day_names = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
                    } else {
                            $day_names = array('su', 'mo', 'tu', 'we', 'th', 'fr', 'sa');
                    }
           
                    $days = array();
                    foreach ($day_names as $val) {                 
                            $days[] = ($this->CI->lang->line('cal_'.$val) === FALSE) ? ucfirst($val) : $this->CI->lang->line('cal_'.$val);
                    }
                    return $days;
            }              
    }
     
    // END Calendar_week class
     
    /* End of file Calendar_week.php */
    /* Location: ./system/application/libraries/Calendar_week.php */

