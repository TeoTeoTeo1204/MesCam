<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package prime_electronic_store
 */
$prime_electronic_store_heading_setting  = get_theme_mod( 'prime_electronic_store_post_heading_setting' , true );
$prime_electronic_store_meta_setting  = get_theme_mod( 'prime_electronic_store_post_meta_setting' , true );
$prime_electronic_store_image_setting  = get_theme_mod( 'prime_electronic_store_post_image_setting' , true );
$prime_electronic_store_content_setting  = get_theme_mod( 'prime_electronic_store_post_content_setting' , true );
$prime_electronic_store_read_more_setting = get_theme_mod( 'prime_electronic_store_read_more_setting' , true );
$prime_electronic_store_read_more_text = get_theme_mod( 'prime_electronic_store_read_more_text', __( 'Read More', 'prime-electronic-store' ) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		  if ( $prime_electronic_store_heading_setting ){ 
			if ( is_single() ) {
				the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		  }

		if ( 'post' === get_post_type() ) : ?>
		<?php
		if ( $prime_electronic_store_meta_setting ){ ?>
			<div class="entry-meta">
				<?php prime_electronic_store_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	 <?php
	 if ( $prime_electronic_store_image_setting ){ 
		 echo ( !is_single() ) ? '<a href="' . esc_url( get_the_permalink() ) . '" class="post-thumbnail">' : '<div class="post-thumbnail">'; ?>
	 			<?php ( is_active_sidebar( 'right-sidebar' ) ) ? the_post_thumbnail( 'prime-electronic-store-with-sidebar', array( 'itemprop' => 'image' ) ) : the_post_thumbnail( 'prime-electronic-store-without-sidebar', array( 'itemprop' => 'image' ) ) ; ?>
	    <?php echo ( !is_single() ) ? '</a>' : '</div>' ;?>
	 <?php } ?>
    <?php
	if ( $prime_electronic_store_content_setting ){ ?>
		<div class="entry-content" itemprop="text">
			<?php
			if( is_single()){
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'prime-electronic-store' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
				}else{
				the_excerpt();
				}
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'prime-electronic-store' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
    <?php } ?>
    <?php if ( !is_single() && $prime_electronic_store_read_more_setting ) { ?>
        <div class="read-more-button">
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more-button"><?php echo esc_html( $prime_electronic_store_read_more_text ); ?></a>
        </div>
    <?php } ?>
</article><!-- #post-## -->