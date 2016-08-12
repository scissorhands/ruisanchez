<?php global $ioa_super_options; ?>

<div class="ioa-menu portfolio-ioa-menu">
	<ul  itemscope itemtype="http://schema.org/ItemList" class='clearfix' >
		<li class='active has-filter' data-cat='all'><span><?php _e('All','ioa') ?></span></li>	
		<?php 
 		$categories=  get_terms('product_cat'); 
 		if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
		{
			$categories=  get_terms('product_cat' ,array( "include" => $ioa_meta_data['tax_filter']['terms'] )); 
		}
 		foreach ($categories as $category) {
  			$option = '<li data-cat="'.$category->slug.'" class="'.$category->slug.' has-filter"><span itemProp="name">';
			$option .= $category->name;
			$option .= '</span></li>';
			echo $option;
  		}
		?>
	</ul>
</div>
