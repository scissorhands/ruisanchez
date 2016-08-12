<?php 
/**
 * Core Class For Create RAD Builder Components
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA Framework V1
 */


global $radunits;


 if(!class_exists('RADUnit'))
{
	class RADUnit
	{
		public $data;
		
		function __construct($data)
		{	
			$this->data = $data;
			$def_style = array();
			
		}


		function getThumb($opts = false)
		{
			$data = $this->data;

			$d ='';

			if(isset($data['data']) )
			{
				foreach ($data['data'] as $key => $v) {
					$d = " data-$key = '$v' ";
				}
			}
			$icon = '';

			if($data['icon']!="") 
				$icon = '<span id="rad-icon-'.$data['id'].'" class="rad-icon ioa-front-icon '.$data['icon'].' " ></span>'; 
			else 
				$icon = '<span id="rad-icon-'.$data['id'].'" class="rad-icon" ></span>';

			if( is_array($opts) && isset($opts['alt']) )
			{
				$de_i = 'C';
				if(isset($data['alt-icon'])) 
					$de_i = $data['alt-icon'];
				$icon = '<span id="rad-icon-'.$data['id'].'" class="rad-icon alt-mode" >'.$de_i.'</span>';
			}

			if(!isset($data['feedback'])) $data['feedback'] = '';

			return '<div class="rad-thumb  cl-'.$data['id'].' cl-'.$data['group'].'" '.$d.' data-group="'.$data['group'].'" data-label="'.$data['label'].'" data-id="'.$data['id'].'" id="thumb-'.$data['id'].'"> '.$icon.' <span class="label">'.$data['label'].'</span> <div class="v-f-d">'.$this->getVisualFeedback($this->getDefaults()).'</div> </div>';
		}
		function mapSettingsOverlay()
		{
			global $rad_defaults;
			$data = $this->data;

			if($data['id']=='rad_page_container_80') $data['id'] = 'rad_page_container';

			$markup = '<div class="settings-pane '.$data['id'].'" data-id="'.$data['id'].'"><div class="rad-widget-settings">';
			$markup .= '<h4> '.$data['heading'].' <span class="custom-id"></span>  </h4><div class="input-section-tabs"><ul class="clearfix">';

			foreach ($data['inputs'] as $key => $values) {
				$markup .= '<li><a href="#'.str_replace(' ','_',$key).'" class=""> '.$key.' </a></li>';
			}

			if(isset($data['styles']))
				$markup .= '<li><a href="#rad_style_'.$data['id'].'">'.__('Widget Custom Style','ioa').'</a></li>';
			
			$markup .= "</ul>";

			foreach ($data['inputs'] as $key => $values) {
				$markup .= '<div id="'.str_replace(' ','_',$key).'">';

					
						if(is_array($values))
						{

							foreach ($values as $key => $input) {

								if( $key === 'supports' )
								{
									if(is_array($input))
									{
										foreach ($input as $subinput) {

											if(isset($rad_defaults[$subinput]['set']))
											{
												foreach ($rad_defaults[$subinput]['inputs'] as  $inp) {
													$markup .= getIOAInput($inp);
												}
											}
											else
												$markup .= getIOAInput($rad_defaults[$subinput]);
										}
									}
									else
										$markup .= getIOAInput($rad_defaults[$input]);	
								}
								else
									{
										$markup .= getIOAInput($input);
									}
							}

						}	

						


				$markup .='</div>';	
			}

			if(isset($data['styles']))
				$markup .=''.$this->getVisualSettings().'';

			$markup .='</div></div>';

			

			$markup .= '</div>';	

			return $markup;
		}

		function getVisualFeedback($values = array())
		{
			$data = $this->data;
			if( isset($data['feedback']) )
			{
				$identifier = ' <div class="rad-identifier"><i class="ioa-front-icon '.$this->data['icon'].'"></i> <span>'.$this->data['label'].'</span></div> ';	
				$feedback = $data['feedback'];

				$cv = '';
						
				 if(isset($values['gallery_images']) && trim($values['gallery_images']) != "" ) : $ar = explode(";",stripslashes($values['gallery_images']));
				
							foreach( $ar as $image) :
								if($image!="") :
									$g_opts = explode("<<",$image);
								if(trim($g_opts[0])!="") :
	 						
								$cv .=  "<img src='".$g_opts[0]."' />";
							endif; endif;
						endforeach; 
						endif; 
						$feedback =  str_replace('{gallery_images}', $cv,$feedback);


				if( isset($values) && is_array($values) )
					foreach ($values as $key => $value) {

						$value =  str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;','&lt;' ), array('\'','"','[',']','<'), $value); 
						

						$value = strip_tags($value);	
						if($key == 'icon' && $value!== "") 
						{
							if(!strpos($value,'ioa_icon'))
							  {
							   $value = "<img src='".$value."' />";
							  } 
							  else
							  	$value = do_shortcode($value);

							if(isset($values['col_style']) && $values['col_style']=='image-box')  
							{
								 $value = "<img src='".$values['top_image']."' />";
							}  

						}

						if($key == 'contact_id')
						{
							$feedback = str_replace('{'.$key.'}', get_the_title($value),$feedback);
						}	
						
						$feedback = str_replace('{'.$key.'}', $value,$feedback);

					}

				if($this->data['id'] == 'rad_logo_widget')
				{
					$feedback = '<h2>'.__('Showing Logos ').'</h2>';
					if( isset($values['rad_tab']) && $values['rad_tab']!="" ) :
						$tab_data = $values['rad_tab'];
						$tab_data = explode('[ioa_mod]',$tab_data);
						
					  $len = count($tab_data) - 1;


						foreach ($tab_data as $key => $value) {
									
									if($value!="")
									{
										$inpval = array();
										$mods = explode('[inp]', $value);	
										foreach($mods as $m)
										{
											if($m!="")
											{
												$te = (explode('[ioas]',$m));  

												if( count($te) == 1 ) $te = (explode(';',$m));  
												if($te[0] == 'logo_icon')
												{
													$feedback .= '<img src="'.$te[1].'" />';
												}
												
											}
										}
									
									}	
							}
					endif;

				}	
				
				

				return "<div class='v-feedback clearfix'>".$feedback."</div>".$identifier;
			}
			else return '';
		}

		function getStyleKeys()
		{
			$data = $this->data;
			$keys = array();

			if(isset($data['styles']) && is_array($data['styles']))
			foreach ($data['styles'] as $key => $group) {
				
				if(is_array($group))
				foreach ($group as $key => $style) {

					if($style['type']=='slider')
						$keys[] = array( 'name' => $style['name']  , 'data' => $style['data'] , 'type' => $style['type'] , 'suffix' => $style['suffix'] );
					else	
						$keys[] = array( 'name' => $style['name']  , 'data' => $style['data'] , 'type' => $style['type'] );
				}
			}

			return $keys;
		}

		function getVisualSettings()
		{
			
			$data = $this->data;

			if(count($data['styles'])==0) return '';

			$markup = '<div class="rad-styler" id="rad_style_'.$data['id'].'"><div class="visual-settings-pane">';
			
			$markup .= '<div class="inner-visual-settings-panel">';


			if(isset($data['styles']))
			foreach($data['styles'] as $k => $group)
			{

				$markup .= "
						<h3 class='sub-styler-title'>".$k." <a href='' class='style-reset'>Reset</a></h3>
						<div  class=\"rad-styler-section clearfix\">
					";
				if(is_array($group))
				foreach($group as $key => $input)
				{	
					$input['noname'] = true;
					$markup .= getIOAInput($input);
					
				}

			
				$markup .= "</div>";

			}

			$markup .='</div>';	


			$markup .= '</div></div>';	

			return $markup;

		}
		
		// Functions to Generate JSON Values for Builder
		 
		function createWidgetIOAStyles($values = array())
		{
			$data = $this->data;
			
			$markup = array();
			if(isset($data['styles']))
			foreach ($data['styles'] as $key => $v) {
						if(is_array($v))
						{
							
							foreach ($v as $key => $input) {
								$markup[] = "'".$input['name']."'";
							}

						}	
			}
			return join(',',$markup);
		}
		function createWidgetIOAInputs($values = array())
		{
			global $rad_defaults;
			$markup = '';
			$data = $this->data;
			
			$markup = array();

			foreach ($data['inputs'] as $key => $v) {
						if(is_array($v))
						{
							
							foreach ($v as $key => $input) {
								$t = ''; 

								if( $key === 'supports' )
								{
									if(is_array($input))
									{

										foreach ($input as $subinput) {
											$tinput = $rad_defaults[$subinput];
												
											if(isset($tinput['set']))
											{
												foreach ($tinput['inputs'] as  $inp) {
													if(isset($inp['default'])) $t = $inp['default'];
													if(isset($values[$inp['name']])) $t = $values[$inp['name']];
													$markup[] = " { value : '".addslashes($t)."' , name : '".$inp['name']."' }  ";
												}
											}
											else
											{

												if(isset($tinput['default'])) $t = $tinput['default'];
												if(isset($values[$tinput['name']])) $t = $values[$tinput['name']];
												$markup[] = " { value : '".addslashes($t)."' , name : '".$tinput['name']."' }  ";
											}

										}
									}
									else
										{
											$tinput = $rad_defaults[$input];
											if(isset($tinput['default'])) $t = $tinput['default'];
											if(isset($values[$tinput['name']])) $t = $values[$tinput['name']];
											$markup[] = " { value : '".addslashes($t)."' , name : '".$tinput['name']."' }  ";
										}
								}
								else
								{
									if(isset($input['default'])) $t = $input['default'];
									if(isset($values[$input['name']])) $t = $values[$input['name']];
									$markup[] = " { value : '".addslashes($t)."' , name : '".$input['name']."' }  ";
								}
							}

						}	
			}

			if(isset($data['styles']))
			foreach ($data['styles'] as $key => $v) {
						if(is_array($v))
						{
							
							foreach ($v as $key => $input) {
								$t = ''; 
								if(isset($input['default'])) $t = '';
								if(isset($values[$input['name']])) $t = $values[$input['name']];

								$markup[] = " { value : '".($t)."' , name : '".$input['name']."' }  ";
							}

						}	
			}
			return join(',',$markup);
		}

		function getDefaults()
		{
			global $rad_defaults;
			$values = array();
			$data = $this->data;

			foreach ($data['inputs'] as $key => $group) {
				
				foreach ($group as $key => $input) {

					if( $key === 'supports' )
					{
						if(is_array($input))
						{
							foreach ($input as $subinput) {
								$tinput = $rad_defaults[$subinput];

								if(isset($tinput['set']))
											{
												foreach ($tinput['inputs'] as  $inp) {
													if(isset($tinput['default']))
														$values[$inp['name']] = $inp['default'];
													else
														$values[$inp['name']] = '';
												}
											}
								else{

									if(isset($tinput['default']))
										$values[$tinput['name']] = $tinput['default'];
									else
										$values[$tinput['name']] = '';

								}			
								
							}
						}
						else
							{
								$tinput = $rad_defaults[$input];
								if(isset($tinput['default']))
									$values[$tinput['name']] = $tinput['default'];
								else
									$values[$tinput['name']] = '';
							}
					}
					else
					{
						if(isset($input['default']))
							$values[$input['name']] = $input['default'];
						else
							$values[$input['name']] = '';
					}
				}	

			}
			
			return $values;
		}

		function getCommonKey()
		{
			if(isset($this->data['common_key'])) return $this->data['common_key'];
			else return '';
		}

		
	}

}

/**
 * Widget Defaults & Variables
 */
add_action( 'after_setup_theme', 'setRADUNITSDAA' );

function setRADUNITSDAA(){

global $radunits,$ioa_helper,$ioa_portfolio_slug,$ioa_portfolio_name;
$title_default_stylings =  array(

					array( 
						"label" => __("Title Color",'ioa') , "name" => "title_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .ioa-widget-title " ,"property" => "color" )     
					),

					array( 
						"label" => __("Title Size",'ioa') , 
						"name" => "title_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 100,
						"value" => 0 ,
						"suffix" => "px",
						 "data" => array(

					 			"target" => " .ioa-widget-title  " ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Title Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " .ioa-widget-title  " ,
					 			"property" => "font-weight" 

		 				)     
					),
					

				);

$demo_imgs = array(
		URL."/sprites/i/demos/d1.jpg",
		URL."/sprites/i/demos/d2.jpg",
		URL."/sprites/i/demos/d3.jpg"
	);

$demo_thumbs = array(
		URL."/sprites/i/demos/d1.jpg",
		URL."/sprites/i/demos/d2.jpg",
		URL."/sprites/i/demos/d3.jpg"
	);

