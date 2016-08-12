<?php
/**
 *  Core Class For Generating Theme Options
 */


/*
 * Currently using old pattern for storing options. Will be Upgraded in coming versions.



======================================================================================
== IOA Option Panel ================================================================
======================================================================================

Version 6.1 
Authors - 

Current Elements -
--------------------------------------------------------
  1.  Text Box            =  ( code => text ) Creates a text box. 
  2.  Text Area           =  ( code => textarea) Creates a textarea 
  3.  Checkboxes          =  ( code => checkbox) Creates checkboxes
  4.  Radio buttons       =  ( code => radio) Creates Radio buttons
  5.  Slider              =  ( code => slider) Creates a numeric slider
  6.  Color picker        =  ( code => colorpicker) Creates a color picker with a supporting textbox
  7.  Drop down lists     =  ( code => select) Creates a dropdown list
  8.  Toggle              =  ( code => toggle) Creates a Yes/No radio button set
  9.  Includes            =  ( code => include) Adds a way to include advance panels
  10. Upload              =  ( code => upload) Creates an upload box
  11. Help                =  ( code => help) Creates a inframe which can be link to pages.
======================================================================================

*/


global $ioa_options;
$pmb ='';

$post_meta_shortcodes =  array(

					"post_author" => array(
							"name" =>  __("Post Author",'ioa'),
							"syntax" => '[post_author_posts_link/]',
							),	
					"post_date" => array(
							"name" =>  __("Post Date",'ioa'),
							"syntax" => '[post_date format=\'\'/]',
							"markup" => "<select><option value='default'>Wordpress Date Format</option><option value='m/d/Y'>Month / Day / Year</option><option value='F j,Y'>Month Day, Year</option><option value='d-m-Y'>Day - Month - Year</option><option value='Y-m-d'>Year - Month - date</option><option value='l, F d S, Y'>Day, Month Date Year</option></select>"
							),					
					"post_time" => array(
							"name" =>  __("Post Time",'ioa'),
							"syntax" => '[post_time format=\'g:i a\'/]',
							),	
					"post_tags" => array(
							"name" =>  __("Post Tags",'ioa'),
							"syntax" => '[post_tags sep=\',\' icon=\'\' /]',
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep=\',\' icon=\'\' /]',
							),
					"get" => array(
							"name" =>  __("Post Meta",'ioa'),
							"syntax" => '[get name=\'\' /]',
							),
					"post_comments" => array(
							"name" => __("Post Comments",'ioa'),
							"syntax" => "[post_comments /]"
							)

						);

foreach($post_meta_shortcodes as $sh)
{
	 $pmb .= " <div class='post-meta-item' data-syntax=\"".$sh['syntax']."\">".$sh['name'];
	 if(isset($sh['markup'])) $pmb .= $sh['markup'];
	 $pmb .= "<a href='' class='button-default'>Add</a></div> ";
}

$osidebars = array("Blog Sidebar");
if( get_option(SN.'_custom_sidebars'))
{
	$dys = explode(',',get_option(SN.'_custom_sidebars'));
	foreach($dys as $s)
			{
				if($s!="")
				{
					$osidebars[] = $s;
				}
			} 
}

/*
_font_face_font
 */
$font_faces = array();

$ffpath = PATH."/sprites/fontface";
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ffpath), RecursiveIteratorIterator::SELF_FIRST);

foreach($objects as $name => $object){
	 if( $object->isDir() )
					    {
					    	 
								$folder_info = pathinfo($name);
								$current_dir = $folder_info['basename'];
					    		if($current_dir!='.' && $current_dir!='..')
					    		$font_faces[] = $current_dir;
					    	
					    }
	}

/* ====================================================================================== */
/* == General Settings Panel ============================================================ */
/* ====================================================================================== */
$ioa_options = array();
$ioa_options[]   = array( 
		           "name" => __("General Settings",'ioa'),
	  	           "type" => "section", "icon" => "pencil"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Basic Settings",'ioa'),__("Logo Settings",'ioa'),__("Head Area Settings",'ioa'),__("BreadCrumbs",'ioa'),__("Misc",'ioa'))  );

		  

	
	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Basic Settings",'ioa') , 
				   "type"=>"subtitle" , 
				  );





$ioa_options[]   = array(
                  "name" => __("Favicon Upload",'ioa'),
				  "desc" => __("upload your favicon here. You can generate favicon from here http://www.favicon.cc/",'ioa'),
				  "id" => SN."_favicon",
				  "type" => "upload",
				  "title" => __("Use as Favicon",'ioa'),
				  "std" => "",
				  "button" => __("Add Favicon",'ioa'), "title" => __("Add Favicon",'ioa')	 
				  );				  


$ioa_options[]   = array(
                  "name"=>__("Number of search results in AJAX Search to show",'ioa'),
			      "desc"=> __("No of posts/pages to show in ajax result in head area",'ioa'),
			      "id" => SN."_ajax_nos",
				  "type"=>"slider",
				  "max"=>10,
				  "std"=>4,
				  "suffix"=>" posts"
					 );


$ioa_options[]   = array(
                 "name" => __("Custom JavaScript Code",'ioa'),
	             "desc" => __("Add your JavaScript code here, this will be added in head section inside <strong>script tags.</strong>, No need to add &lt;script&gt; tags.",'ioa'),
	             "id" => SN."_headjs_code",
	             "type" => "textarea",
	             "std" => ""	 
				  );	
				   
