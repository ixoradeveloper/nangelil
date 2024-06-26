<?php 
global $theme_options; 
$primary_color = "";
$secondary_color = "";
$tertiary_color = "";
if(isset($_COOKIE['mc_main_color']))
{
	if($_COOKIE['mc_main_color']=="blue")
	{
		$primary_color = "42B3E5";
		$secondary_color = "3156A3";
		$tertiary_color = "0384CE";
	}
	else if($_COOKIE['mc_main_color']=="green")
	{
		$primary_color = "7CBA3D";
		$secondary_color = "008238";
		$tertiary_color = "43A140";
	}
	else if($_COOKIE['mc_main_color']=="orange")
	{
		$primary_color = "FFA800";
		$secondary_color = "CB451B";
		$tertiary_color = "F17800";
	}
	else if($_COOKIE['mc_main_color']=="red")
	{
		$primary_color = "F37548";
		$secondary_color = "C03427";
		$tertiary_color = "DB5237";
	}
	else if($_COOKIE['mc_main_color']=="turquoise")
	{
		$primary_color = "00B6CC";
		$secondary_color = "006688";
		$tertiary_color = "0097B5";
	}
	else if($_COOKIE['mc_main_color']=="violet")
	{
		$primary_color = "9187C4";
		$secondary_color = "3E4C94";
		$tertiary_color = "6969B3";
	}
}
else
{
	$primary_color = $theme_options['primary_color'];
	$secondary_color = $theme_options['secondary_color'];
	$tertiary_color = $theme_options['tertiary_color'];
}
if(strtoupper($primary_color)=="42B3E5")
	$primary_color = "";
if(strtoupper($secondary_color)=="3156A3")
	$secondary_color = "";
if(strtoupper($tertiary_color)=="0384CE")
	$tertiary_color = "";
