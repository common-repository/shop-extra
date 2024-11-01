<div class="shop_extra-body-header">
    <h2><?php _e('Add Custom Options (Radio Button) to Checkout', 'shop-extra') ?></h2>
</div>

<div class="shop_extra-input-group hide-show-group mt-13 pl-2">
	
	<input class="shop_extra-toggle shop_extra-toggle-light hide-show" data-hide-show="1" id="shop_extra_optionradio_enable" name="shop_extra_optionradio_enable" value="1" type="checkbox"
	<?php checked(ShopExtra\shop_extra_field_setting( 'shop_extra_optionradio_enable'), 1, true) ?>/>
	<label class="shop_extra-toggle-btn" for="shop_extra_optionradio_enable"></label>
	<label class="toggle-label pl-4" for="shop_extra_optionradio_enable">
	    <?php _e('Enable', 'shop-extra') ?>
	</label>

	<div class="hide-show-content padding-left-0 mb-15">
    
        <div class="grid mt-7 col-2">
	        
	        <!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        			<input class="w-100i style-input" placeholder="<?php _e( 'Label' ); ?>" type="text" id="shop_extra_option_radio_label" name="shop_extra_option_radio_label" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_option_radio_label')) ?>">
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('Appear before the radio button(s)<em>*required</em>', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
        	
        	<!-- start  -->
        	<div class="shop_extra-input-group w-100">
        	    
        		<div class="shop_extra-input">
        			<input class="w-100i style-input" placeholder="<?php _e( 'Description' ); ?>" type="text" id="shop_extra_option_radio_desc" name="shop_extra_option_radio_desc" value="<?php echo esc_html(ShopExtra\shop_extra_field_setting('shop_extra_option_radio_desc')) ?>">
        		</div>
        		<div class="shop_extra-help normal pl-2 pt-4 pb-8">
        		    <?php _e('Appear after the radio button(s)', 'shop-extra') ?>
        		</div>
        	</div>
        	<!-- end -->
	
        </div>
            
            <style>
            #option_radio_data_panel .radio-button-field input {
                position: relative;
                background-color: #f4f7f8;
                border-color: #dfe5ea;
                padding: 2.5px 12px;
                border-radius: 4px;
                margin-bottom: 4px;
                margin-left: 0;
                z-index: 9;
                width: 52%;
            }
            #option_radio_data_panel .wp-editor-wrap {
                margin-top: -30px;
            }
            #option_radio_data_panel div.mce-toolbar-grp {
            	border: 0;
            }
            #option_radio_data_panel .wp-editor-container {
                border: 1px solid #e4e4e4;
                border-radius: 4px;
                border-top-right-radius: 0;
                overflow: hidden;
                box-shadow: none;
            }
            
            #option_radio_data_panel .wp-switch-editor {
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
                font-size: clamp(11.5px, (100vw - 100vmin), 12px);
            }
            #option_radio_data_panel div.mce-panel {
                box-shadow: none;
            }
            #radio-buttons-fields {
                padding: 6px 1px;
                margin-bottom: 10px
            }
            #radio-buttons-fields .move-button,
            #radio-buttons-fields button.remove-radio-button {
                margin-top: 8px
            }
            #radio-buttons-fields .radio-button-field:not(:last-child) {
                margin-bottom: 16px
            }
            #radio-buttons-fields iframe {
                min-height: 140px;
                max-height: 175px;
            }
            
            #radio-buttons-fields textarea.radio-button-textarea {
                width:100%
            }
            #radio-buttons-fields .wp-editor-container textarea.radio-button-textarea {
                background-color: #fff;
                border: 0;
            }
            #option_radio_data_panel .mce-statusbar.mce-last,
            #radio-buttons-fields .radio-button-field:last-child .move-down-radio-button,
            #radio-buttons-fields .radio-button-field:first-child .move-up-radio-button {
                display: none!important;
            }
            .radio-button-field div.mce-toolbar-grp {
            	background: #fefefe;
            }
            
            .radio-button-field .mce-top-part::before {
            	box-shadow: 0 0.5px 1.5px rgb(0 0 0 / 16%);
            }
            .shop-extra-radio-button button.shop-extra-button {
                border: 0;
                font-size: 11.85px;
                padding: 5px 11px;
                border-radius: 4px;
                border-color: #ddd;
                box-shadow: 0 0 2px rgb(0 0 0 / 20%);
                transition: .2125s ease-in;
            }
            button.shop-extra-button.add-new-option {
                background: #fefefe;
                background: linear-gradient(180deg, #fdfdfd, transparent);
            }
            button.shop-extra-button.move-button {
                background: #52616c;
                color: #fff;
            }
            button.shop-extra-button.remove-radio-button {
                
            }
            #woocommerce-product-data ul.wc-tabs li.option_radio_data_options a {
                display: flex;
                align-items: center;
            }
            #woocommerce-product-data ul.wc-tabs li.option_radio_data_options a::before {
            	content: "\f502";
            }
            .mce-panel.mce-menu {
                transform: scale(.9)!important;
            }
            .mce-menu.mce-in.mce-animate {
                transform: scale(.8) rotateY(0) rotateX(0)!important;
                border: 0;
            }
            .quicktags-toolbar {
                display: flex;
            }
            #option_radio_data_panel .mce-toolbar .mce-btn-group>div {
                display: flex;
                align-items: center;
            }
            #option_radio_data_panel .mce-toolbar .mce-listbox button {
                font-size: 12.65px;
                max-width: 105px;
            }
            #option_radio_data_panel .mce-toolbar .mce-ico {
                font-size: 15px;
                width: 1em;
                height: 1em;
            }
            
        </style>
            
             <div id="option_radio_data_panel" class="panel shop-extra-radio-button">
                <div class="options_group">
                    <p class="toolbar">
                        <button class="button shop-extra-button add-new-option" id="add-radio-button-btn"><?php _e('Add New Options', 'woocommerce'); ?></button>
                    </p>
                    <div id="radio-buttons-fields" class=" grid col-2">
                        <?php
                        
                        wp_enqueue_editor();
                        
                        $option_radios = get_option('shop_extra_options')['shop_extra_optionradio_content'];
                        
                        if ($option_radios && is_array($option_radios)) {
                            
                            foreach ($option_radios as $index => $option_radio) {
                                
                                $title   = isset($option_radio['title']) ? esc_attr($option_radio['title']) : '';
                                $content = isset($option_radio['content']) ? wp_kses_post($option_radio['content']) : '';
                                $remove_flag = isset($option_radio['remove']) && $option_radio['remove'] === 1 ? true : false;

                                if ($remove_flag) {
                                    continue; // Skip rendering the removed option
                                }
                                ?>
                                <div class="radio-button-field">
                                    <input type="text" name="option_radios[<?php echo $index; ?>][title]" value="<?php echo esc_attr($title); ?>" placeholder="<?php _e('Option Title', 'woocommerce'); ?>" />
                                    <textarea class="radio-button-textarea" name="option_radios[<?php echo $index; ?>][content]" rows="6" id="radio-button-<?php echo $index; ?>"><?php echo $content; ?></textarea>
                                    <input type="hidden" name="option_radios[<?php echo $index; ?>][remove]" class="remove-radio-button" value="0" />
                                    <?php if (count($option_radios) > 1) : ?>
                                    <button class="button move-button move-up-radio-button shop-extra-button"><?php _e('Move Up', 'woocommerce'); ?></button>
                                    <button class="button move-button move-down-radio-button shop-extra-button"><?php _e('Move Down', 'woocommerce'); ?></button>
                                    <?php endif; ?>
                                    <button class="button remove-radio-button shop-extra-button"><?php _e('Remove Option', 'woocommerce'); ?></button>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <script>
                jQuery(document).ready(function($) {
                $('#add-radio-button-btn').on('click', function(e) {
                    e.preventDefault();
                    var index = $('#radio-buttons-fields .radio-button-field').length;
                    var newOptionField = `
                        <div class="radio-button-field">
                            <input type="text" name="option_radios[${index}][title]" value="" />
                            <textarea class="radio-button-textarea" name="option_radios[${index}][content]" rows="6" id="radio-button-${index}"></textarea>
                            <input type="hidden" name="option_radios[${index}][remove]" class="remove-radio-button" value="0" />
                            <button class="button remove-radio-button shop-extra-button">Remove Option</button>
                            <button class="button move-up-radio-button shop-extra-button">Move Up</button>
                            <button class="button move-down-radio-button shop-extra-button">Move Down</button>
                        </div>`;
                    $('#radio-buttons-fields').append(newOptionField);
            
                    // Reinitialize the WordPress editor for the newly added textarea
                    initializeCustomEditor('radio-button-' + index);
                });
            
                // Clear option values when remove option button clicked
                $(document).on('click', '.remove-radio-button', function(e) {
                    e.preventDefault();
                    var $optionField = $(this).parent();
                    $optionField.find('.remove-radio-button').val('1');
                    $optionField.hide();
                });
            
                // Initialize the WordPress editors for existing options on page load
                $('.radio-button-field textarea').each(function() {
                    var editorId = $(this).attr('id');
                    initializeCustomEditor(editorId, $(this).val());
                });
            
                // Function to move options up
                function moveOptionRadioUp($optionField) {
                    var currentIndex = $optionField.index();
                    if (currentIndex > 0) {
                        $optionField.insertBefore($optionField.prev());
                        reattachEditors();
                    }
                }
            
                // Function to move options down
                function moveOptionRadioDown($optionField) {
                    var currentIndex = $optionField.index();
                    var totalOptions = $('#radio-buttons-fields .radio-button-field').length;
                    if (currentIndex < totalOptions - 1) {
                        $optionField.insertAfter($optionField.next());
                        reattachEditors();
                    }
                }
            
                // Move options up button click event
                $(document).on('click', '.move-up-radio-button', function(e) {
                    e.preventDefault();
                    var $optionField = $(this).parent();
                    moveOptionRadioUp($optionField);
                });
            
                // Move options down button click event
                $(document).on('click', '.move-down-radio-button', function(e) {
                    e.preventDefault();
                    var $optionField = $(this).parent();
                    moveOptionRadioDown($optionField);
                });
            
                function reattachEditors() {
                    // Detach all existing editors
                    $('.radio-button-field textarea').each(function() {
                        var editorId = $(this).attr('id');
                        wp.editor.remove(editorId);
                    });
            
                    // Reattach editors for all textareas
                    $('.radio-button-field textarea').each(function() {
                        var editorId = $(this).attr('id');
                        initializeCustomEditor(editorId, $(this).val());
                    });
                }
            });
            
            function initializeCustomEditor(editorId, content) {
    var customStyles = `
        body.mce-content-body {
            font-size: 12.85px;
            font-family: 'Verdana', sans-serif;
            margin: 10.5px 10px;
            line-height: 1.35;
        }
        body.mce-content-body p {
            margin-block-start: 0.55em;
            margin-block-end: 0.55em;
        }
        body.mce-content-body ul,
        body.mce-content-body ol {
            padding-inline-start: 1.5em;
        }
        body.mce-content-body ul ::marker {
            font-size: 90%
        }
        body.mce-content-body ol ::marker {
            font-size: 82.5%
        }
    `;

    var settings = {
        tinymce: {
            wpautop: false,
            relative_urls: false,
            convert_urls: false,
            entities: "38,amp,60,lt,62,gt",
            entity_encoding: "raw",
            resize: false,
            content_style: customStyles,
            plugins: 'charmap,colorpicker,hr,lists,media,paste,tabfocus,textcolor,wordpress,wpautoresize,wpeditimage,wpgallery,wplink,wpdialogs,wptextpattern,wpview,link',
            toolbar1: 'formatselect,undo,redo,alignleft,aligncenter,alignright,link,unlink,wp_add_media,wp_adv',
            toolbar2: 'bold,underline,italic,bullist,numlist,blockquote,strikethrough,hr,forecolor,pastetext,removeformat,wp_more,charmap,outdent,indent,wp_help',
        },
        quicktags: true,
        mediaButtons: false,
        textarea_name: editorId, // Set the editor ID
    };

    if (content) {
        settings.tinymce.setup = function(editor) {
            editor.on('init', function() {
                editor.setContent(content);
            });
        };
    }

    wp.editor.initialize(editorId, settings);
}

            </script>

        
    </div><!-- end of hide-show container -->
    
</div>