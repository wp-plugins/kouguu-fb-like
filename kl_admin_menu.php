<?php

function kl_add_pages() {

    // Add a new top-level menu:
    add_menu_page('Kouguu Like Button', __('Kouguu FB Like','kl'), 'administrator', 'kl-top-level-handle', 'kl_toplevel_page', plugin_dir_url( __FILE__ )  . 'images/icon_kouguu.png');

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
    $kl_form->add_select('layout', $options, $kl_options['layout'], __('Layout','kl'), __('Information to be shown next to the button.','kl'));
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
