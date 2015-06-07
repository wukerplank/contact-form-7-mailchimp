<div class="mail-fields">

  <div class="half-left">
    <div class="mail-field">
      <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_EMAIL ?>"><?php echo esc_html( __( 'Subscriber Email:', 'wpcf7' ) ); ?></label><br />
      <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_EMAIL ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_EMAIL ?>]" class="wide" size="70" placeholder="email" value="<?php echo (isset ( $wpcf7mc[WPCF7MC_FIELD_EMAIL] ) ) ? esc_attr( $wpcf7mc[WPCF7MC_FIELD_EMAIL] ) : ''; ?>" />
    </div>

    <div class="mail-field">
    <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_FIRSTNAME ?>"><?php echo esc_html( __( 'Subscriber Firstname:', 'wpcf7' ) ); ?></label><br />
    <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_FIRSTNAME ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_FIRSTNAME ?>]" class="wide" size="70" placeholder="firstname" value="<?php echo (isset ($wpcf7mc[WPCF7MC_FIELD_FIRSTNAME] ) ) ? esc_attr( $wpcf7mc[WPCF7MC_FIELD_FIRSTNAME] ) : ''; ?>" />
    </div>

    <div class="mail-field">
    <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_LASTNAME ?>"><?php echo esc_html( __( 'Subscriber Lastame:', 'wpcf7' ) ); ?></label><br />
    <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_LASTNAME ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_LASTNAME ?>]" class="wide" size="70" placeholder="lastname" value="<?php echo (isset ($wpcf7mc[WPCF7MC_FIELD_LASTNAME] ) ) ? esc_attr( $wpcf7mc[WPCF7MC_FIELD_LASTNAME] ) : ''; ?>" />
    </div>

    <div class="mail-field">
    <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_SUBSCRIBE ?>"><?php echo esc_html( __( 'Required Acceptance Field:', 'wpcf7' ) ); ?></label><br />
    <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_SUBSCRIBE ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_SUBSCRIBE ?>]" class="wide" size="70" placeholder="subscribe" value="<?php echo (isset($wpcf7mc[WPCF7MC_FIELD_SUBSCRIBE]) ) ? esc_attr( $wpcf7mc[WPCF7MC_FIELD_SUBSCRIBE] ) : ''; ?>" />
    </div>

    <div class="mail-field"><br/>
    <input type="checkbox" id="wpcf7mc-custom-fields-active" name="wpcf7mc[custom_fields_active]" value="1"<?php echo ( isset($wpcf7mc[WPCF7MC_FIELD_CUSTOM_FIELDS]) ) ? ' checked="checked"' : ''; ?> />
    <label for="wpcf7mc-custom-fields-active"><?php echo esc_html( __( 'Use Custom Fields', 'wpcf7' ) ); ?></label><br/><br/>
    </div>
  </div>

  <div class="half-right">
    <div class="mail-field">
    <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_MAILCHIMP_API_TOKEN ?>"><?php echo esc_html( __( 'MailChimp API Key:', 'wpcf7' ) ); ?></label><br />
    <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_MAILCHIMP_API_TOKEN ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_MAILCHIMP_API_TOKEN ?>]" class="wide" size="70" placeholder="Your Mailchimp API token" value="<?php echo (isset($wpcf7mc[WPCF7MC_FIELD_MAILCHIMP_API_TOKEN]) ) ? esc_attr( $wpcf7mc[WPCF7MC_FIELD_MAILCHIMP_API_TOKEN] ) : ''; ?>" />
    </div>

    <div class="mail-field">
    <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_MAILCHIMP_LIST_ID ?>"><?php echo esc_html( __( 'MailChimp List ID:', 'wpcf7' ) ); ?></label><br />
    <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_MAILCHIMP_LIST_ID ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_MAILCHIMP_LIST_ID ?>]" class="wide" size="70" placeholder="Your Mailchimp List ID" value="<?php echo (isset( $wpcf7mc[WPCF7MC_FIELD_MAILCHIMP_LIST_ID]) ) ?  esc_attr( $wpcf7mc[WPCF7MC_FIELD_MAILCHIMP_LIST_ID]) : '' ; ?>" />
    </div>
  </div>

  <br class="clear" />

  <div class="wpcf7mc-custom-fields">
    <?php for($i=1;$i<=6;$i++){ ?>

      <div class="half-left">
        <div class="mail-field">
        <label for="wpcf7mc-<?php echo WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . $i; ?>"><?php echo esc_html( __( 'Contact Form Value '.$i.':', 'wpcf7' ) ); ?></label><br />
        <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . $i; ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . $i; ?>]" class="wide" size="70" placeholder="Form field #<?php echo $i ?>" value="<?php echo esc_attr( $wpcf7mc[WPCF7MC_FIELD_CUSTOM_FORM_FIELD_PREFIX . $i] ); ?>" />
        </div>
      </div>

      <div class="half-right">
        <div class="mail-field">
        <label for="wpcf7mc-<?php echo _FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . $i; ?>"><?php echo esc_html( __( 'MailChimp Custom Field Name '.$i.':', 'wpcf7' ) ); ?></label><br />
        <input type="text" id="wpcf7mc-<?php echo WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . $i; ?>" name="wpcf7mc[<?php echo WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . $i; ?>]" class="wide" size="70" placeholder="Mailchimp field #<?php echo $i ?>" value="<?php echo esc_attr( $wpcf7mc[WPCF7MC_FIELD_CUSTOM_MAILCHIMP_FIELD_PREFIX . $i] ); ?>" />
        </div>
      </div>

      <br class="clear" />
    <?php } ?>
  </div>
</div>
