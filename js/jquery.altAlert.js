jQuery.altAlert = function (options)  
{  
    var defaults = {  
        title: "Alert",  
        buttons: {  
            "Ok": function()  
            {  
                jQuery(this).dialog("close");  
            }  
        }  
    };  
  
    jQuery.extend(defaults, options);  
  
    delete defaults.autoOpen;  
  
    window.alert = function ()  
    {  
        jQuery("<div />", { html: arguments[0].replace(/\n/, "<br />") }).dialog(defaults);  
    };  
};  