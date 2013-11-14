<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of informatief
 *
 * @author Kevin
 */
class Informatief extends CI_Controller {
    public function index()
	{   
            if ( ! file_exists('application/views/pages/informatie.php'))
            {
                // Whoops, we don't have a page for that!
                show_404();
            }
            //url helper wordt gebruikt voro de "base_url()" functie
            $this->load->helper('url');
            
            //tekst instellen voor title, css en menu 
            $config = array(
                'title' => 'informatie pagina',
                'style' => '.footer {position:fixed;left:0px;bottom:0px;width:100%;line-height: 24px;font-size: 11px;background: #fff;background: rgba(255, 255, 255, 0.5);text-transform: uppercase;z-index: 9999;box-shadow: 1px 0px 2px rgba(0,0,0,0.2);}
                            .footer span.right {float: right;}
                            .author{font-family: "Courier New";margin-right: 5px;}',
                'menu' =>'<ul>
                            <li>
                                <a href="'.  base_url().'index.php/kalender/maandOverzicht">maandoverzicht</a>
                            </li>
                            <li>
                                <a href="'.  base_url().'index.php/kalender/weekOverzicht">weekoverzicht</a>
                            </li>
                            <li>
                                <a href="'.  base_url().'index.php/aanmelden/login">aanmelden</a>
                            </li>
                        </ul>'
            );
            
            //model laden + tekst instellen
            $this->load->model('Informatief_Model');
            $this->Informatief_Model->initialize($config);
            
            //achtergrond van webpagina instellen
            //$this->Informatief_Model->setBackground('blue', 'http://hdwallsize.com/wp-content/uploads/2013/06/Background-White-Wallpaper-Free.jpg');
            
            //titel ophalen uit model
            $data['title'] = $this->Informatief_Model->title;
            //css ophalen uit model
            $data['style'] = $this->Informatief_Model->style;
            //header ophalen uit model
            $data['header'] = $this->Informatief_Model->header;
            //menu aanmaken (momenteel handmatig)
            $data['menu'] = $this->Informatief_Model->menu;
            //banner ophalen uit model
            $data['banner'] = $this->Informatief_Model->banner;
            //inhoud ophalen uit model
            $data['content'] = $this->Informatief_Model->content;
            //footer ophalen uit model
            $data['footer'] = $this->Informatief_Model->footer;
            
            //informatie webpagina laden
            $this->load->view('pages/informatie', $data);
	}
}

?>
