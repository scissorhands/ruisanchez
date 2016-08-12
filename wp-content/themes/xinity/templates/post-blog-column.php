<?php
/**
 * The template used for generating blog template Format 1 List
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_super_options;

$ioa_meta_data['hasFeaturedImage'] = false; 
$blog_props = $ioa_meta_data['blog_props'];

$format_type = get_post_format();

	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	


 
  switch ($format_type) {
    case 'image':  get_template_part("templates/blog-formats/post-image"); break;
    case 'gallery':get_template_part("templates/blog-formats/post-gallery"); break;  
    case 'link':get_template_part("templates/blog-formats/post-link"); break;
    case 'video':get_template_part("templates/blog-formats/post-video"); break;  
    case 'audio':get_template_part("templates/blog-formats/post-audio"); break;  
    case 'chat':get_template_part("templates/blog-formats/post-chat"); break;  
    case 'status':get_template_part("templates/blog-formats/post-status"); break;  
    case 'quote':get_template_part("templates/blog-formats/post-quote"); break;  
    default: ?>
      
      <li itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="iso-item hover-item clearfix <?php echo join(' ',get_post_class()); ?>  <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>"><div class="inner-post-wrap clearfix">
            
            <?php 

            if(is_sticky()) echo '<i class="pin-2icon- ioa-front-icon sticky-icon post-icon"></i>';

             ?>

              
              <?php 

              $mt =  'image';

              switch($mt)
              {

                case "video" : ?>   
                               <div class="video">
                                   <?php $video =  $ioa_options["featured_video"];  echo fixwmode_omembed(wp_oembed_get(trim($video),array( "width" => $ioa_meta_data['width'] , 'height' => $ioa_meta_data['height']) )) ; ?>
                               </div>
                              <?php break;
                case "gallery" : get_template_part("templates/post-featured-gallery"); break;
                case "slider" :get_template_part("templates/post-featured-slider"); break;
                case "image" : 
                default :  $image = '';  

                  if($post->post_type=='page') $image =  '';
                ?>
              

            
             
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : 
                    $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
                    $image = $ar[0];
              endif;
              ?>
              
             <div class="image-wrap">
               <div class="image" >
               <?php


              $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );

              if( isset($ioa_meta_data['crop']) )
                echo $ioa_helper->imageDisplay(array( "crop" => $ioa_meta_data['crop'] , "src" => $image , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
              else      
              echo $ioa_helper->imageDisplay(array( "src" => $image , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
            ?>

             
                <?php if($blog_props['_enable_thumbnail']!="true"): ?>
                     <?php $ioa_helper->getHover(array( "id" => get_the_ID(), "link" => true  , 'format' => 'link' ) ); ?>
                 <?php else: ?>  
                     <?php $ioa_helper->getHover(array( "image" => $image , 'format' => 'image' ) ); ?>
                 <?php endif;  ?> 
              
                
              </div>
             </div>
              
              
            

            <?php
              }
               ?>
              
              <div class="desc">
                <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                  
                  <?php if(isset($blog_props['_blog_meta_enable']) && $blog_props['_blog_meta_enable']!="false") : ?>
                  <div class="extra clearfix">
                    <?php echo do_shortcode($blog_props['_blog_meta']); ?>
                  </div>        
                  <?php endif; ?>


                    <div class="clearfix excerpt" itemprop='description'>
                  <?php  if(  $blog_props['_blog_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      
                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $blog_props['_posts_excerpt_limit'] ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>
                    
                    <?php if($blog_props['_more_label']!="") : ?>
                    <a href="<?php the_permalink(); ?>" itemprop='url' class="read-more"><?php echo stripslashes($blog_props['_more_label']) ?></a> 
                    <?php endif; ?>  

                  </div>
                    
                    


                   

                 
                  
                  
              </div>
                 
          





       </div> </li>


      <?php break;
  }
 ?>  
          
        