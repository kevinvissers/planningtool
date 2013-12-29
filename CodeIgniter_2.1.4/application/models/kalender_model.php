<?php

/**
 * Kalender_model
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Kalender_model class has the following properties and methods:
 * properties:  template
 * methods: Template, ToonAfspraken
 *
 */

class Kalender_model extends CI_Model{
    /********************* PROPERTIES ********************/
/**
 * @access	private 
 */
    private $template = '

            {table_open}<table class="maandKalender" border="0" cellpadding="0" cellspacing="0">{/table_open}

            {heading_row_start}<tr class="hoofding">{/heading_row_start}

            {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
            {heading_title_cell}<th align="center" colspan="{colspan}">{heading}</th>{/heading_title_cell}
            {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

            {heading_row_end}</tr>{/heading_row_end}

            {week_row_start}<tr>{/week_row_start}
            {week_day_cell}<td align="center">{week_day}</td>{/week_day_cell}
            {week_row_end}</tr>{/week_row_end}

            {cal_row_start}<tr>{/cal_row_start}
            {cal_cell_start}<td align="center">{/cal_cell_start}

            {cal_cell_content}<a href="{content}"><div class="afspraak">{day}</div></a>{/cal_cell_content}
            {cal_cell_content_today}<div class="highlight red"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

            {cal_cell_no_content}<div>{day}</div>{/cal_cell_no_content}
            {cal_cell_no_content_today}<div class="highlight red">{day}</div>{/cal_cell_no_content_today}

            {cal_cell_blank}&nbsp;{/cal_cell_blank}

            {cal_cell_end}</td>{/cal_cell_end}
            {cal_row_end}</tr>{/cal_row_end}

            {table_close}</table>{/table_close}
         ';
    /********************* METHODS ********************/
/**
 * @access	public
 */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @return          string 
     *
     */    
    public function Template(){
        return $this->template;
    }
    
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @param           integer $maand Bevat de maand voor de weer te geven afspraken
     * @param           integer $jaar Bevat het jaar voor de weer te geven afspraken
     * @return          array Array met het resultaat
     *
     */
    public function ToonAfspraken($maand, $jaar){
        //database helper laden
        $this->load->database();
        
        try{
            //datum bevat het jaar en maand gesplitst door een '-'
            $datum = $jaar.'-'.$maand;
            //voert de query uit, heeft een object als resultaat, zoekt alle afspraken waarbij datum het huidige jaar en maand bevat
            $query = $this->db->query('SELECT * FROM afspraken WHERE datum LIKE "%'.$datum.'%"');
            //vormt het object om naar een array
            $resultaat = $query->result();
            return $resultaat;
        }catch(PDOException $exc){
            return "error: <br />".$exc->getMessage();
        }
    }
    public function Afspraken($jaar,$maand,$dag){    
        $sqlDatum = $jaar."-".$maand."-".$dag;

        $sql= 'SELECT afspraken.id, afspraken.startTijd, afspraken.eindTijd, klanten.voornaam, klanten.achternaam, klanten.straat, klanten.huisnummer, klanten.klantID   
                FROM afspraken INNER JOIN klanten ON afspraken.klantID = klanten.klantID                                    
                WHERE DATE( afspraken.startTijd ) = "'.$sqlDatum.'" '  ;
        $query = $this->db->query($sql);            
        
        return $query;

    }
    
}
?>
