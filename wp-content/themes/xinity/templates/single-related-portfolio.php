<?php 
/**
 * Single Portfolio Post Related Section
 */
global $ioa_helper,$ioa_super_options,$ioa_portfolio_taxonomy,$ioa_portfolio_slug; 
/**
       * Related Posts Logic
       */
     $filter = wp_get_post_terms($post->ID, $ioa_portfolio_taxonomy );
     $f_c = array();
     foreach($filter as $f)
     $f_c[]  =  $f->name;
   
    if(count($filter) >0 ) : 


     $args = array(
        'post_type' => $ioa_portfolio_slug,
      'posts_per_page' => 4,
      'post__not_in' => array($post->ID),
      'tax_query' => array(
        array(
          'taxonomy' => $ioa_portfolio_taxonomy,
          'field' => 'slug',
          'terms' => $f_c
        )
       )
     );

   

    $rel = new WP_Query( $args ); ?>


<?php if($ioa_super_options[SN.'_single_portfolio_related_enable']!="" && $rel->have_posts()) : ?>

  <div class="related_posts portfolio_related_posts clearfix" itemscope itemtype="http://schema.org/ItemList">
          
     <div class="clearfix related_posts-title-area ">
        <h3 itemprop='name' class="single-related-posts-title custom-title"><?php echo stripslashes($ioa_super_options[SN.'_single_portfolio_related_title']) ?></h3> 
    </div>

<?php 



 ?>


<div class="related-posts-wrap clearfix">
    
    <ul class="clearfix active hoverable single-related-posts related" >
    
    <?php 
      
    $i=0;
    while ($rel->have_posts()) : $rel->the_post();   $i++; 

    ?>

    <li class="clearfix hover-item <?php if($i==4) echo 'last'; ?>" itemscope itemtype="http://schema.org/Article">
    
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>

      <div class="image">
         
        <?php
          $id = get_post_thumbnail_id();
          $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
          echo $ioa_helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 140 , "width" => 180 , "parent_wrap" => false, 'link' => get_permalink() ) );
          $ioa_helper->getHover(array( "id" => get_the_ID(),  "link" => true , "image" => $ar[0]  , 'format' => 'link' ) );
          ?>
      </div> 
      <?php endif; ?>
    
    </li>

<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

</ul>

</div>

</div>

<?php endif; endif; ?>