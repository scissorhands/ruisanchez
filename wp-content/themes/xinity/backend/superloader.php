<?php
/**
 * Core Class That inits all backend functions.
 */

// Define Variables and constants common to the Framework

define('SN',"IOAR");
define('THEMENAME','Xinity');
define('RAD_Version',3.22);

$ioa_options = array();  // Options array
$ioa_super_options = array(); // precaching of get options variables.
$ioa_sliders = array(); //  Registerd Sliders components stored here
$ioa_custom_posts = array(); $ioa_registered_posts = array(); // Custom Posts Vaules holder & Registered post types 
$ioa_meta_data = array(); // Current posts framework values stored here.
$ioa_shortcodes_array = array(); // IOA Shortcodes
$ioa_sidebars = array("Blog Sidebar"); 
$ioa_page_config = array(); // Page settings stored in this 2D array.
$ioa_head_units = array(); // Header Widgets stored in this array.
$ioa_portfolio_name = "Portfolio";
$ioa_portfolio_slug = 'portfolio';
$ioa_portfolio_taxonomy_label = 'Portfolio Categories' ;
$ioa_portfolio_taxonomy = 'portfoliocategories' ;
$ioa_helper = null;
$ioa_woo_flag = false;
$rad_flag = false;
$IOA_templates = array(); // templates of the theme
$IOAHeader = null;
$radunits = array(); // RAD Builder Registerd components stored here

if ( class_exists( 'woocommerce' ) ) { $ioa_woo_flag =  true; } 

define('IOA_WOO_EXISTS',$ioa_woo_flag);

/**
 * Global Layout Array
 */

$ioa_layout = array(
		"layout" => 1140,
		"content_width" => 1060, 
		'sidebar_content_width' => 740,
		"media_height" => 450,
		'cols' => array(

				"full" => '1060',
				"one_half" => '505',
				"one_third" => '320',
				"one_fourth" => '227',
				"one_fifth" => '172',
				"two_third" => '690',
				"three_fourth" => '783',
				"four_fifth" => '838'
			),
		'sidebar_cols' => array(

				"full" => '740',
				"one_half" => '350',
				"one_third" => '220',
				"one_fourth" => '155',
				"one_fifth" => '116',
				"two_third" => '480',
				"three_fourth" => '545',
				"four_fifth" => '584'
			)
	);



/**
 * Global variable for fonts list.
 * @var array
 */
$or_google_webfonts =  array("Abel","Abril Fatface","ABeeZee","Aclonica","Acme","Alice","Allan","Allerta","Allerta Stencil","Alike","Amaranth","Andada","Anonymous Pro","Anton","Antic","Antic Slab","Arimo","Artifika","Arvo","Averia Sans Libre","Aguafina Script","Bentham","Bevan","Belleza","Brawler","Bree Serif","Cabin","Cardo","Cousine","Cabin","Copse","Cinzel","Crimson Text","Capriola","Cuprum","Cantarell","Coustard","Courgette","Condiment","Dancing Script","Damion","Droid Serif","Droid Sans Mono","Droid Sans","Dosis","Dorsa","Domine","Engagement","Esteban","Exo","Exo 2","Englebert","Francois One","Fugaz One","Forum","Habibi","Karla","Kreon","Kaushan Script","Gruppo","Gochi Hand","Inconsolata","Imprima","Lobster","Lobster Two","Lato","Iceland","Inder","Josefin Slab","Julius Sans One","Josefin Sans","Kavoon","Marvel","Mate","Marck Script","Maiden Orange","Maven Pro","Monda","Merriweather","Merriweather Sans","Merienda One","Montez","News Cycle","Nixie One","Nova Round","Nova Script","Nova Slim","Nobile","Numans","Open Sans","Open Sans Condensed","Oleo Script","Oswald","Overlock","Old Standard TT","Oxygen","Orienta","Ovo","PT Sans Narrow","Playfair Display","Playball","PT Sans","PT Serif","Pacifico","Philosopher","Questrial","Quicksand","Russo One","Racing Sans One","Raleway","Rambla","Rosario","Rokkitt","Roboto","Romanesco","Sanchez","Satisfy","Shanti","Source Sans Pro","Petit Formal Script","Tangerine","Terminal Dosis Light","Terminal Dosis","Tenor Sans","Text Me One","Tienne","Tinos","Titillium Web","Trykker","Trocchi","Ubuntu","Ubuntu Condensed","Vollkorn","Wendy One","Yanone Kaffeesatz","Yellowtail");
$websafe_fonts = array("Default", "Arial","Helvetica Neue","Helvetica",'Imapct','Tahoma',"Verdana","Lucida Grande","Lucida Sans");
$ioa_google_webfonts = array_merge($websafe_fonts,$or_google_webfonts);

