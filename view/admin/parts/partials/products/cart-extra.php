<div class="shop_extra-input-group hide-show-group mt-13 w-90 pl-2">
	
	<input class="shop_extra-toggle shop_extra-toggle-light hide-show" data-hide-show="1" id="shop_extra_product_button_cart_proceed_hide" name="shop_extra_product_button_cart_proceed_hide" value="1" type="checkbox"
	<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_product_button_cart_proceed_hide'), 1, true) ?>/>
	<label class="shop_extra-toggle-btn" for="shop_extra_product_button_cart_proceed_hide"></label>
	<label class="toggle-label small pl-4" for="shop_extra_product_button_cart_proceed_hide">
	    <?php _e('Hide Proceed to checkout button', 'shop-extra') ?>
	</label>

	<div class="hide-show-content padding-left-0 mb-15">

	    <div class="shop_extra-input-group">
	        <!-- start info -->
			<div class="shop_extra-help normal w-96 pl-2">
			<?php _e('This will also hide the proceed to checkout button on the Mini Cart. Enabling this assumes that you don\'t need the checkout page, so this will automatically add an additional script to empty the cart when the user click the WhatsApp button(s) in the cart page.', 'shop-extra') ?>
			</div>
			<!-- end info -->
	    </div>
		
	</div><!-- end of hide-show container -->
			
</div>