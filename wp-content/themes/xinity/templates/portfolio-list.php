<?php
/**
 * The template used for generating Portfolio 4 Columns
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */


global $ioa_helper,$ioa_meta_data,$ioa_portfolio_taxonomy,$ioa_portfolio_slug;


$ioa_meta_data['width']  = 320;

$portfolio_props = $ioa_meta_data['portfolio_props'];

  if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;  ?>
        
        <?php 

        $cl = array();
           $terms = get_the_terms( get_the_ID(), $ioa_portfolio_taxonomy );
                    
                   if ( $terms && ! is_wp_error( $terms ) ) : 
                    
                   $links = array();
                   foreach ( $terms as $term ) { 
                      $links[] = '<a href="' .get_term_link($term->slug, $ioa_portfolio_taxonomy) .'">'.$term->name.'</a>'; 
                      $cl[] = "category-".$term->slug;
                    }
                   $terms = join( ", ", $links );
                   endif;

         ?>  
          
        <li  itemscope itemtype="http://schema.org/Article"  id="post-<?php the_ID(); ?>"  class="hover-item iso-item clearfix <?php echo join(' ',$cl); ?>  <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
          <div class="inner-item-wrap">
            
              <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
              <div class="image-wrap">
               <div class="image" >
                <?php
                    $id = get_post_thumbnail_id();
                    $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
                    
                    switch($portfolio_props['portfolio_image_resize'])
                    {

                    case 'proportional' :   echo $ioa_helper->imageDisplay(array( "crop" => "wproportional", "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;
                    default :   echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" => 220 , "width" => 320 , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  break;

                    } 
               
                ?>

             
                  <?php  if($portfolio_props['_portfolio_enable_thumbnail']!="true"): ?>
                     <?php $ioa_helper->getHover(array( "id" => get_the_ID(), "link" => true  , 'format' => 'link' ) ); ?>
                 <?php else: ?>  
                     <?php $ioa_helper->getHover(array( "image" => $ar[0] , 'format' => 'image' ) ); ?>
                 <?php endif; ?>


               </div>
                 
              </div>
              
             <?php endif; ?>

             <div class="desc">
                     <h2 class="" itemprop='name'> <a itemprop='url' href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
                      <div class="clearfix excerpt" itemprop='description'>
                  <?php  if(  $portfolio_props['_portfolio_excerpt'] != "true") : ?>  
                    <p>
                      <?php
                      if(!isset($portfolio_props['_portfolio_excerpt_limit']) || $portfolio_props['_portfolio_excerpt_limit']=="") 
                        $portfolio_props['_portfolio_excerpt_limit'] = 200;
                      
                      $limit = 150;
                      if($portfolio_props['_portfolio_excerpt_limit']!="" && $portfolio_props['_portfolio_excerpt_limit']!="0") $limit = $portfolio_props['_portfolio_excerpt_limit'];

                      $content = get_the_content();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $limit ,   $content); ?>
                    </p>
                   <?php else:  the_excerpt(); endif; ?>

                  </div>
                  
                  <a href="<?php the_permalink(); ?>" itemprop='url' class="read-more"><span class="liner"></span> <?php if($portfolio_props['_portfolio_more_label']!="") echo stripslashes($portfolio_props['_portfolio_more_label']); else _e('More','ioa'); ?></a>  
              </div>


          </div>  
        </li>