$ioa_options[]   = array(
                 "name" => __("Tracking Code",'ioa'),
	             "desc" => __("Add your Google Analytics code or some other, this will be in footer inside <strong>script tags.</strong>, DO NOT ADD &lt;script&gt; tags.",'ioa'),
	             "id" => SN."_tracking_code",
	             "type" => "textarea",
	             "std" => ""	 
				  );	


				  			  				  				  				  				  				  			  				  
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[] = array(
				"name" => __("Logo Settings",'ioa'),
				"type" => "subtitle"	
				);

$ioa_options[]   = array(
                  "name" => __("Logo Upload",'ioa'),
				  "desc" => __("upload your logo here.",'ioa'),
				  "id" => SN."_logo",
				  "type" => "upload",
				  "title" => __("Use as Logo",'ioa'),
				  "std" => URL."/sprites/i/logo.png",
				  "button" => __("Add Logo",'ioa'), "title" => __("Add Logo",'ioa')	 
				  );

$ioa_options[]   = array(
                  "name" => __("Retina Logo Upload",'ioa'),
				  "desc" => __("upload your Retina logo here. It should be twice is your logo",'ioa'),
				  "id" => SN."_rlogo",
				  "type" => "upload",
				  "title" => __("Use as Logo",'ioa'),
				  "std" => URL."/sprites/i/logo.png",
				  "button" => __("Add Logo",'ioa'), "title" => __("Add Logo",'ioa')	 
				  );



$ioa_options[]   = array(
                  "name" => __("Logo Upload for Compact Menu( max height 38px )",'ioa'),
				  "desc" => __("upload logo for compact menu here else default logo will show.",'ioa'),
				  "id" => SN."_clogo",
				  "type" => "upload",
				  "title" => __("Use as Logo",'ioa'),
				  "std" => URL."/sprites/i/clogo.png",
				  "button" => __("Add Logo",'ioa'), "title" => __("Add Logo",'ioa')	 
				  );


$ioa_options[]   = array(
                  "name" => __("Mobile(57px by 57px) and Tables Touch Icon Upload",'ioa'),
				  "desc" => __("upload your icon for apple iphone touch icon. Width and Height should be 57px x 57px",'ioa'),
				  "id" => SN."_generic_touch",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa') 
				  );


$ioa_options[]   = array(
                  "name" => __("iOS7 Retina(120px by 120px) Touch Icon Upload",'ioa'),
				  "desc" => __("upload your icon for apple iPad touch icon. Width and Height should be 72px x 72px",'ioa'),
				  "id" => SN."_iphone7_retina_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" =>  "",
				  "button" => __("Add Icon",'ioa') 
				  );

$ioa_options[]   = array(
                  "name" => __("iOS6 Retina(114px by 114px) Touch Icon Upload",'ioa'),
				  "desc" => __("upload your icon for apple iPad touch icon. Width and Height should be 114px x 114px",'ioa'),
				  "id" => SN."_iphone_retina_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa') 
				  );

$ioa_options[]   = array(
                  "name" => __("Retina(72px by 72px) Touch Icon Upload",'ioa'),
				  "desc" => __("upload your icon for apple iPad touch icon. Width and Height should be 72px x 72px",'ioa'),
				  "id" => SN."_ipad_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa')
				  );

$ioa_options[]   = array(
                  "name" => __("Retina Touch(144px by 144px) Icon Upload",'ioa'),
				  "desc" => __("upload your icon for apple iPad touch icon. Width and Height should be 144px x 144px",'ioa'),
				  "id" => SN."_ipad_retina_icon_logo",
				  "type" => "upload",
				  "title" => __("Use as Icon",'ioa'),
				  "std" => "",
				  "button" => __("Add Icon",'ioa')
				  );


$ioa_options[]   = array(
                  "name" => __("Logo Width",'ioa'),
				  "desc" => __("Width of Logo(Will be added automatically when you add logo)",'ioa'),
				  "id" => SN."_logo_width",
				  "type" => "text",
				  "std" => ""
				  );


$ioa_options[]   = array(
                  "name" => __("Logo Height",'ioa'),
				  "desc" =>__("Height of Logo(Will be added automatically when you add logo)",'ioa'),
				  "id" => SN."_logo_height",
				  "type" => "text",
				  "std" => ""
				  );

$ioa_options[] = array("type" => "close_subtitle");	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Head Area Settings",'ioa') , 
				   "type"=>"subtitle" , 
				  );

$ioa_options[]   =  array( 
				  "name" => __("Show/hide Compact Sticky Bar",'ioa'),
				  "desc" => __("Show or hide the sticky bar that shows when you scroll down",'ioa'),
				  "id" => SN."_cmenu_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	


$ioa_options[]   = array( 
				  "name" => __("Menu Dropdown show style",'ioa'),
				  "desc" => __("select the reveal style for dropdowns.",'ioa'),
				  "id" => SN."_submenu_effect",
				  "type" => "select",
				  "options" => array("None" => __("None",'ioa'),"Fade" => __("Fade",'ioa'),"Fade Shift Down" => __("Fade Shift Down",'ioa'),"Fade Shift Right" => __("Fade Shift Right",'ioa'),"Scale In Fade" => __("Scale In Fade",'ioa'),"Scale Out Fade" => __("Scale Out Fade",'ioa'),"Grow" => __("Grow",'ioa'),"Slide" => __("Slide",'ioa')),
				  "std" => "Type 1"
				 );			


$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("BreadCrumbs" ,'ioa'), 
				   "type"=>"subtitle" , 
				   "id"=>"BreadCrumbs"
					 );
					 	
