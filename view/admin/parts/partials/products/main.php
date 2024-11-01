<div class="shop_extra-input-group show-hide-group flex-full-width pb-10">
    <div class="shop_extra-input pt-15 pb-0">
        <input class="shop_extra-toggle shop_extra-toggle-light main-toggle show-hide" data-show-hide="1" id="shop_extra_product_button_enable" name="shop_extra_product_button_enable" value="1" type="checkbox"
            <?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_product_button_enable'), 1, true) ?>/>
        <label class="shop_extra-toggle-btn" for="shop_extra_product_button_enable"></label>
        <label class="toggle-label pl-4" for="shop_extra_product_button_enable">
                <?php _e('Enable', 'shop-extra') ?>
        </label>
            
    </div>
    <div id="" class="show-hide-content padding-left-0 mb-10">
        <div class="flex grid-col-2 pt-10">
			
			<!-- start names, numbers, images -->
			
			<!-- start name -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Name/Label(s)', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<textarea placeholder="<?php _e( 'e.g.:&#13;&#10 Customer Service One&#13;&#10;Customer Service Two&#13;&#10;Order from Jogja Branch&#13;&#10;Order from Bali Branch&#13;&#10;&#13;&#10;*one per line' ); ?>" class="textarea-custom" rows="7" name="shop_extra_product_button_names" ><?php echo esc_textarea(ShopExtra\shop_extra_field_setting('shop_extra_product_button_names')) ?></textarea>
					</div>
				</div>

            </div>
            <!-- end name -->
			
            <!-- start numbers -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Name/Label Number(s)', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<textarea placeholder="<?php _e( 'e.g.:&#13;&#10 62818000001&#13;&#10;62818000002&#13;&#10;62818000003&#13;&#10;62818000004&#13;&#10;&#13;&#10;*one per line' ); ?>" class="textarea-custom" rows="7" name="shop_extra_product_button_numbers"><?php echo esc_textarea(ShopExtra\shop_extra_field_setting('shop_extra_product_button_numbers')) ?></textarea>
					</div>
				</div>
                    
            </div>
            <!-- end numbers -->
            
            <!-- start images -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Name/Label Image(s)', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<textarea placeholder="<?php _e( 'e.g.:&#13;&#10 /wp-content/uploads/logo-one.png&#13;&#10;/wp-content/uploads/logo-two.png&#13;&#10;/wp-content/uploads/logo-three.png&#13;&#10;/wp-content/uploads/logo-four.png&#13;&#10;&#13;&#10;*one per line' ); ?>" class="textarea-custom" rows="7" name="shop_extra_product_button_images"><?php echo esc_textarea(ShopExtra\shop_extra_field_setting('shop_extra_product_button_images')) ?></textarea>
					</div>
				</div>
                    
            </div>
            <!-- end images -->		
            
        </div><!-- end flex wraper -->
		<!--  end names, numbers, images -->
		
		<div class="flex pt-6 grid-col-2 grid-row-1">
			
			<!-- start single product button -->
            <div class="shop_extra-input-group toggle-group flex-50">
			<input class="shop_extra-toggle shop_extra-toggle-light main-toggle" data-revised="1" id="shop_extra_product_button_single_enable" name="shop_extra_product_button_single_enable" value="1" type="checkbox"
			<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_product_button_single_enable'), 1, true) ?>/>
			<label class="shop_extra-toggle-btn" for="shop_extra_product_button_single_enable"></label>
			<label class="toggle-label small pl-4" for="shop_extra_product_button_single_enable">
			    <?php _e('Enable on Single Product Page', 'shop-extra') ?>
			</label>

			<div class="sub-fields padding-left-0 mb-25">

			    <div class="shop_extra-input-group">
			        <!-- start position -->
					<div class="shop_extra-input pt-10 pb-8">
						<select id="shop_extra_product_button_single_button_position" name="shop_extra_product_button_single_button_position" class="shop_extra-select w-92">
							<option value="1" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_single_button_position') == 1) echo 'selected="selected"'; ?>>After add to cart button</option>
							<option value="2" <?php  if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_single_button_position') == 2 ) echo 'selected="selected"'; ?>>Before add to cart form</option>
							<option value="3" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_single_button_position') == 3 ) echo 'selected="selected"'; ?>>After add to cart form</option>
						</select>
					</div>
					<div class="shop_extra-help w-90 pt-13 pl-2">
						<?php _e('Button position', 'shop-extra') ?>
					</div>
					<!-- end position -->
			    </div>
			</div>
			<!-- end of sub fields container -->
            </div>
            <!-- end single product button -->
			
			<!-- start loop button -->
            <div class="shop_extra-input-group toggle-group flex-50">
				<input class="shop_extra-toggle shop_extra-toggle-light main-toggle" data-revised="1" id="shop_extra_product_button_loops_enable" name="shop_extra_product_button_loops_enable" value="1" type="checkbox"
				<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_product_button_loops_enable'), 1, true) ?>/>
				<label class="shop_extra-toggle-btn" for="shop_extra_product_button_loops_enable"></label>
				<label class="toggle-label small pl-4" for="shop_extra_product_button_loops_enable">
					<?php _e('Enable on Shop Loop', 'shop-extra') ?>
				</label>

				<div class="sub-fields padding-left-0 mb-25">

			    	<div class="shop_extra-input-group">
			        	<!-- start position -->
						<div class="shop_extra-input pt-10 pb-8">
							<select id="shop_extra_product_button_loops_button_position" name="shop_extra_product_button_loops_button_position" class="shop_extra-select w-92">
								<option value="1" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_loops_button_position') == 1) echo 'selected="selected"'; ?>>After add to cart button</option>
								<option value="2" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_loops_button_position') == 2 ) echo 'selected="selected"'; ?>>Before add to cart button</option>
								<option value="3" <?php  if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_loops_button_position') == 3 ) echo 'selected="selected"'; ?>>After product loop price</option>
							</select>
						</div>
						<div class="shop_extra-help w-90 pt-13 pl-2">
						<?php _e('Button position', 'shop-extra') ?>
					</div>
					<!-- end position -->
			    </div>
			</div>
			<!-- end of sub fields container -->
            </div>
            <!-- end loop button -->
            
            <!-- start cart button -->
            <div class="shop_extra-input-group toggle-group flex-50">
				<input class="shop_extra-toggle shop_extra-toggle-light main-toggle" data-revised="1" id="shop_extra_product_button_cart_enable" name="shop_extra_product_button_cart_enable" value="1" type="checkbox"
				<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_product_button_cart_enable'), 1, true) ?>/>
				<label class="shop_extra-toggle-btn" for="shop_extra_product_button_cart_enable"></label>
				<label class="toggle-label small pl-4" for="shop_extra_product_button_cart_enable">
					<?php _e('Enable on Cart Page', 'shop-extra') ?>
				</label>

				<div class="sub-fields padding-left-0 mb-10">

			    	<div class="shop_extra-input-group">
			        	<!-- start position -->
						<div class="shop_extra-input pt-10 pb-8">
							<select id="shop_extra_product_button_cart_button_position" name="shop_extra_product_button_cart_button_position" class="shop_extra-select w-92">
								<option value="1" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_cart_button_position') == 1) echo 'selected="selected"'; ?>>After proceed to checkout button</option>
								<option value="2" <?php  if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_cart_button_position') == 2 ) echo 'selected="selected"'; ?>>Before proceed to checkout button</option>
								<option value="3" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_product_button_cart_button_position') == 3 ) echo 'selected="selected"'; ?>>At the top of cart totals section</option>
							</select>
						</div>
						<div class="shop_extra-help w-90 pt-13 pl-2">
						<?php _e('Button position', 'shop-extra') ?>
						</div>
						<!-- end position -->
					</div>
					<?php ShopExtra\shopextra()->admin_view('parts/partials/products/cart-extra'); ?>
				</div><!-- end of sub fields container -->
			
            </div>
            <!-- end cart button -->
			
			<!-- start checkout button -->
            <div class="shop_extra-input-group toggle-group flex-50">
			<input class="shop_extra-toggle shop_extra-toggle-light main-toggle" data-revised="1" id="shop_extra_product_button_checkout_enable" name="shop_extra_product_button_checkout_enable" value="1" type="checkbox"
			<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_product_button_checkout_enable'), 1, true) ?>/>
			<label class="shop_extra-toggle-btn" for="shop_extra_product_button_checkout_enable"></label>
			<label class="toggle-label small pl-4" for="shop_extra_product_button_checkout_enable">
			    <?php _e('Enable on Checkout Page', 'shop-extra') ?>
			</label>

			<div class="sub-fields padding-left-0 mb-10">

			    <div class="shop_extra-input-group">
			        <!-- start info -->
					<div class="shop_extra-help normal w-96 pl-2">
						<?php _e('This will automatically hide the default place order button and only show the WhatsApp button(s). When clicked, it will automatically place the order and redirect user to WhatsApp in a new tab while the checkout page will go to the order-received page like usual.', 'shop-extra') ?>
					</div>
					<!-- end info -->
			    </div>
			</div><!-- end of sub fields container -->
			
            </div>
            <!-- end checkout button -->
			
			
		</div>
		
		<!--  start styling section -->
		
		<div class="shop_extra-body-header">
			<h2><?php _e('Customize WhatsApp Text', 'shop-extra') ?></h2>
		</div>
		<?php ShopExtra\shopextra()->admin_view('parts/partials/products/styling'); ?>
		<!--  end styling section -->
		
		
		
    </div> <!-- end body wraper -->