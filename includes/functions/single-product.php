<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

function render_single_product_button_html() {
    
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
		$single_button_message_before = get_option('shop_extra_options')['shop_extra_product_button_message_before'];
		/* convert message line breaks to whatsapp format */
		$single_button_message_before = str_replace("\r", "%0D%0A", $single_button_message_before);
		$single_button_message_before = str_replace( " ", "+", $single_button_message_before );
	} else {
		$single_button_message_before = 'Hi,%0D%0AI want to buy:%0D%0A';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_after']) ) {
		$single_button_message_after = get_option('shop_extra_options')['shop_extra_product_button_message_after'];
		/* convert message line breaks to whatsapp format */
		$single_button_message_after = str_replace("\r", "%0D%0A", $single_button_message_after);
	} else {
		$single_button_message_after = 'Thank you!';
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
	
	$single_button_html = '<div class="shop-extra-single-product-button-container">';
	
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
		
		$single_button_html .= '
			<a rel="nofollow" target="_blank" href="https://'.esc_html($product_base_url).''.esc_attr($number).''.esc_html($product_base_text).''.esc_html($single_button_message_before).'%0D%0A*'.esc_html($product_name).'*%0D%0A'.esc_html($product_url).''.esc_attr($product_price).'%0D%0A'.esc_html($single_button_message_after).'%0D%0A" class="button alt shop-extra-single-whatsapp-button">
				<img width="18" height="18" alt="'.esc_html($name).'" src="'.esc_url($image).'" class="shop-extra-single-product-icon">
				<span class="shop-extra-single-product-label">'.esc_html($name).'</span>	
			</a>';
		
	}
	
	$single_button_html .= '
		</div>
	
	';
	
	if ( get_option('shop_extra_options')['shop_extra_product_button_enable'] && get_option('shop_extra_options')['shop_extra_product_button_single_enable'] && !empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) { 

	    echo wp_kses_post($single_button_html);
 
	}
}

function purchasable_button_position() {
	
	if ( get_option('shop_extra_options')['shop_extra_product_button_single_button_position'] == '1' ) {
		add_action( 'woocommerce_after_add_to_cart_button', 'ShopExtra\render_single_product_button_html', 10, 2 );
	}
	elseif ( get_option('shop_extra_options')['shop_extra_product_button_single_button_position'] == '2') {
		add_action( 'woocommerce_before_add_to_cart_form', 'ShopExtra\render_single_product_button_html', 10, 2 );
	}
	elseif (get_option('shop_extra_options')['shop_extra_product_button_single_button_position'] == '3') {
		add_action( 'woocommerce_after_add_to_cart_form', 'ShopExtra\render_single_product_button_html', 10, 2 );
	}
	else {
		add_action( 'woocommerce_after_add_to_cart_button', 'ShopExtra\render_single_product_button_html', 10, 2 );
	}
	
}
add_action('init', 'ShopExtra\purchasable_button_position', PHP_INT_MAX);

function non_purchasable_button_position() {
    
		global $product;
		
		if ( !$product->is_purchasable() || !$product->is_in_stock() ) {
			return render_single_product_button_html();
		}
		
	}
add_action( 'woocommerce_product_meta_start', 'ShopExtra\non_purchasable_button_position', 10, 2 );
