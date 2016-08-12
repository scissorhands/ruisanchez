<?php
/**
 *  Name - Dummy panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Nobody
 */

if(!is_admin()) return;


class EnigmaBackend extends IOA_PANEL_CORE {
	

	
	// init menu
	function __construct () { parent::__construct( __('Visual Styler','ioa'),'submenu','ioaeni');  }
	
	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	

		if( isset($_GET['page']) && $_GET['page'] == "ioaeni" )
		{
			

			if( isset($_GET['export_skin']) )
			{
				$palette  = get_transient('SKIN_EXPORT');

				$name = str_replace(' ','_',$palette['title']);
				
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.$name.'.txt');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');

				$output = base64_encode(json_encode($palette));
				echo $output;

				die();	
				
			} 

		}

	  }	
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){	
		 
		global  $ioa_helper,$ioa_super_options;

		?>
		
		<div class="ioa_panel_wrap visual_styler" data-url="<?php echo admin_url()."admin.php?page=ioamed"; ?>"> <!-- Panel Wrapper -->
			<div class=" clearfix">  <!-- Panel -->
        		<div id="option-panel-tabs" class="clearfix fullscreen ioa-tabs" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        

					<div class="ioa_sidenav_wrap">
	                <ul id="" class="ioa_sidenav clearfix">  <!-- Side Menu -->
	                 
					 <li>
	             		   <a href="#eni_skins" id=""> 
	             		  		 <span><?php _e('Skins','ioa') ?></span>
	             		   </a>
	             	 </li>
	             	<li>
	             		   <a href="#eni_typo" id=""> 
	             		  		 <span><?php _e('Typography','ioa') ?></span>
	             		   </a>
	             	 </li>
	             	 <li>
	             		   <a href="#eni_boxed" id=""> 
	             		  		 <span><?php _e('Advanced Stylings','ioa') ?></span>
	             		   </a>
	             	 </li>
	             	 <li>
	             		   <a href="#eni_custom_css" id=""> 
	             		  		 <span><?php _e('Custom CSS','ioa') ?></span>
	             		   </a>
	             	 </li>
	             	  <li>
	             		   <a href="#eni_font_face" id=""> 
	             		  		 <span><?php _e('Font Face','ioa') ?></span>
	             		   </a>
	             	 </li>
	             	 <li>
	             		   <a href="#eni_font_deck" id=""> 
	             		  		 <span><?php _e('Font Deck','ioa') ?></span>
	             		   </a>
	             	 </li>
	             	 
	             	
	             		
	                </ul>  <!-- End of Side Menu -->

	                 </div>
       			
                
                	<div id="panel-wrapper" class="clearfix visual_styler">
						
						<div id="eni_skins" class="clearifx">
							
							<div class="toolbox clearfix">
								<h4>Select Theme Skin</h4>
								<a href="" class="button-save save-visual-settings">Save</a>
							</div>

							<div class="inbuilt-styles">
								<h4>Select From Predefined Skin</h4>
								<?php 

										$data = get_option(SN.'_enigma_data');
										$dskin = 'default';

										if(isset($data['skin'])) $dskin = $data['skin'];

								 ?>
								<div class="inbuilt-styles-body clearfix">
									<div class="skin-item <?php if('default' == $dskin) echo 'active'; ?>" data-skin="default">
													
													<div class="preview-skin" >
														<i class="default-skin ioa-front-icon paper-planeicon-"></i>
														<div class="hover"> <i href="">Activate</i> </div>
														<a href="" class="skin-tick  checkicon- ioa-front-icon"></a>
													</div>	

													<span class="label">Default</span>

												</div>

										<?php 


										$stylePath =   get_template_directory()."/sprites/skins";
										$skins = scandir($stylePath);
										$skin_ar  = array("default");
										foreach ($skins as $key => $skin) {
											
											if($skin!='.' &&  $skin!='..')	
											{
												$skin_ar[] = $skin;
												?>
												<div class="skin-item <?php if($skin == $dskin) echo 'active'; ?>" data-skin="<?php echo $skin; ?>">
													
													<div class="preview-skin" >
														<img src="<?php echo URL.'/sprites/skins/'.$skin.'/preview.png'; ?>" alt="">
														<div class="hover"> <i href="">Activate</i> </div>
														<a href="" class="skin-tick  checkicon- ioa-front-icon"></a>
													</div>	

													<span class="label"><?php echo ucwords($skin); ?></span>

												</div>
												<?php
											}

										}


										 ?>
								</div>
							</div>

							<div class="predefined-schemes clearfix">
								<h4 class="clearfix"> 
									Available Color Scheme for <strong class="c-skin-label"><?php echo $dskin; ?></strong> skin
									 <a href="" class="adv-opts"><?php _e("[Advance Options]",'ioa') ?></a>
								</h4>
								<div class="scheme-override clearfix">
									<?php 
									$in_schemes = array();
									if(get_option(SN.'_pre_schemes'))
									{
										$in_schemes = get_option(SN.'_pre_schemes');
										$t_s = array(""=>"None");
										foreach ($in_schemes as $key => $scheme) {
											$s =  'default';
											if(isset($scheme['skin'])) $s = $scheme['skin'];
											$t_s[str_replace(' ','_',$key)] = $key."($s Skin)";
										}
										echo getIOAInput(array(
													"label" => __("Save Color Settings To Available Scheme",'ioa'),
													"name" => "scheme_s_override",
													"type" => "select" ,
													"options" => $t_s,
													"default" => "None",
													"value" =>"None",
													"length" => "small",
													"after_input" => '<a href="" class="button-default scheme-override-save">Save To Color Scheme</a>'
												));
									} 

									$toggle_scheme = 'no';
									if(get_option(SN.'_toggle_scheme')) $toggle_scheme = get_option(SN.'_toggle_scheme');

									echo getIOAInput(array(
													"label" => __("Disable Scheme System(If yes stylings will come from stylesheet)",'ioa'),
													"name" => "toggle_color_scheme",
													"type" => "select" ,
													"options" => array("no","yes"),
													"default" => "no",
													"value" => $toggle_scheme,
													"length" => "small"
												));

									 ?> 
									 
								</div>	
								<ul class="clearfix">

									<?php 
									global $ioa_visual_data,$color_scheme_default,$color_schemes;
								
									$str = '';
									/*
									$p = "<span href='' class='pblock' style='background:".$color_scheme_default['primary_color']."'></span><span href='' class='pblock' style='background:".$color_scheme_default['secondary_color']."'></span><span href='' class='pblock' style='background:".$color_scheme_default['color']."'></span><span href='' class='pblock' style='background:".$color_scheme_default['footer_color']."'></span>";

									$str .= "<li class='clearfix sch-sk-default'  data-masterskin='default' id='".str_replace(' ','_',$key)."'>
										<p class='clearfix'>$p</p><small>Default</small> ";

										foreach ($color_scheme_default as $key => $value) {
											$str .= "<input type='hidden' class='".$key."' value='".$value."' />";
										}

									$str .= "</li>";
									echo $str;

									*/


									$pre_schemes =   get_template_directory()."/sprites/colors";
									$schemes = scandir($pre_schemes);

									foreach ($schemes as $key => $scheme) {	
									$str = '';
									if($scheme!='.' &&  $scheme!='..')	{

									$fh = fopen($pre_schemes.'/'.$scheme, 'r');
									$theData = fread($fh, filesize($pre_schemes.'/'.$scheme));
									fclose($fh);

									$sch = json_decode(base64_decode($theData),true);
									$title = $sch['title'];
									$sch = $ioa_helper->getAssocMap($sch['palette'],'value');

									$s = 'default';
									if(isset($sch['skin'])) $s = $sch['skin'];

									$p = "<span href='' class='pblock' style='background:".$sch['primary_color']."'></span>";

									$str .= "<li class='clearfix sch-sk-".$s."'  data-masterskin='".$s."' id='".str_replace(' ','_',$key)."'>
										<p class='clearfix'>$p</p><small>$title</small> ";

										foreach ($sch as $key => $value) {
											$str .= "<input type='hidden' class='".$key."' value='".$value."' />";
										}

									}

									$str .= "</li>";
									echo $str;
								}


								
									
								foreach ($in_schemes as $key => $scheme) {
										$s = 'default';
										if(isset($scheme['skin'])) $s = $scheme['skin'];

										$p = "<span href='' class='pblock' style='background:".$scheme['primary_color']."'></span>";

										$str = "<li class='clearfix sch-sk-".$s."' data-masterskin='".$s."' data-id='".$key."' id='".str_replace(' ','_',$key)."'>
										<p class='clearfix'>$p</p> <small>".$key."</small>";

										foreach ($scheme as $key => $value) {
											$str .= "<input type='hidden' class='".$key."' value='".$value."' />";
										}

										$str .= "<i class='cancel-3icon- ioa-front-icon delete-scheme'></i></li>";
										echo $str;
									}	
									
								 ?>
								</ul>	

							</div>

							<div class="customize-settings clearfix">
								<h4 class="clearfix">
									<span> Customize Color Scheme  </span>
									<div class="ioa-admin-menu-wrap clearfix">
					        					<a href="" class="ioa-admin-menu ioa-front-icon cog-2icon-"></a>
					        					<ul class="ioa-admin-submenu">
					        						<li><a href="" class="reset-skin">Reset</a></li>
					        						<li><a href="" class="export-scheme-toggle">Save as Scheme</a></li>
					        						<li><a href="" class="export-skin-toggle">Export</a></li>
					        						<li><a href="" class="import-skin-toggle">Import</a></li>
					        					</ul>
						        			</div>
								</h4>
								
								<div class="export-skin-panel clearfix">
									<?php 
										echo getIOAInput(array( 
											 "label" => "Enter Title",
											 "name" => "skin_export_title",
											 "default" => "",
											 "type" => "text",
											 "after_input" => ""	
										  ));
										echo getIOAInput(array( 
											 "label" => "Select Skin",
											 "name" => "sk_ex_skin_v",
											 "default" => "default",
											 "options" => $skin_ar,
											 "type" => "select",
											 
										  ));
									 ?>	
									 <a href='<?php echo admin_url() ?>admin.php?page=ioaeni' class='export-skin button-default'>Export Skin</a>
								</div>
								<div class="export-scheme-panel clearfix">
									<?php 
										echo getIOAInput(array( 
											 "label" => "Enter Title",
											 "name" => "scheme_export_title",
											 "default" => "",
											 "type" => "text",
											 "after_input" => ""	
										  ));
										echo getIOAInput(array( 
											 "label" => "Select Skin",
											 "name" => "ex_skin_v",
											 "default" => "default",
											 "options" => $skin_ar,
											 "type" => "select",
											 
										  ));
									 ?>	
									 <a href='' class='save-as-scheme button-default'>Save</a>
								</div>

								<div class="import-skin-panel clearfix">
									<?php 
										echo getIOAInput(array( 
											 "label" => "Enter Import Code",
											 "name" => "skin_import_code",
											 "default" => "",
											 "type" => "textarea",
											 "after_input" => "<a href='".admin_url()."admin.php?page=ioaeni' class='import-skin button-default'>Import Skin</a>"	
										  ));
									 ?>	
								</div>

								<div class="customize-settings-body ">
									
										<ul class="clearfix">
										<?php 
											$palette = array();

											if( isset($data['palette']) )
											$palette = $data['palette'];

											

											foreach ($ioa_visual_data as $key => $ar) {
													
												echo "<li class='clearfix'><a href='#".str_replace(' ','_',$key)."'>$key</a></li>";
											}
											
										?>
										</ul>


										<?php 

											foreach ($ioa_visual_data as $key => $ar) {
												
												echo "<div id='".str_replace(' ','_',$key)."' class='clearfix'><ul class='customize-list'>";

													foreach($ar as $element)
													{
														$help = '';
														$v = '';
														$default = '';

														if(isset($element['help'])) $help = $element['help'];
														if(isset($color_scheme_default[$element['name']]))
														{
															$default = $v = $color_scheme_default[$element['name']];
														}
														if(isset($palette[$element['name']])) $v = $palette[$element['name']];
														

														$this->createSlab($v,$element['label'],$element['name'],$help,$default);

													}	

												echo "</ul></div>";	
												
											}
											

										 ?>


								</div>
							</div>	

						</div>

						<div id="eni_typo">
							
							<div class="ioa_options">
									<div class="subpanel">
										
										<ul class='clearfix'>
											<li><a href="#eni_font_family">Set Font Family</a></li>
											<li><a href="#eni_font_size">Set Font Size</a></li>
											<li><a href="#eni_newel">Add New Font Family Element</a></li>
										</ul>

										<a href="" class="button-error reset-visual-settings">Reset</a>
										<a href="" class="button-save save-visual-settings">Save</a>

										<form action="" class="typo-form">
											<div id="eni_font_family">
											<?php 
											global $ioa_typo_list;
											

												foreach ($ioa_typo_list as $key => $typo) {
													$this->createFontFamilySlab(array(
												"title" =>  $typo['title'],
												"id" => $typo['id']
												));
												}

											 ?>
										</div>	
										<div id="eni_font_size">
											<?php 

										 	$typography = array();

										 	if( isset($data['typography']) )
											$typography = $data['typography'];

											$fx_v = "No";
											if( isset($typography['theme_fz_override']) ) $fx_v  = $typography['theme_fz_override'];

											echo getIOAInput(array(
													"label" => "Override Theme's Font Size",
													"name" => "theme_fz_override",
													"type" => "select" ,
													"options" => array("Yes","No"),
													"default" => "No",
													"value" => $fx_v
												));

											$this->createFontSizeSlab(array(
												"title" => "Set Body Font Size",
											  	"id" =>  "body_font"
												));

											$this->createFontSizeSlab(array(
												"title" => "Set Top Menu Font Size",
											  	"id" =>  "topmenu_font"
												));

											$this->createFontSizeSlab(array(
												"title" => "Set Main & Bottom Menu Font Size",
											  	"id" =>  "mainmenu_font"
												));

											$this->createFontSizeSlab(array(
												"title" => "Set h1 Font Size",
											  	"id" =>  "h1_font"
												));


											$this->createFontSizeSlab(array(
												"title" => "Set h2 Font Size",
											  	"id" =>  "h2_font"
												));


											$this->createFontSizeSlab(array(
												"title" => "Set h3 Font Size",
											  	"id" =>  "h3_font"
												));


											$this->createFontSizeSlab(array(
												"title" => "Set h4 Font Size",
											  	"id" =>  "h4_font"
												));


											$this->createFontSizeSlab(array(
												"title" => "Set h5 Font Size",
											  	"id" =>  "h5_font"
												));


											$this->createFontSizeSlab(array(
												"title" => "Set h6 Font Size",
											  	"id" =>  "h6_font"
												));
											 ?>
										</div>	
										<div id="eni_newel" class="clearfix">
												
												<?php 
													echo getIOAInput(array(
															"label" => "Enter Element Name",
															"name" => "element_name",
															"type" => "text",
															"value" => ""
														));
													echo getIOAInput(array(
															"label" => "Enter Element Selector( ex .yourclass or #id )",
															"name" => "element_selector",
															"type" => "text",
															"value" => ""
														));
												 ?>	

												 <a href="" class="button-default add-new-typo">Add Element</a>
											
											<div class="custom-typo-list">
												<?php 
											$list = $data['custom_typo_list'] ;

											if($list)
											{

												foreach($list as $item) 
												{
													$this->createCustomTypoSlab($item);
												}

											}

											 ?>
											</div>
											<div class="hide">
												<?php $this->createCustomTypoSlab(); ?>
											</div>
										</div>

										</form>

									</div>
								</div>	

						</div>

						<div id="eni_boxed" class="clearifx">
							
							<div class="subpanel cleafix">
								
								<ul class='clearfix'>
											<li><a href="#eni_boxed_tab"><?php _e('Boxed Layout Background Stylings','ioa') ?></a></li>
											<li><a href="#eni_title_tab"><?php _e('Behind Title & Transparent Bar Stylings','ioa') ?></a></li>
								</ul>

										<a href="" class="button-save save-visual-settings">Save</a>	
								
								<div id="eni_boxed_tab" class="clearfix">
									<?php
										$boxed_vals = array();
										if(isset($data['boxed'])) $boxed_vals = $data['boxed'];

										$boxed_bg_keys = array(

							    array( 'name' => 'boxed_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => '' , 'options' =>  array(''=>'None' , 'primary-color' => 'Set Primary Color', 'primary-alt-color' => 'Set Alternate Primary Color' , 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
							    
							    array( 'name' => 'boxed_background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' box-bg-listener bg-color '  ),
							    array( 'name' => 'boxed_background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' box-bg-listener bg-image bg-texture'  ),
							    array( 'name' => 'boxed_background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' box-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
							    array( 'name' => 'boxed_background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' box-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
							    array( 'name' => 'boxed_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' box-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
							    array( 'name' => 'boxed_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' box-bg-listener bg-texture ' , 'label' =>"Background Attachment" ),
							    array( 'name' => 'background_gradient_dir' ,'default'=>"" , 'class' => ' box-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
							    array( 'name' => 'boxed_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' box-bg-listener  bg-gradient'   ),
							    array( 'name' => 'boxed_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' box-bg-listener  bg-gradient'  ),
									);

										?>

										<dib class="box-bg-vals">
											<?php 

											foreach ($boxed_bg_keys as $key => $value) {
												$value['value'] = '';
												if(isset($boxed_vals[$value['name']])) $value['value'] = $boxed_vals[$value['name']];
												echo getIOAInput($value);
											}

											 ?>
										</dib>	
								</div>
								<div id="eni_title_tab" class="clearfix">
										<?php
										$title_vals = array();
										if(isset($data['title_area'])) $title_vals = $data['title_area'];

										$title_bg_keys = array(

							    array( 'name' => 'title_background_opts', 'type' => 'select' , 'label' => 'Select Background Type' , 'default' => 'default' , 'options' =>  array('default'=>'Current Scheme Style' , 'primary-color' => 'Set Primary Color', 'primary-alt-color' => 'Set Alternate Primary Color' , 'secondary-color' => 'Set Secondary Color' ,'bg-color'=>'Background Color','bg-image'=> 'Background Image','bg-texture'=>'Background Texture','bg-gr'=>'Background Gradient','custom'=>'Custom') ),
							    
							    array( 'name' => 'title_background_color', 'type' => 'colorpicker' , 'label' => 'Background Color' , 'default' => '' , 'class' => ' title-bg-listener bg-color '  ),
							    array( 'name' => 'title_background_image', 'type' => 'upload' , 'label' => 'Background Image' , 'default' => '' , 'class' => ' title-bg-listener bg-image bg-texture'  ),
							    array( 'name' => 'title_background_position' , 'type' => 'select' , 'label' => 'Background Position', 'default' => '', 'class' => ' title-bg-listener bg-texture'  , "options" => array('',"top left","top right","bottom left","bottom right","center top","center center","center bottom","center left","center right") ),
							    array( 'name' => 'title_background_cover' , 'type' => 'select' , 'label' => 'Background Cover', 'default' => '' , 'class' => ' title-bg-listener bg-image' , "options" => array("", "auto","contain","cover") ),
							    array( 'name' => 'title_background_repeat' ,'default'=>"", "options" => array("", "repeat","repeat-x","repeat-y","no-repeat") , 'class' => ' title-bg-listener bg-texture' , 'type' => 'select' , 'label' =>"Background Repeat" ),
							    array( 'name' => 'title_background_attachment' ,'default'=>"", "options" => array("", "fixed","scroll") , 'type' => 'select' , 'class' => ' title-bg-listener bg-texture ' , 'label' =>"Background Attachment" ),
							    array( 'name' => 'title_background_gradient_dir' ,'default'=>"" , 'class' => ' title-bg-listener bg-gradient' , "options" => array("horizontal" => __("Horizontal",'ioa'),"vertical"=> __("Vertical",'ioa'),"diagonaltl" => __("Diagonal Top Left",'ioa'),"diagonalbr" => __("Diagonal Bottom Right",'ioa') ) , 'type' => 'select' , 'label' =>"Background Gradient" ),
							    array( 'name' => 'title_start_gr', 'type' => 'colorpicker' , 'label' => 'Gradient Start Color ' , 'default' => '', 'class' => ' title-bg-listener  bg-gradient'   ),
							    array( 'name' => 'title_end_gr', 'type' => 'colorpicker' , 'label' => 'Gradient End Color' , 'default' => '' , 'class' => ' title-bg-listener  bg-gradient'  ),
							    array( 'name' => 'title_color', 'type' => 'colorpicker' , 'label' => 'Title Color' , 'default' => '' , 'class' => ''  ),
									);

										?>

										<dib class="title-bg-vals">
											<?php 

											foreach ($title_bg_keys as $key => $value) {
												$value['value'] = '';
												if(isset($title_vals[$value['name']])) $value['value'] = $title_vals[$value['name']];
												echo getIOAInput($value);
											}

											 ?>
										</dib>	
								</div>

							</div>

						</div>	
						<div id="eni_custom_css" class='concave-wrap'>
							
							<div class="toolbox clearfix">
								<h4><?php _e('Custom CSS Editor','ioa') ?></h4>
								<a href="" class="button-save save-concave-settings save-visual-settings"><?php _e('Save','ioa') ?></a>
							</div>
							<div class="component-opts">

								
								<?php 
										$concave_editor = '';

										if( get_option(SN.'_custom_css') )
											$concave_editor = get_option(SN.'_custom_css');


										echo getIOAInput(array( 
												"label" => "" , 
												"name" => "concave_editor",
												"length" => "small" , 
												"default" => '' , 
												"type" => "textarea",
												"description" => "" ,
												"value" => stripslashes($concave_editor),
												'class' => 'ceditor'
										) );
								 ?>	
							</div>

						</div>


						<div id="eni_font_face" >
							
							<div class="toolbox clearfix">
								<h4>Add Font Face Fonts</h4>
							</div>

							<div class="ioa-information">
								Generating Fonts from zip file.
							</div>
							
							<?php 

							echo getIOAInput(array( 
												"label" => "Upload Fontface Zip" , 
												"name" => "eni_font_face_in",
												"default" => '' , 
												"type" => "zipupload",
												"class" => "has-input-button"
										) );

							 ?>

							 <div class="fontface-list clearfix">
							 	<?php 

								$font_face_fonts = get_option(SN.'_fontface_fonts');
								if(!$font_face_fonts) $font_face_fonts = array();

								
								
								 foreach ($font_face_fonts as $key => $stack) {
								 	
								 	?>
								 	<div class="fontface-item ">
										<input type="hidden" class='fid' value="<?php echo $key; ?>" />
										<span><?php echo $stack['name'] ?></span>
										<a href="" class="ioa-front-icon cancel-3icon-"></a>
									</div>	
									<?php
								 }

							 	 ?>
							 </div>
							
							<div class="fontface-item hide">
								<input type="hidden" class='fid'>
								<span>Font</span>
								<a href="" class="ioa-front-icon cancel-3icon-"></a>
							</div>	

						</div>


						<div id="eni_font_deck">

							<div class="toolbox clearfix">
								<h4>Font Deck Settings</h4>
								<a href="" class="button-save save-visual-settings">Save</a>
							</div>

							<?php 



							$font_Deck_opts = array();

							$font_Deck_opts[]   = array( 
											  "label" => __("Project ID",'ioa'),
											  "name" => SN."_font_deck_project_id",
											  "type" => "text",
											   );

							$font_Deck_opts[]   = array( 
											  "label" => __("Font Name",'ioa'),
				  								"name" => SN."_font_deck_name",
											  "type" => "text",
											   );

							foreach ($font_Deck_opts as $key => $input) {
								$t = $input;
								$t['value'] = '';
								
								if(isset($data[$input['name']])) 
									$t['value'] = $data[$input['name']];
								
								echo getIOAInput($t);	

							}


							 ?>

						</div>	

						


						
					</div>	





							
                

            </div>
         </div>       	



		<?php
	

	    
	 }

	 function createCustomTypoSlab($item = array('name'=>'','selector'=>'') )
	 {
	 	?>
	 	<div class="custom-typo-item clearfix">
	 				<h4><?php echo $item['name'] ?></h4>
	 				<a href="" class="cancel-circled-2icon- ioa-front-icon"></a>
	 				<input type="hidden" class='label' value='<?php echo $item['name'] ?>' />
	 				<input type="hidden" class='selector' value='<?php echo $item['selector'] ?>' />
	 	</div>
	 	<?php
	 }

	 function createFontFamilySlab($options)
	 {
	 	global $ioa_super_options,$ioa_google_webfonts,$websafe_fonts,$or_google_webfonts;
	 	 

	 	$data = get_option(SN.'_enigma_data');
	 	$typography = array();

	 	if( isset($data['typography']) )
		$typography = $data['typography'];


	 	?>
		
		<div class="enig-font-slab">
			<div class="enig-font-head">
				<?php echo $options['title']; ?>			
			</div>
			<div class="enig-font-body">
				
				<div class="selection-panel clearfix">
					<?php 
					$val = 'default';
					if(isset($typography[SN.'_'.$options['id']."_font_type"]))
						$val = $typography[SN.'_'.$options['id']."_font_type"];
					echo getIOAInput(array(
							"label" => "Select Font Type",
							"name" => SN.'_'.$options['id']."_font_type",
							"type" => "select",
							"default" => 'default',
							"options" => array( "default" => "Theme's Default" , "google" => "Google Web Fonts", "fontface" => "Font Face" , "fontdeck" => "Font Deck" , "websafe" => "Websafe Fonts" ),
							"class" => "enig_font_selector",
							'value' => $val

						));

					?>

					<div class="google enig-typo-filter">
						<?php 
						$v = 'Open Sans';
						if(isset($typography[SN.'_'.$options['id']."_google_font"])) $v = $typography[SN.'_'.$options['id']."_google_font"];
						echo getIOAInput(array(
							"label" => "Select Google Web Font",
							"name" => SN.'_'.$options['id']."_google_font",
							"type" => "select",
							"default" => 'Open Sans',
							"options" => $or_google_webfonts,
							'value' => $v

						));
						?>
						<a href="" class="button-default google-advance-settings">Advanced Settings</a>
						<div class="adv-google-settings">
							<?php
							$c = '';
						if(isset($typography[SN.'_'.$options['id']."_google_cfont"])) $c = $typography[SN.'_'.$options['id']."_google_cfont"];

						echo getIOAInput(array(
							"label" => "Enter Google Web Font Name(If Font is not present in above list)",
							"name" => SN.'_'.$options['id']."_google_cfont",
							"type" => "text",
							"default" => '',
							'value' => $c

						));

						$fn_w = '';
						if(isset($typography[SN.'_'.$options['id']."fn_w"])) $fn_w = $typography[SN.'_'.$options['id']."fn_w"];

						echo getIOAInput(array( 
												"label" => __("Select Font Weight",'ioa') , 
												"name" => SN.'_'.$options['id']."fn_w",
												"default" => '' , 
												"type" => "select",
												"std" => "400",
												"options" => array("100","100 Italic", "200","200 Italic","300","300 Italic","400","400 Italic","500","500 Italic","600","600 Italic","700","700 Italic","800","800 Italic"),
												'value' => $fn_w
											));

						$fn_s = '';
						if(isset($typography[SN.'_'.$options['id']."fn_s"])) $fn_s = $typography[SN.'_'.$options['id']."fn_s"];

						echo getIOAInput(array( 
									"label" => __("Select Font Subsets",'ioa') , 
									"name" => SN.'_'.$options['id']."fn_s",
									"default" => '' , 
									"type" => "checkbox",
									"std" => "",
									"options" => array("Cyrillic","Cyrillic Extended","Greek","Greek Extended","Khmer","Latin","Latin Extended","Vietnamese"),
									'value' => $fn_s
								));
						

						 ?>	
						</div>

					</div>

					<div class="fontface enig-typo-filter">
						<?php 
						$ff = array();
						$font_face_fonts = get_option(SN.'_fontface_fonts');
						if(!$font_face_fonts) $font_face_fonts = array();

								 foreach ($font_face_fonts as $key => $stack) {
								 		$ff[$key] = $stack['name']; 
								 }

						

					/*
						$font_faces = array();
						$ffpath = PATH."/sprites/fontface";
						$ffs = scandir($ffpath);

						foreach ($ffs as $key => $value) {
							if(is_dir($ffpath.'/'.$value) && $value!='..' && $value!='.' && $value!='')
							{
								$font_faces[] = $value;
							}
						}
						$ffont = '';
					
						$ff = array_merge($font_faces,$ff);
					 */
						$ffs = '';
						if(isset($typography[SN.'_'.$options['id']."_fontface_font"])) $ffs = $typography[SN.'_'.$options['id']."_fontface_font"];

						
						echo getIOAInput(array( 
												"label" => __("Select Font",'ioa') , 
												"name" => SN.'_'.$options['id']."_fontface_font",
												"default" => '' , 
												"type" => "select",
												"options" => $ff,
												"value" => $ffs
											));

						 ?>

					</div>

					<div class="fontdeck enig-typo-filter">
						
						<div class="ioa-information ">
							 You can edit settings for Font Deck, from the right side tab with label <strong>"FONT DECK"</strong> . 
						</div>			
				
					</div>

					<div class="websafe enig-typo-filter">
						<?php
						$wf = '';
						if(isset($typography[SN.'_'.$options['id']."_websafe_font"])) $wf = $typography[SN.'_'.$options['id']."_websafe_font"];

						echo getIOAInput(array( 
												"label" => __("Select Websafe Font",'ioa') , 
												"name" => SN.'_'.$options['id']."_websafe_font",
												"default" => 'default' , 
												"type" => "select",
												"options" => $websafe_fonts,
												"value" => $wf
											));
											?>
					</div>


				</div>	

			</div>

		</div>	

	 	<?php

	 }

	 function createFontSizeSlab($options)
	 {
	 	global $ioa_super_options,$ioa_font_size_list;
	 	 

	 	$data = get_option(SN.'_enigma_data');
	 	$typography = array();

	 	if( isset($data['typography']) )
		$typography = $data['typography'];

	 	?>
		
		<div class="enig-font-slab">
			<div class="enig-font-head">
				<?php echo $options['title']; ?>			
			</div>
			<div class="enig-font-body">
				<?php
						echo getIOAInput(array( 
												"label" => __("Set Font Size ",'ioa') , 
												"name" => SN.'_'.$options['id']."_font_size",
												"default" => $ioa_font_size_list[$options['id']."_font_size"] , 
												"type" => "slider",
												"max" => 200,
												"suffix" => "px",
												"value" => $typography[SN.'_'.$options['id']."_font_size"]
											));

						echo getIOAInput(array( 
												"label" => __("Set Line Height ",'ioa') , 
												"name" => SN.'_'.$options['id']."_line_height",
												"default" => '1.8' , 
												"type" => "text",
												"value" => $typography[SN.'_'.$options['id']."_line_height"]
											));
				?>
			</div>
		</div>		
		<?php
	 }

	 function createSlab($value,$label,$name,$help='',$d)
	 {
	 	 
	 	?>
	 		<li class="clearfix">
				<div class="title-area">
					<span><?php echo $label; ?></span>
				</div>

				<?php 
					echo getIOAInput(array( 
						"label" => "" , 
						"name" => $name,
						"type" => "colorpicker",
						"value" => $value,
						"default" => $d
					));
				 ?>
				<?php if($help!="") : ?>	 <div class="help-icon">? <p><?php echo $help ?></p></div> <?php endif; ?>
			</li>
		<?php
	 }
	 

}

new EnigmaBackend();