<?php
/*
  Plugin Name: Infogram
  Plugin URI: https://infogram.com/blog/new-infogram-wordpress-plugin/
  Description: It allows you to insert graphics from the site infogram.com
  Version: 1.7.0
  Text Domain: infogram
  Tags: infogram, shortcode, iframe, insert, rest api, json
*/

// Add setings page and register settings
add_action('admin_menu', 'infogr_add_pages');
add_action('wp_ajax_infogram_dialog', 'infogr_ajax_dialog');
add_action('wp_ajax_infogram_projects', 'get_all_inforgaphics');

function create_block_infogram_block_init() {
  // Block editor is not available.
  if (!function_exists('register_block_type')) {
    return;
  }

  global $infogram;

  $config = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php' );
  wp_register_script(
    'infogram-block',
    plugins_url('build/index.js', __FILE__),
    $config['dependencies'],
    $config['version']
  );

  register_block_type('infogram/infogram', [
    'editor_script'   => 'infogram-block',
    'attributes' => [
      'bloginfo' => [
        'default' => get_bloginfo('url'),
        'type'    => 'string',
      ],
      'id' => [
        'default' => '',
        'type'    => 'string',
      ],
      'title' => [
        'default' => '',
        'type'    => 'string',
      ],
      'thumbnailUrl' => [
        'default' => '',
        'type'    => 'string',
      ],
      'configured' => [
        'default' => $infogram->check_is_valid(),
        'type'    => 'boolean',
      ],
    ],
  ]);
}

function infogr_ajax_dialog() {
  global $infogram;
  ($infogram->check_is_valid()) ? infogr_add_media_popup() : infogr_message_popup();

  wp_die();
}

function get_all_inforgaphics() {
  global $infogram;
  wp_send_json($infogram->get_all_inforgaphics(true));
  wp_die();
}

function infogr_add_pages() {
  //create new top-level menu
  add_options_page('Infogram.com v1.7.0', 'Infogram settings', 'manage_options', 'infogram', 'infogr_page');

  //call register settings function
  add_action('admin_init', 'register_infogr_settings');
}

function register_infogr_settings() {
  //register our settings
  register_setting('my-infogr-settings', 'infogr_api_key');
  register_setting('my-infogr-settings', 'infogr_api_secret');
}

function infogr_page() {
  global $infogram;
?>
  <div class="wrap">
    <h2>Infogram</h2>
    <?php $infogram->plugin_status(); ?>
    <form method="post" action="options.php">
      <?php settings_fields('my-infogr-settings'); ?>
      <?php do_settings_sections('my-infogr-settings'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row"><?php _e('Your Api key:', 'infogram'); ?></th>
          <td><input type="text" name="infogr_api_key" size="40" value="<?php echo esc_attr(get_option('infogr_api_key')); ?>" /></td>
        </tr>
        <tr valign="top">
          <th scope="row"><?php _e('Your Api secret:', 'infogram'); ?></th>
          <td><input type="text" name="infogr_api_secret" size="40" value="<?php echo esc_attr(get_option('infogr_api_secret')); ?>" /></td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}

function infogr_create_object() {
  // Load Api config file
  require_once('core/autoload.php');
  // Load main Infogram class
  require_once('class/class-infogram.php');
  // Load media button function
  require_once('button/add_button.php');

  global $infogram;

  $options = array(
    'api_key' => get_option('infogr_api_key'),
    'api_secret' => get_option('infogr_api_secret')
  );

  if (!$infogram) {
    $infogram = new Infogram($options);
  }
}

// out infographic
function infogr_add_infographics($atts) {
  $atts = shortcode_atts(array(
    'id' => '',
    'prefix' => '',
    'format' => '',
    'title' => ''
  ), $atts, 'id');

  if ($atts['id']) {
    $format = $atts['format'] && $atts['format'] == 'image' ? '' : 'interactive';
    return '<div class="infogram-embed" data-id="' . $atts['id'] . '" data-type="' . $format . '" data-title="' . $atts['title'] . '"></div>';
  }
}

add_shortcode('infogram', 'infogr_add_infographics');

// Global Infogram activation hook
function infogr_handle_activation() {}

// Global Infogram deactivation hook
function infogr_handle_deactivation() {}

// Activation hooks for some basic initialization
register_activation_hook(__FILE__, 'infogr_handle_activation');
register_deactivation_hook(__FILE__, 'infogr_handle_deactivation');

// Main Infogram activation hook
if (is_admin()) {
  add_action('plugins_loaded', 'infogr_create_object');
  add_action('init', 'create_block_infogram_block_init');
} else {
  wp_register_script('infogram-async-embed', '', [], '', true);
  wp_enqueue_script('infogram-async-embed');
  wp_add_inline_script('infogram-async-embed', '<script>!function(e,i,n,s){var t="InfogramEmbeds",d=e.getElementsByTagName("script")[0];if(window[t]&&window[t].initialized)window[t].process&&window[t].process();else if(!e.getElementById(n)){var o=e.createElement("script");o.async=1,o.id=n,o.src="https://e.infogram.com/js/dist/embed-loader-min.js",d.parentNode.insertBefore(o,d)}}(document,0,"infogram-async");</script>');
};
