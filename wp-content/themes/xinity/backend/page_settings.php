<?php 
/**
 * Stores Inputs & Settings for Pages / Single 
 */

if(!is_admin()) return;

add_action( 'after_setup_theme', 'setPageData' );


function setPageData(){

global $ioa_google_webfonts,$ioa_page_config,$ioa_sidebars,$ioa_super_options,$ioa_registered_posts,$ioa_portfolio_slug,$post;



$inputs = array(
					
					array( 
							"label" => __("Enter Address",'ioa') , 
							"name" => "address" , 
							"default" => "" , 
							"type" => "textarea",
							"value" => ""   
					) 	
						

			);		

$ioa_page_config['title_settings'] = array(
			'scope' => 'all',	
			'inputs' => array(

					'General Settings' => array(

							array('name' => 'show_title' , 'label' => __('Show Title Area','ioa') , 'type' => 'select' , 'default' => 'yes' , "options" => array("yes" => __("Yes",'ioa') ,"no" => __("No",'ioa')  ) ),
							array( "name" => "title_icon" ,  "label" => __("Set Icon for Title",'ioa') , "default" => "" , "type" => "text",'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>' , 'clear_switch' => true , "class" => "has-input-button" ), 
						    array( 
									"label" => __("Select Title Alignment",'ioa') , 
									"name" => "title_align" , 
									"default" => "left" , 
									"type" => "select",
									"options" => array("left" => __("Left",'ioa') ,"right" => __("Right",'ioa') , "center" => __("Center",'ioa')  )  
							) ,
							array( 
									"label" => __("Select Title Vertical Spacing",'ioa') , 
									"name" => "title_vspace" , 
									"default" => "" , 
									"type" => "slider",
									"max" => "100",
									"suffix" => "px"
							),
							array( 
									"label" => __("Select Title Font Size",'ioa') , 
									"name" => "title_font_size" , 
									"default" => "" , 
									"type" => "slider",
									"max" => "160",
									"suffix" => "px"
							),
							array( 
									"label" => __("Enter Font Weight",'ioa') , 
									"name" => "title_font_weight" , 
									"default" => "" , 
									"type" => "slider",
									"max" => "900",
									"steps" => 100,
									'suffix' => ''
							),
							array( 
									"label" => __("Title Effect",'ioa') , 
									"name" => "title_effect" , 
									"default" => "none" , 
									"type" => "select",
									"options" => array("none" => __("None",'ioa'),"fade"=> __("Fade",'ioa') ,"fade-left" => __("Fade From Left",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"fade-right" => __("Fade From Right",'ioa'),"rotate-right" => __("Rotate from Right",'ioa'),"rotate-left" => __("Rotate from Left",'ioa'),"scale-in" => __("Scale In",'ioa'),"scale-out" => __("Scale Out",'ioa'))
												 
							),
							 	

						) , // End of General Settings
					
					'Title Visual Stylings' => array(

						array( 
									"label" => __("Select Title Color",'ioa') , 
									"name" => "ioa_custom_title_color" , 
									"default" => "" , 
									"type" => "colorpicker",
							) ,
						array( 
									"label" => __("Select Title Background Color",'ioa') , 
									"name" => "ioa_custom_title_bgcolor" , 
									"type" => "colorpicker",
									"default" => ""
							) ,	 
						array( 
									"label" => __("Set Title Background Opacity",'ioa') , 
									"name" => "ioa_custom_title_bgcolor-opacity" , 
									"default" => "0" , 
									"type" => "slider",
									"max" => "100",
									"suffix" => '%'
							) ,


						), // End of Title Stylings
					
					'Background Stylings' =>array(

						  array( 'name' => 'ioa_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => 'default' , 'options' =>  array('default'=>'Theme\'s Default','bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gradient'=>'Background Gradient','bg-video'=>'Background Video') ), 

						array( 
									"label" => __("Select Background Color for title area",'ioa') , 
									"name" => "ioa_titlearea_bgcolor" , 
									"default" => "" , 
									"type" => "colorpicker",
									"class" => "ioa-title-filter bg-color"
							) , 
						array( 
									"label" => __("Add Background Image for Title Area",'ioa') , 
									"name" => "ioa_titlearea_bgimage" , 
									"default" => "" , 
									"type" => "upload",
									"title" => __("Use as Background Image",'ioa'),
				  					"std" => "",
				  					"class" => "ioa-title-filter bg-image bg-texture",
				 					"button" => __("Add Image",'ioa'),
				 					) ,
						array( 
									"label" => __("Enable Full Background Stretch",'ioa') , 
									"name" => "ioa_background_cover" , 
									"default" => "" , 
									"type" => "select",
									"options" => array("", "auto","contain","cover"),
									"class" => "ioa-title-filter bg-image"
							) , 
						
							
						array( 
									"label" => __("Background Position for Title Area Image",'ioa') , 
									"name" => "ioa_titlearea_bgposition" , 
									"default" => "" , 
									"type" => "select",
									"class" => "ioa-title-filter bg-texture bg-image",
  								    "options" => array("", "top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right")
							) ,
						array( 
									"label" => __("Custom Background Position( 0 unit 0 unit format )",'ioa') , 
									"name" => "ioa_titlearea_bgpositionc" , 
									"default" => "" , 
									"type" => "text",
									"class" => "ioa-title-filter bg-texture bg-image"
							) ,
						array( 
									"label" => __("Background Repeat for Title Area Texture",'ioa') , 
									"name" => "ioa_titlearea_bgrepeat" , 
									"default" => "" , 
									"type" => "select",
  								 	"options" => array("","repeat","repeat-x","repeat-y","no-repeat"),
  								 	"class" => "ioa-title-filter bg-texture"
							) ,
						
						array( 
									"label" => __("Background Video",'ioa') , 
									"name" => "titlearea_video" , 
									"default" => "" , 
									"type" => "video",
									"class" => "ioa-title-filter bg-video has-input-button"
							) ,
						array( 
									"label" => __("Use Background Gradient",'ioa') , 
									"name" => "titlearea_gradient_dir" , 
									"default" => "no" , 
									"type" => "select",
									"options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left(Not Supported IE8-9)",'ioa'),"diagonalbr" => __("Diagonal Bottom Right(Not Supported IE8-9)",'ioa') ),
									"class" => "ioa-title-filter bg-gradient"
							) ,

						array( 
									"label" => __("Select Start Background Color for title area",'ioa') , 
									"name" => "ioa_titlearea_grstart" , 
									"default" => "" , 
									"type" => "colorpicker",
									"class" => "ioa-title-filter bg-gradient"
							) ,
						array( 
									"label" => __("Select Start Background Color for title area",'ioa') , 
									"name" => "ioa_titlearea_grend" , 
									"default" => "" , 
									"type" => "colorpicker",
									"class" => "ioa-title-filter bg-gradient"
							) ,

						array( 'name' => 'video_pos', 'type' => 'select' , 'label' => 'Video Position' , 'default' => 'middle-pos', 'class' => 'ioa-title-filter bg-video' , "options" => array("middle-pos" => "Centered" , "top-pos" => "Top" ,"bottom-pos" => "Bottom" ) ),

						array( 'name' => 'video_fallback', 'type' => 'upload' , 'label' => 'Fallback Image(for older browsers & less than IE 10 and mobiles)' , 'default' => '', 'class' => 'ioa-title-filter bg-video '),


					), // Background Stylings

					

				)

	);

