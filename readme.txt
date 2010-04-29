=== Kouguu Facebook Like Button ===
Contributors: nzimmer
Tags: facebook, social, like, button
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: trunk

Use the Facebook Like Button in your blog with this highly customizable WP plugin via iFrame or FBML. Shortcode enabled.

== Description ==

Features:

*   Internationalization Support: English, Deutsch
*   Use iFrame or FBML (with share/comment functionality)
*   Displaying the button is individualy selectable on post/page level
*   Select button position (before/after post)
*   Use shortcode tags [kouguu-fb-like] alternatively
*   Add OpenGraph metatags to your blog
*   View users recent Facebook activies right in your admin pages

Kouguu FB Like wraps the new *Facebook Like Button* plugin into a customizable WP plugin:

"The Like button enables users to make connections to your pages and share content back
to their friends on Facebook with one click. Since the content is hosted by Facebook,
the button can display personalized content whether or not the user has logged into your site.
For logged-in Facebook users, the button is personalized to highlight friends who have also liked the page."

Now you can add this social feature without any hard-coding.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the folder `kouguu-fb-like` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= I have activated XFBML in the admin section but the Button isn't displayed. However iFrames work fine =


Please make sure that the theme is supporting XHTML. Open the header.php file of your theme and check the html-tag which should look like:

`<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>`


= I am using shortcode tags in my posts. Can I overide button options on this level ? =

Yes, you can override the following options: 'layout', 'show_faces', 'width', 'action', 'colorscheme'

Example Code: `[kouguu-fb-like layout='button_count']`


= The plugin is not available in my language =

You can use the kouguu_fb_like.po file located in kouguu_fb_like/language to translate the short language file with POEdit or another editor.
Please share your translation and mail it to n@sq.is so we can make it available for all users.


== Screenshots ==


== Changelog ==

= 2.1 =
Shortcode added
Internationalization: English, German


= 2.0 =
FBML support added
Display option on page/post level added
Recent Activities added


= 1.0.1 =
Separated CSS from code


= 1.0 =
Initial Release

