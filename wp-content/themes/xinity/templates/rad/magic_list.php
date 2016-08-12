<?php 
/**
 * Tabs Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';
if( isset($w['visibility']) && $w['visibility']!='none')
{
	$an .= 'way-animated effect-'.$w['visibility'];
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}

if( isset($w['chainability']) && $w['chainability']!='none' )
{
  $an .= ' chain-animated chain-'.$w['chainability'];
  $rad_attrs[] = 'data-chain="'.$w['chainability'].'"';
}


if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';


$tab_data = array();
$tabs = array();

if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
	$tab_data = $w['rad_tab'];
	$tab_data = explode('[ioa_mod',$tab_data);
	

	foreach ($tab_data as $key => $value) {
				
				if($value!="")
				{
					$inpval = array('id' => uniqid('titan_tab_'));
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
					//$ioa_helper->prettyPrint($inpval);

					$tabs[] = $inpval;
				}	
		}
endif;			




 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="magic_list-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
		
		
		<ul>
			<?php $i=0; foreach ($tabs as  $tab) :?>
			<li class="clearfix chain-link">
				<div class="ioa-icon-area">
					<?php $tc = ''; if(isset($tab['tab_icon'])) $tc = $tab['tab_icon']; echo do_shortcode("[ioa_icon icon_type='default' icon_class='".$tc."' ]"); ?>
				</div>
				<div class="desc-area">
					<h4><?php if(isset($tab['tab_title'])) echo stripslashes($tab['tab_title']); ?></h4>
					<div class="desc">
						<?php if(isset($tab['tab_text'])) echo $ioa_helper->format($tab['tab_text']); ?>
					</div>
				</div>
			</li>	
			<?php endforeach; ?>
		</ul>

		
	
	</div>
</div>

