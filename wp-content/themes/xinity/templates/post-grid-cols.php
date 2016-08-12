<?php 
/**
 * Grid Generation for RAD Builder
 */
global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
$ioa_meta_data['hasFeaturedImage'] = false;
  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  ?>
          
           <?php 

          /**
           * Generate Terms for Portfolio
           */
         if($ioa_meta_data['post_type']==$ioa_portfolio_slug)  :
           $terms = get_the_terms( get_the_ID(), $ioa_portfolio_taxonomy );
                   $cl = array();
                   $links = array();
                     
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                   endif; 

           elseif($ioa_meta_data['post_type']!="post") :
             $tax = $ioa_registered_posts[$ioa_meta_data['post_type']]->getTax();
              $terms = get_the_terms( get_the_ID(), strtolower(str_replace(' ','',$tax[0])) );
                   $cl = array();
                   $links = array();
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, strtolower(str_replace(' ','',$tax[0])) ) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                   endif; 

           endif;

         ?>  

        <li itemscope itemtype="http://schema.org/Article" class="iso-item hover-item clearfix <?php echo $ioa_meta_data['item_class'].' '; if($ioa_meta_data['post_type']=="post") echo join(' ',get_post_class());  elseif($cl!="") echo join(' ',$cl); ?>  <?php $ioa_meta_data['i']++;  ?> ">
            
               <div class="inner-item-wrap chain-link">
                  

              <?php  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  : ?>   
              
              <div class="image" >
               
                <?php
                $id = get_post_thumbnail_id();
                $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  

               $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'icons' ) );
                ?>

              </div>
              
              <?php
              endif;
              ?>
              
              <div class="desc">
                    <h2 itemprop="name" class="custom-font"> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a> </h2> 
                    <?php if(isset($ioa_meta_data['meta_value']) && $ioa_meta_data['meta_value']!="")  : ?>
                    <div class="extras clearfix"> 
                        <?php  echo do_shortcode(stripslashes($ioa_meta_data['meta_value'])); ?> 
                    </div> 
                    <?php endif; ?>
              </div>
               </div>
                 
               
        </li>
