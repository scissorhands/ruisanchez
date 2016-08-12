<?php 


/**
 * Twitter Shortcode using aouth
 */

function IOAgetTweets($count = 20, $username = false, $ioa_options = false) {
 global $ioa_super_options;	

  require_once(HPATH.'/lib/twitteroauth/twitteroauth.php');
 
  $settings = array(
    'oauth_access_token' => $ioa_super_options[SN.'_twitter_token'],
    'oauth_access_token_secret' => $ioa_super_options[SN.'_twitter_secret_token'],
    'consumer_key' => $ioa_super_options[SN.'_twitter_key'],
    'consumer_secret' => $ioa_super_options[SN.'_twitter_secret_key']
  );
  $data =array();

  if( get_transient(SN.'_ioa_tweets') ) 
  {
     $data = get_transient(SN.'_ioa_tweets');
  }
  else
  {
    $connection = new TwitterOAuth($ioa_super_options[SN.'_twitter_key'],  $ioa_super_options[SN.'_twitter_secret_key'], $ioa_super_options[SN.'_twitter_token'], $ioa_super_options[SN.'_twitter_secret_token']);
    $data = $connection->get('statuses/user_timeline');
    set_transient(SN.'_ioa_tweets',$data,60*60*3);
  }
 
    $i=0;
    $filter_array = array();
   if( ! isset($data->errors) )
    foreach($data as $d)
    {
     
     if($i>$count) break;
     $filter_array[] = array("text" => $d->text );
     $i++;
    }
   
    return $filter_array;
  }

  function ioa_twitter_shortcode($atts,$content)
{
	global $ioa_helper;
   	
   	extract(
	shortcode_atts(array(  
    "mode" => "list"  , 
		"count" => "5"
		
    ), $atts)); 

   	if($count <=0 ) $count  = 5; // Validation

    $tweets = IOAgetTweets($count);
    
     
    if(isset($tweets['error'])) return '<h4>'.$tweets['error'].'</h4>';
		$str = '<div class="tweets-wrapper '.$mode.'"><ul class="tweets clearfix ">';
		if(is_array($tweets))
		{
			foreach ($tweets as $key => $tweet) {

				$str .= "<li class='clearfix'><i class=\"ioa-front-icon twitter-1icon-\"></i>".preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>',$tweet['text'])."</li>";
			}
		}
		$str .= "</ul></div>";
   

   	return $str;
  }
  add_shortcode('tweets','ioa_twitter_shortcode');





function ioavideoShortcode($atts,$content)
{
  extract(
  shortcode_atts(array(  
        "width" => "300",
    "height" => "250"
    
    ), $atts)); 
  
  
  global $wp_embed;
   
   $temp = str_replace("webkitAllowFullScreen mozallowfullscreen",'', wp_oembed_get(strip_tags(trim($content)),array( "width" => $width , 'height' => $height) ) ); 
   $temp = str_replace('frameborder="0"','', $temp ); 

  
  
  return str_replace(')','',$temp);
}


add_shortcode("video","ioavideoShortcode");
add_shortcode("ioa_video","ioavideoShortcode");


function registerIOASlider($atts,$content)
{
  global $ioa_helper,$ioa_meta_data;
   extract(
    shortcode_atts(array( 
      "id" => ""
      ), $atts)
  );

 

   if($id== "") return "Invalid ID";

   $str = '';

   $slides = get_post_meta($id,'slides',true);
   $ioa_options = get_post_meta($id,'options',true);

   if(! is_array($slides)) $slides = array();
   if(! is_array($ioa_options)) $ioa_options = array();

   $do ='';
   
   $mo = $ioa_helper->getAssocMap($ioa_options,"value");
   

   $ioa_meta_data['slider_options'] = $ioa_options;
   $ioa_meta_data['slider_slides'] = $slides;

   if($mo['slider_type'] == "slider") :

       ob_start();
      get_template_part('templates/shortcodes/ioa_slider');
      $str .= ob_get_contents();
      ob_end_clean();

   elseif($mo['slider_type'] == "gallery") :

       ob_start();
      get_template_part('templates/shortcodes/ioa_gallery');
      $str .= ob_get_contents();
      ob_end_clean();   
      endif;
   
   return $str;

}
add_shortcode("slider","registerIOASlider");


