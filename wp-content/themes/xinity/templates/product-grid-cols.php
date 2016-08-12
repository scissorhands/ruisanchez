<?php 
/**
 * Grid Generation for RAD Builder
 */
global $ioa_helper,$ioa_meta_data,$product, $woocommerce_loop;

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
  return;
$second_thumb = get_post_meta(get_the_ID(),'sec_thumb',true);

$ioa_meta_data['hasFeaturedImage'] = false;
  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  ?>
          
           <?php 

          /**
           * Generate Terms for Portfolio
           */
           $terms = get_the_terms( get_the_ID(), 'product_cat' );
                   $cl = array();
                   $links = array();
                     
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, 'product_cat') .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                   endif; 

         ?>  
     
<li  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="iso-item hover-item clearfix <?php echo $ioa_meta_data['item_class'].' '; if($ioa_meta_data['post_type']=="post") echo join(' ',get_post_class());  elseif($cl!="") echo join(' ',$cl); ?>  <?php $ioa_meta_data['i']++;  ?> ">
   
    <div class="inner-item-wrap chain-link">
    
     <i class="ioa-front-icon ok-2icon- icon-cart-added"></i>
  <span class="cart-loader"></span>

      <div class="image-wrap">
        <div class="image" >
        <?php woocommerce_template_loop_add_to_cart(); ?>
          <?php 
          $thumbnail_type = 'image'; 
          ?>
          <div class="main-thumb">
          <?php 

          $id = get_post_thumbnail_id(get_the_ID());
            $ar = wp_get_attachment_image_src( $id, array(9999,9999) );

          echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  


         ?>
        </div>
        <?php if($second_thumb!="") : ?>
        <div class="sec-thumb">
          <?php 
            
             echo $ioa_helper->imageDisplay(array( "src" =>$second_thumb , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
             ?>
        </div>
        <?php endif; 
      ?>
      </div>
    </div>


    <div class="desc">
        <p class="tags clearfix">
           <?php echo $terms; ?>
        </p>
        <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
        

        <?php do_action('woocommerce_after_shop_loop_item_title'); ?>
       

    </div>
  <?php do_action('woocommerce_after_shop_loop_item'); ?>
</div>  
</li>
