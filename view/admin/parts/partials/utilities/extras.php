<div class="shop_extra-body-header">
    <h2><?php _e('Extras', 'shop-extra') ?></h2>
</div>


<div class="grid mt-13 col-2">
    
    <!-- start  -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_block_editor_enable" value="1" name="shop_extra_block_editor_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_block_editor_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_block_editor_enable"></label><label class="toggle-label small" for="shop_extra_block_editor_enable"><?php _e('Blocks for Product Editor', 'shop-extra'); ?></label>
        </div>
        <div class="shop_extra-help normal pl-2 pb-8">
            <?php _e('Enable Gutenberg Editor for Products', 'shop-extra') ?>
        </div>
	</div>
	<!-- end -->
    
	<!-- start  -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_custom_tab_enable" value="1" name="shop_extra_custom_tab_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_custom_tab_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_custom_tab_enable"></label><label class="toggle-label small" for="shop_extra_custom_tab_enable"><?php _e('Add Extra Tabs', 'shop-extra'); ?></label>
        </div>
        <div class="shop_extra-help normal pl-2 pb-8">
            <?php _e('Enable extra custom tab(s) for Products', 'shop-extra') ?>
        </div>
	</div>
	<!-- end -->
	
	<!-- start  -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_after_price_text_enable" value="1" name="shop_extra_after_price_text_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_after_price_text_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_after_price_text_enable"></label><label class="toggle-label small" for="shop_extra_after_price_text_enable"><?php _e('Add After Price Text to Products', 'shop-extra'); ?></label>
        </div>
        <div class="shop_extra-help normal pl-2 pb-8">
            <?php _e('<em>*useful if you want to add information like price units</em>', 'shop-extra') ?>
        </div>
	</div>
	<!-- end -->
	
	<!-- start  -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_limit_order_enable" value="1" name="shop_extra_limit_order_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_limit_order_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_limit_order_enable"></label><label class="toggle-label small" for="shop_extra_limit_order_enable"><?php _e('Limit Order Quantity', 'shop-extra'); ?></label>
        </div>
        <div class="shop_extra-help normal pl-2 pb-8">
            <?php _e('Enable limit order quantity (min/max) individually', 'shop-extra') ?>
        </div>
	</div>
	<!-- end -->
	
	<!-- start  -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_checkout_edit_order_enable" value="1" name="shop_extra_checkout_edit_order_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_checkout_edit_order_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_checkout_edit_order_enable"></label><label class="toggle-label small" for="shop_extra_checkout_edit_order_enable"><?php _e('Add Edit Order features to Checkout', 'shop-extra'); ?></label>
        </div>
        <div class="shop_extra-help normal pl-2 pb-8">
            <?php _e('Enable users to edit quantity or remove items on Checkout page', 'shop-extra') ?>
        </div>
	</div>
	<!-- end -->
	
</div>