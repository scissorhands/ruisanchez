<?php global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$portfolio_props = $ioa_meta_data['portfolio_props'];

if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) :

               $id = get_post_thumbnail_id();
             $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

               ?>   
              
               <div  itemscope itemtype='http://schema.org/Article' class="gallery-item <?php echo $portfolio_props['portfolio_image_resize']; ?>" data-thumbnail="<?php $th = wp_get_attachment_image_src($id); echo $th[0]; ?>">

                <?php

                  switch ($portfolio_props['portfolio_image_resize']) {
                    
                    case 'default': echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case 'proportional': echo $ioa_helper->imageDisplay(array( "crop" => "hproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case 'none' : 
                    default: echo "<img src='". $ar[0]."' />"; break;
                  }
                   
             // 
          
        ?>

          <a href="<?php echo $ar[0] ?>" rel="prettyphoto" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
          <div class="gallery-desc s-c-l" >
              <h4 itemprop='name' class=""> <?php the_title(); ?></h4>
               <div class="clearfix"><div  class="caption">
          
          
                  <?php  if(  $portfolio_props['_portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $portfolio_props['_portfolio_excerpt_limit'] ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>
                  

              </div>   </div> 
                   <p class='clearfix'>  <a href="<?php the_permalink(); ?>" itemprop='url' class="hover-link "><?php _e('More','ioa') ?></a> </p> 
              </div>
                
              
              </div>
              
             <?php endif; ?>