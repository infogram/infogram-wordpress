<?php
// Load the necessary classes
use Infogram\InfogramRequest;
use Infogram\RequestSigningSession;

class Infogram {
  // Api key
  private $api_key;

  // API secret
  private $api_secret;

  // Username
  private $username;

  // Valid user settings
  private $valid = false;

  function __construct($init) {
    $this->api_key = $init['api_key'];
    $this->api_secret = $init['api_secret'];
    $this->username = $init['username'];
    // if($this->check_settings() === true) {
      $this->valid = true;
    // }
  }

  function __destruct() {}

  // validate form
  function is_form_filled() {
    if ($this->api_key == '' || $this->api_secret == '' || $this->username == '') {
      return false;
    } else {
      return true;
    }
  }

  // check answer from server
  function is_ok($response) {
    if(!$response) {
      return __('ERROR: Cannot connect to the server', 'infogram');
    }

    if(!$response->isOK()) {
      return __('ERROR: Could not execute request', 'infogram');
    }

    return true;
  }

  // check user settings
  function check_settings() {
    $return = NULL;
    try {
        $response = $this->send_request('GET', 'users/'.$this->username.'/infographics');
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

    $check = $this->is_ok($response);
    if($check === true) return true;

    return $check;
  }

  // get error message
  function plugin_status() {
    if ($this->is_form_filled() !== true) {
      printf('<div id="setting-error-settings_updated" class="notice notice-warning inline below-h2"><p>%s</p><p><strong></strong></p></div>', __('Warning: Plugin is not active.', 'infogram'), __('Please fill out the form below.', 'infogram'));
    } else {
      $st = ($this->check_settings() !== true) ?
        array('error', __('Incorrect settings! Plugin is not active.', 'infogram'), $this->check_settings()) :
        array('updated', __('Plugin is active.', 'infogram'), '');

      printf('<div id="setting-error-settings_updated" class="%s settings-error"><p><strong>%s</strong></br><strong>%s</strong></p></div>', $st[0], $st[1], $st[2]);
    }
  }

  function check_is_valid() {
    if($this->check_settings() !== true) {
      $this->valid = false;
    }
    return $this->valid;
  }

  // get settings status
  function is_valid() {
    return $this->valid;
  }

  // send request to server
  function send_request($method, $param) {
    $session = new RequestSigningSession($this->api_key, $this->api_secret);
    $request = new InfogramRequest($session, $method, $param);
    $response = $request->execute();

    return $response;
  }

  // send request to server
  function get_all_inforgaphics() {
    $response = $this->send_request('GET', 'users/'.$this->username.'/infographics');
    if($this->is_ok($response) === true) {
      $infographics = $response->getBody();
      if (empty($infographics)) {
        return sprintf('<div id="setting-error-settings_updated" class="error settings-error"><p><strong>%s</strong></p></div>', __('There are no public infographics for this user', 'infogram'));
      } else {
        return $infographics;
      }
    }
  }
}
