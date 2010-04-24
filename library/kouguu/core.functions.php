<?php

function kouguu_log($message) {
    $handle = fopen(KOUGUU_APP_PATH.'kouguu.log', "ab");
    $ip = $_SERVER['REMOTE_ADDR'];
    $time=strftime("%Y-%m-%d %H:%M:%S");
    $string=$time.chr(9).$ip.chr(9).$message."\r\n";
    fwrite($handle, $string);
    fclose($handle);
}

function kouguu_get_message($messageHandle) {
    $errorMessage = __("Invalid message handle","kl").": $messageHandle";
    $messageHandle=explode("_", $messageHandle);
    if (!is_array($messageHandle)) {
        $error=TRUE;
    } else {
        $message=get_option($messageHandle[0]."_".$messageHandle[1]);
        $message=$message[$messageHandle[2]];
        $error=empty($message)?TRUE:FALSE;
    }
    if ($error) {
        $message=$errorMessage;
        if (KOUGUU_DEBUG) kouguu_log($message);
    }
    return $message;
}

function kouguu_get_option($optiongroupHandle) {
    $kl_options=get_option($optiongroupHandle);
    $kl_default_values=kouguu_get_default($optiongroupHandle);
    if (is_array($kl_default_values)) {
        foreach (array_keys($kl_default_values) as $kl_key) {
            if (empty($kl_options[$kl_key])) $kl_options[$kl_key]=$kl_default_values[$kl_key];
        }
    }
    return $kl_options;
}

function kouguu_restore_default($optiongroupHandle, &$kl_options) {
    $kl_default_values=kouguu_get_default($optiongroupHandle);
    if (is_array($kl_default_values)) {
        foreach (array_keys($kl_default_values) as $kl_key) {
            $kl_options[$kl_key]=$kl_default_values[$kl_key];
        }
    } else if (KOUGUU_DEBUG) kouguu_log("Kouguu Function: restore_default called with invalid handle '$optiongroupHandle'");
    return $kl_options;
}

function kouguu_get_default($optiongroupHandle) {
    include_once KOUGUU_APP_PATH.'kl_defaults.php';
    global $kl_default_values;
    if (!is_array($kl_default_values[$optiongroupHandle]) AND KOUGUU_DEBUG) kouguu_log("Kouguu Function: get_default called with invalid handle '$optiongroupHandle'");
    return $kl_default_values[$optiongroupHandle];
}

function kouguu_commit_updates($optiongroupHandle, &$kl_options) {
    if (KOUGUU_DEBUG) kouguu_log("Committing updates $optiongroupHandle");
    global $kl_view;
    // If information was posted, hidden field will be set to 'Y'
    if( $_POST['kouguu_submit_hidden'] == 'Y' ) {
        //Restore Defaults if we are asked to
        if ($_POST['kouguu_default']) {
            $kl_options=kouguu_restore_default($optiongroupHandle, $kl_options);
            $kl_message=__('Default values restored.','kl');
        } else {
            // Read the posted value using the default array keys
            foreach (array_keys($kl_options) as $kl_key) {
                $kl_options[$kl_key]=htmlspecialchars($_POST[$kl_key]);
            }
            $kl_message=__('Options updated.','kl');
        }
        if (KOUGUU_DEBUG) kouguu_log($kl_message);
        // Save the posted value in the database
        update_option($optiongroupHandle, $kl_options);
        if (is_object($kl_view)) $kl_view->add_message($kl_message);
    }
    return $kl_message;
}

function kouguu_add_css() {
   add_action('wp_head', 'private_print_css');
}

function private_print_css(){
    $cssDir=KOUGUU_APP_PATH.'css';
    if (is_dir($cssDir)) {
        $return='<!-- Added by '.KOUGUU_APP.' '.KOUGUU_VERSION.' -->'.chr(13);
        $return.='<style type="text/css" media="all">'.chr(13);
        $cssFiles=scandir($cssDir);
        $cssURL=KOUGUU_APP_URL.'css';
        foreach ($cssFiles as $cssFileName) {
            if (stristr($cssFileName,'.css')) $return.="@import url(\"$cssURL/$cssFileName\")".chr(13);
        }
        $return.='</style>'.chr(13);
        $return.='<!-- End '.KOUGUU_APP.' '.KOUGUU_VERSION.' -->'.chr(13);
    } else {
        if (KOUGUU_DEBUG) kouguu_log("Kouguu Function: kouguu_add_css called with invalid directory '$cssDir'");
    }
    echo $return;
}

function kouguu_add_js() {
    $jsDir=KOUGUU_APP_PATH.'js';
    if (is_dir($jsDir)) {
        $jsFiles=scandir($jsDir);
        foreach ($jsFiles as $jsFileName) {
            if (stristr($jsFileName,'.js')) $jsFileInfo=explode(".",$jsFileName);//name.dependency.js -> foo.jquery.js
            if (count($jsFileInfo)==3) {
                wp_enqueue_script($jsFileInfo[0], KOUGUU_APP_URL.'js/'.$jsFileName,array( $jsFileInfo[1] ));
            } else if (KOUGUU_DEBUG) kouguu_log("Kouguu Function: kouguu_add_js ignored malformed filename '$jsFileName'");
        }
    } else {
        if (KOUGUU_DEBUG) kouguu_log("Kouguu Function: kouguu_add_js called with invalid directory '$jsDir'");
    }
}
?>
