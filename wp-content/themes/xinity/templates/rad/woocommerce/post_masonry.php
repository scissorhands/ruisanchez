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
 
$ioa_meta_data['width'] = 700; // $w['width'];
$ioa_meta_data['height'] =  $w['height'];

$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post' ,'suppress_filters' => 0);
$filter = array();
$custom_tax = array();

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


<ul class="post_masonry-container hoverable no-canvas <?php echo $w['masonry_layout'] ?> isotope"  data-layout="masonry" data-gutter="0">

        <?php 
        $query = new WP_Query($opts); $ioa_meta_data['i']=0; 
        while ($query->have_posts()) : $query->the_post();  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : 
        $second_thumb = get_post_meta(get_the_ID(),'sec_thumb',true);
        ?> 
        <li class="masonry-block iso-item hover-item init">  


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

         $id = get_post_thumbnail_id();
          $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
         
          switch($w['masonry_type'])
          {
            case 'wproportional' :     echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $ar[0] ));  break;
            case 'default' : default :
                                       echo $ioa_helper->imageDisplay(array( "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $ar[0] )); 

          }


         ?>
        </div>
        <?php if($second_thumb!="") : ?>
        <div class="sec-thumb">
          <?php 
            
         
          switch($w['masonry_type'])
          {
            case 'wproportional' :     echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $second_thumb ));  break;
            case 'default' : default :
                                       echo $ioa_helper->imageDisplay(array( "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $second_thumb )); 

          }
             ?>
        </div>
        <?php endif; 
      ?>
      </div>
    </div>
  <?php do_action('woocommerce_after_shop_loop_item'); ?>
</div>  

        </li>  
        <?php
        endif; endwhile; ?>
 
      </ul>

    
  </div>

</div>
