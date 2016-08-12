<?php 
/**
 * Testimonails Template for RAD BUILDER
 */

global $ioa_helper, $ioa_super_options , $ioa_meta_data , $wpdb,$radunits;


$w = $ioa_meta_data['widget']['data'];
$rad_attrs = array();
$an = '';
if( isset($w['visibility']) && $w['visibility']!='none')
{
   $an = 'way-animated';
  $rad_attrs[] = 'data-effect="'.$w['visibility'].'"';
  if(isset($w['delay']))
  $rad_attrs[] = 'data-delay="'.$w['delay'].'"';

}
if(isset($ioa_meta_data['widget']['id'])) $rad_attrs[] = 'id="'.$ioa_meta_data['widget']['id'].'"';
if(isset($ioa_meta_data['widget_classes'])) $an .= $ioa_meta_data['widget_classes'].' ';
$rad_attrs[] = 'class="'.$an.' rad-widget person-wrapper"';

$height = $width = $ioa_helper->getLayoutValue($ioa_meta_data['playout']); 

if(isset($w['height'])) $height = $w['height'];

 ?>

<div <?php echo join(" ",$rad_attrs) ?>>
  <div class="person-inner-wrap clearfix">

     <div class="clearfix p-area">
     	 <div class="image">
     	 	<?php echo $ioa_helper->imageDisplay(array( "src" => $w['photo'] , "width" => $width , "height" => $height , "parent_wrap" => false )); ?>
     	 		<a href="<?php echo $w['photo']; ?>" class="ioa-front-icon popupicon- person-icon" rel="prettyPhoto[ppgal]"></a>
       </div>
       <div class="desc-area" >
          <div class="p-info">
           <h4><?php echo stripslashes($w['mem_name']) ?></h4>
          <span><?php echo stripslashes($w['mem_desig']) ?></span>
          <div class="info">
              <?php if(isset($w['mem_desc'])) echo stripslashes($w['mem_desc']) ?>
          </div> 
          </div>
     	 </div>
     </div>

     <?php
     $tab_data = array();
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

    <div class=" social-set h-widget">
    <ul class="top-area-social-list  clearfix " >
        
        <?php
      $i = 0 ;
      foreach($si as $item)
      {
         $tooltip = '';

         if($item['social_label']!="") $tooltip = '<span class="social-tooltip"><i class="up-diricon- ioa-front-icon"></i> '.$item['social_label'].' </span>';

          if( strpos($item['social_icon'],'ioa-front-icon') !== false ) 
          echo "<li>
              <a href='".$item['social_link']."'>
                <span class='".$item['social_icon']." social-block visible-block'></span>
                <span class='hover-block social-block ".$item['social_icon']."' style='background-color:".$item['social_color']."'></span>
              </a> $tooltip
            </li>";
         else
          echo "<li><span class='image-icon' href='".$item['social_link']."' style='background-image:url(".$item['social_icon'].")'></span> $tooltip</li>";

        $i++;
      } 
       ?>

    </ul>
    </div>
 	
  
    
  </div>
</div>
