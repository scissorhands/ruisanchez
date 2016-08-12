<?php 

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );



?>

<div class="ioa_input clearfix">
	<label for=""><?php _e('Export Current Settings','ioa'); ?></label>
	<div class="ioa_input_holder medium">
		<a href="<?php echo admin_url()."admin.php?page=ioa"; ?>" class="button-default export-options-panel-settings"><?php _e('Click To Export Current Settings','ioa') ?></a>
	</div>
</div>

<div class="ioa_input clearfix">
	<label for=""><?php _e('Import Settings(Open export file and paste text in the textbox)','ioa') ?></label>
	<div class="ioa_input_holder medium">
		<textarea name="" id="import_ioa_settings" cols="30" rows="10"></textarea>	
		<a href="<?php echo admin_url()."admin.php?page=ioa"; ?>" class="button-default import-options-panel-settings"><?php _e('Import Settings','ioa') ?></a>
	</div>
</div>