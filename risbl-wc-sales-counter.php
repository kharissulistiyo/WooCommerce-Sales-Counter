<?php
/**
 * @package Risbl_WC_Sales_Counter
 * @version 1.0
 */
/*
Plugin Name: WooCommerce Sales Counter
Plugin URI: http://risbl.co/wp/woocommerce-sales-counter-extension/
Description: Display WooCommerce product sales counter using a very simple shortcode.
Author: Kharis Sulistiyono
Version: 1.0
Author URI: http://risbl.co/wp
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *  WooCommerce Product Sales Counter class shortcode
 *
 * @class Risbl_WC_Sales_Counter
 * @author Kharis Sulistiyono
 */

if ( ! class_exists( 'Risbl_WC_Sales_Counter' ) ) :


  class Risbl_WC_Sales_Counter {

      /**
       * Constructor
       */
      public function __construct(){

        add_shortcode('risbl_sales_counter', array($this, 'sales_counter'));

      }

      /**
       * Core shortcode function
       *
       * @return string
       * @param $atts array
       */
      public function sales_counter($atts){

				$atts = shortcode_atts( array(
					'ids'  						=> '', // Product IDS
					'prod_label' 			=> '',
					'sales_label' 		=> '',
					'no_sales_note' 	=> '',
					'mode'						=> null // Option: single_raw
				), $atts );

				$args = array();
				$args['post_type'] = 'product';
		    $args['post_status'] = 'publish';
		    $args['posts_per_page'] = -1;
				$args['meta_key'] = 'total_sales';
				$args['orderby'] = 'meta_value_num';

				if( isset($atts['ids']) && $atts['ids'] != '' ){
					$args['post__in'] = explode( ',', $atts['ids'] );
				}

		    $products = new WP_Query( $args );

				$prod_label = ( isset($atts['prod_label']) && $atts['prod_label'] != '' ) ? $atts['prod_label'] : __('Product Name', 'woocommerce');
				$sales_label = ( isset($atts['sales_label']) && $atts['sales_label'] != '' ) ? $atts['sales_label'] : __('Sales', 'woocommerce');
				$no_sales_note = ( isset($atts['no_sales_note']) && $atts['no_sales_note'] != '' ) ? $atts['no_sales_note'] : __('No product sold, yet.', 'woocommerce');

        ob_start();

				if( isset($atts['mode']) && $atts['mode'] =='single_raw' && $products->have_posts() ) :

					while ( $products->have_posts() ) : $products->the_post();

						$sales = get_post_meta( get_the_ID(), 'total_sales', true );

						echo $sales;

					endwhile;

				endif; wp_reset_postdata();

				if( !isset($atts['mode']) ) : if( $products->have_posts() ) :

					echo '<table class="wc-sales-counter">';
					echo '<thead>';
					echo '<tr>';
					echo '<th>'.$prod_label.'</th>';
					echo '<th>'.$sales_label.'</th>';
					echo '</tr>';
					echo '</thead>';
					echo '<tbody>';

					while ( $products->have_posts() ) : $products->the_post();

						$sales = get_post_meta( get_the_ID(), 'total_sales', true );

						?>

						<tr>

							<td><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></td>
							<td><?php echo $sales; ?></td>

						</tr>

						<?php

					endwhile; wp_reset_postdata();

					echo '</tbody>';
					echo '</table>';

				else :

					echo '<p>'.apply_filters('risbl_no_product_sold_message', $no_sales_note ).'</p>';

				endif; endif;

        ?>

        <?php

        return ob_get_clean();

      }

  }

endif;

return new Risbl_WC_Sales_Counter();
