<?php
/**
 * The Content Header Template 
 *
 * @package WordPress
 * @subpackage ASI Themes
 * @since IOA Framework V1
 */



global $ioa_super_options , $ioa_helper, $ioa_meta_data;
$head_data = get_option(SN.'_head_builder');

if(isset($_GET['vhead'])) 
      {
        $_SESSION['vhead'] = $ioa_meta_data['page_head_layout'] = $_GET['vhead'];
      }

if(isset($_SESSION['vhead'])) 
{
  $ioa_meta_data['page_head_layout'] = $_SESSION['vhead'];
  }

if(isset($ioa_meta_data['page_head_layout']) && $ioa_meta_data['page_head_layout']!="none" && $ioa_meta_data['page_head_layout']!="default")
{
   $templates  = get_option(SN.'_header_templates');
   if(!$templates) $templates = array();
   if(isset($templates[$ioa_meta_data['page_head_layout']]))
    $head_data = $templates[$ioa_meta_data['page_head_layout']]['data'];
}


if(! is_array($head_data))
{
  $IOAHeader = new IOAHeaderConstructor();
  $head_data = $IOAHeader->getDefault();
}


 if(  $head_data[2]['visibility'] == "Yes" ) 
 {
    $ioa_meta_data['hasbottom'] = 'true';

 }
$clogo = $ioa_super_options[SN."_logo"];

if($ioa_super_options[SN."_clogo"]!="") $clogo = $ioa_super_options[SN."_clogo"]; 
if(isset($_SESSION['vskin']) && $_SESSION['vskin']!="default") $clogo = URL."/sprites/i/clogo-".$_SESSION['vskin'].".png";

 ?>

<!-- Compact menu code -->
<?php if($ioa_super_options[SN.'_cmenu_enable']!="false"  ) : ?>
 <div class="compact-bar theme-header clearfix">
    <div class="skeleton auto_align clearfix" itemscope itemtype='http://schema.org/SiteNavigationElement'>

      <a href="<?php echo home_url(); ?>" id="clogo" >
            <img src="<?php echo $clogo; ?>" alt="compact logo" />
      </a> 

     <div class="menu-wrapper"  > 
         <div class="menu-bar clearfix">
                <?php  if(function_exists("wp_nav_menu"))
  {
      wp_nav_menu(array(
                  'theme_location'=>'top_menu1_nav',
                  'container'=>'',
                  'depth' => 3,
                  'menu_class' => 'menu clearfix',
                  'fallback_cb' => false,
                  'walker' => new ioa_Menu_Frontend()
                   )
                  );
  }   ?>
      </div>
    </div>


    </div>  
 </div>
<?php endif; ?>
<!-- End of compact menu code -->
<div class="mobile-header">
    <div class="skeleton clearfix">
         <?php 

         $logo = $ioa_super_options[SN."_logo"];
         $rlogo = $logo;
         if($ioa_super_options[SN."_rlogo"]!="")   $rlogo = $ioa_super_options[SN."_rlogo"];

         $data = get_option(SN.'_enigma_data');
         if(isset($data['skin']) && $data['skin'] =="dark")  $logo = URL."/sprites/i/logo-dark.png";
                  
         if(isset($_SESSION['vskin']) && $_SESSION['vskin']!="default") $logo = URL."/sprites/i/logo-".$_SESSION['vskin'].".png";

          ?>
         <a href="<?php echo home_url(); ?>" id="mlogo" class='h-widget'>
                <img src="<?php echo $logo; ?>" alt="logo" data-retina="<?php echo $rlogo; ?>" />
         </a> 
         <a href="" class="mobile-menu ioa-front-icon menuicon-"></a>
    </div>
</div>

<div class="mobile-menu-wrap">
    <ul class="mobile-menu-list">
      
    </ul>
</div>

<?php if(!isset($ioa_meta_data['page_head_area_toggle'])) $ioa_meta_data['page_head_area_toggle'] = 'no';  if($ioa_meta_data['page_head_area_toggle']!="yes") : ?>

<div class="theme-header <?php if(isset($head_data['head_style']))  echo str_replace(' ','_', $head_data['head_style']).' '; if(  $head_data[2]['visibility'] == "Yes" ) { echo 'hasbottombar'; } ?>" itemscope itemtype="http://schema.org/WPHeader" >
 



<div class="header-cons-area clearfix">
    <?php 
  if(isset($head_data['head_style']))  $head_style  = $head_data['head_style'];
    if( is_array($head_data) )
    foreach ($head_data as $key => $area) {

      if( $key!=='head_layout' && $key!=='head_style' )
        if( isset($area['visibility']) && $area['visibility']!='No'  ) :
        ?>
        <?php if($area['id']=='bottom_bar') echo '<div class="bottom_bar_area_wrap">'; ?>
        <div id="<?php echo $area['id'] ?>_area" class='clearfix'>
            <div class="skeleton auto_align clearfix">
              <?php 
                $pl = $area['data'];
                if( is_array($pl) )
                foreach ($pl as $key => $placeholder) {
                    ?>
                    <div class="clearfix <?php echo $placeholder['placeholder'].'-area'; ?>">
                        <?php 
                             $widgets = $placeholder['widgets'];
                             foreach ($widgets as $key => $w) {
                               getComponent($w);
                             }
                         ?>
                    </div>
                    <?php
                  }  
               ?>
            </div>
        </div> 

         <?php if($area['id']=='bottom_bar') echo '</div>'; ?> 

        <?php
        endif;
      }  
     ?>
</div>




<?php 
wp_reset_postdata(); // Reset WP Object after Mega Menu Widgets
      
 ?>



</div> <!-- END OF THEME HEADER ~~ Top Bar + Menu + Title -->

<?php endif; ?>


<?php 
get_template_part('templates/content-title'); 


 
 ?>



