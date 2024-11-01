<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_SingleProducts {
    
    private $options = [];
    
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
        $this->options = get_option('shop_extra_options', []);
		
		add_action('wp_enqueue_scripts', array($this, 'single_product_styling_init'), 999);
		
    }
    
    public function single_product_styling_init()
    { 
        if ( !$this->options['shop_extra_product_button_enable'] || !$this->options['shop_extra_product_button_single_enable'] || empty($this->options['shop_extra_product_button_names']) || empty($this->options['shop_extra_product_button_numbers']) ) {
			return;
		}
        
		return $this->single_product_styling();
		
    }
    
    private function single_product_styling()
    {
        
		if ( !is_product() ) {
            return;
        }
		
		wp_register_style( SHOPEXTRA_HANDLER.'-single-product', false);
		wp_enqueue_style( SHOPEXTRA_HANDLER.'-single-product' );
		
		$inline_style = '.shop-extra-single-product-button-container a.button{display:flex;align-items:center;justify-content:center;flex:1 1 0;line-height:2;padding:0.618em 1em;min-width:fit-content}.shop-extra-single-product-button-container .shop-extra-single-product-icon{width:1.25em;height:1.25em;margin-right:.45em}';
		
		$names = $this->options['shop_extra_product_button_names'];
		$names = preg_split('/[\n\r]+/', trim($names));	
		
		/* count the names to add extra styling */
		$a = 1;
		$b = count($names);
		
		/* whatsapp button container style */
		$shop_extra_single_button_container_style = '.shop-extra-single-product-button-container{display:flex;flex-direction:row;flex-wrap:wrap;gap:.25em;min-width:100%}';	
		
		/* hide view cart after shop-extra buttons if the button position is after add to cart */
		if ( $this->options['shop_extra_product_button_single_button_position'] == '1' ) {
			$inline_style .= '.shop-extra-single-product-button-container .added_to_cart{display:none;content-visibility:hidden}';
		}
		
		/* hide description heading */
		if ( $this->options['shop_extra_product_description_heading_hide']) {
			$inline_style .= '#tab-description h2:first-of-type{display:none;content-visibility:hidden}';
		}
		
		/* add style to the button container if the number is more than one and the button position is after add to cart */
		if ( $this->options['shop_extra_product_button_single_button_position'] == '1' && $b > $a ) {
			$inline_style .= esc_attr($shop_extra_single_button_container_style);
			$inline_style .= '.shop-extra-single-product-button-container{margin-top:.25em}';
			$inline_style .= '.product_meta .shop-extra-single-product-button-container{margin:0 0 1.25em}';
		}
		
		/* add margin to the container if the number is only one and the button position is after add to cart */
		if ( $this->options['shop_extra_product_button_single_button_position'] == '1' && $b <= $a  ) {
			if ( !$this->options['shop_extra_product_button_single_add_to_cart_hide'] || !$this->options['shop_extra_product_button_single_quantity_hide'] ) {
				$inline_style .= '.shop-extra-single-product-button-container,.woocommerce.single-product div.product form div.shop-extra-single-product-button-container:not(.quantity):not(.single_add_to_cart_button){display:flex;width:fit-content}';
				$inline_style .= '@media(min-width:600px){.shop-extra-single-product-button-container{margin-left:.25em}}';
				$inline_style .= '@media(max-width:599px){button.single_add_to_cart_button.button{min-width:fit-content}.shop-extra-single-product-button-container{margin-top:.25em}}';
			}
		}
		
		/* add style to the button container if the button position is before and after form and the number is more than one */
		if ( $this->options['shop_extra_product_button_single_button_position'] == '2' && $b > $a || $this->options['shop_extra_product_button_single_button_position'] == '3' && $b > $a ) {
			$inline_style .= esc_attr($shop_extra_single_button_container_style);
		}
		
		/* add top & bottom margin to the container if the button position is before form */
		if ( $this->options['shop_extra_product_button_single_button_position'] == '2' ) {
			$inline_style .= '.shop-extra-single-product-button-container{margin-top:1em;margin-bottom:1em}';
			$inline_style .= '.product_meta .shop-extra-single-product-button-container{margin:0 0 1.25em}';
		}
		
		/* add top margin to the button container if the button position is after form */
		if ( $this->options['shop_extra_product_button_single_button_position'] == '3' ) {
			$inline_style .= esc_attr($shop_extra_single_button_container_style);
			$inline_style .= '.shop-extra-single-product-button-container{margin-top:.25em}';
			$inline_style .= '.product_meta .shop-extra-single-product-button-container{margin:0 0 1.25em}';
		}
		
		
		
		// minify the inline style before inject
		$inline_style = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',],$inline_style);
		
		/* inject above styles */
		wp_add_inline_style( SHOPEXTRA_HANDLER.'-single-product', esc_attr($inline_style) );
		
    }
    
    
}

// Init
SHOPEXTRA_SingleProducts::getInstance();