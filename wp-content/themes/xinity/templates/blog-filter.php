<?php global $ioa_super_options,$ioa_meta_data;

							$ids = array();
if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
						{
							
							$slugs = explode(",",$ioa_meta_data['tax_filter']);

							foreach ($slugs as $key => $slug) {
								if($slug!="")
								{
									$idObj = get_category_by_slug($slug); 
 									$ids[] = $idObj->term_id;	
								}
							}

						}

 ?>

<div class="ioa-menu blog-ioa-menu"  itemscope itemtype='http://schema.org/ItemList'>
					<ul class='clearfix'>
						<li data-cat="all" class='active all has-filter'><span><?php _e('All','ioa') ?></span></li>	
						<?php 
				 		$categories=  get_categories(); 
				 		if( isset($ioa_meta_data['tax_filter']) && $ioa_meta_data['tax_filter'] )
				 		{
				 			$categories=  get_categories(array( "include" => $ids )); 
				 		}
				 		foreach ($categories as $category) {
				  			$option = ' <li data-cat="'.$category->category_nicename.'" class="'.$category->category_nicename.'  has-filter"><span itemprop="name">';
							$option .= $category->cat_name;
							$option .= '</span>';
							$option .= '</li>';
							echo $option;
				  		}
						?>
					</ul>
				</div>