<?php global $ioa_helper,$ioa_meta_data,$ioa_super_options; 
$blog_props = $ioa_meta_data['blog_props'];
?>

<div class="posts-tree clearfix">


<?php


$months = array( 
	"january" => __("January",'ioa') , 
	"february" => __("February",'ioa') , 
	"march" => __("March",'ioa') , 
	"april"  => __("April",'ioa') , 
	"may" => __("May",'ioa') , 
	"june" => __("June",'ioa') , 
	"july" => __("July",'ioa') , 
	"august" => __("August",'ioa') , 
	"september" => __("September",'ioa') , 
	"october" => __("October",'ioa') , 
	"november" => __("November",'ioa') , 
	"december" => __("December",'ioa') 
	); 


$opts = array_merge(array('posts_per_page' => $blog_props['_posts_item_limit'] , 'paged' => $paged ) , $blog_props['query_filter']);

query_posts($opts);

$rs = array(); $count = 0;

if(have_posts()) :
while(have_posts()) : the_post();  
	$row = array();	

	$row["start_time"] = get_the_time();
	$row["start_date"] = get_the_date("d-n-Y");
	$row["ori_date"] = get_the_date();
	$f = get_the_date("d-n-Y");
	$row["factor"] = $f[2].$f[1].$f[0];
	$row["id"] = get_the_ID();

	$row["image_url"] = "";
	
	if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :

		$id = get_post_thumbnail_id();
		$ar = wp_get_attachment_image_src( $id, array(9999,9999) );
		$row["image"] =	 $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" => $ar[0] , "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
		$row["image_url"] = $ar[0];
	else:
		$row["image"] =	 $ioa_helper->imageDisplay(array( "crop" => "wproportional" , "src" =>URL."/sprites/i/dummy.png", "height" =>$ioa_meta_data['height'] , "width" => $ioa_meta_data['width'] , "link" => get_permalink() ,"imageAttr" => "data-link='".get_permalink()."' alt='".get_the_title()."'"));  
	   $row["image_url"] = URL."/sprites/i/dummy.png";	
	endif;

	
	$row["title"] = get_the_title();
	$row["permalink"] =  get_permalink();
	$row["content"] =  $ioa_helper->getShortenContent($blog_props['_posts_excerpt_limit'], strip_tags(strip_shortcodes(get_the_content())) );

	if(isset($blog_props['_blog_meta_enable']) && $blog_props['_blog_meta_enable']!="false") : 
  		$row["extras"] = "<div class='extra clearfix'>".do_shortcode($blog_props['_blog_meta'])."</div>";        
    endif; 

	$rs[] = $row;

	$count++;
endwhile;



$posts  = '<div class="posts-timeline " itemscope itemtype="http://schema.org/Blog" >';

$i=0;

$opts = explode("-",$rs[0]["start_date"]); 
$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];

$month = $opts[1];		
$posts = $posts. " <div class='month-label' data-month='$month'>". $transmonth.' <span class="year">'.$opts[2]."</span></div> ";

foreach($rs as $post)
{
	

	$opts = explode("-",$post["start_date"]); 
	$transmonth =  $months[strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2])))];

	if($opts[1]!=$month)
	{
		$month = $opts[1];	
		$posts = $posts. " <div class='month-label' data-month='$month'> ". $transmonth.' <span class="year">'.$opts[2]."</span></div> ";
	}


$s_date =  $opts[0];
$s_date = str_replace(strtolower(date("F",mktime(0,0,0,$opts[1],1,$opts[2]))),$transmonth,strtolower($s_date));

if($i%2==0) $clname = 'left-post'; else $clname = "right-post";                 

$posts  = $posts ." <div class=\"clearfix hover-item $clname timeline-post\" itemscope itemtype=\"http://schema.org/Article\" ><span class='date'>". $s_date."</span>
 <div class=\"image\">";

if(isset($post['image'])) {
$posts  = $posts.$post['image']; 


ob_start();
 if($blog_props['_enable_thumbnail']!="true"):
 	$ioa_helper->getHover(array( "id" => $post["id"], "link" => true  , 'format' => 'link' ) ); 
 	$posts  = $posts. ob_get_contents();
 else: 
 	$ioa_helper->getHover(array( "image" => $post["image_url"] , 'format' => 'image' ) );  
  	$posts  = $posts. ob_get_contents();
 endif; 
 
ob_end_clean();



 }              

$posts  = $posts."</div>
<div class=\"desc clearfix\"><h3 class=\"title\" itemprop='name'>  <a href=\"".$post['permalink']."\"> ".$post['title']." </a> </h3>";


 $posts  = $posts.$post['extras'];        

$posts .= $post['content']."
</div>  <a itemprop='url' href=\"".$post['permalink']."\" class=\"main-button\"> ".__('More','ioa')." </a>
</div>";



$i++;
} ?>

<?php echo $posts."</div>";?>

<?php wp_reset_query(); ?>	
<span class="circle" data-post_type="post" data-id='<?php echo get_the_ID(); ?> ' data-limit="<?php $p = wp_count_posts(); echo intval($p->publish) ; ?>"></span>

<span class="line"></span>

<?php else: 
   								echo ' <h4 class="auto_align skeleton no-posts-found">'.__('Sorry no posts found','ioa').'</h4>';
 endif; ?>
</div>