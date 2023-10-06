<?php
/**
 * Page Template Specials shortcodes
 *
 * @package ThriveThemeChild
 */

 /**
  * Load child theme css and optional scripts
  *
  * @return
  */

function specials_promotion() {
	ob_start();
    $args = array(
        'post_type' => 'promotion',
        'posts_per_page' => 10, // Retrieve all posts
    );
    
    $ind   = 0;
    $query = new WP_Query($args);
    if ( $query->have_posts() ) : ?>
        <div class="specials-promotion">
            <?php while ( $query->have_posts() ) : 
                $query->the_post();
                global $post;
                $ind ++;
                $class = 'specials-promotion__item' . (($ind == 1 || $ind == 6) ? ' specials-promotion__item__big' : '');
                ?>
            <div class="<?php echo esc_attr( $class ); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="item-image"><?php the_post_thumbnail(); ?></div>
                <?php endif; ?>
                <div class="item-info">
                    <h2 class="item-title"><?php the_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>" class="item-cta text-upper btn">Learn More</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php endif;
    wp_reset_postdata();
	return ob_get_clean();
}

add_shortcode( 'specials_promotion', 'specials_promotion' );
