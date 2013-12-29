<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dag_Library {
    /********************* PROPERTIES ********************/
  
        var $CI             = '';
        var $lang           = '';
        var $local_time     = '';
        var $template       = '';
        var $day_type       = 'abr';
        var $show_next_prev = TRUE;
 
    public function __construct(){}


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


        function GenerateView($jaar,$maand,$dag,$query){

            if ($jaar == ''){ $jaar  = date("Y", $this->local_time);}

            if ($maand == '') {$maand = date("m", $this->local_time);}

            if($dag==''){$dag=date('d',$this->local_time);}

            if (strlen($jaar) == 1){$jaar = '200'.$jaar;}

            if (strlen($jaar) == 2){$jaar = '20'.$jaar;}

            if (strlen($maand) == 1){$maand = '0'.$maand;}

            if(strlen($dag)==1){$dag='0'.$dag;}

            $adjusted_date = $this->adjust_date($dag,$maand, $jaar);

            $dag    = $adjusted_date['dag'];
            $maand  = $adjusted_date['maand'];
            $jaar   = $adjusted_date['jaar'];

            $this->parse_template();

            $strHTML = $this->temp['main_open'];
            

                $strHTML.= $this->temp['heading_row_start'];

                    if ($this->show_next_prev == TRUE){

                        $adjusted_date = $this->adjust_date($dag-1,$maand, $jaar);
                        $strHTML.= str_replace('{previous_url}', site_url("/kalender/dagOverzicht/".$adjusted_date['jaar'].'/'.$adjusted_date['maand'].'/'.$adjusted_date['dag']), $this->temp['heading_prev_cell']);
                    }

                    $this->temp['heading_title_cell'] = str_replace('{datum}', $dag.'/'.$maand.'/'.$jaar, $this->temp['heading_title_cell']);
                    $strHTML.= $this->temp['heading_title_cell'];
                    
                    if ($this->show_next_prev == TRUE){
                        $adjusted_date = $this->adjust_date($dag+1,$maand, $jaar);
                        $strHTML .= str_replace('{next_url}', site_url("/kalender/dagOverzicht/".$adjusted_date['jaar'].'/'.$adjusted_date['maand'].'/'.$adjusted_date['dag']), $this->temp['heading_next_cell']);
                    }
                $strHTML.= $this->temp['heading_row_end'];

                if($query->num_rows() > 0){
                    foreach ($query->result_array() as $row){                                                           
                        $strHTML.= str_replace('{id}', $row['id'], $this->temp['date_start']);
                    
                        $timestamp = strtotime($row['startTijd']);
                        $startTijd = date("H:i", $timestamp);
                        
                        $timestamp = strtotime($row['eindTijd']);
                        $eindTijd = date("H:i", $timestamp);
                        /*
                        $strHTML.= str_replace('{content}', '<div class="large-6 columns">'.$startTijd.'</div><div class="large-6 columns">'.$row['voornaam'].' '.$row['achternaam'].'</div>' , $this->temp['date_row_content']);
                        $strHTML.= str_replace('{content}', '<div class="large-6 columns">'.$eindTijd.'</div><div class="large-6 columns">'.$row['straat'].'</div>', $this->temp['date_row_content']);
                        $strHTML.= str_replace('{content}','<div class="large-12 columns"><hr></div>', $this->temp['date_row_content']);
                        */
                        
                        $strHTML.= str_replace('{content}', '<td>'.$startTijd.' - '.$eindTijd.'</td><td>'.$row['voornaam'].' '.$row['achternaam'].'</td><td>'.$row['straat'].' '.$row['huisnummer'].'</td>' , $this->temp['date_row_content']);
                        //$strHTML.= str_replace('{content}', '<td>'.$eindTijd.'</td><td>'.$row['straat'].'</td>', $this->temp['date_row_content']);  
                        
                        $strHTML.= $this->temp['date_stop'];
                    }
                }
                else{
                    $strHTML.= '<td colspan="4" style="text-align:center">geen afspraken gevonden</td>';
                }
                

            $strHTML.= $this->temp['main_close'];
            
          
            return $strHTML;
         }

        function default_template(){
            return  array (
                            'main_open'                 => '<div>',
                            'heading_row_start'         => '<div id="tijdmenu"><h1 style="margin-bottom:0;">',
                            'heading_prev_cell'         => '<a href="{previous_url}">&lt;&lt;</a>',
                            'heading_title_cell'        => '{datum}',
                            'heading_next_cell'         => '<a href="{next_url}">&gt;&gt;</a>',
                            'heading_row_end'           => '</h1></div>',
                            'date_start'                => '<div class="inhoud"><a href="{afpraak}" "class="detail"> ',
                            'date_row_content'          => '<div>{content}</div>',
                            'date_stop'                 => '</a></div>',
                            'main_close'                => '</div>',
                        );
        }
        function default_template2(){
            return  array (
                            'main_open'                 => '<table class="dagoverzicht">',
                            'heading_row_start'         => '<thead>',
                            'heading_prev_cell'         => '<th class="links"><a href="{previous_url}" class="dagoverzicht">&lt;&lt;</a></th>',
                            'heading_title_cell'        => '<th class="datum">{datum}</th>',
                            'heading_next_cell'         => '<th class="rechts"><a href="{next_url}" class="dagoverzicht">&gt;&gt;</a></th>',
                            'heading_row_end'           => '</thead>',
                            'date_start'                => '<tr onclick="document.location = \''.$_SERVER['PHP_SELF'].'?id={id}\';" class="dagrij">',
                            'date_row_content'          => '{content}',
                            'date_stop'                 => '</tr>',
                            'main_close'                => '</table>',
                        );
        }
        //TODO kijk na php functie om dit simpeler te maken !!!
        // adjust_date + dagenInMaand !!! 
        // ??? date('d-m-Y', strtotime("+1 day")) ???
        function adjust_date($dag,$maand, $jaar){
            $date = array();

            $date['dag'] = $dag;
            $date['maand']  = $maand;
            $date['jaar']   = $jaar;

            if($date['dag']> $this->dagenInMaand($maand,$jaar)){
                $date['dag'] -= $this->dagenInMaand($maand,$jaar);
                $date['maand']++;
            }
            if($date['dag']<=0){
                if($date['maand']== 1){
                    $date['dag'] += 31;
                }
                else{
                    $date['dag'] += $this->dagenInMaand($maand -1,$jaar);
                }
                $date['maand']--;
            }
            while ($date['maand'] > 12){
                $date['maand'] -= 12;
                $date['jaar']++;
            }
            while ($date['maand'] <= 0){
                $date['maand'] += 12;
                $date['jaar']--;
            }
            if (strlen($date['maand']) == 1){
                $date['maand'] = '0'.$date['maand'];
            }
            if (strlen($date['dag']) == 1){
                $date['dag'] = '0'.$date['dag'];
            }
            return $date;
        }
    function dagenInMaand($maand, $jaar)
    {
        $dagen_in_maand  = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if ($maand < 1 OR $maand > 12){
            return 0;
        }
        if ($maand == 2){
            if ($jaar % 400 == 0 OR ($jaar % 4 == 0 AND $jaar % 100 != 0)){
                return 29;
            }
        }

        return $dagen_in_maand[$maand - 1];
    }
        
     function parse_template(){
        $this->temp = $this->default_template2();
        
        if ($this->template == '')
        {
            return;
        }

        $today = array('cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today');

        foreach (array('main_open', 'main_close', 'heading_row_start', 'heading_prev_cell', 'heading_title_cell', 'heading_next_cell', 'heading_row_end', 'date_start', 'week_day_cell', 'date_end', 'cal_row_start', 'cal_cell_start', 'cal_cell_content', 'cal_cell_no_content',  'cal_cell_blank', 'cal_cell_end', 'cal_row_end', 'cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today') as $val)
        {
            if (preg_match("/\{".$val."\}(.*?)\{\/".$val."\}/si", $this->template, $match))
            {
                $this->temp[$val] = $match['1'];
            }
            else
            {
                if (in_array($val, $today, TRUE))
                {
                    $this->temp[$val] = $this->temp[str_replace('_today', '', $val)];
                }
            }
        }
    }
}
    
/* HTML output + css id's en tags 

    id container =  omkaderd volledig
    id tijdmenu =  omkadering datum navigatie
    class inhoud =  omkadering van een afspraak
    class detail =  layout van de a tag te verbeteren

            <div id='container'>
                    <div id='tijdmenu'>
                        <h1 style='margin-bottom:0;'>
                            <a href='link vorige dag'>&lt;&lt;</a>
                                → datum
                            <a href='link volgende dag''>&gt;&gt;</a>
                        </h1>
                    </div>
                    <div class="inhoud">
                        <a href='link naar de afspraak' class='detail'>
                                <div >
                                    → startTijd Voornaam Achternaam
                                </div>
                                <div>
                                    → eindTijd Adress
                                </div>
                        </a>
                    </div>
            </div>
 */
     
    // END Dag_Library class
     
    /* End of file Dag_Library.php */
    /* Location: ./application/libraries/Dag_Library.php */

