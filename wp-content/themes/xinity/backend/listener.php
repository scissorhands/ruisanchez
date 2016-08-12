<?php
/**
 * Listens for all Ajax Queries / Engines
 */


add_action('wp_ajax_nopriv_ioalistener', 'ioalistener');
add_action('wp_ajax_ioalistener', 'ioalistener');


/**
 * Query Maker Engine
 */

function ioalistener() {


global $ioa_sliders,$post,$ioa_super_options, $wpdb,$ioa_helper,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$ioa_meta_data,$ioa_registered_posts;
$type = $_REQUEST["type"]; 
  

if($type=="query_engine") :
	$post_type = $_POST["post_type"];

if($post_type != 'post' && ! isset($ioa_registered_posts[$post_type]) && $post_type !='product' )	$post_type = 'post';



?>

<div class="query_engine">
	<div class="posts-section">
		<?php 

			if($post_type == "post") :

				$categories=  get_categories(); $cats = array(); 
				foreach ($categories as $category) {
				  $cats[$category->slug] =  $category->cat_name;
				 }
				 
				echo getIOAInput( 
							array( 
									"label" => __("Select Category(if none is selected all categories will be included)",'ioa') , 
									"name" => "select_post_cats" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $cats
							) 
						);

				$tags = get_tags(); $t = array();
		        foreach ($tags as $tag) {
		          $t[$tag->term_id] =  $tag->name;
		        }			

        		echo getIOAInput( 
							array( 
									"label" => __("Select Tags(if none is selected all tags will be included)",'ioa') , 
									"name" => "select_post_tags" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $t
							) 
						);
        	else: 
        	 
        	  global $ioa_registered_posts;
				
        		$rax = array();

        		if($post_type !='product')
			 		$tax = $ioa_registered_posts[$post_type]->getTax();
				else 
				 $tax = array('product_cat','product_tag');	

				if($tax)
				foreach ($tax as $t) {
					$ori = $t;
					$te = trim(str_replace(" ","",strtolower(strtolower($t))));	

					$terms = get_terms($te);
					$ta = array();

					foreach ($terms as $term) {
						$ta[$term->term_id] = $term->name;
					}

					?><div class="custom-tax">
						<?php
							echo getIOAInput( 
								array( 
									"label" => "" , 
									"name" => "taxonomy" , 
									"default" => $te , 
									"type" => "hidden",
									
								) 
							);

							echo getIOAInput( 
							array( 
									"label" => __("Select ",'ioa')."$t" , 
									"name" => "term_".$te , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $ta
							) 
						);
						?>
					</div><?php

				}
        		
				


        	endif;	
				$order = 'user_nicename';
				$user_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users ORDER BY $order");
				$all_authors = array();
				
				foreach($user_ids as $user_id) :
					$user = get_userdata($user_id);
					$all_authors[$user_id] = $user->display_name;
				endforeach;

				echo getIOAInput( 
							array( 
									"label" => __("Select Authors",'ioa') , 
									"name" => "select_post_auhtors" , 
									"default" => "" , 
									"type" => "checkbox",
									"description" => "" ,
									"options" => $all_authors
							) 
						);
        		
        		echo getIOAInput( 
							array( 
									"label" => __("Select Order of Posts",'ioa') , 
									"name" => "order" , 
									"default" => "ASC" , 
									"type" => "select",
									"description" => "" ,
									"options" => array("ASC" => "Ascending","DESC" => "Descending")
							) 
						);

        		echo getIOAInput( 
							array( 
									"label" => __("Show Posts by",'ioa') , 
									"name" => "orderby" , 
									"default" => "none" , 
									"type" => "select",
									"description" => "" ,
									"options" => array("none" => "None","ID" => "Post ID","author" => "Author","title" => "Title","date" => "Date","rand" => "Random","comment_count" => "Comments")
							) 
						);

        		echo getIOAInput( 
							array( 
									"label" => __("Show Posts by Year(enter year in 4 digits eg:2011)",'ioa') , 
									"name" => "year" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" 
									
							) 
						);

        		echo getIOAInput( 
							array( 
									"label" => __("Show Posts by Month(enter year in 2 digits eg:12)",'ioa') , 
									"name" => "month" , 
									"default" => "" , 
									"type" => "text",
									"description" => "" 
									
							) 
						);
        		
		 ?>
	</div>
</div>

<?php
elseif($type=="rad-builder-data") :
global $radunits,$post,$ioa_portfolio_slug;

	$settings = array();  
	 foreach ($radunits as $key => $widget) {

	 	if( $widget->getCommonKey() !="" )
	 		$settings[$widget->getCommonKey()] = $widget->mapSettingsOverlay();	
	 	else 
	 		$settings[$key] = $widget->mapSettingsOverlay();	
	 }
	 
	array_unique($settings); 
	foreach ($settings as $key => $setting)  echo $setting;

elseif($type=="icons") :

	$cicon = $_POST['current_icon'];

?>

<div class="scourge clearfix">
	
	<div class="sc-icon-list-wrap">
		<h4>Select from Icon Library</h4>
		<div class="icon-search-panel clearfix">
		<input type="text" class='sicon-search-input' placeholder="Search Icon">
		<i class="search-3icon- ioa-front-icon "></i>
	</div>
	<ul class="sc-icon-list clearfix">
		<?php 

		$icon_config_file = PATH.'/sprites/fonts/config.json';
		$fh = fopen($icon_config_file, 'r');

		$theData = fread($fh, filesize($icon_config_file));
		fclose($fh);
		
		$icons = json_decode($theData,true);
		$icons = $icons['glyphs'];



		foreach($icons as $icon){
		    ?> <li><i class="ioa-front-icon <?php echo $icon['css'].'icon-' ?> "></i></li> <?php
		}

		

		 ?>	
	</ul>
	</div>	

	<div class="main-icon-area clearfix">
		
		<h4>Preview</h4>
		<div class="icon-preview-pane">
			<?php 
			$list = array();
			if($cicon!="") :

			$pattern = get_shortcode_regex();
			preg_match_all("/$pattern/",stripslashes($cicon),$matches);

			$list = $matches[3];

			$list = explode(" ",trim($list[0]));
			endif;	
			$fin_opts = array();

			foreach ($list as $key => $value) {
				if($value!="")
				{
					$v = explode("=",$value);
					$fin_opts[$v[0]] = str_replace("\"","",$v[1]);
				}
			}




			if($cicon!="") echo do_shortcode(stripslashes($cicon));
			else echo '<i class="ioa-front-icon camera-2icon- "></i>';

			 ?>
		</div>	

		<div class="inputs">
			<?php 

			$si = 'none';
			if( isset($fin_opts['icon_type']) ) $si = $fin_opts['icon_type'];

			echo getIOAInput( 
							array( 
									"label" => __("Select Icon Style",'ioa') , 
									"name" => "icn_style" ,
									"type" => 'select', 
									"value" => $si,
									"options" => array('none' => __('None','ioa') , 'border-style' => __('Border Square','ioa') , 'border-style-circ' => __('Border Circle','ioa') , 'background-style' => __('Background Square','ioa') , 'background-style-circ' => __('Background Circle','ioa') , 'longshadow-style' => __('Long Shadow Square','ioa') , 'longshadow-style-circ' => __('Long Shadow Circle','ioa') ),
									"data" => array("attr" => "style" , "css" => "") 
							)  
						);

			$color = '';if( isset($fin_opts['color']) ) $color = $fin_opts['color'];
			$border_color = '';if( isset($fin_opts['border_color']) ) $border_color = $fin_opts['border_color'];
			$background_color = '';if( isset($fin_opts['background_color']) ) $background_color = $fin_opts['background_color'];

			$icon_settings = array(

				array( "label" => "Icon Color"  , "name" => "color" , "type" => "colorpicker" , "value" => $color , "data" => array( "attr" => "color" ) , 'class' => 'sc-icon-listener none border-style border-style-circ background-style background-style-circ longshadow-style longshadow-style-circ'  ),	
				array( "label" => "Icon Border Color"  , "name" => "border_color" , "type" => "colorpicker" , "value" => $border_color , "data" => array( "attr" => "border-color" ) , 'class' => 'sc-icon-listener border-style border-style-circ '  ),	

				array( "label" => "Icon Background Color"  , "name" => "bg_color" , "type" => "colorpicker" , "value" => $background_color , "data" => array( "attr" => "background-color" )  , 'class' => 'sc-icon-listener background-style background-style-circ longshadow-style longshadow-style-circ'    ),	


				);

			foreach ($icon_settings as $key => $setting) {
				echo getIOAInput($setting);
			}

			 ?>
		</div>

	</div>


</div>

<?php

elseif($type=="simple_icons") :
?>

<div class="simple-icons clearfix">
	<div class="icon-search-panel clearfix">
		<input type="text" class='sicon-search-input' placeholder="Search Icon">
		<i class="search-3icon- ioa-front-icon "></i>
	</div>
	<ul class="sicon-list clearfix">
								<?php 

								$icon_config_file = PATH.'/sprites/fonts/config.json';
								$fh = fopen($icon_config_file, 'r');

								$theData = fread($fh, filesize($icon_config_file));
								fclose($fh);
								
								$icons = json_decode($theData,true);
								$icons = $icons['glyphs'];



								foreach($icons as $icon){
								    ?> <li><i class="ioa-front-icon <?php echo $icon['css'].'icon-' ?> "></i></li> <?php
								}

								

								 ?>	
	</ul>	
		

	
</div>

<?php
elseif($type=="IOA_media") :
?>

<div class="IOA_api" data-url='<?php echo  URL.'/sprites/i' ; ?>'>
	<div class="IOA-api-top-bar clearfix">
		<a href="" data-title="Add Image" data-label="Add" class="import-IOA-media-image button-default "> <?php _e('Add Image','ioa') ?> </a>
		<a href=""  class="import-IOA-media-video button-default " > <?php _e('Add Video','ioa') ?> </a>
	</div>
	<div class="image-canvas">
		
		<div class="image-IOA-wrap " >
			<div class="inner-IOA-wrap"  ><img   src="" alt="" class='preview-image'></div>
		
			
		</div>



	</div>
	<div class="image-opts">
		<h6>Image Properties</h6>
		<div class="grouping clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => __("Width",'ioa') , 
												"name" => "image_width" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "width" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Height",'ioa') , 
												"name" => "image_height" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "height" , "element" => "img") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => __("Opacity",'ioa') , 
												"name" => "image_opacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "img") 
										)  
									);
								 ?>
							</div>	
							
							<h6><?php __('Select Image Prop','ioa') ?></h6>
		<div class="grouping clearfix">
								<?php 

							
								

								echo getIOAInput( 
										array( 
												"label" => __("Select Shadow",'ioa') , 
												"name" => "shadow" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array('none' => __('None','ioa') ,'shadow-1' => __('Shadow 1','ioa'),'shadow-2' => __('Shadow 2','ioa'),'shadow-3' => __('Shadow 3','ioa'),'shadow-4' => __('Shadow 4','ioa'),'shadow-5' => __('Shadow 5','ioa'),'shadow-6' => __('Shadow 6','ioa'),'shadow-7' => __('Shadow 7','ioa')),
												"length" => 'small'  ,
												"data" => array("attr" => "shadow" , "element" => "prop") 
										)  
									);

								/*
								echo getIOAInput( 
										array( 
												"label" => "Select Device" , 
												"name" => "shadow" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array('Phone','Laptop','Mac','Tablet','Browser'),
												"length" => 'small'  ,
												"data" => array("attr" => "prop" , "element" => "prop") 
										)  
									);
								 */

								echo getIOAInput( 
										array( 
												"label" => "Select Glare" , 
												"name" => "shadow" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array( 'none' => 'None' ,'prop-glare-1' => 'Glare 1','prop-glare-2' =>'Glare 2','prop-glare-3' =>'Glare 3','prop-glare-4' =>'Glare 4','prop-glare-5' =>'Glare 5','prop-glare-6' =>'Glare 6'),
												"length" => 'small'  ,
												"data" => array("attr" => "glare" , "element" => "prop") 
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => "Select Effect(HTML 5)" , 
												"name" => "html5" , 
												"default" => "" , 
												"type" => "select",
												"description" => "",
												"options" => array('none' => 'None' ,'reflection' => 'Reflection','greyscale' => 'Greyscale', 'sepia' => 'Sepia', 'noise' => 'Noise', 'vintage' => 'Vintage', 'concentrate' => "Concentrate" , 'hemingway' => 'Hemingway' , 'nostalgia' => 'Nostalgia', 'hermajesty' => 'Hermajesty' ,'hazydays' => 'Hazydays', 'glowingsun' => 'Glowingsun', 'oldboot' => 'Old Boot' ,'pinhole' => 'Pin Hole', 'jarques' => 'Jarques', 'grungy' => 'Grungy' ,'love' => 'Love', 'orangePeel' => 'Orange Peel', 'crossprocess' => 'Cross Process', 'sincity' => 'Sincity', 'clarity' => 'Clarity', 'lomo' => 'Lomo', 'vintage' => 'Vintage', 'sunrise' => 'Sunrise'),
												"length" => 'small'  ,
												"data" => array("attr" => "html5" , "element" => "prop") 
										)  
									);

								 ?>
							</div>

							<h6>Image Container Properties</h6>
