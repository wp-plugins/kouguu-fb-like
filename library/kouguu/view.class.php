<?php

class kouguu_view{
    
    protected $html;
    protected $message;
    protected $template;
    protected $scripts;
    
    
    function  __construct() {
        if (KOUGUU_DEBUG) kouguu_log("Kouguu View: New view");
    }
    
    function load_template($filename){
        if (file_exists($filename)){
            $this->template=file_get_contents($filename);
        } else {
            if (KOUGUU_DEBUG) kouguu_log("Kouguu View: No such template file '$filename'");
        }
        
    }
    
    function append($hmtl){
        $this->html.=$hmtl;
    }
    
    function add_message($message,$class='updated'){
        $this->message.="<div class=\"$class\"><p><strong>$message</strong></p></div>";
    }
    
    function prepend($html){
        $this->html=$html.$this->html;
    }

    function add_script($url){
        $this->scripts[]=$url;
    }
    
    function render(){
        $html.=$this->message;
        $html.=$this->html;

        //If template -> Platzhalter ersetzen
        
        return $html;
    }
    
    
}

?>
