<div class="mt-15">
	
	<!-- start hide price button -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_loops_price_hide" value="1" name="shop_extra_product_button_loops_price_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_loops_price_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_loops_price_hide"></label><label class="toggle-label small" for="shop_extra_product_button_loops_price_hide"><?php _e('Hide Product Price', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide price button -->
	
	<!-- start hide add to cart button -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_loops_add_to_cart_hide" value="1" name="shop_extra_product_button_loops_add_to_cart_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_loops_add_to_cart_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_loops_add_to_cart_hide"></label><label class="toggle-label small" for="shop_extra_product_button_loops_add_to_cart_hide"><?php _e('Hide Add to Cart button', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide add to cart button -->
	
	
	<!-- start hide quantity button -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_loops_disable_links" value="1" name="shop_extra_product_button_loops_disable_links" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_loops_disable_links'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_loops_disable_links"></label><label class="toggle-label small" for="shop_extra_product_button_loops_disable_links"><?php _e('Disable Links to Product Pages', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide quantity button -->
		
</div>