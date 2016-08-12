<?php 
/**
 * Core Class For Creating Slider
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA V1
 */


 if(!class_exists('IOASliderItem'))
{
	class IOASliderItem
	{
		private $inputs;
		private $options;

		private $coordinates;
		
		function __construct($inputs,$options)
		{	
			$this->inputs = $inputs;
			$this->options = $options;
			$this->coordinates = $options['coordinates'];
			
		}

		function getOptions()
		{
			return $this->options;
		}

		function getInputKeys()
		{
			$keys = array();

			foreach($this->inputs as $k => $grouping)
			{
				foreach($grouping as $k => $input)
				{	
				
					if(isset($input['name']) )
					$keys[] =   $input['name'];
				}
				
			}

			return $keys;
		}

		function getMetaKeys()
		{
			$keys = array();

			foreach($this->inputs as $k => $grouping)
			{
				foreach($grouping as $k => $input)
				{	
				
					if(isset($input['meta']) )
					$keys[] =   $input['name'];
				}
				
			}

			return $keys;
		}

		public function getHTML($values = false)
		{
			 
			
			$markup = ''; $dy = '';

			

			$markup .= "<div class='media-slide clearfix'> 

								<div class='media-slide-head clearfix'>
									<a href='' class='mslide-edit edit-icon ioa-front-icon pencil-3icon-'>   </a>
									<a href='' class='mslide-delete'> <i class='ioa-front-icon cancel-circled-2icon- cross'></i> </a> ";


			if(isset($values['image']) && $values['image']!="") $markup .= "<img src='".$values['thumbnail']."' />";
			else  $markup .= "<img src='".HURL."/css/i/d.png' />";
			

			if(isset($values['text_title'])) $markup .=" <h6>".$values['text_title']."</h6>";
			$markup .= "</div>";



			$markup .= "<div class='slider-component-tab clearfix'><div class='inner-slide-body-wrap'><a href='' class='cross ioa-front-icon up-open-2icon- close-media-body'></a><ul class='clearfix'>";
			
			foreach($this->inputs as $k => $group)
			{
				$markup .= "<li><a href='#".str_replace(" ","_",$k)."'> $k </a></li>";
			}

			foreach($this->inputs as $k => $group)
			{


				$markup .= "</ul>
					
						<div id='".str_replace(" ","_",$k)."' class=\"slider-component-body clearfix\"><div class='clearfix inner-body-wrap'>
					";

				foreach($group as $k => $input)
				{	

					if(is_array($values))
					{

						if(isset($input['name']) && isset($values[ $input['name']]) )
						$input['value'] =  $values[ $input['name']];

						if(  isset($values[ $input['name'].'_data']) ) 
						{
							$input['value'] =  $values[ $input['name'].'_data'];
						}

					}	

					$markup .= getIOAInput($input);

				}
			
				$markup .= "</div></div>";

			}
			$markup .= "</div></div></div>";
			

			return $markup;
			
		}


		public function getOptionsHTML($values = false)
		{
			 
			
			$markup = ''; $dy = '';

			
			$markup .= "<div class='slider-component-tab clearfix'><div class='inner-slide-body-wrap'>";

			foreach($this->options['inputs'] as $k => $group)
			{


				$markup .= "
					
						<div id='".str_replace(" ","_",$k)."' class=\"slider-component-body clearfix\"><div class='clearfix inner-body-wrap'>
					";

				foreach($group as $k => $input)
				{	

					if(is_array($values))
					{

						if(isset($input['name']) && isset($values[ $input['name']]) )
						$input['value'] =  $values[ $input['name']];

						if(  isset($values[ $input['name'].'_data']) ) 
						{
							$input['value'] =  $values[ $input['name'].'_data'];
						}

					}	

					$markup .= getIOAInput($input);

				}
			
				$markup .= "</div></div>";

			}
			$markup .= "</div></div>";
			

			return $markup;
			
		}


		public function getUniq()
		{
			return str_replace(' ','_',$this->options['label']);
		}
											
		

	}
}