<div class="grouping  clearfix">
								<?php 


								

								echo getIOAInput( 
										array( 
												"label" => "Horizontal Gap" , 
												"name" => "image_cpwidth" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "padding-h" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Vertical Gap" , 
												"name" => "image_cpheight" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "padding-v" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Opacity" , 
												"name" => "image_copacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "parent") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Border Radius" , 
												"name" => "image_radius" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-radius" , "element" => "parent") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Border Width" , 
												"name" => "image_border" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "border-width" , "element" => "parent") 
										)  
									);
								 ?>
							</div>	
						<div class="grouping colorpicker-area clearfix">
								<?php 

								echo getIOAInput( 
										array( 
												"label" => "Background" , 
												"name" => "image_bg" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background" , "element" => "parent") 
										)  
									);


								echo getIOAInput( 
										array( 
												"label" => "Border color" , 
												"name" => "image_brcolor" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false	,
												"data" => array("attr" => "border-color" , "element" => "parent")
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => "Box Shadow color" , 
												"name" => "image_shcolor" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false	,
												"data" => array("attr" => "box-shadow-color" , "element" => "parent")
										)  
									);
								

								 ?>
							</div>	
					<div class="grouping">
						<?php 
						echo getIOAInput( 
										array( 
												"label" => "Horizontal Shadow Distance" , 
												"name" => "image_shh" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "box-shadow-h" , "element" => "parent") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Vertical Shadow Distance" , 
												"name" => "image_shv" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "box-shadow-v" , "element" => "parent") 
										)  
									);

								echo getIOAInput( 
										array( 
												"label" => "Shadow Blur" , 
												"name" => "image_shb" , 
												"default" => "" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "box-shadow-b" , "element" => "parent") 
										)  
									);
						 ?>
					</div>

	</div>

