<?php
/* Adds a custom media button on the post editor. */
add_action('media_buttons', 'infogr_media_button', 11);

/* Loads media button popup content in the footer. */
add_action('admin_print_footer_scripts', 'infogr_media_popup_content', 100);

function infogr_media_button($editor_id) {
  global $infogram;
  global $wp_version;

  wp_enqueue_script('infogr-popup-config', plugins_url('js/popup.js', __FILE__), array(), '20160804', true);
  wp_enqueue_style('infogr-popup-style', plugins_url('css/button.css', __FILE__), array(), 'v4');

  if ($wp_version > 3.8) {
    $button_class = 'infogr_btn_new';
  } else {
    $button_class = 'infogr_btn_old';
  }

  printf('<span class="%s" id="%s">%s</span>', $button_class, 'call_infogr_popup', __('Add Infogram', 'infogram'));
}

/* Check for dashboard page */
global $status;
add_action('admin_head-index.php', 'infogr_check_dashboard');

function infogr_check_dashboard() {
  global $status;
  $status = true;
}

function infogr_media_popup_content() {
  global $status;
  // Check if the wp_editor() function has been called.
  if (!did_action('before_wp_tiny_mce') or $status) {
    return;
  }
?>
  <div id="infogr_media_popup">
    <div class="infogr_inner">
      <span id="close_infogr_popup"></span>
      <div class="infogr_popup_content loader">
      </div>
      <div class="infogr-popup-footer">
        <!-- add embed form -->
        <a href="https://infogram.com/blog/new-infogram-wordpress-plugin/" target="_blank" class="infogr_faq"><?php _e('Need help with plugin?', 'infogram')?></a>
        <form action="" method="POST" id="infogr_embed">
          <input type="text" id="infogr_add_embed" placeholder="<?php _e('Embed from a link. Paste the infogram.com URL to the chart or infographic here.', 'infogram')?>"/>
          <input type="submit" value="Embed"/>
        </form>
      </div>
    </div>
  </div>
<?php
}

function infogr_add_media_popup() {
  global $infogram;

  $infographics = $infogram->get_all_inforgaphics(); ?>
  <div class="infogr-active-top">
    <span><?php _e('Click on a chart or infographic</br>to embed', 'infogram'); ?></span>
    <a href="https://infogram.com/" target="_blank" title="logo"><img src="<?php echo plugins_url('/img/logow.png', __FILE__); ?>" alt="logo" /></a>
  </div>
  <?php
  $count = 1;
  $out = '';

  foreach ($infographics as $infographic) {
    if (!$infographic->published) {
        continue;
    }

    $count--;
    $clear = ($count == 0) ? ' clear' : '';
    if($count == 0) $count = 5;

    $embed = str_replace("https://infogram.com/", "", $infographic->url);

    $start_pos = strpos($infographic->embed_responsive, 'embed.js?') + 9;
    $end_pos = strpos($infographic->embed_responsive, '" type');

    $code = substr($infographic->embed_responsive, $start_pos, $end_pos-$start_pos);

    $settings = ($infographic->published !== true) ? array(' disabled'.$clear) : array($clear,$embed,$code);

    $title = htmlspecialchars($infographic->title, ENT_QUOTES, 'UTF-8');

    $out .= '<div class="infographic'.$settings[0].'" data-embed="'.$settings[1].'" data-code="'.$settings[2].'">
          <img src="'.$infographic->thumbnail_url.'">
          <h4>'.$title.'</h4>
          <div class="infogr-hover"><span class="infogr-h-add">Embed</span></div>
        </div>';
  }

  echo '<div class="container_infographic">'.$out.'</div>';
}

function infogr_message_popup() {
  ?>
  <div class="infogr-no-active">
    <div class="infogr-info-area">
      <h1><?php _e('Embed interactive</br>charts and infographics', 'infogram'); ?></h1>
      <span><?php _e('Infogram.com lets you quickly and easily create interactive and responsive data visualizations.', 'infogram'); ?> <a href="https://infogram.com/about" target="_blank"><?php _e('Read more', 'infogram'); ?></a></span>
      <div class="infogr-slides">
        <img src="<?php echo plugins_url('/img/slide1.gif', __FILE__); ?>" alt="slide" />
        <img src="<?php echo plugins_url('/img/slide2.gif', __FILE__); ?>" alt="slide" />
        <img src="<?php echo plugins_url('/img/slide3.gif', __FILE__); ?>" alt="slide" />
        <img src="<?php echo plugins_url('/img/slide4.gif', __FILE__); ?>" alt="slide" />
      </div>
    </div>
    <div class="infogr-set-area">
      <a href="https://infogram.com/" target="_blank" title="logo"><img src="<?php echo plugins_url('/img/logo.png', __FILE__); ?>" alt="Infogram" /></a>
      <div class="infogr-set-action">
        <span><?php _e('Not yet an Infogram.com user?', 'infogram'); ?></span>
        <a class="create_inf" target="_blank" title="create" href="https://infogram.com/?utm_source=wp-plugin&utm_medium=wp&utm_campaign=wp"><?php _e('Create new account','infogram'); ?></a>
      </div>
      <div class="infogr-set-settings">
        <span><?php _e('Already have an Infogram.com account?', 'infogram'); ?></h5>
        <a class="setting_inf" target="_blank" title="setting" href="/wp-admin/options-general.php?page=infogram"><?php _e('Authenticate here', 'infogram'); ?></a>
      </div>
    </div>
  </div>
  <?php
}
