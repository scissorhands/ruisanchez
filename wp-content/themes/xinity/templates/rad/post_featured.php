<?php 
/**
 * Post Slider Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';


// Default Values 
 
$ioa_meta_data['height'] = $w['height'];
$ioa_meta_data['width'] =  $w['width_el'];

$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post');
$filter = array();
$custom_tax = array();

$margin = '';
if( $w['margin_el'] !="" ) $margin = "margin-right:".$w['margin_el']."px";

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
  <div class="post_featured-inner-wrap" >

<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
    <div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    </div>
    <?php endif; ?>


<div class="swiper-container hoverable" data-items=<?php if(isset($w['no_of_items'])) echo $w['no_of_items'] ?> style="height:<?php echo $ioa_meta_data['height'] ?>px">
  <div class="swiper-wrapper ">

        <?php 
        $query = new WP_Query($opts); $ioa_meta_data['i']=0; 
        while ($query->have_posts()) : $query->the_post();  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : 
        ?> 
        <div class="swiper-slide hover-item" style="height:<?php echo $ioa_meta_data['height'] ?>px;width:<?php echo $ioa_meta_data['width'] ?>px;<?php echo $margin; ?>">  

          <div class="image">
           
            <?php
          $id = get_post_thumbnail_id();
          $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
            echo $ioa_helper->imageDisplay(array( "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] , "parent_wrap" => false , "src" => $ar[0] )); 
         
         $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'icons' ) );
          ?> 
          </div>
        

          

        </div>  
        <?php
        endif; endwhile; ?>
      
 
      </div>
      </div>
    
   


    
  </div>

</div>
