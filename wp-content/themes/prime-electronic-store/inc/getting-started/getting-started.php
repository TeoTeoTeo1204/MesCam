<?php
/**
 * Getting Started Page.
 *
 * @package prime_electronic_store
 */


if( ! function_exists( 'prime_electronic_store_getting_started_menu' ) ) :
/**
 * Adding Getting Started Page in admin menu
 */
function prime_electronic_store_getting_started_menu(){	
	add_theme_page(
		__( 'Getting Started', 'prime-electronic-store' ),
		__( 'Getting Started', 'prime-electronic-store' ),
		'manage_options',
		'prime-electronic-store',
		'prime_electronic_store_getting_started_page'
	);
}
endif;
add_action( 'admin_menu', 'prime_electronic_store_getting_started_menu' );

if( ! function_exists( 'prime_electronic_store_getting_started_admin_scripts' ) ) :
/**
 * Load Getting Started styles in the admin
 */
function prime_electronic_store_getting_started_admin_scripts( $hook ){
	wp_enqueue_script( 'prime-electronic-store', get_template_directory_uri() . '/js/getting-started.js', array( 'jquery' ), PRIME_ELECTRONIC_STORE_THEME_VERSION, true );
	// Load styles only on our page
	if( 'appearance_page_prime-electronic-store' != $hook ) return;

    wp_enqueue_style( 'prime-electronic-store', get_template_directory_uri() . '/css/getting-started.css', false, PRIME_ELECTRONIC_STORE_THEME_VERSION );
    
}
endif;
add_action( 'admin_enqueue_scripts', 'prime_electronic_store_getting_started_admin_scripts' );

if( ! function_exists( 'prime_electronic_store_getting_started_page' ) ) :
/**
 * Callback function for admin page.
*/
function prime_electronic_store_getting_started_page(){ ?>
	<div class="wrap getting-started">
		<h2 class="notices"></h2>
		<div class="intro-wrap">
			<div class="intro">
				<h3><?php echo esc_html( 'Getting started with', 'prime-electronic-store' );?> <span class="theme-name"><?php echo esc_html( PRIME_ELECTRONIC_STORE_THEME_NAME ); ?></span> <span  class="theme-name">v<?php echo esc_html( PRIME_ELECTRONIC_STORE_THEME_VERSION ); ?></span> </h3>

                <span><?php ?></span>
				<h4><?php printf( esc_html__( 'You will find everything you need to get started with %1$s below.', 'prime-electronic-store' ), PRIME_ELECTRONIC_STORE_THEME_NAME ); ?></h4>
			</div>
		</div>

		<div class="panels">
			<ul class="inline-list">
				<li class="current">
                    <a id="help" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                            <defs><style>.a{fill:#354052;}</style></defs>
                            <path class="a" d="M12,23H11V16.43A5.966,5.966,0,0,1,7,18a6.083,6.083,0,0,1-6-6V11H7.57A5.966,5.966,0,0,1,6,7a6.083,6.083,0,0,1,6-6h1V7.57A5.966,5.966,0,0,1,17,6a6.083,6.083,0,0,1,6,6v1H16.43A5.966,5.966,0,0,1,18,17,6.083,6.083,0,0,1,12,23Zm1-9.87v7.74a4,4,0,0,0,0-7.74ZM3.13,13A4.07,4.07,0,0,0,7,16a4.07,4.07,0,0,0,3.87-3Zm10-2h7.74a4,4,0,0,0-7.74,0ZM11,3.13A4.08,4.08,0,0,0,8,7a4.08,4.08,0,0,0,3,3.87Z" transform="translate(-1 -1)"/>
                        </svg>
                        <?php esc_html_e( 'Getting Started', 'prime-electronic-store' ); ?>
                    </a>
                </li>
				<li>
                    <a id="free-pro-panel" href="javascript:void(0);">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.297 20">
                            <defs><style>.a{fill:#354052;}</style></defs>
                            <path class="a" d="M19.384,17.534V13.75L14,19.155l5.384,5.405V20.777H31.3V17.534Zm6.53,9.189H14v3.243H25.914V33.75L31.3,28.345l-5.384-5.405Z" transform="translate(-14 -13.75)"/>
                        </svg>
                        <?php esc_html_e( 'Free Vs Pro', 'prime-electronic-store' ); ?>
                    </a>
                </li>
			</ul>
			<div id="panel" class="panel">
				<?php require get_template_directory() . '/inc/getting-started/tabs/help-panel.php'; ?>
				<?php require get_template_directory() . '/inc/getting-started/tabs/free-vs-pro-panel.php'; ?>
				<?php require get_template_directory() . '/inc/getting-started/tabs/link-panel.php'; ?>
			</div>
		</div>
	</div>
	<?php
}
endif;