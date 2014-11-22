<?php

/**
 * @package MercadoBitcoin
 * @version 1.0
 */
/*
  Plugin Name: MercadoBitcoin
  Plugin URI: http://wordpress.org/plugins/MercadoBitcoin/
  Description: This plugin show the last currencies for BTC.
  Author: cArLiiToX
  Version: 1.0
  Author URI: https://www.facebook.com/cArLiiToX.Miguel
 */



/* * **********************************************
 * Global Variables
  /*********************************************** */

global $wp_roles;

register_activation_hook(__FILE__, 'plugin_install');
register_deactivation_hook(__FILE__, 'plugin_unininstall');

// Create admin page.
// Add settings link on plugin page
function mercadobitcoin_ticker_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=mercadobitcoin_ticker_settings_page">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'mercadobitcoin_ticker_settings_link' );

/* * **********************************************
 * Includes
  /*********************************************** */

include('lib/classes/ticker-class.php');
include('lib/install.php');
include('lib/admin-page.php');
include('lib/ticker-widget.php');

