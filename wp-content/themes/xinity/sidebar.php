<?php
 /**
 * The Template for displaying sidebars.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */
 global $ioa_meta_data;
?>

			
<?php  if(isset($ioa_meta_data['layout']) && $ioa_meta_data['layout']!='full' ) : ?>

 <div class="sidebar <?php echo $ioa_meta_data['layout']; ?> " id="sidebar"><!-- start of one-third column -->
	<?php 
	 	if ($ioa_meta_data['sidebar']!="none" && trim($ioa_meta_data['sidebar'])!=""  ) {
			dynamic_sidebar(trim($ioa_meta_data['sidebar'])); 
		}
		else  {
		 	dynamic_sidebar ("Blog Sidebar"); 
		}

	
	?>  
</div><!-- #sidebar -->


<?php  endif; ?>





