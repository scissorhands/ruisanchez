<?php
/**
 * The template used for generating Product Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$product, $woocommerce_loop;
 $ioa_meta_data['hasFeaturedImage'] = false; 

$product_props = $ioa_meta_data['product_props'];

if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  
  $ioa_meta_data['hasFeaturedImage'] = true; 	

$terms = get_the_terms( get_the_ID(), 'product_cat' );
 $cl = array();
 $links = array();
   
 if ( $terms && ! is_wp_error( $terms ) ) : 
    foreach ( $terms as $term ) { 
       $links[] = '<a href="' .get_term_link($term->slug, 'product_cat') .'">'.$term->name.'</a>'; 
       $cl[] = "category-".$term->slug;
    }
    $terms = join( "<span>-</span>", $links );
endif; 

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
  return;
$second_thumb = get_post_meta(get_the_ID(),'sec_thumb',true);


?>
                 
          
<li  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="iso-item hover-item clearfix <?php echo join(' ',$cl); ?>  <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; ?>">
   
    <div class="inner-item-wrap">
    
     <i class="ioa-front-icon ok-2icon- icon-cart-added"></i>
  <span class="cart-loader"></span>

      <div class="image-wrap">
        <div class="image" >
        <?php woocommerce_template_loop_add_to_cart(); ?>
          <?php 
          $thumbnail_type = 'image'; 
          switch($thumbnail_type)
          {
          case "slider" :
            
              $gallery_images =  "";
              if(isset( $ioa_options['ioa_thumbnail_data'] )) $gallery_images =  $ioa_options['ioa_thumbnail_data'];
                  ?>
                  <div itemscope itemtype="http://schema.org/ImageGallery" class="ioaslider quartz"  data-bullets="false" data-autoplay="false" data-effect_type="fade" data-full_width="false" data-caption="false" data-arrow_control="true" data-duration="5" data-height="<?php  echo $ioa_meta_data['height']; ?>"  data-width="<?php echo $ioa_meta_data['width']; ?>" > 
                      <div class="items-holder" style="height:<?php echo $ioa_meta_data['height']; ?>px;">
                      <?php if(isset($gallery_images) && trim($gallery_images) != "" ) : $ar = explode(";",stripslashes($gallery_images));

                      foreach( $ar as $image) :
                          if($image!="") :
                          $g_opts = explode("[ioabre]",$image);
                          ?>
                              <div class="slider-item" data-thumbnail="<?php if(isset($g_opts[1])) echo $g_opts[1]; ?>">
                                  <?php 
                                  if($cl=="true")
                                     echo "<img src='".$g_opts[0]."' />";  
                                  else
                                     echo $ioa_helper->imageDisplay(array( "src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] )); 
                                  ?> 
                                  <div class="slider-desc">
                                     <h2 itemprop='name'><?php echo $g_opts[3] ?></h2>
                                     <div itemprop='description' class="caption"><?php echo $g_opts[4] ?></div>
                                  </div>  
                              </div> 
                          <?php 
                          endif;
                        endforeach;  ?>
                     </div>
                 </div>
                 <?php endif;  ?>
          <?php break;
          
          case "video" : 
          case "image" : 
          default :


          ?>
          <div class="main-thumb">
          <?php 

          $id = get_post_thumbnail_id(get_the_ID());
            $ar = wp_get_attachment_image_src( $id, array(9999,9999) );


          switch($product_props['product_image_resize'])
                  {
                    case "none" : echo "<img src='".$ar[0]."' alt='".get_the_title()."' />";  break;
                    case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case "default" :
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  }   

         ?>
        </div>
        <?php if($second_thumb!="") : ?>
        <div class="sec-thumb">
          <?php 
            
             switch($product_props['product_image_resize'])
                  {
                    case "none" : echo "<img src='".$second_thumb."' alt='".get_the_title()."' />";  break;
                    case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $second_thumb , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case "default" :
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $second_thumb , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  }

             ?>
        </div>
        <?php endif; 
      }
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