</div>


<?php
elseif($type=="IOA_bg") :
?>

<div class="background-engine">
	
	<div class="background-head clearfix">
		<?php 
		echo getIOAInput( 
							array( 
									"label" => "Select Background Mode" , 
									"name" => "order" , 
									"default" => "Theme's Style" , 
									"type" => "select",
									"description" => "" ,
									"options" => array('none' => "Theme's Style","css" => "Custom Code")
							) 
						);
		 ?>
	</div>


	<div class="bg-preview-mode clearfix">
		<div class="bg-overlay"></div>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, at officia odit quas aliquam natus tempora modi animi. Suscipit, fuga, nulla tenetur nesciunt temporibus nostrum necessitatibus facere possimus incidunt quaerat animi atque architecto totam provident veniam dolor velit illum sint pariatur optio repellendus aspernatur praesentium recusandae sapiente expedita corrupti eius voluptate eligendi doloremque quibusdam. Voluptatem, modi, illo, quos alias enim vel ipsa hic magni blanditiis illum itaque repellendus numquam sint. Libero, eaque consectetur sit doloremque laudantium. Sit iste totam consectetur.</p>
	</div>
	
	
	<div class="grouping bg-opts colorpicker-area clearfix"> 
		<h6>Container Settings</h6>
								<?php 

								echo getIOAInput( 
										array( 
												"label" => "Background Color" , 
												"name" => "el_bg" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background-color" , "element" => "el") 
										)  
									);


								
								echo getIOAInput( 
										array( 
												"label" => "Background Repeat " , 
												"name" => "el_bgrepeat" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("repeat","repeat-x","repeat-y","no-repeat"),
												"data" => array("attr" => "background-repeat" , "element" => "el") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Background Position " , 
												"name" => "el_bgposition" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("top left","top right","bottom left","bottom right","center top","center center","center bottom"),
												"data" => array("attr" => "background-position" , "element" => "el") 
										)  
									);
								echo getIOAInput( 
										array( 
												"label" => "Background Effect" , 
												"name" => "el_parallex" , 
												"default" =>  "none" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("none"=>"None","parallex"=> "Paralllex" ,"sps" => "Particle System","animate-bg-x" => "Animate Background X axis","animate-bg-y" => "Animate Background Y axis" ,"softlight-top" => 'Soft Light At Top',"softlight-bottom" => 'Soft Light At Bottom'),
												"data" => array("attr" => "parallex" , "element" => "el") 
										)  
									);



								 ?>
	</div>

	<div class="bg-opts bg-image">
		<?php 
		echo getIOAInput( 
										array( 
												"label" => "Background Image " , 
												"name" => "el_bgimage" , 
												"default" =>  "" , 
												"type" => "upload",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "background-image" , "element" => "el") 
										)  
									);
		 ?>
	</div>

	<div class="grouping bg-opts colorpicker-area clearfix"> 
		<h6>Container Overlay Settings</h6>
								<?php 
								
								echo getIOAInput( 
										array( 
												"label" => "Background Color" , 
												"name" => "ov_bg" , 
												"default" =>  "1 << ffffff" , 
												"type" => "colorpicker",
												"description" => "",
												"length" => 'small'  ,
												"alpha" => false,
												"data" => array("attr" => "background-color" , "element" => "ov") 
										)  
									);


								
								echo getIOAInput( 
										array( 
												"label" => "Background Repeat " , 
												"name" => "ov_bgrepeat" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("repeat","repeat-x","repeat-y","no-repeat"),
												"data" => array("attr" => "background-repeat" , "element" => "ov") 
										)  
									);
								
								echo getIOAInput( 
										array( 
												"label" => "Background Position " , 
												"name" => "ov_bgposition" , 
												"default" =>  "repeat" , 
												"type" => "select",
												"description" => "",
												"length" => 'small'  ,
												"options" => array("top left","top right","bottom left","bottom right","center top","center center","center bottom"),
												"data" => array("attr" => "background-position" , "element" => "ov") 
										)  
									);
							
								echo getIOAInput( 
										array( 
												"label" => "Opacity" , 
												"name" => "ov_opacity" , 
												"default" => "1" , 
												"type" => "text",
												"description" => "",
												"length" => 'small'  ,
												"data" => array("attr" => "opacity" , "element" => "ov") 
										)  
									);


								 ?>
	</div>

	<div class="grouping bg-opts colorpicker-area clearfix">
		<?php 
		echo getIOAInput( 
										array( 
												"label" => "Background Image " , 
												"name" => "ov_bgimage" , 
												"default" =>  "" , 
												"type" => "upload",
												"description" => "",
												"length" => 'small' ,
												"data" => array("attr" => "background-image" , "element" => "ov") 
										)  
									); ?>
	</div>

</div>


<?php

elseif($type=="RAD") :
	global $ioa_helper;
	$data = array();

	if(isset($_POST['data']))
	$data = $_POST['data'];

	echo update_post_meta($_POST['id'],'rad_data', $data );
	

elseif($type=="RAD-Template-Export") :

	$tdata = array();
	if(isset($_POST['data']))
	$tdata = $_POST['data'];

	$title = 'Page_Template';
	if(isset($_POST['title']))
	$title = str_replace(' ', '_', $_POST['title']);
	
	echo set_transient('TEMP_RAD_TEMPLATE',$tdata,60*60);
	echo set_transient('TEMP_RAD_TEMPLATE_TITLE',$title,60*60);

elseif($type=="RAD-Template") :
	$data = array();
	if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

	$tdata = array();
	if(isset($_POST['data']))
	$tdata = $_POST['data'];
	
	$title = $_POST['title'];
	
	$id = 'RT'.uniqid();
	
	$data[$id] = array( 'post_id' => $_POST['id'] , 'data' => $tdata , 'title' => $title );

	update_option('RAD_TEMPLATES',$data);

elseif($type=="RAD-Template-Section") :
	$data = array();
	if(get_option('RAD_TEMPLATES_SECTION')) $data = get_option('RAD_TEMPLATES_SECTION');

	$tdata = array();
	if(isset($_POST['data']))
	$tdata = $_POST['data'];
	
	$title = $_POST['title'];
	
	$id = 'ST'.uniqid();
	
	$data[$id] = array( 'post_id' => $_POST['id'] , 'data' => $tdata , 'title' => $title );

	update_option('RAD_TEMPLATES_SECTION',$data);

elseif($type=='RAD-Revision-Import') :
global $ioa_helper;
	
$post_id = $_POST['post_id'];
$revisions = get_post_meta($post_id,'rad_revisions',true);

$revision = $revisions[$_POST['key']];

$template = $revision['data'];


foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = $ioa_helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];

		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}



elseif($type=="RAD-Revision") :
	global $ioa_super_options;
	
	$tdata = $_POST['data'];
	
	$title = $_POST['title'];
	$rev_id = 'RT'.uniqid();
	$post_id = $_POST['id'];
	
	$length = 4;

	$revisions =  get_post_meta($post_id,'rad_revisions',true);
	if($revisions == "") $revisions = array();
	$revisions[$rev_id] = array( 'title' => $title , 'post_id' => $post_id  , 'data' =>  json_decode(stripslashes($tdata),true)  );

	if(count($revisions) > $length ) array_shift($revisions);

	echo update_post_meta($post_id,'rad_revisions',$revisions);


elseif($type=="RAD-Template-Delete") :
	global $ioa_helper;

	$data = array();
	if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

	$id = $_POST['key'];
	unset($data[$id] );

	update_option('RAD_TEMPLATES',$data);
	
