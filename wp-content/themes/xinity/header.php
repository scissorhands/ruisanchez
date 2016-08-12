<?php 
/**
 * The Header for the theme.
 *
 * Displays all of the <head> section and everything up till container title.
 *
 * @package WordPress
 * @subpackage ASI Theme
 * @since IOA Framework V 1.0
 */ 
global $ioa_super_options, $rad_flag, $ioa_meta_data; 
/**
 * Maintaince Mode. Only Admin can view the website
 * when maintainence mode is activated from options panel.
 */
if(isset($ioa_super_options[SN.'_uc_mode']) && $ioa_super_options[SN.'_uc_mode']=="true" && ! current_user_can('delete_pages') )
{
  get_template_part("templates/under_construction");
  die(); 
}
 
if(!isset($ioa_meta_data['ioa_custom_template'])) $ioa_meta_data['ioa_custom_template'] = 'default';
 
$box_flag = false;
if(isset($_GET['vlayout']))
{
  if($_GET['vlayout'] == 'boxed')
   $box_flag =true;
   $_SESSION['vlayout'] = $_GET['vlayout'];
}
if(isset($_SESSION['vlayout']) && $_SESSION['vlayout'] == 'boxed')  $box_flag =true;

$mobile_sidebar = '';
if($ioa_super_options[SN.'_show_mobile_sidebar']!="true") $mobile_sidebar = ' hide-mobile-sidebar ';

?>
<!DOCTYPE html>

<html <?php language_attributes(); ?> >
 

<head> <!-- Start of head  -->

  <meta charset="utf-8">

   <?php if($ioa_super_options[SN.'_mobile_view']!="false") : ?> 
         <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
   <?php else: ?>
         <meta name="viewport" content="width=1080"> 
   <?php endif; ?>

    
  <title><?php  wp_title();   ?></title>
  
   
  <link rel="shortcut icon" href="<?php echo $ioa_super_options[SN."_favicon"]; ?>" />
  <link rel='tag' id='shortcode_link' href='<?php echo HURL ?>' />
<?php if($ioa_super_options[SN."_ipad_retina_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ioa_super_options[SN."_ipad_retina_icon_logo"]; ?>"> <?php endif; ?>
<?php if($ioa_super_options[SN."_iphone7_retina_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo $ioa_super_options[SN."_iphone7_retina_icon_logo"]; ?>"> <?php endif; ?>
<?php if($ioa_super_options[SN."_iphone_retina_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $ioa_super_options[SN."_iphone_retina_icon_logo"]; ?>"> <?php endif; ?>
<?php if($ioa_super_options[SN."_ipad_icon_logo"]!="") : ?><link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ioa_super_options[SN."_ipad_icon_logo"]; ?>"> <?php endif; ?>
<?php if($ioa_super_options[SN."_generic_touch"]!="") : ?><link rel="apple-touch-icon-precomposed" href="<?php echo $ioa_super_options[SN."_generic_touch"]; ?>"> <?php endif; ?>

  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /><!-- Feed  -->
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  

  <?php if ( is_singular() && get_option( 'thread_comments' ) )  wp_enqueue_script( 'comment-reply' );    ?>
    

 
  <script type="text/javascript">
    <?php  echo stripslashes($ioa_super_options[SN."_headjs_code"]);  ?>

  </script>
        <?php  
             IOA_head(); // Custom Hook  
             wp_head();  
        ?>    
</head> <!-- End of Head -->

 
<body <?php  body_class( 'style-'.get_option(SN.'_active_etemplate').' '.$mobile_sidebar ); ?> itemscope itemtype="http://schema.org/WebPage"  <?php if(isset($ioa_super_options[SN.'_pptheme'])) echo "data-lightbox_theme='".$ioa_super_options[SN.'_pptheme']."'"; ?>  data-effect="<?php echo $ioa_super_options[SN.'_submenu_effect']; ?>" > <!-- Start of body  -->

<?php IOA_body_start(); // Custom Hook ?>
<div class="super-wrapper   clearfix">
  <div class="inner-super-wrapper <?php if( ( isset($ioa_super_options[SN.'_boxed_layout']) && $ioa_super_options[SN.'_boxed_layout']=="true" ) || $box_flag ) echo 'ioa-boxed-layout' ?>" >  

<?php 

if($ioa_meta_data['ioa_custom_template']!='ioa-template-blank-page')
get_template_part('templates/header-template');
?>

