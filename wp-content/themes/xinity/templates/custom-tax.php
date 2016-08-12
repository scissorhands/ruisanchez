<?php

global $ioa_helper, $ioa_meta_data,$ioa_super_options;
$ioa_meta_data['item_per_rows'] = 4;

$ioa_meta_data['column'] =  'one_fourth left';

$ioa_helper->getPortfolioParameters();
$portfolio_props = $ioa_meta_data['portfolio_props'];

$cl = "portfolio-columns  four-column";

$ioa_meta_data['layout'] = "full";
?> 

	
	<div class="skeleton clearfix auto_align">
		<div class="mutual-content-wrap   iso-parent portfolio-template <?php if($ioa_meta_data['layout']!="full") echo 'has-'.$ioa_meta_data['layout'];  ?> custom-tax-template" >
       		
			
			<div class=" <?php echo $cl ?> hoverable  clearfix">
				<ul class="clearfix portfolio_posts isotope" itemscope itemtype='http://schema.org/ItemList'  data-gutter="<?php if( $portfolio_props['portfolio_cols'] != "grid" ) echo 50; else echo 0; ?>">
					 <?php 
					 
					 		
					 		$ioa_meta_data['i']=0; 
					 		$ioa_meta_data['width'] = 264;
							$ioa_meta_data['height'] = 250;
					 		
					 		while (have_posts()) : the_post(); 	
					 			get_template_part('templates/portfolio-cols');
					 		endwhile; ?>
				</ul>	
			</div>
			
				<div class="pagination_wrap clearfix">
					<?php wp_paginate(); ?>
					<?php wp_paginate_dropdown(); ?>
				</div>
		</div>
		<?php get_sidebar(); ?>
	</div>

