<?php 
/**
 * The Template for Under Construction. This is an
 * independent template. Complete structure is inside
 * the template only.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */


 ?>
<!DOCTYPE html>

<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->

<html <?php language_attributes(); ?>>

<?php global $ioa_super_options; ?>
<head> <!-- Start of head  -->

	<meta charset="utf-8">
    

	<title>Under Construction</title>
	<link rel="shortcut icon" href="<?php echo $ioa_super_options[SN."_favicon"]; ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /><!-- Feed  -->
  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
   	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'>
	<style type="text/css">
	 <?php 
	 	if($ioa_super_options[SN.'_uc_bg']!="")
	 	{
	 		echo " div.main-uc-area { background-image:url(".$ioa_super_options[SN.'_uc_bg']."); background-position:top center; background-size:cover; } ";
	 	}	
	  ?>
	</style>
	<?php wp_head(); ?>
</head> <!-- End of Head -->

 
<body itemscope itemtype="http://schema.org/WebPage"> <!-- Start of body  -->

<img src="<?php echo $ioa_super_options[SN."_logo"]; ?>" alt="logo" id="logo"/>

<div class="main-uc-area clearfix <?php if($ioa_super_options[SN.'_uc_bg_animate']!="false") echo 'animate-uc-area' ?>">
	<div class="uc-content-area ">
		<h1 class="title"><?php echo stripslashes($ioa_super_options[SN."_uc_title"]); ?></h1>
	 	<div class="uc-text clearfix"> <?php echo do_shortcode(stripslashes($ioa_super_options[SN."_uc_text"])); ?> </div>
		<div class="radial-chart" data-bar_color="<?php echo $ioa_super_options[SN.'_uc_barcolor'] ?>"  data-percent="<?php echo $ioa_super_options[SN.'_uc_progress'] ?>"  data-line_width="20" data-width="<?php echo $w['width'] ?>"  ><?php echo $ioa_super_options[SN.'_uc_progress']."%" ?></div>	
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>