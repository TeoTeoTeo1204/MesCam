<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package prime_electronic_store
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function prime_electronic_store_body_classes( $classes ) {
  global $prime_electronic_store_post;
  
    if( !is_page_template( 'template-home.php' ) ){
        $classes[] = 'inner';
        // Adds a class of group-blog to blogs with more than 1 published author.
    }

    if ( is_multi_author() ) {
        $classes[] = 'group-blog ';
    }

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    

    if( prime_electronic_store_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }    

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_page() ) {
        $classes[] = 'hfeed ';
    }
  
    if( is_404() ||  is_search() ){
        $classes[] = 'full-width';
    }
  
    if( ! is_active_sidebar( 'right-sidebar' ) ) {
        $classes[] = 'full-width'; 
    }

    return $classes;
}
add_filter( 'body_class', 'prime_electronic_store_body_classes' );

 /**
 * 
 * @link http://www.altafweb.com/2011/12/remove-specific-tag-from-php-string.html
 */
function prime_electronic_store_strip_single( $tag, $string ){
    $string=preg_replace('/<'.$tag.'[^>]*>/i', '', $string);
    $string=preg_replace('/<\/'.$tag.'>/i', '', $string);
    return $string;
}

if ( ! function_exists( 'prime_electronic_store_excerpt_more' ) ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function prime_electronic_store_excerpt_more($more) {
  return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'prime_electronic_store_excerpt_more' );


if( ! function_exists( 'prime_electronic_store_footer_credit' ) ):
/**
 * Footer Credits
*/
function prime_electronic_store_footer_credit() {
    $prime_electronic_store_copyright_text = get_theme_mod('prime_electronic_store_footer_copyright_text');

    $prime_electronic_store_text = '<div class="site-info"><div class="container"><span class="copyright">';
    if ($prime_electronic_store_copyright_text) {
        $prime_electronic_store_text .= wp_kses_post($prime_electronic_store_copyright_text); 
    } else {
        $prime_electronic_store_text .= esc_html__('&copy; ', 'prime-electronic-store') . date_i18n(esc_html__('Y', 'prime-electronic-store')); 
        $prime_electronic_store_text .= ' <a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>' . esc_html__('. All Rights Reserved.', 'prime-electronic-store');
    }
    $prime_electronic_store_text .= '</span>';
    $prime_electronic_store_text .= '<span class="by"> <a href="' . esc_url('https://www.themeignite.com/products/free-electronic-wordpress-theme') . '" rel="nofollow" target="_blank">' . PRIME_ELECTRONIC_STORE_THEME_NAME . '</a>' . esc_html__(' By ', 'prime-electronic-store') . '<a href="' . esc_url('https://themeignite.com/') . '" rel="nofollow" target="_blank">' . esc_html__('Themeignite', 'prime-electronic-store') . '</a>.';
    $prime_electronic_store_text .= sprintf(esc_html__(' Powered By %s', 'prime-electronic-store'), '<a href="' . esc_url(__('https://wordpress.org/', 'prime-electronic-store')) . '" target="_blank">WordPress</a>.');
    if (function_exists('the_privacy_policy_link')) {
        $prime_electronic_store_text .= get_the_privacy_policy_link();
    }
    $prime_electronic_store_text .= '</span></div></div>';
    echo apply_filters('prime_electronic_store_footer_text', $prime_electronic_store_text);
}
add_action('prime_electronic_store_footer', 'prime_electronic_store_footer_credit');
endif;



/**
 * Is Woocommerce activated
*/
if ( ! function_exists( 'prime_electronic_store_woocommerce_activated' ) ) {
  function prime_electronic_store_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
  }
}

