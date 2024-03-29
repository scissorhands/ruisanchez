<?php
/**
 * IOA Framework Custom Hooks
 * @author Abhin Sharma [WPIOAs]
 * @version 1.0
 * @package Hades Framework
 */


/**
 * Hook that runs after WP HEAD action
 */
function IOA_head() {
	do_action('IOA_head');
}

/**
 * Hook that Outputs Title 
 */

function IOA_title()
{
	do_action('IOA_title');
}

/**
 * Hook after starting of body tag
 */

function IOA_body_start()
{
	do_action('IOA_body_start');
}


/**
 * Hook after ending of body tag
 */

function IOA_body_end()
{
	do_action('IOA_body_end');	
}


