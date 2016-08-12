<?php 
/**
 * Title Template
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data ; 

/**
 * Styling Code ===============================
 */

$show_title =  $tc = $tc =$tco = $tbc =  $ta = $ts = $title_font_size = $title_font_weight =  $code = $title_icon = $ie_tbc= $tv = '';


if(is_singular() || ( IOA_WOO_EXISTS &&  is_woocommerce() ) ) :

$ioa_options = array();

$post_ID = false;

if(is_singular()) $post_ID = get_the_ID();
if( IOA_WOO_EXISTS && is_shop() ) $post_ID = $ioa_meta_data['woo_id'];

if($post_ID)
$ioa_options = get_post_meta( $post_ID, 'ioa_options', true );

if($ioa_options =="")
	$ioa_options = array();

foreach ($ioa_options as $key => $value) {
	if($ioa_options[$key]=="0") $ioa_options[$key]= "";
}

if(isset($ioa_options['show_title'])) $show_title =  $ioa_options['show_title'];
if(isset($ioa_options['title_icon'])) $title_icon =  $ioa_options['title_icon'];
if(isset($ioa_options['ioa_titlearea_bgimage'])) $ttbgimage =  $ioa_options['ioa_titlearea_bgimage'];

if(isset($ioa_options['ioa_custom_title_color'])) $tc =  $ioa_options['ioa_custom_title_color'];
if(isset($ioa_options['ioa_custom_title_bgcolor'])) $tbc =  $ioa_options['ioa_custom_title_bgcolor'];
if(isset($ioa_options['ioa_custom_title_bgcolor-opacity'])) $tbco =  intval($ioa_options['ioa_custom_title_bgcolor-opacity'])/100;


if(isset($ioa_options['title_font_size']) && $ioa_options['title_font_size']!="") $title_font_size =  $ioa_options['title_font_size'];
if(isset($ioa_options['title_font_weight'])) $title_font_weight =  $ioa_options['title_font_weight'];

if( isset($ioa_options['ioa_background_opts']) )
switch($ioa_options['ioa_background_opts'])
{
   case 'bg-color' : $code .= "background-color:".$ioa_options['ioa_titlearea_bgcolor'].";"  ; break;
   case 'bg-image' : 
                      $pos =  $ioa_options['ioa_titlearea_bgposition'];
                      if(isset($ioa_options['ioa_titlearea_bgpositionc']) && $ioa_options['ioa_titlearea_bgpositionc']!="") 
                      $pos =  $ioa_options['ioa_titlearea_bgpositionc'];
                      $code .= "background: url(".$ioa_options['ioa_titlearea_bgimage'].") $pos ;background-size:".$ioa_options['ioa_background_cover'].";"  ; break;
   case 'bg-texture' : 
                      $pos =  $ioa_options['ioa_titlearea_bgposition'];
                      if(isset($ioa_options['ioa_titlearea_bgpositionc']) && $ioa_options['ioa_titlearea_bgpositionc']!="") 
                      $pos =  $ioa_options['ioa_titlearea_bgpositionc'];

                     $code .= "background: url(".$ioa_options['ioa_titlearea_bgimage'].") $pos ".$ioa_options['ioa_titlearea_bgrepeat'].";"  ; break;
   case 'bg-gradient' : 
                      
                      $start_gr =  $ioa_options['ioa_titlearea_grstart'];
                      $end_gr =  $ioa_options['ioa_titlearea_grend'];
                      $dir_gr =  $ioa_options['titlearea_gradient_dir'];

                      $iefix = 0;
  

                      switch($dir_gr)
                      {
                        case "vertical" : $dir_gr = "top"; break;
                        case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
                        case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
                        case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
                      } 
                      $code = "background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$start_gr."', endColorstr='".$end_gr."',GradientType=".$iefix." );";
  break;                   
}


/**
 * End of Styling Code
 */


/**
 * Title General Settings
 */

if(isset($ioa_options['title_vspace']) && $ioa_options['title_vspace']!="") $tv =  $ioa_options['title_vspace'];
if(isset($ioa_options['title_align'])) $ta =  $ioa_options['title_align'];


$gr_offset = 0;
$tp = 0;

if(isset($ioa_meta_data['hasbottom'])) $tp += 85;


if( $tv !="" && $tv !="0" )
{
	$code .=  "padding:".( intval($tp) + $tv)."px 0px ".(  $gr_offset +$tv )."px 0px;";
}

endif;

$title_effect =  '';

if(isset($ioa_options['title_effect'])) $title_effect =  $ioa_options['title_effect'];

