<?php 
/**
 * Post List Template for RAD BUILDER
 */


global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug,$ioa_layout;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';

if( isset($w['chainability']) && $w['chainability']!='none' )
{
  $an .= ' chain-animated';
  $rad_attrs[] = 'data-chain="'.$w['chainability'].'"';
}

if($w['visibility']!='none')
{
   $an = 'way-animated';
  $rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
  

}

if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';




// Default Values 
// 
$ioa_meta_data['height'] = 90;
$ioa_meta_data['width'] = 90;
$ioa_meta_data['hasFeaturedImage'] = false; 
$ioa_meta_data['item_per_rows'] = 1;
$ioa_meta_data['excerpt'] = "yes";
$ioa_meta_data['meta_value'] = "";
$post_structure_class = 'post-list';

$opts = array('posts_per_page' => 3,'post_type'=>'post' ,'suppress_filters' => 0);
  $filter = array();
  $custom_tax = array();

  if(isset($w['meta_value'])) $ioa_meta_data['meta_value'] = $w['meta_value']; 
  if(isset($w['excerpt'])) $ioa_meta_data['excerpt'] = $w['excerpt']; 
  if(isset($w['use_custom_excerpt'])) $ioa_meta_data['use_custom_excerpt'] = $w['use_custom_excerpt']; 
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

global $paged;
if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
if($w['w_pagination']=="yes") $opts['paged'] = $paged;
  
$ioa_meta_data['height'] = 50;
$ioa_meta_data['width'] = 50;
$ioa_meta_data['hasFeaturedImage'] = false; 
$ioa_meta_data['item_per_rows'] = 1;
$post_structure_class = 'thumb-list';

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_list-inner-wrap" >

  <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
    <div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    </div>
    <?php endif; ?>

        <ul  itemscope itemtype="http://schema.org/ItemList" class="rad-posts-list posts <?php echo $post_structure_class; ?> clearfix " >          
        <?php $query = query_posts($opts); $ioa_meta_data['i']=0; while (have_posts()) : the_post();   
        

        $cl = '';

  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  ?>
          
          
        <li itemscope itemtype="http://schema.org/Article" class="clearfix chain-link hover-item <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
            
              
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
              <div class="image">
                
                <?php
                $id = get_post_thumbnail_id();
                $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'")); 
                
                $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'compact' ) ); 
                
                ?>
              </div>
              
              <?php
              endif;
              ?>
              <div class="desc <?php if($ioa_meta_data['excerpt']=="no") echo 'adjust-title'; ?>">
                <h2 class="" itemprop="name"> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                <?php woocommerce_get_template( 'loop/price.php' ); ?>
                
                  
              </div>
                 
               
        </li>


        <?php  endwhile; ?>
    </ul>
   
    <?php  if($w['w_pagination']=="yes")  wp_paginate(); wp_reset_query(); ?>


    
  </div>
</div>
