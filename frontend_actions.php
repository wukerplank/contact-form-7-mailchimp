<?php

function wpcf7mc_subscribe($wpcf7_form_object) {
  $wpcf7mc = get_option('wpcf7mc_' . $wpcf7_form_object->id());

  if ($wpcf7mc) {
    $submission = WPCF7_Submission::get_instance();

    $form_handler = new \WPCF7MC\FormHandler($wpcf7mc, $submission->get_posted_data());
    $success = $form_handler->subscribe();
  }
}
add_action('wpcf7_before_send_mail', 'wpcf7mc_subscribe');

?>
