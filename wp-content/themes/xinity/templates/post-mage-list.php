<?php 
/**
 * Post Grid 3 Column Template
 */
global $ioa_helper,$ioa_meta_data;

 $cl = '';


	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
          
          
        <li itemscope itemtype="http://schema.org/Article" class="clearfix chain-link hover-item <?php $ioa_meta_data['i']++; if($ioa_meta_data['i']==1) echo 'first'; elseif($ioa_meta_data['i']==$ioa_meta_data['item_per_rows']) { echo 'last'; $ioa_meta_data['i']=0; } ?>">
            
            
            	
           		<?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
              <div class="image">
                
                <?php
                $id = get_post_thumbnail_id();
                $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'")); 
                
                $ioa_helper->getHover(array( "id" => get_the_ID() , "link" => true , "image" => $ar[0] , 'format' => 'compact' ) ); 
                
                ?>
              </div>
              
              <?php
              endif;
              ?>
              <div class="desc <?php if($ioa_meta_data['excerpt']=="no") echo 'adjust-title'; ?>">
           			<h2 class="" itemprop="name"> <a href="<?php the_permalink(); ?>" class="clearfix" ><?php the_title(); ?></a></h2> 
        	      
                <?php  if(isset($ioa_meta_data['meta_value']) && $ioa_meta_data['meta_value']!=""):  ?>   
                   <div class="extras clearfix"> 
                        <?php echo do_shortcode(stripslashes($ioa_meta_data['meta_value'])); ?> 
                    </div> 
                 <?php endif; ?> 
                  <?php if(isset($ioa_meta_data['excerpt']) && $ioa_meta_data['excerpt']!="no") : ?>
					        <div class="clearfix">

                    <?php if(isset($ioa_meta_data['use_custom_excerpt']) && $ioa_meta_data['use_custom_excerpt']!="no") : ?>
 					      	  <p itemprop='description'>
                      <?php
						          if(!isset($ioa_meta_data['excerpt_length'])) $ioa_meta_data['excerpt_length'] = 100;
                      $content = get_the_excerpt();
                      $content = apply_filters('the_content', $content);
                      $content = str_replace(']]>', ']]&gt;', $content);
                      echo $ioa_helper->getShortenContent( $ioa_meta_data['excerpt_length'] ,   $content); ?>
                    </p>
                  <?php else: the_excerpt(); endif; ?>

                  
                  </div>
                  <?php endif ?>
                  
           		</div>
                 
               
        </li>
