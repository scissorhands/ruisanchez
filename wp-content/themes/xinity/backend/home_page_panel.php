<?php
/**
 *  Name - Header Construction panel 
 *  Dependency - Core Admin Class
 *  Version - 1.0
 *  Code Name - Anthena
 */


class IOAHeaderConstructor extends IOA_PANEL_CORE {
	
	private $default = 'eyJkYXRhIjp7IjAiOnsidmlzaWJpbGl0eSI6IlllcyIsImRhdGEiOlt7InBsYWNlaG9sZGVyIjoibGVmdCIsIndpZGdldHMiOlt7ImlkIjoidGV4dCIsImlucHV0cyI6W3sibmFtZSI6InRleHRfZGF0YSIsInZhbHVlIjoiPHA+W2ljb24gc2l6ZT1cIlwiIGNvbG9yPVwiIFwiIGJhY2tncm91bmQ9XCIgXCIgcmFkaXVzPVwiMHB4XCIgdHlwZT1cImlvYS1mcm9udC1pY29uIGxvY2F0aW9uaWNvbi1cIiBzcGFjaW5nPVwiMHB4XCIgXC9dIDEwMyBQcmluY2UgU3QsIE5ldyBZb3JrIFtpY29uIHNpemU9XCJcIiBjb2xvcj1cIiBcIiBiYWNrZ3JvdW5kPVwiIFwiIHJhZGl1cz1cIjBweFwiIHR5cGU9XCJpb2EtZnJvbnQtaWNvbiBtb2JpbGVpY29uLVwiIHNwYWNpbmc9XCIwcHhcIiBcL10gKzEgMjEyLTIyNi0zMTI2IFtpY29uIHNpemU9XCJcIiBjb2xvcj1cIiBcIiBiYWNrZ3JvdW5kPVwiIFwiIHJhZGl1cz1cIjBweFwiIHR5cGU9XCJpb2EtZnJvbnQtaWNvbiBtYWlsaWNvbi1cIiBzcGFjaW5nPVwiMHB4XCIgXC9dIGVtYWlsQGVtYWlsLmNvbTxcL3A+In0seyJuYW1lIjoibWFyZ2luX3RvcCIsInZhbHVlIjoiIn0seyJuYW1lIjoibWFyZ2luX2JvdHRvbSIsInZhbHVlIjoiIn0seyJuYW1lIjoibWFyZ2luX2xlZnQiLCJ2YWx1ZSI6IiJ9LHsibmFtZSI6Im1hcmdpbl9yaWdodCIsInZhbHVlIjoiIn1dfV19LHsicGxhY2Vob2xkZXIiOiJyaWdodCIsIndpZGdldHMiOlt7ImlkIjoid3BtbCIsImlucHV0cyI6W3sibmFtZSI6Im1hcmdpbl90b3AiLCJ2YWx1ZSI6IiJ9LHsibmFtZSI6Im1hcmdpbl9ib3R0b20iLCJ2YWx1ZSI6IiJ9LHsibmFtZSI6Im1hcmdpbl9sZWZ0IiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fcmlnaHQiLCJ2YWx1ZSI6IiJ9XX0seyJpZCI6InNvY2lhbF9pY29ucyIsImlucHV0cyI6W3sibmFtZSI6InJhZF90YWIiLCJ2YWx1ZSI6Iltpb2FfbW9kXVtpbnBdc29jaWFsX2xpbmtbaW9hc11baW9hc11baW5wXXNvY2lhbF9sYWJlbFtpb2FzXVtpb2FzXVtpbnBdc29jaWFsX2NvbG9yW2lvYXNdW2lvYXNdW2lucF1zb2NpYWxfaWNvbltpb2FzXWlvYS1mcm9udC1pY29uIGZhY2Vib29rLTFpY29uLVtpb2FzXVtpb2FfbW9kXVtpbnBdc29jaWFsX2xpbmtbaW9hc11baW9hc11baW5wXXNvY2lhbF9sYWJlbFtpb2FzXVtpb2FzXVtpbnBdc29jaWFsX2NvbG9yW2lvYXNdW2lvYXNdW2lucF1zb2NpYWxfaWNvbltpb2FzXWlvYS1mcm9udC1pY29uIHR3aXR0ZXItMWljb24tW2lvYXNdW2lvYV9tb2RdW2lucF1zb2NpYWxfbGlua1tpb2FzXVtpb2FzXVtpbnBdc29jaWFsX2xhYmVsW2lvYXNdW2lvYXNdW2lucF1zb2NpYWxfY29sb3JbaW9hc11baW9hc11baW5wXXNvY2lhbF9pY29uW2lvYXNdaW9hLWZyb250LWljb24gdmltZW8tMWljb24tW2lvYXNdIn1dfSx7ImlkIjoiYWpheF9zZWFyY2giLCJpbnB1dHMiOlt7Im5hbWUiOiJtYXJnaW5fdG9wIiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fYm90dG9tIiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fbGVmdCIsInZhbHVlIjoiIn0seyJuYW1lIjoibWFyZ2luX3JpZ2h0IiwidmFsdWUiOiIifV19LHsiaWQiOiJ3b29fY2FydCIsImlucHV0cyI6W3sibmFtZSI6Im1hcmdpbl90b3AiLCJ2YWx1ZSI6IiJ9LHsibmFtZSI6Im1hcmdpbl9ib3R0b20iLCJ2YWx1ZSI6IiJ9LHsibmFtZSI6Im1hcmdpbl9sZWZ0IiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fcmlnaHQiLCJ2YWx1ZSI6IiJ9XX1dfV0sImlkIjoidG9wX2JhciJ9LCIxIjp7InZpc2liaWxpdHkiOiJObyIsImRhdGEiOlt7InBsYWNlaG9sZGVyIjoibGVmdCIsIndpZGdldHMiOltdfSx7InBsYWNlaG9sZGVyIjoicmlnaHQiLCJ3aWRnZXRzIjpbXX1dLCJpZCI6Im1haW5fbWVudSJ9LCIyIjp7InZpc2liaWxpdHkiOiJZZXMiLCJkYXRhIjpbeyJwbGFjZWhvbGRlciI6ImxlZnQiLCJ3aWRnZXRzIjpbeyJpZCI6ImxvZ28iLCJpbnB1dHMiOlt7Im5hbWUiOiJtYXJnaW5fdG9wIiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fYm90dG9tIiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fbGVmdCIsInZhbHVlIjoiIn0seyJuYW1lIjoibWFyZ2luX3JpZ2h0IiwidmFsdWUiOiIifV19XX0seyJwbGFjZWhvbGRlciI6InJpZ2h0Iiwid2lkZ2V0cyI6W3siaWQiOiJtYWluX21lbnUiLCJpbnB1dHMiOlt7Im5hbWUiOiJtYXJnaW5fdG9wIiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fYm90dG9tIiwidmFsdWUiOiIifSx7Im5hbWUiOiJtYXJnaW5fbGVmdCIsInZhbHVlIjoiIn0seyJuYW1lIjoibWFyZ2luX3JpZ2h0IiwidmFsdWUiOiIifV19XX1dLCJpZCI6ImJvdHRvbV9iYXIifSwiaGVhZF9sYXlvdXQiOiJBdG9tc19EZWZhdWx0LnR4dCIsImhlYWRfc3R5bGUiOm51bGx9LCJ0aXRsZSI6IkhvbWUgRGVmYXVsdCJ9';
	
