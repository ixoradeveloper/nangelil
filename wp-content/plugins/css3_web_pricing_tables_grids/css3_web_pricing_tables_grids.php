<?php
/*
Plugin Name: CSS3 Compare Pricing Tables
Plugin URI: https://1.envato.market/css3-responsive-wordpress-compare-pricing-tables
Description: CSS3 Compare Pricing Tables plugin.
Author: QuanticaLabs
Author URI: https://1.envato.market/quanticalabs-portfolio-codecanyon
Version: 11.5
*/


//translation
function css3_grid_load_textdomain()
{
	load_plugin_textdomain("css3_grid", false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'css3_grid_load_textdomain');

//settings link
function css3_grid_settings_link($links) 
{
	$settings_link = '<a href="options-general.php?page=css3_grid_admin" title="' . __('Settings', 'css3_grid') . '">' . __('Settings', 'css3_grid') . '</a>';
	array_unshift($links, $settings_link); 
	return $links;
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'css3_grid_settings_link' );

//admin
if(is_admin())
{
	/**
	 * Converts form field 'css3_grid_data' with serialized all variables into normal $_POST array
	 * We are doing this to workaround the max_input_vars limit
	 */
	function css3_grid_admin_convert_post_data()
	{
		if($_SERVER["REQUEST_METHOD"]==="POST" && !empty($_POST["css3_grid_data"]))
		{
			$vars = explode("&", $_POST["css3_grid_data"]);
			$data = array();
			foreach($vars as $var)
			{
				parse_str($var, $variable);
				assign_var($_POST, $variable);
			}
		}
	}
	add_action('admin_init', 'css3_grid_admin_convert_post_data', 1);
	
	function css3_grid_admin_init()
	{
		wp_register_script('css3_grid_admin', plugins_url('js/css3_grid_admin.js', __FILE__), array(), "1.0");
		wp_register_script('jquery-carouFredSel', plugins_url('js/jquery.carouFredSel-6.2.1-packed.js', __FILE__));
		wp_register_script('jquery-easing', plugins_url('js/jquery.easing.1.4.1.js', __FILE__));
		wp_register_script('jquery-touchSwipe', plugins_url('js/jquery.touchSwipe.min.js', __FILE__));
		wp_register_style('css3_grid_font_yanone', '//fonts.googleapis.com/css?family=Yanone+Kaffeesatz');
		wp_register_style('css3_grid_style_admin', plugins_url('admin/style.css', __FILE__));
		wp_register_style('css3_grid_table1_style', plugins_url('table1/css3_grid_style.css', __FILE__));
		wp_register_style('css3_grid_table2_style', plugins_url('table2/css3_grid_style.css', __FILE__));
		wp_register_style('css3_grid_responsive', plugins_url('responsive.css', __FILE__));
	}
	add_action('admin_init', 'css3_grid_admin_init');

	function css3_grid_admin_print_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('css3_grid_admin');
		wp_enqueue_script('jquery-carouFredSel');
		wp_enqueue_script('jquery-easing');
		wp_enqueue_script('jquery-touchSwipe');
		//pass data to javascript
		$data = array(
			'imgUrl' =>  plugins_url('img/', __FILE__),
			'siteUrl' => get_site_url(),
			'selectedShortcodeId' => (isset($_POST["action"]) && $_POST["action"]=="save_css3_grid" ? $_POST["shortcodeId"] : ""),
			'translation' => array(
				'screenWidth' => __('Screen width', 'css3_grid'),
				'responsiveButtonWidth' =>  __('Responsive button width', 'css3_grid'),
				'responsiveFontSize' =>  __('Responsive font size', 'css3_grid'),
				'inPx' => __('(in px)', 'css3_grid'),
				'responsiveWidth' => __('responsive width', 'css3_grid'),
				'responsiveHeight' => __('responsive height', 'css3_grid'),
				'optional' => __('(optional)', 'css3_grid'),				
				'chooseShortcode' => __('choose shortcode...', 'css3_grid'),
				'buttonStyle' => __('button style', 'css3_grid'),
				'price' => __('price', 'css3_grid'),
				'Price' => __('Price', 'css3_grid'),
				'headerTitle' => __('header title', 'css3_grid'),
				'caption' => __('caption', 'css3_grid'),
				'button' => __('button', 'css3_grid'),
				'buttonOrange' => __('button orange', 'css3_grid'),
				'buttonYellow' => __('button yellow', 'css3_grid'),
				'buttonLightgreen' => __('button lightgreen', 'css3_grid'),
				'buttonGreen' => __('button green', 'css3_grid'),
				'table' => __('Table', 'css3_grid'),
				'yesIcons' => __('Yes icons', 'css3_grid'),
				'noIcons' => __('No icons', 'css3_grid'),
				'noIconsOld' => __('No icons(old)', 'css3_grid'),
				'yesIconsOld' => __('Yes icons(old)', 'css3_grid'),
				'tooltip' => __('tooltip: ', 'css3_grid'),
				'rowsConfiguration' => __('Rows configuration', 'css3_grid'),
				'heightOptionalInPx' => __('height (optional in px)', 'css3_grid'),
				'paddingTopOptionalInPx' => __('padding top (optional in px)', 'css3_grid'),
				'paddingBottomOptionalInPx' => __('padding bottom (optional in px)', 'css3_grid'),
				'responsiveWidth' => __('responsive width', 'css3_grid'),
				'column' => __('Column', 'css3_grid'),
				'widthOptional' => __('width (optional):', 'css3_grid'),
				'aligmentOptional' => __('aligment (optional):', 'css3_grid'),
				'choose' => __('choose...', 'css3_grid'),
				'left' => __('left', 'css3_grid'),
				'center' => __('center', 'css3_grid'),
				'right' => __('right', 'css3_grid'),
				'activeOptional' => __('active (optional):', 'css3_grid'),
				'yes' => __('yes', 'css3_grid'),
				'no' => __('no', 'css3_grid'),
				'disableHiddenOptional' => __('disable/hidden (optional):', 'css3_grid'),
				'ribbonOptional' => __('ribbon (optional):', 'css3_grid'),
				'trial' => __('trial', 'css3_grid'),
				'topUppercase' => __('top (uppercase)', 'css3_grid'),
				'top' => __('top', 'css3_grid'),
				'saveUppercase' => __('save (uppercase)', 'css3_grid'),
				'save' => __('save', 'css3_grid'),
				'sale' => __('sale', 'css3_grid'),
				'pro' => __('pro', 'css3_grid'),
				'pack' => __('pack', 'css3_grid'),
				'off5' => __('5% off', 'css3_grid'),
				'off10' => __('10% off', 'css3_grid'),
				'off15' => __('15% off', 'css3_grid'),
				'off20' => __('20% off', 'css3_grid'),
				'off25' => __('25% off', 'css3_grid'),
				'off30' => __('30% off', 'css3_grid'),
				'off35' => __('35% off', 'css3_grid'),
				'off40' => __('40% off', 'css3_grid'),
				'off50' => __('50% off', 'css3_grid'),
				'off75' => __('75% off', 'css3_grid'),
				'no1' => __('no. 1', 'css3_grid'),
				'newUppercase' => __('new (uppercase)', 'css3_grid'),
				'new' => __('new', 'css3_grid'),
				'hotUppercase' => __('hot (uppercase)', 'css3_grid'),
				'hot' => __('hot', 'css3_grid'),
				'heart' => __('heart', 'css3_grid'),
				'giftUppercase' => __('gift (uppercase)', 'css3_grid'),
				'fresh' => __('fresh', 'css3_grid'),
				'freeUppercase' => __('free (uppercase)', 'css3_grid'),
				'free' => __('free', 'css3_grid'),
				'buy' => __('buy', 'css3_grid'),
				'best' => __('best', 'css3_grid'),
				'Style' => __('Style', 'css3_grid'),
				'style' => __('style', 'css3_grid'),
				'trial' => __('trial', 'css3_grid'),
				'up' => __('up', 'css3_grid'),
				'down' => __('down', 'css3_grid'),
				'old' => __('(old)', 'css3_grid'),
				'Cycle' => __('Cycle', 'css3_grid'),
				'Title' => __('Title', 'css3_grid'),
				'uniqueID' => __('Unique ID', 'css3_grid'),
				'PriceSubtitle' => __('Price Subtitle', 'css3_grid'),
				'ButtonURL' => __('Button URL', 'css3_grid'),
			),
		);
		wp_localize_script('css3_grid_admin', 'css3_config', $data);
		wp_enqueue_style('css3_grid_font_yanone');
		wp_enqueue_style('css3_grid_style_admin');
		wp_enqueue_style('css3_grid_table1_style');
		wp_enqueue_style('css3_grid_table2_style');
		wp_enqueue_style('css3_grid_responsive');
	}
	
	function css3_grid_admin_menu()
	{	
		$page = add_options_page(__('CSS3 Compare Pricing Tables', 'css3_grid'), __('CSS3 Compare Pricing Tables', 'css3_grid'), 'manage_options', 'css3_grid_admin', 'css3_grid_admin_page');
		add_action('admin_print_scripts-' . $page, 'css3_grid_admin_print_scripts');
	}
	add_action('admin_menu', 'css3_grid_admin_menu');
	
	function css3_grid_stripslashes_deep($value)
	{
		$value = is_array($value) ?
					array_map('stripslashes_deep', $value) :
					stripslashes($value);

		return $value;
	}
	function css3_grid_ajax_get_settings()
	{
		echo "css3_start" . json_encode(css3_grid_stripslashes_deep(get_option('css3_grid_shortcode_settings_' . $_POST["id"]))) . "css3_end";
		exit();
	}
	add_action('wp_ajax_css3_grid_get_settings', 'css3_grid_ajax_get_settings');
	
	function css3_grid_ajax_delete()
	{
		echo "css3_start" . delete_option($_POST["id"]) . "css3_end";
		exit();
	}
	add_action('wp_ajax_css3_grid_delete', 'css3_grid_ajax_delete');
	
	function css3_grid_ajax_sanitize_title()
	{
		echo urldecode(sanitize_title($_POST["val"]));
		exit();
	}
	add_action('wp_ajax_css3_sanitize_title', 'css3_grid_ajax_sanitize_title');
	
	function css3_grid_ajax_get_font_subsets()
	{
		if($_POST["font"]!="")
		{
			$subsets = '';
			$fontExplode = explode(":", $_POST["font"]);
			//get google fonts
			$fontsArray = get_option("css3_grid_google_fonts");
			//update if option doesn't exist or it was modified more than 2 weeks ago
			if($fontsArray===FALSE || (time()-$fontsArray->last_update>2*7*24*60*60)) 
			{
				$google_api_url = 'https://quanticalabs.com/.tools/GoogleFont/font.txt';
				$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
				$fontsArray = json_decode($fontsJson);
				$fontsArray->last_update = time();		
				update_option("css3_grid_google_fonts", $fontsArray);
			}
			$fontsCount = count($fontsArray->items);
			for($i=0; $i<$fontsCount; $i++)
			{
				if($fontsArray->items[$i]->family==$fontExplode[0])
				{
					for($j=0, $max=count($fontsArray->items[$i]->subsets); $j<$max; $j++)
					{
						$subsets .= '<option value="' . $fontsArray->items[$i]->subsets[$j] . '">' . $fontsArray->items[$i]->subsets[$j] . '</option>';
					}
					break;
				}
			}
			echo "css3_start" . $subsets . "css3_end";
		}
		exit();
	}
	add_action('wp_ajax_css3_grid_get_font_subsets', 'css3_grid_ajax_get_font_subsets');
	
	function css3_grid_ajax_preview()
	{
		$responsiveStepWidth = (isset($_POST["responsiveStepWidth"]) ? implode("|", $_POST["responsiveStepWidth"]) : "");

		$responsiveButtonWidth = (isset($_POST["responsiveButtonWidth"]) ? implode("|", $_POST["responsiveButtonWidth"]) : "");

		$responsiveHeaderFontSize = (isset($_POST["responsiveHeaderFontSize"]) ? implode("|", $_POST["responsiveHeaderFontSize"]) : "");

		$responsivePriceFontSize = (isset($_POST["responsivePriceFontSize"]) ? implode("|", $_POST["responsivePriceFontSize"]) : "");
		$responsivePriceFontSize = "";

		$responsivePermonthFontSize = (isset($_POST["responsivePermonthFontSize"]) ? implode("|", $_POST["responsivePermonthFontSize"]) : "");

		$responsiveContentFontSize = (isset($_POST["responsiveContentFontSize"]) ? implode("|", $_POST["responsiveContentFontSize"]) : "");

		$responsiveButtonsFontSize = (isset($_POST["responsiveButtonsFontSize"]) ? implode("|", $_POST["responsiveButtonsFontSize"]) : "");

		$widths = implode("|", $_POST["widths"]);

		$responsiveWidths = (isset($_POST["responsiveWidths"]) ? implode("|", $_POST["responsiveWidths"]) : "");

		$aligments = implode("|", $_POST["aligments"]);

		$actives = implode("|", $_POST["actives"]);

		$hiddens = implode("|", $_POST["hiddens"]);

		$ribbons = implode("|", $_POST["ribbons"]);

		$heights = implode("|", $_POST["heights"]);

		$responsiveHeights = (isset($_POST["responsiveHeights"]) ? implode("|", $_POST["responsiveHeights"]) : "");

		$paddingsTop = implode("|", $_POST["paddingsTop"]);

		$paddingsBottom = implode("|", $_POST["paddingsBottom"]);

		$texts = str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["texts"]))));

		$tooltips = str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["tooltips"]))));

		$headerFontSubsets = (isset($_POST["headerFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["headerFontSubset"])))) : "");

		$priceFontSubsets = (isset($_POST["priceFontSubset"])) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["priceFontSubset"])))) : "";

		$permonthFontSubsets = (isset($_POST["permonthFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["permonthFontSubset"])))) : "");

		$contentFontSubsets = (isset($_POST["contentFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["contentFontSubset"])))) : "");

		$buttonsFontSubsets = (isset($_POST["buttonsFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["buttonsFontSubset"])))) : "");

		$dropdownAlignment = (!empty($_POST["dropdownAlignment"]) ? $_POST["dropdownAlignment"] : "");
		
		$cyclesTitles = (isset($_POST["pricingCycleTitle"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $_POST["pricingCycleTitle"])))) : "");

		$cyclesIDs = (isset($_POST["pricingCycleID"]) ? implode("|", $_POST["pricingCycleID"]) : "");

		$cyclesPrices = (isset($_POST["pricingCyclePriceColumn"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", "{" . implode("}{", array_map("css3_grid_implode_entry", $_POST["pricingCyclePriceColumn"])) . "}"))) : "");

		$cyclesButtonURLs = (isset($_POST["pricingCycleButtonURLColumn"]) ? "{" . implode("}{", array_map("css3_grid_implode_entry", $_POST["pricingCycleButtonURLColumn"])). "}" : "");
		
		echo "css3_start" . do_shortcode("[css3_grid_print id='" . $_POST["shortcodeId"] . "' kind='" . (int)$_POST["kind"] . "' style='" . (int)$_POST["styleForTable" . (int)$_POST["kind"]] . "' hoverType='" . $_POST["hoverTypeForTable" . (int)$_POST["kind"]] . "' css3CustomCss='" . $_POST["css3CustomCss"] . "' responsive='" . $_POST["responsive"] . "' responsiveHideCaptionColumn='" . (int)$_POST["responsiveHideCaptionColumn"] . "' responsiveSteps='" . (int)$_POST["responsiveSteps"] . "' responsiveStepWidth='" . $responsiveStepWidth . "' responsiveButtonWidth='" . $responsiveButtonWidth . "' responsiveHeaderFontSize='" . $responsiveHeaderFontSize . "' responsivePriceFontSize='" . $responsivePriceFontSize . "' responsivePermonthFontSize='" . $responsivePermonthFontSize . "' responsiveContentFontSize='" . $responsiveContentFontSize . "' responsiveButtonsFontSize='" . $responsiveButtonsFontSize . "' priceFontCustom='" . $_POST["priceFontCustom"] . "' priceFont='" . $_POST["priceFont"] . "' priceFontSubsets='" . $priceFontSubsets . "' priceFontSize='" . $_POST["priceFontSize"] . "' headerFontCustom='" . $_POST["headerFontCustom"] . "' headerFont='" . $_POST["headerFont"] . "' headerFontSubsets='" . $headerFontSubsets . "' headerFontSize='" . $_POST["headerFontSize"] . "' permonthFontCustom='" . $_POST["permonthFontCustom"] . "' permonthFont='" . $_POST["permonthFont"] . "' permonthFontSubsets='" . $permonthFontSubsets . "' permonthFontSize='" . $_POST["permonthFontSize"] . "' contentFontCustom='" . $_POST["contentFontCustom"] . "' contentFont='" . $_POST["contentFont"] . "' contentFontSubsets='" . $contentFontSubsets . "' contentFontSize='" . $_POST["contentFontSize"] . "' buttonsFontCustom='" . $_POST["buttonsFontCustom"] . "' buttonsFont='" . $_POST["buttonsFont"] . "' buttonsFontSubsets='" . $buttonsFontSubsets . "' buttonsFontSize='" . $_POST["buttonsFontSize"] . "' slidingColumns='" . $_POST["slidingColumns"] . "' visibleColumns='" . (int)$_POST["visibleColumns"] . "' scrollColumns='" . (int)$_POST["scrollColumns"] . "' slidingNavigation='" . (int)$_POST["slidingNavigation"] . "' slidingNavigationArrows='" . (int)$_POST["slidingNavigationArrows"] . "' slidingArrowsStyle='" . $_POST["slidingArrowsStyle"] . "' slidingPagination='" . (int)$_POST["slidingPagination"] . "' slidingPaginationPosition='" . $_POST["slidingPaginationPosition"] . "' slidingPaginationStyle='" . $_POST["slidingPaginationStyle"] . "' slidingCircular='" . (int)$_POST["slidingCircular"] . "' slidingInfinite='" . (int)$_POST["slidingInfinite"] . "' slidingOnTouch='" . (int)$_POST["slidingOnTouch"] . "' slidingOnMouse='" . (int)$_POST["slidingOnMouse"] . "' slidingThreshold='" . (int)$_POST["slidingThreshold"] . "' slidingAutoplay='" . (int)$_POST["slidingAutoplay"] . "' slidingEffect='" . $_POST["slidingEffect"] . "' slidingEasing='" . $_POST["slidingEasing"] . "' slidingDuration='" . (int)$_POST["slidingDuration"] . "' columns='" . (int)$_POST["columns"] . "' rows='" . (int)$_POST["rows"] . "' hiddenRows='" . (int)$_POST["hiddenRows"] . "' hiddenRowsButtonExpandText='" . $_POST["hiddenRowsButtonExpandText"] . "' hiddenRowsButtonCollapseText='" . $_POST["hiddenRowsButtonCollapseText"] . "' texts='" . $texts . "' tooltips='" . $tooltips . "' widths='" . $widths . "' responsivewidths='" . $responsiveWidths . "' aligments='" . $aligments . "' actives='" . $actives . "' hiddens='" . $hiddens . "' ribbons='" . $ribbons . "' heights='" . $heights . "' responsiveheights='" . $responsiveHeights . "' paddingstop='" . $paddingsTop . "' paddingsbottom='" . $paddingsBottom . "' dropdownAlignment='" . $dropdownAlignment . "' pricingCycles='" . $_POST["pricingCycles"] . "' pricingCyclesSteps='" . $_POST["pricingCyclesSteps"] . "' pricingCyclesTitles='".$cyclesTitles."' pricingCyclesIDs='".$cyclesIDs."' pricingCyclesPrices='".$cyclesPrices."' pricingCyclesButtonURLs='".$cyclesButtonURLs."']") . "css3_end";
		exit();
	}
	add_action('wp_ajax_css3_grid_preview', 'css3_grid_ajax_preview');
	
	function css3_grid_admin_page()
	{
		$error = "";
		$message = "";

		if(isset($_POST["action"]) && $_POST["action"]=="save_css3_grid")
		{
			if($_POST["shortcodeId"]!="")
			{
				$css3_grid_options = array(
					'columns' => $_POST['columns'],
					'rows' => $_POST['rows'],
					'hiddenRows' => $_POST['hiddenRows'],
					'hiddenRowsButtonExpandText' => $_POST["hiddenRowsButtonExpandText"],
					'hiddenRowsButtonCollapseText' => $_POST["hiddenRowsButtonCollapseText"],
					'css3CustomCss' => $_POST["css3CustomCss"],
					'kind' => $_POST['kind'],
					'styleForTable1' => $_POST["styleForTable1"],
					'styleForTable2' => $_POST["styleForTable2"],
					'hoverTypeForTable1' => $_POST["hoverTypeForTable1"],
					'hoverTypeForTable2' => $_POST["hoverTypeForTable2"],
					'responsive' => $_POST['responsive'],
					'responsiveHideCaptionColumn' => $_POST['responsiveHideCaptionColumn'],
					'responsiveSteps' => $_POST['responsiveSteps'],
					'responsiveStepWidth' => $_POST['responsiveStepWidth'],
					'responsiveButtonWidth' => $_POST['responsiveButtonWidth'],
					'responsiveHeaderFontSize' => $_POST['responsiveHeaderFontSize'],
					'responsivePriceFontSize' => $_POST['responsivePriceFontSize'],
					'responsivePermonthFontSize' => $_POST['responsivePermonthFontSize'],
					'responsiveContentFontSize' => $_POST['responsiveContentFontSize'],
					'responsiveButtonsFontSize' => $_POST['responsiveButtonsFontSize'],
					'priceFontCustom' => $_POST['priceFontCustom'],
					'priceFont' => $_POST['priceFont'],
					'priceFontSubset' => (isset($_POST['priceFontSubset']) ? $_POST['priceFontSubset'] : ''),
					'priceFontSize' => $_POST['priceFontSize'],
					'headerFontCustom' => $_POST['headerFontCustom'],
					'headerFont' => $_POST['headerFont'],
					'headerFontSubset' => (isset($_POST['headerFontSubset']) ? $_POST['headerFontSubset'] : ''),
					'headerFontSize' => $_POST['headerFontSize'],
					'permonthFontCustom' => $_POST['permonthFontCustom'],
					'permonthFont' => $_POST['permonthFont'],
					'permonthFontSubset' => (isset($_POST['permonthFontSubset']) ? $_POST['permonthFontSubset'] : ''),
					'permonthFontSize' => $_POST['permonthFontSize'],
					'contentFontCustom' => $_POST['contentFontCustom'],
					'contentFont' => $_POST['contentFont'],
					'contentFontSubset' => (isset($_POST['contentFontSubset']) ? $_POST['contentFontSubset'] : ''),
					'contentFontSize' => $_POST['contentFontSize'],
					'buttonsFontCustom' => $_POST['buttonsFontCustom'],
					'buttonsFont' => $_POST['buttonsFont'],
					'buttonsFontSubset' => (isset($_POST['buttonsFontSubset']) ? $_POST['buttonsFontSubset'] : ''),
					'buttonsFontSize' => $_POST['buttonsFontSize'],
					'slidingColumns' => $_POST['slidingColumns'],
					'visibleColumns' => $_POST['visibleColumns'],
					'scrollColumns' => $_POST['scrollColumns'],
					'slidingNavigation' => $_POST['slidingNavigation'],
					'slidingNavigationArrows' => $_POST['slidingNavigationArrows'],
					'slidingArrowsStyle' => $_POST['slidingArrowsStyle'],
					'slidingPagination' => $_POST['slidingPagination'],
					'slidingPaginationPosition' => $_POST['slidingPaginationPosition'],
					'slidingPaginationStyle' => $_POST['slidingPaginationStyle'],
					'slidingCircular' => $_POST['slidingCircular'],
					'slidingInfinite' => $_POST['slidingInfinite'],
					'slidingOnTouch' => $_POST['slidingOnTouch'],
					'slidingOnMouse' => $_POST['slidingOnMouse'],
					'slidingThreshold' => $_POST['slidingThreshold'],
					'slidingAutoplay' => $_POST['slidingAutoplay'],
					'slidingEffect' => $_POST['slidingEffect'],
					'slidingEasing' => $_POST['slidingEasing'],
					'slidingDuration' => $_POST['slidingDuration'],
					'widths' => $_POST['widths'],
					'responsiveWidths' => $_POST['responsiveWidths'],
					'aligments' => $_POST['aligments'],
					'actives' => $_POST['actives'],
					'hiddens' => $_POST['hiddens'],
					'ribbons' => $_POST['ribbons'],
					'heights' => $_POST['heights'],
					'responsiveHeights' => $_POST['responsiveHeights'],
					'paddingsTop' => $_POST['paddingsTop'],
					'paddingsBottom' => $_POST['paddingsBottom'],
					'texts' => $_POST['texts'],
					'tooltips' => $_POST['tooltips'],
					'pricingCycles' => $_POST['pricingCycles'],
					'dropdownAlignment' => $_POST['dropdownAlignment'],
					'pricingCyclesSteps' => $_POST['pricingCyclesSteps'],
					'pricingCycleTitle' => $_POST['pricingCycleTitle'],
					'pricingCycleID' => $_POST['pricingCycleID'],
					'pricingCyclePriceColumn' => $_POST['pricingCyclePriceColumn'],
					'pricingCycleButtonURLColumn' => $_POST['pricingCycleButtonURLColumn'],
				);
				//add if not exist or update if exist
				$updated = true;
				if(!get_option('css3_grid_shortcode_settings_' . $_POST["shortcodeId"]))
					$updated = false;
				/*echo "<pre style='white-space: normal;'>";
				var_export($css3_grid_options);
				echo "</pre>";*/
				update_option('css3_grid_shortcode_settings_' . $_POST["shortcodeId"], $css3_grid_options);
				$message .= __("Settings saved!", "css3_grid") . ($updated ? __(" (overwritten)", "css3_grid") : "");
				$message .= "<br />" . __("Please use", "css3_grid") . "<br />[css3_grid id='" . $_POST["shortcodeId"] . "']<br />" . __("shortcode to put css3 grid table on your page.", "css3_grid") . "";
			}
			else
			{
				$error .= __("Please fill 'Shortcode id' field!", "css3_grid");
			}
		}
		else if(isset($_POST["action"]) && $_POST["action"]=="import_from_file")
		{
			$importedOptions = json_decode(file_get_contents($_FILES['import_from_file_input']['tmp_name']),true);
			$importedOptionsCount = count($importedOptions);
			$importedIds = "";
			for($i=0; $i<$importedOptionsCount; $i++)
			{
				$name = $importedOptions[$i]["name"];
				unset($importedOptions[$i]["name"]);
				$importedIds .= "<br />" . substr($name, 29);
				update_option($name, $importedOptions[$i]);
			}
			if($importedIds!="")
				$message .= sprintf(__("Import completed successfully! Imported pricing tables: %s", "css3_grid"), $importedIds);
			else
				$error .= __("No data for import found!", "css3_grid");
		}
		else if(isset($_POST["action"]) && $_POST["action"]=="restore_default_tables")
		{
			//delete current tables
			$pricingTables = array(
				"css3_grid_shortcode_settings_Table_t1_s1",
				"css3_grid_shortcode_settings_Table_t1_s2",
				"css3_grid_shortcode_settings_Table_t1_s3",
				"css3_grid_shortcode_settings_Table_t1_s4",
				"css3_grid_shortcode_settings_Table_t1_s5",
				"css3_grid_shortcode_settings_Table_t1_s6",
				"css3_grid_shortcode_settings_Table_t1_s7",
				"css3_grid_shortcode_settings_Table_t1_s8",
				"css3_grid_shortcode_settings_Table_t1_s9",
				"css3_grid_shortcode_settings_Table_t1_s10",
				"css3_grid_shortcode_settings_Table_t1_s11",
				"css3_grid_shortcode_settings_Table_t1_s12",
				"css3_grid_shortcode_settings_Table_t2_s1",
				"css3_grid_shortcode_settings_Table_t2_s2",
				"css3_grid_shortcode_settings_Table_t2_s3",
				"css3_grid_shortcode_settings_Table_t2_s4",
				"css3_grid_shortcode_settings_Table_t2_s5",
				"css3_grid_shortcode_settings_Table_t2_s6",
				"css3_grid_shortcode_settings_Table_t2_s7",
				"css3_grid_shortcode_settings_Table_t2_s8",
				"css3_grid_shortcode_settings_medicenter_blue",
				"css3_grid_shortcode_settings_medicenter_blue_sliding",
				"css3_grid_shortcode_settings_medicenter_green",
				"css3_grid_shortcode_settings_medicenter_green_sliding",
				"css3_grid_shortcode_settings_medicenter_orange",
				"css3_grid_shortcode_settings_medicenter_orange_sliding",
				"css3_grid_shortcode_settings_medicenter_red",
				"css3_grid_shortcode_settings_medicenter_red_sliding",
				"css3_grid_shortcode_settings_medicenter_turquoise",
				"css3_grid_shortcode_settings_medicenter_turquoise_sliding",
				"css3_grid_shortcode_settings_medicenter_violet",
				"css3_grid_shortcode_settings_medicenter_violet_sliding",
			);
			foreach($pricingTables as $pricingTable)
				delete_option($pricingTable);
			
			//create default tables
			css3_grid_activate();
			
			$message = __("Default pricing tables restored successfully!", "css3_grid");
		}
		$css3GridAllShortcodeIds = array();
		/*if(function_exists('is_multisite') && is_multisite()) 
		{
			global $blog_id;
			global $wpdb;
			$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
			$query = "SELECT meta_key, meta_value FROM {$wpdb->sitemeta} WHERE site_id='" . $blog_id . "' AND meta_key LIKE '%css3_grid_shortcode_settings%'";
			$allOptions = $wpdb->get_results($query, ARRAY_A);
			foreach($allOptions as $key => $value)
			{
				if(substr($value["meta_key"], 0, 28)=="css3_grid_shortcode_settings")
					$css3GridAllShortcodeIds[] = $value["meta_key"];
			}
		}
		else
		{*/
			//get pricing tables list
			global $wpdb;
			$query = "SELECT option_name FROM {$wpdb->options}
					WHERE 
					option_name LIKE 'css3_grid_shortcode_settings%'
					ORDER BY option_name";
			$pricing_tables_list = $wpdb->get_results($query);
			$css3GridAllShortcodeIds = array();
			foreach($pricing_tables_list as $pricing_table)
				$css3GridAllShortcodeIds[] = $pricing_table->option_name;
			/*$allOptions = get_alloptions();
			foreach($allOptions as $key => $value)
			{
				if(substr($key, 0, 28)=="css3_grid_shortcode_settings")
					$css3GridAllShortcodeIds[] = $key;
			}*/
		//}
		//sort shortcode ids
		sort($css3GridAllShortcodeIds);
		?>
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br></div>
			<h2><?php _e("CSS3 Compare Pricing Tables settings", "css3_grid"); ?></h2>
		</div>
		<?php
		if($error!="" || $message!="")
		{
		?>
		<div class="<?php echo ($message!="" ? "updated" : "error"); ?> settings-error"> 
			<p style="line-height: 150%;font-weight: bold;">
				<?php echo ($message!="" ? $message : $error); ?>
			</p>
		</div>
		<?php
		}
		$shortcodesSelect = "<br />
			<select name='inset'>
				<option value='-1'>" . __('choose shortcode...', 'css3_grid') . "</option>
				<optgroup label='" . __('Table', 'css3_grid') . " 1'>
					<option value='caption'>" . __('caption', 'css3_grid') . "</option>
					<option value='header_title'>" . __('header title', 'css3_grid') . "</option>
					<option value='price'>" . __('price', 'css3_grid') . "</option>
					<option value='button'>" . __('button', 'css3_grid') . "</option>
					<option value='button_orange'>" . __('button orange', 'css3_grid') . "</option>
					<option value='button_yellow'>" . __('button yellow', 'css3_grid') . "</option>
					<option value='button_lightgreen'>" . __('button lightgreen', 'css3_grid') . "</option>
					<option value='button_green'>" . __('button green', 'css3_grid') . "</option>
				</optgroup>
				<optgroup label='" . __('Table', 'css3_grid') . " 2'>
					<option value='caption2'>" . __('caption', 'css3_grid') . "</option>
					<option value='header_title2'>" . __('header title', 'css3_grid') . "</option>
					<option value='price2'>" . __('price', 'css3_grid') . "</option>
					<option value='button1'>" . __('button style', 'css3_grid') . " 1</option>
					<option value='button2'>" . __('button style', 'css3_grid') . " 2</option>
					<option value='button3'>" . __('button style', 'css3_grid') . " 3</option>
					<option value='button4'>" . __('button style', 'css3_grid') . " 4</option>
				</optgroup>
				<optgroup label='" . __('Yes icons', 'css3_grid') . "'>";
		for($i=0; $i<10; $i++)
			$shortcodesSelect .= "<option value='yes_" . ($i<9 ? "0" : "") . ($i+1) . "'>" . __('style', 'css3_grid') . " " . ($i+1) . "</option>";
		for($i=0; $i<21; $i++)
			$shortcodesSelect .= "<option value='tick_" . ($i<9 ? "0" : "") . ($i+1) . "'>" . __('style', 'css3_grid') . " " . ($i+1) . " " . __('(old)', 'css3_grid') . "</option>";
		$shortcodesSelect .= "</optgroup>
				<optgroup label='" . __('No icons', 'css3_grid') . "'>";
		for($i=0; $i<10; $i++)
			$shortcodesSelect .= "<option value='no_" . ($i<9 ? "0" : "") . ($i+1) . "'>" . __('style', 'css3_grid') . " " . ($i+1) . "</option>";
		for($i=0; $i<21; $i++)
			$shortcodesSelect .= "<option value='cross_" . ($i<9 ? "0" : "") . ($i+1) . "'>" . __('style', 'css3_grid') . " " . ($i+1) . " " . __('(old)', 'css3_grid') . "</option>";
		$shortcodesSelect .= "</optgroup>
			</select>
			<span class='css3_grid_tooltip css3_grid_admin_info'>
				<span>
					<div class='css3_grid_tooltip_column'>
						<strong>" . __('Yes icons', 'css3_grid') . "</strong>";
						for($i=0; $i<10; $i++)
							$shortcodesSelect .= "<div class='p_table_1'><span class='css3_grid_icon icon_yes_" . ($i<9 ? "0" : "") . ($i+1) . "'></span></div><label>&nbsp;" . __('style', 'css3_grid') . " " . ($i+1) . "</label><br />";
		$shortcodesSelect .= "
					</div>					
					<div class='css3_grid_tooltip_column'>
						<strong>" . __('Yes icons(old)', 'css3_grid') . "</strong>";
						for($i=0; $i<11; $i++)
							$shortcodesSelect .= "<img src='" . plugins_url("img/tick_" . ($i<9 ? "0" : "") . ($i+1) . ".png", __FILE__) . "' /><label>&nbsp;" . __('style', 'css3_grid') . " " . ($i+1) . "</label><br />";
		$shortcodesSelect .= "
					</div>
					<div class='css3_grid_tooltip_column'>
						<strong>" . __('Yes icons(old)', 'css3_grid') . "</strong>";
						for($i=11; $i<21; $i++)
							$shortcodesSelect .= "<img src='" . plugins_url("img/tick_" . ($i+1) . ".png", __FILE__) . "' /><label>&nbsp;style " . ($i+1) . "</label><br />";
		$shortcodesSelect .= "
					</div>
					<div class='css3_grid_tooltip_column'>
						<strong>" . __('No icons', 'css3_grid') . "</strong>";
					for($i=0; $i<10; $i++)
							$shortcodesSelect .= "<div class='p_table_1'><span class='css3_grid_icon icon_no_" . ($i<9 ? "0" : "") . ($i+1) . "'></span></div><label>&nbsp;" . __('style', 'css3_grid') . " " . ($i+1) . "</label><br />";
		$shortcodesSelect .= "
					</div>
					<div class='css3_grid_tooltip_column'>
						<strong>" . __('No icons(old)', 'css3_grid') . "</strong>";
					for($i=0; $i<11; $i++)
							$shortcodesSelect .= "<img src='" . plugins_url("img/cross_" . ($i<9 ? "0" : "") . ($i+1) . ".png", __FILE__) . "' /><label>&nbsp;" . __('style', 'css3_grid') . " " . ($i+1) . "</label><br />";
		$shortcodesSelect .= "
					</div>
					<div class='css3_grid_tooltip_column'>
						<strong>" . __('No icons(old)', 'css3_grid') . "</strong>";
					for($i=11; $i<21; $i++)
							$shortcodesSelect .= "<img src='" . plugins_url("img/cross_" . ($i+1) . ".png", __FILE__) . "' /><label>&nbsp;" . __('style', 'css3_grid') . " " . ($i+1) . "</label><br />";
		$shortcodesSelect .= "
					</div>
				</span>
			</span>
			<br />
			<label>" . __('tooltip: ', 'css3_grid') . "</label><input class='css3_grid_tooltip_input' type='text' name='tooltips[]' value='' />";
		//get google fonts
		$fontsArray = get_option("css3_grid_google_fonts");
		//update if option doesn't exist or it was modified more than 2 weeks ago
		if($fontsArray===FALSE || count((array)$fontsArray)==0 || (time()-$fontsArray->last_update>2*7*24*60*60))
		{
			$google_api_url = 'https://quanticalabs.com/.tools/GoogleFont/font.txt';
			$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false )));
			$fontsArray = json_decode($fontsJson);
			if(isset($fontsArray))
			{
				$fontsArray->last_update = time();		
				update_option("css3_grid_google_fonts", $fontsArray);
			}
		}
		
		$fontsHtml = "";
		if(isset($fontsArray))
		{
			$fontsCount = count($fontsArray->items);
			for($i=0; $i<$fontsCount; $i++)
			{
				$variantsCount = count($fontsArray->items[$i]->variants);
				if($variantsCount>1)
				{
					for($j=0; $j<$variantsCount; $j++)
					{
						$fontsHtml .= '<option value="' . $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] . '">' . $fontsArray->items[$i]->family . ":" . $fontsArray->items[$i]->variants[$j] . '</option>';
					}
				}
				else
				{
					$fontsHtml .= '<option value="' . $fontsArray->items[$i]->family . '">' . $fontsArray->items[$i]->family . '</option>';
				}
			}
		}
		?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="css3_grid_settings" enctype="multipart/form-data">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<label for="editShortcodeId"><?php _e("Choose shortcode id", "css3_grid"); ?></label>
						</th>
						<td>
							<select name="editShortcodeId" id="editShortcodeId">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<?php
									for($i=0; $i<count($css3GridAllShortcodeIds); $i++)
										echo "<option value='$css3GridAllShortcodeIds[$i]'>" . substr($css3GridAllShortcodeIds[$i], 29) . "</option>";
								?>
							</select>
							<img style="display: none; cursor: pointer;" id="deleteButton" src="<?php echo esc_url(plugins_url('img/delete.png', __FILE__));?>" alt="del" title="<?php _e('Delete this pricing table', 'css3_grid'); ?>" />
							<span id="ajax_loader" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
							<span class="description"><?php _e("Choose the shortcode id for editing", "css3_grid"); ?></span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="shortcodeId"><?php _e("Or type new shortcode id *", "css3_grid"); ?></label>
						</th>
						<td>
							<input type="text" class="regular-text" value="" id="shortcodeId" name="shortcodeId" pattern="[a-zA-z0-9_-]+" title="<?php _e("Please use only listed characters: letters, numbers, hyphen(-) and underscore(_)", "css3_grid"); ?>">
							<span class="description"><?php _e("Unique identifier for css3_grid shortcode. Don't use special characters.", "css3_grid"); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="css3_grid_configuration_tabs">
				<ul class="nav-tabs css3_clearfix">
					<li class="nav-tab">
						<a href="#tab-main">
							<?php _e('Main configuration', 'css3_grid'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-responsive">
							<?php _e('Responsive', 'css3_grid'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-fonts">
							<?php _e('Fonts configuration', 'css3_grid'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-sliding">
							<?php _e('Sliding configuration', 'css3_grid'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-import-export">
							<?php _e('Import/export', 'css3_grid'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-restore-default-tables">
							<?php _e('Restore default tables', 'css3_grid'); ?>
						</a>
					</li>
					<li class="nav-tab">
						<a href="#tab-pricing-cycles">
							<?php _e('Pricing cycles', 'css3_grid'); ?>
						</a>
					</li>
				</ul>
				<div id="tab-main">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="kind"><?php _e('Type', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="kind" id="kind">
										<option value="1"><?php _e('Table', 'css3_grid'); ?> 1</option>
										<option value="2"><?php _e('Table', 'css3_grid'); ?> 2</option>
									</select>
									<span class="description"><?php _e('One of two available kinds of table.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="style"><?php _e('Style', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="styleForTable1" id="styleForTable1">
										<option value="1"><?php _e('Style', 'css3_grid'); ?> 1</option>
										<option value="2"><?php _e('Style', 'css3_grid'); ?> 2</option>
										<option value="3"><?php _e('Style', 'css3_grid'); ?> 3</option>
										<option value="4"><?php _e('Style', 'css3_grid'); ?> 4</option>
										<option value="5"><?php _e('Style', 'css3_grid'); ?> 5</option>
										<option value="6"><?php _e('Style', 'css3_grid'); ?> 6</option>
										<option value="7"><?php _e('Style', 'css3_grid'); ?> 7</option>
										<option value="8"><?php _e('Style', 'css3_grid'); ?> 8</option>
										<option value="9"><?php _e('Style', 'css3_grid'); ?> 9</option>
										<option value="10"><?php _e('Style', 'css3_grid'); ?> 10</option>
										<option value="11"><?php _e('Style', 'css3_grid'); ?> 11</option>
										<option value="12"><?php _e('Style', 'css3_grid'); ?> 12</option>
										<option value="13"><?php _e('Style', 'css3_grid'); ?> 13 <?php _e('(medicenter blue)', 'css3_grid'); ?></option>
										<option value="14"><?php _e('Style', 'css3_grid'); ?> 14 <?php _e('(medicenter green)', 'css3_grid'); ?></option>
										<option value="15"><?php _e('Style', 'css3_grid'); ?> 15 <?php _e('(medicenter orange)', 'css3_grid'); ?></option>
										<option value="16"><?php _e('Style', 'css3_grid'); ?> 16 <?php _e('(medicenter red)', 'css3_grid'); ?></option>
										<option value="17"><?php _e('Style', 'css3_grid'); ?> 17 <?php _e('(medicenter turquoise)', 'css3_grid'); ?></option>
										<option value="18"><?php _e('Style', 'css3_grid'); ?> 18 <?php _e('(medicenter violet)', 'css3_grid'); ?></option>
									</select>
									<select name="styleForTable2" id="styleForTable2" style="display: none;">
										<option value="1"><?php _e('Style', 'css3_grid'); ?> 1</option>
										<option value="2"><?php _e('Style', 'css3_grid'); ?> 2</option>
										<option value="3"><?php _e('Style', 'css3_grid'); ?> 3</option>
										<option value="4"><?php _e('Style', 'css3_grid'); ?> 4</option>
										<option value="5"><?php _e('Style', 'css3_grid'); ?> 5</option>
										<option value="6"><?php _e('Style', 'css3_grid'); ?> 6</option>
										<option value="7"><?php _e('Style', 'css3_grid'); ?> 7</option>
										<option value="8"><?php _e('Style', 'css3_grid'); ?> 8</option>
									</select>
									<span class="description"><?php _e('Specifies the style version of the table.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_hover_type_row">
								<th scope="row">
									<label for="hoverType"><?php _e('Hover type', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="hoverTypeForTable1" id="hoverTypeForTable1">
										<option value="active"><?php _e('Active', 'css3_grid'); ?></option>
										<option value="light"><?php _e('Light', 'css3_grid'); ?></option>
										<option value="disabled"><?php _e('Disabled', 'css3_grid'); ?></option>
									</select>
									<select name="hoverTypeForTable2" id="hoverTypeForTable2" style="display: none;">
										<option value="active"><?php _e('Active', 'css3_grid'); ?></option>
										<option value="disabled"><?php _e('Disabled', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('Specifies the hover effect for the columns.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="columns"><?php _e('Columns', 'css3_grid'); ?></label>
								</th>
								<td>
									<input style="float: left;" type="text" readonly="readonly" class="regular-text" value="3" id="columns" name="columns" maxlength="2">
									<a href="#" class="css3_grid_less" title="<?php _e('less', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_more" title="<?php _e('more', 'css3_grid'); ?>"></a>
									<span style="float: left;margin-top: 2px;" class="description"><?php _e('Number of columns.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="rows"><?php _e('Rows', 'css3_grid'); ?></label>
								</th>
								<td>
									<input style="float: left;" type="text" readonly="readonly" class="regular-text" value="9" id="rows" name="rows" maxlength="2">
									<a href="#" class="css3_grid_less" title="<?php _e('less', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_more" title="<?php _e('more', 'css3_grid'); ?>"></a>
									<span style="float: left;margin-top: 2px;" class="description"><?php _e('Number of rows.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="hiddenRows"><?php _e('Hidden rows', 'css3_grid'); ?></label>
								</th>
								<td>
									<input style="float: left;" type="text" readonly="readonly" class="regular-text" value="0" id="hiddenRows" name="hiddenRows" maxlength="2">
									<a href="#" class="css3_grid_less css3_grid_to_zero" title="<?php _e('less', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_more" title="<?php _e('more', 'css3_grid'); ?>"></a>
									<span style="float: left;margin-top: 2px;" class="description"><?php _e('Number of hidden rows<br />at the bottom (for long tables).', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_hidden_rows_row">
								<th scope="row">
									<label for="hiddenRowsButtonExpandText"><?php _e('Hidden rows button expand text', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="<?php _e('Click here to expand!', 'css3_grid'); ?>" id="hiddenRowsButtonExpandText" name="hiddenRowsButtonExpandText">
								</td>
							</tr>
							<tr valign="top" class="css3_hidden_rows_row">
								<th scope="row">
									<label for="hiddenRowsButtonCollapseText"><?php _e('Hidden rows button collapse text', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="<?php _e('Click here to collapse!', 'css3_grid'); ?>" id="hiddenRowsButtonCollapseText" name="hiddenRowsButtonCollapseText">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="css3CustomCss"><?php _e('Custom CSS code', 'css3_grid'); ?></label>
								</th>
								<td>
									<textarea id="css3CustomCss" name="css3CustomCss" style="width: 500px; height: 150px;"></textarea>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-responsive">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="responsive"><?php _e('Responsive', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="responsive" id="responsive">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('Enable or disable responsive feature (fit for different resolutions).', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="responsiveStepsRow">
								<th scope="row">
									<label for="responsiveSteps"><?php _e('Responsive steps (sizes)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input style="float: left;" type="text" readonly="readonly" class="regular-text" value="3" id="responsiveSteps" name="responsiveSteps" maxlength="2">
									<a href="#" class="css3_grid_less" title="<?php _e('less', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_more" title="<?php _e('more', 'css3_grid'); ?>"></a>
								</td>
							</tr>
							<tr valign="top" class="responsiveStepRow responsiveStepRow1">
								<th scope="row">
									<label><?php _e('Screen width', 'css3_grid'); ?> 1</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="1009" name="responsiveStepWidth[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveStepRow responsiveStepRow2">
								<th scope="row">
									<label><?php _e('Screen width', 'css3_grid'); ?> 2</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="767" name="responsiveStepWidth[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveStepRow responsiveStepRow3">
								<th scope="row">
									<label><?php _e('Screen width', 'css3_grid'); ?> 3</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="479" name="responsiveStepWidth[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveButtonWidthRow responsiveButtonWidthRow1">
								<th scope="row">
									<label><?php _e('Responsive button width', 'css3_grid'); ?> 1</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveButtonWidth[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveButtonWidthRow responsiveButtonWidthRow2">
								<th scope="row">
									<label><?php _e('Responsive button width', 'css3_grid'); ?> 2</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveButtonWidth[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveButtonWidthRow responsiveButtonWidthRow3">
								<th scope="row">
									<label><?php _e('Responsive button width', 'css3_grid'); ?> 3</label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveButtonWidth[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveHideCaptionColumnRow">
								<th scope="row">
									<label for="responsiveHideCaptionColumn"><?php _e('Hide caption (first) column on small resolutions', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="responsiveHideCaptionColumn" id="responsiveHideCaptionColumn">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('If set to \'yes\' you can adjust screen width value in responsive.css file (line 5).', 'css3_grid'); ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-fonts">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Header font', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="headerFontCustom"><?php _e('Enter font name', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="headerFontCustom" name="headerFontCustom">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="headerFont"><?php _e('or choose Google font', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="headerFont" id="headerFont" class="google_font_chooser">
										<option value=""><?php _e("Default", 'css3_grid'); ?></option>
										<?php
											echo $fontsHtml;
										?>
									</select>
									<span id="ajax_loader_header_font" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
								</td>
							</tr>
							<tr valign="top" class="fontSubsetRow">
								<th scope="row">
									<label for="headerFontSubset"><?php _e('Google font subset', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="headerFontSubset[]" id="headerFontSubset" class="fontSubset" multiple="multiple"></select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="headerFontSize"><?php _e('Font size (in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="headerFontSize" name="headerFontSize">
								</td>
							</tr>
							<tr valign="top" class="responsiveHeaderFontSizeRow responsiveHeaderFontSizeRow1">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 1 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveHeaderFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveHeaderFontSizeRow responsiveHeaderFontSizeRow2">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 2 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveHeaderFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveHeaderFontSizeRow responsiveHeaderFontSizeRow3">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 3 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveHeaderFontSize[]">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Price font', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="priceFontCustom"><?php _e('Enter font name', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="priceFontCustom" name="priceFontCustom">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="priceFont"><?php _e('or choose Google font', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="priceFont" id="priceFont" class="google_font_chooser">
										<option value=""><?php _e("Default", 'css3_grid'); ?></option>
										<?php
											echo $fontsHtml;
										?>
									</select>
									<span id="ajax_loader_price_font" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
								</td>
							</tr>
							<tr valign="top" class="fontSubsetRow">
								<th scope="row">
									<label for="priceFontSubset"><?php _e('Google font subset', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="priceFontSubset[]" id="priceFontSubset" class="fontSubset" multiple="multiple"></select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="priceFontSize"><?php _e('Font size (in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="priceFontSize" name="priceFontSize">
								</td>
							</tr>
							<tr valign="top" class="responsivePriceFontSizeRow responsivePriceFontSizeRow1">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 1 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsivePriceFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsivePriceFontSizeRow responsivePriceFontSizeRow2">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 2 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsivePriceFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsivePriceFontSizeRow responsivePriceFontSizeRow3">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 3 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsivePriceFontSize[]">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Per month font', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="permonthFontCustom"><?php _e('Enter font name', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="permonthFontCustom" name="permonthFontCustom">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="permonthFont"><?php _e('or choose Google font', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="permonthFont" id="permonthFont" class="google_font_chooser">
										<option value=""><?php _e("Default", 'css3_grid'); ?></option>
										<?php
											echo $fontsHtml;
										?>
									</select>
									<span id="ajax_loader_header_font" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
								</td>
							</tr>
							<tr valign="top" class="fontSubsetRow">
								<th scope="row">
									<label for="permonthFontSubset"><?php _e('Google font subset', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="permonthFontSubset[]" id="permonthFontSubset" class="fontSubset" multiple="multiple"></select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="permonthFontSize"><?php _e('Font size (in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="permonthFontSize" name="permonthFontSize">
								</td>
							</tr>
							<tr valign="top" class="responsivePermonthFontSizeRow responsivePermonthFontSizeRow1">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 1 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsivePermonthFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsivePermonthFontSizeRow responsivePermonthFontSizeRow2">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 2 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsivePermonthFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsivePermonthFontSizeRow responsivePermonthFontSizeRow3">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 3 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsivePermonthFontSize[]">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Content font', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="contentFontCustom"><?php _e('Enter font name', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="contentFontCustom" name="contentFontCustom">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="contentFont"><?php _e('or choose Google font', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="contentFont" id="contentFont" class="google_font_chooser">
										<option value=""><?php _e("Default", 'css3_grid'); ?></option>
										<?php
											echo $fontsHtml;
										?>
									</select>
									<span id="ajax_loader_header_font" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
								</td>
							</tr>
							<tr valign="top" class="fontSubsetRow">
								<th scope="row">
									<label for="contentFontSubset"><?php _e('Google font subset', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="contentFontSubset[]" id="contentFontSubset" class="fontSubset" multiple="multiple"></select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="contentFontSize"><?php _e('Font size (in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="contentFontSize" name="contentFontSize">
								</td>
							</tr>
							<tr valign="top" class="responsiveContentFontSizeRow responsiveContentFontSizeRow1">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 1 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveContentFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveContentFontSizeRow responsiveContentFontSizeRow2">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 2 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveContentFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveContentFontSizeRow responsiveContentFontSizeRow3">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 3 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveContentFontSize[]">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Buttons font', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="buttonsFontCustom"><?php _e('Enter font name', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="buttonsFontCustom" name="buttonsFontCustom">
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="buttonsFont"><?php _e('or choose Google font', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="buttonsFont" id="buttonsFont" class="google_font_chooser">
										<option value=""><?php _e("Default", 'css3_grid'); ?></option>
										<?php
											echo $fontsHtml;
										?>
									</select>
									<span id="ajax_loader_header_font" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
								</td>
							</tr>
							<tr valign="top" class="fontSubsetRow">
								<th scope="row">
									<label for="buttonsFontSubset"><?php _e('Google font subset', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="buttonsFontSubset[]" id="buttonsFontSubset" class="fontSubset" multiple="multiple"></select>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">
									<label for="buttonsFontSize"><?php _e('Font size (in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="buttonsFontSize" name="buttonsFontSize">
								</td>
							</tr>
							<tr valign="top" class="responsiveButtonsFontSizeRow responsiveButtonsFontSizeRow1">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 1 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveButtonsFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveButtonsFontSizeRow responsiveButtonsFontSizeRow2">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 2 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveButtonsFontSize[]">
								</td>
							</tr>
							<tr valign="top" class="responsiveButtonsFontSizeRow responsiveButtonsFontSizeRow3">
								<th scope="row">
									<label><?php _e('Responsive font size', 'css3_grid'); ?> 3 <?php _e('(in px)', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="responsiveButtonsFontSize[]">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-sliding">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="slidingColumns"><?php _e('Sliding columns', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingColumns" id="slidingColumns">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('Enable or disable sliding for columns (left/right moving).', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="visibleColumns"><?php _e('Visible columns', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="1" id="visibleColumns" name="visibleColumns" maxlength="2">
									<span class="description"><?php _e('Number of visible columns at start, when sliding columns feature is enabled.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="scrollColumns"><?php _e('Columns to scroll', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" id="scrollColumns" name="scrollColumns" maxlength="2">
									<span class="description"><?php _e('The number of columns to scroll. When empty the \'Visible columns\' value is used.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingNavigation"><?php _e('Navigation', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingNavigation" id="slidingNavigation">
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('Enable or disable sliding navigation.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row css3_sliding_navigation_row">
								<th scope="row">
									<label for="slidingNavigationArrows"><?php _e('Navigation arrows', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingNavigationArrows" id="slidingNavigationArrows">
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row css3_sliding_navigation_row css3_sliding_arrows_row">
								<th scope="row">
									<label for="slidingArrowsStyle"><?php _e('Arrows style', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingArrowsStyle" id="slidingArrowsStyle">
										<option value="style1"><?php _e('style', 'css3_grid'); ?> 1</option>
										<option value="style2"><?php _e('style', 'css3_grid'); ?> 2</option>
										<option value="style3"><?php _e('style', 'css3_grid'); ?> 3</option>
										<option value="style4"><?php _e('style', 'css3_grid'); ?> 4</option>
										<option value="style5"><?php _e('style', 'css3_grid'); ?> 5</option>
										<option value="style6"><?php _e('style', 'css3_grid'); ?> 6</option>
										<option value="style7"><?php _e('style', 'css3_grid'); ?> 7</option>
										<option value="style8"><?php _e('style', 'css3_grid'); ?> 8</option>
										<option value="style9"><?php _e('style', 'css3_grid'); ?> 9</option>
										<option value="style10"><?php _e('style', 'css3_grid'); ?> 10</option>
									</select>
									<span class='css3_grid_tooltip css3_grid_admin_info css3_grid_tooltip_arrows'>
										<span>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 1</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style1'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style1'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 2</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style2'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style2'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 3</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style3'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style3'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 4</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style4'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style4'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 5</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style5'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style5'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 6</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style6'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style6'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 7</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style7'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style7'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 8</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style8'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style8'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 9</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style9'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style9'></a>
											</div>
											<div class='css3_grid_tooltip_column'>
												<strong><?php _e('style', 'css3_grid'); ?> 10</strong>
												<a href='#' class='css3_grid_slide_button_prev css3_grid_slide_button_style10'></a>
												<a href='#' class='css3_grid_slide_button_next css3_grid_slide_button_style10'></a>
											</div>
										</span>
									</span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row css3_sliding_navigation_row">
								<th scope="row">
									<label for="slidingPagination"><?php _e('Navigation pagination', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingPagination" id="slidingPagination">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row css3_sliding_navigation_row css3_sliding_pagination_row">
								<th scope="row">
									<label for="slidingPaginationStyle"><?php _e('Pagination style', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingPaginationStyle" id="slidingPaginationStyle">
										<option value="style1"><?php _e('style', 'css3_grid'); ?> 1</option>
										<option value="style2"><?php _e('style', 'css3_grid'); ?> 2</option>
										<option value="style3"><?php _e('style', 'css3_grid'); ?> 3</option>
									</select>
									<span class='css3_grid_tooltip css3_grid_admin_info css3_grid_tooltip_pagination'>
										<span>
											<div class='css3_grid_tooltip_column css3_grid_pagination css3_grid_pagination_style1'>
												<strong><?php _e('style', 'css3_grid'); ?> 1</strong>
												<a href='#' class="selected"></a>
												<a href='#'></a>
												<a href='#'></a>
											</div>
											<div class='css3_grid_tooltip_column css3_grid_pagination css3_grid_pagination_style2'>
												<strong><?php _e('style', 'css3_grid'); ?> 2</strong>
												<a href='#' class="selected"></a>
												<a href='#'></a>
												<a href='#'></a>
											</div>
											<div class='css3_grid_tooltip_column css3_grid_pagination css3_grid_pagination_style3'>
												<strong><?php _e('style', 'css3_grid'); ?> 3</strong>
												<a href='#' class="selected"></a>
												<a href='#'></a>
												<a href='#'></a>
											</div>
										</span>
									</span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row css3_sliding_navigation_row css3_sliding_pagination_row">
								<th scope="row">
									<label for="slidingPaginationPosition"><?php _e('Pagination position', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="slidingPaginationPosition" id="slidingPaginationPosition">
										<option value="bottom"><?php _e('bottom', 'css3_grid'); ?></option>
										<option value="top"><?php _e('top', 'css3_grid'); ?></option>
										<option value="both"><?php _e('both', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingCircular"><?php _e('Circular', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingCircular" name="slidingCircular">
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingInfinite"><?php _e('Infinite', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingInfinite" name="slidingInfinite">
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingOnTouch"><?php _e('Slide on touch', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingOnTouch" name="slidingOnTouch">
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingOnMouse"><?php _e('Slide on mouse', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingOnMouse" name="slidingOnMouse">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingThreshold"><?php _e('Slide threshold', 'css3_grid'); ?></label>
								</th>
								<td>	
									<input type="text" class="regular-text" value="75" id="slidingThreshold" name="slidingThreshold">
									<span class="description"><?php _e('The number of pixels that the user must move their finger before it is considered a swipe.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingAutoplay"><?php _e('Sliding autoplay', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingAutoplay" name="slidingAutoplay">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingEffect"><?php _e('Sliding effect', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingEffect" name="slidingEffect">
										<option value="scroll"><?php _e('scroll', 'css3_grid'); ?></option>
										<option value="none"><?php _e('none', 'css3_grid'); ?></option>
										<option value="directscroll"><?php _e('directscroll', 'css3_grid'); ?></option>
										<option value="fade"><?php _e('fade', 'css3_grid'); ?></option>
										<option value="crossfade"><?php _e('crossfade', 'css3_grid'); ?></option>
										<option value="cover"><?php _e('cover', 'css3_grid'); ?></option>
										<option value="uncover"><?php _e('uncover', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingEasing"><?php _e('Sliding easing', 'css3_grid'); ?></label>
								</th>
								<td>	
									<select id="slidingEasing" name="slidingEasing">
										<option value="swing"><?php _e('swing', 'css3_grid'); ?></option>
										<option value="linear"><?php _e('linear', 'css3_grid'); ?></option>
										<option value="easeInQuad"><?php _e('easeInQuad', 'css3_grid'); ?></option>
										<option value="easeOutQuad"><?php _e('easeOutQuad', 'css3_grid'); ?></option>
										<option value="easeInOutQuad"><?php _e('easeInOutQuad', 'css3_grid'); ?></option>
										<option value="easeInCubic"><?php _e('easeInCubic', 'css3_grid'); ?></option>
										<option value="easeOutCubic"><?php _e('easeOutCubic', 'css3_grid'); ?></option>
										<option value="easeInOutCubic"><?php _e('easeInOutCubic', 'css3_grid'); ?></option>
										<option value="easeInQuart"><?php _e('easeInQuart', 'css3_grid'); ?></option>
										<option value="easeOutQuart"><?php _e('easeOutQuart', 'css3_grid'); ?></option>
										<option value="easeInOutQuart"><?php _e('easeInOutQuart', 'css3_grid'); ?></option>
										<option value="easeInSine"><?php _e('easeInSine', 'css3_grid'); ?></option>
										<option value="easeOutSine"><?php _e('easeOutSine', 'css3_grid'); ?></option>
										<option value="easeInOutSine"><?php _e('easeInOutSine', 'css3_grid'); ?></option>
										<option value="easeInExpo"><?php _e('easeInExpo', 'css3_grid'); ?></option>
										<option value="easeOutExpo"><?php _e('easeOutExpo', 'css3_grid'); ?></option>
										<option value="easeInOutExpo"><?php _e('easeInOutExpo', 'css3_grid'); ?></option>
										<option value="easeInQuint"><?php _e('easeInQuint', 'css3_grid'); ?></option>
										<option value="easeOutQuint"><?php _e('easeOutQuint', 'css3_grid'); ?></option>
										<option value="easeInOutQuint"><?php _e('easeInOutQuint', 'css3_grid'); ?></option>
										<option value="easeInCirc"><?php _e('easeInCirc', 'css3_grid'); ?></option>
										<option value="easeOutCirc"><?php _e('easeOutCirc', 'css3_grid'); ?></option>
										<option value="easeInOutCirc"><?php _e('easeInOutCirc', 'css3_grid'); ?></option>
										<option value="easeInElastic"><?php _e('easeInElastic', 'css3_grid'); ?></option>
										<option value="easeOutElastic"><?php _e('easeOutElastic', 'css3_grid'); ?></option>
										<option value="easeInOutElastic"><?php _e('easeInOutElastic', 'css3_grid'); ?></option>
										<option value="easeInBack"><?php _e('easeInBack', 'css3_grid'); ?></option>
										<option value="easeOutBack"><?php _e('easeOutBack', 'css3_grid'); ?></option>
										<option value="easeInOutBack"><?php _e('easeInOutBack', 'css3_grid'); ?></option>
										<option value="easeInBounce"><?php _e('easeInBounce', 'css3_grid'); ?></option>
										<option value="easeOutBounce"><?php _e('easeOutBounce', 'css3_grid'); ?></option>
										<option value="easeInOutBounce"><?php _e('easeInOutBounce', 'css3_grid'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top" class="css3_sliding_row">
								<th scope="row">
									<label for="slidingDuration"><?php _e('Sliding transition speed (ms)', 'css3_grid'); ?></label>
								</th>
								<td>	
									<input type="text" class="regular-text" value="500" id="slidingDuration" name="slidingDuration">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-import-export">
					<table class="form-table">
						<tbody>
							<?php if(count($css3GridAllShortcodeIds)): ?>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Export', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<th scope="row" style="vertical-align: middle;">
									<label for="exportIds"><?php _e('Choose tables for export', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="exportIds[]" id="exportIds" multiple="multiple" style="height: 250px;">
										<?php
											for($i=0; $i<count($css3GridAllShortcodeIds); $i++)
												echo "<option value='$css3GridAllShortcodeIds[$i]' selected='selected'>" . substr($css3GridAllShortcodeIds[$i], 29) . "</option>";
										?>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">	
									<a href="<?php echo plugins_url("export.php", __FILE__); ?>?action=export_to_file" id="export_to_file" class="button-primary"><?php _e('Export to file', 'css3_grid'); ?></a>
								</td>
							</tr>
							<?php endif; ?>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Import', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<td colspan="2">	
									<input type="file" id="import_from_file_input" name="import_from_file_input">
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2">	
									<input type="submit" id="import_from_file" value="<?php _e('Import from file', 'css3_grid'); ?>" class="button-primary" name="Submit">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-restore-default-tables">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label class="css3_grid_bold">
										<?php _e('Restore default tables', 'css3_grid'); ?>
									</label>
								</th>
							</tr>
							<tr valign="top">
								<td colspan="2">	
									<input type="submit" id="restore_default_tables" value="<?php _e('Restore default tables', 'css3_grid'); ?>" class="button-primary" name="Submit">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="tab-pricing-cycles">
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">
									<label for="pricingCycles"><?php _e('Pricing cycles', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="pricingCycles" id="pricingCycles">
										<option value="0"><?php _e('no', 'css3_grid'); ?></option>
										<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('Enable or disable pricing cycles feature.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow">
								<th scope="row">
									<label for="dropdownAlignment"><?php _e('Dropdown alignment', 'css3_grid'); ?></label>
								</th>
								<td>
									<select name="dropdownAlignment" id="dropdownAlignment">
										<option value="left"><?php _e('left', 'css3_grid'); ?></option>
										<option value="center"><?php _e('center', 'css3_grid'); ?></option>
										<option value="right"><?php _e('right', 'css3_grid'); ?></option>
									</select>
									<span class="description"><?php _e('Position of a dropdown list.', 'css3_grid'); ?></span>
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow">
								<th scope="row">
									<label for="pricingCyclesSteps"><?php _e('Pricing Cycles Steps', 'css3_grid'); ?></label>
								</th>
								<td>
									<input style="float: left;" type="text" readonly="readonly" class="regular-text" value="1" id="pricingCyclesSteps" name="pricingCyclesSteps" maxlength="2">
									<a href="#" class="css3_grid_less" title="less"></a>
									<a href="#" class="css3_grid_more" title="more"></a>
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow">
								<th colspan="2">
									<div class="pricingCyclesConfiguration">
										<h3 class="pricingCycle pricingCycle1" data-cycle="1"><?php _e('Cycle', 'css3_grid'); ?> 1</h3>
										<div class="pricingCycle1">
											<table>
												<tr valign="top">
													<th scope="row"><label><?php _e('Title', 'css3_grid'); ?></label></th>
													<td><input type="text" class="regular-text cycleTitle" value="" name="pricingCycleTitle[]"></td>
												</tr>
												<tr valign="top">
													<th scope="row"><label><?php _e('Unique ID', 'css3_grid'); ?></label><br></th>
													<td><input type="text" class="regular-text cycleUniqueID" value="" name="pricingCycleID[]"></td>
												</tr>
												<tr valign="top" class="pricingCycleColumn1">		
													<th scope="row" colspan="2"><label class="column-number"><?php _e('Column', 'css3_grid'); ?> 1</label></th>
												</tr>
												<tr valign="top" class="pricingCycleColumn1">
													<th scope="row"><label><?php _e('Price', 'css3_grid'); ?></label></th>
													<td>
														<input type="text" class="regular-text" value="" name="pricingCyclePriceColumn[0][]">
														<select name="inset">
															<option value="-1"><?php _e('choose shortcode...', 'css3_grid'); ?></option>
															<optgroup label="<?php _e('Table', 'css3_grid'); ?> 1">
																<option value="price"><?php _e('price', 'css3_grid'); ?></option>
															</optgroup>
															<optgroup label="<?php _e('Table', 'css3_grid'); ?> 2">
																<option value="price2"><?php _e('price', 'css3_grid'); ?></option>
															</optgroup>
														</select>
													</td>
												</tr>
												<tr valign="top" class="pricingCycleColumn1">
													<th scope="row"><label><?php _e('Button URL', 'css3_grid'); ?></label></th>
													<td><input type="text" class="regular-text" value="" name="pricingCycleButtonURLColumn[0][]"></td>
												</tr>
												<tr valign="top" class="pricingCycleColumn2">
													<th scope="row" colspan="2"><label class="column-number"><?php _e('Column', 'css3_grid'); ?> 2</label></th>													
												</tr>
												<tr valign="top" class="pricingCycleColumn2">
													<th scope="row"><label><?php _e('Price', 'css3_grid'); ?></label></th>
													<td>
														<input type="text" class="regular-text" value="" name="pricingCyclePriceColumn[0][]">
														<select name="inset">
															<option value="-1"><?php _e('choose shortcode...', 'css3_grid'); ?></option>
															<optgroup label="<?php _e('Table', 'css3_grid'); ?> 1">
																<option value="price"><?php _e('price', 'css3_grid'); ?></option>
															</optgroup>
															<optgroup label="<?php _e('Table', 'css3_grid'); ?> 2">
																<option value="price2"><?php _e('price', 'css3_grid'); ?></option>
															</optgroup>
														</select>
													</td>
												</tr>
												<tr valign="top" class="pricingCycleColumn2">
													<th scope="row"><label><?php _e('Button URL', 'css3_grid'); ?></label></th>
													<td><input type="text" class="regular-text" value="" name="pricingCycleButtonURLColumn[0][]"></td>
												</tr>
											</table>
										</div>
									</div>
								</th>
							</tr>
							<?php /* ?>
							<tr valign="top" style="display: none;" class="pricingCycle pricingCycleRow pricingCycle1">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Title', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCycleTitle[]">
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow pricingCycle1">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Unique ID', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCycleID[]">
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow pricingCycle1">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Price Subtitle', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCycleSubtitle[]">
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow pricingCycle1 pricingCycleColumn1">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Column', 'css3_grid'); ?> 1 <?php _e('price', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCyclePriceColumn[0][]"><br>
									<select name="inset">
										<option value="-1">choose shortcode...</option>
										<optgroup label="Table 1">
											<option value="price">price</option>
										</optgroup>
										<optgroup label="Table 2">
											<option value="price2">price</option>
										</optgroup>
									</select>
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow pricingCycle1 pricingCycleColumn1">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Column', 'css3_grid'); ?> 1 <?php _e('Button URL', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCycleButtonURLColumn[0][]">
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow pricingCycle1 pricingCycleColumn2">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Column', 'css3_grid'); ?> 2 <?php _e('price', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCyclePriceColumn[0][]"><br>
									<select name="inset">
										<option value="-1">choose shortcode...</option>
										<optgroup label="Table 1">
											<option value="price">price</option>
										</optgroup>
										<optgroup label="Table 2">
											<option value="price2">price</option>
										</optgroup>
									</select>
								</td>
							</tr>
							<tr valign="top" style="display: none;" class="pricingCycleRow pricingCycle1 pricingCycleColumn2">
								<th scope="row">
									<label><?php _e('Cycle', 'css3_grid'); ?> 1 - <?php _e('Column', 'css3_grid'); ?> 2 <?php _e('Button URL', 'css3_grid'); ?></label>
								</th>
								<td>
									<input type="text" class="regular-text" value="" name="pricingCycleButtonURLColumn[0][]">
								</td>
							</tr>
							<?php */ ?>
						</tbody>
					</table>
				</div>
			</div>
			<div id="textsTable">
				<table class="widefat css3_grid_widefat">
				<thead>
					<tr>
						<th class="css3_grid_admin_column1">
							<div class="css3_grid_column1_text">
								<?php _e('Rows configuration', 'css3_grid'); ?>
							</div>
						</th>
						<th class="css3_grid_admin_column2">
							<div class="css3_grid_sort_column css3_clearfix">
								<div class="css3_grid_arrows">
									<a href="#" class="css3_grid_sort_left" title="<?php _e('left', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_sort_right" title="<?php _e('right', 'css3_grid'); ?>"></a>
								</div>
							</div>
							<?php _e('Column', 'css3_grid'); ?> 1
							<br />
							<label><?php _e('width (optional):', 'css3_grid'); ?></label><input type="text" name="widths[]" value="" />
							<div class="css3_responsive_width_container">
								<label class="css3_responsive_width css3_responsive_width1"><?php _e('responsive width', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width1" type="text" name="responsiveWidths[]" value="" />
								<br class="css3_responsive_width css3_responsive_width2">
								<label class="css3_responsive_width css3_responsive_width2"><?php _e('responsive width', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width2" type="text" name="responsiveWidths[]" value="" />
								<br class="css3_responsive_width css3_responsive_width3">
								<label class="css3_responsive_width css3_responsive_width3"><?php _e('responsive width', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width3" type="text" name="responsiveWidths[]" value="" />
							</div>
							<label><?php _e('aligment (optional):', 'css3_grid'); ?></label>
							<select name="aligments[]">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<option value="left"><?php _e('left', 'css3_grid'); ?></option>
								<option value="center"><?php _e('center', 'css3_grid'); ?></option>
								<option value="right"><?php _e('right', 'css3_grid'); ?></option>
							</select>
							<br class="css3_active_column_br" />
							<label class="css3_active_column_label"><?php _e('active (optional):', 'css3_grid'); ?></label>
							<select name="actives[]" class="css3_active_column_select">
								<option value="-1"><?php _e('no', 'css3_grid'); ?></option>
								<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
							</select>
							<br />
							<label><?php _e('disable/hidden (optional):', 'css3_grid'); ?></label>
							<select name="hiddens[]">
								<option value="-1"><?php _e('no', 'css3_grid'); ?></option>
								<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
							</select>
							<br />
							<label><?php _e('ribbon (optional):', 'css3_grid'); ?></label>
							<select name="ribbons[]">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<optgroup label="Style 1">
									<option value="style1_best"><?php _e('best', 'css3_grid'); ?></option>
									<option value="style1_buy"><?php _e('buy', 'css3_grid'); ?></option>
									<option value="style1_free"><?php _e('free', 'css3_grid'); ?></option>
									<option value="style1_free_caps"><?php _e('free (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_fresh"><?php _e('fresh', 'css3_grid'); ?></option>
									<option value="style1_gift_caps"><?php _e('gift (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_heart"><?php _e('heart', 'css3_grid'); ?></option>
									<option value="style1_hot"><?php _e('hot', 'css3_grid'); ?></option>
									<option value="style1_hot_caps"><?php _e('hot (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_new"><?php _e('new', 'css3_grid'); ?></option>
									<option value="style1_new_caps"><?php _e('new (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_no1"><?php _e('no. 1', 'css3_grid'); ?></option>
									<option value="style1_off5"><?php _e('5% off', 'css3_grid'); ?></option>
									<option value="style1_off10"><?php _e('10% off', 'css3_grid'); ?></option>
									<option value="style1_off15"><?php _e('15% off', 'css3_grid'); ?></option>
									<option value="style1_off20"><?php _e('20% off', 'css3_grid'); ?></option>
									<option value="style1_off25"><?php _e('25% off', 'css3_grid'); ?></option>
									<option value="style1_off30"><?php _e('30% off', 'css3_grid'); ?></option>
									<option value="style1_off35"><?php _e('35% off', 'css3_grid'); ?></option>
									<option value="style1_off40"><?php _e('40% off', 'css3_grid'); ?></option>
									<option value="style1_off50"><?php _e('50% off', 'css3_grid'); ?></option>
									<option value="style1_off75"><?php _e('75% off', 'css3_grid'); ?></option>
									<option value="style1_pack"><?php _e('pack', 'css3_grid'); ?></option>
									<option value="style1_pro"><?php _e('pro', 'css3_grid'); ?></option>
									<option value="style1_sale"><?php _e('sale', 'css3_grid'); ?></option>
									<option value="style1_save"><?php _e('save', 'css3_grid'); ?></option>
									<option value="style1_save_caps"><?php _e('save (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_top"><?php _e('top', 'css3_grid'); ?></option>
									<option value="style1_top_caps"><?php _e('top (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_trial"><?php _e('trial', 'css3_grid'); ?></option>
								</optgroup>
								<optgroup label="Style 2">
									<option value="style2_best"><?php _e('best', 'css3_grid'); ?></option>
									<option value="style2_buy"><?php _e('buy', 'css3_grid'); ?></option>
									<option value="style2_free"><?php _e('free', 'css3_grid'); ?></option>
									<option value="style2_free_caps"><?php _e('free (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_fresh"><?php _e('fresh', 'css3_grid'); ?></option>
									<option value="style2_gift_caps"><?php _e('gift (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_heart"><?php _e('heart', 'css3_grid'); ?></option>
									<option value="style2_hot"><?php _e('hot', 'css3_grid'); ?></option>
									<option value="style2_hot_caps"><?php _e('hot (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_new"><?php _e('new', 'css3_grid'); ?></option>
									<option value="style2_new_caps"><?php _e('new (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_no1"><?php _e('no. 1', 'css3_grid'); ?></option>
									<option value="style2_off5"><?php _e('5% off', 'css3_grid'); ?></option>
									<option value="style2_off10"><?php _e('10% off', 'css3_grid'); ?></option>
									<option value="style2_off15"><?php _e('15% off', 'css3_grid'); ?></option>
									<option value="style2_off20"><?php _e('20% off', 'css3_grid'); ?></option>
									<option value="style2_off25"><?php _e('25% off', 'css3_grid'); ?></option>
									<option value="style2_off30"><?php _e('30% off', 'css3_grid'); ?></option>
									<option value="style2_off35"><?php _e('35% off', 'css3_grid'); ?></option>
									<option value="style2_off40"><?php _e('40% off', 'css3_grid'); ?></option>
									<option value="style2_off50"><?php _e('50% off', 'css3_grid'); ?></option>
									<option value="style2_off75"><?php _e('75% off', 'css3_grid'); ?></option>
									<option value="style2_pack"><?php _e('pack', 'css3_grid'); ?></option>
									<option value="style2_pro"><?php _e('pro', 'css3_grid'); ?></option>
									<option value="style2_sale"><?php _e('sale', 'css3_grid'); ?></option>
									<option value="style2_save"><?php _e('save', 'css3_grid'); ?></option>
									<option value="style2_save_caps"><?php _e('save (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_top"><?php _e('top', 'css3_grid'); ?></option>
									<option value="style2_top_caps"><?php _e('top (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_trial"><?php _e('trial', 'css3_grid'); ?></option>
								</optgroup>
							</select>
						</th>
						<th class="css3_grid_admin_column3">
							<div class="css3_grid_sort_column css3_clearfix">
								<div class="css3_grid_arrows">
									<a href="#" class="css3_grid_sort_left" title="<?php _e('left', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_sort_right" title="<?php _e('right', 'css3_grid'); ?>"></a>
								</div>
							</div>
							<?php _e('Column', 'css3_grid'); ?> 2
							<br />
							<label><?php _e('width (optional):', 'css3_grid'); ?></label><input type="text" name="widths[]" value="" />
							<div class="css3_responsive_width_container">
								<label class="css3_responsive_width css3_responsive_width1"><?php _e('responsive width', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width1" type="text" name="responsiveWidths[]" value="" />
								<br class="css3_responsive_width css3_responsive_width2">
								<label class="css3_responsive_width css3_responsive_width2"><?php _e('responsive width', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width2" type="text" name="responsiveWidths[]" value="" />
								<br class="css3_responsive_width css3_responsive_width3">
								<label class="css3_responsive_width css3_responsive_width3"><?php _e('responsive width', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width3" type="text" name="responsiveWidths[]" value="" />
							</div>
							<label><?php _e('aligment (optional):', 'css3_grid'); ?></label>
							<select name="aligments[]">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<option value="left"><?php _e('left', 'css3_grid'); ?></option>
								<option value="center"><?php _e('center', 'css3_grid'); ?></option>
								<option value="right"><?php _e('right', 'css3_grid'); ?></option>
							</select>
							<br class="css3_active_column_br" />
							<label class="css3_active_column_label"><?php _e('active (optional):', 'css3_grid'); ?></label>
							<select name="actives[]" class="css3_active_column_select">
								<option value="-1"><?php _e('no', 'css3_grid'); ?></option>
								<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
							</select>
							<br />
							<label><?php _e('disable/hidden (optional):', 'css3_grid'); ?></label>
							<select name="hiddens[]">
								<option value="-1"><?php _e('no', 'css3_grid'); ?></option>
								<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
							</select>
							<br />
							<label><?php _e('ribbon (optional):', 'css3_grid'); ?></label>
							<select name="ribbons[]">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<optgroup label="Style 1">
									<option value="style1_best"><?php _e('best', 'css3_grid'); ?></option>
									<option value="style1_buy"><?php _e('buy', 'css3_grid'); ?></option>
									<option value="style1_free"><?php _e('free', 'css3_grid'); ?></option>
									<option value="style1_free_caps"><?php _e('free (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_fresh"><?php _e('fresh', 'css3_grid'); ?></option>
									<option value="style1_gift_caps"><?php _e('gift (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_heart"><?php _e('heart', 'css3_grid'); ?></option>
									<option value="style1_hot"><?php _e('hot', 'css3_grid'); ?></option>
									<option value="style1_hot_caps"><?php _e('hot (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_new"><?php _e('new', 'css3_grid'); ?></option>
									<option value="style1_new_caps"><?php _e('new (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_no1"><?php _e('no. 1', 'css3_grid'); ?></option>
									<option value="style1_off5"><?php _e('5% off', 'css3_grid'); ?></option>
									<option value="style1_off10"><?php _e('10% off', 'css3_grid'); ?></option>
									<option value="style1_off15"><?php _e('15% off', 'css3_grid'); ?></option>
									<option value="style1_off20"><?php _e('20% off', 'css3_grid'); ?></option>
									<option value="style1_off25"><?php _e('25% off', 'css3_grid'); ?></option>
									<option value="style1_off30"><?php _e('30% off', 'css3_grid'); ?></option>
									<option value="style1_off35"><?php _e('35% off', 'css3_grid'); ?></option>
									<option value="style1_off40"><?php _e('40% off', 'css3_grid'); ?></option>
									<option value="style1_off50"><?php _e('50% off', 'css3_grid'); ?></option>
									<option value="style1_off75"><?php _e('75% off', 'css3_grid'); ?></option>
									<option value="style1_pack"><?php _e('pack', 'css3_grid'); ?></option>
									<option value="style1_pro"><?php _e('pro', 'css3_grid'); ?></option>
									<option value="style1_sale"><?php _e('sale', 'css3_grid'); ?></option>
									<option value="style1_save"><?php _e('save', 'css3_grid'); ?></option>
									<option value="style1_save_caps"><?php _e('save (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_top"><?php _e('top', 'css3_grid'); ?></option>
									<option value="style1_top_caps"><?php _e('top (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_trial"><?php _e('trial', 'css3_grid'); ?></option>
								</optgroup>
								<optgroup label="Style 2">
									<option value="style2_best"><?php _e('best', 'css3_grid'); ?></option>
									<option value="style2_buy"><?php _e('buy', 'css3_grid'); ?></option>
									<option value="style2_free"><?php _e('free', 'css3_grid'); ?></option>
									<option value="style2_free_caps"><?php _e('free (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_fresh"><?php _e('fresh', 'css3_grid'); ?></option>
									<option value="style2_gift_caps"><?php _e('gift (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_heart"><?php _e('heart', 'css3_grid'); ?></option>
									<option value="style2_hot"><?php _e('hot', 'css3_grid'); ?></option>
									<option value="style2_hot_caps"><?php _e('hot (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_new"><?php _e('new', 'css3_grid'); ?></option>
									<option value="style2_new_caps"><?php _e('new (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_no1"><?php _e('no. 1', 'css3_grid'); ?></option>
									<option value="style2_off5"><?php _e('5% off', 'css3_grid'); ?></option>
									<option value="style2_off10"><?php _e('10% off', 'css3_grid'); ?></option>
									<option value="style2_off15"><?php _e('15% off', 'css3_grid'); ?></option>
									<option value="style2_off20"><?php _e('20% off', 'css3_grid'); ?></option>
									<option value="style2_off25"><?php _e('25% off', 'css3_grid'); ?></option>
									<option value="style2_off30"><?php _e('30% off', 'css3_grid'); ?></option>
									<option value="style2_off35"><?php _e('35% off', 'css3_grid'); ?></option>
									<option value="style2_off40"><?php _e('40% off', 'css3_grid'); ?></option>
									<option value="style2_off50"><?php _e('50% off', 'css3_grid'); ?></option>
									<option value="style2_off75"><?php _e('75% off', 'css3_grid'); ?></option>
									<option value="style2_pack"><?php _e('pack', 'css3_grid'); ?></option>
									<option value="style2_pro"><?php _e('pro', 'css3_grid'); ?></option>
									<option value="style2_sale"><?php _e('sale', 'css3_grid'); ?></option>
									<option value="style2_save"><?php _e('save', 'css3_grid'); ?></option>
									<option value="style2_save_caps"><?php _e('save (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_top"><?php _e('top', 'css3_grid'); ?></option>
									<option value="style2_top_caps"><?php _e('top (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_trial"><?php _e('trial', 'css3_grid'); ?></option>
								</optgroup>
							</select>
						</th>
						<th class="css3_grid_admin_column4">
							<div class="css3_grid_sort_column css3_clearfix">
								<div class="css3_grid_arrows">
									<a href="#" class="css3_grid_sort_left" title="<?php _e('left', 'css3_grid'); ?>"></a>
									<a href="#" class="css3_grid_sort_right" title="<?php _e('right', 'css3_grid'); ?>"></a>
								</div>
							</div>
							<?php _e('Column', 'css3_grid'); ?> 3
							<br />
							<label><?php _e('width (optional):', 'css3_grid'); ?></label><input type="text" name="widths[]" value="" />
							<div class="css3_responsive_width_container">
								<label class="css3_responsive_width css3_responsive_width1"><?php _e('responsive width', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width1" type="text" name="responsiveWidths[]" value="" />
								<br class="css3_responsive_width css3_responsive_width2">
								<label class="css3_responsive_width css3_responsive_width2"><?php _e('responsive width', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width2" type="text" name="responsiveWidths[]" value="" />
								<br class="css3_responsive_width css3_responsive_width3">
								<label class="css3_responsive_width css3_responsive_width3"><?php _e('responsive width', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label><input class="css3_responsive_width css3_responsive_width3" type="text" name="responsiveWidths[]" value="" />
							</div>
							<label><?php _e('aligment (optional):', 'css3_grid'); ?></label>
							<select name="aligments[]">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<option value="left"><?php _e('left', 'css3_grid'); ?></option>
								<option value="center"><?php _e('center', 'css3_grid'); ?></option>
								<option value="right"><?php _e('right', 'css3_grid'); ?></option>
							</select>
							<br class="css3_active_column_br" />
							<label class="css3_active_column_label"><?php _e('active (optional):', 'css3_grid'); ?></label>
							<select name="actives[]" class="css3_active_column_select">
								<option value="-1"><?php _e('no', 'css3_grid'); ?></option>
								<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
							</select>
							<br />
							<label><?php _e('disable/hidden (optional):', 'css3_grid'); ?></label>
							<select name="hiddens[]">
								<option value="-1"><?php _e('no', 'css3_grid'); ?></option>
								<option value="1"><?php _e('yes', 'css3_grid'); ?></option>
							</select>
							<br />
							<label><?php _e('ribbon (optional):', 'css3_grid'); ?></label>
							<select name="ribbons[]">
								<option value="-1"><?php _e('choose...', 'css3_grid'); ?></option>
								<optgroup label="Style 1">
									<option value="style1_best"><?php _e('best', 'css3_grid'); ?></option>
									<option value="style1_buy"><?php _e('buy', 'css3_grid'); ?></option>
									<option value="style1_free"><?php _e('free', 'css3_grid'); ?></option>
									<option value="style1_free_caps"><?php _e('free (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_fresh"><?php _e('fresh', 'css3_grid'); ?></option>
									<option value="style1_gift_caps"><?php _e('gift (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_heart"><?php _e('heart', 'css3_grid'); ?></option>
									<option value="style1_hot"><?php _e('hot', 'css3_grid'); ?></option>
									<option value="style1_hot_caps"><?php _e('hot (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_new"><?php _e('new', 'css3_grid'); ?></option>
									<option value="style1_new_caps"><?php _e('new (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_no1"><?php _e('no. 1', 'css3_grid'); ?></option>
									<option value="style1_off5"><?php _e('5% off', 'css3_grid'); ?></option>
									<option value="style1_off10"><?php _e('10% off', 'css3_grid'); ?></option>
									<option value="style1_off15"><?php _e('15% off', 'css3_grid'); ?></option>
									<option value="style1_off20"><?php _e('20% off', 'css3_grid'); ?></option>
									<option value="style1_off25"><?php _e('25% off', 'css3_grid'); ?></option>
									<option value="style1_off30"><?php _e('30% off', 'css3_grid'); ?></option>
									<option value="style1_off35"><?php _e('35% off', 'css3_grid'); ?></option>
									<option value="style1_off40"><?php _e('40% off', 'css3_grid'); ?></option>
									<option value="style1_off50"><?php _e('50% off', 'css3_grid'); ?></option>
									<option value="style1_off75"><?php _e('75% off', 'css3_grid'); ?></option>
									<option value="style1_pack"><?php _e('pack', 'css3_grid'); ?></option>
									<option value="style1_pro"><?php _e('pro', 'css3_grid'); ?></option>
									<option value="style1_sale"><?php _e('sale', 'css3_grid'); ?></option>
									<option value="style1_save"><?php _e('save', 'css3_grid'); ?></option>
									<option value="style1_save_caps"><?php _e('save (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_top"><?php _e('top', 'css3_grid'); ?></option>
									<option value="style1_top_caps"><?php _e('top (uppercase)', 'css3_grid'); ?></option>
									<option value="style1_trial"><?php _e('trial', 'css3_grid'); ?></option>
								</optgroup>
								<optgroup label="Style 2">
									<option value="style2_best"><?php _e('best', 'css3_grid'); ?></option>
									<option value="style2_buy"><?php _e('buy', 'css3_grid'); ?></option>
									<option value="style2_free"><?php _e('free', 'css3_grid'); ?></option>
									<option value="style2_free_caps"><?php _e('free (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_fresh"><?php _e('fresh', 'css3_grid'); ?></option>
									<option value="style2_gift_caps"><?php _e('gift (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_heart"><?php _e('heart', 'css3_grid'); ?></option>
									<option value="style2_hot"><?php _e('hot', 'css3_grid'); ?></option>
									<option value="style2_hot_caps"><?php _e('hot (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_new"><?php _e('new', 'css3_grid'); ?></option>
									<option value="style2_new_caps"><?php _e('new (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_no1"><?php _e('no. 1', 'css3_grid'); ?></option>
									<option value="style2_off5"><?php _e('5% off', 'css3_grid'); ?></option>
									<option value="style2_off10"><?php _e('10% off', 'css3_grid'); ?></option>
									<option value="style2_off15"><?php _e('15% off', 'css3_grid'); ?></option>
									<option value="style2_off20"><?php _e('20% off', 'css3_grid'); ?></option>
									<option value="style2_off25"><?php _e('25% off', 'css3_grid'); ?></option>
									<option value="style2_off30"><?php _e('30% off', 'css3_grid'); ?></option>
									<option value="style2_off35"><?php _e('35% off', 'css3_grid'); ?></option>
									<option value="style2_off40"><?php _e('40% off', 'css3_grid'); ?></option>
									<option value="style2_off50"><?php _e('50% off', 'css3_grid'); ?></option>
									<option value="style2_off75"><?php _e('75% off', 'css3_grid'); ?></option>
									<option value="style2_pack"><?php _e('pack', 'css3_grid'); ?></option>
									<option value="style2_pro"><?php _e('pro', 'css3_grid'); ?></option>
									<option value="style2_sale"><?php _e('sale', 'css3_grid'); ?></option>
									<option value="style2_save"><?php _e('save', 'css3_grid'); ?></option>
									<option value="style2_save_caps"><?php _e('save (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_top"><?php _e('top', 'css3_grid'); ?></option>
									<option value="style2_top_caps"><?php _e('top (uppercase)', 'css3_grid'); ?></option>
									<option value="style2_trial"><?php _e('trial', 'css3_grid'); ?></option>
								</optgroup>
							</select>
						</th>
					</tr>
				</thead>
				<tbody>
				<tr class="css3_grid_admin_row1">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="&lt;h2 class='col1'&gt;starter&lt;/h2&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="&lt;h2 class='col2'&gt;econo&lt;/h2&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row2">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="&lt;h2 class='caption'&gt;choose &lt;span&gt;your&lt;/span&gt; plan&lt;/h2&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="&lt;h1 class='col1'&gt;$&lt;span&gt;10&lt;/span&gt;&lt;/h1&gt;&lt;h3 class='col1'&gt;per month&lt;/h3&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="&lt;h1 class='col1'&gt;$&lt;span&gt;30&lt;/span&gt;&lt;/h1&gt;&lt;h3 class='col1'&gt;per month&lt;/h3&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row3">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="Amount of space" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="10GB" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="30GB" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row4">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="Bandwidth per month" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="100GB" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="200GB" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row5">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="No. of e-mail accounts" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="1" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="10" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row6">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="No. of MySql databases" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="1" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="10" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row7">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="24h support" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="Yes" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="Yes" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row8">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="Support tickets per mo." />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="1" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="3" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				<tr class="css3_grid_admin_row9">
					<td class="css3_grid_admin_column1">
						<div class="css3_grid_arrows_row">
							<a href="#" class="css3_grid_sort_up" title="<?php _e('up', 'css3_grid'); ?>"></a>
							<a href="#" class="css3_grid_sort_down" title="<?php _e('down', 'css3_grid'); ?>"></a>
						</div>
						<div class="css3_grid_row_config">
							<input class="css3_grid_short" type="text" name="heights[]" value="" /><label><?php _e('height (optional in px)', 'css3_grid'); ?></label>
							<div class="css3_responsive_height_container">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height1" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height1"><?php _e('responsive height', 'css3_grid'); ?> 1 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height2">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height2" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height2"><?php _e('responsive height', 'css3_grid'); ?> 2 <?php _e('(optional)', 'css3_grid'); ?></label>
								<br class="css3_responsive_height css3_responsive_height3">
								<input class="css3_grid_short css3_responsive_height css3_responsive_height3" type="text" name="responsiveHeights[]" value="" /><label class="css3_responsive_height css3_responsive_height3"><?php _e('responsive height', 'css3_grid'); ?> 3 <?php _e('(optional)', 'css3_grid'); ?></label>
							</div>
							<input class="css3_grid_short" type="text" name="paddingsTop[]" value="" /><label><?php _e('padding top (optional in px)', 'css3_grid'); ?></label><br>
							<input class="css3_grid_short" type="text" name="paddingsBottom[]" value="" /><label><?php _e('padding bottom (optional in px)', 'css3_grid'); ?></label>
						</div>
					</td>
					<td class="css3_grid_admin_column2">
						<input type="text" name="texts[]" value="" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column3">
						<input type="text" name="texts[]" value="&lt;a href='<?php echo get_site_url(); ?>?plan=1' class='sign_up radius3'&gt;sign up!&lt;/a&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
					<td class="css3_grid_admin_column4">
						<input type="text" name="texts[]" value="&lt;a href='<?php echo get_site_url(); ?>?plan=2' class='sign_up radius3'&gt;sign up!&lt;/a&gt;" />
						<?php echo $shortcodesSelect;?>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
			<p>
				<input type="button" id="preview" value="<?php _e('Preview', 'css3_grid'); ?>" class="button-primary" name="Preview">
				<input type="submit" id="save_css3_grid_1" value="<?php _e('Save Options', 'css3_grid'); ?>" class="button-primary" name="Submit">
				<span id="ajax_loader_save_1" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
			</p>
			<div id="previewContainer">
			<?php
			echo do_shortcode("[css3_grid_print]");
			?>
			</div>
			<p>
				<input type="hidden" name="action" value="save_css3_grid" />
				<input type="submit" id="save_css3_grid_2" value="<?php _e('Save Options', 'css3_grid'); ?>" class="button-primary" name="Submit">
				<span id="ajax_loader_save_2" style="display: none;"><img style="margin-bottom: -3px;" src="<?php echo esc_url(plugins_url('img/ajax-loader.gif', __FILE__));?>" /></span>
			</p>
		</form>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="css3_grid_settings_hidden">
			<input type='hidden' id='css3_grid_data_hidden' name='css3_grid_data'/>
			<input type="hidden" id='css3_grid_action_hidden' name="action" value="save_css3_grid"/>
		</form>
		<?php
		$message = "";
		if(isset($_POST["action"]) && $_POST["action"]=="save_css3_global_settings")
		{
			$css3_grid_global_options = array(
				'loadFiles' => $_POST['loadFiles']
			);
			update_option('css3_grid_global_settings', $css3_grid_global_options);
			$message .= "Settings saved!";
		}
		?>
		<br />
		<div class="wrap">
			<div class="icon32" id="icon-options-general"><br></div>
			<h2><?php _e('CSS3 Compare Pricing Tables global settings', 'css3_grid'); ?></h2>
		</div>
		<?php
		if($message!="")
		{
		?>
		<div class="<?php echo ($message!="" ? "updated" : "error"); ?> settings-error"> 
			<p style="line-height: 150%;font-weight: bold;">
				<?php echo ($message!="" ? $message : $error); ?>
			</p>
		</div>
		<?php
		}
		$css3_grid_global_options = (array)get_option('css3_grid_global_settings');
		?>
		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="css3_grid_global_settings">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">
							<label for="loadFiles"><?php _e('Load plugin files', 'css3_grid'); ?></label>
						</th>
						<td>
							<select name="loadFiles" id="loadFiles">
								<option value="always"<?php echo (isset($css3_grid_global_options['loadFiles']) && $css3_grid_global_options['loadFiles']=='always' ? ' selected="selected"' : ''); ?>><?php _e('on every page', 'css3_grid'); ?></option>
								<option value="when_used"<?php echo (isset($css3_grid_global_options['loadFiles']) && $css3_grid_global_options['loadFiles']=='when_used' ? ' selected="selected"' : ''); ?>><?php _e('only when used', 'css3_grid'); ?></option>
							</select>
							<span class="description"><?php _e('If you see unstyled table on your page when using \'only when used\' option, please set \'on every page\' as some themes may not be compatibile with \'only when used\' option', 'css3_grid'); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
			<p>
				<input type="hidden" name="action" value="save_css3_global_settings" />
				<input type="submit" id="save_css3_grid_global" value="<?php _e('Save Settings', 'css3_grid'); ?>" class="button-primary" name="Submit">
			</p>
		</form>
		<?php
	}
}

//activate plugin
function css3_grid_activate()
{
	$css3_grid_global_options = array('loadFiles' => 'when_used');
	add_option('css3_grid_global_settings', $css3_grid_global_options);
	
	$table_t1_s1 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '','kind' => '1','styleForTable1' => '1','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '2','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style7','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style2','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style1_best',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '47',  8 => '',  9 => '',  10 => '47',  11 => '',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '47',  20 => '',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_01.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/tick_01.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_01.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_01.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '10 accounts under one domain',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => 'Hight priority support!',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''),'pricingCycles' => '1', 'dropdownAlignment' => 'left', 'pricingCyclesSteps' => '3', 'pricingCycleTitle' =>  array (   0 => 'Weekly',   1 => 'Monthly',   2 => 'Annually', ), 'pricingCycleID' =>  array (   0 => 'weekly',   1 => 'monthly',   2 => 'annually', ), 'pricingCyclePriceColumn' =>  array (   0 =>    array (     0 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per week</h3>',     1 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per week</h3>',     2 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per week</h3>',     3 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per week</h3>',   ),   1 =>    array (     0 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">$<span>120</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>200</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>350</span></h1><h3 class="col1">per month</h3>',   ),   2 =>    array (     0 => '<h1 class="col1">$<span>300</span></h1><h3 class="col1">per annum</h3>',     1 => '<h1 class="col1">$<span>500</span></h1><h3 class="col1">per annum</h3>',     2 => '<h1 class="col1">$<span>800</span></h1><h3 class="col1">per annum</h3>',     3 => '<h1 class="col1">$<span>900</span></h1><h3 class="col1">per annum</h3>',   ), ), 'pricingCycleButtonURLColumn' =>  array (   0 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   1 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   2 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ), ));
	add_option("css3_grid_shortcode_settings_Table_t1_s1", $table_t1_s1);
	$table_t1_s2 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#css3_grid_Table_t1_s2_slider_container, .css3_grid_Table_t1_s2_pagination
{
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:767px)
{
	#css3_grid_Table_t1_s2_slider_container .css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	#css3_grid_Table_t1_s2_slider_container .css3_grid_arrow_area
	{
		padding: 0 0 0 5px;
	}
	#css3_grid_Table_t1_s2_slider_container .css3_grid_arrow_area:first-child
	{
		padding: 0 5px 0 0;
	}
}','kind' => '1','styleForTable1' => '2','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '1','visibleColumns' => '2','scrollColumns' => '','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style7','slidingPagination' => '1','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style2','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '1','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '',  1 => '107px',  2 => '',  3 => '',  4 => '95px',  5 => '87px',  6 => '',  7 => '95px',  8 => '87px',  9 => '',  10 => '95px',  11 => '87px',  12 => '',  13 => '95px',  14 => '87px',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => 'style2_heart',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '35',  8 => '47',  9 => '',  10 => '35',  11 => '47',  12 => '',  13 => '35',  14 => '47',  15 => '',  16 => '35',  17 => '47',  18 => '',  19 => '35',  20 => '47',  21 => '',  22 => '35',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_02.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_02.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_02.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_02.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s2", $table_t1_s2);
	$table_t1_s3 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s3
{
	width: 660px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:767px)
{
	#Table_t1_s3
	{
		width: 422px;
	}
	#Table_t1_s3 .pp_button
	{
		width: 92px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s3
	{
		width: 260px;
	}
	#Table_t1_s3 .pp_button
	{
		width: 65px;
	}
}','kind' => '1','styleForTable1' => '3','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '0','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '52','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '',  1 => '25%',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '25%',  8 => '',  9 => '',  10 => '25%',  11 => '',  12 => '',  13 => '25%',  14 => '',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => 'style1_off30',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '',  9 => '',  10 => '34',  11 => '',  12 => '',  13 => '34',  14 => '',  15 => '',  16 => '34',  17 => '',  18 => '',  19 => '34',  20 => '',  21 => '',  22 => '46',  23 => '',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_03.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_03.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_03.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_03.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input name="cmd" value="_xclick" type="hidden"> <input name="business" value="me@mybusiness.com" type="hidden"> <input name="currency_code" value="USD" type="hidden"> <input name="item_name" value="Teddy bear" type="hidden"> <input name="amount" value="12.99" type="hidden"> <input class="pp_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" name="submit" alt="Make payments with paypal" border="0" type="image"> </form>',  42 => '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input name="cmd" value="_xclick" type="hidden"> <input name="business" value="me@mybusiness.com" type="hidden"> <input name="currency_code" value="USD" type="hidden"> <input name="item_name" value="Teddy bear" type="hidden"> <input name="amount" value="12.99" type="hidden"> <input class="pp_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" name="submit" alt="Make payments with paypal" border="0" type="image"> </form>',  43 => '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input name="cmd" value="_xclick" type="hidden"> <input name="business" value="me@mybusiness.com" type="hidden"> <input name="currency_code" value="USD" type="hidden"> <input name="item_name" value="Teddy bear" type="hidden"> <input name="amount" value="12.99" type="hidden"> <input class="pp_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" name="submit" alt="Make payments with paypal" border="0" type="image"> </form>',  44 => '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input name="cmd" value="_xclick" type="hidden"> <input name="business" value="me@mybusiness.com" type="hidden"> <input name="currency_code" value="USD" type="hidden"> <input name="item_name" value="Teddy bear" type="hidden"> <input name="amount" value="12.99" type="hidden"> <input class="pp_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" name="submit" alt="Make payments with paypal" border="0" type="image"> </form>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => 'Your tooltip text!',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => 'You can have unlimited bandwidth for $10 surcharge!',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => 'Support only in standard and professional plans!',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',44 => ''), 'pricingCycles' => '1', 'dropdownAlignment' => 'left', 'pricingCyclesSteps' => '4', 'pricingCycleTitle' =>  array (   0 => 'Shared Hosting',   1 => 'Cloud VPS',   2 => 'Dedicated Server',   3 => 'Reseller Hosting', ), 'pricingCycleID' =>  array (   0 => 'shared-hosting',   1 => 'cloud-vps',   2 => 'dedicated-server',   3 => 'reseller-hosting', ), 'pricingCyclePriceColumn' =>  array (   0 =>    array (     0 => '',     1 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',   ),   1 =>    array (     0 => '',     1 => '<h1 class="col1">$<span>45</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>79</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>119</span></h1><h3 class="col1">per month</h3>',   ),   2 =>    array (     0 => '',     1 => '<h1 class="col1">$<span>60</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>149</span></h1><h3 class="col1">per month</h3>',   ),   3 =>    array (     0 => '',     1 => '<h1 class="col1">$<span>69</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>129</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>179</span></h1><h3 class="col1">per month</h3>',   ), ), 'pricingCycleButtonURLColumn' =>  array (   0 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   1 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   2 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   3 =>    array (     0 => '',     1 => '',     2 => '',     3 => '' ) ));
	add_option("css3_grid_shortcode_settings_Table_t1_s3", $table_t1_s3);
	$table_t1_s4 = array('columns' => '5','rows' => '9','hiddenRows' => '3','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s4
{
	width: 820px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t1_s4
	{
		width: 710px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s4
	{
		width: 422px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s4
	{
		width: 260px;
	}
}','kind' => '1','styleForTable1' => '4','styleForTable2' => '1','hoverTypeForTable1' => 'light','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '34',  11 => '47',  12 => '34',  13 => '54',  14 => '60',  15 => '34',  16 => '54',  17 => '60',  18 => '',  19 => '34',  20 => '47',  21 => '34',  22 => '54',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_04.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_04.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_04.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_04.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => 'Cool price!',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''), 'pricingCycles' => '1', 'dropdownAlignment' => 'left', 'pricingCyclesSteps' => '3', 'pricingCycleTitle' =>  array (   0 => 'US Dollars (USD)',   1 => 'Euro (EUR)',   2 => 'Pounds (GPB)', ), 'pricingCycleID' =>  array (   0 => 'us-dollars',   1 => 'euro-eur',   2 => 'pounds-gpb', ), 'pricingCyclePriceColumn' =>  array (   0 =>    array (     0 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',   ),   1 =>    array (     0 => '<h1 class="col1">€<span>10</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">€<span>30</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">€<span>50</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">€<span>90</span></h1><h3 class="col1">per month</h3>',   ),   2 =>    array (     0 => '<h1 class="col1">£<span>7</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">£<span>20</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">£<span>35</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">£<span>75</span></h1><h3 class="col1">per month</h3>',   ), ), 'pricingCycleButtonURLColumn' =>  array (   0 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   1 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   2 =>    array (     0 => '',     1 => '',     2 => '',     3 => '')));
	add_option("css3_grid_shortcode_settings_Table_t1_s4", $table_t1_s4);
	$table_t1_s5 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s5
{
	width: 835px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t1_s5
	{
		width: 710px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s5
	{
		width: 422px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s5
	{
		width: 260px;
	}
	#Table_t1_s5 li.row_style_1 span, #Table_t1_s5 li.row_style_2 span, #Table_t1_s5 li.row_style_3 span, #Table_t1_s5 li.row_style_4 span
	{
		padding: 0 !important;
	}
}','kind' => '1','styleForTable1' => '5','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '100',  1 => '60',  2 => '52',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '170',  1 => '125',  2 => '150',  3 => '180',  4 => '210',),'responsiveWidths' => array (  0 => '146',  1 => '88',  2 => '',  3 => '106',  4 => '63',  5 => '54',  6 => '127',  7 => '75',  8 => '62',  9 => '153',  10 => '90',  11 => '66',  12 => '178',  13 => '106',  14 => '78',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style2_new',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '34',  11 => '47',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '',  20 => '47',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_05.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_05.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_05.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_05.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s5", $table_t1_s5);
	$table_t1_s6 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#css3_grid_Table_t1_s6_slider_container
{
	margin-left: auto;
	margin-right: auto;
}','kind' => '1','styleForTable1' => '6','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '1','visibleColumns' => '2','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style7','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style2','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '20','slidingAutoplay' => '1','slidingEffect' => 'crossfade','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '',  1 => '146',  2 => '',  3 => '',  4 => '130',  5 => '',  6 => '',  7 => '130',  8 => '',  9 => '',  10 => '130',  11 => '',  12 => '',  13 => '130',  14 => '',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '60',  12 => '',  13 => '34',  14 => '60',  15 => '',  16 => '34',  17 => '60',  18 => '',  19 => '',  20 => '34',  21 => '',  22 => '34',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_06.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_06.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_06.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_06.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',));
	add_option("css3_grid_shortcode_settings_Table_t1_s6", $table_t1_s6);
	$table_t1_s7 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s7
{
	width: 820px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t1_s7
	{
		width: 710px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s7
	{
		width: 422px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s7
	{
		width: 260px;
	}
}','kind' => '1','styleForTable1' => '7','styleForTable2' => '1','hoverTypeForTable1' => 'disabled','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_top_caps',),'heights' => array (  0 => '',  1 => '200',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '178',  4 => '105',  5 => '81',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '34',  11 => '47',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '34',  20 => '47',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '0',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '0',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/011.jpg" style="width:100%;height:auto;">',  7 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/021.jpg" style="width:100%;height:auto;">',  8 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/031.jpg" style="width:100%;height:auto;">',  9 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/041.jpg" style="width:100%;height:auto;">',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_07.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_07.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_07.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_07.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s7", $table_t1_s7);
	$table_t1_s8 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#css3_grid_Table_t1_s8_slider_container, .css3_grid_Table_t1_s8_pagination
{
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:767px)
{
	#css3_grid_Table_t1_s8_slider_container .css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	#css3_grid_Table_t1_s8_slider_container .css3_grid_arrow_area
	{
		padding: 0 0 0 5px;
	}
	#css3_grid_Table_t1_s8_slider_container .css3_grid_arrow_area:first-child
	{
		padding: 0 5px 0 0;
	}
}','kind' => '1','styleForTable1' => '8','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '0','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '90',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '26',),'responsivePriceFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '1','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style5','slidingPagination' => '1','slidingPaginationPosition' => 'both','slidingPaginationStyle' => 'style3','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '20','slidingAutoplay' => '0','slidingEffect' => 'cover','slidingEasing' => 'easeInOutExpo','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '',  1 => '170',  2 => '100px',  3 => '',  4 => '',  5 => '100px',  6 => '',  7 => '',  8 => '100px',  9 => '',  10 => '',  11 => '100px',  12 => '',  13 => '',  14 => '100px',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => 'style2_no1',  2 => '-1',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '34',  9 => '',  10 => '',  11 => '34',  12 => '',  13 => '',  14 => '34',  15 => '',  16 => '',  17 => '34',  18 => '',  19 => '',  20 => '34',  21 => '',  22 => '',  23 => '47',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_08.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_08.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_08.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_08.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s8", $table_t1_s8);
	$table_t1_s9 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s9
{
	width: 820px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t1_s9
	{
		width: 710px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s9
	{
		width: 422px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s9
	{
		width: 260px;
	}
}','kind' => '1','styleForTable1' => '9','styleForTable2' => '1','hoverTypeForTable1' => 'light','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '26',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '38',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Yanone Kaffeesatz:regular','priceFontSubset' => '','priceFontSize' => '42','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '25%',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_hot_caps',),'heights' => array (  0 => '200',  1 => '60',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '178',  1 => '105',  2 => '81',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '34',  11 => '47',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '34',  20 => '47',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '0',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '5',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/01.jpg" style="width:100%;height:auto;">',  2 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/02.jpg" style="width:100%;height:auto;">',  3 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/03.jpg" style="width:100%;height:auto;">',  4 => '<img src="https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/04.jpg" style="width:100%;height:auto;">',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1>',  7 => '<h1 class="col1">$<span>30</span></h1>',  8 => '<h1 class="col1">$<span>59</span></h1>',  9 => '<h1 class="col1">$<span>99</span></h1>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '100',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_11.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_11.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_11.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_11.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s9", $table_t1_s9);
	$table_t1_s10 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s10
{
	width: 820px;
	margin-left: auto;
	margin-right: auto;
}
#Table_t1_s10 div.column_1 li.header_row_2
{
	background-image: url("https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/01.jpg") !important;
}
#Table_t1_s10 div.column_2 li.header_row_2
{
	background-image: url("https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/02.jpg") !important;
}
#Table_t1_s10 div.column_3 li.header_row_2
{
	background-image: url("https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/03.jpg") !important;
}
#Table_t1_s10 div.column_4 li.header_row_2
{
	background-image: url("https://quanticalabs.com/wp_plugins/css3-responsive-web-pricing-tables-grids/files/2014/03/04.jpg") !important;
}
#Table_t1_s10 li.header_row_2 h1, #Table_t1_s10 li.header_row_2 h1 span, #Table_t1_s10 li.header_row_2 h3
{
	text-shadow: 0 2px 0 rgba(0, 0, 0, 0.5) !important;
}
@media screen and (max-width:1009px)
{
	#Table_t1_s10
	{
		width: 710px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s10
	{
		width: 422px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s10
	{
		width: 260px;
	}
}','kind' => '1','styleForTable1' => '10','styleForTable2' => '1','hoverTypeForTable1' => 'light','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style2_fresh',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '200',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '176',  4 => '105',  5 => '80',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '34',  11 => '47',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '34',  20 => '47',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '0',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '0',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_06.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_06.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_04.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_04.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''), 'pricingCycles' => '1', 'dropdownAlignment' => 'right', 'pricingCyclesSteps' => '3', 'pricingCycleTitle' =>  array (   0 => 'US resident',   1 => 'EU resident',   2 => 'Rest of the World', ), 'pricingCycleID' =>  array (   0 => 'us-resident',   1 => 'eu-resident',   2 => 'rest-of-the-world', ), 'pricingCyclePriceColumn' =>  array (   0 =>    array (     0 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',   ),   1 =>    array (     0 => '<h1 class="col1">$<span>12</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">$<span>32</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>61</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>101</span></h1><h3 class="col1">per month</h3>',   ),   2 =>    array (     0 => '<h1 class="col1">$<span>15</span></h1><h3 class="col1">per month</h3>',     1 => '<h1 class="col1">$<span>35</span></h1><h3 class="col1">per month</h3>',     2 => '<h1 class="col1">$<span>64</span></h1><h3 class="col1">per month</h3>',     3 => '<h1 class="col1">$<span>104</span></h1><h3 class="col1">per month</h3>',   ), ), 'pricingCycleButtonURLColumn' =>  array (   0 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   1 =>    array (     0 => '',     1 => '',     2 => '',     3 => '',   ),   2 =>    array (     0 => '',     1 => '',     2 => '',     3 => '')));
	add_option("css3_grid_shortcode_settings_Table_t1_s10", $table_t1_s10);
	$table_t1_s11 = array('columns' => '4','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '@media screen and (max-width:1009px)
{
	#Table_t1_s11 iframe
	{
		height: 100px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s11 iframe
	{
		height: 60px;
	}
}','kind' => '1','styleForTable1' => '11','styleForTable2' => '1','hoverTypeForTable1' => 'disabled','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '26',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Yanone Kaffeesatz:regular','priceFontSubset' => '','priceFontSize' => '42','headerFontCustom' => '','headerFont' => 'Yanone Kaffeesatz:regular','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '25%',  1 => '25%',  2 => '25%',  3 => '25%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '33.3%',  6 => '',  7 => '',  8 => '33.3%',  9 => '',  10 => '',  11 => '33.3%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style1_save_caps',  3 => '-1',),'heights' => array (  0 => '131',  1 => '60',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '100',  1 => '60',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '34',  11 => '47',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '34',  20 => '47',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '0',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '5',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<iframe src="//player.vimeo.com/video/56755711?color=F3BF34" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="131px" width="100%"></iframe>',  2 => '<iframe src="//player.vimeo.com/video/339113469?color=F19300" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="131px" width="100%"></iframe>',  3 => '<iframe src="//player.vimeo.com/video/182778904?color=E06400" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0" height="131px" width="100%"></iframe>',  4 => '<h2 class="caption">choose <span>your</span> plan</h2>',  5 => '<h1 class="col1">$<span>10</span></h1>',  6 => '<h1 class="col1">$<span>30</span></h1>',  7 => '<h1 class="col1">$<span>59</span></h1>',  8 => 'Amount of space',  9 => '10GB',  10 => '30GB',  11 => '100GB',  12 => 'Bandwidth per month',  13 => '100GB',  14 => '200GB',  15 => '500GB',  16 => 'No. of e-mail accounts',  17 => '1',  18 => '10',  19 => '50',  20 => 'No. of MySql databases',  21 => '1',  22 => '10',  23 => '50',  24 => '24h support',  25 => '<img src="' . plugins_url("img/cross_02.png", __FILE__) . '" alt="no">',  26 => '<img src="' . plugins_url("img/cross_02.png", __FILE__) . '" alt="no">',  27 => '<img src="' . plugins_url("img/tick_04.png", __FILE__) . '" alt="yes">',  28 => 'Support tickets per mo.',  29 => '1',  30 => '3',  31 => '5',  32 => '',  33 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  34 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  35 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s11", $table_t1_s11);
	$table_t1_s12 = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t1_s12
{
	width: 820px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t1_s12
	{
		width: 710px;
	}
}
@media screen and (max-width:767px)
{
	#Table_t1_s12
	{
		width: 422px;
	}
}
@media screen and (max-width:479px)
{
	#Table_t1_s12
	{
		width: 260px;
	}
}','kind' => '1','styleForTable1' => '12','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '72',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '21',  2 => '16',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '38',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style1_off25',  3 => 'style1_off30',  4 => 'style1_off40',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '47',  9 => '',  10 => '',  11 => '',  12 => '34',  13 => '47',  14 => '60',  15 => '34',  16 => '47',  17 => '60',  18 => '',  19 => '34',  20 => '47',  21 => '34',  22 => '47',  23 => '60',  24 => '',  25 => '',  26 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">starter</h2>',  2 => '<h2 class="col2">econo</h2>',  3 => '<h2 class="col1">standard</h2>',  4 => '<h2 class="col1">professional</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>99</span></h1><h3 class="col1">per month</h3>',  10 => 'Amount of space',  11 => '10GB',  12 => '30GB',  13 => '100GB',  14 => 'Unlimited',  15 => 'Bandwidth per month',  16 => '100GB',  17 => '200GB',  18 => '500GB',  19 => '1000GB',  20 => 'No. of e-mail accounts',  21 => '1',  22 => '10',  23 => '50',  24 => 'Unlimited',  25 => 'No. of MySql databases',  26 => '1',  27 => '10',  28 => '50',  29 => 'Unlimited',  30 => '24h support',  31 => '<img src="' . plugins_url("img/cross_07.png", __FILE__) . '" alt="no">',  32 => '<img src="' . plugins_url("img/cross_07.png", __FILE__) . '" alt="no">',  33 => '<img src="' . plugins_url("img/tick_07.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_07.png", __FILE__) . '" alt="yes">',  35 => 'Support tickets per mo.',  36 => '1',  37 => '3',  38 => '5',  39 => '10',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up radius3">sign up!</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up radius3">sign up!</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => ''));
	add_option("css3_grid_shortcode_settings_Table_t1_s12", $table_t1_s12);
	$table_t2_s1 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t2_s1
{
	width: 850px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t2_s1
	{
		width: 100%;
	}
}
@media screen and (max-width:479px)
{
	#Table_t2_s1.p_table_2.p_table_responsive li.row_style_1 .css3_grid_vertical_align &gt; span, #Table_t2_s1.p_table_2.p_table_responsive li.row_style_2 .css3_grid_vertical_align &gt; span, #Table_t2_s1.p_table_2.p_table_responsive li.row_style_3 .css3_grid_vertical_align &gt; span, #Table_t2_s1.p_table_2.p_table_responsive li.row_style_4 .css3_grid_vertical_align &gt; span
	{
		padding: 0 5px !important;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '80',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '28',  2 => '22',),'responsivePriceFontSize' => array (  0 => '',  1 => '31',  2 => '32',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => '','priceFontSubset' => '','priceFontSize' => '','headerFontCustom' => '','headerFont' => '','headerFontSubset' => '','headerFontSize' => '','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => '','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style1_gift_caps',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '60',  9 => '',  10 => '34',  11 => '60',  12 => '',  13 => '34',  14 => '60',  15 => '',  16 => '34',  17 => '60',  18 => '',  19 => '34',  20 => '60',  21 => '',  22 => '34',  23 => '60',  24 => '',  25 => '34',  26 => '60',  27 => '',  28 => '34',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes"> 2 domains',  39 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes"> 3 domains',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  49 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => 'Every additional database cost $3!',  27 => 'Every additional database cost $2!',  28 => 'Every additional database cost $1!',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',),'pricingCycles' =>'1', 'dropdownAlignment' =>'center', 'pricingCyclesSteps' =>'5', 'pricingCycleTitle' => array (   0 =>'Weekly',   1 =>'Monthly',   2 =>'Annually',   3 =>'Biennially',   4 =>'Triennially', ), 'pricingCycleID' => array (   0 =>'weekly-plan',   1 =>'monthly-plan',   2 =>'annually-plan',   3 =>'biennially-plan',   4 =>'triennially-plan', ), 'pricingCyclePriceColumn' => array (   0 =>   array (     0 =>'<h1>$3.95</h1><h3>per week</h3>',     1 =>'<h1>$5.95</h1><h3>per week</h3>',     2 =>'<h1>$7.95</h1><h3>per week</h3>',     3 =>'<h1>$9.95</h1><h3>per week</h3>',   ),   1 =>   array (     0 =>'<h1>$11.99</h1><h3>per month</h3>',     1 =>'<h1>$19.99</h1><h3>per month</h3>',     2 =>'<h1>$24.99</h1><h3>per month</h3>',     3 =>'<h1>$39.99</h1><h3>per month</h3>',   ),   2 =>   array (     0 =>'<h1>$99</h1><h3>per year</h3>',     1 =>'<h1>$199</h1><h3>per year</h3>',     2 =>'<h1>$299</h1><h3>per year</h3>',     3 =>'<h1>$399</h1><h3>per year</h3>',   ),   3 =>   array (     0 =>'<h1>$199</h1><h3>per biennium</h3>',     1 =>'<h1>$299</h1><h3>per biennium</h3>',     2 =>'<h1>$399</h1><h3>per biennium</h3>',     3 =>'<h1>$499</h1><h3>per biennium</h3>',   ),   4 =>   array (     0 =>'<h1>$299</h1><h3>per triennium</h3>',     1 =>'<h1>$399</h1><h3>per triennium</h3>',     2 =>'<h1>$499</h1><h3>per triennium</h3>',     3 =>'<h1>$599</h1><h3>per triennium</h3>',   ), ), 'pricingCycleButtonURLColumn' => array (   0 =>   array (     0 =>'',     1 =>'',     2 =>'',     3 =>'',   ),   1 =>   array (     0 =>'',     1 =>'',     2 =>'',     3 =>'',   ),   2 =>   array (     0 =>'',     1 =>'',     2 =>'',     3 =>'',   ),   3 =>   array (     0 =>'',     1 =>'',     2 =>'',     3 =>'',   ),   4 =>   array (     0 =>'',     1 =>'',     2 =>'',     3 =>'')));
	add_option("css3_grid_shortcode_settings_Table_t2_s1", $table_t2_s1);
	$table_t2_s2 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#css3_grid_Table_t2_s2_slider_container
{
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:767px)
{
	#css3_grid_Table_t2_s2_slider_container .css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	#css3_grid_Table_t2_s2_slider_container .css3_grid_arrow_area
	{
		padding: 0 0 0 5px;
	}
	#css3_grid_Table_t2_s2_slider_container .css3_grid_arrow_area:first-child
	{
		padding: 0 5px 0 0;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '2','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '100',  2 => '',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '24','slidingColumns' => '1','visibleColumns' => '2','scrollColumns' => '','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style3','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '',  1 => '120',  2 => '',  3 => '',  4 => '105',  5 => '102',  6 => '',  7 => '105',  8 => '102',  9 => '',  10 => '105',  11 => '102',  12 => '',  13 => '105',  14 => '102',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => 'style2_sale',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '70',  9 => '',  10 => '34',  11 => '70',  12 => '',  13 => '',  14 => '60',  15 => '',  16 => '34',  17 => '60',  18 => '',  19 => '',  20 => '47',  21 => '',  22 => '',  23 => '47',  24 => '',  25 => '34',  26 => '60',  27 => '',  28 => '',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_12.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes"> 2 domains',  39 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes"> 2 domains',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_12.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_12.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_12.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_12.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_12.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_12.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => ''));
	add_option("css3_grid_shortcode_settings_Table_t2_s2", $table_t2_s2);
	$table_t2_s3 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t2_s3
{
	width: 850px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t2_s3
	{
		width: 100%;
	}
}
@media screen and (max-width:479px)
{
	#Table_t2_s3.p_table_2.p_table_responsive li.row_style_1 .css3_grid_vertical_align &gt; span, #Table_t2_s3.p_table_2.p_table_responsive li.row_style_2 .css3_grid_vertical_align &gt; span, #Table_t2_s3.p_table_2.p_table_responsive li.row_style_3 .css3_grid_vertical_align &gt; span, #Table_t2_s3.p_table_2.p_table_responsive li.row_style_4 .css3_grid_vertical_align &gt; span
	{
		padding: 0 5px !important;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '3','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '80',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '21',),'responsivePriceFontSize' => array (  0 => '',  1 => '28',  2 => '32',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '22',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => 'style2_pack',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '60',  9 => '',  10 => '34',  11 => '60',  12 => '',  13 => '34',  14 => '60',  15 => '',  16 => '34',  17 => '60',  18 => '',  19 => '34',  20 => '60',  21 => '',  22 => '34',  23 => '60',  24 => '',  25 => '34',  26 => '60',  27 => '',  28 => '34',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_18.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes"> 2 domains',  39 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes"> 3 domains',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_18.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_18.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_18.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_18.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_18.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_18.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',));
	add_option("css3_grid_shortcode_settings_Table_t2_s3", $table_t2_s3);
	$table_t2_s4 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t2_s4
{
	width: 850px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t2_s4
	{
		width: 100%;
	}
}
@media screen and (max-width:479px)
{
	#Table_t2_s4.p_table_2.p_table_responsive li.row_style_1 .css3_grid_vertical_align &gt; span, #Table_t2_s4.p_table_2.p_table_responsive li.row_style_2 .css3_grid_vertical_align &gt; span, #Table_t2_s4.p_table_2.p_table_responsive li.row_style_3 .css3_grid_vertical_align &gt; span, #Table_t2_s4.p_table_2.p_table_responsive li.row_style_4 .css3_grid_vertical_align &gt; span
	{
		padding: 0 5px !important;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '4','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '80',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '21',),'responsivePriceFontSize' => array (  0 => '',  1 => '28',  2 => '32',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '22',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '60',  9 => '',  10 => '34',  11 => '60',  12 => '',  13 => '34',  14 => '60',  15 => '',  16 => '34',  17 => '60',  18 => '',  19 => '34',  20 => '60',  21 => '',  22 => '34',  23 => '60',  24 => '',  25 => '34',  26 => '60',  27 => '',  28 => '34',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes"> 2 domains',  39 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes"> 3 domains',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',));
	add_option("css3_grid_shortcode_settings_Table_t2_s4", $table_t2_s4);
	$table_t2_s5 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t2_s5
{
	width: 850px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t2_s5
	{
		width: 100%;
	}
}
@media screen and (max-width:479px)
{
	#Table_t2_s5.p_table_2.p_table_responsive li.row_style_1 .css3_grid_vertical_align &gt; span, #Table_t2_s5.p_table_2.p_table_responsive li.row_style_2 .css3_grid_vertical_align &gt; span, #Table_t2_s5.p_table_2.p_table_responsive li.row_style_3 .css3_grid_vertical_align &gt; span, #Table_t2_s5.p_table_2.p_table_responsive li.row_style_4 .css3_grid_vertical_align &gt; span
	{
		padding: 0 5px !important;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '5','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '80',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '21',),'responsivePriceFontSize' => array (  0 => '',  1 => '28',  2 => '32',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '22',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style2_new_caps',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '34',  8 => '60',  9 => '',  10 => '34',  11 => '60',  12 => '',  13 => '34',  14 => '60',  15 => '',  16 => '34',  17 => '60',  18 => '',  19 => '34',  20 => '60',  21 => '',  22 => '34',  23 => '60',  24 => '',  25 => '34',  26 => '60',  27 => '',  28 => '34',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes"> 2 domains',  39 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes"> 3 domains',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',));
	add_option("css3_grid_shortcode_settings_Table_t2_s5", $table_t2_s5);
	$table_t2_s6 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t2_s6
{
	width: 850px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t2_s6
	{
		width: 100%;
	}
}
@media screen and (max-width:479px)
{
	#Table_t2_s6.p_table_2.p_table_responsive li.row_style_1 .css3_grid_vertical_align &gt; span, #Table_t2_s6.p_table_2.p_table_responsive li.row_style_2 .css3_grid_vertical_align &gt; span, #Table_t2_s6.p_table_2.p_table_responsive li.row_style_3 .css3_grid_vertical_align &gt; span, #Table_t2_s6.p_table_2.p_table_responsive li.row_style_4 .css3_grid_vertical_align &gt; span
	{
		padding: 0 5px !important;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '6','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '80',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '21',),'responsivePriceFontSize' => array (  0 => '',  1 => '28',  2 => '32',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '22',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => 'style2_new_caps',  3 => '-1',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '37',  8 => '60',  9 => '',  10 => '37',  11 => '60',  12 => '',  13 => '37',  14 => '60',  15 => '',  16 => '37',  17 => '60',  18 => '',  19 => '37',  20 => '60',  21 => '',  22 => '37',  23 => '60',  24 => '',  25 => '37',  26 => '60',  27 => '',  28 => '37',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes"> 2 domains',  39 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes"> 3 domains',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_19.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_19.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',));
	add_option("css3_grid_shortcode_settings_Table_t2_s6", $table_t2_s6);
	$table_t2_s7 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#css3_grid_Table_t2_s7_slider_container,
.css3_grid_Table_t2_s7_pagination
{
	margin-left: auto;
	margin-right: auto;
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '7','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '0','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '1','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '1','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style3','slidingPagination' => '1','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style2','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '1','slidingEffect' => 'crossfade','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '132',  3 => '',  4 => '',  5 => '128',  6 => '',  7 => '',  8 => '128',  9 => '',  10 => '',  11 => '128',  12 => '',  13 => '',  14 => '128',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => 'style1_pro',  4 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_16.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  39 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_16.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_16.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_16.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_16.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_16.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_16.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',));	
	add_option("css3_grid_shortcode_settings_Table_t2_s7", $table_t2_s7);
	$table_t2_s8 = array('columns' => '5','rows' => '11','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => '#Table_t2_s8
{
	width: 850px;
	margin-left: auto;
	margin-right: auto;
}
@media screen and (max-width:1009px)
{
	#Table_t2_s8
	{
		width: 100%;
	}
}
@media screen and (max-width:479px)
{
	#Table_t2_s8.p_table_2.p_table_responsive li.row_style_1 .css3_grid_vertical_align &gt; span, #Table_t2_s8.p_table_2.p_table_responsive li.row_style_2 .css3_grid_vertical_align &gt; span, #Table_t2_s8.p_table_2.p_table_responsive li.row_style_3 .css3_grid_vertical_align &gt; span, #Table_t2_s8.p_table_2.p_table_responsive li.row_style_4 .css3_grid_vertical_align &gt; span
	{
		padding: 0 5px !important;
	}
}','kind' => '2','styleForTable1' => '1','styleForTable2' => '8','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '80',  2 => '60',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '',  2 => '21',),'responsivePriceFontSize' => array (  0 => '',  1 => '28',  2 => '32',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '11',),'responsiveContentFontSize' => array (  0 => '',  1 => '',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '',  2 => '22',),'priceFontCustom' => '','priceFont' => 'PT Sans Narrow:regular','priceFontSubset' => '','priceFontSize' => '44','headerFontCustom' => '','headerFont' => 'PT Sans Narrow:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => '','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => '','contentFontSubset' => '','contentFontSize' => '','buttonsFontCustom' => '','buttonsFont' => 'PT Sans Narrow:regular','buttonsFontSubset' => '','buttonsFontSize' => '','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',),'responsiveWidths' => array (  0 => '20%',  1 => '',  2 => '',  3 => '20%',  4 => '',  5 => '25%',  6 => '20%',  7 => '',  8 => '25%',  9 => '20%',  10 => '',  11 => '25%',  12 => '20%',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style2_heart',),'heights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '37',  8 => '60',  9 => '',  10 => '37',  11 => '60',  12 => '',  13 => '37',  14 => '60',  15 => '',  16 => '37',  17 => '60',  18 => '',  19 => '37',  20 => '60',  21 => '',  22 => '37',  23 => '60',  24 => '',  25 => '37',  26 => '60',  27 => '',  28 => '37',  29 => '60',  30 => '',  31 => '',  32 => '',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',),'texts' => array (  0 => '',  1 => '<h2>basic</h2>',  2 => '<h2>standard</h2>',  3 => '<h2>super</h2>',  4 => '<h2>ultimate</h2>',  5 => '<h1 class="caption">Hosting <span>Plans</span></h1>',  6 => '<h1>$3.95</h1><h3>per month</h3>',  7 => '<h1>$5.95</h1><h3>per month</h3>',  8 => '<h1>$7.95</h1><h3>per month</h3>',  9 => '<h1>$9.95</h1><h3>per month</h3>',  10 => 'Data Storage',  11 => '2GB Disk Space',  12 => '10GB Disk Space',  13 => '50GB Disk Space',  14 => 'Unlimited',  15 => 'Monthly Traffic',  16 => '10GB Bandwidth',  17 => '50GB Bandwidth',  18 => '100GB Bandwidth',  19 => 'Unlimited',  20 => 'Email Accounts',  21 => '5 Accounts',  22 => '10 Accounts',  23 => 'Unlimited',  24 => 'Unlimited',  25 => 'MySQL Databases',  26 => '2 Databases',  27 => '10 Databases',  28 => '20 Databases',  29 => 'Unlimited',  30 => 'Daily Backup',  31 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  32 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  33 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  34 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  35 => 'Free Domain',  36 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  37 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  38 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  39 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  40 => 'Website Statistics',  41 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  42 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  43 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  44 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  45 => 'Online Support',  46 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  47 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  48 => '<img src="' . plugins_url("img/cross_09.png", __FILE__) . '" alt="no">',  49 => '<img src="' . plugins_url("img/tick_09.png", __FILE__) . '" alt="yes">',  50 => '',  51 => '<a class="button_1 radius5" href="' . get_site_url() . '?plan=1">sign up</a>',  52 => '<a class="button_2 radius5" href="' . get_site_url() . '?plan=2">sign up</a>',  53 => '<a class="button_3 radius5" href="' . get_site_url() . '?plan=3">sign up</a>',  54 => '<a class="button_4 radius5" href="' . get_site_url() . '?plan=4">sign up</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => 'Every additonal 1GB of space cost $2!',  12 => 'Every additonal 1GB of space cost $2!',  13 => 'Every additonal 1GB of space cost $2!',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',));
	add_option("css3_grid_shortcode_settings_Table_t2_s8", $table_t2_s8);
	//medicenter style
	$medicenter_blue = array('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_blue.p_table_1 h1, div#medicenter_blue.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_blue.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}','kind' => '1','styleForTable1' => '13','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array ( 0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array ( 0 => '',  1 => '85',  2 => '64',),'responsiveHeaderFontSize' => array ( 0 => '18',  1 => '',  2 => '',),'responsivePriceFontSize' => array ( 0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '13',  1 => '12',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '13',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_pro',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '49',  8 => '55',  9 => '',  10 => '49',  11 => '66',  12 => '',  13 => '',  14 => '55',  15 => '',  16 => '',  17 => '55',  18 => '',  19 => '',  20 => '55',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '<h2 class="col1">Super Prestige</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  10 => 'Available Medical Specialties',  11 => '6 Specialties',  12 => '12 Specialties',  13 => '24 Specialties',  14 => '36 Specialties',  15 => 'Investigations and Treatments',  16 => '30 Tests and Treatments',  17 => '90 Tests and Treatments',  18 => '160 Tests and Treatments',  19 => '250 Tests and Treatments',  20 => 'Medical Consultation',  21 => '1 Time a Year',  22 => '2 Times a Year',  23 => '4 Times a Year',  24 => 'Unlimited',  25 => 'Home Visits',  26 => '1 Time a Year',  27 => '2 Times a Year',  28 => '4 Times a Year',  29 => 'Unlimited',  30 => 'Pregnancy Care',  31 => '<span class="css3_grid_icon icon_no_01"></span>',  32 => '<span class="css3_grid_icon icon_yes_01"></span>',  33 => '<span class="css3_grid_icon icon_yes_01"></span>',  34 => '<span class="css3_grid_icon icon_yes_01"></span>',  35 => 'Medical Assistance',  36 => '<span class="css3_grid_icon icon_no_01"></span>',  37 => '24h Assistance',  38 => '24h Assistance',  39 => '24h Assistance',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => 'Can be extended to 250 Tests',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array ( 0 => '',),'pricingCycleID' => array ( 0 => '',),'pricingCyclePriceColumn' => array ( 0 => array ( 0 => '',    1 => '',    2 => '',    3 => '',  ),),'pricingCycleButtonURLColumn' => array ( 0 => array ( 0 => '',    1 => '',    2 => '',    3 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_blue", $medicenter_blue);
	$medicenter_green = array ('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_green.p_table_1 h1, div#medicenter_green.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_green.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}','kind' => '1','styleForTable1' => '14','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '85',  2 => '64',),'responsiveHeaderFontSize' => array (  0 => '18',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '13',  1 => '12',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '13',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_pro',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '49',  8 => '55',  9 => '',  10 => '49',  11 => '66',  12 => '',  13 => '',  14 => '55',  15 => '',  16 => '',  17 => '55',  18 => '',  19 => '',  20 => '55',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '<h2 class="col1">Super Prestige</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  10 => 'Available Medical Specialties',  11 => '6 Specialties',  12 => '12 Specialties',  13 => '24 Specialties',  14 => '36 Specialties',  15 => 'Investigations and Treatments',  16 => '30 Tests and Treatments',  17 => '90 Tests and Treatments',  18 => '160 Tests and Treatments',  19 => '250 Tests and Treatments',  20 => 'Medical Consultation',  21 => '1 Time a Year',  22 => '2 Times a Year',  23 => '4 Times a Year',  24 => 'Unlimited',  25 => 'Home Visits',  26 => '1 Time a Year',  27 => '2 Times a Year',  28 => '4 Times a Year',  29 => 'Unlimited',  30 => 'Pregnancy Care',  31 => '<span class="css3_grid_icon icon_no_01"></span>',  32 => '<span class="css3_grid_icon icon_yes_01"></span>',  33 => '<span class="css3_grid_icon icon_yes_01"></span>',  34 => '<span class="css3_grid_icon icon_yes_01"></span>',  35 => 'Medical Assistance',  36 => '<span class="css3_grid_icon icon_no_01"></span>',  37 => '24h Assistance',  38 => '24h Assistance',  39 => '24h Assistance',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => 'Can be extended to 250 Tests',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_green", $medicenter_green);
	$medicenter_orange = array ('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_orange.p_table_1 h1, div#medicenter_orange.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_orange.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}','kind' => '1','styleForTable1' => '15','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '85',  2 => '64',),'responsiveHeaderFontSize' => array (  0 => '18',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '13',  1 => '12',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '13',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_pro',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '49',  8 => '55',  9 => '',  10 => '49',  11 => '66',  12 => '',  13 => '',  14 => '55',  15 => '',  16 => '',  17 => '55',  18 => '',  19 => '',  20 => '55',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '<h2 class="col1">Super Prestige</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  10 => 'Available Medical Specialties',  11 => '6 Specialties',  12 => '12 Specialties',  13 => '24 Specialties',  14 => '36 Specialties',  15 => 'Investigations and Treatments',  16 => '30 Tests and Treatments',  17 => '90 Tests and Treatments',  18 => '160 Tests and Treatments',  19 => '250 Tests and Treatments',  20 => 'Medical Consultation',  21 => '1 Time a Year',  22 => '2 Times a Year',  23 => '4 Times a Year',  24 => 'Unlimited',  25 => 'Home Visits',  26 => '1 Time a Year',  27 => '2 Times a Year',  28 => '4 Times a Year',  29 => 'Unlimited',  30 => 'Pregnancy Care',  31 => '<span class="css3_grid_icon icon_no_01"></span>',  32 => '<span class="css3_grid_icon icon_yes_01"></span>',  33 => '<span class="css3_grid_icon icon_yes_01"></span>',  34 => '<span class="css3_grid_icon icon_yes_01"></span>',  35 => 'Medical Assistance',  36 => '<span class="css3_grid_icon icon_no_01"></span>',  37 => '24h Assistance',  38 => '24h Assistance',  39 => '24h Assistance',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => 'Can be extended to 250 Tests',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_orange", $medicenter_orange);
	$medicenter_red = array ('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_red.p_table_1 h1, div#medicenter_red.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_red.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}','kind' => '1','styleForTable1' => '16','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '85',  2 => '64',),'responsiveHeaderFontSize' => array (  0 => '18',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '13',  1 => '12',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '13',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_pro',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '49',  8 => '55',  9 => '',  10 => '49',  11 => '66',  12 => '',  13 => '',  14 => '55',  15 => '',  16 => '',  17 => '55',  18 => '',  19 => '',  20 => '55',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '<h2 class="col1">Super Prestige</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  10 => 'Available Medical Specialties',  11 => '6 Specialties',  12 => '12 Specialties',  13 => '24 Specialties',  14 => '36 Specialties',  15 => 'Investigations and Treatments',  16 => '30 Tests and Treatments',  17 => '90 Tests and Treatments',  18 => '160 Tests and Treatments',  19 => '250 Tests and Treatments',  20 => 'Medical Consultation',  21 => '1 Time a Year',  22 => '2 Times a Year',  23 => '4 Times a Year',  24 => 'Unlimited',  25 => 'Home Visits',  26 => '1 Time a Year',  27 => '2 Times a Year',  28 => '4 Times a Year',  29 => 'Unlimited',  30 => 'Pregnancy Care',  31 => '<span class="css3_grid_icon icon_no_01"></span>',  32 => '<span class="css3_grid_icon icon_yes_01"></span>',  33 => '<span class="css3_grid_icon icon_yes_01"></span>',  34 => '<span class="css3_grid_icon icon_yes_01"></span>',  35 => 'Medical Assistance',  36 => '<span class="css3_grid_icon icon_no_01"></span>',  37 => '24h Assistance',  38 => '24h Assistance',  39 => '24h Assistance',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">Learn more</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => 'Can be extended to 250 Tests',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_red", $medicenter_red);
	$medicenter_turquoise = array ('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_turquoise.p_table_1 h1, div#medicenter_turquoise.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_turquoise.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}','kind' => '1','styleForTable1' => '17','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '85',  2 => '64',),'responsiveHeaderFontSize' => array (  0 => '18',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '13',  1 => '12',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '13',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_pro',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '49',  8 => '55',  9 => '',  10 => '49',  11 => '66',  12 => '',  13 => '',  14 => '55',  15 => '',  16 => '',  17 => '55',  18 => '',  19 => '',  20 => '55',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '<h2 class="col1">Super Prestige</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  10 => 'Available Medical Specialties',  11 => '6 Specialties',  12 => '12 Specialties',  13 => '24 Specialties',  14 => '36 Specialties',  15 => 'Investigations and Treatments',  16 => '30 Tests and Treatments',  17 => '90 Tests and Treatments',  18 => '160 Tests and Treatments',  19 => '250 Tests and Treatments',  20 => 'Medical Consultation',  21 => '1 Time a Year',  22 => '2 Times a Year',  23 => '4 Times a Year',  24 => 'Unlimited',  25 => 'Home Visits',  26 => '1 Time a Year',  27 => '2 Times a Year',  28 => '4 Times a Year',  29 => 'Unlimited',  30 => 'Pregnancy Care',  31 => '<span class="css3_grid_icon icon_no_01"></span>',  32 => '<span class="css3_grid_icon icon_yes_01"></span>',  33 => '<span class="css3_grid_icon icon_yes_01"></span>',  34 => '<span class="css3_grid_icon icon_yes_01"></span>',  35 => 'Medical Assistance',  36 => '<span class="css3_grid_icon icon_no_01"></span>',  37 => '24h Assistance',  38 => '24h Assistance',  39 => '24h Assistance',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => 'Can be extended to 250 Tests',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_turquoise", $medicenter_turquoise);
	$medicenter_violet = array ('columns' => '5','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_violet.p_table_1 h1, div#medicenter_violet.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_violet.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}','kind' => '1','styleForTable1' => '18','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '3','responsiveStepWidth' => array (  0 => '1009',  1 => '767',  2 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '85',  2 => '64',),'responsiveHeaderFontSize' => array (  0 => '18',  1 => '',  2 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',),'responsiveContentFontSize' => array (  0 => '13',  1 => '12',  2 => '10',),'responsiveButtonsFontSize' => array (  0 => '13',  1 => '',  2 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '0','visibleColumns' => '1','scrollColumns' => '','slidingNavigation' => '0','slidingNavigationArrows' => '0','slidingArrowsStyle' => 'style1','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '1','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '20%',  1 => '20%',  2 => '20%',  3 => '20%',  4 => '20%',),'responsiveWidths' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '25%',  6 => '',  7 => '',  8 => '25%',  9 => '',  10 => '',  11 => '25%',  12 => '',  13 => '',  14 => '25%',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => 'style1_pro',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '49',  8 => '55',  9 => '',  10 => '49',  11 => '66',  12 => '',  13 => '',  14 => '55',  15 => '',  16 => '',  17 => '55',  18 => '',  19 => '',  20 => '55',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '<h2 class="col1">Super Prestige</h2>',  5 => '<h2 class="caption">choose <span>your</span> plan</h2>',  6 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  7 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  8 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  9 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  10 => 'Available Medical Specialties',  11 => '6 Specialties',  12 => '12 Specialties',  13 => '24 Specialties',  14 => '36 Specialties',  15 => 'Investigations and Treatments',  16 => '30 Tests and Treatments',  17 => '90 Tests and Treatments',  18 => '160 Tests and Treatments',  19 => '250 Tests and Treatments',  20 => 'Medical Consultation',  21 => '1 Time a Year',  22 => '2 Times a Year',  23 => '4 Times a Year',  24 => 'Unlimited',  25 => 'Home Visits',  26 => '1 Time a Year',  27 => '2 Times a Year',  28 => '4 Times a Year',  29 => 'Unlimited',  30 => 'Pregnancy Care',  31 => '<span class="css3_grid_icon icon_no_01"></span>',  32 => '<span class="css3_grid_icon icon_yes_01"></span>',  33 => '<span class="css3_grid_icon icon_yes_01"></span>',  34 => '<span class="css3_grid_icon icon_yes_01"></span>',  35 => 'Medical Assistance',  36 => '<span class="css3_grid_icon icon_no_01"></span>',  37 => '24h Assistance',  38 => '24h Assistance',  39 => '24h Assistance',  40 => '',  41 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  42 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  43 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  44 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => 'Can be extended to 250 Tests',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => '',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_violet", $medicenter_violet);
	$medicenter_blue_sliding = array ('columns' => '8','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_blue_sliding.p_table_1 h1, div#medicenter_blue_sliding.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_blue_sliding.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}
@media screen and (max-width:767px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 5px;
	}
}','kind' => '1','styleForTable1' => '13','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '4','responsiveStepWidth' => array (  0 => '1249',  1 => '1009',  2 => '767',  3 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '85',  3 => '64',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '18',  2 => '',  3 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',  3 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',  3 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '13',  2 => '12',  3 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '13',  2 => '',  3 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '1','visibleColumns' => '3','scrollColumns' => '3','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style2','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '0','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '273',  1 => '273',  2 => '273',  3 => '273',  4 => '273',  5 => '273',  6 => '273',  7 => '273',),'responsiveWidths' => array (  0 => '213',  1 => '153',  2 => '91',  3 => '74',  4 => '213',  5 => '153',  6 => '91',  7 => '74',  8 => '213',  9 => '153',  10 => '91',  11 => '74',  12 => '213',  13 => '153',  14 => '91',  15 => '74',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '213',  21 => '153',  22 => '91',  23 => '74',  24 => '213',  25 => '153',  26 => '91',  27 => '74',  28 => '213',  29 => '153',  30 => '91',  31 => '74',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',  5 => '-1',  6 => '-1',  7 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => 'style1_pro',  6 => '-1',  7 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '49',  11 => '55',  12 => '',  13 => '',  14 => '49',  15 => '79',  16 => '',  17 => '',  18 => '',  19 => '55',  20 => '',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '',  27 => '55',  28 => '',  29 => '',  30 => '',  31 => '55',  32 => '',  33 => '',  34 => '',  35 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '',  5 => '<h2 class="col1">Super Prestige</h2>',  6 => '<h2 class="col1">Prestige Plus</h2>',  7 => '<h2 class="col1">Full Package</h2>',  8 => '<h2 class="caption">choose <span>your</span> plan</h2>',  9 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  10 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  11 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  12 => '',  13 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  14 => '<h1 class="col1">$<span>49</span></h1><h3 class="col1">per month</h3>',  15 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  16 => 'Available Medical Specialties',  17 => '6 Specialties',  18 => '12 Specialties',  19 => '24 Specialties',  20 => '',  21 => '36 Specialties',  22 => '36 Specialties',  23 => '50 Specialties',  24 => 'Investigations and Treatments',  25 => '30 Tests and Treatments',  26 => '90 Tests and Treatments',  27 => '160 Tests and Treatments',  28 => '',  29 => '250 Tests and Treatments',  30 => '300 Tests and Treatments',  31 => 'Unlimited Tests and Treatments',  32 => 'Medical Consultation',  33 => '1 Time a Year',  34 => '2 Times a Year',  35 => '4 Times a Year',  36 => '',  37 => 'Unlimited',  38 => 'Unlimited',  39 => 'Unlimited',  40 => 'Home Visits',  41 => '1 Time a Year',  42 => '2 Times a Year',  43 => '4 Times a Year',  44 => '',  45 => '6 Times a Year',  46 => 'Unlimited',  47 => 'Unlimited',  48 => 'Pregnancy Care',  49 => '<span class="css3_grid_icon icon_no_01"></span>',  50 => '<span class="css3_grid_icon icon_no_01"></span>',  51 => '<span class="css3_grid_icon icon_yes_01"></span>',  52 => '',  53 => '<span class="css3_grid_icon icon_yes_01"></span>',  54 => '<span class="css3_grid_icon icon_yes_01"></span>',  55 => '<span class="css3_grid_icon icon_yes_01"></span>',  56 => 'Medical Assistance',  57 => '<span class="css3_grid_icon icon_no_01"></span>',  58 => '24h Assistance',  59 => '24h Assistance',  60 => '',  61 => '24h Assistance',  62 => '24h Assistance',  63 => '24h Assistance',  64 => '',  65 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  66 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  67 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  68 => '',  69 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',  70 => '<a href="' . get_site_url() . '?plan=5" class="sign_up" radius3="">LEARN MORE</a>',  71 => '<a href="' . get_site_url() . '?plan=6" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => 'Can be extended to 250 Tests',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',  55 => '',  56 => '',  57 => '',  58 => '',  59 => '',  60 => '',  61 => '',  62 => '',  63 => '',  64 => '',  65 => '',  66 => '',  67 => '',  68 => '',  69 => '',  70 => '',  71 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_blue_sliding", $medicenter_blue_sliding);
	$medicenter_green_sliding = array ('columns' => '8','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_green_sliding.p_table_1 h1, div#medicenter_green_sliding.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_green_sliding.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}
@media screen and (max-width:767px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 5px;
	}
}','kind' => '1','styleForTable1' => '14','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '4','responsiveStepWidth' => array (  0 => '1249',  1 => '1009',  2 => '767',  3 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '85',  3 => '64',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '18',  2 => '',  3 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',  3 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',  3 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '13',  2 => '12',  3 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '13',  2 => '',  3 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '1','visibleColumns' => '3','scrollColumns' => '3','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style2','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '0','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '273',  1 => '273',  2 => '273',  3 => '273',  4 => '',  5 => '273',  6 => '273',  7 => '273',),'responsiveWidths' => array (  0 => '213',  1 => '153',  2 => '91',  3 => '74',  4 => '213',  5 => '153',  6 => '91',  7 => '74',  8 => '213',  9 => '153',  10 => '91',  11 => '74',  12 => '213',  13 => '153',  14 => '91',  15 => '74',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '213',  21 => '153',  22 => '91',  23 => '74',  24 => '213',  25 => '153',  26 => '91',  27 => '74',  28 => '213',  29 => '153',  30 => '91',  31 => '74',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',  5 => '-1',  6 => '-1',  7 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => 'style1_pro',  6 => '-1',  7 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '49',  11 => '55',  12 => '',  13 => '',  14 => '49',  15 => '79',  16 => '',  17 => '',  18 => '',  19 => '55',  20 => '',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '',  27 => '55',  28 => '',  29 => '',  30 => '',  31 => '55',  32 => '',  33 => '',  34 => '',  35 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '',  5 => '<h2 class="col1">Super Prestige</h2>',  6 => '<h2 class="col1">Prestige Plus</h2>',  7 => '<h2 class="col1">Full Package</h2>',  8 => '<h2 class="caption">choose <span>your</span> plan</h2>',  9 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  10 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  11 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  12 => '',  13 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  14 => '<h1 class="col1">$<span>49</span></h1><h3 class="col1">per month</h3>',  15 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  16 => 'Available Medical Specialties',  17 => '6 Specialties',  18 => '12 Specialties',  19 => '24 Specialties',  20 => '',  21 => '36 Specialties',  22 => '36 Specialties',  23 => '50 Specialties',  24 => 'Investigations and Treatments',  25 => '30 Tests and Treatments',  26 => '90 Tests and Treatments',  27 => '160 Tests and Treatments',  28 => '',  29 => '250 Tests and Treatments',  30 => '300 Tests and Treatments',  31 => 'Unlimited Tests and Treatments',  32 => 'Medical Consultation',  33 => '1 Time a Year',  34 => '2 Times a Year',  35 => '4 Times a Year',  36 => '',  37 => 'Unlimited',  38 => 'Unlimited',  39 => 'Unlimited',  40 => 'Home Visits',  41 => '1 Time a Year',  42 => '2 Times a Year',  43 => '4 Times a Year',  44 => '',  45 => '6 Times a Year',  46 => 'Unlimited',  47 => 'Unlimited',  48 => 'Pregnancy Care',  49 => '<span class="css3_grid_icon icon_no_01"></span>',  50 => '<span class="css3_grid_icon icon_no_01"></span>',  51 => '<span class="css3_grid_icon icon_yes_01"></span>',  52 => '',  53 => '<span class="css3_grid_icon icon_yes_01"></span>',  54 => '<span class="css3_grid_icon icon_yes_01"></span>',  55 => '<span class="css3_grid_icon icon_yes_01"></span>',  56 => 'Medical Assistance',  57 => '<span class="css3_grid_icon icon_no_01"></span>',  58 => '24h Assistance',  59 => '24h Assistance',  60 => '',  61 => '24h Assistance',  62 => '24h Assistance',  63 => '24h Assistance',  64 => '',  65 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  66 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  67 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  68 => '',  69 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',  70 => '<a href="' . get_site_url() . '?plan=5" class="sign_up" radius3="">LEARN MORE</a>',  71 => '<a href="' . get_site_url() . '?plan=6" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => 'Can be extended to 250 Tests',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',  55 => '',  56 => '',  57 => '',  58 => '',  59 => '',  60 => '',  61 => '',  62 => '',  63 => '',  64 => '',  65 => '',  66 => '',  67 => '',  68 => '',  69 => '',  70 => '',  71 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '')));	
	add_option("css3_grid_shortcode_settings_medicenter_green_sliding", $medicenter_green_sliding);
	$medicenter_orange_sliding = array ('columns' => '8','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_orange_sliding.p_table_1 h1, div#medicenter_orange_sliding.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_orange_sliding.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}
@media screen and (max-width:767px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 5px;
	}
}','kind' => '1','styleForTable1' => '15','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '4','responsiveStepWidth' => array (  0 => '1249',  1 => '1009',  2 => '767',  3 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '85',  3 => '64',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '18',  2 => '',  3 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',  3 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',  3 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '13',  2 => '12',  3 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '13',  2 => '',  3 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '1','visibleColumns' => '3','scrollColumns' => '3','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style2','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '0','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '273',  1 => '273',  2 => '273',  3 => '273',  4 => '',  5 => '273',  6 => '273',  7 => '273',),'responsiveWidths' => array (  0 => '213',  1 => '153',  2 => '91',  3 => '74',  4 => '213',  5 => '153',  6 => '91',  7 => '74',  8 => '213',  9 => '153',  10 => '91',  11 => '74',  12 => '213',  13 => '153',  14 => '91',  15 => '74',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '213',  21 => '153',  22 => '91',  23 => '74',  24 => '213',  25 => '153',  26 => '91',  27 => '74',  28 => '213',  29 => '153',  30 => '91',  31 => '74',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',  5 => '-1',  6 => '-1',  7 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => 'style1_pro',  6 => '-1',  7 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '49',  11 => '55',  12 => '',  13 => '',  14 => '49',  15 => '79',  16 => '',  17 => '',  18 => '',  19 => '55',  20 => '',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '',  27 => '55',  28 => '',  29 => '',  30 => '',  31 => '55',  32 => '',  33 => '',  34 => '',  35 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '',  5 => '<h2 class="col1">Super Prestige</h2>',  6 => '<h2 class="col1">Prestige Plus</h2>',  7 => '<h2 class="col1">Full Package</h2>',  8 => '<h2 class="caption">choose <span>your</span> plan</h2>',  9 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  10 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  11 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  12 => '',  13 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  14 => '<h1 class="col1">$<span>49</span></h1><h3 class="col1">per month</h3>',  15 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  16 => 'Available Medical Specialties',  17 => '6 Specialties',  18 => '12 Specialties',  19 => '24 Specialties',  20 => '',  21 => '36 Specialties',  22 => '36 Specialties',  23 => '50 Specialties',  24 => 'Investigations and Treatments',  25 => '30 Tests and Treatments',  26 => '90 Tests and Treatments',  27 => '160 Tests and Treatments',  28 => '',  29 => '250 Tests and Treatments',  30 => '300 Tests and Treatments',  31 => 'Unlimited Tests and Treatments',  32 => 'Medical Consultation',  33 => '1 Time a Year',  34 => '2 Times a Year',  35 => '4 Times a Year',  36 => '',  37 => 'Unlimited',  38 => 'Unlimited',  39 => 'Unlimited',  40 => 'Home Visits',  41 => '1 Time a Year',  42 => '2 Times a Year',  43 => '4 Times a Year',  44 => '',  45 => '6 Times a Year',  46 => 'Unlimited',  47 => 'Unlimited',  48 => 'Pregnancy Care',  49 => '<span class="css3_grid_icon icon_no_01"></span>',  50 => '<span class="css3_grid_icon icon_no_01"></span>',  51 => '<span class="css3_grid_icon icon_yes_01"></span>',  52 => '',  53 => '<span class="css3_grid_icon icon_yes_01"></span>',  54 => '<span class="css3_grid_icon icon_yes_01"></span>',  55 => '<span class="css3_grid_icon icon_yes_01"></span>',  56 => 'Medical Assistance',  57 => '<span class="css3_grid_icon icon_no_01"></span>',  58 => '24h Assistance',  59 => '24h Assistance',  60 => '',  61 => '24h Assistance',  62 => '24h Assistance',  63 => '24h Assistance',  64 => '',  65 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  66 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  67 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  68 => '',  69 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',  70 => '<a href="' . get_site_url() . '?plan=5" class="sign_up" radius3="">LEARN MORE</a>',  71 => '<a href="' . get_site_url() . '?plan=6" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => 'Can be extended to 250 Tests',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',  55 => '',  56 => '',  57 => '',  58 => '',  59 => '',  60 => '',  61 => '',  62 => '',  63 => '',  64 => '',  65 => '',  66 => '',  67 => '',  68 => '',  69 => '',  70 => '',  71 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '')));
	
	add_option("css3_grid_shortcode_settings_medicenter_orange_sliding", $medicenter_orange_sliding);
	$medicenter_red_sliding = array ('columns' => '8','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_red_sliding.p_table_1 h1, div#medicenter_red_sliding.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_red_sliding.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}
@media screen and (max-width:767px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 5px;
	}
}','kind' => '1','styleForTable1' => '16','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '4','responsiveStepWidth' => array (  0 => '1249',  1 => '1009',  2 => '767',  3 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '85',  3 => '64',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '18',  2 => '',  3 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',  3 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',  3 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '13',  2 => '12',  3 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '13',  2 => '',  3 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '1','visibleColumns' => '3','scrollColumns' => '3','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style2','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '0','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '273',  1 => '273',  2 => '273',  3 => '273',  4 => '',  5 => '273',  6 => '273',  7 => '273',),'responsiveWidths' => array (  0 => '213',  1 => '153',  2 => '91',  3 => '74',  4 => '213',  5 => '153',  6 => '91',  7 => '74',  8 => '213',  9 => '153',  10 => '91',  11 => '74',  12 => '213',  13 => '153',  14 => '91',  15 => '74',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '213',  21 => '153',  22 => '91',  23 => '74',  24 => '213',  25 => '153',  26 => '91',  27 => '74',  28 => '213',  29 => '153',  30 => '91',  31 => '74',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',  5 => '-1',  6 => '-1',  7 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => 'style1_pro',  6 => '-1',  7 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '49',  11 => '55',  12 => '',  13 => '',  14 => '49',  15 => '79',  16 => '',  17 => '',  18 => '',  19 => '55',  20 => '',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '',  27 => '55',  28 => '',  29 => '',  30 => '',  31 => '55',  32 => '',  33 => '',  34 => '',  35 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '',  5 => '<h2 class="col1">Super Prestige</h2>',  6 => '<h2 class="col1">Prestige Plus</h2>',  7 => '<h2 class="col1">Full Package</h2>',  8 => '<h2 class="caption">choose <span>your</span> plan</h2>',  9 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  10 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  11 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  12 => '',  13 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  14 => '<h1 class="col1">$<span>49</span></h1><h3 class="col1">per month</h3>',  15 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  16 => 'Available Medical Specialties',  17 => '6 Specialties',  18 => '12 Specialties',  19 => '24 Specialties',  20 => '',  21 => '36 Specialties',  22 => '36 Specialties',  23 => '50 Specialties',  24 => 'Investigations and Treatments',  25 => '30 Tests and Treatments',  26 => '90 Tests and Treatments',  27 => '160 Tests and Treatments',  28 => '',  29 => '250 Tests and Treatments',  30 => '300 Tests and Treatments',  31 => 'Unlimited Tests and Treatments',  32 => 'Medical Consultation',  33 => '1 Time a Year',  34 => '2 Times a Year',  35 => '4 Times a Year',  36 => '',  37 => 'Unlimited',  38 => 'Unlimited',  39 => 'Unlimited',  40 => 'Home Visits',  41 => '1 Time a Year',  42 => '2 Times a Year',  43 => '4 Times a Year',  44 => '',  45 => '6 Times a Year',  46 => 'Unlimited',  47 => 'Unlimited',  48 => 'Pregnancy Care',  49 => '<span class="css3_grid_icon icon_no_01"></span>',  50 => '<span class="css3_grid_icon icon_no_01"></span>',  51 => '<span class="css3_grid_icon icon_yes_01"></span>',  52 => '',  53 => '<span class="css3_grid_icon icon_yes_01"></span>',  54 => '<span class="css3_grid_icon icon_yes_01"></span>',  55 => '<span class="css3_grid_icon icon_yes_01"></span>',  56 => 'Medical Assistance',  57 => '<span class="css3_grid_icon icon_no_01"></span>',  58 => '24h Assistance',  59 => '24h Assistance',  60 => '',  61 => '24h Assistance',  62 => '24h Assistance',  63 => '24h Assistance',  64 => '',  65 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  66 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  67 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  68 => '',  69 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',  70 => '<a href="' . get_site_url() . '?plan=5" class="sign_up" radius3="">LEARN MORE</a>',  71 => '<a href="' . get_site_url() . '?plan=6" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => 'Can be extended to 250 Tests',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',  55 => '',  56 => '',  57 => '',  58 => '',  59 => '',  60 => '',  61 => '',  62 => '',  63 => '',  64 => '',  65 => '',  66 => '',  67 => '',  68 => '',  69 => '',  70 => '',  71 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_red_sliding", $medicenter_red_sliding);
	$medicenter_turquiose_sliding = array ('columns' => '8','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_turquiose_sliding.p_table_1 h1, div#medicenter_turquiose_sliding.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_turquiose_sliding.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}
@media screen and (max-width:767px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 5px;
	}
}','kind' => '1','styleForTable1' => '17','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '4','responsiveStepWidth' => array (  0 => '1249',  1 => '1009',  2 => '767',  3 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '85',  3 => '64',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '18',  2 => '',  3 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',  3 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',  3 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '13',  2 => '12',  3 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '13',  2 => '',  3 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '1','visibleColumns' => '3','scrollColumns' => '3','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style2','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '0','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '273',  1 => '273',  2 => '273',  3 => '273',  4 => '',  5 => '273',  6 => '273',  7 => '273',),'responsiveWidths' => array (  0 => '213',  1 => '153',  2 => '91',  3 => '74',  4 => '213',  5 => '153',  6 => '91',  7 => '74',  8 => '213',  9 => '153',  10 => '91',  11 => '74',  12 => '213',  13 => '153',  14 => '91',  15 => '74',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '213',  21 => '153',  22 => '91',  23 => '74',  24 => '213',  25 => '153',  26 => '91',  27 => '74',  28 => '213',  29 => '153',  30 => '91',  31 => '74',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',  5 => '-1',  6 => '-1',  7 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => 'style1_pro',  6 => '-1',  7 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '49',  11 => '55',  12 => '',  13 => '',  14 => '49',  15 => '79',  16 => '',  17 => '',  18 => '',  19 => '55',  20 => '',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '',  27 => '55',  28 => '',  29 => '',  30 => '',  31 => '55',  32 => '',  33 => '',  34 => '',  35 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '',  5 => '<h2 class="col1">Super Prestige</h2>',  6 => '<h2 class="col1">Prestige Plus</h2>',  7 => '<h2 class="col1">Full Package</h2>',  8 => '<h2 class="caption">choose <span>your</span> plan</h2>',  9 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  10 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  11 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  12 => '',  13 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  14 => '<h1 class="col1">$<span>49</span></h1><h3 class="col1">per month</h3>',  15 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  16 => 'Available Medical Specialties',  17 => '6 Specialties',  18 => '12 Specialties',  19 => '24 Specialties',  20 => '',  21 => '36 Specialties',  22 => '36 Specialties',  23 => '50 Specialties',  24 => 'Investigations and Treatments',  25 => '30 Tests and Treatments',  26 => '90 Tests and Treatments',  27 => '160 Tests and Treatments',  28 => '',  29 => '250 Tests and Treatments',  30 => '300 Tests and Treatments',  31 => 'Unlimited Tests and Treatments',  32 => 'Medical Consultation',  33 => '1 Time a Year',  34 => '2 Times a Year',  35 => '4 Times a Year',  36 => '',  37 => 'Unlimited',  38 => 'Unlimited',  39 => 'Unlimited',  40 => 'Home Visits',  41 => '1 Time a Year',  42 => '2 Times a Year',  43 => '4 Times a Year',  44 => '',  45 => '6 Times a Year',  46 => 'Unlimited',  47 => 'Unlimited',  48 => 'Pregnancy Care',  49 => '<span class="css3_grid_icon icon_no_01"></span>',  50 => '<span class="css3_grid_icon icon_no_01"></span>',  51 => '<span class="css3_grid_icon icon_yes_01"></span>',  52 => '',  53 => '<span class="css3_grid_icon icon_yes_01"></span>',  54 => '<span class="css3_grid_icon icon_yes_01"></span>',  55 => '<span class="css3_grid_icon icon_yes_01"></span>',  56 => 'Medical Assistance',  57 => '<span class="css3_grid_icon icon_no_01"></span>',  58 => '24h Assistance',  59 => '24h Assistance',  60 => '',  61 => '24h Assistance',  62 => '24h Assistance',  63 => '24h Assistance',  64 => '',  65 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  66 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  67 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  68 => '',  69 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',  70 => '<a href="' . get_site_url() . '?plan=5" class="sign_up" radius3="">LEARN MORE</a>',  71 => '<a href="' . get_site_url() . '?plan=6" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => 'Can be extended to 250 Tests',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',  55 => '',  56 => '',  57 => '',  58 => '',  59 => '',  60 => '',  61 => '',  62 => '',  63 => '',  64 => '',  65 => '',  66 => '',  67 => '',  68 => '',  69 => '',  70 => '',  71 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_turquiose_sliding", $medicenter_turquiose_sliding);
	$medicenter_violet_sliding = array ('columns' => '8','rows' => '9','hiddenRows' => '0','hiddenRowsButtonExpandText' => 'Click here to expand!','hiddenRowsButtonCollapseText' => 'Click here to collapse!','css3CustomCss' => 'div#medicenter_violet_sliding.p_table_1 h1, div#medicenter_violet_sliding.p_table_1 h1 span
{
font-weight: 300 !important;
}
div#medicenter_violet_sliding.p_table_1 a.sign_up
{
padding: 12px 0 !important;
height: auto !important;
}
@media screen and (max-width:767px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 10px;
	}
}
@media screen and (max-width:479px)
{
	div.css3_grid_arrow_area
	{
		padding: 0 5px;
	}
}','kind' => '1','styleForTable1' => '18','styleForTable2' => '1','hoverTypeForTable1' => 'active','hoverTypeForTable2' => 'active','responsive' => '1','responsiveHideCaptionColumn' => '1','responsiveSteps' => '4','responsiveStepWidth' => array (  0 => '1249',  1 => '1009',  2 => '767',  3 => '479',),'responsiveButtonWidth' => array (  0 => '',  1 => '',  2 => '85',  3 => '64',),'responsiveHeaderFontSize' => array (  0 => '',  1 => '18',  2 => '',  3 => '',),'responsivePriceFontSize' => array (  0 => '',  1 => '42',  2 => '',  3 => '',),'responsivePermonthFontSize' => array (  0 => '',  1 => '',  2 => '',  3 => '',),'responsiveContentFontSize' => array (  0 => '',  1 => '13',  2 => '12',  3 => '10',),'responsiveButtonsFontSize' => array (  0 => '',  1 => '13',  2 => '',  3 => '',),'priceFontCustom' => '','priceFont' => 'Source Sans Pro:300','priceFontSubset' => '','priceFontSize' => '48','headerFontCustom' => '','headerFont' => 'Source Sans Pro:regular','headerFontSubset' => '','headerFontSize' => '24','permonthFontCustom' => '','permonthFont' => 'Open Sans:regular','permonthFontSubset' => '','permonthFontSize' => '','contentFontCustom' => '','contentFont' => 'Open Sans:regular','contentFontSubset' => '','contentFontSize' => '14','buttonsFontCustom' => '','buttonsFont' => 'Open Sans:regular','buttonsFontSubset' => '','buttonsFontSize' => '14','slidingColumns' => '1','visibleColumns' => '3','scrollColumns' => '3','slidingNavigation' => '1','slidingNavigationArrows' => '1','slidingArrowsStyle' => 'style2','slidingPagination' => '0','slidingPaginationPosition' => 'bottom','slidingPaginationStyle' => 'style1','slidingCircular' => '0','slidingInfinite' => '1','slidingOnTouch' => '1','slidingOnMouse' => '0','slidingThreshold' => '75','slidingAutoplay' => '0','slidingEffect' => 'scroll','slidingEasing' => 'swing','slidingDuration' => '500','widths' => array (  0 => '273',  1 => '273',  2 => '273',  3 => '273',  4 => '',  5 => '273',  6 => '273',  7 => '273',),'responsiveWidths' => array (  0 => '213',  1 => '153',  2 => '91',  3 => '74',  4 => '213',  5 => '153',  6 => '91',  7 => '74',  8 => '213',  9 => '153',  10 => '91',  11 => '74',  12 => '213',  13 => '153',  14 => '91',  15 => '74',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '213',  21 => '153',  22 => '91',  23 => '74',  24 => '213',  25 => '153',  26 => '91',  27 => '74',  28 => '213',  29 => '153',  30 => '91',  31 => '74',),'aligments' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'actives' => array (  0 => '-1',  1 => '-1',  2 => '1',  3 => '-1',  4 => '-1',  5 => '-1',  6 => '-1',  7 => '-1',),'hiddens' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '1',  5 => '-1',  6 => '-1',  7 => '-1',),'ribbons' => array (  0 => '-1',  1 => '-1',  2 => '-1',  3 => '-1',  4 => '-1',  5 => 'style1_pro',  6 => '-1',  7 => '-1',),'heights' => array (  0 => '',  1 => '',  2 => '31',  3 => '31',  4 => '31',  5 => '31',  6 => '31',  7 => '31',  8 => '46',),'responsiveHeights' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '49',  11 => '55',  12 => '',  13 => '',  14 => '49',  15 => '79',  16 => '',  17 => '',  18 => '',  19 => '55',  20 => '',  21 => '',  22 => '',  23 => '55',  24 => '',  25 => '',  26 => '',  27 => '55',  28 => '',  29 => '',  30 => '',  31 => '55',  32 => '',  33 => '',  34 => '',  35 => '62',),'paddingsTop' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'paddingsBottom' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',),'texts' => array (  0 => '',  1 => '<h2 class="col1">Basic Plan</h2>',  2 => '<h2 class="col2">Care Plus</h2>',  3 => '<h2 class="col1">Super Care</h2>',  4 => '',  5 => '<h2 class="col1">Super Prestige</h2>',  6 => '<h2 class="col1">Prestige Plus</h2>',  7 => '<h2 class="col1">Full Package</h2>',  8 => '<h2 class="caption">choose <span>your</span> plan</h2>',  9 => '<h1 class="col1">$<span>16</span></h1><h3 class="col1">per month</h3>',  10 => '<h1 class="col1">$<span>25</span></h1><h3 class="col1">per month</h3>',  11 => '<h1 class="col1">$<span>29</span></h1><h3 class="col1">per month</h3>',  12 => '',  13 => '<h1 class="col1">$<span>39</span></h1><h3 class="col1">per month</h3>',  14 => '<h1 class="col1">$<span>49</span></h1><h3 class="col1">per month</h3>',  15 => '<h1 class="col1">$<span>59</span></h1><h3 class="col1">per month</h3>',  16 => 'Available Medical Specialties',  17 => '6 Specialties',  18 => '12 Specialties',  19 => '24 Specialties',  20 => '',  21 => '36 Specialties',  22 => '36 Specialties',  23 => '50 Specialties',  24 => 'Investigations and Treatments',  25 => '30 Tests and Treatments',  26 => '90 Tests and Treatments',  27 => '160 Tests and Treatments',  28 => '',  29 => '250 Tests and Treatments',  30 => '300 Tests and Treatments',  31 => 'Unlimited Tests and Treatments',  32 => 'Medical Consultation',  33 => '1 Time a Year',  34 => '2 Times a Year',  35 => '4 Times a Year',  36 => '',  37 => 'Unlimited',  38 => 'Unlimited',  39 => 'Unlimited',  40 => 'Home Visits',  41 => '1 Time a Year',  42 => '2 Times a Year',  43 => '4 Times a Year',  44 => '',  45 => '6 Times a Year',  46 => 'Unlimited',  47 => 'Unlimited',  48 => 'Pregnancy Care',  49 => '<span class="css3_grid_icon icon_no_01"></span>',  50 => '<span class="css3_grid_icon icon_no_01"></span>',  51 => '<span class="css3_grid_icon icon_yes_01"></span>',  52 => '',  53 => '<span class="css3_grid_icon icon_yes_01"></span>',  54 => '<span class="css3_grid_icon icon_yes_01"></span>',  55 => '<span class="css3_grid_icon icon_yes_01"></span>',  56 => 'Medical Assistance',  57 => '<span class="css3_grid_icon icon_no_01"></span>',  58 => '24h Assistance',  59 => '24h Assistance',  60 => '',  61 => '24h Assistance',  62 => '24h Assistance',  63 => '24h Assistance',  64 => '',  65 => '<a href="' . get_site_url() . '?plan=1" class="sign_up" radius3="">LEARN MORE</a>',  66 => '<a href="' . get_site_url() . '?plan=2" class="sign_up" radius3="">LEARN MORE</a>',  67 => '<a href="' . get_site_url() . '?plan=3" class="sign_up" radius3="">LEARN MORE</a>',  68 => '',  69 => '<a href="' . get_site_url() . '?plan=4" class="sign_up" radius3="">LEARN MORE</a>',  70 => '<a href="' . get_site_url() . '?plan=5" class="sign_up" radius3="">LEARN MORE</a>',  71 => '<a href="' . get_site_url() . '?plan=6" class="sign_up" radius3="">LEARN MORE</a>',),'tooltips' => array (  0 => '',  1 => '',  2 => '',  3 => '',  4 => '',  5 => '',  6 => '',  7 => '',  8 => '',  9 => '',  10 => '',  11 => '',  12 => '',  13 => '',  14 => '',  15 => '',  16 => '',  17 => '',  18 => '',  19 => '',  20 => '',  21 => '',  22 => '',  23 => '',  24 => '',  25 => '',  26 => '',  27 => 'Can be extended to 250 Tests',  28 => '',  29 => '',  30 => '',  31 => '',  32 => '',  33 => '',  34 => '',  35 => '',  36 => '',  37 => '',  38 => '',  39 => '',  40 => '',  41 => '',  42 => '',  43 => '',  44 => '',  45 => '',  46 => '',  47 => '',  48 => '',  49 => '',  50 => '',  51 => '',  52 => '',  53 => '',  54 => '',  55 => '',  56 => '',  57 => '',  58 => '',  59 => '',  60 => '',  61 => '',  62 => '',  63 => '',  64 => '',  65 => '',  66 => '',  67 => '',  68 => '',  69 => '',  70 => '',  71 => '',),'pricingCycles' => '0','dropdownAlignment' => 'left','pricingCyclesSteps' => '1','pricingCycleTitle' => array (  0 => '',),'pricingCycleID' => array (  0 => '',),'pricingCyclePriceColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '',  ),),'pricingCycleButtonURLColumn' => array (  0 =>   array (    0 => '',    1 => '',    2 => '',    3 => '',    4 => '',    5 => '',    6 => '')));
	add_option("css3_grid_shortcode_settings_medicenter_violet_sliding", $medicenter_violet_sliding);
}
register_activation_hook( __FILE__, 'css3_grid_activate');

function css3_grid_shortcode($atts)
{
	extract(shortcode_atts(array(
		'id' => '',
		'top_margin' => 'none'
	), $atts));
	if($id!="")
	{
		if($shortcode_settings = get_option('css3_grid_shortcode_settings_' . $id))
		{
			$responsiveStepWidth = (isset($shortcode_settings["responsiveStepWidth"]) ? implode("|", $shortcode_settings["responsiveStepWidth"]) : "");
			
			$responsiveButtonWidth = (isset($shortcode_settings["responsiveButtonWidth"]) ? implode("|", $shortcode_settings["responsiveButtonWidth"]) : "");

			$responsiveHeaderFontSize = (isset($shortcode_settings["responsiveHeaderFontSize"]) ? implode("|", $shortcode_settings["responsiveHeaderFontSize"]) : "");

			$responsivePriceFontSize = (isset($shortcode_settings["responsivePriceFontSize"]) ? implode("|", $shortcode_settings["responsivePriceFontSize"]) : "");

			$responsivePermonthFontSize = (isset($shortcode_settings["responsivePermonthFontSize"]) ? implode("|", $shortcode_settings["responsivePermonthFontSize"]) : "");

			$responsiveContentFontSize = (isset($shortcode_settings["responsiveContentFontSize"]) ? implode("|", $shortcode_settings["responsiveContentFontSize"]) : "");

			$responsiveButtonsFontSize = (isset($shortcode_settings["responsiveButtonsFontSize"]) ? implode("|", $shortcode_settings["responsiveButtonsFontSize"]) : "");

			$widths = implode("|", $shortcode_settings["widths"]);

			$responsiveWidths = (isset($shortcode_settings["responsiveWidths"]) ? implode("|", $shortcode_settings["responsiveWidths"]) : "");

			$aligments = implode("|", $shortcode_settings["aligments"]);

			$actives = implode("|", $shortcode_settings["actives"]);

			$hiddens = implode("|", $shortcode_settings["hiddens"]);

			$ribbons = implode("|", $shortcode_settings["ribbons"]);

			$heights = implode("|", $shortcode_settings["heights"]);

			$responsiveHeights = (isset($shortcode_settings["responsiveHeights"]) ? implode("|", $shortcode_settings["responsiveHeights"]) : "");

			$paddingsTop = implode("|", $shortcode_settings["paddingsTop"]);

			$paddingsBottom = implode("|", $shortcode_settings["paddingsBottom"]);

			$texts = str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["texts"]))));

			$tooltips = str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["tooltips"]))));

			$headerFontSubsets = (!empty($shortcode_settings["headerFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["headerFontSubset"])))) : "");

			$priceFontSubsets = (!empty($shortcode_settings["priceFontSubset"])) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["priceFontSubset"])))) : "";

			$permonthFontSubsets = (!empty($shortcode_settings["permonthFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["permonthFontSubset"])))) : "");

			$contentFontSubsets = (!empty($shortcode_settings["contentFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["contentFontSubset"])))) : "");

			$buttonsFontSubsets = (!empty($shortcode_settings["buttonsFontSubset"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["buttonsFontSubset"])))) : "");
			
			$dropdownAlignment = (!empty($shortcode_settings["dropdownAlignment"]) ? $shortcode_settings["dropdownAlignment"] : "");
			
			$cyclesTitles = (!empty($shortcode_settings["pricingCycleTitle"]) ? esc_html(str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", implode("|", $shortcode_settings["pricingCycleTitle"]))))) : "");

			$cyclesIDs = (!empty($shortcode_settings["pricingCycleID"]) ? implode("|", $shortcode_settings["pricingCycleID"]) : "");

			$cyclesPrices = (!empty($shortcode_settings["pricingCyclePriceColumn"]) ? str_replace("]", "&#93;", str_replace("[", "&#91;", str_replace("'", "&#39;", "{" . implode("}{", array_map("css3_grid_implode_entry", $shortcode_settings["pricingCyclePriceColumn"])) . "}"))) : "");

			$cyclesButtonURLs = (!empty($shortcode_settings["pricingCycleButtonURLColumn"]) ? "{" . implode("}{", array_map("css3_grid_implode_entry", $shortcode_settings["pricingCycleButtonURLColumn"])). "}" : "");
			
			$output = do_shortcode("[css3_grid_print id='" . $id . "' top_margin='" . $top_margin . "' kind='" . $shortcode_settings["kind"] . "' style='" . $shortcode_settings["styleForTable" . $shortcode_settings["kind"]] . "' hoverType='" . $shortcode_settings["hoverTypeForTable" . $shortcode_settings["kind"]] . "' css3CustomCss='" . (isset($shortcode_settings["css3CustomCss"]) ? $shortcode_settings["css3CustomCss"] : '') . "' responsive='" . $shortcode_settings["responsive"] . "' responsiveHideCaptionColumn='" . (isset($shortcode_settings["responsiveHideCaptionColumn"]) ? $shortcode_settings["responsiveHideCaptionColumn"] : '') . "' responsiveSteps='" . $shortcode_settings["responsiveSteps"] . "' responsiveStepWidth='" . $responsiveStepWidth . "' responsiveButtonWidth='" . $responsiveButtonWidth . "' responsiveHeaderFontSize='" . $responsiveHeaderFontSize . "' responsivePriceFontSize='" . $responsivePriceFontSize . "' responsivePermonthFontSize='" . $responsivePermonthFontSize . "' responsiveContentFontSize='" . $responsiveContentFontSize . "' responsiveButtonsFontSize='" . $responsiveButtonsFontSize . "' priceFontCustom='" . (isset($shortcode_settings["priceFontCustom"]) ? $shortcode_settings["priceFontCustom"] : '') . "' priceFont='" . (isset($shortcode_settings["priceFont"]) ? $shortcode_settings["priceFont"] : '') . "' priceFontSubsets='" . (isset($priceFontSubsets) ? $priceFontSubsets : '') . "' priceFontSize='" . (isset($shortcode_settings["priceFontSize"]) ? $shortcode_settings["priceFontSize"] : '') . "' headerFontCustom='" . (isset($shortcode_settings["headerFontCustom"]) ? $shortcode_settings["headerFontCustom"] : '') . "' headerFont='" . (isset($shortcode_settings["headerFont"]) ? $shortcode_settings["headerFont"] : '') . "' headerFontSubsets='" . (isset($headerFontSubsets) ? $headerFontSubsets : '') . "' headerFontSize='" . (isset($shortcode_settings["headerFontSize"]) ? $shortcode_settings["headerFontSize"] : '') . "' permonthFontCustom='" . (isset($shortcode_settings["permonthFontCustom"]) ? $shortcode_settings["permonthFontCustom"] : '') . "' permonthFont='" . (isset($shortcode_settings["permonthFont"]) ? $shortcode_settings["permonthFont"] : '') . "' permonthFontSubsets='" . (isset($permonthFontSubsets) ? $permonthFontSubsets : '') . "' permonthFontSize='" . (isset($shortcode_settings["permonthFontSize"]) ? $shortcode_settings["permonthFontSize"] : '') . "' contentFontCustom='" . (isset($shortcode_settings["contentFontCustom"]) ? $shortcode_settings["contentFontCustom"] : '') . "' contentFont='" . (isset($shortcode_settings["contentFont"]) ? $shortcode_settings["contentFont"] : '') . "' contentFontSubsets='" . (isset($contentFontSubsets) ? $contentFontSubsets : '') . "' contentFontSize='" . (isset($shortcode_settings["contentFontSize"]) ? $shortcode_settings["contentFontSize"] : '') . "' buttonsFontCustom='" . (isset($shortcode_settings["buttonsFontCustom"]) ? $shortcode_settings["buttonsFontCustom"] : '') . "' buttonsFont='" . (isset($shortcode_settings["buttonsFont"]) ? $shortcode_settings["buttonsFont"] : '') . "' buttonsFontSubsets='" . (isset($buttonsFontSubsets) ? $buttonsFontSubsets : '') . "' buttonsFontSize='" . (isset($shortcode_settings["buttonsFontSize"]) ? $shortcode_settings["buttonsFontSize"] : '') . "' slidingColumns='" . $shortcode_settings["slidingColumns"] . "' visibleColumns='" . $shortcode_settings["visibleColumns"] . "' scrollColumns='" . $shortcode_settings["scrollColumns"] . "' slidingNavigation='" . $shortcode_settings["slidingNavigation"] . "' slidingNavigationArrows='" . $shortcode_settings["slidingNavigationArrows"] . "' slidingArrowsStyle='" . $shortcode_settings["slidingArrowsStyle"] . "' slidingPagination='" . $shortcode_settings["slidingPagination"] . "' slidingPaginationPosition='" . $shortcode_settings["slidingPaginationPosition"] . "' slidingPaginationStyle='" . $shortcode_settings["slidingPaginationStyle"] . "' slidingCircular='" . (isset($shortcode_settings["slidingCircular"]) ? $shortcode_settings["slidingCircular"] : '') . "' slidingInfinite='" . (isset($shortcode_settings["slidingInfinite"]) ? $shortcode_settings["slidingInfinite"] : '') . "' slidingOnTouch='" . $shortcode_settings["slidingOnTouch"] . "' slidingOnMouse='" . $shortcode_settings["slidingOnMouse"] . "' slidingThreshold='" . $shortcode_settings["slidingThreshold"] . "' slidingAutoplay='" . $shortcode_settings["slidingAutoplay"] . "' slidingEffect='" . $shortcode_settings["slidingEffect"] . "' slidingEasing='" . $shortcode_settings["slidingEasing"] . "' slidingDuration='" . $shortcode_settings["slidingDuration"] . "' columns='" . $shortcode_settings["columns"] . "' rows='" . $shortcode_settings["rows"] . "' hiddenRows='" . $shortcode_settings["hiddenRows"] . "' hiddenRowsButtonExpandText='" . $shortcode_settings["hiddenRowsButtonExpandText"] . "' hiddenRowsButtonCollapseText='" . $shortcode_settings["hiddenRowsButtonCollapseText"] . "' texts='" . $texts . "' tooltips='" . $tooltips . "' widths='" . $widths . "' responsiveWidths='" . $responsiveWidths . "' aligments='" . $aligments . "' actives='" . $actives . "' hiddens='" . $hiddens . "' ribbons='" . $ribbons . "' heights='" . $heights . "' responsiveHeights='" . $responsiveHeights . "' paddingstop='" . $paddingsTop . "' paddingsbottom='" . $paddingsBottom . "' dropdownAlignment='" . $dropdownAlignment . "' pricingCycles='" . (isset($shortcode_settings["pricingCycles"]) ? $shortcode_settings["pricingCycles"] : '') . "' pricingCyclesSteps='" . (isset($shortcode_settings["pricingCyclesSteps"]) ? $shortcode_settings["pricingCyclesSteps"] : '') . "' pricingCyclesTitles='".$cyclesTitles."' pricingCyclesIDs='".$cyclesIDs."' pricingCyclesPrices='".$cyclesPrices."' pricingCyclesButtonURLs='".$cyclesButtonURLs."']");
		}
		else
			$output = __('Shortcode with given id not found!', 'css3_grid');
	}
	else
		$output = __('Parameter id not specified!', 'css3_grid');
	return $output;
}
add_shortcode('css3_grid', 'css3_grid_shortcode');

function css3_grid_enqueue_scripts()
{
	$css3_grid_global_options = (array)get_option('css3_grid_global_settings');
	if(!isset($css3_grid_global_options['loadFiles']) || $css3_grid_global_options['loadFiles']!='when_used')
	{
		wp_enqueue_style('css3_grid_font_yanone', '//fonts.googleapis.com/css?family=Yanone+Kaffeesatz');
		wp_enqueue_style('css3_grid_table1_style', plugins_url('table1/css3_grid_style.css', __FILE__));
		wp_enqueue_style('css3_grid_table2_style', plugins_url('table2/css3_grid_style.css', __FILE__));
		wp_enqueue_style('css3_grid_responsive', plugins_url('responsive.css', __FILE__));
	}
}
add_action('wp_enqueue_scripts', 'css3_grid_enqueue_scripts');

function css3_grid_wp_footer()
{
	global $css3_grid_shortcode_used;
	global $css3_grid_load_responsive;
	global $css3_grid_load_kind_1;
	global $css3_grid_load_kind_2;
	global $css3_grid_load_js;
	global $css3_grid_load_expand_collapse;
	if((int)$css3_grid_load_js)
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-carouFredSel', plugins_url('js/jquery.carouFredSel-6.2.1-packed.js', __FILE__));
		wp_enqueue_script('css3_grid_main', plugins_url('js/main.js', __FILE__)); 
		wp_enqueue_script('jquery-easing', plugins_url('js/jquery.easing.1.4.1.js', __FILE__));
		wp_enqueue_script('jquery-touchSwipe', plugins_url('js/jquery.touchSwipe.min.js', __FILE__));
	}
	else if((int)$css3_grid_load_expand_collapse)
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('css3_grid_main', plugins_url('js/main.js', __FILE__));
	}
	$css3_grid_global_options = (array)get_option('css3_grid_global_settings');
	if($css3_grid_shortcode_used && (!empty($css3_grid_global_options) && $css3_grid_global_options['loadFiles']=='when_used'))
	{
		wp_enqueue_style('css3_grid_font_yanone', '//fonts.googleapis.com/css?family=Yanone+Kaffeesatz');
		if((int)$css3_grid_load_kind_1)
			wp_enqueue_style('css3_grid_table1_style', plugins_url('table1/css3_grid_style.css', __FILE__));
		if((int)$css3_grid_load_kind_2)
			wp_enqueue_style('css3_grid_table2_style', plugins_url('table2/css3_grid_style.css', __FILE__));
		if((int)$css3_grid_load_responsive)
			wp_enqueue_style('css3_grid_responsive', plugins_url('responsive.css', __FILE__));
	}
}
add_action('wp_footer', 'css3_grid_wp_footer');

function filterArray($value)
{
	return (!empty($value) || $value == '0');
}

function css3_grid_print_shortcode($atts)
{
	global $css3_grid_shortcode_used;
	global $css3_grid_load_responsive;
	global $css3_grid_load_kind_1;
	global $css3_grid_load_kind_2;
	global $css3_grid_load_js;
	global $css3_grid_load_expand_collapse;
	extract(shortcode_atts(array(
		'id' => 'css3_grid_example',
		'cycles' => '',
		'prices' => '',
		'columns' => '3',
		'rows' => '9',
		'hiddenrows' => '0',
		'hiddenrowsbuttonexpandtext' => 'Click here to expand!',
		'hiddenrowsbuttoncollapsetext' => 'Click here to collapse!',
		'kind' => '1',
		'style' => '1',
		'hovertype' => 'active',
		'css3customcss' => '',
		'responsive' => '0',
		'responsivehidecaptioncolumn' => '0',
		'responsivesteps' => '3',
		'responsivestepwidth' => '1009|767|479|',
		'responsivebuttonwidth' => '|||',
		'responsiveheaderfontsize' => '|||',
		'responsivepricefontsize' => '|||',
		'responsivepermonthfontsize' => '|||',
		'responsivecontentfontsize' => '|||',
		'responsivebuttonsfontsize' => '|||',
		'pricefontcustom' => '',
		'pricefont' => '',
		'pricefontsubsets' => '',
		'pricefontsize' => '',
		'headerfontcustom' => '',
		'headerfont' => '',
		'headerfontsubsets' => '',
		'headerfontsize' => '',
		'permonthfontcustom' => '',
		'permonthfont' => '',
		'permonthfontsubsets' => '',
		'permonthfontsize' => '',
		'contentfontcustom' => '',
		'contentfont' => '',
		'contentfontsubsets' => '',
		'contentfontsize' => '',
		'buttonsfontcustom' => '',
		'buttonsfont' => '',
		'buttonsfontsubsets' => '',
		'buttonsfontsize' => '',
		'slidingcolumns' => '0',
		'visiblecolumns' => '2',
		'scrollcolumns' => '',
		'slidingnavigation' => '1',
		'slidingnavigationarrows' => '1',
		'slidingarrowsstyle' => 'style1',
		'slidingpagination' => '0',
		'slidingpaginationposition' => 'bottom',
		'slidingpaginationstyle' => 'style1', 
		'slidingcircular' => '1',
		'slidinginfinite' => '1',
		'slidingontouch' => '1',
		'slidingonmouse' => '0',
		'slidingthreshold' => '75',
		'slidingautoplay' => '0',
		'slidingeffect' => 'scroll',
		'slidingeasing' => 'swing',
		'slidingduration' => '500',
		'widths' => '|||',
		'responsivewidths' => '|||',
		'aligments' => '-1|-1|-1|',
		'actives' => '-1|-1|-1|',
		'hiddens' => '-1|-1|-1|',
		'ribbons' => '-1|-1|-1|',
		'heights' => '|||||||||',
		'responsiveheights' => '|||||||||',
		'paddingstop' => '|||||||||',
		'paddingsbottom' => '|||||||||',
		'texts' => '|<h2 class="col1">starter</h2>|<h2 class="col2">econo</h2>|<h2 class="caption">choose <span>your</span> plan</h2>|<h1 class="col1">$<span>10</span></h1><h3 class="col1">per month</h3>|<h1 class="col1">$<span>30</span></h1><h3 class="col1">per month</h3>|Amount of space|10GB|30GB|Bandwidth per month|100GB|200GB|No. of e-mail accounts|1|10|No. of MySql databases|1|10|24h support|Yes|Yes|Support tickets per mo.|1|3||<a href="' . get_site_url() . '?plan=1" class="sign_up radius3">sign up!</a>|<a href="' . get_site_url() . '?plan=2" class="sign_up radius3">sign up!</a>',
		'tooltips' => '|||||||||',
		'top_margin' => 'none',
		'pricingcycles' => '0',
		'dropdownalignment' => '',
		'pricingcyclessteps' => '',
		'pricingcyclestitles' => '',
		'pricingcyclesids' => '',
		'pricingcyclesprices' => '',
		'pricingcyclesbuttonurls' => '',
	), $atts));
	
	if($id=="")
		$id = "sample";
	$responsiveStepWidth = array_filter(explode("|", $responsivestepwidth), 'filterArray');
	$responsiveButtonWidth = array_filter(explode("|", $responsivebuttonwidth), 'filterArray');
	$responsiveHeaderFontSize = array_filter(explode("|", $responsiveheaderfontsize), 'filterArray');
	$responsivePriceFontSize = array_filter(explode("|", $responsivepricefontsize), 'filterArray');
	$responsivePermonthFontSize = array_filter(explode("|", $responsivepermonthfontsize), 'filterArray');
	$responsiveContentFontSize = array_filter(explode("|", $responsivecontentfontsize), 'filterArray');
	$responsiveButtonsFontSize = array_filter(explode("|", $responsivebuttonsfontsize), 'filterArray');
	$widths = explode("|", $widths);
	$responsiveWidths = array_filter(explode("|", $responsivewidths), 'filterArray');
	$aligments = explode("|", $aligments);
	$actives = explode("|", $actives);
	$hiddens = explode("|", $hiddens);
	$ribbons = explode("|", $ribbons);
	$heights = array_filter(explode("|", $heights), 'filterArray');
	$responsiveHeights = array_filter(explode("|", $responsiveheights), 'filterArray');
	$headerFontSubsets = array_filter(explode("|", $headerfontsubsets), 'filterArray');
	$priceFontSubsets = array_filter(explode("|", $pricefontsubsets), 'filterArray');
	$permonthFontSubsets = array_filter(explode("|", $permonthfontsubsets), 'filterArray');
	$contentFontSubsets = array_filter(explode("|", $contentfontsubsets), 'filterArray');
	$buttonsFontSubsets = array_filter(explode("|", $buttonsfontsubsets), 'filterArray');
	if((int)$responsive)
		$css3_grid_load_responsive = 1;
	if((int)$kind==1)
		$css3_grid_load_kind_1 = 1;
	if((int)$kind==2)
		$css3_grid_load_kind_2 = 1;
	$output = "";

	if($pricefontcustom!="" || $pricefont!="" || (int)$pricefontsize>0 || $headerfontcustom!="" || $headerfont!="" || (int)$headerfontsize>0 || $permonthfontcustom!="" || $permonthfont!="" || (int)$permonthfontsize>0 || $contentfontcustom!="" || $contentfont!="" || (int)$contentfontsize>0 || $buttonsfontcustom!="" || $buttonsfont!="" || (int)$buttonsfontsize>0)
	{
		$fontStyles = "";
		$fontsGoogleUrl = "";
		$joinedSubsets = array();
		$headerFont = $headerfontcustom;
		if($headerfont!="" || $headerfontcustom!="" || (int)$headerfontsize>0)
		{
			if($headerfont!="")
			{
				$headerFontExplode = explode(":", $headerfont);
				$headerFont = '"' . $headerFontExplode[0] . '"';
				$fontsGoogleUrl .= $headerfont;
				$joinedSubsets = array_unique(array_merge((array)$headerFontSubsets, $joinedSubsets));
			}
			else
			{
				$headerFontsExplode = explode(",", $headerFont);
				$headerFont = "";
				for($i=0; $i<count($headerFontsExplode); $i++)
					$headerFont .= ($i>0 ? ',' : '') . '"' . trim($headerFontsExplode[$i]) . '"';
			}
			$fontStyles .= 'div.p_table_' . $kind . '#' . $id . ' h2' . ($kind==1 ? ', div.p_table_' . $kind . '#' . $id . ' h2 span' : '') . '{' . ($headerFont!="" ? 'font-family: ' . $headerFont . ' !important;' : '') . ((int)$headerfontsize>0 ? 'font-size: ' . (int)$headerfontsize . 'px !important;' : '') . '}';
		}
		$priceFont = $pricefontcustom;
		if($pricefont!="" || $pricefontcustom!="" || (int)$pricefontsize>0)
		{
			if($pricefont!="")
			{
				$priceFontExplode = explode(":", $pricefont);
				$priceFont = '"' . $priceFontExplode[0] . '"';
				$fontsGoogleUrl .= ($fontsGoogleUrl!="" ? '|' : '') . $pricefont;
				$joinedSubsets = array_unique(array_merge((array)$priceFontSubsets, $joinedSubsets));
			}
			else
			{
				$priceFontsExplode = explode(",", $priceFont);
				$priceFont = "";
				for($i=0; $i<count($priceFontsExplode); $i++)
					$priceFont .= ($i>0 ? ',' : '') . '"' . trim($priceFontsExplode[$i]) . '"';
			}
			$fontStyles .= 'div.p_table_' . $kind . '#' . $id . ' h1' . ($kind==1 ? ', div.p_table_' . $kind . '#' . $id . ' h1 span' : '') . '{' . ($priceFont!="" ? 'font-family: ' . $priceFont . ' !important;' : '') . ((int)$pricefontsize>0 ? 'font-size: ' . (int)$pricefontsize . 'px !important;' : '') . '}';
		}
		$permonthFont = $permonthfontcustom;
		if($permonthfont!="" || $permonthfontcustom!="" || (int)$permonthfontsize>0)
		{
			if($permonthfont!="")
			{
				$permonthFontExplode = explode(":", $permonthfont);
				$permonthFont = '"' . $permonthFontExplode[0] . '"';
				$fontsGoogleUrl .= ($fontsGoogleUrl!="" ? '|' : '') . $permonthfont;
				$joinedSubsets = array_unique(array_merge((array)$permonthFontSubsets, $joinedSubsets));
			}
			else
			{
				$permonthFontsExplode = explode(",", $permonthFont);
				$permonthFont = "";
				for($i=0; $i<count($permonthFontsExplode); $i++)
					$permonthFont .= ($i>0 ? ',' : '') . '"' . trim($permonthFontsExplode[$i]) . '"';
			}
			$fontStyles .= 'div.p_table_' . $kind . '#' . $id . ' h3{' . ($permonthFont!="" ? 'font-family: ' . $permonthFont . ' !important;' : '') . ((int)$permonthfontsize>0 ? 'font-size: ' . (int)$permonthfontsize . 'px !important;' : '') . '}';
		}
		$contentFont = $contentfontcustom;
		if($contentfont!="" || $contentfontcustom!="" || (int)$contentfontsize>0)
		{
			if($contentfont!="")
			{
				$contentFontExplode = explode(":", $contentfont);
				$contentFont = '"' . $contentFontExplode[0] . '"';
				$fontsGoogleUrl .= ($fontsGoogleUrl!="" ? '|' : '') . $contentfont;
				$joinedSubsets = array_unique(array_merge((array)$contentFontSubsets, $joinedSubsets));
			}
			else
			{
				$contentFontsExplode = explode(",", $contentFont);
				$contentFont = "";
				for($i=0; $i<count($contentFontsExplode); $i++)
					$contentFont .= ($i>0 ? ',' : '') . '"' . trim($contentFontsExplode[$i]) . '"';
			}
			$fontStyles .= 'div.p_table_' . $kind . '#' . $id . ' li.row_style_1 span, div.p_table_' . $kind . '#' . $id . ' li.row_style_2 span, div.p_table_' . $kind . '#' . $id . ' li.row_style_3 span, div.p_table_' . $kind . '#' . $id . ' li.row_style_4 span{' . ($contentFont!="" ? 'font-family: ' . $contentFont . ' !important;' : '') . ((int)$contentfontsize>0 ? 'font-size: ' . (int)$contentfontsize . 'px !important;' : '') . '}';
		}
		$buttonsFont = $buttonsfontcustom;
		if($buttonsfont!="" || $buttonsfontcustom!="" || (int)$buttonsfontsize>0)
		{
			if($buttonsfont!="")
			{
				$buttonsFontExplode = explode(":", $buttonsfont);
				$buttonsFont = '"' . $buttonsFontExplode[0] . '"';
				$fontsGoogleUrl .= ($fontsGoogleUrl!="" ? '|' : '') . $buttonsfont;
				$joinedSubsets = array_unique(array_merge((array)$buttonsFontSubsets, $joinedSubsets));
			}
			else
			{
				$buttonsFontsExplode = explode(",", $buttonsFont);
				$buttonsFont = "";
				for($i=0; $i<count($buttonsFontsExplode); $i++)
					$buttonsFont .= ($i>0 ? ',' : '') . '"' . trim($buttonsFontsExplode[$i]) . '"';
			}
			$fontStyles .= ($kind==1 ? 'div.p_table_' . $kind . '#' . $id . ' a.sign_up, div.p_table_' . $kind . '#' . $id . ' .css3_grid_hidden_rows_control span' : 'div.p_table_' . $kind . '#' . $id . ' a.button_1, div.p_table_' . $kind . '#' . $id . ' a.button_2, div.p_table_' . $kind . '#' . $id . ' a.button_3, div.p_table_' . $kind . '#' . $id . ' a.button_4, div.p_table_' . $kind . '#' . $id . ' .css3_grid_hidden_rows_control span') . '{' . ($buttonsFont!="" ? 'font-family: ' . $buttonsFont . ' !important;' : '') . ((int)$buttonsfontsize>0 ? 'font-size: ' . (int)$buttonsfontsize . 'px !important;' : '') . '}';
		}
		
		/*if($priceFont!="" && $headerFont!="")
		{
			if($priceFont!=$headerFont)
			{
				if($headerFont!="")
					$output .= '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=' . $headerfont . '&subset=' . implode(",", (array)$headerFontSubsets) . '">';
				if($priceFont!="")
					$output .= '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=' . $pricefont . '&subset=' . implode(",", (array)$priceFontSubsets) . '">';
			}
			else
			{
				$joinedSubsets = array_unique(array_merge((array)$headerFontSubsets, (array)$priceFontSubsets));
				$output .= '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=' . $headerfont . '&subset=' . implode(",", (array)$joinedSubsets) . '">';
			}
		}*/
		if($fontsGoogleUrl!="")
			$output .= '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=' . $fontsGoogleUrl . '&subset=' . implode(",", (array)$joinedSubsets) . '">';
		$output .= '<style type="text/css">' . $fontStyles . '</style>';
	}
	if((int)$responsive && count($responsiveStepWidth) && (count($responsiveWidths) || count($responsiveHeights) || count($responsiveButtonWidth) || count($responsiveHeaderFontSize)))
	{
		$output .= '<style type="text/css">';
		for($i=0; $i<count($responsiveStepWidth); $i++)
		{
			$output .= '@media screen and (max-width:' . $responsiveStepWidth[$i] . 'px)
			{';
			if(count($responsiveWidths))
			{
				foreach($responsiveWidths as $key=>$responsiveWidth)
				{
					if($key%(int)$responsivesteps==$i)
						$output .= 'div.p_table_responsive#' . $id . ' div.column_' . floor($key/(int)$responsivesteps) . '_responsive
						{
							width: ' . $responsiveWidth . (substr($responsiveWidth, -1)!="%" && substr($responsiveWidth, -2)!="px" ? "px" : "") . ' !important;' . ((int)$responsiveWidth==0 ? 'display: none;' : '') . '
						}';
				}
			}
			if(count($responsiveHeights))
			{
				foreach($responsiveHeights as $key=>$responsiveHeight)
				{
					if($key%(int)$responsivesteps==$i)
						$output .= 'div.p_table_responsive#' . $id . ' li.css3_grid_row_' . floor($key/(int)$responsivesteps) . '_responsive
						{
							height: ' . (int)$responsiveHeight . 'px !important;' . ((int)$responsiveHeight==0 ? 'display: none;' : '') . '
						}';
				}
			}
			if(isset($responsiveButtonWidth[$i]) && (int)$responsiveButtonWidth[$i]>0)
			{
				$output .= ($kind==1 ? 'div.p_table_responsive#' . $id . ' a.sign_up' : 'div.p_table_' . $kind . '#' . $id . ' a.button_1, div.p_table_' . $kind . '#' . $id . ' a.button_2, div.p_table_' . $kind . '#' . $id . ' a.button_3, div.p_table_' . $kind . '#' . $id . ' a.button_4') . '
				{
					width: ' . (int)$responsiveButtonWidth[$i] . 'px;
				}';
			}
			if(isset($responsiveHeaderFontSize[$i]) && (int)$responsiveHeaderFontSize[$i]>0)
				$output .= 'div.p_table_' . $kind . '#' . $id . ' h2' . ($kind==1 ? ', div.p_table_' . $kind . '#' . $id . ' h2 span' : '') . '{font-size: ' . (int)$responsiveHeaderFontSize[$i] . 'px !important;}';
			if(isset($responsivePriceFontSize[$i]) && (int)$responsivePriceFontSize[$i]>0)
				$output .= 'div.p_table_' . $kind . '#' . $id . ' h1' . ($kind==1 ? ', div.p_table_' . $kind . '#' . $id . ' h1 span' : '') . '{font-size: ' . (int)$responsivePriceFontSize[$i] . 'px !important;}';
			if(isset($responsivePermonthFontSize[$i]) && (int)$responsivePermonthFontSize[$i]>0)
				$output .= 'div.p_table_' . $kind . '#' . $id . ' h3{font-size: ' . (int)$responsivePermonthFontSize[$i] . 'px !important;}';
			if(isset($responsiveContentFontSize[$i]) && (int)$responsiveContentFontSize[$i]>0)
				$output .= 'div.p_table_' . $kind . '#' . $id . ' li.row_style_1 span, div.p_table_' . $kind . '#' . $id . ' li.row_style_2 span, div.p_table_' . $kind . '#' . $id . ' li.row_style_3 span, div.p_table_' . $kind . '#' . $id . ' li.row_style_4 span{font-size: ' . (int)$responsiveContentFontSize[$i] . 'px !important;}';
			if(isset($responsiveButtonsFontSize[$i]) && (int)$responsiveButtonsFontSize[$i]>0)
				$output .= ($kind==1 ? 'div.p_table_' . $kind . '#' . $id . ' a.sign_up, div.p_table_' . $kind . '#' . $id . ' .css3_grid_hidden_rows_control span' : 'div.p_table_' . $kind . '#' . $id . ' a.button_1, div.p_table_' . $kind . '#' . $id . ' a.button_2, div.p_table_' . $kind . '#' . $id . ' a.button_3, div.p_table_' . $kind . '#' . $id . ' a.button_4, div.p_table_' . $kind . '#' . $id . ' .css3_grid_hidden_rows_control span') . '{font-size: ' . (int)$responsiveButtonsFontSize[$i] . 'px !important;}';
			
			$output .= '}';
		}
		$output .= '</style>';
	}
	if($css3customcss!='')
		$output .= '<style type="text/css">' . $css3customcss . '</style>';
	if((int)$hiddenrows>0 && (count($responsiveHeights) || count($heights)))
		$output .= '<style type="text/css">div#' . $id . '.p_table_1.css3_grid_clearfix div li.css3_grid_hidden_row.css3_grid_hide, div#' . $id . '.p_table_1.css3_grid_clearfix div:hover li.css3_grid_hidden_row.css3_grid_hide{height: 0 !important;opacity: 0;padding: 0 !important;}</style>';

	if(intval($pricingcycles)==1 && 
		!empty($pricingcyclestitles) && 
		!empty($pricingcyclesids) && 
		!empty($pricingcyclesprices)) 
	{
		$css3_grid_load_js = 1;
		$pricingcyclesids = explode("|", $pricingcyclesids);
		$pricingcyclestitles = explode("|", $pricingcyclestitles);
		
		// column pricing for each column
		$pricingcyclesprices = explode("}{", addslashes($pricingcyclesprices));
		$prices_count = count($pricingcyclesprices);
		$pricingcyclesprices[0] = str_replace("{", "", $pricingcyclesprices[0]);
		$pricingcyclesprices[$prices_count-1] = str_replace("}", "", $pricingcyclesprices[$prices_count-1]);
		// column button URLs for each column
		$pricingcyclesbuttonurls = explode("}{", $pricingcyclesbuttonurls);
		$buttonURLs_count = count($pricingcyclesbuttonurls);
		$pricingcyclesbuttonurls[0] = str_replace("{", "", $pricingcyclesbuttonurls[0]);
		$pricingcyclesbuttonurls[$buttonURLs_count-1] = str_replace("}", "", $pricingcyclesbuttonurls[$buttonURLs_count-1]);

		// create variable that will be passed to JavaScript
		$pricingCyclesJS = array();
		foreach($pricingcyclesids as $index=>$cycleid) {
			$pricingCyclesJS[$cycleid] = array(
				"columns" => array(
					"prices" => explode("|", $pricingcyclesprices[$index]),
					"button_urls" => explode("|", $pricingcyclesbuttonurls[$index]),
				),
			);
		}
		ob_start();
		?>
		<script type="text/javascript">
			if(typeof(pricingCycles)==="undefined") 
			{
				var pricingCycles = {};
			}
			<?php
			foreach($pricingCyclesJS as $cycle_id=>$cycle_prices) 
			{
				echo "pricingCycles['{$id}-{$cycle_id}'] = JSON.parse('" . json_encode($cycle_prices) . "');";
			}
			?>
		</script>
		<?php
		$output .= ob_get_clean();
	} 
	$paddingsTop = array_filter(explode("|", $paddingstop), 'filterArray');
	$paddingsBottom = array_filter(explode("|", $paddingsbottom), 'filterArray');
	$texts = explode("|", $texts);
	for($i=0; $i<count($texts); $i++)
		$texts[$i] = html_entity_decode(str_replace("&#39;", "'", $texts[$i]));
	$tooltips = explode("|", $tooltips);
	for($i=0; $i<count($tooltips); $i++)
		$tooltips[$i] = str_replace("&#93;", "]", str_replace("&#91;", "[", str_replace("&#39;", "'", $tooltips[$i])));
	if((int)$slidingcolumns && (int)$visiblecolumns>0)
	{
		$css3_grid_load_js = 1;
		if((int)$kind==1)
			$hovertype = "disabled";
	}
	if((int)$hiddenrows>0)
		$css3_grid_load_expand_collapse = 1;
	//$output = '<link rel="stylesheet" type="text/css" href="' . plugins_url('table' . $kind . '/main.css', __FILE__) . '"/>';
	//$output .= '<link rel="stylesheet" type="text/css" href="' . plugins_url('table' . $kind . '/style_' . $style . '.css', __FILE__) . '"/>';
	if((int)$slidingcolumns && (int)$visiblecolumns>0)
	{
		if((int)$slidingpagination && ($slidingpaginationposition=="top" || $slidingpaginationposition=="both"))
			$output .= "<div class='css3_grid_pagination css3_grid_" . $id . "_pagination css3_grid_pagination_" . $slidingpaginationstyle . "'></div>";
		$output .= "<div id='css3_grid_" . $id . "_slider_container' class='css3_grid_slider_container css3_grid_clearfix" . ($top_margin!="none" ? " " . $top_margin : "") . "'>";
		if((int)$slidingnavigation && (int)$slidingnavigationarrows)
			$output .= "<div class='css3_grid_arrow_area'><a id='css3_grid_" . $id . "_prev' href='#css3_grid_" . $id . "_prev' class='css3_grid_slide_button_prev css3_grid_slide_button_" . $slidingarrowsstyle . "'></a></div>";
	}
	$output .= '<div id="' . $id . '" class="' . ((int)$responsive ? 'p_table_responsive ' : '') . ((int)$responsivehidecaptioncolumn ? 'p_table_hide_caption_column ' : '') . ((int)$slidingcolumns && (int)$visiblecolumns>0 ? 'p_table_sliding ' : '') . 'p_table_' . $kind . ' p_table_' . $kind . '_' . $style . ' css3_grid_clearfix' . ($hovertype!="active" ? ' p_table_hover_' . $hovertype : '') . ($top_margin!="none" && (!(int)$slidingcolumns || !(int)$visiblecolumns) ? ' ' . $top_margin : '') . '">';

	if(intval($pricingcycles)==1 && !empty($pricingcyclestitles) && !empty($pricingcyclesids) && !empty($pricingcyclesprices))
	{
		$output .= '<div class="pricing-cycle-wrapper">
				<div aria-haspopup="true" class="pricing-cycle-navigation' . (!empty($dropdownalignment) && $dropdownalignment!="left" ? ' css3_grid_' . $dropdownalignment : '') . '">
					<label>' . $pricingcyclestitles[0] . '</label>
					<span class="tabs_box_navigation_icon"></span>
					<ul class="pricing-cycle">';
			for($i=0; $i<count($pricingcyclestitles); $i++)
				$output .= '<li><a href="#' . ($pricingcyclesids[$i]) . '">' . $pricingcyclestitles[$i] . '</a></li>';
		$output .= '</ul>
				</div>
			</div>';
	}
	$countValues = array_count_values($hiddens);
	$totalColumns = $countValues["-1"];
	$currentColumn = 0;
	for($i=0; $i<$columns; $i++)
	{
		if($hiddens[$i]!=1)
		{
			if($i==0)
				$output .= '<div class="caption_column' . ((int)$actives[0]==1 && !((int)$slidingcolumns && (int)$visiblecolumns>0 && (int)$kind==1) ? ' active_column' : '') . ((int)$responsive ? ' column_' . $i . '_responsive' : '') . '"' . ($widths[0]>0 ? ' style="width: ' . $widths[0] . (substr($widths[0], -1)!="%" && substr($widths[0], -2)!="px" ? "px" : "") . ';"' : '') . '>';
			else
			{
				if($i==1 && (int)$slidingcolumns && (int)$visiblecolumns>0)
					$output .= '<div class="css3_grid_slider id-' . $id . ' autoplay-' . $slidingautoplay . ' effect-' . $slidingeffect . ' easing-' . $slidingeasing . ' duration-' . $slidingduration . ' items-' . $visiblecolumns . ' scroll-' . ((int)$scrollcolumns>0 ? (int)$scrollcolumns : (int)$visiblecolumns) . ((int)$slidingcircular ? ' circular' : '') . ((int)$slidinginfinite ? ' infinite' : '') . ((int)$slidingontouch ? ' ontouch' : '') . ((int)$slidingonmouse ? ' onmouse' : '') . ((int)$slidingontouch || (int)$slidingonmouse ? ' threshold-' . $slidingthreshold : '') . ((int)$slidingpagination ? ' slidingPagination' : '') . '">';
				$output .= '<div class="column_' . ($i%4==0 ? 4 : $i%4) . (intval($pricingcycles)==1 ? ' pc_column_' . $i : '') . ((int)$actives[$i]==1 && !((int)$slidingcolumns && (int)$visiblecolumns>0 && (int)$kind==1) ? ' active_column' : '') . ((int)$responsive ? ' column_' . $i . '_responsive' : '') . '"' . ($widths[$i]>0 ? ' style="width: ' . $widths[$i] . (substr($widths[$i], -1)!="%" && substr($widths[$i], -2)!="px" ? "px" : "") . ';"' : '') . '>';
			}
			if((int)$ribbons[$i]!=-1)
				$output .= '<div class="column_ribbon ribbon_' . $ribbons[$i] . '"></div>';
			$output .= '<ul>';
			for($j=0; $j<$rows; $j++)
			{
				if($j<2)
				{
					if($j==0)
						$output .= '<li' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) || isset($heights[$j]) || (isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) || (isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? ' style="' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) ? 'text-align: ' . $aligments[$i] . ';' : '') . (isset($heights[$j]) ? 'height: ' . (int)$heights[$j] . 'px;' . ((int)$heights[$j]==0 ? 'display: none;' : '') : '') . ((isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) ? 'padding-top: ' . $paddingsTop[$j] . 'px !important;' : '') . ((isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? 'padding-bottom: ' . $paddingsBottom[$j] . 'px !important;' : '') . '"' : '') . ' class="css3_grid_row_' . $j . ' header_row_1 align_center' . ((int)$responsive ? ' css3_grid_row_' . $j . '_responsive' : '') . ($currentColumn==0 && (int)$kind==1 ? ' radius5_topleft' : (($currentColumn==0 && $hiddens[0]==1) || ($currentColumn==1 && $hiddens[0]==-1) && (int)$kind==2 ? ' radius5_topleft' : '')) . ($currentColumn+1==$totalColumns ? ' radius5_topright' : '') . '"><span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align">' . do_shortcode(($tooltips[$j*$columns+$i]!="" ? '<span class="css3_grid_tooltip"><span>' . $tooltips[$j*$columns+$i] . '</span>' : '' ) . $texts[$j*$columns+$i] . ($tooltips[$j*$columns+$i]!="" ? '</span>' : '' )) . '</span></span></li>';
					else if($j==1)
					{
						if((int)$kind==2)
							$output .= '<li class="decor_line"></li>';
						$output .= '<li' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) || isset($heights[$j]) || (isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) || (isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? ' style="' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) ? 'text-align: ' . $aligments[$i] . ';' : '') . (isset($heights[$j]) ? 'height: ' . (int)$heights[$j] . 'px;' . ((int)$heights[$j]==0 ? 'display: none;' : '') : '') . ((isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) ? 'padding-top: ' . $paddingsTop[$j] . 'px !important;' : '') . ((isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? 'padding-bottom: ' . $paddingsBottom[$j] . 'px !important;' : '') . '"' : '') . ' class="css3_grid_row_' . $j . ' header_row_2' . ((int)$responsive ? ' css3_grid_row_' . $j . '_responsive' : '') . (($currentColumn==0 && $hiddens[0]==1) || ($currentColumn==1 && $hiddens[0]==-1) && (int)$kind==2 ? ' radius5_bottomleft' : '') . ($currentColumn+1==$totalColumns && (int)$kind==2 ? ' radius5_bottomright' : '') . ($i!=0 ? ' align_center':'') . '"><span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align">' . do_shortcode(($tooltips[$j*$columns+$i]!="" ? '<span class="css3_grid_tooltip"><span>' . $tooltips[$j*$columns+$i] . '</span>' : '' ) . $texts[$j*$columns+$i] . ($tooltips[$j*$columns+$i]!="" ? '</span>' : '' )) .  '</span></span></li>';
					}
				}
				else if($j+1==$rows)
				{
					$output .= '<li' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) || isset($heights[$j]) || (isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) || (isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? ' style="' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) ? 'text-align: ' . $aligments[$i] . ';' : '') . (isset($heights[$j]) ? 'height: ' . (int)$heights[$j] . 'px;' . ((int)$heights[$j]==0 ? 'display: none;' : '') : '') . ((isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) ? 'padding-top: ' . $paddingsTop[$j] . 'px !important;' : '') . ((isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? 'padding-bottom: ' . $paddingsBottom[$j] . 'px !important;' : '') . '"' : '') . ' class="css3_grid_row_' . $j . ' footer_row' . ((int)$responsive ? ' css3_grid_row_' . $j . '_responsive' : '') . ($currentColumn+1==$totalColumns && (int)$kind==2 ? ' radius5_bottomright' : '') . '"><span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align">' . do_shortcode((isset($tooltips[$j*$columns+$i]) && $tooltips[$j*$columns+$i]!="" ? '<span class="css3_grid_tooltip"><span>' . $tooltips[$j*$columns+$i] . '</span>' : '' ) . $texts[$j*$columns+$i] . (isset($tooltips[$j*$columns+$i]) && $tooltips[$j*$columns+$i]!="" ? '</span>' : '' )) .  '</span></span></li>';
				}
				else
				{
					$output .= '<li' . ((isset($aligments[$i]) && (int)$aligments[$i]!=-1) || isset($heights[$j]) || (isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) || (isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? ' style="' . ((int)$aligments[$i]!=-1 ? 'text-align: ' . $aligments[$i] . ';' : '') . (isset($heights[$j]) ? 'height: ' . (int)$heights[$j] . 'px;' . ((int)$heights[$j]==0 ? 'display: none;' : '') : '') . ((isset($paddingsTop[$j]) && (int)$paddingsTop[$j]>=0) ? 'padding-top: ' . $paddingsTop[$j] . 'px !important;' : '') . ((isset($paddingsBottom[$j]) && (int)$paddingsBottom[$j]>=0) ? 'padding-bottom: ' . $paddingsBottom[$j] . 'px !important;' : '') . '"' : '') . ' class="css3_grid_row_' . $j . ' row_style_' . ($i%2==0 && $j%2==0 ? ((int)$kind==1 ? '4' : '1') : ($i%2==0 && $j%2==1 ? ((int)$kind==1 ? '2' : '3'): ($i%2==1 && $j%2==0 ? ((int)$kind==1 ? '3' : '1') : ((int)$kind==1 ? '1' : '2')))) . ((int)$responsive ? ' css3_grid_row_' . $j . '_responsive' : '') . ($i>0 ? ' align_center' : '' ) . ((int)$rows-$j-2<(int)$hiddenrows ? ' css3_grid_hidden_row css3_grid_hide' : '') . '"><span class="css3_grid_vertical_align_table"><span class="css3_grid_vertical_align"><span>'. ((int)$responsive && (int)$responsivehidecaptioncolumn ? '<span class="css3_hidden_caption">' . $texts[$j*$columns] . '</span>' : '') . do_shortcode((isset($tooltips[$j*$columns+$i]) && $tooltips[$j*$columns+$i]!="" ? '<span class="css3_grid_tooltip"><span>' . $tooltips[$j*$columns+$i] . '</span>' : '' ) . $texts[$j*$columns+$i] . (isset($tooltips[$j*$columns+$i]) && $tooltips[$j*$columns+$i]!="" ? '</span>' : '' )) . '</span></span></span></li>';
				}
			}
			$output .= '</ul></div>';
			$currentColumn++;
		}
	}
	if((int)$slidingcolumns && (int)$visiblecolumns>0)
		$output .= '</div>';
	if((int)$hiddenrows>0)
		$output .= "<a class='css3_grid_hidden_rows_control css3_grid_hidden_rows_control_p_table_" . $kind . "_" . $style ." css3_grid_hidden_rows_control_" . $id . "' href='#'><span class='css3_grid_hidden_rows_control_expand_text'>" . $hiddenrowsbuttonexpandtext . "</span><span class='css3_grid_hidden_rows_control_collapse_text css3_grid_hide'>" . $hiddenrowsbuttoncollapsetext . "</span></a>";
	
	$output .= "</div>";
	if((int)$slidingcolumns && (int)$visiblecolumns>0)
	{
		if((int)$slidingnavigation && (int)$slidingnavigationarrows)
			$output .= "<div class='css3_grid_arrow_area'><a id='css3_grid_" . $id . "_next' href='#css3_grid_" . $id . "_next' class='css3_grid_slide_button_next css3_grid_slide_button_" . $slidingarrowsstyle . "'></a></div>";
		$output .= "</div>";
	}
	if((int)$slidingcolumns && (int)$visiblecolumns>0)
	{
		if((int)$slidingpagination && ($slidingpaginationposition=="bottom" || $slidingpaginationposition=="both"))
			$output .= "<div class='css3_grid_pagination css3_grid_" . $id . "_pagination css3_grid_pagination_" . $slidingpaginationstyle . "'></div>";
	}
	$css3_grid_shortcode_used = true;
	return $output;
}
add_shortcode('css3_grid_print', 'css3_grid_print_shortcode');

/**
 * Configure Visual Composer pricing table component
 * @global type $wpdb
 */
function css3_grid_vc_init()
{
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	if(!is_plugin_active("js_composer/js_composer.php") || !function_exists('vc_map'))
		return;
	global $wpdb;
	//get pricing tables list
	$query = "SELECT option_name FROM {$wpdb->options}
			WHERE 
			option_name LIKE 'css3_grid_shortcode_settings%'
			ORDER BY option_name";
	$pricing_tables_list = $wpdb->get_results($query);
	$css3GridAllShortcodeIds = array();
	$css3GridAllShortcodeIds["none"] = "none";
	foreach($pricing_tables_list as $pricing_table)
		$css3GridAllShortcodeIds[substr($pricing_table->option_name, 29)] = substr($pricing_table->option_name, 29);
	
	vc_map( array(
		"name" => __("Pricing Table", 'css3_grid'),
		"base" => "css3_grid",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-pricing-table",
		'admin_enqueue_css' => array(plugins_url('admin/style.css', __FILE__)),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Id", 'css3_grid'),
				"param_name" => "id",
				"value" => $css3GridAllShortcodeIds
			)
		)
	));
}
add_action("init", "css3_grid_vc_init"); 

function css3_grid_implode_entry($entry)
{
	return implode("|", $entry);
}

/**
* Assigns $var to $target array
* @param type $target - array that will be filled with new data
* @param type $var - variable used to fill the above array
*/
function assign_var(&$target, $var)
{
	$key = key($var);
	if(is_array($var[$key]))
		assign_var($target[$key], $var[$key]);
	else
	{
		if($key===0)
			$target[] = $var[$key];
		else
			$target[$key] = $var[$key];
	}
}
?>