<?php
/*
Plugin Name: Variations Select Menu For Woocommerce
Description: Adds menu and Add To Cart instead "Select options" text. In menu which appears bellow product image on any page, user can choose woocommerce product variations and add them to cart.
Version: 1.1
Author: Drazen Duvnjak
Author URI: https://eranova.hr

*/

/** Add Style **/
add_action('wp_enqueue_scripts','register_vsmw_scripts');

function register_vsmw_scripts(){
wp_enqueue_style( 'style1', plugins_url( 'css/style.css' , __FILE__ ) );

}

/**
 * Replace add to cart button in the loop.
 */
function variations_change_loop_add_to_cart() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    add_action( 'woocommerce_after_shop_loop_item', 'variations_template_loop_add_to_cart', 10 );
}
 
add_action( 'init', 'variations_change_loop_add_to_cart', 10 );
 
/**
 * Use single add to cart button for variable products.
 */
function variations_template_loop_add_to_cart() {
    global $product;
 
    if ( ! $product->is_type( 'variable' ) ) {
        woocommerce_template_loop_add_to_cart();
        return;
    }
 
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
    add_action( 'woocommerce_single_variation', 'variations_loop_variation_add_to_cart_buttont', 20 );
 
    woocommerce_template_single_add_to_cart();
}
 
/**
 * Customise variable add to cart button for loop.
 *
 * Remove qty selector and simplify.
 */
function variations_loop_variation_add_to_cart_buttont() {
    global $product;
 
    ?>
    <div class="woocommerce-variation-add-to-cart variations_button">
        <button type="submit" class="single_add_to_cart_button button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="0" />
    </div>
    <?php
}
