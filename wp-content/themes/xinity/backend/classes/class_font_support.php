<?php 
/**
 * Core Class to enable hooks and actions for Fonts
 * @version 1.0
 */

if(!class_exists('IOAFont'))
{
	class IOAFont
	{
		private $google_fonts = array();
		private $fontface_fonts = array();
		private $fontdeck_fonts = array();
		private $websafe = array();

		function __construct()
		{	
			$this->setThemeTypography();

		}

		function setFontParameters()
		{
			$code ='' ;
			$data = get_option(SN.'_enigma_data');
			  $typography = array();

			if($data) :

				if( isset($data['typography']) && is_array($data['typography']) )
				    $typography = $data['typography'];

				if( isset($data['typography']) && $typography['theme_fz_override'] == "Yes" )
				{
					if(! ($typography[SN.'_body_font_line_height'] == "" || $typography[SN.'_body_font_line_height'] == "0") ) 
						$typography[SN.'_body_font_line_height'] = "line-height :".$typography[SN.'_body_font_line_height'].";";

					$code .= " body { font-size : ".$typography[SN.'_body_font_font_size']."px; ".$typography[SN.'_body_font_line_height']." }";

					if(! ($typography[SN.'_topmenu_font_line_height'] == "" || $typography[SN.'_topmenu_font_line_height'] == "0") ) 
						$typography[SN.'_topmenu_font_line_height'] = "line-height :".$typography[SN.'_topmenu_font_line_height'].";";

					$code .= " div.theme-header #top_bar_area .menu>li>a { font-size : ".$typography[SN.'_topmenu_font_font_size']."px; ".$typography[SN.'_topmenu_font_line_height']." }";

					if(! ($typography[SN.'_mainmenu_font_line_height'] == "" || $typography[SN.'_mainmenu_font_line_height'] == "0") ) 
						$typography[SN.'_mainmenu_font_line_height'] = "line-height :".$typography[SN.'_mainmenu_font_line_height'].";";

					$code .= " div.theme-header div#main_menu_area .menu > li > a, div.theme-header div#bottom_bar_area .menu > li > a { font-size : ".$typography[SN.'_mainmenu_font_font_size']."px; ".$typography[SN.'_mainmenu_font_line_height']." }";

					if(! ($typography[SN.'_h1_font_line_height'] == "" || $typography[SN.'_h1_font_line_height'] == "0") ) 
						$typography[SN.'_h1_font_line_height'] = "line-height :".$typography[SN.'_h1_font_line_height'].";";

					$code .= " h1 { font-size : ".$typography[SN.'_h1_font_font_size']."px; ".$typography[SN.'_h1_font_line_height']." }";

					if(! ($typography[SN.'_h2_font_line_height'] == "" || $typography[SN.'_h2_font_line_height'] == "0") ) 
						$typography[SN.'_h2_font_line_height'] = "line-height :".$typography[SN.'_h2_font_line_height'].";";

					$code .= " h2 { font-size : ".$typography[SN.'_h2_font_font_size']."px; ".$typography[SN.'_h2_font_line_height']." }";

					if(! ($typography[SN.'_h3_font_line_height'] == "" || $typography[SN.'_h3_font_line_height'] == "0") ) 
						$typography[SN.'_h3_font_line_height'] = "line-height :".$typography[SN.'_h3_font_line_height'].";";

					$code .= " h3 { font-size : ".$typography[SN.'_h3_font_font_size']."px; ".$typography[SN.'_h3_font_line_height']." }";

					if(! ($typography[SN.'_h4_font_line_height'] == "" || $typography[SN.'_h4_font_line_height'] == "0") ) 
						$typography[SN.'_h4_font_line_height'] = "line-height :".$typography[SN.'_h4_font_line_height'].";";

					$code .= " h4 { font-size : ".$typography[SN.'_h4_font_font_size']."px; ".$typography[SN.'_h4_font_line_height']." }";

					if(! ($typography[SN.'_h5_font_line_height'] == "" || $typography[SN.'_h5_font_line_height'] == "0") ) 
						$typography[SN.'_h5_font_line_height'] = "line-height :".$typography[SN.'_h5_font_line_height'].";";

					$code .= " h5 { font-size : ".$typography[SN.'_h5_font_font_size']."px; ".$typography[SN.'_h5_font_line_height']." }";

					if(! ($typography[SN.'_h6_font_line_height'] == "" || $typography[SN.'_h6_font_line_height'] == "0") ) 
						$typography[SN.'_h6_font_line_height'] = "line-height :".$typography[SN.'_h6_font_line_height'].";";

					$code .= " h6 { font-size : ".$typography[SN.'_h6_font_font_size']."px; ".$typography[SN.'_h6_font_line_height']." }";
					
				}

			endif;	
			
			echo "<style type='text/css'> $code </style>";
		}

		/**
		 * Retrives all registered fonts.
		 */
		public function setThemeTypography()
		{

			global $ioa_typo_list ;

			$default_typo_list = array(
					"body_font" => array(  "id" => "body_font" , "type" => "google" , "font" => "Lato" , "weight" => "400" ),
					"h1_font" => array( 	"id" => "h1_font" , "type" => "google" , "font" =>"Lato", "weight" => "700"),
					"h2_font" => array( 	"id" => "h2_font" , "type" => "google" , "font" =>"Lato", "weight" => "700"),
					"h3_font" => array( 	"id" => "h3_font" , "type" => "google" , "font" =>"Lato", "weight" => "700"),
					"h4_font" => array( 	"id" => "h4_font" , "type" => "google" , "font" =>"Lato", "weight" => "700"),
					"h5_font" => array( 	"id" => "h5_font" , "type" => "google" , "font" =>"Lato", "weight" => "600"),
					"h6_font" => array( 	"id" => "h6_font" , "type" => "google" , "font" =>"Lato", "weight" => "600"),
					"topmenu_font" => array( 	"id" => "topmenu_font" , "type" => "google" , "font" =>"Lato", "weight" => "400"),
					"mainmenu_font" => array(  "id" => "mainmenu_font" , "type" => "google" ,"font" => "Lato", "weight" => "400"),
					);

			$data = get_option(SN.'_enigma_data');
	 		$typography = array();

			if( isset($data['typography']) )
			$typography = $data['typography'];
			



			foreach ($ioa_typo_list as $key => $typo) {
				
				$opt = 'default';

				if(  isset($typography[SN.'_'.$typo['id']."_font_type"]) )
				$opt = $typography[SN.'_'.$typo['id']."_font_type"]	;

				switch($opt)
				{
					case 'fontdeck' :  $this->fontdeck_fonts[] = array(  "selector" => $typo['selector']  ); break;
					case 'websafe' :  $this->websafe[] = array( "font" => $typography[SN.'_'.$typo['id']."_websafe_font"] , "selector" => $typo['selector']  ); break;
					case 'fontface' : 
									$id = $typography[SN.'_'.$typo['id']."_fontface_font"];

									$ff = array();
									$font_face_fonts = get_option(SN.'_fontface_fonts');
									if(!$font_face_fonts) $font_face_fonts = array();

									$this->fontface_fonts[] = array( "font_data" => $font_face_fonts[$id] , "selector" => $typo['selector']  );
											

									break;

					case 'google' : 

									$font_name = $typography[SN.'_'.$typo['id']."_google_font"];

									if($typography[SN.'_'.$typo['id']."_google_cfont"]!="")
										$font_name = $typography[SN.'_'.$typo['id']."_google_cfont"];

									$req = str_replace(" ","+",$font_name);
									$link = "http://fonts.googleapis.com/css?family={$req}";
									$weights = $subsets  = array();

									if($typography[SN.'_'.$typo['id']."fn_w"]!="" )
									{
										$weights = str_replace(' ','',$typography[SN.'_'.$typo['id']."fn_w"]);
										$weights = explode(',',$weights);
										//$weights = ':'.strtolower($weights);
										//$link = $link.$weights;
									}
									if($typography[SN.'_'.$typo['id']."fn_s"]!="" || $typography[SN.'_'.$typo['id']."fn_s"]!=",")
									{
										$subsets = str_replace('Extended','ext',$typography[SN.'_'.$typo['id']."fn_s"]);
										$subsets = str_replace(' ','-',$subsets);
										$subsets = strtolower($subsets);
										$subsets = explode(',',$subsets);
									}

									

									$this->google_fonts[] = array( "name" => $font_name , "link" => $link, "selector" => $typo['selector'] , "weight" => $weights , "subset" => $subsets );
									break;

					case 'default' : 
									$font_name = $default_typo_list[$typo['id']]['font'];
									$weights = $subsets  = array();

									
									$req = str_replace(" ","+",$font_name);
									$link = "http://fonts.googleapis.com/css?family={$req}";

									if( isset($default_typo_list[$typo['id']]['weight']) && ( $default_typo_list[$typo['id']]['weight']!="" || $default_typo_list[$typo['id']]['weight']!=",") )
									{
										$weights = str_replace(' ','',$default_typo_list[$typo['id']]['weight']);
										$weights = explode(',',$weights);
									}

									

									$this->google_fonts[] = array( "name" => $font_name , "link" => $link, "selector" => $typo['selector'] , "weight" => $weights, "subset" => $subsets );
									break;				
				}
				 
			}


			if( count($this->google_fonts) > 0 )	
			{
				add_action('wp_enqueue_scripts',array(&$this,"setGoogleFontScripts"));	
				add_action('wp_head',array(&$this,"setGoogleFontCode"));
			}
			

			if( count($this->fontface_fonts) > 0 )	
				add_action('wp_head',array(&$this,"setFontFaceScript"));

			if( count($this->fontdeck_fonts) > 0 )
			{
				add_action('wp_head',array(&$this,"setFontDeckCode"));	
				add_action('wp_head',array(&$this,"setFontDeckCSS"));	
			}

			add_action('wp_head',array(&$this,"setFontParameters"));

			if( count($this->websafe) > 0 )
			{
				add_action('wp_head',array(&$this,"setWebsafeCSS"));	
			}	

		}


		public function setGoogleFontScripts()
		{
			if(is_login_page()) return;
			
			$i =0;
			$google_fonts = $this->google_fonts;
			$new_array = array();

			//$google_fonts = array_unique($google_fonts);

			foreach ($google_fonts as $key => $font) {
					
				if( ! array_key_exists ($font['name'],$new_array) )
					$new_array[$font['name']] = array(  'link' => $font['link'] , 'weight' => array( $font['weight'] ), 'subset' => array( $font['subset'] ) );
				else
				{
					$new_array[$font['name']]['weight'][] = $font['weight'];
					$new_array[$font['name']]['subset'][] = $font['subset'];
				}
					
						
				}

				$weight = array();
					$subset = array();

				foreach ($new_array as $key => $font) {
						
					$link = $font['link'];

					$weight = array();
					$subset = array();

					foreach ($font['weight'] as $key => $w) {
						$weight = array_merge($weight,$w);

					}

					foreach ($font['subset'] as $key => $s) {
						$subset = array_merge($subset,$s);
					}

					$weight = array_unique($weight);
					$subset = array_unique($subset);
					

					$link .= ":".join(',',$weight);
					
					

					if( join(',',$subset)!='' )
					$link .= '&amp;subset='.join(',',$subset);
					

					wp_enqueue_style('google_font_'.($i++),$link);	

				}

				
		}

		function setWebsafeCSS()
		{
			$websafe = '';

			foreach ($this->websafe as $key => $font) {
				$websafe .= $font['selector']." { font-family: \"".$font["font"]."\";  }";

			}
			

			echo "<style type='text/css'>".$websafe."</style>";
		}

		function setFontDeckCSS()
		{
			$fontdeck_query = '';
			$data = get_option(SN.'_enigma_data');
			foreach ($this->fontdeck_fonts as $key => $font) {
				$fontdeck_query .= $font['selector']." { font-family: \"".$data[SN."_font_deck_name"]."\";  }";

			}
			

			echo "<style type='text/css'>".$fontdeck_query."</style>";
		}
		function setFontDeckCode()
		{
			$data = get_option(SN.'_enigma_data');
	 		
			?>
			<script type="text/javascript">
			WebFontConfig = { fontdeck: { id: '<?php echo $data[SN."_font_deck_project_id"] ?>' } };

			(function() {
			  var wf = document.createElement('script');
			  wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			  wf.type = 'text/javascript';
			  wf.async = 'true';
			  var s = document.getElementsByTagName('script')[0];
			  s.parentNode.insertBefore(wf, s);
			})();
			</script>
			<?php
		}

		function setFontFaceScript()
		{
			$fontface_query = '';
			foreach ($this->fontface_fonts as $key => $font) {
				$f = $font['font_data'];

				$eot = $f['eot'];
				$woff = $f['woff'];
				$ttf = $f['ttf'];
				$svg = $f['svg'];

				if( is_multisite() )
				{
					

					$eot = str_replace('uploads', 'uploads/sites/'.get_current_blog_id().'/',$eot);
					$woff = str_replace('uploads', 'uploads/sites/'.get_current_blog_id().'/',$woff);
					$eot = str_replace('uploads', 'uploads/sites/'.get_current_blog_id().'/',$eot);
					$eot = str_replace('uploads','uploads/sites/'.get_current_blog_id().'/',$eot);

				}

				$fontface_query .= "

							@font-face {
										    font-family: '".$f['name']."';
										    src: url('".$eot."');
										    src: url('".$eot."?#iefix') format('embedded-opentype'),
										         url('".$woff."') format('woff'),
										         url('".$ttf."') format('truetype'),
										         url('".$svg."#verbregular') format('svg');
										    font-weight: normal;
										    font-style: normal;

										}
							".$font['selector']." { font-family: \"".$f['name']."\";  }

							";

			}
			

			echo "<style type='text/css'>".$fontface_query."</style>";				
		}

		

		function setGoogleFontCode()
		{

			$css_code = ''; $w = '';
			
			
			
			foreach ($this->google_fonts as $key => $font) {
						
						if(isset($font['weight'][0])) $w = $font['weight'][0];
						$css_code .= $font['selector']."{ font-family:\"".$font['name']."\",Helvetica,Arial; font-weight:".$w."  } \n ";

				}
			echo "<style> $css_code </style>";	
		}

	}
}

if( ! is_admin() )
$fonts = new IOAFont();



 ?>