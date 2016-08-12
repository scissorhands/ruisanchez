<?php 
/**
 * Featured Media for Posts
 */
global $ioa_helper, $ioa_super_options , $ioa_meta_data ,$post,$ioa_layout, $woocommerce, $product;

$post_ID = get_the_ID();

$sm = ''; $fw ='';

$attachment_ids = $product->get_gallery_attachment_ids();

$featured = false;
$thumb = false;

if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail($post_ID))) :

  $id = get_post_thumbnail_id($post_ID);
  $featured = wp_get_attachment_image_src( $id, array(9999,9999) );
  $thumb = wp_get_attachment_image_src( $id, 'thumbnail' );

endif;


?>

<div class="featured-wrap product-gallery">
  <div class="ioa-gallery seleneGallery " itemscope itemtype="http://schema.org/ImageGallery"  data-thumbnails="<?php if(!isset($ioa_meta_data['full_screen'])) echo 'true'; else echo 'false'; ?>" data-autoplay="false" data-effect_type="fade" data-caption="false" <?php if(isset($ioa_meta_data['full_screen'])) echo "data-fullscreen='true'" ?> data-arrow_control="true" data-duration="5" data-height="<?php  echo $ioa_meta_data['height']; ?>"  data-width="<?php echo $ioa_meta_data['width']; ?>" > 
           <div class="gallery-holder" style="height:<?php echo $ioa_meta_data['height']; ?>px;">
            
            <?php if( $featured) : ?>
             <div class="gallery-item" data-thumbnail="<?php echo $thumb[0]; ?>">
              <?php 
              echo $ioa_helper->imageDisplay(array( "src" => $featured[0] , 'imageAttr' =>  '', "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] )); 
              ?> 
                <a href="<?php echo $featured[0] ?>" data-rel="prettyphoto[gallery-<?php echo get_the_ID(); ?>]" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
            </div> 
            <?php endif; ?>
          
          <?php  if ( $attachment_ids ) { foreach ( $attachment_ids as $attachment_id ) :  

              $thumb = wp_get_attachment_image_src($attachment_id,'thumbnail');
              $image = wp_get_attachment_image_src($attachment_id,array(9999,9999));

            ?>
             <div class="gallery-item" data-thumbnail="<?php echo $thumb[0]; ?>">
              <?php 
              echo $ioa_helper->imageDisplay(array( "src" => $image[0] , 'imageAttr' =>  '', "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] )); 
              ?> 
                <a href="<?php echo $image[0] ?>" data-rel="prettyphoto[gallery-<?php echo get_the_ID(); ?>]" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>
            </div> 
          <?php 
          endforeach; } ?>
        </div>
      </div>
</div>
<?php  ?>