?>
<!--custom style-->
<style type="text/css">
	<?php if($primary_color!=""): ?>
	.single-ql_services .vertical-menu li:hover>a,
	.single-ql_services .vertical-menu li:hover>a::after,
	.single-ql_services .vertical-menu li ul li:hover>a,
	.single-ql_services .vertical-menu li ul li:hover>a::after,
	.single-ql_services .vertical-menu li ul li ul li:hover>a,
	.single-ql_services .vertical-menu li ul li ul li:hover>a::after,
	.mc-icon,
	.mc-features-style-light .hexagon span::before,
	.hexagon.style-light span:before,
	.mc-features-style-light .circle span::before,
	.icon-single.circle.style-light span::before,
	.services-list li .service-icon::before,
	.site-container .simple-list li::before,
	.single .post-content ul li:not([class^="template-"])::before,
	.single-page ul li:not([class^="template-"])::before,
	.wpb_text_column ul li:not([class^="template-"])::before,
	.info-box::before,
	.rs-layer.slider-heading.mc-colored a
	{
		color: #<?php echo $primary_color; ?>;
	}
	.background-primary-color,
	.box-header::after,
	.sf-menu li:hover a, .sf-menu li.selected a, .sf-menu li.current-menu-item a, .sf-menu li.current-menu-ancestor a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-item>a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-parent a,
	.single-ql_services .vertical-menu li.current-menu-item>a,
	.single-ql_services .vertical-menu li.current-menu-ancestor>a,
	.social-icons li a:hover::before,
	.icon-single[class^="social-"]:hover::before, .icon-single[class*=" social-"]:hover::before,
	.hexagon,
	.timeline-item label,
	.items-list .value,
	.comment-box .comments-number a,
	.comment-form .mc-button:hover,
	.contact-form .mc-button:hover,
	.post-password-form .mc-button:hover,
	.pagination li a:hover,
	.pagination li.selected a,
	.pagination li.selected span,
	.categories li a:hover,
	.widget_categories li a:hover,
	.categories li.current-cat a,
	.widget_categories li.current-cat a,
	.widget_tag_cloud a:hover,
	.tabs-box-navigation.sf-menu .tabs-box-navigation-selected:hover,
	.timetable .event.tooltip:hover,
	.timetable .event .event-container.tooltip:hover,
	.tooltip .tooltip-content,
	.gallery-box:hover .description,
	.gallery-box .controls a:hover,
	.widget_archive li a:hover,
	.scroll-top:hover,
	.home-box-container:nth-child(3n+1),
	.footer-banner-box-container .footer-banner-box:nth-child(3n+1),
	.more.light-color,
	.more.dark-color:hover,
	.more.light-color.no-hover-color:hover,
	body .vc_progress_bar .vc_single_bar .vc_bar,
	.arrow-container .arrow,
	body .vc_progress_bar .vc_single_bar .vc_bar+.vc_label_units
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .product-categories li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a.current,
	.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
	.woocommerce-cart .woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce .widget_product_search form input[type='submit']:hover,
	.woocommerce .widget_product_search form button:hover,
	.woocommerce div.product form.cart .button.single_add_to_cart_button:hover,
	.woocommerce #review_form #respond .form-submit input:hover,
	.woocommerce #payment #place_order:hover,
	.woocommerce .cart input.button:hover,
	.woocommerce .button.wc-forward:hover,
	.woocommerce #respond input#submit:hover, 
	.woocommerce a.button:hover, 
	.woocommerce button.button:hover, 
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt:hover, 
	.woocommerce a.button.alt:hover, 
	.woocommerce button.button.alt:hover, 
	.woocommerce input.button.alt:hover,
	.woocommerce .cart .coupon input.button:hover,
	.woocommerce .comment-reply-title:after,
	.woocommerce mark,
	.woocommerce .quantity .plus:hover,
	.woocommerce .quantity .minus:hover,
	.woocommerce a.remove:hover,
	.woocommerce-checkout .woocommerce h2:after,
	span.cart-items-number
	<?php
	endif;
	?>
	{
		background-color: #<?php echo $primary_color; ?>;
	}
	.mc-features-style-light.light-colored .hexagon,
	.hexagon.style-light.light-colored,
	.mc-features-style-light.light-colored .circle span
	{
		background-color: #<?php echo $primary_color; ?>26;
	}
	.rs-layer.slider-heading.mc-colored ::after
	{
		background: #<?php echo $primary_color; ?>7F;
	}
	.header.layout-2 .sf-menu li:hover a, .header.layout-2 .sf-menu li.selected a, .header.layout-2 .sf-menu li.current-menu-item a, .header.layout-2 .sf-menu li.current-menu-ancestor a,
	.header.layout-2 .sf-menu li ul li a:hover, .header.layout-2 .sf-menu li ul li.selected a, .header.layout-2 .sf-menu li ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a:hover, .header.layout-2 .sf-menu li ul li.menu-item-type-custom a:hover,
	.sf-menu li ul li a:hover, .sf-menu li ul li.selected a, .sf-menu li ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item a,
	.sf-menu>li.menu-item-has-children ul li a:hover, .sf-menu>li.menu-item-has-children:hover ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item ul li a:hover,
	.sf-menu>li.menu-item-has-children:hover ul li.selected ul li a:hover,.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a:hover, .sf-menu>li.menu-item-has-children:hover ul li ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.current-menu-item a,
	.sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a:hover, .sf-menu li ul li.menu-item-type-custom a:hover, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.menu-item-type-custom a:hover,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-item>a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-parent a,
	.vertical-menu li a:hover,
	.vertical-menu li.is-active a,
	.timeline-item .label-container .timeline-circle::after,
	.scrolling-list-control-left:hover,
	.scrolling-list-control-right:hover,
	.caroufredsel-wrapper-testimonials.grey+.scrolling-controls .scrolling-list-control-left:hover,
	.caroufredsel-wrapper-testimonials.grey+.scrolling-controls .scrolling-list-control-right:hover,
	.comment-form .mc-button:hover,
	.contact-form .mc-button:hover,
	.post-password-form .mc-button:hover,
	.pagination li a:hover,
	.pagination li.selected a,
	.pagination li.selected span,
	.categories li a:hover,
	.widget_categories li a:hover,
	.categories li.current-cat a,
	.widget_categories li.current-cat a,
	.widget_tag_cloud a:hover,
	.tabs-box-navigation.sf-menu li:hover ul, .tabs-box-navigation.sf-menu li.sfHover ul,
	.controls .prev:hover,
	.controls .next:hover,
	.controls .close:hover,
	.gallery-box:hover .item-details,
	.widget_archive li a:hover,
	.footer .header-right a.scrolling-list-control-left:hover, 
	.footer .header-right a.scrolling-list-control-right:hover,
	.header-right a.scrolling-list-control-left:hover, 
	.header-right a.scrolling-list-control-right:hover,
	.tabs-navigation li a:hover,
	.tabs-navigation li a.selected,
	.tabs-navigation li.ui-tabs-active a,
	.scrolling-list li a:hover .number,
	.more.light-color,
	.more.dark-color:hover,
	.more.light-color.no-hover-color:hover,
	.services-list li .service-details::after,
	body .site-container .clearfix.has-gutenberg-blocks blockquote.wp-block-quote
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .product-categories li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a.current,
	.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
	.woocommerce-cart .woocommerce .wc-proceed-to-checkout a.checkout-button:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce .widget_product_search form input[type='submit']:hover,
	.woocommerce .widget_product_search form button:hover,
	.woocommerce div.product form.cart .button.single_add_to_cart_button:hover,
	.woocommerce #review_form #respond .form-submit input:hover,
	.woocommerce #payment #place_order:hover,
	.woocommerce .cart input.button:hover,
	.woocommerce .button.wc-forward:hover,
	.woocommerce #respond input#submit:hover, 
	.woocommerce a.button:hover, 
	.woocommerce button.button:hover, 
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt:hover, 
	.woocommerce a.button.alt:hover, 
	.woocommerce button.button.alt:hover, 
	.woocommerce input.button.alt:hover,
	.woocommerce .cart .coupon input.button:hover,
	.woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce .woocommerce-message,
	.woocommerce .quantity .plus:hover,
	.woocommerce .quantity .minus:hover
	<?php
	endif;
	?>
	{
		border-color: #<?php echo $primary_color; ?>;
	}
	.sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a,
	.sf-menu>li.menu-item-has-children:hover ul li.selected ul li a,
	.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a,
	.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.menu-item-type-custom a,
	.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item ul li a,
	.sf-menu li ul li.menu-item-type-custom a
	{
		color: #666;
		border-color: #E5E5E5;
	}
	.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a,
	.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li a,
	.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a,
	.header.layout-2 .sf-menu li ul li.menu-item-type-custom a
	{
		border-color: #E5E5E5;
	}
	.hexagon::before,
	.hexagon.small::before,
	.comment-box .arrow-comments,
	.tooltip .tooltip-arrow
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active span,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a.selected,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a
	<?php
	endif;
	?>
	{
		border-bottom-color: #<?php echo $primary_color; ?>;
	}
	.hexagon::after,
	.hexagon.small::after,
	.comment-box .arrow-comments,
	.tooltip .tooltip-arrow
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active span
	<?php
	endif;
	?>
	{
		border-top-color: #<?php echo $primary_color; ?>;
	}
	.timeline-item .label-triangle
	{
		border-left-color: #<?php echo $primary_color; ?>;
	}
	.mc-features-style-light.light-colored .hexagon::after,
	.mc-features-style-light.light-colored .hexagon.small::after,
	.hexagon.style-light.light-colored::after,
	.hexagon.small.style-light.light-colored::after
	{
		border-top-color: #<?php echo $primary_color; ?>26;
	}
	.mc-features-style-light.light-colored .hexagon::before,
	.mc-features-style-light.light-colored .hexagon.small::before,
	.hexagon.style-light.light-colored::before,
	.hexagon.small.style-light.light-colored::before
	{
		border-bottom-color: #<?php echo $primary_color; ?>26;
	}
	<?php endif;
	if($secondary_color!=""): ?>
	a,
	blockquote,
	blockquote p,
	.sentence,
	.bread-crumb li a:hover,
	.more,
	.accordion .ui-accordion-header.ui-state-hover h3,
	.post-footer-details li a:hover,
	#cancel_comment:hover,
	.button-label
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .posted_in a:hover,
	.woocommerce-message a,
	.woocommerce-info a,
	.woocommerce-error a,
	.woocommerce-review-link,
	.woocommerce-checkout #payment .payment_method_paypal .about_paypal
	<?php
	endif;
	?>
	{
		color: #<?php echo $secondary_color; ?>;
	}
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	.woocommerce a.remove
	{
		color: #<?php echo $secondary_color; ?> !important;
	}
	<?php
	endif;
	?>
	.background-secondary-color,
	.background-secondary-color>.wpb_wrapper>.home-box-container,
	.more.light:hover,
	.more.dark-color,
	.more.light-color:hover,
	.comment-box .date .value,
	.comment-form .mc-button,
	.contact-form .mc-button,
	.post-password-form .mc-button,
	.ui-datepicker-current-day,
	.wpb_content_element .accordion .ui-accordion-header.ui-state-active,
	.accordion .ui-accordion-header.ui-state-active,
	.tabs-box-navigation.sf-menu .tabs-box-navigation-selected,
	.dropcap .dropcap-label,
	.timetable .event,
	.tip,
	.home-box-container:nth-child(3n+3),
	.footer-banner-box-container .footer-banner-box:nth-child(3n+3),
	.hexagon.fancybox,
	.circle.fancybox span,
	.arrow-container .arrow-dark
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce #respond input#submit, 
	.woocommerce a.button, 
	.woocommerce button.button, 
	.woocommerce input.button,
	.woocommerce #respond input#submit.alt, 
	.woocommerce a.button.alt, 
	.woocommerce button.button.alt, 
	.woocommerce input.button.altm,
	.woocommerce .widget_product_search form input[type='submit'],
	.woocommerce .widget_product_search form button,
	.woocommerce .cart .coupon input.button,
	.woocommerce .button.add_to_cart_button.loading,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce div.product form.cart .button.single_add_to_cart_button,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce #payment #place_order,
	.woocommerce .cart input.button,
	.woocommerce .button.wc-forward,
	.woocommerce span.onsale,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range
	<?php
	endif;
	?>
	{
		background-color: #<?php echo $secondary_color; ?>;
	}
	blockquote,
	.more.dark-color,
	.more.light-color:hover,
	.more.light:hover,
	.comment-form .mc-button,
	.contact-form .mc-button,
	.post-password-form .mc-button,
	.wpb_content_element .accordion .ui-accordion-header.ui-state-active,
	.accordion .ui-accordion-header.ui-state-active,
	.services-list ul li:nth-child(3n+3) .service-details::after
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce #respond input#submit, 
	.woocommerce a.button, 
	.woocommerce button.button, 
	.woocommerce input.button,
	.woocommerce #respond input#submit.alt, 
	.woocommerce a.button.alt, 
	.woocommerce button.button.alt, 
	.woocommerce input.button.altm,
	.woocommerce .widget_product_search form input[type='submit'],
	.woocommerce .widget_product_search form button,
	.woocommerce .cart .coupon input.button,
	.woocommerce .button.add_to_cart_button.loading,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce div.product form.cart .button.single_add_to_cart_button,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce #payment #place_order,
	.woocommerce .cart input.button,
	.woocommerce .button.wc-forward,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle
	<?php
	endif;
	?>
	{
		border-color: #<?php echo $secondary_color; ?>;
	}
	.comment-box .date .arrow-date,
	.hexagon.fancybox::after
	{
		border-top-color: #<?php echo $secondary_color; ?>;
	}
	.comment-box .date .arrow-date,
	.hexagon.fancybox::before
	{
		border-bottom-color: #<?php echo $secondary_color; ?>;
	}
	<?php endif;
	if($tertiary_color!=""): ?>
	.background-tertiary-color,
	.home-box-container:nth-child(3n+2),
	.footer-banner-box-container .footer-banner-box:nth-child(3n+2)
	{
		background-color: #<?php echo $tertiary_color; ?>;
	}
	.services-list ul li:nth-child(3n+2) .service-details::after
	{
		border-color: #<?php echo $tertiary_color; ?>;
	}
	<?php endif;
	if($theme_options["site_background_color"]!=""): ?>
	body
	{
		background-color: #<?php echo $theme_options["site_background_color"]; ?>;
	}
	<?php endif;
	if($theme_options["header_background_color"]!=""): ?>
	.header-container
	{
		background-color: #<?php echo $theme_options["header_background_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_background_color"]!=""): ?>
	.site-container
	{
		background-color: #<?php echo $theme_options["body_background_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_background_color"]!=""): ?>
	.footer-container
	{
		background-color: #<?php echo $theme_options["footer_background_color"]; ?>;
	}
	<?php endif;
	if($theme_options["copyright_area_background_color"]!=""): ?>
	.copyright-area-container
	{
		background-color: #<?php echo $theme_options["copyright_area_background_color"]; ?>;
	}
	<?php endif;
	if($theme_options["link_color"]!=""): ?>
	a,
	.more
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce-message a,
	.woocommerce-info a,
	.woocommerce-error a,
	.woocommerce-review-link,
	.woocommerce-checkout #payment .payment_method_paypal .about_paypal
	<?php
	endif;
	?>
	{
		color: #<?php echo $theme_options["link_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["link_hover_color"]!=""): ?>
	a:hover,
	.bread-crumb li a:hover,
	.post-footer-details li a:hover,
	#cancel_comment:hover
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .posted_in a:hover
	<?php
	endif;
	?>
	{
		color: #<?php echo $theme_options["link_hover_color"]; ?>;
	}
	<?php endif;
	if($theme_options["footer_link_color"]!=""): ?>
	.footer a,
	.footer .scrolling-list li a
	{
		color: #<?php echo $theme_options["footer_link_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_link_hover_color"]!=""): ?>
	.footer a:hover,
	.footer .scrolling-list li a:hover
	{
		color: #<?php echo $theme_options["footer_link_hover_color"]; ?>;
	}
	<?php endif;
	if($theme_options["body_headers_color"]!=""): ?>
	h1, h2, h3, h4, h5,
	h1 a, h2 a, h3 a, h4 a, h5 a,
	h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover
	{
		color: #<?php echo $theme_options["body_headers_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["body_headers_border_color"]!=""): ?>
	.box-header::after
	<?php 
	if(is_plugin_active('woocommerce/woocommerce.php')): ?>	
	,
	.woocommerce .comment-reply-title::after,
	.woocommerce-checkout .woocommerce h2::after
	<?php endif; ?>
	{
		<?php if($theme_options["body_headers_border_color"]=="none"): ?>
		background: none;
		height: 0;
		margin-top: 0;
		<?php else: ?>
		background: #<?php echo $theme_options["body_headers_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if(is_plugin_active('woocommerce/woocommerce.php') && $theme_options["body_headers_border_color"]!=""): ?>	
	.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a.selected,
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a
	{
		border-bottom-color: #<?php echo $theme_options["body_headers_border_color"] ?>;
	}
	<?php endif; 
	if($theme_options["body_text_color"]!=""): ?>
	p
	{
		color: #<?php echo $theme_options["body_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["timeago_label_color"]!=""): ?>
	.timeago
	{
		color: #<?php echo $theme_options["timeago_label_color"]; ?>;
	}
	<?php endif;
	if($theme_options["footer_headers_color"]!=""): ?>
	.footer-banner-box h2,
	.footer .box-header
	{
		color: #<?php echo $theme_options["footer_headers_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["footer_headers_border_color"]!=""): ?>
	.footer .box-header:after
	{
		<?php if($theme_options["footer_headers_border_color"]=="none"): ?>
		background: none;
		height: 0;
		margin-top: 0;
		<?php else: ?>
		background: #<?php echo $theme_options["footer_headers_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["footer_text_color"]!=""): ?>
	.footer,
	.footer .contact-data li,
	.footer-box-container,
	.footer-box-container p,
	.copyright-area-container
	{
		color: #<?php echo $theme_options["footer_text_color"]; ?>;
	}
	<?php endif;
	if($theme_options["footer_timeago_label_color"]!=""): ?>
	.footer .timeago
	{
		color: #<?php echo $theme_options["footer_timeago_label_color"]; ?>;
	}
	<?php endif;
	if($theme_options["sentence_color"]!=""): ?>
	.sentence
	{
		color: #<?php echo $theme_options["sentence_color"]; ?>;
	}
	<?php endif;
	if($theme_options["quote_color"]!=""): ?>
	blockquote,
	blockquote p
	{
		color: #<?php echo $theme_options["quote_color"]; ?>;
		border-color:  #<?php echo $theme_options["quote_color"]; ?>;
	}
	<?php
	if($theme_options["quote_color"]!="" && is_plugin_active('woocommerce/woocommerce.php')):
	?>
	.woocommerce mark
	{
		background:  #<?php echo $theme_options["quote_color"]; ?>;
	}
	<?php
	endif;
	?>
	<?php endif; 
	if($theme_options["logo_text_color"]!=""): ?>
	.logo
	{
		color: #<?php echo $theme_options["logo_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["categories_and_pagination_color"]!="" || $theme_options["categories_and_pagination_border_color"]!="" || $theme_options["categories_and_pagination_background_color"]): ?>
	.categories li, .widget_categories li, .widget_tag_cloud a, .widget_archive li a,
	.categories li a, .widget_categories li a,
	.pagination li a, .pagination li span
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .product-categories li a,
	.woocommerce .woocommerce-pagination ul.page-numbers li a,
	.woocommerce .woocommerce-pagination ul.page-numbers li span,
	.woocommerce .woocommerce-pagination ul.page-numbers li a:focus,
	.woocommerce .quantity .plus, 
	.woocommerce .quantity .minus
	<?php
	endif;
	?>
	{
		<?php if($theme_options["categories_and_pagination_color"]!=""): ?>
		color: #<?php echo $theme_options["categories_and_pagination_color"]; ?>;
		<?php endif;
		if($theme_options["categories_and_pagination_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["categories_and_pagination_border_color"]; ?>;
		<?php endif;
		if($theme_options["categories_and_pagination_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["categories_and_pagination_background_color"] ?>;
		<?php endif; ?>	
	}
	<?php endif; 
	if($theme_options["categories_and_pagination_hover_color"]!="" || $theme_options["categories_and_pagination_border_hover_color"]!="" || $theme_options["categories_and_pagination_hover_background_color"]!=""): ?>
	.categories li a:hover,
	.widget_categories li a:hover,
	.categories li.current-cat a,
	.widget_categories li.current-cat a,
	.widget_tag_cloud a:hover,
	.widget_archive li a:hover,
	.pagination li a:hover,
	.pagination li.selected a,
	.pagination li.selected span
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce .product-categories li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a:hover,
	.woocommerce .woocommerce-pagination ul.page-numbers li a.current,
	.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
	.woocommerce .quantity .plus:hover, 
	.woocommerce .quantity .minus:hover
	<?php
	endif;
	?>
	{
		<?php if($theme_options["categories_and_pagination_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["categories_and_pagination_hover_color"]; ?>;
		<?php endif;
		if($theme_options["categories_and_pagination_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["categories_and_pagination_border_hover_color"]; ?>;
		<?php endif;
		if($theme_options["categories_and_pagination_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["categories_and_pagination_hover_background_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["light_button_color"]!="" || $theme_options["light_button_border_color"]!="" || $theme_options["light_button_background_color"]): ?>
	.more.light
	{
		<?php if($theme_options["light_button_color"]!=""): ?>
		color: #<?php echo $theme_options["light_button_color"]; ?>;
		<?php endif;
		if($theme_options["light_button_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["light_button_border_color"]; ?>;
		<?php endif;
		if($theme_options["light_button_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["light_button_background_color"] ?>;
		<?php endif; ?>	
	}
	<?php endif;
	if($theme_options["light_button_hover_color"]!="" || $theme_options["light_button_border_hover_color"]!="" || $theme_options["light_button_hover_background_color"]!=""): ?>
	.more.light:hover
	{
		<?php if($theme_options["light_button_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["light_button_hover_color"]; ?>;
		<?php endif;
		if($theme_options["light_button_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["light_button_border_hover_color"]; ?>;
		<?php endif;
		if($theme_options["light_button_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["light_button_hover_background_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["light_color_button_color"]!="" || $theme_options["light_color_button_border_color"]!="" || $theme_options["light_color_button_background_color"]): ?>
	.more.light-color,
	.more.light-color.no-hover-color:hover
	{
		<?php if($theme_options["light_color_button_color"]!=""): ?>
		color: #<?php echo $theme_options["light_color_button_color"]; ?>;
		<?php endif;
		if($theme_options["light_color_button_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["light_color_button_border_color"]; ?>;
		<?php endif;
		if($theme_options["light_color_button_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["light_color_button_background_color"] ?>;
		<?php endif; ?>	
	}
	<?php endif;
	if($theme_options["light_color_button_hover_color"]!="" || $theme_options["light_color_button_border_hover_color"]!="" || $theme_options["light_color_button_hover_background_color"]!=""): ?>
	.more.light-color:hover
	{
		<?php if($theme_options["light_color_button_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["light_color_button_hover_color"]; ?>;
		<?php endif;
		if($theme_options["light_color_button_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["light_color_button_border_hover_color"]; ?>;
		<?php endif;
		if($theme_options["light_color_button_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["light_color_button_hover_background_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["dark_color_button_color"]!="" || $theme_options["dark_color_button_border_color"]!="" || $theme_options["dark_color_button_background_color"]): ?>
	.more.dark-color
	{
		<?php if($theme_options["dark_color_button_color"]!=""): ?>
		color: #<?php echo $theme_options["dark_color_button_color"]; ?>;
		<?php endif;
		if($theme_options["dark_color_button_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["dark_color_button_border_color"]; ?>;
		<?php endif;
		if($theme_options["dark_color_button_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["dark_color_button_background_color"] ?>;
		<?php endif; ?>	
	}
	<?php endif;
	if($theme_options["dark_color_button_hover_color"]!="" || $theme_options["dark_color_button_border_hover_color"]!="" || $theme_options["dark_color_button_hover_background_color"]!=""): ?>
	.more.dark-color:hover
	{
		<?php if($theme_options["dark_color_button_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["dark_color_button_hover_color"]; ?>;
		<?php endif;
		if($theme_options["dark_color_button_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["dark_color_button_border_hover_color"]; ?>;
		<?php endif;
		if($theme_options["dark_color_button_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["dark_color_button_hover_background_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["scrolling_list_number_color"]!="" || $theme_options["scrolling_list_number_border_color"]!=""): ?>
	.scrolling-list li .number
	{
		<?php if($theme_options["scrolling_list_number_color"]!=""): ?>
		color: #<?php echo $theme_options["scrolling_list_number_color"]; ?>;
		<?php endif;
		if($theme_options["scrolling_list_number_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["scrolling_list_number_border_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["scrolling_list_number_hover_color"]!="" || $theme_options["scrolling_list_number_border_hover_color"]!=""): ?>
	.scrolling-list li a:hover .number
	{
		<?php if($theme_options["scrolling_list_number_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["scrolling_list_number_hover_color"]; ?>;
		<?php endif;
		if($theme_options["scrolling_list_number_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["scrolling_list_number_border_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["scrolling_list_control_arrow_color"]!="" || $theme_options["scrolling_list_control_border_color"]!=""): ?>
	.header-right a.scrolling-list-control-left, .header-right a.scrolling-list-control-right
	{
		<?php if($theme_options["scrolling_list_control_arrow_color"]!=""): ?>
		color: #<?php echo $theme_options["scrolling_list_control_arrow_color"]; ?>;
		<?php endif;
		if($theme_options["scrolling_list_control_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["scrolling_list_control_border_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["scrolling_list_control_arrow_hover_color"]!="" || $theme_options["scrolling_list_control_arrow_border_hover_color"]!=""): ?>
	.header-right a.scrolling-list-control-left:hover, .header-right a.scrolling-list-control-right:hover
	{
		<?php if($theme_options["scrolling_list_control_arrow_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["scrolling_list_control_arrow_hover_color"]; ?>;
		<?php endif;
		if($theme_options["scrolling_list_control_arrow_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["scrolling_list_control_arrow_border_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["footer_scrolling_list_control_arrow_color"]!="" || $theme_options["footer_scrolling_list_control_border_color"]!=""): ?>
	.footer .header-right a.scrolling-list-control-left, .footer .header-right a.scrolling-list-control-right
	{
		<?php if($theme_options["footer_scrolling_list_control_arrow_color"]!=""): ?>
		color: #<?php echo $theme_options["footer_scrolling_list_control_arrow_color"]; ?>;
		<?php endif;
		if($theme_options["footer_scrolling_list_control_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["footer_scrolling_list_control_border_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["footer_scrolling_list_control_arrow_hover_color"]!="" || $theme_options["footer_scrolling_list_control_arrow_border_hover_color"]!=""): ?>
	.footer .header-right a.scrolling-list-control-left:hover, .footer .header-right a.scrolling-list-control-right:hover
	{
		<?php if($theme_options["footer_scrolling_list_control_arrow_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["footer_scrolling_list_control_arrow_hover_color"]; ?>;
		<?php endif;
		if($theme_options["footer_scrolling_list_control_arrow_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["footer_scrolling_list_control_arrow_border_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["menu_position_text_color"]!="" || $theme_options["menu_position_background_color"]!=""): ?>
	.sf-menu li a, .sf-menu li a:visited
	{
		<?php if($theme_options["menu_position_text_color"]!=""): ?>
		color: #<?php echo $theme_options["menu_position_text_color"] ?>;
		<?php endif;
		if($theme_options["menu_position_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["menu_position_background_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["menu_position_hover_text_color"]!="" || $theme_options["menu_position_hover_background_color"]!=""): ?>
	.sf-menu li:hover a, .sf-menu li.selected a, .sf-menu li.current-menu-item a, .sf-menu li.current-menu-ancestor a
	{
		<?php if($theme_options["menu_position_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["menu_position_hover_text_color"] ?>;
		<?php endif; 
		if($theme_options["menu_position_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["menu_position_hover_background_color"] ?>;
		<?php endif; ?>
	}
	.header.layout_2 .sf-menu li:hover a, .header.layout_2 .sf-menu li.selected a, .header.layout_2 .sf-menu li.current-menu-item a, .header.layout_2 .sf-menu li.current-menu-ancestor a
	{
		<?php
		if($theme_options["menu_position_hover_background_color"]!=""): ?>
		border-color: #<?php echo $theme_options["menu_position_hover_background_color"] ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["menu_position_childrens_hover_text_color"]!="" || $theme_options["menu_position_childrens_hover_background_color"]!=""): ?>
	.sf-menu>li.menu-item-has-children:hover a
	{
		<?php if($theme_options["menu_position_childrens_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["menu_position_childrens_hover_text_color"] ?>;
		<?php endif;
		if($theme_options["menu_position_childrens_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["menu_position_childrens_hover_background_color"] ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["submenu_position_text_color"]!="" || $theme_options["submenu_position_border_color"]!=""): ?>
	.sf-menu li:hover ul a, .sf-menu > li.menu-item-has-children:hover ul a,
	.header.layout-2 .sf-menu li:hover ul a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul a
	{
		<?php if($theme_options["submenu_position_text_color"]!=""): ?>
		color: #<?php echo $theme_options["submenu_position_text_color"] ?>;
		<?php endif;
		if($theme_options["submenu_position_border_color"]=="none"): ?>
		border: none;
		padding-bottom: 16px;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["submenu_position_border_color"] ?>;
		<?php endif; ?>
	}
	<?php
	if($theme_options["submenu_position_text_color"]!="" || $theme_options["submenu_position_border_color"]!=""):?>
	.vertical-menu li a
	{
		<?php if($theme_options["submenu_position_text_color"]!=""): ?>
		color: #<?php echo $theme_options["submenu_position_text_color"] ?>;
		<?php endif;
		if($theme_options["submenu_position_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["submenu_position_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; ?>
	@media screen and (max-width:1009px)
	{
		.sf-menu li:hover ul a, .sf-menu > li.menu-item-has-children:hover ul a,
		.header.layout-2 .sf-menu li:hover ul a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul a
		{
			<?php
			if($theme_options["submenu_position_border_color"]=="none"): ?>
			padding-bottom: 13px;
			<?php else: ?>
			padding-bottom: 12px;
			<?php endif; ?>
		}
	}
	<?php endif; 
	if($theme_options["submenu_position_hover_text_color"]!="" || $theme_options["submenu_position_hover_border_color"] || $theme_options["submenu_position_border_color"]=="none"): ?>
	.sf-menu li ul li a:hover, .sf-menu li ul li.selected a, .sf-menu li ul li.current-menu-item a,
	.sf-menu>li.menu-item-has-children ul li a:hover, .sf-menu>li.menu-item-has-children:hover ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item ul li a:hover,
	.sf-menu>li.menu-item-has-children:hover ul li.selected ul li a:hover,.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a:hover, .sf-menu>li.menu-item-has-children:hover ul li ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.current-menu-item a,
	.sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a:hover, .sf-menu li ul li.menu-item-type-custom a:hover,
	.header.layout-2 .sf-menu li ul li a:hover, .header.layout-2 .sf-menu li ul li.selected a, .header.layout-2 .sf-menu li ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a:hover, .header.layout-2 .sf-menu li ul li.menu-item-type-custom a:hover
	{
		<?php if($theme_options["submenu_position_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["submenu_position_hover_text_color"] ?>;
		<?php endif;
		if($theme_options["submenu_position_hover_border_color"]=="none"): ?>
		border: none;
		padding-bottom: 16px;
		<?php else: ?>
		border-bottom: 2px solid #<?php echo $theme_options["submenu_position_hover_border_color"] ?>;
		padding-bottom: 14px;
		<?php endif; ?>
	}
	@media screen and (max-width:1009px)
	{
		.sf-menu li ul li a:hover, .sf-menu li ul li.selected a, .sf-menu li ul li.current-menu-item a,
		.sf-menu>li.menu-item-has-children ul li a:hover, .sf-menu>li.menu-item-has-children:hover ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item a,
		.sf-menu>li.menu-item-has-children:hover ul li.selected ul li a:hover,.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a:hover, .sf-menu>li.menu-item-has-children:hover ul li ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li ul li.current-menu-item a, .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.selected a, .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.current-menu-item a,
		.sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a:hover, .sf-menu li ul li.menu-item-type-custom a:hover,
		.header.layout-2 .sf-menu li ul li a:hover, .header.layout-2 .sf-menu li ul li.selected a, .header.layout-2 .sf-menu li ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a:hover, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.selected a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li.current-menu-item a, .header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a:hover, .header.layout-2 .sf-menu li ul li.menu-item-type-custom a:hover
		{
			<?php if($theme_options["submenu_position_hover_text_color"]!=""): ?>
			color: #<?php echo $theme_options["submenu_position_hover_text_color"] ?>;
			<?php endif;
			if($theme_options["submenu_position_hover_border_color"]=="none"): ?>
			padding-bottom: 13px;
			<?php else: ?>
			padding-bottom: 11px;
			<?php endif; ?>
		}
	}
	.sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a,
	.sf-menu>li.menu-item-has-children:hover ul li.selected ul li a,
	.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a,
	.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item ul li a,
	.sf-menu li ul li.menu-item-type-custom a,
	.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a,
	.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li a,
	.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a,
	.header.layout-2 .sf-menu li ul li.menu-item-type-custom a
	{
		color: #<?php echo ($theme_options["submenu_position_text_color"]!="" ? $theme_options["submenu_position_text_color"] : "666"); ?>;
		<?php if($theme_options["submenu_position_border_color"]=="none"): ?>
		border: none;
		padding-bottom: 16px;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo ($theme_options["submenu_position_border_color"]!="" ? $theme_options["submenu_position_border_color"] : "E8E8E8"); ?>;
		padding-bottom: 15px;
		<?php endif; ?>
	}
	@media screen and (max-width:1009px)
	{
		.sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a,
		.sf-menu>li.menu-item-has-children:hover ul li.selected ul li a,
		.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a,
		.sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li.current-menu-item ul li a,
		.sf-menu li ul li.menu-item-type-custom a,
		.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.menu-item-type-custom a,
		.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.selected ul li a,
		.header.layout-2 .sf-menu>li.menu-item-has-children:hover ul li.current-menu-item ul li a,
		.header.layout-2 .sf-menu li ul li.menu-item-type-custom a
		{
			<?php if($theme_options["submenu_position_border_color"]=="none"): ?>
			border: none;
			padding-bottom: 13px;
			<?php else: ?>
			border-bottom: 1px solid #<?php echo ($theme_options["submenu_position_border_color"]!="" ? $theme_options["submenu_position_border_color"] : "E8E8E8"); ?>;
			padding-bottom: 12px;
			<?php endif; ?>
		}
	}
	<?php
	if($theme_options["submenu_position_hover_text_color"]!="" || $theme_options["submenu_position_hover_border_color"]!=""):?>
	.vertical-menu li a:hover,
	.vertical-menu li.is-active a
	{
		<?php if($theme_options["submenu_position_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["submenu_position_hover_text_color"] ?>;
		<?php endif;
		if($theme_options["submenu_position_hover_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border-bottom: 2px solid #<?php echo $theme_options["submenu_position_hover_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	endif;
	if($theme_options["dropdownmenu_background_color"]!=""): ?>
	.tabs-box-navigation.sf-menu .tabs-box-navigation-selected
	{
		background-color: #<?php echo $theme_options["dropdownmenu_background_color"] ?>;
	}
	<?php endif; 
	if($theme_options["dropdownmenu_hover_background_color"]!=""): ?>
	.tabs-box-navigation.sf-menu .tabs-box-navigation-selected:hover
	{
		background-color: #<?php echo $theme_options["dropdownmenu_hover_background_color"] ?>;
	}
	<?php endif; 
	if($theme_options["dropdownmenu_border_color"]!=""): ?>
	.tabs-box-navigation.sf-menu li:hover ul, .tabs-box-navigation.sf-menu li.sfHover ul
	{
		border-color: #<?php echo $theme_options["dropdownmenu_border_color"] ?>;
	}
	<?php endif;
	if($theme_options["mobile_menu_link_color"]!=""): ?>
	.mobile-menu-container nav.mobile-menu>ul li a
	{
		color: #<?php echo $theme_options["mobile_menu_link_color"] ?>;
	}
	<?php endif;
	if($theme_options["mobile_menu_position_background_color"]!=""): ?>
	.mobile-menu-container nav.mobile-menu>ul li a
	{
		background-color: #<?php echo $theme_options["mobile_menu_position_background_color"] ?>;
	}
	<?php endif;
	if($theme_options["mobile_menu_active_link_color"]!=""): ?>
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-item>a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-parent a
	{
		color: #<?php echo $theme_options["mobile_menu_active_link_color"] ?>;
	}
	<?php endif;
	if($theme_options["mobile_menu_active_position_background_color"]!=""): ?>
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-item>a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-item a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent a,
	.mobile-menu-container nav.mobile-menu>ul li.current-menu-ancestor ul li.current-menu-parent ul li.current-menu-parent a
	{
		background-color: #<?php echo $theme_options["mobile_menu_active_position_background_color"] ?>;
		border-left-color: #<?php echo $theme_options["mobile_menu_active_position_background_color"] ?>;
		border-right-color: #<?php echo $theme_options["mobile_menu_active_position_background_color"] ?>;
	}
	<?php endif;
	if($theme_options["form_field_text_color"]!=""): ?>
	.comment-form input, .comment-form textarea,
	.contact-form input, .contact-form textarea,
	.post-password-form input,
	.search .search-input:focus
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce form .form-row input.input-text,
	.woocommerce form .form-row textarea,
	.woocommerce .comment-form input,
	.woocommerce #review_form_wrapper .comment-form-comment #comment,
	.woocommerce-cart table.cart td.actions .coupon .input-text,
	.woocommerce .widget_product_search form .search-field
	<?php
	endif;
	?>
	{
		color: #<?php echo $theme_options["form_field_text_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["form_field_border_color"]!=""): ?>
	.search .search-input, 
	.comment-form input, .comment-form textarea, 
	.contact-form input, .contact-form textarea,
	.post-password-form input
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce form .form-row input.input-text,
	.woocommerce form .form-row textarea,
	.woocommerce .comment-form input,
	.woocommerce #review_form_wrapper .comment-form-comment #comment,
	.woocommerce-cart table.cart td.actions .coupon .input-text,
	.woocommerce .widget_product_search form .search-field
	<?php
	endif;
	?>
	{
		<?php if($theme_options["form_field_border_color"]=="none"): ?>
		border: none;
		<?php else: ?>
		border: 1px solid #<?php echo $theme_options["form_field_border_color"] ?>;
		<?php endif; ?>
	}
	<?php if($theme_options["form_field_border_color"]!="none"): ?>
	.search .search-submit-container
	{
		top: 1px;
		<?php
		if(((is_rtl() || $theme_options["direction"]=='rtl') && ((isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]!="LTR") || !isset($_COOKIE["mc_direction"]))) || (isset($_COOKIE["mc_direction"]) && $_COOKIE["mc_direction"]=="RTL")):?>
		left: 1px;
		<?php else: ?>
		right: 1px;
		<?php endif; ?>
	}
	<?php endif;
	endif;
	if($theme_options["form_field_background_color"]!=""): ?>
	.comment-form input, .comment-form textarea,
	.contact-form input, .contact-form textarea,
	.post-password-form input,
	.search .search-input
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce form .form-row input.input-text,
	.woocommerce form .form-row textarea,
	.woocommerce .comment-form input,
	.woocommerce #review_form_wrapper .comment-form-comment #comment,
	.woocommerce-cart table.cart td.actions .coupon .input-text,
	.woocommerce .widget_product_search form .search-field
	<?php
	endif;
	?>
	{
		background-color: #<?php echo $theme_options["form_field_background_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["form_button_background_color"]!="" || $theme_options["form_button_text_color"]!=""): ?>
	.comment-form .mc-button, .contact-form .mc-button, .post-password-form .mc-button
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.altm,
	.woocommerce .widget_product_search form input[type='submit'],
	.woocommerce .widget_product_search form button,
	.woocommerce .cart .coupon input.button,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce div.product form.cart .button.single_add_to_cart_button,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce #payment #place_order,
	.woocommerce .cart input.button,
	.woocommerce .button.wc-forward,
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range	
	<?php
	endif;
	?>
	{
		<?php if($theme_options["form_button_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["form_button_background_color"]; ?>;
		border-color: #<?php echo $theme_options["form_button_background_color"]; ?>;
		<?php endif; ?>
		<?php if($theme_options["form_button_text_color"]!=""): ?>
		color: #<?php echo $theme_options["form_button_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["form_button_background_color"]!="" && is_plugin_active('woocommerce/woocommerce.php')):
	?>
	.woocommerce .widget_price_filter .ui-slider .ui-slider-handle
	{
		border: 2px solid #<?php echo $theme_options["form_button_background_color"]; ?>;	
	}
	<?php
	endif;
	
	if($theme_options["form_button_background_color"]!="" && is_plugin_active('woocommerce/woocommerce.php')):
	?>
	.woocommerce .woocommerce-error,
	.woocommerce .woocommerce-info,
	.woocommerce .woocommerce-message
	{
		border-left-color: #<?php echo $theme_options["form_button_background_color"]; ?>;	
	}
	.rtl .woocommerce .woocommerce-error,
	.rtl .woocommerce .woocommerce-info,
	.rtl .woocommerce .woocommerce-message
	{
		border-right-color: #<?php echo $theme_options["form_button_background_color"]; ?>;	
	}
	<?php
	endif;
	if($theme_options["form_button_background_color"]!="" && is_plugin_active('woocommerce/woocommerce.php')):
	?>
	.woocommerce a.remove
	{
		color: #<?php echo $theme_options["form_button_background_color"]; ?> !important;	
	}
	.woocommerce a.remove:hover
	{
		background-color: #<?php echo $theme_options["form_button_background_color"]; ?>;	
	}
	<?php
	endif;
	if($theme_options["form_button_hover_background_color"]!="" || $theme_options["form_button_hover_text_color"]!=""): ?>
	.comment-form .mc-button:hover, .contact-form .mc-button:hover, .post-password-form .mc-button:hover
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce #respond input#submit:hover,
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit.alt:hover,
	.woocommerce a.button.alt:hover,
	.woocommerce button.button.alt:hover,
	.woocommerce input.button.altm:hover,
	.woocommerce .widget_product_search form input[type='submit']:hover,
	.woocommerce .widget_product_search form button:hover,
	.woocommerce .cart .coupon input.button:hover,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover,
	.woocommerce div.product form.cart .button.single_add_to_cart_button:hover,
	.woocommerce #review_form #respond .form-submit input:hover,
	.woocommerce #payment #place_order:hover,
	.woocommerce .cart input.button:hover,
	.woocommerce .button.wc-forward:hover,
	.woocommerce .quantity .plus:hover,
	.woocommerce .quantity .minus:hover
	<?php
	endif;
	?>
	{
		<?php if($theme_options["form_button_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["form_button_hover_background_color"]; ?> !important;
		border-color: #<?php echo $theme_options["form_button_hover_background_color"]; ?> !important;
		<?php endif; ?>
		<?php if($theme_options["form_button_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["form_button_hover_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["date_box_color"]!="" || $theme_options["date_box_text_color"]!=""): ?>
	.comment-box .date .value
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce span.onsale,
	.cart_items_number
	<?php
	endif;
	?>
	{
		<?php if($theme_options["date_box_color"]!=""): ?>
		background-color: #<?php echo $theme_options["date_box_color"]; ?>;
		<?php endif;
		if($theme_options["date_box_text_color"]!=""): ?>
		color: #<?php echo $theme_options["date_box_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["date_box_color"]!=""): ?>
	.comment-box .date .arrow-date
	{
		border-color: #<?php echo $theme_options["date_box_color"]; ?> transparent;
	}
	<?php endif;
	if($theme_options["date_box_comments_number_color"]!="" || $theme_options["date_box_comments_number_text_color"]!=""): ?>
	.comment-box .comments-number a
	{
		<?php if($theme_options["date_box_comments_number_color"]!=""): ?>
		background-color: #<?php echo $theme_options["date_box_comments_number_color"]; ?>;
		<?php endif;
		if($theme_options["date_box_comments_number_text_color"]!=""): ?>
		color: #<?php echo $theme_options["date_box_comments_number_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["date_box_comments_number_color"]!=""): ?>
	.comment-box .arrow-comments
	{
		border-color: #<?php echo $theme_options["date_box_comments_number_color"]; ?> transparent;
	}
	<?php endif;
	if($theme_options["gallery_box_color"]!=""): ?>
	.gallery-box .description
	{
		background-color: #<?php echo $theme_options["gallery_box_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_text_first_line_color"]!=""): ?>
	.gallery-box h4
	{
		color: #<?php echo $theme_options["gallery_box_text_first_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_text_second_line_color"]!=""): ?>
	.gallery-box .description h5
	{
		color: #<?php echo $theme_options["gallery_box_text_second_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_hover_color"]!=""): ?>
	.gallery-box:hover .description
	{
		background-color: #<?php echo $theme_options["gallery_box_hover_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_hover_text_first_line_color"]!=""): ?>
	.gallery-box:hover h4
	{
		color: #<?php echo $theme_options["gallery_box_hover_text_first_line_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["gallery_box_hover_text_second_line_color"]!=""): ?>
	.gallery-box:hover .description h5
	{
		color: #<?php echo $theme_options["gallery_box_hover_text_second_line_color"]; ?>;
	}
	<?php endif;
	if($theme_options["gallery_box_border_color"]!=""): ?>
	.gallery-box .item-details
	{
		<?php if($theme_options["gallery_box_border_color"]=="none"): ?>
		border: none;
		padding-bottom: 25px;
		<?php else: ?>
		border-bottom: 1px solid #<?php echo $theme_options["gallery_box_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["gallery_box_hover_border_color"]!=""): ?>
	.gallery-box:hover .item-details
	{
		<?php if($theme_options["gallery_box_hover_border_color"]=="none"): ?>
		border: none;
		padding-bottom: 25px;
		<?php else: ?>
		border-bottom: 2px solid #<?php echo $theme_options["gallery_box_hover_border_color"] ?>;
		<?php endif; ?>
	}
	<?php endif; 
	if($theme_options["gallery_box_control_color"]!=""): ?>
	.gallery-box .controls a
	{
		background-color: #<?php echo $theme_options["gallery_box_control_color"]; ?>;
	}
	<?php endif;
	if($theme_options["gallery_box_control_hover_color"]!=""): ?>
	.gallery-box .controls a:hover
	{
		background-color: #<?php echo $theme_options["gallery_box_control_hover_color"]; ?>;
	}
	<?php endif;
	if($theme_options["timetable_box_color"]!="" || $theme_options["timetable_box_text_color"]!=""): ?>
	.timetable .event
	{
		<?php if($theme_options["timetable_box_color"]!=""): ?>
		background-color: #<?php echo $theme_options["timetable_box_color"]; ?>;
		<?php endif;
		if($theme_options["timetable_box_text_color"]!=""): ?>
		color: #<?php echo $theme_options["timetable_box_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php if($theme_options["timetable_box_text_color"]!=""): ?>
	.timetable .event a
	{
		color: #<?php echo $theme_options["timetable_box_text_color"]; ?>;
	}
	<?php endif;
	endif;
	if($theme_options["timetable_box_hover_color"]!="" || $theme_options["timetable_box_hover_text_color"]!=""): ?>
	.timetable .event.tooltip:hover,
	.timetable .event .event-container.tooltip:hover,
	.tooltip .tooltip-content
	{
		<?php if($theme_options["timetable_box_hover_color"]!=""): ?>
		background-color: #<?php echo $theme_options["timetable_box_hover_color"]; ?>;
		<?php endif;
		if($theme_options["timetable_box_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["timetable_box_hover_text_color"]; ?>;
		<?php endif; ?>
	}
	<?php if($theme_options["timetable_box_hover_text_color"]!=""): ?>
	.timetable .event.tooltip:hover a,
	.timetable .event .event-container.tooltip:hover a,
	.tooltip .tooltip-content a
	{
		color: #<?php echo $theme_options["timetable_box_hover_text_color"]; ?>;
	}
	<?php endif;
	if($theme_options["timetable_box_hover_color"]!=""): ?>
	.tooltip .tooltip-arrow
	{
		border-color: #<?php echo $theme_options["timetable_box_hover_color"]; ?> transparent;
	}
	<?php endif; 
	endif;
	if($theme_options["timetable_tip_box_color"]!=""): ?>
	.tip
	{
		background-color: #<?php echo $theme_options["timetable_tip_box_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["accordion_tab_color"]!=""): ?>
	.wpb_content_element .accordion .ui-accordion-header.ui-state-active,
	.accordion .ui-accordion-header.ui-state-active
	{
		background: #<?php echo $theme_options["accordion_tab_color"]; ?>;
		border-color: #<?php echo $theme_options["accordion_tab_color"]; ?>;
	}
	.accordion .ui-accordion-header.ui-state-hover h3
	{
		color: #<?php echo $theme_options["accordion_tab_color"]; ?>;
	}
	<?php endif; 
	if($theme_options["tabs_text_color"]!="" || $theme_options["tabs_border_color"]!=""): ?>
	.tabs-navigation li a
	{
		<?php if($theme_options["tabs_text_color"]!=""): ?>
		color: #<?php echo $theme_options["tabs_text_color"]; ?>;
		<?php endif;
		if($theme_options["tabs_border_color"]!=""): ?>
		border-color: #<?php echo $theme_options["tabs_border_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["tabs_hover_text_color"]!="" || $theme_options["tabs_border_hover_color"]!=""): ?>
	.tabs-navigation li a:hover,
	.tabs-navigation li a.selected,
	.tabs-navigation li.ui-tabs-active a
	{
		<?php if($theme_options["tabs_hover_text_color"]!=""): ?>
		color: #<?php echo $theme_options["tabs_hover_text_color"]; ?>;
		<?php endif;
		if($theme_options["tabs_border_hover_color"]!=""): ?>
		border-color: #<?php echo $theme_options["tabs_border_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["featured_icon_color"]!=""): ?>
	.hexagon span::before,
	.circle span::before
	{
		color: #<?php echo $theme_options["featured_icon_color"]; ?>;
	}
	<?php endif;
	if($theme_options["featured_icon_background_color"]!=""): ?>
	.hexagon,
	.mc-features-circle .circle span
	{
		background-color: #<?php echo $theme_options["featured_icon_background_color"]; ?>;
	}
	.hexagon::before,
	.hexagon.small::before
	{
		border-bottom-color: #<?php echo $theme_options["featured_icon_background_color"]; ?>;
	}
	.hexagon::after,
	.hexagon.small::after
	{
		border-top-color: #<?php echo $theme_options["featured_icon_background_color"]; ?>;
	}
	<?php endif;
	if($theme_options["light_featured_icon_color"]!=""): ?>
	.mc-features-style-light .hexagon span::before,
	.hexagon.style-light span:before,
	.mc-features-style-light .circle span::before,
	.icon-single.circle.style-light span::before
	{
		color: #<?php echo $theme_options["light_featured_icon_color"]; ?>;
	}
	<?php endif;
	if($theme_options["light_featured_icon_background_color"]!=""): ?>
	.mc-features-style-light .hexagon,
	.hexagon.style-light
	{
		background-color: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>;
	}
	.mc-features-style-light.light-colored .hexagon,
	.hexagon.style-light.light-colored
	{
		background-color: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>26;
	}
	.mc-features-style-light .hexagon::after,
	.mc-features-style-light .hexagon.small::after,
	.hexagon.style-light::after,
	.hexagon.small.style-light::after
	{
		border-top-color: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>;
	}
	.mc-features-style-light .hexagon::before,
	.mc-features-style-light .hexagon.small::before,
	.hexagon.style-light::before,
	.hexagon.small.style-light::before
	{
		border-bottom-color: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>;
	}
	.mc-features-style-light.light-colored .hexagon::after,
	.mc-features-style-light.light-colored .hexagon.small::after,
	.hexagon.style-light.light-colored::after,
	.hexagon.small.style-light.light-colored::after
	{
		border-top-color: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>26;
	}
	.mc-features-style-light.light-colored .hexagon::before,
	.mc-features-style-light.light-colored .hexagon.small::before,
	.hexagon.style-light.light-colored::before,
	.hexagon.small.style-light.light-colored::before
	{
		border-bottom-color: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>26;
	}
	.mc-features-style-light.light-colored .circle span
	{
		background: #<?php echo $theme_options["light_featured_icon_background_color"]; ?>26;
	}
	<?php endif;
	if($theme_options["simple_featured_icon_color"]!=""): ?>
	.mc-icon
	{
		color: #<?php echo $theme_options["simple_featured_icon_color"]; ?>;
	}
	<?php endif;
	if($theme_options["social_icon_color"]!="" || $theme_options["social_icon_background_color"]!=""): ?>
	.social-icons li a::before,
	.icon-single[class^="social-"]::before, .icon-single[class*=" social-"]::before
	{
		<?php if($theme_options["social_icon_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["social_icon_background_color"]; ?>;
		<?php endif;
		if($theme_options["social_icon_color"]!=""): ?>
		color: #<?php echo $theme_options["social_icon_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["social_icon_hover_color"]!="" || $theme_options["social_icon_hover_background_color"]!=""): ?>
	.social-icons li a:hover::before,
	.icon-single[class^="social-"]:hover::before, .icon-single[class*=" social-"]:hover::before
	{
		<?php if($theme_options["social_icon_hover_background_color"]!=""): ?>
		background-color: #<?php echo $theme_options["social_icon_hover_background_color"]; ?>;
		<?php endif;
		if($theme_options["social_icon_hover_color"]!=""): ?>
		color: #<?php echo $theme_options["social_icon_hover_color"]; ?>;
		<?php endif; ?>
	}
	<?php endif;
	if($theme_options["divider_background_color"]!=""): ?>
	.page-header > .vc_inner,
	.vc_separator.wpb_content_element.vc_sep_color_grey .vc_sep_line,
	.wpb_separator.wpb_content_element, .vc_text_separator.wpb_content_element
	{
		border-color: #<?php echo $theme_options["divider_background_color"]; ?>
	}
	<?php endif;
	if($theme_options["header_font"]!=""): $header_font_explode = explode(":", $theme_options["header_font"]); ?>
	h1, h2, h3, h4, h5,
	.header-left a, .logo,
	.top-info-list li .value,
	.footer-banner-box p,
	.rev_slider p,
	table td:first-child, table th:first-child
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce div.product .woocommerce-tabs ul.tabs li a,
	.woocommerce ul.products li.product .price,
	.woocommerce div.product p.price, 
	.woocommerce div.product span.price,
	.woocommerce .widget_top_rated_products .amount,
	.woocommerce table.shop_table th,
	.woocommerce-cart .cart-collaterals .cart_totals table th,
	.woocommerce ul.cart_list li a, .woocommerce ul.product_list_widget li a
	<?php endif; ?>
	{
		font-family: '<?php echo $header_font_explode[0]; ?>';
	}
	<?php endif;
	if($theme_options["content_font"]!=""): $content_font_explode = explode(":", $theme_options["content_font"]); ?>
	body,
	input, textarea,
	.sf-menu li a, .sf-menu li a:visited,
	.timeline-item label,
	.timeline-content span.timeline-subtitle,
	.ui-datepicker-title,
	.timetable th,
	.timetable tbody td,
	.gallery-box .description h5,
	.footer-banner-box h2,
	.footer-banner-box .more
	<?php
	if(is_plugin_active('woocommerce/woocommerce.php')):
	?>
	,
	.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
	.woocommerce .widget_price_filter .price_slider_amount .button,
	.woocommerce .widget_product_search form input[type='submit'],
	.woocommerce .widget_product_search form button,
	.woocommerce div.product form.cart .button.single_add_to_cart_button,
	.woocommerce #review_form #respond .form-submit input,
	.woocommerce #payment #place_order,
	.woocommerce .cart input.button,
	.woocommerce .button.wc-forward
	<?php endif; ?>
	{
		font-family: '<?php echo $content_font_explode[0]; ?>';
	}
	<?php endif;
	if($theme_options["blockquote_font"]!=""): $blockquote_font_explode = explode(":", $theme_options["blockquote_font"]); ?>
	blockquote,
	.sentence,
	.style-light .gallery-box h5
	{
		font-family: '<?php echo $blockquote_font_explode[0]; ?>';
	}
	<?php endif; ?>
</style>