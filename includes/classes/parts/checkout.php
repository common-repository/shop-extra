<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Checkout {
    
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
		
		add_action('wp_enqueue_scripts', array($this, 'checkout_styling_init'), 999);
		add_action('wp_print_footer_scripts', array($this, 'checkout_script_init'), 999);
		
    }
    
    public function checkout_styling_init()
    {

        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] || !get_option('shop_extra_options')['shop_extra_product_button_checkout_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
        
		return $this->checkout_styling();
		
    }

    
    private function checkout_styling()
    {

        if ( !is_checkout() ) {
            return;
        }
        
        wp_register_style( SHOPEXTRA_HANDLER.'-checkout', false);
		wp_enqueue_style( SHOPEXTRA_HANDLER.'-checkout' );
		
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
		
		/* whatsapp button container style */
		$shop_extra_single_button_container_style = '.shop-extra-checkout-button-container{display:flex;flex-direction:row;flex-wrap:wrap;gap:.25em;min-width:100%}';
		
		$inline_style = esc_attr($shop_extra_single_button_container_style);
		
		$inline_style .= '.woocommerce-checkout .shop-extra-checkout-button-container a.shop-extra-checkout-whatsapp-button{display:flex;align-items:center;justify-content:center;min-width:fit-content;flex:1 1 0}.shop-extra-checkout-icon{width:1.2em;height:1.2em;margin-right:.45em}';
		
		$inline_style .= '.woocommerce-checkout .wc-proceed-to-checkout.shop-extra-checkout-button-container a.checkout-button{margin-bottom:0}.woocommerce-checkout .shop-extra-checkout-button-container:before,.woocommerce-checkout .shop-extra-checkout-button-container:after{display:none}.wc-proceed-to-checkout.shop-extra-checkout-button-container{padding:0}';
		
		$inline_style .= 'a.shop-extra-checkout-whatsapp-button[disabled] {
		    pointer-events: none;
		    opacity: .735
		}';
		
		
		$names = get_option('shop_extra_options')['shop_extra_product_button_names'];
		$names = preg_split('/[\n\r]+/', trim($names));	
		
		/* count the names to add extra styling */
		$a = 1;
		$b = count($names);
		
		/* add style to the button container if the number is is after add to checkout */
		if ( get_option('shop_extra_options')['shop_extra_product_button_checkout_button_position'] == '1' ) {
			$inline_style .= '.shop-extra-checkout-button-container{margin-top:.25em}';
		}
		
		/* add style to the button container if the number is more than one */
		if ( $b > $a ) {
			//$inline_style .= '.shop-extra-checkout-button-container a.button{flex:1 1 0}';
		}
		
		/* add style to the button container if the number is is after price */
		if ( get_option('shop_extra_options')['shop_extra_product_button_checkout_button_position'] == '2' ) {
			$inline_style .= '.shop-extra-checkout-button-container{margin:.25em 0}';
		}
		
		/* add style to the button container if the number is is right before add to checkout */
		if ( get_option('shop_extra_options')['shop_extra_product_button_checkout_button_position'] == '3' ) {
			$inline_style .= '.shop-extra-checkout-button-container{margin-bottom:.25em}';
		}
		
		// hide the default checkout button
		$inline_style .= '.woocommerce-checkout-payment button[type=submit][name=woocommerce_checkout_place_order]#place_order{'.esc_attr($hide_css).'}';
		
		// minify the inline style before inject
		$inline_style = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',],$inline_style);
		
		/* inject above styles */
		wp_add_inline_style( SHOPEXTRA_HANDLER.'-checkout', esc_attr($inline_style) );
        
		        
    }
    
    public function checkout_script_init()
    {

        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] || !get_option('shop_extra_options')['shop_extra_product_button_checkout_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
        
		return $this->checkout_script();
		
    }
    
    public function checkout_script()
    {
		
		if ( !is_checkout() ) {
            return;
        }
		
        $inline_script = '
        // disable shopextra buttons if some required fields is empty
        jQuery(document).ready((function(e) {
        	let i = document.querySelectorAll("#shop-extra-checkout"),
        		l = document.querySelectorAll("#billing_first_name, #billing_address_1, #billing_city, #billing_postcode, #billing_email");
        	e("#billing_first_name, #billing_address_1, #billing_city, #billing_postcode, #billing_email").bind("change", (function(n) {
        		for (t = 0, len = l.length; t < len; t++) "" !== e(l[t]).val() ? jQuery.each(i, (function(e, i) {
        			setTimeout((function() {
        				jQuery("#payment #shop-extra-checkout").attr("disabled", !1)
        			}), 1e3)
        		})) : jQuery.each(i, (function(e, i) {
        			setTimeout((function() {
        				jQuery("#payment #shop-extra-checkout").attr("disabled", !0)
        			}), 1e3)
        		}))
        	})), e("#billing_first_name, #billing_address_1, #billing_city, #billing_postcode, #billing_email").trigger("change")
        }));
        
        jQuery(function($){
        
            // ensure the object exists
            if (typeof wc_checkout_params === "undefined" ) 
                return false;
            
            // trigger updating checkout data when field data changes
            $("form.checkout").on("change", function() {
                jQuery(document.body).trigger("update_checkout");
            });
            
            // trigger click place order button when buttons clicked
            jQuery(document.body).on("click", "#shop-extra-checkout", function() {
             $("#place_order").trigger("click");
            });
            
        });
        
        ';
		
        
    	// minify the inline script before inject
    	/*
		$inline_script = preg_replace(['/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/','/\>[^\S ]+/s','/[^\S ]+\</s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si'],['','>','<','$1$2$3$4$5$6$7'], $inline_script);
		*/
		
        $inline_script_handle = SHOPEXTRA_HANDLER.'-checkout-js';
    
        /* inject above script */
    
        $shop_extra_inline_script =
            '<script id="%s">%s</script>' . PHP_EOL;
            
        printf(
            $shop_extra_inline_script,
            esc_html($inline_script_handle),
            htmlspecialchars_decode(wp_kses_data($inline_script))
        );
        
        
    }
    
	
}

// Init
SHOPEXTRA_Checkout::getInstance();