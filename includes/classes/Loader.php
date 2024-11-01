<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Loader {
    
    const CLASS_DIR = 'includes/classes/';
    const VIEW_DIR = 'view/';

    private $admin_core_class;
    private $settings_class;
    private $admin_url;

	private $floating_class;
	private $products_class;
	private $translations_class;
	private $utilities_class;

    private static $_instance; // the single instance


    function __construct()
    {
        $this->loadClasses();
    }

    public static function getInstance()
    {
        if (!self::$_instance) { // if no instance then make one
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function loadClasses()
    {
        $this->require_class('Messages');

        $this->require_class('Core');
        $this->admin_core_class = new SHOPEXTRA_Core();

        $this->require_class('Settings');
        $this->settings_class = new SHOPEXTRA_Settings();
        
        // safe guard to prevent the plugin from executing anything if the user haven't save any settings
		if ( !get_option('shop_extra_options') ) {
		  return;
		}
		
		$this->require_class('Floating');
        $this->floating_class = new SHOPEXTRA_Floating();
        
        // only execute WooCommerce feature if WooCommerce plugin is active
        if ( in_array(  'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            
            $this->require_class('Products');
            $this->products_class = new SHOPEXTRA_Products();
            
            $this->require_class('Translations');
            $this->translations_class = new SHOPEXTRA_Translations();
            
            $this->require_class('Utilities');
            $this->utilities_class = new SHOPEXTRA_Utilities();
            
        }
    }

    public function Admin_Core()
    {
        return $this->admin_core_class;
    }

    public function Settings()
    {
        return $this->settings_class;
    }
	
	public function Floating()
    {
        return $this->floating_class;
    }
    
    public function Products()
    {
        return $this->products_class;
    }
    
    public function Spamblock()
    {
        return $this->spamblock_class;
    }
    
    public function Translations()
    {
        return $this->translations_class;
    }
    
    public function Utilities()
    {
        return $this->utilities_class;
    }

    public function require_class($file = "")
    {
        return $this->required(self::CLASS_DIR . $file);
    }

    public function admin_url($view = 'settings')
    {
        return admin_url('admin.php?page='.SHOPEXTRA_HANDLER.'&view=' . $view);
    }

    public function required($file = "")
    {
        $dir = SHOPEXTRA_DIR;

        if (empty($dir) || !is_dir($dir)) {
            return false;
        }

        $file = path_join($dir, $file . '.php');

        if (!file_exists($file)) {
            return false;
        }

        require_once $file;
    }

    public function get_view($file = "")
    {
        $this->required(self::VIEW_DIR . $file);
    }

    public function admin_view($file = "")
    {
        $this->get_view('admin/' . $file);
    }

    public function get_active_view()
    {
        $default = 'settings';

        if (!isset($_GET['view'])) {
            return $default;
        }

        $view = wp_filter_kses($_GET['view']);

        return ($view) ? $view : $default;

    }
    
}