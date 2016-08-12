<?php 
/**
 * @description : This File contains all theme's widgets
 * @dependency : none
 * @author Abhin Sharma <abhin_sh@yahoo.com>
 */

/*
   == Index ==========================================================

   1. Twitter Widget
   2. Google Map
   3. Custom Box Widget
   4. Facebook Like
   5. Posts

*/


/* == Twitter Widget ================================================= */

class IOA_Twitter_Widget extends WP_Widget {
    function __construct() {
        $params = array(
	    'description' => __('Display and cache recent tweets to your readers.','ioa'),
	    'name' => __('Twitter Widgets','ioa')
        );
        
        // id, name, params
        parent::__construct(__('IOA_Twitter_Widget','ioa'), '', $params);
    }
    
    public function form($instance) {
        extract($instance);
        ?>
        
        <p>
	    <label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title:','ioa') ?> </label>
	    <input type="text"
		class="widefat"
		id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>"
		value="<?php if ( isset($title) ) echo esc_attr($title); ?>" />
        </p>
        
       
        <p>
	    <label for="<?php echo $this->get_field_id('tweet_count'); ?>">
		<?php _e('Number of Tweets to Retrieve:','ioa'); ?>
	    </label>
	     
	    <input
		type="number"
		class="widefat"
		style="width: 40px;"
		id="<?php echo $this->get_field_id('tweet_count');?>"
		name="<?php echo $this->get_field_name('tweet_count');?>"
		min="1"
		max="10"
		value="<?php echo !empty($tweet_count) ? $tweet_count : 5; ?>" />
        </p>
        <?php
    }
    
    // What the visitor sees...
    public function widget($args, $instance) {
		extract($instance);
        extract( $args );
        
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $before_widget;
		
			echo $before_title;
			    echo $title;
			echo $after_title;

			echo do_shortcode("[tweets  count='".$tweet_count."']");

        echo $after_widget;
        
    }
   

    
}

add_action('widgets_init', 'register_IOA_Twitter_Widget');
function register_IOA_Twitter_Widget()
{
    register_widget('IOA_Twitter_Widget');
}


/* == Google Map ========================================================== */


// == Google Map =====================

class IOAGoogleMap extends WP_Widget {
	
	function __construct() {
		 /* Widget settings. */
		 $widget_ops = array( 'classname' => 'IOAGoogleMap', 'description' => __( 'Add google map.' ,'ioa'));

		 /* Widget control settings. */
		 $control_ops = array( "width"=>200);
		 parent::WP_Widget(false,__( "Google map" ,'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['map_width']= strip_tags($new_instance['map_width']); 
			$instance['map_height']= strip_tags($new_instance['map_height']); 
			$instance['address']= strip_tags($new_instance['address']); 
			return $instance;
	}
	function form($instance) {
		 $title = $width = $height = $address = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['map_width'])) $width = esc_attr($instance['map_width']);
		if(isset($instance['map_height'])) $height = esc_attr($instance['map_height']);
		if(isset($instance['address'])) $address = esc_attr($instance['address']);
		
		if($width=="") $width = 300;
		if($height=="") $height = 250;
		?>
        
       
		<p> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('map_width'); ?>"> <?php _e('Map Width','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('map_width'); ?>" name="<?php echo $this->get_field_name('map_width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('map_height'); ?>"> <?php _e('Map Height','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('map_height'); ?>" name="<?php echo $this->get_field_name('map_height'); ?>" type="text" value="<?php echo $height; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('address'); ?>"> <?php _e('Enter Address','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" />
		</p>
        
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$width = esc_attr($instance['map_width']);
	$height = esc_attr($instance['map_height']);
	$address = esc_attr($instance['address']);
	
	if($width!="") $width = 250;
	if($height!="") $height = 250;	

	echo $before_widget;
		
	if($title!="")
	echo $before_title." ".$title.$after_title;
	
	echo '<div class="google-map" style="width:'.$width.'px;height:'.($height).'px;">
	          <iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?q='.$address.'&amp;ie=UTF8&amp;hq=&amp;hnear='.$address.'&amp;gl=in&amp;z=11&amp;vpsrc=0&amp;output=embed">              </iframe>
		    </div>';
			
	echo $after_widget; 
		
		}
	
	

	}

add_action('widgets_init', create_function('', 'return register_widget("IOAGoogleMap");'));

/* == Custom Box Widget ================================================================ */



class IOACustomBoxWidget extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'CustomBox', 'description' => __(' Create a custom text box with read more link and image.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("CustomBox",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['link']= $new_instance['link']; 
			$instance['label']= $new_instance['label']; 
			$instance['description']= $new_instance['description'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		$link = $label = $description = $title = $intro_image_link = '';

		if(isset($instance['link'])) $link = esc_attr($instance['link']);
		if(isset($instance['label'])) $label = esc_attr($instance['label']);
		if(isset($instance['description'])) $description = $instance['description'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['intro_image_link'])) $intro_image_link = esc_attr($instance['intro_image_link']); 
		
		if(trim($label)=="") $label = __('more','ioa');
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
         <div class="ioa-upload-field ">
			<label for="<?php echo $this->get_field_id( 'intro_image_link' ); ?>"><?php _e('Intro Image Link: ( if empty image not will appear )', 'ioa') ?></label>
            	<div class="clearfix">
    	        	<a href="#" class="button image_upload" data-title="Add To Widget" data-label="Add To Widget"> <?php _e('Upload','ioa') ?> </a>
					<input class="widefat widget_text" id="<?php echo $this->get_field_id( 'intro_image_link' ); ?>" name="<?php echo $this->get_field_name( 'intro_image_link' ); ?>" value="<?php echo $intro_image_link; ?>" type="text" /> 
	            </div>
		</div>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'ioa') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $description; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Link:( if empty link will not appear )', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $link; ?>" type="text" />
		</p>
        
