<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Loops {
    
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
		
		add_action('wp_enqueue_scripts', array($this, 'loops_styling_init'), 999);
		
    }
    
    public function loops_styling_init()
    {

        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] || !get_option('shop_extra_options')['shop_extra_product_button_loops_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
        
		return $this->loops_styling();
		
    }
    
    private function loops_styling()
    {
        global $post;
		
		if ( is_404() ) {
			return;
		}
        
        if ( !strpos($post->post_content, 'products') && !is_shop() && !is_product_category() && !is_product() ) {
            return;
        }
		
		wp_register_style( SHOPEXTRA_HANDLER.'-loops', false);
		wp_enqueue_style( SHOPEXTRA_HANDLER.'-loops' );
		
		/* whatsapp button container style */
		$shop_extra_single_button_container_style = '.shop-extra-loops-button-container{display:flex;flex-direction:row;flex-wrap:wrap;gap:.25em;min-width:100%}.shop-extra-loops-button-container a.shop-extra-loops-whatsapp-button{display:flex}';
		
		$inline_style = esc_attr($shop_extra_single_button_container_style);
		
		$inline_style .= '.shop-extra-loops-button-container .shop-extra-loops-whatsapp-button{display:flex;align-items:center;justify-content:center;min-width:fit-content}.woocommerce ul.products .shop-extra-loops-button-container .shop-extra-loops-icon{width:1.25em;height:1.25em;margin-right:.45em}';
		
		/* whatsapp button disable margin from woocommerce css for non first-child shop-extra buttons */
		$inline_style .= '.woocommerce ul.products .shop-extra-loops-button-container a.button:not(:first-child){margin:0}';
		
		$names = get_option('shop_extra_options')['shop_extra_product_button_names'];
		$names = preg_split('/[\n\r]+/', trim($names));	
		
		/* count the names to add extra styling */
		$a = 1;
		$b = count($names);
		
		/* add style to the button container if the number is is after add to cart */
		if ( get_option('shop_extra_options')['shop_extra_product_button_loops_button_position'] == '1' ) {
			$inline_style .= '.shop-extra-loops-button-container{margin-top:.25em}';
		}
		
		/* add style to the button container if the number is more than one */
		if ( $b > $a ) {
			$inline_style .= '.shop-extra-loops-button-container a.button{flex:1 1 0}';
		}
		
		/* add style to the button container if the number is is right before add to cart */
		if ( get_option('shop_extra_options')['shop_extra_product_button_loops_button_position'] == '2' ) {
			$inline_style .= '.shop-extra-loops-button-container{margin-bottom:.25em}';
		}
		
		/* add style to the button container if the number is is after price */
		if ( get_option('shop_extra_options')['shop_extra_product_button_loops_button_position'] == '3' ) {
			$inline_style .= '.shop-extra-loops-button-container{margin:.25em 0}';
		}
		
		
		// minify the inline style before inject
		$inline_style = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',],$inline_style);
		
		/* inject above styles */
		wp_add_inline_style( SHOPEXTRA_HANDLER.'-loops', wp_kses_data($inline_style) );
	   
    }
	
}

// Init
SHOPEXTRA_Loops::getInstance();