elseif($type=="RAD-Section-Delete") :
	global $ioa_helper;

	$data = array();
	if(get_option('RAD_TEMPLATES_SECTION')) $data = get_option('RAD_TEMPLATES_SECTION');

	$id = $_POST['key'];
	unset($data[$id] );

	update_option('RAD_TEMPLATES_SECTION',$data);

elseif($type=="RAD-Page-Import") :
	global $ioa_helper;
	$data = array();

	$data = base64_decode($_POST['data']);	
	$template = json_decode(stripslashes($data),true);

	
	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = $ioa_helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="RAD-Import") :
	global $ioa_helper;
	$data = array();
	if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

	$tkey = $_POST['key'];
	$template = json_decode(stripslashes($data[$tkey]['data']),true);
	
	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = $ioa_helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="RAD-Import-Section") :
	global $ioa_helper;
	$data = array();
	if(get_option('RAD_TEMPLATES_SECTION')) $data = get_option('RAD_TEMPLATES_SECTION');

	$tkey = $_POST['key'];
	$template = json_decode(stripslashes($data[$tkey]['data']),true);
	
	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = $ioa_helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="RAD-InstaImport") :
	global $ioa_helper;
	

	$ins_path =   get_template_directory()."/sprites/templates/".$_POST['key'];
	$fh = fopen($ins_path, 'r');
	$super_query = fread($fh, filesize($ins_path));

	$data = base64_decode($super_query);	
	$template = json_decode(stripslashes($data),true);


	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = $ioa_helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];



		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="RAD-InstaImport-Section") :
	global $ioa_helper;
	

	$ins_path =   get_template_directory()."/sprites/rad_sections/".$_POST['key'];
	$fh = fopen($ins_path, 'r');
	$super_query = fread($fh, filesize($ins_path));

	$data = base64_decode($super_query);	
	$template = json_decode(stripslashes($data),true);


	foreach ($template as $key => $section) {

		$d = $section['data'];
		$d = $ioa_helper->getAssocMap($d,'value');
		
		$containers = array();

		if(isset($section['containers']))
		$containers = $section['containers'];

		RADMarkup::generateRADSection($d,$section['id'],$containers,false,$section['data']);
				
	}

elseif($type=="search") :
	
	$q = $_POST['query'];
	 $nos = 4;
	 if(get_option(SN.'_ajax_nos')) $nos = get_option(SN.'_ajax_nos');
	  $query = new WP_Query( 
	  						array(
	  								'posts_per_page' => $nos,
	  								's' => $q,
	  								'cache_results' => false,
	  								'no_found_rows' => true,
	  								'post_status' => 'publish'
	  								)
	  						 );
	  $output = '';

	  if ( $query->have_posts() ) {
	  while ( $query->have_posts() ) {
	    $query->the_post();
	    $img ='';
	    if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail(get_the_ID()))) :

	    $id = get_post_thumbnail_id(get_the_ID());
	      $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
	      $img = $ioa_helper->imageDisplay( array( "src"=> $ar[0] ,"height" =>  50 , "width" =>  50 , "parent_wrap" => false ) );  
	    endif; 

	    $output .= '<li class="clearfix"><div class="image">'.$img.'</div> <div class="desc ';
	    if(has_post_thumbnail()) $output .= 'hasImage'; 
	    $output .= ' "><h5><a href="'.get_permalink().'">' . get_the_title() . '</a></h5><span class="date">'.get_the_date("j M, Y").__(' in ','ioa')."<strong>".ucfirst(get_post_type( get_the_ID()) ).'</strong></span><a class="more" href="'.get_permalink().'">'.__('more','ioa').'</a> </div></li>';
	  
	  }
	  	$output .= "<li><a href='".get_search_link($q)."' class='view-all'>".__('View All Results','ioa')."</a></li>";
	  } else {
	    
	    $output = '<li class="not-found">'.__('No Results Found','ioa').' </li>'; 

	  }

	  echo $output;

elseif($type=='rad-masonry-widget') :

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug;

$widget = json_decode(base64_decode($_POST['query']),true);
$offset = $_POST['offset'];
$ioa_meta_data['widget'] = $widget;

$w = $ioa_helper->getAssocMap($ioa_meta_data['widget']['data'],'value');

$rad_attrs = array();
$an = '';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
$rad_attrs[] = 'class="'.$an.' rad-widget"';


// Default Values 
 
$ioa_meta_data['width'] = 700; // $w['width'];
$ioa_meta_data['height'] =  $w['height'];

$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post');
$filter = array();
$custom_tax = array();

if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 
if(isset($w['post_type']) && trim($w['post_type'])!="") $opts['post_type'] = $w['post_type']; 




  if(isset($w['posts_query']) && $w['posts_query'] !="" )
  {
     $qr = explode('&',$w['posts_query']);


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


  }

  $opts = array_merge($opts,$filter);
  $opts['tax_query'] = $custom_tax;
  $opts['offset'] = $offset;


        $query = new WP_Query($opts); $ioa_meta_data['i']=0; 
         if(!$query->have_posts()) 
 		{
 			echo '<li class="ioa-end"></li>';
 		}
        while ($query->have_posts()) : $query->the_post();  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : 
        ?> 
        <li class="masonry-block iso-item hover-item">  

          <div class="image">
           
            <?php
          $id = get_post_thumbnail_id();
          $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
         
          switch($w['masonry_type'])
          {
            case 'wproportional' :     echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $ar[0] ));  break;
            case 'default' : default :
                                       echo $ioa_helper->imageDisplay(array( "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $ar[0] )); 

          }
         
           $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'masonry' ) );
          ?> 
          </div>

         

        </li>  
        <?php
        endif; endwhile; 

elseif($type=='rad-list-widget'):

$widget = json_decode(base64_decode($_POST['query']),true);
$offset = $_POST['offset'];

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;
$ioa_meta_data['widget'] = $widget;
$w = $ioa_helper->getAssocMap($ioa_meta_data['widget']['data'],'value');

$rad_attrs = array();

// Default Values 
// 
$ioa_meta_data['height'] = 90;
$ioa_meta_data['width'] = 90;
$ioa_meta_data['hasFeaturedImage'] = false; 
$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['excerpt'] = "yes";
$ioa_meta_data['meta_value'] = "";
$post_structure_class = 'post-list';

$opts = array('posts_per_page' => 3,'post_type'=>'post');
$filter = array();
$custom_tax = array();

if(isset($w['meta_value'])) $ioa_meta_data['meta_value'] = $w['meta_value']; 
if(isset($w['excerpt'])) $ioa_meta_data['excerpt'] = $w['excerpt']; 
if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 
if(isset($w['post_type']) && trim($w['post_type'])!="") $opts['post_type'] = $w['post_type']; 



  if(isset($w['posts_query']) && $w['posts_query'] !="" )
  {
     $qr = explode('&',$w['posts_query']);


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


  }


