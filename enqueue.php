<?php

function wpcf7mc_admin_enqueue_scripts() {
  global $plugin_page;

  if ( ! isset( $plugin_page ) || 'wpcf7' != $plugin_page ) {
    return;
  }

  wp_enqueue_script('wpcf7-mc', WPCF7MC_PLUGIN_DIR . '/assets/javascripts/toggle-custom-fields.js', array('jquery', 'wpcf7-admin'), WPCF7MC_PLUGIN_VERSION, true);
}
add_action('admin_print_scripts', 'wpcf7mc_admin_enqueue_scripts');

?>
