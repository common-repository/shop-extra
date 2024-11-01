<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Products {

    public function __construct()
    {
		
		add_action( 'init', array($this, 'single_product_init'), 99);
		add_action( 'init', array($this, 'loops_init'), 99);
		add_action( 'init', array($this, 'cart_init'), 99);
		add_action( 'plugins_loaded', array($this, 'checkout_init'), 99);
		add_action( 'init', array($this, 'customize_elements_init'), 99);
		
    }
    
    public function single_product_init()
    {
    
        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] && !get_option('shop_extra_options')['shop_extra_product_button_single_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
 
    	return $this->single_product();
		
    }
    
    private function single_product()
    {

		require_once(SHOPEXTRA_FUNCTIONS_DIR . 'single-product.php'); // render html
		require_once(SHOPEXTRA_CLASSES_DIR . '/parts/single-product.php'); // styes or scripts
		
    }
    
    
	public function loops_init()
    {
    
        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] && !get_option('shop_extra_options')['shop_extra_product_button_loops_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
 
    	return $this->loops();
		
    }
    
    private function loops()
    {
        
		require_once(SHOPEXTRA_FUNCTIONS_DIR . 'loops.php'); // render html
		require_once(SHOPEXTRA_CLASSES_DIR . '/parts/loops.php'); // styes or scripts
		
    }
    
    public function cart_init()
    {
    
        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] && !get_option('shop_extra_options')['shop_extra_product_button_cart_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
 
    	return $this->cart();
		
    }
    
    private function cart()
    {
        
		require_once(SHOPEXTRA_FUNCTIONS_DIR . 'cart.php'); // render html
		require_once(SHOPEXTRA_CLASSES_DIR . '/parts/cart.php'); // styes or scripts
		
    }
	
	public function checkout_init()
    {
    
        if ( !get_option('shop_extra_options')['shop_extra_product_button_enable'] && !get_option('shop_extra_options')['shop_extra_product_button_checkout_enable'] || empty(get_option('shop_extra_options')['shop_extra_product_button_names']) || empty(get_option('shop_extra_options')['shop_extra_product_button_numbers']) ) {
			return;
		}
 
    	return $this->checkout();
		
    }
    
    private function checkout()
    {
        
		require_once(SHOPEXTRA_FUNCTIONS_DIR . 'checkout.php'); // render html
		require_once(SHOPEXTRA_CLASSES_DIR . '/parts/checkout.php'); // styes or scripts
		
    }
    
    public function customize_elements_init()
    {
    
        if ( !get_option('shop_extra_options') ) {
			return;
		}
 
    	return $this->customize_elements();
		
    }
    
    private function customize_elements()
    {

		require_once(SHOPEXTRA_CLASSES_DIR . '/parts/customize-elements.php'); // styes or scripts
		
    }
    
    	
}