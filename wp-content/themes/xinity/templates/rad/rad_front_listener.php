<?php 
/**
 * This template intializes RAD Frontend Engine.
 * All Components are available in Templates -> rad folder
 * @since Hades Framework V5
 */

$path = __FILE__;
$pathwp = explode( 'wp-content', $path );
$wp_url = $pathwp[0];
require_once( $wp_url.'/wp-load.php' );

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;


 $predict = 0; $pflag = false;
 ?>


			<?php 
			$widget = array();
			$widget['inputs'] = $_POST['inputs'];
			$widget['layout'] = "100%";
			$widget['type'] = trim($_POST['name']);
			$ioa_meta_data['rad_layout'] = $_POST['layout'];

			$ioa_meta_data['widget'] = $widget;
			$ioa_meta_data['predict'] = $predict;

			$ioa_meta_data['id'] = $_POST['name'].uniqid();

			$ioa_meta_data['state'] = $_POST['state'];
			
			get_template_part('templates/rad/'.trim(strtolower($widget['type'])));

			 ?>
		