$schemes = array("none");
$in_schemes = array();
if(get_option(SN.'_pre_schemes'))
	 $in_schemes = get_option(SN.'_pre_schemes');
	
foreach ($in_schemes as $key => $scheme) $schemes[] = $key;

$header_templates = array("none");

$templates  = get_option(SN.'_header_templates');
if(!$templates) $templates = array();

$header_templates = array("none" => "none");

if(is_array($templates))
foreach ($templates as $key => $value) {
	$header_templates[$key] = $value['title'];
}

$ioa_page_config['page_settings'] = array(
			'scope' => 'all',	
			'inputs' => array(


					'Layout Settings' => array(

							array( 
									"label" => __("Select Page Layout",'ioa') , 
									"name" => "page_layout" , 
									"default" => "" , 
									"type" => "select",
									"options" => array( 'full' =>"Full" , 'right-sidebar' => "Right Sidebar" , 'left-sidebar' => "Left Sidebar" )
							),
							array( 
									"label" => __("Select Sidebar",'ioa') , 
									"name" => "page_sidebar" , 
									"default" => "Blog Sidebar" , 
									"type" => "select",
									"options" => $ioa_sidebars
												 
							),
							array( 
									"label" => __("Output Content From",'ioa') , 
									"name" => "builder_placement" , 
									"default" => 'auto' , 
									"type" => "select",
									"options" => array("auto"=>"Auto Detect","builder"=>"Page Builder","editor" => "WP Editor Content")
												 
							),
							array( 
									"label" => "" , 
									"name" => "ioa_template_mode" , 
									"default" => 'wp-editor' , 
									"type" => "hidden",
												 
							)

						


						) , // End of Page Settings

					'Advance Parameters' => array(

							array( 
									"label" => __("Select Color Scheme for the Page",'ioa') , 
									"name" => "page_scheme" , 
									"default" => "none" , 
									"type" => "select",
									"options" => $schemes
							),

							array( 
									"label" => __("Select Header Layout for the Page",'ioa') , 
									"name" => "page_head_layout" , 
									"default" => "none" , 
									"type" => "select",
									"options" => $header_templates
							),

							array( 
									"label" => __("Hide Head Area",'ioa') , 
									"name" => "page_head_area_toggle" , 
									"default" => "no" , 
									"type" => "select",
									"options" => array("no" => "No" , "yes" => "Yes")
							),

							array( 
									"label" => __("Hide Breadcrumb Area",'ioa') , 
									"name" => "page_breadcrumb_toggle" , 
									"default" => "no" , 
									"type" => "select",
									"options" => array("no" => "No" , "yes" => "Yes")
							),

							array( 
									"label" => __("Hide Footer Widget Area",'ioa') , 
									"name" => "page_footer_area_toggle" , 
									"default" => "no" , 
									"type" => "select",
									"options" => array("no" => "No" , "yes" => "Yes")
							),

							array( 
									"label" => __("Hide Bottom Footer Area",'ioa') , 
									"name" => "page_footer_b_area_toggle" , 
									"default" => "no" , 
									"type" => "select",
									"options" => array("no" => "No" , "yes" => "Yes")
							),



						)  // End of Advance Settings

					

				)

	);


