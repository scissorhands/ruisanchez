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


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
	<div class="progress_bar-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
			
		<div class="progress-bar-group" data-type="area" data-unit="<?php echo $w['unit'] ?>"  itemscope itemtype="http://schema.org/Dataset">
			
			<?php 
   		$tab_data = array();
		$values = array();

		if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
			$tab_data = $w['rad_tab'];
			$tab_data = explode('[ioa_mod]',$tab_data);
			

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
									$inpval[$te[0]] =   $te[1]  ; 
									
								}

								
							}
							//$ioa_helper->prettyPrint($inpval);

							$values[] = $inpval;
						}	
				}
		endif;

		
			foreach ($values as $key => $value) {
				 $end_gr = $value['pr_color'];
           		

			$code = "background:  $end_gr;";
				?>
				<div class="progress-bar">
					<h6 class='progress-bar-title' itemprop="name"><?php echo stripslashes($value['pr_label']) ?></h6>
					<div class="filler" style="<?php echo $code; ?>" data-fill="<?php echo $value['pr_value']; ?>">
						<span itemprop="spatial"> <i class="down-dir-1icon- ioa-front-icon"></i> <?php echo $value['pr_value'].' '.$w['unit']; ?></span>
					 <?php if(isset($w['show_strips']) && $w['show_strips'] == 'yes' ): ?>
							<div class="overlay"></div>
					<?php endif; ?>
					</div>
				</div>
				<?php
			}
		    ?>	

				
				
			
		</div>	
		
	</div>
</div>