        <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'label' ); ?>"><?php _e('Label for button', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'label' ); ?>" name="<?php echo $this->get_field_name( 'label' ); ?>" value="<?php echo $label; ?>" type="text" />
		</p>
		
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$label = esc_attr($instance['label']);
	$description = $instance['description'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$intro_image_link = esc_attr($instance['intro_image_link']); 
	
	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
		
	if(trim($intro_image_link)=="")
	$img = '';
	else
	$img = "<img src='{$intro_image_link}' alt='custom-box-image' />";
		
	echo " <div class='clearfix custom-box-content' itemscope itemtype='http://schema.org/Text'> $img  ".do_shortcode(wpautop($description))." </div>  ";
		
	if(trim($link)!="")
	echo "<a href='{$link}' class='more custom-font thunder_button' itemprop='url'> $label </a>";
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOACustomBoxWidget");'));

// == Facebook Like ==========================================================


class IOAFBLike extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOAFBLike', 'description' => __('Add facebook Like box to your sidebar.','ioa') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::WP_Widget(false,__("Facebook Like Box",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['fb_link']= strip_tags($new_instance['fb_link']); 
			$instance['title']= strip_tags($new_instance['title']);
			$instance['show_friends']= $new_instance['show_friends'];
			$instance['fb_header']= $new_instance['fb_header'];
			$instance['fb_stream']= $new_instance['fb_stream'];
			
			 
			return $instance;
	}
	function form($instance) {
		 $fb = $title = $width = $friends = $header = $stream = '';

		if(isset($instance['fb_link'])) $fb = esc_attr($instance['fb_link']);
		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['show_friends'])) $friends = $instance['show_friends'];
		if(isset($instance['fb_header'])) $header = $instance['fb_header'];
		if(isset($instance['fb_stream'])) $stream = $instance['fb_stream'];
		
		if($fb==""&&get_option("ami_fb_id"))
		$fb = get_option("ami_fb_id");
		
		
		 ?>
        
        
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('fb_link'); ?>"> <?php _e('Add facebook page link','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('fb_link'); ?>" name="<?php echo $this->get_field_name('fb_link'); ?>" type="text" value="<?php echo $fb; ?>" />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('show_friends'); ?>"> <?php _e('Show friends','ioa'); ?> </label>
		<input id="<?php echo $this->get_field_id('show_friends'); ?>" name="<?php echo $this->get_field_name('show_friends'); ?>" type="checkbox" value="true" <?php if($friends) echo "checked='checked'"; ?> />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('fb_header'); ?>"> <?php _e('Show Head','ioa'); ?> </label>
		<input id="<?php echo $this->get_field_id('fb_header'); ?>" name="<?php echo $this->get_field_name('fb_header'); ?>" type="checkbox" value="true" <?php if($header) echo "checked='checked'"; ?> />
		</p>
        
         <p> 
        <label for="<?php echo $this->get_field_id('fb_stream'); ?>"> <?php _e('Show Stream','ioa'); ?> </label>
		<input id="<?php echo $this->get_field_id('fb_stream'); ?>" name="<?php echo $this->get_field_name('fb_stream'); ?>" type="checkbox" value="true" <?php if($stream) echo "checked='checked'"; ?> />
		</p>
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
		$fb = esc_attr($instance['fb_link']);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$friends = $instance['show_friends'];
		$header= $instance['fb_header'];
		$stream= $instance['fb_stream'];
	    
	    $height = 100;

	    if($friends=="true") $height +=200;
	    if($stream=="true") $height +=300;

		echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
		?>
		
       <div class="facebookOuter">
		<div class="facebookInner">
       		 <div class="fb-widget">
				<iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo $fb; ?>&amp;width=270&amp;height=<?php echo $height; ?>&amp;show_faces=<?php if($friends) echo $friends; else echo 'false'; ?>&amp;colorscheme=light&amp;stream=<?php if($stream) echo $stream; else echo 'false'; ?>&amp;border_color&amp;header=<?php if($header) echo $header; else echo 'false'; ?>&amp;appId=165111413574616"  style="border:none; overflow:hidden; width:270px; height:<?php echo $height; ?>px;" ></iframe>
        	</div>
       </div> </div>
        
		<?php
			echo $after_widget; 
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOAFBLike");'));

