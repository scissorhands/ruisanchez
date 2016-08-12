<?php 
/**
 * Post Slider Template for RAD BUILDER
 */


global $ioa_helper,$ioa_meta_data,$product, $woocommerce_loop;



$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';


// Default Values 
 
$ioa_meta_data['width'] = 235;
$ioa_meta_data['height'] =  $w['height'];

$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post' ,'suppress_filters' => 0);
$filter = array();
$custom_tax = array();

$ioa_meta_data['product_props']['product_image_resize'] = 'default';

if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 
if(isset($w['post_type']) && trim($w['post_type'])!="") $opts['post_type'] = $w['post_type']; 



  if(isset($w['posts_query']) && $w['posts_query'] !="" )
  {
     $qr = explode('&',$w['posts_query']);


     foreach($qr as $q)
     {
      if(trim($q)!="")
      {
        $temp = explode("=",$q);
        $filter[$temp[0]] = $temp[1];
        if($temp[0]=="tax_query")
        {
          $vals = explode("|",$temp[1]);  
          $custom_tax[] = array(
              'taxonomy' => $vals[0],
          'field' => 'id',
          'terms' => explode(",", $vals[1])

            );
        }
      }
     }


  }

  $opts = array_merge($opts,$filter);
  $opts['tax_query'] = $custom_tax;
 

?>
<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_masonry-inner-wrap" >

<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
    <div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    </div>
    <?php endif; ?>


<?php  $query = new WP_Query($opts); woocommerce_product_loop_start(); ?>

        <?php woocommerce_product_subcategories(); ?>

        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

          <?php woocommerce_get_template_part( 'templates/content-default-shop' ); ?>

        <?php endwhile; // end of the loop. ?>

<?php woocommerce_product_loop_end(); ?>

    
  </div>

</div>
