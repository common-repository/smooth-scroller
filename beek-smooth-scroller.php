<?php
/*
  Plugin Name: Smooth Scroller
  Plugin URI: http://beek.jp/smooth-scroller/
  Description: Add smooth scroller in your website.
  Version: 0.1.0
  Author: Satoshi Yoshida
  Author URI: http://beek.jp
  License: GPLv2 or later
 */
/*  Copyright 2015 Satoshi Yoshida (email : yos.3104@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class SmoothScrollerSettings {

	function __construct() {
		add_action('admin_menu', array($this, 'add_pages'));
	}

	function add_pages() {
		add_submenu_page('plugins.php', __('Smooth Scroller', 'beek-smooth-scroller'), __('Smooth Scroller', 'beek-smooth-scroller'), 'level_8', __FILE__, array($this, 'setting_view'));
	}

	function setting_view() {
		$post_settings = filter_input(INPUT_POST, "beek_smooth_scroller_settings", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		if (!is_null($post_settings)) {
			check_admin_referer('beek_smooth_scroller_settings');
			update_option('beek_smooth_scroller_settings', $post_settings);
			?><div class="updated fade"><p><strong><?php _e('Settings saved.', 'beek-smooth-scroller'); ?></strong></p></div><?php
		}
		?>
			<div class="bss-admin-settings-wrapper" style="padding: 20px;">
			<h1><?php _e('Smooth Scroller Settings', 'beek-smooth-scroller'); ?></h1>
			<form action="" method="post" style="padding-left: 10px;">
				<?php
				wp_nonce_field('beek_smooth_scroller_settings');
				$settings = get_option('beek_smooth_scroller_settings');
				$scroller_arrow_type = isset($settings['arrow_type']) ? esc_html($settings['arrow_type']) : 'angle-up';
				$scroller_px = isset($settings['scroller_px']) ? esc_html($settings['scroller_px']) : 15;
				$padding_top = isset($settings['padding_top']) ? esc_html($settings['padding_top']) : 10;
				$padding_right = isset($settings['padding_right']) ? esc_html($settings['padding_right']) : 13;
				$padding_bottom = isset($settings['padding_bottom']) ? esc_html($settings['padding_bottom']) : 10;
				$padding_left = isset($settings['padding_left']) ? esc_html($settings['padding_left']) : 13;
				$font_color = isset($settings['font_color']) ? esc_html($settings['font_color']) : '#FFFFFF';
				$background_color = isset($settings['background_color']) ? esc_html($settings['background_color']) : '#2196F3';
				?>

				<h2 style="margin: 20px 0 5px 0;"><?php _e('Scroller arrow type', 'beek-smooth-scroller'); ?></h2>

				<select id="beek_smooth_scroller_arrow_type" name="beek_smooth_scroller_settings[arrow_type]">
					<option<?php ($scroller_arrow_type == 'angle-up') ? print ' selected ' : print ''; ?>>angle-up</option>
					<option<?php ($scroller_arrow_type == 'angle-double-up') ? print ' selected ' : print ''; ?>>angle-double-up</option>
					<option<?php ($scroller_arrow_type == 'arrow-up') ? print ' selected ' : print ''; ?>>arrow-up</option>
					<option<?php ($scroller_arrow_type == 'caret-up') ? print ' selected ' : print ''; ?>>caret-up</option>
					<option<?php ($scroller_arrow_type == 'chevron-up') ? print ' selected ' : print ''; ?>>chevron-up</option>
				</select>

				<h2 style="margin: 20px 0 5px 0;"><?php _e('Scroller size', 'beek-smooth-scroller'); ?></h2>
				<input id="beek_smooth_scroller_size_px" name="beek_smooth_scroller_settings[scroller_px]" min="10" max="64" type="number" value="<?php echo $scroller_px; ?>">px

				<h2 style="margin: 20px 0 5px 0;"><?php _e('Scroller padding', 'beek-smooth-scroller'); ?></h2>
				<?php _e('padding-top:', 'beek-smooth-scroller'); ?> <input id="beek_smooth_scroller_padding_top" name="beek_smooth_scroller_settings[padding_top]" min="10" max="64" type="number" value="<?php echo $padding_top; ?>">px<br>
				<?php _e('padding-right:', 'beek-smooth-scroller'); ?> <input id="beek_smooth_scroller_padding_right" name="beek_smooth_scroller_settings[padding_right]" min="10" max="64" type="number" value="<?php echo $padding_right; ?>">px<br>
				<?php _e('padding-bottom:', 'beek-smooth-scroller'); ?> <input id="beek_smooth_scroller_padding_bottom" name="beek_smooth_scroller_settings[padding_bottom]" min="10" max="64" type="number" value="<?php echo $padding_bottom; ?>">px<br>
				<?php _e('padding-left:', 'beek-smooth-scroller'); ?> <input id="beek_smooth_scroller_padding_left" name="beek_smooth_scroller_settings[padding_left]" min="10" max="64" type="number" value="<?php echo $padding_left; ?>">px

				<h2 style="margin: 20px 0 5px 0;"><?php _e('Scroller font color', 'beek-smooth-scroller'); ?></h2>
				<input id="beek_smooth_scroller_font_color" name="beek_smooth_scroller_settings[font_color]" type="text" placeholder="#FFFFFF" value="<?php echo $font_color; ?>">

				<h2 style="margin: 20px 0 5px 0;"><?php _e('Scroller background color', 'beek-smooth-scroller'); ?></h2>
				<input id="beek_smooth_scroller_background_color" name="beek_smooth_scroller_settings[background_color]" type="text" placeholder="#000000" value="<?php echo $background_color; ?>">

				<h2 style="margin: 20px 0 5px 0;"><?php _e('Scroller example', 'beek-smooth-scroller'); ?></h2>
				<i class="fa fa-<?php echo $scroller_arrow_type; ?>"
				   style="
				   font-size: <?php echo $scroller_px; ?>px!important;
				   padding: <?php echo $this->get_padding_px() ?>!important;
				   color: <?php echo $font_color; ?>!important;
				   background-color: <?php echo $background_color; ?>!important;"></i>

				<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e('Save', 'beek-smooth-scroller'); ?>"></p>
			</form>
			<h2 style="padding-left: 10px;"><?php _e('Support', 'beek-smooth-scroller'); ?></h2>
			<p style="padding-left: 10px;">
				<?php _e('Please contact me if you need help.', 'beek-smooth-scroller'); ?><br>
				<?php _e('Mail:<a href="mailto:yos.3104@gmail.com">yos.3104@gmail.com</a>', 'beek-smooth-scroller'); ?><br>
				<?php _e('Twitter:<a href="https://twitter.com/beek_jp" target="_blank">@beek_jp</a>', 'beek-smooth-scroller'); ?><br>
			</p>
		</div>
		<?php
	}

	function echo_scroller() {
		$ret = '';
		$ret .= ' <i id="beek_smooth_scroller" class="fa fa-' . $this->get_scroller_arrow_type() . '" ';
		$ret .= ' style=" ';
		$ret .= ' font-size: ' . $this->get_scroller_px() . '!important; ';
		$ret .= ' padding: ' . $this->get_padding_px() . '!important; ';
		$ret .= ' color: ' . $this->get_font_color() . '!important; ';
		$ret .= ' background-color: ' . $this->get_background_color() . '!important; ';
		$ret .= ' position: fixed; ';
		$ret .= ' bottom: 10px; ';
		$ret .= ' right: 10px; ';
		$ret .= ' cursor: pointer; ';
		$ret .= ' "></i> ';
		return $ret;
	}

	private function get_scroller_arrow_type() {
		$option = get_option('beek_smooth_scroller_settings');
		return isset($option['arrow_type']) ? $option['arrow_type'] : 'angle-up';
	}

	private function get_scroller_px() {
		$option = get_option('beek_smooth_scroller_settings');
		return isset($option['scroller_px']) ? $option['scroller_px'] . 'px' : '15px';
	}

	private function get_padding_px() {
		$option = get_option('beek_smooth_scroller_settings');
		$top = isset($option['padding_top']) ? $option['padding_top'] . 'px' : '10px';
		$right = isset($option['padding_right']) ? $option['padding_right'] . 'px' : '13px';
		$bottom = isset($option['padding_bottom']) ? $option['padding_bottom'] . 'px' : '10px';
		$left = isset($option['padding_left']) ? $option['padding_left'] . 'px' : '13px';
		return $top . ' ' . $right . ' ' . $bottom . ' ' . $left;
	}

	private function get_font_color() {
		$option = get_option('beek_smooth_scroller_settings');
		return isset($option['font_color']) ? $option['font_color'] : '#FFFFFF';
	}

	function get_background_color() {
		$option = get_option('beek_smooth_scroller_settings');
		return isset($option['background_color']) ? $option['background_color'] : '#2196F3';
	}

}

$bss_settings = new SmoothScrollerSettings();


/* Load scripts and styles */
add_action('wp_enqueue_scripts', 'beek_smooth_scroller_enqueue_files');
add_action('admin_menu', 'beek_smooth_scroller_admin_enqueue_files');