$featured_options =  array(
							"none" => __("None",'ioa') , 
							"image" => __("Featured Image",'ioa') , 
							"proportional" => __("Proportional Resized Featured Image",'ioa'),
							//"none-full" => __("Top Featured Image(No Resizing)",'ioa') , 
							//"none-contained" => __("Contained Featured Image(No Resizing)",'ioa'), 
							"image-full" =>__("Full Width Featured Image" ,'ioa'), 
							"image-parallex" =>__("Full Width Parallex Featured Image",'ioa'),
							"video" => __("Video",'ioa'),
							"slideshow" => __("Slideshow",'ioa'), 
							//"slideshow-contained" => __("Full Contained Slideshow",'ioa'),
							"slideshow-fullscreen" => __("Fullscreen Slideshow",'ioa'),
							"slider" => __("Slider",'ioa'),
							//"slider-contained" => __("Full Contained Slider",'ioa'),
							"slider-full" => __("Full Width Slider",'ioa'),  
							"slider-manager" => __("Select From Slider Manager",'ioa') 
							);

if(function_exists('rev_slider_shortcode'))
	{ 
		 $featured_options["rev_slider"] = "Revolution Slider"; 	
	}


if(function_exists('lsSliders'))
	{ 
		 $featured_options["layered_slider"] = "Layered Slider"; 	
	}


$featured_d = "image";




$sliders = get_posts('post_type=slider&posts_per_page=-1');
$ts = array(""=>"None");
foreach ($sliders as $post) {
   $ts[$post->ID] = get_the_title($post->ID) ;
}

