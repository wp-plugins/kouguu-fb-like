<?php

class kouguu_form {

    public $name;
    public $action;
    public $class;
    protected $headline;
    protected $introduction;
    protected $table_row;
    protected $buttons;
    protected $style;
    protected $response;

    function __construct($name,$action="", $class="") {
        $this->name=$name;
        $this->action=$action;
        $this->class=$class;
        $this->style="colums";
        if (KOUGUU_DEBUG) kouguu_log("New Form $name");
    }

    function set_class($class) {
        $this->class=$class;
    }

    function set_style($style) {
        $this->style=$style;
    }

    function add_headline($headline, $selector="h2", $class="") {
        $class=$class?" class=\"$class\"":"";
        $this->headline="<$selector$class>$headline</$selector>";
    }

    function add_introduction($introduction,$class="") {
        $class=$class?" class=\"$class\"":"";
        $this->introduction="<p$class>$introduction</p>";
    }

    function add_input($type,$name,$value="",$label="",$description="",$class="") {
        if (!empty($this->table_row[$name])) {
            if (KOUGUU_DEBUG) kouguu_log("KouguuForm: Element '$name' already used in form $this->name");
            return false;
        }
        $this->table_row[$name].="<tr>";
        if ($this->style!="single") $this->table_row[$name].="<th scope=\"row\">$label</th>";
        $class = $class ? $class="class=\"$class\"":$class='class="regular-text"';
        switch ($type) {
            case 'checkbox':
                if (!empty($value)) {
                    $checked='checked="checked"';
                }
                $this->table_row[$name].= "<td><input type=\"checkbox\" name=\"$name\" $checked>$description";
                break;

            default:
                $this->table_row[$name].= "<td><input type=\"$type\" name=\"$name\" value=\"$value\" $class id=\"$this->name-$name\">";
                if (!empty ($description)) $this->table_row[$name].= "<br /><span class=\"description\">$description</span>";
                break;
        }
    }

    function add_textarea($name,$value,$label="",$description="",$class="") {
        if (!empty($this->table_row[$name])) {
            if (KOUGUU_DEBUG) kouguu_log("KouguuForm: Element '$name' already used in form $this->name");
            return false;
        }
        $this->table_row[$name].="<tr>";
        if ($this->style!="single") $this->table_row[$name].="<th scope=\"row\">$label</th>";
        $class = $class ? $class="class=\"$class\"":$class='class="regular-text"';
        $this->table_row[$name].= "<td><textarea name=\"$name\" $class id=\"$this->name-$name\">$value</textarea>";
        if (!empty ($description)) $this->table_row[$name].= "<br /><span class=\"description\">$description</span>";
        $this->table_row[$name].="</td></tr>";
    }

    function add_select($name,$options,$value,$label="",$description="",$class="") {
        if (!empty($this->table_row[$name])) {
            if (KOUGUU_DEBUG) kouguu_log("KouguuForm: Element '$name' already used in form $this->name");
            return false;
        }
        $this->table_row[$name].="<tr>";
        if ($this->style!="single") $this->table_row[$name].="<th scope=\"row\">$label</th>";
        $class = $class ? $class="class=\"$class\"":$class='class="regular-text"';
        $this->table_row[$name].= "<td><select name=\"$name\" $class id=\"$this->name-$name\">";
        foreach ($options as $optval=>$option) {
            if ($optval==$value) $selected=" selected=\"selected\"";
            $this->table_row[$name].= "<option value=\"$optval\"$selected>$option";
            unset($selected);
        }
        $this->table_row[$name].="</select>";
        if (!empty ($description)) $this->table_row[$name].= "<br /><span class=\"description\">$description</span>";
        $this->table_row[$name].="</td></tr>";
    }

    function add_button($type,$name,$value,$class="") {
        if (!empty($this->buttons[$name])) {
            if (KOUGUU_DEBUG) kouguu_log("KouguuForm: Element '$name' already used in form $this->name");
            return false;
        }
        $this->buttons[$name].="<input type=\"$type\" name=\"$name\" id=\"$this->name-$name\" value=\"$value\" class=\"$class\">";
    }

    function add_response($id="",$value="",$class="") {
        $id=$id?$id:$this->name."_response";
        $class=$class?$class:"kouguu_response";
        if (!empty($this->response[$id])) {
            if (KOUGUU_DEBUG) kouguu_log("KouguuForm: Element '$id' already used in form $this->name");
            return false;
        }
        $this->response[$name]="<div id=\"$id\" class=\"$class\">$value</div>";
    }

    function add_plain_text($name,$text,$label="",$description="") {
        if (!empty($this->table_row[$name])) {
            if (KOUGUU_DEBUG) kouguu_log("KouguuForm: Element '$name' already used in form $this->name");
            return false;
        }
        $this->table_row[$name].="<tr>";
        if ($this->style!="single") $this->table_row[$name].="<th scope=\"row\">$label</th>";
        $class = $class ? $class="class=\"$class\"":$class='class="regular-text"';
        $this->table_row[$name].= "<td>$text";
        if (!empty ($description)) $this->table_row[$name].= "<br /><span class=\"description\">$description</span>";
        $this->table_row[$name].="</td></tr>";
    }


    function render() {
        $html.=$this->headline;
        $html.=$this->introduction;
        $wrapper=($this->style=="single")?"div":"p";
        $html.="<$wrapper class=\"kouguu_form\">";
        $html.="<form name=\"form_$this->name\" id=\"form_$this->name\" method=\"POST\" action=\"$this->action\">";
        $html.="<input type=\"hidden\" name=\"kouguu_submit_hidden\" value=\"Y\">";
        $class=$this->class?" class=\"$this->class\"":"";
        $html.="<$wrapper class=\"kouguu_form\">";
        $html.="<table$class>";
        $html.=implode("\n", $this->table_row);
        $html.="</table>";
        $html.="</$wrapper>";
        if (!empty($this->buttons)) $html.="<$wrapper class=\"kouguu_submit\" style=\"padding-top:10px;\">".implode($this->buttons)."</$wrapper>";
        if (!empty ($this->response)) $html.=implode("\n",$this->response);
        $html.="</form>";
        return $html;
    }

}

?>