function beek_smooth_scroller_admin_enqueue_files() {
	wp_register_style('beek-smooth-scroller-font-awesome-admin', plugins_url('', __FILE__) . '/inc/font-awesome-4.4.0/css/font-awesome.min.css', array(), '4.4.0');
	wp_enqueue_style('beek-smooth-scroller-font-awesome-admin');
}

function beek_smooth_scroller_enqueue_files() {
	wp_register_style('beek-smooth-scroller-font-awesome', plugins_url('', __FILE__) . '/inc/font-awesome-4.4.0/css/font-awesome.min.css', array(), '4.4.0');
	wp_register_style('beek-smooth-scroller-style', plugins_url('', __FILE__) . '/css/beek-smooth-scroller.css', array(), '0.0.1');
	wp_register_script('beek-smooth-scroller-sctipt', plugins_url('', __FILE__) . '/js/beek-smooth-scroller.js', array('jquery'), '0.0.1', TRUE);
	wp_enqueue_script('jquery');
	wp_enqueue_script('beek-smooth-scroller-sctipt');
	wp_enqueue_style('beek-smooth-scroller-font-awesome');
	wp_enqueue_style('beek-smooth-scroller-style');
}

/* Beek Smooth Scroller Plugin Load */

function bss_load_plugin() {
	load_plugin_textdomain('beek-smooth-scroller', FALSE, basename(dirname(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'bss_load_plugin');

/* echo scroller */

function echo_beek_smooth_scroller() {
	$beek_smooth_scroller_object = new SmoothScrollerSettings();
	echo $beek_smooth_scroller_object->echo_scroller();
}

add_action('wp_footer', 'echo_beek_smooth_scroller');
