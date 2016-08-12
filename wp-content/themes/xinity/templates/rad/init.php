<?php
/**
 * This template intializes RAD Frontend Engine.
 * All Components are available in Templates -> rad folder
 * @since IOA Framework V1
 */

global $radunits,$ioa_helper,$post;

require_once(HPATH.'/classes/ui.php');
 


$id = '';




?>



<div id="rad_sidebar" class="clearfix">
	<div id="top-rad-bar" class='clearfix'>
		<a href="" class="toggle-rad-sidebar"> <span class="b-line"></span></a>
		
		<div class="skeleton rad-tabs-holder">
			
			<ul id="rad-tabs">
				<li class='ui-state-active'><a href="#builder" class='clearfix'><img src='<?php echo URL ?>/sprites/i/rad_sprites/builder-icon.png' /><span>Builder</span><span class="b-line"></span></a></li>
				<!--<li><a href="#templates" class='clearfix'><img src='<?php echo URL ?>/sprites/i/rad_sprites/templates-icon.png' /><span>Templates</span><span class="b-line"></span></a></li>
				<li><a href="#title" class='clearfix'><img src='<?php echo URL ?>/sprites/i/rad_sprites/title-icon.png' /><span>Title Settings</span><span class="b-line"></span></a></li>
				<li><a href="#settings" class='clearfix'><img src='<?php echo URL ?>/sprites/i/rad_sprites/page-icon.png' /><span>Page Settings</span><span class="b-line"></span></a></li>
				<li><a href="#featured" class='clearfix'><img src='<?php echo URL ?>/sprites/i/rad_sprites/featured-icon.png' /><span>Featured Media</span><span class="b-line"></span></a></li>-->
			</ul>

			<div class="save-menu">

				<div class="save-template-lightbox">
					<h4>Enter Template Title</h4>
					<a href="" class="close-icon">x</a>
					<div class="template-panel clearfix">
						<input type="text" id="rad-template-title">
						<a href="" class="save-rad-template">Save Template</a>
					</div>
				</div>


				<a href="" id="save-rad">Save</a>
				
				<div class="save-toggle-wrap clearfix">
					<a href="" class="save-toggle"></a>

					<ul class="save-menu">
						<li><a href="" class='save-template'>Save As Template</a></li>
						<!--<li><a href="" class='save-revision'>Save As Revision</a></li>-->
					</ul>
				</div>
			</div>
			<a href="<?php echo $rad_url ?>rad_preview=true" target="_BLANK" id="live-preview" class='clearfix'><img src='<?php echo URL ?>/sprites/i/rad_sprites/preivew-icon.png' /><span>Preview</span></a>
		</div>


	</div>
	<div class="rad-content-area">
		
		<div class="skeleton clearfix">
			<ul id="c-rad-tabs">
				<li><a href="#builder" class='clearfix'></a></li>
				<li><a href="#templates" class='clearfix'></a></li>
				<li><a href="#title" class='clearfix'></a></li>
				<li><a href="#settings" class='clearfix'></a></li>
				<li><a href="#featured" class='clearfix'></a></li>
			</ul>
		</div>
		<div id="builder">
			
				<div class="builder-toolbar clearfix">
				<div class="skeleton">
					 <!--<a href="" class="insta-library">Insta library</a>-->
					 <div class="import-templates-wrap">
					 	<a href="" class="toolbar-button saved-templates">Use saved templates</a>
					 	<div class="import-template-lightbox">
							<h4>Select Template To Import</h4>
							<a href="" class="close-icon">x</a>
							<div class="template-panel clearfix">
								<?php 

								$data = array();
								if(get_option('RAD_TEMPLATES')) $data = get_option('RAD_TEMPLATES');

								$templates = array(''=>'Select Template');
								foreach ($data as $key => $template) {

									if( isset($template['title']) ) 
									$templates[$key] = $template['title']; 
								}
							

					 			echo getIOAInput(array(
					 				"label" => "" , 
									"name" => "import_rad_templates" , 
									"default" => "100%" , 
									"type" => "select",
									"description" => "" ,
									"options" => $templates
									) );
					 			?>
								<a href="" class="import-rad-template">Import</a>
								<a href="" class="delete-rad-template">Delete</a>
							</div>
						</div>
					 </div>

					 <!--<a href="" class="toolbar-button revisions">Revisions</a>-->

					<!-- <div class="widgets-search-bar clearfix">
					 	<div class="inner-widgets-search-bar clearfix">
					 		<a href="" class="search-button"><img src='<?php echo URL ?>/sprites/i/rad_sprites/search-icon.png' /></a>
					 		<input type="text">
					 	</div>
					 </div>-->
				</div>	
			</div>

			<div class="skeleton">
				<div class="rad-widgets clearfix">
					<ul class="rad-w-cats">
						<li><a href="#rad-structure">Structure <img class='tip' src='<?php echo URL ?>/sprites/i/rad_sprites/active-tip.png' /></a></li>
						<li><a href="#rad-widgets">Widgets <img class='tip' src='<?php echo URL ?>/sprites/i/rad_sprites/active-tip.png' /></a></li>
						<li><a href="#rad-core">WP Core <img class='tip' src='<?php echo URL ?>/sprites/i/rad_sprites/active-tip.png' /></a></li>
					<!--	<li><a href="#rad-plugin">Plugin Widgets <img class='tip' src='<?php echo URL ?>/sprites/i/rad_sprites/active-tip.png' /></a></li>
						<li><a href="#rad-insta">Insta Templates <img class='tip' src='<?php echo URL ?>/sprites/i/rad_sprites/active-tip.png' /></a></li> -->
					</ul>
					<div id="rad-structure" class='rad-w-tab-content clearfix'>
						<!--
						<div class="filter-wrap clearfix">
							<span>Filter</span>
							<ul class="filter-menu">
								<li class='active'><a href="">All</a></li>
								<li><a href="">Columns</a></li>
								<li><a href="">Rows</a></li>
							</ul>
						</div>
						-->
						<div class="widgets-area">
							<?php  
							 foreach ($radunits as $key => $widget) {
							 		
							 	if($widget->getGroup()=="structure" || $widget->getGroup()=="section")
							 	echo $widget->getThumb();	
							 	 
							 }
							?>
						</div>

					</div>		
					<div id="rad-widgets"  class='rad-w-tab-content'>
							<?php  
							 foreach ($radunits as $key => $widget) {
							 		
							 	if($widget->getGroup()=="widgets" )
							 	echo $widget->getThumb();	
							 	 
							 }
							?>	

					</div>		
					<div id="rad-core"  class='rad-w-tab-content'>
							<?php  
							 foreach ($radunits as $key => $widget) {
							 		
							 	if($widget->getGroup()=="core" )
							 	echo $widget->getThumb();	
							 	 
							 }
							?>	
					</div>		
					<!-- <div id="rad-plugin"  class='rad-w-tab-content'>d</div>		
					<div id="rad-insta"  class='rad-w-tab-content'>e</div>	-->	
				</div>	
			</div>

		</div>	
		<!--<div id="templates">templates code here...</div>	
		<div id="title">title code here...</div>	
		<div id="settings">settings code here...</div>	
		<div id="featured">features code here...</div>-->

	</div>

</div>

<div class="clonable">
	<?php 
		RADMarkup::generateRADSection();
		RADMarkup::generateRADContainer(); 
		foreach ($radunits as $key => $widget) {
			if($widget->getGroup()!="structure" && $widget->getGroup()!="section" )
			RADMarkup::generateRADWidget($widget->getData(),$widget->getDefaults());
		}
	?>
</div>

<div class="settings-overlay">
	
</div>
<div class="settings-lightbox">
	<div class="settings-body">
		<div class="inner-settings-body clearfix">
		<?php
		$settings = array();  
		 foreach ($radunits as $key => $widget) {
		 	if( $widget->getCommonKey() !="" )
		 		$settings[$widget->getCommonKey()] = $widget->mapSettingsOverlay();	
		 	else 
		 		$settings[$key] = $widget->mapSettingsOverlay();	
		 }
		 
		array_unique($settings); 

		 foreach ($settings as $key => $setting) echo $setting;

		?>

	</div>
	</div>
	<div class="bottom-bar clearfix">
		<a href="" class="cancel-settings">Cancel</a>
		<a href="" class="save-settings">Save</a>
	</div>
</div>
