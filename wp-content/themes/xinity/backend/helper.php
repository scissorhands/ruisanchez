<?php
/**
 * @description : Helper class for Framework
 * @version : Version 6
 */


if(!defined('HPATH'))
die(' The File cannot be accessed directly ');


if(!class_exists('IOA_Helper')) {

/**
 * Class Begins here
 */


class IOA_Helper
{

	public function preIOACacheSettings()
	{
		global $wpdb,$ioa_super_options,$ioa_options;


		/**
		 * Cache all Theme options & if a option is not set map from default options.
		 */

		$special_options = array(
				
				);
		$resultSet =  $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options where option_name like '%".SN."%' ",ARRAY_A);
		
		$i =0;
		$data = array();


		
		/**
		 *  Map options from database
		 * 
		 * */
		foreach($resultSet as $rs)
			$data[$rs['option_name']] = apply_filters("option_".$rs['option_name'] , $rs['option_value'] );
		

		foreach($ioa_options as $k => $value)
		{
			
		  if( isset($value["id"])  ) 	
		  {
			  
			  $id = $value["id"];
			  $std = false;
			  
			
			  if( isset( $value["std"]) ) $std = $value["std"]; 
			  $ioa_super_options[$id] = $std ;
		  }
			
			
		}

		foreach($special_options as $k => $value)
		{
			
		  if( isset($value["id"])  ) 	
		  {
			  
			  $id = $value["id"];
			  $std = false;
			  
			
			  if( isset( $value["std"]) ) $std = $value["std"]; 
			  $ioa_super_options[$id] = $std ;
		  }
			
			
		}	
	}

	/**
	 * Initiates all frameworks core actions and  settings.
	 */
	function __construct() {

		global $wpdb,$ioa_super_options,$ioa_options;


		/**
		 * Cache all Theme options & if a option is not set map from default options.
		 */

		$special_options = array(
				
				);
		$resultSet =  $wpdb->get_results("SELECT option_name,option_value FROM $wpdb->options where option_name like '%".SN."%' ",ARRAY_A);
		
		$i =0;
		$data = array();


		
		foreach($resultSet as $rs)
			$data[$rs['option_name']] = $rs['option_value'];
		

		foreach($ioa_options as $k => $value)
		{
			
		  if( isset($value["id"])  ) 	
		  {
			  
			  $id = $value["id"];
			  $std = false;
			  
			
			  if( isset( $value["std"]) ) $std = $value["std"]; 
			  $ioa_super_options[$id] = $std ;
		  }
			
			
		}

		foreach($special_options as $k => $value)
		{
			
		  if( isset($value["id"])  ) 	
		  {
			  
			  $id = $value["id"];
			  $std = false;
			  
			
			  if( isset( $value["std"]) ) $std = $value["std"]; 
			  $ioa_super_options[$id] = $std ;
		  }
			
			
		}

		if(is_admin()) :

		add_action( 'admin_bar_menu', 'wp_admin_ioa_links', 1000 );


		function zipmimesupport( $post_mime_types ) {

		$post_mime_types['application/zip'] = array( __( 'Fonts' ,'ioa'), __( 'Manage Fonts','ioa' ), _n_noop( 'Font <span class="count">(%s)</span>', 'Fonts <span class="count">(%s)</span>' ) );

		return $post_mime_types;

		}

		// Add Filter Hook
		add_filter( 'post_mime_types', 'zipmimesupport' );	
		
		function radexport_session()
		{
  		  
  		  if(isset($_GET['rad_export']))
  		  {

				$data = get_transient('TEMP_RAD_TEMPLATE');

				$name = get_transient('TEMP_RAD_TEMPLATE_TITLE');

				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($name.'.txt'));
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');

				
				$output = base64_encode($data);
				echo $output;

				die();	
  		  }
		  
		}

		if(is_admin())
		add_action('init', 'radexport_session', 1);


		function wp_admin_ioa_links()
		{
			global $wp_admin_bar,$wpdb;
			
			
	

			$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=ioa",
								'parent' => false, // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "theme_admin", // defaults to a sanitized title value.
								'title' => 'Theme Admin',
								'meta' => array('title' => 'Theme Admin') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));	

				$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=hcons",
								'parent' => "theme_admin", // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#hcons", // defaults to a sanitized title value.
								'title' => 'Header Constructor',
								'meta' => array('title' => 'Header Constructor') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));	

				$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=ioamed",
								'parent' => "theme_admin", // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#ioamed", // defaults to a sanitized title value.
								'title' => 'Slider Manager',
								'meta' => array('title' => 'Slider Manager') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));

				$wp_admin_bar->add_menu(array(
								'href' =>  admin_url()."admin.php?page=ioapty",
								'parent' => "theme_admin", // false for a root menu, pass the ID value for a submenu of that menu.
								'id' => "#ioapty", // defaults to a sanitized title value.
								'title' => 'Content Manager',
								'meta' => array('title' => 'Content Manager') // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', 'target' => '', 'title' => '' );
							));				

				$wp_admin_bar->add_menu(array(
							'href' =>  "#",
							'parent' => false, // false for a root menu, pass the ID value for a submenu of that menu.
							'id' => "trigger-post-update", // defaults to a sanitized title value.
							'title' => 'Update Post',
							'meta' => array('title' => 'Update Post') 
						));	

		}
		

			function my_custom_login_logo() {
  
				  
				    echo '<style type="text/css">
				        #login h1 a { background:url('.get_option(SN."_admin_logo").') center center no-repeat !important;
						 
						  margin-top:0px;
						   }
				    </style>';

				}

				if(get_option(SN."_enable_admin_logo")=="Yes")
				add_action('login_head', 'my_custom_login_logo');

		endif;	
		
		$ioa_super_options = array_merge($ioa_super_options,$data);


		global $ioa_portfolio_name,$ioa_portfolio_slug,$ioa_portfolio_taxonomy_label,$ioa_portfolio_taxonomy;

		$ioa_portfolio_name = $ioa_super_options[SN.'_portfolio_label'];
		$ioa_portfolio_slug =$ioa_super_options[SN.'_portfolio_slug'];
		$ioa_portfolio_taxonomy_label = $ioa_super_options[SN.'_portfolio_taxonomy'];
		$ioa_portfolio_taxonomy =  str_replace(" ","",strtolower(trim($ioa_portfolio_taxonomy_label))) ;

		global $ioa_sidebars;
		if(isset($ioa_super_options[SN.'_custom_sidebars'])) :
			$sidebar_opts = $ioa_super_options[SN.'_custom_sidebars']; 
			$sidebar_opts = explode(',',$sidebar_opts);
			foreach($sidebar_opts as $s)
			{
				if($s!="")
				{
					$ioa_sidebars[] = $s;
				}
			} 
		endif;	

		if(is_admin())
		{
			$portfolio_fields = $ioa_super_options[SN.'_single_portfolio_meta'];

			if($portfolio_fields!="")
			{
				$portfolio_fields = explode(';',$portfolio_fields);
				$inps = array();
				foreach($portfolio_fields as $field)
				{
					if(trim($field)!="")
					$inps[trim($field)] 	=  array(	"label" => $field , "name" => str_replace(' ','_',strtolower(trim($field))) , 	"default" => "" , "type" => "textarea",	"description" => "" );
				}

				
				new IOAMetaBox(array(
				"id" => "IOA_portfolio_fields",
				"title" => "Portfolio Extra Fields",
				"inputs" => $inps,
				"post_type" => $ioa_portfolio_slug,
				"context" => "advanced",
				"priority" => "low"
				));	
			}
		}
		
	add_action( 'after_setup_theme', array(&$this,'customPosts') );

	add_filter('the_content','rad_appender', 10 );	


	function rad_appender( $content ) {
	
	global $ioa_super_options,$ioa_meta_data,$ioa_portfolio_slug,$post;

	if( isset($ioa_meta_data['rad_trigger']) && $ioa_meta_data['rad_trigger']) :


	$opts = get_post_meta(get_the_ID(),'ioa_options',true);
	$l ='skeleton auto_align'; // Container Classes
	if(isset($opts['page_layout']) && $opts['page_layout']!='full') $l = '  ';  

	$ioa_meta_data['rad_trigger'] = false;


		/**
		 * If Post Type is portfolio, add the meta area.
		 */

		if( get_post_meta( $post->ID, 'rad_version', true ) == "" )	 
		{

			if( $post->post_type == $ioa_portfolio_slug ) :
				ob_start();
				get_template_part( 'templates/single-portfolio-meta'); 
				$content = ob_get_contents(). $content;
				ob_end_clean();
			endif;	

			ob_start();
   			get_template_part('templates/rad/construct'); 
		   	 if($content!="")
				$content =  '<div class="page-content '.$l.' clearfix">'.$content.'</div>';

			$rad_data = ob_get_contents();  
			if(trim($rad_data)!="") 
				$content = $rad_data;   
	    
	   		ob_end_clean();
		}
		else
		{
			if(has_shortcode($post->post_content,'rad_page_section'))
				$content = '<div class="rad-holder  clearfix">'.do_shortcode( $content ).'</div>';
			else	
			{
				if( $post->post_type == $ioa_portfolio_slug ) :
						ob_start();
						get_template_part( 'templates/single-portfolio-meta'); 
						$content = ob_get_contents(). $content;
						ob_end_clean();
				endif;	
				$content =  '<div class="page-content  '.$l.' clearfix">'.$content.'</div>';
	

			}	
		
		}


		endif;	
	
	            return $content;
	}
			
				 
		
		function add_lightbox_code( $mode )
		{
			global $ioa_shortcodes_array,$ioa_layout;
			 

			?>
			<div class="ioa-message">
		        
		          <div class="ioa-message-body clearfix">
		               <div class="ioa-icon-area">
		               		<i class="ioa-front-icon checkicon-"></i>
		               </div>
		               <div class="ioa-info-area">
		               		<h3 class='msg-title'>Settings Saved !</h3>
		               		<p class='msg-text'>Options Panel Settings were saved at 11 PM</p>
		               </div>
		              
		          </div>
		    </div>

			<div class="rad-lightbox">
			<div class="rad-l-head">
				<h4><?php _e('Text Widget[Edit mode]','ioa') ?></h4>
			</div>
			<div class="rad-l-body clearfix">
				<div class="component-opts">
					
				</div>
				
			</div>
			
			<div class="rad-l-footer clearfix">
				<a href="" class="button-save" id="save-l-data" ><?php _e('Save Changes','ioa') ?></a>
				<a href="" class="button-save" id="shortcode-l-data" ><?php _e('Add','ioa') ?></a>

				<a href="" class="button-default" id="close-l" ><?php _e('Close','ioa') ?></a>
			</div>
		</div>

		<div class="temp-overlay"></div>
		<script type="text/javascript">
		 var ioa_layout_config = <?php echo json_encode($ioa_layout); ?>;
		</script>
		<?php
		}	


		function ioatitlelightbox()
		{
			global $ioa_page_config,$post,$ioa_portfolio_slug,$ioa_super_options;
			 

			$ioa_options = get_post_meta( $post->ID, 'ioa_options',true);
			 wp_nonce_field( 'IOA', 'ioa_noncename' );
			?>
			<div class="ioa-title-overlay"></div>
			<div class='ioa-title-lightbox'>
				<div class="ioa-title-lightbox-head">
					<h3>Page Title Settings</h3>

					<a href="" class="ioa-front-icon cancel-3icon-"></a>
				</div>
				
					<div class="ioa-title-lightbox-body">
					<div class="ioa-title-lightbox-tabs">
					
					<ul class='clearfix'>
					<?php 
					foreach ($ioa_page_config['title_settings']['inputs'] as $key => $mods) {
					?>
					<li><a href="#<?php echo str_replace(' ','_',strtolower($key)) ?>"><?php echo $key ?></a></li>
					<?php } ?>	
					</ul>
					<?php 
						foreach ($ioa_page_config['title_settings']['inputs'] as $key => $mods) {
							?> 
							
							<div class="ioa-title-mod-section" id="<?php echo str_replace(' ','_',strtolower($key)) ?>"> 
							<?php
							foreach ($mods as $key => $input) {
								
								$t  = $input['default'];
								if(isset($ioa_options[$input['name']])) $t  = $ioa_options[$input['name']];
								$fn = $input;
								$fn['value'] = $t;

								if( $input['type'] == 'slider' && $t =='' )
								{
									$fn['value'] = '0'; 
								}

								echo getIOAInput($fn);	
							}
							?>
							</div>
							<?php

						}
						?>
					
				</div></div>
				
				</div>


				<div class="ioa-page-overlay"></div>
			<div class='ioa-page-lightbox'>
				<div class="ioa-page-lightbox-head">
					<h3><?php echo ucwords($post->post_type) ?> Settings</h3>

					<a href="" class="ioa-front-icon cancel-3icon-"></a>
				</div>
				
					<div class="ioa-page-lightbox-body">
					<div class="ioa-page-lightbox-tabs">
					
					<ul class='clearfix'>
					<?php 
					foreach ($ioa_page_config['page_settings']['inputs'] as $key => $mods) {

					?>
					<li><a href="#<?php echo str_replace(' ','_',strtolower($key)) ?>"><?php echo $key ?></a></li>
					<?php } ?>	
					</ul>
					<?php 
		 

						
						foreach ($ioa_page_config['page_settings']['inputs'] as $key => $mods) {
							?> 
							
							<div class="ioa-page-mod-section" id="<?php echo str_replace(' ','_',strtolower($key)) ?>"> 
							<?php
							foreach ($mods as $key => $input) {
								
								$t  = $input['default'];
								if(isset($ioa_options[$input['name']])) $t  = $ioa_options[$input['name']];
								$fn = $input;

								if($input['name']=='page_layout')
								{

								   if(!isset($ioa_options[$input['name']]))
								   {

								   		if(isset( $ioa_super_options[SN.'_page_layout']) && $ioa_super_options[SN.'_page_layout']!="" )
											 $t = $ioa_super_options[SN.'_page_layout'];
										else 
											 $t = 'full';

										if($post->post_type=="post")
										{
											if( isset( $ioa_super_options[SN.'_post_layout']) && $ioa_super_options[SN.'_post_layout']!="" )
												$t = $ioa_super_options[SN.'_post_layout'];
											else 
												$t = 'right-sidebar';

										} 
									}
										
								}

								$fn['value'] = $t;

								if( $input['type'] == 'slider' && $t =='' )
								{
									$fn['value'] = '0'; 
								}


								echo getIOAInput($fn);	
							}
							?>
							</div>
							<?php

						}
						?>
					
				</div></div>
				
				</div>	


				<div class="ioa-custom_post-overlay"></div>
			<div class='ioa-custom_post-lightbox'>
				<div class="ioa-custom_post-lightbox-head">
					<h3>Template Settings</h3>

					<a href="" class="ioa-front-icon cancel-3icon-"></a>
				</div>
				
					<div class="ioa-custom_post-lightbox-body">
					<div class="ioa-custom_post-lightbox-tabs">
					
					<ul class='clearfix'>
					<?php 
					foreach ($ioa_page_config['custom_post_settings']['inputs'] as $key => $mods) {
					?>
					<li><a href="#<?php echo str_replace(' ','_',strtolower($key)) ?>"><?php echo $key ?></a></li>
					<?php } ?>	
					</ul>
					<?php 
						foreach ($ioa_page_config['custom_post_settings']['inputs'] as $key => $mods) {
							?> 
							
							<div class="ioa-custom_post-mod-section ioa-query-box" id="<?php echo str_replace(' ','_',strtolower($key)) ?>"> 
							<?php
							foreach ($mods as $key => $input) {
								$t= '';
								if(isset($input['default']))
								$t  = $input['default'];
								if(isset($ioa_options[$input['name']])) $t  = $ioa_options[$input['name']];
								$fn = $input;
								$fn['value'] = $t;

								if( $input['type'] == 'slider' && $t =='' )
								{
									$fn['value'] = '0'; 
								}

								echo getIOAInput($fn);	
							}
							?>
							</div>
							<?php

						}
						?>
					
				</div></div>
				
				</div>

			<?php
		}
		 

		add_action('admin_footer','add_lightbox_code',10,1);

		if( ! ( isset($_GET['page']) && $_GET['page'] == "ioautoup" ) && get_option(SN.'_en_key') )
		add_action('admin_notices', 'checkioaUpdates');

		function checkioaUpdates()
		{
			global $ioa_super_options,$ioa_upgrader;
		    // include the library
		    
			$checker  =  $ioa_upgrader->check_for_theme_update();
		    
			if($checker->updated_themes_count > 0 )
			    {
			    	?>
						<div class="updated">
							<p style="text-align:center"><strong>Theme Update</strong> is available. Click <strong><a href="<?php echo admin_url()."admin.php?page=ioautoup"; ?>">here</a></strong> to update.</p>
						</div>

						
			    	<?php
			    } 
		   
		}


		/**
		 * Version Check for WP 
		 */
		
		function addversionw()
		{
			global $ioa_super_options,$wp_version;
			echo "<link rel='tag' id='wp_version' href='".$wp_version."' />";
			echo "<link rel='tag' id='backend_link' href='". admin_url( 'admin-ajax.php' )."' />";
			echo "<link rel='tag' id='shortcode_link' href='".HURL."' />";

			
		}

		add_action('admin_head','addversionw');		
		
		/**
		 * Custom Exerpt Length
		 */
		
		function custom_excerpt_length( $length ) {
			return 20;
		}
		add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

		/**
		 *  Core WP Declarations 
		 */
		
		function custom_excerpt_more( $more ) {
			return '...';
		}
		add_filter( 'excerpt_more', 'custom_excerpt_more' );

		add_editor_style( 'backend/css/editor-style.css' );
		add_filter('widget_text', 'do_shortcode');
		add_filter( 'use_default_gallery_style', '__return_false' );
		
		add_filter( 'jpg_quality', 'ioa_jpg_q' );
			function ioa_jpg_q() {
			return 100;
			}

		function ioa_mime_types( $mimes ){
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
		add_filter( 'upload_mimes', 'ioa_mime_types' );

		add_filter( 'wp_title', 'setIOAHomeTitle' );
		function setIOAHomeTitle( $title )
		{
		  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
		    return __( 'Home', 'ioa' ) . ' | ' . get_bloginfo( 'description' );
		  }
		  return $title;
		}	

        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'woocommerce' );
		add_theme_support( 'automatic-feed-links' );

		add_filter( 'woocommerce_enqueue_styles', '__return_false' );

		add_filter( 'woocommerce_product_add_to_cart_text', 'ioa_woo_text' );    // 2.1 +
 
		function ioa_woo_text($text) {
		 		global $product;

		 		if( $product->product_type == 'simple')
		        	return __( '+<i class="ioa-front-icon basketicon-"></i>', 'ioa' );
		        else
		        	return $text;
		 
		}

		if(IOA_WOO_EXISTS) :

			add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			add_filter( 'woocommerce_breadcrumb_defaults', 'ioa_change_breadcrumb_home_text' );

			remove_action('woocommerce_after_single_product_summary','woocommerce_output_related_products',20);
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
			remove_action('wp_footer','woocommerce_demo_store',10);

			// Now Add it to Header
			
			add_action('IOA_body_start','woocommerce_demo_store',10);


			function ioa_change_breadcrumb_home_text( $defaults ) {
			    global $ioa_super_options;

				return array(
	            'delimiter'   => $ioa_super_options[SN."_breadcrumb_delimiter"],
	            'wrap_before' => '',
	            'wrap_after'  => '',
	            'before'      => ' <span class="current">',
	            'after'       => '</span> ',
	            'home'        => $ioa_super_options[SN."_breadcrumb_home_label"],
	        	);

				return $defaults;
			}

			add_action( 'init', 'ioa_remove_wc_breadcrumbs' );
			function ioa_remove_wc_breadcrumbs() {
			    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			}

		endif;

		global $ioa_layout;

		if ( ! isset( $content_width ) )
		$content_width = $ioa_layout['content_width'];

		add_theme_support( 'post-formats', array(
		 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
		) );


		add_action('layerslider_ready', 'my_layerslider_overrides');
 
	    function my_layerslider_overrides() {
	        $GLOBALS['lsAutoUpdateBox'] = false;
	    }


		/**
		 * Theme Actions Declaration
		 */
		global $IOA_templates;

		$IOA_templates = array(
					"default" => __('Default Template','ioa'),
					
					"Blog List" => __('Blog List','ioa'),
					"Blog Grid" => __('Blog Grid','ioa'),
					
					"Blog One Column" => __('Blog One Column','ioa'),
					
					"Blog Timeline" => __('Blog Timeline','ioa'),
					"Full Width Blog Masonary" => __('Full Width Blog Masonary','ioa'),

					"Portfolio One Column" => $ioa_portfolio_name.__(' One Column','ioa'),
					"Portfolio Two Column" => $ioa_portfolio_name.__(' Two Column','ioa'),
					"Portfolio Three Column" => $ioa_portfolio_name.__(' Three Column','ioa'),
					"Portfolio Four Column" => $ioa_portfolio_name.__(' Four Column','ioa'),
					"Portfolio Five Column" => $ioa_portfolio_name.__(' Five Column','ioa'),
					"Portfolio List" => $ioa_portfolio_name.__(' List','ioa'),
					"Portfolio Full Screen Gallery" => $ioa_portfolio_name.__(' Full Screen Gallery','ioa'),
					"Portfolio Product Gallery" => $ioa_portfolio_name.__(' Product Gallery','ioa'),
					"Portfolio Modelie" => $ioa_portfolio_name.__(' Modelie','ioa'),
					"Portfolio Masonry" => $ioa_portfolio_name.__(' Masonry','ioa'),
					"Portfolio Maerya" => $ioa_portfolio_name.__(' Maerya','ioa'),

					"Shop Masonry" =>__('Shop Masonry','ioa'),
					"Shop Default" =>__('Shop Default','ioa'),
					"Shop Maerya" =>__('Shop Maerya','ioa'),
					"Shop Gallery" =>__('Shop Gallery','ioa'),
					"Shop Two Columns" =>__('Shop Two Columns','ioa'),
					"Shop Three Columns" =>__('Shop Three Columns','ioa'),
					"Shop Four Columns" =>__('Shop Four Columns','ioa'),
					"Shop Five Columns" =>__('Shop Five Columns','ioa'),

					"Contact Page" => __('Contact Page','ioa'),
					"Contact Full Screen Page" => __('Contact Full Screen Page','ioa'),
					"Blank Page" => __('Blank Page','ioa'),
					"Sitemap" => __('Sitemap','ioa'),
					"Custom Post Template" => __('Custom Post Template','ioa'),

					);

		new IOAMetaBox(array(
			"id" => "IOA_testimonial_box",
			"title" => __("Enter Client Designation",'ioa'),
			"inputs" => array(
										
							 array(	"label" => __("Enter Designation",'ioa') , "name" => "design" , "length" => "small",	"default" => "" , "type" => "text",	"description" => "" ), 
							
							 ),
			"post_type" => "testimonial",
			"context" => "side",
			"priority" => "low"
			));

		new IOAMetaBox(array(
			"id" => "IOA_product_alt_thumb",
			"title" => __("Add 2nd Thumbnail",'ioa'),
			"inputs" => array(
										
							 array(	"label" => __(" Add 2nd Thumbnail to show Hover",'ioa') , "name" => "sec_thumb" , "length" => "small",	"default" => "" , "type" => "upload",	"description" => "" ), 
							
							 ),
			"post_type" => "product",
			"context" => "side",
			"priority" => "low"
			));

		/**
		 * Template Column
		 */
		
		function addioa_template_cols($columns) {
			    return array_merge($columns, 
			              array('ioa_template' => __('Template','ioa') ));
			}
			add_filter('manage_page_posts_columns' , 'addioa_template_cols');

		add_action( 'manage_page_posts_custom_column' , 'custom_columns', 10, 2 );

		function custom_columns( $column, $post_id ) {
		    switch ( $column ) {
				case 'ioa_template' : 

						$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );
						if( isset($ioa_options['ioa_custom_template']) && $ioa_options['ioa_custom_template']!="ioa-template-default" )
						{
							$temp = str_replace('ioa-template-','',$ioa_options['ioa_custom_template']);
							$temp = str_replace('-',' ',$temp );
							 echo "<span class='ioa-highlight'>".ucwords($temp)."</span>";
						}
						else echo 'Default';
				 break;
		    }
		}

		/**
		 * Set RAD Styler Styles
		 */
		
			
		add_action('wp_head', array($this,'RADStyler'));
			

		function add_js_variables()
		{

			$data = get_option(SN.'_enigma_data');
			$current_skin = 'default';
			if(isset($data['skin'])) $current_skin = $data['skin'];
			if(isset($_GET['vskin'])) $current_skin = $_GET['vskin'];
			if(isset($_SESSION['vskin'])) $current_skin = $_SESSION['vskin'];

			if($current_skin=='default') $current_skin = '';
			else $current_skin = '-'.$current_skin;	

			echo "
			<script>
			var ioa_listener_url = '".admin_url( 'admin-ajax.php' )."',
				theme_url  = '".URL."',
				backend_url  = '".HURL."';

			</script>
			";
			?>

			 <!--[if IE 9]>
			      <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie9<?php echo $current_skin; ?>.css" />
			  <![endif]-->  
			  
			  <!--[if IE 8]>
			      <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/sprites/stylesheets/ie8<?php echo $current_skin; ?>.css" />
			  <![endif]--> 

			  <!--[if lt IE 9]>
			<script src="<?php echo URL; ?>/sprites/js/html5shiv.js"></script>
			<![endif]-->
			<?php
		}
		add_action('wp_head','add_js_variables');

		// Comment Support ====================================
		
		if ( ! function_exists( 'ioa_comment' ) ) :

			function ioa_comment( $comment, $args, $depth ) {
				$GLOBALS['comment'] = $comment;
				switch ( $comment->comment_type ) :
					case '' :
				?>
				
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
						<div id="comment-<?php comment_ID(); ?>">
						
							<div class="comment-info  clearfix">
							   
							   <div class="image-info clearfix">
								<?php echo get_avatar( $comment, 40 ); 
								 printf( '<cite class="fn">%1$s </cite>',
						get_comment_author_link()
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'ioa' ), get_comment_date(), get_comment_time() )
					);?>
			
								 <?php if ( $comment->comment_approved == '0' ) : ?>
										<em><?php _e( 'Your comment is awaiting moderation.'  , 'ioa'); ?></em>
								  <?php endif; ?>
							   </div>
								
							   
							   <div class="comment-body clearfix"><span class="arrow"></span><?php comment_text(); ?></div>
								<div class="reply clearfix">
									<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
							   </div><!-- .reply -->
							 </div><!-- .comment-author .vcard -->
					
				</div><!-- #comment-##  -->
			
				<?php
						break;
					case 'pingback'  :
					case 'trackback' :
				?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:' , 'ioa' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)' , 'ioa'), ' ' ); ?></p>
				<?php
						break;
				endswitch;
			}
			endif;


		/**
		 * Register Sidebars
		 */
		
		$this->initSidebars();
		
		/**
		 * IOA Panel in pages/posts
		 */
		

