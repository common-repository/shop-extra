<div class="shop_extra-body-header">
    <h2><?php _e('Add Datepicker to WooCommerce', 'shop-extra') ?></h2>
</div>

<div class="shop_extra-input-group hide-show-group mt-13 pl-2">
	
	<input class="shop_extra-toggle shop_extra-toggle-light hide-show" data-hide-show="1" id="shop_extra_datepicker_enable" name="shop_extra_datepicker_enable" value="1" type="checkbox"
	<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_datepicker_enable'), 1, true) ?>/>
	<label class="shop_extra-toggle-btn" for="shop_extra_datepicker_enable"></label>
	<label class="toggle-label pl-4" for="shop_extra_datepicker_enable">
	    <?php _e('Enable', 'shop-extra') ?>
	</label>

	<div class="hide-show-content padding-left-0 mb-15">
    
        <div class="grid mt-7 col-2">
	
        	<!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        			<input class="w-100i style-input" placeholder="<?php _e( 'Label' ); ?>" type="text" id="shop_extra_datepicker_label" name="shop_extra_datepicker_label" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_label')) ?>">
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('Appear before the datepicker <em>*required</em>', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
        	
        	<!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        			<input class="w-100i style-input" placeholder="<?php _e( 'Description' ); ?>" type="text" id="shop_extra_datepicker_desc" name="shop_extra_datepicker_desc" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_desc')) ?>">
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('Appear after the datepicker', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
        	
        	<!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        			<input class="w-100i style-input" placeholder="<?php _e( 'Key and Meta' ); ?>" type="text" id="shop_extra_datepicker_meta_key" name="shop_extra_datepicker_meta_key" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_meta_key')) ?>">
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('Appear in cart, checkout, and order page <em>*required</em>', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
        	
        	<div class="shop_extra-input-group grid col-2">
        	    
        	    <!-- start  -->
            	<div class="shop_extra-input-group w-100">
            	    
            		<div class="shop_extra-input">
            			<input class="w-100i style-input" placeholder="<?php _e( 'minimum availability' ); ?>" type="text" id="shop_extra_datepicker_min_date" name="shop_extra_datepicker_min_date" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_min_date')) ?>">
            		</div>
            		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
            		    <?php _e('*days (required)', 'shop-extra') ?>
            		</div>
            	</div>
            	<!-- end -->
            	
            	<!-- start  -->
            	<div class="shop_extra-input-group w-100">
            	    
            		<div class="shop_extra-input">
            			<input class="w-100i style-input" placeholder="<?php _e( 'maximum availability' ); ?>" type="text" id="shop_extra_datepicker_max_date" name="shop_extra_datepicker_max_date" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_max_date')) ?>">
            		</div>
            		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
            		    <?php _e('*days', 'shop-extra') ?>
            		</div>
            	</div>
            	<!-- end -->
        	    
        	</div>
        	
        	<!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        		    <select id="shop_extra_datepicker_mode" name="shop_extra_datepicker_mode" class="shop_extra-select w-100">
            			<option value="single" <?php selected(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_mode'), 'single', true) ?>>Single</option>
                        <option value="range" <?php selected(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_mode'), 'range', true) ?>>Range</option>
                    </select>
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('<strong>Default date picker mode</strong>. <em>*You can change it individually in the product editor (Product Data - Date Picker Tab)</em>', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
        	
        	<!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        		    <select id="shop_extra_datepicker_display" name="shop_extra_datepicker_display" class="shop_extra-select w-100">
            			<option value="product" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_datepicker_display') == "product") echo 'selected="selected"'; ?>>Product pages (save the date for each product)</option>
        	        	<option value="checkout" <?php if (ShopExtra\shop_extra_field_setting('shop_extra_datepicker_display') == "checkout") echo 'selected="selected"'; ?>>Checkout page (save the date per order)</option>
                    </select>
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('Choose where you want the datepicker to be displayed', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
        	
        	<!-- start  -->
            <div class="shop_extra-input-group w-100 pt-4">
                
            	<div class="shop_extra-input">
            		<input class="w-100i style-input" placeholder="<?php _e( 'eg: 1,3 *use comma if you have more than 1 day to disable' ); ?>" type="text" id="shop_extra_datepicker_disable_days" name="shop_extra_datepicker_disable_days" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_disable_days')) ?>">
            	</div>
            	<div class="shop_extra-help normal pl-2 pt-4 pb-8">
            	    <?php _e('Disable day(s) <em>*only works in Single mode</em>', 'shop-extra') ?>
            	</div>
            </div>
            <!-- end -->
            
            <!-- start  -->
            <div class="shop_extra-input-group w-100 pt-4">
                
            	<div class="shop_extra-input">
            		<input class="w-100i style-input" placeholder="<?php _e( 'format: mm/dd/yyyy; 12/25/2023,12/31/2023,01/01/2024' ); ?>" type="text" id="shop_extra_datepicker_disable_dates" name="shop_extra_datepicker_disable_dates" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_disable_dates')) ?>">
            	</div>
            	<div class="shop_extra-help normal pl-2 pt-4 pb-8">
            	    <?php _e('Disable specific date(s)', 'shop-extra') ?>
            	</div>
            </div>
            <!-- end -->
        	
        	<div class="shop_extra-input-group show-hide-group pt-6 pl-2 grid col-2 w-100i" style="grid-column:span 2">
	           <div class=" ">
	               <div>
                	<input class="shop_extra-toggle shop_extra-toggle-light show-hide" data-show-hide="1" id="shop_extra_datepicker_time" name="shop_extra_datepicker_time" value="1" type="checkbox"
                	<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_datepicker_time'), 1, true) ?>/>
                	<label class="shop_extra-toggle-btn" for="shop_extra_datepicker_time"></label>
                	<label class="toggle-label pl-4" for="shop_extra_datepicker_time">
                	    <?php _e('Add Time', 'shop-extra') ?>
                	</label>
            	    </div>
            	    <div class="shop_extra-help normal pl-2 pb-8">
                        <?php _e('Give the datepicker a time option', 'shop-extra') ?>
                    </div>
            	</div>
            
            	<div class="show-hide-content shop_extra-input-group grid col-2 pt-4">
                    	    
                    <!-- start  -->
                    <div class="shop_extra-input-group w-100">
                    	    
                        <div class="shop_extra-input">
                            <input class="w-100i style-input" placeholder="<?php _e( 'minimum time availability' ); ?>" type="text" id="shop_extra_datepicker_min_time" name="shop_extra_datepicker_min_time" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_min_time')) ?>">
                        </div>
                        <div class="shop_extra-help normal pl-2 pt-4 pb-8">
                            <?php _e('*format "H:i" (required)', 'shop-extra') ?>
                        </div>
                    </div>
                    <!-- end -->
                        	
                    <!-- start  -->
                    <div class="shop_extra-input-group w-100">
                        	    
                        <div class="shop_extra-input">
                            <input class="w-100i style-input" placeholder="<?php _e( 'maximum time availability' ); ?>" type="text" id="shop_extra_datepicker_max_time" name="shop_extra_datepicker_max_time" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_datepicker_max_time')) ?>">
                        </div>
                        <div class="shop_extra-help normal pl-2 pt-4 pb-8">
                            <?php _e('*format "H:i"', 'shop-extra') ?>
                        </div>
                    </div>
                    <!-- end -->
                    	    
                </div>
                    	
            </div>
        
        </div><!-- end of show-hide container -->
    
    </div><!-- end of hide-show container -->
    
</div>