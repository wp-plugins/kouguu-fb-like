<?php
function fb_like_button($href, $layout, $show_faces, $width, $height, $action, $colorscheme) {
    $src_iframe="href=$href&layout=$layout&show_faces=$show_faces&width=$width&action=$action&colorscheme=$colorscheme";
    $iframe='<iframe src="http://www.facebook.com/plugins/like.php?'.$src_iframe.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;"></iframe>';
    return "<div class='kouguu_fb_like_button'>$iframe</div>";
}

function kl_render($content) {
    global $post;
    $kl_options=kouguu_get_option('kouguuLike_main');
    $href=urlencode(get_permalink($post->ID));
    $show_faces=($kl_options['show_faces']=='on')?'true':'false';
    $height=($show_faces=='true')?'65':'25';
    $button=fb_like_button($href, $kl_options['layout'], $show_faces, $kl_options['width'], $height, $kl_options['action'], $kl_options['colorscheme']);
    $content=($kl_options['position']=='prepend')?$button.$content:$content.$button;
    return $content;
}
?>