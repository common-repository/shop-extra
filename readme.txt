=== ShopExtra — WooCommerce Extras ===
Contributors: aryadhiratara
Tags: whatsapp, whatsapp chat, woocommerce, woocommerce whatsapp, click to chat, shop, date picker, woocommerce tab, woocommerce tabs, woocommerce order limit,
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight plugin to enhance your WooCommerce & Business site. Floating WhatsApp Chat Widget , WhatsApp Order Button for WooCommerce, Hide/Disable WooCommerce Elements, WooCommerce Strings Translations, add Extra Product Tabs, add Date Picker to products, limit order quantity, add Custom Option to Checkout Page, Add Edit Order features to Checkout page, and many more.

== Description ==

**A lightweight plugin to enhance your WooCommerce & Business site**

## Features

- **Floating WhatsApp Chat Widget** - with:
  * Multiple numbers, no limitaton
  * Availability time
  * customizable settings

- **WhatsApp Order Button** - WhatsApp order button for WooCommerce products (multiple numbers, no limitaton). You can choose to enable it: 
  * on Single Product Page
  * on Shop Loop (Shop & Product Category page, product shortcode, related products)
  * on Cart Page
  * on Checkout Page
  * and customize the settings
&nbsp;
- **Extra Utility Features**
  - **Add Extra Product Tabs** - Enable extra custom tab(s) for each Products; you can add extra tabs as many as you like. The extra tabs can be exported using the default WooCommerce export, so you can migrate your store easily.
  - **Datepicker** (using [flatpickr js](https://flatpickr.js.org/) library) - 
combine this feature with [Order Approval for WooCommerce](https://wordpress.org/plugins/order-approval-woocommerce/) so you can easily turn your WooCommerce to have order date / booking functionality. Or, combine this with Custom (Radio Button) Options on Checkout Page, so you can easily turn your WooCommerce to have Order Date and Pickup Functionality. Features:

      * Option to display the Datepicker in the Product Page or Checkout Page
      * Option to display the Datepicker in Single or Range mode (_can be override individually in the product editor *only works if you display the Datepicker in the product page_)
      * Option to set minimum and maximum Availability Date
      * Option to disable day(s) and specific date(s)
      * Option to enable Time in the Datepicker
      * Option to enable Time in the Datepicker
      * Option to set minimum and maximum Availability Time
      * Saved the chosen date (will appear in order details and emails)

  - **Custom (Radio Button) Options** - Add custom options to WooCommerce Checkout Page. Combine this with the Date picker features, so you can easily turn your WooCommerce to have Order Date and Pickup Functionality. Features:

      * Add multiple options (no limitation)
      * Add option description using TinyMCE editor _(you can leave this blank if you only need the option title)_

  - **Add Edit Order features to Checkout** - Add Cart page functionality to Checkout page. Enable users to edit quantity or remove items on Checkout page.
      > You can use this filter if you want the quantity input to appear like Quantity Plus Minus Button:
      > ```
    add_filter('shop_extra_checkout_plus_minus_quantity_button', '__return_true');

  - **Blocks for Product Editor** - Enable Gutenberg Editor for Products; build your product pages using your favorite blocks.

  - **Add After Price Text to Products** - useful if you want to add information like price units.

  - **Limit Order Quantity** - Enable limit order quantity (min/max) individually.

- **WooCommerce Elements Customization** - Hide or disable:
  - Single Product Elements:
    - Hide Product Price
    - Hide Quantity Option
    - Hide Add to Cart button
    - Hide Category Label
    - Hide Description Heading
  - Loops Elements:
    - Hide Product Price
    - Hide Add to Cart button
    - Disable Links to Product Pages
  - Checkout Page Elements :
    - Hide Last Name Fields
    - Hide Ship to Different Address
    - Unset Billing Company Field
    - Unset Billing Address 1 Field
    - Unset Billing Address 2 Field
    - Unset Billing City Field
    - Unset Billing Postcode Field
    - Unset Billing Country Field
    - Unset Billing State Field
    - and more to come

- **WooCommerce Strings Translations** - Translate common WooCommerce strings like:
  - Add to cart
  - Select options
  - View Cart
  - Checkout
  - .... has ben added to cart
  - Proceed to Checkout
  - Cart Updated.
  - Description (Tab)
  - Review (Tab)
&nbsp; <br>


...and more to come!
## Note

- **Floating WhatsApp Chat Widget** can be use without WooCommerce.
- If you don't have WooCommerce plugin activated, the only setting that will appear is the **Floating WhatsApp Chat Widget** setting.
- By default, the look of **WhatsApp Order Buttons** should match the look of your WooCommerce buttons as they use the default WooCommerce button class.
- Therefore, there are no settings to customize the style of **WhatsApp Order Buttons** as there are no specific style for the buttons (I only add some inline styles to style the parent container). Feel free to customize the style using your own CSS if you need different appearance for the buttons.

## Disclaimer

This plugin only adds 1 extra row to your database. And it will self delete upon uninstalation.

## Found any issues?
Please use this [support forum](https://wordpress.org/support/plugin/shop-extra/) to report it.

## Check out my other plugins:

- **[Optimize More!](https://wordpress.org/plugins/optimize-more/)** -  A DIY WordPress Page Speed Optimization Pack.
- **[Optimize More! Images](https://wordpress.org/plugins/optimize-more-images/)** - A simple yet powerfull image, iframe, and video optimization plugin.
- **[Lazyload, Preload, and more!](https://wordpress.org/plugins/lazyload-preload-and-more/)** - This tiny little plugin (around 14kb zipped) is a simplified version of **Optimize More! Images**. Able to do what **Optimize More! Images** can do but without UI for settings (you can customize the default settings using filters).
- **[Image & Video Lightbox](https://wordpress.org/plugins/image-video-lightbox/)** - A lightweight plugin that will automatically adds Lightbox functionality to images.
- **[Animate on Scroll](https://wordpress.org/plugins/animate-on-scroll/)** - Animate any Elements on scroll using the popular AOS JS library simply by adding class names.
- **[SEO that Matters](https://wordpress.org/plugins/seo-that-matters/)** - A lightweight plugin to make your site more SEO (and Social Media) Friendly in a non-intrusive way.

&nbsp;
== Frequently Asked Questions ==

= WhatsApp Buttons =

Your can use multiple numbers. Number and image on line 1 will be the number and image of name in line 1, number and image on line 2 will be the number and image of name on line 2, and so on.

= Availability time =

The format is ```timezone, day(s), hour-start, hour-end```. Day start from monday (1). So if you want to set availability day is monday to friday, use 5. If it's monday to saturday, use 6.
E.g.: ```+7,5,9,17``` (GMT+7, Monday to Friday, start from 9am to 5pm)
Note: This will apply to all numbers and the available day can not be custom (e.g.: monday to thursday and saturday only) since this feature only use a simple (and only few lines of) vanilla js.

== Installation ==

#### From within WordPress

1. Visit **Plugins > Add New**
1. Search for **Shop Extra** or **Arya Dhiratara**
1. Activate Shop Extra from your Plugins page
1. Find Shop Extra in **Settings > ShopExtra**


#### Manually

1. Download the plugin using the download link in this WordPress plugins repository
1. Upload **shop-extra** folder to your **/wp-content/plugins/** directory
1. Activate Shop Extra plugin from your Plugins page
1. Find Shop Extra in **Settings > ShopExtra**


== Screenshots ==

1. Floating WhatsApp
2. WhatsApp Order
3. Hide /  Disable
4. Translations


== Changelog ==
&nbsp;
**Note**: Each update with new features are expected to have "undefined _some_options_ ...." warnings if you set WP_DEBUG to true in wp-config. Simply re-save this plugin settings to remove the warning.
&nbsp;

= 1.0.9 =
- Fixed missing custom radio options ui setting 

= 1.0.8 =
- Add Custom Options (Radio Button) for Checkout page
      * You can add multiple options (no limitation)
      * You can add option description using TinyMCE editor _(you can leave this blank if you only need the option title)_

- Add Edit Order features to Checkout page - Add Cart page functionality to Checkout page, enable users to edit quantity or remove items on Checkout page.

- Fix error in some PHP version if WhatsApp Order button enabled on Checkout page that occured after this plugin using _namespace_

= 1.0.7 =

- Enhance features for Datepicker.
 - Add option to display the Datepicker in the Checkout Page
 - Add option to disable day(s) and specific date(s)
 - Add option to enable Time in the Datepicker
 - Add option to set minimum and maximum Availability Time

= 1.0.6 =

- Bug fixes and performance improvements.

= 1.0.5 =

- **Extra Utility Features**
 - **Date picker** (using flatpickr library) - combine this feature with [Order Approval for WooCommerce](https://wordpress.org/plugins/order-approval-woocommerce/) so you can easily turn your WooCommerce to have order date / booking functionality.
 - **Add Extra Product Tabs** - Enable extra custom tab(s) for Products; you can add extra tabs as many as you like (the extra tabs can be exported using the default WooCommerce export). 
 - **Blocks for Product Editor** - Enable Gutenberg Editor for Products; build your product pages using your favorite blocks.
 - **Add After Price Text to Products** - useful if you want to add information like price units.
 - **Limit Order Quantity** - Enable limit order quantity (min/max) individually.

- **WooCommerce Elements Customization**
  add options to:
  - Unset Billing Company Field
  - Unset Billing Address 1 Field
  - Unset Billing Address 2 Field
  - Unset Billing City Field
  - Unset Billing Postcode Field
  - Unset Billing Country Field
  - Unset Billing State Field

  from the checkout fields

= 1.0.4 =

- Fix popup chat close button css
- Add simple hover effect for Floating WhatsApp Chat Widget Image
- Remove `return` for current_user_can( 'manage_options' ) for all WhatsApp related functions, so now all user (including super-admins) can see the WhatsApp related feature

= 1.0.3 =

- Fix Hide Add to Cart on Shop Loop button not working

= 1.0.2 =

- Cleanup some unused php codes

= 1.0.1 =

- Fix readme file
- Change plugin's banner

= 1.0.0 =

- Initial release