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

function custom_product_shortcode( $atts = '9' ) {
	ob_start();
	// Extract and process the parameters
	$parameters = shortcode_atts(
		array(
			'parameter' => '9',
			'page' => 'feed'
		),
		$atts
	);
	// Access the parameter value
	$parameter_value = $parameters['parameter'];
	$page_value = $parameters['page'];

	$args     = array(
		'post_type'      => 'hot_tubs',
		'posts_per_page' => $parameter_value,
		'order'          => 'ASC',
	);
	$products = new WP_Query( $args );

	// Filters
	?>
	<?php if( $page_value == 'feed' ) : ?>
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
	endif;
	// Products

	if ( $products->have_posts() ) {
		?>
		<div class="hot-tub-product cpt-list"
                data-cat="" 
                data-post-type="hot_tubs" 
                data-paged="" 
                data-posts-per-page="9">

		<?php while ( $products->have_posts() ) {
			$products->the_post();
			$permalink = get_permalink();
			$my_tub    = get_field( 'design_my_tub' );
			$first_tub = $my_tub[0]['shell'];
			$image_2   = $first_tub[0]['media_image'];
			$people    = get_field( 'people' );
			$parts     = explode(' ', $people);

			echo '<a class="hot-tub-product__item" href="' . $permalink . '">';
			echo '<div class="hot-tub-product__item__image">' . get_the_post_thumbnail() . '</div>';
			?>
			<div class="hot-tub-product__item__image_2"><img src="<?php echo esc_attr( $image_2['url'] ); ?>" alt="Hot Tub"></div>
			<?php
			$product_categories = get_the_terms( get_the_id(), 'hot_tubs_cat' );

			// var_dump($product_categories);
			echo '<div class="hot-tub-product__item__categories">';
			// foreach ( $product_categories as $category ) {
				echo '<h5 class="hot-tub-product__item__category">' . $product_categories[0]->name . '</h5>';
			// }
			echo '</div>';
			echo '<h3 class="hot-tub-product__item__name">' . get_the_title() . '</h3>';
			?>
			<p class="hot-tub-product__item__seats">Seats <?php echo esc_html($parts[0]); ?> | $$$$</p>
			<?php
			echo '</a>';
		}
		echo '</div>';
		wp_reset_postdata();
		?>
		<div class="hot-tub-product__seemore btn">See More</div>
		<?php
	} else {
		// No products found
	}

	return ob_get_clean();
}
add_shortcode( 'custom_product_shortcode', 'custom_product_shortcode' );
