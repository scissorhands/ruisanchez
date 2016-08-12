<?php 
/**
 * Post List Template for RAD BUILDER
 */


global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_layout;

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

$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

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

$opts = array('posts_per_page' => 3,'post_type'=>'post');
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
  
$parent_class = '';
 switch($w['post_structure'])
      {
        case 'post-list' : 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'plain-list';
                      break;
           case 'post-thumbs-big' :
                      $ioa_meta_data['blog_props'] = array();
                      $ioa_meta_data['blog_props']['_enable_thumbnail'] = "false";
                      $ioa_meta_data['blog_props']['_blog_meta_enable'] = "true";
                      $ioa_meta_data['blog_props']['_blog_meta'] = $w['meta_value'];
                      $ioa_meta_data['blog_props']['_blog_excerpt'] = $w['use_custom_excerpt'];
                      $ioa_meta_data['blog_props']['_posts_excerpt_limit'] = $w['excerpt_length'];
                      $ioa_meta_data['blog_props']['_more_label'] = '';
                      

                      $ioa_meta_data['height'] = 350;
                      $ioa_meta_data['width'] =  $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'blog_posts';
                      $parent_class = ' blog-column-posts';
                      break;                   
        default :                
        case 'post-thumbs' :
                      $ioa_meta_data['height'] = 50;
                      $ioa_meta_data['width'] = 50;
                      $ioa_meta_data['hasFeaturedImage'] = false; 
                      $ioa_meta_data['item_per_rows'] = 1;
                      $post_structure_class = 'thumb-list';
                      break;
                    
        
      }


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_list-inner-wrap <?php echo $parent_class; ?> " >

  <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
    <div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    </div>
    <?php endif; ?>

        <ul  itemscope itemtype="http://schema.org/ItemList" class="rad-posts-list hoverable posts <?php echo $post_structure_class; ?> clearfix " >          
        <?php $query = query_posts($opts); $ioa_meta_data['i']=0; while (have_posts()) : the_post();   ?> 
       <?php  
        if($w['excerpt_length']!="") $ioa_meta_data['excerpt_length'] =  $w['excerpt_length'];
         switch($w['post_structure'])
         {
           case 'post-list' :  get_template_part('templates/post-list'); break;
           case 'post-thumbs' : get_template_part('templates/post-thumbs'); break;
           case 'post-thumbs-big' : get_template_part('templates/post-blog-column'); break;
        
          }
        ?>
        <?php  endwhile; ?>
    </ul>
    <?php if($w['w_ajax'] =="yes") : ?> <a href="" class="rad-ajax-load-more ajax-load-more-button" data-query="<?php echo base64_encode(json_encode($ioa_meta_data['widget'])) ?>">
      <span class="button-content">Load More</span>
      <span class="progress">
        <span class="inner-progress-bar"></span>
      </span>
    </a>  <?php endif; ?>
    <?php  if($w['w_pagination']=="yes")  wp_paginate(); wp_reset_query(); ?>


    
  </div>
</div>
