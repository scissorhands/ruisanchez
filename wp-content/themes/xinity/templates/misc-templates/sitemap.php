<?php
  global $ioa_meta_data,$ioa_helper,$ioa_super_options,$ioa_portfolio_slug,$ioa_portfolio_name;
    /**
     * Full Width Featured Media Items will appear here. 
     * Note the switches are for condition checking on featured media Full or Contained. 
     */
    if(! post_password_required())  // Check if Page is password protected

    switch($ioa_meta_data['featured_media_type'])
    {
      case "slider-full" :
      case "slider-contained" :
      case "slideshow-contained" :
      case "none-full" :
      case 'image-parallex' : 
      case 'slider-manager' :
      case 'image-full' : $ioa_meta_data['gr'] = true; get_template_part('templates/content-featured-media'); break;
    }
  ?>


  
  <div class="skeleton clearfix auto_align">
    <div class="mutual-content-wrap sitemap <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
      <?php  
        /**
         * Featured Media Items contained by parent width will appear here. 
         */
        if(! post_password_required()) // Check if Page is password protected
        switch($ioa_meta_data['featured_media_type'])
        {
          case 'slider' :
          case 'slideshow' :
          case 'video' :
          case 'proportional' :
          case 'none-contained' :
          case 'image' : get_template_part('templates/content-featured-media'); break;
        }
      ?>
      

      <?php  if(have_posts()): while(have_posts()) : the_post(); ?>
      
        <?php if(get_the_content()!="") : ?>
          <div class="page-content clearfix">
            <?php  the_content(); ?>
          </div>
        <?php endif; ?>
    
      <?php endwhile; endif;  ?>

      <div class="one_third left layout_element first">
     
         <h2>Pages</h2>
                <ul>
                  <?php
                     wp_list_pages(   array( 'exclude' => '', 'title_li' => '' ) );
                  ?>
                 </ul>
          </div>  

         
        
          <div class="one_third layout_element  left  ">  
            
             <h2><?php _e('Posts','ioa'); ?></h2>
                <ul class="cats">
            <?php 
        
            $category_ids = get_all_category_ids();
            foreach($category_ids as $cat_id) {
            $cat_name = get_cat_name($cat_id);
            echo "<li> <h5 > $cat_name </h5><ul class='subcats children'>";

            $query = new WP_Query();

            $query->query('cat='.$cat_id.'');
            while ($query->have_posts()) : $query->the_post();  
            echo " <li><a href=\"".get_permalink()."\">". get_the_title()  ."  </a></li>";
            endwhile; 

            echo "</ul></li>";

            }
              ?>
                  </ul> 
        </div>
         <div class="one_third left layout_element  last ">  
            
             <h2><?php echo $ioa_portfolio_name.' Items'; ?></h2>
                <ul class="cats">
            <?php 
        
             $query = new WP_Query('posts_per_page=-1&post_type='.$ioa_portfolio_slug);
            while ($query->have_posts()) : $query->the_post();  
            echo " <li><a href=\"".get_permalink()."\">". get_the_title()  ."  </a></li>";
            endwhile; 

              ?>
                  </ul> 
        </div>   
    </div>
    <?php get_sidebar(); ?>


