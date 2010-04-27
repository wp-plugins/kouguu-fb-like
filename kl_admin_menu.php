<?php

function kl_add_pages() {

    // Add a new top-level menu:
    add_menu_page('Kouguu Like Button', __('FB Like','kl'), 'administrator', 'kl-top-level-handle', 'kl_toplevel_page', plugin_dir_url( __FILE__ ) . '/library/kouguu/images/icon_kouguu.png');
    // Link top-level to first sub-page
    add_submenu_page('kl-top-level-handle', __('Basic Settings','kl'), __('Basic Stettings','kl'), 'administrator', 'kl-top-level-handle', 'kl_toplevel_page');
    // Add a submenus to the custom top-level menu:
    add_submenu_page('kl-top-level-handle', __('Advanced Settings','kn'), __('Advanced Settings','kn'), 'administrator', 'sub-page-advanced', 'kl_sublevel_advanced');
    add_submenu_page('kl-top-level-handle', __('Recent Activity','kn'), __('Recent Activity','kn'), 'administrator', 'sub-page-activity', 'kl_sublevel_activity');

}

function kl_toplevel_page() {

    //Settings for Facebook Like Button via iFrame
    $optiongroupHandle = 'kouguuLike_main';
    $kl_form=new kouguu_form($optiongroupHandle);
    $kl_view=new kouguu_view();
    $kl_options=kouguu_get_option($optiongroupHandle);
    $kl_message=kouguu_commit_updates($optiongroupHandle, $kl_options);
    if ($kl_message) $kl_view->add_message($kl_message);
    $kl_form->set_class('form-table');

    //Intro
    $kl_form->add_headline(__('Kouguu Facebook Like Button Options','kl'));
    $kl_form->add_introduction(__('Configure the appearance of the Like Button with the values below.','kl'));

    //Elements
    $options=array('standard'=>'standard','button_count'=>'button_count');
    $kl_form->add_select('layout', $options, $kl_options['layout'], __('Layout','kl'), __('Information to be shown next to button.','kl'));
    $kl_form->add_input('checkbox', 'show_faces', $kl_options['show_faces'],__('Show Faces','kl'),__('Check here if friends\' profile pictures should be shown below the button.','kl'));
    $kl_form->add_input('text', 'width', $kl_options['width'], __('Width','kl'), __('Width of iFrame in px','kl'),'small-text code');
    $options=array('like'=>__('like', 'kl'),'recommend'=>__('recommend','kl'));
    $kl_form->add_select('action', $options, $kl_options['action'], __('Action','kl'), __('Action to be displayed in button (like/recommend).','kl'));
    $options=array('light'=>'light','dark'=>'dark');
    $kl_form->add_select('colorscheme', $options, $kl_options['colorscheme'], __('Color Scheme','kl'), __('Color Scheme of the button.','kl'));
    $options=array('prepend'=>__('before', 'kl'),'append'=>__('after','kl'));
    $kl_form->add_select('position', $options, $kl_options['position'], __('Position','kl'), __('Show button before or after post.','kl'));

    //Buttons
    $kl_form->add_button('submit', 'submit', __('Update Options', 'kl' ), 'button-primary');
    $kl_form->add_button('submit', 'kouguu_default', __('Restore Default Values', 'kl' ), 'button-primary');

    $kl_view->prepend('<div class="wrap">');
    $kl_view->append($kl_form->render());
    $kl_view->append('</div>');

    echo $kl_view->render();

}