function add_slider_component($inputs,$options)
{
	global $ioa_sliders;
	$ioa_sliders[str_replace(' ','_',$options['label'])] = new IOASliderItem($inputs,$options);

}

add_action( 'after_setup_theme', 'setSliderData' );
function setSliderData() {

global $ioa_portfolio_slug,$ioa_portfolio_name;

$links = array( 'Default' => array('none' => "No Link" , "custom" => "Custom Link" ) , "Pages" => array() , "Posts" => array(), $ioa_portfolio_name => array()  );

$pages = get_posts('posts_per_page=-1&post_type=page');
$post = get_posts('posts_per_page=-1&post_type=post');
$portfolio = get_posts('posts_per_page=-1&post_type='.$ioa_portfolio_slug);

foreach ($pages as $key => $p) {
	$links["Pages"][$p->ID] = get_the_title($p->ID); 
}
foreach ($post as $key => $p) {
	$links["Posts"][$p->ID] = get_the_title($p->ID); 
}
foreach ($portfolio as $key => $p) {
	$links[$ioa_portfolio_name][$p->ID] = get_the_title($p->ID); 
}

$position_markup = "<h5> Select Caption Position </h5>
<div class='slide-pos-grid clearfix'> 
	<div class='s-t-l'>Top Left</div>
	<div class='s-t-c'>Top Center</div>
	<div class='s-t-r'>Top Right</div>
	
	<div class='s-c-l active'>Center Left</div>
	<div class='s-c-c'>Center Center</div>
	<div class='s-c-r'>Center Right</div>

	<div class='s-b-l'>Bottom Left</div>
	<div class='s-b-c'>Bottom Center</div>
	<div class='s-b-r'>Bottom Right</div>
</div>
";

// Slider Option
add_slider_component(array(
							"General Settings" => array(

							/*
							array( "label" => __("Select Slide Type",'ioa') , "name" => "slide_type" , "default" => "default" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array( "default" => "Default" ,"left-image" => "Left Image Staged" , "right-image" => "Right Image Staged" , "full-image" => "Full Image" , "none" => "No Image and Caption"  ) )  ,	
							 */
							
							array(  "label" => __("Upload Image",'ioa') , "name" => "image" ,"default" => "" ,"type" => "upload","description" => "","length" => 'medium' , 'class' => 'mm-filter left-image right-image full-image' )  ,
							array(  "label" => __("Image Alt Tag",'ioa') , "name" => "img_alt" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium', 'class' => 'mm-filter left-image right-image default') ,
							array(  "label" => __("Caption Background",'ioa') , "name" => "caption_bg" ,"default" => "none" ,"type" => "select","description" => "","length" => 'medium' , 'options' => array( "none" => "None" , "white-bg" => "White Background" , 'black-bg' => "Black Background" ) )  ,
						
							array( "alpha"=>false, "label" => __("Slide Text & Button Color",'ioa') , "name" => "g_color" ,"default" => "" ,"type" => "colorpicker", "description" => "", "length" => 'medium'),

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text", "description" => "", "length" => 'medium', 'class' => 'mm-filter left-image right-image default') ,
							

							array( "label" => __("Text",'ioa') , "name" => "text_desc" , "default" => "Your text here." , "type" => "textarea", "description" => "", "length" => 'medium', 'class' => 'mm-filter left-image right-image default') ,

							array( "label" => __("Set Link",'ioa') , "name" => "slide_link" , "default" => "custom" , "type" => "select", "description" => "", "length" => 'medium', 'class' => 'mm-filter left-image right-image default' , 'optgroup' => true, "options" => $links ) ,

							array(  "label" => __("Custom Link",'ioa') , "name" => "custom_link" ,"default" => "" ,"type" => "text", "description" => "", "length" => 'medium', 'class' => 'mm-filter left-image right-image default') ,

							

							
							array(  "label" => __("Image Thumbnail",'ioa') , "name" => "thumbnail" ,"default" => "" ,"type" => "hidden","description" => "","length" => 'medium')  ,
									

							),
							
							"Caption Settings" => array(

							
							array(  "label" => __("",'ioa') , "name" => "caption_position" ,"default" => "" ,"type" => "hidden","description" => "","length" => 'medium' , 'after_input' => $position_markup )  ,	
							
								

							),
							"Background Settings" => array(

					    array( 'name' => 'background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => 'none' , 'options' =>  array('none'=>'none','bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gradient'=>'Background Gradient','bg-video'=>'Background Video' ,'custom'=>'Custom') ),
					    array( 'name' => 'background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '#ffffff' , 'class' => ' mm-bg-listener bg-color custom'  ),
					   
					    array( 'name' => 'background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' mm-bg-listener bg-image bg-texture custom'  ),
					     array( 'name' => 'background_video', 'type' => 'video' , 'label' => 'Background Video' , 'default' => '' , 'class' => ' mm-bg-listener bg-video'  ),

						array( 'name' => 'video_fallback', 'type' => 'upload' , 'label' => 'Fallback Image(for older browsers & less than IE 10 and mobiles)' , 'default' => '', 'class' => ' mm-bg-listener  bg-video '),
					    array( 'name' => 'background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => 'custom mm-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
					    array( 'name' => 'background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => 'custom mm-bg-listener ' , "options" => array("", "auto","contain","cover") ),
					    array( 'name' => 'background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => 'custom mm-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
					    array( 'name' => 'background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => 'custom mm-bg-listener bg-texture bg-image' , 'label' =>"Background Fixed or Scroll" ),
					    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' mm-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
					    array( 'name' => 'start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '#ffffff', 'class' => ' mm-bg-listener  bg-gradient'   ),
					    array( 'name' => 'end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '#eeeeee' , 'class' => ' mm-bg-listener  bg-gradient'  ),

					)
							 

							 ),

						array(  "label" => __("Slider",'ioa')  ,"coordinates" => true , 
							 	"inputs" => array(
								
								"Slider Settings" => array(

							array( "label" => __("Select Slider Type",'ioa') , "name" => "slider_type" , "default" => "quantum_slider" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("slider" => __("Slider",'ioa') ,"gallery" => __("Gallery",'ioa') ) )  ,		

								array( "label" => __("Image Resize",'ioa') , "name" => "image_resize" , "default" => "default" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("default" => __("Cropped",'ioa'),"wproportional" => __("Proportional",'ioa') , "none" => "No Resizing" ) , 'class' => 'so-opts so-slider so-gallery' )  ,

							array( "label" => __("Width(in px)",'ioa') , "name" => "width" , "default" => "500" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Height(in px)",'ioa') , "name" => "height" , "default" => "350" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Full Width(Only for sliders)",'ioa') , "name" => "full_width" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa'))  , 'class' => 'so-opts so-slider  so-quantum_slider')  ,
							array( "label" => __("Adaptive height",'ioa') , "name" => "adaptive" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) , 'class' => 'so-opts so-slider ')  ,
							
							


							array( "label" => __("Slide Show Time(in secs)",'ioa') , "name" => "duration" , "default" => "4" , "type" => "text", "description" => "", "length" => 'medium') ,
							array( "label" => __("Autoplay",'ioa') , "name" => "autoplay" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Captions",'ioa') , "name" => "captions" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Use lightbox",'ioa') , "name" => "lightbox" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Controls",'ioa') , "name" => "arrow_control" , "default" => "true" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
							array( "label" => __("Bullets / Thumbnail",'ioa') , "name" => "bullets" , "default" => "false" , "type" => "select", "description" => "", "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) , 'class' => 'so-opts so-slider so-gallery' )  ,
							

							)

							 	)
							 )

					);	

}