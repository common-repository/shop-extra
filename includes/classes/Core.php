<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Core
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_option_menu'));
        
		add_filter('plugin_action_links_' . SHOPEXTRA_BASENAME, [$this, 'plugin_setting_links']);
		add_filter('plugin_row_meta', array($this, 'plugin_row_links'), 10, 2);
    }

    /**
     * Add shop_extra to setting menu
     *
     * @return void
     */
     
    /* add settings on admin sidebar */
    public function add_option_menu()
    {
		
		$menu = add_options_page(
            SHOPEXTRA_SHORT_NAME,		// Page title
            SHOPEXTRA_SHORT_NAME,		// Menu name
            'manage_options', 			// Permissions
            SHOPEXTRA_HANDLER,					// Menu slug
            array($this, 'view')
        );

        add_action('load-' . $menu, array($this, 'load'));
 
		
    }
    
	
	/* add settings on plugin list */
	public function plugin_setting_links($links)
    {
        $links = array_merge(array(
            '<a href="' . esc_url(admin_url('/options-general.php?page='.SHOPEXTRA_HANDLER.'')) . '">' . __('Settings', 'shop_extra') . '</a>',
        ), $links);
        
        return $links;
    }
    
    /* add links on plugin list row */
    public function plugin_row_links($links, $file)
      {
        if ($file !== SHOPEXTRA_BASENAME ) {
          return $links;
        }
    
        $pro_link = '<a target="_blank" href="https://dhiratara.me/services/speed-optimization/" title="' . __('Optimize More', 'shop_extra') . '">' . __('Speed Up Your Site!', 'shop_extra') . '</a>';
    
        $links[] = $pro_link;
    
        return $links;
      } // plugin_meta_links

    /**
     * shop_extra setting menu page is loaded
     *
     * @return void
     */
    public function load()
    {

        do_action("shop_extra_load-page");

        // Register scripts
        add_action("admin_enqueue_scripts", array($this, 'enqueue_scripts'));

        //check store;
        $this->store();
    }

    public function enqueue_scripts()
    {

        $setting_js = 'js/admin-settings.js';
        wp_register_script(
            'shop_extra-admin-settings',
            SHOPEXTRA_ASSETS_URL . $setting_js, '',
            SHOPEXTRA_VERSION
        );
		
        $ays_before_js = 'js/ays-beforeunload-shim.js';
        wp_register_script(
            'ays-beforeunload-shim',
            SHOPEXTRA_ASSETS_URL . $ays_before_js,
            array('jquery'),
            SHOPEXTRA_VERSION
        );

        $areyousure_js = 'js/jquery-areyousure.js';
        wp_register_script(
            'jquery-areyousure',
            SHOPEXTRA_ASSETS_URL . $areyousure_js,
            array('jquery'),
            SHOPEXTRA_VERSION
        );

        $setting_css = 'css/admin-settings.css';
        wp_register_style(
            'shop_extra-admin-settings',
            SHOPEXTRA_ASSETS_URL . $setting_css, '',
            SHOPEXTRA_VERSION . '2'
        );
		
		wp_enqueue_script('wp-color-picker-alpha', SHOPEXTRA_ASSETS_URL . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ));
		wp_enqueue_script('wp-color-picker-init', SHOPEXTRA_ASSETS_URL . 'js/wp-color-picker-init.js', array( 'wp-color-picker-alpha' ));

        wp_enqueue_script(array('ays-beforeunload-shim', 'jquery-areyousure', 'wp-color-picker-alpha', 'shop_extra-admin-settings'));
        wp_enqueue_style(array('shop_extra-admin-settings'));
		
        wp_localize_script(
            'shop_extra-admin-settings',
            'shop_extra_settings',
            array(
                'adminurl' => admin_url("index.php"),
                'shop_extra_ajax_nonce' => wp_create_nonce("shop_extra_ajax_nonce")
            )
        );
    }

    private function store()
    {
        do_action('shop_extra_save_before_validation');

        if (!isset($_POST['shop_extra-settings'])) {
            return;
        }

        if (isset($_POST['shop_extra-action']) && $_POST['shop_extra-action'] == 'reset') {
            return;
        }
        //  nonce checking
        if (!isset($_POST['shop_extra-settings_nonce'])
            || !wp_verify_nonce($_POST['shop_extra-settings_nonce'], 'shop_extra-settings-action')) {

            print 'Sorry, your nonce did not verify.';
            exit;
        }

        SHOPEXTRA()->Settings()->store();
        return;
    }

    public function view()
    {
        $SHOPEXTRA = SHOPEXTRA();
        $view = $SHOPEXTRA->get_active_view();
        $SHOPEXTRA->admin_view($view);
    }
    
    
}