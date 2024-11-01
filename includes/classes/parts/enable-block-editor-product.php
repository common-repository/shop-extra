<?php

namespace ShopExtra;

/**
 * Forked & Modified from Mário Valney codes in https://github.com/Vizir/blocks-for-products v1.1.1
 * 
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

class ShopExtra_Blocks_For_Products {
    
    const PRODUCT_POST_TYPE = 'product';
    const META_KEY_CLASSIC_EDITOR = '_shop_extra_edit_with_classic_editor';

    private static $_instance;
    
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    private $options = [];

    public function __construct() {
            
        $this->options = get_option('shop_extra_options', []);
        
        if ( $this->options['shop_extra_block_editor_enable'] ) {
            /**/
            add_filter( 'use_block_editor_for_post_type', array( $this, 'use_block_editor_for_post_type' ), 99, 2 );

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ), PHP_INT_MAX );
    
            add_action( 'load-post.php', array( $this, 'edit_page_init' ) );
            add_action( 'load-post-new.php', array( $this, 'edit_page_init' ) );
            add_action( 'edit_form_after_title', array( $this, 'edit_form_after_title' ), 20 );
            add_action( 'edit_form_after_title', array( $this, 'edit_form_after_editor' ) );
    
            // Edit
            add_filter( 'admin_body_class', array( $this, 'add_disable_block_editor_class' ), 10, 2 );
            
            add_action( 'admin_print_footer_scripts', array( $this, 'add_switch_to_classic_link' ), 999 );
            
        }

    }
    
    /**
      * Filter: 'use_block_editor_for_post_type'
      * Activate Gutenberg for products post type.
      */
    public function use_block_editor_for_post_type( $can_edit, $post_type ) {
        if ( $post_type !== self::PRODUCT_POST_TYPE ) {
            return $can_edit;
        }

        if ( empty( $_GET['post'] ) ) {
            return false;
        }

        $post = get_post( sanitize_text_field( $_GET['post'] ) );

        return $this->is_using_blocks() && ! $this->edit_post_with_classic_editor( $post );
    }
    
    /**
     * Action: 'admin_enqueue_scripts'
     * Add style to product editor screen
     */
    public function admin_enqueue_scripts( $page ) {
        global $post;

        if ( ! in_array( $page, array( 'post.php', 'post-new.php' ), true ) ) {
            return;
        }

        if ( empty( $post ) || $post->post_type !== self::PRODUCT_POST_TYPE ) {
            return;
        }
        $style_handle = 'shop-extra-edit-content-style';
        
        wp_register_style( esc_html($style_handle), false );
		wp_enqueue_style( esc_html($style_handle) );
		
		$inline_style = '
    		.shop-extra-postbox {
            	margin-top: 20px;
            	margin-bottom: 0;
            }
            
            .shop-extra-postbox>h2 {
            	border-bottom: 1px solid #CCD0D4;
            }
            
            #poststuff .shop-extra-postbox .inside {
            	margin-top: 0 !important;
            	padding: 12px;
            	display: flex;
                align-items: center;
                gap: 12px;
            }
            
            .shop-extra-postbox .inside .button-link {
            	display: inline-flex;
            }
            
            .shop-extra-postbox .inside .button {
                padding: 2px 12px;
                box-shadow: none!important;
            }
            
            .shop-extra-postbox .inside>p:first-child {
            	margin-top: 0;
            }
            /*
            .shop-extra-after-editor {
            	display: block;
            	margin: 10px 0 0;
            	text-align: right;
            }
            */
            .shop-extra-after-editor.notice {
                border-left: 4px solid #2271b1;
            }
            
			#woocommerce-product-images,
            #wpcontent #woocommerce-product-data,
            #wpcontent #postexcerpt {
             	display:block;
            }
            
            #useClassicLink.use-classic {
                border: 1px solid #ececec;
                border-radius: 30px;
                padding: 0 14px;
                font-size: 12.5px;
            }
            
            #local-storage-notice.notice-warning,
            body:not(.disable-block-editor) #postdivrich.woocommerce-product-description,
            body.block-editor-page .edit-post-layout__metaboxes #postexcerpt,
            body.block-editor-page .edit-post-layout__metaboxes #woocommerce-product-data {
            	display: none !important;
            	overflow: hidden;
                clip: rect(0 0 0 0);
                width: 1px;
                height: 1px;
                margin: -1px;
                padding: 0;
                border: 0;
                position: absolute;
                top: -999vh;
                left: -999vw;
                content-visibility: hidden;
            }
		
		';
		
		// minify the inline style before inject
		$inline_style = preg_replace(['#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si','#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si','#(?<=[\s:,\-])0+\.(\d+)#s',],['$1','$1$2$3$4$5$6$7','$1','.$1',],$inline_style);
		
		wp_add_inline_style(
		    esc_html($style_handle),
			wp_strip_all_tags( $inline_style ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
		
		$script_handle = 'shop-extra-edit-content-script';
		
		$editor_switch_data = array(
            'nonce' => wp_create_nonce( 'shop-extra-editor-switch' ),
        );
        wp_localize_script( 'shop-extra-editor-switch', 'shopExtraEditorSwitch', $editor_switch_data );
        
        wp_register_script( esc_html($script_handle), false );
		wp_enqueue_script( esc_html($script_handle) );
		
		$inline_script = "
    		jQuery(document).ready(function($) {
                $('.use-classic, .use-blocks').on('click', function() {
                    if (window.localStorage) {
                        localStorage.clear();
                    }
                });
            });
		";
		
		// minify the inline script before inject
		$inline_script = preg_replace(['/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/','/\>[^\S ]+/s','/[^\S ]+\</s','#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si'],['','>','<','$1$2$3$4$5$6$7'], $inline_script);
				
		wp_add_inline_script(
		    esc_html($script_handle),
			( $inline_script )
		);
		
    }
    
    /**
     * Action: 'enqueue_block_editor_assets'
     * Add script if block editor enabled (to add back to classic option menu in gutenberg more option)
     */
    public function enqueue_block_editor_assets() {
        global $post;
    
        if ( empty( $post ) || $post->post_type !== self::PRODUCT_POST_TYPE || $this->edit_post_with_classic_editor( $post ) ) {
            return;
        }
        
        // Generate a random version value (random string)
        //$random_version = substr(md5(rand()), 0, 10);
    
        $block_editor_script = array(
            'dependencies' => array( 'wp-components', 'wp-edit-post', 'wp-element', 'wp-i18n', 'wp-plugins', 'wp-polyfill', 'wp-url', 'wp-plugins' ),
            'version' => '0a1a2b',
        );
    
        wp_enqueue_script( 'shop-extra-block-editor-script', SHOPEXTRA_ASSETS_URL . '/js/block-editor.min.js', $block_editor_script['dependencies'], $block_editor_script['version'], true );
        //wp_enqueue_script( 'shop-extra-block-editor-script', SHOPEXTRA_ASSETS_URL . '/js/block-editor.js', $block_editor_script['dependencies'], $block_editor_script['version'], true );
    }
    
    /**
     * Action: 'load-post.php'
     * configuration
     */
    public function edit_page_init() {
        if ( empty( $_GET['post'] ) || empty( $_GET['_wpnonce'] ) ) {
            return;
        }

        $post  = get_post( sanitize_text_field( $_GET['post'] ) );
        $nonce = sanitize_text_field( $_GET['_wpnonce'] );

        if ( empty( $post ) || $post->post_type !== self::PRODUCT_POST_TYPE ) {
            return;
        }

        if ( ! empty( $_GET['remove-blocks'] ) && wp_verify_nonce( $nonce, 'shop-extra-remove-blocks' ) ) {
            update_post_meta( $post->ID, self::META_KEY_CLASSIC_EDITOR, '1' );

            wp_redirect( remove_query_arg( array( 'remove-blocks', 'blocks', '_wpnonce' ), false ), 302 );
            exit;
        }

        if ( ! empty( $_GET['use-blocks'] ) && wp_verify_nonce( $nonce, 'shop-extra-use-blocks' ) ) {
            delete_post_meta( $post->ID, self::META_KEY_CLASSIC_EDITOR );

            wp_redirect( remove_query_arg( array( 'use-blocks', 'blocks', '_wpnonce' ), false ), 302 );
            exit;
        }
    }

    /**
     * Action: 'edit_form_after_title'
     * Render button to edit post with blocks and remove editor support
     */
    public function edit_form_after_title( $post ) {
        if ( $post->post_type !== self::PRODUCT_POST_TYPE || $this->edit_post_with_classic_editor( $post ) ) {
            return;
        }

        remove_post_type_support( self::PRODUCT_POST_TYPE, 'editor' );

        $screen = get_current_screen();
        if ( $screen->action === 'add' ) {
            ?>
            <div class="postbox shop-extra-postbox">
                <h2><?php esc_html_e( 'Description', 'woocommerce' ); ?></h2>
                <div class="inside">
                    <p><?php esc_html_e( 'You\'ve enable block editor for product option from Shop Extra. You need to save your product first to edit the content.', 'woocommerce' ); ?></p>
                </div>
            </div>
            <?php
            return;
        }
        ?>
        <div class="postbox shop-extra-postbox">
            <h2><?php esc_html_e( 'Description', 'woocommerce' ); ?></h2>
            <div class="inside">
                <a href="<?php echo esc_url( add_query_arg( 'blocks', '1' ) ); ?>" class="button button-primary button-large use-blocks" title="<?php esc_attr_e( 'Click here to edit the product description in block editor', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Edit with blocks', 'woocommerce' ); ?>
                </a>
                <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'remove-blocks', '1' ), 'shop-extra-remove-blocks' ) ); ?>" class="button-link" title="<?php esc_attr_e( 'Clicking this we will disable this feature to this post only.', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'Use Classic Editor for this product', 'woocommerce' ); ?>
                </a>
            </div>
        </div>
        <?php
    }
    
    /**
      * Action: 'edit_form_after_editor'
      * Return editor support
      */
    public function edit_form_after_editor( $post ) {
        if ( $post->post_type !== self::PRODUCT_POST_TYPE ) {
            return;
        }

        if ( $this->edit_post_with_classic_editor( $post ) ) {
            ?>
            <div class="shop-extra-after-editor notice is-dismissible notice-warning">
                <p>
                    <?php esc_html_e( 'You\'ve enable block editor for product option from Shop Extra, but you\'ve disabled blocks for this product. Do you want to ', 'woocommerce' ); ?>
                    <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'use-blocks', '1' ), 'shop-extra-use-blocks' ) ); ?>" class="button-link" title="<?php esc_attr_e( 'Clicking here we will enable blocks again.', 'woocommerce' ); ?>">
                        <?php esc_html_e( 'enable it back', 'woocommerce' ); ?>
                    </a>
                    <?php esc_html_e( '?', 'woocommerce' ); ?>
                </p>
            </div>
            <?php
            return;
        }

        add_post_type_support( self::PRODUCT_POST_TYPE, 'editor' );
    }

    private function is_using_blocks() {
        if ( empty( $_GET['blocks'] ) ) {
            return false;
        }

        return sanitize_text_field( $_GET['blocks'] ) === '1';
    }

    private function edit_post_with_classic_editor( $post ) {
        if ( empty( $post ) || empty( $post->ID ) ) {
            return false;
        }

        return get_post_meta( $post->ID, self::META_KEY_CLASSIC_EDITOR, true ) === '1';
    }
    
    /**
      * Action: 'admin_print_footer_scripts'
      * Add extra switch to classic option if block editor enabled
      */
    
    public function add_switch_to_classic_link() {
        
        global $post;
    
        if ( empty( $post ) || $post->post_type !== self::PRODUCT_POST_TYPE || $this->edit_post_with_classic_editor( $post ) ) {
            return;
        }
        
        ?>
<script>
    ( function( window, wp ) { var linkId = 'useClassicLink'; var linkText = '<?php echo esc_html__('Switch to Classic', 'woocommerce'); ?>'; var linkUrl = '<?php echo get_edit_post_link($post->ID); ?>'; var linkTitle = '<?php echo esc_attr__('Click here edit your product data and short description', 'woocommerce'); ?>'; var linkHtml = '<a id="' + linkId + '" class="components-button use-classic" href="' + linkUrl + '" title="' + linkTitle + '">' + linkText + '</a>'; var editorEl = document.getElementById( 'editor' ); if ( ! editorEl ) { return; } var unsubscribe = wp.data.subscribe( function() { setTimeout( function() { if ( ! document.getElementById( linkId ) ) { var toolbarEl = editorEl.querySelector( '.edit-post-header__center' ); if ( toolbarEl instanceof HTMLElement ) { toolbarEl.insertAdjacentHTML( 'beforebegin', linkHtml ); } } }, 1 ); } ); } )( window, wp );
</script>
        <?php
        
    }
    
    // Add body class 'disable-block-editor' when using the classic editor
    public function add_disable_block_editor_class( $classes ) {
        global $post;
        if ($this->edit_post_with_classic_editor( $post )) {
            $classes .= ' disable-block-editor';
        }
        return $classes;
    }

}

ShopExtra_Blocks_For_Products::getInstance();