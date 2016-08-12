<?php

/**
 * Password Protected
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums" class='skeleton auto_align'>
	<fieldset class="bbp-form" id="bbp-protected">
		<Legend><?php _e( 'Protected', 'ioa' ); ?></legend>

		<?php echo get_the_password_form(); ?>

	</fieldset>
</div>