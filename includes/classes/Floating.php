<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

class SHOPEXTRA_Floating {

    public function __construct()
    {
		// @ https://wordpress.stackexchange.com/questions/12863/check-if-wp-login-is-current-page
    	if ( !function_exists('is_wp_login_page')) { 
    	        function is_wp_login_page(){
        		$ABSPATH_MY = str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ABSPATH);
        		return ((in_array($ABSPATH_MY.'wp-login.php', get_included_files()) || in_array($ABSPATH_MY.'wp-register.php', get_included_files()) ) || (isset($_GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'wp-login.php') || $_SERVER['PHP_SELF']== '/wp-login.php');
    	    }
    	}
    	
    	if ( is_wp_login_page() ) {
            return;
        }
    	
		add_action( 'init', array($this, 'floating_html'), 99);
		add_action('wp_enqueue_scripts', array($this, 'floating_styles'), 999);
		add_action('wp_print_footer_scripts', array($this, 'floating_scripts'), 999);
		
    }

	public function floating_html()
    {

        if ( !get_option('shop_extra_options')['shop_extra_floating_enable'] || empty(get_option('shop_extra_options')['shop_extra_floating_names']) || empty(get_option('shop_extra_options')['shop_extra_floating_numbers']) ) {
            return;
        }
        
		require_once(SHOPEXTRA_FUNCTIONS_DIR . 'floating.php');
		
    }
    