$ioa_options[]   =  array( 
				  "name" => __("Show/Hide Breadcrumbs",'ioa'),
				  "desc" => __("Enable/ Disable Breadcrumbs all over the theme.",'ioa'),
				  "id" => SN."_breadcrumbs_enable",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   = array(
                  "name" => __("Breadcrumb Delimiter",'ioa'),
	              "desc" => __("Enter the symbol for separator words in breadcrumb.",'ioa'),
	              "id" => SN."_breadcrumb_delimiter",
	              "type" => "text",
	              "std" => "/"	 
				  );
				  
$ioa_options[]   = array(
                  "name" => __("Enter Home Label",'ioa'),
	              "desc" => __("Enter the home label for breadcrumb.",'ioa'),
	              "id" => SN."_breadcrumb_home_label",
	              "type" => "text",
	              "std" => "Home"	 
				  );				
									  				  										 
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Misc",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"misc"
					 );

$ioa_options[]   = array( 
				  "name" => __("Show Pagination Dropdown",'ioa'),
				  "desc" => __("show or hide pagination dropdown in blog and portfolio templates.",'ioa'),
				  "id" => SN."_pagination_dropdown",
				 
				 "type" => "toggle",
				  "std" => "true",
				 );



$ioa_options[]   = array( 
				  "name" => __("Show Posts Comments",'ioa'),
				  "desc" => __("show/hide posts comments.",'ioa'),
				  "id" => SN."_posts_comments",
				  "type" => "toggle",
				  "std" => "true",
				 );	


$ioa_options[]   = array( 
				  "name" => __("Show Page Comments",'ioa'),
				  "desc" => __("show/hide page comments.",'ioa'),
				  "id" => SN."_page_comments",
				  "type" => "toggle",
				  "std" => "false",
				 );	


				 				 				 				 		 				
$ioa_options[]   = array( 
				  "name" => __("Select Prettyphoto Theme",'ioa'),
				  "id" => SN."_pptheme",
				  "type" => "select",
				  "std" => "pp_default",
				  "options" => array( "pp_default" => "Default" , "light_rounded" => "Light Rounded" , "dark_rounded" => "Dark Rounded", "light_square" => "Light Square", "dark_square" => "Dark Square", "facebook" => "Facebook"),
				  "desc" => __("Select lightbox color theme",'ioa')
				 );	


$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */




$ioa_options[]   = array("type"=>"close");



/* ====================================================================================== */
/* == Social Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Social Settings",'ioa'),
	  	           "type" => "section", "icon" => "share"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array("Twitter Settings") );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Twitter Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   
					 );

$ioa_options[] = array(

				  "type" => "custom",
				  "std" => "<div class='ioa-information-p'> You can create it here <a href='https://dev.twitter.com/apps/new' style='color:#fff'>https://dev.twitter.com/apps/new</a> </div>"	

				);

$ioa_options[]   = array(
                  "name" => __("Consumer key",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => SN."_twitter_key",
	              "type" => "text",
	              "std" => ""	 
				  );


$ioa_options[]   = array(
                  "name" => __("Consumer secret",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => SN."_twitter_secret_key",
	              "type" => "text",
	              "std" => ""	 
				  );

$ioa_options[]   = array(
                  "name" => __("Access Token",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => SN."_twitter_token",
	              "type" => "text",
	              "std" => ""	 
				  );

$ioa_options[]   = array(
                  "name" => __("Access token secret",'ioa'),
	              "desc" => "You can create it here https://dev.twitter.com/apps/new.",
	              "id" => SN."_twitter_secret_token",
	              "type" => "text",
	              "std" => ""	 
				  );
				  					
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

	
$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Social Panel Ends =---================================================================ */
/* ====================================================================================== */


/* ====================================================================================== */
/* == General Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Sidebars",'ioa'),
	  	           "type" => "section" ,"icon" => "numbered-list"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Sidebar Settings",'ioa'),__("Misc Pages Sidebars",'ioa')) );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Sidebar Settings" ,'ioa'), 
				   "type"=>"subtitle" , 
				   
					 );


$ioa_options[] = array(

				  "type" => "custom",
				  "std" => "<div class='ioa-information-p'>".__("Sidebar Manager allows you to create Widgetzed Areas that can be used in sidebars for pages or post or in Page Builder Sidebar Widget. Once you have created a sidebar , goto widgets page under Appearance menu and the widget area will appear there.",'ioa')."</div>"	

				);

$ioa_options[]   = array(
						"name" => __("Visual File",'ioa'), 
						"type"=>"include", 
						"std"=> HPATH."/adv_mods/sidebar.php"
					  );	

				  
				  					
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ==================================================================== */

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Misc Pages Sidebars",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"pagesmisc"
					 );



