<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');


class SHOPEXTRA_Translations {
    
    private $options = [];

    public function __construct()
    {
        $this->options = get_option('shop_extra_options', []);
        
        if ( !$this->options['shop_extra_translations_enable']  ) {
			return;
		}
		
		add_filter( 'gettext', array($this, 'shop_extra_wc_translations'), 999, 3);
		add_filter( 'woocommerce_shipping_package_name', array($this, 'shop_extra_shipping_translations'), 10, 2);
		add_filter( 'wc_add_to_cart_message_html', array($this, 'shop_extra_added_to_cart_translations'), 10, 3 );
		
		add_filter( 'woocommerce_product_tabs', array($this, 'shop_extra_rename_tab_titles'), 99, 1 );
		
		add_filter( 'woocommerce_checkout_fields', array($this, 'shop_extra_wc_checkout_change_text') );
    }
    
    
    public function shop_extra_wc_translations($translated, $untranslated, $domain)
    {
        
        $lang = get_locale();
        
        if ($lang == 'en-US' || $lang == 'en_AU' || $lang == 'en_CA' || $lang == 'en_GB' || $lang == 'en-ZA' ) {
            $translate = $translated;
        } else {
            $translate = $untranslated;
        }
        
        /**
         * adapted from https://businessbloomer.com/?p=162
         */
        
        if ( !$this->options['shop_extra_translations_enable']  ) {
			return $untranslated;
		}
        
	    if ( ! is_admin() && 'woocommerce' == $domain ) { // with woocommerce textdomain filter

            switch ( strtolower( $translate ) ) {
            
            case 'add to cart' :
                if ( !empty( $this->options['shop_extra_translate_add_to_cart'])  ) {
                    $add_to_cart_text = $this->options['shop_extra_translate_add_to_cart'];
			        $translated = esc_html($add_to_cart_text);
		        }
                break;
                
            case 'select options' :
                if ( !empty( $this->options['shop_extra_translate_select_options'])  ) {
                    $select_options_text = $this->options['shop_extra_translate_select_options'];
			        $translated = esc_html($select_options_text);
		        }
                break;
					
			case 'read more' :
                if ( !empty( $this->options['shop_extra_translate_read_more'])  ) {
                    $read_more_text = $this->options['shop_extra_translate_read_more'];
			        $translated = esc_html($read_more_text);
		        }
                break;
            
            case 'checkout' :
                if ( !empty( $this->options['shop_extra_translate_checkout'])  ) {
                    $checkout_text = $this->options['shop_extra_translate_checkout'];
			        $translated = esc_html($checkout_text);
		        }
                break;
            
            case 'view cart' :
                if ( !empty( $this->options['shop_extra_translate_view_cart'])  ) {
                    $view_cart_text = $this->options['shop_extra_translate_view_cart'];
			        $translated = esc_html($view_cart_text);
		        }
                break;
                
            case 'proceed to checkout' :
                if ( !empty( $this->options['shop_extra_translate_proceed_to_checkout'])  ) {
                    $proceed_to_checkout_text = $this->options['shop_extra_translate_proceed_to_checkout'];
			        $translated = esc_html($proceed_to_checkout_text);
		        }
                break;
            
            /* start checkout page translations */
            
            case 'billing details' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_billing_details'])  ) {
                    $billing_details_text = $this->options['shop_extra_translate_checkout_page_billing_details'];
			        $translated = esc_html($billing_details_text);
		        }
                break;
            
            case 'first name' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_first_name'])  ) {
                    $first_name_text = $this->options['shop_extra_translate_checkout_page_first_name'];
			        $translated = esc_html($first_name_text);
		        }
                break;
            
            case 'last name' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_last_name'])  ) {
                    $last_name_text = $this->options['shop_extra_translate_checkout_page_last_name'];
			        $translated = esc_html($last_name_text);
		        }
                break;
            
