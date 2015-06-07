<?php

namespace WPCF7MC;

require 'lib/form_handler.php';

class FormHandlerTest extends \PHPUnit_Framework_TestCase {

  // The form configuration hash (without subscribe field) that will be reused throughout the tests
  private function form_configuration_without_subscribe () {
    return array(
      WPCF7MC_FIELD_MAILCHIMP_API_TOKEN => 'ABCDEFGHIJK123456789-us4',
      WPCF7MC_FIELD_MAILCHIMP_LIST_ID => 'abcdef123456',
      WPCF7MC_FIELD_EMAIL => 'email',
    );
  }

  // The form configuration hash (with subscribe field) that will be reused throughout the tests
  private function form_configuration_with_subscribe () {
    return $this->form_configuration_without_subscribe() + array(WPCF7MC_FIELD_SUBSCRIBE => 'subscribe');
  }

  public function test_does_nothing_without_data () {
    $form_handler = new \WPCF7MC\FormHandler(array(), array());

    // Individual requirements for a subscription are false
    $this->assertEquals(false, $form_handler->has_mailchimp_settings);
    $this->assertEquals(false, $form_handler->should_subscribe);
    $this->assertEquals(false, $form_handler->has_valid_email);

    $this->assertEquals(false, $form_handler->subscribable());
    $this->assertEquals(false, $form_handler->subscribe());
  }

  public function test_is_subscribable_with_necessary_data () {
    $form_data = array(
      'email' => 'test@test.at',
      'subscribe' => 'true'
    );

    $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_with_subscribe(), $form_data);
    $this->assertEquals(true, $form_handler->subscribable());
    // Don't run $form_handler->subscribe() as we don't live test against the live API
  }

  public function test_needs_mailchimp_credentials () {
    $form_configuration = array(
      WPCF7MC_FIELD_MAILCHIMP_API_TOKEN => 'ABCDEFGHIJK123456789-us4',
      WPCF7MC_FIELD_MAILCHIMP_LIST_ID => 'abcdef123456'
    );

    $form_handler = new \WPCF7MC\FormHandler($form_configuration, array());

    $this->assertEquals(true, $form_handler->has_mailchimp_settings);
  }

  public function test_needs_an_email_field_in_the_form () {
    $invalid_email_form_data = array(
      'email' => 'www.test.at'
    );
    $valid_email_form_data = array(
      'email' => 'test@test.at'
    );

    $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_without_subscribe(), $invalid_email_form_data);
    $this->assertEquals(false, $form_handler->has_valid_email);

    $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_without_subscribe(), $valid_email_form_data);
    $this->assertEquals(true, $form_handler->has_valid_email);
  }

  public function test_is_subscribable_if_no_subscribe_field_is_defined () {
    $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_without_subscribe(), array('email' => 'test@test.com'));
    $this->assertEquals(true, $form_handler->subscribable());
  }

  public function test_user_needs_to_accept_subscription_if_configured () {
    // Check a bunch of values; all should prevent the handler from subscribing
    $invalid_accepts = array('', 'false', 'FALSE', 'no', 'NO', 'bogus', 'foo', 'bar');
    foreach($invalid_accepts as $invalid_accept) {
      $form_data = array(
        'email' => 'test@test.at',
        'subscribe' => $invalid_accept
      );

      $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_with_subscribe(), $form_data);
      $this->assertEquals(false, $form_handler->should_subscribe);
    }

    // Check a bunch of valid values; all should allow the subscriber to subscibe
    $valid_accepts = array('1', 'true', 'TRUE', 'yes', 'YES', 'ok', 'OK');
    foreach($valid_accepts as $valid_accept) {
      $form_data = array(
        'email' => 'test@test.at',
        'subscribe' => $valid_accept
      );

      $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_with_subscribe(), $form_data);
      $this->assertEquals(true, $form_handler->has_valid_email);
    }
  }

  public function test_handles_accept_value_inside_array () {
    $form_data = array(
      'email' => 'test@test.at',
      'subscribe' => array('yes')
    );

    $form_handler = new \WPCF7MC\FormHandler($this->form_configuration_with_subscribe(), $form_data);
    $this->assertEquals(true, $form_handler->has_valid_email);
  }

  public function test_translates_name_to_mailchimp_fields () {
    $form_configuration = $this->form_configuration_without_subscribe();
    $form_configuration = $form_configuration + array(
      WPCF7MC_FIELD_FIRSTNAME => 'firstname',
      WPCF7MC_FIELD_LASTNAME => 'lastname'
    );
    $form_data = array('email' => 'test@test.com', 'firstname' => 'John', 'lastname' => 'Doe');
    $expected_data = array(
      'FNAME' => 'John',
      'LNAME' => 'Doe'
    );

    $form_handler = new \WPCF7MC\FormHandler($form_configuration, $form_data);

    $this->assertEquals($expected_data, $form_handler->subscriber_data());
  }

  public function test_translates_custom_fields_properly () {
    $form_configuration = $this->form_configuration_without_subscribe();
    $form_configuration = $form_configuration + array(
      WPCF7MC_FIELD_FIRSTNAME     => 'firstname',
      WPCF7MC_FIELD_LASTNAME      => 'lastname',
      WPCF7MC_FIELD_CUSTOM_FIELDS => '1',
      WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . '1'      => 'street',
      WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . '1' => 'STREET',
      WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . '2'      => 'zip',
      WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . '2' => 'ZIP',
      WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . '3'      => 'city',
      WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . '3' => 'CITY',
      WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . '4'      => 'state',
      WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . '4' => 'STATE',
      WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . '5'      => 'phone',
      WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . '5' => 'PHONE',
      WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . '6'      => 'birthyear',
      WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . '6' => 'BIRTHYEAR'
    );
    $form_data = array(
      'firstname' => 'John',
      'lastname' => 'Doe',
      'street' => 'Infinity Drive 1',
      'zip' => '12345',
      'state' => 'California',
      'city' => 'San Francisco',
      'phone' => '1 234 56789',
      'birthyear' => '1970'
    );
    $expected_data = array(
      'FNAME' => 'John',
      'LNAME' => 'Doe',
      'STREET' => 'Infinity Drive 1',
      'ZIP' => '12345',
      'STATE' => 'California',
      'CITY' => 'San Francisco',
      'PHONE' => '1 234 56789',
      'BIRTHYEAR' => '1970'
    );

    $form_handler = new \WPCF7MC\FormHandler($form_configuration, $form_data);

    $this->assertEquals($expected_data, $form_handler->subscriber_data());
  }
}

?>
