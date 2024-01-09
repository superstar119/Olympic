<?php
/**
 * Theme functions and definitions
 *
 * @package ThriveThemeChild
 */

 /**
  * Load child theme css and optional scripts
  *
  * @return void
  */


require_once 'inc/extras.php';

require_once 'templates/shortcode/feed-archieve.php';

require_once 'templates/shortcode/single-hot-tubs.php';

require_once 'templates/shortcode/collection.php';

require_once 'templates/shortcode/blog.php';

require_once 'templates/shortcode/user-account.php';


/** pages */
require_once 'templates/pages/brand.php';

require_once 'templates/pages/about.php';

require_once 'templates/pages/specials.php';

require_once 'templates/pages/locations.php';

require_once 'templates/pages/blog-feed.php';

require_once 'templates/pages/contact.php';

require_once 'templates/pages/estore.php';

/** plugins */
add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 30 );
remove_action( 'yith_wcqv_product_image', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_show_product_images', 'woocommerce_show_product_images', 20 );


function thrive_theme_child_enqueue_scripts() {

	wp_enqueue_style( 'olympic-child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', null, '1.0.0' );
	wp_enqueue_script( 'olympic-child-script', get_stylesheet_directory_uri() . '/assets/js/main.js', null, '1.0.0' );

	remove_post_type_support( 'page', 'editor' );
}

function enqueue_react_scripts() {
	wp_enqueue_script( 'design-hottub', get_stylesheet_directory_uri() . '/extra/build/static/js/main.js', array(), '1.0', true );
	wp_enqueue_style( 'design-hottub', get_stylesheet_directory_uri() . '/extra/build/static/css/main.css', array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_react_scripts' );
add_action( 'wp_enqueue_scripts', 'thrive_theme_child_enqueue_scripts', 10 );


/* CUSTOM PRODUCT TEMPLATES */
add_filter( 'template_include', 'product_custom_template', 12 );


function get_product_categories( $product_id ) {
	$terms = get_the_terms( $product_id, 'product_cat' );
	return $terms;
}

function get_product_brand( $product ) {
	$product_brand = '';
	$brands        = array( 'Hot Spring®', 'Caldera® Spas', 'Fantasy® Spas', 'Freeflow® Spas', 'ht-clearance' );
	$brandsSlug    = array( 'hot-spring', 'Caldera® Spas', 'fantasy-spas', 'freeflow-spas', 'ht-clearance' );
	$current_url   = get_permalink();
	$product_id    = $product->get_id();
	$categories    = get_product_categories( $product_id );
	var_dump( $categories[0]->name );

	foreach ( $brands as $key => $brand ) {
		if ( stripos( $categories[0]->name, $brand ) !== false ) {
			$product_brand = $brandsSlug[ $key ];
		}
	}
	return $product_brand;
}
// custom hot tub function

function get_hottub_pricing_links( $product_brand, $title, $product_cap ) {
	$pricing_link  = get_site_url() . '/request-hot-tub-pricing/';
	$brochure_link = get_site_url() . '/download-a-brochure/';

	switch ( $product_brand ) {
		case 'hot-spring':
			$product_brand = 'Hot Spring';
			$hotTubName    = setHotTubName( $product_brand, $title, $product_cap );

			$brochure_link = get_site_url() . '/download-a-brochure/hot-spring-spas-brochure/?hottub=' . $hotTubName;
			$pricing_link  = get_site_url() . '/request-hot-tub-pricing/request-a-price-quote-hot-spring-spas/?hottub=' . $hotTubName;
			break;
		case 'caldera-spas':
			$product_brand = 'Caldera Spas';
			$hotTubName    = setHotTubName( $product_brand, $title, $product_cap );

			$brochure_link = get_site_url() . '/download-a-brochure/caldera-spas-brochure/?hottub=' . $hotTubName;
			$pricing_link  = get_site_url() . '/request-hot-tub-pricing/request-a-price-quote-caldera-spas/?hottub=' . $hotTubName;
			break;
		case 'freeflow-spas':
			$product_brand = 'Freeflow Spas';
			$hotTubName    = setHotTubName( $product_brand, $title, $product_cap );

			$brochure_link  = get_site_url() . '/download-a-brochure/freeflow-spas-brochure/?hottub=' . $hotTubName;
			$pricing_link   = get_site_url() . '/request-hot-tub-pricing/request-a-price-quote-freeflow-spas/?hottub=' . $hotTubName;
			$deliveryCtaUrl = '/free-setup-delivery-freeflow/';

			break;
		case 'fantasy-spas':
			$product_brand = 'Fantasy Spas';
			$hotTubName    = setHotTubName( $product_brand, $title, $product_cap );

			$brochure_link = get_site_url() . '/download-a-brochure/fantasy-spas-brochure/?hottub=' . $hotTubName;
			$pricing_link  = get_site_url() . '/request-hot-tub-pricing/request-a-price-quote-fantasy-spas/?hottub=' . $hotTubName;
			break;
		default:
			$pricing_link = get_site_url() . '/request-hot-tub-pricing/.';
	}

	return array(
		'pricing_link'  => $pricing_link,
		'brochure_link' => $brochure_link,
	);
}
function setHotTubName( $product_brand, $title, $product_cap ) {
	// $newTitle = str_replace(' ®','',$title);
	$newTitle   = str_replace( array( ' ®', ' ™' ), '', $title );
	$hotTubName = $product_brand . ' - ' . $newTitle . ' - ' . $product_cap . ' Person';
	return $hotTubName;
}
