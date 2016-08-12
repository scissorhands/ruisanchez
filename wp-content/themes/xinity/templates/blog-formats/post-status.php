<?php
/**
 * The template used for generating Post Format Link
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_super_options;

 ?>
      
      <li itemscope itemtype='http://schema.org/BlogPosting' id="post-<?php the_ID(); ?>" class="iso-item clearfix hover-item <?php echo join(' ',get_post_class()); ?> <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            <div class="inner-post-wrap clearfix">
              
              <div class="desc ">
                  <h2 class="" itemprop="name"> <a itemprop="url" href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                
                <div class="status clearfix">
                   <?php the_content(); ?>
                </div>
              
              </div>
			</div>
        </li>

