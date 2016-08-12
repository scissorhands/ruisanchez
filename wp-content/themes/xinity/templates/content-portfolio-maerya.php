<?php
/**
 * The template used for generating Portfolio 4 Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;

$portfolio_props = $ioa_meta_data['portfolio_props'];

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
          
        <li  itemscope itemtype='http://schema.org/Article' data-id="<?php echo get_the_ID(); ?>" class=" clearfix  <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
          <div class="inner-item-wrap">
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
            	
              <div class="image-wrap">

                  
              	 

             	 <div class="image" >
                <?php
					  	      $id = get_post_thumbnail_id();
	          		    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					          
                    echo $ioa_helper->imageDisplay(array(   "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"   ));
                    
				       
                ?>
					<div class="stub clearfix">
						
						<h2 class=""> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
								<?php
								$terms = get_the_terms( $post->ID, $ioa_portfolio_taxonomy );

								if ( $terms && ! is_wp_error( $terms ) ) : 

								$links = array();
								foreach ( $terms as $term ) { $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; }
								$terms = join( ",", $links );
								?>

								<p class="tags">
								<?php echo $terms; ?>
								</p>

							<?php endif; ?>

					</div>		

				      <div class="hover" >
								<div class="hover-inner-wrap">
									<div class="proxy" >
									<h2 > <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
								<?php
								$terms = get_the_terms( $post->ID, $ioa_portfolio_taxonomy );

								if ( $terms && ! is_wp_error( $terms ) ) : 

								$links = array();
								foreach ( $terms as $term ) { $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; }
								$terms = join( ", ", $links );
								?>

								<p class="tags">
								<?php echo $terms; ?>
								</p>

								<?php endif; ?>
								</div>

								</div>
             		   </div>
                
               </div>
              </div>
               <div class="meta-info">
              	  	
                   <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                 	
                 <div class="clearfix excerpt" itemprop='description'>
                  <?php  if(  $portfolio_props['_portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $portfolio_props['_portfolio_excerpt_limit']  ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                  </div>
                  
                  <a href="<?php the_permalink(); ?>"itemprop='url' class="hover-link"><?php if($portfolio_props['_portfolio_more_label']!="") echo stripslashes($portfolio_props['_portfolio_more_label']); else _e("More",'ioa') ?></a>  
                  
              </div>
             <?php endif; ?>
             
          </div>  
        </li>
