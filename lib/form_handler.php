<?php
namespace WPCF7MC;

class FormHandler {

  private $true_subscribe_values = array('ok', 'yes', 'true', '1');
  private $email_regex = "/\A.*?@.*?\z/i";
  private $form_configuration;
  private $form_data;

  // true if the user accepted to be subscribed
  public $has_mailchimp_settings = false;
  public $should_subscribe = false;
  public $has_valid_email = false;
  public $error;

  function __construct($a_form_configuration, $the_form_data) {
    $this->form_configuration = $a_form_configuration;
    $this->form_data = $the_form_data;

    if ($this->check_mailchimp_settings() === true) {
      if ($this->check_subscribe_status() === true) {
        $this->check_email_field_status();
      }
    }
  }

  // Subscribes if everything is in order
  public function subscribe () {
    if ($this->subscribable()) {
      return $this->perform_subscribe();
    }

    return false;
  }

  // Does the actual work of subscribing
  public function perform_subscribe () {
    $mc = new \WPCF7MC\Mailchimp($this->mailchimp_api_token());

    try {
      $response = $mc->subscribe($this->mailchimp_list_id(), $this->email_value(), $this->subscriber_data());

      // TODO check the header for a 200 status
      return true;
    }
    catch (Exception $e) {
      $this->error = $e;
      // Quietly ignore
    }

    return false;
  }

  // Checks if everything is in order
  function subscribable () {
    return $this->has_mailchimp_settings && $this->should_subscribe && $this->has_valid_email;
  }

  // Sets the has_mailchimp_settings
  private function check_mailchimp_settings () {
    $this->has_mailchimp_settings = ($this->mailchimp_api_token() !== null && $this->mailchimp_list_id() !== null);
    return $this->has_mailchimp_settings;
  }

  // Sets the has_valid_email field to true if the email field was configured and
  // if the user submitted a valid-ish email address (must contain an @ sign).
  private function check_email_field_status () {
    // See if the email field is configured
    if ($this->email_field() !== null) {
      // See if a value was set
      if ($this->email_value() !== null) {
        // See if the email address is valid-ish
        if (preg_match($this->email_regex, $this->email_value())) {
          $this->has_valid_email = true;
        }
      }
    }

    return $this->has_valid_email;
  }

  // Sets the should_subscribe property to true if no accept field was configured or
  // if the user submitted ok, yes, true or 1 in the accept field.
  private function check_subscribe_status () {
    // See if the subscribe field is configured
    if ($this->subscribe_field() !== null) {

      $subscribe_value = $this->subscribe_value();

      // See if the user submitted a value that gives us the go-ahead
      if ($subscribe_value !== null) {

        // For some obscure reason CF7 wraps values of radio groups in arrays
        if (is_array($subscribe_value)) {
          $subscribe_value = array_pop($subscribe_value);
        }

        if (in_array(strtolower($subscribe_value), $this->true_subscribe_values)) {
          $this->should_subscribe = true;
        }
      }
    }
    else {
      $this->should_subscribe = true;
    }

    return $this->should_subscribe;
  }

  // Configuration fields -------------------------------------------------------------------------

  private function mailchimp_api_token () {
    return $this->get_field(WPCF7MC_FIELD_MAILCHIMP_API_TOKEN);
  }

  private function mailchimp_list_id () {
    return $this->get_field(WPCF7MC_FIELD_MAILCHIMP_LIST_ID);
  }

  private function email_field () {
    return $this->get_field(WPCF7MC_FIELD_EMAIL);
  }

  private function firstname_field () {
    return $this->get_field(WPCF7MC_FIELD_FIRSTNAME);
  }

  private function lastname_field () {
    return $this->get_field(WPCF7MC_FIELD_LASTNAME);
  }

  private function subscribe_field () {
    return $this->get_field(WPCF7MC_FIELD_SUBSCRIBE);
  }

  // $number must be >= 1
  private function custom_form_field ($number) {
    return $this->get_field(WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . $number);
  }

  // $number must be >= 1
  private function custom_mailchimp_field ($number) {
    return $this->get_field(WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . $number);
  }

  // Utility method that returns fields from the configuration hash
  private function get_field($field) {
    if (isset($this->form_configuration[$field]) && !empty($this->form_configuration[$field])) {
      return $this->form_configuration[$field];
    }
    return null;
  }

  // Form values ----------------------------------------------------------------------------------

  public function subscriber_data () {
    $subscriber_data = array();

    if ($this->firstname_value() !== null) {
      $subscriber_data['FNAME'] = $this->firstname_value();
    }

    if ($this->lastname_value() !== null) {
      $subscriber_data['LNAME'] = $this->lastname_value();
    }

    if (count($subscriber_data) > 0) {
      return $subscriber_data + $this->custom_mailchimp_values();
    }

    return null;
  }

  private function email_value () {
    return $this->get_form_value(WPCF7MC_FIELD_EMAIL);
  }

  private function firstname_value () {
    return $this->get_form_value(WPCF7MC_FIELD_FIRSTNAME);
  }

  private function lastname_value () {
    return $this->get_form_value(WPCF7MC_FIELD_LASTNAME);
  }

  private function subscribe_value () {
    return $this->get_form_value(WPCF7MC_FIELD_SUBSCRIBE);
  }

  // $number must be >= 1
  private function custom_form_field_value ($number) {
    $field = $this->custom_form_field($number);

    if (isset($this->form_data[$field]) && !empty($this->form_data[$field])) {
      return $this->form_data[$field];
    }

    return null;
  }

  // Extracts all custom fields from the form data
  private function custom_mailchimp_values () {
    $custom_mailchimp_values = array();
    $i = 1;
    while ($this->custom_form_field($i) !== null) {
      $custom_mailchimp_values[$this->custom_mailchimp_field($i)] = $this->custom_form_field_value($i);
      $i++;
    }

    return $custom_mailchimp_values;
  }

  private function get_form_value($field) {
    if ($this->get_field($field) !== null) {
      if (isset($this->form_data[$this->get_field($field)]) && !empty($this->form_data[$this->get_field($field)])) {
        return $this->form_data[$this->get_field($field)];
      }
    }

    return null;
  }
}

?>
