<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

function render_floating_button_html($floating_html) {
    
    /*
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
	*/
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_floating_button_image']) ) {
		$chat_button = get_option('shop_extra_options')['shop_extra_floating_button_image'];
	} else {
		$chat_button = SHOPEXTRA_PUBLIC_URL . 'img/whatsapp-white.svg';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_floating_heading_image']) ) {
		$heading_image = get_option('shop_extra_options')['shop_extra_floating_heading_image'];
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_floating_images']) ) {
		$images = get_option('shop_extra_options')['shop_extra_floating_images'];
		$images = preg_split('/[\n\r]+/', $images);
		
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_floating_numbers']) ) {
		$numbers = get_option('shop_extra_options')['shop_extra_floating_numbers'];
		$numbers = preg_split('/[\n\r]+/', $numbers);
		
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_floating_names']) ) {
		$names = get_option('shop_extra_options')['shop_extra_floating_names'];
		$names = preg_split('/[\n\r]+/', trim($names));
	}
	
    $tooltip = get_option('shop_extra_options')['shop_extra_floating_tooltip'];
    $tooltip = str_replace([
            	"\'"],
                ["'"],
        	$tooltip);
        	
    $title = get_option('shop_extra_options')['shop_extra_floating_heading_title'];
    $title = str_replace([
            	"\'"],
                ["'"],
        	$title);
    
	$floating_prefilled_message = get_option('shop_extra_options')['shop_extra_floating_prefilled_message'];
	
	if (!empty($floating_prefilled_message)) {
		$whatsapp_pretext_html = '?text=';
		$prefilled_message_html = $floating_prefilled_message;
	} else {
		$whatsapp_pretext_html = '';
		$prefilled_message_html = '';
	}
	
	$floating_html = '
<div id="shop-extra-floating-button" class="shop-extra-floating-button">
	<img width="63" height="63" src="'.esc_url($chat_button).'" alt="whatsapp chat button" class="shop-extra-floating-button-img">
	';
	
	if (!empty(get_option('shop_extra_options')['shop_extra_floating_tooltip'])) {
	$floating_html .= '<div class="shop-extra-floating-tooltip-container">	
		<p class="shop-extra-floating-tooltip">'.esc_html($tooltip).'</p>
	</div>';
	}
	
	$floating_html .= '
</div>
<div id="shop-extra-floating-wrapper" class="shop-extra-floating-popup">
	<div class="shop-extra-floating-popup-container">
	';
	
	if (!empty(get_option('shop_extra_options')['shop_extra_floating_heading_title'])) {
	$floating_html .= '	<div class="shop-extra-floating-popup-heading-container">
	';
	
		if (!empty(get_option('shop_extra_options')['shop_extra_floating_heading_image'])) {
		$floating_html .= '		<div class="shop-extra-floating-popup-heading-image-container">
				<img width="53" height="53" src="'.esc_url($heading_image).'" alt="whatsapp chat heading image" class="shop-extra-floating-popup-heading-image">
			</div>
			';
		}
		$floating_html .= '<div class="shop-extra-floating-popup-heading-text-container">
				<p class="shop-extra-floating-popup-heading">'.esc_html($title).'</p>
				<p class="shop-extra-floating-popup-description">'.esc_html(get_option('shop_extra_options')['shop_extra_floating_heading_description']).'</p>
			</div>
		</div>
		';		
	}
	$floating_html .= '<div class="shop-extra-floating-account-container-padding">
			<div class="shop-extra-floating-account-container">';
		
	
	foreach($names as $i => $name){
    	
		if( isset($images[$i]) ) {
			$image = $images[$i];
		} else {
			$image = SHOPEXTRA_PUBLIC_URL . 'img/whatsapp-black.svg';
		}
		
		if( isset($numbers[$i]) ) {
			$number = $numbers[$i];
		} else {
			return;
		}
		
		$floating_html .= '
				<div class="shop-extra-floating-account">
					<a rel="nofollow" target="_blank" href="https://wa.me/'.esc_attr($number).''.esc_html($whatsapp_pretext_html).''.esc_html($floating_prefilled_message).'" role="button" class="shop-extra-floating-account-number">
						<img width="52" height="52" src="'.esc_url($image).'" alt="whatsapp chat account avatar" class="shop-extra-floating-number-img">
						<p class="shop-extra-floating-number-account-label">'.esc_html($name).'</p>
					</a>
				</div>';
		
	}
	
	$floating_html .= '
			</div>';
			
	if (!empty(get_option('shop_extra_options')['shop_extra_floating_availability'])) {
		$floating_html .= '<p class="shop-extra-floating-availability"></p>';
	}
	
	$floating_html .= '
				</div>
		<span class="shop-extra-popup-close">&times;</span>
	</div>
</div>
	';
	
	if ( get_option('shop_extra_options')['shop_extra_floating_enable'] && !empty(get_option('shop_extra_options')['shop_extra_floating_numbers']) && !empty(get_option('shop_extra_options')['shop_extra_floating_names']) ) { 
	
		echo htmlspecialchars_decode(wp_kses_post($floating_html));
		
	}
}
add_action('wp_footer', 'ShopExtra\render_floating_button_html', 10, 2);