<?php

$kl_default_values=array(
        "kouguuLike_main"=>array(
                'layout'=>'standard',
                'show_faces'=>'true',
                'width'=>'450',
                'height'=>'65',
                'position'=>'append',
                'action'=>'like',
                'colorscheme'=>'light'
        ),
        "kouguuLike_advanced"=>array(
                'use_xfbml'=>'',
                'fb_app_id'=>'',
                'fb_locale'=>'en_EN',
                'fb_add_meta'=>'',
                'fb_meta_title'=>'',
                'fb_meta_site_name'=>'',
                'fb_meta_description'=>'',
                'fb_meta_image'=>''
        ),
        "metabox"=>array(
                KOUGUU_APP.'_status'=>'display'
        )
);

$kl_function_templates = array(
        'fb_like'=>array('href', 'layout', 'show_faces', 'width', 'height', 'action', 'colorscheme')
);

?>
