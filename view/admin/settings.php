<?php

$views = array(
        "floating" => __('Floating WhatsApp'),
		"order-button" => __('WhatsApp Order'),
		"hide-elements" => __('Hide / Disable'),
		"translations" => __('Translations'),
		"utilities" => __('Utilities')
    );

// unset WooCommerce features if WooCommerce plugin is not active
if ( !class_exists( 'WooCommerce' ) ) {
    unset($views["order-button"]);
    unset($views["hide-elements"]);
    unset($views["translations"]);
    unset($views["utilities"]);
}

?>

<div class="shop_extra-plugin-wrapper">

    <div class="shop_extra_header">
                <h1 class="shop_extra_page_title"><?php echo esc_html(SHOPEXTRA_NAME); ?><span> v. <?php echo esc_html(SHOPEXTRA_VERSION); ?></span></h1>
			<p class="shop_extra_page_description"><?php echo esc_html(SHOPEXTRA_DESCRIPTION); ?></p>
            </div>
    <div class="shop_extra_wrapper">
        <div class="shop_extra_messages">
            <?php do_action("ShopExtra\shop_extra_messages");?>
            <span></span>
        </div>
    	
    	<div class="shop_extra-navigation navigation flex">
    	    
                <ul class="nav">
                    <?php
                    foreach($views as $slug => $view):
                    ?>
                    <li class="shop_extra_tab-<?php echo esc_html( $slug ) ?>">
                        <a href="#tab-<?php echo esc_html( $slug ) ?>" data-tab="tab-<?php echo esc_html( $slug ) ?>" id="shop_extra_tab-<?php echo esc_html( $slug ) ?>"<?php esc_html( $slug ) == 'floating' ? ' class="current"' : ''?>><?php _e($view, 'shop-extra'); ?></a>
                    </li>
                    <?php
                    endforeach;
                    ?>
                    <?php do_action("shop_extra_after_menu_tab"); ?>
                </ul>
                
                <ul class="mt-auto small-padding">
                    <li><a href="#tab-import-settings" data-tab="tab-import-settings" id="shop_extra_tab_import-settings"><?php _e('Import Settings')?></a></li>
                    <li><a href="<?php echo esc_url(admin_url('admin.php?page=optimize-more=shop_extra&shop_extra-action=export')) ?>" class="shop_extra-ignore"><?php _e('Export Settings') ?></a></li>
                    <li><a href="<?php echo esc_url(admin_url('admin.php?page=optimize-more=shop_extra&shop_extra-action=reset')) ?>" class="shop_extra-ignore reset-confirm"><?php _e('Reset Plugin')?></a></li>
                </ul>
                
        </div>
    	
        <form method="post" enctype="multipart/form-data" class="shop_extra-form" action="<?php echo ShopExtra\SHOPEXTRA()->admin_url(); ?>" >
            <?php wp_nonce_field('shop_extra-settings-action', 'shop_extra-settings_nonce'); ?>
            
            <div class="shop_extra_content">
                <?php
                
                do_action("shop_extra_before_body");
                
                foreach ($views as $slug => $view) :
                    print '<section class="tab-'. esc_html( $slug ) .'" id="'. esc_html( $slug ) .'">';
                    ShopExtra\SHOPEXTRA()->admin_view( 'parts/' . esc_html( $slug ));
                    print '</section>';
                endforeach;
                
                do_action("shop_extra_after_body");
                ?>
            </div>
    		
    	<div class="shop_extra-save-settings">
                    <input type="submit" value="<?php _e('Save Changes', 'shop-extra') ?>" class="button button-primary button-large" name="shop_extra-settings" />
        </div>
        </form>
        
        <div class="shop_extra_sidebar">
            <?php ShopExtra\SHOPEXTRA()->admin_view('parts/sidebar'); ?>
        </div>
        
    </div>

</div>
<?php
wp_enqueue_media();