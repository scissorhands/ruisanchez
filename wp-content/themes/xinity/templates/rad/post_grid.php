<?php 
/**
 * gallery Template for RAD BUILDER
 */



global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug,$ioa_layout;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
if($w['visibility']!='none')
{
   $an = 'way-animated';
  $rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
  $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';



// Default Values 
// 
$ioa_meta_data['height'] = 400;
$ioa_meta_data['width'] = 450;
$ioa_meta_data['hasFeaturedImage'] = false; 
$ioa_meta_data['item_per_rows'] = 4;
$ioa_meta_data['excerpt'] = "yes";
$ioa_meta_data['meta_value'] = "";
$post_structure_class = 'post-list';



$opts = array('posts_per_page' => 3,'post_type'=>'post');
  $filter = array();
$custom_tax = array();

  if(isset($w['meta_value'])) $ioa_meta_data['meta_value'] = $w['meta_value']; 
  if(isset($w['excerpt'])) $ioa_meta_data['excerpt'] = $w['excerpt']; 
  if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 
  if(isset($w['post_type'])) $opts['post_type'] = $w['post_type']; 

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
     if(isset($filter['category_name']))
     $ioa_meta_data['tax_filter'] = $filter['category_name'];
  }

$ioa_meta_data['post_type'] = $w['post_type'];
 


if( ! isset($w['excerpt_length']) ) $w['excerpt_length'] = 150;
  $opts = array_merge($opts,$filter);
  $opts['tax_query'] = $custom_tax;
$ioa_meta_data['content_limit'] = $w['excerpt_length'];



if(isset($opts['tax_query'][0]))
$ioa_meta_data['tax_filter'] = $opts['tax_query'][0];



if( isset($ioa_meta_data['section_width']) && $ioa_meta_data['section_width'] == "Full Width") $w['post_structure'] = 'full_width';

switch($w['post_structure'])
      {
        case '1-col' : 
                      $ioa_meta_data['height'] = 500;
                      $ioa_meta_data['width'] = $ioa_layout['cols']['full'];
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $ioa_meta_data['item_class'] = 'full';
                      $post_structure_class = 'post-grid-1cols'; 
                      break;
        case '2-col' : 
                      $ioa_meta_data['height'] = 300;
                      $ioa_meta_data['width'] = $ioa_layout['cols']['one_half'];
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 2;
                      $ioa_meta_data['item_class'] = 'one_half';
                      $post_structure_class = 'post-grid-2cols';
                      break;
        case '3-col' : $ioa_meta_data['height'] = 220;
                      $ioa_meta_data['width'] = $ioa_layout['cols']['one_third'];
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 3;
                      $ioa_meta_data['item_class'] = 'one_third';
                      $post_structure_class = 'post-grid-3cols';
                      break;
        default :              
        case '4-col' : $ioa_meta_data['height'] = 180;
                      $ioa_meta_data['width'] = $ioa_layout['cols']['one_fourth'];
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 4;
                      $ioa_meta_data['item_class'] = 'one_fourth';
                      $post_structure_class = 'post-grid-4cols';
                      break;
        case '5-col' : $ioa_meta_data['height'] = 120;
                      $ioa_meta_data['width'] = $ioa_layout['cols']['one_fifth'];
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 5;
                      $ioa_meta_data['item_class'] = 'one_fifth';
                      $post_structure_class = 'post-grid-5cols';
                      break;
        case '6-col' : $ioa_meta_data['height'] = 90;
                      $ioa_meta_data['width'] = 150;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 6;
                      $post_structure_class = 'post-grid-6cols';
                      break; 
       case 'full_width' : $ioa_meta_data['height'] = 550;
                      $ioa_meta_data['width'] = 550;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 4;
                      $post_structure_class = 'post-grid-4cols';
                      break;                                          
      }

global $paged;
if(is_front_page()) $paged = (get_query_var('page')) ? get_query_var('page') : 1;
if($w['w_pagination']=="yes") $opts['paged'] = $paged;

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_grid-inner-wrap clearfix iso-parent">

    
    <div class="text-title-wrap clearfix"  itemscope itemtype="http://schema.org/Thing">
       
       <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    <?php endif; ?>

       <?php
        if(isset($w['filter_menu']) && $w['filter_menu'] != "no") :
            if($w['post_type']=="post") get_template_part('templates/blog-filter');
            elseif($w['post_type']==$ioa_portfolio_slug) get_template_part('templates/portfolio-filter');
        endif;  
       ?>
    </div>
    
    <ul itemscope itemtype="http://schema.org/ItemList" data-gutter="50" data-layout="cellsByRow" class="isotope hoverable posts-grid posts  <?php echo $post_structure_class; ?>"  >          
    <?php query_posts($opts); $ioa_meta_data['i']=0; while (have_posts()) : the_post();  
         get_template_part('templates/post-grid-cols'); 
     endwhile; ?>
   </ul>
  
    <?php  if($w['w_pagination']=="yes")  wp_paginate(); wp_reset_query(); ?>

    </div>
   

</div>
