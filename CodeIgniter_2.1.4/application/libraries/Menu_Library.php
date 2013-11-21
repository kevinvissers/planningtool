<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Menu_Library
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @version		1.0
 * @date		01/11/2013
 * @copyright (c)       2013, KHLIM-ict
 *
 * the Menu_Library class has the following properties and methods:
 * properties:  activeMenu
 * methods: ToonMenu
 *
 */
class Menu_Library {
    /********************* PROPERTIES ********************/
/**
 * @access	private 
 */
    private $activeMenu = '';
    /********************* METHODS ********************/
/**
 * @access	public
 */    
    public function __construct($params)
    {
        // Do something with $params
        $this->activeMenu = $params['active'];
    }
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @return          string Geeft een string terug met de html-code van het hoofdmenu
     *
     */
    public function ToonMenu()
    {
        return '<!-- Nav Bar -->

		<div class="row">
		<div class="large-12 columns">
		  <nav class="top-bar">
                    <ul class="title-area">

                        <!-- Title Area -->
                        <li class="name">
                            <h1>
                                <a href="'.base_url().'index.php">
                                        Planningtool
                                </a>
                            </h1>
                        </li>
                        <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
                    </ul>					 
                    <section class="top-bar-section">
                        <ul class="left">
                            <li class="has-dropdown">
                              <a class="active" href="#">Kalenderweergaven</a>
                              <ul class="dropdown">
                                <li><label>Kalenders</label></li>
                                <li><a href="'.base_url().'index.php/kalender/maandOverzicht">Maandoverzicht</a></li>
                                <li><a href="'.base_url().'index.php/kalender/weekOverzicht">Weekoverzicht</a></li>
                                <li><a href="'.base_url().'index.php/kalender/dagOverzicht">dagoverzicht</a></li>
                              </ul>
                            </li>
                            <!--<li><a href="">Extra</a></li>-->
                        </ul>
                        <ul class="right">
                            <li class="has-button">
                              <a class="small button knopje" href="'.base_url().'index.php/aanmelden/login">Aanmelden</a>
                            </li>
                        </ul>
                    </section>
                </nav>
		  <h1>Planningtool <small>Here you can plan everything!</small></h1>
		  <hr />
		</div>
		</div>

	<!-- End Nav -->';
    }
}

?>
