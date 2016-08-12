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

if( isset($w['chainability']) && $w['chainability']!='none' )
{
  $an .= ' chain-animated';
  $rad_attrs[] = 'data-chain="'.$w['chainability'].'"';
}


if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget"';

$tab_data = array();
$tabs = array();

if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
	$tab_data = $w['rad_tab'];
	$tab_data = explode('[ioa_mod]',$tab_data);
	
  $len = count($tab_data) - 1;

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
					//$ioa_helper->prettyPrint($inpval);

					$tabs[] = $inpval;
				}	
		}
endif;			


 ?>

<div <?php echo join(" ",$rad_attrs) ?>>

	<div class="logo-inner-wrap">
		
			

		<?php 	$tab_data = array();
                                        $si = array();


                                        if( isset($w['rad_tab']) && $w['rad_tab']!="" ) :
                                           $tab_data = $w['rad_tab'];
                                           $tab_data = explode('[ioa_mod',$tab_data);


                                           foreach ($tab_data as $key => $value) {

                                             if($value!="")
                                             {
                                                $inpval = array();
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
                                                   $si[] = $inpval;
                                              } 
                                             } 


                                        endif;  
                                       
                                        ?> 

                                        <?php if($w['style']!='scrollable') : ?>
                                        <ul class="logo-area <?php echo 'logo-'.$w['style'] ?>  clearfix " >
                                            
                                            <?php
                                           $i =0; 
                                          foreach($si as $item)
                                          {
                                            $is_top = '';
                                            if($i < $len/2 ) $is_top = " top_item ";

                                            if($i == 0 || ($i % 3 == 0) ) $is_top .= ' first_item';
                                            if($i == 0 || ($i % 2 == 0) ) $is_top .= ' alt_item ';

                                             $tooltip = '';

                                             echo "<li class='chain-link $is_top'><div class='inner-logo-item'>";

                                             if($item['logo_label']!="") $tooltip = '<span class="logo-tooltip">'.$item['logo_label'].' </span>';
                                                $image = "<img src='".$item['logo_icon']."' alt='logo' /> $tooltip";
                                             if($item['logo_label']!="") 
                                                echo "<a href='".$item['logo_link']."'>$image</a>";
                                             else 
                                                echo "$image";

                                              echo "</div></li>";
                                            $i++; 
                                          } 

                                           ?>

                                        </ul>
                                      <?php else: ?>
                                         <div class="logo-scrollable">
                                           <div class="scrollable  clearfix" itemscope itemtype="http://schema.org/ItemList">
                                           <?php
                                           $i =0; 
                                          foreach($si as $item)
                                          {
                                            $is_top = '';
                                            if($i < $len/2 ) $is_top = " top_item ";

                                            if($i == 0 || ($i % 3 == 0) ) $is_top .= ' first_item';

                                             $tooltip = '';

                                             echo "<div class='chain-link slide $is_top'><div class='inner-logo-item'>";

                                             if($item['logo_label']!="") $tooltip = '<span class="logo-tooltip">'.$item['logo_label'].' </span>';
                                                $image = "<img src='".$item['logo_icon']."' alt='logo' /> $tooltip";
                                             if($item['logo_label']!="") 
                                                echo "<a href='".$item['logo_link']."'>$image</a>";
                                             else 
                                                echo "$image";

                                              echo "</div></div>";
                                            $i++; 
                                          } 

                                           ?>

                                         </div> 
                                         </div>
                                      <?php endif; ?>

	
	</div>
</div>

