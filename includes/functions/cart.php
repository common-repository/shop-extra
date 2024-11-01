<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

function render_cart_button_html() {
    
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
		$cart_button_message_before = get_option('shop_extra_options')['shop_extra_product_button_message_before'];
		/* convert message line breaks to whatsapp format */
		$cart_button_message_before = str_replace("\r\n", "%0D%0A", $cart_button_message_before);
	} else {
		$cart_button_message_before = 'Hi,%0D%0AI want to buy:%0D%0A';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_after']) ) {
		$cart_button_message_after = get_option('shop_extra_options')['shop_extra_product_button_message_after'];
		/* convert message line breaks to whatsapp format */
		$cart_button_message_after = str_replace("\r\n", "%0D%0A", $cart_button_message_after);
	} else {
		$cart_button_message_after = 'Thank you!';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_total']) ) {
		$total_text = get_option('shop_extra_options')['shop_extra_product_button_message_total'];
	} else {
		$total_text = 'Total';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_ship_to']) ) {
		$ship_to_text = get_option('shop_extra_options')['shop_extra_product_button_message_ship_to'];
	} else {
		$ship_to_text = 'Please ship to:';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_shipping_method']) ) {
		$shipping_method_text = get_option('shop_extra_options')['shop_extra_product_button_message_shipping_method'];
	} else {
		$shipping_method_text = 'Shipping method';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_tax']) ) {
		$tax_text = get_option('shop_extra_options')['shop_extra_product_button_message_tax'];
	} else {
		$tax_text = 'Tax';
	}
	
	if ( !empty(get_option('shop_extra_options')['shop_extra_product_button_message_grand_total']) ) {
		$grand_total_text = get_option('shop_extra_options')['shop_extra_product_button_message_grand_total'];
	} else {
		$grand_total_text = 'Grand Total';
	}
	
	$purchased_products = '';
	
	/* grab the product info */
	global $product;
	global $post;
	
	/* Getting cart items */
	$items= WC()->cart->get_cart();
	
	foreach($items as $item ) {
	    $get_product = $item['data'];
	    
		$products =  wc_get_product( $item['product_id']);
		$product_name = $products->get_name();
		
		$quantity = $item['quantity'];
		  
		$price= wp_strip_all_tags( wc_price($item['line_subtotal']) );
		
		$get_var = $item['variation_id'];
		$var = new \WC_Product_Variation($get_var);
		$variations = implode(" / ", $var->get_variation_attributes());
		$variation = ucwords($variations);
		
		$product_url  = get_post_permalink($item['product_id']);
		$cart_total =  wp_strip_all_tags( wc_price(WC()->cart->get_cart_contents_total()) );
		
		
        if ( !get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
		    $purchased_products .= '- *'.$product_name.'*';
		    if ( $products->is_type( 'variable' ) ) {
    	        $purchased_products .= ' - *'.$variation.'*';
		    }
        } else {
		    $purchased_products .= '*'.$quantity.'* x ';
            $purchased_products .= '*'.$product_name.'*';
            if ( $products->is_type( 'variable' ) ) {
    	        $purchased_products .= ' - *'.$variation.'*';
            }
        }
        
		if ( get_option('shop_extra_options')['shop_extra_product_button_url_enable'] && get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
    	    $purchased_products .= urlencode("\r\n".$product_url.' ');
        }
        
        elseif ( get_option('shop_extra_options')['shop_extra_product_button_url_enable'] && !get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
    	    $purchased_products .= urlencode("\r\n".$product_url."\r\n");
        }
		
		if ( get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
		    
		    $purchased_products .= urlencode("\r\n");
    		$purchased_products .= '@ '.$price.'  ';
    		
    		$purchased_products .= urlencode("\r\n\r\n");
    		
    		$total = urlencode("\r\n");
    		$total .= ''.$total_text.': *'.$cart_total.'*';
    		
    		
	    } else {
	        $purchased_products .= urlencode("\r\n");
	        $total = '';
	    }

		
	}
	
	/* give line break before $cart_button_message_after */
	if ( get_option('shop_extra_options')['shop_extra_product_button_url_enable'] && get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
       $total .= urlencode("\r\n");
    }
    elseif ( get_option('shop_extra_options')['shop_extra_product_button_url_enable'] && !get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
        $total .= '';
    }
    elseif ( !get_option('shop_extra_options')['shop_extra_product_button_url_enable'] && get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
        $total .= urlencode("\r\n");
    }
    
    /* start get customer info, shipping info, and total price (only if price on message enabled) */
    
    $shipping_details = '';
    
    if ( get_option('shop_extra_options')['shop_extra_product_button_price_enable'] ) {
    
        /* start get customer address info from session */
        
        $firstname = WC()->customer->get_billing_first_name();
        $lastname = WC()->customer->get_billing_last_name();
        $address_1 = WC()->customer->get_billing_address_1();
        $address_2 = WC()->customer->get_billing_address_2(); 
        $city = WC()->customer->get_billing_city();
        $get_country = WC()->customer->get_billing_country(); 
        $get_state = WC()->customer->get_billing_state();
        $phone = WC()->customer->get_billing_phone();
        
        if( !empty($city) && !empty($get_country) && !empty($get_state) ) {
            
            $country = WC()->countries->get_countries()[$get_country];
            $state = WC()->countries->get_states( $get_country )[$get_state];
            $postcode = WC()->customer->get_billing_postcode();
                
            $shipping_details .= urlencode("\r\n\r\n");
            $shipping_details .= $ship_to_text;
            if( !empty($firstname) ) {
                $shipping_details .= urlencode("\r\n");
                $shipping_details .= '*'.$firstname.'* ';
            }
            if( !empty($lastname) ) {
                $shipping_details .= '*'.$lastname.'*';
            }
            $shipping_details .= urlencode("\r\n");
            if( !empty($address_1) ) {
                $shipping_details .= '*'.$address_1.'*, ';
            }
            if( !empty($address_2) ) {
                $shipping_details .= '*'.$address_2.'*, ';
            }
            $shipping_details .= '*'.$city.'*, ';
            $shipping_details .= '*'.$state.'*, ';
            $shipping_details .= '*'.$postcode.'*, ';
            $shipping_details .= '*'.$country.'*. ';
            if( !empty($phone) ) {
                $shipping_details .= urlencode("\r\n");
                $shipping_details .= '*✆ '.$phone.'*';
            }
        	$shipping_details .= urlencode("\r\n");
            
        }
        
        /* end get customer address info from session */
        
        /* start get shipping info from session */
        
    	$get_shiping = WC()->session->get('chosen_shipping_methods');
    	
    	if( isset( $get_shiping ) ) {
    	    
        	foreach( WC()->session->get('shipping_for_package_0')['rates'] as $method_id => $rate ){
        	    
                if( $get_shiping[0] == $method_id ){
                    
            	    $shipping_label = ucwords( $rate->label );
            	    $shipping_total = WC()->cart->get_cart_shipping_total();
            	    
            	    $total_price = WC()->cart->get_total();
            	    
            	    /* The taxes cost
                    $rate_taxes = 0;
                    foreach ($rate->taxes as $rate_tax)
                        $rate_taxes += floatval($rate_tax);
                    // The cost including tax
                    $rate_cost_incl_tax = $rate_cost_excl_tax + $rate_taxes;
                    */
                    //$rate_cost_incl_tax = WC()->cart->get_total_tax();
                    $tax = WC()->cart->get_cart_tax();
            	    
            	    $shipping_details .= urlencode("\r\n");
            	    $shipping_details .= $shipping_method_text;
            	    $shipping_details .= ': *'.$shipping_label.'* - ';
            	    $shipping_details .= wp_strip_all_tags($shipping_total);
            	    if ( get_option('woocommerce_calc_taxes') == 'yes' ) {
            	        $shipping_details .= urlencode("\r\n");
            	        $shipping_details .= $tax_text;
            	        $shipping_details .= ': *'.wp_strip_all_tags($tax).'*';
            	        $shipping_details .= urlencode("\r\n");
            	    }
            	    $shipping_details .= urlencode("\r\n");
            	    $shipping_details .= urlencode("\r\n");
            	    $shipping_details .= $grand_total_text;
            	    $shipping_details .= ': *'.wp_strip_all_tags($total_price).'*';
            	    $shipping_details .= urlencode("\r\n\r\n");
        		}
        	}
    	}
    	/* end get shipping info from session */
    }
    
    /* end get customer info, shipping info, and total price (only if price on message enabled) */
	
	/* replace spaces & line breaks to whatsapp format before rendered to html */
	
	$cart_button_message_before = str_replace( " ", '+', $cart_button_message_before );
	$cart_button_message_before = str_replace( "\r\n", '%0D%0A', $cart_button_message_before );
	$purchased_products = str_replace( " ", '+', $purchased_products );
	$purchased_products = str_replace( "\r\n", '%0D%0A', $purchased_products );
	$total = str_replace( " ", '+', $total );
	$total = str_replace( "\r\n", '%0D%0A', $total );
	$shipping_details = str_replace( " ", '+', $shipping_details );
	$shipping_details = str_replace( "\r\n", '%0D%0A', $shipping_details );
	$cart_button_message_after = str_replace( " ", '+', $cart_button_message_after );
	$cart_button_message_after = str_replace( "\r\n", '%0D%0A', $cart_button_message_after );
	
	/* start rendering button html */
	
	$cart_button_html = '<div class="shop-extra-cart-button-container wc-proceed-to-checkout">';
	
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
		
		$cart_button_html .= '
		<a rel="nofollow" target="_blank" href="https://'.esc_html($product_base_url).''.esc_attr($number).''.esc_html($product_base_text).''.esc_html($cart_button_message_before).'%0D%0A'.esc_html($purchased_products).''.esc_html($total).''.esc_html($shipping_details).'%0D%0A'.esc_html($cart_button_message_after).'%0D%0A" class="checkout-button button alt wc-forward shop-extra-cart-whatsapp-button">
			<img width="18" height="18" alt="'.esc_html($name).'" src="'.esc_url($image).'" class="shop-extra-cart-icon">
			<span class="shop-extra-cart-label">'.esc_html($name).'</span>	
		</a>';

	}
	
	$cart_button_html .= '
	</div>
	
	';
	
	if ( get_option('shop_extra_options')['shop_extra_product_button_enable'] && get_option('shop_extra_options')['shop_extra_product_button_cart_enable'] && !empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) && !empty(get_option('shop_extra_options')['shop_extra_product_button_names']) ) { 

	echo wp_kses_post($cart_button_html);
 
	}
}