function registerGETMETA($atts)
{

  global $ioa_helper;
   extract(
    shortcode_atts(array( 
      "field" => "" ,
      ), $atts)
  );
  global $post;  

if($field=="") return '';
  $field = str_replace(" ","_",strtolower(trim($field)));

  return get_post_meta(get_the_ID(), $field,true); 
   
}
add_shortcode('get','registerGETMETA');




/**
 * Scrollable
 */

function registerPostIScrollable($atts)
{
   extract(
    shortcode_atts(array(  
      "post_type" => 'post',
      "no" => 5,
      "ioa_query" => "",
      "width" => 250,
      "height" => 180,
      "margin" => 20
  ), $atts));
  
 global $ioa_helper,$ioa_meta_data,$ioa_portfolio_slug;
  
  $opts = array();

  $filter = $ioa_helper->ioaquery($ioa_query);

    $opts = array(
      
      'post_type' => $post_type, 
      'posts_per_page' => $no
      );

    $opts = array_merge($opts,$filter);
   

    $ioa_meta_data['post_type'] = $post_type;
    $ioa_meta_data['height'] = 180;
    $ioa_meta_data['width'] = 250;
    $ioa_meta_data['hasFeaturedImage'] = false; 
    $ioa_meta_data['i'] = 0;

    $data = '<div class="shortcode-scrollable"><div style="height:'.$height.'px;" class="scrollable hoverable clearfix" data-margin="'.$margin.'" itemscope itemtype="http://schema.org/ItemList">';

    $query = new WP_Query($opts); 
    while ($query->have_posts()) : $query->the_post();  
      
    
       if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail()))  $ioa_meta_data['hasFeaturedImage'] = true;           
          
        $data .= '<div class="clearfix hover-item slide" style="width:'.$width.'px" itemscope itemtype="http://schema.org/Article">';
            
             $ar = ''; 
             if($ioa_meta_data['hasFeaturedImage']) :
              
                $data .='<div class="image">';
               
                $id = get_post_thumbnail_id();
                $ar = wp_get_attachment_image_src( $id , array(9999,9999) );
            
                  $data .= $ioa_helper->imageDisplay(array( "src" => $ar[0] , "height" =>$height , "width" => $width , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
              

                $hover = '';
                  ob_start();
                  $ioa_helper->getHover(array( "id" => get_the_ID(),  "link" => true , "image" => $ar[0]  , 'format' => 'auto' ) );
                  $hover = ob_get_contents();
                 ob_end_clean();  
               
                 $data .= $hover;
  
              $data .=  ' </div>';
              endif;  

              
              $data .= '</div> ';
     
    endwhile; 
   
  return $data."</div></div>";
  
}

add_shortcode("post_scrollable","registerPostIScrollable");





/**
 * Toggle
 */

function registerSingleToggle($atts,$content)
{
  global $ioa_helper;
  extract(
  shortcode_atts(array(  
        "title" => 'Your Question',
    'collapse' => "collapse"
      ), $atts)); 
  $content = $ioa_helper->format($content);
  $state = '';
  $id =  uniqid('tg');
  $icon = "plus-squaredicon-";
  if($collapse=="collapse")
  {
     $collapse = 'collapse';
  } else 
  {
    $collapse= 'open';  $icon = "minus-squaredicon-"; $state = ' title-active ';
  }
    
  $tab =  " <div class='toggle' itemscope itemtype='http://schema.org/Thing'><a href=\"#{$id}\" class='toggle-title $state' itemprop='name'  > <i class='ioa-front-icon  $icon'></i> ".stripslashes($title)."</a><div id='{$id}' itemprop='description' class='toggle-body $collapse'> $content</div> </div>";
  return $tab;
}

add_shortcode("toggle","registerSingleToggle");




/**
 * Radial Progress Counter
 */

function registerRadialChart($atts,$content)
{
  extract(
  shortcode_atts(array(  
    "width" => 100,     
    "percent" => 60,
    "size" => 10,
    "bar_color" => "",
    "track_color" => "",
      ), $atts)); 
  
 
  $data = "<div class='radial-chart' data-size='{$size}' data-bar_color='{$bar_color}' data-track_color='{$track_color}' data-start_percent='{$percent}' data-percent='0'  data-width='$width' itemscope itemtype='http://schema.org/Dataset'  ><span>{$content}</span></div>"; 
 

  return $data;
}
add_shortcode("radialchart","registerRadialChart");




/**
 * Icon
 */

function registerIcon($atts,$content)
{
  extract(
  shortcode_atts(array(  
    
    "size"=> '14px',
    "color" => "#ffffff",
    "background" => "",
    "radius" => "3px" ,
    "spacing" => "10px",
    "type" => "blank"
      ), $atts)); 
  
  
  $ic = '';

  

  $ic = "<i style='padding:$spacing;font-size:$size;color:$color;background:$background;border-radius:$radius' class='ioa-front-icon shortcode-icon {$type}'></i>";
  return $ic;
}
add_shortcode("icon","registerIcon");

/**
 * Divider
 */

function registerDivider($atts,$content)
{
  extract(
  shortcode_atts(array(  
    
    "vspace"=> '10px',
    "hspace" => "0px",
    "type" => "default",
    
     ), $atts)); 
  


  $button= "<div class='divider {$type}' style='margin:{$vspace} {$hspace}'></div>";

  return $button;
}
add_shortcode("divider","registerDivider");



// == Google Map =======================================

function registerGoogleshortcodeMap($atts)
{
  extract(
    shortcode_atts(array(  
      "width"=>"300",
      "height"=>"300",
      "address" => '',
      "view" => "m"
  ), $atts)); 
  
  $address = str_replace(" ","+",$address);
  
  return '<div class="google-map" style="width:'.$width.'px;height:'.($height).'px;">
            <iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?q='.$address.'&amp;ie=UTF8&amp;hq=&amp;hnear='.$address.'&amp;gl=in&amp;z=11&amp;vpsrc=0&amp;output=embed&amp;t='.$view.'">              </iframe>
        </div>';
  
}

add_shortcode("map","registerGoogleshortcodeMap");

// == Image =======================================

function registerImageFrame($atts)
{
  extract(
    shortcode_atts(array(  
      "src" => '',
      "resize" => "none",
      "frame" => "none",
      "align" => "none",
      "width" => '100%' ,
      "height" => 250,
      "link" => "",
      "hoverbg" => "#1ed8ee",
      "hoverc" => "#ffffff",
      "effect" => '',
      "effect_delay" => 0,
      "lightbox" => "false"
  ), $atts)); 
  
  global $ioa_helper;

 
 $hover = "";

if($link!='')
{
  ob_start();
   $ioa_helper->getHover(array(  "link" => true , "custom_link" => $link , 'format' => 'link' ) );
    $hover = ob_get_contents();
  ob_end_clean();  
}
 if($lightbox == "true")
 {
   ob_start();
    $ioa_helper->getHover(array( 'image' => $src ,  'format' => 'image' ) );
    $hover = ob_get_contents();
   ob_end_clean();  
 }

 if($link!='' && $lightbox == "true")
 {
    ob_start();
    $ioa_helper->getHover(array(  "link" => true , "image" => $src, "custom_link" => $link  , 'format' => 'icons' ) );
    $hover = ob_get_contents();
   ob_end_clean();  
 }




  $frame = str_replace(" ","-",strtolower(trim($frame))) ; 
  $image = '';
  $listener = '';

  if($effect!="" && strtolower($effect)!="none") $listener = 'way-animated';

  $test = false;
  
  switch($resize)
  {
     case 'hard' : $image = $ioa_helper->imageDisplay(array( "width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     case 'proportional' :   $image = $ioa_helper->imageDisplay(array( "crop" => "proportional" , "width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     case 'wproportional' : $image = $ioa_helper->imageDisplay(array( "crop" => "wproportional" ,"width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     case 'hproportional' : $image = $ioa_helper->imageDisplay(array( "crop" => "hproportional" ,"width" => $width , "height" => $height , "src" => $src , "parent_wrap" => $test , "link" => $link )); break;
     default : $image = "<img src='{$src}' itemprop='url' alt='shortcode image' />";
  }

  return "<div style='width:{$width}px' data-waycheck='$effect' data-delay='$effect_delay' class='$listener hoverable no-canvas hover-item  image-align-{$align}' itemscope itemprop='http://schema.org/ImageObject'> $image  $hover</div>";
  
}

add_shortcode("image","registerImageFrame");



/**
 * Register Column
 */

function registerCol($atts,$content)
{
  global $ioa_helper;
  extract(
    shortcode_atts(array(  
      "width" => "full" ,
      "last" => "false"
  ), $atts)); 

$after ='';
  if($last!="false") 
  {
    $last = "last";
    $after ='<div class="clearfix"></div>';
  }

  return "<div class='$width $last col clearfix'>".do_shortcode($content)."</div>".$after;
}

add_shortcode("col","registerCol");



function registerIOAWPMLSelector($atts,$content)
{

ob_start();
   do_action('icl_language_selector');
    $temp = ob_get_contents();
 ob_end_clean();


 
 return $temp;

}


add_shortcode("wpml_selector","registerIOAWPMLSelector");



 function add_IOAbutton() {  
    
   add_filter('mce_external_plugins', 'registerIOAButtonPlugin');  
   add_filter('mce_buttons', 'registerIOAButton');  
    
}  

function registerIOAButton($buttons) {
   array_push($buttons, "ioabutton");
   return $buttons;
}
function registerIOAButtonPlugin($plugin_array) {
   $plugin_array['button'] = HURL.'/js/ioa_menu.js';
   return $plugin_array;
}

add_action('init', 'add_IOAbutton'); 


/**
 * Image
 */

function registerioa_image($atts,$content)
{
    global $ioa_meta_data;
    extract(
  shortcode_atts(array(  
       "image" => '',
       "text_title" => '',
       "link" => '',
       "lightbox" => '',
       "text_caption" => '',
       "width" => '',
       "height" => '',
       "hoverc" => '',
       "hoverbg" => '',
       "resizing" => '',
       "visibility" => '',
       "delay" => '',
      
    ), $atts)); 

 $code = '';

 $logos = do_shortcode($content); 


 $widget =  array(

    'id' => '',
    'type' => 'rad-image-widget',
    'data' => array(
       
         array( 'name' => 'image' , 'value' => $image ),
         array( 'name' => 'text_title' , 'value' => $text_title ),
         array( 'name' => 'link' , 'value' => $link ),
         array( 'name' => 'lightbox' , 'value' => $lightbox ),
         array( 'name' => 'text_caption' , 'value' => $text_caption ),
         array( 'name' => 'width' , 'value' => $width ),
         array( 'name' => 'height' , 'value' => $height ),
         array( 'name' => 'hoverc' , 'value' => $hoverc ),
         array( 'name' => 'hoverbg' , 'value' => $hoverbg ),
         array( 'name' => 'resizing' , 'value' => $resizing ),
         array( 'name' => 'visibility' , 'value' => $visibility ),
         array( 'name' => 'delay' , 'value' => $delay ),
        
      )

  );   
 
 $ioa_meta_data['widget'] = $widget;
 

  ob_start();
  get_template_part("templates/rad/image");
  $code = ob_get_contents();
  ob_end_clean();
   

 return $code;

  }

add_shortcode("ioa_image","registerioa_image");

/**
 * Button
 */

function registerButton($atts,$content)
{
  extract(
  shortcode_atts(array(  
    
    "size"=> 'normal',
    "color" => "",
    "background" => "",
    "radius" => "3px" ,
    "type" => "default",
    "link" => "#",
    "newwindow" => "true",
    "icon" => ""
      ), $atts)); 
  
  $t = '';

  if($newwindow == "true") $t = "target='_BLANK'";

  $query = '';
  $hi = '';

  if($background!="")
    $query = "background-color:{$background};";

  if($color!="")
    $query = "color:{$color};";

  if($radius!="")
    $query = "border-radius:{$radius};";


  if($icon!="") { 
      $icon = "<i class=' {$icon}'></i>";
      $hi = 'has-icon';
    }

  $button= "<a href='{$link}' $t class='ioa-button size-{$size} $hi style-{$type}' style='$query'><span> $icon ".$content."</span></a>";

  return $button;
}
add_shortcode("button","registerButton");


/**
 * Icon Shortcode
 */

function ioa_icon_shortcode($atts,$content)
{
 global $ioa_helper,$color_scheme_default;

  extract(
  shortcode_atts(array( 
     "icon_type"  => "",
     "icon_class" => "" , 
     "border_color" => "" , 
     "color" => "",
     "background_color" => "" , 

    ), $atts)); 

 $css_str = '';

 if($background_color=="" && ($icon_type ==  'longshadow-style' || $icon_type ==  'longshadow-style-circ' ) ) $background_color = $color_scheme_default['primary_alt_color'];

 if( $color !="" ) $css_str .= "color:".$color.";";
 if( $border_color !="" ) $css_str .= "border-color:".$border_color.";";
 if( $background_color !="" ) $css_str .= "background-color:".$background_color.";";



 if( ($icon_type ==  'longshadow-style' || $icon_type ==  'longshadow-style-circ' ) && trim($background_color)!="" )
  $css_str .=  'text-shadow:'.adjustBrightness($background_color,-50).' 1px 1px,'.adjustBrightness($background_color,-50).' 2px 2px,'.adjustBrightness($background_color,-50).' 3px 3px,'.adjustBrightness($background_color,-50).' 4px 4px,'.adjustBrightness($background_color,-50).' 5px 5px, '.adjustBrightness($background_color,-50).' 6px 6px,'.adjustBrightness($background_color,-50).' 7px 7px,'.adjustBrightness($background_color,-50).' 8px 8px,'.adjustBrightness($background_color,-50).' 9px 9px,'.adjustBrightness($background_color,-50).' 10px 10px,'.adjustBrightness($background_color,-50).' 11px 11px,'.adjustBrightness($background_color,-50).' 12px 12px,'.adjustBrightness($background_color,-50).' 13px 13px,'.adjustBrightness($background_color,-50).' 14px 14px,'.adjustBrightness($background_color,-50).' 15px 15px,'.adjustBrightness($background_color,-50).' 16px 16px,'.adjustBrightness($background_color,-50).' 17px 17px,'.adjustBrightness($background_color,-50).' 18px 18px,'.adjustBrightness($background_color,-50).' 19px 19px,'.adjustBrightness($background_color,-50).' 20px 20px,'.adjustBrightness($background_color,-50).' 21px 21px ,'.adjustBrightness($background_color,-50).' 22px 22px, '.adjustBrightness($background_color,-50).' 23px 23px ,'.adjustBrightness($background_color,-50).' 24px 24px ,'.adjustBrightness($background_color,-50).' 25px 25px ,'.adjustBrightness($background_color,-50).' 26px 26px ,'.adjustBrightness($background_color,-50).' 27px 27px ,'.adjustBrightness($background_color,-50).' 28px 28px, '.adjustBrightness($background_color,-50).' 29px 29px ,'.adjustBrightness($background_color,-50).' 30px 30px  ,'.adjustBrightness($background_color,-50).' 31px 31px  ,'.adjustBrightness($background_color,-50).' 32px 32px  ,'.adjustBrightness($background_color,-50).' 33px 33px  ,'.adjustBrightness($background_color,-50).' 34px 34px  ,'.adjustBrightness($background_color,-50).' 35px 35px ';

$addon = '';

if($background_color!="") $addon = '<span style="background-color:'.$background_color.'"></span>';
else $addon = '<span></span>';

 return '<i style="'.$css_str.'" class="ioa-front-icon '.$icon_class.' '.$icon_type.'"></i>'.$addon;

}


add_shortcode("ioa_icon","ioa_icon_shortcode");


/**
 * Blog Meta Data Shortcodes
 */


function functionpost_author_posts_link($atts)
{
   global $post,$author;
   
   
   return "<a href='".get_author_posts_url(get_the_author_meta( 'ID' ))."'>".get_the_author()."</a>";
}


add_shortcode("post_author_posts_link","functionpost_author_posts_link");


function functionpost_date($atts)
{
   global $post,$author;
   extract(
   shortcode_atts(array( 
       "format"  => "l, F d S, Y"
      
    ), $atts)); 

   if($format == 'default') $format = get_option('date_format');
   
   return '<i class="calendar-emptyicon- ioa-front-icon"></i> '.get_the_time($format);
}


add_shortcode("post_date","functionpost_date");


function functionpost_time($atts)
{
   global $post,$author;
   extract(
   shortcode_atts(array( 
       "format"  => "g:i a"
      
    ), $atts)); 
   
   return '<i class="clock-3icon- ioa-front-icon"></i> '.get_the_time($format);
}


add_shortcode("post_time","functionpost_time");


function functionpost_tags($atts)
{
   extract(
  shortcode_atts(array(  
        "icon" => '<i class="tag-3icon- ioa-front-icon"></i>',
    "sep" => ","
    
    ), $atts)); 

   global $post,$author;
   
   $posttags = get_the_tags($post->ID);

   $str = '';
      if ($posttags) {
         $i=0;
        foreach($posttags as $tag) {
         
         if($i==0)
         $str = $str. '<a rel="tag" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; 
         else
         $str = $str. ' '.$sep.' <a rel="tag" href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a>'; 
         
         $i++;
        }
      }

      if($str!='') $str = $icon.' '.$str;
   
   return $str ;
}


add_shortcode("post_tags","functionpost_tags");


function functionpost_comments($atts)
{
   global $post,$author;
   
   ob_start();
    comments_number( __('no Comments','ioa'), __('one Comment','ioa'), '%'.__(' Comments','ioa') );
    $temp = ob_get_contents();
    ob_end_clean();
   
return '<i class="chat-2icon- ioa-front-icon"></i> <a class="single-comment" href="'.get_permalink().'#comment" >'.$temp.'</a> ';
}


add_shortcode("post_comments","functionpost_comments");


function functionpost_comments_number($atts)
{
   global $post,$author;
   return '<a class="single-comment" href="'.get_permalink().'#comment" >'.get_comments_number( $post->ID ).'</a>';
}




add_shortcode("post_comments_number","functionpost_comments_number");

function functionpost_categories($atts)
{
   global $post,$author;
    extract(
  shortcode_atts(array(  
        "icon" => '<i class="star-3icon- ioa-front-icon"></i>',
    "sep" => ","
    
    ), $atts)); 

   $cats = get_the_category( $post->ID );
 $str = '';
 $i =0;
  foreach($cats as $c)
  {
     if($i==count($cats)-1)
     $str = $str .' <a rel="tag" href="'.get_category_link($c->term_id ).'">'.$c->cat_name.'</a>'; 
     else
     $str =$str . ' <a rel="tag" href="'.get_category_link($c->term_id ).'">'.$c->cat_name.'</a> '.$sep; 
     
     $i++;
  }
 return $icon.' '.$str;
}


add_shortcode("post_categories","functionpost_categories");


/**
 * Drop Cap
 */


function register_dropcap($atts,$content)
{
    extract(
  shortcode_atts(array(  
       

    ), $atts)); 



 return "<span class='drop-cap'>$content</span>";
}
add_shortcode("drop_cap","register_dropcap");

/**
 * Quote Left
 */

function register_quotes_left($atts,$content)
{
    extract(
  shortcode_atts(array(  
       

    ), $atts)); 



 return "<blockquote class='blockquote-left'>$content</blockquote>";
}
add_shortcode("quotes_left","register_quotes_left");

/**
 * Quote Right
 */

function register_quotes_right($atts,$content)
{
    extract(
  shortcode_atts(array(  
       

    ), $atts)); 



 return "<blockquote class='blockquote-right'>$content</blockquote>";
}
add_shortcode("quotes_right","register_quotes_right");

/**
 * Quote Right
 */

function register_quotes($atts,$content)
{
    extract(
  shortcode_atts(array(  
       

    ), $atts)); 



 return "<blockquote class='blockquote'>$content</blockquote>";
}
add_shortcode("quotes","register_quotes");


/**
 * Drops
 */

function register_highlighter($atts,$content,$tag)
{
    extract(
  shortcode_atts(array(  
       

    ), $atts)); 

  $c = 'highlighter-p';

  if($tag=='highlight_dark') $c= 'highlighter-s';

 return "<span class='$c'>$content</span>";
}
add_shortcode("highlight","register_highlighter");
add_shortcode("highlight_dark","register_highlighter");


/**
 * RAD Shortcode to Template Conversion
 */



function RAD_rad_page_section($atts,$content)
{
 global $ioa_meta_data; 
 
  $content = str_replace('&#215;','x',$content);
  
  $cl = array();
 
 if(isset($ioa_meta_data['rad_editable']))
 {
    $ioa_meta_data['rad_reconstruct'][$atts['id']] = array( 'data' => $atts, 'containers' => array() ); 
    $ioa_meta_data['current_rad_section'] = $atts['id'];
    do_shortcode($content);
    return;
 }

if(isset($atts['layout']))
  $ioa_meta_data['section_container_width'] = $atts['layout'];

  $ioa_meta_data['rad_section_data'] = array('data' => $atts , 'containers' => $content );
  

  $section = '';
  
  ob_start();
    get_template_part('templates/rad/section');
    $section = ob_get_contents();
  ob_end_clean();


  return $section;
}


add_shortcode("rad_page_section","RAD_rad_page_section");



function RAD_rad_page_container($atts,$content)
{
 global $ioa_meta_data; 



 if(isset($ioa_meta_data['rad_editable']))
 {

    $current_section =  $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']];
    $current_section['containers'][$atts['id']] = array('data' => $atts , 'widgets' => array() );
    $ioa_meta_data['current_rad_container'] = $atts['id'];

    $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']] = $current_section;
 }
  
  $cl = array();

  $ioa_meta_data['rad_container_data'] = array('data' => $atts , 'widgets' => $content );

  $container = '';
  
  ob_start();
    get_template_part('templates/rad/container');
    $container = ob_get_contents();
  ob_end_clean();


  return $container;
}


add_shortcode("rad_page_container","RAD_rad_page_container");



/*===============================================
=            RAD Shortcode to Widget            =
===============================================*/


function RAD_rad_page_widget($atts,$content)
{
 global $ioa_meta_data,$radunits;
 $widget = '';
 $w = $atts;

 if(isset($w['rich_key']))
   $w[$w['rich_key']] = $content;
 
 foreach ($w as $key => $f) {
  $temp = $f;
  $temp  = str_replace(array( '&squot;','&quot;','&sqstart;','&sqend;' ), array('\'','"','[',']'), $temp );
  $temp  = str_replace(array( '&amp;squot;','&amp;quot;','&amp;sqstart;','&amp;sqend;' ), array('\'','"','[',']'), $temp );
  $temp = str_replace(array("&#038;","#038;"), '&', $temp );
  
  $w[$key] = $temp; 

 }



 if(isset($ioa_meta_data['rad_editable']))
 {

    $current_section =  $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']];
    $current_container = $current_section['containers'][$ioa_meta_data['current_rad_container']];


    $current_container['widgets'][$w['id']] = $w;

    $current_section['containers'][$ioa_meta_data['current_rad_container']] = $current_container;
    $ioa_meta_data['rad_reconstruct'][$ioa_meta_data['current_rad_section']] = $current_section;

    return;
 }

 $ioa_meta_data['widget'] = array();
 $ioa_meta_data['widget']['data'] =  $w;
 $ioa_meta_data['widget']['id'] =  $w['id'];
 $ioa_meta_data['widget']['type'] =  $w['type'];
 $ioa_meta_data['widget_classes'] = '';
 $ioa_meta_data['widget_attributes'] = '';


 ob_start();
            
  $istop = '';
  $islast = '';

if(isset($w['top']) && $w['top'])
{
  $istop = ' top ';
}

if(isset($w['last']) && $w['last'])
{
  $islast = ' last ';
}

  $ioa_meta_data['widget_classes'] .= ' w_full w_layout_element '.$istop;
  
  if(isset($w['layout'])) $ioa_meta_data['widget_classes'] = 'w_layout_element w_'.$w['layout'].' '.$islast.' '.$istop;

  if(isset($w['animation']) && $w['animation']!='none')
      $ioa_meta_data['widget_classes'] .= ' widget-animate widget-animate-'.$w['animation'];

  $ioa_meta_data['rad_type'] = $w['type'];

  if(isset($radunits[str_replace('-','_',$w['type'])]))
  {
    get_template_part("templates/rad/".$radunits[str_replace('-','_',$w['type'])]->data['template']);
  }

   $widget = ob_get_contents();
  ob_end_clean();


  return $widget;
}


add_shortcode("rad_page_widget","RAD_rad_page_widget");




/*-----  End of RAD Shortcode to Widget  ------*/