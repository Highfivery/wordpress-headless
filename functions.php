<?php
/**
 * Headless functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Headless
 * @since Headless 1.0.0
 */

 add_action( 'init', function() {
  register_nav_menus(
    array(
      'primary-menu' => __( 'Primary Menu' ),
     )
   );
} );