            case 'country / region' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_country_region'])  ) {
                    $country_region_text = $this->options['shop_extra_translate_checkout_page_country_region'];
			        $translated = esc_html($country_region_text);
		        }
                break;
            
            case 'street address' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_street_address'])  ) {
                    $street_address_text = $this->options['shop_extra_translate_checkout_page_street_address'];
			        $translated = esc_html($street_address_text);
		        }
                break;
            
            case 'town / city' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_town_city'])  ) {
                    $town_city_text = $this->options['shop_extra_translate_checkout_page_town_city'];
			        $translated = esc_html($town_city_text);
		        }
                break;
            
            case 'state' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_state'])  ) {
                    $state_text = $this->options['shop_extra_translate_checkout_page_state'];
			        $translated = esc_html($state_text);
		        }
                break;
            
            case 'zip code' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_zip_code'])  ) {
                    $zip_code_text = $this->options['shop_extra_translate_checkout_page_zip_code'];
			        $translated = esc_html($zip_code_text);
		        }
                break;
            
            case 'phone' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_phone'])  ) {
                    $phone_text = $this->options['shop_extra_translate_checkout_page_phone'];
			        $translated = esc_html($phone_text);
		        }
                break;
            
            case 'email address' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_email_address'])  ) {
                    $email_address_text = $this->options['shop_extra_translate_checkout_page_email_address'];
			        $translated = esc_html($email_address_text);
		        }
                break;
            
            case 'your order' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_your_order'])  ) {
                    $your_order_text = $this->options['shop_extra_translate_checkout_page_your_order'];
                    if ( is_checkout() ) {
			            $translated = esc_html($your_order_text);
                    }
		        }
                break;
            
            case 'place order' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_place_order'])  ) {
                    $place_order_text = $this->options['shop_extra_translate_checkout_page_place_order'];
					if ( is_checkout() ) {
			        	$translated = esc_html($place_order_text);
					}
		        }
                break;
                
            case 'additional information' :
                if ( !empty( $this->options['shop_extra_translate_checkout_page_additional_info'])  ) {
                    $additional_info_text = $this->options['shop_extra_translate_checkout_page_additional_info'];
					if ( is_checkout() ) {
			        	$translated = esc_html($additional_info_text);
					}
		        }
                break;
            
            /* end checkout page translations */
            
            /* start cart & checkout page translations */
            
            case 'subtotal' :
				$subtotal_text = $this->options['shop_extra_translate_cart_checkout_page_subtotal'];
                if ( !empty( $subtotal_text )  ) {
			        $translated = esc_html($subtotal_text);
		        }
                break;
                
            case 'cart totals' :
                $cart_totals_text = $this->options['shop_extra_translate_cart_page_cart_totals'];
                if ( !empty( $cart_totals_text )  ) {
                    if ( is_cart() ) {
			            $translated = esc_html($cart_totals_text);
                    }
		        }
                break;
            
            
            /* end cart & checkout page translations */
            

          }
    	
        } // end with woocommerce textdomain filter
        
        
        if ( ! is_admin() ) {

            switch ( $translated ) { // without woocommerce textdomain filter
            
            case 'Product' :
                $product_text = $this->options['shop_extra_translate_cart_checkout_page_product'];
                if ( !empty( $product_text )  ) {
                    if ( is_cart() || is_checkout() ) {
			        	$translated = esc_html($product_text);
			        }
		        }
                break;
                
            case 'Quantity' :
                
                $quantity_text = $this->options['shop_extra_translate_cart_page_quantity'];
                if ( !empty( $quantity_text )  ) {
                    if ( is_cart() ) {
			        	$translated = esc_html($quantity_text);
			        }
		        }
                break;
            
            
            //cart page
            case 'Cart updated.' :
				
				$cart_updated_text = $this->options['shop_extra_translate_cart_page_cart_updated'];
                if ( !empty( $cart_updated_text )  ) {
                    //if ( is_cart() ) {
			        	$translated = esc_html($cart_updated_text);
			        //}
		        }
                break;
				
        
            }
            
        }
        
        return $translated;
    
    } // end shop extra translations function
    
    public function shop_extra_wc_checkout_change_text($fields) {
        
        if ( !empty( $this->options['shop_extra_translate_checkout_page_additional_info_order_notes']) ) { {
                    $fields['order']['order_comments']['label'] = __(esc_html($this->options['shop_extra_translate_checkout_page_additional_info_order_notes']), 'woocommerce');
                }
        }
        
        if ( !empty( $this->options['shop_extra_translate_checkout_page_additional_info_notes_placeholder']) ) { {
                    $fields['order']['order_comments']['placeholder'] = __(esc_html($this->options['shop_extra_translate_checkout_page_additional_info_notes_placeholder']), 'woocommerce');
                }
        }
        
        //$fields['order']['order_comments']['placeholder'] = __('Notes about your order...', 'placeholder', 'woocommerce');
        //$fields['order']['order_comments']['placeholder'] = 'Any additional notes for delivery';
        
     return $fields;

        return $fields;
    }
    
    public function shop_extra_shipping_translations($default)
    {
        $shipping_text = $this->options['shop_extra_translate_checkout_page_shipping'];
        
        if ( !empty( $shipping_text )  ) {
            return esc_html($shipping_text);
        } else {
            return $default;
        }
        
    }
    
    
    public function shop_extra_added_to_cart_translations($message, $products, $show_qty)
    {
        /**
         * adapted from https://aceplugins.com/how-to-change-the-add-to-cart-notice/
         * https://gist.github.com/JeroenSormani/f6158a8772d55f80871f2fc67304db8d#file-woocommerce-change-added-to-cart-notice-extended-php
         */
        
        $added_to_cart_text = $this->options['shop_extra_translate_single_product_added_to_cart'];
        
        if ( !empty( $added_to_cart_text )  ) {
            $new_text = $added_to_cart_text;
        } else {
            $new_text = 'has been added to your cart.';
        }
        
        $titles = array();
    	$count  = 0;
    
    	if ( ! is_array( $products ) ) {
    		$products = array( $products => 1 );
    		$show_qty = false;
    	}
    
    	if ( ! $show_qty ) {
    		$products = array_fill_keys( array_keys( $products ), 1 );
    	}
    
    	foreach ( $products as $product_id => $qty ) {
    		/* translators: %s: product name */
    		$titles[] = apply_filters( 'woocommerce_add_to_cart_qty_html', ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ), $product_id ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce' ), strip_tags( get_the_title( $product_id ) ) ), $product_id );
    		$count    += $qty;
    	}
    
    	$titles = array_filter( $titles );
    	
    	$added_text = sprintf( _n( '%s '.esc_html($new_text).'', '%s '.esc_html($new_text).'', $count, 'woocommerce' ), wc_format_list_of_items( $titles ) );
    
    	// Output success messages.
    	if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
    		$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );
    		$message   = sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( $return_to ), esc_html__( 'Continue shopping', 'woocommerce' ), esc_html( $added_text ) );
    	} else {
    		$message = sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( wc_get_cart_url() ), esc_html__( 'View cart', 'woocommerce' ), esc_html( $added_text ) );
    	}
    
    	return $message;
        
        
    }
    
    public function shop_extra_rename_tab_titles($tabs) {
		
		global $product;
		
        if ( !empty( $this->options['shop_extra_translate_single_product_description_tab'] ) ) {
            $description_title = $this->options['shop_extra_translate_single_product_description_tab'];
    	    if (isset($tabs['description'])) {
    	        $tabs['description']['title'] = esc_html__( $description_title, 'woocommerce');
    	    }
        }
		if ( !empty( $this->options['shop_extra_translate_single_product_reviews_tab'] ) ) {
            $reviews_title = $this->options['shop_extra_translate_single_product_reviews_tab'];
    	    if (isset($tabs['reviews'])) {
				$tabs['reviews']['title'] = sprintf(esc_html__('%s (%d)', 'woocommerce'), $reviews_title, $product->get_review_count());
    	    }
        }
		
		return $tabs;
		
	}
    
}