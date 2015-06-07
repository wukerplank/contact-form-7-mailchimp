<?php
/*
Plugin Name: Contact Form 7 MailChimp
Plugin URI: http://github.com/wukerplank/contact-form-7-mailchimp
Description: Enables you to send you Contact Form 7 data to Mailchimp
Author: Christoph Edthofer
Author URI: http://wukerplank.com
Version: 0.1.0
*/

require 'lib/mailchimp.php';
require 'lib/form_handler.php';

define('WPCF7MC_PLUGIN_VERSION', '0.1.0');
define('WPCF7MC_PLUGIN_DIR', '/wp-content/plugins/' . trim(dirname(plugin_basename(__FILE__)), '/'));

define('WPCF7MC_FIELD_MAILCHIMP_API_TOKEN', 'mailchimp_api_token');
define('WPCF7MC_FIELD_MAILCHIMP_LIST_ID', 'mailchimp_list_id');
define('WPCF7MC_FIELD_EMAIL', 'email');
define('WPCF7MC_FIELD_FIRSTNAME', 'firstname');
define('WPCF7MC_FIELD_LASTNAME', 'lastname');
define('WPCF7MC_FIELD_SUBSCRIBE', 'subscribe');
define('WPCF7MC_FIELD_CUSTOM_FIELDS', 'custom_fields_active');
define('WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX', 'custom_form_field_');
define('WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX', 'custom_mailchimp_field_');

require 'enqueue.php';
require 'backend_actions.php';
require 'frontend_actions.php';
