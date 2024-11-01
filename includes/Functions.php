<?php

namespace ShopExtra;

defined('ABSPATH') or die('No script kiddies please!');

function shop_extra_field_setting($key = "", $default = false) {
        if (isset($_POST)) {
            if (isset($_POST['shop_extra'][$key])) {
                return $_POST['shop_extra'][$key];
            }
        }

        $value = SHOPEXTRA()->Settings()->get($key, $default);
        return $value;
}

function shop_extra_array_value($data = array(), $default = false) {
        return isset($data) ? $data : $default;
}

function shop_extra_sanitize_text_field($value) {
        if (!is_array($value)) {
            return wp_kses_post($value);
        }

        foreach ($value as $key => $array_value) {
            $value[$key] = shop_extra_sanitize_text_field($array_value);
        }
        return $value;
}

function shop_extra_esc_html_e($value) {
        return shop_extra_sanitize_text_field($value);
}

function shop_extra_removeslashes($value) {
        return stripslashes_deep($value);
}

function shop_extra_kses($value, $callback = 'wp_kses_post') {
        if (is_array($value)) {
            foreach ($value as $index => $item) {
                $value[$index] = shop_extra_kses($item, $callback);
            }
        } elseif (is_object($value)) {
            $object_vars = get_object_vars($value);
            foreach ($object_vars as $property_name => $property_value) {
                $value->$property_name = shop_extra_kses($property_value, $callback);
            }
        } else {
            $value = call_user_func($callback, $value);
        }

        return $value;
}


function shop_extra_fix_json($matches) {
    return "s:" . strlen($matches[2]) . ':"' . $matches[2] . '";';
}
