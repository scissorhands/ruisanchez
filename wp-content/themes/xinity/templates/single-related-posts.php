<?php 
/**
 * Single Related Posts Section
 */
global $ioa_helper,$ioa_super_options;


 // Related Posts logic
      $tags = wp_get_post_tags($post->ID); $args  = array();
    
      if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args=array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page'=>4
        );

      }

      $rel = new WP_Query( $args );

 /**
       * Popular Posts logic
       */
      $args=array( 'posts_per_page'=>3, "order" => "DESC" , "orderby" => "comment_count" , 'post__not_in' => array($post->ID)  );


    $pop = new WP_Query( $args );


     /**
       * Recent Posts logic
       */
      $args=array(
   
      'posts_per_page'=>3, "order" => "DESC" , "orderby" => "date" ,'post__not_in' => array($post->ID)  );


    $rec = new WP_Query( $args );
 
if( ! $rec->have_posts() &&  ! $rel->have_posts()  &&  ! $pop->have_posts()  ) return;
 ?>


  <!-- Filterable menu section -->
  <div class="related_posts clearfix">
          
     <div class="clearfix related_posts-title-area ">
            <div class="ioa-menu related-menu"> 
                   <ul itemscope itemtype="http://schema.org/Thing" class='clearfix related-list'>
           <?php if($rec->have_posts()) : ?> <li class='recent active' data-val="recent"><span itemprop="name" ><?php _e('Recent','ioa') ?></span></li><?php endif; ?>
           <?php if($rel->have_posts()) : ?><li class='related ' data-val="related"><span itemprop="name"><?php _e('Related','ioa'); ?></span></li> <?php endif; ?>
           <?php if($pop->have_posts()) : ?> <li class='popular' data-val="popular"><span itemprop="name"><?php _e('Popular','ioa') ?></span></li><?php endif; ?>
          </ul>
        </div>
        <h3 class="single-related-posts-title custom-title"><?php echo stripslashes($ioa_super_options[SN.'_related_posts_title']) ?></h3> 
    </div>


  <!-- Posts Area -->
<div class="related-posts-wrap hoverable clearfix">
    
    <?php if($rel->have_posts()) : ?>
    <ul class="clearfix single-related-posts related" itemscope itemtype="http://schema.org/ItemList">
    
    <?php 
     
      $i=0;
      while ($rel->have_posts()) : $rel->the_post();   $i++;

       ?>

        <li class="clearfix hover-item <?php if($i==4) echo 'last'; ?>" itemscope itemtype="http://schema.org/Article" >
        
          <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>

          <div class="image">
           <?php
              $id = get_post_thumbnail_id();
              $ar = wp_get_attachment_image_src( $id, array(9999,9999) );
              echo $ioa_helper->imageDisplay( array( "src"=> $ar[0] ,"height" => 140 , "width" => 180 , "parent_wrap" => false, 'link' => get_permalink() ) );
              $ioa_helper->getHover(array( "id" => get_the_ID(),  "link" => true , "image" => $ar[0]  , 'format' => 'link' ) );
              ?>
          </div> 
          <?php  else : ?>
          <div class="image">
          <?php 

          $ioa_helper->getHelperDisplay(get_the_ID()); 
          $ioa_helper->getHover(array( "id" => get_the_ID(),  "link" => true   , 'format' => 'link' ) );
          ?>
          
        </div>
        <?php  endif; ?>
        
        </li>

      <?php endwhile; ?>

<?php wp_reset_postdata(); ?>

</ul>
<?php endif; ?>

<?php if($pop->have_posts()) : ?>
<ul class="clearfix single-related-posts popular" itemscope itemtype="http://schema.org/ItemList">
    
    <?php 
  
     
    $i=0;
    while ($pop->have_posts()) : $pop->the_post();   $i++;
       
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
     <?php  else : ?>
    <div class="image">
          <?php 

          $ioa_helper->getHelperDisplay(get_the_ID()); 
          $ioa_helper->getHover(array( "id" => get_the_ID(),  "link" => true   , 'format' => 'link' ) );
          ?>
        </div>
      <?php  endif; ?>
    
    </li>

<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

</ul>
<?php endif; ?>

<?php if($rec->have_posts()) : ?>
<ul class="clearfix single-related-posts recent" itemscope itemtype="http://schema.org/ItemList">
    
    <?php 
  
     
    $i=0;
    while ($rec->have_posts()) : $rec->the_post();   $i++; 
       
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
      <?php  else : ?>
         <div class="image">
            <?php 

          $ioa_helper->getHelperDisplay(get_the_ID()); 
          $ioa_helper->getHover(array( "id" => get_the_ID(),  "link" => true  , 'format' => 'link' ) );
          ?>
         </div>
      <?php  endif; ?>
    
    </li>

<?php endwhile; ?>

<?php wp_reset_postdata(); ?>

</ul>
<?php endif; ?>

</div>

</div>