$pmb ='';

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
							"syntax" => '[post_tags sep=\',\'  /]',
							),	
					"post_categories" => array(
							"name" =>  __("Post Categories",'ioa'),
							"syntax" => '[post_categories sep=\',\'  /]',
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
$post_type_array = array("post" => __("Post",'ioa') , $ioa_portfolio_slug => $ioa_portfolio_name);

$pages = get_posts('posts_per_page=-1&post_type=custompost&post_status=publish');

foreach ($pages as $key => $p) {
	$coptions = get_post_meta($p->ID,'options',true);
	$w = $ioa_helper->getAssocMap($coptions,'value');
	$post_type_array[$w['post_type']] = get_the_title($p->ID);

}





// Structure Widgets

$radunits['rad_page_section'] = new RADUnit(array(

		'label' => __('Page Section','ioa'),
		'id' => 'rad_page_section',
		'group'	=> 'section',
		'icon' => '',
		'alt-icon' => 'Section',
		'heading' => 'Section Settings',
		'inputs' => array(

				'Layout Settings' => array(

						array( 'name' => 'section_name' , 'type' => 'text' , 'label' => 'Enter Section Name(will be used in menu item for One Page System)' , 'default' => 'Section' ),
						array( 'name' => 'v_padding_top', 'type' => 'slider' , 'max' => 400 , "suffix" => "px" , 'label' => 'Top Padding' , 'default' => 0 ),
						array( 'name' => 'v_padding_bottom', 'type' => 'slider' , 'max' => 400 , "suffix" => "px" , 'label' => 'Bottom Padding' , 'default' => 0 ),
						array( 'name' => 'classes' , 'type' => 'text' , 'label' => 'Enter Custom Classes' , 'default' => '' ),
						array( 'name' => 'visibility' , 'type' => 'checkbox' , 'label' => 'Hide Section on' , 'default' => 'None' , 'options' => array('None','Screen','iPad Horizontal','iPad Vertical & Small Tablets','Mobile Landscape','Mobile Potrait') ),
						array( 'name' => 'layout' , 'type' => 'select' , 'label' => 'Section Layout' , 'default' => 'Contained' , 'options' => array('Contained','Full Width',"Cell Blocks"  ) ),


					),
				'Background Settings' => array(

					    array( 'name' => 'background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'None' , 'primary-color' => 'Set Primary Color', 'primary-alt-color' => 'Set Alternate Primary Color' , 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','bg-video'=>'Background Video','custom'=>'Custom') ),
					    
					    array( 'name' => 'background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' sec-bg-listener bg-color '  ),
					    array(  "label" => __("Background Opacity",'ioa') , "name" => "bg_opacity" , "default" => "100" , "type" => "slider",  "length" => 'medium' , "suffix" => "%" , "max" => 100 , 'class' => ' sec-bg-listener bg-color '  ),
					    array( 'name' => 'background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' sec-bg-listener bg-image bg-texture'  ),
					    array( 'name' => 'background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' sec-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
					    array( 'name' => 'background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' sec-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
					    array( 'name' => 'background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' sec-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
					    array( 'name' => 'background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' sec-bg-listener bg-texture bg-image' , 'label' =>"Background Attachment" ),
					    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' sec-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
					    array( 'name' => 'start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' sec-bg-listener  bg-gradient'   ),
					    array( 'name' => 'end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' sec-bg-listener  bg-gradient'  ),
						array( 'name' => 'video_url', 'type' => 'video' , 'label' => 'Enter Video Link(MP4 Only) ' , 'default' => '', 'class' => ' sec-bg-listener bg-video'  ),

						array( 'name' => 'video_pos', 'type' => 'select' , 'label' => 'Video Position' , 'default' => 'middle-pos', 'class' => ' sec-bg-listener bg-video' , "options" => array("middle-pos" => "Centered" , "top-pos" => "Top" ,"bottom-pos" => "Bottom" ) ),

						array( 'name' => 'video_fallback', 'type' => 'upload' , 'label' => 'Fallback Image(for older browsers & less than IE 10)' , 'default' => '', 'class' => ' sec-bg-listener bg-video '),

					),

				'Background Overlay Settings' => array(
						 array( 'name' => 'ov_use' ,'default'=>"no" , "options" => array("no" => __("No",'ioa'),"yes"=> __("Yes",'ioa') ) , 'type' => 'select' , 'label' =>"Use Overlay Layer" ),

					   	array(  "label" => __("Overlay Opacity",'ioa') , "name" => "ov_opacity" , "default" => "60" , "type" => "slider",  "length" => 'medium' , "suffix" => "%" , "max" => 100  ),

					    array( 'name' => 'ov_background_color', 'type' => 'colorpicker' , 'label' => 'Overlay Color' , 'default' => ''  ),
					    array( 'name' => 'ov_background_image', 'type' => 'upload' , 'label' => 'Overlay Image' , 'default' => ''  ),
					    array( 'name' => 'ov_background_position' , 'type' => 'select' , 'label' => 'Overlay Image Position', 'default' => ''  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
					    array( 'name' => 'ov_background_cover' , 'type' => 'select' , 'label' => 'Overlay Image Cover', 'default' => '' , "options" => array("none", "auto","contain","cover") ),

					    array( 'name' => 'ov_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") ,'type' => 'select' , 'label' =>"Overlay Image Repeat"  ),

					    array( 'name' => 'ov_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select'  , 'label' =>"Overlay Image Attachment" ),

					    array( 'name' => 'ov_use_gradient_dir' ,'default'=>"no" , "options" => array("no" => __("No",'ioa'),"yes"=> __("Yes",'ioa') ) , 'type' => 'select' , 'label' =>"Use Gradient" ),

					    array( 'name' => 'ov_background_gradient_dir' ,'default'=>"" , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Overlay Gradient" ),
					    array( 'name' => 'ov_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => ''  ),
					    array( 'name' => 'ov_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => ''  ),
					

					),

				'Border Settings' => array(

						array( 'name' => 'border_top_width' , 'type' => 'text' , 'label' => 'Border Top Width' , 'default' => '0' ),
						array( 'name' => 'border_top_color' , 'type' => 'colorpicker' , 'label' => 'Border Top Color' , 'default' => '' ),
						array( 'name' => 'border_top_type' , 'type' => 'select' , 'label' => 'Border Top Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),
						array(  "label" => __("Border Top Opacity",'ioa') , "name" => "border_top_opacity" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "%" , "max" => 100  ),

						array( 'name' => 'border_bottom_width' , 'type' => 'text' , 'label' => 'Border Bottom Width' , 'default' => '0' ),
						array( 'name' => 'border_bottom_color' , 'type' => 'colorpicker' , 'label' => 'Border Bottom Color' , 'default' => '' ),
						array( 'name' => 'border_bottom_type' , 'type' => 'select' , 'label' => 'Border Bottom Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),

						array(  "label" => __("Border Bottom Opacity",'ioa') , "name" => "border_bottom_opacity" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "%" , "max" => 100  ),


					)

			) 

	));

$container_settings  = array(
		'common_key' => 'c',
		'label' => __('Column','ioa'),
		'id' => 'rad_page_container',
		'group'	=> 'structure',
		'alt-icon' => 'Column',
		'icon' => '',
		'heading' => 'Container Settings',
		'data' => array('default' => ''),
		'inputs' => array(

				'Layout Settings' => array(

						array( 'name' => 'classes' , 'type' => 'text' , 'label' => 'Enter Custom Classes' , 'default' => '' ),
						array( 'name' => 'visibility' , 'type' => 'checkbox' , 'label' => 'Hide on' , 'default' => 'None' , 'options' => array('None','Screen','iPad Horizontal','iPad Vertical & Small Tablets','Mobile Landscape','Mobile Potrait') ),
						array( "label" => __("Container Layout",'ioa') , "name" => "float" , "default" => "left" , "type" => "select",  "length" => 'medium'  , "options" => array("left" => __("Float Left",'ioa'),"right" => __("Float Right",'ioa'),"auto_align" => __("Center(It should be only column in section)",'ioa') ) , "data" => array("attr" => "float-test" )  )  ,

					),
				'Background Settings' => array(

					    array( 'name' => 'background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'none','bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
					    array( 'name' => 'background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' sec-bg-listener bg-color '  ),
					    array( 'name' => 'background_opacity', 'type' => 'text' , 'label' => 'Background Opacity' , 'default' => '' , 'class' => ' sec-bg-listener bg-color '  ),
					    array( 'name' => 'background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' sec-bg-listener bg-image bg-texture'  ),
					    array( 'name' => 'background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' sec-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
					    array( 'name' => 'background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' sec-bg-listener ' , "options" => array("", "auto","contain","cover") ),
					    array( 'name' => 'background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' sec-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
					    array( 'name' => 'background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' sec-bg-listener bg-texture bg-image' , 'label' =>"Background Attachment" ),
					    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' sec-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
					    array( 'name' => 'start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' sec-bg-listener  bg-gradient'   ),
					    array( 'name' => 'end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' sec-bg-listener  bg-gradient'  ),

					),
				'Border Settings' => array(

						array( 'name' => 'border_top_width' , 'type' => 'text' , 'label' => 'Border Top Width' , 'default' => '0' ),
						array( 'name' => 'border_top_color' , 'type' => 'colorpicker' , 'label' => 'Border Top Color' , 'default' => '' ),
						array( 'name' => 'border_top_type' , 'type' => 'select' , 'label' => 'Border Top Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),

						array( 'name' => 'border_bottom_width' , 'type' => 'text' , 'label' => 'Border Bottom Width' , 'default' => '0' ),
						array( 'name' => 'border_bottom_color' , 'type' => 'colorpicker' , 'label' => 'Border Bottom Color' , 'default' => '' ),
						array( 'name' => 'border_bottom_type' , 'type' => 'select' , 'label' => 'Border Bottom Type' , 'default' => '' , 'options' => array('','solid','dashed','dotted') ),

					),
				'Margin Control' => array(

						 array( 'name' => 'use_margin' ,'default'=>"no" , "options" => array("no"=> __("No",'ioa'),"yes" => __("Yes",'ioa')) , 'type' => 'select' , 'label' =>"Override Default Margin Settings" ),

						 array(  "label" => __("Top Container Margin",'ioa') , "name" => "margin_top" , "default" => "50" , "type" => "slider",  "length" => 'medium' , "suffix" => "px" , "max" => 300  ),

						  array(  "label" => __("Bottom Container Margin",'ioa') , "name" => "margin_bottom" , "default" => "50" , "type" => "slider",  "length" => 'medium' , "suffix" => "px" , "max" => 300  ),
			


						

					)

			) 

	);

$variants = array(

'rad_page_container' =>	array( "data" => array('default'=>'full') , "label" => 'Column'   ),
'rad_page_container_50' =>	array( "id"=>"rad_page_container_50","data" => array('default'=>'one_half') , "label" => '1/2 Column' , 'alt-icon' => '1/2' ),
'rad_page_container_33' =>	array( "id"=>"rad_page_container_33","data" => array('default'=>'one_third') , "label" => '1/3 Column' , 'alt-icon' => '1/3' ),
'rad_page_container_25' =>	array( "id"=>"rad_page_container_25","data" => array('default'=>'one_fourth') , "label" => '1/4 Column' , 'alt-icon' => '1/4' ),
'rad_page_container_20' =>	array( "id"=>"rad_page_container_20","data" => array('default'=>'one_fifth') , "label" => '1/5 Column' , 'alt-icon' => '1/5' ),
'rad_page_container_66' =>	array( "id"=>"rad_page_container_66","data" => array('default'=>'two_third') , "label" => '2/3 Column' , 'alt-icon' => '2/3' ),
'rad_page_container_75' =>	array( "id"=>"rad_page_container_75","data" => array('default'=>'three_fourth') , "label" => '3/4 Column' , 'alt-icon' => '3/4' ),
'rad_page_container_80' =>	array( "id"=>"rad_page_container_80","data" => array('default'=>'four_fifth') , "label" => '4/5 Column' , 'alt-icon' => '4/5' ),

	);

foreach ($variants as $key => $col) {
	$temp = array_merge($container_settings,$col);
	$radunits[$key] = new RADUnit($temp);
}


$links = array(  "Pages" => array() , "Posts" => array(), $ioa_portfolio_name => array()  );

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
$links_only = $links;
$links = array_merge( array('Default' => array('none' => "No Link" , "custom" => "Custom Link" , "video" => "Open Video in Lightbox" , "image" => "Open Image in Lightbox" )) , $links );

$radunits['rad_text_widget'] = new RADUnit(array(
	'label' => __('Text','ioa'),
	'id' => 'rad_text_widget',
	'template' => 'text',
	'group'	=> 'widgets',
	'icon' => 'text-widthicon-',
	'heading' => 'Text Settings',
	'feedback' => " <div class='text-icon vf-icon'>{icon}</div> <div class='text-info'> <h2 class='vf-text_title'>{text_title}</h2><h4 class='vf-text_subtitle'>{text_subtitle}</h4> <div class='vtext vf-text_data'>{text_data}</div> </div> ",
	'inputs' => array(
			__("Column Inputs",'ioa') => array(

			
			array( "label" => __("Column Style",'ioa') , "name" => "col_style" , "default" => "" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => "None" , "centered" => "Centered", "left-icon" => "Left Icon Box", "right-icon" => "Right Icon Box" ,"boxed" => "Hover Color Box","iconed" =>"Top Icon Box","iconed-alt" =>"Alternate Icon Box" ,"image-box" =>"Top Image") , "data" => array("attr" => "text-align" , "el" => ".text-inner-wrap")  )  ,

			
			array(  "label" => __("Top Image",'ioa') , "name" => "top_image" ,"default" => "" ,"type" => "upload" , 'class' => "image-box" ,  "length" => 'medium') ,
			array( "label" => __("Top Image Resizing",'ioa') , "name" => "image_resize" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Full Stretch(Cropped)",'ioa'),"hard" => __("Proportional",'ioa') , "none" => "No Resizing"  ) , 'class' => "image-box" ),  
			array(  "label" => __("Height",'ioa') , 'class' => "image-box"  , "name" => "height" ,"default" => "300" ,"type" => "text",  "length" => 'medium') ,
			array(  "label" => __("Auto Width",'ioa') , 'class' => "image-box"  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,
			array(  "label" => __("Width",'ioa') , 'class' => "image-box"  , "name" => "width" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,

			array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,

			array(  "label" => __("Subtitle",'ioa') , "name" => "text_subtitle" ,"default" => "Sub Title" ,"type" => "text","length" => 'medium')  ,
			array( "label" => __("Text",'ioa') , "name" => "text_data" , "default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultrices, nisl ac lobortis ultrices, enim dolor malesuada risus, id lacinia sapien metus scelerisque mauris. Aliquam elementum a libero nec euismod. Nunc ut sapien et augue faucibus aliquam. " , "type" => "textarea",  "length" => 'medium' , 'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>'),

			array( "label" => __("Set Link",'ioa') , "name" => "col_link" , "default" => "none" , "type" => "select",  'optgroup' => true, "options" => $links ) ,

			array(  "label" => __("Custom Link",'ioa') , "name" => "custom_link" ,"default" => "" ,"type" => "text", 'class'=> "ioa-link-filter custom" ) ,

			array(  "label" => __("Enter Video Link",'ioa') , "name" => "video_link" ,"default" => "" ,"type" => "text", 'class'=> "ioa-link-filter video" ) ,

			array(  "label" => __("Image",'ioa') , "name" => "image_link" ,"default" => "" ,"type" => "upload", 'class'=> "ioa-link-filter image" ) ,


			array(  "label" => __("Button label",'ioa') , "name" => "button_label" ,"default" => "More" ,"type" => "text",  ) ,

			),

			__("Animation Settings",'ioa') => array(
			
			array(  "label" => __("Column Animation on Scroll",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa') , "icon-animate" => "Animate Icon"   )  ),
			array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
			
			
			),

			__("Icon Settings",'ioa') => array(  
			array(  "label" => __("Set Icon",'ioa') , "name" => "icon" ,"default" => "" ,"type" => "text","after_input" => "<a href='' class='scrouge add-rad-icon button-default'>".__('Set Icon','ioa')."</a>" ,"length" => 'medium')  ,
			array(  "label" => __("Set Icon",'ioa') , "name" => "icon_hidden" ,"default" => "" ,"type" => "hidden")  ,
			array(  "label" => __("Icon Top Margin Correction" ,'ioa') ,  "name" => "icon_margin" ,"default" => "0" ,"type" => "text","length" => 'medium', "data" => array("attr" => "top-margin" , "el" => "div.icon"))  ,
			
			)

		),

	'styles' => array(
			__("Columns Styling",'ioa') => array(

					array( 
						"label" => __("Icon Box Hover Color",'ioa') , "name" => "box_hover_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .ioa-text-column.boxed:hover  " ,"property" => "background" , "extra_cl" => array(

						 	".ioa-text-column.boxed:hover i.longshadow-style" => "color",
						 	".ioa-text-column.boxed:hover i.longshadow-style-circ" => "color",
						 	".ioa-text-column.boxed:hover i.background-style" => "color",
						 	".ioa-text-column.boxed:hover i.background-style-circ" => "color"

						 	)

						  )     
					),

					array( 
						"label" => __("Title Color",'ioa') , "name" => "title_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .ioa-text-column h2 " ,"property" => "color" )     
					),
					array( 
						"label" => __("Subtitle Color",'ioa') , "name" => "subtitle_color" , "default" => "" , "type" => "colorpicker","value" => "",
						 "data" => array("target" => " .ioa-text-column h4 " ,"property" => "color" )     
					),
					array( 
						"label" => __("Text Color",'ioa') , 
						"name" => "text_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						
						"value" => "",
						 "data" => array(

					 			"target" => " .ioa-text-column div.ioa-text " ,
					 			"property" => "color" , "extra_cl" => array(

						 	".ioa-text-column p " => "color",

						 	) 


		 					)     
					),
					array( 
						"label" => __("Link Color",'ioa') , 
						"name" => "link_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						
						"value" => "",
						 "data" => array(

					 			"target" => " .ioa-text-column .ioa-more-button " ,
					 			"property" => "color", "extra_cl" => array(

						 	".ioa-text-column .ioa-more-button:hover " => "border-color",

						 	) 

		 					)  


					)

				),

			__("Font Size Settings",'ioa') => array(

					array( 
						"label" => __("Title Size",'ioa') , 
						"name" => "title_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 100,
						"value" => 0 ,
						"suffix" => "px",
						 "data" => array(

					 			"target" => " .ioa-text-column h2 " ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Title Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " .ioa-text-column h2 " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Subtitle Size",'ioa') , 
						"name" => "subtitle_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " .ioa-text-column h4 " ,
					 			"property" => "font-size" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Font Weight",'ioa') , 
						"name" => "subtitle_w" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " .ioa-text-column h4 " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Text Size",'ioa') , 
						"name" => "text_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => "  .ioa-text-column div.ioa-text " ,
					 			"property" => "font-size" 

		 					)     
					)

				),

			
			__("Margin Settings",'ioa') => array(

					
					array( 
						"label" => __("Title Top Margin",'ioa') , 
						"name" => "tt_margin" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => ".ioa-text-column h2 " ,
					 			"property" => "margin-top" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Top Margin",'ioa') , 
						"name" => "st_margin" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " .ioa-text-column h4 " ,
					 			"property" => "margin-top" 

		 				)     
				),
				
					array( 
						"label" => __("Text Top Margin",'ioa') , 
						"name" => "tet_margin" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " .ioa-text-column div.ioa-text " ,
					 			"property" => "margin-top" 

		 					)     
					)

				)

		)		

	));

/**
 * RAW HTML Widget
 */

$radunits['rad_html_widget'] = new RADUnit(array(
	'label' => __('HTML Text','ioa'),
	'id' => 'rad_html_widget',
	'template' => 'html',
	'group'	=> 'widgets',
	'icon' => 'html5-1icon-',
	'heading' => 'HTML Text Settings',
	'feedback' => " <div class='text-info'> <h2 class='vf-text_title'>{text_title}</h2><h4 class='vf-text_subtitle'>{text_subtitle}</h4> <div class='vtext vf-text_data'>{text_data}</div> </div> ",
	'inputs' => array(
			__("Column Inputs",'ioa') => array(

			
			
			array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,

			array(  "label" => __("Subtitle",'ioa') , "name" => "text_subtitle" ,"default" => "Sub Title" ,"type" => "text","length" => 'medium')  ,
			array( "label" => __("Text",'ioa') , "name" => "text_data" , "default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultrices, nisl ac lobortis ultrices, enim dolor malesuada risus, id lacinia sapien metus scelerisque mauris. Aliquam elementum a libero nec euismod. Nunc ut sapien et augue faucibus aliquam. " , "type" => "textarea",  "length" => 'medium'),

			array(  "label" => __("Column Text Alignment",'ioa') , "name" => "col_align" , "default" => "left" , "type" => "select",  "length" => 'medium'  , "options" => array("left" => __("left",'ioa') , "right" => __("Right",'ioa') , "center" => __("Center",'ioa')  , "justify" => __("Justify",'ioa')   )  ),

			),

			__("Animation Settings",'ioa') => array(
			
			array(  "label" => __("Column Animation on Scroll",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
			array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
			
			
			)

		),

	'styles' => array(
			__("Columns Styling",'ioa') => array(

					array( 
						"label" => __("Title Color",'ioa') , "name" => "title_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .ioa-text-column h2 " ,"property" => "color" )     
					),
					array( 
						"label" => __("Subtitle Color",'ioa') , "name" => "subtitle_color" , "default" => "" , "type" => "colorpicker","value" => "",
						 "data" => array("target" => " .ioa-text-column h4 " ,"property" => "color" )     
					),
					array( 
						"label" => __("Text Color",'ioa') , 
						"name" => "text_color" , 
						"default" => "" , 
						"type" => "colorpicker",
						
						"value" => "",
						 "data" => array(

					 			"target" => " .ioa-text-column div.ioa-text " ,
					 			"property" => "color" 

		 					)     
					),
			

				),

			__("Font Size Settings",'ioa') => array(

					array( 
						"label" => __("Title Size",'ioa') , 
						"name" => "title_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 100,
						"value" => 0 ,
						"suffix" => "px",
						 "data" => array(

					 			"target" => " .ioa-text-column h2 " ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Title Font Weight",'ioa') , 
						"name" => "title_w" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " .ioa-text-column h2 " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Subtitle Size",'ioa') , 
						"name" => "subtitle_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " .ioa-text-column h4 " ,
					 			"property" => "font-size" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Font Weight",'ioa') , 
						"name" => "subtitle_w" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " .ioa-text-column h4 " ,
					 			"property" => "font-weight" 

		 				)     
					),
					array( 
						"label" => __("Text Size",'ioa') , 
						"name" => "text_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => "  .ioa-text-column div.ioa-text " ,
					 			"property" => "font-size" 

		 					)     
					)

				),

			
			__("Margin Settings",'ioa') => array(

					
					array( 
						"label" => __("Title Top Margin",'ioa') , 
						"name" => "tt_margin" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => ".ioa-text-column h2 " ,
					 			"property" => "margin-top" 

		 				)     
				),
					array( 
						"label" => __("Subtitle Top Margin",'ioa') , 
						"name" => "st_margin" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " .ioa-text-column h4 " ,
					 			"property" => "margin-top" 

		 				)     
				),
				
					array( 
						"label" => __("Text Top Margin",'ioa') , 
						"name" => "tet_margin" , 
						"default" => "" , 
						"type" => "slider",
						
						"value" => 0,
						"max" => 100,
						"suffix" => 'px',
						 "data" => array(

					 			"target" => " .ioa-text-column div.ioa-text " ,
					 			"property" => "margin-top" 

		 					)     
					)

				)

		)		

	));


/**
 * Menu Widget
 */


$radunits['rad_one_menu_widget'] = new RADUnit(array(
	'label' => __('One Page Menu','ioa'),
	'id' => 'rad_one_menu_widget',
	'template' => 'one_menu',
	'group'	=> 'widgets',
	'icon' => 'menu-2icon-',
	'heading' => 'Menu Settings',
	'feedback' => " <div class='vf-rad_added_menus clearfix'> </div> ",
	'inputs' => array(
			__("Menu Items",'ioa') => array(

				array( "label" => __("Add Custom Menu Item",'ioa') , "name" => "col_link" , "default" => "none" , "type" => "select",  'optgroup' => true, "options" => $links_only , "after_input" => "<a href='' class='add_rad_menu_item button-default'> ".__("Add Menu Item",'ioa')." </a>") ,
					
					array(  "label" => __("Available Sections",'ioa') , "name" => "rad_menu_sections" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa')  ) , "after_input" => "<a href='' class='add_rad_menu_item button-default'> ".__("Add Menu Item",'ioa')." </a>  <ul class='clearfix rad_menu_area'>  </ul> "   ),

					array(  "label" => "" , "name" => "rad_added_menus" , "default" => "" , "type" => "hidden",  "length" => 'medium'   ),

			)

		),

	'styles' => array(

		__('Menu Stylings','ioa') => array(

				
					array( 
						"label" => __("Menu Background Color",'ioa') , "name" => "one_m" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-one-page-menu-wrap " ,"property" => "background-color" )     
					),

					array( 
						"label" => __("Menu Item Text Color",'ioa') , "name" => "one_m_item_c" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-one-page-menu li a	 " ,"property" => "color" )     
					),

					array( 
						"label" => __("Menu Item Border Color",'ioa') , "name" => "one_m_item_bg" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-one-page-menu-wrap li a " ,"property" => "border-color" )     
					),

					array( 
						"label" => __("Active & Hover Menu Item Text Color",'ioa') , "name" => "one_a_item_c" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-one-page-menu li:hover a  " ,"property" => "color"   ,  
						 "extra_cl" => array(
						 	".rad-one-page-menu li.active a" => "color",
						 	) 
						 )
					),

					array( 
						"label" => __("Active & Hover Menu Item Background Color",'ioa') , "name" => "one_a_item_bg" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-one-page-menu li:hover a , .rad-one-page-menu li.active a " ,"property" => "background-color" ,  
						 "extra_cl" => array(
						 	".rad-one-page-menu li.active a" => "background-color",
						 	)   
						 	)   
					),

			)

		)

	));



/**
 * Quotes Widget
 */

$radunits['rad_quotes_widget'] = new RADUnit(array(
	'label' => __('Quotes','ioa'),
	'id' => 'rad_quotes_widget',
	'template' => 'quotes',
	'group'	=> 'widgets',
	'icon' => 'quote-left-1icon-',
	'heading' => 'Quotes Text Settings',
	'feedback' => "  <i class='quote-mark quote-left-1icon- ioa-front-icon'></i><div class='text-info'> <h2 class='vf-text_title'>{text_title}</h2> <div class='vf-quote-area'> <div class='vtext vf-text_data'>{text_data}</div> <span class='vf-author_name'>{author_name}</span> </div> </div> ",
	'inputs' => array(
			__("Column Inputs",'ioa') => array(

			
			array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
			array(  "label" => __("Author",'ioa') , "name" => "author_name" ,"default" => "Hannibal" ,"type" => "text",  "length" => 'medium') ,
			array(  "label" => __("Author Preffix Text",'ioa') , "name" => "author_preffix" ,"default" => "&#8211; Words by " ,"type" => "text",  "length" => 'medium') ,

			array( "label" => __("Text",'ioa') , "name" => "text_data" , "default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultrices, nisl ac lobortis ultrices, enim dolor malesuada risus, id lacinia sapien metus scelerisque mauris. Aliquam elementum a libero nec euismod. Nunc ut sapien et augue faucibus aliquam. " , "type" => "textarea",  "length" => 'medium'),

			),

			__("Animation Settings",'ioa') => array(
			
			array(  "label" => __("Column Animation on Scroll",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
			array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
			
			
			)

		),

	'styles' => array(

				__("Title Styling",'ioa') => $title_default_stylings,

				__('Quote Stylings','ioa') => array(

					
					array( 
						"label" => __("Quote Color",'ioa') , "name" => "q_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " blockquote " ,"property" => "color" )     
					),

					array( 
						"label" => __("Quote Size",'ioa') , 
						"name" => "q_size" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 100,
						"value" => 0 ,
						"suffix" => "px",
						 "data" => array(

					 			"target" => " blockquote  " ,
					 			"property" => "font-size" 

		 				)     
					),
					array( 
						"label" => __("Quote Font Weight",'ioa') , 
						"name" => "q_w" , 
						"default" => "" , 
						"type" => "slider",
						
						"max" => 900,
						"value" => 100 ,
						"steps" => 100,
						"suffix" => '',
						 "data" => array(

					 			"target" => " blockquote  " ,
					 			"property" => "font-weight" 

		 				)     
					),



					)

		)		

	));


/**
 * Notfication Widget
 */

$radunits['rad_notification_widget'] = new RADUnit(array(
	'label' => __('Notification','ioa'),
	'id' => 'rad_notification_widget',
	'template' => 'notification',
	'group'	=> 'widgets',
	'icon' => 'info-circled-2icon-',
	'heading' => 'Notification Text Settings',
	'feedback' => "<div class='cioa-message message-default'> <h2 class='message-title vf-text_title'>{text_title}</h2><div class='message-content'><div class='vf-text_data'>{text_data}</div>	  <i class='vf-t_icon {t_icon}'></i></div></div>",
	'inputs' => array(
			__("Column Inputs",'ioa') => array(

			
			array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,

			array( "label" => __("Message",'ioa') , "name" => "text_data" , "default" => "This is the Message " , "type" => "textarea",  "length" => 'medium'),

			array(  "label" => __("Select Box Type",'ioa') , "name" => "c_type" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Default",'ioa')  , 'success' => "Success" , "information" => "Information" , "error" => "Error" , "inverse" => "Inverse"   )  ),

			 array( 
              "label" => __("Add Icon Title",'ioa') , 
              "name" => "t_icon" , 
              "default" => "" , 
              "type" => "text",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a><a class="button-default image_iupload">Add Image Icon</a>'  ,
              "value" => ""   ,
              "class" => "has-two-buttons"
          ) , 


			),


			__("Animation Settings",'ioa') => array(
			
			array(  "label" => __("Column Animation on Scroll",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
			array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
			
			
			)

		),

			

	));

/**
 * Sidebar
 */

$radunits['rad_sidebar_widget'] = new RADUnit(array(
	'label' => __('Sidebar','ioa'),
	'id' => 'rad_sidebar_widget',
	'template' => 'sidebar',
	'group'	=> 'widgets',
	'icon' => 'columnsicon- ',
	'heading' => 'Sidebar Settings',
	'feedback' => "  <div class='text-info'> ".__('This  Area will show widgets from ','ioa')." - <strong class='vf-sidebar_v'>{sidebar_v}</strong> </div> ",
	'inputs' => array(
			__("General Fields",'ioa') => array(

							array( "label" => __("Select Sidebar",'ioa') , "name" => "sidebar_v" , "default" => "Blog Sidebar" ,"meta" => true, "type" => "select",  "length" => 'medium'  , "options" => $osidebars )  ,
							
							)

		),

	'styles' => array( 	)

	));

/**
 * Gallery
 */


$radunits['rad_gallery_widget'] = new RADUnit(array(
	'label' => __('Gallery','ioa'),
	'id' => 'rad_gallery_widget',
	'template' => 'gallery',
	'group'	=> 'media',
	'icon' => 'laptopicon-',
	'heading' => 'Gallery Settings',
	'feedback' => "  <div class='rad-gallery-info clearfix'> {gallery_images} </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Auto Width",'ioa')  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,
					array(  "label" => __("Width",'ioa') , "name" => "width" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,
					
					
					),

					__("Images",'ioa') => array(

					array( "label" => __("Set Images",'ioa') , "name" => "gallery_images" , "default" => $demo_imgs[0]."<<".$demo_thumbs[0]."<<<<photodune-5298865-wheat-field-l<<;".$demo_imgs[1]."<<".$demo_thumbs[1]."<<<<8<<;".$demo_imgs[2]."<<".$demo_thumbs[2]."<<<<blue06_jennistock<<;" , "type" => "hidden",  "length" => 'medium' , "after_input" => "<a href='' data-title='Add to Gallery' data-label='Add' class='rad_gallery_upload button-default'> ".__("Add Images",'ioa')." </a>  <ul class='clearfix rad_gallery_thumbs'>  </ul> "  )  ,
					 
					),
					__("Settings",'ioa') =>  array( 

					array( "label" => __("Slide Show Time(in secs)",'ioa') , "name" => "duration" , "default" => "4" , "value" => 0 , "max" =>300 , "suffix" => '', "type" => "slider") ,
					array( "label" => __("Image Resizing",'ioa') , "name" => "image_resize" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Full Stretch(Cropped)",'ioa'),"hard" => __("Proportional",'ioa') , "none" => "No Resizing"  ) )  ,
					array( "label" => __("Autoplay",'ioa') , "name" => "autoplay" , "default" => "false" , "type" => "select",  "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Use Lightbox",'ioa') , "name" => "lightbox" , "default" => "false" , "type" => "select",  "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Captions",'ioa') , "name" => "captions" , "default" => "false" , "type" => "select",  "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Controls",'ioa') , "name" => "arrow_control" , "default" => "true" , "type" => "select",  "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array( "label" => __("Thumbnail",'ioa') , "name" => "bullets" , "default" => "true" , "type" => "select",  "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa')) )  ,
					array(  "label" =>__( "Gallery Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					
					)


					 ),

	'styles' => array(

					__("Title Styling",'ioa') => $title_default_stylings,
								__("Gallery Controls",'ioa') => array(

										array( 
											"label" => __("Arrow Color",'ioa') , 
											"name" => "ar_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " .seleneGallery div.selene-controls-wrap a" ,
										 			"property" => "color" 

							 				)     
										),
										array( 
											"label" => __("Arrow Background Color",'ioa') , 
											"name" => "ar_bgcolor" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " .seleneGallery div.selene-controls-wrap a" ,
										 			"property" => "background-color" 

							 				)     
										),

								)
		)		

	));



/**
 * Flickr
 */



$radunits['rad_flickr_widget'] = new RADUnit(array(
	'label' => __('Flickr','ioa'),
	'id' => 'rad_flickr_widget',
	'template' => 'flickr',
	'group'	=> 'media',
	'icon' => 'picture-2icon-',
	'heading' => 'Flickr Settings',
	'feedback' => "<div> Flickr Album (<strong class='vf-text_title'>{text_title}</strong>) by <span class='vf-username'>{username}</span> </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Flickr Username",'ioa') , "name" => "username" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Flickr API KEY(get your key at http://www.flickr.com/services/api/misc.api_keys.html)",'ioa') , "name" => "api_key" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Images",'ioa') , "name" => "nos" ,"default" => "8" ,"type" => "text",  "length" => 'medium') ,
					
					array(  "label" =>__( "Thumbnails Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					array(  "label" => __("Thumbnail Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					
					),


					 ),

	'styles' => array()		

	));


/**
 * Slider Manager
 */

$sliders = get_posts('post_type=slider&posts_per_page=-1');
$ts = array(""=>"None");
foreach ($sliders as $post) {
   $ts[$post->ID] = get_the_title($post->ID) ;
}


$radunits['rad_slidermanager_widget'] = new RADUnit(array(
	'label' => __('Slider Manager','ioa'),
	'id' => 'rad_slidermanager_widget',
	'template' => 'slidermanager',
	'group'	=> 'media',
	'icon' => 'rocketicon-',
	'heading' => 'Gallery Settings',
	'feedback' => " <div class='text-info'> Using Slider - <strong class='vf-slideshow'>{slideshow}</strong> from Slide Manager </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Select Slideshow",'ioa') , "name" => "slideshow" ,"default" => "" ,"type" => "select",  "length" => 'medium' , 'options' => $ts ) ,
					array(  "label" =>__( "Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					
					
					),

				
				 ),

	'styles' => array(

					__("Title Styling",'ioa') => $title_default_stylings
		)		

	));

/**
 * Gallery Thumbnails
 */



$radunits['rad_thumbnails_widget'] = new RADUnit(array(
	'label' => __('Images Thumbnails','ioa'),
	'id' => 'rad_thumbnails_widget',
	'template' => 'thumbs',
	'group'	=> 'media',
	'icon' => 'layouticon- ',
	'heading' => 'Thumbnails Settings',
	'feedback' => " <div class='rad-gallery-info clearfix'> {gallery_images} </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Thumbnails Height",'ioa') , "name" => "th_height" ,"default" => "75" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Thumbnails Width",'ioa') , "name" => "th_width" ,"default" => "75" ,"type" => "text",  "length" => 'medium') ,
					
					array(  "label" =>__( "Thumbnails Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					array(  "label" => __("Thumbnail Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					
					),

					__("Images",'ioa') => array(

					array( "label" => __("Set Images",'ioa') , "name" => "gallery_images" , "default" => $demo_imgs[0]."<<".$demo_thumbs[0]."<<<<photodune-5298865-wheat-field-l<<;".$demo_imgs[1]."<<".$demo_thumbs[1]."<<<<8<<;".$demo_imgs[2]."<<".$demo_thumbs[2]."<<<<blue06_jennistock<<;" , "type" => "hidden",  "length" => 'medium' , "after_input" => "<a href='' data-title='Add to Gallery' data-label='Add' class='rad_gallery_upload button-default'> ".__("Add Images",'ioa')." </a>  <ul class='clearfix rad_gallery_thumbs'>  </ul> "  )  ,
					 
					),


					 ),

	'styles' => array(

					__("Title Styling",'ioa') => $title_default_stylings,
								
		)		

	));


/**
 * Posts List
 */

$radunits['rad_post_list_widget'] = new RADUnit(array(
	'label' => __('Posts List','ioa'),
	'id' => 'rad_post_list_widget',
	'template' => 'post_list',
	'group'	=> 'advance',
	'icon' => 'list-bulleticon- ',
	'heading' => 'Posts List Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <i class='list-bulleticon- ioa-front-icon'></i> <h2 class='vf-text_title'>{text_title}</h2> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in <strong class='vf-post_structure'>{post_structure}</strong> format. </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Post Structure",'ioa') , "name" => "post_structure" , "default" => "post-thumbs" , "type" => "select",  "length" => 'medium'  , "options" => array("post-list" => __("Plain Lists",'ioa'),"post-thumbs" => __("Lists with Small Thumbnails",'ioa'),"post-thumbs-big" => __("Lists with Full Width Images",'ioa') )   )  ,
					array(  "label" => __("Numbe of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Extra Information",'ioa') , "name" => "meta_value" ,"default" => "" ,"type" => "textarea",  "length" => 'medium', "after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", "buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>") ,
					),

					__("Post Filter & Type",'ioa') => array(
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "post" , "type" => "select",  "length" => 'medium'  , "options" => $post_type_array   )  ,
					array( "label" => __("Show Small Summary(Excerpt)",'ioa') , "name" => "excerpt" , "default" => "yes" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,

					array( "label" => __("Use Theme's Excerpt (if No WP excerpt will be used) ",'ioa') , "name" => "use_custom_excerpt" , "default" => "yes" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,

					array( "label" => __("Show Pagination",'ioa') , "name" => "w_pagination" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
					array( "label" => __("Ajax Loading",'ioa') , "name" => "w_ajax" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
					
					array(  "label" => __("Summary Content limit",'ioa') , "name" => "excerpt_length" ,"default" => "150" ,"type" => "text",  "length" => 'medium') ,
					
					
					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => "has-input-button") ,
					),

					__("Animation",'ioa') => array(

					array(  "label" => __("Posts Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
					array(  "label" => __("Posts Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),

					array(  "label" => __("Posts Items Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )
	));


/**
 * Posts Featured
 */

$radunits['rad_post_feature_widget'] = new RADUnit(array(
	'label' => __('Featured Posts','ioa'),
	'id' => 'rad_post_feature_widget',
	'template' => 'post_featured',
	'group'	=> 'advance',
	'icon' => 'feathericon-',
	'heading' => 'Featured Posts Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <i class='th-1icon- ioa-front-icon'></i> <h2 class='vf-text_title'>{text_title}</h2> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items. </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Items viewable",'ioa') , "name" => "no_of_items" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
						array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "post" , "type" => "select",  "length" => 'medium'  , "options" => $post_type_array   )  ,

					array(  "label" => __("Margin Between Elements",'ioa') , "name" => "margin_el" ,"default" => "0" ,"type" => "text",  "length" => 'medium') ,	

					
					array(  "label" => __("Width",'ioa') , "name" => "width_el" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text",  "length" => 'medium') ,

					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => "has-input-button") ,
					
					),

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )
	));


/**
 * Posts Slider
 */

$radunits['rad_post_slider_widget'] = new RADUnit(array(
	'label' => __('Posts Slider','ioa'),
	'id' => 'rad_post_slider_widget',
	'template' => 'post_slider',
	'group'	=> 'media',
	'icon' => 'picture-2icon- ',
	'heading' => 'Posts Slider Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Slider has <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items . </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "post" , "type" => "select",  "length" => 'medium'  , "options" => $post_type_array   )  ,
					array(  "label" => __("Summary Content limit",'ioa') , "name" => "excerpt_length" ,"default" => "150" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Use Theme's Excerpt (if No WP excerpt will be used) ",'ioa') , "name" => "use_custom_excerpt" , "default" => "yes" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
					
					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => "has-input-button") ,
					
		
					),
					__('Slider Settings','ioa') => array(
					array(  "label" => __("Auto Width",'ioa')  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,	
					array(  "label" => __("Slider Width",'ioa') , "name" => "width" ,"default" => "500" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Slider Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Slide Show Time(in secs)",'ioa') , "name" => "duration" , "default" => "5" , "type" => "text") ,
					array( "label" => __("Autoplay",'ioa') , "name" => "autoplay" , "default" => "true" , "type" => "select",  "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa')) )  ,
					),

					__("Animation",'ioa') => array(

					array(  "label" => __("Posts Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,
			
			__("Slider Controls Stylings",'ioa') => array(

				array( 
						"label" => __("Controls Color",'ioa') , 
						"name" => "coc" , 
						"default" => "" , 
						"type" => "colorpicker",
						
						
						"value" => "",
						 "data" => array(

					 			"target" => " div.quartz-controls-wrap > a " ,
					 			"property" => "color" 

		 					)     
					),
				array( 
						"label" => __("Controls Background Color",'ioa') , 
						"name" => "cobc" , 
						"default" => "" , 
						"type" => "colorpicker",
						
						
						"value" => "",
						 "data" => array(

					 			"target" => " div.quartz-controls-wrap > a " ,
					 			"property" => "background-color" 

		 					)     
					),
				array( 
						"label" => __("Progress bar Background Color",'ioa') , 
						"name" => "pcoc" , 
						"default" => "" , 
						"type" => "colorpicker",
						
						
						"value" => "",
						 "data" => array(

					 			"target" => ".quartz span.progress-bar " ,
					 			"property" => "background-color" 

		 					)     
					)
				

				)

	 )
	));


/**
 * Posts Grid
 */

$radunits['rad_post_grid_widget'] = new RADUnit(array(
	'label' => __('Posts Grid','ioa'),
	'id' => 'rad_post_grid_widget',
	'template' => 'post_grid',
	'group'	=> 'advance',
	'icon' => 'th-1icon-',
	'feedback' => " <div class='rad-post-list-info clearfix'> <i class='th-1icon- ioa-front-icon'></i> <h2 class='vf-text_title'>{text_title}</h2> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in <strong class='vf-post_structure'>{post_structure}</strong> format. </div> ",
	'heading' => 'Posts Grid Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

						array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Recent Work" ,"type" => "text",  "length" => 'medium') ,
						array( "label" => __("Post Structure",'ioa') , "name" => "post_structure" , "default" => "4-col" , "type" => "select",  "length" => 'medium'  , "options" => array("1-col" => __("Featured Column",'ioa'),"2-col" => __("Two Columns",'ioa'),"3-col" => __("Three Columns",'ioa'),"4-col" => __("Four Columns",'ioa'),"5-col" => __("Five Columns",'ioa'))   )  ,
						array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" => __("Extra Information",'ioa') , "name" => "meta_value" ,"default" => "[post_date format='default'/]" ,"type" => "textarea",  "length" => 'medium', "after_input" => "<div class='post-meta-panel clearfix'> $pmb </div>", "buttons" => " <a href='' class='shortcode-extra-insert'>".__("Add Posts Info",'ioa')."</a>") ,

					),
					__("Post Filter & Type",'ioa') => array(

						array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "portfolio" , "type" => "select",  "length" => 'medium'  , "options" => $post_type_array   )  ,
						array( "label" => __("Show Pagination",'ioa') , "name" => "w_pagination" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
						
						array( "label" => __("Show Filter",'ioa') , "name" => "filter_menu" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') )  )  ,
						
						
						array(  "label" => __("WP Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => "has-input-button"  ) ,

					),
					__("Animation",'ioa') => array(

						array(  "label" => __("Posts Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
						array(  "label" => __("Posts Items Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));


/**
 * Posts Masonry
 */

$radunits['rad_post_masonry_widget'] = new RADUnit(array(
	'label' => __('Masonry Posts','ioa'),
	'id' => 'rad_post_masonry_widget',
	'template' => 'post_masonry',
	'group'	=> 'advance',
	'icon' => 'layouticon-',
	'heading' => 'Masonry Posts Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <i class='th-1icon- ioa-front-icon'></i> <h2 class='vf-text_title'>{text_title}</h2> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in masonry format. </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "post" , "type" => "select",  "length" => 'medium'  , "options" => $post_type_array   )  ,

					array( "label" => __("Masonry Type",'ioa') , "name" => "masonry_type" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array( "default" =>"Equal Grid" , "wproportional" => "Masonry" )   )  ,

					array( "label" => __("Masonry Layout",'ioa') , "name" => "masonry_layout" , "default" => "four-col" , "type" => "select",  "length" => 'medium'  , "options" => array( "four-col" =>"Four Column" ,"five-col" =>"Five Column" ,"six-col" =>"Six Column"  )   )  ,

					array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "500"  ,"type" => "text",  "length" => 'medium') ,

					array( "label" => __("Ajax Loading",'ioa') , "name" => "w_ajax" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,

					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => "has-input-button") ,
						
					),

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));

/**
 * Intro Widget
 */

$radunits['rad_intro_widget'] = new RADUnit(array(
	'label' => __('Intro Title','ioa'),
	'id' => 'rad_intro_widget',
	'template' => 'intro_title',
	'group'	=> 'widgets',
	'feedback' => '<div class="rad-intro-info"><h2 class="vf-text_title">{text_title}</h2><h4 class="vf-text_subtitle">{text_subtitle}</h4></div>',
	'icon' => 'align-lefticon- ',
	'heading' => 'Intro Title Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("Heading",'ioa') , "name" => "text_title" ,"default" => "Main Title Here" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Sub Heading",'ioa') , "name" => "text_subtitle" ,"default" => "Sub Title Here" ,"type" => "text","length" => 'medium')  ,
							array( "label" => __("Show Mini Divider",'ioa') , "name" => "divider_toggle" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("no" => __("No",'ioa'),"yes" => __("Yes",'ioa'))  ) ,

							array( "label" => __("Column Alignment",'ioa') , "name" => "col_alignment" , "default" => "left" , "type" => "select",  "length" => 'medium'  , "options" => array("left" => __("Left",'ioa'),"right" => __("Right",'ioa'),"center" =>__("Center",'ioa')) , "data" => array("attr" => "text-align" , "el" => ".intro_title-title-inner-wrap")  ) 
							
							),

			),

	'styles' => array( 

				__("Styling",'ioa') => array(

										array( 
											"label" => __("Title Color",'ioa') , 
											"name" => "title_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap h2 " ,
										 			"property" => "color" 

							 				)     
									), 
										array( 
											"label" => __("Subtitle Color",'ioa') , 
											"name" => "subtitle_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap .text_subtitle " ,
										 			"property" => "color" 

							 				) ,
							 				    
									),


									),

								__("Font Size Settings",'ioa') => array(

										array( 
											"label" => __("Title Size",'ioa') , 
											"name" => "title_size" , 
											"default" => "" , 
											"type" => "slider",
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											
											
											"value" => "28px",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap h2 " ,
										 			"property" => "font-size" 

							 				)     
										),
										array( 
											"label" => __("Title Font Weight",'ioa') , 
											"name" => "title_w" , 
											"default" => "" , 
											"type" => "slider",
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap h2 " ,
										 			"property" => "font-weight" 

							 				)     
										),
										array( 
											"label" => __("Subtitle Size",'ioa') , 
											"name" => "subtitle_size" , 
											"default" => "" , 
											"type" => "slider",
											"value" => 0,
											"max" => 100,
											"suffix" => "px",
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap .text_subtitle " ,
										 			"property" => "font-size" 

							 				)     
									),
										array( 
											"label" => __("Subtitle Font Weight",'ioa') , 
											"name" => "subtitle_w" , 
											"type" => "slider",
											"value" => 0,
											"max" => 900,
											"steps" => 100,
											"suffix" => "",
											"class" => ' rad_style_property ',
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap .text_subtitle " ,
										 			"property" => "font-weight" 

							 				)     
										)

									),

								
								__("Margin Settings",'ioa') => array(

										

										array( 
											"label" => __("Main Title Bottom Margin",'ioa') , 
											"name" => "subtitle_mb" , 
											"default" => "" , 
											"type" => "text",
											"class" => ' rad_style_property ',
											"value" => "10px",
											 "data" => array(

										 			"target" => " .intro_title-inner-wrap h2 " ,
										 			"property" => "margin-bottom" 

							 				) ,
							 				    
										),

										array( 
											"label" => __("Intro Title Area Bottom Margin",'ioa') , 
											"name" => "title_mb" , 
											"default" => "" , 
											"type" => "text",
											
											
											"class" => ' rad_style_property ',
											"value" => "0px",
											 "data" => array(

										 			"target" => " div.intro_title-inner-wrap" ,
										 			"property" => "margin-bottom" 

							 				) ,
							 				    
										)								
										

								)

			)

	));


/**
 * CTA Widget
 */

$radunits['rad_cta_widget'] = new RADUnit(array(
	'label' => __('CTA','ioa'),
	'id' => 'rad_cta_widget',
	'template' => 'cta',
	'group'	=> 'widgets',
	'feedback' => '<div class="rad-intro-info"><h2 class="vf-text_title">{text_title}</h2><h4 class="vf-subtext_title">{subtext_title}</h4> <a class="vf-cta_button" href="{button_link}">{cta_button}</a> </div>',
	'icon' => 'blankicon-',
	'heading' => 'CTA Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array( "label" => __("Select CTA Style",'ioa') , "name" => "cta_style" , "meta" => true,"default" => "default" , "type" => "select",  "length" => 'medium'  ,  "options" => array("default" => __("Default",'ioa') ,'center' => "Center Button" )  , "data" => array("attr" => "button-align" , "el" => ".cta-inner-wrap")  )  ,

					
					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Welcome To our awesome site !" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Sub Title",'ioa') , "name" => "subtext_title" ,"default" => "This is a sub title." ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("CTA Button Classes",'ioa') , "name" => "cta_button_classes" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,

					 array( 
              "label" => __("Add Icon Title",'ioa') , 
              "name" => "t_icon" , 
              "default" => "" , 
              "type" => "text",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'  ,
              "value" => ""   
         		 ) , 

					array(  "label" => __("Add Image(Works only for image box style)",'ioa') , "name" => "cta_image" ,"default" => "" ,"type" => "upload",  "length" => 'medium') ,

					array( "label" => __("Button Label",'ioa') , "name" => "cta_button" , "default" => "Learn More !" , "type" => "text",  "length" => 'medium') ,
					array( "label" => __("Button Link",'ioa') , "name" => "button_link" , "meta" => true, "default" => "#" , "type" => "text",  "length" => 'medium', "data" => array("attr" => "button-link" , "el" => "cta_button") ) ,
					
					)

			),

	'styles' => array(

		__("CTA Stylings",'ioa') => array(

					array( 
						"label" => __("CTA Text Color",'ioa') , "name" => "ctah" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".cta-inner-wrap .cta-heading h3" ,"property" => "color" )     
					),

					array( 
						"label" => __("CTA Subtitle Color",'ioa') , "name" => "ctash" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".cta-inner-wrap .cta-heading h5" ,"property" => "color" )     
					),

					array( 
						"label" => __("Button Text Color",'ioa') , "name" => "ctatc" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".cta-inner-wrap a.cta_button,.cta-inner-wrap .cta-icon " ,"property" => "color", "extra_cl" => array(

						 	".cta-inner-wrap a.cta_button,.cta-inner-wrap .cta-icon" => "border-color",

						 	) )     
					),

					array( 
						"label" => __("Button Background Color",'ioa') , "name" => "ctatcg" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".cta-inner-wrap a.cta_button " ,"property" => "background" )     
					),

				


			)	

	 )

	));


/**
 * Tabs Widget
 */

$inputs = array(
					array( 
							"label" => __("Title",'ioa') , 
							"name" => "tab_title" , 
							"default" => "Title" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Set Icon",'ioa') , 
							"name" => "tab_icon" , 
							"default" => "" , 
							"type" => "text",
							"class" => "has-input-button",
							"length" => 'medium',
							"value" => ""  ,
							'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'  
					) ,
					
					array( 
							"label" => __("Text",'ioa') , 
							"name" => "tab_text" , 
							"default" => "Tab text goes here.." , 
							"type" => "textarea",
							'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>'  ,
							"length" => 'long',
							"value" => ""   
					) 	
						

			);


/**
 * Tab Widget
 */

$radunits['rad_tabs_widget'] = new RADUnit(array(
	'label' => __('Tabs','ioa'),
	'id' => 'rad_tabs_widget',
	'template' => 'tabs',
	'group'	=> 'widgets',
	'icon' => 'tableicon-',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Tabs','ioa')."</div>",
	'heading' => 'Tabs Settings',
	'inputs' => array(
					 __("General Fields",'ioa') => array(

						array(  "label" =>  __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
						
						array( "label" =>  __("Tab Layout",'ioa') , "name" => "tab_orientation" , "default" => "top" , "type" => "select",  "length" => 'medium'  , "options" => array("bottom" => __("Bottom",'ioa'),"top" => __("Top",'ioa'),"left" => __("Left",'ioa'),"right" => __("Right",'ioa')  )  )  ,

						array( "label" =>  __("Tab Style",'ioa') , "name" => "tab_style" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Default",'ioa'),"styled" => __("Styled",'ioa')  )  )  ,
						
						),
						
						 __("Add Tabs",'ioa') => array(
							array( 'inputs' => $inputs, 'label' => __('Tabs' ,'ioa') , 	'name' => 'rad_tab','type'=>'module','unit' => __(' Tab','ioa') )
						
						)

			),

	'styles' => array( 

			__("Title Styling",'ioa') => $title_default_stylings,
		
	 )

	));





/**
 * Google Map Widget
 */

$inputs = array(
					
					array( 
							"label" => __("Enter Address",'ioa') , 
							"name" => "address" , 
							"default" => "" , 
							"type" => "textarea",
							"value" => ""   
					) 	
						

			);		


$radunits['rad_googlemap_widget'] = new RADUnit(array(
	'label' => __('Google Map','ioa'),
	'id' => 'rad_googlemap_widget',
	'template' => 'googlemap',
	'group'	=> 'widgets',
	'icon' => 'mapicon-',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Google Map','ioa')."</div>",
	'heading' => 'Map Settings',
	'inputs' => array(
					 __("General Fields",'ioa') => array(

						array(  "label" =>  __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" =>  __("Map Height",'ioa') , "name" => "height" ,"default" => "350" ,"type" => "text",  "length" => 'medium') ,
						array(  "label"=> __("Set Zoom Level",'ioa'), "name" =>"map_zoom", "type"=>"slider", "max"=>16, "default"=>8,  "suffix"=>"" ),
 						array(  "label"=> __("Set Map Hue",'ioa'), "name" =>"map_color", "type"=>"colorpicker", "alpha" => false , "value"=>"", "default" => "" ),

 						array( "label" => __("Add Map Marker",'ioa'), "name" =>"map_marker", "type" => "upload", "default" => URL."/sprites/i/map-pin.png"	),
						 
						 ),
						 __("Add Addresses",'ioa') => array(
							
							array( 'inputs' => $inputs, 'label' => __('Addresses' ,'ioa') , 	'name' => 'rad_tab','type'=>'module','unit' => __(' Address','ioa') )
						
						)

			),

	'styles' => array( 

			__("Title Styling",'ioa') => $title_default_stylings
		
	 )

	));




/**
 * Magic List Widget
 */

$inputs = array(
					array( 
							"label" => __("Title",'ioa') , 
							"name" => "tab_title" , 
							"default" => "Title" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Set Icon",'ioa') , 
							"name" => "tab_icon" , 
							"default" => "" , 
							"type" => "text",
							"class" => "has-input-button",
							"length" => 'medium',
							"value" => ""  ,
							'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'  
					) ,
					
					array( 
							"label" => __("Text",'ioa') , 
							"name" => "tab_text" , 
							"default" => "List Text Goes here" , 
							"type" => "textarea",
							'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>' ,
							"length" => 'long',
							"value" => ""   
					) 	
						

			);


$radunits['rad_magic_widget'] = new RADUnit(array(
	'label' => __('Magic List','ioa'),
	'id' => 'rad_magic_widget',
	'template' => 'magic_list',
	'group'	=> 'widgets',
	'icon' => 'magicicon-',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Easy List','ioa')."</div>",
	'heading' => 'List Settings',
	'inputs' => array(
					 __("General Fields",'ioa') => array(

						array(  "label" =>  __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" => __("Column Animation on Scroll",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')  )  ),
						array(  "label" => __("List Items Animation on Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa') , 'icon-animate' => "Icons Fade In"   )  ),
						array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
							
						),
						
						 __("Add List Items",'ioa') => array(
							array( 'inputs' => $inputs, 'label' => __('List' ,'ioa') , 	'name' => 'rad_tab','type'=>'module','unit' => __(' Item','ioa') )
						
						)

			),

	'styles' => array(
		__("Title Styling",'ioa') => $title_default_stylings,
		__("List Stylings",'ioa') => array(

					array( 
						"label" => __("List Item Title Color",'ioa') , "name" => "mlic" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".magic_list-inner-wrap ul li h4" ,"property" => "color" )     
					),

					array( 
						"label" => __("List Item Text Color",'ioa') , "name" => "mltic" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".magic_list-inner-wrap ul li .desc-area" ,"property" => "color" )     
					),

					array( 
						"label" => __("List Item Icon Color",'ioa') , "name" => "mliiic" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".magic_list-inner-wrap ul li .ioa-icon-area i" ,"property" => "color" )     
					),

					array( 
						"label" => __("List Item Icon Border Color",'ioa') , "name" => "mlibic" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".magic_list-inner-wrap ul li .ioa-icon-area" ,"property" => "border-color" )     
					),


			)	

	 )

	));

/**
 * Accordion Widget
 */

$ainputs = array(
					array( 
							"label" => __("Title",'ioa') , 
							"name" => "tab_title" , 
							"default" => "Title" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,



					array( 
							"label" => __("Text",'ioa') , 
							"name" => "tab_text" , 
							"default" => "Tab text goes here.." , 
							"type" => "textarea",
							'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>'  ,
							"length" => 'long',
							"value" => ""   
					) 		

			);


$radunits['rad_accordion_widget'] = new RADUnit(array(
	'label' => __('Accordion','ioa'),
	'id' => 'rad_accordion_widget',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing According','ioa')."</div>",
	'template' => 'accordion',
	'group'	=> 'widgets',
	'icon' => 'align-justifyicon-',
	'heading' => 'Accordion Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
					array( "label" =>  __("Accordion Style",'ioa') , "name" => "accordion_style" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Default",'ioa'),"styled" => __("Styled",'ioa') ,"simple" => __("Plain",'ioa') )  )  ,
					
					),

					
					__("Add Accordion Sections",'ioa') => array(
						array( 'inputs' => $ainputs, 'label' => __('Accordion','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __(' Section','ioa') )
					
					)

			),

	'styles' => array(	)


	));

/**
 * Toggles
 */

$ainputs = array(
					array( 
							"label" => __("Title",'ioa') , 
							"name" => "tab_title" , 
							"default" => "Title" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Toggle State",'ioa') , 
							"name" => "tab_state" , 
							"type" => "select",
							"options" => array("collapse" => "Closed" , "open" => "Opened"),
							"length" => 'long',
							"default" => "collapse",
							"value" => ""   
					) ,


					array( 
							"label" => __("Text",'ioa') , 
							"name" => "tab_text" , 
							"default" => "Tab text goes here.." , 
							"type" => "textarea",
							'addMarkup' => '<a href="" class="button-default ioa-editor-trigger">'.__('Use WP Editor','ioa').'</a>'  ,
							"length" => 'long',
							"value" => ""   
					) 		

			);


$radunits['rad_toggle_widget'] = new RADUnit(array(
	'label' => __('Toggles','ioa'),
	'id' => 'rad_toggle_widget',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Toggles','ioa')."</div>",
	'template' => 'toggle',
	'group'	=> 'widgets',
	'icon' => 'plus-squared-smallicon- ',
	'heading' => 'Toggle Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(
							
							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
					array( "label" =>  __("Toggle Style",'ioa') , "name" => "toggle_style" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Default",'ioa'),"styled" => __("Styled",'ioa') ,"simple" => __("Plain",'ioa') )  )  ,
					
					),
					__("Add Toggles","ioa") => array(

						array( 'inputs' => $ainputs, 'label' => __('Toggles','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __(' Toggle','ioa') )

						)

			),

	'styles' => array(
		__("Title Styling",'ioa') => $title_default_stylings,
		)


	));

/**
 * Icon Sets
 */

$ainputs = array(
          array( 
              "label" => __("Enter Link",'ioa') , 
              "name" => "social_link" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,

           array( 
              "label" => __("Enter Label(if empty tooltip won't appear)",'ioa') , 
              "name" => "social_label" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,
            array( 
              "label" => __("Icon Hover Color",'ioa') , 
              "name" => "social_color" , 
              "default" => "" , 
              "type" => "colorpicker",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Set Icon",'ioa') , 
              "name" => "social_icon" , 
              "default" => "" , 
              "type" => "text",
              "class" => "has-two-buttons",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a><a class="button-default image_iupload">Add Image Icon</a>'  ,
              "value" => ""   
          )     

      );


$radunits['rad_iconsets_widget'] = new RADUnit(array(
	'label' => __('Icon Sets','ioa'),
	'id' => 'rad_iconsets_widget',
	'feedback' => "<div class='min-rad-highlight'>".__('Showing Icons Set','ioa')."</div>",
	'template' => 'iconset',
	'group'	=> 'widgets',
	'icon' => 'circle-emptyicon-',
	'heading' => 'Icon Sets Settings',
	'inputs' => array(
					__("Add Icons",'ioa') => array(
							
							array(  "label" => __("Items Animation on Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')  )  ),
							array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
							array( 'inputs' => $ainputs, 'label' => __('Icons','ioa'),  'name' => 'rad_tab','type'=>'module','unit' => __(' Icon','ioa') )
					
					)

			),

	'styles' => array(	)


	));

/**
 * Logo Area
 */

/**
 * Icon Sets
 */

$ainputs = array(
          array( 
              "label" => __("Enter Link",'ioa') , 
              "name" => "logo_link" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,

           array( 
              "label" => __("Enter Label(if empty tooltip won't appear)",'ioa') , 
              "name" => "logo_label" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Set Logo",'ioa') , 
              "name" => "logo_icon" , 
              "default" => "" , 
              "type" => "upload",
              "value" => ""   
          )     

      );


$radunits['rad_logo_widget'] = new RADUnit(array(
	'label' => __('Logo Area','ioa'),
	'id' => 'rad_logo_widget',
	'feedback' => "<div class='rad-logo-thumb'>{rad_tab}</div>",
	'template' => 'logo',
	'group'	=> 'widgets',
	'icon' => 'leaf-1icon- ',
	'heading' => 'Logo Settings',
	'inputs' => array(


					__("General Fields",'ioa') => array(
							
		array(  "label" => __("Logo Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

		array(  "label" => __("Logo Area Style",'ioa') , "name" => "style" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa') , "grid" => __("Grid",'ioa') , "scrollable" => __("Scrollable",'ioa') )  ),

		array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
							
					
					),
					__("Add Logo",'ioa') => array(

					array( 'inputs' => $ainputs, 'label' => __('Logos','ioa'),  'name' => 'rad_tab','type'=>'module','unit' => __(' Logo','ioa') ),	

						)

			),

	


	));



/**
 * Image
 */

$radunits['rad_image_widget'] = new RADUnit(array(
	'label' => __('Image','ioa'),
	'id' => 'rad_image_widget',
	'template' => 'image',
	'group'	=> 'media',
	'icon' => 'picture-1icon-',
	'feedback' => "<div class='rad-image-info'> <h2 class='vf-text_title'>{text_title}</h2> <img src='{image}' /> </div>",
	'heading' => 'Image Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array( "label" => __("Image",'ioa') , "name" => "image" , "default" => $demo_imgs[0] , "type" => "upload",  "length" => 'medium'	) ,
							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Image" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Link",'ioa') , "name" => "link" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
							array( "label" => __("Use lightbox to show full image",'ioa') , "name" => "lightbox" , "default" => "" , "type" => "select",  "length" => 'medium'  , "options" => array("false" => __("No",'ioa'),"true" => __("Yes",'ioa'))  )  ,
							array(  "label" => __("Caption",'ioa') , "name" => "text_caption" ,"default" => "Caption For the Image" ,"type" => "text","length" => 'medium')  ,
							array(  "label" => __("Auto Width",'ioa')  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,
							array(  "label" => __("Width",'ioa') , "meta" => "true", "name" => "width" ,"default" => "" ,"type" => "text","length" => 'medium')  ,
							array(  "label" => __("Height",'ioa') , "meta" => "true", "name" => "height" ,"default" => "400" ,"type" => "text","length" => 'medium')  ,

							array( "label" => __("Image Resizing",'ioa') , "name" => "resizing" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("No",'ioa'),"hard" => __("Hard Resize",'ioa') , "proportional" => __("Proportional",'ioa') , "wproportional" => __("Width Proportional",'ioa'), "hproportional" => __("Height Proportional",'ioa') )  )  ,

							),

							__("Animation Fields",'ioa') => array(      
							array(  "label" => __("Image Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
							array(  "label" => __("Column Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
							
							)
			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

		)

	));

/**
 * Divider
 */

$radunits['rad_divider_widget'] = new RADUnit(array(
	'label' => __('Divider','ioa'),
	'id' => 'rad_divider_widget',
	'template' => 'divider',
	'group'	=> 'widgets',
	'icon' => 'minus-2icon-',
	'feedback' => "<div class='rad-divider'> </div>",
	'heading' => 'Divider Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array( "label" => __("Select Style",'ioa') , "name" => "divider_style" , "default" => "line" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("Empty Space",'ioa'),"line" => __("Line",'ioa'),"double"=>__("Double Stroke",'ioa'),"dotted"=>__("Dotted",'ioa'),"dashed"=>__("Dashed",'ioa')) , "data" => array("attr" => "divider" )  )  ,
							array(  "label" => __("Vertical Spacing",'ioa') , "max"=>200 , "name" => "vspace" ,"default" => "0", "suffix" => "px" ,"type" => "slider",  "length" => 'medium') ,
							  
							)
			),

	'styles' => array(

			__(" Divider Styling",'ioa') => array(

										array( 
											"label" => __("Divider Color",'ioa') , 
											"name" => "divder_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " div.divider" ,
										 			"property" => "border-color" 

							 				)     
										),

									)

		)

	));


/**
 * Post Scrollable
 */

$radunits['rad_scrollable_widget'] = new RADUnit(array(
	'label' => __('Scrollable','ioa'),
	'id' => 'rad_scrollable_widget',
	'template' => 'scrollable',
	'group'	=> 'widgets',
	'icon' => 'resize-horizontal-1icon-',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items . </div> ",
	'heading' => 'Scrollable Settings( Not recommended for smaller images use feature posts instead )',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "6" ,"type" => "text",  "length" => 'medium') ,

							array(  "label" => __("Margin Left",'ioa') , "name" => "margin" ,"default" => "20" ,"type" => "text",  "length" => 'medium') ,
							
							array(  "label" => __("Item Width",'ioa') , "name" => "width" ,"default" => "250"  ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Item Height",'ioa') , "name" => "height" ,"default" => "180"  ,"type" => "text",  "length" => 'medium') ,
							
							
							array( "label" => __("Post Type" ,'ioa'), "name" => "post_type" , "default" => "post" , "type" => "select",  "length" => 'medium'  , "options" => $post_type_array   )  ,
							
							
							array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Posts','ioa').'</a>' , "class" => "has-input-button") ,
							
							)
			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,
			__("Control Stylings",'ioa') => array(

										
										array( 
											"label" => __("Arrow Color",'ioa') , 
											"name" => "arc" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " .bx-wrapper .bx-controls-direction a " ,
										 			"property" => "color" 

							 					)     
										),
										array( 
											"label" => __("Arrow Background Color",'ioa') , 
											"name" => "arbg" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => " .bx-wrapper .bx-controls-direction a " ,
										 			"property" => "background-color" 

							 					)     
										),

									)
		)

	));


/**
 * Testimonials
 */

$radunits['rad_testimonials_widget'] = new RADUnit(array(
	'label' => __('Testimonials','ioa'),
	'id' => 'rad_testimonials_widget',
	'feedback' => " Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> testimonials . ",
	'template' => 'testimonials',
	'group'	=> 'widgets',
	'icon' => 'usersicon-',
	'heading' => 'Testimonials Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(
							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,

							array( "label" => __("Select Style",'ioa') , "name" => "t_style" , "meta" => true,"default" => "default" , "type" => "select",  "length" => 'medium'  ,  "options" => array("default" => __("Default",'ioa'),"centered" => __("Centered",'ioa') ) )  ,

							array(  "label" => __("Number of Testimonials (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
							
							array( "label" => __("Sort by",'ioa') , "name" => "sort_by" , "default" => "" , "type" => "select",  "length" => 'medium'  , "options" => array("date" => __("Date",'ioa'),"title" => __("Title",'ioa'),"random" =>__("Random",'ioa'))   )  ,
							array( "label" => __("Order",'ioa') , "name" => "order" , "default" => "" , "type" => "select",  "length" => 'medium'  , "options" => array("ASC" => __("Ascending",'ioa'),"DESC" => __("Descending",'ioa'))   )  ,

							)
			),

	'styles' => array(

		__("Title Styling",'ioa') => $title_default_stylings,
		__("Testimonails Styling","ioa") => array(

				array( 
						"label" => __("Content Color",'ioa') , "name" => "testi_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-testimonials-list .desc " ,"property" => "color" )     
					),
				array( 
						"label" => __("Content Font Size",'ioa') , "name" => "testi_size" ,"default" => "0" ,"type" => "slider", "suffix" => 'px' , "max" => 300 ,  "length" => 'medium' ,
						 "data" => array( "target" => " .rad-testimonials-list .desc " ,"property" => "font-size" )     
					),
				array( 
						"label" => __("Name Color",'ioa') , "name" => "testi_title_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".rad-testimonials-list  h2 " ,"property" => "color" )     
					),
				array( 
						"label" => __("Designation Color",'ioa') , "name" => "testi_desig_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".rad-testimonials-list .designation " ,"property" => "color" )     
					),

			)

		)

	));


/**
 * Testimonials List
 */

$radunits['rad_testimonials_list_widget'] = new RADUnit(array(
	'label' => __('Testimonials List','ioa'),
	'id' => 'rad_testimonials_list_widget',
	'feedback' => " Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> testimonials . ",
	'template' => 'testimonials_list',
	'group'	=> 'widgets',
	'icon' => 'user-1icon- ',
	'heading' => 'Testimonials List Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(
							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,

								array(  "label" => __("Number of Testimonials (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
							
							array( "label" => __("Sort by",'ioa') , "name" => "sort_by" , "default" => "" , "type" => "select",  "length" => 'medium'  , "options" => array("date" => __("Date",'ioa'),"title" => __("Title",'ioa'),"random" =>__("Random",'ioa'))   )  ,
							array( "label" => __("Order",'ioa') , "name" => "order" , "default" => "" , "type" => "select",  "length" => 'medium'  , "options" => array("ASC" => __("Ascending",'ioa'),"DESC" => __("Descending",'ioa'))   )  ,

							)
			),

	'styles' => array(

		__("Title Styling",'ioa') => $title_default_stylings,
		__("Testimonails Styling","ioa") => array(

				array( 
						"label" => __("Content Color",'ioa') , "name" => "testi_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " .rad-testimonials-list-alt .desc " ,"property" => "color" )     
					),
				array( 
						"label" => __("Content Font Size",'ioa') , "name" => "testi_size" ,"default" => "0" ,"type" => "slider", "suffix" => 'px' , "max" => 300 ,  "length" => 'medium' ,
						 "data" => array( "target" => " .rad-testimonials-list-alt .desc " ,"property" => "font-size" )     
					),
				array( 
						"label" => __("Name Color",'ioa') , "name" => "testi_title_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".rad-testimonials-list-alt  h2 " ,"property" => "color" )     
					),
				array( 
						"label" => __("Designation Color",'ioa') , "name" => "testi_desig_color" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".rad-testimonials-list-alt .designation " ,"property" => "color" )     
					),

			)

		)

	));

/**
 * Single Testimonial Unit
 */

$testimonials = get_posts('post_type=testimonial');
$ts = array();
foreach ($testimonials as $post) {
   $ts[$post->ID] = get_the_title($post->ID) ;
}

$radunits['rad_testimonial_widget'] = new RADUnit(array(
	'label' => __('Testimonial','ioa'),
	'id' => 'rad_testimonial_widget',
	'template' => 'testimonial_bubble',
	'group'	=> 'widgets',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-t_id'>".__('Testimonial of','ioa')." {t_id}</h4></div> ",
	'icon' => 'user-2icon- ',
	'heading' => 'Testimonial Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

							array(  "label" => __("Select Testimonial",'ioa') , "name" => "t_id" ,"default" => "" ,"type" => "select","options" => $ts ,  "length" => 'medium') ,
							
							array(  "label" => __("Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In",'ioa') , "fade-left" => __("Fade from Left" ,'ioa'), "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom" ,'ioa'),"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left" ,'ioa'), "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top" ,'ioa')   )  ),
							array(  "label" => __("Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),

							)
			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

		)

	));


/**
 * Video Widget
 */

$radunits['rad_video_widget'] = new RADUnit(array(
	'label' => __('Video','ioa'),
	'id' => 'rad_video_widget',
	'template' => 'video',
	'group'	=> 'media',
	'icon' => 'video-1icon-',
	'heading' => 'Video Settings',
	'feedback' => "<div class='min-rad-highlight'>".__("Showing Video",'ioa')." <strong class='vf-v_id'>{v_id}</strong></div>",
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Caption",'ioa') , "name" => "text_caption" ,"default" => "Sub Title" ,"type" => "text","length" => 'medium')  ,
							array(  "label" => __("Video URL",'ioa') , "name" => "v_id" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Auto Width",'ioa')  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text",  "length" => 'medium') ,
							

							)
			),

	'styles' => array(
			__("Title Styling",'ioa') => $title_default_stylings,
			__(" Text Styling",'ioa') => array(
										
										array( 
											"label" => __("Caption Color",'ioa') , 
											"name" => "text_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => "div.video-inner-wrap h4.text_caption" ,
										 			"property" => "color" 

							 				)     
										),


									)

		)

	));



/**
 * Self Hosted Video Widget
 */

$radunits['rad_self_video_widget'] = new RADUnit(array(
	'label' => __('Hosted Video','ioa'),
	'id' => 'rad_self_video_widget',
	'template' => 'self_video',
	'group'	=> 'media',
	'icon' => 'video-2icon-',
	'heading' => 'Video Settings',
	'feedback' => "<div class='min-rad-highlight'>".__("Showing Self Hosted Video",'ioa')." <strong class='vf-video_url'>{video_url}</strong></div>",
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Video URL",'ioa') , "name" => "video_url" ,"default" => "" ,"type" => "video", "class" => "has-input-button", "length" => 'medium' ) ,
							array(  "label" => __("Video Fallback Image",'ioa') , "name" => "video_fallback" ,"default" => "" ,"type" => "upload",  "length" => 'medium') ,
							array(  "label" => __("Auto Width",'ioa')  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300" ,"type" => "text",  "length" => 'medium') ,
							

							)
			),

	'styles' => array(
			__("Title Styling",'ioa') => $title_default_stylings,
			__(" Text Styling",'ioa') => array(
										
										array( 
											"label" => __("Caption Color",'ioa') , 
											"name" => "text_color" , 
											"default" => "" , 
											"type" => "colorpicker",
											
											
											"value" => "",
											 "data" => array(

										 			"target" => "div.video-inner-wrap h4.text_caption" ,
										 			"property" => "color" 

							 				)     
										),


									)

		)

	));

// Progress Bars Widget
 
$cinputs = array(
					array( 
							"label" => __("Section Color",'ioa') , 
							"name" => "pr_color" , 
							"default" => "" , 
							"type" => "colorpicker",
							
							"length" => 'medium',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Label",'ioa') , 
							"name" => "pr_label" , 
							"default" => "Label" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Enter Percent",'ioa') , 
							"name" => "pr_value" , 
							"default" => "20" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) 
							

			);

$radunits['rad_progressbar_widget'] = new RADUnit(array(
	'label' => __('Progress Bar','ioa'),
	'id' => 'rad_progressbar_widget',
	'template' => 'progress_bar',
	'feedback' => "<div class='min-rad-highlight'>Showing  Progess Bars</div>",
	'group'	=> 'infographic',
	'icon' => 'progress-2icon-',
	'heading' => 'Progress Bar Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Enter Value Unit",'ioa') , "name" => "unit" ,"default" => "%" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Show Animated Strips",'ioa') , "name" => "show_strips" ,"default" => "no" ,"type" => "select",  "length" => 'medium' , "options" => array( "yes" => "Yes" , "no" => "No" ) ) ,
							
													
							),
							__("Add Bars",'ioa') => array(
								array( 'inputs' => $cinputs, 'label' => __('Progress Bars','ioa'), 	'name' => 'rad_tab','type'=>'module','unit' => __(' Section','ioa'))
							
							)
			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));

// Radial Widget


$radunits['rad_radial_widget'] = new RADUnit(array(
	'label' => __('Radial Chart','ioa'),
	'id' => 'rad_radial_widget',
	'template' => 'radial_chart',
	'feedback' => " <div class='min-rad-highlight'>Showing Radial Chart <strong class='vf-text_title'>{text_title}</strong> with value <strong class='vf-value'>{value}</strong></div>",
	'group'	=> 'infographic',
	'icon' => 'dot-circledicon- ',
	'heading' => 'Radial Chart Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
							
							array(  "label" => __("Enter Label",'ioa') , "name" => "label" ,"default" => "A" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Enter Value (1 to 100)",'ioa'), "name" => "value" ,"default" => "60" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Set Thickness",'ioa'), "name" => "size" ,"default" => "10" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Auto Width",'ioa')  , "name" => "auto_width" ,"default" => "yes" ,"type" => "select",  "length" => 'medium', "options" =>array("yes" => "Yes" , "no" => "No" ) ) ,
							array(  "label" => __("Width",'ioa'), "name" => "width" ,"default" => "400" ,"type" => "text",  "length" => 'medium') ,
							
							array(  "label" => __("Bar Color",'ioa'),"alpha" => false, "name" => "bar_color" ,"default" => "" ,"type" => "colorpicker",  "length" => 'medium') ,
							
							)
			),

	'styles' => array(

		__("Title Styling",'ioa') => $title_default_stylings,
		__("Radial Stylings",'ioa') => array(
				array( 
						"label" => __("Radial Label Color",'ioa') , "name" => "scctc" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".radial-chart" ,"property" => "color" ) ,
					),
				
				)


	 )

	));


// Counter Widget


$radunits['rad_counter_widget'] = new RADUnit(array(
	'label' => __('Counter','ioa'),
	'id' => 'rad_counter_widget',
	'template' => 'counter',
	'feedback' => "<div class='min-rad-highlight'> Counter <strong class='vf-text_title'>{text_title}</strong> starting from <strong class='vf-start'>{start}</strong> to <strong class='vf-end'>{end}</strong></div>",
	'group'	=> 'infographic',
	'icon' => 'sort-number-upicon- ',
	'heading' => 'Counter Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
							 array( 
              "label" => __("Add Icon Title",'ioa') , 
              "name" => "t_icon" , 
              "class" => "has-two-buttons",
              "default" => "" , 
              "type" => "text",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a><a class="button-default image_iupload">Add Image Icon</a>'  ,
              "value" => ""   
          ) , 
							array(  "label" => __("Enter Start Value",'ioa'), "name" => "start" ,"default" => "0" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Enter Final Value",'ioa'), "name" => "end" ,"default" => "100" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Enter Steps",'ioa'), "name" => "step" ,"default" => "1" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Enter Total Time Duration",'ioa'), "name" => "time" ,"default" => "1500" ,"type" => "slider", "suffix" => 'ms', "max" => 10000,  "length" => 'medium') ,
							
							
							)
			),

	'styles' => array(
			__("Title Styling",'ioa') => $title_default_stylings,
			__("Counter Stylings",'ioa') => array(
				array( 
						"label" => __("Counter Text Color",'ioa') , "name" => "ctc" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".counter-inner-wrap .counter " ,"property" => "color" ) ,
					),

				array( 
						"label" => __("Counter Text Font Size",'ioa') , "name" => "ctsc" , "default" => "" ,"type" => "text","value" => "",
						 "data" => array( "target" => ".counter-inner-wrap .counter " ,"property" => "font-size" ) ,
					),

				array( 
						"label" => __("Styled Counter Border Color",'ioa') , "name" => "ssctsc" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => ".counter-inner-wrap.counter-styled " ,"property" => "border-color" ) ,
					),

				)
	 )

	));



// Button Widget


$radunits['rad_button_widget'] = new RADUnit(array(
	'label' => __('Button','ioa'),
	'id' => 'rad_button_widget',
	'template' => 'button',
	'feedback' => "  <a href='#' class='vf-label rad-feedback-button'>{label}</a>",
	'group'	=> 'widgets',
	'icon' => 'check-emptyicon-',
	'heading' => 'Button Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

				array(  "label" => __("Enter Button Label",'ioa') , "name" => "label" ,"default" => "Button" ,"type" => "text",  "length" => 'medium') ,
				array( "label" => __("Set Link",'ioa') , "name" => "col_link" , "default" => "none" , "type" => "select",  'optgroup' => true, "options" => $links ) ,
				array(  "label" => __("Custom Link",'ioa') , "name" => "custom_link" ,"default" => "" ,"type" => "text", 'class'=> "ioa-link-filter custom" ) ,

				array(  "label" => __("Enter Video Link",'ioa') , "name" => "video_link" ,"default" => "" ,"type" => "text", 'class'=> "ioa-link-filter video" ) ,

				array(  "label" => __("Image",'ioa') , "name" => "image_link" ,"default" => "" ,"type" => "upload", 'class'=> "ioa-link-filter image" ) ,

				array(  "label" => __("Select Button Style",'ioa') , "name" => "button_style" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Default",'ioa'), "gradient" => __("Gradient",'ioa') , "classic" => __("Classic",'ioa')   )  ),

				array(  "label" => __("Add Icon Title",'ioa') , "name" => "t_icon" , "default" => "" , "type" => "text", 'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a>'  , "value" => ""    ) , 
			
				array(  "label" => __("Set Button Color",'ioa'), "name" => "button_color" ,"default" => "" ,"type" => "colorpicker",  "length" => 'medium') ,
				array(  "label" => __("Set Button Background",'ioa'), "name" => "button_bgcolor" ,"default" => "" ,"type" => "colorpicker",  "length" => 'medium') ,

				array(  "label" => __("Open in New Window",'ioa') , "name" => "new_window" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("no" => __("No",'ioa'), "yes" => __("Yes",'ioa')   )  ),

				array(  "label" => __("Select Button Size",'ioa') , "name" => "button_size" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array("default" => __("Default",'ioa'), "small" => __("Small",'ioa') , "large" => __("Large",'ioa') , "big" => __("Big",'ioa')  , "block" => __("Full Stretch",'ioa') )  ),

				array(  "label" => __("Set Button Radius",'ioa') , "name" => "radius" ,"default" => "0" ,"type" => "slider", "suffix" => 'px' , "max" => 300 ,  "length" => 'medium') ,

			
				array(  "label" => __("Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In",'ioa') , "fade-left" => __("Fade from Left" ,'ioa'), "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom" ,'ioa'),"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left" ,'ioa'), "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top" ,'ioa')   )  ),
				array(  "label" => __("Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
							
							)
			),

	'styles' => array(

	 )

	));

// Team Widget

$ainputs = array(
          array( 
              "label" => __("Enter Link",'ioa') , 
              "name" => "social_link" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,

           array( 
              "label" => __("Enter Label(if empty tooltip won't appear)",'ioa') , 
              "name" => "social_label" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,
            array( 
              "label" => __("Icon Hover Color",'ioa') , 
              "name" => "social_color" , 
              "default" => "" , 
              "type" => "colorpicker",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Set Icon",'ioa') , 
              "name" => "social_icon" , 
              "default" => "" , 
              "type" => "text",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a><a class="button-default image_iupload">Add Image Icon</a>'  ,
              "value" => ""   
          )     

      );


$radunits['rad_teamwidget_widget'] = new RADUnit(array(
	'label' => __('Person','ioa'),
	'id' => 'rad_teamwidget_widget',
	'template' => 'person',
	'group'	=> 'widgets',
	'feedback' => "<div class='rad-person-info'><h2 class='vf-mem_name'>{mem_name}</h2><img src='{photo}' /> <span class='vf-mem_desc'>{mem_desc}</span> </div>",
	'icon' => 'usericon-',
	'heading' => 'Person Settings',
	'inputs' => array(
				__("General Fields",'ioa') => array(

							array(  "label" => __("Photo",'ioa') , "name" => "photo" ,"default" => $demo_imgs[0] ,"type" => "upload",  "length" => 'medium') ,
							array(  "label" => __("Name",'ioa'), "name" => "mem_name" ,"default" => "Tony Stark" ,"type" => "text",  "length" => 'medium') ,
							array(  "label" => __("Description",'ioa'), "name" => "mem_desc" ,"default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tempus vestibulum mi. Nam metus elit, vestibulum et turpis ac, imperdiet tristique diam" ,"type" => "textarea",  "length" => 'medium') ,
							array(  "label" => __("Designation",'ioa'), "name" => "mem_desig" ,"default" => "CEO" ,"type" => "text",  "length" => 'medium') ,
							
							array(  "label" => __("Height",'ioa') , "meta" => "true", "name" => "height" ,"default" => "400" ,"type" => "text","length" => 'medium')  ,
							
							array(  "label" => __("Animation on Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In",'ioa') , "fade-left" => __("Fade from Left" ,'ioa'), "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom" ,'ioa'),"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left" ,'ioa'), "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top" ,'ioa')   )  ),
							array(  "label" => __("Animation Delay",'ioa') , "name" => "delay" , "default" => "" , "type" => "slider",  "length" => 'medium' , "suffix" => "secs" , "max" => 120  ),
							),
							__("Social Links",'ioa') => array(
								 array( 'inputs' => $ainputs, 'label' => __('Social Icons','ioa'),  'name' => 'rad_tab','type'=>'module','unit' => __(' Icon','ioa') )

								) 
							
			),

	'styles' => array(

	 )

	));



/**
 * Third Party Widgets
 */

/**
 * Revolution Slider
 */

		$slds = array("none" => "None");
if(function_exists('rev_slider_shortcode'))
	{
		global $wpdb;
		 $table_db_name = GlobalsRevSlider::$table_sliders;
		 $lsliders = $wpdb->get_results("SELECT * FROM $table_db_name",ARRAY_A);

		 foreach ($lsliders as $slider) {
		 	$slds[$slider['alias']] = $slider['title'];
		 }

	

$radunits['rad_rev_widget'] = new RADUnit(array(
	'label' => __('Revolution Slider','ioa'),
	'id' => 'rad_rev_widget',
	'feedback' => " Using Slider with ID <strong class='vf-slider_id'>{slider_id}</strong>",
	'template' => 'rev_slider',
	'group'	=> 'widgets',
	'icon' => ' cog-alticon- ',
	'heading' => 'Revolution Slider Settings',
	'inputs' => array(

			  __("General Settings",'ioa') => array(
			  		array( 'name' => 'slider_id' , 'type' => 'select' , 'label' => 'Select Slider' , 'default' => 'none' , 'options' => $slds ),
			  	)

			),

	'styles' => array(
	
		)


	));
}
/**
 * Contact Form 7
 */



$forms = get_posts('posts_per_page=-1&post_type=wpcf7_contact_form');

$cf = array("none"=>"None");

foreach ($forms as $key => $form) {
	$cf[$form->ID] = get_the_title($form->ID);
}

$radunits['rad_cf7_widget'] = new RADUnit(array(
	'label' => __('Contact Form 7','ioa'),
	'id' => 'rad_cf7_widget',
	'feedback' => "Using Contact Form  <strong class='vf-contact_id'>{contact_id}</strong>",
	'template' => 'contactform',
	'group'	=> 'widgets',
	'icon' => ' cog-alticon- ',
	'heading' => 'Contact Form Settings',
	'inputs' => array(

			  __("General Settings",'ioa') => array(
					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
			  		array( 'name' => 'contact_id' , 'type' => 'select' , 'label' => 'Select Form' , 'default' => 'none' , 'options' =>$cf ),
			  	)

			),

	'styles' => array(
			__("Title Styling",'ioa') => $title_default_stylings,
			__("Form Stylings",'ioa') => array(
				array( 
						"label" => __("Label Color",'ioa') , "name" => "c7l" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => "form.wpcf7-form p " ,"property" => "color" ) ,
					),


				array( 
						"label" => __("Inputs Border Color",'ioa') , "name" => "c7l-br" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " form.wpcf7-form .wpcf7-text " ,"property" => "border-color"  , "extra_cl" => array(

						 	"form.wpcf7-form .wpcf7-select" => "border-color",
						 	"form.wpcf7-form .wpcf7-textarea" => "border-color",
						 	"form.wpcf7-form .wpcf7-password" => "border-color",
						 	"form.wpcf7-form .wpcf7-email" => "border-color",
						 	"form.wpcf7-form .wpcf7-captchar" => "border-color",

						 	) ) ,
						 ),

				array( 
						"label" => __("Inputs Background Color",'ioa') , "name" => "c7l-bg" , "default" => "" ,"type" => "colorpicker","value" => "",
						 "data" => array( "target" => " form.wpcf7-form .wpcf7-text " ,"property" => "background-color"  , "extra_cl" => array(

						 	"form.wpcf7-form .wpcf7-select" => "background-color",
						 	"form.wpcf7-form .wpcf7-textarea" => "background-color",
						 	"form.wpcf7-form .wpcf7-password" => "background-color",
						 	"form.wpcf7-form .wpcf7-email" => "background-color",
						 	"form.wpcf7-form .wpcf7-captchar" => "background-color",

						 	) ) ,
						 )

			

					)

			)	

	));



/**
 * Tabs Widget
 */


$inputs = array(
					array( 
							"label" => __("Feature Title",'ioa') , 
							"name" => "r_title" , 
							"default" => "Basic" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Feature Price",'ioa') , 
							"name" => "r_price" , 
							"default" => "35$" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					array( 
							"label" => __("Featured Column",'ioa') , 
							"name" => "r_featured_col" , 
							"default" => "No" , 
							"type" => "select",
							"options" => array("No","Yes"),
							"value" => "No"   
					) ,
					array( 
							"label" => __("Information Below Price",'ioa') , 
							"name" => "r_price_info" , 
							"default" => "Monthly" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,

					array( 
							"label" => __("Column Rows separated by ; (use [tick] for tick and [cross] for cross icon)",'ioa') , 
							"name" => "r_data" , 
							"default" => "Feature;Feature;Feature;Feature;" , 
							"type" => "textarea",
							
							"length" => 'long',
							"value" => ""   
					) ,

					array( 
							"label" => __("Button Label",'ioa') , 
							"name" => "r_button_label" , 
							"default" => "Sign Up" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,

					array( 
							"label" => __("Button Link",'ioa') , 
							"name" => "r_button_link" , 
							"default" => "#" , 
							"type" => "text",
							
							"length" => 'long',
							"value" => ""   
					) ,
					
					
						

			);


/**
 * Pricing Widget
 */

$radunits['rad_pricing_widget'] = new RADUnit(array(
	'label' => __('Pricing Table','ioa'),
	'id' => 'rad_pricing_widget',
	'template' => 'pricing',
	'group'	=> 'widgets',
	'icon' => '  moneyicon- ',
	'feedback' => " Pricing Table - <strong class='vf-text_title'>{text_title}</strong>",
	'heading' => 'Pricing Settings',
	'inputs' => array(
					 __("General Fields",'ioa') => array(

						array(  "label" =>  __("Title",'ioa') , "name" => "text_title" ,"default" => "Title" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" =>  __("Plan Title",'ioa') , "name" => "p_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" =>  __("Show Featured Column",'ioa') , "name" => "show_featured_col" ,"default" => "yes" ,"type" => "select",  "length" => 'medium' , "options" => array("yes"=>"Yes","no" =>"No")  ) ,
						array(  "label" =>  __("Plan Description",'ioa') , "name" => "p_desc" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" =>  __("Enter Feature Row Data( Separate by ; )",'ioa') , "name" => "p_feature_list" ,"default" => "" ,"type" => "textarea",  "length" => 'medium') ,
						
						),

						__("Add Plan Column",'ioa') => array(
							array( 'inputs' => $inputs, 'label' => __('Row' ,'ioa') , 	'name' => 'rad_tab','type'=>'module','unit' => __(' Column','ioa') )
						
						)

			),

	'styles' => array( 
			__("Title Styling",'ioa') => $title_default_stylings,
	 )

	));


if(IOA_WOO_EXISTS) :

/**
 * Product Grid
 */

$radunits['rad_product_grid_widget'] = new RADUnit(array(
	'label' => __('Products Grid','ioa'),
	'id' => 'rad_product_grid_widget',
	'template' => 'woocommerce/post_grid',
	'group'	=> 'widgets',
	'icon' => ' cog-alticon- ',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in Products. </div> ",
	'heading' => 'Product Grid Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

						array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Recent Products" ,"type" => "text",  "length" => 'medium') ,
						array( "label" => __("Post Structure",'ioa') , "name" => "post_structure" , "default" => "4-col" , "type" => "select",  "length" => 'medium'  , "options" => array("1-col" => __("Featured Column",'ioa'),"2-col" => __("Two Columns",'ioa'),"3-col" => __("Three Columns",'ioa'),"4-col" => __("Four Columns",'ioa'),"5-col" => __("Five Columns",'ioa'))   )  ,
						array(  "label" => __("Number of Product (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,

						array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "product" , "type" => "hidden",  "length" => 'medium'  )  ,
						array( "label" => __("Show Pagination",'ioa') , "name" => "w_pagination" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
						
						array( "label" => __("Show Filter",'ioa') , "name" => "filter_menu" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') )  )  ,
						
						array(  "label" => __("WP Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Product','ioa').'</a>'  , "class" => "has-input-button" ) ,

					),
					__("Animation",'ioa') => array(

						array(  "label" => __("Product Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
						array(  "label" => __("Product Items Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));


/**
 * Product List
 */

$radunits['rad_product_list_widget'] = new RADUnit(array(
	'label' => __('Products List','ioa'),
	'id' => 'rad_product_list_widget',
	'template' => 'woocommerce/post_list',
	'group'	=> 'widgets',
	'icon' => ' cog-alticon- ',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> <strong class='vf-post_type'>{post_type}</strong> items in Products. </div> ",
	'heading' => 'Product Grid Settings',
	'inputs' => array(
					__("General Fields",'ioa') => array(

						array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "Recent Products" ,"type" => "text",  "length" => 'medium') ,
						array(  "label" => __("Number of Product (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,

						array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "product" , "type" => "hidden",  "length" => 'medium'  )  ,
						array( "label" => __("Show Pagination",'ioa') , "name" => "w_pagination" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa'))   )  ,
						
						
						array(  "label" => __("WP Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter Product','ioa').'</a>'  , "class" => "has-input-button" ) ,

					),
					__("Animation",'ioa') => array(

						array(  "label" => __("Product Animation Visibility",'ioa') , "name" => "visibility" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),
						array(  "label" => __("Product Items Animation Visibility",'ioa') , "name" => "chainability" , "default" => "none" , "type" => "select",  "length" => 'medium'  , "options" => array("none" => __("None",'ioa'), "fade" => __("Fade In" ,'ioa'), "fade-left" => __("Fade from Left",'ioa') , "fade-top" => __("Fade from Top",'ioa') , "fade-bottom" => __("Fade from Bottom",'ioa') ,"fade-right" => __("Fade from Right",'ioa') , "scale-in" => __("Scale In",'ioa') ,"scale-out" => __("Scale Out",'ioa') , "big-fade-left" => __("Long Fade from Left",'ioa') , "big-fade-right" => __("Long Fade from Right",'ioa'), "big-fade-bottom" => __("Long Fade from Bottom",'ioa')  , "big-fade-top" => __("Long Fade from Top",'ioa')    )  ),

					)

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));

$radunits['rad_product_masonry_widget'] = new RADUnit(array(
	'label' => __('Masonry Products','ioa'),
	'id' => 'rad_product_masonry_widget',
	'template' => 'woocommerce/post_masonry',
	'group'	=> 'widgets',
	'icon' => ' cog-alticon- ',
	'heading' => 'Masonry Products Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> Product items. </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "product" , "type" => "hidden",  "length" => 'medium'   )  ,
					array( "label" => __("Show Filter",'ioa') , "name" => "filter_menu" , "default" => "no" , "type" => "select",  "length" => 'medium'  , "options" => array("yes" => __("Yes",'ioa'),"no" => __("No",'ioa') )  )  ,

					array( "label" => __("Masonry Type",'ioa') , "name" => "masonry_type" , "default" => "default" , "type" => "select",  "length" => 'medium'  , "options" => array( "default" =>"Equal Grid" , "wproportional" => "Masonry" )   )  ,

					array( "label" => __("Masonry Layout",'ioa') , "name" => "masonry_layout" , "default" => "four-col" , "type" => "select",  "length" => 'medium'  , "options" => array( "four-col" =>"Four Column" ,"five-col" =>"Five Column" ,"six-col" =>"Six Column"  )   )  ,

					array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "500"  ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter','ioa').'</a>' , "class" => "has-input-button") ,
						
					),

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));


$radunits['rad_product_shortcodes_widget'] = new RADUnit(array(
	'label' => __('Products Shortcode','ioa'),
	'id' => 'rad_product_shortcodes_widget',
	'template' => 'woocommerce/default',
	'group'	=> 'widgets',
	'icon' => ' cog-alticon- ',
	'heading' => 'Products Settings',
	'feedback' => " <div class='rad-post-list-info clearfix'> <h4 class='vf-text_title'>{text_title}</h4> Showing <strong class='vf-no_of_posts'>{no_of_posts}</strong> Product items. </div> ",
	'inputs' => array(
					__("General Fields",'ioa') => array(

					array(  "label" => __("Title",'ioa') , "name" => "text_title" ,"default" => "" ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Number of Posts (enter -1 to show all)",'ioa') , "name" => "no_of_posts" ,"default" => "4" ,"type" => "text",  "length" => 'medium') ,
					array( "label" => __("Post Type",'ioa') , "name" => "post_type" , "default" => "product" , "type" => "hidden",  "length" => 'medium'   )  ,
					array(  "label" => __("Height",'ioa') , "name" => "height" ,"default" => "300"  ,"type" => "text",  "length" => 'medium') ,
					array(  "label" => __("Query",'ioa') , "name" => "posts_query" ,"default" => "" ,"type" => "text",  "length" => 'medium', 'addMarkup' => '<a href="" class="button-default query-maker">'.__('Filter','ioa').'</a>' , "class" => "has-input-button") ,
						
					),

			),

	'styles' => array(

			__("Title Styling",'ioa') => $title_default_stylings,

	 )

	));

endif;

}