/* == Posts ================================================= */



class IOACustomPostW extends WP_Widget {
	
	function IOACustomPostW() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOACustomPostW', 'description' => __('Create and show custom posts or any filtered variation.','ioa') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::WP_Widget(false,__("Custom Posts",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['count']= strip_tags($new_instance['count']); 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['post_type']= strip_tags($new_instance['post_type']); 
			$instance['post_filter']= strip_tags($new_instance['post_filter']); 
			$instance['excerpt']= strip_tags($new_instance['excerpt']); 
			return $instance;
	}
	function form($instance) {
		global $ioa_registered_posts;
		 $count = $title = $post_type = $post_filter = $excerpt = '';

		if(isset($instance['count'])) $count = esc_attr($instance['count']);
		if(isset($instance['title'])) $title = $instance['title'];
		if(isset($instance['post_type'])) $post_type = $instance['post_type'];	
		if(isset($instance['post_filter'])) $post_filter = $instance['post_filter'];	
		if(isset($instance['excerpt'])) $excerpt = $instance['excerpt'];	
	    $excerpt = trim($excerpt=="") ? 90 : $excerpt ;
		 ?>
        
        <div class="ioa-query-box clearfix"> 

        <p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('post_type'); ?>"> <?php _e('Post Type','ioa'); ?> </label>
		<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>" class='post_type'>
		 <?php 
		 $array = array("post");
		 foreach ($ioa_registered_posts as $cp) {
		 	if( $cp->getPostType()!="slider" &&  $cp->getPostType()!="custompost")
		 	$array[] = $cp->getPostType();
		 }
		 foreach($array as $val){
		 
		 if($val==$post_type)
		 echo "<option value='$val' selected>$val</option>";
		 else
		 echo "<option value='$val'>$val</option>";
		 
		 }
		 ?>
        </select>
		</p>
        
		 
        <label for="<?php echo $this->get_field_id('post_filter'); ?>"> <?php _e('Posts Filter','ioa'); ?> </label>
		
		<p class="clearfix">
			<input class="widefat" id="<?php echo $this->get_field_id('post_filter'); ?>" name="<?php echo $this->get_field_name('post_filter'); ?>" type="text" value="<?php echo $post_filter; ?>" />
			<a href="" class="query-maker button-default">Add Filter</a>
		</p>
		
		</div>
		
        
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        
		<p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('count'); ?>"> <?php _e('Number of posts to display','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
        
        <p class="hades-custom-media"> 
        <label for="<?php echo $this->get_field_id('excerpt'); ?>"> <?php _e('Enter excerpt Words Limit','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="text" value="<?php echo $excerpt; ?>" />
		</p>
		
           
       
        
        
<?php
		
		 }
	function widget($args, $instance) { 
	global $ioa_helper;
	global $more;
	extract($args); 
	$post_type = $instance['post_type'];	
	$post_filter = $instance['post_filter'];
	$excerpt = $instance['excerpt'];	
	$count = esc_attr($instance['count']);
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
	echo $before_widget;
	if($title!="")
	echo $before_title." ".$title.$after_title;
		
		?>

   <ul class="widget-posts clearfix" >
                          
    <?php 
   
    $qr = explode('&',$post_filter);
    $custom_tax = array( );
     $filter = array();

     foreach($qr as $q)
     {
      if(trim($q)!="")
      {
        $temp = explode("=",$q);
        $filter[$temp[0]] = $temp[1];
        if($temp[0]=="tax_query")
        {
        	$vals = explode("|",$temp[1]); 	
        	$custom_tax[] = array(
        			'taxonomy' => $vals[0],
					'field' => 'id',
					'terms' => explode(",", $vals[1])

        		);
        }
      }
     }


		
    $ioa_options = array(
			'post_type' => $post_type, 
			'posts_per_page' => $count
			);
    $filter['tax_query'] = $custom_tax;
		
	
	$popPosts = new WP_Query(array_merge($ioa_options,$filter ));
	
	
	
	
    while ($popPosts->have_posts()) : $popPosts->the_post();  $more = 0; ?>
    
    <li class="clearfix <?php echo join(' ',get_post_class('', get_the_ID())); ?>" itemscope itemtype="http://schema.org/Article" >
    
     
      <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
      <div class="image">
      <?php 
            $id = get_post_thumbnail_id();
            $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
            echo $ioa_helper->imageDisplay( array( "src" => $ar[0]  , "width" => 50 , "height" => 50 , "link"=> get_permalink() , "lightbox" => false , "imgclass" => "thunder_image" , 'imageAttr' => 'alt="'.get_the_title().'"')  ); 
      ?>
      </div><!--image-->
      <?php  else : ?>
       <div class="image">
          <?php $ioa_helper->getHelperDisplay(get_the_ID()); ?>
        </div>

      <?php endif; ?>
    
      <div class="description <?php if ( ! has_post_thumbnail() && get_post_format()=="standard" ) echo 'full-desc'; ?>">
          <h5 itemprop="title"><a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
         <p class='clearfix' itemprop="description"> <?php echo $ioa_helper->getShortenContent($excerpt,strip_tags(strip_shortcodes(get_the_content()))); ?></p>
         
      </div><!--details-->
    </li>
    
    <?php endwhile; ?>
    
    

    </ul>
					
					
		<?php
			echo $after_widget; 
		
		}
		
	
	
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOACustomPostW");'));


/**
 * Custom Posts Grid
 */



class IOACustomPostGrid extends WP_Widget {
	
	function IOACustomPostGrid() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOACustomPostGrid', 'description' => __('Create and show Posts Grid.','ioa') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200);
		 parent::WP_Widget(false,__("Custom Posts Grid",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['post_type']= strip_tags($new_instance['post_type']); 
			$instance['post_filter']= strip_tags($new_instance['post_filter']); 
			$instance['count']= strip_tags($new_instance['count']); 
			return $instance;
	}
	function form($instance) {
		global $ioa_registered_posts;
		 $count = $title = $post_type = $post_filter = $excerpt = '';

		if(isset($instance['title'])) $title = $instance['title'];
		if(isset($instance['post_type'])) $post_type = $instance['post_type'];	
		if(isset($instance['post_filter'])) $post_filter = $instance['post_filter'];	
		if(isset($instance['count'])) $count = esc_attr($instance['count']);

		 ?>
        
        <div class="ioa-query-box clearfix"> 

        <p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('post_type'); ?>"> <?php _e('Post Type','ioa'); ?> </label>
		<select name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php echo $this->get_field_id('post_type'); ?>" class='post_type'>
		 <?php 
		 $array = array("post");
		 foreach ($ioa_registered_posts as $cp) {
		 	if( $cp->getPostType()!="slider" &&  $cp->getPostType()!="custompost")
		 	$array[] = $cp->getPostType();
		 }
		  if( IOA_WOO_EXISTS ) $array[] = 'product';
		 foreach($array as $val){
		 
		 if($val==$post_type)
		 echo "<option value='$val' selected>$val</option>";
		 else
		 echo "<option value='$val'>$val</option>";
		 
		 }
		

		 ?>
        </select>
		</p>

		
        
		 
        <label for="<?php echo $this->get_field_id('post_filter'); ?>"> <?php _e('Posts Filter','ioa'); ?> </label>
		
		<p class="clearfix">
			<input class="widefat" id="<?php echo $this->get_field_id('post_filter'); ?>" name="<?php echo $this->get_field_name('post_filter'); ?>" type="text" value="<?php echo $post_filter; ?>" />
			<a href="" class="query-maker button-default">Add Filter</a>
		</p>
		
		</div>

		<p class="ioa-media"> 
        <label for="<?php echo $this->get_field_id('count'); ?>"> <?php _e('Number of posts to display','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
		
        
        
        <p class="ioa-media"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        
<?php
		
		 }
	function widget($args, $instance) { 
	global $ioa_helper;
	global $more;
	extract($args); 
	$post_type = $instance['post_type'];	
	$post_filter = $instance['post_filter'];
	$count = $instance['count'];	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
	echo $before_widget;
	if($title!="")
	echo $before_title." ".$title.$after_title;
		
		?>

   <div class="widget-posts-grid clearfix" >
                          
    <?php 
   
    $qr = explode('&',$post_filter);
    $custom_tax = array(
                 array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-quote','post-format-chat', 'post-format-image','post-format-audio','post-format-status','post-format-aside','post-format-video','post-format-gallery','post-format-link'),
                    'operator' => 'NOT IN'
                  ),

             );
     $filter = array();

     foreach($qr as $q)
     {
      if(trim($q)!="")
      {
        $temp = explode("=",$q);
        $filter[$temp[0]] = $temp[1];
        if($temp[0]=="tax_query")
        {
        	$vals = explode("|",$temp[1]); 	
        	$custom_tax[] = array(
        			'taxonomy' => $vals[0],
					'field' => 'id',
					'terms' => explode(",", $vals[1])

        		);
        }
      }
     }


		
	$ioa_options = array(

		'post_type' => $post_type, 
		'posts_per_page' => $count
	);
	$filter['tax_query'] = $custom_tax;


	$popPosts = new WP_Query(array_merge($ioa_options,$filter ));


	$i=0; 

	while ($popPosts->have_posts()) : $popPosts->the_post(); ?>
	
		<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : /* if post has post thumbnail */ ?>
		<div class="image">
		<?php 
		$id = get_post_thumbnail_id();
		$ar = wp_get_attachment_image_src( $id , array(9999,9999) );
		echo $ioa_helper->imageDisplay( array( "src" => $ar[0]  , "width" => 150 , "height" => 150 , "link"=> get_permalink() , "lightbox" => false  , 'imageAttr' => 'alt="'.get_the_title().'"')  ); 
	?>
	<h3><?php the_title(); ?></h3>
	</div><!--image-->
	<?php endif; ?>



	<?php $i++; endwhile; ?>

	</div>

	<?php
	echo $after_widget; 
		
		}
		
	
	
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOACustomPostGrid");'));


// == Dribbble =============================================


class IOADribbbble extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOADribbbble', 'description' => __( 'Dribbble Widget.','ioa') );

		/* Widget control settings. */
		$control_ops = array( "width"=>200);
		 parent::WP_Widget(false,__( "Dribbble Widget" ,'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']); 
			$instance['username']= strip_tags($new_instance['username']); 
		
			return $instance;
	}
	function form($instance) {
		 $title = $username = $nos = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']);
		if(isset($instance['username'])) $username = esc_attr($instance['username']);
	  
		if(isset($instance['nos'])) $nos = esc_attr($instance['nos']);
		 ?>
        
       
		<p class="hades-custom"> 
        <label for="<?php echo $this->get_field_id('title'); ?>"> <?php _e('Title','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
        <p> 
        <label for="<?php echo $this->get_field_id('username'); ?>"> <?php _e('Username','ioa'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
		</p>
     
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$username = esc_attr($instance['username']);
	 
	$count = 5;
	
	
	
		echo $before_widget; 
		
			if($title!="")
		echo $before_title." ".$title.$after_title;
	
	$data = array();

	if(get_transient(SN.'_dribbble_data'))
	{
		$data = get_transient(SN.'_dribbble_data');
	}
	else
	{
		$data = wp_remote_get('http://api.dribbble.com/players/'.$username.'/shots');
		$data = json_decode($data['body'],true);
		if(isset($data['message']) && $data['message'] =="Not found" )
		{
			_e("Something's Wrong",'ioa');
		}
		else
			set_transient(SN.'_dribbble_data',$data);
	}	


	$shots = "<div class='dribble_widget_media widget-posts-grid clearfix' itemscope itemtype='http://schema.org/ImageGallery'>";
	$i=0;

	if(isset($data['shots']) && is_array($data['shots']) )
	foreach($data['shots'] as $shot)
	{
		if($i>=$count) break;
		
			$shots .=  "<div class='image'><a itemprop='url' class='sub-image' href='".$shot['url']."' title='".$shot['title']."'><img src='".$shot['image_url']."' /></a><h3>".$shot['title']."</h3></div>";

		$i++;
	}

	echo $shots."</div>";
	echo $after_widget; 
		
		}
	
	


	}

add_action('widgets_init', create_function('', 'return
register_widget("IOADribbbble");'));

// == Social Set ========================================================

class IOAIconSet extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOAIconSet', 'description' => __('Creates a list with icon.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("IOAIconSet",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			$instance['title']= $new_instance['title']; 
			$instance['social_data']= $new_instance['social_data']; 
			return $instance;
	}
	function form($instance) {
	
	$title = $social_data = '';
	 
	
	if(isset($instance['title'])) $title = esc_attr($instance['title']);
	if(isset($instance['social_data'])) $social_data = $instance['social_data'];
	
		?>
    
       
       	<p class="hades-custom">
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>
        
 
        <?php

       $ainputs = array(
          array( 
              "label" => __("Enter Link",'ioa') , 
              "name" => "social_link" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Enter Label(if empty tooltip wont appear)",'ioa') , 
              "name" => "social_label" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Icon Hover Color",'ioa') , 
              "name" => "social_color" , 
              "default" => "" , 
              "type" => "colorpicker",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Set Icon",'ioa') , 
              "name" => "social_icon" , 
              "default" => "" , 
              "type" => "text",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a><a class="button-default image_iupload">Add Image Icon</a>'  ,
              "value" => ""   , "class" => "has-two-buttons"
          )     

      );
			
	  echo getIOAInput(array( 
					'inputs' => $ainputs, 
					'label' => __('Social Icons','ioa'),  
					'name' => $this->get_field_name( 'social_data' ),
					'type'=>'module',
					'unit' => __(' Icon','ioa') ,
					'value' => $social_data
					));	
 
 
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			
	$social_data = esc_attr($instance['social_data']);
	
	echo $before_widget;
	if($title!="")
		echo $before_title." ".$title .$after_title;

	?>
	
    
    <div class="social-set clearfix">
        <ul class="social-icons clearfix">
			<?php 


				 $tab_data = array();
                $si = array();


                if( isset($social_data) && $social_data!="" ) :
                   $tab_data = $social_data;
                   $tab_data = explode('[ioa_mod',$tab_data);

                   foreach ($tab_data as $key => $value) {

                     if($value!="")
                     {
                        $inpval = array();
                        $mods = explode('[inp]', $value); 

                         foreach($mods as $m)
                         {

                             if($m!="")
                              {
                              $te = (explode('[ioas]',$m));  
                              if( count($te) == 1 ) $te = (explode(';',$m));  

                              if(isset($te[1]))
                              $inpval[$te[0]] =   $te[1]  ; 

                              }

                           }
                           $si[] = $inpval;
                      } 
                     } 


                endif; 

                foreach($si as $item)
	              {
	                 $tooltip = '';

	                 if($item['social_label']!="") $tooltip = '<span class="social-tooltip"><i class="up-diricon- ioa-front-icon"></i> '.$item['social_label'].' </span>';

	                 if( strpos($item['social_icon'],'ioa-front-icon') !== false ) 
	                  echo "<li>
	              				<a href='".$item['social_link']."'>
	              					<span class='".$item['social_icon']." social-block visible-block'></span>
	              					<span class='hover-block social-block ".$item['social_icon']."' style='background-color:".$item['social_color']."'></span>
	              				</a> $tooltip
	              			</li>";
	                 else
	                  echo "<li><span class='image-icon' href='".$item['social_link']."' style='background-image:url(".$item['social_icon'].")'></span> $tooltip</li>";
	              } 
			 ?>


        </ul>
    </div>
	
	<?php
	
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOAIconSet");'));


// == Video Box ============================

class IOAVideoBox extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Video', 'description' => __(' Add youtube/vimeo/html5 to widget areas.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("IOAVideoBox",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['link']= $new_instance['link']; 
			$instance['description']= $new_instance['description'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['type']= strip_tags($new_instance['type']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		$link = $label = $description = $title = $intro_image_link = '';

		if(isset($instance['link'])) $link = esc_attr($instance['link']);
		if(isset($instance['description'])) $description = $instance['description'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['type'])) $type = esc_attr($instance['type']); 
		
		if(trim($label)=="") $label = 'more &rarr;';
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
         <p class="">
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('type:', 'ioa') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" >
				<?php $opts = array("YouTube","Vimeo"); 
				$str = '';
				foreach($opts as $o)
				{
					if($type==$o)
						$str .= "<option selected='selected' value='{$o}'>$o</option>";
					else
						$str .= "<option value='{$o}'>$o</option>";
				}
				echo $str;
				?>
			</select>
		</p>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'ioa') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $description; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Video Link', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $link; ?>" type="text" />
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$description = $instance['description'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$type = esc_attr($instance['type']); 
	
	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title."<div class='video-wrap' itemscope itemtype='http://schema.org/VideoObject'>";
		
	switch($type)
	{
		case "YouTube" :
		case "Vimeo" : echo do_shortcode("[video width='250' height='250']{$link}[/video]");
	}	
	echo " <p class='clearfix caption' itemprop='description'>   ".stripslashes($description)." </p> </div> ";
		
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOAVideoBox");'));


// == Image Box ============================

class IOAImageBox extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOAImageBox', 'description' => __(' Add images to widget areas.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("ImageBox",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['link']= $new_instance['link']; 
			$instance['description']= $new_instance['description'];
			$instance['resize']= $new_instance['resize'];
			$instance['title']= strip_tags($new_instance['title']);
			$instance['intro_image_link']= strip_tags($new_instance['intro_image_link']);
			return $instance;
	}
	function form($instance) {
		$link = $label = $description = $title = $intro_image_link = '';

		if(isset($instance['link'])) $link = esc_attr($instance['link']);
		if(isset($instance['description'])) $description = $instance['description'];
		if(isset($instance['resize'])) $resize = $instance['resize'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['intro_image_link'])) $intro_image_link = esc_attr($instance['intro_image_link']); 
		
		if(trim($label)=="") $label = 'more &rarr;';
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
       

		<p class="">
			<label for="<?php echo $this->get_field_id( 'resize' ); ?>"><?php _e('resize:', 'ioa') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'resize' ); ?>" name="<?php echo $this->get_field_name( 'resize' ); ?>" >
				<?php $opts = array("Yes","No"); 
				$str = '';
				foreach($opts as $o)
				{
					if($resize==$o)
						$str .= "<option selected='selected' value='{$o}'>$o</option>";
					else
						$str .= "<option value='{$o}'>$o</option>";
				}
				echo $str;
				?>
			</select>
		</p>
		
		<div class="ioa-upload-field ">
			<label for="<?php echo $this->get_field_id( 'intro_image_link' ); ?>"><?php _e(' Image URL: ( Ideal size 250 x 300 px )', 'ioa') ?></label>
            	<div class="clearfix">
    	        	<a href="#" class="button image_upload" data-title="Add To Widget" data-label="Add To Widget"> <?php _e('Upload','ioa') ?> </a>
					<input class="widefat widget_text" id="<?php echo $this->get_field_id( 'intro_image_link' ); ?>" name="<?php echo $this->get_field_name( 'intro_image_link' ); ?>" value="<?php echo $intro_image_link; ?>" type="text" /> 
	            </div>
		</div>

		
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text', 'ioa') ?></label>
			<textarea  class="widefat" style="height:200px;" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo  $description; ?></textarea>
		</p>
		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e(' Link', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $link; ?>" type="text" />
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	global $ioa_helper;
	extract($args); 
	
	$link = esc_attr($instance['link']);
	$description = $instance['description'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$resize = $instance['resize'];
	$intro_image_link = esc_attr($instance['intro_image_link']); 
	$pw  = true;
	if($link=="") $pw = false;

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;

	echo "<div class='ioa-image-wrap' itemscope itemtype='http://schema.org/ImageObject'>";
	
	$str = '';

	switch($resize)
	{
		case "Yes" : echo $ioa_helper->imageDisplay( array( "width" =>270 , "height" => 270 , "link" => $link , "parent_wrap" => $pw , "src" => $intro_image_link ) ); break;
		case "No" :  $str = "<img src='".$intro_image_link."' alt='sidebar image' itemprop='image' />"; 
					 if($pw) echo "<a href='".$link."'>".$str."</a>";
					 else echo $str;
	}	
	echo " <p class='clearfix caption' itemprop='description'>   ".stripslashes($description)." </p> </div> ";
		
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOAImageBox");'));


// == Testimonial Box ============================

class IOATestimonial extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOATestimonial', 'description' => __(' Add Single Testimonial Here.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("Testimonial",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']);
			$instance['tid']= strip_tags($new_instance['tid']);
			return $instance;
	}
	function form($instance) {
		 $title = $tid = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		if(isset($instance['tid'])) $tid = esc_attr($instance['tid']); 
		

		$query = new WP_Query("post_type=testimonial&posts_per_page=-1&post_status=publish");  
		$testi = array();
		while ($query->have_posts()) : $query->the_post(); 
				$testi[get_the_ID()] = get_the_title();
		endwhile; 


		
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
       

		
		 <p class="hades-custom">
			<label for="<?php echo $this->get_field_id( 'tid' ); ?>"><?php _e('Testimonial ID', 'ioa') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'tid' ); ?>" name="<?php echo $this->get_field_name( 'tid' ); ?>">
				<?php 
				foreach($testi as $key => $val){
		 
					 if($key==$tid)
					 echo "<option value='$key' selected>$val</option>";
					 else
					 echo "<option value='$key'>$val</option>";
					 
					 }
				 ?>
			</select>	
		</p>
     
<?php
		
		 }
	function widget($args, $instance) { 
	global $ioa_helper;
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	$tid = esc_attr($instance['tid']); 
	

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
	
	?>

	  <div class="testimonial-bubble" itemscope itemtype='http://schema.org/Review'>
       <?php  if(isset($tid)) : $tpost = get_post($tid);
        
          ?> 
           
           <div class="testimonial-bubble-content" itemprop='review' >
              <?php echo $tpost->post_content  ?>
                 <i class="icon icon-caret-down" ></i>
           </div> 

           <div class="testimonial-bubble-meta clearfix">
             
                <?php   if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail($tid)))  : ?>   
              
                <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id($tid);
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>50 , "width" =>50 , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
              </div>

            <?php endif;
              ?>

              <div class="info">
                      <h2 class="name" itemprop="author"> <?php echo get_the_title($tid); ?></h2> 
                      <?php  if(get_post_meta($tid,'design',true)!="")  echo "<span class='designation'>".get_post_meta($tid,'design',true)."</span>" ?>
                    </div>
                    
              </div>

        <?php endif; ?>
    </div>

    <?php
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOATestimonial");'));


class IOA_Testimonial_Slider extends WP_Widget {
	
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Testimonial Slider', 'description' => __(' Add Testimonials Slider Here.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("Testimonial Slider",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['title']= strip_tags($new_instance['title']);
			return $instance;
	}
	function form($instance) {
		 $title = $tid = '';

		if(isset($instance['title'])) $title = esc_attr($instance['title']); 
		
		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
     

     
<?php
		
		 }
	function widget($args, $instance) { 
	global $ioa_helper;
	extract($args); 
	
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	

	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
	
	$opts = array('posts_per_page' => -1,'post_type'=>'testimonial', 'order' => "DESC" , 'orderby' => 'date');
	?>
	 <div class="testimonials-wrapper">	
	 <ul class="rad-testimonials-list clearfix"   itemscope itemtype="http://schema.org/Review">          
        <?php $query = new WP_Query($opts); $ioa_meta_data['i']=0;   $i=0;while ($query->have_posts()) : $query->the_post(); 
       
          ?> 
       <?php  
      
     	if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true; 	?>
          
        <li class="clearfix <?php if($i==0) echo 'active'; ?>" style="border:none">
				<div class="desc">
        	        <div class="content clearfix" itemprop="description" >
 					      	<i class="icon icon-sort-down" ></i>
                      		<?php the_content() ?>
                  	</div>
           		</div>
           		
                <div class="clearfix">
                <?php if ( $ioa_meta_data['hasFeaturedImage']) : ?>   
              
               	 <div class="image">
                  
                  <?php
                  $id = get_post_thumbnail_id();
                  $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
           
                  echo $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>50 , "width" => 50 , "parent_wrap" => false ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
                  ?>
                </div>

           	     <?php endif;   ?>

               <div class="info">
                      <h2 class="name" itemprop="name"> <?php the_title(); ?></h2> 
                      <?php  if(get_post_meta(get_the_ID(),'design',true)!="")  echo "<span class='designation'>".get_post_meta(get_the_ID(),'design',true)."</span>" ?>
                    </div>
                    
              </div>
              
                 
               
        </li>

        <?php $i++; endwhile; ?>
    </ul>
	</div> 
    <?php
		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOA_Testimonial_Slider");'));

/**
 * Adsense Widget
 */



class IOAAdsense extends WP_Widget {
	
	function IOAAdsense() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'IOAAdsense', 'description' => __(' Create a adsense code area.','ioa') );

		/* Widget control settings. */
		$control_ops = array(  );
		 parent::WP_Widget(false,__("Ad Adsense",'ioa'),$widget_ops,$control_ops); }
	
	function update($new_instance, $old_instance) {
			$instance = $old_instance; 
			
			$instance['google_ad_client']= $new_instance['google_ad_client'];
			$instance['google_ad_slot']= $new_instance['google_ad_slot'];
			$instance['width']= $new_instance['width'];
			$instance['height']= $new_instance['height'];
			$instance['title']= strip_tags($new_instance['title']);
			
			return $instance;
	}
	function form($instance) {
		$google_ad_slot = $google_ad_client = $title = '';

		if(isset($instance['google_ad_client'])) $google_ad_client = $instance['google_ad_client'];
		if(isset($instance['google_ad_slot'])) $google_ad_slot = $instance['google_ad_slot'];
		if(isset($instance['width'])) $width = $instance['width'];
		if(isset($instance['height'])) $height = $instance['height'];
		if(isset($instance['title'])) $title = esc_attr($instance['title']); 

		?>
    
       
       	 <p class="">
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" type="text" />
		</p>
    

		
		<p>
			<label for="<?php echo $this->get_field_id( 'google_ad_client' ); ?>"><?php _e('Enter Google Ad Client', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google_ad_client' ); ?>" name="<?php echo $this->get_field_name( 'google_ad_client' ); ?>" value="<?php echo $google_ad_client; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'google_ad_slot' ); ?>"><?php _e('Enter Google Ad Slot', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'google_ad_slot' ); ?>" name="<?php echo $this->get_field_name( 'google_ad_slot' ); ?>" value="<?php echo $google_ad_slot; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Enter Ad Width', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $width; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Enter Ad Height', 'ioa') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $height; ?>" type="text" />
		</p>
		
		
<?php
		
		 }
	function widget($args, $instance) { 
	
	extract($args); 
	
	$google_ad_client = $instance['google_ad_client'];
	$google_ad_slot = $instance['google_ad_slot'];
	$height = $instance['height'];
	$width = $instance['width'];
	$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
	
	echo $before_widget;
		if($title!="")
		echo $before_title." ".$title.$after_title;
		
		
	echo " <div class='clearfix custom-box-content' itemscope itemtype='http://schema.org/Text'>  "
	?>
	<script type="text/javascript"><!--
	google_ad_client = "<?php echo $google_ad_client; ?>"; 
	google_ad_slot = "<?php echo $google_ad_slot; ?>"; 
	google_ad_width = <?php echo $width; ?>;
	google_ad_height = <?php echo $height; ?>;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php

	echo " </div>  ";
		

		
	echo  $after_widget;
		
		}
	
	}

add_action('widgets_init', create_function('', 'return
register_widget("IOAAdsense");'));



/**
 * Search widget class
 *
 * @since 2.8.0
 */
class DWP_Widget_Search extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'DWP_Widget_Search', 'description' => __( "A search form for your site",'ioa') );
		parent::__construct('search', __('Styled Search','ioa'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		?>
		<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		    <div>
		        <div class="search-input">
		        	<input type="text" value="" name="s" id="s" placeholder="<?php _e('What are you looking for ?','ioa') ?>"  />
		        </div>
		        <input type="submit" id="searchsubmit" value="" />
		        <a href='' class="proxy-search search-3icon- ioa-front-icon"></a>
		    </div>
		</form>
		<?php

		echo $after_widget;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
?> 
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','ioa'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

}

add_action('widgets_init', create_function('', 'return
register_widget("DWP_Widget_Search");'));