$opts = array_merge($opts,$filter);
$opts['tax_query'] = $custom_tax;
$opts['offset'] = $offset;
if($w['w_pagination']=="yes") $opts['paged'] = $paged;
  

 switch($w['post_structure'])
      {
        case 'post-list' : 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'plain-list';
                      break;
          case 'post-thumbs-big' :
                      $ioa_meta_data['blog_props'] = array();
                      $ioa_meta_data['blog_props']['_enable_thumbnail'] = "false";
                      $ioa_meta_data['blog_props']['_blog_meta_enable'] = "true";
                      $ioa_meta_data['blog_props']['_blog_meta'] = $w['meta_value'];
                      $ioa_meta_data['blog_props']['_blog_excerpt'] = $w['use_custom_excerpt'];
                      $ioa_meta_data['blog_props']['_posts_excerpt_limit'] = $w['excerpt_length'];
                      $ioa_meta_data['blog_props']['_more_label'] = '';
                      

                      $ioa_meta_data['height'] = 350;
                      $ioa_meta_data['width'] =  $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'blog_posts';
                      break;             
        default :                
        case 'post-thumbs' :
                      $ioa_meta_data['height'] = 50;
                      $ioa_meta_data['width'] = 50;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'thumb-list';
                      break;

        
      }


 $query = query_posts($opts); $ioa_meta_data['i']=0; 

if(!have_posts()) 
 		{
 			echo '<li class="ioa-end"></li>';
 		}
 while (have_posts()) : the_post();   ?> 
       <?php  
        if($w['excerpt_length']!="") $ioa_meta_data['excerpt_length'] =  $w['excerpt_length'];
         switch($w['post_structure'])
         {
           case 'post-list' :  get_template_part('templates/post-list'); break;
           case 'post-thumbs' : get_template_part('templates/post-thumbs'); break;
        	case 'post-thumbs-big' : get_template_part('templates/post-blog-column'); break;
          }
        ?>
        <?php  endwhile; 
 


elseif($type=='portfolio_block'):


global $ioa_helper,$ioa_meta_data,$ioa_super_options; 

$ioa_meta_data['item_per_rows'] = 3;
$ioa_meta_data['width'] = 320;
$ioa_meta_data['column'] =  '';



$id = $_POST['id'];

$ioa_helper->getPortfolioParameters($id);
$portfolio_props = $ioa_meta_data['portfolio_props'];
if( $portfolio_props['portfolio_cols'] == "grid" ) $ioa_meta_data["width"] = 351;

$ioa_meta_data['height'] = $portfolio_props['_p_height'];
$ioa_meta_data['i']=  $_POST['offset']; 

$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] ) , $portfolio_props['query_filter']);
$opts['offset'] = $_POST['offset'];

query_posts($opts); 

if(have_posts()) :
	while (have_posts()) : the_post(); 
		get_template_part('templates/portfolio-cols');
	endwhile;
else : 
	echo ' <li class="ioa-end">'.__('Sorry no posts found','ioa').'</li> ';
endif;	


elseif($type=='masonry_block') :

global $ioa_helper,$ioa_meta_data,$ioa_super_options; 

$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 400;
$ioa_meta_data['height'] = $ioa_super_options[SN.'_bt_height'];

$ioa_meta_data['crop'] = 'wproportional';

$id = $_POST['id'];

$ioa_helper->getBlogParameters($id );

$blog_props = $ioa_meta_data['blog_props'];
$ioa_meta_data['i']=  $_POST['offset']; 

$opts = array_merge(array('posts_per_page' => $blog_props['_posts_item_limit']  ) , $blog_props['query_filter']);
$opts['offset'] = $_POST['offset'];

 $opts['offset']+= 2;

query_posts($opts); 

if(have_posts()) :
	while (have_posts()) : the_post(); 
		get_template_part('templates/post-blog-column');  
	endwhile;
else : 
	echo ' <li class="ioa-end">'.__('Sorry no posts found','ioa').'</li> ';
endif;	


elseif($type=='portfolio_masonry_block') :

global $ioa_helper,$ioa_meta_data,$ioa_super_options; 

$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 600;
$ioa_meta_data['column'] =  'full';

$id = $_POST['id'];

$ioa_helper->getPortfolioParameters($id);
$portfolio_props = $ioa_meta_data['portfolio_props'];

print_r($portfolio_props);

$ioa_meta_data['height'] = $portfolio_props['_p_height'];
$ioa_meta_data['i']=  $_POST['offset']; 

$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] ) , $portfolio_props['query_filter']);
$opts['offset'] = $_POST['offset'];


query_posts($opts); 

if(have_posts()) :
	while (have_posts()) : the_post(); 
		get_template_part('templates/portfolio-cols');
	endwhile;
else : 
	echo ' <li class="ioa-end">'.__('Sorry no posts found','ioa').'</li> ';
endif;	

elseif($type=='product_masonry_block') :

global $ioa_helper,$ioa_meta_data,$ioa_super_options; 

$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['width'] = 600;
$ioa_meta_data['column'] =  'full';

$id = $_POST['id'];

$ioa_helper->getProductParameters($id);
$product_props = $ioa_meta_data['product_props'];
$ioa_meta_data['height'] = $product_props['_pr_height'];
$ioa_meta_data['i']=  $_POST['offset']; 

$opts = array_merge(array( 'post_type' => 'product',  'posts_per_page' => $product_props['_product_item_limit'] ) , $product_props['query_filter']);
$opts['offset'] = $_POST['offset'];

query_posts($opts); 

if(have_posts()) :
	while (have_posts()) : the_post(); 
		get_template_part('templates/product-cols');
	endwhile;
else : 
	echo ' <li class="ioa-end">'.__('Sorry no posts found','ioa').'</li> ';
endif;	

elseif($type=='posts-timeline') :

global $ioa_helper,$ioa_meta_data,$ioa_super_options; 

$id = $_POST['id'];

$ioa_helper->getBlogParameters($id );
$blog_props = $ioa_meta_data['blog_props'];

$ioa_meta_data['width'] = 333;
$ioa_meta_data['height'] = 230;

$months = array( 
	"january" => __("January",'ioa') , 
	"february" => __("February",'ioa') , 
	"march" => __("March",'ioa') , 
	"april"  => __("April",'ioa') , 
	"may" => __("May",'ioa') , 
	"june" => __("June",'ioa') , 
	"july" => __("July",'ioa') , 
	"august" => __("August",'ioa') , 
	"september" => __("September",'ioa') , 
	"october" => __("October",'ioa') , 
	"november" => __("November",'ioa') , 
	"december" => __("December",'ioa') 
	); 

$offset = $_POST['offset'];
$month = $_POST['month'];
$post_id = $_POST['id'];
$post_type = $_POST['post_type'];

$opts = array_merge(array('posts_per_page' => $blog_props['_posts_item_limit'] , 'post_type' => $post_type ) , $blog_props['query_filter']);
$opts['offset'] = $offset;



$rs = array(); $count = 0;

query_posts($opts); 
if(have_posts()) {
while(have_posts()) : the_post();  
	$row = array();	
	
	$row["start_time"] = get_the_time();
	$row["start_date"] = get_the_date("d-n-Y");
	$row["ori_date"] = get_the_date();
	$f = get_the_date("d-n-Y");
	$row["factor"] = $f[2].$f[1].$f[0];
	$row["id"] = get_the_ID();


	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :

		$id = get_post_thumbnail_id();
		$ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		$row["image"] =	 $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
		$row["image_url"] = $ar[0];
	else:
		$row["image"] =	 $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" =>URL."/sprites/i/dummy.png", "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
	   $row["image_url"] = URL."/sprites/i/dummy.png";	
	endif;


	$row["title"] = get_the_title();
	$row["permalink"] =  get_permalink();
	$row["content"] =  $ioa_helper->getShortenContent($blog_props['_posts_excerpt_limit'], strip_tags(strip_shortcodes(get_the_content())) );
	$rs[] = $row;

	$count++;
endwhile;
}
else
{
	echo "<h4 class='post-end'>".__('End of post','ioa')."</h4>";
	return;
}


$posts  = '';

$i=0;

