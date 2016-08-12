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
  $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget testimonials-wrapper"';


// Default Values 
// 
$ioa_meta_data['height'] = 50;
$ioa_meta_data['width'] = 50;
$ioa_meta_data['hasFeaturedImage'] = false; 

$opts = array('posts_per_page' => 3,'post_type'=>'testimonial');
  $filter = array();


  if(isset($w['no_of_posts'])) $opts['posts_per_page'] = $w['no_of_posts']; 

  if(isset($w['sort_by']) && $w['sort_by'] !="" )
  {
   
        $filter['orderby '] =  $w['sort_by'];
     
  }
  if(isset($w['order']) && $w['order'] !="" )
  {
   
        $filter['order '] =  $w['order'];
     
  }

  $opts = array_merge($opts,$filter);


 ?>


<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="testimonials-inner-wrap <?php if(isset($w['t_style']) ) echo 'testimonial-'.$w['t_style'];  ?>" >

    
  <?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
    <div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
      <h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
    </div>
    <?php endif; ?>

    <div class="updatable">
        <ul class="rad-testimonials-list clearfix <?php if(isset($w['t_style']) ) echo $w['t_style'];  ?>"   itemscope itemtype="http://schema.org/Review">          
        <?php $query = new WP_Query($opts); $ioa_meta_data['i']=0;   $i=0;while ($query->have_posts()) : $query->the_post(); 

          ?> 
       <?php  
      
     	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
          
          
        <li class="clearfix <?php if($i==0) echo 'active'; ?>">
            
              
             	
				<div class="desc">
           			  
        	        <div class="content clearfix" itemprop="description" >
                      <?php
                     the_content() ?>
                  	</div>
           		     </div>
           		
              <div class="clearfix">
                <?php if ( $ioa_meta_data['hasFeaturedImage'] && (isset($w['t_style']) &&  $w['t_style'] != 'centered' ) ) : ?>   
              

                <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
              </div>

            <?php endif;
              ?>

              <div class="info">
                      <h2 class="name" itemprop="name"> <?php the_title(); ?></h2> 
                      <?php  if(get_post_meta(get_the_ID(),'design',true)!="")  echo "<span class='designation'>".get_post_meta(get_the_ID(),'design',true)."</span>" ?>
                    </div>
                    
              </div>
              
                 
               
        </li>

        <?php $i++; endwhile; ?>
    </ul>
    </div>
   

    
  </div>

</div>
