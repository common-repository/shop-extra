<div class="flex flex grid-col-2">
	
	<!-- start custom intro message -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<textarea placeholder="<?php _e( 'Hi&#13;&#10 I want to buy:' ); ?>" class="textarea-custom style-textarea" rows="6" name="shop_extra_product_button_message_before"><?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_before')) ?></textarea>
		</div>
		<div class="shop_extra-help style pl-2">
			<?php _e('Before order details message', 'shop-extra') ?>
		</div>
	</div>
	<!-- end custom intro message -->
	
	<!-- start custom after message -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<textarea placeholder="<?php _e( 'Thank you!' ); ?>" class="textarea-custom style-textarea" rows="6" name="shop_extra_product_button_message_after"><?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_after')) ?></textarea>
		</div>
		<div class="shop_extra-help pl-2">
			<?php _e('After order details message', 'shop-extra') ?>
		</div>
	</div>
	<!-- end custom after message -->
	
	<!-- start price & url -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<!-- start price -->
        <div class="shop_extra-input pt-6 pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_price_enable" value="1" name="shop_extra_product_button_price_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_price_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_price_enable"></label><label class="toggle-label small" for="shop_extra_product_button_price_enable"><?php _e('Enable Price in message', 'shop-extra'); ?></label>
        </div>
		<!-- start url -->
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_product_button_url_enable" value="1" name="shop_extra_product_button_url_enable" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_product_button_url_enable'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_product_button_url_enable"></label><label class="toggle-label small" for="shop_extra_product_button_url_enable"><?php _e('Enable URL in message', 'shop-extra'); ?></label>
        </div>
		
		
    </div>
	<!-- end price & url -->
	
	<div class="shop_extra-spacer shop_extra-spacer-medium"></div>
	
	<div class="custom-header w-100">
		<h3><?php _e('These texts below appear only on the Cart & Checkout Page buttons and if you enable price in message:', 'shop-extra') ?></h3>
	</div>
	
	<!-- start custom total text message -->
	<div class="shop_extra-input-group flex-20 pt-6 pb-0">
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Total' ); ?>" type="text" id="shop_extra_product_button_message_total" name="shop_extra_product_button_message_total" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_total')) ?>">
		</div>
	</div>
	<!-- end custom total text message -->
	
	<!-- start custom ship to message -->
	<div class="shop_extra-input-group flex-20 pt-6 pb-0">
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Please ship to:' ); ?>" type="text" id="shop_extra_product_button_message_ship_to" name="shop_extra_product_button_message_ship_to" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_ship_to')) ?>">
		</div>
	</div>
	<!-- end custom ship to message -->
	
	<!-- start custom ship method message -->
	<div class="shop_extra-input-group flex-20 pt-6 pb-0">
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Shipping method' ); ?>" type="text" id="shop_extra_product_button_message_shipping_method" name="shop_extra_product_button_message_shipping_method" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_shipping_method')) ?>">
		</div>
	</div>
	<!-- end custom ship method message -->
	
	<!-- start custom tax message -->
	<div class="shop_extra-input-group flex-20 pt-6 pb-0">
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Tax' ); ?>" type="text" id="shop_extra_product_button_message_tax" name="shop_extra_product_button_message_tax" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_tax')) ?>">
		</div>
	</div>
	<!-- end custom tax message -->
	
	<!-- start custom payment message -->
	<div class="shop_extra-input-group flex-20 pt-6 pb-0">
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Payment Method' ); ?>" type="text" id="shop_extra_product_button_message_payment" name="shop_extra_product_button_message_payment" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_payment')) ?>">
		</div>
	</div>
	<!-- end custom payment message -->
	
	<!-- start custom grand total message -->
	<div class="shop_extra-input-group flex-20 pt-6 pb-0">
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Grand Total' ); ?>" type="text" id="shop_extra_product_button_message_grand_total" name="shop_extra_product_button_message_grand_total" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_product_button_message_grand_total')) ?>">
		</div>
	</div>
	<!-- end custom grand total message -->

		
</div>