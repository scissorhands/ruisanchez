<?php
/**
 * The template used for generating Post Format Image
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_super_options;

$blog_props = $ioa_meta_data['blog_props'];

 ?>
      
      <li itemscope itemtype='http://schema.org/BlogPosting' id="post-<?php the_ID(); ?>" class="iso-item clearfix hover-item <?php echo join(' ',get_post_class()); ?>  <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            <div class="inner-post-wrap clearfix">
            
             <div class="image-wrap">
               <div class="image" itemprop="description" >

                 <?php the_content() ?>
                
              </div>
             </div>
              
              <div class="desc">
                <h2 class=""> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
              </div>
            </div>
        </li>