$ioa_options[]   = array( 
				  "name" => __("Search Sidebar",'ioa'),
				  "desc" => __("Set sidebar for search page by default Blog Sidebar will show",'ioa'),
				  "id" => SN."_search_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );
				 				 				 		 				
$ioa_options[]   = array( 
				  "name" => __("Archive Sidebar",'ioa'),
				  "desc" =>  __("Set sidebar for archives or custom taxonomies page by default Blog Sidebar will show",'ioa'),
				  "id" => SN."_archive_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );


$ioa_options[]   = array( 
				  "name" => __("Tags Sidebar",'ioa'),
				  "desc" =>  __("Set sidebar for tags page by default Blog Sidebar will show",'ioa'),
				  "id" => SN."_tag_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array( 
				  "name" => __("Author Sidebar",'ioa'),
				  "desc" =>  __("Set sidebar for author page by default Blog Sidebar will show",'ioa'),
				  "id" => SN."_author_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array( 
				  "name" => __("Category Sidebar",'ioa'),
				  "desc" =>  __("Set sidebar for category page by default Blog Sidebar will show",'ioa'),
				  "id" => SN."_category_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */



$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == SEO Panel Ends =---================================================================ */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Menu Settings Panel Ends ======================================================= */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Layout Settings",'ioa'),
	  	           "type" => "section", "icon" => "browser"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(__("Default Settings",'ioa')) );

		  

	
/* == Sub Panel Begins ================================================================== */

$ioa_options[]   = array(
				   "name" => __("Default Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   
					 );

$ioa_options[]   = 	array( 
						"name" => __("Switch On Boxed Layout",'ioa'),
						"desc" => __("If you want to show boxed layout switch this option on, by default full layout is active.",'ioa'),
						"id" => SN."_boxed_layout",
						"type" => "toggle",
						"std" => "false"
					  );	

$ioa_options[]   = 	array( 
						"name" => __("Show Sidebar on Mobile Devices",'ioa'),
						"desc" => __("If you want to show sidebars on mobile view, select yes else they will not show",'ioa'),
						"id" => SN."_show_mobile_sidebar",
						"type" => "toggle",
						"std" => "false"
					  );	

$ioa_options[]   =  array( 
				  "name" => "Enable/ Disable Responsive View",
				  "desc" => __("Enable/ Disable Mobile View all over the theme. The site will look at it looks on a standard screen",'ioa'),
				  "id" => SN."_mobile_view",
				  "type" => "toggle",
				  "std" => "true"
					);	
				
				
$ioa_options[]   = array(
                  "name"=>__("Set Container Width for Mobile Devices",'ioa'),
			      "desc"=> __("You can set the width of container in devices smaller than 767px",'ioa'),
			      "id" => SN."_res_width",
				  "type"=>"slider",
				  "max"=>100,
				  "std"=>70,
				  "suffix"=>"%"
					 );
$ioa_options[]   = array(
						"name" => __(" Panel File",'ioa'), 
						"type"=>"include", 
						"std"=> HPATH."/adv_mods/layout.php"
					  );

				  					
$ioa_options[]   = array("type"=>"close_subtitle");



$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Menu Panel Ends =---================================================================ */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Footer Panel ====================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Footer",'ioa'),
	  	           "type" => "section" , "icon" => "text-doc"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array("Footer Settings"));

		  

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Footer Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"fsettings"
					 );

$ioa_options[]   = array( 
				  "name" => __("Show Footer Widgets column area",'ioa'),
				  "desc" => __("Show or Hide footer widgets area","ioa"),
				  "id" => SN."_footer_widgets",
				  "type" => "toggle",
				  "std" => "true"
				   );
				   

$ioa_options[]   = array(
						"name" => __("Footer Panel File",'ioa'), 
						"type"=>"include", 
						"std"=> HPATH."/adv_mods/footer.php"
					  );

$ioa_options[]   = array( 
				  "name" => __("Show Bottom Footer Area",'ioa'),
				  "desc" => __("Show Bottom Footer Bar (Text and Menu Area) ",'ioa'),
				  "id" => SN."_footer_menu",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "Yes"
				   );

$ioa_options[]   = array( 
				  "name" => __("Footer Text",'ioa'),
				  "desc" =>  __("Add text that will show in bottom footer bar at left side(HTML supported). ",'ioa'),
				  "id" => SN."_footer_text",
				  "type" => "textarea",
				  "std" => ""
				   );
				   				   										
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Footer Panel Ends ================================================================= */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Portfolio Panel =================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Portfolio",'ioa'),
	  	           "type" => "section" , "icon" => "monitor"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open","tabs" => array(__("Portfolio General",'ioa'),__("Portfolio Template",'ioa'), __("Single Portfolio",'ioa'), __("Portfolio Post Type",'ioa')));

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Portfolio General",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"portfoliooption"
					 );

$ioa_options[]   = 	array( 
						"name" => __("Portfolio Parent Link for Breadcrumb",'ioa'),
						"desc" => __("This will appear as parent portfolio link for items. ex: http//www.example.com/portfolio/portfolio-item",'ioa'),
						"id" => SN."_portfolio_parent_link",
						"type" => "text",
						"std" => ""
					  );

$ioa_options[]   = 	array( 
						"name" => __("Portfolio Parent label for Breadcrumb",'ioa'),
						"desc" => __("Label for the link",'ioa'),
						"id" => SN."_portfolio_blabel",
						"type" => "text",
						"std" => "Portfolio"
					  );

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Portfolio Template",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"portfoliooption"
					 );

$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Live Filter",'ioa'),
						"desc" => __("show or hide portfolio filters on portfolio template where applicable ",'ioa'),
						"id" => SN."_portfolio_filter",
						"type" => "toggle",
						"std" => "true"
					  );		


$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Portfolio View Switch",'ioa'),
						"desc" =>  __("show or hide portfolio view area on portfolio column templates. ",'ioa'),
						"id" => SN."_portfolio_switch",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Use WordPress Excerpt",'ioa'),
						"desc" => __("Use wordpress default excerpt in portfolio templates, by default theme's custom excerpt works.",'ioa'),
						"id" => SN."_portfolio_excerpt",
						"type" => "toggle",
						"std" => "true"
					  );	

