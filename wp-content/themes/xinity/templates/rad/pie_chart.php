<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper,$ioa_meta_data;

$w = $ioa_meta_data['widget']['data'];
$rad_attrs = array();
$rad_attrs[] = $ioa_meta_data['widget_attributes'];
$an = '';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="pie_chart-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title']); ?></h2>
		</div>
		<?php endif; ?>
			
   <?php 
   		$tab_data = array();
		$values = array();

		if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
	$tab_data = $w['rad_tab'];
	$tab_data = explode('[ioa_mod]',$temp);
	

	foreach ($tab_data as $key => $value) {
				
				if($value!="")
				{
					$inpval = array('id' => uniqid('ioa_accordion_'));
					$mods = explode('[inp]', $value);	
					
					foreach($mods as $m)
					{
						
						if($m!="")
						{
							$te = (explode('[ioas]',$m));  

							if( count($te) == 1 ) $te = (explode(';',$m));  
							
							$inpval[$te[0]] =   $te[1]  ; 
							
						}

						
					}
					// $ioa_helper->prettyPrint($inpval);

					$values[] = $inpval;
				}	
		}
endif;		

		$code = "[pie_chart width='".$w['width']."' height='".$w['height']."']";
			foreach ($values as $key => $value) {
				$code .= "[pie background='".$value['chart_color']."' value='".$value['chart_value']."' label='".$value['chart_label']."'/]";
			}
		$code .= "[/pie_chart]";
		 echo do_shortcode($code);
    ?>		
	
	</div>
</div>

<?php if(  $w['clear_float']=="yes") echo '<div class="clearfix empty_element"></div>'; ?>