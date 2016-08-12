<?php 
/**
 * Post Slider Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug;

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
 

$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'post');
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
  $custom_tax[] = array(
                      'taxonomy' => 'post_format',
                      'field' => 'slug',
                      'terms' => array('post-format-quote','post-format-aside','post-format-video','post-format-gallery','post-format-link','post-format-status','post-format-chat'),
                      'operator' => 'NOT IN'
                    );

  $opts = array_merge($opts,$filter);
  $opts['tax_query'] = $custom_tax;


if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';
if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
  $w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}
?>
<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="post_slider-inner-wrap" >

<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
    <div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    </div>
    <?php endif; ?>
  
    <div data-arrow_control="true" data-autoplay="<?php if($w['autoplay']=="yes") echo 'true'; ?>" data-duration="<?php echo $w['duration'] ?>" data-caption="true" data-width="<?php echo $w['width'] ?>" data-effect_type="fade" data-height="<?php echo $w['height'] ?>" class="ioaslider quartz rad-slider clearfix <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?>> 
           <div class="items-holder">
        <?php $query = new WP_Query($opts); $ioa_meta_data['i']=0; while ($query->have_posts()) : $query->the_post();  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?> 

        <div class="slider-item"  itemscope itemtype="http://schema.org/ItemList">  <a itemprop="url" href="<?php the_permalink(); ?>"><?php
          
          $id = get_post_thumbnail_id();
          $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
          echo $ioa_helper->imageDisplay(array( "width" => $w['width'] , "height" => $w['height'] , "parent_wrap" => false , "src" => $ar[0] )); ?>
        
          <div class="slider-desc s-c-l black-bg">
          <div class="inner-desc-wrap"><div class="inner-bg-desc">
                   <h4 itemprop="name"><?php the_title(); ?></h4>
                   <div class="clearfix">
                      <div  class="caption"> 
                       <?php if(isset($w['use_custom_excerpt']) && $w['use_custom_excerpt']!="no") : ?>
                    <p itemprop='description'>
                      <?php
                      if(!isset($w['excerpt_length'])) $w['excerpt_length'] = 100;
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $w['excerpt_length'] ,   $content); ?>
                    </p>
                  <?php else: the_excerpt(); endif; ?>
                   
                  </div> 
                   </div>
          </div> </div></div>

       </a></div> 
        <?php endif; endwhile; ?>
      
 
        </div>
    </div>
   


    
  </div>

</div>