$ioa_options[] = array(
                  "name"=>__("Custom Excerpt text Limit",'ioa'),
			      "desc"=> __("set your no of characters for excerpt here. Works Only When custom excerpt is active",'ioa'),
				   "id" => SN."_portfolio_excerpt_limit",
				   "type"=>"slider",
				   "max"=>500,
				   "std"=>300,
				   "suffix"=>"letters");



$ioa_options[]   = 	array( 
						"name" => __("Show Lightbox on posts thumbnail",'ioa'),
						"desc" => __("Show lightbox on posts thumbnail, if no it will point to the post.",'ioa'),
						"id" => SN."_portfolio_enable_thumbnail",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Read More Button Label",'ioa'),
						"desc" => __("Enter the label for Read More button for portfolio templates",'ioa'),
						"id" => SN."_portfolio_more_label",
						"type" => "text",
						"std" => "more"
					  );
					  
$ioa_options[] = array(
                  "name"=> __("Portfolio Items Limit",'ioa'),
			      "desc"=> __("Set items per page limit here for portfolio templates",'ioa'),
				   "id" => SN."_portfolio_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "std"=>6,
				   "suffix"=>"Items");						  					  

$ioa_options[] = array(
                  "name"=>__("Portfolio Post's Image Height",'ioa'),
			      "desc"=> __("Set Height for Image or Slider for items in portfolio templates.",'ioa'),
				   "id" => SN."_p_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>450,
				   "suffix"=>"px");						  					  


$ioa_options[]   = array("type"=>"close_subtitle");


/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Single Portfolio",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"singleportfoliooption"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Extra Fields Separated by <strong>;</strong>",'ioa'),
						"desc" => __("You can find them in single portfolio at the bottom",'ioa'),
						"id" => SN."_single_portfolio_meta",
						"type" => "text",
						"std" => "Time ; Live Site"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Related Posts Title",'ioa'),
						"desc" => __("Enter Title for portfolio related items",'ioa'),
						"id" => SN."_single_portfolio_related_title",
						"type" => "text",
						"std" => "More Similar Projects"
					  );


$ioa_options[]   = 	array( 
						"name" => __("Show Related Area",'ioa'),
						"desc" => __("If Yes, it will show the related portfolio underneath the single portfolio view, else it won't",'ioa'),
						"id" => SN."_single_portfolio_related_enable",
						"type" => "toggle",
						"std" => "true"
					  );	


$ioa_options[]   = array("type"=>"close_subtitle");


/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Portfolio Post Type",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"ppostype"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Post Name",'ioa'),
						"desc" => __("Set the name for portfolio posts, by default it is Portfolio",'ioa'),
						"id" => SN."_portfolio_label",
						"type" => "text",
						"std" => "Portfolio"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Post Slug",'ioa'),
						"desc" => __("Set the slug for portfolio posts( ex : www.yoursite/<strong>portfolio</strong>/item , only letters and numbers allowed ), by default it is portfolio",'ioa'),
						"id" => SN."_portfolio_slug",
						"type" => "text",
						"std" => "portfolio"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Enter Portfolio Post Category(Taxonomy)",'ioa'),
						"desc" => __("Enter Label for portfolio category, by default it is Portfolio Categories.",'ioa'),
						"id" => SN."_portfolio_taxonomy",
						"type" => "text",
						"std" => "Portfolio Categories"
					  );

$ioa_options[]   = array("type"=>"close_subtitle");
$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Portfolio Panel Ends ============================================================== */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Blog & Posts Panel ================================================================ */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Blog Posts",'ioa'),
	  	           "type" => "section" , "icon" => "newspaper"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open", "tabs" => array(__("Blog General Settings",'ioa'),__("Blog Template Settings",'ioa'),__("Single Post Settings",'ioa')));

		  


	
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Blog General Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"bloglayout"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Main Blog Link for Breadcrumb",'ioa'),
						"desc" => __("Enter Link for Blog Parent that will be the link in the structure http://www.example.com/blog/post",'ioa'),
						"id" => SN."_blog_parent_link",
						"type" => "text",
						"std" => ""
					  );

$ioa_options[]   = 	array( 
						"name" => __("Main Blog label for Breadcrumb",'ioa'),
						"desc" => __("Enter label for Blog Parent that will appear in the blog in the structure http://www.example.com/blog/post",'ioa'),
						"id" => SN."_blog_label",
						"type" => "text",
						"std" => "Blog"
					  );

	

$ioa_options[]   = 	  array("type"=>"close_subtitle");


	
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Blog Template Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"bloglayout"
					 );


$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Live Filter",'ioa'),
						"desc" => __("Show or hide animated live fitler on blog templates where applicable",'ioa'),
						"id" => SN."_blog_filter",
						"type" => "toggle",
						"std" => "true"
					  );		


$ioa_options[]   = 	array( 
						"name" => __("Use WordPress Excerpt",'ioa'),
						"desc" => __("Enable/Disable excerpt for blog posts, by default it uses framework's content limiter.",'ioa'),
						"id" => SN."_blog_excerpt",
						"type" => "toggle",
						"std" => "true"
					  );	


$ioa_options[] = array(
                  "name"=>__("Custom Excerpt text Limit",'ioa'),
			      "desc"=> __("set your number of characters for excerpt here. Works Only When WordPress excerpt is disabled",'ioa'),
				   "id" => SN."_posts_excerpt_limit",
				   "type"=>"slider",
				   "max"=>500,
				   "std"=>300,
				   "suffix"=>"letters");

