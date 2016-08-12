<?php global $ioa_super_options; ?>

<?php if($ioa_super_options[SN.'_sc_enable'] != "false") : ?>
<div class="sticky-contact">
	<a href="" class="mail-2icon- ioa-front-icon trigger"></a>
	<div class="inner-sticky-contact">
		<p class="message"><?php echo stripslashes($ioa_super_options[SN.'_sc_message']) ?></p>
		<?php echo do_shortcode('[contact-form-7 id="'.$ioa_super_options[SN.'_c_form'].'" ]');  ?>	
		
	</div>
</div>
<?php endif; ?>