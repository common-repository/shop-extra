<div class="shop_extra-body-wrapper">
    <div class="shop_extra-body-header">
        <h2><?php _e('WooCommerce Elements Customization', 'shop-extra') ?></h2>
    </div>
    <div class="flex grid-col-2 pt-15">
    
        <div class="shop_extra-input-group flex-30">
            <div class="custom-header">
                <h2>Single Product Elements</h2>
            </div>
			<?php ShopExtra\shopextra()->admin_view('parts/partials/products/single-product-extra'); ?>
        </div>
    
	    <div class="shop_extra-input-group flex-30">
            <div class="custom-header">
                <h2>Loops Elements</h2>
            </div>
			<?php ShopExtra\shopextra()->admin_view('parts/partials/products/loops-extra'); ?>
        </div>
	
	    <div class="shop_extra-input-group flex-30">
            <div class="custom-header">
                <h2>Checkout Elements</h2>
            </div>
			<?php ShopExtra\shopextra()->admin_view('parts/partials/products/checkout-extra'); ?>
        </div>
	
	</div>
</div>

<div class="shop_extra-spacer shop_extra-spacer-medium"></div>
<div class="shop_extra-spacer shop_extra-spacer-medium"></div>