<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Google Timezone
 *
 * A CodeIgniter library to interact with Google Timezone api
 *
 * @package       CodeIgniter
 * @category      Libraries
 * @author        Juan Rodriguez
 * @link          https://github.com/rodriguez24/codeigniter-google-timezone
 * @link          http://dothashcode.com
 * @EmailAddress  juanrodriguez@outlook.com
 * @license       http://www.opensource.org/licenses/mit-license.html
 */
class Google_timezone {

  public $debug = FALSE;

  private $_ci;       // CodeIgniter instance
  private $_api_key;  // Google Api Key
  private $_tz_id;

  /**
   * Constructor
   */
  function __construct() {
    log_message('debug', 'Google Timezone Class Initialized');
    $this->_ci =& get_instance();

    // Load all config items
    $this->_ci->load->config('google_timezone');
    $this->_api_key = $this->_ci->config->item('google_timezone_api_key');
  }

  /**
   * Debug
   *
   * Makes send() return the actual API response instead of a bool
   * @param  bool
   * @return  void
   */
  public function debug($bool) {
    $this->debug = (bool)$bool;
  }

  /**
   * @param $lat string
   * @param $lon string
   * @return string NULL if not found, otherwise the timzone reference e.g. 'UM7'
   */
  public function get_timezone_reference($lat, $lon) {
    // Google uses tz IDs. See http://en.wikipedia.org/wiki/List_of_tz_database_time_zones.
    // We want the timzone reference since it is what we use throughout our system

    if (!$this->_api_request($lat, $lon)) {
      // Default to UTC since we don't want to fail
      return NULL;
    }

    switch ($this->_tz_id) {
      case 'America/Adak':
        $tz_ref = 'UM10';
        break;
      case 'America/Anchorage':
        $tz_ref = 'UM9';
        break;
      case 'America/Boise':
        $tz_ref = 'UM7';
        break;
      case 'America/Chicago':
        $tz_ref = 'UM6';
        break;
      case 'America/Denver':
        $tz_ref = 'UM7';
        break;
      case 'America/Detroit':
        $tz_ref = 'UM5';
        break;
      case 'America/Indiana/Indianapolis':
        $tz_ref = 'UM5';
        break;
      case 'America/Indiana/Knox':
        $tz_ref = 'UM6';
        break;
      case 'America/Indiana/Marengo':
        $tz_ref = 'UM5';
        break;
      case 'America/Indiana/Petersburg':
        $tz_ref = 'UM5';
        break;
      case 'America/Indiana/Tell_City':
        $tz_ref = 'UM6';
        break;
      case 'America/Indiana/Valparaiso':
        $tz_ref = 'UM6';
        break;
      case 'America/Indiana/Vevay':
        $tz_ref = 'UM5';
        break;
      case 'America/Indiana/Vincennes':
        $tz_ref = 'UM5';
        break;
      case 'America/Indiana/Winamac':
        $tz_ref = 'UM5';
        break;
      case 'America/Juneau':
        $tz_ref = 'UM9';
        break;
      case 'America/Kentucky/Louisville':
        $tz_ref = 'UM5';
        break;
      case 'America/Kentucky/Monticello':
        $tz_ref = 'UM5';
        break;
      case 'America/Los_Angeles':
        $tz_ref = 'UM8';
        break;
      case 'America/Menominee':
        $tz_ref = 'UM6';
        break;
      case 'America/Metlakatla':
        $tz_ref = 'UM8';
        break;
      case 'America/New_York':
        $tz_ref = 'UM5';
        break;
      case 'America/Nome':
        $tz_ref = 'UM9';
        break;
      case 'America/North_Dakota/Beulah':
        $tz_ref = 'UM6';
        break;
      case 'America/North_Dakota/Center':
        $tz_ref = 'UM6';
        break;
      case 'America/North_Dakota/New_Salem':
        $tz_ref = 'UM6';
        break;
      case 'America/Phoenix':
        $tz_ref = 'UM7';
        break;
      case 'America/Shiprock':
        $tz_ref = 'UM7';
        break;
      case 'America/Sitka	Alaska Time':
        $tz_ref = 'UM9';
        break;
      case 'America/Yakutat':
        $tz_ref = 'UM9';
        break;
      case 'Pacific/Honolulu	Hawaii':
        $tz_ref = 'UM10';
        break;
      default:
        $tz_ref = NULL;
    }

    return $tz_ref;
  }

  private function _api_request($lat, $lon) {
    $json_str = file_get_contents(
      'https://maps.googleapis.com/maps/api/timezone/json?timestamp='.now().'&location='.$lat.','.$lon.'&key='.$this->_api_key);
    $response = json_decode($json_str);

    if ($response->status == 'OK') {
      $this->_tz_id = $response->timeZoneId;
    } else {
      return FALSE;
    }

    // Return the actual response when in debug or if requested specifically
    if ($this->debug === TRUE) {
      return $response;
    }

    return TRUE;
  }

}