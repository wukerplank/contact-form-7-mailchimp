<?php

function wpcf7mc_save_mailchimp ($args) {
  update_option( 'wpcf7mc_' . $args->id(), $_POST['wpcf7mc'] );
}
add_action( 'wpcf7_after_save', 'wpcf7mc_save_mailchimp' );

function wpcf7mc_add_meta_box () {
  if ( wpcf7_admin_has_edit_cap() ) {
    add_meta_box( 'wpcf7cmdiv', __( 'Mailchimp: Subscriber List Details <a href="https://github.com/wukerplank/contact-form-7-mailchimp" class="helping-hand" target="_blank">Need Help?</a>', 'wpcf7' ),
      'wpcf7mc_add_mailchimp', 'cfseven', 'wpcf7_mc', 'core',
      array(
        'id' => 'wpcf7-cf7',
        'name' => 'wpcf7mc',
        'use' => __( 'Use Mail Chimp', 'wpcf7' )
      )
    );
  }
}
add_action( 'wpcf7_add_meta_boxes', 'wpcf7mc_add_meta_box' );

function wpcf7mc_show_meta_box($cf) {
  do_meta_boxes( 'cfseven', 'wpcf7_mc', $cf );
}
add_action( 'wpcf7_admin_after_mail_2', 'wpcf7mc_show_meta_box' );

function wpcf7mc_add_mailchimp($args) {
  $wpcf7mc_defaults = array();
  $wpcf7mc = get_option('wpcf7mc_' . $args->id(), $wpcf7mc_defaults);

  require('templates/settings_form.php');
}

?>
