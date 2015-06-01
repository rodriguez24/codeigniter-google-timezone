<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Config for the Google Timezone library
 *
 * @see ../libraries/Google_timezone.php
 */

// Use DB to get values
$CI =& get_instance();
$key = $CI->db->query("SELECT code, string_value FROM settings WHERE code ='GOOGLE_TIMEZONE_API_KEY'")->row()->string_value;

// Google credentials
$config['google_timezone_api_key'] = $key;
