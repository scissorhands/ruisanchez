<?php

global $ioa_helper, $ioa_meta_data;

$ioa_options = $ioa_meta_data['slider_options'];
$slides = $ioa_meta_data['slider_slides'];

$str = '';
$do = '';


if(! is_array($slides)) $slides = array();
if(! is_array($ioa_options)) $ioa_options = array();

$mo = $ioa_helper->getAssocMap($ioa_options,"value");

        
          foreach($ioa_options as $key => $o)
         {
            if($o['name'] =="captions")
              $do .= " data-caption='".$o['value']."'";
           else
            $do .= " data-".$o['name']."='".$o['value']."'";
         } 

          $ioa_options = $ioa_helper->getAssocMap($ioa_options,'value'); 


         $str .= ' <div class="slideshow-wrap"><div class="ioaslider quartz" '.$do.' data-effect_type="fade" itemscope itemtype="http://schema.org/ImageGallery" > 
          
          <div class="items-holder" style="height:'.$mo['height'].'px">';


         


         foreach ($slides as $key => $slide) {
           $w = $ioa_helper->getAssocMap($slide,'value'); 

           $bg_type ='';$code='';

          if($w['background_opts']== 'bg-image')
          {
             $code = "style='background-image:url(".$w['background_image'].")'";
             $bg_type = 'image_model';
          }  
           if($w['background_opts']== 'bg-color')
          {
             $code = "style='background-color:".$w['background_color']."'";
             $bg_type = 'bgcolor_model';
          } 
          if($w['background_opts']== 'custom')
          {
             $code = "style='background:url(".$w['background_image'].") ".$w['background_position']." ".$w['background_repeat']." ".$w['background_attachment']." ;background-color:".$w['background_color'].";background-size:".$w['background_cover']."'";
             $bg_type = '';
          } 
          if($w['background_opts']== 'bg-texture')
          {
             $code = "style='background:url(".$w['background_image'].") ".$w['background_position']." ".$w['background_repeat']." ".$w['background_attachment']." '";
             $bg_type = 'image_model';
          } 
          if($w['background_opts']== 'bg-gradient')
          {
               $start_gr =  $w['start_gr'];
               $end_gr =  $w['end_gr'];
              $dir_gr =  $w['background_gradient_dir'];

              $iefix = 0;

              switch($dir_gr)
              {
                case "vertical" : $dir_gr = "top"; break;
                case "horizontal" : $dir_gr = "left"; $iefix = 1;  break;
                case "diagonaltl" : $dir_gr = "45deg"; $iefix = 1; break;
                case "diagonalbr" : $dir_gr = "-45deg"; $iefix = 1; break;
              } 
                  
              $code = "style='background:".$start_gr.";background: -webkit-gradient(".$dir_gr.", 0% 0%, 0% 100%, from(".$end_gr."), to(".$start_gr."));background: -webkit-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -moz-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -ms-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");background: -o-linear-gradient(".$dir_gr.", ".$start_gr.", ".$end_gr.");'";

            

             $bg_type = 'gradient_model';
          }
          $vid_w = '';
          if( isset($w['background_opts']) && $w['background_opts'] =='bg-video' )
          {
            if(isset($w['video_fallback']))
            $vid_w = "<img src='".$w['video_fallback'] ."' alt='fallback-image' class='fallback' />";
          }

          $imgalt = '';
          if(isset($w['img_alt'])) $imgalt = $w['img_alt'];

          $str .= ' <div class="slider-item '.$bg_type.'" '.$code.'>';

           if($w['background_opts']== 'bg-video')
          {
            $str .= "<div class='quant_video-bg'>$vid_w<video id='".uniqid('bgvid')."' preload='auto' loop autplay  src='".$w['background_video']."'></video></div>";
          }
          if( $w['image']!='' ) :

           if($mo['image_resize'] == "none" || $ioa_options['full_width'] == "true")
             $str .= ' <img src="'.$w['image'].'" alt="'.$imgalt.'" itemprop="image" />';
          else 
           {
              switch ($ioa_options['image_resize']) {
               case 'default': $str .= $ioa_helper->imageDisplay(array( "imageAttr" => ' alt="'.$imgalt.'" ', "width" => $ioa_options['width'] , "height" => $ioa_options['height'] , 'imageAttr' =>  '', "parent_wrap" => false , "src" => $w['image'] ));  break;
               case 'wproportional': $str .= $ioa_helper->imageDisplay(array( "imageAttr" => ' alt="'.$imgalt.'" ', "width" => $ioa_options['width'] , "height" => $ioa_options['height'] , 'imageAttr' =>  '', "parent_wrap" => false , "src" => $w['image'] ,"crop" => "wproportional" ));  break;
             }
           }

           endif;

           $link = '';
             $linkcode = '';
             $hcode = '';
            if( $w['g_color'] != "" )
            {
               $linkcode = "style='color:".$w['g_color'].";border-color:".$w['g_color']."'";
               $hcode = "style='color:".$w['g_color'].";'";
            }

            if($w['slide_link']!="none") : 

              if($w['custom_link']!='' && $w['slide_link'] == 'custom' )
              {
                $link = "<p class='clearfix'><a ".$linkcode." class='hover-link' href='".$w['custom_link']."'>More</a></p>";
              } 
              else
                $link = "<p class='clearfix'><a ".$linkcode." class='hover-link' href='".get_permalink($w['slide_link'])."'>More</a></p>";

            endif;


            if($w['image']!="" && $ioa_options['lightbox'] =='true')
             $str .= ' <a href="'.$w['image'].'" rel="prettyphoto" class=" resize-full-alt-1icon- ioa-front-icon ioa-lightbox-icon"></a>';
            
             $gcode = '';
            if( $w['g_color'] != "" ) $gcode = "style='color:".$w['g_color']."'";
            
            $cl = 's-c-l';
            if( $w['caption_position']!="" ) $cl = $w['caption_position'];

            $caption_bg = '';
            if( isset($w['caption_bg']) && $w['caption_bg']!="" ) $caption_bg = $w['caption_bg'];


             $str .= ' <div class="slider-desc '.$caption_bg.' '.$cl.'" '.$gcode.' itemprop="description"><div class="inner-desc-wrap"><div class="inner-bg-desc">';
             if(trim($w['text_title'])!="")  $str .= '    <h4 '.$hcode.' >'.$w['text_title'].'</h4> ';
              if(trim($w['text_desc'])!="")  $str .= '    <div class="clearfix"><div  class="caption" '.$hcode.' >'.$w['text_desc'].'</div> </div>'.$link ;
           $str .= ' </div></div></div>
          </div>';

         }

         

   $str .= '</div></div></div>';

   echo $str;