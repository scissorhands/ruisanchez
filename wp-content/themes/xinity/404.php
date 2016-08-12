<?php
/**
 * The Template for 404
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */

global $ioa_meta_data;
get_header(); 
?>   

<div class="supper-title-wrapper hasbottomBar" >
  <div class="title-wrap "  >
    <div class="wrap">
      <div class="skeleton auto_align clearfix"> 
            <div class="title-block">
              <h1 class="custom-title"  ><?php echo stripslashes($ioa_super_options[SN."_notfound_title"]) ?></h1>
            </div>
         </div>
     </div>
  </div>
</div>
	
	<div class="skeleton clearfix auto_align">

		

		<div class="mutual-content-wrap ">
			

		 <?php if($ioa_super_options[SN.'_not_found_style']=='Default') : ?>
          
          <div class="not-found-image">
        <img src=" <?php 
            if(!$ioa_super_options[SN."_notfound_logo"]) 
                echo URL."/sprites/i/notfound.png"; 
             else echo $ioa_super_options[SN."_notfound_logo"]; ?>" alt="Page Not Found" title="Page Not Found" />

       </div>
       <div class="not-found-text clearfix"> <?php echo do_shortcode(stripslashes($ioa_super_options[SN."_notfound_text"])); ?> </div>
      
      <div class="error-search clearfix">
          <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
          <div>
              <input type="text" value="" name="s" id="s" placeholder='<?php _e('Search..','ioa') ?>' />
              <input type="submit" id="searchsubmit" value="<?php _e('Search','ioa') ?>" />
          </div>
           </form>
      </div>
    
    

     <?php else: $ioa_meta_data['layout'] = "right-sidebar";  $ioa_meta_data['sidebar'] = $ioa_super_options[SN.'_not_found_sidebar']; ?>
            <div class="sidebar-layout has-sidebar has-right-sidebar">
               
                  <div class="not-found-teaser">
                          <h4><span>4</span><span>0</span><span>4</span></h4>
                   </div>
                   <div class="not-found-text clearfix"> <?php echo do_shortcode(stripslashes($ioa_super_options[SN."_notfound_text"])); ?> </div>
                  
                  <div class="error-search clearfix">
                      <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                      <div>
                          <input type="text" value="" name="s" id="s" placeholder='<?php _e('Search..','ioa') ?>' />
                           <input type="submit" id="searchsubmit" value="<?php _e('Search','ioa') ?>" />
                      </div>
                       </form>
                  </div> 

            </div>
            
          <?php get_sidebar(); ?>
     <?php endif; ?> 
	
      </div>

	</div>



<?php get_footer(); ?>


      