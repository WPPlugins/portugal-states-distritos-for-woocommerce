<?php
/*
 * Plugin Name: Portugal States (Distritos) for WooCommerce
 * Plugin URI: http://www.webdados.pt/produtos-e-servicos/internet/desenvolvimento-wordpress/portugal-states-distritos-woocommerce-wordpress/
 * Description: This plugin adds the Portuguese "States", known as "Distritos", to WooCommerce and sets the correct address format for Portugal
 * Version: 1.5.2
 * Author: Webdados
 * Author URI: http://www.webdados.pt
 * Text Domain: woocommerce-portugal-states
 * Domain Path: /lang
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Check if WooCommerce is active
 **/
// Get active network plugins - "Stolen" from Novalnet Payment Gateway
function wps_active_nw_plugins() {
	if (!is_multisite())
		return false;
	$wps_activePlugins = (get_site_option('active_sitewide_plugins')) ? array_keys(get_site_option('active_sitewide_plugins')) : array();
	return $wps_activePlugins;
}
if (in_array('woocommerce/woocommerce.php', (array) get_option('active_plugins')) || in_array('woocommerce/woocommerce.php', (array) wps_active_nw_plugins())) {

	//Languages
	add_action('plugins_loaded', 'woocommerce_portugal_states_init');
	function woocommerce_portugal_states_init() {
		load_plugin_textdomain('woocommerce-portugal-states', false, dirname(plugin_basename(__FILE__)) . '/lang/');
	}

	//The States
	add_filter('woocommerce_states', 'woocommerce_portugal_states');
	function woocommerce_portugal_states($states) {
		$states["PT"] = array(
			'AC' => __('Azores',			'woocommerce-portugal-states'),
			'AV' => __('Aveiro',			'woocommerce-portugal-states'),
			'BJ' => __('Beja',				'woocommerce-portugal-states'),
			'BR' => __('Braga',				'woocommerce-portugal-states'),
			'BG' => __('Bragança',			'woocommerce-portugal-states'),
			'CB' => __('Castelo Branco',	'woocommerce-portugal-states'),
			'CM' => __('Coimbra',			'woocommerce-portugal-states'),
			'EV' => __('Évora',				'woocommerce-portugal-states'),
			'FR' => __('Faro',				'woocommerce-portugal-states'),
			'GD' => __('Guarda',			'woocommerce-portugal-states'),
			'LR' => __('Leiria',			'woocommerce-portugal-states'),
			'LS' => __('Lisbon',			'woocommerce-portugal-states'),
			'MD' => __('Madeira',			'woocommerce-portugal-states'),
			'PR' => __('Portalegre',		'woocommerce-portugal-states'),
			'PT' => __('Oporto',			'woocommerce-portugal-states'),
			'ST' => __('Santarém',			'woocommerce-portugal-states'),
			'SB' => __('Setúbal', 			'woocommerce-portugal-states'),
			'VC' => __('Viana do Castelo',	'woocommerce-portugal-states'),
			'VR' => __('Vila Real',			'woocommerce-portugal-states'),
			'VS' => __('Viseu',				'woocommerce-portugal-states'),
		);
		return $states;
	}

	//Localization
	add_filter('woocommerce_get_country_locale', 'woocommerce_portugal_localization');
	function woocommerce_portugal_localization($countries) {
		$countries['PT']['postcode_before_city'] = true;
		$countries['PT']['state']['label'] = __('District', 'woocommerce');
		$countries['PT']['state']['required'] = true;
		return $countries;
	}

	//Correct portuguese address format
	add_filter('woocommerce_localisation_address_formats','woocommerce_portugal_address_format');
	function woocommerce_portugal_address_format($formats) {
		$formats['PT'] = "{name}\n{company}\n{address_1}\n{address_2}\n{postcode} {city}\n{state}\n{country}";
		return $formats;
	}

}

/* If you're reading this you must know what you're doing ;-) Greetings from sunny Portugal! */