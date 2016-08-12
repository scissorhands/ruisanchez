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
	 $an = 'way-animated';
	$rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
	$rad_attrs[] = 'data-delay="'.$w['delay'].'"';

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
	<div class="  pricing_table-inner-wrap" >
		
		<?php if(isset($w['text_title']) && $w['text_title']!="") : ?>
		<div class="text-title-wrap" itemscope itemtype="http://schema.org/Thing">
			<h2 itemprop="name" class="ioa-widget-title"><?php echo $ioa_helper->format($w['text_title'],true,false,false); ?></h2>
		</div>
		<?php endif; ?>
		
		<div class="pricing-table">
			
			<?php if($w['show_featured_col'] != 'no' ) : ?>
			<div class="feature-column">
				<div class="feature_area">
					<h2 class='feature-title'><?php echo stripslashes($w['p_title']); ?></h2>
					<span class="feature-desc"><?php echo stripslashes($w['p_desc']); ?></span>
				</div>
				<ul>
					<?php 
						$rows = explode(';',$w['p_feature_list']);
						foreach ($rows as $key => $row) {
							echo "<li>$row</li>";
						}
					?>
				</ul>
			</div>
			<?php endif; ?>	
	

			<?php 
			$i =0;
			 foreach ($tabs as $key => $column) {
			 	?>
				<div class="plan <?php if($i==0) echo 'first-plan'; if($i == count($tabs)-1) echo 'last-plan'; if($column['r_featured_col']=="Yes") echo ' featured-plan'; ?>">
					<div class="pricing_area">
						<span class='plan-title'><?php echo stripslashes($column['r_title']) ?></span>
						<h2><?php echo stripslashes($column['r_price']) ?></h2>
						<span class="suffix"><?php echo stripslashes($column['r_price_info']) ?></span>
					</div>

					<ul class='pricing-row'>
					<?php 
						$rows = explode(';',$column['r_data']);
						foreach ($rows as $key => $row) {
							if($row!='')
							echo "<li>$row</li>";
						}
					?>
					<li class="sign-up">
						<a href="<?php echo $column['r_button_link'] ?>"><?php echo stripslashes($column['r_button_label']) ?></a>
					</li>	
				</ul>

				</div>
			 	<?php
			 	$i++;
			 }

			 ?>

		</div>
		

	
	</div>
</div>