	// init menu
	function __construct () { parent::__construct( __('Head Builder','ioa'),'submenu','hcons');  }
	
	public function getDefault()
	{
		$template = json_decode(base64_decode($this->default),true);;
		$template = $template['data'];

		return $template;
	}

	// setup things before page loads , script loading etc ...
	function manager_admin_init(){	 

		if( isset($_GET['exhcon_id']) )
		{
			$id = $_GET['exhcon_id'];
			$templates  = get_option(SN.'_header_templates');
			$template = $templates[$id];

			$name = str_replace(' ','_',$template['title']);
			
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($name.'.txt'));
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			$output = base64_encode(json_encode($template));
			echo $output;

			die();	
			
		} 

		if( isset($_GET['hcon_delete_id']) )
		{
			$id = $_GET['hcon_delete_id'];
			$templates  = get_option(SN.'_header_templates');
			unset($templates[$id]);
			update_option(SN.'_header_templates',$templates);
		} 

		if( isset($_GET['hcon_reset']) )
		{	
			
			$template = json_decode(base64_decode($this->default),true);
			update_option(SN.'_head_builder',$template['data']);

		}

	 }	
	
	
	/**
	 * Main Body for the Panel
	 */

	function panelmarkup(){
		global $ioa_super_options;	
		 
		
		?>

		 <div class="ioa_panel_wrap fullscreen"> <!-- Panel Wrapper -->
		

        <div class=" clearfix">  <!-- Panel -->
        	<div id="option-panel-tabs" class="clearfix" data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
                <div id="header-constructor-wrap" class="clearfix">
					<?php $this->getHeadBuilder(); ?>	
				</div>
   			</div>
   		</div>
	    <?php
	 }

	 public function getHeadBuilder()
	 {
	 	global $ioa_super_options,$ioa_helper,$ioa_head_units;	
		 
		
		$holders = array( "top_bar"  => "Top Bar" , "main_menu"  => "Main Area" , "bottom_bar"  => "Bottom Bar" );
		$placeholders = array( 'left' => 'Left Area' , 'right' => 'Right Area' );

		$head_data = get_option(SN.'_head_builder');


		$head_layout = $head_style = "default";
		$h_opts = array();

		if(isset($head_data['head_layout']))
		$head_layout  = $head_data['head_layout'];

		$flag = false;

		if(isset($_GET['clayout'])) $flag = true;

		$layouts =   get_template_directory()."/sprites/htemplates";
		$hlayouts = scandir($layouts);

		foreach ($hlayouts as $key => $hcon) {
			
			if($hcon!='.' &&  $hcon!='..')	
			{ 
				$fh = fopen($layouts.'/'.$hcon, 'r');
				$theData = fread($fh, filesize($layouts.'/'.$hcon));
				fclose($fh);

				$code = json_decode(base64_decode($theData),true);
				$h_opts[$hcon] = $code['title'];

				if($flag && $_GET['clayout'] == $hcon )
				{
					$head_data = $code['data'];
				}

			}

		}


		if(!$head_data)
		{
			$head_data = json_decode(base64_decode($this->default),true);
			$head_data = $head_data['data'];
		}




		if( isset($_GET['hcon_id']) )
		{
			$id = $_GET['hcon_id'];
			$templates  = get_option(SN.'_header_templates');
			$template = $templates[$id];

			$head_data = $template['data'];
		} 

		if(!is_array($head_data)) $head_data = array();



		$corrected_data = array();


		foreach ($head_data as $key => $data) {
			if(isset($data['id']))
			$corrected_data[$data['id']] = $data;
		}
		
		$templates  = get_option(SN.'_header_templates');
										if(!$templates) $templates = array();

										$temps = array();

										if(is_array($templates))
										foreach ($templates as $key => $value) {
											$temps[$key] = $value['title'];
										}



	 	?>
		
		<div class="ioa_panel_wrap" > <!-- Panel Wrapper -->

			<div class=" clearfix">  <!-- Panel -->
        		<div  class="clearfix " data-shortname="<?php echo SN; ?>">  <!-- Options Panel -->
        

					
       			
                
                	<div id="panel-wrapper" class="clearfix normalize">
						
						
						<div id="hcon_layout">
								
								<div class="toolbox clearfix">
									<a href="" class="button-save header-save-settings">Save</a>
									
									<div class="ioa-admin-menu-wrap clearfix">
					        					<a href="" class="ioa-admin-menu ioa-front-icon cog-2icon-"></a>
					        					<ul class="ioa-admin-submenu">
					        						<li><a href="#hcon-template-panel" class="hcon-template"><?php _e('Save as Template','ioa') ?></a></li>
					        						<li><a href="#hcon-import-panel" class="hcon-import-template"><?php _e('Import','ioa') ?></a></li>
					        						<li><a href="#hcon-export-panel" class="hcon-export-template"><?php _e('Export','ioa') ?></a></li>
					        						<li><a href="<?php echo admin_url().'admin.php?page=ioa&amp;hcon_reset=true'; ?>" class="header-reset-settings"><?php _e('Reset','ioa') ?></a></li>
					        					</ul>
					        				</div>

								</div>


								<div id="hcon-template-panel" class='hcon-panel clearfix'>
									<input type="text" class='new-template' placeholder='Enter Template Name' />
									 <a href='' class='new-hcon-template button-default'><?php _e('Create','ioa') ?></a>
								</div>

								<div id="hcon-import-panel" class="clearfix hcon-panel">
									<?php 

										

										echo getIOAInput(array( 
											 "label" => "Import From Head Template File",
											 "name" => "import_head_temp_code",
											 "default" => "",
											 "type" => "textarea",
											 "after_input" => "<a href='".admin_url()."admin.php?page=hcons&amp;' class='import-hcon-code button-default'>Import</a>"	
										  ));

									 ?>

									  
								</div>
								<div id="hcon-export-panel" class="clearfix hcon-panel">
									<?php 

										echo getIOAInput(array( 
											 "label" => "Select Template To Export",
											 "name" => "head_templates",
											 "default" => "none",
											 "type" => "select",
											 "options" => $temps,
											 "after_input" => "<a href='".admin_url()."admin.php?page=hcons&amp;' class='export-hcon-template button-default'>Export</a>"	
										  ));

										

									 ?>



									  
								</div>

								<div class="subpanel clearfix">
									<?php 

									if(isset($head_data['head_style']))
									$head_style  = $head_data['head_style'];

									echo getIOAInput(array( "type" => "select" , "options" => $h_opts , "label" => "Inbuilt Templates" , "name" => "head_layout" , "default" => "default" , "length" => "small", "value" => $head_layout ));

									echo getIOAInput(array( 
											 "label" => "Saved Templates",
											 "name" => "i_head_templates",
											 "default" => "none",
											 "type" => "select",
											  "length" => "small",
											 "options" => $temps,
											 "addMarkup" => "<a href='".admin_url()."admin.php?page=hcons&amp;' class='import-hcon-template button-default'>".__('Import','ioa')."</a><a href='".admin_url()."admin.php?page=hcons&amp;' class='delete-hcon-template button-default'>".__('Delete','ioa')."</a>"	
										  ));
										
									 ?>
								</div>

								<div class="hcon-widgets clearfix">
									<?php 
									foreach ($ioa_head_units as $key => $unit) {
										echo "<div class='hcon-widget' data-id='".$unit->getID()."'>".$unit->getLabel()." ".$unit->getSaveData()."</div>";
									}

									 ?>
								</div>

								<div class="hcon-canvas">
									<?php 
									foreach ($holders as $key => $holder) {

										$data = array();

										if( isset($corrected_data[$key]) )
										$data =  $corrected_data[$key];
										
										$v = 'Yes';
										$pl = array();
										$corrected_pl = array();

										if(isset($data['data'])) :

											$pl = $data['data'];	
											
											foreach ($pl as  $p) {
												$corrected_pl[$p['placeholder']] = $p;
											}
											$v = $data['visibility'];

										endif;	

										?>
										
										<div class="hcon-holder clearfix" data-id="<?php echo $key ?>">
											<span class="hcon-section-name"><?php 
													echo str_replace(array('Bottom Bar','Main Menu'),array('Transparent Bar','Flat Bar'),ucwords(str_replace('_',' ',$key))); 

													?></span>
											<?php 
											echo getIOAInput(array(
														"label" => "Show Section",
														"name" => "holder_visibility",
														"default" => "Yes",
														"options" => array("Yes","No"),
														"type" => "select",
														"value" => $v
													));
											 ?>
											 <div class="inner-holder clearfix">
											 	 <?php 
											 	  foreach ($placeholders as $key => $pl) {

											 	    ?>
											 	     <div class="<?php echo $key ?>-area placeholder" data-position="<?php echo $key ?>">
												 	 	<span class="label"><?php echo $pl ?></span>
												 	 	<?php 
												 	 	 if( isset($corrected_pl[$key]['widgets']) ) :

												 	 		$widgets  = $corrected_pl[$key]['widgets'];
												 	 		foreach ($widgets as $key => $widget) {
												 	 			$inp = $widget['inputs'];
												 	 			$inp = $ioa_helper->getAssocMap($inp,'value');
												 	 			echo "<div class='hcon-widget in-placeholder' data-id='".$ioa_head_units[$widget['id']]->getID()."'>".$ioa_head_units[$widget['id']]->getLabel()." ".$ioa_head_units[$widget['id']]->getSaveData($inp)."</div>";	

												 	 		}

												 	 	  endif;		
												 	 	 ?>
												 	 </div>
												 	 <?php
											 	  }

											 	  ?>
											 </div>
										</div>	

										<?php
									}
									 ?>
								</div>

								

						</div>

					

					</div>
				

				</div>						
			</div>
		</div>	


									<?php 
									foreach ($ioa_head_units as $key => $unit) {
										echo "<div class='hcon-lightbox ".$unit->getID()."' data-id='".$unit->getID()."'>".$unit->getInputs()."</div>";
									}
									 ?>

		
		
	 	<?php
	 }
	 

}

$IOAHeader = new IOAHeaderConstructor();