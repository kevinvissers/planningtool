<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dag_Library {
    /********************* PROPERTIES ********************/
  
        var $CI             = '';
        var $lang           = '';
        var $local_time     = '';
        var $template       = '';
        var $day_type       = 'abr';
        var $show_next_prev = TRUE;
        var $next_prev_url  = 'kalender/dagOverzicht/';
/**
 * @access  public
 */    
    public function __construct(){
        // Do something with $params
    }


        function Calendar_dag($config = array()){
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
           
            log_message('debug', "Calendar_dag Class Initialized");
        }

        function initialize($config = array()){
            foreach ($config as $key => $val){
                if (isset($this->$key)){
                    $this->$key = $val;
                }
            }
        }


        function GenerateView($dag,$maand,$jaar,$query){

            if ($jaar == ''){ $jaar  = date("Y", $this->local_time);}

            if ($maand == '') {$maand = date("m", $this->local_time);}

            if($dag==''){$dag=date('d',$this->local_time);}

            if (strlen($jaar) == 1){$jaar = '200'.$jaar;}

            if (strlen($jaar) == 2){$jaar = '20'.$jaar;}

            if (strlen($maand) == 1){$maand = '0'.$maand;}

            if(strlen($dag)==1){$dag='0'.$dag;}

            $strHTML = "<div id='container'>
                            <div id='tijdmenu'>
                                <h1 style='margin-bottom:0;'>
                                    <a href='{previous_url}'>&lt;&lt;</a>
                                    ".$dag."/".$maand."/".$jaar."
                                    <a href='{next_url}''>&gt;&gt;</a>
                                </h1>
                            </div>";

            if ($query->num_rows() > 0){
                foreach ($query->result_array() as $row){
                  $strHTML.="<a href='#' class='detail'>
                                <div class='tijd'>
                                    ".$row['startTijd']."
                                    ".$row['voornaam']." ".$row['achternaam']."
                                </div>
                                <div class='inhoud'>
                                    ".$row['eindTijd']."
                                    ".$row['straat']."
                                </div>
                            </a>";  
                }
            }
            else{ $strHTML.= "Geen afspraken gevonden"; }
            
            $strHTML.="</div>";

            return $strHTML;
         }
         /*
        if ($this->show_next_prev == TRUE)
        {
            // Add a trailing slash to the  URL if needed
            $this->next_prev_url = preg_replace("/(.+?)\/*$/", "\\1/",  $this->next_prev_url);

            $adjusted_date = $this->adjust_date($maand - 1, $jaar);
            $out = str_replace('{previous_url}', $this->next_prev_url.$adjusted_date['jaar'].'/'.$adjusted_date['maand']);
        }
        */
/*
        // "next" maand link
        if ($this->show_next_prev == TRUE)
        {
            $adjusted_date = $this->adjust_date($maand + 1, $jaar);
            $out = str_replace('{next_url}', $this->next_prev_url.$adjusted_date['jaar'].'/'.$adjusted_date['maand']);
        }
*/
        function adjust_date($maand, $jaar)
        {
            $date = array();

            $date['maand']  = $maand;
            $date['jaar']   = $jaar;

            while ($date['maand'] > 12)
            {
                $date['maand'] -= 12;
                $date['jaar']++;
            }

            while ($date['maand'] <= 0)
            {
                $date['maand'] += 12;
                $date['jaar']--;
            }

            if (strlen($date['maand']) == 1)
            {
                $date['maand'] = '0'.$date['maand'];
            }

            return $date;
        }
    
    }
    
    /* TODO: CSS toevoegen

            #container{
                width:25em;
                text-align: center;
            }
            .inhoud{
                background-color:#EEEEEE;
                height:3em;
                width:20em;
                float:left;
            }
            .tijd{
                background-color:#444499;
                height:3em;
                width:5em;
                float:left;
            }
            #tijdmenu{
                background-color:#5555AA;
                
            }
            .detail{
                a:link {color:#000000;}      
                a:visited {color:#FFFFFF;}  
                a:hover {color:#FFFFFF;}  
                a:active {color:#FFFFFF;}  
            }

    */
     
    // END Calendar_dag class
     
    /* End of file Calendar_dag.php */
    /* Location: ./system/application/libraries/Calendar_dag.php */

