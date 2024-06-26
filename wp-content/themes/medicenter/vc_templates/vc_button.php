<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
extract( shortcode_atts( array(
	'style' => 'light',
	'color' => '#3156A3',
	'text_color' => '#666666',
	'hover_text_color' => '#FFFFFF',
	'custom_button_color' => '',
	'hover_color' => '#3156A3',
	'custom_button_hover_color' => '',
	'size' => '',
	'icon' => 'none',
	'target' => '_self',
	'href' => '',
	'el_class' => '',
	'title' => __( 'Text on the button', "medicenter" ),
	'label' => '',
	'position' => '',
	'top_margin' => 'none'
), $atts ) );
$a_class = '';

if ( $el_class != '' ) {
	$tmp_class = explode( " ", strtolower( $el_class ) );
	$tmp_class = str_replace( ".", "", $tmp_class );
	if ( in_array( "prettyphoto", $tmp_class ) ) {
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );
		$a_class .= ' prettyphoto';
		$el_class = str_ireplace( "prettyphoto", "", $el_class );
	}
	if ( in_array( "pull-right", $tmp_class ) && $href != '' ) {
		$a_class .= ' pull-right';
		$el_class = str_ireplace( "pull-right", "", $el_class );
	}
	if ( in_array( "pull-left", $tmp_class ) && $href != '' ) {
		$a_class .= ' pull-left';
		$el_class = str_ireplace( "pull-left", "", $el_class );
	}
}

if ( $target == 'same' || $target == '_self' ) {
	$target = '';
}
$target = ( $target != '' ) ? ' target="' . $target . '"' : '';

$icon_orig = $icon;

$color = ($custom_button_color!='' ? $custom_button_color : $color);
$hover_color = ($custom_button_hover_color!='' ? $custom_button_hover_color : $hover_color);
$size = ( $size != '' && $size != 'wpb_regularsize' ) ? ' ' . $size : ' ' . $size;
$icon = ( $icon != '' && $icon != 'none' ) ? ' '.$icon : '';
$i_icon = ( $icon != '' ) ? ' <i class="icon"> </i>' : '';
$position = ( $position != '' ) ? ' ' . $position . '-button-position' : '';
$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_button ' . $color . $size . $icon . $el_class . $position, $this->settings['base'], $atts );

$output .= ($label!="" ? '<h2><span class="button-label">' . $label . '</span>' : '') . '<a' . (!empty($style) && $style=="custom" ? ' style="color:'.esc_attr($text_color).';background-color:'.esc_attr($color).';border-color:'.($color=="transparent" ? '#E5E5E5' : esc_attr($color)).';" onMouseOver="this.style.color=\''.esc_attr($hover_text_color).'\';this.style.backgroundColor=\''.esc_attr($hover_color).'\';this.style.borderColor=\''.($hover_color=="transparent" ? '#E0E0E0' : $hover_color).'\'" onMouseOut="this.style.color=\''.esc_attr($text_color).'\';this.style.backgroundColor=\''.esc_attr($color).'\';this.style.borderColor=\''.($color=="transparent" ? '#E0E0E0' : $color).'\'"' : '') . ' title="'.esc_attr($title).'" href="'.esc_attr($href).'"'.esc_attr($target).' class="mc-button more'.(!empty($style) && $style!="custom" ? ' ' . esc_attr($style) : '').esc_attr($size).esc_attr($icon).esc_attr($el_class).esc_attr($position).esc_attr($a_class).($top_margin!='none' ? ' ' . esc_attr($top_margin) : '').'">'.$title.(substr($icon_orig, 0, 8)!="template" ? $i_icon : '').'</a>' . ($label!="" ? '</h2>' : '');


echo $output . $this->endBlockComment( 'button' ) . "\n";