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


  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  ?>
        
      
                 
          
        <li  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="iso-item clearfix hover-item  <?php echo $ioa_meta_data['column']; ?> <?php $ioa_meta_data['i']++; ?>">
          <div class="inner-item-wrap">
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
                  
               echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
              
               if($ioa_meta_data['custom_enable_thumbnail']!="true"): 
                     $ioa_helper->getHover(array( "id" => get_the_ID(), "link" => true  , 'format' => 'link' ) ); 
                   else:
                     $ioa_helper->getHover(array( "image" => $ar[0] , 'format' => 'image' ) );
                    endif;
            ?>
                
              </div>
             </div>
              <div class="desc">
                <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
             </div>
              
              <?php
              endif;
              ?>

            <?php
              }
               ?>
          </div>  
        </li>
