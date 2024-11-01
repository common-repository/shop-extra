<div class="shop_extra-body-wrapper">
    <div class="shop_extra-body-header">
        <h2><?php _e('WooCommerce Strings Translations', 'shop-extra') ?></h2>
    </div>
    
    <div class="shop_extra-input-group hide-show-group mt-13 pl-2">
	
	<input class="shop_extra-toggle shop_extra-toggle-light hide-show" data-hide-show="1" id="shop_extra_translations_enable" name="shop_extra_translations_enable" value="1" type="checkbox"
	<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_translations_enable'), 1, true) ?>/>
	<label class="shop_extra-toggle-btn" for="shop_extra_translations_enable"></label>
	<label class="toggle-label pl-4" for="shop_extra_translations_enable">
	    <?php _e('Enable', 'shop-extra') ?>
	</label>

	<div class="hide-show-content padding-left-0 mb-15">
    
    
        <?php ShopExtra\shopextra()->admin_view('parts/partials/translations/general'); ?>
        <div class="shop_extra-spacer shop_extra-spacer-small"></div>
        <?php ShopExtra\shopextra()->admin_view('parts/partials/translations/single-product'); ?>
        <div class="shop_extra-spacer shop_extra-spacer-small"></div>
        <?php ShopExtra\shopextra()->admin_view('parts/partials/translations/cart'); ?>
        <div class="shop_extra-spacer shop_extra-spacer-small"></div>
        <?php ShopExtra\shopextra()->admin_view('parts/partials/translations/checkout'); ?>
        <div class="shop_extra-spacer shop_extra-spacer-small"></div>
        <?php ShopExtra\shopextra()->admin_view('parts/partials/translations/cart-checkout'); ?>
    
    
    </div><!-- end of hide-show container -->
    
</div>

<div class="shop_extra-spacer shop_extra-spacer-medium"></div>
<div class="shop_extra-spacer shop_extra-spacer-medium"></div>