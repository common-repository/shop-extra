<div class="shop_extra-input-group show-hide-group flex-full-width pb-10">
    <div class="shop_extra-input pt-15 pb-0">
        <input class="shop_extra-toggle shop_extra-toggle-light main-toggle show-hide" data-show-hide="1" id="shop_extra_floating_enable" name="shop_extra_floating_enable" value="1" type="checkbox"
            <?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_floating_enable'), 1, true) ?>/>
        <label class="shop_extra-toggle-btn" for="shop_extra_floating_enable"></label>
        <label class="toggle-label pl-4" for="shop_extra_floating_enable">
                <?php _e('Enable', 'shop-extra') ?>
        </label>
            
    </div>
    <div id="" class="show-hide-content padding-left-0 pb-18 mb-15 border-bottom-light">
        <div class="flex grid-col-2 pt-10">
            
			<!-- start names, numbers, images -->
			
			<!-- start name -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Name/Label(s)', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<textarea placeholder="<?php _e( 'e.g.:&#13;&#10 Customer Service One&#13;&#10;Customer Service Two&#13;&#10;Chat to Jogja Branch&#13;&#10;Chat to Bali Branch&#13;&#10;&#13;&#10;*one per line' ); ?>" class="textarea-custom" rows="7" name="shop_extra_floating_names" ><?php echo esc_textarea(ShopExtra\shop_extra_field_setting('shop_extra_floating_names')) ?></textarea>
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
						<textarea placeholder="<?php _e( 'e.g.:&#13;&#10 62818000001&#13;&#10;62818000002&#13;&#10;62818000003&#13;&#10;62818000004&#13;&#10;&#13;&#10;*one per line' ); ?>" class="textarea-custom" rows="7" name="shop_extra_floating_numbers"><?php echo esc_textarea(ShopExtra\shop_extra_field_setting('shop_extra_floating_numbers')) ?></textarea>
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
						<textarea placeholder="<?php _e( 'e.g.:&#13;&#10 /wp-content/uploads/logo-one.png&#13;&#10;/wp-content/uploads/logo-two.png&#13;&#10;/wp-content/uploads/logo-three.png&#13;&#10;/wp-content/uploads/logo-four.png&#13;&#10;&#13;&#10;*one per line' ); ?>" class="textarea-custom" rows="7" name="shop_extra_floating_images"><?php echo esc_textarea(ShopExtra\shop_extra_field_setting('shop_extra_floating_images')) ?></textarea>
					</div>
				</div>
                    
            </div>
            <!-- end images -->
			
			<!-- start availability -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Availability Time', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input class="w-100" placeholder="<?php _e( 'leave this empty to always available' ); ?>" type="text" id="shop_extra_floating_availability" name="shop_extra_floating_availability" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_floating_availability')) ?>">
					</div>
				</div>
                    
            </div>
            <!-- end availability -->
			
			<!-- start available text -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Custom Available Text', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input class="w-100" placeholder="<?php _e( 'only appear if availability time is set' ); ?>" type="text" id="shop_extra_floating_availability_available_text" name="shop_extra_floating_availability_available_text" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_floating_availability_available_text')) ?>">
					</div>
				</div>
                    
            </div>
            <!-- end available tex -->
			
			<!-- start not available text -->
            <div class="shop_extra-input-group flex-30">
                    
                <div class="custom-header">
                    <h2><?php _e('Custom Not Available Text', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input class="w-100" placeholder="<?php _e( 'only appear if availability time is set' ); ?>" type="text" id="shop_extra_floating_availability_notavailable_text" name="shop_extra_floating_availability_notavailable_text" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_floating_availability_notavailable_text')) ?>">
					</div>
				</div>
                    
            </div>
            <!-- end not available tex -->
            
        
		<!--  end names, numbers, images -->
		
		<div class="shop_extra-spacer shop_extra-spacer-large"></div>
			            
            <!-- start chat custom button img -->
            <div class="shop_extra-input-group flex-50">
                    
                <div class="custom-header">
                    <h2><?php _e('Custom Chat Button Image', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input class="w-100" placeholder="<?php _e( 'if leave empty, the WhatsApp default icon will be used' ); ?>" type="text" id="shop_extra_floating_button_image" name="shop_extra_floating_button_image" value="<?php echo esc_url(ShopExtra\shop_extra_field_setting('shop_extra_floating_button_image')) ?>">
					</div>
				</div>

            </div>
            <!-- end chat custom button img -->
			
            
            <!-- start chat tooltip -->
            <div class="shop_extra-input-group flex-50">
                    
                <div class="custom-header">
                    <h2><?php _e('Chat Button Tooltip', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input class="w-100" placeholder="<?php _e( 'if leave empty, no tooltip will be displayed' ); ?>" type="text" id="shop_extra_floating_tooltip" name="shop_extra_floating_tooltip" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_floating_tooltip')) ?>">
					</div>
				</div>
                    
            </div>
            <!-- end chat tooltip -->
			
			<!-- start chat heading/title -->
            <div class="shop_extra-input-group flex-50">
                    
                <div class="custom-header">
                    <h2><?php _e('Popup Heading Title', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input class="w-100" placeholder="<?php _e( 'if leave empty, the heading section will not be displayed' ); ?>" type="text" id="shop_extra_floating_heading_title" name="shop_extra_floating_heading_title" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_floating_heading_title')) ?>">
					</div>
				</div>
      
            </div>
            <!-- end chat heading/title -->
			
			<!-- start heading desc -->
            <div class="shop_extra-input-group flex-50">
                    
                <div class="custom-header">
                    <h2><?php _e('Popup Heading Description', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input placeholder="<?php _e( 'if leave empty, no description will be displayed' ); ?>" type="text" id="shop_extra_floating_heading_description" name="shop_extra_floating_heading_description" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_floating_heading_description')) ?>">
					</div>
				</div>
                   
            </div>
            <!-- end heading desc -->
			
			<!-- start chat heading image -->
            <div class="shop_extra-input-group flex-50">
                    
                <div class="custom-header">
                    <h2><?php _e('Popup Heading Image', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input placeholder="<?php _e( 'if leave empty, no image will be displayed' ); ?>" type="text" id="shop_extra_floating_heading_image" name="shop_extra_floating_heading_image" value="<?php echo esc_url(ShopExtra\shop_extra_field_setting('shop_extra_floating_heading_image')) ?>">
					</div>
				</div>
      
            </div>
            <!-- end chat heading image -->
			
			<!-- start chat pre-filled message -->
            <div class="shop_extra-input-group flex-50">
                    
                <div class="custom-header">
                    <h2><?php _e('Chat Pre-filled Message', 'shop-extra') ?></h2>
                </div>
				<div class="shop_extra-input-group">
					<div class="shop_extra-input">
						<input placeholder="<?php _e( 'leave empty to not use chat pre-filled messages' ); ?>" type="text" id="shop_extra_floating_prefilled_message" name="shop_extra_floating_prefilled_message" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_prefilled_message')) ?>">
					</div>
				</div>
      
            </div>
            <!-- end chat pre-filled message -->
		
		</div><!-- end flex wraper -->
		
		<!--  start styling section -->
		<div class="shop_extra-spacer shop_extra-spacer-medium"></div>
		<div class="shop_extra-body-header">
			<h2><?php _e('Floating WhatsApp Button Custom Styling', 'shop-extra') ?></h2>
		</div>
		<?php ShopExtra\shopextra()->admin_view('parts/partials/floating/styling'); ?>
		<!--  end styling section -->
		
    </div> <!-- end body wraper -->