/**
 * Visual Settings
 */

$ioa_visual_data = array(
						
						"General Settings" => array(

							array( "label" => "Primary Color" , "name" => 'primary_color', "help" => "This will change the main color of the site like active menu colors, button backgrounds and at important visual places."  ),
							array("label" => "Primary Alternate Color" , "name" => 'primary_alt_color' , "help" =>'' ),
							array("label" => "Secondary Color" , "name" => 'secondary_color' , "help" =>'' ),
							array("label" => "Links Color" , "name" => 'link_color' , "help" =>'' ),
							array("label" => "Links Hover Color" , "name" => 'link_hover_color', "help" =>''  ),
							array("label" => "Title Color" , "name" => 'title_color', "help" =>''  ),
							array("label" => "Text Color" , "name" => 'color', "help" =>''  ),

							),

						"Head Area Settings" => array(

							array("label" => "Primary Color" , "name" => 'menu_primary_color' , "help" =>'' ),
							array("label" => "Primary Alternate Color" , "name" => 'menu_primary_alt_color' , "help" =>'' ),
							array("label" => "Secondary Color" , "name" => 'menu_secondary_color' , "help" =>'' ),
							array("label" => "Links Color" , "name" => 'menu_link_color' , "help" =>'' ),
							array("label" => "Links Hover Color" , "name" => 'menu_link_hover_color', "help" =>''  ),
							array("label" => "Text Color" , "name" => 'menu_text_color', "help" =>''  ),
							array("label" => "Menu Item Color" , "name" => 'menu_title_color', "help" =>''  ),

							),
						"Content Settings" => array(

							array("label" => "Links Color" , "name" => 'p_link_color' , "help" =>'' ),
							array("label" => "Links Hover Color" , "name" => 'p_link_hover_color', "help" =>''  ),
							array("label" => "Text Color" , "name" => 'p_text_color', "help" =>''  ),	
							array("label" => "Title Color" , "name" => 'p_title_color', "help" =>''  ),

							),
						 "Footer Settings" => array(

						 	array("label" => "Footer Primary Color" , "name" => 'footer_primary_color' , "help" =>'' ),
						 	array("label" => "Footer Background Color" , "name" => 'footer_color' , "help" =>'' ),
						 	array("label" => "Links Color" , "name" => 'f_link_color' , "help" =>'' ),
							array("label" => "Links Hover Color" , "name" => 'f_link_hover_color', "help" =>''  ),
							array("label" => "Text Color" , "name" => 'f_text_color', "help" =>''  ),	
							array("label" => "Title Color" , "name" => 'f_title_color', "help" =>''  ),

							),
						 "Bottom Footer Settings" => array(

						 	array("label" => "Background Color" , "name" => 'bf_color' , "help" =>'' ),
						 	array("label" => "Links Color" , "name" => 'bf_link_color' , "help" =>'' ),
							array("label" => "Links Hover Color" , "name" => 'bf_link_hover_color', "help" =>''  ),
							array("label" => "Text Color" , "name" => 'bf_text_color', "help" =>''  ),	

							),

						 "Sidebar Settings" => array(

						 	array("label" => "Sidebar Primary Color" , "name" => 'sidebar_primary_color' , "help" =>'' ),
						 	array("label" => "Sidebar Text Color" , "name" => 'sidebar_text_color' , "help" =>'' ),
						 	array("label" => "Sidebar Links Color" , "name" => 'sidebar_link_color' , "help" =>'' ),
							array("label" => "Sidebar Links Hover Color" , "name" => 'sidebar_link_hover_color', "help" =>''  ),
							array("label" => "Sidebar Title Color" , "name" => 'sidebar_title_color', "help" =>''  ),	
							)
					
					);	

/**
 * Typography Settings
 */