$ioa_options[]   = 	array( 
						"name" => __("Use Lightbox on posts thumbnail",'ioa'),
						"desc" => __("Enable/Disable lightbox on posts thumbnail, if not it will point to the post.",'ioa'),
						"id" => SN."_enable_thumbnail",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = 	array( 
						"name" => __("Read More Button Label",'ioa'),
						"desc" => __("Enter the label for read more button.",'ioa'),
						"id" => SN."_more_label",
						"type" => "text",
						"std" => "more"
					  );
					  
$ioa_options[] = array(
                  "name"=>__("Blog Posts Items Limit",'ioa'),
			      "desc"=> __("Set your posts per page limit here",'ioa'),
				   "id" => SN."_posts_item_limit",
				   "type"=>"slider",
				   "max"=>50,
				   "std"=>6,
				   "suffix"=>"Items");						  					  

$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Posts Metabar",'ioa'),
						"desc" => __("Show or hide the extra post information below title",'ioa'),
						"id" => SN."_blog_meta_enable",
						"type" => "toggle",
						"std" => "true"
					  );

					  					  
$ioa_options[]   = 	array( 
						"name" => __("Post Metabar ( Extra information that appears below title)",'ioa'),
						"desc" => __("You can set the extra infor for posts in blog template here. Available shortcodes <br/><strong>[post_categories]</strong> - List of categories",'ioa')."
<strong>[post_tags]</strong> - ".__("List of post tags",'ioa')."</br>
<strong>[post_comments]</strong> - ".__("Link to post comments",'ioa')."</br>
<strong>[post_author_posts_link]</strong> - ".__("Author and link to archive",'ioa')."</br>
<strong>[post_time]</strong> - ".__("Time of post",'ioa')."</br>
<strong>[post_date]</strong> - ".__("Date of post",'ioa')."</br>",
						"id" => SN."_blog_meta",
						"type" => "textarea",
						"std" => "By [post_author_posts_link] On [post_date] &middot; [post_comments] &middot; In [post_categories] ",
						"after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", 
						"buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>"
					  );


$ioa_options[] = array(
                  "name"=>__("Blog Posts Media Height",'ioa'),
			      "desc"=> __("Set Height for images of posts in blog templates",'ioa'),
				   "id" => SN."_bt_height",
				   "type"=>"slider",
				   "max"=>800,
				   "std"=>360,
				   "suffix"=>"px");			

$ioa_options[]   = 	  array("type"=>"close_subtitle");


	
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Single Post Settings",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"postlayout"
					 );

$ioa_options[]   = 	array( 
						"name" => __("Show Featured Media",'ioa'),
						"desc" => __("Show or hide featured media all over the posts",'ioa'),
						"id" => SN."_featured_image",
						"type" => "toggle",
						"std" => "true"
					  );
					  
$ioa_options[]   = 	array( 
						"name" => __("Show / Hide Metabar information area",'ioa'),
						"desc" => __("Show or hide extra information below image in single post",'ioa'),
						"id" => SN."_meta_s",
						"type" => "toggle",
						"std" => "true"
					  );	

$ioa_options[]   = 	array( 
						"name" => __("Facebook Comments",'ioa'),
						"desc" => __("Show/Hide facebook comment .",'ioa'),
						"id" => SN."_fb_comments",
						"type" => "toggle",
						"std" => "false"
					  );					  					  	
$ioa_options[]   = 	array( 
						"name" => __("Show Author BIO",'ioa'),
						"desc" => __("Don't you need an Author Bio then just disable it here.",'ioa'),
						"id" => SN."_author_bio",
						"type" => "toggle",
						"std" => "true"
					  );

$ioa_options[]   = array( 
				  "name" => __("Enter Related Posts Title",'ioa'),
				  "desc" => __("Enter title for related posts here",'ioa'),
				  "id" => SN."_related_posts_title",
				  "type" => "text",
				  "std" => ""
				  
				   );
				   					
$ioa_options[]   = 	array( 
						"name" => __("Show Related Posts",'ioa'),
						"desc" => __("Want to show your related posts? Then enable them here.",'ioa'),
						"id" => SN."_popular",
						"type" => "toggle",
						"std" => "true"
					  );

					  
$ioa_options[]   = 	array( 
						"name" => __("Single Post Metabar ( Extra information that appears below title)",'ioa'),
						"desc" => __("You can set the extra infor for posts in blog template here. Available shortcodes ",'ioa')."<br/><strong>[post_categories]</strong> - ".__('List of categories','ioa')."
<strong>[post_tags]</strong> - ".__('List of post tags','ioa')."</br>
<strong>[post_comments]</strong> - ".__('Link to post comments','ioa')."</br>
<strong>[post_author_posts_link]</strong> - ".__('Author and link to archive','ioa')."</br>
<strong>[post_time]</strong> - ".__('Time of post','ioa')."</br>
<strong>[post_date]</strong> - ".__('Date of post','ioa')."</br>",
						"id" => SN."_single_meta",
						"type" => "textarea",
						"std" => "By [post_author_posts_link] On [post_date] &middot; [post_comments] &middot; In [post_categories] ",
						"after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", 
						"buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>"
					  );	
					  								  	
$ioa_options[]   = 	  array("type"=>"close_subtitle");

/* == Sub Panel Ends =================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Blog & Posts Panel Ends =========================================================== */
/* ====================================================================================== */


