<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Settings {
    
    private $settings;

    function __construct()
    {
        $this->init_settings();
        add_action('init', array($this, 'init'));
        add_action('shop_extra_after_body', array($this, 'add_import_html'));
    }

    public function init()
    {
        // check or initiate import
        $this->import();

        if (!isset($_GET['shop_extra-action'])) {
            return;
        }

        // check or initiate reset
        $this->reset_plugin();

        // check or initiate export
        $this->export();

    }

    public function get($key = "", $default = false)
    {
        if (!isset($this->settings[$key])) {
            return $default;
        }

        $value = shop_extra_removeslashes($this->settings[$key]);
        if (empty($value) || is_null($value)) {
            return false;
        }

        if (is_array($value) && count($value) == 0) {
            return false;
        }

        return $value;
    }

    public function reset()
    {
        $this->settings = array();
    }

    public function setAll($value)
    {
        $this->settings = $value;
    }

    public function getAll()
    {
        return $this->settings;
    }

    public function set($key, $value)
    {
        $this->settings[$key] = $value;
    }

    public function remove($key)
    {
        if (isset($this->settings[$key])) {
            unset($this->settings[$key]);
        }
    }

    public function save()
    {
        update_option("shop_extra_options", $this->settings);
		
    }

    public function store()
    {
        do_action('shop_extra_before_saving', $this);
        $this->reset();
        $this->set('version', SHOPEXTRA_VERSION);
    
        foreach ($this->keys() as $key) {
            $setting_value = '';
            if (isset($_POST[$key])) {
                $setting_value = shop_extra_kses($_POST[$key]);
            }
            $this->set($key, $setting_value);
        }
    
        // Handle saving radio button options
        $radio_options = isset($_POST['option_radios']) ? $_POST['option_radios'] : array();
    
        // Remove options marked for removal
        $radio_options = array_filter($radio_options, function ($option) {
            return empty($option['remove']);
        });
    
        $this->set('shop_extra_optionradio_content', $radio_options);
    
        $placeholder = '';
        do_action('shop_extra_save_addtional_settings', $this, $placeholder);
    
        $this->save();
    
        do_action('shop_extra_after_saving', $this);
    
        SHOPEXTRA_Queue('Settings saved.');
        wp_redirect(SHOPEXTRA()->admin_url());
        exit;
    }


    public function init_settings()
    {
        $settings = get_option("shop_extra_options", false);

        if (!$settings) {
            $settings = $this->default_options();
        }

        $this->settings = $settings;
		
    }

    public function add_import_html()
    {
        SHOPEXTRA()->admin_view('parts/import');
    }

    public function import()
    {
        if (!isset($_POST['shop_extra-settings_nonce'])) return;

        if (!is_admin() && !current_user_can('manage_options')) {
            return;
        }

        if (!isset($_POST['shop_extra-settings']) && !isset($_FILES['import_file'])) {
            return;
        }

        if (!isset($_FILES['import_file'])) {
            return;
        }

        if ($_FILES['import_file']['size'] == 0 && $_FILES['import_file']['name'] == '') {
            return;
        }

        // check nonce
        if (!wp_verify_nonce($_POST['shop_extra-settings_nonce'], 'shop_extra-settings-action')) {

           SHOPEXTRA_Queue('Sorry, your nonce did not verify.', 'error');
            wp_redirect(SHOPEXTRA()->admin_url());
            exit;
        }

        $import_field = 'import_file';
        $temp_file_raw = $_FILES[$import_field]['tmp_name'];
        $temp_file = esc_attr($temp_file_raw);
        $arr_file_type = $_FILES[$import_field];
        $uploaded_file_type = $arr_file_type['type'];
        $allowed_file_types = array('application/json');


        if (!in_array($uploaded_file_type, $allowed_file_types)) {
            SHOPEXTRA_Queue('Upload a valid .json file.', 'error');
            wp_redirect(SHOPEXTRA()->admin_url());
            exit;
        }

        $settings = (array)json_decode(
            file_get_contents($temp_file),
            true
        );

        unlink($temp_file);

        if (!$settings) {

            SHOPEXTRA_Queue('Nothing to import, please check your json file format.', 'error');
            wp_redirect(SHOPEXTRA()->admin_url());
            exit;

        }

        $this->setAll($settings);
        $this->save();

        SHOPEXTRA_Queue('Your Import has been completed.');

        wp_redirect(SHOPEXTRA()->admin_url());
        exit;
    }


    public function export()
    {
        if (!isset($_GET['shop_extra-action']) || (isset($_GET['shop_extra-action']) && $_GET['shop_extra-action'] != 'export')) {
            return;
        }

        $settings = $this->getAll();

        if (!is_array($settings)) {
            $settings = array();
        }

        $settings = json_encode($settings);
		
		$site_name = get_bloginfo('url');
		$site_name = preg_replace('#^https?://#i', '', $site_name);

        header('Content-disposition: attachment; filename='.SHOPEXTRA_HANDLER.'_'.$site_name.'-settings_' . date_i18n( 'd-m-Y' ) . '.json');
        header('Content-type: application/json');
        print $settings;
        exit;
    }

    public function reset_plugin()
    {
        global $wpdb;

        if ($_GET['shop_extra-action'] != 'reset') {
            return;
        }

        delete_option("shop_extra_options");
        $wpdb->get_results($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s", 'shop_extra_o_%'));

        SHOPEXTRA_Queue('Settings reset.');
        wp_redirect(SHOPEXTRA()->admin_url());
        exit;
    }

    public function keys()
    {
        return array_keys($this->default_options());
    }

    public function get_default_option($key)
    {
        $settings = $this->default_options();
        return isset($settings[$key]) ? $settings[$key] : null;
    }

    public function default_options()
    {

        $settings = array(
	        
			// floating button
			'shop_extra_floating_enable' => false,
			'shop_extra_floating_button_image' => '',
			'shop_extra_floating_heading_image' => '',
			'shop_extra_floating_heading_title' => '',
			'shop_extra_floating_heading_description' => '',
			'shop_extra_floating_prefilled_message' => '',
			'shop_extra_floating_tooltip' => '',
			'shop_extra_floating_names' => '',
			'shop_extra_floating_numbers' => '',
			'shop_extra_floating_images' => '',
			'shop_extra_floating_availability' => '',
			'shop_extra_floating_availability_available_text' => '',
			'shop_extra_floating_availability_notavailable_text' => '',
			
			// floating button style
			'shop_extra_floating_left' => false,
			'shop_extra_floating_button_width' => '',
			'shop_extra_floating_button_padding' => '',
			'shop_extra_floating_button_bg_color' => '',
			'shop_extra_floating_heading_bg_color' => '',
			'shop_extra_floating_names_bg_color' => '',
			'shop_extra_floating_names_text_color' => '',
			
			// whatsapp order button
			'shop_extra_product_button_enable' => false,
			'shop_extra_product_button_price_enable' => false,
			'shop_extra_product_button_url_enable' => false,
			'shop_extra_product_button_names' => '',
			'shop_extra_product_button_numbers' => '',
			'shop_extra_product_button_images' => '',
			'shop_extra_product_button_message_before' => '',
			'shop_extra_product_button_message_after' => '',
			// whatsapp order button - single product
			'shop_extra_product_button_single_enable' => false,
			'shop_extra_product_button_single_button_position' => '',
			'shop_extra_product_button_single_add_to_cart_hide' => false,
			'shop_extra_product_button_single_quantity_hide' => false,
			'shop_extra_product_button_single_price_hide' => false,
			'shop_extra_product_single_category_label_hide' => false,
			'shop_extra_product_description_heading_hide' => false,
			// whatsapp order button - shop loop
			'shop_extra_product_button_loops_enable' => false,
			'shop_extra_product_button_loops_button_position' => '',
			'shop_extra_product_button_loops_price_hide' => false,
			'shop_extra_product_button_loops_add_to_cart_hide' => false,
			'shop_extra_product_button_loops_disable_links' => false,
			// whatsapp order button - cart page
			'shop_extra_product_button_cart_enable' => false,
			'shop_extra_product_button_cart_button_position' => '',
			'shop_extra_product_button_cart_proceed_hide' => false,
			// whatsapp order button - checkout page
			'shop_extra_product_button_checkout_enable' => false,
			'shop_extra_product_button_checkout_button_position' => '',
			
			// extra whatsapp message for cart and checkout page
			'shop_extra_product_button_message_total' => '',
			'shop_extra_product_button_message_tax' => '',
			'shop_extra_product_button_message_payment' => '',
			'shop_extra_product_button_message_ship_to' => '',
			'shop_extra_product_button_message_shipping_method' => '',
			'shop_extra_product_button_message_grand_total' => '',
			// hide/remove elements
			'shop_extra_checkout_last_name_hide' => false,
			'shop_extra_checkout_different_address_hide' => false,
			'shop_extra_checkout_unset_billing_company' => false,
			'shop_extra_checkout_unset_billing_address_1' => false,
			'shop_extra_checkout_unset_billing_address_2' => false,
			'shop_extra_checkout_unset_billing_city' => false,
			'shop_extra_checkout_unset_billing_postcode' => false,
			'shop_extra_checkout_unset_billing_country' => false,
			'shop_extra_checkout_unset_billing_state' => false,
			
			
			// translations - general
			'shop_extra_translate_add_to_cart' => '',
			'shop_extra_translate_select_options' => '',
			'shop_extra_translate_read_more' => '',
			'shop_extra_translate_view_cart' => '',
			'shop_extra_translate_checkout' => '',
			'shop_extra_translate_proceed_to_checkout' => '',
			// translations - checkout page
			'shop_extra_translations_enable' => false,
			'shop_extra_translate_single_product_added_to_cart' => '',
			'shop_extra_translate_single_product_description_tab' => '',
			'shop_extra_translate_single_product_reviews_tab' => '',
			'shop_extra_translate_cart_page_quantity' => '',
			'shop_extra_translate_cart_page_cart_totals' => '',
			'shop_extra_translate_cart_page_cart_updated' => '',
			'shop_extra_translate_checkout_page_billing_details' => '',
			'shop_extra_translate_checkout_page_first_name' => '',
			'shop_extra_translate_checkout_page_last_name' => '',
			'shop_extra_translate_checkout_page_country_region' => '',
			'shop_extra_translate_checkout_page_street_address' => '',
			'shop_extra_translate_checkout_page_town_city' => '',
			'shop_extra_translate_checkout_page_state' => '',
			'shop_extra_translate_checkout_page_zip_code' => '',
			'shop_extra_translate_checkout_page_phone' => '',
			'shop_extra_translate_checkout_page_email_address' => '',
			'shop_extra_translate_checkout_page_your_order' => '',
			'shop_extra_translate_checkout_page_place_order' => '',
			'shop_extra_translate_checkout_page_shipping' => '',
			'shop_extra_translate_cart_checkout_page_product' => '',
			'shop_extra_translate_cart_checkout_page_subtotal' => '',
			'shop_extra_translate_checkout_page_additional_info' => '',
			'shop_extra_translate_checkout_page_additional_info_order_notes' => '',
			'shop_extra_translate_checkout_page_additional_info_notes_placeholder' => '',
			
			// utilities
			'shop_extra_datepicker_enable' => false,
			'shop_extra_datepicker_label' => '',
			'shop_extra_datepicker_desc' => '',
			'shop_extra_datepicker_meta_key' => '',
			'shop_extra_datepicker_min_date' => '',
			'shop_extra_datepicker_max_date' => '',
			'shop_extra_datepicker_mode' => '',
			'shop_extra_datepicker_display' => '',
			'shop_extra_datepicker_disable_days' => '',
			'shop_extra_datepicker_disable_dates' => '',
			'shop_extra_datepicker_time' => '',
			'shop_extra_datepicker_min_time' => '',
			'shop_extra_datepicker_max_time' => '',
			'shop_extra_block_editor_enable' => false,
			'shop_extra_custom_tab_enable' => false,
			'shop_extra_after_price_text_enable' => false,
			'shop_extra_limit_order_enable' => false,
			'shop_extra_checkout_edit_order_enable' => false,
			
			'shop_extra_optionradio_enable' => false,
			'shop_extra_option_radio_label' => '',
			'shop_extra_option_radio_desc' => '',
			'shop_extra_optionradio_content' => '',
			
        );
        
        return apply_filters('shop_extra_setting_fields', $settings);
    }
}