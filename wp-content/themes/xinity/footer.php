<?php 
/**
 * The Footer Template. 
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */

global $ioa_super_options,$ioa_helper,$ioa_meta_data,$post ;     

if(!isset($ioa_meta_data['page_footer_area_toggle'])) $ioa_meta_data['page_footer_area_toggle'] = 'no';   
if(!isset($ioa_meta_data['page_footer_b_area_toggle'])) $ioa_meta_data['page_footer_b_area_toggle'] = 'no';   
?>

</div> <!-- END of Page Wrapper -->

<!-- Start of Footer -->
<?php if($ioa_meta_data['ioa_custom_template']!='ioa-template-blank-page') :  ?>
<div id="footer" itemscope itemtype="http://schema.org/WPFooter">
	<!-- Footer Widgets area -->
	<?php if($ioa_meta_data['page_footer_area_toggle']!="yes") get_template_part('templates/content-footer-widgets'); ?>
	
	<!-- Footer Menu area -->
	<?php if($ioa_meta_data['page_footer_b_area_toggle']!="yes") get_template_part('templates/content-footer-menu'); ?>

</div>


  </div>
</div>
<?php endif; ?>

<?php 
wp_reset_postdata();

	if($post->post_type=='product') 
	{
		
		get_template_part('woocommerce/review_form');
	}
 ?>


<script type="text/javascript">
   <?php echo stripslashes(strip_tags($ioa_super_options[SN.'_tracking_code'])); ?>
</script>

<?php get_template_part('templates/sticky-contact'); ?>
<a href="" class="back-to-top ioa-front-icon up-dir-1icon-"></a>

<?php   wp_footer();   ?>
</body>
</html>
