<?php
/**
 * The template used for generating Post Format Gallery
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_super_options;

$blog_props = $ioa_meta_data['blog_props'];
 ?>
      
      <li itemscope itemtype='http://schema.org/BlogPosting' id="post-<?php the_ID(); ?>" class="iso-item  clearfix  hover-item <?php echo join(' ',get_post_class()); ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
               <div class="inner-post-wrap clearfix">
               <div class="gallery  clearfix" itemprop="description" >
                    <div class="clearfix">


                        <div class="ioa-gallery seleneGallery " data-effect_type="fade" data-thumbnails="false" data-autoplay="fase" data-caption="false" data-arrow_control="true" data-duration="3000" data-height="<?php echo $ioa_meta_data['height'] ?>"  data-width="<?php echo $ioa_meta_data['width'] ?>" > 
                        <div class="gallery-holder">
                       <?php  
                      
                       $images = get_post_gallery_images();

                    
                    foreach( $images as $image) :
                     
                     $tr_image = str_replace('-150x150', '',$image);
                     ?>
                     <div class="gallery-item" data-thumbnail="<?php echo $image; ?>">
                                  
                                  <?php 
                                 echo $ioa_helper->imageDisplay(array( "src" =>$tr_image , 'imageAttr' =>  get_the_title(), "parent_wrap" => false , "width" => $ioa_meta_data['width'] , "height" => $ioa_meta_data['height'] ));
                                   ?> 
                      </div> 
                  <?php 
                    
                  endforeach; ?>
                </div>
              </div>

                   </div>
               
              </div>
              
              <div class="desc">
                  <h2 class=""> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
              </div>
            </div>
        </li>

