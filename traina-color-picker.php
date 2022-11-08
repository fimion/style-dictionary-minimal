<?php
/**
 * @package Traina Color Picker
 * @version 1.0.0
 */
/*
Plugin Name: Traina Color Picker
Plugin URI: https://github.com/fimion/traina-color-picker
Description: Swap out the colors for traina colors in the color picker
Author: Alex Riviere
Version: 1.0.0
Author URI: https://wearetraina.com
*/

// Set this once here, so we can cache this value for later.
$__DESIGN_TOKENS = null;

function tcp_return_design_tokens()
{
    global $__DESIGN_TOKENS;
    if (!is_null($__DESIGN_TOKENS)) {
        return $__DESIGN_TOKENS;
    }
    $plugin_dir = WP_PLUGIN_DIR . '/traina-color-picker';
    $__DESIGN_TOKENS = json_decode(file_get_contents($plugin_dir . '/build/tokens.json'), true);
    return $__DESIGN_TOKENS;
}


// gutenberg custom color palette
function tcp_change_gutenberg_color_palette()
{
    $design_tokens = tcp_return_design_tokens();

    // creates an array to store our color variables from css file
    $color_palette = [];

    foreach ($design_tokens['colors'] as $color_slug => $color_hex){
        $color_name = trim(ucwords(str_replace('-', ' ', $color_slug)));
            $color_palette[] = [
                'name' => $color_name,
                'slug' => $color_slug,
                'color' => $color_hex
            ];
        }

    if ($color_palette) {
        add_theme_support('editor-color-palette', $color_palette); 
    }
}

add_action('after_setup_theme', 'change_gutenberg_color_palette');