if( isset($rs[0]["start_date"]) ) :

$opts = explode("-",$rs[0]["start_date"]); 
$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];
$month = $opts[1];		

endif;

$posts = $posts. " <div class='month-label' data-month='$month'>". $transmonth.' <span class="year">'.$opts[2]."</span></div> ";

foreach($rs as $post)
{
	

	$opts = explode("-",$post["start_date"]); 
	$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];

	if($opts[1]!=$month)
	{
		$month = $opts[1];	
		$posts = $posts. " <div class='month-label' data-month='$month'> ". $transmonth.' <span class="year">'.$opts[2]."</span></div> ";
	}


$s_date =  $opts[0];
$s_date = str_replace(strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2]))),$transmonth,strtolower($s_date));

if($i%2==0) $clname = 'left-post'; else $clname = "right-post";                 

$posts  = $posts ." <div class=\"clearfix hover-item $clname timeline-post\"  ><span class='date'>". $s_date."</span>
  <div class=\"image\">";

if(isset($post['image']) && isset($post['image_url']) ) {
$posts  = $posts.$post['image']; 


ob_start();
 if($blog_props['_enable_thumbnail']!="true"):
 	$ioa_helper->getHover(array( "id" => $post["id"], "link" => true  , 'format' => 'link'  ) ); 
 	$posts  = $posts. ob_get_contents();
 else: 
 	$ioa_helper->getHover(array( "image" => $post["image_url"] , 'format' => 'image' , 'useLightboxClass' => true) );  
  	$posts  = $posts. ob_get_contents();
 endif; 
 
ob_end_clean();

 }                

$posts  = $posts."</div>
<div class=\"desc clearfix\"><h3 class=\"title\">  <a href=\"".$post['permalink']."\"> ".$post['title']." </a> </h3>
".$post['content']."
</div>  <a href=\"".$post['permalink']."\" class=\"main-button\"> ".__('More','ioa')." </a>
</div>";



$i++;
} ?>

<?php echo $posts;?>

<?php elseif ( $type == "portfolio_modelie") :
	global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug,$paged;

	$offset = $_POST['offset'];
	$id = $_POST['id'];

	$ioa_helper->getPortfolioParameters($id);
	$portfolio_props = $ioa_meta_data['portfolio_props'];

	$ioa_meta_data['item_per_rows'] = 1;
	$ioa_meta_data['width'] = 525;
	$ioa_meta_data['height'] = 600;
	$ioa_meta_data['column'] =  '';

	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] , 'paged' => $paged , 'offset' => $offset) , $portfolio_props['query_filter']);
				query_posts($opts); 

	$ioa_meta_data['i']=0; 

	if(have_posts()) :
	while (have_posts()) : the_post(); 	
					 					
	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 
                  $terms = get_the_terms( get_the_ID(), $ioa_portfolio_taxonomy );
                   $cl = array();
                   $links = array();
                     
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( "<span>|</span>", $links );
                  endif; ?>
          
        <div  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="hover-item swiper-slide <?php echo join(' ',$cl); ?>  <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; echo $portfolio_props['portfolio_cols'].'-col-layout'; ?>" style='width:<?php echo $ioa_meta_data['width'] ?>px'>
          <div class="inner-item-wrap clearfix">
            <?php 

              $mt =  'image';

              switch($mt)
              {

                
                case "image" : 
                default : ?>
      
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
             <div class="image-wrap">
               <div class="image" >
               <?php



              $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
                  
              switch($portfolio_props['portfolio_image_resize'])
              {
                  case "none" : echo "<img src='".$ar[0]."' alt='".get_the_title()."' />";  break;
                  case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "hproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                  case "default" :
                  default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                 
              }
                    
            
            ?>

              <?php   $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'auto' ) ); ?>  
                

              </div>
             </div>

              <?php
              endif;
              ?>

            <?php
              }
               ?>
          </div>  
        </div>


	<?php

	endwhile;
		else : 
			echo ' <div class="no-posts-found">'.__('Sorry no posts found','ioa').'</div> ';
		endif;	