function ioa_custom_templates_f()
{

	global $IOA_templates,$post,$ioa_portfolio_slug;
	if($post->post_type!="page" && $post->post_type!=$ioa_portfolio_slug ) return;

	$temp = '';

	$ioa_options = get_post_meta(  get_the_ID(), 'ioa_options', true );
	  if($ioa_options =="")
			{
			  $ioa_options = array();
			}  


	$single_portfolio_templates =  array(
											"default" => __("Default Template",'ioa'), 
											"full-screen" => __("Full Screen",'ioa') , 
											"model" => __("Horizontal Images",'ioa') , 
										);
	$snp = '';
	if(isset($ioa_options['single_portfolio_template']))
	$snp = $ioa_options['single_portfolio_template'];
	if($snp=="") $snp= "default";							
 ?>

<div class="ioa-custom-templates clearfix">
	
	<div class="ioa-template-section">
			
		<h4><?php _e('Select The Template','ioa') ?></h4>

			<div class="template-set clearfix">
				
			
			<?php 
				if($post->post_type==$ioa_portfolio_slug) :
				 ?>	
				<ul class="ioa-portfolio-template clearfix">
					<?php foreach ($single_portfolio_templates as $key => $template) {
						?> <li class="<?php echo $key ?>" data-tmp="<?php echo $key ?>"> 
							<span class="holder"></span> <span class="label"><?php echo $template ?></span> </li> <?php
					}?>
				</ul>	
				<input type="hidden" name="single_portfolio_template" class='single_portfolio_template' value='<?php echo $snp; ?>'>	
			<?php endif; ?>
				
			</div>	

	</div>
</div>

<?php
}

		if(is_admin())
		{
			add_action( 'edit_form_after_title', 'ioa_title_settings' );
			
			add_action('edit_form_after_title', 'ioa_custom_templates_f');
			add_action('edit_form_after_title','ioatitlelightbox');
		}

		
		function ioa_title_settings(){
	
		global $post,$IOA_templates,$ioa_portfolio_slug ,$ioa_portfolio_name;
		

		$post_id = $post->ID;
		$ioa_options = get_post_meta(  $post_id, 'ioa_options', true );
		$temp = "default";

		if( isset($ioa_options['ioa_custom_template']) ) $temp = $ioa_options['ioa_custom_template'];	

		?>
			
			 <div class="ioa-title-edit-wrap">
			 	<?php echo IOAHTMLCOMP::tooltip('Title Settings','Set title are stylings from here.'); ?>
			 	<a href='' class="ioa-front-icon cog-2icon- ioa-title-settings-trigger"></a>
			 </div>


			 <div class="clearfix ioa-below-title-area">
			 	<ul class="ioa-context-bar clearfix">
							
							<?php if($post->post_type=='page' || $post->post_type=='post' || $post->post_type==$ioa_portfolio_slug): ?>
							<li><a href="" class="ioa-page-builder-trigger">Switch To Page Builder</a></li>
							<?php endif; ?>
							<li class='ioa-page-settings-wrap'>
								<?php echo IOAHTMLCOMP::tooltip('Set Page Layout','You can set sidebars , layouts and SEO settings here.'); ?>
								<a href="" class="ioa-page-settings"> Page Settings </a>
							</li>
			 	</ul>
				<?php if($post->post_type == $ioa_portfolio_slug || $post->post_type == 'page') :  ?>
			 	<ul class="ioa-template-bar clearfix">
							<li class='custom-template-wrap'>
								<?php echo IOAHTMLCOMP::tooltip('Set Page Template','You can set blog , portfolio or special templates from here.'); ?>
								<div class="custom-template-select-wrap">
									<select name="ioa_custom_template" id="ioa-page-template">
									
									<?php if($post->post_type == 'page') : ?>
									
											<?php foreach ($IOA_templates as $key => $template) { ?> 
											<option <?php if($temp == 'ioa-template-'.str_replace(" ","-",strtolower(trim($key))) ) echo "selected='selected' " ?> value="<?php echo 'ioa-template-'.str_replace(" ","-",strtolower(trim($key))) ?>"> 
												<?php echo $template ?>
											</option>

									<?php } 
											endif;
										   if($post->post_type == $ioa_portfolio_slug) : 

													$single_portfolio_templates =  array(
															"default" => sprintf(__("Set %s Template",'ioa') , $ioa_portfolio_name ), 
															"full-screen" => __("Full Screen",'ioa') , 
															"model" => __("Horizontal Images",'ioa') , 
															"side" => __("Side Layout",'ioa') );
											?>
									
											 <?php foreach ($single_portfolio_templates as $key => $template) {	?>  
												<option <?php if($temp == $key) echo "selected='selected' " ?> value="<?php echo $key ?>"> 
													<?php echo $template ?>
												</option>
												<?php } ?>
									<?php endif; ?>
									</select>	
								</div>
							</li>
							<li class='set-template-settings-wrap'><a href="" class="set-template-settings"> Settings </a></li>
			 	</ul>
			 <?php endif; ?>

			 </div>

		<?php
		


		}


		
		/* When the post is saved, saves our custom data */
		function ioa_save_panel( $post_id ) {

		 global $post,$ioa_page_config,$ioa_meta_data;

		 	  // Check if our nonce is set.
		  if ( ! isset( $_POST['ioa_panel_markup_nonce'] ) )
		    return $post_id;

		  $nonce = $_POST['ioa_panel_markup_nonce'];

		  // Verify that the nonce is valid.
		  if ( ! wp_verify_nonce( $nonce, 'ioa_panel_markup' ) )
		      return $post_id;

		  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
		  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		      return $post_id;

  
		  if ( isset( $_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		    if ( ! current_user_can( 'edit_page', $post_id ) )
		        return;
		  } else {
		    if ( ! current_user_can( 'edit_post', $post_id ) )
		        return;
		  }

		 

		  //if saving in a custom table, get post_ID
		  $post_ID = $post->ID;
		  
		  if ($parent_id = wp_is_post_revision($post_id)) 
			$post_ID = $parent_id;
		  
		  
		   $ioa_options = array();
		   
		   foreach ($ioa_page_config as $key => $section) 
		   	foreach ($section['inputs'] as $key => $mods) {
							
							foreach ($mods as $key => $input) {
								$t = '';
								if(isset($input['default']))	
								$t  = $input['default'];

								if(isset($_POST[$input['name']])) $t  = $_POST[$input['name']];
								
								
								
								$ioa_options[$input['name']] =sanitize_text_field( $t );
									
							}

						}

		 	if(isset($_POST['ioa_custom_template']))
			$ioa_options['ioa_custom_template'] = $_POST['ioa_custom_template'];

			if( isset($_POST['ioa_portfolio_data']) ) $ioa_options['ioa_portfolio_data'] = $_POST['ioa_portfolio_data'];

			if( isset($_POST['ioa_thumbnail_type']) ) $ioa_options['ioa_thumbnail_type'] = $_POST['ioa_thumbnail_type'];
			if( isset($_POST['ioa_custom_thumbnail']) ) $ioa_options['ioa_custom_thumbnail'] = $_POST['ioa_custom_thumbnail'];
			if( isset($_POST['ioa_video_link']) ) $ioa_options['ioa_video_link'] = $_POST['ioa_video_link'];
			if( isset($_POST['ioa_thumbnail_data']) ) $ioa_options['ioa_thumbnail_data'] = $_POST['ioa_thumbnail_data'];

				
			   $r_style = ''; $rad_custom_css = '';

			   if(isset($_POST['style_keys'])) $r_style =  $_POST['style_keys'];
			   if(isset($_POST['rad_custom_css'])) $rad_custom_css = $_POST['rad_custom_css'];

			   update_post_meta( $post_ID, '_style_keys', $r_style );
			   update_post_meta( $post_ID, 'rad_custom_css', $rad_custom_css );

		   	update_post_meta( $post_ID, 'ioa_options', $ioa_options );
			update_post_meta( $post_ID, 'rad_version',RAD_Version);

		 	

		}
		add_action( 'save_post', 'ioa_save_panel' );
		add_action( 'pre_post_update', 'ioa_save_panel' );
		
		/**
		 * Featured Media Panel
		 */
		
		if(is_admin())
		{
			add_action( 'add_meta_boxes', 'ioa_add_panel',1 );
			add_action('add_meta_boxes','ioa_portfolio_images');
			add_action('add_meta_boxes','ioa_thumbnail_management');


		}

		function ioa_portfolio_images() {
			
		    	global $ioa_portfolio_slug;

		        add_meta_box(
		            'ioa_portfolio_images',
		           __('Portfolio Extra Images', 'ioa'),
		            'ioa_portfolio_images_markup',
		            $ioa_portfolio_slug, 'normal' , 'core'
		        );
		    
		}

		/* Prints the box content */
		function ioa_portfolio_images_markup( $post ) {

		  // Use nonce for verification
		  wp_nonce_field( 'IOA', 'ioa_noncename' );
		  global $ioa_super_options ;
		  // The actual fields for data entry
		  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
		  // All custom tab details are retreived here.
		  
		   


		  $ioa_options = get_post_meta( $post->ID, 'ioa_options', true );

  		   ?>		<div id="ioa_images" class="clearfix">
				<p class="note ioa-information-p"> <?php _e(" To Select Multiple Images hold down control key or cmd for MAC. To select in a row in a single click, hold down shift click on first image then click on last image you want.",'ioa') ?> </p>
				<a href="" class="portfolio-ioa-images-generator button-default" data-title="Add Images" data-label="Add" ><?php _e(' Add Images ','ioa') ?></a>	
				 <div class="ioa-image-area clearfix">
				 	<?php 
				 	if(isset($ioa_options['ioa_portfolio_data']) && trim($ioa_options['ioa_portfolio_data']) != "" ) : 
				 		$ar = explode(";",stripslashes($ioa_options['ioa_portfolio_data']));

				 	foreach( $ar as $image) :

							if($image!="") :
								$g_opts = explode("[ioabre]",$image);
							
							?>
								<div class='ioa-gallery-item' data-thumbnail='<?php echo $g_opts[1]; ?>' data-img='<?php echo $g_opts[0]; ?>' data-alt='<?php echo $g_opts[2]; ?>' data-title='<?php echo $g_opts[3] ?>' data-description='<?php echo $g_opts[4] ?>' ><img src='<?php echo $g_opts[1] ?>' /> <a class='close  ioa-front-icon cancel-3icon-' href=''></a></div>
							<?php 
						endif;
					endforeach; endif; ?>

				 </div>
				 <input type="hidden" name="ioa_portfolio_data" class="ioa_portfolio_data" value="<?php if(isset($ioa_options['ioa_portfolio_data']) && trim($ioa_options['ioa_portfolio_data']) != "" ) echo $ioa_options['ioa_portfolio_data'];  ?>" />
			</div>	


		  <?php
		}

		/**
		 * Thumbnail Management
		 */

		function ioa_thumbnail_management() {
			
		    	global $ioa_portfolio_slug;

		        add_meta_box(
		            'ioa_thumbnail_management',
		           __('Portfolio Thumbnail Management', 'ioa'),
		            'ioa_thumbnail_management_markup',
		            $ioa_portfolio_slug, 'normal' , 'core'
		        );
		    
		}

		/* Prints the box content */
		function ioa_thumbnail_management_markup( $post ) {

		  // Use nonce for verification
		  wp_nonce_field( 'IOA', 'ioa_noncename' );
		  global $ioa_super_options ;
		  // The actual fields for data entry
		  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
		  // All custom tab details are retreived here.
		  
		   


		  $ioa_options = get_post_meta( $post->ID, 'ioa_options', true );
		  
		  $thumbnail_type = 'image';  $custom_thumbnail = $video_link ='';
		

		  if(isset($ioa_options['ioa_thumbnail_type'])) $thumbnail_type = $ioa_options['ioa_thumbnail_type'];
		  if( isset($ioa_options['ioa_custom_thumbnail']) ) $custom_thumbnail = $ioa_options['ioa_custom_thumbnail'];
		  if( isset($ioa_options['ioa_video_link']) ) $video_link = $ioa_options['ioa_video_link'];
		  
		  echo getIOAInput(array( 
									"label" => __("Select Thumbnail Type",'ioa') , 
									"name" => "ioa_thumbnail_type" , 
									"default" => 'image' ,
									"value" => $thumbnail_type, 
									"type" => "select",
									"options" => array('image' => 'Featured Image','hosted_video' =>'Featured Image with Self Hosted Video in lightbox','video' =>'Featured Image with Video in lightbox','slider' =>'Slider')
												 
							));

		  echo getIOAInput(array( 
									"label" => __("Alternate Thumbnail Type",'ioa') , 
									"name" => "ioa_custom_thumbnail" , 
									"default" => '' ,
									"value" => $custom_thumbnail, 
									"type" => "upload"
												 
							));
  		 
  		 echo getIOAInput(array( 
									"label" => __("Video Link That will Appear in Lightbox(Set Thumbnail Type to 2nd option)",'ioa') , 
									"name" => "ioa_video_link" , 
									"default" => '' ,
									"class" => "has-input-button",
									"value" => $video_link, 
									"type" => "video"
												 
							));

  		   ?>
  		   <div id="ioa_images" class="clearfix">
				<p class="note ioa-information-p"> <?php _e(" To Select Multiple Images hold down control key or cmd for MAC. To select in a row in a single click, hold down shift click on first image then click on last image you want.",'ioa') ?> </p>
				<a href="" class="thumbnail-ioa-images-generator button-default" data-title="Add Images" data-label="Add" ><?php _e(' Add Images ','ioa') ?></a>	
				 <div class="ioa-image-area clearfix">
				 	<?php 
				 	if(isset($ioa_options['ioa_thumbnail_data']) && trim($ioa_options['ioa_thumbnail_data']) != "" ) : 
				 		$ar = explode(";",stripslashes($ioa_options['ioa_thumbnail_data']));

				 	foreach( $ar as $image) :

							if($image!="") :
								$g_opts = explode("[ioabre]",$image);
							
							?>
								<div class='ioa-gallery-item' data-thumbnail='<?php echo $g_opts[1]; ?>' data-img='<?php echo $g_opts[0]; ?>' data-alt='<?php echo $g_opts[2]; ?>' data-title='<?php echo $g_opts[3] ?>' data-description='<?php echo $g_opts[4] ?>' ><img src='<?php echo $g_opts[1] ?>' /> <a class='close  ioa-front-icon cancel-3icon-' href=''></a></div>
							<?php 
						endif;
					endforeach; endif; ?>

				 </div>
				 <input type="hidden" name="ioa_thumbnail_data" class="ioa_thumbnail_data" value="<?php if(isset($ioa_options['ioa_thumbnail_data']) && trim($ioa_options['ioa_thumbnail_data']) != "" ) echo $ioa_options['ioa_thumbnail_data'];  ?>" />
			</div>	
			<?php

		}


		function ioa_add_panel() {
			global $ioa_registered_posts;
		    $screens = array( 'post', 'page' , 'product' );

		    $scr = array();
		    foreach ($ioa_registered_posts as $rs) {
		    	if( $rs->getPostType()!="slider" && $rs->getPostType()!="custompost")
		    	$screens[] = $rs->getPostType();
		    }

		    foreach ($screens as $screen) {
		        add_meta_box(
		            'ioa_featured_media',
		           __('Featured Media', 'ioa'),
		            'ioa_panel_markup',
		            $screen, 'side' , 'core'
		        );
		    }
		}

		/* Prints the box content */
		function ioa_panel_markup( $post ) {

		  // Use nonce for verification
		  wp_nonce_field( 'ioa_panel_markup', 'ioa_panel_markup_nonce' );
		  global $ioa_super_options ,  $ioa_page_config;
		  // The actual fields for data entry
		  // Use get_post_meta to retrieve an existing value from the database and use the value for the form
		  // All custom tab details are retreived here.
		  
		   


		  $ioa_options = get_post_meta( $post->ID, 'ioa_options', true );
		  if($ioa_options=="") $ioa_options  = array();

		 

			foreach ($ioa_page_config['featured_media']['inputs'] as $key => $mods) {
				?> 
				
				<div class="ioa-title-mod-section" id="<?php echo str_replace(' ','_',strtolower($key)) ?>"> 
				<?php
				foreach ($mods as $key => $input) {
					
					$t  = '';

					if(isset($input['default'])) $t = $input['default'];


					if(isset($ioa_options[$input['name']])) $t  = $ioa_options[$input['name']];
					$fn = $input;
					



					$fn['value'] = $t;

					if($input['name'] == 'featured_media_type' && $post->post_type =='product')
					{

						$fn['options']['product_gallery'] = "Gallery From Product Gallery";
						$fn['options']['zoomable'] = "Product Zoom";
						
						if(count($ioa_options) == 0)
						$fn['value'] = 'product_gallery'; 
					}



					if( $input['type'] == 'slider' && $t =='' )
					{
						$fn['value'] = '0'; 
					}

					echo getIOAInput($fn);	
				}
				?>
				</div>
				<?php	}	?>
		
		<div id="ioa_images" class="clearfix ioa-media-filterable slideshow-fullscreen slideshow slideshow-contained slider slider-contained slider-full">
				<p class="note ioa-information-p"> <?php _e(" To Select Multiple Images hold down control key or cmd for MAC. To select in a row in a single click, hold down shift click on first image then click on last image you want.",'ioa') ?> </p>
				 <div class="ioa-image-area clearfix">
				 	<?php 
				 	if(isset($ioa_options['ioa_gallery_data']) && trim($ioa_options['ioa_gallery_data']) != "" ) : 
				 		$ar = explode(";",stripslashes($ioa_options['ioa_gallery_data']));

				 	foreach( $ar as $image) :

							if($image!="") :
								$g_opts = explode("[ioabre]",$image);
							
							?>
								<div class='ioa-gallery-item' data-thumbnail='<?php echo $g_opts[1]; ?>' data-img='<?php echo $g_opts[0]; ?>' data-alt='<?php echo $g_opts[2]; ?>' data-title='<?php echo $g_opts[3] ?>' data-description='<?php echo $g_opts[4] ?>' ><img src='<?php echo $g_opts[1] ?>' /> <a class='close  ioa-front-icon cancel-3icon-' href=''></a></div>
							<?php 
						endif;
					endforeach; endif; ?>

				 </div>
				 <a href="" class="post-ioa-images-generator button-default" data-title="Add Images" data-label="Add" ><?php _e(' Add Images ','ioa') ?></a>	
			</div>	


		  <?php
		}


		/**
		 * Registers All Javascript and CSS Files ( for both admin and frontend )
		 */


		$this-> registerScripts();
		
		/**
		 *  Menu Register
		 */
		
		$menus =  array(
			'top_menu1_nav' => __('Main Menu','ioa'),
		  	'top_menu2_nav' => __('Top Menu Holder 2','ioa'),
			'footer_nav' => __('Bottom Footer Menu','ioa')
		  );
		
		$this->registerMenus($menus);		  



		function headcustomstyle()
		{
			$code = '';
			
			global $ioa_super_options,$color_scheme_default,$ioa_meta_data;
			$cvals = '';
			if(get_option(SN.'concave_value')) $cvals = stripslashes(get_option(SN.'concave_value'));	

			$code = '';

			$disable_scheme = 'no';
			if(get_option(SN.'_toggle_scheme')) $disable_scheme = get_option(SN.'_toggle_scheme');
			
			if($disable_scheme != "yes") :


			$palette = array();
			$data = get_option(SN.'_enigma_data');
			if( isset($data['palette']) )
			$palette = $data['palette'];

			$pl_c = '';
			/**
			*
			* Per Page Scheme
			*
			**/
			

			if(isset($ioa_meta_data['page_scheme']) && $ioa_meta_data['page_scheme']!="none" )
			  {
			  	 if(get_option(SN.'_pre_schemes'))
				 	$in_schemes = get_option(SN.'_pre_schemes');
				
				 if(isset($in_schemes[$ioa_meta_data['page_scheme']]))
				 	$palette = $in_schemes[$ioa_meta_data['page_scheme']] ;

				  $en = new EnigmaDynamic();
				$pl_c =  $en->getRuntimeCode($palette);

			  } 
			 
			

			 /**
			 *
			 * File Not Exists
			 *
			 **/
			 
			if( get_option(SN.'_dynamic_css_status') && get_option(SN.'_dynamic_css_status') !='file' )
			{
				 $en = new EnigmaDynamic();
				$pl_c =  $en->getRuntimeCode($palette);
			}

			$code .= $pl_c;

			endif;
			

			if(isset($data['boxed']))
				{
					 $boxed_vals = $data['boxed'];
					 switch($boxed_vals['boxed_background_opts'])
					 {
					 	case 'primary-color' : $code .= "div.super-wrapper { background: ".$palette['primary_color']."; } " ; break;
					 	case 'primary-alt-color' : $code .= "div.super-wrapper { background: ".$palette['primary_alt_color']."; } " ; break;
					 	case 'secondary-color' : $code .= "div.super-wrapper { background: ".$palette['secondary_color']."; } " ; break;
					 	case 'bg-color' : $code .= "div.super-wrapper { background: ".$boxed_vals['boxed_background_color']."; } " ; break;
					 	case 'bg-image': $code.= "div.super-wrapper {  background:url(".$boxed_vals['boxed_background_image'].") top left fixed;background-size:cover; }"; break;
					 	case 'bg-texture': $code.= "div.super-wrapper {  background:url(".$boxed_vals['boxed_background_image'].") ".$boxed_vals['boxed_background_position']." ".$boxed_vals['boxed_background_repeat']." ".$boxed_vals['boxed_background_attachment']."; }"; break;
					case 'custom': $code.= "div.super-wrapper { background-color:".$boxed_vals['boxed_background_color'].";background:url(".$boxed_vals['boxed_background_image'].") ".$boxed_vals['boxed_background_position']." ".$boxed_vals['boxed_background_repeat']." ".$boxed_vals['boxed_background_attachment'].";background-size:".$boxed_vals['boxed_background_cover']."; }"; break;
					case 'bg-gr': 
					
					$iefix = 0;
					$dir_gr ='top';
					$end_gr = $boxed_vals['boxed_end_gr'];
					$start_gr = $boxed_vals['boxed_start_gr'];
					switch($boxed_vals['background_gradient_dir'])
					{
						case "vertical" : $dir_gr = "top"; break;
						case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
						case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
						case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
					}	
							
					 $code.= "div.super-wrapper {  background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr."); }";

					break;

					 }
					 
				}

			if(isset($data['title_area']))
				{
					 $title_vals = $data['title_area'];
					 switch($title_vals['title_background_opts'])
					 {
					 	case 'primary-color' : $code .= " div.supper-title-wrapper { background: ".$palette['primary_color']."; } " ; break;
					 	case 'primary-alt-color' : $code .= " div.supper-title-wrapper { background: ".$palette['primary_alt_color']."; } " ; break;
					 	case 'secondary-color' : $code .= " div.supper-title-wrapper { background: ".$palette['secondary_color']."; } " ; break;
					 	case 'bg-color' : $code .= " div.supper-title-wrapper { background: ".$title_vals['title_background_color']."; } " ; break;
					 	case 'bg-image': $code.= " div.supper-title-wrapper {  background:url(".$title_vals['title_background_image'].") top left fixed;background-size:cover; }"; break;
					 	case 'bg-texture': $code.= " div.supper-title-wrapper {  background:url(".$title_vals['title_background_image'].") ".$title_vals['title_background_position']." ".$title_vals['title_background_repeat']." ".$title_vals['title_background_attachment']."; }"; break;
					case 'custom': $code.= " div.supper-title-wrapper { background-color:".$title_vals['title_background_color'].";background:url(".$title_vals['title_background_image'].") ".$title_vals['title_background_position']." ".$title_vals['title_background_repeat']." ".$title_vals['title_background_attachment'].";background-size:".$title_vals['title_background_cover']."; }"; break;
					case 'bg-gr': 
					
					$iefix = 0;
					$dir_gr ='top';
					$end_gr = $title_vals['title_end_gr'];
					$start_gr = $title_vals['title_start_gr'];
					switch($title_vals['title_background_gradient_dir'])
					{
						case "vertical" : $dir_gr = "top"; break;
						case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
						case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
						case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
					}	
							
					 $code.= " div.supper-title-wrapper {  background:$start_gr; background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr."); }";

					break;

					 }
					 
					 $code .= " div.title-wrap h1 { color:".$title_vals['title_color']."}";
					 
				}		
            
            if(!isset($ioa_super_options[SN.'_custom_css'])) $ioa_super_options[SN.'_custom_css'] ='';
				
			$code =  "<style type='text/css'>
						
						".$ioa_super_options[SN.'_custom_css']."
					@media  only screen and (max-width: 767px) {  .skeleton {   width:".$ioa_super_options[SN.'_res_width']."%;   } }
					
				  </style><style id='concave-area-styles'>  /* Concave Stylings */  $cvals $code </style>
				  <script type='text/javascript'> ".$ioa_super_options[SN.'_headjs_code']." </script>";

			  
				  
			echo $code;	  
		}

		add_action('wp_head','headcustomstyle');

	}
	
	function RADStyler()
		{

			global $post,$ioa_meta_data,$radunits;
			
			if( !is_singular() ) return;
			
			$rad_styles = get_post_meta( $post->ID, '_style_keys', true );



			if( $rad_styles  == "" && is_array($ioa_meta_data['rad_data']))	 
			{

				$this->RADBaseStyler();
				return;
			}


			$styler_code = '';
			$responsive_view = array(
						'Screen' => array( 'el' => array() , 'query' => '@media (min-width:1024px)' ),
						'iPad Horizontal'=>  array( 'el' => array() , 'query' => '@media (min-width: 768px) and (max-width: 1024px)' ),
						'iPad Vertical & Small Tablets'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 768px) and (max-width: 979px)' ),
						'Mobile Landscape'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 480px) and (max-width: 767px) ' ),
						'Mobile Potrait'=>  array( 'el' => array() , 'query' => ' @media only screen and (max-width: 479px)' ),
						);

			$rad_styles =  json_decode(urldecode(str_replace('[p]','%',$rad_styles)),true);
			
			if($rad_styles!="")
			foreach($rad_styles as $k => $element) : 
					
				switch($element['key'])
				{
					case 'rad_page_section' :
							$sc = '';
							$d = array();

							if(isset($element['data']))
							$d = $element['data'];

							$d = $this->getAssocMap($d,'value'); 

							if(isset($d['visibility']))
							{
								$view_test = explode(';',$d['visibility']);
								foreach ($view_test as $key => $pkey) {
									
									if(isset($responsive_view[$pkey]))
									{
										$responsive_view[$pkey]['el'][] = '#'.$k;
									}

								}
							}

							if( isset($d['ov_use']) && $d['ov_use']=="yes")
							{
								$ov = '';
								$styler_code .= "#".$k." .section-overlay{   ";
								$styler_code.= "opacity:".(intval($d['ov_opacity'])/100).";";	
								$styler_code.= "background:url(".$d['ov_background_image'].") ".$d['ov_background_position']." ".$d['ov_background_repeat']." ".$d['ov_background_attachment']." ".$d['ov_background_color'].";;background-size:".$d['ov_background_cover']." ";
								

								if($d['ov_use_gradient_dir']=='yes') :
									$iefix = 0;
									$dir_gr ='top';
									$end_gr = $d['ov_end_gr'];
									$start_gr = $d['ov_start_gr'];
									switch($d['ov_background_gradient_dir'])
									{
										case "vertical" : $dir_gr = "top"; break;
										case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
										case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
										case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
									}	
											
									$styler_code .= "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

								endif;

								$styler_code .= "}";


							}

							if(isset($d['v_padding_top']) && $d['v_padding_top']!=""  && $d['v_padding_top']!="") $sc = "padding-top: ".$d['v_padding_top']."px;";
							if(isset($d['v_padding_bottom']) && $d['v_padding_bottom']!="" && $d['v_padding_bottom']!="") $sc .= "padding-bottom: ".$d['v_padding_bottom']."px;";

							if(isset($d['background_opts']))
							switch ($d['background_opts']) {
								case 'bg-color': 
												 $rgb = hex2RGB($d['background_color']);
												 if(isset($d['bg_opacity']) && $d['bg_opacity']!="") :
													 $op= $d['bg_opacity'];
													 if($op=="") $op = 100;
													 $op = $op/100;
													 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");";
												 else:	
												 	$sc.= "background:rgb(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].");";
												 endif;
												 	 
												 break;
								case 'bg-image': $sc.= "background:url(".$d['background_image'].") top left ".$d['background_attachment'].";background-size:cover;"; break;
								case 'parallax': $sc.= "background:url(".$d['background_image'].") top center fixed;background-size:cover;"; break;
								case 'bg-texture': $sc.= "background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";"; break;
								case 'custom': $sc.= "background-color:".$d['background_color'].";background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";background-size:".$d['background_cover'].";"; break;
								case 'bg-gr': 
								
								$iefix = 0;
								$dir_gr ='top';
								$end_gr = $d['end_gr'];
								$start_gr = $d['start_gr'];
								switch($d['background_gradient_dir'])
								{
									case "vertical" : $dir_gr = "top"; break;
									case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
									case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
									case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
								}	
										
								$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

								$sc.= $code; 
								break;
								
							}

							if( isset($d['border_top_width']) && $d['border_top_width']!="" && $d['border_top_width']!="0")
							{
								$op = 1;
								if(isset($d['border_top_opacity'])) $op = $d['border_top_opacity']/100;
								$rgb = hex2RGB($d['border_top_color']);

								$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
								$sc .= "border-top:".$d['border_top_width']."px ".$d['border_top_type']." ".$color.";";
							}	
							if( isset($d['border_bottom_width']) && $d['border_bottom_width']!="" && $d['border_bottom_width']!="0")
							{
								$op = 1;
								if(isset($d['border_bottom_opacity'])) $op = $d['border_bottom_opacity']/100;
								$rgb = hex2RGB($d['border_bottom_color']);

								$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
								$sc .= "border-bottom:".$d['border_bottom_width']."px ".$d['border_bottom_type']." ".$color.";";
							}	

							if(trim($sc)!="")
							$styler_code .= "#".$k."{ $sc  }";

						break;
					case 'rad_page_container' :
						

						$sc = '';
						$c = $element['data'];
						
						$c = $this->getAssocMap($c,'value');

						switch ($c['background_opts']) {
							case 'bg-color': $rgb = hex2RGB($c['background_color']);
											 $op= $c['background_opacity'];
											 if($op=="") $op = 1;
											 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");"; break;
							case 'bg-image': $sc.= "background:url(".$c['background_image'].") top left ".$c['background_attachment'].";background-size:cover;"; break;
							case 'bg-texture': $sc.= "background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";"; break;
							case 'custom': $sc.= "background-color:".$c['background_color'].";background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";background-size:".$c['background_cover'].";"; break;
							case 'bg-gr': 
							
							$iefix = 0;
							$dir_gr ='top';
							$end_gr = $c['end_gr'];
							$start_gr = $c['start_gr'];
							switch($c['background_gradient_dir'])
							{
								case "vertical" : $dir_gr = "top"; break;
								case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
								case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
								case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
							}	
									
							$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

							$sc.= $code; 
							break;
							
						}

						if($c['border_top_width']!="" && $c['border_top_width']!="0")
							$sc .= "border-top:".$c['border_top_width']."px ".$c['border_top_type']." ".$c['border_top_color'].";";
						if($c['border_bottom_width']!="" && $c['border_bottom_width']!="0")
							$sc .= "border-bottom:".$c['border_bottom_width']."px ".$c['border_bottom_type']." ".$c['border_bottom_color'].";";

						if( isset($c['use_margin']) && $c['use_margin']=='yes' && $c['margin_top']!="" && $c['margin_top']!="")
							$sc.="margin-top:".$c['margin_top']."px;";

					    if( isset($c['use_margin']) && $c['use_margin']=='yes' && $c['margin_bottom']!="" && $c['margin_bottom']!="")
							$sc.="margin-bottom:".$c['margin_bottom']."px;";

						if(trim($sc)!="" )
						$styler_code .= "#".$k."{ $sc  } ";

						$view_test = array();

						if(isset($c['visibility']))
						{
							$view_test = explode(';',$c['visibility']);
							foreach ($view_test as $key => $pkey) {
								
								if(isset($responsive_view[$pkey]))
								{
									$responsive_view[$pkey]['el'][] = '#'.$k;
								}

							}
						}

					break;	
					default : 
								$widget_data = $element['data'];
								$widget_data = $this->getAssocMap($widget_data,'value');
									
								$keys  = $radunits[str_replace('-','_',$element['key'])]->getStyleKeys();

								foreach ($keys as $key => $field) {
								 	if( isset($widget_data[$field['name']]) && trim($widget_data[$field['name']])!="" )
								 	{
								 		$v = $widget_data[$field['name']];
								 		$d = $field['data'];

								 		if($field['type']=='slider') $v .= $field['suffix'];

								 		if($v!="" || $v!="0" || $v!="0px")
								 		$styler_code .= ' #'.$k.' '.$d['target'].' { '.$d['property'].' : '.$v.' }';
								 		if( isset($d['extra_cl']) )
								 		{
								 			foreach ($d['extra_cl'] as $key => $value) {
								 					$styler_code .= ' #'.$k.' '.$key.' { '.$value.' : '.$v.'!important }';
								 			}
								 		}
								 	}
								 }
					break;			 
				}

			endforeach; 

			$page_css = get_post_meta( get_the_ID() , 'rad_custom_css', true );

			$styler_code .= " ".$page_css;

			foreach($responsive_view as $view)
				{
					$styler_code .= " ".$view['query']." { ".join(',',$view['el'])." { display:none; } } ";
				}

			echo "<style type='text/css' id='rad_styler'> $styler_code </style>";

		}

	function RADBaseStyler()
		{

			global $post,$ioa_meta_data,$radunits;
			
			if( !is_singular() ) return;
			
			$styler_code = '';
			$responsive_view = array(
						'Screen' => array( 'el' => array() , 'query' => '@media (min-width:1024px)' ),
						'iPad Horizontal'=>  array( 'el' => array() , 'query' => '@media (min-width: 768px) and (max-width: 1024px)' ),
						'iPad Vertical & Small Tablets'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 768px) and (max-width: 979px)' ),
						'Mobile Landscape'=>  array( 'el' => array() , 'query' => '@media only screen and (min-width: 480px) and (max-width: 767px) ' ),
						'Mobile Potrait'=>  array( 'el' => array() , 'query' => ' @media only screen and (max-width: 479px)' ),
						);

			
			if(isset($ioa_meta_data['rad_data']) && is_array($ioa_meta_data['rad_data'])) : foreach($ioa_meta_data['rad_data'] as $section) : 
				$sc ='';
				$d = array();

				if(isset($section['data']))
				$d = $section['data'];

				

				$d = $this->getAssocMap($d,'value');

				if(isset($d['visibility']))
				{
					$view_test = explode(';',$d['visibility']);
					foreach ($view_test as $key => $pkey) {
						
						if(isset($responsive_view[$pkey]))
						{
							$responsive_view[$pkey]['el'][] = '#'.$section['id'];
						}

					}
				}

				if( isset($d['ov_use']) && $d['ov_use']=="yes")
				{
					$ov = '';
					$styler_code .= "#".$section['id']." .section-overlay{   ";
					$styler_code.= "opacity:".(intval($d['ov_opacity'])/100).";";	

					$styler_code .= "-ms-filter: \"progid:DXImageTransform.Microsoft.Alpha(Opacity=".$d['ov_opacity'].")\";";

					$styler_code.= "background:url(".$d['ov_background_image'].") ".$d['ov_background_position']." ".$d['ov_background_repeat']." ".$d['ov_background_attachment']." ".$d['ov_background_color'].";;background-size:".$d['ov_background_cover']." ";
					

					if($d['ov_use_gradient_dir']=='yes') :
						$iefix = 0;
						$dir_gr ='top';
						$end_gr = $d['ov_end_gr'];
						$start_gr = $d['ov_start_gr'];
						switch($d['ov_background_gradient_dir'])
						{
							case "vertical" : $dir_gr = "top"; break;
							case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
							case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
							case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
						}	
								
						$styler_code .= "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

					endif;

					$styler_code .= "}";


				}

				if(isset($d['v_padding_top']) && $d['v_padding_top']!=""  && $d['v_padding_top']!="0") $sc = "padding-top: ".$d['v_padding_top']."px;";
				if(isset($d['v_padding_bottom']) && $d['v_padding_bottom']!="" && $d['v_padding_bottom']!="0") $sc .= "padding-bottom: ".$d['v_padding_bottom']."px;";

				if(isset($d['background_opts']))
				switch ($d['background_opts']) {
					case 'bg-color': 
									 $rgb = hex2RGB($d['background_color']);
									 if(isset($d['bg_opacity']) && $d['bg_opacity']!="") :
										 $op= $d['bg_opacity'];
										 if($op=="") $op = 100;
										 $op = $op/100;
										 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");";
									 else:	
									 	$sc.= "background:rgb(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].");";
									 endif;
									 	 
									 break;
					case 'bg-image': $sc.= "background:url(".$d['background_image'].") top left ".$d['background_attachment'].";background-size:cover;"; break;
					case 'bg-texture': $sc.= "background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";"; break;
					case 'custom': $sc.= "background-color:".$d['background_color'].";background:url(".$d['background_image'].") ".$d['background_position']." ".$d['background_repeat']." ".$d['background_attachment'].";background-size:".$d['background_cover'].";"; break;
					case 'bg-gr': 
					
					$iefix = 0;
					$dir_gr ='top';
					$end_gr = $d['end_gr'];
					$start_gr = $d['start_gr'];
					switch($d['background_gradient_dir'])
					{
						case "vertical" : $dir_gr = "top"; break;
						case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
						case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
						case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
					}	
							
					$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

					$sc.= $code; 
					break;
					
				}

				if( isset($d['border_top_width']) && $d['border_top_width']!="" && $d['border_top_width']!="0")
				{
					$op = 1;
					if(isset($d['border_top_opacity'])) $op = $d['border_top_opacity']/100;
					$rgb = hex2RGB($d['border_top_color']);

					$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
					$sc .= "border-top:".$d['border_top_width']."px ".$d['border_top_type']." ".$color.";";
				}	
				if( isset($d['border_bottom_width']) && $d['border_bottom_width']!="" && $d['border_bottom_width']!="0")
				{
					$op = 1;
					if(isset($d['border_bottom_opacity'])) $op = $d['border_bottom_opacity']/100;
					$rgb = hex2RGB($d['border_bottom_color']);

					$color = "rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.")";
					$sc .= "border-bottom:".$d['border_bottom_width']."px ".$d['border_bottom_type']." ".$color.";";
				}	

				if(trim($sc)!="")
				$styler_code .= "#".$section['id']."{ $sc  }";

				if( isset($section['containers']) )
				foreach ($section['containers'] as $key => $container) {
					$sc = '';
					$c = $container['data'];
					$c = $this->getAssocMap($c,'value');

					switch ($c['background_opts']) {
						case 'bg-color': $rgb = hex2RGB($c['background_color']);
										 $op= $c['background_opacity'];
										 if($op=="") $op = 1;
										 $sc.= "background:rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",".$op.");"; break;
						case 'bg-image': $sc.= "background:url(".$c['background_image'].") top left ".$c['background_attachment'].";background-size:cover;"; break;
						case 'bg-texture': $sc.= "background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";"; break;
						case 'custom': $sc.= "background-color:".$c['background_color'].";background:url(".$c['background_image'].") ".$c['background_position']." ".$c['background_repeat']." ".$c['background_attachment'].";background-size:".$c['background_cover'].";"; break;
						case 'bg-gr': 
						
						$iefix = 0;
						$dir_gr ='top';
						$end_gr = $c['end_gr'];
						$start_gr = $c['start_gr'];
						switch($c['background_gradient_dir'])
						{
							case "vertical" : $dir_gr = "top"; break;
							case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
							case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
							case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
						}	
								
						$code = "background:$start_gr;background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";

						$sc.= $code; 
						break;
						
					}

					if($c['border_top_width']!="" && $c['border_top_width']!="0")
						$sc .= "border-top:".$c['border_top_width']."px ".$c['border_top_type']." ".$c['border_top_color'].";";
					if($c['border_bottom_width']!="" && $c['border_bottom_width']!="0")
						$sc .= "border-bottom:".$c['border_bottom_width']."px ".$c['border_bottom_type']." ".$c['border_bottom_color'].";";

					if( isset($c['use_margin']) && $c['use_margin']=='yes')
						$sc.="margin-top:".$c['margin_top']."px;margin-bottom:".$c['margin_bottom']."px;";

					if(trim($sc)!="" && isset($container['id']))
					$styler_code .= "#".$container['id']."{ $sc  } ";
					$view_test = array();

					if(isset($c['visibility']))
					{
						$view_test = explode(';',$c['visibility']);
						foreach ($view_test as $key => $pkey) {
							
							if(isset($responsive_view[$pkey]))
							{
								$responsive_view[$pkey]['el'][] = '#'.$container['id'];
							}

						}
					}

					if(trim($sc)!="" && isset($container['id']))
					$styler_code .= "#".$container['id']."{ $sc  } ";

					$widgets = array();
					if(isset($container['widgets'])) $widgets = $container['widgets'];

					foreach ($widgets as $key => $widget) {
						if( isset($radunits[str_replace('-','_',$widget['type'])]) ) :


						$widget_data = $widget['data'];
						$widget_data = $this->getAssocMap($widget_data,'value');
						
						$keys  = $radunits[str_replace('-','_',$widget['type'])]->getStyleKeys();

						 foreach ($keys as $key => $field) {
						 	if( isset($widget_data[$field['name']]) && trim($widget_data[$field['name']])!="" )
						 	{
						 		$v = $widget_data[$field['name']];
						 		$d = $field['data'];

						 		if($field['type']=='slider') $v .= $field['suffix'];

						 		if($v!="" || $v!="0" || $v!="0px")
						 		$styler_code .= ' #'.$widget['id'].' '.$d['target'].' { '.$d['property'].' : '.$v.' }';
						 		if( isset($d['extra_cl']) )
						 		{
						 			foreach ($d['extra_cl'] as $key => $value) {
						 					$styler_code .= ' #'.$widget['id'].' '.$key.' { '.$value.' : '.$v.'!important }';
						 			}
						 		}
						 	}
						 }

						 endif;

					}

				}
			endforeach; endif; 


			foreach($responsive_view as $view)
			{
				$styler_code .= " ".$view['query']." { ".join(',',$view['el'])." { display:none; } } ";
			}
			
			echo "<style type='text/css'> $styler_code </style>";

		}	

	function preparePage($id=false)
	{
		global $post,$ioa_meta_data,$ioa_super_options,$ioa_layout;

		$flag = true;

		if(IOA_WOO_EXISTS && is_shop())
		{
			$flag = false;
		}

		

		if( ((is_author()|| is_search() || is_tag() || is_category() || is_archive() ) || is_home()) &&  ! ( IOA_WOO_EXISTS && is_shop() ) )
		{
			
			if( (is_author()|| is_search() || is_tag() || is_category() || is_archive() ) && $flag  ) $ioa_meta_data['layout'] = 'right-sidebar';
			if(is_archive()) 
			{
				
				$ioa_meta_data['title']="";
				if ( is_day() ) :
					$ioa_meta_data['title'] =  __( 'Daily Archives:', 'ioa' );
				elseif ( is_month() ) :
					$ioa_meta_data['title'] = __( 'Monthly Archives: ', 'ioa' );
				elseif ( is_year() ) :
					$ioa_meta_data['title'] = __( 'Yearly Archives: ', 'ioa' );
				elseif(is_tax()) : $ioa_meta_data['title'] =  single_term_title('',false);
				else :
					$ioa_meta_data['title'] = __( 'Archives', 'ioa' );

				endif;
				$show_title ="yes";
			}
			if(is_category())
			{
				
				$ioa_meta_data['title']= __('Category : ','ioa').single_cat_title( '', false );
			} 
			if(is_tag()) 
			{
				
				$ioa_meta_data['title']= __('Tag : ','ioa').single_tag_title( '', false );
			}
			if(is_search()) 
			{
				
				$ioa_meta_data['title'] =  __( 'Search Results for: ', 'ioa' ). '<span>' . get_search_query() . '</span>';
			}
			if(is_author())
			{
				if ( have_posts() ) : the_post();
					$ioa_meta_data['title'] = __( 'Author Posts :', 'ioa' ).  get_the_author();
				endif;
				rewind_posts();
				
			}

			if(is_home()) $ioa_meta_data['title'] = 'Posts';
			if( IOA_WOO_EXISTS && is_shop() && $id )
			{
				$ioa_meta_data['title'] = get_the_title($id);
			} 

			if( (function_exists('is_bbpress') && is_bbpress()) )
			{
				$ioa_meta_data['title'] = 'Forums';
			
				$ioa_meta_data['layout'] ="right-sidebar";
				$ioa_meta_data['sidebar']  = $ioa_super_options[SN.'_bbpress_sidebar'];
			
			}

			return;
		} 
			
		$ioa_options = array();

		
		if(!$id)	
			{ 
				$ioa_options = get_post_meta(  get_the_ID(), 'ioa_options', true );
				$ioa_meta_data['title'] = get_the_title();

			}
		else
			{
				$ioa_meta_data['title'] = get_the_title($id);
				$ioa_options = get_post_meta(  $id, 'ioa_options', true );

			}

		


		if($ioa_options=="")
			$ioa_options = array();
		
		$page_layout= $page_sidebar= '';
		$ioa_options['page_breadcrumb_toggle'] =  $ioa_meta_data['page_head_area_toggle'] = $ioa_meta_data['page_footer_area_toggle'] =  $ioa_meta_data['page_footer_b_area_toggle'] = 'no';

		if(isset($ioa_options['page_layout'])) $page_layout= $ioa_options['page_layout'];
		if(isset($ioa_options['page_sidebar'])) $page_sidebar= $ioa_options['page_sidebar'];
		if(isset($ioa_options['show_title'])) $ioa_meta_data['show_title'] = $ioa_options['show_title']; 
		if(isset($ioa_options['page_scheme'])) $ioa_meta_data['page_scheme'] = $ioa_options['page_scheme']; 
		if(isset($ioa_options['page_head_layout'])) $ioa_meta_data['page_head_layout'] = $ioa_options['page_head_layout']; 
		if(isset($ioa_options['page_head_area_toggle'])) $ioa_meta_data['page_head_area_toggle'] = $ioa_options['page_head_area_toggle']; 
		if(isset($ioa_options['page_breadcrumb_toggle'])) $ioa_meta_data['page_breadcrumb_toggle'] = $ioa_options['page_breadcrumb_toggle']; 
		if(isset($ioa_options['page_footer_area_toggle'])) $ioa_meta_data['page_footer_area_toggle'] = $ioa_options['page_footer_area_toggle']; 
		if(isset($ioa_options['page_footer_b_area_toggle'])) $ioa_meta_data['page_footer_b_area_toggle'] = $ioa_options['page_footer_b_area_toggle']; 

		$ioa_meta_data['rad_data'] = get_post_meta($post->ID,"rad_data",true);	
		if( get_post_meta( $post->ID, '_style_keys', true ) == "" && !is_array($ioa_meta_data['rad_data']))	 
		 {
		 	$ioa_meta_data['rad_data'] =json_decode(stripslashes(base64_decode($ioa_meta_data['rad_data'])),true);
		 }
		 
		if($page_layout=="") { 

			if(isset( $ioa_super_options[SN.'_page_layout']) && $ioa_super_options[SN.'_page_layout']!="" )
				 $page_layout = $ioa_super_options[SN.'_page_layout'];
			else 
				 $page_layout = 'full';

			if($post->post_type=="post")
			{
				if( isset( $ioa_super_options[SN.'_post_layout']) && $ioa_super_options[SN.'_post_layout']!="" )
					$page_layout = $ioa_super_options[SN.'_post_layout'];
				else 
					$page_layout = 'right-sidebar';

			} 
				
		}
		
		

		$ioa_meta_data['layout'] = $page_layout;
		$ioa_meta_data['sidebar'] = $page_sidebar;
		if(isset($ioa_options['ioa_template_mode'])) $ioa_meta_data['template_type'] = $ioa_options['ioa_template_mode'];
		else $ioa_meta_data['template_type'] =  'wp-editor';

		if( (function_exists('is_bbpress') && is_bbpress()) )
			{
				$ioa_meta_data['layout'] ="right-sidebar";
				$ioa_meta_data['sidebar']  = $ioa_super_options[SN.'_bbpress_sidebar'];
			
			}


		$ioa_meta_data['width'] = $ioa_layout['content_width'];
		
		$ioa_meta_data['height'] = 	$ioa_meta_data['adaptive_height'] = '';

		if(isset($ioa_options['featured_media_height'])) $ioa_meta_data['height'] = $ioa_options['featured_media_height'];
		if(isset($ioa_options['adaptive_height'])) $ioa_meta_data['adaptive_height'] = $ioa_options['adaptive_height'];
		
		if($ioa_meta_data['height']=="") $ioa_meta_data['height'] = $ioa_layout['media_height'];
		
		$ioa_meta_data['featured_media_type'] = $ioa_meta_data['layered_media_type'] = $ioa_meta_data['klayered_media_type'] = '';

		if(isset($ioa_options['featured_media_type'])) $ioa_meta_data['featured_media_type'] = $ioa_options['featured_media_type'];
		if(isset($ioa_options['layered_media_type'])) $ioa_meta_data['layered_media_type'] = $ioa_options['layered_media_type'];
		if(isset($ioa_options['klayered_media_type'])) $ioa_meta_data['klayered_media_type'] = $ioa_options['klayered_media_type'];



		if($ioa_meta_data['featured_media_type'] == "") 
		{
			$ioa_meta_data['featured_media_type'] = "image";
			if($post->post_type=='page') $ioa_meta_data['featured_media_type'] = "none";
			if($post->post_type=='product') $ioa_meta_data['featured_media_type'] = "product_gallery";
		}

		$ioa_meta_data['background_image'] = $ioa_meta_data['featured_video'] = '';

		if(isset($ioa_options['background_image'])) $ioa_meta_data['background_image'] = $ioa_options['background_image'];
		if(isset($ioa_options['featured_video'])) $ioa_meta_data['featured_video'] = $ioa_options['featured_video'];

		if($ioa_meta_data['layout']=="left-sidebar" || $ioa_meta_data['layout'] == "right-sidebar" )
		{
			$ioa_meta_data['width'] = $ioa_layout['sidebar_content_width'];
			
		}

		$ioa_meta_data['single_portfolio_template']  =  $ioa_meta_data['ioa_custom_template'] =  '';

		if(isset($ioa_options['single_portfolio_template']))  $ioa_meta_data['single_portfolio_template']  =  $ioa_options['single_portfolio_template'];
		if(isset($ioa_options['ioa_custom_template']))  $ioa_meta_data['ioa_custom_template'] = $ioa_options['ioa_custom_template'];
		
	
		
		
	}

	function getHover($opts = array( 'format' => 'default' ))
	{
		global $post,$ioa_super_options;

		$id = '' ;
		$link = '';
		$image = '';
		if(isset($opts['id']))
		{
			$id = $opts['id'];
			$link = get_permalink($id);
		}

		if(isset($opts['custom_link'])) $link = $opts['custom_link'];
		if(isset($opts['image'])) $image = $opts['image'];

		?><div class="hover-overlay"><?php

		switch($opts['format'])
		{
			case 'auto' : ?>
				
				<div class="masonry-hover-style">
					<h4><?php echo get_the_title($id); ?></h4>
					<ul class="hover-icons clearfix">
						<li><a href="<?php echo $link ?>" class='ioa-front-icon hover-link link-3icon-'></a></li>
						<li><a href="<?php echo $image ?>" class='ioa-front-icon hover-image  resize-full-2icon-' data-rel='prettyphoto[pp_gal]' <?php if(isset($opts['title'])) echo 'title="'.$opts['title'].'"' ?>></a></li>
					</ul>
				</div>	

			<?php break;
			case 'image' : $cl = ''; if(isset($opts['useLightboxClass']) && $opts['useLightboxClass']) $cl = 'lightbox'; ?>
				
				<div class="masonry-hover-style">
					<ul class="hover-icons clearfix single-icon">
						<li><a href="<?php echo $image ?>" class='ioa-front-icon hover-image <?php echo $cl; ?> resize-full-2icon-' data-rel='prettyphoto[pp_gal]' <?php if(isset($opts['title'])) echo 'title="'.$opts['title'].'"' ?> ></a></li>
					</ul>
				</div>	
				<?php
			break;
			case 'link' : ?>
				
				<div class="masonry-hover-style">
					<ul class="hover-icons clearfix single-icon">
						<li><a href="<?php echo $link ?>" class='ioa-front-icon hover-link link-3icon-'></a></li>
					</ul>
				</div>	
				<?php
			break;
			case 'video' : ?>
				
				<div class="masonry-hover-style">
					<ul class="hover-icons clearfix single-icon">
						<li><a href="<?php echo $link ?>" data-rel='prettyphoto[pp_gal]' class='ioa-front-icon hover-link video-2icon-'></a></li>
					</ul>
				</div>	
				<?php
			break;
			case 'hosted_video' : $id = uniqid('vid'); ?>
				
				<div class="masonry-hover-style">
					<ul class="hover-icons clearfix single-icon">
						<li><a href="#<?php echo $id; ?>" data-rel='prettyphoto[pp_gal]' class='ioa-front-icon self-host-trigger hover-link video-2icon-'></a></li>
					</ul>
				</div>	
				  <div class="hide">
							
							<div class="lightbox-vid"  id='<?php echo $id; ?>'>
						   		<video poster="" width="600" height="275"  id="<?php echo uniqid('vs') ?>" src="<?php echo $link ?>" >
						   			<!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
						   	 	<source type="video/mp4" src="<?php echo $link ?>"/>
						    		<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
						    		<object width="600" height="275" type="application/x-shockwave-flash" data="<?php echo includes_url().'js/mediaelement/' ?>flashmediaelement.swf">
						        		<param name="movie" value="<?php echo includes_url().'js/mediaelement/' ?>flashmediaelement.swf" />
						        		<param name="flashvars" value="controls=false&amp;file=<?php echo $link ?>"/>
						    		</object>
								</video>
							</div>

				  </div>
				<?php
			break;	
			case 'compact' : ?>
				
				<div class="masonry-hover-style compact-style">
					<ul class="hover-icons clearfix single-icon">
						<li><a href="<?php echo $link ?>" class='ioa-front-icon hover-link link-3icon-'></a></li>
					</ul>
				</div>	
				<?php
			break;	
			case 'icons' : ?>
				
				<div class="masonry-hover-style">
					<ul class="hover-icons clearfix icons-only">
						<li><a href="<?php echo $link ?>" class='ioa-front-icon hover-link link-3icon-'></a></li>
						<li><a href="<?php echo $image ?>" class='ioa-front-icon hover-image  resize-full-2icon-' data-rel='prettyphoto[pp_gal]' <?php if(isset($opts['title'])) echo 'title="'.$opts['title'].'"' ?>></a></li>
					</ul>
				</div>	

			<?php break;
			case 'masonry' : ?>
				
				<div class="masonry-hover-style">
					<h4><?php echo get_the_title($id); ?></h4>
					<ul class="hover-icons clearfix">
						<li><a href="<?php echo  $link ?>" class='ioa-front-icon hover-link link-3icon-'></a></li>
						<li><a href="<?php echo $image ?>" class='ioa-front-icon hover-image  resize-full-2icon-' rel='prettyphoto[pp_gal]' <?php if(isset($opts['title'])) echo 'title="'.$opts['title'].'"' ?>></a></li>
					</ul>
				</div>	

			<?php break;

		}
		
		?> </div> <?php
		
	}

	function getHelperDisplay($id)
	{
		$format_type = get_post_format($id);
		$code = '';

		  switch ($format_type) {
			    case 'image': $code = ' <i class="ioa-front-icon picture-1icon- helper-display-icon"></i>  ';  break;
			    case 'gallery':  $code = ' <i class="ioa-front-icon camera-2icon- helper-display-icon"></i>  ';  break;  
			    case 'link':  $code = ' <i class="ioa-front-icon link-2icon- helper-display-icon"></i>  ';  break;
			    case 'video':  $code = ' <i class="ioa-front-icon videocam-1icon- helper-display-icon"></i>  '; break;  
			    case 'audio':  $code = ' <i class="ioa-front-icon music-2icon- helper-display-icon"></i>  ';  break;  
			    case 'chat':  $code = ' <i class="ioa-front-icon  chat-2icon- helper-display-icon"></i>  ';  break;  
			    case 'status':  $code = ' <i class="ioa-front-icon comment-3icon- helper-display-icon"></i>  ';  break;  
			    case 'quote':  $code = ' <i class="ioa-front-icon quote-left-1icon- helper-display-icon"></i>  ';  break;  
			    default: $code = ' <i class="ioa-front-icon pencil-2icon- helper-display-icon"></i>  ';

			}

		echo $code;	

	}


	function getBlogParameters($id = false)
	{
		global $ioa_meta_data,$post,$ioa_super_options;

		$ioa_meta_data['blog_props'] = array();

		$property_keys = array( '_blog_excerpt' , '_posts_excerpt_limit' , '_enable_thumbnail' , '_more_label' , '_posts_item_limit' , '_blog_meta_enable' , '_blog_meta' , '_bt_height' );

		$override = 'false';
		$ioa_options = array( 'blog_override' => "false" );

		if(is_page()) :

		if($id) $post_id = $id;
		else $post_id = $post->ID;

		$ioa_options = get_post_meta( $post_id, 'ioa_options',true);
		
		endif;



		foreach ($property_keys as $key => $value) {
			if($ioa_options['blog_override']=="false")
				$ioa_meta_data['blog_props'][$value] = $ioa_super_options[SN.$value];
			else
				$ioa_meta_data['blog_props'][$value] = $ioa_options[$value];
		}


		$query_s =  '';
		$ioa_meta_data['blog_props']['query_filter'] = array();

		if(isset($ioa_options['query_filter']) && $ioa_options['query_filter']!="")  $query_s =  $ioa_options['query_filter'];

		if($query_s!="")
		{
			$gen = array();
			$query_s = explode("&",$query_s);
			foreach ($query_s as  $para) {
				$p = explode("=", $para); 

				if($para!="") $gen[$p[0]] = $p[1];		
				
			}

			$ioa_meta_data['blog_props']['query_filter'] = $gen;
		}

		if(count($ioa_meta_data['blog_props']['query_filter']) == 0)
		{
			$ioa_meta_data['blog_props']['query_filter'] = array( 'orderby' => 'date' , 'order' => "DESC" );
		}


	}


	function getPortfolioParameters($id = false)
	{
		global $ioa_meta_data,$post,$ioa_super_options;

		$ioa_meta_data['portfolio_props'] = array();

		$property_keys = array( '_portfolio_excerpt' , '_portfolio_excerpt_limit' , '_portfolio_enable_thumbnail' , '_portfolio_more_label' , '_portfolio_item_limit' , '_p_height' );

		$override = 'false';

		
		if($id) $post_id = $id;
		else $post_id = $post->ID;

		$ioa_options = get_post_meta( $post_id, 'ioa_options',true);


		foreach ($property_keys as $key => $value) {

			if(! isset($ioa_options['portfolio_override']) ) $ioa_meta_data['portfolio_props'][$value] = $ioa_super_options[SN.$value];
			else if( $ioa_options['portfolio_override']=="false")
				$ioa_meta_data['portfolio_props'][$value] = $ioa_super_options[SN.$value];
			else
				$ioa_meta_data['portfolio_props'][$value] = $ioa_options[$value];
		}


		$query_s =  '';
		$ioa_meta_data['portfolio_props']['query_filter'] = array();

		if(isset($ioa_options['portfolio_override']) && $ioa_options['portfolio_override']=="true")
			$ioa_meta_data['portfolio_props']['portfolio_image_resize'] = $ioa_options['portfolio_image_resize'];
		else 
			$ioa_meta_data['portfolio_props']['portfolio_image_resize'] = 'default';

		$ioa_meta_data['portfolio_props']['portfolio_cols'] = 'default';
		if(isset($ioa_options['portfolio_cols']))$ioa_meta_data['portfolio_props']['portfolio_cols'] =  $ioa_options['portfolio_cols'];
		

		if(isset($ioa_options['portfolio_query_filter']) && $ioa_options['portfolio_query_filter']!="")  $query_s =  $ioa_options['portfolio_query_filter'];

		if($query_s!="")
		{
			$gen = array(); $custom_tax = array();
			$query_s = explode("&",$query_s);
			foreach ($query_s as  $para) {
				$p = explode("=", $para); 

					
				if($p[0]=="tax_query")
		        {
		        	$vals = explode("|",$p[1]); 	
		        	$custom_tax[] = array(
		        			'taxonomy' => $vals[0],
							'field' => 'id',
							'terms' => explode(",", $vals[1])

		        		);
		        }
		        else if($para!="") $gen[$p[0]] = $p[1];	
				
			}
			$gen["tax_query"] = $custom_tax;
			$ioa_meta_data['portfolio_props']['query_filter'] = $gen;
		}

		if(count($ioa_meta_data['portfolio_props']['query_filter']) == 0)
		{
			$ioa_meta_data['portfolio_props']['query_filter'] = array( 'orderby' => 'date' , 'order' => "DESC" );
		}


	}


	function getProductParameters($id = false)
	{
		global $ioa_meta_data,$post,$ioa_super_options;

		$ioa_meta_data['product_props'] = array();

		$property_keys = array(  '_product_item_limit' , '_pr_height' );

		$override = 'false';

		
		if($id) $post_id = $id;
		else $post_id = $post->ID;

		$ioa_options = get_post_meta( $post_id, 'ioa_options',true);


		foreach ($property_keys as $key => $value) {
				$ioa_meta_data['product_props'][$value] = $ioa_options[$value];
		}


		$query_s =  '';
		$ioa_meta_data['product_props']['query_filter'] = array();

		$ioa_meta_data['product_props']['product_image_resize'] = $ioa_options['product_image_resize'];

		

		if(isset($ioa_options['product_query_filter']) && $ioa_options['product_query_filter']!="")  $query_s =  $ioa_options['product_query_filter'];

		if($query_s!="")
		{
			$gen = array(); $custom_tax = array();
			$query_s = explode("&",$query_s);
			foreach ($query_s as  $para) {
				$p = explode("=", $para); 

					
				if($p[0]=="tax_query")
		        {
		        	$vals = explode("|",$p[1]); 	
		        	$custom_tax[] = array(
		        			'taxonomy' => $vals[0],
							'field' => 'id',
							'terms' => explode(",", $vals[1])

		        		);
		        }
		        else if($para!="") $gen[$p[0]] = $p[1];	
				
			}
			$gen["tax_query"] = $custom_tax;
			$ioa_meta_data['product_props']['query_filter'] = $gen;
		}

		if(count($ioa_meta_data['product_props']['query_filter']) == 0)
		{
			$ioa_meta_data['product_props']['query_filter'] = array( 'orderby' => 'date' , 'order' => "DESC" );
		}


	}
   
   function getRating($val)
   {
   	$r = intval($val);
		$code ='' ;
		for($i=0;$i<5;$i++)
		{
			if($i < $r)
				$code .= '<li><i class="ioa-front-icon star-2icon- rated"></i></li>';
			else		
				$code .= '<li><i class="ioa-front-icon star-2icon- inactive"></i></li>';
		}
		return '<ul class="rating-bar clearfix">'.$code.'</ul>';
   }	

   // == Custom Posts =====================

	function customPosts()
	{
		global $ioa_registered_posts,$ioa_portfolio_taxonomy_label,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$ioa_portfolio_name ;
		


	  $ioa_registered_posts["testimonial"] = new IOACustomPost("testimonial",array(),"", __("Testimonials", 'ioa'));	
	  $ioa_registered_posts[$ioa_portfolio_slug] = new IOACustomPost($ioa_portfolio_slug,array(),$ioa_portfolio_taxonomy_label,"$ioa_portfolio_name Items");	
	  $ioa_registered_posts["slider"] = new IOACustomPost("slider",array( 
	   				  'publicly_queryable' => false,
					  'show_ui' => false,
					  'exclude_from_search' => true,
					  'show_in_nav_menus' => false
					   ),"Slider Categories","Slider Items");
		$ioa_registered_posts["custompost"] =new IOACustomPost("custompost",array( 
	   				  'publicly_queryable' => false,
					  'show_ui' => false,
					  'exclude_from_search' => true,
					  'show_in_nav_menus' => false
					   ),"Categories","Custom Post Types");	
			
			
		

		$stack_custom = array();

		$custom_query = get_posts( array( "post_type" => "custompost" , "posts_per_page" => -1 ,  
			'cache_results' => false , 
			'no_found_rows' => true,
    		'update_post_term_cache' => false,
    		'update_post_meta_cache' => false,
    		'post_status' => 'publish'
			));  
	
		foreach( $custom_query as $post ) :  
			
			$metaboxes = get_post_meta($post->ID,'metaboxes',true);
			$coptions = get_post_meta($post->ID,'options',true);
			$post_type = str_replace(" ","_",strtolower(trim(get_the_Title($post->ID))));
			$opts = $this->getAssocMap($coptions,"value",true);
			
			$stack_custom[] = array ($metaboxes,$opts,$post_type);		
			
		endforeach;

		foreach ($stack_custom as $fs ) {
			$refine_meta = array();
			$tax ='' ;
			if(isset($fs[1]["taxonomies"]) && $fs[1]["taxonomies"]!="") $tax = $fs[1]["taxonomies"];	
			$ioa_registered_posts[$fs[2]] = new IOACustomPost($fs[2], array( 'labels' => $fs[1] ),$tax,"".ucwords($fs[2])." Items");	

			if( is_array($fs[0] ))
			{
				foreach ($fs[0] as  $metabox) {
					$temp = $this->getAssocMap($metabox,"value");
					$refine_meta[] = array(	"label" => $temp["meta_name"] , "name" => str_replace(" ","_",strtolower(trim($temp["meta_name"]))) , 	"default" => $temp["default"] , "type" =>  $temp["type"],	"description" => "" , "color"  =>  $temp["title_color"]);
				}

				new IOAMetaBox(array(
					"id" => "IOA_custom_values",
					"title" => __("Custom Fields", 'ioa'),
					"inputs" => $refine_meta,
					"post_type" => $fs[2],
					"context" => "advanced",
					"priority" => "low"
				));

			}
		}

	}

   
  function getLayoutValue($str)
  {
  		global $ioa_layout,$ioa_meta_data;
  		$v = trim($str);

  		if( $ioa_meta_data['layout'] == 'full') :
	  		switch($v)
	  		{
	  			case 'one_half' : $v = $ioa_layout['cols']['one_half']; break;
	  			case 'one_third' : $v = $ioa_layout['cols']['one_third']; break;
	  			case 'one_fourth' : $v = $ioa_layout['cols']['one_fourth']; break;
	  			case 'one_fifth' : $v = $ioa_layout['cols']['one_fifth']; break;
	  			case 'two_third' : $v = $ioa_layout['cols']['two_third']; break;
	  			case 'three_fourth' : $v = $ioa_layout['cols']['three_fourth']; break;
	  			case 'four_fifth' : $v = $ioa_layout['cols']['four_fifth']; break;

	  			default : $v = $ioa_layout['cols']['full'];
	  		}
  		else :
  			switch($v)
	  		{
	  			case 'one_half' : $v = $ioa_layout['sidebar_cols']['one_half']; break;
	  			case 'one_third' : $v = $ioa_layout['sidebar_cols']['one_third']; break;
	  			case 'one_fourth' : $v = $ioa_layout['sidebar_cols']['one_fourth']; break;
	  			case 'one_fifth' : $v = $ioa_layout['sidebar_cols']['one_fifth']; break;
	  			case 'two_third' : $v = $ioa_layout['sidebar_cols']['two_third']; break;
	  			case 'three_fourth' : $v = $ioa_layout['sidebar_cols']['three_fourth']; break;
	  			case 'four_fifth' : $v = $ioa_layout['sidebar_cols']['four_fifth']; break;

	  			default : $v = $ioa_layout['sidebar_cols']['full'];
	  		}

  		endif;	

  		return $v;
  }	

  function initSidebars()
  {

  	$sidebars = array();

    $sidebars[] = array(
  		'name' => 'Blog Sidebar',
  		'id' => 'blog_sidebar',
  		'description' => __('This is the default sidebar for the theme', 'ioa'),
  		'before_widget' => '<div class="sidebar-wrap widget %2$s clearfix">',
  		'after_widget' => '</div>',
  		'before_title' => '<h3 class="custom-font heading"><span class="widget-title">',
  		'after_title' => '</span><span class="w-h-line"></span></h3>'
	);

	
	$sidebars[] = array(
	  'name' =>  "Footer Mobile",
	  'id' => 'footer_mobile',
	  'description' => __('Widgets will be shown in the Footer for Mobile Devices.', 'ioa'),
	  'before_widget' => '<div class="footer-wrap widget %2$s clearfix">',
	  'after_widget' => '</div>',
	  'before_title' => '<h3 class="custom-font footer-heading">',
	  'after_title' => '</h3>'
	);
	
	
	
	
	if(function_exists('register_sidebar')){
		
		foreach($sidebars as $sidebar)
		register_sidebar($sidebar);
	
	} 
	
	 $this->registerDynamicFooter();

	  global $ioa_super_options;
	  $dynamic_active_sidebars = array();
	  
	 if( isset($ioa_super_options[SN."_custom_sidebars"]) ) 
	  $dynamic_active_sidebars = explode(',',$ioa_super_options[SN."_custom_sidebars"]);
	 
      
	  if( count($dynamic_active_sidebars ) >0 )
	  foreach($dynamic_active_sidebars as  $widget)
	  {
	  	if( $widget!="") {
		 $tid = strtolower ( str_replace(" ","_",trim($widget)) );
		 $temp_widget = array(
		
		'name' => $widget,
		'description' => __('This is a dynamic sidebar','ioa'),
		'before_widget' => '<div class="dynamic-wrap widget %2$s sidebar-wrap clearfix">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="custom-font heading"><span class="widget-title">',
  		'after_title' => '</span><span class="w-h-line"></span></h3>',
		'id' => 'sidebar_'.$tid
		);
	  register_sidebar($temp_widget);
	}
	  }
	  
  
  }
  
  // == Dynamic Footer =================================
  
	 
	 function registerDynamicFooter() {
		 
		 $footer_layout = get_option(SN."_footer_layout");
		
		 $count = 4;
		 switch($footer_layout)
		 {
			 case "two-col" : $count = 2 ; break;
			 case "three-col" : $count = 3 ; break;
			 case "four-col" : $count = 4 ; break;
			 case "five-col" : $count = 5 ; break;
			 case "six-col" : $count = 6 ; break;
			 case "one-third" : $count = 2 ; break;
			 case "one-fourth" : $count = 2 ; break;
			 case "one-fifth" : $count = 2 ; break;
			 case "one-sixth" : $count = 2 ; break;
			 default :  $count = 4;

		 }
		 
		for($i=1;$i<=$count;$i++)
		 {
		   $sidebar = array(
						'name' => ("Footer Column $i"),
						'id' => "footer_column_".$i ,
						'description' => __('Widgets will be shown in the footer.', 'ioa'),
						'before_widget' => '<div class="footer-wrap  %2$s clearfix">',
						'after_widget' => '</div>',
						'before_title' => '<h3 class="custom-font footer-heading">',
						'after_title' => '</h3>',
					  );	 
           
		   register_sidebar($sidebar);
		   
		 }
   }



   	public function breadcrumbs()
	{
		global $ioa_super_options,$ioa_portfolio_slug;
	 $delimiter = $ioa_super_options[SN."_breadcrumb_delimiter"];
 	 $portfolio_parent_link = $ioa_super_options[SN.'_portfolio_parent_link'];
 	 $blog_parent_link = $ioa_super_options[SN.'_blog_parent_link'];

 	 $blog_label = $ioa_super_options[SN.'_blog_label'];
 	 $portfolio_label = $ioa_super_options[SN.'_portfolio_blabel'];


			$name =  $ioa_super_options[SN."_breadcrumb_home_label"]; // text for the 'Home' link
			$currentBefore = ' <span class="current">';
			$currentAfter = '</span> ';
			$type=get_post_type();
			
			if(IOA_WOO_EXISTS && is_woocommerce()) {

				echo '<div id="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';	
				woocommerce_breadcrumb();
				echo '</div>';
			}
			else if( (function_exists('is_bbpress') && is_bbpress()) )
			{
				echo '<div id="breadcrumbs" class="clearfix"  itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';	
				bbp_breadcrumb(); 
				echo '</div>';
			}
			elseif (!is_home() && !is_front_page() && get_post_type() == $type || is_paged()) {

				echo '<div id="breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
				global $post;
				$home = home_url();
				echo '<a href="' . $home . '"  itemprop="url"><span itemprop="title">' . $name . '</span></a> ' . $delimiter . ' ';
				if (is_category()) {
					global $wp_query;
					$cat_obj = $wp_query->get_queried_object();
					$thisCat = $cat_obj->term_id;
					$thisCat = get_category($thisCat);
					$parentCat = get_category($thisCat->parent);
					if ($thisCat->parent != 0) {
						echo(get_category_parents($parentCat, true, '' . $delimiter . ''));
					}
					echo $currentBefore . single_cat_title() . $currentAfter;
				}
				else if(is_tax())
				{
					echo $currentBefore . single_term_title() . $currentAfter;
				}
				else if (is_day()) {
					echo '<a href="' . get_year_link(get_the_time('Y')) . '"  itemprop="url"><span itemprop="title">' . get_the_time('Y') . '</span></a> ' . $delimiter . '';
					echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '"  itemprop="url"><span itemprop="title">' . get_the_time('F') . '</span></a> ' . $delimiter . ' ';
					echo $currentBefore . get_the_time('d') . $currentAfter;
				} else if (is_month()) {
					echo '<a href="' . get_year_link(get_the_time('Y')) . '"  itemprop="url"><span itemprop="title">' . get_the_time('Y') . '</span></a> ' . $delimiter . '';
					echo $currentBefore . get_the_time('F') . $currentAfter;
				} else if (is_year()) {
					echo $currentBefore . get_the_time('Y') . $currentAfter;
				} else if (is_attachment()) {
					echo $currentBefore;
					the_title();
					$currentAfter;
				} if (is_single()  ){
					$cat = null;
					if($post->post_type=="post") {	

						if(trim($blog_parent_link)!="")
						{
							echo "<a href='". $blog_parent_link ."'  itemprop='url'><span itemprop=\"title\">".$blog_label."</span></a> ". $delimiter . ' ';
						}	
						else
						{
							$cat = get_the_category();
							$cat = $cat[0];
							if ($cat !==NULL) {
								echo get_category_parents($cat, true, ' ' . $delimiter . '');
							}

						}
					
					}
					else if($post->post_type==$ioa_portfolio_slug && $portfolio_parent_link!="")
					{
						echo "<a href='". $portfolio_parent_link ."'  itemprop='url'><span itemprop=\"title\">".$portfolio_label."</span></a> ". $delimiter . ' ';
					
					}
					else
					{
						
						
					$taxonomies = get_object_taxonomies($post, 'names');

					if(count($taxonomies) > 0) :
						$cats =   get_the_terms($post->ID,$taxonomies[0]); 
						$cat = false; $i=0; 
						
						if($cats)
						foreach ($cats as $c) {
							 if($i==0)
							 {
							 	$cat = $c; $i++;
							 }
							 else break;
						}

						if ($cat !==NULL && $cat!="" && $cat->parent > 0 ) {
							
							echo get_category_parents($cat, true, ' ' . $delimiter . '');
						}
						else if($cat !==NULL && $cat!="")
							echo  ''.$cat->name.' '.$delimiter ;


					endif;


					}

					

					echo $currentBefore;
					the_title();
					echo $currentAfter;


				}
				else if (is_page() && !$post->post_parent) {
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_page() && $post->post_parent) {
					$parent_id = $post->post_parent;
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '"  itemprop="url"><span itemprop="title">' . get_the_title($page->ID) . '</span></a>';
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					foreach($breadcrumbs as $crumb)
					echo $crumb . ' ' . $delimiter . ' ';
					echo $currentBefore;
					the_title();
					echo $currentAfter;
				} else if (is_search()) {
					echo $currentBefore . __('Search Results For:','ioa') . ' ' . get_search_query() . $currentAfter;
				} else if (is_tag()) {
					echo $currentBefore . single_tag_title() . $currentAfter;
				} else if (is_author()) {
					global $author;
					$userdata = get_userdata($author);
					echo $currentBefore . $userdata->display_name . $currentAfter;
				} else if (is_404()) {
					echo $currentBefore . __('404 Not Found', 'ioa') . $currentAfter;
				}
				if (get_query_var('paged')) {
					if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
						echo  $currentBefore;
					}
					echo __('Page','ioa') . ' ' . get_query_var('paged');
					if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
						echo $currentAfter;
					}
				}
				echo '</div>';
			}
		}


	 /**
	  *  Function to register external scripts for framework.
	  */
   
   

   public function registerScripts()
	{
		
		if( IOA_WOO_EXISTS  )
		add_action( 'wp_enqueue_scripts', 'fc_remove_woo_lightbox', 99 );
		function fc_remove_woo_lightbox() {
		    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		        wp_dequeue_script( 'prettyPhoto' );
		        wp_dequeue_script( 'prettyPhoto-init' );
		}


		add_action('wp_enqueue_scripts','addThemeScripts');	

		function addThemeScripts() { 
			global $ioa_super_options, $ioa_meta_data;

			if(is_login_page() ) return;
			
			// Core Files Must be loaded in every scenarioa	

			// Skin Selector
			$data = get_option(SN.'_enigma_data');
			$current_skin = 'default';
			$woo_skin = URL.'/sprites/stylesheets/woocommerce.css';
			if(isset($data['skin']) && is_array($data)) $current_skin = $data['skin'];
				$skin = CHURL.'/style.css';
			
			if(isset($_GET['vskin'])) 
			{
				$current_skin = $_GET['vskin'];

				
					if($current_skin=="dark")
						$_SESSION['vscheme'] = 'purpled';
					else
						$_SESSION['vscheme'] = 'purpleye'; 
				

				$_SESSION['vskin']	= $_GET['vskin'];
			}
			if(isset($_SESSION['vskin'])) 
			{
				$current_skin = $_SESSION['vskin'];
			}	

			if($current_skin!="default") 
			{
				$skin = CHURL.'/sprites/skins/'.$current_skin.'/style.css';
				$woo_skin =CHURL.'/sprites/skins/'.$current_skin.'/woocommerce.css';
			}	

			wp_enqueue_style('base',URL.'/sprites/stylesheets/base.css');
			wp_enqueue_style('layout',URL.'/sprites/stylesheets/layout.css');
			wp_enqueue_style('style',$skin);
			
			
				wp_enqueue_style('forums',URL.'/sprites/stylesheets/forums.css');

			if(!isset($ioa_meta_data['page_scheme'])) $ioa_meta_data['page_scheme'] = 'none';				


			// Scripts
			
			if(IOA_WOO_EXISTS )
				wp_enqueue_style('ioa-woocom',$woo_skin);
			
			if($ioa_meta_data['page_scheme']=="none"   )
			{
				  wp_enqueue_style('runtime-css', admin_url('admin-ajax.php?action=ioalistener&type=runtime_css'), array() );
			}	
			

				
			if($ioa_super_options[SN.'_mobile_view']!="false")
				wp_enqueue_style('responsive',URL.'/sprites/stylesheets/responsive.css');	

			wp_enqueue_script('jquery',false,array(),false,true);
			wp_enqueue_script('jquery-ui-tabs',array('jquery'),false,true);
			wp_enqueue_script('jquery-ui-accordion',array(),false,true);
			
			if(! function_exists('lsSliders'))
			wp_enqueue_script('jquery-transit',URL.'/sprites/js/jquery.transit.js',array(),false,true);
				
			wp_enqueue_script('jquery-selene',URL.'/sprites/js/jquery.selene.js',array(),false,true);
			wp_enqueue_script('jquery-quartz',URL.'/sprites/js/jquery.quartz.js',array(),false,true);
			wp_enqueue_script('jquery-bxslider',URL.'/sprites/js/jquery.bxslider.js',array(),false,true);
			wp_enqueue_script('jquery-isotope',URL.'/sprites/js/jquery.isotope.js',array(),false,true);
			wp_enqueue_script('jquery-prettyphoto',URL.'/sprites/js/jquery.prettyPhoto.js',array(),false,true);
			wp_enqueue_script('wp-mediaelement',false,array(),false,true);
			wp_enqueue_script('jquery-idangerous',URL.'/sprites/js/idangerous.swiper-2.1.js',array(),false,true);
			wp_enqueue_script('jquery-idangerous-scrollable',URL.'/sprites/js/idangerous.swiper.scrollbar-2.1.js',array(),false,true);
			wp_enqueue_script('ext-js',URL.'/sprites/js/ext.js',array(),false,true);
			
			wp_enqueue_script('custom',URL.'/sprites/js/custom.js',array('jquery','ext-js'),false,true);

			$translation_array = array( 

					'rad_ajax_loading' => __("Loading",'ioa'),
					'no_posts' => __("No More Posts",'ioa'),
					'load_more' => __("Load More",'ioa'),
					'search_placeholder' => __('Type something..','ioa'),
					'search_placeholder' => __('Type something..','ioa'),

			  );
   			wp_localize_script( 'custom', 'ioa_localize', $translation_array );


			if(isset($ioa_super_options[SN.'_uc_mode']) && $ioa_super_options[SN.'_uc_mode']=="true" && ! current_user_can('delete_pages') )
			{
					wp_enqueue_script('jquery-uc', URL.'/sprites/js/uc.js','jquery',array(),false,true);
					wp_enqueue_style('uc',URL.'/sprites/stylesheets/uc.css');
			} 

			
		}

	 
		 function addAdminScripts() {
			global $pagenow;

			wp_enqueue_script('jquery-ui-slider');
			wp_enqueue_script('jquery-ui-accordion');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-minicolorpicker',HURL.'/js/jquery.minicolors.js');
			wp_enqueue_script('jquery-transit',URL.'/sprites/js/jquery.transit.js');

			if( isset($_GET['page']) &&  $_GET['page'] == "ioaeni"  )
			wp_enqueue_script('cordemirror',URL."/sprites/js/enigma-lib/codemirror-compressed.js");

			if( isset($_GET['page']) &&  $_GET['page'] == "hcons"  )
			{
				wp_enqueue_script('jquery-ui-draggble');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-droppable');
			}
			
			wp_enqueue_script('jquery-global',HURL.'/js/global.js');
			
			if( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) :
				wp_enqueue_style('rad-css',HURL.'/css/rad.css');
				wp_enqueue_script('rad-js',URL.'/sprites/js/rad.js');
			endif;


			wp_enqueue_style('global-css',HURL.'/css/global.css');
			
			$media_import_array = array("ioa","ioamed","ioapty","ioaeni");
			
			if( ( $pagenow == "widgets.php" ) || (  isset($_GET['page']) && in_array($_GET['page'],$media_import_array ) )  )
			wp_enqueue_media();


		
			}
		add_action('admin_enqueue_scripts','addAdminScripts');
			
		
				
	}	
  // == Image Display ======================================
 
 
 public function imageDisplay( $ioa_options )
	{
	  global $ioa_super_options;
	  extract( array_merge(  array( "src" => NULL , "crop"=> 'hard', "height" => 300 , "width" => 600 , "lightbox" => false , 'parent_wrap' => true , "hoverable" => false , "advance_query" => false , "gallery" => 'pp_gal'  , "link" =>'' , "title" => ''  , 'class' => '', 'imageAttr' => '' , 'imgclass' => '' ) ,$ioa_options ) );
	  $o_src =  $src;
		
	 if($src == "") return "";	
	    
	  $rel = '';
	  
	  if($imageAttr=='') $imageAttr=' alt="image" ';
	  if($hoverable)	$hoverable = '<span class="hover-image"> <small></small> </span>';
	  
	  if($lightbox) {  $link = $o_src;  $lightbox = 'rel="prettyPhoto['.$gallery.']"'; } else $lightbox = '';
		
		$cr_img = $this->wp_resize(NULL,$src,$width,$height,$crop);
		
		if(!is_array($cr_img)) $cr_img = array('url' => $o_src , "height" => $height , "width" => $width );	

		if( !isset($cr_img['width']) || $cr_img['width'] == "" ) $cr_img['width'] = $width;
		if( !isset($cr_img['height']) ||  $cr_img['height'] == "" ) $cr_img['height'] = $height;

		$image = "  $hoverable  <img itemprop='image'  $imageAttr class='".$imgclass."' src='".$cr_img['url']."' width='".$cr_img['width']."' height='".$cr_img['height']."'   />";
	
	  if($parent_wrap) $image = "<a href='$link' $lightbox class=' imageholder $class' title='$title'> $image </a>";		 				 
			 
	  return $image;
	}
	
 
 
 // == WP Core resizer ==================
	
	 public function wp_resize($attach_id = null, $img_url = null, $width, $height, $crop = 'hard') {

	  global $blog_id;
	  $src = $img_url;
	  if($img_url=="") return;
	  
	   if ( is_multisite() ) {

		  	$image = $img_url;
		 
			$current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
		 	$site = $current_blog_details->siteurl;
		 	$master = $current_blog_details->domain;
		    $image = str_replace($site,$master,$image);
		    
		    if(is_ssl()) $image = 'https://'.$image; else $image = 'http://'.$image;

		     $src =  $image;
		
	 }	
    
    if($src){

        $file_path = parse_url($src);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

        $orig_size = @getimagesize($file_path);

        $image_src[0] = $img_url;
        $image_src[1] = $orig_size[0];
        $image_src[2] = $orig_size[1];
    }
 
    if(!isset($file_path) || $file_path== "")
    {
    	return $vt_image = array (
            'url' => $img_url,
            'width' => $orig_size[0],
            'height' => $orig_size[1]
        );


    }

    if( $height > $orig_size[1] )
    {
    	return $vt_image = array (
            'url' => $img_url,
            'width' => $orig_size[0],
            'height' => $orig_size[1]
        );


    }
  
    $file_info = pathinfo($file_path);
    $extension = '.'. $file_info['extension'];

    // the image path without the extension
    $no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];


    if($crop=='proportional')
    {
    	$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
    	$width = $proportional_size[0];
    	$height = $proportional_size[1];

    }
    if($crop=='wproportional')
    {
    	
    	
    	$height = intval($image_src[2] * ( $width / $image_src[1] ));

    }
    if($crop=='hproportional')
    {
    	
    	
    	$width = intval($image_src[1] * ( $height / $image_src[2] ));

    }
     if($crop=='wproportional-max')
    {
    	if( $width > $image_src[1]   )
    	$width = $image_src[1];	
    	$height = intval($image_src[2] * ( $width / $image_src[1] ) );
    }

    $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
  	

	if ( file_exists($cropped_img_path) )
	{
		
		$new_img = str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
		
		$vt_image = array (
            'url' => $new_img,
            'width' => $width,
            'height' => $height
        );

        return $vt_image;
	}
   		
	
        // no cache files - let's finally resize it
        $new_img_path = null;
		if(  function_exists('wp_get_image_editor')) {

			$editor = wp_get_image_editor($file_path);

			if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) return $img_url ;

			$resized_file = $editor->save();
              
			
			  
			if(!is_wp_error($resized_file)) {
			 $new_img_path	= $resized_file['path'];
				
			} else {
				return false;
			}

		}
		
        $new_img_size = getimagesize($new_img_path);
        $new_img = str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);

        // resized output
        $vt_image = array (
            'url' => $new_img,
            'width' => $new_img_size[0],
            'height' => $new_img_size[1]
        );

        return $vt_image;
  

}	

 
	public function getShortenContent($charlength , $content) {
	$excerpt = $content;
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		return '...';
	} else {
		return $excerpt;
	}

	$excerpt = $content;
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = $excerpt.'... ';
	return $excerpt;
}

 
  // IOA Query string to Array
  
  public function ioaquery($query_string)
  {

  	$ioa_query = str_replace("&amp;","&", $query_string);
    $qr = explode('&',$ioa_query);
    $custom_tax = array();
    $filter = array();

	 foreach($qr as $q)
	 {
	  if(trim($q)!="")
	  {
	    $temp = explode("=",$q);
	    $filter[$temp[0]] = $temp[1];
	    if($temp[0]=="tax_query")
	    {
	      $vals = explode("|",$temp[1]);  
	      $custom_tax[] = array(
	          'taxonomy' => $vals[0],
	      'field' => 'id',
	      'terms' => explode(",", $vals[1])

	        );
	    }
	  }
	 }

     $custom_tax[] = array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  );
     $filter['tax_query'] = $custom_tax;
     return $filter;

  }	

  // == Register Menus =====================================================	  
	
 public function registerMenus($menus)
	{
		

		  if ( function_exists( 'register_nav_menus' ) ) {
			 
			  register_nav_menus($menus);
		  }
	}

 // == Convert RAD inputs to assoctive Array
 
 function getAssocMap($inputs,$key,$noempty=false)
 {
 	$arr = array();
 	if(is_array($inputs))
 	{
 		foreach($inputs as $input)
		{
			if(isset( $input[$key]))
				{
					if( $noempty)
						{
							if(trim( $input[$key])!="")
							$arr[$input['name']] =   stripslashes($input[$key]);
						}
					else
					{
						if(isset($input['name'])) $arr[$input['name']] =    stripslashes($input[$key]);
					}	
				}
			else
				$arr[$input['name']] =   false;	
		}
 	}
	return $arr;	
 }	
 
 // == Set Post Title ==========================

 function setPostTitle($title,$id)
 {
 	global $wpdb;


   $table_name = $wpdb->prefix . "posts";
   
   $alter_title = "UPDATE  $table_name SET post_title = '{$title}' WHERE ID = {$id} ";
   $wpdb->query($alter_title);
	  
 }

  // == Custom Formatter ======================
   
   public function format($content,$strip_tags = false,$shortcode=true,$p=true,$strip_p=false){
	    $content = 	stripslashes($content);
	    
		if($shortcode) $content = do_shortcode( $content  ); 
	  
	   if($strip_tags) $content = strip_tags($content);
	   if($p) $content =  wptexturize($content); 
	   
	   if($strip_p)
	   {
	   
	   	$content= str_replace('<p>','',$content);
	   	$content= str_replace('</p>','',$content);
	   }			 
	   return $content;
	   
	   }	

