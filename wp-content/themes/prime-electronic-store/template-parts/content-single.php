<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package prime_electronic_store
 */
$prime_electronic_store_single_meta_setting  = get_theme_mod( 'prime_electronic_store_single_post_meta_setting' , true );
$prime_electronic_store_single_content_setting  = get_theme_mod( 'prime_electronic_store_single_post_content_setting' , true );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php

		if ( 'post' === get_post_type() ) : ?>
		<?php
		if ( $prime_electronic_store_single_meta_setting ){ ?>
			<div class="entry-meta">
				<?php prime_electronic_store_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php } ?>
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	
    <?php
	if ( $prime_electronic_store_single_content_setting ){ ?>
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
		</div>
		<!-- .entry-content -->
    <?php } ?>
</article><!-- #post-## -->