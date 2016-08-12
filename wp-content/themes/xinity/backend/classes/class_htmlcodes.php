<?php
/**
 * Main Class for Generating Resuable HTML Widgets
 */

if(!class_exists('IOAHTMLCOMP')) {

// == Class defination begins	=====================================================
  
  class IOAHTMLCOMP {


  static function tooltip($title = '',$desc='')
  {

  		return '
  		<div class="ioa-tooltip">
  			 <h4> '.$title.'</h4>
         <p> '.$desc.'</p>
  			 <i class="ioa-front-icon down-diricon-"></i>
  		</div>';

  }	

  static function hoverable( $o = array() )
  {

      $str = '';

      

  }


  }


}
	  