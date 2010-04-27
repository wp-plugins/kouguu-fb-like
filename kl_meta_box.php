<?php

function kl_inner_custom_box($post_id) {
    // Use nonce for verification
    echo '<input type="hidden" name="'.KOUGUU_APP.'_noncename" id="'.KOUGUU_APP.'_noncename" value="' .
            wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Data
    $status=get_post_meta($post_id->ID,KOUGUU_APP.'_status',true);
    if ($status=="") $status="display";
    $checked=($status=='display')?'checked="checked"':'';
    echo '<label for="'.KOUGUU_APP.'_status" class="selectit"><input name="'.KOUGUU_APP.'_status" type="checkbox" id="'.KOUGUU_APP.'_status" value="display"  '.$checked.' />'.__("Display Like Button",KOUGUU_ID).'</label><br />';
}

?>