$ioa_typo_list = array(

					array(  "title" => "Set Body Font",	"id" => "body_font" , "selector" => "body"),
					array(  "title" => "Set H1's Font",	"id" => "h1_font" , "selector" => "h1" ),
					array(  "title" => "Set H2's Font",	"id" => "h2_font" , "selector" => "h2" ),
					array(  "title" => "Set H3's Font",	"id" => "h3_font" , "selector" => "h3" ),
					array(  "title" => "Set H4's Font",	"id" => "h4_font" , "selector" => "h4" ),
					array(  "title" => "Set H5's Font",	"id" => "h5_font" , "selector" => "h5" ),
					array(  "title" => "Set H6's Font",	"id" => "h6_font" , "selector" => "h6" ),
					array(  "title" => "Set Top Menu Font",	"id" => "topmenu_font" , "selector" => "#top_bar_area .menu li"),
					array(  "title" => "Set Main Menu and Bottom Menu Font",	"id" => "mainmenu_font" , "selector" => "div.theme-header #main_menu_area .menu , div.theme-header #bottom_bar_area .menu" ),
					);

$ioa_font_size_list = array(  "body_font_font_size" => 13 , "topmenu_font_font_size" => 13 , "mainmenu_font_font_size"  => 13, "h1_font_font_size" => 36, "h2_font_font_size"=> 30 , "h3_font_font_size"=> 24 ,"h4_font_font_size"=> 18 ,"h5_font_font_size"=> 12 ,"h6_font_font_size" => 10 );

$data = get_option(SN.'_enigma_data');
$ioa_custom_list = array();

if( isset($data['custom_typo_list']) && is_array($data['custom_typo_list'] ) )
$ioa_custom_list = $data['custom_typo_list'] ;
$cmake = array();


foreach ($ioa_custom_list  as $key => $value) {
		$cmake[] = array( "title" => $value['name'] , "id" => str_replace(' ','_',$value['name']) , "selector" => $value['selector']  );
	}

$ioa_typo_list = array_merge( $ioa_typo_list , $cmake );		

/**
 * Core Includes
 */

require_once('ioa_actions.php'); // This needs to be first
require_once('classes/class_htmlcodes.php'); // This needs to be second

/**
 *  Base Class for creating Admin panels ~~ By Default Sub menus are added to Options Panel.
 */
require_once('classes/class_admin_panel_maker.php');   
require_once(HPATH.'/classes/class_options.inc');
require_once(HPATH.'/classes/class_slider.php');
require_once(HPATH.'/classes/class_radstyler.php');
require_once(HPATH.'/classes/class_enigma.php');
require_once(HPATH.'/classes/class_font_support.php');
require_once(HPATH.'/classes/class_headerdata.php');
require_once(HPATH.'/classes/class_custom_posts.php');
require_once(HPATH.'/classes/class_custom_posts_maker.php');
require_once(HPATH.'/classes/class_pagination.php');
require_once(HPATH.'/classes/class_enigma_front.php');
require_once(HPATH.'/classes/hypermenu.php'); // Hyper Menu 
require_once(HPATH.'/page_settings.php'); // Page Settings
require_once(PATH.'/style_config.php'); // Style Config 

/**
 * Input Generator for Framework
 */

require_once('classes/ui.php');   	
require_once('classes/class_metabox.php');

/**
 *  Helper file
 */


require_once('helper.php');

/**
 * Rad Unit Class needs to be after helper
 */
require_once(HPATH.'/classes/class_radunit.inc');
require_once(HPATH.'/classes/class_radmarkup.php');
require_once(HPATH.'/classes/class_radpagebuilder.php');


/**
 *  Options & Options Panel
 */


require_once('options_panel.php'); 


/**
 *  Header Constructor Panel
 */


require_once('home_page_panel.php'); 


/**
 *  Media Manager
 */


require_once('media_manager.php'); 


/**
 *  Enigma Styler
 */


require_once('enigma_backend.php'); 

/**
 *  User Manager
 */


require_once('user_roles.php'); 

/**
 *  Custom Posts Manager
 */


require_once('customposts_manager.php'); 

/**
 *  Installer Manager
 */

require_once('installer.php'); 


/**
 *  Update
 */
$ioa_upgrader = null;
if(get_option(SN.'_en_key')) :

	require_once(HPATH.'/lib/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php'); 
	require_once('auto_update.php'); 

	$ioa_upgrader  = new Envato_WordPress_Theme_Upgrader( get_option(SN.'_en_username'), get_option(SN.'_en_key') ); 

endif;

/**
 *  Widgets
 */


require_once('theme_widgets.php'); 


/**
 *  Shortcodes
 */


require_once('shortcodes.php'); 

/**
 * Ajax Listener
 */

require_once('listener.php');   


/**
 * BBPress Support
 */

if( function_exists('is_bbpress') ) :
require_once(PATH.'/config/config-bbpress.php'); 
require_once(PATH.'/bbpress/bbpress-functions.php');
endif;
