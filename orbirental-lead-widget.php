<?php
/*
  Plugin Name: Hostfully Booking
  Plugin URI: https://www.hostfully.com/
  Description: Add the Hostfully Booking Plugin for Wordpress
  Version: 4.0
  Author: Hostfully Inc
  License: GPLv2+
  Text Domain: orbirental-lead-widget
*/

define('HOSTFULLY__PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once(HOSTFULLY__PLUGIN_DIR . 'includes/meta.php');
require_once(HOSTFULLY__PLUGIN_DIR . 'includes/settings.php');

function wpb_load_widget()
{
	register_widget('hostfully_booking_widget');
}

function load_admin_scripts()
{
	// Enqueue jQuery
	wp_enqueue_script('jquery');
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('wp-color-picker');

	wp_register_script('hf-pikaday', "https://platform.hostfully.com/assets/js/pikaday.js");
	wp_register_script('hf-lead-capture-widget', "https://platform.hostfully.com/assets/js/leadCaptureWidget_2.0.js");
	wp_register_script('hf-script', plugins_url('js/script.js', __FILE__), array('jquery', 'wp-color-picker', 'hf-lead-capture-widget'), false, true);

	wp_enqueue_script('hf-pikaday');
	wp_enqueue_script('hf-lead-capture-widget');
	wp_enqueue_script('hf-script');
}

add_action('widgets_init', 'wpb_load_widget');

add_action('widgets_init', 'load_admin_scripts', 100);

// Creating the widget 
class hostfully_booking_widget extends WP_Widget
{

	function __construct()
	{
		parent::__construct(

			// Base ID of your widget
			'hostfully_booking_widget',

			// Widget name will appear in UI
			__('Hostfully Booking Widget', 'hostfully_booking_widget_domain'),

			// Widget description
			array('description' => __('Hostfully booking widget', 'hostfully_booking_widget_domain'),)
		);
	}

	// Creating widget front-end
	public function widget($args, $instance)
	{
		$options = get_option('hostfully_booking_widget_settings');

		// Check property uid
		if(!empty(get_post_meta( get_the_ID(), 'property_uid', true ))) {
			$property_uid = get_post_meta( get_the_ID(), 'property_uid', true );
		} else {
			$property_uid = isset($options['hostfully-property-uid']) ? $options['hostfully-property-uid'] : '';
		}

		if (!isset($property_uid) || trim($property_uid) == "") {
			return;
		}
        
		// Fields
		$showPhoneField = isset($options['hf-show-phone']) == '1' ? 'true' : 'false';
        $showNotesField = isset($options['hf-show-notes']) == '1' ? 'true' : 'false';
        
		// Options
		$showPriceDetails = isset($options['hf-show-price-details']) == '1' ? 'true' : 'false';
        $showPrice = isset($options['hf-show-price']) == '1' ? 'true' : 'false';
        $showMinStay = isset($options['hf-show-minStay']) == '1' ? 'true' : 'false';
        $showAvailability = isset($options['hf-show-availability']) == '1' ? 'true' : 'false';
        
		// Colors
		$widgetColor = !empty($options['hf-widgetColor']) ? $options['hf-widgetColor'] : '#ffffff';
		$textColor = !empty($options['hf-textColor']) ? $options['hf-textColor'] : '#F8981B';
		$buttonBackgroundColor = !empty($options['hf-buttonBackgroundColor']) ? $options['hf-buttonBackgroundColor'] : '#F8981B';

		$fields = array();
		if (!empty($instance['showPhoneField']) && $showPhoneField == 'true')
			array_push($fields, "\"phone\"");
		if (!empty($instance['showNotesField']) && $showNotesField == 'true')
			array_push($fields, "\"notes\"");
		$fieldsString = '[' . join(',', $fields) . ']';

		
		// Render Widget
		echo __('<div id="leadWidget"></div>', 'hostfully_booking_widget_domain');
		echo '<script>var widget = new Widget("leadWidget", "' . $property_uid . '", {"type":"agency","fields":' . $fieldsString . ',"showAvailability":' . $showAvailability . ',"lang":"US","minStay":' . $showMinStay . ',"price":' . $showPrice . ',"cc":false,"emailClient":false,"saveCookie":true,"showDynamicMinStay":true,"backgroundColor":"' . $widgetColor . '","buttonSubmit":{"backgroundColor":"' . $buttonBackgroundColor . '"},"showPriceDetailsLink":' . $showPriceDetails . ',"showGetQuoteLink":false,"labelColor":"' . $textColor . '","showTotalWithoutSD":true,"redirectURL":false});</script>';
		echo $args['after_widget'];

	}

	// Widget Backend 
	public function form($instance)
	{ 
?>
		<p style="font-size: 16px;">Go to the <a href="options-general.php?page=hostfully_booking_widget-settings">Settings page</a> to edit the widget.</p>

<?php
	}

} // Class hostfully_booking_widget ends here

// Add Settings Link
function hostfully_booking_widget_add_settings_link($links)
{
	$settings_link = '<a href="options-general.php?page=hostfully_booking_widget-settings">Settings</a>';
	array_push($links, $settings_link);
	return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'hostfully_booking_widget_add_settings_link');
