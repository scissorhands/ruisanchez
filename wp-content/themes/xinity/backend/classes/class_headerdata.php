<?php
/**
 * Main Class for Generating Resuable Header Widgets
 */

if(!class_exists('IOAHeaderUnits')) {

// == Class defination begins	=====================================================
  
  class IOAHeaderUnits {

      private $data;
      private $preDefs  = array(

            
        );
      
      function __construct($data)
      { 
        $this->data = $data;
      }

      function getLabel()
      {
         return "<span class='label'>".$this->data['label']."</span>";
      }

      function getID()
      {
         return $this->data['id'];
      }

      function getSaveData($values = array() )
       {
         
        $code =  "<div class='opts-panel clearfix'><a href='' class='pencil-2icon- ioa-front-icon edit-hcon-widget'></a><a href='' class=' docsicon- ioa-front-icon clone-hcon-widget'></a><a href='' class=' cancel-2icon- ioa-front-icon delete-hcon-widget'></a></div> <div class='save-data'>";
          
          foreach ($this->data['inputs'] as $key => $input) {
            
            $t = '';
            if(isset($values[$input['name']])) $t = $values[$input['name']];

            $code .= "<textarea name='".$input['name']."' class='".$input['name']."'>$t</textarea>";
          }

           foreach ($this->preDefs as $key => $input) {
            
            $t = '';
            if(isset($values[$input['name']])) $t = $values[$input['name']];

            $code .= "<textarea name='".$input['name']."' class='".$input['name']."'>$t</textarea>";
          }

        $code .= "</div>";
        return $code;
      }


      function getInputs()
      {
         
        $code =  "<div class='hcon-data-panel'><h4 class='clearfix'> ".$this->data['label']." Options <a href='' class='close-hcon button-default'>Close</a> </h4><div class='hcon-body clearfix'><div class='inner-hcon-wrap'>";
          
          foreach ($this->data['inputs'] as $key => $input) {
            $code .= getIOAInput($input);
          }

           foreach ($this->preDefs as $key => $input) {
            $code .= getIOAInput($input);
          }

        $code .= "</div></div></div>";
        return $code;
      }

  }


}


