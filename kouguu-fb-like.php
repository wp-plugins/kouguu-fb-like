<?php
/*
Plugin Name: Kouguu FB Like
Plugin URI: http://www.kouguu.net
Description: Kouguu Facebook Like Button Plugin
Version: 2.1
Author: Nicolas Zimmer
Author URI: http://www.kouguu.net
*/
/*  Copyright 2010  Nicolas Zimmer  (email : n@sq.is)

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

try {

// Constants
    define('KOUGUU_DEBUG',false);
    define('KOUGUU_VERSION',"2.1");
    define('KOUGUU_APP',"kouguu_fb_like");
    define('KOUGUU_DESCRIPTIVE_NAME',"Facebook Like Button");
    define('KOUGUU_ID', "kl");
    define('KOUGUU_APP_PATH',dirname( __FILE__ ).'/');
    define('KOUGUU_APP_URL',plugin_dir_url( __FILE__ ));
    define('KOUGUU_LIBRARY', dirname( __FILE__ )."/library/kouguu/" );

// Hook for language files
    load_plugin_textdomain(KOUGUU_APP, false, dirname(plugin_basename(__FILE__)).'/language');

// Includes
    global $wpdb;
    require_once KOUGUU_LIBRARY.'core.functions.php';
    require_once KOUGUU_LIBRARY.'form.class.php';
    require_once KOUGUU_LIBRARY.'view.class.php';
    require_once KOUGUU_ID.'_defaults.php';
    require_once KOUGUU_LIBRARY.'app.functions.php';
    if (KOUGUU_DEBUG) kouguu_log("Init ".KOUGUU_APP." ".KOUGUU_VERSION);

// Hook for adding admin menus
    require_once KOUGUU_ID.'_admin_menu.php';
    add_action('admin_menu', KOUGUU_ID.'_add_pages');

//Hook for adding meta-box
    require_once KOUGUU_ID.'_meta_box.php';
    add_action('admin_menu', 'kouguu_add_custom_box');
    add_action('save_post', 'kouguu_save_custom_box');

// Hook for button display
    add_filter('the_content', 'fb_render_button', 8);

// Hook for CSS
    kouguu_add_css();

//Hook for fb_sdk
    $kl_options=kouguu_get_option('kouguuLike_advanced');
    if ($kl_options['use_xfbml']=="on" && is_numeric($kl_options['fb_app_id'])) {
        add_filter('language_attributes', 'fb_add_schema');
        if ($kl_options['fb_add_meta']=='on'){
            add_filter('language_attributes', 'og_add_schema');
            add_action('wp_head','fb_add_meta');
        }
        add_action('wp_print_footer_scripts', 'fb_JavaScript_SDK');
    }

//Hook for shortcode
    add_shortcode('kouguu-fb-like', 'fb_shortcode_handler');


} catch (exception $e) {
    if (KOUGUU_DEBUG) kouguu_log($e->getMessage());
}
