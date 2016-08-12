<?php 
/**
 * Text Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits,$ioa_portfolio_slug;

$w = $ioa_meta_data['widget']['data'];

$rad_attrs = array();
$an = '';

if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget rad-menu-widget"';

$menu_items = explode(';',$w['rad_added_menus']);
 ?>


<div <?php echo join(" ",$rad_attrs) ?>>
		
		<?php if($w['rad_added_menus']!='') : ?>
			<div class="rad-one-page-menu-wrap">
			
			<div class="skeleton auto_align">
				<div class="one-page-select-wrap">
					<select name="" id="" class="one-page-mobile-selector">
					<?php 
					foreach ($menu_items as $key => $item) {
						if( $item!="") :
						$i = explode(':',$item);

					if(strpos($i[0],'ps') > 0 ) 
					{
						$i[0] = '#'.$i[0];
					}
					else
					{
						$i[0] = get_permalink($i[0]);
					}
					
						?><option value="<?php echo $i[0] ?>"><?php echo $i[1] ?></option><?php
						endif;
					} ?>
					</select>
					
				</div>
			</div>

		<ul class="rad-one-page-menu skeleton auto_align clearfix">
			<?php 

				

				foreach ($menu_items as $key => $item) {
					if( $item!="") :
					$i = explode(':',$item);
					$cl = $i[0];

					if(strpos($i[0],'ps') > 0 ) 
					{
						$i[0] = '#'.$i[0];
					}
					else
					{
						$cl = 'external';
						$i[0] = get_permalink($i[0]);
					}

					?><li class='<?php echo 'one-'.$cl ?>'><a href="<?php echo $i[0] ?>"><?php echo $i[1] ?></a></li><?php
					endif;
				}

			 ?>
		</ul>
		</div>
		<?php endif; ?>

	

</div>


