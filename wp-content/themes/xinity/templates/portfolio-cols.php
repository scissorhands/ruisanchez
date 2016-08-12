<?php
/**
 * The template used for generating Portfolio Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;
 $ioa_meta_data['hasFeaturedImage'] = false; 

$portfolio_props = $ioa_meta_data['portfolio_props'];

$ioa_options = get_post_meta( get_the_ID(), 'ioa_options', true );

/**
 * Thumbnail management code 
 */
$custom_thumbnail = '';
$thumbnail_type = 'image';
$ioa_video_link = '';


if(isset($ioa_options['ioa_thumbnail_type'])) $thumbnail_type = $ioa_options['ioa_thumbnail_type'];
if(isset($ioa_options['ioa_custom_thumbnail'])) $custom_thumbnail = $ioa_options['ioa_custom_thumbnail'];
if( isset($ioa_options['ioa_video_link']) ) $ioa_video_link = $ioa_options['ioa_video_link'];

if(!isset($ioa_meta_data['ioa_custom_template'] )) $ioa_meta_data['ioa_custom_template']  = '';

if($ioa_meta_data['ioa_custom_template'] == 'ioa-template-portfolio-list') $portfolio_props['portfolio_cols'] = 'default';

if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  
  $ioa_meta_data['hasFeaturedImage'] = true; 	

$terms = get_the_terms( get_the_ID(), $ioa_portfolio_taxonomy );
 $cl = array();
 $links = array();
   
 if ( $terms && ! is_wp_error( $terms ) ) : 
    foreach ( $terms as $term ) { 
       $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; 
       $cl[] = "category-".$term->slug;
    }
    $terms = join( "<span>-</span>", $links );
endif; ?>
                 
          
<li  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="iso-item hover-item clearfix <?php echo join(' ',$cl); ?>  <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; echo $portfolio_props['portfolio_cols'].'-col-layout'; ?>">
    
    <div class="inner-item-wrap">

      <div class="image-wrap">
        <div class="image" >
          <?php 

          switch($thumbnail_type)
          {
          case "slider" :
            
              $gallery_images =  "";
              if(isset( $ioa_options['ioa_thumbnail_data'] )) $gallery_images =  $ioa_options['ioa_thumbnail_data'];
                  ?>
                  <div itemscope itemtype="http://schema.org/ImageGallery" class="ioaslider quartz"  data-bullets="false" data-autoplay="false" data-effect_type="fade" data-full_width="false" data-caption="false" data-arrow_control="true" data-duration="5" data-height="<?php  echo $ioa_meta_data['height']; ?>"  data-width="<?php echo $ioa_meta_data['width']; ?>" > 
                      <div class="items-holder" style="height:<?php echo $ioa_meta_data['height']; ?>px;">
                      <?php if(isset($gallery_images) && trim($gallery_images) != "" ) : $ar = explode(";",stripslashes($gallery_images));

                      foreach( $ar as $image) :
                          if($image!="") :
                          $g_opts = explode("[ioabre]",$image);
                          ?>
                              <div class="slider-item" data-thumbnail="<?php if(isset($g_opts[1])) echo $g_opts[1]; ?>">
                                  <?php 
                                  if($cl=="true")
                                     echo "<img src='".$g_opts[0]."' />";  
                                  else
                                     echo $ioa_helper->imageDisplay(array( "src" =>$g_opts[0] , 'imageAttr' =>  $g_opts[2], "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] )); 
                                  ?> 
                                  <div class="slider-desc">
                                     <h2 itemprop='name'><?php echo $g_opts[3] ?></h2>
                                     <div itemprop='description' class="caption"><?php echo $g_opts[4] ?></div>
                                  </div>  
                              </div> 
                          <?php 
                          endif;
                        endforeach;  ?>
                     </div>
                 </div>
                 <?php endif;  ?>
          <?php break;
          
          case "video" : 
          case "image" : 
          default :
          
          if ( $ioa_meta_data['hasFeaturedImage'] || $custom_thumbnail!="") : ?>   
          <?php

              $id = get_post_thumbnail_id();
              $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

              if($custom_thumbnail!="") $ar[0] = $custom_thumbnail;
                
                  switch($portfolio_props['portfolio_image_resize'])
                  {
                    case "none" : echo "<img src='".$ar[0]."' alt='".get_the_title()."' />";  break;
                    case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    case "default" :
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  }
              ?>

              <?php 
              if($thumbnail_type == 'video')
                 $ioa_helper->getHover(array( "id" => get_the_ID(), "custom_link" => $ioa_video_link  , 'format' => 'video' ) ); 
              else if($thumbnail_type=='hosted_video'){
                $ioa_helper->getHover(array( "id" => get_the_ID(), "custom_link" => $ioa_video_link  , 'format' => 'hosted_video' ) ); 
              }
              else {  
                if( $portfolio_props['portfolio_cols'] != "grid" ) :

                   if($portfolio_props['_portfolio_enable_thumbnail']!="true"): 
                     $ioa_helper->getHover(array( "id" => get_the_ID(), "link" => true  , 'format' => 'link' ) ); 
                   else:
                     $ioa_helper->getHover(array( "image" => $ar[0] , 'format' => 'image' ) );
                    endif;
                else : 
                   $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'auto' ) ); 
                 endif; 

              }    ?>  

              
          <?php
      endif;
      }
      ?>
      </div>
    </div>

 <?php if( $portfolio_props['portfolio_cols'] != "grid" ) : ?>

    <div class="desc">
        <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
        <p class="tags clearfix">
           <?php echo $terms; ?>
        </p>
        <div class="like-icon-wrap">
          <i class="like-icon ioa-front-icon heart-2icon-" data-id="<?php echo get_the_ID() ?>" ></i>
          <span class="p-counter"><?php echo get_post_meta(get_the_ID(),'_ioa_likes',true) ?></span>
        </div>

        <?php if($ioa_meta_data['ioa_custom_template'] == 'ioa-template-portfolio-list' || $portfolio_props['portfolio_cols'] == "text" ) : ?>
              <div class="clearfix excerpt" itemprop='description'>
                  <?php   if(  $portfolio_props['_portfolio_excerpt'] != "true") : ?>  
                      <p>
                      <?php
                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $portfolio_props['_portfolio_excerpt_limit'] ,   $content); ?>
                      </p>
                  <?php else:  the_excerpt(); endif; ?>

                  <?php if($portfolio_props['_portfolio_more_label']!="") : ?>
                  <a href="<?php the_permalink(); ?>" itemprop='url' class="read-more">
                       <?php echo stripslashes($portfolio_props['_portfolio_more_label']) ?>
                  </a> 
              <?php endif; ?>  

              </div>
        <?php endif; ?>

    </div>
<?php endif; ?>
</div>  
</li>