$ioa_page_config['featured_media'] = array(
			'scope' => 'all',	
			'inputs' => array(


					'Media' => array(

							array( 
									"label" => __("Select Featured Media Type",'ioa') , 
									"name" => "featured_media_type" , 
									"default" => $featured_d , 
									"type" => "select",
									"options" => $featured_options
												 
							),

							array( 
									"label" => __("Select Slider from Slider Manager",'ioa') , 
									"name" => "featured_media_slidermanager" , 
									"default" => "" , 
									"type" => "select",
									"class" => "ioa-media-filterable slider-manager" ,
									"options" => $ts
												 
							),
							

							array( 
									"label" => __("Enter Featured Video Link",'ioa') , 
									"name" => "featured_video" , 
									"default" => "" , 
									"type" => "text",
									"class" => "ioa-media-filterable video" 
							),
							
							array(
				                  "label"=> __("Featured Media Height",'ioa'),
								   "name" => "featured_media_height",
								   "type"=>"slider",
								   "class" => "ioa-media-filterable product_gallery image image-full image-parallex video slideshow slideshow-contained slider slider-contained slider-full zoomable", 
								   "max"=>800,
								   "default"=> 450, 
								   "suffix"=>" px"

							),
							array( 
									"label" => __("Enable Adaptive Height",'ioa') , 
									"name" => "adaptive_height" , 
									"default" => "false", 
									"class" => "ioa-media-filterable image  image-full   slideshow slideshow-contained slider slider-contained slider-full",
									"type" => "toggle",
							),
								array( 
									"label" => "" , 
									"name" => "ioa_gallery_data" , 
									"default" => "", 
									"class" => "",
									"type" => "hidden",
							)

						


						) , // End of Page Settings

					

				)

	);



	if(function_exists('rev_slider_shortcode'))
	{
		global $wpdb;
		 $table_db_name = GlobalsRevSlider::$table_sliders;
		 $lsliders = $wpdb->get_results("SELECT * FROM $table_db_name",ARRAY_A);

		 $slds = array();
		 foreach ($lsliders as $slider) {
		 	$slds[$slider['alias']] = $slider['title'];
		 }

		$ioa_page_config['featured_media']['inputs']['Media'][] = array( 
					"label" => __("Select Revolution Layered Slider for Featured Media",'ioa') , 
					"name" => "layered_media_type" , 
					"default" => "none" , 
					"type" => "select",
					"options" => $slds,
					"class" => "ioa-media-filterable rev_slider"
								 
			 );

	}
	
	if(function_exists('lsSliders'))
	{
		$layered_slds = array();
		$lsl = lsSliders();
		foreach ($lsl as $slider) {
		 	$layered_slds[$slider['id']] = $slider['name'];
		 }
		$ioa_page_config['featured_media']['inputs']['Media'][] = array( 
					"label" => __("Select Layered Slider for Featured Media",'ioa') , 
					"name" => "klayered_media_type" , 
					"default" => "none" , 
					"type" => "select",
					"options" => $layered_slds,
					"class" => "ioa-media-filterable layered_slider"
								 
			 );

	}

$cps = array();
$custom_query = get_posts( array( "post_type" => "custompost" , "posts_per_page" => -1 ,  
			'cache_results' => false , 
			'no_found_rows' => true,
    		'update_post_term_cache' => false,
    		'update_post_meta_cache' => false,
    		'post_status' => 'publish'
			));  
	
		foreach( $custom_query as $post ) :  
			
			$post_type = str_replace(" ","_",strtolower(trim(get_the_Title($post->ID))));
			$cps[$post_type] = get_the_Title($post->ID);		
			
		endforeach;

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


