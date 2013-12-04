<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Menu_Library
 *
 * @package             planningtool
 * @author              Kevin Vissers <kevin.vissers@student.khlim.be>
 * @author              Bart Bollen <bart.bollen@student.khlim.be>
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
    private $currentController = '';
    private $loggedIn = false;
    private $user = '';
    private $userRole = 0;
    /********************* METHODS ********************/
/**
 * @access	public
 */    
    public function __construct($params)
    {
        // Do something with $params
        $this->currentController = $params['currentController'];
        $this->loggedIn = $params['loggedIn'];
        $this->user = $params['user'];
        $this->userRole = $params['userRole'];
    }
    /**
     * @author 		Kevin Vissers
     * @access 		public
     * @return          string Geeft een string terug met de html-code van het hoofdmenu
     *
     */
    public function ToonMenu()
    {
        $strHtml = '<!-- Nav Bar -->

		<div class="row">
		<div class="large-12 columns">
		  <nav class="top-bar">
                    <ul class="title-area">

                        <!-- Title Area -->
                        <li class="name">
                            <h1>
                                <a href="'.site_url().'">Planningtool</a>
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
                                <li><a href="'.site_url().'/kalender/maandOverzicht">Maandoverzicht</a></li>
                                <li><a href="'.site_url().'/kalender/weekOverzicht">Weekoverzicht</a></li>
                                <!--<li><a href="'.site_url().'/kalender/dagOverzicht">dagoverzicht</a></li>-->
                              </ul>
                            </li>
                            <!--<li><a href="">Extra</a></li>-->
                        </ul>';
                        if($this->userRole == 3){
                        $strHtml .= '<ul class="left">
                            <li class="has-dropdown">
                              <a class="active" href="#">Gebruikers</a>
                              <ul class="dropdown">
                                <li><a class="iconlink" href="'.site_url().'/gebruiker/toevoegen">
                                    <i class="step fi-plus size-21"></i>
                                    &nbsp;&nbsp;
                                    Toevoegen
                                    </a>
                                </li>
                                <li><a class="iconlink" href="'.site_url().'/gebruiker/bewerken">
                                    <i class="step fi-pencil size-21"></i>
                                    &nbsp;&nbsp;
                                    Bewerken
                                    </a>
                                </li>
                              </ul>
                            </li>
                            <!--<li><a href="">Extra</a></li>-->
                        </ul>';
                        }
                        $strHtml .= '<ul class="left">
                                <li class="has-dropdown">
                                  <a class="active" href="#">Klanten</a>
                                  <ul class="dropdown">
                                    <li><a class="iconlink" href="'.site_url().'/klanten/toevoegen">
                                        <i class="step fi-plus size-21"></i>
                                        &nbsp;&nbsp;
                                        Toevoegen
                                        </a>
                                    </li>
                                    <li><a class="iconlink" href="'.site_url().'/klanten/bewerken">
                                        <i class="step fi-pencil size-21"></i>
                                        &nbsp;&nbsp;
                                        Bewerken
                                        </a>
                                    </li>
                                  </ul>
                                </li>
                                <!--<li><a href="">Extra</a></li>-->
                            </ul>';
        if($this->loggedIn){             
        $strHtml .= '<ul class="right">
                        <li class="has-dropdown">
					<a href="#" style="color:#888">
					'.$this->user.'
					</a>
					<ul class="dropdown">
                                                <li><a class="iconlink" href="">
							<i class="step fi-torso size-21"></i>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<span>Profiel</span>
                                                    </a>
                                                </li>
						<li><a class="iconlink" href="'.site_url().'/gebruiker/wachtwoordWijzigen">
							<i class="step fi-pencil size-21"></i>
                                                        &nbsp;&nbsp;&nbsp;Bewerken
                                                    </a>
                                                </li>
						<li>  
                                                    <a class="iconlink" href="'.site_url().'/'.$this->currentController.'/logout">
							<i class="step fi-power size-21"></i>
                                                        &nbsp;&nbsp;&nbsp;Afmelden
                                                    </a>
                                                </li>
					</ul>
				</li>  
                    </ul>';
        }
        $strHtml .= '</section>
                </nav>
		  <h1>Planningtool <small>Here you can plan everything!</small></h1>
		  <hr />
		</div>
		</div>
                <div class="row">
                    <div class="large-12 columns">
                    </div>
                </div>

	<!-- End Nav -->';
        return $strHtml;
    }
}

?>
