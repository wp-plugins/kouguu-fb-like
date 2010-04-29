<?php
function fb_like_iframe($href, $layout, $show_faces, $width, $height, $action, $colorscheme) {
    $funct_args=func_get_args();
    $params=kouguu_parse_args('fb_like', $funct_args);
    foreach ($params as $par_name=>$par_value) {
        if ($par_value) $par_list.="$par_name=$par_value&";
    }
    $iframe='<iframe src="http://www.facebook.com/plugins/like.php?'.$par_list.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;"></iframe>';
    return "<div class='kouguu_fb_like_button'>$iframe</div>";
}

function fb_like_fbml($href, $layout, $show_faces, $width, $height, $action, $colorscheme) { //
    $funct_args=func_get_args();
    $params=kouguu_parse_args('fb_like', $funct_args);
    foreach ($params as $par_name=>$par_value) {
        if ($par_value) $par_list.=" $par_name=\"$par_value\"";
    }
    $fbml="<fb:like $par_list/>";
    return "<div class='kouguu_fb_like_button'>$fbml</div>";
}

function fb_JavaScript_SDK() {
    $kl_options=kouguu_get_option('kouguuLike_advanced');
    $js_script="<div id=\"fb-root\"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '$kl_options[fb_app_id]', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/$kl_options[fb_locale]/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>";
    echo $js_script;
}

function fb_add_schema($content) {
    return $content.' xmlns:fb="http://www.facebook.com/2008/fbml"';
}

function og_add_schema($content) {
    return $content.' xmlns:og="http://opengraphprotocol.org/schema/"';
}

function fb_add_meta() {
    $kl_options=kouguu_get_option('kouguuLike_advanced');
    foreach ($kl_options as $meta_property=>$meta_content) {
        if (stristr($meta_property,'fb_meta_') && !empty ($meta_content)) {
            $meta_property=substr($meta_property, 8);
            $meta_content=($meta_property=='image')?KOUGUU_APP_URL.$meta_content:$meta_content;
            $meta_tags.="<meta property=\"og:$meta_property\" content=\"$meta_content\"/>".chr(13);
        }
    }
    echo $meta_tags;
}

function fb_render_button($content) {
    global $post;
    $status=get_post_meta($post->ID,KOUGUU_APP.'_status',true);
    if ($status=="") $status="display";
    $kl_options=kouguu_get_option('kouguuLike_main');
    if ($status!="display" or $kl_options['position']=='shortcode') return $content;
    $href=get_permalink($post->ID);
    $show_faces=($kl_options['show_faces']=='on')?'true':'false';
    $height=($show_faces=='true')?'65':'25';
    $kl_options_fbml=kouguu_get_option('kouguuLike_advanced');
    if ($kl_options_fbml['use_xfbml']&&$kl_options_fbml['fb_app_id']) {
        $button=fb_like_fbml($href, $kl_options['layout'], $show_faces, $kl_options['width'], $height, $kl_options['action'], $kl_options['colorscheme']);
    } else $button=fb_like_iframe($href, $kl_options['layout'], $show_faces, $kl_options['width'], $height, $kl_options['action'], $kl_options['colorscheme']);
    $content=($kl_options['position']=='prepend')?$button.$content:$content.$button;
    return $content;
}

function fb_shortcode_handler($args, $content = null) {
    global $post;
    $kl_options_fbml=kouguu_get_option('kouguuLike_advanced');
    $params=kouguu_get_option(kouguuLike_main);
    if ($params['position']!='shortcode') return;
    $params['href']=urlencode(get_permalink($post->ID));
    $params['use_xfbml']=$kl_options_fbml['use_xfbml'];
    $params['fb_app_id']=$kl_options_fbml['fb_app_id'];
    extract(shortcode_atts($params, $args));
    $height=($show_faces=='true')?'65':'25';
    $button=($use_xfmbl && is_numeric($fb_app_id))?fb_like_fbml($href, $layout, $show_faces, $width, $height, $action, $colorscheme):fb_like_iframe($href, $layout, $show_faces, $width, $height, $action, $colorscheme);
    return $button;
}

?>