$ioa_page_config['custom_post_settings'] = array(
			'scope' => 'all',	
			'inputs' => array(


					'Portfolio Template Settings' => array(
							
							array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "portfolio_query_filter" , 
									"default" => "" , 
									"type" => "text",
									"class" => "has-input-button",
									'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							),

							array( 
									"label" => __("Portfolio Columns Layout",'ioa') , 
									"name" => "portfolio_cols" , 
									"default" => "default" , 
									"type" => "select",
									"options" => array( "default" => __("Default",'ioa') , "text" => __("Column with Text",'ioa') , "grid" => "Compact Grid"  )
												 
							),


							array( 
									"label" => __("Portfolio Images Resizing",'ioa') , 
									"name" => "portfolio_image_resize" , 
									"default" => "default" , 
									"type" => "select",
									"options" => array( "default" => __("Full Width",'ioa'), "proportional" => __("Proportional",'ioa') , "none" => __("None",'ioa')  )
									, "class" => "pt-filter" 
												 
							),
							
							array( 
									"label" => __("Override Settings of Admin Panel > Portfolio Settings ",'ioa') , 
									"name" => "portfolio_override" , 
									"default" => "false", 
									"type" => "select",
									"options" => array("true" => "Yes" , "false" => "No")
							),

							array( 
									"label" => __("Enable lightbox icon on hover (if false link icon will show)",'ioa') , 
									"name" => "_portfolio_enable_thumbnail" , 
									"default" => '', 
									"type" => "toggle", "class" => "pt-filter"
							),
							array( 
									"label" => __("Use wordpress default excerpt",'ioa') , 
									"name" => "_portfolio_excerpt" , 
									"default" => '', 
									"type" => "toggle","class" => "pt-filter"
							),
							array( 
									"label" => __("More Button Label",'ioa') , 
									"name" => "_portfolio_more_label" , 
									"default" => '' , 
									"type" => "text","class" => "pt-filter"
							),
							array(
				                  "label"=> __("Portfolio Items Limit",'ioa'),
								   "name" => "_portfolio_item_limit",
								   "type"=>"slider",
								   "max"=>50,
								   "default"=>6,
								   "suffix"=>"Items" ,"class" => "pt-filter"),
							array(
				                  "label"=> __("Portfolio Content Limit",'ioa'),
								   "name" => "_portfolio_excerpt_limit",
								   "type"=>"slider",
								   "max"=>800,
								   "default"=>'', 
								   "suffix"=>" Letters","class" => "pt-filter" ),

							array(
				                  "label"=> __("Portfolio Thumbnails Height",'ioa'),
								   "name" => "_p_height",
								   "type"=>"slider",
								   "max"=>900,
								   "default"=>350,"class" => "pt-filter",
								   "suffix"=>"px", "after_input" => "<input type='hidden' class='post_type' name='post_type' value='".$ioa_portfolio_slug."' />" ),
							
							

						) , // End of Portfolio Settings

					'Blog Template Settings' => array(	
						
						array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "query_filter" , 
									"default" => "" , 
									"type" => "text",
									"class" => "has-input-button",
									'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							),
						array( 
									"label" => __("Override Settings of Admin Panel > Blog Settings ",'ioa') , 
									"name" => "blog_override" , 
									"default" => "false", 
									"options" => array("true" => "Yes" , "false" => "No"),
									"type" => "select",
							),

						

				 		array( 
									"label" => __("Use Wordpress Excerpt",'ioa'),
									"name" => "_blog_excerpt",
									"type" => "toggle",
									"default" => "true", "class" => "bt-filter"
							),

					   array(
									"label"=>__("Custom Excerpt text Limit",'ioa'),
									"name" => "_posts_excerpt_limit",
									"type"=>"slider",
									"max"=>500,
									"default"=>300,
									"suffix"=>"letters", "class" => "bt-filter"
							),

				   		array( 
									"label" => __("Use Lightbox on posts thumbnail",'ioa'),
									"name" => "_enable_thumbnail",
									"type" => "toggle",
									"default" => "true", "class" => "bt-filter"
								  ),

					  	array( 
									"label" => __("Continue Button Label",'ioa'),
									"name" => "_more_label",
									"type" => "text",
									"default" => "more", "class" => "bt-filter"
								  ),

					  	array(
				                  "label"=>__("Blog Posts Items Limit",'ioa'),
								   "name" => "_posts_item_limit",
								   "type"=>"slider",
								   "max"=>50,
								   "default"=>6,
								   "suffix"=>"Items", "class" => "bt-filter"
								   ),

					   	array( 
								"label" => __("Show/Hide Posts extra information",'ioa'),
								"name" => "_blog_meta_enable",
								"type" => "toggle",
								"default" => "true", "class" => "bt-filter"
							  ),

					  	array( 
							"label" => __("Post Metabar ( Extra information that appears below title)",'ioa'),
							"name" => "_blog_meta",
							"type" => "textarea",
							"default" => "By [post_author_posts_link] On [post_date] &middot; [post_comments] &middot; In [post_categories] ",
							"after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", 
							"buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>", "class" => "bt-filter"
						  ),

					  	array(
		                  "label"=>__("Blog Posts Media Height",'ioa'),
						   "name" => "_bt_height",
						   "type"=>"slider",
						   "max"=>800,
						   "default"=>360,
						   "suffix"=>"px",
						   "after_input" => "<input type='hidden' class='post_type' name='post_type' value='post' />", "class" => "bt-filter"
						   ),


										), // End of Blog Settings
					

									  
					
					"Custom Posts Template Settings" => array(

						array( 
									"label" => __("Select Post Type",'ioa') , 
									"name" => "custom_post_type" , 
									"default" => '' , 
									"type" => "select",
									"options" => $cps
							
							),
						array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "custom_query_filter" , 
									"default" => "" , 
									"type" => "text",
									"class" => "has-input-button",
									'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							),
						array( 
									"label" => __("Enable lightbox icon on hover (if false link icon will show)",'ioa') , 
									"name" => "custom_enable_thumbnail" , 
									"default" =>'', 
									"type" => "toggle",
							),
						array(
				                  "label"=> __("Custom Posts Items Limit",'ioa'),
								   "name" => "custom_posts_item_limit",
								   "type"=>"slider",
								   "max"=>50,
								   "default"=>6,
								   "suffix"=>"Items" ),


						),// End of Custom Posts


					"Contact Page Template Settings" => array(

						array( 'inputs' => $inputs, 'label' => __('Addresses','ioa'), 	'name' => 'rad_addresses','type'=>'module','unit' => __(' Address','ioa') ),

					array( 
						"label" => __("Enter Address for Contact Template Address Area(html supported)",'ioa'),
						"name" =>"prop_address",
						"type" => "textarea",
						"default" => ""
						),													
					array(
                  "label"=> __("Set Zoom Level",'ioa'),
			      "name" =>"map_zoom",
				  "type"=>"slider",
				  "max"=>16,
				  "default"=>8,
				  "suffix"=>""
					 ),
 					array(
                  "label"=> __("Set Map Hue",'ioa'),
			      "name" =>"map_color",
				  "type"=>"colorpicker",
				  "alpha" => false ,
				  "value"=>"", 
				  "default" => ""
					 ),

 					array( 
						"label" => __("Add Map Marker",'ioa'),
						"name" =>"map_marker",
						"type" => "upload",
						"default" => URL."/sprites/i/map-pin.png"
						),	



						), // End of Custom Posts

				'Product Template Settings' => array(
							
							array( 
									"label" => __("Generate Filters",'ioa') , 
									"name" => "product_query_filter" , 
									"default" => "" , 
									"type" => "text",
									"class" => "has-input-button",
									'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>'
							),

							array( 
									"label" => __("Product Images Resizing",'ioa') , 
									"name" => "product_image_resize" , 
									"default" => "default" , 
									"type" => "select",
									"options" => array( "default" => __("Full Width",'ioa'), "proportional" => __("Proportional",'ioa') , "none" => __("None",'ioa')  )
												 
							),
							
							array(
				                  "label"=> __("Product Items Limit",'ioa'),
								   "name" => "_product_item_limit",
								   "type"=>"slider",
								   "max"=>50,
								   "default"=>6,
								   "suffix"=>"Items"),
							
							array(
				                  "label"=> __("Product Thumbnails Height",'ioa'),
								   "name" => "_pr_height",
								   "type"=>"slider",
								   "max"=>900,
								   "default"=>350,
								   "suffix"=>"px", "after_input" => "<input type='hidden' class='post_type' name='post_type' value='product' />" ),
							
							

						) , // End of Product Settings		

				)

	);

}
 ?>
