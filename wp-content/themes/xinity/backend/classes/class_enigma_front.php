<?php 
/**
 * Creates a runtime css file for Enigma Styler, if folder is not writable it prints inline css.
 * @version 1.0
 */

if(!class_exists('EnigmaDynamic'))
{
	class EnigmaDynamic
	{
		private $dynamic_status = 'inline';
		private $filename = 'runtime.css';

		/**
		 * By Default Set Ouput to Inline
		 */	
		function __construct()
		{	
			$flag = get_option(SN.'_dynamic_css_status');
			if($flag) $this->dynamic_status = $flag;
		}

		/**
		 * Get Runtime Mode - inline / file
		 */

		function runtimeMode()
		{
			$upload_dir = wp_upload_dir();
			if(!file_exists($upload_dir['path'].'/'.$this->filename))
			{
				$this->dynamic_status = 'inline';
				update_option(SN.'_dynamic_css_status',$this->dynamic_status);
			}

			return $this->dynamic_status;
		}

		/**
		 * Runtime File name
		 */
		function getFileName()
		{
			$upload_dir = wp_upload_dir();
			return  $upload_dir['url'].'/'.$this->filename;
		}

		/**
		 * This function creates the file
		 */
		function createCSSFile()
		{
			$upload_dir = wp_upload_dir();

			$cssFile = $upload_dir['path'].'/'.$this->filename;
			$flag = 'inline';
			$fh = fopen($cssFile, 'w');

			if( is_writable($cssFile) )
			{
				
				$data = get_option(SN.'_enigma_data');
				$palette = array();

				if(isset($data['palette']))
					$palette = $data['palette'];

				

				$code = $this->getRuntimeCode($palette,$data);
				fwrite($fh, $code);
				
				$flag = 'file';
			}

			fclose($fh);
			
			update_option(SN.'_dynamic_css_status',$flag);
			update_option(SN.'_compiled_css',$code);
		}

		/**
		 * This Function Generates CSS Code
		 */

		function getRuntimeCode($palette,$data = array()){
		
		global $ioa_meta_data,$color_scheme_default;
		$cvals = '';

		$code = '';

		$ioa_meta_data['palette'] = $palette;
		
			
	
		$parsed_array = array();

			
			$filename = PATH."/backend/style_hash.txt";
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			$parsed_array = json_decode(base64_decode($content),true);
			set_transient('CACHE_PA',$parsed_array,60*60*24);
			

			$cases = array(
						
						 array(

						 		"element" => "i.longshadow-style , i.longshadow-style-circ",
						 		"property" => "text-shadow", 
								"syntax" => "[val] 1px 1px, [val] 2px 2px,[val] 3px 3px,[val] 4px 4px, [val] 5px 5px,[val] 6px 6px,[val] 7px 7px,[val] 8px 8px,  [val] 9px 9px,[val] 10px 10px,[val] 11px 11px,[val] 12px 12px, [val] 13px 13px,[val] 14px 14px,[val] 15px 15px,[val] 16px 16px, [val] 17px 17px,[val] 18px 18px,[val] 19px 19px,[val] 20px 20px, [val] 21px 21px,[val] 22px 22px,[val] 23px 23px,[val] 24px 24px   ,[val] 25px 25px,[val] 26px 26px,[val] 27px 27px,[val] 28px 28px ,[val] 29px 29px,[val] 30px 30px ,[val] 31px 31px,[val] 32px 32px  ,[val] 33px 33px,[val] 34px 34px,[val] 35px 35px",
								"darken" => true , "value" => 15

						 	)

						);

			if( isset($palette) && is_array($palette) && count($palette) > 0 ) 			
			foreach ($cases as $k => $case) {
							$c = $palette['primary_alt_color'];
							if( isset($case['darken']) )
								$c = adjustBrightness($c,-$case['value']);

							$code .= " ".$case['element']." {  ".$case['property']." : ".str_replace('[val]',$c,$case['syntax'])."; } "	;
						}
			if( isset($palette) && is_array($palette) && count($palette) > 0 ) 			
			foreach ($parsed_array as $key => $slabs) {
				
				if($key == 'gradient')
				{
					$pr_color = $color_scheme_default['primary_color'];
					if( isset( $palette['primary_color']) ) $pr_color = $palette['primary_color'];

					$pr_alt_color = $color_scheme_default['primary_alt_color'];
					if( isset( $palette['primary_alt_color']) ) $pr_alt_color = $palette['primary_alt_color'];
					$code .=  join(',',$slabs)." { background: -moz-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background : $pr_color;
						 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$pr_color."), color-stop(100%, ".$pr_alt_color."));
						 background: -webkit-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: -o-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: -ms-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: linear-gradient(to bottom, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='".$pr_color."', endColorstr='".$pr_alt_color."',GradientType=0 );

					 }";
				}

				if($key == 'menu_gradient')
				{
					$pr_color = $color_scheme_default['menu_primary_color'];
					if( isset( $palette['menu_primary_color']) ) $pr_color = $palette['menu_primary_color'];

					$pr_alt_color = $color_scheme_default['menu_primary_alt_color'];
					if( isset( $palette['menu_primary_alt_color']) ) $pr_alt_color = $palette['menu_primary_alt_color'];
					$code .=  join(',',$slabs)." { background: -moz-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: $pr_color;
						 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$pr_color."), color-stop(100%, ".$pr_alt_color."));
						 background: -webkit-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: -o-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: -ms-linear-gradient(top, ".$pr_color." 0%, ".$pr_alt_color." 100%);
						 background: linear-gradient(to bottom, ".$pr_color." 0%, ".$pr_alt_color." 100%);

					 }";
				}


				if($key == 'theme_button')
				{
					$pr_color = $color_scheme_default['primary_color'];
					if( isset( $palette['primary_color']) ) $pr_color = $palette['primary_color'];

					$pr_alt_color = $color_scheme_default['primary_alt_color'];
					if( isset( $palette['primary_alt_color']) ) $pr_alt_color = $palette['primary_alt_color'];
						
					$code .=  join(',',$slabs)." { 
						background-color: ".$pr_alt_color.";
						background-image: -webkit-gradient(linear, left bottom, right top, from(".$pr_color."), to(".$pr_alt_color."));
						background-image: -webkit-linear-gradient(left bottom, ".$pr_color.", ".$pr_alt_color.");
						background-image: -moz-linear-gradient(left bottom, ".$pr_color.", ".$pr_alt_color.");
						background-image: -o-linear-gradient(left bottom, ".$pr_color.", ".$pr_alt_color.");
						background-image: -ms-linear-gradient(left bottom, ".$pr_color.", ".$pr_alt_color.");
						background-image: linear-gradient(left bottom, ".$pr_color.", ".$pr_alt_color.");
					 }";
				}

				if( $key!='gradient' && $key != 'theme_button') {
					if(isset($palette[$key])) :	

				$color = $palette[$key];



				foreach ($slabs as $prop => $classes) {
						$cl = array();
						$m_prop = $prop;

						if($prop == 'border') $m_prop = 'border-color';	
						if($prop == 'background') $m_prop = 'background-color';	
						if($prop == 'border-bottom') $m_prop = 'border-bottom-color';	
						if($prop == 'border-left') $m_prop = 'border-left-color';	
						if($prop == 'border-right') $m_prop = 'border-right-color';	
						if($prop == 'border-top') $m_prop = 'border-top-color';	
						


						foreach ($classes as $key => $c) {

							if(!is_array($c))
								$cl[] = $c;
							else
							{

								switch($prop)
								{
									case 'box-shadow' :$code .=  $c['selector']." { ".$m_prop.":".str_replace('[ioa_ss]',$color,$c['ori_code'])."; }"; break;
								}
							}	
						}
						
						if($prop != 'box-shadow')
						$code .=  join(',',$cl)." { ".$m_prop.":".$color."; }";

					}


					endif;	

				}
				
			}
			

		return $code;
		}	  


	}
}

$enigma_runtime = new EnigmaDynamic();

//$enigma_runtime->createCSSFile();


 ?>