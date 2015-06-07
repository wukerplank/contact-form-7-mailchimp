jQuery(document).ready(function() {
  try {

    if (! jQuery('#wpcf7mc-custom-fields-active').is(':checked')) {
      jQuery('.wpcf7mc-custom-fields').hide();
    }


    jQuery('#wpcf7mc-custom-fields-active').click(function() {
      if (jQuery('.wpcf7mc-custom-fields').is(':hidden') && jQuery('#wpcf7mc-custom-fields-active').is(':checked')) {
        jQuery('.wpcf7mc-custom-fields').slideDown('fast');
      }
      else if (jQuery('.wpcf7mc-custom-fields').is(':visible')&& jQuery('#wpcf7mc-custom-fields-active').not(':checked')) {
        jQuery('.wpcf7mc-custom-fields').slideUp('fast');
      }
    });

  }
  catch (e) {
    console.log(e);
  }
});
