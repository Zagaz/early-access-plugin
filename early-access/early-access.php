<?php 
/**
 * Plugin Name: Early Access
 * Description: A custom WP CLI command to untag early access products.
 * Version: 1.0.0
 * Author: Andre Ranulfo
 * Author URI: https://www.linkedin.com/in/andre-ranulfo/
 * Plugin URI: https://github.com/Zagaz/early-access-plugin
 * Text Domain: early-access
 * Domain Path: /lang
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 7.0
 */
     if ( ! defined( 'ABSPATH' ) ) {
          die; 
      }

     if ( ! defined( 'WPINC' ) ) {
          die; 
      }

      /* 

      Task
Please create a custom WP CLI job the does the following things

For all the product content that has custom taxonomy product_cat term early-access remove the early-access term if the post meta public_access_date has past.

Templates
Below is the skeleton class template for the custom cli. Add your function in this class.
This is the template:

class Product_CLI extends \WP_CLI_Command {

	//*
	// Untag all early access classes when public access date is past.
	//
	// Your comments go here.
	///
	// Your function goes here.
}

WP_CLI::add_command( 'product', 'Product_CLI' );

      */

      class Product_CLI extends \WP_CLI_Command {

          /**
           * Untag all early access classes when public access date is past.
           */
          public function untag_early_access() {
              
                 $args = array(
                      'post_type' => 'product',
                      'tax_query' => array(
                           array(
                           'taxonomy' => 'product_cat',
                           'field' => 'slug',
                           'terms' => 'early-access'
                           )
                      ),
                      'meta_query' => array(
                           array(
                           'key' => 'public_access_date',
                           'value' => date('Y-m-d'),
                           'compare' => '<'
                           )
                      )
                 );
     
                 $products = new WP_Query( $args );
     
                 if ( $products->have_posts() ) {
                      while ( $products->have_posts() ) {
                           $products->the_post();
                           $product_id = get_the_ID();
                           wp_remove_object_terms( $product_id, 'early-access', 'product_cat' );
                      }
                 }
     
                 wp_reset_postdata();
          }
      }

          WP_CLI::add_command( 'product', 'Product_CLI' );


      
