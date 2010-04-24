<?php
/*
Plugin Name: Kouguu FB Like
Plugin URI: http://www.kouguu.net
Description: Kouguu Facebook Like Button Plugin
Version: 1.0.1
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
    define('KOUGUU_VERSION',"1.0");
    define('KOUGUU_APP',"Kouguu FB Like");
    define('KOUGUU_APP_PATH',dirname( __FILE__ ).'/');
    define('KOUGUU_APP_URL',plugin_dir_url( __FILE__ ));
    define('KOUGUU_LIBRARY', dirname( __FILE__ )."/library/kouguu/" );

// Includes
    global $wpdb;
    require_once KOUGUU_LIBRARY.'core.functions.php';
    require_once KOUGUU_LIBRARY.'form.class.php';
    require_once KOUGUU_LIBRARY.'view.class.php';
    require_once 'kl_defaults.php';
    require_once KOUGUU_LIBRARY.'app.functions.php';

    if (KOUGUU_DEBUG) kouguu_log("Init ".KOUGUU_APP." ".KOUGUU_VERSION);

// Hook for db install
    /*require_once 'kl_install.php';
    register_activation_hook(__FILE__,'kl_install');*/

// Hook for adding admin menus
    require_once 'kl_admin_menu.php';
    add_action('admin_menu', 'kl_add_pages');

// Hook for display
    add_filter('the_content', 'kl_render', 8);

// Hook for CSS
    kouguu_add_css();


} catch (exception $e) {
    if (KOUGUU_DEBUG) kouguu_log($e->getMessage());
}
