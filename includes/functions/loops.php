<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

function render_loops_button_html() {
    
    /*
    if ( current_user_can( 'manage_options' ) ) {
        return;
    }
	*/
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
		$numbers = get_option('shop_extra_options')['shop_extra_product_button_numbers'];
		$numbers = preg_split('/[\n\r]+/', $numbers);
	}

	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_images']) ) {
		$images = get_option('shop_extra_options')['shop_extra_product_button_images'];
		$images = preg_split('/[\n\r]+/', $images);
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_names']) ) {
		$names = get_option('shop_extra_options')['shop_extra_product_button_names'];
		$names = preg_split('/[\n\r]+/', trim($names));
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_before']) ) {
		$loops_button_message_before = get_option('shop_extra_options')['shop_extra_product_button_message_before'];
		/* convert message line breaks to whatsapp format */
		$loops_button_message_before = str_replace("\r", "%0D%0A", $loops_button_message_before);
	} else {
		$loops_button_message_before = 'Hi,%0D%0AI want to buy:%0D%0A';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_after']) ) {
		$loops_button_message_after = get_option('shop_extra_options')['shop_extra_product_button_message_after'];
		/* convert message line breaks to whatsapp format */
		$loops_button_message_after = str_replace("\r", "%0D%0A", $loops_button_message_after);
	} else {
		$loops_button_message_after = 'Thank you!';
	}
	
	/* grab the product info */
	global $product;
	global $post;
	$product_name = $product->get_name();
	if ( get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
		$price = wp_strip_all_tags(wc_price(wc_get_price_including_tax( $product )));
		$product_price = "$price%0D%0A";
	} else {
		$product_price = '';
	}
	if ( get_option('shop_extra_options')['shop_extra_product_button_url_enable'] ) {
		$url = urlencode( get_permalink( $product->get_id() ) );
		$product_url = "$url%0D%0A";
	} else {
		$product_url = '';
	}
	
	$loops_button_html = '<div class="shop-extra-loops-button-container">';
	
	foreach($names as $i => $name){
		
		if( isset($images[$i]) ) {
			$image = $images[$i];
		} else {
			$image = SHOPEXTRA_PUBLIC_URL . 'img/whatsapp-white.svg';
		}
		
		if( isset($numbers[$i]) ) {
			$number = $numbers[$i];
		} else {
			return;
		}
		
		$product_base_url = apply_filters( 'product_base_url', 'wa.me/' );
		
		$product_base_text = apply_filters( 'product_base_text', '?text=' );
		
		$loops_button_html .= '
			<a rel="nofollow" target="_blank" href="https://'.esc_html($product_base_url).''.esc_attr($number).''.esc_html($product_base_text).''.esc_html($loops_button_message_before).'%0D%0A*'.esc_html($product_name).'*%0D%0A'.esc_html($product_url).''.esc_attr($product_price).'%0D%0A'.esc_html($loops_button_message_after).'%0D%0A" class="button ajax_add_to_cart shop-extra-loops-whatsapp-button">
				<img width="18" height="18" alt="'.esc_html($name).'" src="'.esc_url($image).'" class="shop-extra-loops-icon">
				<span class="shop-extra-loops-label">'.esc_html($name).'</span>	
			</a>';
		
	}
	
	$loops_button_html .= '
		</div>
	
	';
	
	if ( get_option('shop_extra_options')['shop_extra_product_button_enable'] && get_option('shop_extra_options')['shop_extra_product_button_loops_enable'] && !empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) && !empty(get_option('shop_extra_options')['shop_extra_product_button_names']) ) { 

	echo wp_kses_post($loops_button_html);
 
	}
}

function loops_button_position() {
	
	if ( get_option('shop_extra_options')['shop_extra_product_button_loops_button_position'] == '1' ) {
		add_action( 'woocommerce_after_shop_loop_item', 'ShopExtra\render_loops_button_html', 10, 2 ); // after button
	}
	elseif (get_option('shop_extra_options')['shop_extra_product_button_loops_button_position'] == '2') {
		add_action( 'woocommerce_after_shop_loop_item', 'ShopExtra\render_loops_button_html', 7 ); // right before button
	}
	elseif ( get_option('shop_extra_options')['shop_extra_product_button_loops_button_position'] == '3') {
		add_action( 'woocommerce_after_shop_loop_item_title', 'ShopExtra\render_loops_button_html', 10, 2 ); // after price
	}
	else {
		add_action( 'woocommerce_after_shop_loop_item', 'ShopExtra\render_loops_button_html', 10, 2 ); // after button
	}
	
}
add_action('init', 'ShopExtra\loops_button_position', PHP_INT_MAX);
