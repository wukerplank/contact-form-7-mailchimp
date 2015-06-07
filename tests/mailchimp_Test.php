<?php
namespace WPCF7MC;

require 'lib/mailchimp.php';

class MailchimpTest extends \PHPUnit_Framework_TestCase {

  public function test_sets_datacenter () {
    $mailchimp = new \WPCF7MC\Mailchimp('XXXXXXXX');
    $this->assertEquals('', $mailchimp->datacenter);

    $mailchimp = new \WPCF7MC\Mailchimp('XXXXXXXX-us2');
    $this->assertEquals('us2', $mailchimp->datacenter);
  }

  public function test_uses_correct_url () {
    $mailchimp = new \WPCF7MC\Mailchimp('XXXXXXXX-us2');
    $this->assertEquals('https://us2.api.mailchimp.com/3.0/', $mailchimp->mailchimp_url());
  }
}

?>