if( ! function_exists( 'prime_electronic_store_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function prime_electronic_store_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $prime_electronic_store_commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $prime_electronic_store_aria_req = ( $req ? " aria-required='true'" : '' );
    $prime_electronic_store_required = ( $req ? " required" : '' );
    $prime_electronic_store_author   = ( $req ? __( 'Name*', 'prime-electronic-store' ) : __( 'Name', 'prime-electronic-store' ) );
    $prime_electronic_store_email    = ( $req ? __( 'Email*', 'prime-electronic-store' ) : __( 'Email', 'prime-electronic-store' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'prime-electronic-store' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $prime_electronic_store_author ) . '" type="text" value="' . esc_attr( $prime_electronic_store_commenter['comment_author'] ) . '" size="30"' . $prime_electronic_store_aria_req . $prime_electronic_store_required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'prime-electronic-store' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $prime_electronic_store_email ) . '" type="text" value="' . esc_attr(  $prime_electronic_store_commenter['comment_author_email'] ) . '" size="30"' . $prime_electronic_store_aria_req . $prime_electronic_store_required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'prime-electronic-store' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'prime-electronic-store' ) . '" type="text" value="' . esc_attr( $prime_electronic_store_commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'prime_electronic_store_change_comment_form_default_fields' );

if( ! function_exists( 'prime_electronic_store_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function prime_electronic_store_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'prime-electronic-store' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'prime-electronic-store' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'prime_electronic_store_change_comment_form_defaults' );

if( ! function_exists( 'prime_electronic_store_escape_text_tags' ) ) :
/**
 * Remove new line tags from string
 *
 * @param $text
 * @return string
 */
function prime_electronic_store_escape_text_tags( $text ) {
    return (string) str_replace( array( "\r", "\n" ), '', strip_tags( $text ) );
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
    /**
     * Triggered after the opening <body> tag.
    */
    do_action( 'wp_body_open' );
}
endif;

if ( ! function_exists( 'prime_electronic_store_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function prime_electronic_store_get_fallback_svg( $prime_electronic_store_post_thumbnail ) {
    if( ! $prime_electronic_store_post_thumbnail ){
        return;
    }
    
    $prime_electronic_store_image_size = prime_electronic_store_get_image_sizes( $prime_electronic_store_post_thumbnail );
     
    if( $prime_electronic_store_image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $prime_electronic_store_image_size['width'] ); ?> <?php echo esc_attr( $prime_electronic_store_image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $prime_electronic_store_image_size['width'] ); ?>" height="<?php echo esc_attr( $prime_electronic_store_image_size['height'] ); ?>" style="fill:#dedddd;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

function prime_electronic_store_enqueue_google_fonts() {

    require get_template_directory() . '/inc/wptt-webfont-loader.php';

    wp_enqueue_style(
            'google-fonts-raleway',
        wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap' ),
        array(),
        '1.0'
    );

    wp_enqueue_style(
        'google-fonts-pacifico',
        wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Pacifico&display=swap' ),
        array(),
        '1.0'
    );
}
add_action( 'wp_enqueue_scripts', 'prime_electronic_store_enqueue_google_fonts' );


if( ! function_exists( 'prime_electronic_store_site_branding' ) ) :
/**
 * Site Branding
*/
function prime_electronic_store_site_branding(){
    $prime_electronic_store_logo_site_title = get_theme_mod( 'header_site_title', 1 );
    $prime_electronic_store_tagline = get_theme_mod( 'header_tagline', false );
    $prime_electronic_store_logo_width = get_theme_mod('logo_width', 100); // Retrieve the logo width setting

    ?>
    <div class="site-branding" style="max-width: <?php echo esc_attr(get_theme_mod('logo_width', '-1'))?>px;">
        <?php 
        // Check if custom logo is set and display it
        if (function_exists('has_custom_logo') && has_custom_logo()) {
            the_custom_logo();
        }
        if ($prime_electronic_store_logo_site_title):
             if (is_front_page()): ?>
            <h1 class="site-title" style="font-size: <?php echo esc_attr(get_theme_mod('prime_electronic_store_site_title_size', '30')); ?>px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
          </h1>
            <?php else: ?>
                <p class="site-title" itemprop="name">
                    <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                </p>
            <?php endif; ?>
        <?php endif; 
    
        if ($prime_electronic_store_tagline) :
            $prime_electronic_store_description = get_bloginfo('description', 'display');
            if ($prime_electronic_store_description || is_customize_preview()) :
        ?>
                <p class="site-description" itemprop="description"><?php echo $prime_electronic_store_description; ?></p>
            <?php endif;
        endif;
        ?>
    </div>
    <?php
}
endif;
if( ! function_exists( 'prime_electronic_store_navigation' ) ) :
/**
 * Site Navigation
*/
function prime_electronic_store_navigation(){
    ?>
    <nav class="main-navigation" id="site-navigation"  role="navigation">
        <?php 
        wp_nav_menu( array( 
            'theme_location' => 'primary', 
            'menu_id' => 'primary-menu' 
        ) ); 
        ?>
    </nav>
    <?php
}
endif;


if( ! function_exists( 'prime_electronic_store_top_header' ) ) :
/**
 * Header Start
*/
function prime_electronic_store_top_header(){
    $prime_electronic_store_header_setting     = get_theme_mod( 'prime_electronic_store_header_setting', false );
    $prime_electronic_store_location     = get_theme_mod( 'prime_electronic_store_topbar_text_3' );
    $prime_electronic_store_phone        = get_theme_mod( 'prime_electronic_store_topbar_text_1' );
    $prime_electronic_store_email        = get_theme_mod( 'prime_electronic_store_topbar_text_2' );
    ?>
    <?php if ( $prime_electronic_store_header_setting ){?>
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-3 align-self-center">
                      <?php if ( $prime_electronic_store_phone ){?>
                        <span><a><i class="<?php echo esc_attr(get_theme_mod('prime_electronic_store_1_icon','fas fa-shopping-cart')); ?>"></i>
                        <?php echo esc_html( $prime_electronic_store_phone);?></span></a></span><?php } ?>      
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-5 align-self-center email">
                      <?php if ( $prime_electronic_store_email ){?>
                            <span><a><i class="<?php echo esc_attr(get_theme_mod('prime_electronic_store_mail_icon','far fa-clock')); ?>"></i> <?php echo esc_html($prime_electronic_store_email);?></a></span>
                        <?php } ?>  
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 text-lg-end align-self-center time">
                    <?php if ( $prime_electronic_store_location ){?>
                        <span>
                            <i class="<?php echo esc_attr(get_theme_mod('prime_electronic_store_marker_icon','fas fa-table')); ?>"></i>
                            <?php echo esc_html( $prime_electronic_store_location );?>
                        </span>
                    <?php } ?>  
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
}
endif;
add_action( 'prime_electronic_store_top_header', 'prime_electronic_store_top_header', 20 );


if( ! function_exists( 'prime_electronic_store_header' ) ) :
/**
 * Header Start
*/
function prime_electronic_store_header(){
      $prime_electronic_store_header_image = get_header_image();
      $prime_electronic_store_sticky_header = get_theme_mod('prime_electronic_store_sticky_header');
    ?>
    <div id="page-site-header">
        <header id="masthead" style="background-image: url('<?php echo esc_url( $prime_electronic_store_header_image ); ?>');" data-sticky="<?php echo $prime_electronic_store_sticky_header; ?>" class="site-header header-inner" role="banner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12 align-self-center">
                        <?php prime_electronic_store_site_branding(); ?>
                    </div>
                    <div class="col-lg-7 align-self-center">
                        <?php prime_electronic_store_navigation(); ?>
                    </div>
                    <div class="col-lg-2 align-self-center header-detail">
                        <?php if( get_theme_mod('prime_electronic_store_show_hide_search', false) ) { ?>
                            <div class="search-body text-md-end">
                                <button type="button" class="search-show">
                                    <i class="<?php echo esc_attr(get_theme_mod('prime_electronic_store_search_icon', 'fas fa-search')); ?>"></i>
                                </button>
                            </div>
                            <div class="searchform-inner">
                                <?php get_search_form(); ?>
                                <button type="button" class="close" aria-label="<?php esc_attr_e( 'Close', 'prime-electronic-store' ); ?>"><span aria-hidden="true">X</span></button>
                            </div> 
                        <?php } ?>
                        <?php if(class_exists('woocommerce')){ ?>
                                <a class="cart-customlocation" href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>" title="<?php esc_attr_e( 'View Shopping Cart','prime-electronic-store' ); ?>"><i class="fas fa-shopping-cart"></i><span class="cart-item-box"><?php echo esc_html(wp_kses_data( WC()->cart->get_cart_contents_count() ));?></span></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <?php
}
endif;
add_action( 'prime_electronic_store_header', 'prime_electronic_store_header', 20 );