<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $ioa_meta_data;
?>
<!--
	<h2 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h2>
	-->

	<h1 class="custom-title"  >  <?php echo $ioa_meta_data['title']; ?></h1>