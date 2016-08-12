<?php 
/**
 * Enigma Styler -- Official Styler for IOA Framework
 * @author Abhin Sharma 
 * @dependency none
 * @since  IOA Framework V1
 */

$template = get_option(SN.'_active_etemplate');
if(!$template)
{
	$data = get_option(SN.'_enigma_data');
}
else
{
	if($template=="default")
		$data =get_option(SN.'_enigma_data');
	else
		$data =get_option($template);
	
}

if(!$data) $data = array();

$mutated_vals = array();

if(is_array($data))
foreach ($data as  $value) {
	
	if(isset($value['target']))
	$mutated_vals[$value['target'].''.$value['name']] = $value['value'];
}


 if(!class_exists('Enigma'))
{
	class Enigma extends RADStyler
	{
		
		public function getBackgroundImage($label , $prop , $target)
		{
			global $mutated_vals;
			 
			$code ='';
			$defimage = ''; $defposition = "top left"; $defsize = "auto"; $defrepeat = "repeat"; $defattachment = "scroll";

			if(isset($mutated_vals[$target.''.$prop])) $defimage = $mutated_vals[$target.''.$prop];


			$code .=  getIOAInput(array( 
									"label" => __("Background Image",'ioa') , 
									"name" => "_bg_image" , 
									"default" => $defimage , 
									"type" => "upload",
									"description" => "" ,
									"length" => 'small'  ,
									"title" => __("Use as Background Image",'ioa'),
				  					"std" => "",
				 					"button" => __("Add Image",'ioa'),
				 					"class" => ' rad_style_property ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-image" 

							 			) 

							) );

			if(isset($mutated_vals[$target."background-position"])) $defposition = $mutated_vals[$target."background-position"];


			$code .= getIOAInput(array( 
									"label" => __("Background Position",'ioa') , 
									"name" => "_bgposition" , 
									"default" => $defposition , 
									"type" => "select",
									"class" => ' rad_style_property ',
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right"),
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-position" 

							 			)  			 
							) );

			if(isset($mutated_vals[$target."background-size"])) $defsize = $mutated_vals[$target."background-size"];


			$code .= getIOAInput(array( 
									"label" => __("Background Cover",'ioa') , 
									"name" => "_bgcover" , 
									"default" => $defsize , 
									"type" => "select",
									"class" => ' rad_style_property ',
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("auto","contain","cover"),
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-size" 

							 			)  			 
							) );

			if(isset($mutated_vals[$target."background-repeat"])) $defrepeat = $mutated_vals[$target."background-repeat"];


			$code .= getIOAInput(array( 
									"label" => __("Background Repeat",'ioa') , 
									"name" => "_bgrepeat" , 
									"default" => $defrepeat , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("repeat","repeat-x","repeat-y","no-repeat"),
									"class" => ' rad_style_property ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-repeat" 

							 			) 
												 
							) );
			if(isset($mutated_vals[$target."background-attachment"])) $defattachment = $mutated_vals[$target."background-attachment"];
				
			$code .= getIOAInput(array( 
									"label" => __("Background Scroll",'ioa') , 
									"name" => "_bgscroll" , 
									"default" => $defattachment , 
									"type" => "select",
									"description" => "" ,
									"length" => 'medium'  ,
									"options" => array("scroll","fixed"),
									"class" => ' rad_style_property ',
									"data" => array(

							 			"target" => $target ,
							 			"property" => "background-attachment" 

							 			) 
												 
							) );	
			return $code;
		}
		
		public function createStyleMatrix($args)
		{
			global $ioa_super_options;
			 
			$code = '';

			$websafe_fonts = array("Arial","Helvetica Neue","Helvetica",'Tahoma',"Verdana","Lucida Grande","Lucida Sans");
			$font_stack = get_option(SN.'font_stacks'); 
			$registered_fonts = array();

			if($font_stack!="" && is_array($font_stack))
			{
				foreach ($font_stack as $key => $font) {
					$font_br = explode(';',$font);
					$registered_fonts[] = $font_br[0];
				}
			}
  			
  			$fn_fonts = array_merge( array("None"), $registered_fonts, $websafe_fonts);

  			$fts = "google";
			if( get_option(SN.'font_selector') ) $fts = get_option(SN.'font_selector');

			if($fts=="fontface") 
			{
				$fontfaces = array("None");
				$font = $ioa_super_options[SN.'_font_face_font'];
				if(isset($font) && $font!="") $fontfaces[] = $font;
				$fn_fonts = array_merge( $fontfaces, $websafe_fonts);
			}

			if($fts=="fontdeck") 
			{
				$fontdeck = array("None");
				$font = $ioa_super_options[SN.'_font_deck_name'];
				if(isset($font) && $font!="") $fontdeck[] = $font;
				$fn_fonts = array_merge( $fontdeck, $websafe_fonts);
			}

			global $mutated_vals ;
			

			foreach ($args as $key => $section) {
			$code .='<h4 class="engima-styler-title">'.$key.'<i class="icon icon-caret-down"></i> <a href="" class="en-section-reset">'.__('Reset','ioa').'</a> </h4><div class="enigma-styler-section clearfix">';

			foreach ($section as  $key => $arg) {
					
			$code .='<h5 class="sub-styler-title">'.$arg['label'].'<i class="icon icon-caret-down"></i> <a href="" class="en-comp-reset">'.__('Reset','ioa').'</a> </h5><div class="sub-styler-section clearfix">';

			$i =0;
			
			
				
					foreach($arg['matrix'] as $key => $value)
					{
						$props = explode(',',$value['prop']);
						$defaults = array();
						if(isset($value['default']))
							$defaults = explode(',',$value['default']);
						$j=0;
						foreach ($props  as $prop) {
							
							$def = 	''; $d = '';
							if(isset($defaults[$j])) {
								 $def = $defaults[$j]; $d =  $defaults[$j];
							}
							if(isset($mutated_vals[$key.''.$prop])) $def = $mutated_vals[$key.''.$prop];
							$cls = '';

							if(isset($value['sync'])) $cls = ' sync ';
							if(isset($value['dark'])) $cls = ' sync-dark ';

							switch($prop)
							{
								case 'background-image' : $code .= $this->getBackgroundImage($value['label'],$prop,$key); break;
								case 'font-size' :

								$code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => "font-size"

													 			)  
													)); break;
								case 'line-height' :

								$code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => "line-height"

													 			)  
													));
								break;
								case 'border-width' :
								case 'border-bottom-width' :

								$code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => '1px' , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => $prop

													 			)  
													));
								break;
								case 'left' :
								case 'right' :
								case 'top' :
								case 'bottom' : $code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => '0px' , 
													"type" => "text",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => $prop

													 			)  
													));
								break;
								case 'border-style' :
								case 'border-bottom-style' :
								$code .= getIOAInput( 
															array( 
																	"label" => $value['label'] , 
																	"name" => "styler".$i , 
																	"default" => $d , 
																	"type" => "select",
																	"description" => "",
																	"length" => 'small',
																	"value" => $def ,
																	"options" => array('solid','dashed','dotted'),
																	"class" => $cls,
																	 "data" => array(

																	 			"target" => $key ,
																	 			"property" => $prop

																	 			)  
													));
								break;
								case 'font-family' :
								$code .= "<div class='info'> To add More Fonts, Click on Fonts on <strong>Top Menu</strong>. </div>".getIOAInput( 
															array( 
																	"label" => $value['label'] , 
																	"name" => "styler".$i , 
																	"default" => $d , 
																	"type" => "select",
																	"description" => "",
																	"length" => 'small',
																	"value" => $def ,
																	"options" => $fn_fonts,
																	"class" => $cls.' font-family-sel ',
																	 "data" => array(

																	 			"target" => $key ,
																	 			"property" => "font-family"

																	 			)  
													));
								break;
								case 'font-weight' :
								$code .= getIOAInput( 
															array( 
																	"label" => $value['label'] , 
																	"name" => "styler".$i , 
																	"default" => $d , 
																	"type" => "text",
																	"description" => "",
																	"length" => 'small',
																	"value" => $def ,
																	"class" => $cls,
																	 "data" => array(

																	 			"target" => $key ,
																	 			"property" => "font-weight"

																	 			)  
													));
								break;
								case 'parent-background-color' : 
								if(isset($mutated_vals[$key.'background-color'])) $def = $mutated_vals[$key.'background-color'];

								$code .= getIOAInput(array( 
													"label" => "Background Color" , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "colorpicker",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => "background-color"

													 			)  
													)); break;
								default : $code .= getIOAInput(array( 
													"label" => $value['label'] , 
													"name" => "styler".$i , 
													"default" => $d , 
													"type" => "colorpicker",
													"description" => "",
													"length" => 'small',
													"value" => $def ,
													"class" => $cls,
													 "data" => array(

													 			"target" => $key ,
													 			"property" => $prop

													 			)  
													));
							}
							$j++;

						}
						$i++;
					}
					$code .= '</div>';
			}	
					$code .= '</div>';

		}

			return $code;
		}

		

	}
}



