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
	$args     = array(
		'post_type'      => 'hot_tubs',
		'posts_per_page' => -1,
		'order'          => 'ASC',
	);
	$products = new WP_Query( $args );

	// Filters
	?>
  <div class="hot-tub-filters">
	<div class="filters">
	  <div class="filter filter-brand">
		<div class="filter-btn button" data-value="brand">BRAND</div>
		<div class="filter-dropdown">
		  <p value="hot_spring_spas" class="option">Hot Spring Spas</p>
		  <p value="freeflow_spas" class="option">Freeflow Spas</p>
		</div>
	  </div>
	  <div class="filter filter-capacity">
		<div class="filter-btn button" data-value="capacity">SEATING CAPACITY</div>
		<div class="filter-dropdown">
		  <p value="hot_spring_spas" class="option">Hot Spring Spas</p>
		  <p value="freeflow_spas" class="option">Freeflow Spas</p>
		</div>
	  </div>
	  <div class="filter filter-saltwater">
		<div class="filter-btn button" data-value="saltwater">SALTWATER READY</div>
		<div class="filter-dropdown">
		  <p value="hot_spring_spas" class="option">Hot Spring Spas</p>
		  <p value="freeflow_spas" class="option">Freeflow Spas</p>
		</div>
	  </div>
	  <div class="filter filter-price">
		<div class="filter-btn button" data-value="price">PRICE LEVEL</div>
		<div class="filter-dropdown">
		  <p value="hot_spring_spas" class="option">Hot Spring Spas</p>
		  <p value="freeflow_spas" class="option">Freeflow Spas</p>
		</div>
	  </div>
	</div>
	<div class="clear-filter">Clear Filters</div>
  </div>
	<?php

	// Products

	if ( $products->have_posts() ) {
		echo '<div class="hot-tub-product">';
		while ( $products->have_posts() ) {
			$products->the_post();
			$permalink = get_permalink();
			var_dump($permalink);

			echo '<a class="hot-tub-product__item" href="' . $permalink . '">';
			echo '<div class="hot-tub-product__item__image">' . get_image() . '</div>';
			$product_categories = get_the_terms( get_id(), 'hot_tubs_cat' );

			echo '<div class="hot-tub-product__item__categories>';
			foreach ( $product_categories as $ind => $category ) {
				// if ( $ind == 2 ) {
					echo '<h5 class="hot-tub-product__item__category">' . $category->name . '</h5>';
				// }
			}
			// // echo '</div>';
			// echo '<h3 class="hot-tub-product__item__name">' . $product->get_name() . '</h3>';
			// echo '<h6 class="hot-tub-product__item__cost">Seats 6-7 | ' . $product_categories[0]->name . '</h6>';
			echo '</a>';
		}
		echo '</div>';
		wp_reset_postdata();
	} else {
		// No products found
	}

	return ob_get_clean();
}
add_shortcode( 'custom_product_shortcode', 'custom_product_shortcode' );