if( $tbc!="") {
$ie_tbc= $tbc ;
$tbc = hex2RGB($tbc);
$tbc = "background:rgba(".$tbc['red'].",".$tbc['green'].",".$tbc['blue'].",".$tbco.");";
}


if( isset($ioa_options['ioa_background_opts']) && $ioa_options['ioa_background_opts'] =='bg-video' && (isset($ioa_options['video_pos']) && $ioa_options['video_pos']!="" ) )
{
	$code .= "background:url(".$ioa_options['video_fallback'] .");background-size:cover;";
}


$page_wrapper_classes = array("page-wrapper");

if(!isset($ioa_meta_data['hasbottom'])) $page_wrapper_classes[] = 'no-bottom-bar '; 

if(is_page() || is_singular()) :

	$page_wrapper_classes[] = get_post_type() ;
	
	if(isset($ioa_meta_data['show_title']) && $ioa_meta_data['show_title']=="no" ) $page_wrapper_classes[] = 'no-title ';  
	if($ioa_meta_data['featured_media_type']=="none" || ($ioa_meta_data['featured_media_type']=="image" && ! has_post_thumbnail(get_the_ID())) ) 
		$page_wrapper_classes[] = 'no-media ';
	if($ioa_meta_data['template_type'] == 'rad-builder') $page_wrapper_classes[] = 'rad-template';
	if(isset($ioa_meta_data['full_media'] )) $page_wrapper_classes[] = 'has-full-media';

  if(isset($portfolio_props['portfolio_image_resize']))
    $page_wrapper_classes[] = $portfolio_props['portfolio_image_resize'].'-resize';

  if(isset($ioa_meta_data['ioa_custom_template'])) 
    $page_wrapper_classes[] = $ioa_meta_data['ioa_custom_template'];


  if($ioa_meta_data['page_head_area_toggle']=="yes") $page_wrapper_classes[] = ' no-head-area ';

endif;


global $ioa_portfolio_slug;
$alt_title = true;


if(is_singular() && ( $post->post_type=='product' || ($post->post_type==$ioa_portfolio_slug && $ioa_meta_data['ioa_custom_template'] == 'side') ) )
{
  $alt_title = false;
}

if(!isset($ioa_options['page_breadcrumb_toggle'])) $ioa_options['page_breadcrumb_toggle'] = 'no';

if(is_home()) $ioa_meta_data['title'] = __('Home Page','ioa');

 ?>

<div class="<?php echo implode(' ',$page_wrapper_classes); ?>">

<?php  if($show_title !="no" && ! is_404() ) : ?>
<div class="supper-title-wrapper <?php  if(isset($ioa_meta_data['hasbottom'])) echo ' hasbottomBar'; ?>" >
	
	

	<div class="title-wrap <?php echo "title-text-algin-".$ta; ?>"  style="<?php echo $code;  ?>"  >
		<?php  if( isset( $ioa_options['ioa_background_opts']) && $ioa_options['ioa_background_opts']=="bg-video" && $ioa_options['titlearea_video']!="") : ?>
	<div class="video-bg <?php if(isset($d['video_pos'])) echo $d['video_pos'] ?>">
		<video src="<?php echo $ioa_options['titlearea_video'] ?>" id="<?php echo uniqid('vs') ?>"  preload='auto' loop autplay></video>
	</div>
	<?php endif; ?>

  	<div class="wrap">
    	<div class="skeleton auto_align clearfix <?php if(!$alt_title) echo 'left-breadcrumb';   ?>"> 
		
        		<div class="title-block <?php if( $tbc!="") echo 'title-bg-model '; echo $title_effect; if($title_effect!="none" && $title_effect!="") echo " animate-block"; ?>" data-effect="<?php echo $title_effect ?>" >
        			
              <?php if($alt_title) : ?>
                <h1 class="custom-title" style='<?php echo $tbc; ?>color:<?php echo $tc; ?>;font-size:<?php echo $title_font_size ?>px;font-weight:<?php echo $title_font_weight ?>;' >  <?php if(isset($title_icon) && $title_icon!="") echo "<i class='icon $title_icon'></i>";  echo $ioa_meta_data['title']; ?></h1>
              <?php endif; ?>

        		</div>
        		<?php if(!is_front_page() && $ioa_super_options[SN.'_breadcrumbs_enable']!="false" && $ioa_options['page_breadcrumb_toggle']!="yes" ) $ioa_helper->breadcrumbs(); ?>
                           	
         </div>
     </div>
	</div>
</div>



<?php endif; ?>

