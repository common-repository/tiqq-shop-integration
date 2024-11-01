<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
 * Plugin Name: tiqq shop integration
 * Description: Easily integrate your tiqq shop on your own website.
 * Version: 1.3
 * Author: tiqq
 * Contributors: jurrevanderschaaf
 * Tags: tiqq, tickets, ticket shop
 * Requires at least: 3.0
 * Tested up to: 6.4
 * Stable tag: 1.3
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Plugin URI: https://tiqq.io/wordpress-plugin
 */

/**
 * Shortcode functions
 */
function tiqq_plugin_shop_shortcode( $atts ) {
    $iframe_url_query = [];
    if(get_query_var('tiqq-return', false) == "true") {
        $iframe_url = 'https://kiwi.tiqq.io/shop/' . str_replace('/', '', $atts['shop']) . '/return';

        $iframe_url_query['order'] = get_query_var('tiqq-order');
        $iframe_url_query['expires'] = get_query_var('tiqq-expires');
        $iframe_url_query['signature'] = get_query_var('tiqq-signature');
    } else {
        global $wp;
        $current_url = home_url( add_query_arg( array(), $wp->request ) );

        $iframe_url = 'https://kiwi.tiqq.io/shop/' . str_replace('/', '', $atts['shop']);
        $iframe_url_query['return_url'] = urlencode($current_url);
        $iframe_url_query['lang'] = substr(get_locale(), 0, 2);
    }

    if(isset($atts['accent-color'])) $iframe_url_query['accent-color'] = $atts['accent-color'];
    if(isset($atts['accent-prime-color'])) $iframe_url_query['accent-prime-color'] = $atts['accent-prime-color'];

    $iframe_url .= '?'.http_build_query($iframe_url_query);
    return tiqq_build_iframe($iframe_url, "tiqq-shop-frame", $atts['style'], true);
}

function tiqq_plugin_cart_shortcode( $atts ) {
    wp_enqueue_script('tiqq-js-external-cart');

    $iframe_url_query = [];
    if(get_query_var('tiqq-return', false) == "true") {
        $iframe_url = 'https://kiwi.tiqq.io/external-cart/' . str_replace('/', '', $atts['shop']) . '/return';

        $iframe_url_query['order'] = get_query_var('tiqq-order');
        $iframe_url_query['expires'] = get_query_var('tiqq-expires');
        $iframe_url_query['signature'] = get_query_var('tiqq-signature');
    } else {
        global $wp;
        $current_url = home_url( add_query_arg( array(), $wp->request ) );

        $iframe_url = 'https://kiwi.tiqq.io/external-cart/' . str_replace('/', '', $atts['shop']);
        $iframe_url_query['return_url'] = urlencode($current_url);
        $iframe_url_query['lang'] = substr(get_locale(), 0, 2);
    }

    if(isset($atts['accent-color'])) $iframe_url_query['accent-color'] = $atts['accent-color'];
    if(isset($atts['accent-prime-color'])) $iframe_url_query['accent-prime-color'] = $atts['accent-prime-color'];

    $iframe_url .= '?'.http_build_query($iframe_url_query);
    return tiqq_build_iframe($iframe_url, "tiqq-cart-frame", $atts['style'], true);
}

function tiqq_plugin_add_to_cart_shortcode( $atts ) {
    wp_enqueue_script('tiqq-js-external-cart');

    $iframe_url_query = [];
    $iframe_url_query['lang'] = substr(get_locale(), 0, 2);
    if(isset($atts['accent-color'])) $iframe_url_query['accent-color'] = $atts['accent-color'];
    if(isset($atts['accent-prime-color'])) $iframe_url_query['accent-prime-color'] = $atts['accent-prime-color'];

    $iframe_url = 'https://kiwi.tiqq.io/add-to-cart/' . str_replace('/', '', $atts['shop']) . '/' . $atts['product'];
    $iframe_url .= '?'.http_build_query($iframe_url_query);
    
    return tiqq_build_iframe($iframe_url, "tiqq-add-to-cart-frame-".rand(1000,9999), $atts['style'], false, "48px");
}


/**
 * General functions
 */
function tiqq_build_iframe($iframe_url, $frame_id, $style = null, $include_height_change = false, $height = "500px") {
    if($include_height_change) {
        wp_enqueue_script('tiqq-js-iframe-height');
        wp_localize_script('tiqq-js-iframe-height', 'vars', ['frame_id' => $frame_id] );
        wp_add_inline_script(
            'tiqq-js-iframe-height',
            'window.addEventListener("message",e=>{"heightChange"==e.data.type&&(document.getElementById(vars.frame_id).style.height=e.data.content+"px",document.getElementById(vars.frame_id).scrolling="no")},!1);'
        );
    }
    
    $html  = '<iframe id="'.$frame_id.'" ';
    $html .= 'class="tiqq-frame" ';
    $html .= 'src="' . $iframe_url . '" ';
    $html .= 'width="100%" ';               // default value, can be overwritten using style
    $html .= 'height="'.$height.'" ';       // default value, can be overwritten using style
    $html .= 'frameBorder="0" ';            // default value, can be overwritten using style
    $html .= 'scrolling="no" ';             // default value, can be overwritten using style
    if(isset($style)) {
        $html .= 'style="' . $style . '" ';
    }
	$html .= '></iframe>'."\n";

	return $html;
}


/**
 * Scripts
 */
wp_register_script('tiqq-js-iframe-height', '');
wp_register_script('tiqq-js-external-cart', plugins_url('js/tiqq_external_cart.js', __FILE__ ));


/**
 * Shortcodes
 */
add_shortcode( 'tiqq', 'tiqq_plugin_shop_shortcode' );
add_shortcode( 'tiqq_add_to_cart', 'tiqq_plugin_add_to_cart_shortcode' );
add_shortcode( 'tiqq_cart', 'tiqq_plugin_cart_shortcode' );


/**
 * Register URL query parameters
 */
function tiqq_query_vars( $qvars ) {
	$qvars[] = 'tiqq-return';
	$qvars[] = 'tiqq-order';
	$qvars[] = 'tiqq-expires';
	$qvars[] = 'tiqq-signature';
	return $qvars;
}
add_filter( 'query_vars', 'tiqq_query_vars' );