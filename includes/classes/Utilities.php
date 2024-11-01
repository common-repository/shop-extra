<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Utilities {

    private $options = [];
    
    private $datepicker_label;
    private $datepicker_desc;
    private $datepicker_meta_key;
    private $datepicker_mode;
    private $meta_key = 'custom_tabs_data';
    private $option_radio_label;
    private $option_radio_allowed_html;

    public function __construct()
    {
        $this->options = get_option('shop_extra_options', []);
        
		if ( $this->options['shop_extra_block_editor_enable']) {
		    require_once( SHOPEXTRA_CLASSES_DIR . '/parts/enable-block-editor-product.php' );
		}
        
        // create the custom shop extra tab inside product data section
        if ( $this->options['shop_extra_datepicker_enable'] && !empty($this->options['shop_extra_datepicker_label']) && !empty($this->options['shop_extra_datepicker_meta_key']) ||
            $this->options['shop_extra_after_price_text_enable'] ||
            $this->options['shop_extra_limit_order_enable'] ) {
            
            add_action('woocommerce_product_data_tabs', [$this, 'add_shop_extra_tab'] );
            
            // create the date picker panel inside product data section
            add_action('woocommerce_product_data_panels', [$this, 'add_shop_extra_panels'] );
            
        }
        
        $this->datepicker_label = $this->options['shop_extra_datepicker_label'];
        $this->datepicker_desc = $this->options['shop_extra_datepicker_desc'];
        $this->datepicker_meta_key = sanitize_text_field($this->options['shop_extra_datepicker_meta_key']);
        $this->datepicker_mode = $this->options['shop_extra_datepicker_mode'];
        
        // Date Picker
        if ( $this->options['shop_extra_datepicker_enable'] && !empty($this->options['shop_extra_datepicker_label']) && !empty($this->options['shop_extra_datepicker_meta_key']) ) {
            
            // save the date picker data
            add_action('woocommerce_admin_process_product_object', [$this, 'save_date_picker_data_fields'] );
            
            // Output/Add date picker field to product page
            $display_option = get_option('shop_extra_options')['shop_extra_datepicker_display'];

            switch ($display_option) {
                case 'product':
                    add_action('woocommerce_before_add_to_cart_button', [$this, 'display_date_picker_field']);
                    add_action('woocommerce_before_variations_form', [$this, 'display_date_picker_field']);
                    break;
            /* stil not able to make the saving data works 
                case 'cart':
                    add_action('woocommerce_proceed_to_checkout', [$this, 'display_date_picker_field']);
            */       break;
            
                case 'checkout':
                    add_action('woocommerce_review_order_before_payment', [$this, 'display_date_picker_field']);
                    add_action('woocommerce_checkout_process', array($this, 'validate_date_picker_field'));
                    break;
            
                default:
                    add_action('woocommerce_before_add_to_cart_button', [$this, 'display_date_picker_field']);
                    add_action('woocommerce_before_variations_form', [$this, 'display_date_picker_field']);
                    break;
            }
            
            // Save selected date to cart item data
            add_filter('woocommerce_add_cart_item_data', [$this, 'save_date_picker_data_to_cart'], 10, 3 );
            
            // Display selected date in cart and checkout
            add_filter('woocommerce_get_item_data', [$this, 'display_date_picker_data_in_cart'], 10, 2 );
            
            // Save date in the order
            add_action('woocommerce_checkout_create_order_line_item', [$this, 'save_date_picker_data_to_order'], 10, 4 );
            
            // Enqueue date picker script and style in product page (frontend)
            add_action('wp_enqueue_scripts', [$this, 'enqueue_date_picker_assets'] );
            
            /* checkout page */
            add_action( 'woocommerce_checkout_update_order_meta', [$this, 'datepicker_checkout_save_data'] );
            add_action( 'woocommerce_thankyou', [$this, 'datepicker_checkout_thankyou_display'] );
            add_action( 'woocommerce_admin_order_data_after_billing_address', [$this, 'datepicker_checkout_order_display'] );
            add_action( 'woocommerce_email_after_order_table', [$this, 'datepicker_checkout_email_display'], 20, 4 );
 
        }
		
		if ( $this->options['shop_extra_after_price_text_enable'] ) {
		    
            // Save custom meta fields when the product is saved or updated
            add_action('woocommerce_process_product_meta', array($this, 'save_custom_after_price_text'));
    
            // Display the after price text in the frontend
            add_filter('woocommerce_get_price_html', array($this, 'display_custom_after_price_text'), 10, 2);
            
            // enqueue style to hide the after price text in product list screen as it not relevant
            add_action('admin_enqueue_scripts', array($this, 'hide_after_price_text'), 999);
            
		}
		
		if ( $this->options['shop_extra_custom_tab_enable'] ) {
		    
		    // create the custom tab inside product data section
    		add_action('woocommerce_product_data_tabs', array($this, 'add_custom_tab_data_tab'));
    		
    		// create the custom tab panel inside product data section
            add_action('woocommerce_product_data_panels', array($this, 'render_custom_tab_data_panel'));
            
            // save the tab data
            add_action('woocommerce_process_product_meta', array($this, 'save_custom_tab_data'));
            
            // enqueue the tinymice editor for the tab content
    		add_action('admin_enqueue_scripts', array($this, 'enqueue_tinymce_scripts'));
    		
            // output the tab in the frontend
            add_filter('woocommerce_product_tabs', array($this, 'add_custom_tabs_to_frontend'));
    		
    		// Add custom tab columns for export
            add_filter('woocommerce_product_export_product_default_columns', array($this, 'add_custom_tab_columns'));
            
            // Add custom tab data to CSV export
            add_filter('woocommerce_product_export_product_column_custom_tab_title', array($this, 'get_custom_tab_title'), 10, 2);
            add_filter('woocommerce_product_export_product_column_custom_tab_content', array($this, 'get_custom_tab_content'), 10, 2);
            
            // Process and save custom tab data during product import
            add_filter('woocommerce_product_import_pre_insert_product_object', array($this, 'process_custom_tab_data'), 10, 2);
    		
    		// Add tabs to mapping option for import
    		add_filter('woocommerce_csv_product_import_mapping_options', array($this, 'add_custom_tab_mapping_options'));
    		
    		// Set default mapping option for "Custom Tab Title" and "Custom Tab Content" columns
            add_filter('woocommerce_csv_product_import_mapping_default_columns', array($this, 'set_custom_tab_default_mapping_options'), 10, 2);
		    
		}
		
		if ( $this->options['shop_extra_limit_order_enable'] ) {
		    
		     add_action('woocommerce_product_options_pricing', array($this, 'add_quantity_metabox'));
            add_action('woocommerce_variation_options_pricing', array($this, 'add_variation_quantity_metabox'), 10, 3);
            add_action('woocommerce_process_product_meta', array($this, 'save_quantity_metabox'));
            add_action('woocommerce_save_product_variation', array($this, 'save_variation_quantity_metabox'), 10, 2);
            add_filter('woocommerce_quantity_input_args', array($this, 'limit_order_quantity'), 10, 2);
            add_filter('woocommerce_available_variation', array($this, 'limit_variation_order_quantity'), 10, 3);
            
            add_filter('woocommerce_dropdown_variation_attribute_options_args', array($this, 'select_default_variation_option'));
		}
		
		// Option Radio
		
		$this->option_radio_label = $this->options['shop_extra_option_radio_label'];
		
		$this->option_radio_allowed_html = array(
    		'div'      => array('id' => array(), 'class' => array()),
    		'label'    => array('for' => array(), 'class' => array()),
    		'input'    => array('type' => array(), 'name' => array(), 'value' => array(), 'checked' => array(), 'id' => array(), 'class' => array()),
    		'abbr'     => array('title' => array(), 'class' => array()),
    		'strong'   => array('title' => array(), 'class' => array()),
    		'p'        => array('title' => array(), 'class' => array()),
    		'ul'       => array('title' => array(), 'class' => array()),
    		'ol'       => array('title' => array(), 'class' => array()),
    		'li'       => array('title' => array(), 'class' => array()),
    		'span'     => array('class' => array()),
    		'a'        => array('href' => array(), 'title' => array(), 'target' => array(), 'class' => array()),
    		'img'      => array('src' => array(), 'alt' => array(), 'title' => array(), 'class' => array(), 'width' => array(), 'height' => array()),
    		'br'       => array(),
    		'hr'       => array(),
    		'figure'   => array(),
    		'heading'  => array('h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array()),
    		'blockquote' => array('cite' => array(), 'class' => array()),
    		'code'     => array('class' => array()),
    		'pre'      => array('class' => array()),
    		'em'       => array('class' => array()),
    		'i'       => array('class' => array()),
		);
		
		
        if ( $this->options['shop_extra_optionradio_enable'] && !empty($this->options['shop_extra_option_radio_label']) && !empty($this->options['shop_extra_optionradio_content']) ) {
            
            // Display options
            add_action('woocommerce_review_order_before_payment', array($this, 'display_custom_radio_buttons'));
            
            // Save Options
            add_filter('woocommerce_add_cart_item_data', [$this, 'save_custom_radio_option_to_cart'], 10, 3 );
            add_action('woocommerce_checkout_create_order_line_item', [$this, 'save_custom_radio_option_to_order'], 10, 4 );
            add_action('woocommerce_checkout_update_order_meta', array($this, 'save_custom_radio_option') );
            
            // Add validation for custom radio option during checkout process
            add_action('woocommerce_checkout_process', array($this, 'validate_custom_radio_option'));
            
            // Display on Thank You Page
            add_action('woocommerce_thankyou', array($this, 'display_custom_radio_option_thankyou') );
            
            // Display in Order Details
            add_action('woocommerce_admin_order_data_after_billing_address', array($this, 'display_custom_radio_option_order_details') );
            
            // Display in Emails
            add_action('woocommerce_email_after_order_table', array($this, 'display_custom_radio_option_emails'), 20, 4);
        
        }
		
		if ( $this->options['shop_extra_checkout_edit_order_enable'] ) {
		    
            add_filter('woocommerce_checkout_cart_item_quantity', array($this, 'customizeCheckoutItemDisplay'), 9999, 3);
            add_action('woocommerce_checkout_update_order_review', array($this, 'updateItemQuantityCheckout'));
         	// add option to use custom plus minus quantity button using filter
         	add_action('init', array($this, 'checkoutCustomQuantityButton'));
		}
		
    }
	
	private function minifyStyles( $input ) {
		$output = $input;
		$output = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',], $output);
		return $output;
	}
	
	private function minifyScripts( $input ) {
		$output = $input;
		$output = preg_replace(['/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/','/\>[^\S ]+/s','/[^\S ]+\</s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si'],['','>','<','$1$2$3$4$5$6$7'], $output);
		return $output;
	}
    
    public function add_quantity_metabox($loop = false) {
        global $post, $product_object;
    
        $product = wc_get_product($post->ID);
    
        echo '
        <style>
        .shop-extra-limit-order-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }
        </style>
        <div class="options_group shop-extra-limit-order-container">';
    
        woocommerce_wp_text_input(array(
            'id' => '_min_order_qty' . ($loop ? '_' . $loop : ''),
            'label' => __('Minimum Order', 'woocommerce'),
            'desc_tip' => true,
            'description' => __('Set a minimum quantity limit allowed per order. *optional', 'woocommerce'),
            'value' => $loop ? $product_object->get_meta('_min_order_qty', true) : get_post_meta($post->ID, '_min_order_qty', true),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min' => '0'
            )
        ));
    
        woocommerce_wp_text_input(array(
            'id' => '_max_order_qty' . ($loop ? '_' . $loop : ''),
            'label' => __('Maximum Order', 'woocommerce'),
            'desc_tip' => true,
            'description' => __('Set a maximum quantity limit allowed per order. *optional', 'woocommerce'),
            'value' => $loop ? $product_object->get_meta('_max_order_qty', true) : get_post_meta($post->ID, '_max_order_qty', true),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => '1',
                'min' => '0'
            )
        ));
    
        echo '</div>';
    }
    
    public function add_variation_quantity_metabox($loop, $variation_data, $variation) {
        echo '<div class="options_group shop-extra-limit-order-variable-container">';
        
        woocommerce_wp_text_input(array(
            'id' => '_min_order_qty_' . $loop,
            'label' => __('Minimum Order', 'woocommerce'),
            'desc_tip' => true,
            'description' => __('Set a minimum quantity limit allowed per order for this variation. *optional', 'woocommerce'),
            'value' => get_post_meta($variation->ID, '_min_order_qty', true),
            'type' => 'number',
            'wrapper_class' => 'form-row form-row-first',
            'custom_attributes' => array(
                'step' => '1',
                'min' => '0'
            )
        ));
        
        woocommerce_wp_text_input(array(
            'id' => '_max_order_qty_' . $loop,
            'label' => __('Maximum Order', 'woocommerce'),
            'desc_tip' => true,
            'description' => __('Set a maximum quantity limit allowed per order for this variation. *optional', 'woocommerce'),
            'value' => get_post_meta($variation->ID, '_max_order_qty', true),
            'type' => 'number',
            'wrapper_class' => 'form-row form-row-last',
            'custom_attributes' => array(
                'step' => '1',
                'min' => '0'
            )
        ));
        
        echo '</div>';
    }
	
    public function save_quantity_metabox($post_id) {
        $min_qty = isset($_POST['_min_order_qty']) ? sanitize_text_field($_POST['_min_order_qty']) : '';
        $max_qty = isset($_POST['_max_order_qty']) ? sanitize_text_field($_POST['_max_order_qty']) : '';
        update_post_meta($post_id, '_min_order_qty', $min_qty);
        update_post_meta($post_id, '_max_order_qty', $max_qty);
    }

    public function save_variation_quantity_metabox($variation_id, $i) {
        $min_qty = isset($_POST['_min_order_qty_' . $i]) ? sanitize_text_field($_POST['_min_order_qty_' . $i]) : '';
        $max_qty = isset($_POST['_max_order_qty_' . $i]) ? sanitize_text_field($_POST['_max_order_qty_' . $i]) : '';
        update_post_meta($variation_id, '_min_order_qty', $min_qty);
        update_post_meta($variation_id, '_max_order_qty', $max_qty);
    }

    public function limit_order_quantity($args, $product) {
        $apply_minmax = apply_filters('shop_extra_auto_minmax_variations', true);
        if ($product->is_type('simple')) {
            $product_id = $product->get_id();
            $product_min = $this->wc_get_product_min_limit($product_id);
            $product_max = $this->wc_get_product_max_limit($product_id);
            if (false !== $product_min) {
                $args['min_value'] = $product_min;
            }
            if (false !== $product_max) {
                $args['max_value'] = $product_max;
            }
            if ($product->managing_stock() && !$product->backorders_allowed()) {
                $stock = $product->get_stock_quantity();
                $args['max_value'] = min($stock, $args['max_value']);
            }
        } elseif ($apply_minmax &&  $product->is_type('variable')) {
            $variation_ids = $product->get_children();
            if ($variation_ids) {
                $first_variation_id = reset($variation_ids);
                $product_min = $this->wc_get_product_min_limit($first_variation_id);
                $product_max = $this->wc_get_product_max_limit($first_variation_id);
                if (false !== $product_min) {
                    $args['min_value'] = $product_min;
                }
                if (false !== $product_max) {
                    $args['max_value'] = $product_max;
                }
            }
        }
        return $args;
    }

    public function limit_variation_order_quantity($args, $product, $variation) {
        $variation_id = $variation->get_id();
        $product_min = $this->wc_get_product_min_limit($variation_id);
        $product_max = $this->wc_get_product_max_limit($variation_id);
        if (false !== $product_min) {
            $args['min_qty'] = $product_min;
        }
        if (false !== $product_max) {
            $args['max_qty'] = $product_max;
        }
        if ($variation->managing_stock() && !$variation->backorders_allowed()) {
            $stock = $variation->get_stock_quantity();
            $args['max_qty'] = min($stock, $args['max_qty']);
        }
        return $args;
    }
    
    public function select_default_variation_option($args) {
        global $product;
        $apply_autoselect = apply_filters('shop_extra_autoselect_variations', true);
        if ($apply_autoselect && $product->is_type('variable') && count($args['options']) > 0) {
            $args['selected'] = $args['options'][0];
        }
        return $args;
    }
    
    public function wc_get_product_max_limit($product_id) {
        $qty = get_post_meta($product_id, '_max_order_qty', true);
        if (empty($qty)) {
            $limit = false;
        } else {
            $limit = (int) $qty;
        }
        return $limit;
    }

    public function wc_get_product_min_limit($product_id) { 
        $qty = get_post_meta($product_id, '_min_order_qty', true);
        if (empty($qty)) {
            $limit = false;
        } else {
            $limit = (int) $qty;
        }
        return $limit;
    }
    
    public function add_shop_extra_tab($tabs) {
        $tabs['shop_extra_options'] = array(
            'label' => __('Shop Extra', 'woocommerce'),
            'icon' => 'dashicons-cart',
            'target' => 'shop_extra_panel',
            'priority' => 15,
        );
        return $tabs;
    }
    
    public function add_shop_extra_panels() {
        global $post;
        $date_picker_panel = (
            $this->options['shop_extra_datepicker_enable'] &&
            !empty($this->options['shop_extra_datepicker_label']) &&
            !empty($this->options['shop_extra_datepicker_meta_key'])
        );
        $limit_order_panel = (
            $this->options['shop_extra_limit_order_enable']
        );
        $after_price_panel = (
            $this->options['shop_extra_after_price_text_enable']
        );
        // Output styles and initial container div
        ?>
        <style>
            .shop-extra-panel p {
                line-height:30px;
            }
            .shop-extra-panel .options_group {
                display: grid;
                padding-bottom: 8px;
            }
            .shop-extra-panel .two-col {
                grid-template-columns: repeat(2, 1fr);
            }
            .shop-extra-panel .three-col {
                grid-template-columns: repeat(3, 1fr);
            }
            .shop-extra-panel h3 {
                font-size: 1.015em;
                padding: 0 12px;
                margin-bottom: 2px;
                margin-top: 1.55em;
            }
            .shop-extra-panel select,
            .shop-extra-panel input {
                font-size: 1.015em;
                line-height: 36px;
                height: 36px;
            }
            .shop-extra-panel input[type=number] {
                line-height: 30px;
                height: 30px;
            }
            .shop-extra-panel .options_group.three-col p.form-field:last-child {
                border-left: 1px solid #efefef;
            }
            .shop-extra-panel .options_group.three-col p.form-field:last-child label {
                padding-left: 4px;
                margin-right: -4px;
                height: 100%;
                display: inline-flex;
                align-items: center;
            }
            .shop-extra-panel .options_group input[type=number] {
                padding-right: 0;
                padding-left: 9px;
                text-align: center;
            }
            .shop-extra-panel .date-picker-options select {
                min-width: 75px;
                margin-left: -16px;
            }
            /*
            .shop-extra-limit-order-variable-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                width: 100%;
                grid-column-gap: 30px;
            }
            */
            .shop-extra-limit-order-variable-container input[type=number] {
                min-width: 100%;
            }
            #woocommerce-product-data ul.wc-tabs li.shop_extra_options_options a {
                display: flex;
                align-items: center;
            }
            #woocommerce-product-data ul.wc-tabs li.shop_extra_options_options a::before {
            	content: "\f502";
            }
        </style>
        
        <div id="shop_extra_panel" class="panel woocommerce_options_panel shop-extra-panel">
    
        <?php
        // Output After Price Text section if enabled
        if ($after_price_panel) :
            ?>
            <h3><?php _e('After Price Text', 'woocommerce'); ?></h3>
            <div class="options_group after-price">
                <?php
                woocommerce_wp_text_input(
                    array(
                        'id' => '_after_price_text',
                        'label' => __('Extra text after price', 'woocommerce'),
                        'desc_tip' => true,
                        'description' => __('Enter the maximum date range (in days) for the date picker. *the selected date will be counted', 'woocommerce'),
                        'type' => 'text',
                        'value' => get_post_meta($post->ID, '_after_price_text', true),
                    )
                );
                ?>
            </div>
            <?php
        endif;
    
        // Output Date Picker section if enabled
        if ($date_picker_panel) :
            ?>
            <h3 style=""><?php _e('Date Picker', 'woocommerce'); ?></h3>
            <div class="options_group date-picker-options three-col">
                <?php
                $datepicker_mode = $this->datepicker_mode;
    
                // Original options array with both options
                $options = array(
                    'single' => __('Single', 'woocommerce'),
                    'range' => __('Range', 'woocommerce'),
                );
    
                // Swap the order of options if the mode is 'range'
                if ($datepicker_mode === 'range') {
                    $options = array(
                        'range' => __('Range', 'woocommerce'),
                        'single' => __('Single', 'woocommerce'),
                    );
                }
    
                woocommerce_wp_select(
                    array(
                        'id' => 'shop_extra_date_picker_mode',
                        'label' => __('Mode', 'woocommerce'),
                        'options' => $options,
                        'desc_tip' => true,
                        'description' => __('Choose your date picker style (single / range)', 'woocommerce'),
                        'value' => get_post_meta($post->ID, 'shop_extra_date_picker_mode', true)
                    )
                );
    
                // Output the max range container
                ?>
                <div class="shop_extra_date_picker_max_range_container" style="display: <?php echo (get_post_meta($post->ID, 'shop_extra_date_picker_mode', true) === 'range' ? 'block' : 'none'); ?>">
                    <?php
                    woocommerce_wp_text_input(
                        array(
                            'id' => 'shop_extra_date_picker_max_range',
                            'label' => __('Date span', 'woocommerce'),
                            'desc_tip' => true,
                            'description' => __('Enter the maximum date range (in days) for the date picker. *the selected date will be counted', 'woocommerce'),
                            'type' => 'number',
                        )
                    );
                    ?>
                </div>
            </div>
        <?php
        endif;
        // Close the container div
        ?>
        </div>
        <?php
        // Output the JavaScript for Date Picker if enabled
        if ($date_picker_panel) :
            ?>
            <script>
                jQuery(document).ready(function($) {
                    const modeSelect = $("#shop_extra_date_picker_mode");
                    const maxRangeContainer = $(".shop_extra_date_picker_max_range_container");
    
                    maxRangeContainer.toggle(modeSelect.val() === 'range');
    
                    modeSelect.on('change', function() {
                        maxRangeContainer.toggle(this.value === 'range');
                    });
                });
            </script>
        <?php
        endif;
    }
    
    public function hide_after_price_text() {
        // Get the current screen object
        $current_screen = get_current_screen();
    
        // Check if the current screen is the product list screen
        if ($current_screen && $current_screen->id === 'edit-product') {
             $style_handle = 'shop-extra-product-list-style';
        
            wp_register_style( $style_handle, false ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
    		wp_enqueue_style( $style_handle );
    		
    		$inline_style = '.column-price span.after-price-text {display:none}table.wp-list-table .column-price{width:fit-content}';
    		
    		wp_add_inline_style(
    		    $style_handle, ( $inline_style ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    		);
        }
    }
    
    // Save the after price text value when the product is saved or updated
    public function save_custom_after_price_text($post_id) {
        // Get the after price text value from the submitted data
        $custom_after_price_text = isset($_POST['_after_price_text']) ? wp_kses_post($_POST['_after_price_text']) : '';
        // Save the after price text value to the product's meta data
        update_post_meta($post_id, '_after_price_text', $custom_after_price_text);
    }

    // Display the after price text in the frontend
    public function display_custom_after_price_text($price_html, $product) {
        $after_price_text = get_post_meta($product->get_id(), '_after_price_text', true);
        if (!empty($after_price_text)) {
            $price_html .= '<span class="after-price-text"> ' . wp_kses_post($after_price_text) . '</span>';
        }
        return $price_html;
    }
    
    public function add_custom_tab_mapping_options($options) {
        $custom_tab_fields = array(
            'custom_tab_title' => __('Custom Tab Title', 'woocommerce'),
            'custom_tab_content' => __('Custom Tab Content', 'woocommerce'),
        );
        return array_merge($options, $custom_tab_fields);
    }
    
    public function set_custom_tab_default_mapping_options($columns) {
        $columns['Custom Tab Title'] = 'custom_tab_title';
    	$columns['Custom Tab Content'] = 'custom_tab_content';
        return $columns;
    }
    
    public function add_custom_tab_columns($columns) {
        $columns['custom_tab_title'] = 'Custom Tab Title';
        $columns['custom_tab_content'] = 'Custom Tab Content';
        return $columns;
    }
    
    public function get_custom_tab_title($title, $product) {
        $product_id = $product->get_id();
        $custom_tabs = get_post_meta($product_id, $this->meta_key, true);
        $titles = array();
        if ($custom_tabs && is_array($custom_tabs)) {
            foreach ($custom_tabs as $tab) {
                if (!empty($tab['title'])) {
                    $titles[] = $tab['title'];
                }
            }
        }
        if (!empty($titles)) {
            $title = implode(", ", $titles); // Separate titles with commas
        }
        return $title;
    }
    
    public function get_custom_tab_content($content, $product) {
        $product_id = $product->get_id();
        $custom_tabs = get_post_meta($product_id, $this->meta_key, true);
        $contents = array();
        if ($custom_tabs && is_array($custom_tabs)) {
            foreach ($custom_tabs as $tab) {
                if (!empty($tab['content'])) {
                    $contents[] = '"' . str_replace('"', '""', $tab['content']) . '"';
                }
            }
        }
        if (!empty($contents)) {
            $content = implode(",", $contents);
        }
        return $content;
    }
    
    public function process_custom_tab_data($product, $data) {
        if (isset($data['custom_tab_title']) && isset($data['custom_tab_content'])) {
            $custom_tabs = array();
            $titles = array_filter(array_map('trim', explode(",", $data['custom_tab_title'])));
            $contents = array_map('trim', explode('","', $data['custom_tab_content']));
            $contents = array_map(function ($content) {
                return trim($content, '"');
            }, $contents);
            // Make sure titles and contents have the same count
            $count = max(count($titles), count($contents));
            for ($i = 0; $i < $count; $i++) {
                $title = isset($titles[$i]) ? $titles[$i] : '';
                $content = isset($contents[$i]) ? $contents[$i] : '';
                if (!empty($title) || !empty($content)) {
                    $custom_tabs[] = array(
                        'title' => $title,
                        'content' => $content,
                    );
                }
            }
            // Save custom tab data as post meta
            update_post_meta($product->get_id(), $this->meta_key, $custom_tabs);
        }
        return $product;
    }
    
    
    public function add_custom_tab_data_tab($tabs) {
        $tabs['custom_tab_data'] = array(
            'label' => __('Shop Extra - Custom Tabs', 'shop-extra'),
            'target' => 'custom_tab_data_panel',
            'class' => array('show_if_simple', 'show_if_variable'),
            'priority' => 15,
        );
        return $tabs;
    }

    public function render_custom_tab_data_panel() {
        global $post;
        $custom_tabs = get_post_meta($post->ID, $this->meta_key, true);
        ?>
        <style>
            #custom_tab_data_panel .custom-tab-field input {
                /*margin-bottom: 6px; */
                position: relative;
                z-index: 9;
                font-size: 13px;
                border-radius: 3px;
                float: none;
                width: 40%;
            }
            #custom_tab_data_panel .wp-editor-wrap {
                margin-top: -26px;
            }
            #custom_tab_data_panel div.mce-toolbar-grp {
            	border: 0;
            }
            #custom_tab_data_panel .wp-editor-container {
                border: 1px solid #e4e4e4;
                box-shadow: none;
            }
            #custom_tab_data_panel div.mce-panel {
                box-shadow: none;
            }
            #custom-tabs-fields {
                padding: 6px 10px;
                margin-bottom: 10px
            }
            #custom-tabs-fields .move-button,
            #custom-tabs-fields button.remove-custom-tab {
                margin-top: 8px
            }
            #custom-tabs-fields .custom-tab-field:not(:last-child) {
                margin-bottom: 16px
            }
            #custom-tabs-fields iframe {
                min-height: 185px
            }
            #custom-tabs-fields textarea.custom-tab-textarea {
                width:100%
            }
            #custom-tabs-fields .custom-tab-field:last-child .move-down-custom-tab,
            #custom-tabs-fields .custom-tab-field:first-child .move-up-custom-tab {
                display: none!important;
            }
            .custom-tab-field div.mce-toolbar-grp {
            	background: #fefefe;
            }
            
            .custom-tab-field .mce-top-part::before {
            	box-shadow: 0 1px 2px rgb(0 0 0 / 16%);
            }
            .shop-extra-custom-tab button.shop-extra-button {
                border: 0;
                font-size: 11.85px;
                padding: 5px 11px;
                border-radius: 4px;
                border-color: #ddd;
                box-shadow: 0 0 2px rgb(0 0 0 / 20%);
                transition: .2125s ease-in;
            }
            button.shop-extra-button.add-new-tab {
                background: #fefefe;
                background: linear-gradient(180deg, #fdfdfd, transparent);
            }
            button.shop-extra-button.move-button {
                background: #52616c;
                color: #fff;
            }
            button.shop-extra-button.remove-custom-tab {
                
            }
            #woocommerce-product-data ul.wc-tabs li.custom_tab_data_options a {
                display: flex;
                align-items: center;
            }
            #woocommerce-product-data ul.wc-tabs li.custom_tab_data_options a::before {
            	content: "\f502";
            }
        </style>
        
        <div id="custom_tab_data_panel" class="panel woocommerce_options_panel shop-extra-custom-tab">
            <div class="options_group">
                <p class="toolbar">
                    <button class="button shop-extra-button add-new-tab" id="add-custom-tab-btn"><?php _e('Add New Custom Tab', 'woocommerce'); ?></button>
                </p>
                <div id="custom-tabs-fields">
                    <?php
                    if ($custom_tabs && is_array($custom_tabs)) {
                        foreach ($custom_tabs as $index => $tab) {
                            $title = isset($tab['title']) ? $tab['title'] : '';
                            $content = isset($tab['content']) ? $tab['content'] : '';
                            $tab_id = 'custom-tab-' . $index;
                            $remove_flag = isset($tab['remove']) && $tab['remove'] === '1' ? true : false;
    
                            if ($remove_flag) {
                                continue; // Skip rendering the removed tab
                            }
                            ?>
                            <div class="custom-tab-field">
                                <input type="text" name="custom_tabs[<?php echo $index; ?>][title]" value="<?php echo esc_attr($title); ?>" placeholder="<?php _e('Tab Title', 'woocommerce'); ?>" />
                                <textarea class="custom-tab-textarea" name="custom_tabs[<?php echo $index; ?>][content]" rows="8" id="custom-tab-<?php echo $index; ?>"><?php echo $content; ?></textarea>
                                <input type="hidden" name="custom_tabs[<?php echo $index; ?>][remove]" class="remove-custom-tab" value="0" />
                                <?php if (count($custom_tabs) > 1) : ?>
                                <button class="button move-button move-up-custom-tab shop-extra-button"><?php _e('Move Up', 'woocommerce'); ?></button>
                                <button class="button move-button move-down-custom-tab shop-extra-button"><?php _e('Move Down', 'woocommerce'); ?></button>
                                <?php endif; ?>
                                <button class="button remove-custom-tab shop-extra-button"><?php _e('Remove Tab', 'woocommerce'); ?></button>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        
         <script>
            jQuery(document).ready(function($) {
                $('#add-custom-tab-btn').on('click', function(e) {
                    e.preventDefault();
                    var index = $('#custom-tabs-fields .custom-tab-field').length;
                    var newTabField = `
                        <div class="custom-tab-field">
                            <input type="text" name="custom_tabs[${index}][title]" value="" placeholder="<?php _e('Custom Tab Title', 'woocommerce'); ?>" />
                            <textarea class="custom-tab-textarea" name="custom_tabs[${index}][content]" rows="8" id="custom-tab-${index}"></textarea>
                            <input type="hidden" name="custom_tabs[${index}][remove]" class="remove-custom-tab" value="0" />
                            <button class="button remove-custom-tab shop-extra-button"><?php _e('Remove Tab', 'woocommerce'); ?></button>
                        </div>`;
                    $('#custom-tabs-fields').append(newTabField);
    
                    // Reinitialize the WordPress editor for the newly added textarea
                    initializeCustomEditor('custom-tab-' + index);
                });
    
                // Clear tab values when remove custom tab button clicked
                $(document).on('click', '.remove-custom-tab', function(e) {
                    e.preventDefault();
                    var $tabField = $(this).parent();
                    $tabField.find('.remove-custom-tab').val('1');
                    $tabField.hide();
                });
    
                // Initialize the WordPress editors for existing custom tabs on page load
                $('.custom-tab-field textarea').each(function() {
                    var editorId = $(this).attr('id');
                    initializeCustomEditor(editorId, $(this).val());
                });
                
                // Function to move custom tab up
                function moveCustomTabUp($tabField) {
                    var currentIndex = $tabField.index();
                    if (currentIndex > 0) {
                        $tabField.insertBefore($tabField.prev());
                    }
                }
    
                // Function to move custom tab down
                function moveCustomTabDown($tabField) {
                    var currentIndex = $tabField.index();
                    var totalTabs = $('#custom-tabs-fields .custom-tab-field').length;
                    if (currentIndex < totalTabs - 1) {
                        $tabField.insertAfter($tabField.next());
                    }
                }
    
                // Move custom tab up button click event
                $(document).on('click', '.move-up-custom-tab', function(e) {
                    e.preventDefault();
                    var $tabField = $(this).parent();
                    moveCustomTabUp($tabField);
                });
    
                // Move custom tab down button click event
                $(document).on('click', '.move-down-custom-tab', function(e) {
                    e.preventDefault();
                    var $tabField = $(this).parent();
                    moveCustomTabDown($tabField);
                });
                
            });
    
            function initializeCustomEditor(editorId, content) {
                var settings = {
                    tinymce: {
                        wpautop: false,
                        relative_urls: false,
                        convert_urls: false,
                        entities: "38,amp,60,lt,62,gt",
                        entity_encoding: "raw",
                        resize: false,
                        plugins: 'charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,wordpress,wpautoresize,wpeditimage,wpgallery,wplink,wpdialogs,wptextpattern,wpview',
                        toolbar1: 'formatselect,undo,redo,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_add_media,wp_adv',
                        toolbar2: 'strikethrough,hr,forecolor,pastetext,removeformat,wp_more,charmap,outdent,indent,wp_help',
                    },
                    quicktags: true,
                    mediaButtons: false,
                    textarea_name: 'custom_tabs[0][content]', // Set a dummy name for the textarea
                };
    
                if (content) {
                    settings.tinymce.setup = function (editor) {
                        editor.on('init', function () {
                            editor.setContent(content);
                        });
                    };
                }
    
                wp.editor.initialize(editorId, settings);
            }
        </script>
        <?php
    }

    public function enqueue_tinymce_scripts() {
        global $post_type;
        if( 'product' == $post_type ) {
            wp_enqueue_editor();
        }
    }
    
    public function save_custom_tab_data($post_id) {
        if (isset($_POST['custom_tabs'])) {
            $custom_tabs = array_map('wp_unslash', $_POST['custom_tabs']);
            $custom_tabs = array_filter($custom_tabs, function($tab) {
                return isset($tab['remove']) && $tab['remove'] === '0' && (!empty($tab['title']) || !empty($tab['content']));
            });
            // Re-index the custom_tabs array to ensure correct ordering of the tabs
            $custom_tabs = array_values($custom_tabs);
            update_post_meta($post_id, $this->meta_key, $custom_tabs);
        }
    }

    public function add_custom_tabs_to_frontend($tabs) {
        global $post;
        $custom_tabs = get_post_meta($post->ID, $this->meta_key, true);
        if ($custom_tabs && is_array($custom_tabs)) {
            foreach ($custom_tabs as $tab) {
                if (!empty($tab['title']) && !empty($tab['content'])) {
                    $tabs['custom_tab_' . sanitize_title($tab['title'])] = array(
                        'title' => $tab['title'],
                        'priority' => 15,
                        'callback' => function() use ($tab) {
                            echo wp_kses_post($tab['content']);
                        },
                    );
                }
            }
        }
        return $tabs;
    }
    
    public function save_date_picker_data_fields($product) {
        if (isset($_POST['shop_extra_date_picker_mode'])) {
            $product->update_meta_data('shop_extra_date_picker_mode', wc_clean($_POST['shop_extra_date_picker_mode']));
        }
        if (isset($_POST['shop_extra_date_picker_max_range'])) {
            $product->update_meta_data('shop_extra_date_picker_max_range', wc_clean($_POST['shop_extra_date_picker_max_range']));
        }
    }
    
    public function display_date_picker_field() {
        $field_args = array(
    		'type' => 'text',
    		'required' => true,
    		'class' => array('input-text', 'shop-extra-date-picker'),
    		'label' => __(esc_html($this->datepicker_label), 'woocommerce'),
		);
		// Add description if $desc is not empty
		if (!empty($this->datepicker_desc)) {
		    $field_args['description'] = __(esc_html($this->datepicker_desc), 'woocommerce');
		}
		woocommerce_form_field('shop_extra_date_picker', $field_args, '');
    }
    
    public function save_date_picker_data_to_cart($cart_item_data, $product_id, $variation_id) {
        $date_picker_value = isset($_POST['shop_extra_date_picker']) ? wc_clean($_POST['shop_extra_date_picker']) : '';
        if (!empty($date_picker_value)) {
            $cart_item_data['shop_extra_date_picker'] = $date_picker_value;
        }
        return $cart_item_data;
    }
    
    public function display_date_picker_data_in_cart($item_data, $cart_item) {
        if (isset($cart_item['shop_extra_date_picker'])) {
            $item_data[] = array(
                'key'   => esc_html($this->datepicker_meta_key),
                'value' => wc_clean($cart_item['shop_extra_date_picker']),
            );
        }
        return $item_data;
    }
    
    public function save_date_picker_data_to_order($item, $cart_item_key, $values, $order) {
        if (isset($values['shop_extra_date_picker'])) {
            $item->add_meta_data(esc_html($this->datepicker_meta_key), $values['shop_extra_date_picker']);
        }
    }
    
    /* datepicker checkout page functions */
    public function datepicker_checkout_save_data( $order_id ) { 
        $display_option = get_option('shop_extra_options')['shop_extra_datepicker_display'];
        if ($display_option !== 'product') {
            if ( $_POST['shop_extra_date_picker'] ) update_post_meta( $order_id, 'shop_extra_date_picker', esc_attr( $_POST['shop_extra_date_picker'] ) );
        }
    }
    
    public function datepicker_checkout_thankyou_display( $order_id ) {    
        if ( get_post_meta( $order_id, 'shop_extra_date_picker', true ) ) {
            
            echo '<style>
                p.date-picker-output {
                    margin: 0.65em 0;
                }
            </style>';
            
            echo '<p class="date-picker-output"><strong>' . esc_html($this->datepicker_meta_key) . '</strong><br>' . esc_html( get_post_meta( $order_id, 'shop_extra_date_picker', true ) ) . '</p>';
        }
    }
 
    public function datepicker_checkout_order_display( $order ) {    
       $order_id = $order->get_id();
       if ( get_post_meta( $order_id, 'shop_extra_date_picker', true ) ) {
            echo '<p class="date-picker-output"><strong>' . esc_html($this->datepicker_meta_key) . '</strong><br>' . esc_html( get_post_meta( $order_id, 'shop_extra_date_picker', true ) ) . '</p>';
        }
    }
     
    public function datepicker_checkout_email_display( $order, $sent_to_admin, $plain_text, $email ) {
        if ( get_post_meta( $order->get_id(), 'shop_extra_date_picker', true ) ) {
            echo '<style>
                p.date-picker-output {
                    border: 1px solid #e5e5e5;
                    padding: 14px 12px;
                }
            </style>';
            echo '<p class="date-picker-output"><strong>' . esc_html($this->datepicker_meta_key) . '</strong><br>' . esc_html( get_post_meta( $order->get_id(), 'shop_extra_date_picker', true ) ) . '</p>';
        }
    }
    
    public function validate_date_picker_field() {
        // Find the last occurrence of ":"
        $last_colon_position = strrpos($this->datepicker_meta_key, ':');
        // Check if ":" is found
        if ($last_colon_position !== false) {
        // Remove the last ":"
            $label_without_last_colon = substr_replace($this->datepicker_meta_key, '', $last_colon_position, 1);
        } else {
            // If ":" is not found, use the original label
            $label_without_last_colon = $this->datepicker_meta_key;
        }
        // Check if the custom radio option is selected
        if (empty($_POST['shop_extra_date_picker'])) {
            // If not selected, display a notice
            $notice_message = sprintf(__('Please choose <strong>%s</strong> before proceeding.', 'woocommerce'), esc_html($label_without_last_colon));
            // Add the notice
            wc_add_notice($notice_message, 'error');
        }
    }
    
    public function enqueue_date_picker_assets() {
        
        $ver = '4.6.13'; // flatpickr version
        
        wp_register_script(SHOPEXTRA_HANDLER . '-flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr@' . esc_attr($ver) . '/dist/flatpickr.min.js', array(), esc_attr($ver), true);
        wp_register_style( SHOPEXTRA_HANDLER.'-flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr@' . esc_attr($ver) . '/dist/flatpickr.min.css', array(), esc_attr($ver));
        
        $inline_style = '
			#shop_extra_date_picker_field {
				margin-bottom: calc(15px + (25 - 15) * ((100vw - 300px)/ (1680 - 300)));
				/* display: flex;
				flex-direction: column;
				max-width: 440px; */
			}
			form.variations_form .woocommerce-variation-add-to-cart #shop_extra_date_picker_field {
				display:none
			}
			#shop_extra_date_picker_field label {
				font-size: medium
			}
			#shop_extra_date_picker_field label .required {
				color: red;
				font-weight: 700;
				border: 0!important;
				cursor: none;
				text-decoration: none;
			}
			#shop_extra_date_picker_field span.description {
				/*display: block!important;*/
				margin-top: calc(2px + (4 - 2) * ((100vw - 300px)/ (1680 - 300)));
				margin-left: 1px;
				font-size: smaller
			}

			a[disabled=disabled],
			button.empty {
				opacity: .5;
				cursor: not-allowed;
			}

			dd.variation-PickupDate {
				word-spacing: -.3px;
				letter-spacing: -.3px;
				margin-bottom: 10px;
			}
			div.flatpickr-current-month {
				font-size: inherit;
				font-size: clamp(15px, (100vw - 100vmin), 15.5px);
			}
			div.flatpickr-months,
			div.flatpickr-innerContainer {
				padding: 2.5px 0;
			}
			div.flatpickr-months {
				background: linear-gradient(180deg, #fafafa, transparent);
				border-top-left-radius: 5px;
				border-top-right-radius: 5px;
				overflow: hidden
			}
			div.flatpickr-time {
				border-bottom-left-radius: 5px;
				border-bottom-right-radius: 5px;
				overflow: hidden
			}
			div.flatpickr-time,
			div.flatpickr-time input.flatpickr-hour,
			div.flatpickr-time input.flatpickr-minute,
			div.flatpickr-time input.flatpickr-second,
			div.flatpickr-time .flatpickr-time-separator {
				background: linear-gradient(360deg,#f7f7f7,transparent);
			}
			.flatpickr-calendar.hasTime div.flatpickr-time {
				border-top: 1px solid rgb(230 230 230 / 30%);
			}
			div.flatpickr-time input.flatpickr-hour,
			div.flatpickr-time input.flatpickr-minute,
			div.flatpickr-time input.flatpickr-second {
				border: 0
			}
        ';
		
        $max_date_range = get_post_meta(get_the_ID(), 'shop_extra_date_picker_max_range', true);
		$date_picker_mode = get_post_meta(get_the_ID(), 'shop_extra_date_picker_mode', true);
		$default_date_picker_mode = $this->datepicker_mode;

        if (empty($date_picker_mode)) {
            $date_picker_mode = $default_date_picker_mode;
        }
        
        $mode = 'mode: "' . ($date_picker_mode === 'range' ? 'range' : 'single') . '",';
        
        $min_date = $this->options['shop_extra_datepicker_min_date'];
        $max_date = $this->options['shop_extra_datepicker_max_date'];
        
        if (!empty($min_date)) {
            $minDate = "minDate: new Date().fp_incr($min_date),";
        } else {
            $minDate = "minDate: 'today',";
        }
        
        if (!empty($max_date)) {
            $maxDate = "maxDate: new Date().fp_incr($max_date),";
        } else {
            $maxDate = "maxDate: null,";
        }
        
        $onChangeScript = '';
        if ($date_picker_mode === 'range' && (int)$max_date_range > 0) {
            $onChangeScript = '
                if (selectedDates.length === 1) {
                    const endDate = new Date(selectedDates[0]);
                    endDate.setDate(endDate.getDate() + ' . ((int)$max_date_range - 1) . ');
                    instance.set("maxDate", endDate);
                }
            ';
        }
        
        $disableScript = '';
        $display_option = get_option('shop_extra_options')['shop_extra_datepicker_display'];

        switch ($display_option) {
            case 'product':
                $disableButtons = '.single_add_to_cart_button';
                $add = 'prop';
                break;
        /* stil not able to make the saving data works 
            case 'cart':
                $disableButtons = '.wc-proceed-to-checkout a';
                $add = 'attr';
                $disableScript = '
                disabledButtons.on("click", function(event) {
                    if ($(this).is("[disabled]")) {
                        event.preventDefault();
                    }
                });
                ';
                break;
        */
            case 'checkout':
                $disableButtons = '#place_order';
                $add = 'prop';
                break;
            default:
                $disableButtons = '.single_add_to_cart_button';
                $add = 'prop';
                break;
        }
        
        if ( get_option('shop_extra_options')['shop_extra_datepicker_time'] ) {
            $dateFormat = 'F j, Y H:i';
            $altFormat = 'F j, Y H:i';
            $enableTime = 'true';
            $minTime = !empty(get_option('shop_extra_options')['shop_extra_datepicker_min_time']) ? get_option('shop_extra_options')['shop_extra_datepicker_min_time'] : '06:30';
            $maxTime = get_option('shop_extra_options')['shop_extra_datepicker_max_time'];
            $defaultHour = $minTime;
        } else {
            $dateFormat = 'F j, Y';
            $altFormat = 'F j, Y';
            $enableTime = 'false';
            $minTime = 'null';
            $maxTime = 'null';
            $defaultHour = 'null';
        }
        
        //$dateFormat = apply_filters('shop_extra_date_picker_format', $dateFormat);
        $altInput = apply_filters('shop_extra_date_picker_alt_input', true);
        $firstDay = apply_filters('shop_extra_date_picker_first_day', 1);
        //$defaultHour = apply_filters('shop_extra_date_picker_default_hour', $defaultHour);
        
        $disableDay = '';
        $disableDayFunctions = '';
        $disableDays = get_option('shop_extra_options')['shop_extra_datepicker_disable_days'];
        
        if ($date_picker_mode !== 'range') {
            if (!empty($disableDays)) {
                // Split the input into an array
                $disabledDay = explode(',', $disableDays);
                foreach ($disabledDay as $day) {
                    $disableDayFunctions .= '
                        function(date) {
                            return date.getDay() === ' . trim($day) . ';
                        },
                    ';
                }
            }
        }
        
        $disableDate = '';
        $disableDateFunctions = '';
        $disableDates = get_option('shop_extra_options')['shop_extra_datepicker_disable_dates'];

        if (!empty($disableDates)) {
            // Split the input into an array
            $disabledDate = explode(',', $disableDates);
            foreach ($disabledDate as $date) {
                $disableDateFunctions .= '
                    function(date) {
                        return date.toDateString() === new Date("' . trim($date) . '").toDateString();
                    },
                ';
            }
        }
        
        $disableDayAndDates = '
            disable: [' . $disableDayFunctions . ' ' . $disableDateFunctions . ']
        ';
        
        $inline_script = '
            function initDatePicker() {
                jQuery(document).ready(function($) {
                    const dateField = jQuery("#shop_extra_date_picker");
                    const disabledButtons = jQuery("' . $disableButtons . '");
        
                    const flatpickrInstance = dateField.flatpickr({
                        ' . $mode . '
                        dateFormat: "' . $dateFormat . '",
                        altFormat: "' . $altFormat . '",
                        enableTime: "' . $enableTime . '",
                        defaultHour: "' . $defaultHour . '",
                        minTime: "' . $minTime . '",
                        maxTime: "' . $maxTime . '",
                        ' . $minDate . '
                        ' . $maxDate . '
                        altInput: "' . $altInput . '",
                        onChange: function(selectedDates, dateStr, instance) {
                        console.log("onChange function triggered");
                            const isDisabled = (!dateStr || dateField.val().trim() === "");
                            disabledButtons.' . $add . '("disabled", isDisabled);
                            ' . $onChangeScript . '
                        },
                        "locale": {
                            "firstDayOfWeek": ' . $firstDay . '
                        },
                        ' . $disableDayAndDates . '
                    });
        
                    const initialIsDisabled = (!flatpickrInstance.selectedDates || flatpickrInstance.selectedDates.length === 0 || dateField.val().trim() === "");
                    disabledButtons.' . $add . '("disabled", initialIsDisabled);
                    
                    ' . $disableScript . '
                    
                });
            }
            setTimeout(initDatePicker, 1000);
        ';
        
        // enqueue only in the selected page
        // allow user to modify the condition using a filter
        
        if ( get_option('shop_extra_options')['shop_extra_datepicker_display'] == 'product' ) {
            $load_date_picker = apply_filters('shop_extra_load_date_picker', is_product());
        }
        /* stil not able to make the saving data works 
        elseif ( get_option('shop_extra_options')['shop_extra_datepicker_display'] == 'cart' ) {
            $load_date_picker = apply_filters('shop_extra_load_date_picker', is_cart());
        }
        */
        elseif ( get_option('shop_extra_options')['shop_extra_datepicker_display'] == 'checkout' ) {
            $load_date_picker = apply_filters('shop_extra_load_date_picker', is_checkout());
        } else {
            $load_date_picker = apply_filters('shop_extra_load_date_picker', is_product());
        }
        
        if ( $load_date_picker ) {
            wp_enqueue_style( SHOPEXTRA_HANDLER.'-flatpickr' );
            wp_add_inline_style( SHOPEXTRA_HANDLER.'-flatpickr', esc_attr($this->minifyStyles($inline_style)) );
            wp_enqueue_script( SHOPEXTRA_HANDLER.'-flatpickr' );
            wp_add_inline_script( SHOPEXTRA_HANDLER.'-flatpickr', htmlspecialchars_decode(wp_kses_data($this->minifyScripts($inline_script))) );
        }
        
    }
	
	public function checkoutCustomQuantityButton() {
		// set the filter value
		$this->shop_extra_checkout_plus_minus_quantity_button = apply_filters('shop_extra_checkout_plus_minus_quantity_button', false);
		// only execute plus minus quantity button if the filters set to true    	
        if ($this->shop_extra_checkout_plus_minus_quantity_button === true) {
            add_action('woocommerce_after_quantity_input_field', array($this, 'customCheckoutQuantityDisplayPlus'));
            add_action('woocommerce_before_quantity_input_field', array($this, 'customCheckoutQuantityDisplayMinus'));
            add_action('wp_footer', array($this, 'customCheckoutQuantityDisplayJS'));
			/* to enable: add_filter('shop_extra_checkout_plus_minus_quantity_button', '__return_true'); */
        }
    }
    
    public function customizeCheckoutItemDisplay($product_quantity, $cart_item, $cart_item_key) {
        $product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if (!$product->is_sold_individually()) {
			
			$style = '
				.shop-extra-checkout-edit-order {
                        display: flex;
						align-items: center;
						margin-top: 1.5px;
						gap: 8px;
                    }
				.shop-extra-checkout-edit-order a.remove {
					border: 0!important
				}
			';
			
			if ($this->shop_extra_checkout_plus_minus_quantity_button === true) {
				$style .= '
					.shop-extra-checkout-edit-order .quantity {
						border: 1px solid rgba(0,0,0,.1);
						display: flex;
   						align-items: center;
						max-height: 42px;
						border-radius: 4px;
					}
					.shop-extra-checkout-edit-order .quantity button {
						transition: opacity .3s ease;
						padding: 9px 14px;
						background-color: unset;
						background: none;
    					color: inherit;
						opacity: .75;
						cursor: pointer;
					}
					.shop-extra-checkout-edit-order .quantity button:hover {
						opacity: 1;
					}
					.shop-extra-checkout-edit-order .quantity .qty {
						border: 0;
    					max-height: 25px;
						font-size: small;
    					-webkit-text-stroke: 0.1px;
						padding: 9px 4px;
					}
					.shop-extra-checkout-edit-order .quantity button.minus::before {
						content: \'\2013\'; /* Unicode for en dash - minus sign */
					}
					.shop-extra-checkout-edit-order .quantity button.plus::before {
						content: \'\002B\'; /* Unicode for plus sign */
					}
					.shop-extra-checkout-edit-order .quantity button.minus:hover::before,
					.shop-extra-checkout-edit-order .quantity button.plus:hover::before {
						-webkit-text-stroke: 0.1px;
					}
					.shop-extra-checkout-edit-order .quantity .ct-increase,
					.shop-extra-checkout-edit-order .quantity .ct-decrease {
						display: none
					}
					.shop-extra-checkout-edit-order .quantity input[type=number] {
						padding-inline: 0;
					}
					/* removes default increment arrows inside the quantity input field */
					/* Chrome, Safari, Edge, Opera */
					.shop-extra-checkout-edit-order input::-webkit-outer-spin-button,
					.shop-extra-checkout-edit-order input::-webkit-inner-spin-button {
					  -webkit-appearance: none;
					  margin: 0;
					}
					/* Firefox */
					.shop-extra-checkout-edit-order input[type=number] {
					  -moz-appearance: textfield;
					}
				';
			}
			
            // Add style
            $product_quantity .= '
                <style id="shop-extra-custom-checkout-edit-order">'. $this->minifyStyles($style) .'</style>
            ';
			
			// add container
			$product_quantity .= '
			<div class="shop-extra-checkout-edit-order">
			';
            // Display quantity input
            $product_quantity .= $this->getQuantityInput($product_id, $cart_item);
            // Add hidden input to make the update function work
            $product_quantity .= '<input type="hidden" name="product_key_' . $product_id . '" value="' . $cart_item_key . '">';
            // Display remove link
            $product_quantity .= '<a href="' . esc_url(wc_get_cart_remove_url($cart_item_key)) . '" class="remove" aria-label="Remove this item" data-product_id="' . esc_attr($product_id) . '" data-product_sku="' . esc_attr($cart_item['data']->get_sku()) . '">&times;</a>';
			// close the container
			$product_quantity .= '
			</div>
			';
        }
        return $product_quantity;
    }

    public function updateItemQuantityCheckout($post_data) {
        parse_str($post_data, $post_data_array);
        $updated_qty = false;

        foreach ($post_data_array as $key => $value) {
            if (substr($key, 0, 20) === 'shipping_method_qty_') {
                $id = substr($key, 20);
                WC()->cart->set_quantity($post_data_array['product_key_' . $id], $post_data_array[$key], false);
                $updated_qty = true;
            }
        }

        if ($updated_qty) {
            WC()->cart->calculate_totals();
        }
    }

    private function getQuantityInput($product_id, $cart_item) {
        return woocommerce_quantity_input(
            array(
                'input_name'  => 'shipping_method_qty_' . $product_id,
                'input_value' => $cart_item['quantity'],
                'max_value'   => $cart_item['data']->get_max_purchase_quantity(),
                'min_value'   => '1',
            ),
            $cart_item['data'],
            false
        );
    }
	
    public function customCheckoutQuantityDisplayPlus() {
        echo '<button type="button" class="plus"></button>';
    }
	
    public function customCheckoutQuantityDisplayMinus() {
        echo '<button type="button" class="minus"></button>';
    }
	
    public function customCheckoutQuantityDisplayJS() {
        if ( ! is_checkout() ) {
        	return;
        }
		$enqueue_js = '
		$(document).on( "click", "button.plus, button.minus", function() {
            var qty = $( this ).parent( ".quantity" ).find( ".qty" );
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr( "max" ));
            var min = parseFloat(qty.attr( "min" ));
            var step = parseFloat(qty.attr( "step" ));
            if ( $( this ).is( ".plus" ) ) {
				if ( max && ( max <= val ) ) {
					qty.val(max);
				} else {
					qty.val( val + step ).change();
				}
            } else {
				if ( min && ( min >= val ) ) {
					 event.preventDefault();
				} else if ( val > 1 ) {
					qty.val( val - step ).change();
				}
            }
        });
		';
        wc_enqueue_js( $this->minifyScripts($enqueue_js) );
    }
    
    public function display_custom_radio_buttons() {
        
        $radio_options = get_option('shop_extra_options')['shop_extra_optionradio_content'];
        $radio_options_description = get_option('shop_extra_options')['shop_extra_option_radio_desc'];
    
        if ($radio_options && is_array($radio_options)) {
            
            $radio_inline_style = '
            .shop-extra-radio-options-label {
                font-weight: 500;
                font-size: medium;
                margin-bottom: .35em;
                display: block;
            }
            .shop-extra-radio-options-label .required {
                color: red;
                font-weight: 700;
                border: 0!important;
                cursor: none;
                text-decoration: none;
            }
            .option-title input[type=radio] {
                accent-color: #52616c;
            }
            #shop-extra-radio-options .option-title {
                font-size: clamp(16.5px, (100vw - 100vmin), 18px);
                margin-bottom: 3.5px;
                font-weight: bold;
                line-height: 1.4;
                display: flex;
                gap: 8px;
            }
            .shop-extra-radio-options {
                margin-bottom: 1.75em
            }
            .shop-extra-radio-option-container {
                font-size: clamp(15.5px, (100vw - 100vmin), 17px);
            }
            .shop-extra-radio-option-container label.option-title.validate-required input:before {
                content: \'\';
                position: absolute;
                display: block;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                width: 100%;
                height: 100%;
                cursor: pointer; 
            }
            .custom-radio-content a,
            .shop-extra-radio-option-container {
                position: relative
            }
            .custom-radio-content>*:last-child {
                margin-bottom: 0
            }
            @media (min-width: 768px) {
                .shop-extra-radio-options-container {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
            		grid-column-gap: 3%;
                	grid-row-gap: 8px;
                }
            }
            ';
            
            $output = '<div id="shop-extra-radio-options" class="shop-extra-radio-options">';
            $output .= '<label for="shop-extra-radio-options-label" class="shop-extra-radio-options-label">' . esc_html($this->option_radio_label, 'woocommerce') . '&nbsp;<abbr class="required" title="required">*</abbr></label>';
            $output .= '<div class="shop-extra-radio-options-container">';
                
            foreach ($radio_options as $index => $option) {
				$title = isset($option['title']) ? $option['title'] : '';

				if (!empty($title)) {
					$content = isset($option['content']) ? wpautop($option['content']) : '';

					$output .= '<div class="shop-extra-radio-option-container">';
					$output .= '<label class="option-title validate-required">';
					$output .= '<input type="radio" name="shop_extra_radio_option" value="' . ($index + 1) . '" />';
					$output .= '<input type="hidden" name="shop_extra_radio_title[' . $index . ']" value="' . esc_attr($title) . '" />';
					$output .= '<input type="hidden" name="shop_extra_radio_content[' . $index . ']" value="' . esc_attr($content) . '" />';
					$output .= $title . '</label>';

					if (!empty($content)) {
						$output .= '<div class="custom-radio-content">' . $content . '</div>';
					}

					$output .= '</div>'; // Close the container
				}
			}
            
            $output .= '</div>';
            
            if (!empty($radio_options_description)) {
                $radio_inline_style .= '
                    .custom-radio-description {
                        margin-top: .45em;
                        font-size: medium;
                        line-height: 1.45
                    }
                ';
                $output .= '<p class="custom-radio-description">' . $radio_options_description . '</div>';
            }
    
            $output .= '</div>';

            echo '<style id="shop-extra-option-radio-style">' . $this->minifyStyles($radio_inline_style) . '</style>';
            
            echo wp_kses($output, $this->option_radio_allowed_html);
            
            $radio_inline_script = '
                document.querySelectorAll(".option-title input[type=radio]").forEach(elem => 
                    elem.addEventListener("click", () => {
                        document.querySelectorAll(".option-title input[type=radio]").forEach(elem => {
                            elem.removeAttribute("checked");
                            const parentContainer = elem.closest(".shop-extra-radio-option-container");
                            parentContainer && parentContainer.classList.remove("selected");
                        });
            
                        const checkedRadio = document.querySelector(".option-title input[type=radio]:checked");
                        if (checkedRadio) {
                            checkedRadio.setAttribute("checked", "");
                            const parentContainer = checkedRadio.closest(".shop-extra-radio-option-container");
                            parentContainer && parentContainer.classList.add("selected");
                        }
                    })
                );
            ';
			
            echo PHP_EOL . '<script id="shop-extra-option-radio-script">' . $this->minifyScripts($radio_inline_script) . '</script>';
        }
    }
    
    public function save_custom_radio_option_to_cart($cart_item_data, $product_id, $variation_id) {
        $custom_radio_option_value = isset($_POST['shop_extra_radio_option']) ? wc_clean($_POST['shop_extra_radio_option']) : '';
        if (!empty($custom_radio_option_value)) {
            $index = $custom_radio_option_value - 1; // Adjust the index based on the value
            $cart_item_data['shop_extra_radio_option'] = array(
                'value' => $custom_radio_option_value,
                'title' => sanitize_text_field($_POST['shop_extra_radio_title'][$index]),
                'content' => wp_kses($_POST['shop_extra_radio_content'][$index], $this->option_radio_allowed_html),
            );
        }
        return $cart_item_data;
    }
    
    public function save_custom_radio_option_to_order($item, $cart_item_key, $values, $order) {
        if (isset($values['shop_extra_radio_option'])) {
            $item->add_meta_data($this->option_radio_label . ' Value', $values['shop_extra_radio_option']['value']);
            $item->add_meta_data($this->option_radio_label . ' Title', $values['shop_extra_radio_option']['title']);
            $item->add_meta_data($this->option_radio_label . ' Content', $values['shop_extra_radio_option']['content']);
        }  
    }
        
    public function save_custom_radio_option($order_id) {
        if (isset($_POST['shop_extra_radio_option'])) {
            $value = wc_clean($_POST['shop_extra_radio_option']);
            $index = $value - 1; // Adjust the index based on the value
            $title = sanitize_text_field($_POST['shop_extra_radio_title'][$index]);
            $content = $_POST['shop_extra_radio_content'][$index];
    
            update_post_meta($order_id, 'shop_extra_radio_option_value', $value);
            update_post_meta($order_id, 'shop_extra_radio_option_title', $title);
            update_post_meta($order_id, 'shop_extra_radio_option_content', $content);
        }
    }
    
    public function validate_custom_radio_option() {
        // Find the last occurrence of ":"
        $last_colon_position = strrpos($this->option_radio_label, ':');
        // Check if ":" is found
        if ($last_colon_position !== false) {
            // Remove the last ":"
            $label_without_last_colon = substr_replace($this->option_radio_label, '', $last_colon_position, 1);
        } else {
            // If ":" is not found, use the original label
            $label_without_last_colon = $this->option_radio_label;
        }
        // Check if the custom radio option is selected
        if (empty($_POST['shop_extra_radio_option'])) {
            // If not selected, display a notice
            $notice_message = sprintf(__('Please choose <strong>%s</strong> before proceeding.', 'woocommerce'), esc_html($label_without_last_colon));
            // Add the notice
            wc_add_notice($notice_message, 'error');
        }
    }
    
    public function display_custom_radio_option_thankyou($order_id) {
        $value = get_post_meta($order_id, 'shop_extra_radio_option_value', true);
        $title = get_post_meta($order_id, 'shop_extra_radio_option_title', true);
        $content = get_post_meta($order_id, 'shop_extra_radio_option_content', true);
        if ($value) {
            echo '<style>
                div.shop-extra-radio-container {
                    margin: 0.65em 0 0.8em;
                }
                div.shop-extra-radio-container p:empty {
                    display:none
                }
                p.shop-extra-radio-option-title {
                    margin-bottom: 0;
                    font-size: 100%
                }
                div.shop-extra-radio-option-content {
                    line-height: 1.515
                }
            </style>';
            echo '<div class="shop-extra-radio-container">';
            echo '<p class="shop-extra-radio-label"><strong>' . esc_html__($this->option_radio_label) . '</strong></p>';
            echo '<p class="shop-extra-radio-option-title"><strong>' . esc_html($title) . '</strong><p>';
            echo '<div class="shop-extra-radio-option-content">'. wp_kses($content, $this->option_radio_allowed_html) . '</div>';
            echo '</div>';
        }
    }
    
    public function display_custom_radio_option_order_details($order) {
        $order_id = $order->get_id();
        $value = get_post_meta($order_id, 'shop_extra_radio_option_value', true);
        $title = get_post_meta($order_id, 'shop_extra_radio_option_title', true);
        $content = get_post_meta($order_id, 'shop_extra_radio_option_content', true);
    
        if ($value) {
            echo '<style>
                div.shop-extra-radio-container {
                    
                }
                .shop-extra-radio-option-content > p,
                .shop-extra-radio-container > p {
                    margin: 0;
                }
                .shop-extra-radio-container p:empty {
                    display:none;
                }
                p.shop-extra-radio-label {
                    margin-bottom: 1.5px
                }
            </style>';
            echo '<div class="shop-extra-radio-container">';
            echo '<p class="shop-extra-radio-label"><strong>' . esc_html__($this->option_radio_label) . '</strong></p>';
            echo '<p class="shop-extra-radio-option-title"><strong>' . esc_html($title) . '</strong><p>';
            echo '<div class="shop-extra-radio-option-content">'. wp_kses($content, $this->option_radio_allowed_html) . '</div>';
            echo '</div>';
        }
    }
    
    public function display_custom_radio_option_emails($order, $sent_to_admin, $plain_text, $email) {
        $order_id = $order->get_id();
        $value = get_post_meta($order_id, 'shop_extra_radio_option_value', true);
        $title = get_post_meta($order_id, 'shop_extra_radio_option_title', true);
        $content = get_post_meta($order_id, 'shop_extra_radio_option_content', true);
    
        if ($value) {
            echo '<style>
                div.shop-extra-radio-container {
                    border: 1px solid #e5e5e5;
                    padding: 14px 12px;
                    margin-bottom: 25px!important
                }
                .shop-extra-radio-option-content > p,
                .shop-extra-radio-container > p {
                    margin: 0!important
                }
                p.shop-extra-radio-label {
                    margin-bottom: 1.5px!important
                }
            </style>';
            echo '<div class="shop-extra-radio-container">';
            echo '<p class="shop-extra-radio-label"><strong>' . esc_html__($this->option_radio_label) . '</strong></p>';
            echo '<p class="shop-extra-radio-option-title"><strong>' . esc_html($title) . '</strong><p>';
            echo '<div class="shop-extra-radio-option-content">'. wp_kses($content, $this->option_radio_allowed_html) . '</div>';
            echo '</div>';
        }
    }
	
}