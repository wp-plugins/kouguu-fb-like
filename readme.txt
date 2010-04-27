=== Kouguu Facebook Like ===
Contributors: nzimmer
Tags: facebook, social, like, button
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: trunk

Kouguu FB Like wraps the new Facebook Like Button plugin into a customizable WP plugin via iFrame or FBML.

== Description ==

Features:

*   Use iFrame or FBML (with share/comment functionality)
*   Displaying the Like Button is individualy settable on post/page level
*   Add OpenGraph metatags to your blog
*   View recent activies right on your admin pages

Kouguu FB Like wraps the new *Facebook Like Button* plugin into a customizable WP plugin:

"The Like button enables users to make connections to your pages and share content back
to their friends on Facebook with one click. Since the content is hosted by Facebook,
the button can display personalized content whether or not the user has logged into your site.
For logged-in Facebook users, the button is personalized to highlight friends who have also liked the page."

Visit http://developers.facebook.com/docs/reference/plugins/like for more details on this feature.

Now you can add this social feature without any hard-coding.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the folder `kouguu-fb-like` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= I have activated XFBML in the admin section but the Button isn't displayed. However iFrames work fine =

Please make sure that the theme is supporting XHTML. Open the header.php file of your theme and check the html-tag which should look like:

`<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>`



== Screenshots ==


== Changelog ==

= 2.0 =
FBML support added
Display option on page/post level added
Recent Activities added

= 1.0.1 =
Separated CSS from code

= 1.0 =
Initial Release

