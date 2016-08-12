<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
if( isset($w['visibility']) && $w['visibility']!='none')
{
   $an = 'way-animated';
  $rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
  $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';

if(isset($w['auto_width']) && $w['auto_width'] =='yes')
{
	$w['width'] = $ioa_helper->getLayoutValue($ioa_meta_data['playout']);
}
 ?>


<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="video-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>

					<div class="video-player" >
          <video poster="<?php echo $w['video_fallback'] ?>"  id="<?php echo uniqid('vs'); ?>" >
            <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
          <source type="video/mp4" src="<?php echo $w['video_url'] ?>" />
            <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
            <object width="<?php echo $w['width'] ?>" height="<?php echo $w['height'] ?>" type="application/x-shockwave-flash" data="<?php echo includes_url() ?>js/mediaelement/flashmediaelement.swf">
                <param name="movie" value="<?php echo includes_url() ?>js/mediaelement/flashmediaelement.swf" />
                <param name="flashvars" value="controls=false&amp;file=<?php echo $w['video_url'] ?>" />
                <!-- Image as a last resort -->
                <img src="<?php echo $w['video_fallback'] ?>" width="<?php echo $w['width'] ?>" height="<?php echo $w['height'] ?>" title="No video playback capabilities"   alt="No video playback capabilities" />
            </object>
           
      </video>

    </div>
			
	</div>
</div>