    public function floating_styles()
    {

        if ( !get_option('shop_extra_options')['shop_extra_floating_enable'] || empty(get_option('shop_extra_options')['shop_extra_floating_names']) || empty(get_option('shop_extra_options')['shop_extra_floating_numbers']) ) {
            return;
        }
        
		wp_register_style( SHOPEXTRA_HANDLER.'-floating', SHOPEXTRA_PUBLIC_URL . 'css/floating.css', [], SHOPEXTRA_VERSION);
		wp_enqueue_style( SHOPEXTRA_HANDLER.'-floating' );
		
		// button position
		if ( get_option('shop_extra_options')['shop_extra_floating_left']) {
			$button_position = 'left';
			$rotate_tooltip = '270deg';
			$rotate_popup_after = '349deg';
		} else {
			$button_position = 'right';
			$rotate_tooltip = '90deg';
			$rotate_popup_after = '11deg';
		}
		
		$inline_style = '.shop-extra-floating-button{display:flex;position:fixed;bottom:calc(11px + (19 - 11) * ((100vw - 300px) / (1680 - 300)));' . esc_attr( $button_position ) . ':calc(6px + (19 - 6) * ((100vw - 300px) / (1680 - 300)));border-radius:50%;box-shadow:0 8px 25px -5px rgb(45 62 79 / 30%);z-index:99999;text-decoration:none}.shop-extra-floating-button-img{width:calc(62px + (63.5 - 62) * ((100vw - 300px) / (1680 - 300)));height:calc(62px + (63.5 - 62) * ((100vw - 300px) / (1680 - 300)));padding:calc(11.25px + (11.5 - 11.25) * ((100vw - 300px) / (1680 - 300)));z-index:-1;position:relative}.shop-extra-floating-popup-container{opacity:0}';
		
		/* tooltip inline style */
		if (!empty(get_option('shop_extra_options')['shop_extra_floating_tooltip'])) {
			$inline_style .= '.shop-extra-floating-tooltip-container{position:fixed; bottom: calc(25px + (29 - 25) * ((100vw - 300px) / (1680 - 300)));display: table;transition: opacity .15s linear;opacity: 1;z-index: -1}';
			$inline_style .= '.shop-extra-floating-tooltip-container{' . esc_attr( $button_position ) . ': calc(72px + (88 - 72) * ((100vw - 300px) / (1680 - 300)));}';
			$inline_style .= '.shop-extra-floating-tooltip:before{' . esc_attr( $button_position ) . ': calc(-9px + (-11 + 9) * ((100vw - 300px) / (1680 - 300)));transform: rotate(' . esc_attr( $rotate_tooltip ) . ') scale(1.25)}';
			$inline_style .= '.shop-extra-floating-tooltip{display:none}';
		}

		$inline_style .= '.shop-extra-floating-popup-container{' . esc_attr( $button_position ) . ': 22px}';
		
		$inline_style .= '.shop-extra-floating-popup-container:after{' . esc_attr( $button_position ) . ': calc(35px + (43 - 35) * ((100vw - 300px)/ (1920 - 300)));transform: scaleY(-1) scale(2) rotate(' . esc_attr( $rotate_popup_after ) . ')}';
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_button_bg_color']) ) {
		    $floating_button_bg_color = get_option('shop_extra_options')['shop_extra_floating_button_bg_color'];
			$inline_style .= '#shop-extra-floating-button{background-color:' . esc_attr( $floating_button_bg_color ) . '}';
		}
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_heading_bg_color']) ) {
		    $floating_heading_bg_color = get_option('shop_extra_options')['shop_extra_floating_heading_bg_color'];
			$inline_style .= '.shop-extra-floating-popup-heading-container{background-color:' . esc_attr( $floating_heading_bg_color ) . '}';
		}
		
		$inline_style .= 'img.shop-extra-floating-button-img:not([src]){color:transparent}';
		
		$names = get_option('shop_extra_options')['shop_extra_floating_names'];
		$names = preg_split('/[\n\r]+/', $names);
		
		/* count the number to add extra styling */
		$a = 1;
		$b = count($names);
		
		/* add more padding if the account is only one */
		if ( $b == $a ) {
			$inline_style .= '.shop-extra-floating-account-container-padding{padding:.8em 0}';
		}
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_names_bg_color']) ) {
		    $floating_account_label_bg_color = get_option('shop_extra_options')['shop_extra_floating_names_bg_color'];
			$inline_style .= '.shop-extra-floating-account-number{background-color:' . esc_attr( $floating_account_label_bg_color ) . '}';
		}
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_names_text_color']) ) {
		    $floating_account_label_text_color = get_option('shop_extra_options')['shop_extra_floating_names_text_color'];
			$inline_style .= '.shop-extra-floating-number-account-label{color:' . esc_attr( $floating_account_label_text_color ) . '}';
		}
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_button_width']) ) {
			$floating_button_width = get_option('shop_extra_options')['shop_extra_floating_button_width'];
			$inline_style .= '.shop-extra-floating-button img{width:' . esc_attr( $floating_button_width ) . ';height:' . esc_attr( $floating_button_width ) . '}';
		}
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_button_padding']) ) {
			$floating_button_padding = get_option('shop_extra_options')['shop_extra_floating_button_padding'];
			$inline_style .= '.shop-extra-floating-button img{padding:' . esc_attr( $floating_button_padding ) . '}';
		}
		
		/* add extra style if the heading title is empty */
		if ( empty(get_option('shop_extra_options')['shop_extra_floating_heading_title']) ) {
			$inline_style .= '.shop-extra-floating-account-container-padding{padding:1.525em 0 1.075em}';
			$inline_style .= '.shop-extra-popup-close{filter:invert(.7)}';
		}
		
		// minify the inline style before inject
		$inline_style = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',],$inline_style);
		
		/* inject above styles */
		wp_add_inline_style( SHOPEXTRA_HANDLER.'-floating', esc_attr($inline_style) );
        
    }
    
    public function floating_scripts()
    {
		
		if ( !get_option('shop_extra_options')['shop_extra_floating_enable'] || empty(get_option('shop_extra_options')['shop_extra_floating_names']) || empty(get_option('shop_extra_options')['shop_extra_floating_numbers']) ) {
            return;
        }
		
		$tooltip_active_script = '';
		$tooltip_not_active_script = '';
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_tooltip']) ) {
			$tooltip_active_script = 'tooltip.classList.add("active");';
			$tooltip_not_active_script = 'tooltip.classList.remove("active");';
		}
        
        $inline_script = '"use strict";
        let button = document.getElementById("shop-extra-floating-button"), 
    	modal = document.getElementById("shop-extra-floating-wrapper"),
    	close = document.getElementsByClassName("shop-extra-popup-close")[0],
		popup = document.getElementsByClassName("shop-extra-floating-popup-container")[0],
		tooltip = document.getElementsByClassName("shop-extra-floating-tooltip-container")[0],
		html = document.getElementsByTagName("html")[0],
		img = document.getElementsByClassName("shop-extra-floating-button-img")[0],
    	action = 1;
    	button.onclick = function() {
			if ( action == 1 ) {
				html.classList.add("overflow-hidden");
				button.classList.add("active");
				modal.classList.add("active");
				' . wp_kses_data($tooltip_active_script) . '
				popup.classList.add("active");
				img.classList.add("active");
				action = 2;
			} else {
				html.classList.remove("overflow-hidden");
				button.classList.remove("active");
				modal.classList.remove("active");
				' . wp_kses_data($tooltip_not_active_script) . '
				popup.classList.remove("active");
				img.classList.remove("active");
				action = 1;
			}
		};
    	window.onclick = function(event) {
    	  if (event.target == close || event.target == modal ) {
			html.classList.remove("overflow-hidden");
			button.classList.remove("active");
    	  	modal.classList.remove("active");
			' . wp_kses_data($tooltip_not_active_script) . '
			popup.classList.remove("active");
			img.classList.remove("active");
			action = 1;
    	  	};
    	};';
    	
    	// minify the inline script before inject
		$inline_script = preg_replace(['/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/','/\>[^\S ]+/s','/[^\S ]+\</s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si'],['','>','<','$1$2$3$4$5$6$7'], $inline_script);
		
        $inline_script_handle = SHOPEXTRA_HANDLER.'-floating-popup-js';
    
        $shop_extra_inline_script =
            '<script id="%s">%s</script>' . PHP_EOL;
            
        printf(
            $shop_extra_inline_script,
            esc_html($inline_script_handle),
            wp_kses_data($inline_script)
        );
		
		/* start availability */
		
		$availability = get_option('shop_extra_options')['shop_extra_floating_availability'];
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_availability_available_text']) ) {
			$available_text = get_option('shop_extra_options')['shop_extra_floating_availability_available_text'];
		} else {
			$available_text = 'We are available!';
		}
		
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_availability_notavailable_text']) ) {
			$notavailable_text = get_option('shop_extra_options')['shop_extra_floating_availability_notavailable_text'];
		} else {
			$notavailable_text = 'Really sorry, we are not available at the moment.';
		}

		$floating_availability_inline_script = '"use strict";
    	const numlink = document.querySelectorAll(".shop-extra-floating-account-number"),
		availtext = document.getElementsByClassName("shop-extra-floating-availability")[0],
		avail = "' . esc_attr($availability) . '",
		splitAvail = avail.split(",");
		let zone = splitAvail[0].toString();
		const time = new Date(),
		day = (time.getUTCDay() + 6) % 7,
		hours = time.getUTCHours()+parseInt(zone);
		if( day >= splitAvail[1] || ( hours < splitAvail[2] || hours >= splitAvail[3] ) ) {	
			for (let i = 0; i < numlink.length; i++) {
				numlink[i].setAttribute("href", "javascript:void(0)");
				numlink[i].style.cssText += "pointer-events:none;opacity:.678";
				availtext.classList.add("not-available");
				availtext.textContent = "' . wp_kses_data($notavailable_text) . '";
			}
		} else {
			for (let i = 0; i < numlink.length; i++) {
				availtext.classList.add("available");
				availtext.textContent = "' . wp_kses_data($available_text) . '";
			}
		}
    	';
		
		// minify the inline script
		$floating_availability_inline_script = preg_replace(['/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/','/\>[^\S ]+/s','/[^\S ]+\</s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si'],['','>','<','$1$2$3$4$5$6$7'], $floating_availability_inline_script);
    
        $floating_availability_inline_script_handle = SHOPEXTRA_HANDLER.'-floating-popup-availability-js';
    
        $shop_extra_availability_inline_script =
            '<script id="%s">%s</script>' . PHP_EOL;
        
		if ( !empty(get_option('shop_extra_options')['shop_extra_floating_availability']) ) {
			printf(
				$shop_extra_availability_inline_script,
				esc_html($floating_availability_inline_script_handle),
				htmlspecialchars_decode(esc_js($floating_availability_inline_script))
			);
		}

        
    }
    
	
}