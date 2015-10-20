<?php
// Load the necessary classes 
use Infogram\InfogramRequest;
use Infogram\RequestSigningSession;

class Infogram
{
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
    if($this->check_settings() === true) {
      $this->valid = true;
    }
  }

  function __destruct() {}

  // check answer from server
  function is_ok($response) {
    if(!$response) {
      return 'ERROR: Cannot connect to the server';
    }

    if(!$response->isOK()) {
      return 'ERROR: Could not execute request';
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
    $st = ($this->check_settings() !== true) ?
      array('error', 'Incorrect settings! Plugin is not active.', $this->check_settings()) :
      array('updated', 'Plugin is active.', '');

    printf('<div id="setting-error-settings_updated" class="%s settings-error"><p><strong>%s</strong></br><strong>%s</strong></p></div>', $st[0], $st[1], $st[2]);
  }

  // get settings status
  function is_valid() {
    return $this->valid;
  }

  // send request to server
  function send_request($method,$param) {
    $session = new RequestSigningSession($this->api_key, $this->api_secret);
    $request = new InfogramRequest($session, $method, $param);
    $response = $request->execute();

    return $response;
  }

  // send request to server
  function get_all_inforgams() {
    $response = $this->send_request('GET', 'users/'.$this->username.'/infographics');
    if($this->is_ok($response) === true) {
      $infographics = $response->getBody();
      if (empty($infographics)) {
        return sprintf('<div id="setting-error-settings_updated" class="error settings-error"><p><strong>%s</strong></p></div>', 'There are no public infographics for this user');
      } else {
        return $infographics;
      }
    }
  }
}