elseif($type=="portfolio_fullscreen") :	

	global $ioa_helper,$ioa_meta_data,$paged;
	
	$width = $_POST['width'];
	$height = $_POST['height'];
	$id = $_POST['id'];

	$ioa_helper->getPortfolioParameters($id);
	$portfolio_props = $ioa_meta_data['portfolio_props'];

	$opts = array_merge(array( 'post_type' => $ioa_portfolio_slug,  'posts_per_page' => $portfolio_props['_portfolio_item_limit'] , 'paged' => $paged) , $portfolio_props['query_filter']);
	query_posts($opts); 

	?> 

	<div class="ioa-gallery seleneGallery" data-effect_type="fade" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-thumbnails="true" > 
                      <div class="gallery-holder"> 
                      	<?php
         if(have_posts()) :             	
	while(have_posts()) : the_post(); 
	

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
             
       	
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) :

               $id = get_post_thumbnail_id();
	           $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
	           ?>   
            	
               <div class="gallery-item <?php echo $portfolio_props['portfolio_image_resize']; ?>" data-thumbnail="<?php $th = wp_get_attachment_image_src($id); echo $th[0]; ?>">

	                <?php

                	switch ($portfolio_props['portfolio_image_resize']) {
                		
                		case 'default': echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                		case 'proportional': echo $ioa_helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                		case 'none' :	
                		default: echo "<img src='". $ar[0]."' />"; break;
                	}
					  	     
					   // 
					
				?>

		      
		        <a href="<?php echo $ar[0] ?>" rel="prettyphoto" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
		      <div class="gallery-desc s-c-l" >
		      		<h4 class="" <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h4>
		      		<div class="clearfix">
		      			<div class="caption">
					
                  <?php  if(  $portfolio_props['_portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      if(!isset($portfolio_props['_portfolio_excerpt_limit'])) $portfolio_props['_portfolio_excerpt_limit'] = 150;	
                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);

                      echo $ioa_helper->getShortenContent( 150,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>
                  

		      		</div> 
		      		</div>
                  	 <a href="<?php the_permalink(); ?>"  class="hover-link"><?php echo stripslashes($portfolio_props['_portfolio_more_label']) ?></a>  
              </div>
                
              
              </div>
              
             <?php endif; ?>
          
      
	


	<?php endwhile;
			else : 
				echo '<div class="no-posts-found skeleton auto_align"><h4>'.__('Sorry no posts found','ioa').'</h4></div>';
				
			endif;
	?> </div></div> <?php

elseif($type=='like-portfolio') :

$id = $_POST['id'];

$likes = get_post_meta($id,'_ioa_likes',true);

if($likes == "") $likes = 0;

$likes = intval($likes) + 1;
update_post_meta($id,'_ioa_likes',$likes);

echo $likes;

elseif($type=="single_portfolio_fullscreen") :	

	global $ioa_helper,$ioa_meta_data,$paged;
	
	$width = $_POST['width'];
	$height = $_POST['height'];
	$id = $_POST['id'];
	$gallery_images = '';

	$ioa_options = get_post_meta( $id, 'ioa_options', true );
	if($ioa_options =="")  $ioa_options = array();

	if(isset($ioa_options['ioa_portfolio_data'])) $gallery_images =  $ioa_options['ioa_portfolio_data'];	

	?> 

	<div class="ioa-gallery seleneGallery" data-effect_type="scroll" data-width="<?php echo $width ?>" data-height="<?php echo $height ?>" data-duration="5" data-autoplay="true" data-captions="true" data-arrow_control="true" data-fullscreen="true" data-thumbnails="true" > 
                     <div class="gallery-holder">
					<?php if(isset($gallery_images) && trim($gallery_images) != "" ) : $ar = explode(";",stripslashes($gallery_images));
						
						foreach( $ar as $image) :
							if($image!="") :
								$g_opts = explode("[ioabre]",$image);

							
						 ?>
						 <div class="gallery-item" data-thumbnail="<?php echo $g_opts[1]; ?>">
                      		<?php echo $ioa_helper->imageDisplay(array( "crop" => "proportional" ,"src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $height )); ?> 
                     		
                  		 </div>	
					<?php 
						endif;
					endforeach; endif; ?>
				</div></div> <?php

elseif ($type =="portfolio_maerya") :

	$pid = $_POST['id'];
	$ajax_post = get_post($pid);
	?>
	
	<div class="one_half left">
		<?php    
			$id = get_post_thumbnail_id($pid);
            $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
             echo $ioa_helper->imageDisplay(array( "src" => $ar[0], "height" =>530 , "width" => 530 , "link" => get_permalink($pid) ,"imageAttr" => ""));  
            ?>

	</div>
	<div class="one_half left">
		<h2><a href="<?php echo get_permalink($pid) ?>"><?php  echo $ajax_post->post_title; ?></a></h2>
		<div class="desc clearfix">
				
				<div class="clearfix">
                    <p>
                      <?php
                      
                      $content = $ajax_post->post_content ;
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( 320 ,   $content); ?>
                    </p>
                  </div>
                       <a href="<?php echo get_permalink($pid) ?>" class="read-more"><?php _e('View the Post','ioa') ?></a>  

	
		</div>
	</div>


	<?php
elseif($type == 'shortcode_columns') :

?>

<div id="s-column-maker">
						<h6><?php _e('Click the layout you want, a layout grid will be generated. Once satisfied, click on Insert Column Layout. When you are adding last column select the column with last suffix to ensure proper spacings.','ioa') ?></h6>
						<div class="top-bar clearfix">
							<a href="full" class="button-default"><?php _e('100%','ioa'); ?></a>
							<a href="one_half" class="button-default"><?php _e('50%','ioa'); ?></a>
							<a class="last button-default" href="one_half"><?php _e('50% Last','ioa'); ?></a>
							<a href="one_fourth" class="button-default"><?php _e('25%','ioa'); ?></a>
							<a class="last button-default" href="one_fourth"><?php _e('25% Last','ioa'); ?></a>
							<a href="one_third" class="button-default"><?php _e('33%','ioa'); ?></a>
							<a class="last button-default" href="one_third"><?php _e('33% Last','ioa'); ?></a>
							<a href="one_fifth" class="button-default"><?php _e('20%','ioa'); ?></a>
							<a class="last button-default" href="one_fifth"><?php _e('20% Last','ioa'); ?></a>
							<a href="three_fourth" class="button-default"><?php _e('75%','ioa'); ?></a>
							<a class="last button-default" href="three_fourth"><?php _e('75% Last','ioa'); ?></a>
							<a href="two_third" class="button-default"><?php _e('66%','ioa'); ?></a>
							<a class="last button-default" href="two_third"><?php _e('66% Last','ioa'); ?></a>
							<a href="four_fifth" class="button-default"><?php _e('80%','ioa'); ?></a>
							<a class="last button-default" href="four_fifth"><?php _e('80% Last','ioa'); ?></a>
						</div>
						<div class="column-maker-area clearfix">
							
						</div>	

</div>
<?php

elseif($type=='headercons') :

	$data = json_decode( stripslashes($_POST['data']) , true );
	$data['head_layout'] = $_POST['head_layout'];
	$data['head_style'] = $_POST['head_style'];
	echo update_option(SN.'_head_builder',$data);

elseif($type=='headercons-import-code') :

	$code = base64_decode($_POST['code']);
	$template = json_decode( stripslashes($code) , true );
	echo update_option(SN.'_head_builder',$template['data']);

elseif($type=='headercons-template') :

	$data = json_decode( stripslashes($_POST['data']) , true );
	$data['head_layout'] = $_POST['head_layout'];
	$data['head_style'] = $_POST['head_style'];

	$templates  = get_option(SN.'_header_templates');
	if(!$templates) $templates = array();

	$key = uniqid();

	$templates['hcon'.$key] = array( 'data' => $data , 'title' => $_POST['hcon_title'] );
	echo update_option(SN.'_header_templates',$templates);

elseif($type=='delheadercons') :

	$post_id = $_POST['id'];
	delete_post_meta($post_id,'ioaheader_data');

elseif($type=="Enigma-styler-add") :

	$name = $_POST['label'];
	$key = uniqid();

	$table = get_option(SN.'enigma_hash');

	if(!$table || !is_array($table)) $table = array();

	$table['en'.$key] = $name;

	update_option(SN.'enigma_hash',$table);

	echo 'en'.$key;

elseif($type=="Enigma-typo") :

	$font_stacks = json_decode(stripslashes($_POST['fontstack']));

	update_option(SN.'font_stacks',$font_stacks);

	$font_selector = $_POST['font_selector'];
	update_option(SN.'font_selector',$font_selector);

	$fontface = $_POST['fontface'];
	update_option(SN.'_font_face_font',$fontface);

	$font_deck_project_id = $_POST['font_deck_id'];
	update_option(SN.'_font_deck_project_id',$font_deck_project_id);

	$font_deck_name = $_POST['font_deck_name'];
	update_option(SN.'_font_deck_name',$font_deck_name);
	
elseif($type=="Enigma-styler") :

	$data = $_POST['data'];

	$template =  $_POST['template'];
	
	$gc = urldecode($_POST['global_color']);
    
	$concave_val =  urldecode($_POST['concave_val']);
	update_option(SN.'concave_value',$concave_val);

	$new_data = array();
	foreach($data as $style )
	{
		$style = json_decode(stripslashes($style));
   

		if($style->target!="undefined")
		$new_data[] = array( "target" => urldecode($style->target) , "value" => urldecode($style->value) , "name" => urldecode($style->name)  ); 
	} 
	$data = $new_data;
	update_option(SN.'_global_color',$gc);
	
	if($template=="default")
		update_option(SN.'_enigma_data',$data);
	else
		update_option($template,$data);

	
	$code =  $en->getRuntimeCode($palette);


	update_option(SN.'_active_etemplate',$template);
	echo $template;
elseif($type=="Enigma-active") :

	$template = $_POST['template'];
	update_option(SN.'_active_etemplate',$template);
elseif($type=="Enigma-delete") :

	$table = get_option(SN.'enigma_hash');
	$key = $_POST['template'];	
	if(!$table  || !is_array($table)) $table = array();

	unset($table[$key]);
	
	update_option(SN.'enigma_hash',$table);
	update_option(SN.'_active_etemplate','default');

	echo $key;

elseif($type=="Enigma-styler-reset") :
	
	$template = $_POST['template'];
	if($template=="default")
		update_option(SN.'_enigma_data',array());
	else
		update_option($template,array());

	delete_option(SN.'_global_color');

elseif($type=='Enigma-import') :
	
	$data=  $_POST['value'];
	
	$data = base64_decode($data);	
	$input = json_decode($data,true);

	$name = str_replace("_"," ",$input[0]);
	$style = $input[1];
	$name = ucwords($name);

	$key = uniqid();

	$table = get_option(SN.'enigma_hash');

	if(!$table  || !is_array($table)) $table = array();

	$table['en'.$key] = $name;

	update_option(SN.'enigma_hash',$table);
	update_option('en'.$key,$style);

	echo "<option value='en".$key."'> $name </option>";
elseif($type=="visualizer_save"):
	$data = $_POST['data'];
	$bgs = $_POST['images'];
	update_option(SN.'visualizer_hash',$data);
	update_option(SN.'visualizer_images',$bgs);

elseif($type=='skin_import') :
global $ioa_helper;

$data = json_decode(base64_decode($_POST['code']),true);

$sch = $ioa_helper->getAssocMap($data['palette'],'value');
$title = $data['title'];

$in_schemes = array();
	
if(get_option(SN.'_pre_schemes'))
	 $in_schemes = get_option(SN.'_pre_schemes');

 $in_schemes[$title] = $sch;
update_option(SN.'_pre_schemes',$in_schemes);

elseif($type=='skin_export') :

	
	$tdata = array();
	$title = '';

	if(isset($_POST['palette']))
		$tdata = $_POST['palette'];

	if(isset($_POST['title']))
		$title = $_POST['title'];

	
    if(isset($_POST['skin'])) $tdata[] = array( "name" => 'skin' , "value" => $_POST['skin'] );	
 
	echo set_transient('SKIN_EXPORT',array( "palette" => $tdata , "title" => $title ) ,60*60);


elseif($type=='eni_fontface_del') :

if( ! isset($_POST['attachment_id']) ) return '0';

$file = $_POST['attachment_id'];

 //wp_delete_attachment($file, true );


$font_face_fonts = get_option(SN.'_fontface_fonts');

if(!$font_face_fonts) $font_face_fonts = array();

$dir = $font_face_fonts[$file]['dir'];

unset($font_face_fonts[$file]);
update_option(SN.'_fontface_fonts',$font_face_fonts);


function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

rrmdir($dir);

elseif($type=='eni_fontface') :


if( ! isset($_POST['attachment_id']) ) return '0';

$file = $_POST['attachment_id'];
$zip_file = get_attached_file($file);

$dir  = pathinfo($zip_file);
$zip_cr = false;


$zipArchive = new ZipArchive();
$result = $zipArchive->open($zip_file);
if ($result === TRUE) {
    $zipArchive ->extractTo($dir['dirname'].'/'.$dir['filename']);
    $zipArchive ->close();
    $zip_cr = true;
} else {
   return "0";
}


if($zip_cr) :

$stack = array( 'dir' => $dir['dirname'].'/'.$dir['filename'] );
$fnt = array('eot','svg','ttf','woff');

$upload_dir = wp_upload_dir();

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir['dirname'].'/'.$dir['filename']), RecursiveIteratorIterator::SELF_FIRST );

$upload_url = explode('uploads', $upload_dir['url']);
$upload_url = $upload_url[0].'uploads';


foreach ( $iterator as $path ) {
	
	if ($path->isDir()) {
	      //  print($path->__toString() . PHP_EOL.'<br>');
	    } else {
	        
	        $file = pathinfo($path->__toString());
	       
	        if( in_array($file['extension'],$fnt) )
	        {
	        	$stack[$file['extension']] = str_replace('\\','/' ,$upload_url.str_replace($upload_dir['basedir'],'',$path->__toString()));
	        	
	        }	
	    }

}

$font_face_fonts = get_option(SN.'_fontface_fonts');

if(!$font_face_fonts) $font_face_fonts = array();

$name = str_replace("-"," ", $dir['filename']);

$stack['name'] = $name;

$font_face_fonts[$_POST['attachment_id']] = $stack;

update_option(SN.'_fontface_fonts',$font_face_fonts);

echo $name ;

endif;

elseif($type=="sticky_contact") :


$qname = $_POST["name"];
$qemail = $_POST["email"];
$qmsg = $_POST["msg"];
$notify_email = $_POST["notify_email"];

$form_data = "Name : $qname \n Email : $qemail \n Message : $qmsg ";



function isEmail($email) { 
	
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));		
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");


$comments = strip_tags($form_data);

if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}