// == Pretty Print =========

function prettyPrint($obj)
{
	echo "<pre>";
	print_r($obj);
	echo "</pre>";
}	   
		  
} // End of Class

}

global $ioa_helper;
$ioa_helper = new IOA_Helper();


/**
 * Third Party Functions
 */

function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
} 

function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}


/**
 * Custom Theme Functions for Checking etc
 */

function IOATour()
{
	global $current_user;
	$url="http://support.artillegence.com/";
	?>
	
	<div class="ioa-tour-overlay">
		
		

	</div>

	<div class="ioa-tour-lightbox">
			<a href="" class="close ioa-front-icon cancel-2icon-"></a>
			<div class="ioa-tour-body clearfix">
				<div class="heading-area">
					<h2> <?php printf( __("Hey %s",'ioa'), $current_user->user_login ); ?></h2>
					<p><?php printf( __("This is your first time using %s, Here is a quick guide to set things up. Please be sure to activate the plugins before running the installer else all settings won't be imported !",'ioa') , "<strong>  ".THEMENAME." </strong>" ) ?></p>	
				</div>	
				
				<ul class="ioa-tour-feature-list  clearfix">
					<li class='plugins-panel clearfix'>
						<span class="no">1</span> <?php printf( __("There are certain %1s that have to be activated before running installer and to enjoy full power of <?php echo THEMENAME; ?>. Don't worry you dont need to goto any where to get them.Click the Button below and theme will do it for you",'ioa') , "<strong>".__('plugins','ioa')."</strong>" ); ?>
						<a href="<?php echo admin_url(); ?>themes.php?page=install-required-plugins" class='more-link'><?php _e('Click Here','ioa') ?></a>				
					</li>

					<li class='installer-panel clearfix'>
						<span class="no">2</span> <?php printf( __("If this is a %1s	, you can use Installer to set up website in matter seconds. It will setup the site exactly as demo %2s The images seen on the demo are not included, instead dummy images will be placed.",'ioa'), "<strong>".__('fresh WordPress Installation','ioa')."</strong>" , '<strong>*'.__("excluding",'ioa').'*</strong>' ) ?>
						Once You have <strong>activated the required plugins</strong> goto Theme Admin panel from bottom left , click on Installer Menu on top right on Theme Admin page.
					</li>


				</ul>

			</div>
		</div>
		
	<?php
	update_option(SN.'ioa_tour',true);
}

if(!get_option(SN.'ioa_tour'))
add_action('admin_footer','IOATour');




function register_IOA_template($templates)
{
	global $IOA_templates;

	foreach ($templates as $key => $template) {
		$IOA_templates[$key] = $template;
	}


}


function appendableLink($testlink)
	{
		
		if(strpos($testlink,'?'))
		 return	$testlink .= "&";
			 
		return	$testlink .= "?";
	}


require_once('class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'ioa_activate_preplugins' );

function ioa_activate_preplugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'source'   				=> 'http://downloads.wordpress.org/plugin/contact-form-7.3.7.2.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
		    'name' => 'Revolution WP',
		    'slug' => 'revslider',
		    'source' => HPATH . '/plugins/revslider.zip',
		    'required' => true,
		    'version' => '',
		    'force_activation' => false,
		    'force_deactivation' => false
		)

	);

	// Change this to your theme text domain, used for internationalising strings
	

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'ioa',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Recommended Plugins', 'ioa'),
			'menu_title'                       			=> __( 'Install Plugins', 'ioa'),
			'installing'                       			=> __( 'Installing Plugin: %s', 'ioa'), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'ioa'),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'ioa'),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'ioa'),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'ioa'), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}