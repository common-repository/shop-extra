<div class="flex custom-header mt-10 pl-2">
    <h2>Cart & Checkout Page</h2>
</div>

<div class="flex mt-7 grid-col-2 grid-row-05">
	
	<!-- start custom product text -->
	<div class="shop_extra-input-group flex-20 pb-0">
	    
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Product' ); ?>" type="text" id="shop_extra_translate_cart_checkout_page_product" name="shop_extra_translate_cart_checkout_page_product" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_translate_cart_checkout_page_product')) ?>">
		</div>
	</div>
	<!-- end custom product text -->
	
	<!-- start custom subtotal text -->
	<div class="shop_extra-input-group flex-20 pb-0">
	    
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Subtotal' ); ?>" type="text" id="shop_extra_translate_cart_checkout_page_subtotal" name="shop_extra_translate_cart_checkout_page_subtotal" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_translate_cart_checkout_page_subtotal')) ?>">
		</div>
	</div>
	<!-- end custom subtotal text -->
	
	<!-- start custom shipping text -->
	<div class="shop_extra-input-group flex-20 pb-0">
	    
		<div class="shop_extra-input">
			<input class="w-100 style-input" placeholder="<?php _e( 'Shipping' ); ?>" type="text" id="shop_extra_translate_checkout_page_shipping" name="shop_extra_translate_checkout_page_shipping" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_translate_checkout_page_shipping')) ?>">
		</div>
	</div>
	<!-- end custom shipping text -->
	
		
</div>