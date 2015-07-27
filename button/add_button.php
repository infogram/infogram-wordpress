<?php
/* Adds a custom media button on the post editor. */
add_action('media_buttons', 'infogr_media_button', 11);

/* Loads media button popup content in the footer. */
add_action('admin_print_footer_scripts', 'infogr_media_popup_content', 100);

function infogr_media_button( $editor_id ) {
	global $inforgam;
	
	wp_enqueue_script('infogr-popup-config', plugins_url('js/popup.js', __FILE__), array(), '20152306', true);
	wp_enqueue_style('infogr-popup-style', plugins_url('css/button.css', __FILE__));

	if($inforgam->is_valid()) {
		wp_enqueue_script('infogr-scroll-js', plugins_url('js/jquery.nicescroll.min.js', __FILE__), array(), '20152306', true);
	}
	
	printf('<span id="%s">%s</span>',
		'call_infogr_popup',
		'Add From Infogram'
	);
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
			<?php
				// Check if the plugins setting is wrong
				global $inforgam;
				($inforgam->is_valid()) ? infogr_add_media_popup() : infogr_message_popup();
			?>
			<div class="infogr-popup-footer">
				<!-- add embed form -->
				<a href="https://infogram.zendesk.com/hc/en-us/sections/200446823-FAQ" target="_blank" class="infogr_faq"><?php echo _e('Need help with plugin?','Infogram')?></a>
				<form action="" method="POST" id="infogr_embed">
					<input type="text" id="infogr_add_embed" placeholder="<?php echo _e('Embed from a link. Paste the Infogr.am URL to the chart or infographic here.','Infogram')?>"/>
					<input type="submit" value="Embed"/>
				</form>
			</div>
		</div>
	</div>
	<?php
}

function infogr_add_media_popup() {
	global $inforgam;
	
	$infographics = $inforgam->get_all_inforgams(); ?>
	<div class="infogr-active-top">
		<span><?php echo _e('Click on a chart or infographic</br>to embed','Infogram')?></span>
		<a href="https://infogr.am/" target="_blank" title="logo"><img src="<?php echo  plugins_url('/img/logow.png', __FILE__); ?>" alt="logo" /></a>
	</div>
	<?php
	$count = 1;
	
	foreach ($infographics as $infographic) {
		$count--;
		$clear = ($count == 0) ? ' clear' : '';
		if($count == 0) $count = 5;
		
		$embed = str_replace("https://infogr.am/", "", $infographic->url);

		$start_pos = strpos($infographic->embed_responsive, 'embed.js?')+9;
		$end_pos = strpos($infographic->embed_responsive, '" type');
		
		$code = substr($infographic->embed_responsive, $start_pos,$end_pos-$start_pos);
		
		$settings = ($infographic->published !== true) ? array(' disabled'.$clear) : array($clear,$embed,$code);

		$out .= '<div class="infographic'.$settings[0].'" data-embed="'.$settings[1].'" data-code="'.$settings[2].'">
					<img src="'.$infographic->thumbnail_url.'">
					<h4>'.$infographic->title.'</h4>
					<div class="infogr-hover"><span class="infogr-h-add">Embed</span></div>
				</div>';
	}
	
	echo '<div class="container_infographic">'.$out.'</div>';
}

function infogr_message_popup() { 
	?>
	<div class="infogr-no-active">
		<div class="infogr-info-area">
			<h1><?php echo _e('Embed interactive</br>charts and infographics','Infogram')?></h1>
			<span><?php echo _e('Infogram lets you quickly and easily create interactive and responsive data visualizations.','Infogram')?> <a href="https://about.infogr.am/" target="_blank"><?php echo _e('Read more','Infogram')?></a></span>
			<div class="infogr-slides">
				<img src="<?php echo plugins_url('/img/slide1.gif', __FILE__); ?>" alt="slide" />
				<img src="<?php echo plugins_url('/img/slide2.gif', __FILE__); ?>" alt="slide" />
				<img src="<?php echo plugins_url('/img/slide3.gif', __FILE__); ?>" alt="slide" />
				<img src="<?php echo plugins_url('/img/slide4.gif', __FILE__); ?>" alt="slide" />
			</div>
		</div>
		<div class="infogr-set-area">
			<a href="https://infogr.am/" target="_blank" title="logo"><img src="<?php echo  plugins_url('/img/logo.png', __FILE__); ?>" alt="logo" /></a>
			<div class="infogr-set-action">
				<span><?php echo _e('Not yet an infogram user?','Infogram')?></span>
				<span><?php echo _e('Get a 30-day free trial!','Infogram')?></span>
				<a class="create_inf" target="_blank" title="create" href="https://infogr.am/pricing?utm_source=wp-plugin&utm_medium=wp&utm_campaign=wp"><?php echo _e('Create new account','Infogram')?></a>
			</div>
			<div class="infogr-set-settings">
				<span><?php echo _e('Already have an Infogram account?')?></h5>
				<a class="setting_inf" target="_blank" title="setting" href="<?php bloginfo('url') ?>/wp-admin/options-general.php?page=infogram">Authenticate here</a>
			</div>
		</div>
	</div>
	<?php
}

// out infographic
function infogr_add_infographics($atts) {
	$atts = shortcode_atts( array(
		'id' => '',
		'prefix' => '',
		'format' => ''
	), $atts, 'id' );

	if($atts['id']) {
		if($atts['format'] && $atts['format'] == 'image') {
			return '<script id="infogramimg_0_'.$atts['id'].'" src="//e.infogr.am/js/embed.js?'.$atts['prefix'].'" async></script>';
		} else 
			return '<script id="infogram_0_'.$atts['id'].'" src="//e.infogr.am/js/embed.js?'.$atts['prefix'].'" async></script>';
	} else {
		return 'This code is broken or not exists!';
	}
}

add_shortcode('infogram', 'infogr_add_infographics');
