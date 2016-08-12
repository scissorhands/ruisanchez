<?php
/**
 * The template used for generating Portfolio 4 Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
       
          
        <li  itemscope itemtype='http://schema.org/Article' class=" clearfix <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
          <div class="inner-item-wrap">
            
              <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
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


              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
            	
              <div class="image-wrap">
             	 <div class="image" >
                <?php
					  	      $id = get_post_thumbnail_id();
	          		    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
					          
                    switch($ioa_meta_data['thumb_resize'])
                    {

                    case 'proportional' :   echo $ioa_helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;

                    } 
				       
                ?>

				      <?php if($ioa_meta_data['portfolio_enable_thumbnail']!="true"): ?>
                    <a class="hover" href="<?php the_permalink(); ?>" >  <i class="hover-link icon icon-link"></i></a>  
                 <?php else: ?>  
                     <a class="hover"  href="<?php echo $ar[0]; ?>"  rel='prettyPhoto[pp_gal]'> <i title="<?php the_title() ?>"  class="hover-lightbox lightbox icon-resize-full icon"></i></a>
                 <?php endif; ?> 
                
               </div>
              </div>
              
             <?php endif; ?>
          </div>  
        </li>