function kl_sublevel_advanced() {

    //Settings for Facebook Like Button via iFrame
    $optiongroupHandle = 'kouguuLike_advanced';
    $kl_form=new kouguu_form($optiongroupHandle);
    $kl_view=new kouguu_view();
    $kl_options=kouguu_get_option($optiongroupHandle);
    $kl_message=kouguu_commit_updates($optiongroupHandle, $kl_options);
    if ($kl_message) $kl_view->add_message($kl_message);
    $kl_form->set_class('form-table');

    //Intro
    $kl_form->add_headline(__('Kouguu Facebook Like Button Advanced Options - FBML','kl'));
    $kl_form->add_introduction(__('You can configure Kouguu FB Like to use FBML to allow advanced options.','kl'));

    //Elements
    $kl_form->add_input('checkbox', 'use_xfbml', $kl_options['use_xfbml'],__('Use FBML instead of iframes','kl'),__('Check here if you want to use FBML to offer more options (i.e. comment & share). Requires javascript on client side.','kl'));
    $kl_form->add_input('text', 'fb_app_id', $kl_options['fb_app_id'], __('Facebook App ID','kl'), __('Facebook Application ID for your website. ONLY needed for FBML. Get one <a href="http://developers.facebook.com/setup/" target=_blank>here</a>.','kl'),'code');
    $kl_form->add_input('text', 'fb_locale', $kl_options['fb_locale'], __('Facebook Language Locale','kl'), __('Language used for the button. Telling from your Wordpress installation it should be ','kl').'"'.str_replace("-", "_", get_bloginfo('language')).'"','small-text code');
    $kl_form->add_input('checkbox', 'fb_add_meta', $kl_options['fb_add_meta'],__('Add OpenGraph metadata','kl'),__('Check here if you want to add <a href="http://developers.facebook.com/docs/opengraph" target=_blank>OpenGraph</a> metadata below. Otherwise Facebook pulls information directly from the post or page.','kl'));
    $kl_form->add_input('text', 'fb_locale', $kl_options['fb_locale'], __('Facebook Language Locale','kl'), __('Use this value to change language of the button.','kl'),'small-text code');
    $kl_form->add_input('text', 'fb_meta_site_name', $kl_options['fb_meta_site_name'], __('Site Name','kl'), __('Something like "'.get_bloginfo('name').'". Leave blank if Facebook should use the blog title.','kl'),'regular-text');
    $kl_form->add_input('text', 'fb_meta_title', $kl_options['fb_meta_title'], __('Object Title','kl'), __('Leave blank if Facebook should use the post or page title (recommended). Otherwise this will be used for ALL liked objects.','kl'),'regular-text');
    $kl_form->add_textarea('fb_meta_description', $kl_options['fb_meta_description'], __('Object Description','kl'), __('Leave blank if Facebook should use the post or page contents (recommended). Otherwise this will be used for ALL liked objects.','kl'),'large-text');
    unset($options);
    $image_files=scandir(KOUGUU_APP_PATH.'/images');
    foreach ($image_files as $image_url) {
        $file_types=array('gif','jpg','png');
        $file_info=pathinfo($image_url, PATHINFO_EXTENSION);
        if (in_array($file_info, $file_types)) $options[$image_url]=$image_url;
    }
    if (is_array($options)) {
        $options['']='none';
        $kl_form->add_select('fb_meta_image', $options, $kl_options['fb_meta_image'], __('Site Image','kl'), __('Thumbnail used by Facebook. Must be at least 50px by 50px and have a maximum aspect ratio of 3:1. Allowed types '.implode(", ",$file_types),'kl'));
    } else $kl_form->add_plain_text('fb_meta_image', "No images files available in ".KOUGUU_APP_URL."images",  __('Site Image','kl'), __('Thumbnail used by Facebook. Must be at least 50px by 50px and have a maximum aspect ratio of 3:1. Allowed types '.implode(", ",$file_types),'kl'));


    //Buttons
    $kl_form->add_button('submit', 'submit', __('Update Options', 'kl' ), 'button-primary');
    $kl_form->add_button('submit', 'kouguu_default', __('Restore Default Values', 'kl' ), 'button-primary');

    $kl_view->prepend('<div class="wrap">');
    $kl_view->append($kl_form->render());
    $kl_view->append('</div>');

    echo $kl_view->render();

}

function kl_sublevel_activity() {
    $domain=parse_url(get_bloginfo('url'), PHP_URL_HOST);
    $description="<h2>Recent Facebook Activity for $domain</h2>";
    $iframe='<iframe src="http://www.facebook.com/plugins/activity.php?site='.$domain.'&amp;width=600&amp;height=400&amp;header=true&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:600px; height:400px"></iframe>';
    $activity="<div class='wrap'>$description<p>$iframe</p></div>";
    echo $activity;
}