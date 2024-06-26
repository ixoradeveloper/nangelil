jQuery(document).ready(function($){
	function css3GridSetWidth(id)
	{
		$("#"+id).css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width() + "px");
		$("#css3_grid_" + id + "_slider_container, .css3_grid_" + id + "_pagination").css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width() + (2*$("#css3_grid_" + id + "_slider_container .css3_grid_arrow_area").outerWidth()) + "px");				
		$("#"+id+" .css3_grid_caroufredsel_wrapper").css("height", ($("#"+id+" .caption_column").length ? $("#"+id+" .caption_column").height() : $("#"+id+" [class^='column_']:first").height()) + "px");
		$(".p_table_1 .css3_grid_hidden_rows_control_"+id).css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width()-2 + "px");
		$(".p_table_2 .css3_grid_hidden_rows_control_"+id).css("width", ($("#"+id+" .caption_column").is(":visible") ? $("#"+id+" .caption_column").width() : 0) + $("#"+id+" .css3_grid_caroufredsel_wrapper").width() + "px");
	};
	var items = 1, autoplay = 0, effect = 'scroll', easing = 'swing', duration = 500, id;
	$(".css3_grid_slider").each(function(){
		var self = $(this);
		var elementClasses = $(this).attr('class').split(' ');
		for(var i=0; i<elementClasses.length; i++)
		{
			if(elementClasses[i].indexOf('id-')!=-1)
				id = elementClasses[i].replace('id-', '');
			if(elementClasses[i].indexOf('autoplay-')!=-1)
				autoplay = elementClasses[i].replace('autoplay-', '');
			if(elementClasses[i].indexOf('items-')!=-1)
				items = elementClasses[i].replace('items-', '');
			if(elementClasses[i].indexOf('scroll-')!=-1)
				scroll = elementClasses[i].replace('scroll-', '');
			if(elementClasses[i].indexOf('effect-')!=-1)
				effect = elementClasses[i].replace('effect-', '');
			if(elementClasses[i].indexOf('easing-')!=-1)
				easing = elementClasses[i].replace('easing-', '');
			if(elementClasses[i].indexOf('duration-')!=-1)
				duration = elementClasses[i].replace('duration-', '');
			if(elementClasses[i].indexOf('threshold-')!=-1)
				threshold = elementClasses[i].replace('threshold-', '');
		}
		var carouselOptions = {
			circular:  (self.hasClass('circular') ? true : false),
			infinite:  (self.hasClass('infinite') ? true : false),
			items: parseInt(items),
			prev: {
				items: parseInt(scroll),
				button: $('#css3_grid_' + id + '_prev'),
				fx: effect,
				easing: easing,
				duration: parseInt(duration)
			},
			next: {
				items: parseInt(scroll),
				button: $('#css3_grid_' + id + '_next'),
				fx: effect,
				easing: easing,
				duration: parseInt(duration)
			},
			auto: {
				items: parseInt(scroll),
				play: (parseInt(autoplay) ? true : false),
				fx: effect,
				easing: easing,
				duration: parseInt(duration)
			}
		};
		if(self.hasClass('ontouch') || self.hasClass('onmouse'))
			carouselOptions.swipe = {
				items: parseInt(scroll),
				onTouch: (self.hasClass('ontouch') ? true : false),
				onMouse: (self.hasClass('onmouse') ? true : false),
				options: {
					allowPageScroll: "none",
					threshold: parseInt(threshold)
				},
				fx: effect,
				easing: easing,
				duration: parseInt(duration)
			};
		if(self.hasClass('slidingPagination'))
			carouselOptions.pagination = {
				items: parseInt(scroll),
				container: $(".css3_grid_" + id + "_pagination"),
				fx: effect,
				easing: easing,
				duration: parseInt(duration)
			};
		$(this).carouFredSel(carouselOptions, {
			wrapper: {
				classname: 'css3_grid_caroufredsel_wrapper'
			}
		});
		css3GridSetWidth(id);
	});
	function windowResize()
	{
		$(".p_table_sliding").each(function(){
			css3GridSetWidth($(this).attr("id"));
		});
		$(".css3_grid_slider").trigger('configuration', ['debug', false, true]);
	}
	if($(".css3_grid_slider").length)
	{
		$(window).resize(windowResize);
		window.addEventListener('orientationchange', windowResize);
	}	
	$(".css3_grid_hidden_rows_control").click(function(event)
	{
		event.preventDefault();
		var self = $(this);
		self.parent().find(".css3_grid_hidden_row").toggleClass("css3_grid_hide");
		$(this).children(".css3_grid_hidden_rows_control_expand_text").toggleClass("css3_grid_hide");
		$(this).children(".css3_grid_hidden_rows_control_collapse_text").toggleClass("css3_grid_hide");
		if(self.parent().hasClass("p_table_sliding"))
		{
			var time = 250;
			var animationInterval = setInterval(function(){
				time--;
				css3GridSetWidth(self.parent().attr("id"));
				if(time==0)
					clearInterval(animationInterval);
			}, 1);
		}
	});

	// Change table pricing depending on selected pricing cycle
	function setPricingCycle(cycleID, urlHash)
	{
		var tableId = cycleID.substring(0, cycleID.length-urlHash.length-1);
		var pricingTable = $("#" + tableId);
		var pricingCycle = pricingCycles[cycleID];
		var columns_count = pricingCycle.columns.prices.length;
		var column;
		
		for(var i=0; i<columns_count; i++)
		{
			column = pricingTable.find('.pc_column_'+(i+1));
			column.find(".header_row_2 .css3_grid_vertical_align").html(pricingCycle.columns.prices[i].replace(/&#39;/g, "'"));			
			if(typeof(pricingCycle.columns.button_urls[i])!="undefined" && pricingCycle.columns.button_urls[i].length)
				column.find(".footer_row .css3_grid_vertical_align a").attr("href", pricingCycle.columns.button_urls[i]);
		}
	}
	
	function setDefaultPricingCycles()
	{
		$("ul.pricing-cycle").each(function(index, elem){
			var $this = $(this);
			var temp = $this.find("a:first").attr("href").substr(1);
			var cycleIDs = [];
			for (var key in pricingCycles) 
			{
				if (pricingCycles.hasOwnProperty(key))
				{
					if(key.indexOf(temp)!=-1)
						cycleIDs.push([key, temp]);
					if(key.indexOf(decodeURIComponent(temp))!=-1)
						cycleIDs.push([key, decodeURIComponent(temp)]);
				}
			}
			
			$this.find("a:first").addClass("selected");
			cycleIDs.forEach(function(entry) {
				setPricingCycle(entry[0], entry[1]);
			});
		});
	}
	
	function handleHashChange()
	{
		var hash = window.location.hash;
		if(hash.substr(0,7)=="#cycle-")
		{
			var temp = hash.substr(7);
			
			var cycleIDs = [];
			for (var key in pricingCycles) 
			{
				if(pricingCycles.hasOwnProperty(key))
				{
					if(key.indexOf(temp)!=-1)
						cycleIDs.push([key, temp]);
					if(key.indexOf(decodeURIComponent(temp))!=-1)
						cycleIDs.push([key, decodeURIComponent(temp)]);
				}
			}
			
			cycleIDs.forEach(function(entry){			
				setPricingCycle(entry[0], entry[1]);
				var tableId = entry[0].substring(0, entry[0].length-entry[1].length-1);				
				var link = $("#" + tableId + " ul.pricing-cycle li a[href='#" + entry[1] + "']");
				link.parents(".pricing-cycle-navigation").find("label").html(link.text())
				link.addClass("selected").parent().siblings().find("a").removeClass("selected");
			});
		}
	}
	
	setDefaultPricingCycles();
	if(typeof(window.location.hash)!="undefined")
		handleHashChange();
	
	$(window).bind("hashchange", function(e)
	{
		handleHashChange();
	});
	
	// handle changing of pricing cycle
	$("ul.pricing-cycle li a").on("click", function(event)
	{
		event.preventDefault();
		var $this = $(this);
		var cycleID = $this.attr("href").substr(1);
		var sharpPos = (window.location.href.indexOf("#")!==-1 ? window.location.href.indexOf("#") : window.location.href.length);
		window.location.href = window.location.href.substr(0, sharpPos) + decodeURIComponent("#cycle-" + cycleID);
		$this.parent().parent().parent().addClass("css3_grid_hide");
	});
	$(".pricing-cycle-navigation").mouseover(function(){
		$(this).removeClass("css3_grid_hide");
	});
});