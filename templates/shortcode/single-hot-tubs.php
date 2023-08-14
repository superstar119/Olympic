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

function get_first_line ( $text, $split = '\n' ) {
    $array = explode( $split, $text );
    return trim( $array[0] );
}

function single_hot_tubs_shortcode() {
    ob_start();
    global $post;
    $intro_content = get_field( 'intro_content' );
    ?>
    <div class="hot-tub-intro">
        <div class="container">
            <div class="hot-tub-intro__content">
                <?php
                get_template_part_args(
                    'template-parts/content-modules-text',
                    array(
                        'v'  => 'intro_content',
                        't'  => 'div',
                        'o'  => 'f',
                        'tc' => 'hot-tub-intro__content__text'
                    )
                );
                get_template_part_args(
                    'template-parts/content-modules-cta',
                    array(
                        'v'  => 'get_price_cta',
                        'o'  => 'f',
                        'c' => 'hot-tub-intro__content__cta btn btn-blue'
                    )
                );
                ?>
            </div>
            <div class="hot-tub-intro__image"></div>
        </div>
    </div>
    <div class="hot-tub-simple-specs">
        <div class="container">
            <h2 class="hot-tub-simple-specs__title">Specs</h2>
            <ul class="specs-items">
                <?php
                $people     = get_field( 'people' );
                $jets       = get_field( 'jets' );
                $seating    = get_field( 'seating' );
                $dimentions = get_field( 'dimentions' );
                $water_care = get_field( 'water_care' );
                ?>
                <li class="specs-item">
                    <h5 class="specs-item__title">People</h5>
                    <p class="specs-item__data"><?php echo esc_html( $people ); ?></p>
                </li>
                <li class="specs-item">
                    <h5 class="specs-item__title">Jets</h5>
                    <p class="specs-item__data"><?php echo esc_html( get_first_line( $jets, ' ' ) ); ?></p>
                </li>
                <li class="specs-item">
                    <h5 class="specs-item__title">Seating</h5>
                    <p class="specs-item__data"><?php echo esc_html( $seating ); ?></p>
                </li>
                <li class="specs-item">
                    <h5 class="specs-item__title">Dimentions</h5>
                    <p class="specs-item__data"><?php echo esc_html( get_first_line( $dimentions ) ); ?></p>
                </li>
                <li class="specs-item">
                    <h5 class="specs-item__title">Water Care</h5>
                    <p class="specs-item__data"><?php echo esc_html( $water_care ); ?></p>
                </li>
            </ul>
        </div>
    </div>
    <div class="hot-tub-features">
        <div class="container">
            <h2 class="hot-tub-features__title">Features</h2>
            <?php
            $features = get_field( 'features' );
            if ( $features ) :
            ?>
            <div class="featrues-items">
                <?php foreach ( $features as $post ) :
                    setup_postdata( $post );
                    get_template_part( 'template-parts/loop', 'feature' );
                    endforeach;
                wp_reset_postdata();
                ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="hot-tub__specification">
        <div class="container">
            <h2 class="hot-tub__specification__title"><?php the_title();?> Specifications</h2>
            <?php
            get_template_part_args(
                'template-parts/content-modules-text',
                array(
                    'v'  => 'specification_title',
                    'o'  => 'f',
                    't'  => 'p',
                    'tc' => 'hot-tub__specification__content'
                )
            );
            ?>
            <div class="hot-tub__specification__info">
                <div class="info-left">
                    <div class="info-left__image">
                        <?php if ( has_post_thumbnail() ) :
                            the_post_thumbnail();
                        endif;
                            ?>
                    </div>
                    <div class="info-left__ctas">
                        <?php
                        get_template_part_args(
                            'template-parts/content-modules-cta',
                            array(
                                'v'  => 'warranty_cta',
                                'o'  => 'f',
                                'c'  => 'info-left__cta btn btn-trans-blue'
                            )
                        );
                        get_template_part_args(
                            'template-parts/content-modules-cta',
                            array(
                                'v'  => 'specs_cta',
                                'o'  => 'f',
                                'c'  => 'info-left__cta btn btn-trans-blue'
                            )
                        );
                        get_template_part_args(
                            'template-parts/content-modules-cta',
                            array(
                                'v'  => 'owner_manual_cta',
                                'o'  => 'f',
                                'c'  => 'info-left__cta btn btn-trans-blue'
                            )
                        );
                        get_template_part_args(
                            'template-parts/content-modules-cta',
                            array(
                                'v'  => 'delivery_guide_cta',
                                'o'  => 'f',
                                'c'  => 'info-left__cta btn btn-trans-blue'
                            )
                        );
                        ?>
                    </div>
                </div>
                <div class="info-right"></div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'single_hot_tubs_shortcode', 'single_hot_tubs_shortcode' );