/* ====================================================================================== */
/* == Advanced ========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Advanced",'ioa'),
	  	           "type" => "section" 
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" ,"tabs" => array(__("Auto Update",'ioa'),__("Admin Logo & Misc",'ioa'),__("404 Not Found",'ioa'),__("Under Construction",'ioa')) );


		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Auto Update",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 

$ioa_options[]   =	array( 
						"name" => __("Enter Your Themeforest Username",'ioa'),
						"desc" => "",
						"id" => SN."_en_username",
						"type" => "text",
						"std" => ""
						);		

$ioa_options[]   =	array( 
						"name" => __("Enter Your Themeforest API Key",'ioa'),
						"desc" => __("You can find that by going to settings page on your themeforest account. Click on API keys from bottom left.",'ioa'),
						"id" => SN."_en_key",
						"type" => "text",
						"std" => ""
						);		
				  										
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Admin Logo & Misc",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 
$ioa_options[]   = array( 
				  "name" => __("Admin Login Logo Enable",'ioa'),
				  "desc" => __("Show/Hide admin logo, that appears in http://www.example.com/wp-login.php .",'ioa'),
				  "id" => SN."_enable_admin_logo",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "No"
				   );	

												
$ioa_options[]   = array(
                  "name" => __("Admin Login Logo Upload",'ioa'),
				  "desc" => __("Upload your wp admin logo here.",'ioa'),
				  "id" => SN."_admin_logo",
				  "type" => "upload",
				  "std" => ""	,
				  "button" => "Add Logo", 
				  "title" => "Add Logo"	  
				  );


$ioa_options[]   = array( 
				  "name" => __("Hide Demo Install Panel and Top Menu",'ioa'),
				  "desc" => __("Setting to Yes will hide the installer.",'ioa'),
				  "id" => SN."_hide_installer",
				  "type" => "radio",
				  "options" => array("Yes","No"),
				  "std" => "No"
				   );	

				  										
$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */
	
$ioa_options[]   =  array(
						"name" => __("404 Not Found",'ioa') , 
						"type"=>"subtitle" , 
						"id"=>"notfound"
						);	

$ioa_options[]   = array( 
				  "name" => __("404 Style",'ioa'),
				  "desc" => __("Select 404 style from here",'ioa'),
				  "id" => SN."_not_found_style",
				  "type" => "select",
				  "options" => array("Default","Alternate"),
				  "std" => "Default"
				 );