$address = $notify_email;
$e_subject = 'You\'ve have a message from '.$qname;

$e_body = $form_data . PHP_EOL . PHP_EOL;
$e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
		
$msg = wordwrap( $e_body , 70 );

$headers = "From: $qemail " . PHP_EOL;
$headers .= "Reply-To: $notify_email " . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;


if(mail($notify_email, $e_subject, $msg, $headers)) 
	echo "success";
else 
	echo 'ERROR!';

elseif($type=='options_import') :

$theme_options = $_POST['data'];

$theme_options = base64_decode($theme_options);	
$input = json_decode($theme_options,true);
	
foreach($input as $key => $val)
{
	$data = @unserialize($val["option_value"]);

	if (  $data === false) $data = $val["option_value"];
	else $data = unserialize($data);

	update_option($val["option_name"],$data);
}

echo 'done';	
elseif($type=='eni_delete_scheme') :

	$in_schemes = array();
	
	if(get_option(SN.'_pre_schemes'))
		 $in_schemes = get_option(SN.'_pre_schemes');

	unset($in_schemes[$_POST['id']]);	

	update_option(SN.'_pre_schemes',$in_schemes);
		
elseif($type=='eni_save_as_scheme') :
	$in_schemes = array();
	
	if(get_option(SN.'_pre_schemes'))
		 $in_schemes = get_option(SN.'_pre_schemes');
	
	$key = 'sc'.uniqid();
	if(isset($_POST['title'])) $key = $_POST['title'];

	

	$in_schemes[$key] = $ioa_helper->getAssocMap(json_decode(urldecode(stripslashes($_POST['palette'])),true),'value'); ;
    $in_schemes[$key]['skin'] = 'default';
    if(isset($_POST['skin'])) $in_schemes[$key]['skin'] = $_POST['skin'];	

    update_option(SN.'_pre_schemes',$in_schemes);

elseif($type=='eni_data') :
global $ioa_helper;
$data = get_option(SN.'_enigma_data');

if(!is_array($data)) $data = array();

$data['skin'] = $_POST['activeskin'];

$palette  =  $ioa_helper->getAssocMap(json_decode(urldecode(stripslashes($_POST['palette'])),true),'value'); ;
$data['palette'] = $palette;

$typo = $ioa_helper->getAssocMap($_POST['typography'],'value'); 

$data['boxed'] = $ioa_helper->getAssocMap($_POST['box_val'],'value'); 
$data['title_area'] = $ioa_helper->getAssocMap($_POST['title_val'],'value'); 


$data['typography'] = $typo;
$data['concave_editor'] = urldecode(stripslashes($_POST['ceditor']));

$data[SN."_font_deck_project_id"] = $_POST['font_deck_id'];
$data[SN."_font_deck_name"] = $_POST['font_deck_name'];

if(isset($_POST['custom_typo']))
$data['custom_typo_list'] = $_POST['custom_typo'];

update_option(SN.'_enigma_data',$data);
update_option(SN.'_custom_css',$data['concave_editor']);
update_option(SN.'_toggle_scheme',$_POST['toggle_scheme']);

 $en = new EnigmaDynamic();
$en->createCSSFile();


elseif($type=="options_save" && current_user_can('edit_pages')) :

	$new_values =  $_POST['values'];

	foreach($new_values as $value)
	{
	 	update_option( $value["name"], $value["value"] );
	}

elseif($type=='bbpress_setstatus') :

	$id = $_POST['id'];
	
	echo update_post_meta($id,'topic_status',$_POST['status']);

elseif($type=='runtime_css') :
	header('Content-Type: text/css');
	echo get_option(SN.'_compiled_css');

endif;

die();
}