$ioa_head_units["logo"] = new IOAHeaderUnits(array(

      "id" => "logo",
      "label" => __("Logo",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  ));

 $ioa_head_units["text"] = new IOAHeaderUnits(array(

      "id" => "text",
      "label" => __("Text",'ioa'),
      "inputs" => array(  

         array( "label" => __("Text",'ioa') , "name" => "text_data" , "default" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit." ,"is_editor" => true, "type" => "textarea",  "length" => 'medium'),
         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  ));    	  

  $ioa_head_units["image"] = new IOAHeaderUnits(array(

      "id" => "image",
      "label" => __("Image",'ioa'),
      "inputs" => array( 

         array( "label" => __("Upload Image",'ioa') , "name" => "image" , "default" => "", "type" => "upload"),
          array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

         ),

  ));  


  $ioa_head_units["main_menu"] = new IOAHeaderUnits(array(

      "id" => "main_menu",
      "label" => __("Main Menu",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  ));  

  $ioa_head_units["top_menu"] = new IOAHeaderUnits(array(

      "id" => "top_menu",
      "label" => __("Top Menu",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  )); 

   $ioa_head_units["wpml"] = new IOAHeaderUnits(array(

      "id" => "wpml",
      "label" => __("WPML Selector",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  ));

   $ioa_head_units["search_bar"] = new IOAHeaderUnits(array(

      "id" => "search_bar",
      "label" => __("Search Bar",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  )); 

  $ioa_head_units["ajax_search"] = new IOAHeaderUnits(array(

      "id" => "ajax_search",
      "label" => __("Live Search",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  )); 


   $ioa_head_units["woo_cart"] = new IOAHeaderUnits(array(

      "id" => "woo_cart",
      "label" => __("Woo Cart",'ioa'),
       "inputs" => array(  

         array("label" => __("Margin Top",'ioa') , "name" => "margin_top" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Bottom",'ioa') , "name" => "margin_bottom" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Left",'ioa') , "name" => "margin_left" , "default" => "" , "type" => "text" ),
         array("label" => __("Margin Right",'ioa') , "name" => "margin_right" , "default" => "" , "type" => "text" ),

        ),

  )); 


 
$ainputs = array(
          array( 
              "label" => __("Enter Link",'ioa') , 
              "name" => "social_link" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,

           array( 
              "label" => __("Enter Label(if empty tooltip won't appear)",'ioa') , 
              "name" => "social_label" , 
              "default" => "" , 
              "type" => "text",
              "value" => ""   
          ) ,
            array( 
              "label" => __("Icon Hover Color",'ioa') , 
              "name" => "social_color" , 
              "default" => "" , 
              "type" => "colorpicker",
              "value" => ""   
          ) ,
          array( 
              "label" => __("Set Icon",'ioa') , 
              "name" => "social_icon" , 
              "default" => "" , 
              "type" => "text",
              "class" => "has-two-buttons",
             'addMarkup' => '<a href="" class="button-default icon-maker">'.__('Add Icon','ioa').'</a><a class="button-default image_iupload">Add Image Icon</a>'  ,
              "value" => ""   
          )     

      );

  $ioa_head_units["social_icons"] = new IOAHeaderUnits(array(

      "id" => "social_icons",
      "label" => __("Icon Set",'ioa'),
      "inputs" => array( 

            array( 'inputs' => $ainputs, 'label' => __('Social Icons','ioa'),  'name' => 'rad_tab','type'=>'module','unit' => __(' Icon','ioa') )

         ),

  ));            


  function getComponent($el)
      {
        global $ioa_helper,$ioa_super_options,$ioa_meta_data;
        $m = ''; 
        
        $inp = $el['inputs'];
        $inp = $ioa_helper->getAssocMap($inp,'value');

        $style = ''; 

         if( isset($inp['margin_top']) && $inp['margin_top'] !="" ) $style .= 'margin-top:'.$inp['margin_top'].'px;';
         if( isset($inp['margin_bottom']) && $inp['margin_bottom'] !="" ) $style .= 'margin-bottom:'.$inp['margin_bottom'].'px;';
         if( isset($inp['margin_left']) && $inp['margin_left'] !="" ) $style .= 'margin-left:'.$inp['margin_left'].'px;';
         if( isset($inp['margin_right']) && $inp['margin_right'] !="" ) $style .= 'margin-right:'.$inp['margin_right'].'px;';

        $style .= ''; 

        switch($el['id'])
              {
                case 'logo' : $logo = $ioa_super_options[SN."_logo"];

                   $rlogo = $logo;
                  if($ioa_super_options[SN."_rlogo"]!="")   $rlogo = $ioa_super_options[SN."_rlogo"];

                  //$data = get_option(SN.'_enigma_data');
                  //if(isset($data['skin']) && $data['skin'] =="dark")  $logo = URL."/sprites/i/logo-dark.png";
                  //if(isset($_SESSION['vskin']) && $_SESSION['vskin']!="default") $logo = URL."/sprites/i/logo-".$_SESSION['vskin'].".png";

                   ?>
                                  <a href="<?php echo home_url(); ?>" id="logo" class='h-widget' style='<?php if($style!='') echo $style; ?>max-width:<?php echo $ioa_super_options[SN.'_logo_width']; ?>px'>
                                      <img src="<?php echo $logo; ?>" alt="logo" data-retina="<?php echo $rlogo; ?>" />
                                  </a> 
                              <?php break;
                case 'image' : 

                               

                             ?>
                                 
                                      <div class="image-area h-widget">
                                        <img src="<?php echo $inp['image']; ?>" alt="head image" <?php if($style!='') echo 'style="'.$style.'"'; ?>  />
                                      </div>
                              <?php break;              
                case 'text' : if(isset($inp['text_data'])) : 
                              ?>
                               <div class="top-text h-widget" <?php if($style!='') echo 'style="'.$style.'"'; ?>> 
                                <?php  echo stripslashes(do_shortcode($inp['text_data'])); ?> 
                              </div>
                              
                              <?php endif; break; 

               case 'wpml' :  ?>
                               <div class="wpml-selector h-widget" <?php if($style!='') echo 'style="'.$style.'"'; ?>> 
                                    <a href="" class="wpml-lang-selector  clearfix"> <i class="ioa-front-icon flag-emptyicon-"></i><span><?php _e('Change Language ','ioa'); ?></span> </a>

                                    <ul>
                                      
                                    <?php 
                                   
                                    $i=0; $cl = '';
                                    $langs = array();
                                    $languages = array(
                                        array( 'url' => '' , 'translated_name' => 'English' ),
                                        array( 'url' => '' , 'translated_name' => 'French' ),
                                      );
                                    if(function_exists('icl_get_languages') ) 
                                     $languages =icl_get_languages('skip_missing=0&orderby=KEY&order=DIR');

                                      foreach($languages as $l){
                                       
                                          $cl = ''; $ar = '';
                                            if($i==0) { 
                                              $cl = 'first-c';
                                              $ar = '<i class="ioa-front-icon  up-dir-1icon-"></i>';
                                            }
                                            else if($i == count($languages)-1) $cl = 'last';
                                              $langs[] = '<li  class="'.$cl.'">'.$ar.'<a href="'.$l['url'].'">  '.$l['translated_name'].'</a></li>';

                                     
                                        $i++; 
                                        
                                      }
                                      echo join('', $langs);
                                   
                                     ?>
                                     </ul>
                               </div>
                              
                              <?php  break;                
                case 'top_menu' : 
                                ?>  <div class="menu-wrapper h-widget" <?php if($style!='') echo 'style="'.$style.'"'; ?>  > 
                                       <div class="menu-bar clearfix">
                                               <?php  
                                              
                                                        if(function_exists("wp_nav_menu"))
                                                        {
                                                            wp_nav_menu(array(
                                                                        'theme_location'=>'top_menu2_nav',
                                                                        'container'=>'',
                                                                        'depth' => 3,
                                                                        'menu_class' => 'menu clearfix',
                                                                        'menu_id' => 'menu2',
                                                                        'fallback_cb' => false,
                                                                        'walker' => new ioa_Menu_Frontend()
                                                                         )
                                                                        );
                                                        }
                                               ?>
                                    </div>
                                    </div>
                                 <?php break; 
                case 'main_menu' : ?>
                                   <div class="menu-wrapper main-menu-wrap h-widget" <?php if($style!='') echo 'style="'.$style.'"'; ?>  > 
                                       <div class="menu-bar clearfix">
                                              <?php  if(function_exists("wp_nav_menu"))
  {
      wp_nav_menu(array(
                  'theme_location'=>'top_menu1_nav',
                  'container'=>'',
                  'depth' => 5,
                  'menu_class' => 'menu clearfix',
                  'fallback_cb' => false,
                  'walker' => new ioa_Menu_Frontend()
                   )
                  );
  }  ?>
                                    </div>
                                  </div>
                                 <?php break;   
                case 'social_icons' : 
                                
                                        $tab_data = array();
                                        $si = array();


                                        if( isset($inp['rad_tab']) && $inp['rad_tab']!="" ) :
                                           $tab_data = $inp['rad_tab'];
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

                                        <div class="top-social-area-wrap social-set h-widget" <?php if($style!='') echo 'style="'.$style.'"'; ?>>
                                        <ul class="top-area-social-list  clearfix " >
                                            
                                            <?php
                                          foreach($si as $item)
                                          {
                                             $tooltip = '';

                                             if($item['social_label']!="") $tooltip = '<span class="social-tooltip"><i class="up-diricon- ioa-front-icon"></i> '.$item['social_label'].' </span>';

                                              if( strpos($item['social_icon'],'ioa-front-icon') !== false ) 
                                              echo "<li>
                                                  <a href='".$item['social_link']."'>
                                                    <span class='".$item['social_icon']." social-block visible-block'></span>
                                                    <span class='hover-block social-block ".$item['social_icon']."' style='color:".$item['social_color']."'></span>
                                                  </a> $tooltip
                                                </li>";
                                             else
                                              echo "<li><span class='image-icon' href='".$item['social_link']."' style='background-image:url(".$item['social_icon'].")'></span> $tooltip</li>";
                                          } 

                                           ?>

                                        </ul>
                                        </div>

                                 
                                 
                                  <?php break;
                case 'ajax_search' :  ?>
                                   <div data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" class='ajax-search h-widget' >
                                      
                                      <a href="" class="ajax-search-trigger search-3icon- ioa-front-icon " ></a>
                                      <div class="ajax-search-pane">
                                         <a href="" class="ajax-search-close ioa-front-icon cancel-2icon-"></a>
                                         <span class=" up-dir-1icon- ioa-front-icon tip"></span>
                                          
                                          <div class="form">
                                             <form role="search" method="get"  action="<?php echo home_url( '/' ); ?>">
                                                <div>
                                                    <input type="text"  autocomplete="off" name="s" class='live_search' value="<?php _e('Type something..','ioa') ?>" />
                                                    <input type="submit"  value="Search" />
                                                    <span class="search-loader"></span>
                                                </div>
                                            </form>
                                          </div>
                                          <div class="search-results clearfix">
                                            <ul>
                                             
                                            </ul>
                                          </div>
                                      </div>

                                  </div> 
                                  <?php break; 
                case 'search_bar' : ?>
                                  <form role="search" method="get" id="searchform" class='h-widget' action="<?php echo home_url( '/' ); ?>" <?php if($style!='') echo 'style="'.$style.'"'; ?>>
                                      <div>
                                          <div class="search-input">
                                            <input type="text" value="" name="s" id="s" placeholder="<?php _e('What are you looking for ?','ioa') ?>"  />
                                          </div>
                                          <input type="submit" id="searchsubmit" value="" />
                                          <a href='' class="proxy-search search-3icon- ioa-front-icon"></a>
                                      </div>
                                  </form>
                                  <?php break;     
                 case 'woo_cart' :
            
                  global $woocommerce; ?> 
                  
                  <div class="ajax-cart h-widget" <?php if($style!='') echo 'style="'.$style.'"'; ?>>
                    <a href="" class='icon ioa-front-icon basketicon- ioa-menu-icon ajax-cart-trigger'></a>
                    <div class="ajax-cart-items clearfix">
                      
                      <div class="widget_shopping_cart_content"></div>
      
                    </div>
                  </div>

                 <?php break;                                                           
                                                                       
              }
      } 