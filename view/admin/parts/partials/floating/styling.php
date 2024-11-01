<div class="flex flex grid-col-2">

	<!-- start button position -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input pb-0">
            <input class="shop_extra-toggle shop_extra-toggle-light" id="shop_extra_floating_left" value="1" name="shop_extra_floating_left" <?php checked(ShopExtra\shop_extra_field_setting('shop_extra_floating_left'), 1, true) ?> type="checkbox"/>
            <label class="shop_extra-toggle-btn" for="shop_extra_floating_left"></label><label class="toggle-label small" for="shop_extra_floating_left"><?php _e('Move button to left', 'shop-extra'); ?></label>
        </div>
	</div>
	<!-- end button position -->
	
	<div class="shop_extra-spacer shop_extra-spacer-small"></div>
	
	<!-- start heading bg -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="" name="shop_extra_floating_button_bg_color" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_button_bg_color')) ?>"/>
		</div>
		<div class="shop_extra-help">
			<?php _e('Chat button background color', 'shop-extra') ?>
		</div>
	</div>
	<!-- end heading bg -->
	
	<!-- start heading bg -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="" name="shop_extra_floating_heading_bg_color" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_heading_bg_color')) ?>"/>
		</div>
		<div class="shop_extra-help">
			<?php _e('Chat heading background color', 'shop-extra') ?>
		</div>
	</div>
	<!-- end heading bg -->
	
	<!-- start account label bg -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="" name="shop_extra_floating_names_bg_color" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_names_bg_color')) ?>"/>
		</div>
		<div class="shop_extra-help">
			<?php _e('Account label background color', 'shop-extra') ?>
		</div>
	</div>
	<!-- end account label bg -->
	
	<!-- start account label text color -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<input type="text" class="color-picker" data-alpha-enabled="true" data-default-color="" name="shop_extra_floating_names_text_color" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_names_text_color')) ?>"/>
		</div>
		<div class="shop_extra-help">
			<?php _e('Account label text color', 'shop-extra') ?>
		</div>
	</div>
	<!-- end account label text color -->
	
	<!-- start chat button width -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<input type="text" id="shop_extra_floating_button_width" name="shop_extra_floating_button_width" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_button_width')) ?>" class="small"><span class="unit"><?php _e('*specify the unit', 'shop-extra') ?></span>
		</div>
		<div class="shop_extra-help">
			<?php _e('Chat button width & height', 'shop-extra') ?>
		</div>
	</div>
	<!-- end chat button width -->
	
	<!-- start chat button padding -->
	<div class="shop_extra-input-group flex-30 pt-24 pb-0">
		<div class="shop_extra-input">
			<input class="small" type="text" id="shop_extra_floating_button_padding" name="shop_extra_floating_button_padding" value="<?php echo esc_attr(ShopExtra\shop_extra_field_setting('shop_extra_floating_button_padding')) ?>"><span class="unit"><?php _e('*specify the unit', 'shop-extra') ?></span>
		</div>
		<div class="shop_extra-help">
			<?php _e('Chat button padding', 'shop-extra') ?>
		</div>
	</div>
	<!-- end chat button padding -->
	
</div>