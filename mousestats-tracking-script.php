<?php
/*
Plugin Name: mousestats-tracking-script
Plugin URI: https://www.mousestats.com/
Description: MouseStats plugin to activate User Experience Analytics for Wordpress, create a free/paid account at <a href="https://www.mousestats.com">MouseStats website</a>.
Version: 0.6
Author: MouseStats
Author URI: https://www.mousestats.com/
License: MIT
*/

add_action('wp_footer', 'mousestats_trackingcode');
register_activation_hook(__FILE__, 'ms_install');
register_deactivation_hook(__FILE__, 'ms_remove' );

function ms_install() {
  add_option("ms_account_id", '', '', 'yes');
}

function ms_remove() {
  delete_option('ms_account_id');
}

if (is_admin()) {
  add_action('admin_menu', 'ms_admin_menu');
  function ms_admin_menu() {
    add_options_page('MouseStats Tracking Script', 'MouseStats Tracking Script', 'administrator', 'mousestats-tracking-script', 'ms_html_page');
  }
}

function mousestats_trackingcode() {
  $account_id = get_option("ms_account_id");
  if (!empty($account_id)) {
    echo '<!--  MouseStats:Begin WP-Plugin v0.6 -->
<script type="text/javascript">
var MouseStats_Commands = MouseStats_Commands ? MouseStats_Commands : [];
(function () {
if(document.getElementById(\'MouseStatsTrackingScript\') == undefined) {
    var mousestats_script = document.createElement(\'script\');
    mousestats_script.type = \'text/javascript\';
    mousestats_script.id = \'MouseStatsTrackingScript\';
    mousestats_script.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www2\') + \'.mousestats.com/js/'.$account_id[0].'/'.$account_id[1].'/'.$account_id.'.js?\' + Math.floor(new Date().getTime()/600000);
    mousestats_script.async = true;
    (document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(mousestats_script);
} })();
</script>
<!--  MouseStats:End  -->';
  }
}

function ms_html_page() {
?>
<div class="wrap">
  <div id="icon-plugins" class="icon32"></div>
  <h2>MouseStats Tracking Script</h2>
  <form method="POST" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">
          <label for="ms_account_id">Account ID</label>
        </th>
        <td>
          <input id="ms_account_id" name="ms_account_id" value="<?php echo get_option('ms_account_id'); ?>" class="regular-text" />
          <span class="description">(eg. 5003504249777020952)</span>
        </td>
      </tr>
    </table>
    <p>
      Your MouseStats Account ID is available in your MouseStats panel. You would find it above the tracking code section in <a href="https://www.mousestats.com/panel/overview" target="_blank">panel overview page</a>.
    </p>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="ms_account_id" />
    <p class="submit">
      <input class="button-primary" type="submit" name="Save" value="<?php _e('Save'); ?>" />
    </p>
  </form>
</div>
<?php
}
?>