function cart_button_position() {
	
	if ( get_option('shop_extra_options')['shop_extra_product_button_cart_button_position'] == '1' ) {
		add_action( 'woocommerce_after_cart_totals', 'ShopExtra\render_cart_button_html', 10, 2 ); // after checkout button
	}
	elseif ( get_option('shop_extra_options')['shop_extra_product_button_cart_button_position'] == '2') {
		if ( get_option('shop_extra_options')['shop_extra_product_button_cart_proceed_hide'] ) {
			add_action( 'woocommerce_after_cart_totals', 'ShopExtra\render_cart_button_html', 10, 2 ); // after checkout button
		} else {
			add_action( 'woocommerce_proceed_to_checkout', 'ShopExtra\render_cart_button_html', 10, 2 ); // before checkout button
		}
	}
	elseif (get_option('shop_extra_options')['shop_extra_product_button_cart_button_position'] == '3') {
		//add_action( 'woocommerce_cart_totals_after_order_total', 'render_cart_button_html', 99 ); // after total price *not working
		add_action( 'woocommerce_before_cart_totals', 'ShopExtra\render_cart_button_html', 99 ); // before cart totals
	}
	else {
		add_action( 'woocommerce_after_cart_totals', 'ShopExtra\render_cart_button_html', 10, 2 ); // after button
	}
	
}
add_action('init', 'ShopExtra\cart_button_position', PHP_INT_MAX);


function empty_cart_after_clicked() {
	WC()->cart->empty_cart();
}

add_action('wp_ajax_clear_cart', 'ShopExtra\empty_cart_after_clicked' );
add_action('wp_ajax_nopriv_clear_cart', 'ShopExtra\empty_cart_after_clicked' );