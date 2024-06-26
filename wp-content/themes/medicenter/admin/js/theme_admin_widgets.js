jQuery(document).ready(function($){
	"use strict";
	$(document).on("click", ".widget-content [name$='[add_new_button]']", function(){
		$(this).parent().before($(this).parent().prev().clone().wrap('<div>').parent().html());
		$(this).parent().prev().find("input").val('');
		$(this).parent().prev().find("select").each(function(){
			$(this).val($(this).children("option:first").val());
		});
	});
	$(document).on("change", ".widget-content [name$='[button_style]']", function(){
		if(jQuery(this).val()=="custom")
		{
			jQuery(this).parent().nextAll(".custom-color-row").css("display", "block");
		}
		else
		{
			jQuery(this).parent().nextAll(".custom-color-row").css("display", "none");
		}
	});
	$(document).on("widget-added widget-updated", function(event, widget){
		//colorpicker
		if($(".color").length)
		{
			$(".color").ColorPicker({
				onChange: function(hsb, hex, rgb, el) {
					$(el).val(hex).trigger("change");
					$(el).prev(".color_preview").css("background-color", "#" + hex);
				},
				onSubmit: function(hsb, hex, rgb, el){
					$(el).val(hex).trigger("change");
					$(el).ColorPickerHide();
				},
				onBeforeShow: function (){
					var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
					$(this).ColorPickerSetColor(color);
					$(this).prev(".color_preview").css("background-color", color);
				}
			}).on('keyup', function(event, param){
				$(this).ColorPickerSetColor(this.value);
				
				var default_color = $(this).attr("data-default-color");
				$(this).prev(".color_preview").css("background-color", (this.value!="none" ? "#" + (this.value!="" ? (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : default_color) : "transparent"));
			});
		}
    });
	$(document).on("change", ".widget-content [name$='[tab_color]'], .widget-content [name$='[button_color]'], .widget-content [name$='[button_hover_color]'], .widget-content [name$='[color]']", function(){
		$(this).next().next().val($(this).val()).trigger("keyup", [1]);
	});
});