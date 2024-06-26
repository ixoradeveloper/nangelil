function getCookie(c_name)
{
	"use strict";
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}
function setCookie(c_name,value,exdays)
{
	"use strict";
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value + ";domain=;path=/;SameSite=None;Secure";
}
function removeCookie(c_name)
{   
    document.cookie = c_name +'=;domain=;path=/;Max-Age=-99999999;SameSite=None;Secure';  
}
jQuery.fn.removeClassPrefix = function(prefix) 
{
	"use strict";
    this.each(function(i, el) {
        var classes = el.className.split(" ").filter(function(c) {
            return c.lastIndexOf(prefix, 0) !== 0;
        });
        el.className = jQuery.trim(classes.join(" "));
    });
    return this;
};
jQuery(document).ready(function($){
	"use strict";
	$(".style-selector select option[selected]").prop("selected", true);
	$(".style-selector select input[checked]").prop("checked", true);
	$(".style-selector-icon").on("click", function(){
		$(this).parent().toggleClass("opened");
		setCookie("mc_style_selector", ($(this).parent().hasClass("opened") ? "opened" : ""));
	});
	if(getCookie("mc_main_color")!="")
	{
		if(getCookie("mc_main_color")=="green")
		{
			$("#medicenter_blue, #medicenter_blue_sliding").addClass("p_table_1_14");
		}
		else if(getCookie("mc_main_color")=="orange")
		{
			$("#medicenter_blue, #medicenter_blue_sliding").addClass("p_table_1_15");
		}
		else if(getCookie("mc_main_color")=="red")
		{
			$("#medicenter_blue, #medicenter_blue_sliding").addClass("p_table_1_16");
		}
		else if(getCookie("mc_main_color")=="turquoise")
		{
			$("#medicenter_blue, #medicenter_blue_sliding").addClass("p_table_1_17");
		}
		else if(getCookie("mc_main_color")=="violet")
		{
			$("#medicenter_blue, #medicenter_blue_sliding").addClass("p_table_1_18");
		}
	}
	$(".style-selector-content ul.for-main-color a").on("click touchend", function(event, param){
		event.preventDefault();
		$(".style-selector-content ul.for-main-color li").removeClass("selected");
		$(this).parent().addClass("selected");
		setCookie("mc_main_color", $(this).data("color"));
		location.reload();
	});
	$(".style-selector-content #overlay").change(function(){
		if($(this).is(":checked"))
		{
			if($("body").is('[class*="image-"]'))
			{
				$("body").addClass("overlay");
				setCookie("cs_image_overlay", "overlay");
			}
			else
				setCookie("cs_image_overlay", "");
		}
		else
		{
			$("body").removeClass("overlay");
			setCookie("cs_image_overlay", "");
		}
	});
	$(".style-selector [name='layout_style']").change(function(){
		if($(this).val()=="boxed")
		{
			$(".site-container").addClass("boxed");
			setCookie("mc_layout", "boxed");
		}
		else
		{
			$(".site-container").removeClass("boxed");
			setCookie("mc_layout", "");
		}
		$(window).trigger('resize');
	});
	
	$(".style-selector [name='menu_type']").change(function(){
		if($(this).val()==1)
		{
			if($(".header").hasClass("layout-1"))
			{
				$(".header-container").addClass("sticky");
				if(menu_position==null)
					menu_position = $(".header-container").offset().top;
			}
			else
			{
				$(".header-container:eq(1)").addClass("sticky");
				if(menu_position==null)
					menu_position = $(".header-container:eq(1)").offset().top;
			}			
			$(document).scroll();
		}
		else
		{
			$(".header-container").removeClass("sticky");
			$("#mc-sticky-clone").remove()
		}
		setCookie("mc_sticky_menu", $(this).val());
	});
	$(".style-selector [name='header_type']").change(function(){
		setCookie("mc_header_type", parseInt($(this).val()));
		if(parseInt($(this).val())==2)
			setCookie("mc_header_sidebar_right", 1);
		location.reload();
	});
	$(".style-selector [name='style_selector_direction']").change(function(){
		setCookie("mc_direction", $(this).val());
		location.reload();
	});
	$("[name='style_selector_animations']").change(function(){
		setCookie("mc_animations", $(this).val());
		location.reload();
	});
	$("[name='style_selector_demo']").change(function(){
		if($(this).val()!="-")
		{
			removeCookie("mc_main_color");
			var page = "-" + $(this).val();
			if($(this).val()=="main")
			{
				page = "/home/";
			}
			location.href = "https://quanticalabs.com/wp_themes/medicenter" + page;
		}
	});
	$(".style-selector-reset-color").on("click", function(event){
		event.preventDefault();
		removeCookie("mc_main_color");
		location.reload();
	});
});