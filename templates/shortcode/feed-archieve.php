<?php
/**
 * Theme shortcodes
 *
 * @package ThriveThemeChild
 */

 /**
  * Load child theme css and optional scripts
  *
  * @return void
  */
  
function custom_product_shortcode() {
    ob_start();
    $args = array(
      'post_type' => 'product',
      'posts_per_page' => 9,
	  'order' => 'ASC',
	  'meta_query' => array(
		 'relation' => 'OR',
		 array(
            'key' => 'dswaves_brand',
            'value' => 'Hot Spring Spas',
            'compare' => '='
         ),
		 array(
            'key' => 'dswaves_brand',
            'value' => 'Freeflow Spas',
            'compare' => '='
         )
       )
    );
    $products = new WP_Query($args);
		
    if ($products->have_posts()) {
		echo '<div class="hot-tub-product">';
        while ($products->have_posts()) {
            $products->the_post();
			$product = wc_get_product(get_the_ID());
			
			echo '<div class="hot-tub-product__item">';
			echo '<div class="hot-tub-product__item__image">' . $product->get_image() . '</div>';
			$product_categories = get_the_terms( $product->get_id(), 'product_cat' );

// 			echo '<div class="hot-tub-product__item__categories>';
			foreach($product_categories as $ind => $category) {
				if ( $ind == 2 )
			    	echo '<h5 class="hot-tub-product__item__category">' . $category->name . '</h5>';
			}
// 			echo '</div>';
			echo '<h3 class="hot-tub-product__item__name">' . $product->get_name() . '</h3>';
			echo '<h6 class="hot-tub-product__item__cost">Seats 6-7 | ' . $product_categories[0]->name . '</h6>';
			echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        // No products found
    }

    return ob_get_clean();
}
add_shortcode('custom_product_shortcode', 'custom_product_shortcode');