$ioa_options[]   = array( 
				  "name" => __("404 Sidebar(Available in Alternate Style)",'ioa'),
				  "desc" => __("Select sidebar to show on Alternate 404 style",'ioa'),
				  "id" => SN."_not_found_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );


$ioa_options[]   =	array( 
						"name" => __("404 page title here",'ioa'),
						"desc" => __("Add your 404 title here.",'ioa'),
						"id" => SN."_notfound_title",
						"type" => "text",
						"std" => ""
						);		

					
$ioa_options[]   =	array( 
						"name" => __("404 image URL",'ioa'),
						"desc" => __("Upload your 404 image.  ",'ioa'),
						"id" => SN."_notfound_logo",
						"type" => "upload",
						"std" => URL."/sprites/i/notfound.png",
						"button" => "Add" , "label" => "Add Image" ,"title" => "Add"
					);	
				
	
$ioa_options[]   =	array( 
						"name" => __("404 page text here",'ioa'),
						"desc" => __("Add your 404 text here.",'ioa'),
						"id" => SN."_notfound_text",
						"type" => "textarea",
						"std" => ""
						);		
                
$ioa_options[]   =	array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */



/* == Sub Panel Ends ===================================================================== */
	
$ioa_options[]   =  array(
						"name" => __("Under Construction",'ioa') , 
						"type"=>"subtitle" , 
						"id"=>"ucm"
						);	
$ioa_options[]   =	array( 
						"name" => __("Title here",'ioa'),
						"desc" => __("Add your title text here.",'ioa'),
						"id" => SN."_uc_title",
						"type" => "text",
						"std" => ""
						);		
		
$ioa_options[]   = array(
                  "name"=> __("Set Radial Bar Color",'ioa'),
			      "desc"=> __("Set the Radial Bar color here",'ioa'),
			      "id" => SN."_uc_barcolor",
				  "type"=>"colorpicker",
				  "alpha" => false ,
				  "value"=>"#444444", 
					 );


$ioa_options[]   =  array( 
				  "name" => __("Under Construction Mode",'ioa'),
				  "desc" => __("If yes, it will show a under construction page to the non-logged in users.",'ioa'),
				  "id" => SN."_uc_mode",
				  "type" => "toggle",
				  "std" => "false"
					);	

$ioa_options[]   =	array( 
						"name" => __("Background Image",'ioa'),
						"desc" => __("Set the background image for under constuction area here",'ioa'),
						"id" => SN."_uc_bg",
						"type" => "upload",
						"std" => "",
						"button" => "Add" , "label" => "Add Background Image" ,"title" => "Add Background Image"
					);	

$ioa_options[]   =  array( 
				  "name" => __("Animate Background",'ioa'),
				  "desc" => __('Animate the background of under construction area','ioa'),
				  "id" => SN."_uc_bg_animate",
				  "type" => "toggle",
				  "std" => "true"
					);	

$ioa_options[]   =	array( 
						"name" => __("Under Construction Page Content",'ioa'),
						"desc" => __("Add your message here.",'ioa'),
						"id" => SN."_uc_text",
						"type" => "textarea",
						"std" => ""
						);		



$ioa_options[]   = array(
                  "name"=> __("Set Progress",'ioa'),
			      "desc"=> __("You can update the % of work done here.",'ioa'),
			      "id" => SN."_uc_progress",
				  "type"=>"slider",
				  "max"=>100,
				  "std"=>60,
				  "suffix"=>"%"
					 );
                
$ioa_options[]   =	array("type"=>"close_subtitle");
/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Advanced Panel Ends =============================================================== */
/* ====================================================================================== */



/* ====================================================================================== */
/* == Personalize ========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Personalize",'ioa'),
	  	           "type" => "section" 
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" ,"tabs" => array(__("General",'ioa')) );


		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("General",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 


$ioa_options[]   = 	array( 
						"name" => __("Show Company Branding",'ioa'),
						"desc" => __("If yes, below uploaded logo and tagline will appear in the Theme Admin",'ioa'),
						"id" => SN."_cbrand_toggle",
						"type" => "toggle",
						"std" => "false"
					  );	

$ioa_options[]   =	array( 
						"name" => __("Set Company Logo",'ioa'),
						"id" => SN."_cbrand_logo",
						"type" => "upload",
						"std" => URL."/sprites/i/logo.png",
						"desc" => __("Add your company logo here",'ioa'),
						"button" => "Add Logo" , "title" => "Add"
						);	

$ioa_options[]   =	array( 
						"name" => __("Set Text",'ioa'),
						"desc" => __("A tagline appear below the Company logo in Theme Admin",'ioa'),
						"id" => SN."_cbrand_text",
						"type" => "text",
						"std" => " Theme Admin "
						);	

$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Personalize Panel Ends =============================================================== */
/* ====================================================================================== */


add_action( 'after_setup_theme', 'IOaaddContactforms' );
function IOaaddContactforms()
{
global $ioa_options;	
/* ====================================================================================== */
/* == Contact =========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("Contact",'ioa'), "icon" => "mail",
	  	           "type" => "section"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open", "tabs" => array(__("Sticky Contact",'ioa')));


/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Sticky Contact",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"cnt"
					 );



$ioa_options[]   =  array( 
				  "name" => __("Show/Hide Sticky Contact",'ioa'),
				  "desc" => __("Show or hide sticky contact area in front end",'ioa'),
				  "id" => SN."_sc_enable",
				  "type" => "toggle",
				  "std" => "false"
					);	
											 

$ioa_options[]   =	array( 
						"name" => __("Enter Text for top area of contact form ",'ioa'),
						"desc" => __("Enter the text that will appear on top of contact form",'ioa'),
						"id" => SN."_sc_message",
						"type" => "textarea",
						"std" => " We usually reply with 24 hours except for weekends. All emails are kept confidential and we do not spam in any ways. "
						);	
										
$forms = get_posts('posts_per_page=-1&post_type=wpcf7_contact_form');

$cf = array("none"=>"None");

foreach ($forms as $key => $form) {
	$cf[$form->ID] = get_the_title($form->ID);
}

$ioa_options[]   = array( 
				  "name" => __("Select Contact Form",'ioa'),
				  "desc" => __("Sticky Contact form uses Contact Form 7 plugin, if it is enabled the available contact forms will appear here.",'ioa'),
				  "id" => SN."_c_form",
				  "type" => "select",
				  "options" =>$cf,
				  "std" => "none"
				 );

$ioa_options[]   = array("type"=>"close_subtitle");

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Contact Panel Ends ================================================================ */
/* ====================================================================================== */

}


/* ====================================================================================== */
/* == Forums Panel ====================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("BBPress",'ioa'),
	  	           "type" => "section" , "icon" => "text-doc"
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" , "tabs" => array(   __("Sidebars",'ioa')  ));

	

/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("Sidebars",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 

$ioa_options[]   = array( 
				  "name" => __("BBPress Forums Sidebar",'ioa'),
				  "desc" => __("Select Sidebar for forums page",'ioa'),
				  "id" => SN."_bbpress_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Default Sidebar"
				 );



$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */


$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Forums Ends ================================================================= */
/* ====================================================================================== */

/* ====================================================================================== */
/* == Woo Commerce ========================================================================== */
/* ====================================================================================== */

$ioa_options[]   = array( 
		           "name" => __("WOO Commerce",'ioa'),
	  	           "type" => "section" 
		          );
$ioa_options[]   = array( 
			      
			      "type" => "information"
		           );
		  				  
$ioa_options[]   = array( "type" => "open" ,"tabs" => array(__("General",'ioa')) );


		  
/* == Sub Panel Begins =================================================================== */

$ioa_options[]   = array(
				   "name" => __("General",'ioa') , 
				   "type"=>"subtitle" , 
				   "id"=>"adv"
					 );
					 

$ioa_options[]   = array( 
				  "name" => __("Product Category Sidebar",'ioa'),
				  "desc" => __("Select Sidebar for product category page",'ioa'),
				  "id" => SN."_woo_category_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );

$ioa_options[]   = array( 
				  "name" => __("Product Tag Sidebar",'ioa'),
				  "desc" => __("Select Sidebar for product tag page",'ioa'),
				  "id" => SN."_woo_tag_sidebar",
				  "type" => "select",
				  "options" =>$osidebars,
				  "std" => "Blog Sidebar"
				 );


$ioa_options[]   = 	array( 
						"name" => __("Show/Hide Live Filter in Templates",'ioa'),
						"desc" => __("Show or hide live filter in shop templates where applicable",'ioa'),
						"id" => SN."_product_filter",
						"type" => "toggle",
						"std" => "true"
					  );	


$ioa_options[]   = array("type"=>"close_subtitle");

/* == Sub Panel Ends ===================================================================== */

$ioa_options[]   = array("type"=>"close");

/* ====================================================================================== */
/* == Personalize Panel Ends =============================================================== */
/* ====================================================================================== */

