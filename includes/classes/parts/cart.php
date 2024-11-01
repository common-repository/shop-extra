<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Cart {
    
    private static $_instance;
    
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
		
		add_action('wp_enqueue_scripts', array($this, 'cart_styling_init'), 999);
		add_action('wp_print_footer_scripts', array($this, 'cart_script_init'), 999);
		
		
    }
    
    public function cart_styling_init()
    {

        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] || !get_option('shop_extra_options')['shop_extra_product_button_cart_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
        
		return $this->cart_styling();
		
    }
    
    private function cart_styling()
    {
        
        if ( !is_cart() ) {
            return;
        }
        
        $hide_css = 'overflow: hidden;
		clip: rect(1px,1px,1px,1px);
		position: absolute;
		width: 1px;
		height: 1px;
		margin: -1px;
		padding: 0;
		border: 0;
		top: -999vh;
		left: -999vw;
		content-visibility: hidden;
		display: none';
		
		wp_register_style( SHOPEXTRA_HANDLER.'-cart', false);
		wp_enqueue_style( SHOPEXTRA_HANDLER.'-cart' );
		
		/* whatsapp button container style */
		$shop_extra_single_button_container_style = '.shop-extra-cart-button-container{display:flex;flex-direction:row;flex-wrap:wrap;gap:.25em;min-width:100%}';
		
		$inline_style = esc_attr($shop_extra_single_button_container_style);
		
		$inline_style .= '.woocommerce-cart .shop-extra-cart-button-container a.shop-extra-cart-whatsapp-button{display:flex;align-items:center;justify-content:center;min-width:fit-content;flex:1 1 0}.shop-extra-cart-icon{width:1.2em;height:1.2em;margin-right:.45em}';
		
		$inline_style .= '.woocommerce-cart .wc-proceed-to-checkout.shop-extra-cart-button-container a.checkout-button{margin-bottom:0}.woocommerce-cart .shop-extra-cart-button-container:before,.woocommerce-cart .shop-extra-cart-button-container:after{display:none}';
		
		if ( !get_option('shop_extra_options')['shop_extra_product_button_cart_proceed_hide'] ) {
		    
		    $inline_style .= '.woocommerce-cart .wc-proceed-to-checkout{padding-bottom:0.25em}.woocommerce-cart .wc-proceed-to-checkout a.checkout-button{margin-bottom:.25em}';
		    
		    $inline_style .= '.wc-proceed-to-checkout.shop-extra-cart-button-container{padding:0}';
		    
		}
		
		$names = get_option('shop_extra_options')['shop_extra_product_button_names'];
		$names = preg_split('/[\n\r]+/', trim($names));	
		
		/* count the names to add extra styling */
		$a = 1;
		$b = count($names);
		
		// check if the active theme is Blocksy
    	$blocksy = wp_get_theme( 'blocksy' );
		
		/* add style to the button container if the number is is after add to cart */
		if ( get_option('shop_extra_options')['shop_extra_product_button_cart_button_position'] == '1' ) {
			if ( $blocksy->exists() ) {
				$inline_style .= '.ct-cart-form .cart_totals .wc-proceed-to-checkout.shop-extra-cart-button-container{margin-top:.25em}';
			} else {
				$inline_style .= '.shop-extra-cart-button-container{margin-top:.25em}';
			}
		}
		
		/* add style to the button container if the number is more than one */
		if ( $b > $a ) {
			//$inline_style .= '.shop-extra-cart-button-container a.button{flex:1 1 0}';
		}
		
		/* add style to the button container if the number is is after price */
		if ( get_option('shop_extra_options')['shop_extra_product_button_cart_button_position'] == '2' ) {
			$inline_style .= '.shop-extra-cart-button-container{margin:.25em 0}';
			if ( $blocksy->exists() ) {
				$inline_style .= '.shop-extra-cart-button-container{margin-bottom:.75em}';
			}
		}
		
		/* add style to the button container if the number is is right before add to cart */
		if ( get_option('shop_extra_options')['shop_extra_product_button_cart_button_position'] == '3' ) {
			$inline_style .= '.shop-extra-cart-button-container{margin-bottom:.25em}';
			$inline_style .= '.wc-proceed-to-checkout.shop-extra-cart-button-container{padding-bottom:1em}';
			if ( $blocksy->exists() ) {
				$inline_style .= '.ct-cart-form .cart_totals .wc-proceed-to-checkout.shop-extra-cart-button-container{margin-top:.75em}';
			}
		}
		
		/* hide the proceed to checkout using $hide_css */
    	if ( get_option('shop_extra_options')['shop_extra_product_button_cart_proceed_hide'] ) {
    		$inline_style .= '.woocommerce-cart .wc-proceed-to-checkout:not([class*="shop-extra-"]){'.esc_attr($hide_css).'}';
    	}
		
		// minify the inline style before inject
		$inline_style = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',],$inline_style);
		
		/* inject above styles */
		wp_add_inline_style( SHOPEXTRA_HANDLER.'-cart', wp_kses_data($inline_style) );
		
		
    }
    
    public function cart_script_init()
    {

        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] || !get_option('shop_extra_options')['shop_extra_product_button_cart_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
        
		return $this->cart_script();
		
    }
    
    private function cart_script()
    {

        if ( !is_cart() ) {
            return;
        }
        
        
        if ( !get_option('shop_extra_options')['shop_extra_product_button_cart_proceed_hide'] ) {
            return;
        }
        
		$inline_script = '(function( $ ) {
    	"use strict";
        	$(function() {
        		$(".shop-extra-cart-whatsapp-button").on("click", function(e) {
        			$.ajax({
                        type: "post",
                        url: woocommerce_params["ajax_url"],
                        data: {
                            action: "clear_cart",
                        },
                        success: function(data) {
                                location.reload();
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    })
        		});
        	});
        })( jQuery );
        ';
		
        
    	// minify the inline script before inject
		$inline_script = preg_replace(['/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/','/\>[^\S ]+/s','/[^\S ]+\</s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si'],['','>','<','$1$2$3$4$5$6$7'], $inline_script);
    
        $inline_script_handle = SHOPEXTRA_HANDLER.'-cart-js';
    
        $shop_extra_inline_script =
            '<script id="%s">%s</script>' . PHP_EOL;
            
        printf(
            $shop_extra_inline_script,
            esc_html($inline_script_handle),
            wp_kses_data($inline_script)
        );
        
    }
    
	
}

// Init
SHOPEXTRA_Cart::getInstance();