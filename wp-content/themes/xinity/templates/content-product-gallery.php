<?php global $ioa_helper,$ioa_meta_data;

$product_props = $ioa_meta_data['product_props'];

if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) :

               $id = get_post_thumbnail_id();
             $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

               ?>   
              
               <div  itemscope itemtype='http://schema.org/Article' class="gallery-item <?php echo $product_props['product_image_resize']; ?>" data-thumbnail="<?php $th = wp_get_attachment_image_src($id); echo $th[0]; ?>">

                <?php

                  switch ($product_props['product_image_resize']) {
                    
                    case 'default': echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case 'proportional': echo $ioa_helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case 'none' : 
                    default: echo "<img src='". $ar[0]."' />"; break;
                  }
            
          
        ?>

          <a href="<?php echo $ar[0] ?>" rel="prettyphoto" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
          <div class="gallery-desc s-c-l" >
              <h4 itemprop='name' class=""> <?php the_title(); ?></h4>
               <div class="clearfix"><div  class="caption">
                  <?php  the_excerpt(); ?>
              </div>   </div> 
                   <p class='clearfix'>  
                      <a href="<?php the_permalink(); ?>" itemprop='url' class="hover-link "><?php _e('More','ioa') ?></a>
                      <?php woocommerce_template_loop_add_to_cart(); ?>
                   </p> 
              </div>
                
              
              </div>
              
             <?php endif; ?>