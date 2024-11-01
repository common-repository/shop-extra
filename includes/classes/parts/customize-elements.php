<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_ProductElements {
    
    private static $_instance;
    
    private $options = [];
    
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
	    
	    $this->options = get_option('shop_extra_options', []);
		
		add_action('wp_enqueue_scripts', array($this, 'product_elements_styling_init'), 999);
		
		add_filter('woocommerce_checkout_fields', array($this, 'custom_checkout_fields_init') );
		
		if ( $this->options['shop_extra_product_single_category_label_hide'] ) {
    		add_action('woocommerce_single_product_summary', array($this, 'custom_single_product_category_meta'), 40);
    	}
		
    }
    
    public function custom_single_product_category_meta() {
        global $product;
       ?>
       <div class="product_meta shop-extra">
       <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '', '', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?> 
       </div>
       <?php
    }
    
    public function product_elements_styling_init()
    { 
        if ( !$this->options ) {
			return;
		}
        
		return $this->product_elements_styling();
		
    }
    
    private function product_elements_styling()
    {
        global $post;
		
		if ( is_404() ) {
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
		
		$hide_css = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',], $hide_css);
		
		
		
		/* single product customization */
        
		if ( is_product() ) {
		    
		    $inline_product_style = '';
            
            /* hide the add to cart button using $hide_css */
    		if ( $this->options['shop_extra_product_button_single_add_to_cart_hide'] ) {
    			$inline_product_style .= 'button[type=submit].single_add_to_cart_button{'.esc_attr($hide_css).'}';
    		}
    		/* hide the quantity option using $hide_css */
    		if ( $this->options['shop_extra_product_button_single_quantity_hide'] ) {
    			$inline_product_style .= '.single-product .product form.cart .quantity{'.esc_attr($hide_css).'}';
    		}
    		/* hide the price option using $hide_css */
    		if ( $this->options['shop_extra_product_button_single_price_hide'] ) {
    			$inline_product_style .= '.single-product .product .price{'.esc_attr($hide_css).'}';
    		}
    		
    		if ( $this->options['shop_extra_product_single_category_label_hide'] ) {
    			$inline_product_style .= '.single-product .summary .product_meta:not(.shop-extra){'.esc_attr($hide_css).'}';
    		}

    		
    		/* register the styles if whatsapp button in product page is not enable */
    		
    		 if ( !$this->options['shop_extra_product_button_single_enable'] ) {
    		    
    		    wp_register_style( SHOPEXTRA_HANDLER.'-single-product', false);
		        wp_enqueue_style( SHOPEXTRA_HANDLER.'-single-product' );
    		    
    		}
    		
    		/* inject above styles */
    		
    		wp_add_inline_style( SHOPEXTRA_HANDLER.'-single-product', esc_attr($inline_product_style) );
            
        }
        
        /* end single product customization */
		
		
		/* loops customization */
        
		if ( strpos($post->post_content, 'products') || is_shop() || is_product_category() || is_product() ) {
		    
		    $inline_loops_style = '';
                
			/* hide the add to cart button using $hide_css */
			if ( $this->options['shop_extra_product_button_loops_add_to_cart_hide'] ) {
				$inline_loops_style .= 'ul.products a.button:not([class*="shop-extra-"]){'.esc_attr($hide_css).'}';
			}
			/* hide the price option using $hide_css */
			if ( $this->options['shop_extra_product_button_loops_price_hide'] ) {
				$inline_loops_style .= 'ul.products li a .price{'.esc_attr($hide_css).'}';
			}
			/* disable links to product details pages  */
			if ( $this->options['shop_extra_product_button_loops_disable_links'] ) {
				$inline_loops_style .= 'a.woocommerce-LoopProduct-link.woocommerce-loop-product__link{pointer-events:none;cursor:default}';
			}
    		
    		/* register the styles if whatsapp button in loops is not enable */
    		
    		 if ( !$this->options['shop_extra_product_button_loops_enable']) {
    		    
    		    wp_register_style( SHOPEXTRA_HANDLER.'-loops', false);
		        wp_enqueue_style( SHOPEXTRA_HANDLER.'-loops' );
    		    
    		}
    		
    		/* inject above styles */
    		
    		wp_add_inline_style( SHOPEXTRA_HANDLER.'-loops', htmlspecialchars_decode(esc_attr($inline_loops_style)) );
            
        }
        
        /* end loops customization */
		
		/* cart customization */
        
		if ( is_cart() ) {
		    
		    $inline_cart_style = '';
        
        		
        	/* register the styles if whatsapp button in cart is not enable */
        		
        	if ( !$this->options['shop_extra_product_button_cart_enable']) {
        		    
        	    wp_register_style( SHOPEXTRA_HANDLER.'-cart', false);
    		    wp_enqueue_style( SHOPEXTRA_HANDLER.'-cart' );
        		    
        	}
        		
        	/* inject above styles */
    		
    		//wp_add_inline_style( SHOPEXTRA_HANDLER.'-cart', wp_kses_data($inline_cart_style) );
            
        }
        
        /* end cart customization */
		
		
		/* checkout customization */
        
		if ( is_checkout() ) {
		    
		    $inline_checkout_style = '';
        	
			/* hide last name fields using $hide_css */
			if ( $this->options['shop_extra_checkout_last_name_hide'] ) {
				$inline_checkout_style .= '@media(min-width:690px){p#billing_first_name_field{width:100%}}';
				$inline_checkout_style .= 'p#billing_last_name_field{'.esc_attr($hide_css).'}';
			}
			
			/* hide ship to a different address using $hide_css */
			if ( $this->options['shop_extra_checkout_different_address_hide'] ) {
				$inline_checkout_style .= 'div.woocommerce-shipping-fields{'.esc_attr($hide_css).'}';
			}
        		
        	/* register the styles if whatsapp button in checkout is not enable */
        		
        	if ( !$this->options['shop_extra_product_button_checkout_enable']) {
        		    
        	    wp_register_style( SHOPEXTRA_HANDLER.'-checkout', false);
    		    wp_enqueue_style( SHOPEXTRA_HANDLER.'-checkout' );
        		    
        	}
        		
        	/* inject above styles */
    		
    		wp_add_inline_style( SHOPEXTRA_HANDLER.'-checkout', esc_attr($inline_checkout_style) );
            
        }
        
        /* end checkout customization */
		
		
		/* global customization */
		
		wp_register_style( SHOPEXTRA_HANDLER.'-global-customization', false);
    	wp_enqueue_style( SHOPEXTRA_HANDLER.'-global-customization' );
		
		$inline_global_style = '';
		
		 if ( $this->options ['shop_extra_product_button_cart_proceed_hide']  ) {
			
			$inline_global_style .= '.woocommerce-mini-cart__buttons{grid-template-columns:none}.woocommerce-mini-cart__buttons a.button{margin:0;min-width:100%}';
			$inline_global_style .= '.woocommerce-mini-cart__buttons .checkout.wc-forward{'.esc_attr($hide_css).'}';
			 /* inject above styles */
    		wp_add_inline_style( SHOPEXTRA_HANDLER.'-global-customization', wp_kses_data($inline_global_style) );
			 
		}
		
    }
    
    public function custom_checkout_fields_init( $fields )
    {
	    if ( !is_checkout() ) {
			return;
		}
		
		if ( $this->options['shop_extra_checkout_last_name_hide'] ) {
			$fields['billing']['billing_last_name']['required'] = false;
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_company'] ) {
			unset($fields['billing']['billing_company']);
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_address_1'] ) {
			unset($fields['billing']['billing_address_1']);
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_address_2'] ) {
			unset($fields['billing']['billing_address_2']);
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_city'] ) {
			unset($fields['billing']['billing_city']);
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_postcode'] ) {
			unset($fields['billing']['billing_postcode']);
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_country'] ) {
			unset($fields['billing']['billing_country']);
		}
		
		if ( $this->options['shop_extra_checkout_unset_billing_state'] ) {
			unset($fields['billing']['billing_state']);
		}
		

		return $fields;	
	    
	}
    
    
}

// Init
SHOPEXTRA_ProductElements::getInstance();