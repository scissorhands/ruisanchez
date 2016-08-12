<?php 
/**
 * Testimonails Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
if( isset($w['visibility']) && $w['visibility']!='none')
{
   $an = 'way-animated';
  $rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
  if(isset($w['delay'])) $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget testimonials-wrapper"';



// Default Values 
// 
$ioa_meta_data['height'] = 50;
$ioa_meta_data['width'] = 50;


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="testimonial_bubble-inner-wrap" >


    <div  itemscope itemtype="http://schema.org/review" class="testimonial-bubble  <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'way-animated'; ?>" <?php if(isset($w['visibility']) && trim($w['visibility'])!= "" && trim($w['visibility'])!= "none") echo 'data-waycheck="'.$w['visibility'].'"'; ?>>
       <?php  if(isset($w['t_id'])) : $tpost = get_post($w['t_id']);
 

        if(isset($tpost)) :
          ?> 
           
           <div class="testimonial-bubble-content clearfix" itemprop='description' >
              <div class="clearfix">
                <?php echo $tpost->post_content  ?>
              </div>
               <div class="info">
                      <h2 class="name" itemprop="name"> <?php echo get_the_title($w['t_id']); ?></h2> 
                      <?php  if(get_post_meta($w['t_id'],'design',true)!="")  echo "<span class='designation'>".get_post_meta($w['t_id'],'design',true)."</span>" ?>
                </div>

                 <i class="ioa-front-icon down-dir-1icon-"></i>

           </div> 

           <div class="testimonial-bubble-meta clearfix">
             
                <?php   if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail($w['t_id'])))  : ?>   
              
                <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id($w['t_id']);
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
              </div>

            <?php endif;
              ?>

             
                    
              </div>

        <?php endif;  endif; ?>
    </div>
   

    
  </div>
</div>
