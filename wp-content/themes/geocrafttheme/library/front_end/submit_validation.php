<script type="text/javascript">
    //<![CDATA[
    jQuery(document).ready(function(){
<?php
echo 'var placeform = jQuery("#placeform");';
global $validation_field;
$jfunction = array();
for ($i = 0; $i < count($validation_field); $i++) {
    $name = $validation_field[$i]['name'];
    $span = $validation_field[$i]['span'];
    $type = $validation_field[$i]['type'];
    if ($type == 'image_uploader') {
        $js_code .= 'var ' . $name . ' =  jQuery(".' . $name . '");' . "\n";
    } else {
        $js_code .= 'var ' . $name . ' =  jQuery("#' . $name . '");' . "\n";
    }
    $js_code .= 'var ' . $span . ' =  jQuery("#' . $span . '");' . "\n";
    if (($type == 'text' && $name !== 'geocraft_meta_email') || $type == 'texteditor' || $type == 'textarea' || $type == 'geo_map') {
        $js_code .= 'function validate_' . $name . '()
    {
    if(jQuery("#' . $name . '").val() == "")

    {
        ' . $name . '.addClass("error");
        ' . $span . '.text("This field is required.");
        ' . $span . '.addClass("error");
        return false;
    }
    else{
        ' . $name . '.removeClass("error");
        ' . $span . '.text("");
        ' . $span . '.removeClass("error");
        return true;
        }
    }
        ' . $name . '.blur(validate_' . $name . ');
        ' . $name . '.keyup(validate_' . $name . ');' . "\n";
    }
    if ($name == 'geocraft_meta_email') {
        $js_code .= 'function validate_' . $name . '()
{
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
if(jQuery("#' . $name . '").val() == "") {
    ' . $name . '.addClass("error");
    ' . $span . '.text("Please provide your email address");
    ' . $span . '.addClass("error");
    return false;
} else if(!emailReg.test(jQuery("#' . $name . '").val())) {
    ' . $name . '.addClass("error");
    ' . $span . '.text("Please provide valid email address");
    ' . $span . '.addClass("error");
    return false;
} else {
    ' . $name . '.removeClass("error");
    ' . $span . '.text("");
    ' . $span . '.removeClass("error");
    return true;
}             
}
' . $name . '.blur(validate_' . $name . ');
' . $name . '.keyup(validate_' . $name . ');' . "\n";
    }
    if ($type == 'image_uploader') {
        $js_code .= 'function validate_' . $name . '()
    {
    if(jQuery(".' . $name . '").val() == "")

    {
        ' . $name . '.addClass("error");
        ' . $span . '.text("This field is required.");
        ' . $span . '.addClass("error");
        return false;
    }
    else{
        ' . $name . '.removeClass("error");
        ' . $span . '.text("");
        ' . $span . '.removeClass("error");
        return true;
        }
    }
        ' . $name . '.blur(validate_' . $name . ');
        ' . $name . '.keyup(validate_' . $name . ');' . "\n";
    }
    if ($type == 'radio') {
        $js_code .= '
        function validate_' . $name . '()
        {
			
                var chklength = jQuery("#' . $name . '").length;
			
                var temp	  = "";
                var i = 0;
                var chk_' . $name . ' = jQuery("#' . $name . '");
			
                if(chklength == 0){
			
                        if ((chk_' . $name . '.checked == false)) {
                                flag = 1;	
                        } 
                } else {
                        var flag      = 0;
                        for(i=0;i<chklength;i++) {
					
                                if ((chk_' . $name . '[i].checked == false)) { ';
        $js_code .= '
                                        flag = 1;	
                                } else {
                                        flag = 0;
                                        break;
                                }
                        }
				
                }
                if(flag == 1)
                {
                        ' . $span . '.text("This field is required");
                        ' . $span . '.addClass("error");
                        return false;
                }
                else{			
                        ' . $span . '.text("");
                        ' . $span . '.removeClass("error");
                        return true;
                }
                alert(flag);
			
        }
';
    }
    $jfunction[] = 'validate_' . $name . '()';
}
if ($jfunction) {
    $jfunction_str = implode(' & ', $jfunction);
}
$js_code .= '	
placeform.submit(function()
{
if(' . $jfunction_str . ')
{
        return true
}
else
{
        return false;
}
});
';
echo $js_code;
?>       
    });//]]>
</script>
