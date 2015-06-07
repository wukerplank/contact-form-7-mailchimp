<?php
namespace WPCF7MC;

// This is a very basic implementation of a Mailchimp API (v3) client.
// Its sole purpose is to provide the functionality to add new
// subscribers to an existing Mailchimp list.
// At this point it is very much "fire-and-forget" as it does not
// do any error handling.
class Mailchimp {

  private $api_key;
  public $datacenter;

  function __construct ($a_api_key) {
    $this->api_key = $a_api_key;
    $this->datacenter = $this->infer_datacenter_from_api_key($a_api_key);
  }

  // $subscriber_data may include keys like:
  // FNAME ... firstname
  // LNAME ... lastname
  function subscribe ($list_id, $email_address, $subscriber_data) {
    $data = array(
      'email_address' => $email_address,
      'status' => 'subscribed'
    );
    if ($subscriber_data !== null) {
      $data['merge_fields'] = $subscriber_data;
    }

    $response = $this->post('lists/' . $list_id . '/members', $data);

    return $response;
  }

  // Returns all of the lists of this account
  function get_lists () {
    return $this->get('lists');
  }

  // Returns a specific list of this account
  function get_list ($list_id) {
    return $this->get('lists/' . $list_id);
  }

  // Returns a list of all the subscribers of a list
  function get_members($list_id) {
    return $this->get('lists/' . $list_id . '/members');
  }

  // Performs a POST request to the Mailchimp API
  private function post ($path, $data = array()) {
    $url = $this->mailchimp_url($path);
    $options = $this->curl_options(array(
      CURLOPT_URL => $url,
      CURLOPT_POST => true,
      CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
      CURLOPT_POSTFIELDS => json_encode($data)
    ));

    return $this->make_request($options);
  }

  // Performs a PATCH request to the Mailchimp API
  private function patch ($path, $data = array()) {
    $url = $this->mailchimp_url($path);
    $options = $this->curl_options(array(
      CURLOPT_URL => $url,
      CURLOPT_CUSTOMREQUEST => 'PATCH',
      CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
      CURLOPT_POSTFIELDS => json_encode($data)
    ));

    return $this->make_request($options);
  }

  // Performs a GET request to the Mailchimp API
  private function get ($path) {
    $url = $this->mailchimp_url($path);
    $options = $this->curl_options(array(CURLOPT_URL => $url));

    return $this->make_request($options);
  }

  // Does the acutal work of perorming a request via CURL
  private function make_request ($options) {
    $curl = curl_init('Mailchimp API');
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    if (count($body) > 0) {
      $data = json_decode($body);
    }

    return array('header' => $header, 'body' => $data);
  }

  // Returns a hash of all necessary options for CURL
  private function curl_options ($options) {
    $default_options = array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER => true,
      CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
      CURLOPT_USERPWD => 'wpcf7mc:' . $this->api_key
    );

    return $default_options + $options;
  }

  // Returns a Mailchimp URL with the right datacenter subdomain
  public function mailchimp_url ($path = '') {
    return 'https://' . $this->datacenter . '.api.mailchimp.com/3.0/' . $path;
  }

  // Extracts the datacenter information from the API key
  private function infer_datacenter_from_api_key ($a_api_key) {
    $key_parts = explode('-', $a_api_key);

    if (count($key_parts) > 1) {
      return array_pop($key_parts);
    }

    return '';
  }
}

?>
