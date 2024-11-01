<div class="mt-15">
	
	<!-- start hide price button -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_single_price_hide" value="1" name="shop_extra_product_button_single_price_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_single_price_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_single_price_hide"></label><label class="toggle-label small" for="shop_extra_product_button_single_price_hide"><?php _e('Hide Product Price', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide price button -->
    
	<!-- start hide quantity button -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_single_quantity_hide" value="1" name="shop_extra_product_button_single_quantity_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_single_quantity_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_single_quantity_hide"></label><label class="toggle-label small" for="shop_extra_product_button_single_quantity_hide"><?php _e('Hide Quantity Option', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide quantity button -->
	
	<!-- start hide add to cart button -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_single_add_to_cart_hide" value="1" name="shop_extra_product_button_single_add_to_cart_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_single_add_to_cart_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_single_add_to_cart_hide"></label><label class="toggle-label small" for="shop_extra_product_button_single_add_to_cart_hide"><?php _e('Hide Add to Cart button', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide add to cart button -->
	
	<!-- start hide category label -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_single_category_label_hide" value="1" name="shop_extra_product_single_category_label_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_single_category_label_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_single_category_label_hide"></label><label class="toggle-label small" for="shop_extra_product_single_category_label_hide"><?php _e('Hide Category Label', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide category label -->
	
	<!-- start hide description_heading -->
	<div class="shop_extra-input-group">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_description_heading_hide" value="1" name="shop_extra_product_description_heading_hide" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_description_heading_hide'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_description_heading_hide"></label><label class="toggle-label small" for="shop_extra_product_description_heading_hide"><?php _e('Hide Description Heading', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end hide description_heading -->
		
</div>