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

if(!isset($ioa_meta_data['ioa_custom_template'] )) $ioa_meta_data['ioa_custom_template']  = '';

if($ioa_meta_data['ioa_custom_template'] == 'ioa-template-portfolio-list') $portfolio_props['portfolio_cols'] = 'default';

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
        
        <?php 
                  $terms = get_the_terms( get_the_ID(), $ioa_portfolio_taxonomy );
                   $cl = array();
                   $links = array();
                     
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                   
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( "<span>|</span>", $links );
                  endif; ?>
                 
          
        <div  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="hover-item swiper-slide <?php echo join(' ',$cl); ?>  <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; echo $portfolio_props['portfolio_cols'].'-col-layout'; ?>" style='width:<?php echo $ioa_meta_data['width'] ?>px'>
          <div class="inner-item-wrap clearfix">
            <?php 

              $mt =  'image';

              switch($mt)
              {

                /*
                 * case "video" : ?>   
                               <div class="video">
                                   <?php $video =  get_post_meta( get_the_ID(),"featured_video",true);  echo wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height']) ) ; ?>
                               </div>
                              <?php break;
                 
                case "gallery" : get_template_part("templates/post-featured-gallery"); break;
                case "slider" :get_template_part("templates/post-featured-slider"); break; */
                case "image" : 
                default : ?>
      
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
             <div class="image-wrap">
               <div class="image" >
               <?php



              $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
                  
              switch($portfolio_props['portfolio_image_resize'])
              {
                  case "none" : echo "<img src='".$ar[0]."' alt='".get_the_title()."' />";  break;
                  case "proportional" :  echo $ioa_helper->imageDisplay(array( "crop" => "hproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                  case "default" :
                  default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                 
              }
                    
            
            ?>

              <?php   $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'auto' ) ); ?>  
                

              </div>
             </div>

              <?php
              endif;
              ?>

            <?php
              }
               ?>
          </div>  
        </div>
