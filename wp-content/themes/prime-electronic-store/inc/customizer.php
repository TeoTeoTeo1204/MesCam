<?php
/**
 * Prime Electronic Store Theme Customizer.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package prime_electronic_store
 */

if( ! function_exists( 'prime_electronic_store_customize_register' ) ):  
/**
 * Add postMessage support for site title and description for the Theme Customizer.F
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function prime_electronic_store_customize_register( $wp_customize ) {
    require get_parent_theme_file_path('/inc/controls/changeable-icon.php');
    

    if ( version_compare( get_bloginfo('version'),'4.9', '>=') ) {
        $wp_customize->get_section( 'static_front_page' )->title = __( 'Static Front Page', 'prime-electronic-store' );
    }
	
    /* Option list of all post */	
    $prime_electronic_store_options_posts = array();
    $prime_electronic_store_options_posts_obj = get_posts('posts_per_page=-1');
    $prime_electronic_store_options_posts[''] = esc_html__( 'Choose Post', 'prime-electronic-store' );
    foreach ( $prime_electronic_store_options_posts_obj as $prime_electronic_store_posts ) {
    	$prime_electronic_store_options_posts[$prime_electronic_store_posts->ID] = $prime_electronic_store_posts->post_title;
    }
    
    /* Option list of all categories */
    $prime_electronic_store_args = array(
	   'type'                     => 'post',
	   'orderby'                  => 'name',
	   'order'                    => 'ASC',
	   'hide_empty'               => 1,
	   'hierarchical'             => 1,
	   'taxonomy'                 => 'category'
    ); 
    $prime_electronic_store_option_categories = array();
    $prime_electronic_store_category_lists = get_categories( $prime_electronic_store_args );
    $prime_electronic_store_option_categories[''] = esc_html__( 'Choose Category', 'prime-electronic-store' );
    foreach( $prime_electronic_store_category_lists as $prime_electronic_store_category ){
        $prime_electronic_store_option_categories[$prime_electronic_store_category->term_id] = $prime_electronic_store_category->name;
    }
    
    /** Default Settings */    
    $wp_customize->add_panel( 
        'wp_default_panel',
         array(
            'priority' => 10,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Default Settings', 'prime-electronic-store' ),
            'description' => esc_html__( 'Default section provided by wordpress customizer.', 'prime-electronic-store' ),
        ) 
    );
    
    $wp_customize->get_section( 'title_tagline' )->panel                  = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel                         = 'wp_default_panel';
    $wp_customize->get_section( 'header_image' )->panel                   = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel               = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel              = 'wp_default_panel';
    
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
    /** Default Settings Ends */
    
    /** Site Title control */
    $wp_customize->add_setting( 
        'header_site_title', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'header_site_title',
        array(
            'label'       => __( 'Show / Hide Site Title', 'prime-electronic-store' ),
            'section'     => 'title_tagline',
            'type'        => 'checkbox',
        )
    );

    /** Tagline control */
    $wp_customize->add_setting( 
        'header_tagline', 
        array(
            'default'           => false,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'header_tagline',
        array(
            'label'       => __( 'Show / Hide Tagline', 'prime-electronic-store' ),
            'section'     => 'title_tagline',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting('logo_width', array(
        'sanitize_callback' => 'absint', 
    ));

    // Add a control for logo width
    $wp_customize->add_control('logo_width', array(
        'label' => __('Logo Width', 'prime-electronic-store'),
        'section' => 'title_tagline',
        'type' => 'number',
        'input_attrs' => array(
            'min' => '50', 
            'max' => '500', 
            'step' => '5', 
    ),
        'default' => '100', 
    ));

    $wp_customize->add_setting( 'prime_electronic_store_site_title_size', array(
        'default'           => 30, // Default font size in pixels
        'sanitize_callback' => 'absint', // Sanitize the input as a positive integer
    ) );

    // Add control for site title size
    $wp_customize->add_control( 'prime_electronic_store_site_title_size', array(
        'type'        => 'number',
        'section'     => 'title_tagline', // You can change this section to your preferred section
        'label'       => __( 'Site Title Font Size (px)', 'prime-electronic-store' ),
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 100,
            'step' => 1,
        ),
    ) );
    /** Post Settings */
    $wp_customize->add_section(
        'prime_electronic_store_post_settings',
        array(
            'title' => esc_html__( 'Post Settings', 'prime-electronic-store' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
        )
    );

    /** Post Heading control */
    $wp_customize->add_setting( 
        'prime_electronic_store_post_heading_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_post_heading_setting',
        array(
            'label'       => __( 'Show / Hide Post Heading', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Meta control */
    $wp_customize->add_setting( 
        'prime_electronic_store_post_meta_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_post_meta_setting',
        array(
            'label'       => __( 'Show / Hide Post Meta', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Image control */
    $wp_customize->add_setting( 
        'prime_electronic_store_post_image_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_post_image_setting',
        array(
            'label'       => __( 'Show / Hide Post Image', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Post Content control */
    $wp_customize->add_setting( 
        'prime_electronic_store_post_content_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_post_content_setting',
        array(
            'label'       => __( 'Show / Hide Post Content', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_post_settings',
            'type'        => 'checkbox',
        )
    );
    /** Post ReadMore control */
     $wp_customize->add_setting( 'prime_electronic_store_read_more_setting`', array(
        'default'           => true,
        'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'prime_electronic_store_read_more_setting`', array(
        'type'        => 'checkbox',
        'section'     => 'prime_electronic_store_post_settings', 
        'label'       => __( 'Display Read More Button', 'prime-electronic-store' ),
    ) );

    /** Post Settings Ends */

     /** Single Post Settings */
    $wp_customize->add_section(
        'prime_electronic_store_single_post_settings',
        array(
            'title' => esc_html__( 'Single Post Settings', 'prime-electronic-store' ),
            'priority' => 20,
            'capability' => 'edit_theme_options',
        )
    );

    /** Single Post Meta control */
    $wp_customize->add_setting( 
        'prime_electronic_store_single_post_meta_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_single_post_meta_setting',
        array(
            'label'       => __( 'Show / Hide Single Post Meta', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_single_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Single Post Content control */
    $wp_customize->add_setting( 
        'prime_electronic_store_single_post_content_setting', 
        array(
            'default'           => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_single_post_content_setting',
        array(
            'label'       => __( 'Show / Hide Single Post Content', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_single_post_settings',
            'type'        => 'checkbox',
        )
    );

    /** Single Post Settings Ends */

         // Typography Settings Section
    $wp_customize->add_section('prime_electronic_store_typography_settings', array(
        'title'      => esc_html__('Typography Settings', 'prime-electronic-store'),
        'priority'   => 30,
        'capability' => 'edit_theme_options',
    ));

    // Array of fonts to choose from
    $font_choices = array(
        ''               => __('Select', 'prime-electronic-store'),
        'Arial'          => 'Arial, sans-serif',
        'Verdana'        => 'Verdana, sans-serif',
        'Helvetica'      => 'Helvetica, sans-serif',
        'Times New Roman'=> '"Times New Roman", serif',
        'Georgia'        => 'Georgia, serif',
        'Courier New'    => '"Courier New", monospace',
        'Trebuchet MS'   => '"Trebuchet MS", sans-serif',
        'Tahoma'         => 'Tahoma, sans-serif',
        'Palatino'       => '"Palatino Linotype", serif',
        'Garamond'       => 'Garamond, serif',
        'Impact'         => 'Impact, sans-serif',
        'Comic Sans MS'  => '"Comic Sans MS", cursive, sans-serif',
        'Lucida Sans'    => '"Lucida Sans Unicode", sans-serif',
        'Arial Black'    => '"Arial Black", sans-serif',
        'Gill Sans'      => '"Gill Sans", sans-serif',
        'Segoe UI'       => '"Segoe UI", sans-serif',
        'Open Sans'      => '"Open Sans", sans-serif',
        'Roboto'         => 'Roboto, sans-serif',
        'Lato'           => 'Lato, sans-serif',
        'Montserrat'     => 'Montserrat, sans-serif',
        'Libre Baskerville' => 'Libre Baskerville',
    );

    // Heading Font Setting
    $wp_customize->add_setting('prime_electronic_store_heading_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'prime_electronic_store_sanitize_choicess',
    ));
    $wp_customize->add_control('prime_electronic_store_heading_font_family', array(
        'type'    => 'select',
        'choices' => $font_choices,
        'label'   => __('Select Font for Heading', 'prime-electronic-store'),
        'section' => 'prime_electronic_store_typography_settings',
    ));

    // Body Font Setting
    $wp_customize->add_setting('prime_electronic_store_body_font_family', array(
        'default'           => '',
        'sanitize_callback' => 'prime_electronic_store_sanitize_choicess',
    ));
    $wp_customize->add_control('prime_electronic_store_body_font_family', array(
        'type'    => 'select',
        'choices' => $font_choices,
        'label'   => __('Select Font for Body', 'prime-electronic-store'),
        'section' => 'prime_electronic_store_typography_settings',
    ));

    /** Typography Settings Section End */

    /** General Settings */
    $wp_customize->add_section(
        'prime_electronic_store_general_settings',
        array(
            'title' => esc_html__( 'General Settings', 'prime-electronic-store' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** Scroll to top control */
    $wp_customize->add_setting( 
        'prime_electronic_store_footer_scroll_to_top', 
        array(
            'default' => 1,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_footer_scroll_to_top',
        array(
            'label'       => __( 'Show Scroll To Top', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_general_settings',
            'type'        => 'checkbox',
        )
    );

     $wp_customize->add_setting('prime_electronic_store_scroll_icon',array(
        'default'   => 'fas fa-arrow-up',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Prime_Electronic_Store_Changeable_Icon(
        $wp_customize,'prime_electronic_store_scroll_icon',array(
        'label' => __('Scroll Top Icon','prime-electronic-store'),
        'transport' => 'refresh',
        'section'   => 'prime_electronic_store_general_settings',
        'type'      => 'icon'
    )));

    /** Preloader control */
    $wp_customize->add_setting( 
        'prime_electronic_store_header_preloader', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_header_preloader',
        array(
            'label'       => __( 'Show Preloader', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_general_settings',
            'type'        => 'checkbox',
        )
    );

    $wp_customize->add_setting('prime_electronic_store_loader_layout_setting', array(
        'default' => 'load',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add control for loader layout
    $wp_customize->add_control('prime_electronic_store_loader_layout_control', array(
        'label' => __('Preloader Layout', 'prime-electronic-store'),
        'section' => 'prime_electronic_store_general_settings',
        'settings' => 'prime_electronic_store_loader_layout_setting',
        'type' => 'select',
        'choices' => array(
            'load' => __('Preloader 1', 'prime-electronic-store'),
            'load-one' => __('Preloader 2', 'prime-electronic-store'),
            'ctn-preloader' => __('Preloader 3', 'prime-electronic-store'),
        ),
    ));
    /** Sticky Header control */
    $wp_customize->add_setting( 
        'prime_electronic_store_sticky_header', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_sticky_header',
        array(
            'label'       => __( 'Show Sticky Header', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_general_settings',
            'type'        => 'checkbox',
        )
    );

    // Add Setting for Menu Font Weight
    $wp_customize->add_setting( 'prime_electronic_store_menu_font_weight', array(
        'default'           => '500',
        'sanitize_callback' => 'prime_electronic_store_sanitize_font_weight',
    ) );

    // Add Control for Menu Font Weight
    $wp_customize->add_control( 'prime_electronic_store_menu_font_weight', array(
        'label'    => __( 'Menu Font Weight', 'prime-electronic-store' ),
        'section'  => 'prime_electronic_store_general_settings',
        'type'     => 'select',
        'choices'  => array(
            '100' => __( '100 - Thin', 'prime-electronic-store' ),
            '200' => __( '200 - Extra Light', 'prime-electronic-store' ),
            '300' => __( '300 - Light', 'prime-electronic-store' ),
            '400' => __( '400 - Normal', 'prime-electronic-store' ),
            '500' => __( '500 - Medium', 'prime-electronic-store' ),
            '600' => __( '600 - Semi Bold', 'prime-electronic-store' ),
            '700' => __( '700 - Bold', 'prime-electronic-store' ),
            '800' => __( '800 - Extra Bold', 'prime-electronic-store' ),
            '900' => __( '900 - Black', 'prime-electronic-store' ),
        ),
    ) );

    // Add Setting for Menu Text Transform
    $wp_customize->add_setting( 'prime_electronic_store_menu_text_transform', array(
        'default'           => 'Uppercase',
        'sanitize_callback' => 'prime_electronic_store_sanitize_text_transform',
    ) );

    // Add Control for Menu Text Transform
    $wp_customize->add_control( 'prime_electronic_store_menu_text_transform', array(
        'label'    => __( 'Menu Text Transform', 'prime-electronic-store' ),
        'section'  => 'prime_electronic_store_general_settings',
        'type'     => 'select',
        'choices'  => array(
            'none'       => __( 'None', 'prime-electronic-store' ),
            'capitalize' => __( 'Capitalize', 'prime-electronic-store' ),
            'uppercase'  => __( 'Uppercase', 'prime-electronic-store' ),
            'lowercase'  => __( 'Lowercase', 'prime-electronic-store' ),
        ),
    ) );

    $wp_customize->add_setting('prime_electronic_store_sidebar_text_align', array(
    'default'           => 'left',
    'sanitize_callback' => 'sanitize_text_field',
    ));

    // Add Sidebar Text Align Control
    $wp_customize->add_control('sidebar_text_align_control', array(
        'label'    => __('Sidebar Heading Text Align', 'prime-electronic-store'),
        'section'  => 'prime_electronic_store_general_settings',
        'settings' => 'prime_electronic_store_sidebar_text_align',
        'type'     => 'select',
        'choices'  => array(
            'left'   => __('Left', 'prime-electronic-store'),
            'center' => __('Center', 'prime-electronic-store'),
        ),
    ));

    /** Header Section Settings */
    $wp_customize->add_section(
        'prime_electronic_store_header_section_settings',
        array(
            'title' => esc_html__( 'Header Section Settings', 'prime-electronic-store' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
        )
    );

    /** Header Section control */
    $wp_customize->add_setting( 
        'prime_electronic_store_header_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_header_setting',
        array(
            'label'       => __( 'Show Header', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_header_section_settings',
            'type'        => 'checkbox',
        )
    );

     /** Phone */
    $wp_customize->add_setting(
        'prime_electronic_store_topbar_text_1',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_electronic_store_topbar_text_1',
        array(
            'label' => esc_html__( 'Topbar Text 1', 'prime-electronic-store' ),
            'section' => 'prime_electronic_store_header_section_settings',
            'type' => 'text',
        )
    );
    $wp_customize->add_setting('prime_electronic_store_1_icon',array(
        'default'   => 'fas fa-shopping-cart',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Prime_Electronic_Store_Changeable_Icon(
        $wp_customize,'prime_electronic_store_1_icon',array(
        'label' => __('Icon 1','prime-electronic-store'),
        'transport' => 'refresh',
        'section'   => 'prime_electronic_store_header_section_settings',
        'type'      => 'icon'
    )));

     /** Email */
    $wp_customize->add_setting(
        'prime_electronic_store_topbar_text_2',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_electronic_store_topbar_text_2',
        array(
            'label' => esc_html__( 'Topbar Text 2', 'prime-electronic-store' ),
            'section' => 'prime_electronic_store_header_section_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting('prime_electronic_store_mail_icon',array(
        'default'   => 'far fa-clock',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Prime_Electronic_Store_Changeable_Icon(
        $wp_customize,'prime_electronic_store_mail_icon',array(
        'label' => __('Icon 2','prime-electronic-store'),
        'transport' => 'refresh',
        'section'   => 'prime_electronic_store_header_section_settings',
        'type'      => 'icon'
    )));


    /**  TIMING */
    $wp_customize->add_setting(
        'prime_electronic_store_topbar_text_3',
        array( 
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh'
        )
    );
    
    $wp_customize->add_control(
        'prime_electronic_store_topbar_text_3',
        array(
            'label' => esc_html__( 'Topbar Text 3', 'prime-electronic-store' ),
            'section' => 'prime_electronic_store_header_section_settings',
            'type' => 'text',
        )
    );

    $wp_customize->add_setting('prime_electronic_store_marker_icon',array(
        'default'   => 'fas fa-table',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Prime_Electronic_Store_Changeable_Icon(
        $wp_customize,'prime_electronic_store_marker_icon',array(
        'label' => __('Icon 3','prime-electronic-store'),
        'transport' => 'refresh',
        'section'   => 'prime_electronic_store_header_section_settings',
        'type'      => 'icon'
    )));


    $wp_customize->add_setting( 
        'prime_electronic_store_show_hide_search', 
        array(
            'default' => false ,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_show_hide_search',
        array(
            'label'       => __( 'Show Search Icon', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_header_section_settings',
            'type'        => 'checkbox',
        )
    );
    $wp_customize->add_setting('prime_electronic_store_search_icon',array(
        'default'   => 'fas fa-search',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control(new Prime_Electronic_Store_Changeable_Icon(
        $wp_customize,'prime_electronic_store_search_icon',array(
        'label' => __('Search Icon','prime-electronic-store'),
        'transport' => 'refresh',
        'section'   => 'prime_electronic_store_header_section_settings',
        'type'      => 'icon'
    )));


    /** Home Page Settings */
    $wp_customize->add_panel( 
        'prime_electronic_store_home_page_settings',
         array(
            'priority' => 40,
            'capability' => 'edit_theme_options',
            'title' => esc_html__( 'Home Page Settings', 'prime-electronic-store' ),
            'description' => esc_html__( 'Customize Home Page Settings', 'prime-electronic-store' ),
        ) 
    );

    /** Slider Section Settings */
    $wp_customize->add_section(
        'prime_electronic_store_slider_section_settings',
        array(
            'title' => esc_html__( 'Slider Section Settings', 'prime-electronic-store' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'prime_electronic_store_home_page_settings',
        )
    );

    /** Slider Section control */
    $wp_customize->add_setting( 
        'prime_electronic_store_slider_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_slider_setting',
        array(
            'label'       => __( 'Show Slider', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_slider_section_settings',
            'type'        => 'checkbox',
        )
    );

     // Section Text
    $wp_customize->add_setting(
        'prime_electronic_store_slider_extra_text', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',    
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control(
        'prime_electronic_store_slider_extra_text', 
        array(
            'label'       => __('Section Extra Heading', 'prime-electronic-store'),
            'section'     => 'prime_electronic_store_slider_section_settings',
            'settings'    => 'prime_electronic_store_slider_extra_text',
            'type'        => 'text'
        )
    );
    
    $categories = get_categories();
        $cat_posts = array();
            $i = 0;
            $cat_posts[]='Select';
        foreach($categories as $category){
            if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cat_posts[$category->slug] = $category->name;
    }

    $wp_customize->add_setting(
        'prime_electronic_store_blog_slide_category',
        array(
            'default'   => 'select',
            'sanitize_callback' => 'prime_electronic_store_sanitize_choices',
        )
    );
    $wp_customize->add_control(
        'prime_electronic_store_blog_slide_category',
        array(
            'type'    => 'select',
            'choices' => $cat_posts,
            'label' => __('Select Category to display Slides','prime-electronic-store'),
            'section' => 'prime_electronic_store_slider_section_settings',
        )
    );

    /** Classes Section Settings */
    $wp_customize->add_section(
        'prime_electronic_store_classes_section_settings',
        array(
            'title' => esc_html__( 'Product Section Settings', 'prime-electronic-store' ),
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'panel' => 'prime_electronic_store_home_page_settings',
        )
    );

    /** Classes Section control */
    $wp_customize->add_setting( 
        'prime_electronic_store_classes_setting', 
        array(
            'default' => false,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_classes_setting',
        array(
            'label'       => __( 'Show product Section', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_classes_section_settings',
            'type'        => 'checkbox',
        )
    );

    $args = array(
        'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
    $categories = get_categories($args);
    $cat_posts = array();
    $m = 0;
    $cat_posts[]='Select';
    foreach($categories as $category){
        if($m==0){
            $default = $category->slug;
            $m++;
        }
        $cat_posts[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('prime_electronic_store_hot_products_cat',array(
        'default'   => 'select',
        'sanitize_callback' => 'prime_electronic_store_sanitize_choices',
    ));
    $wp_customize->add_control('prime_electronic_store_hot_products_cat',array(
        'type'    => 'select',
        'choices' => $cat_posts,
        'label' => __('Select category to display products ','prime-electronic-store'),
        'section' => 'prime_electronic_store_classes_section_settings',
    ));
    
    /** Home Page Settings Ends */
    
    /** Footer Section */
    $wp_customize->add_section(
        'prime_electronic_store_footer_section',
        array(
            'title' => __( 'Footer Settings', 'prime-electronic-store' ),
            'priority' => 70,
        )
    );

    /** Footer Copyright control */
    $wp_customize->add_setting( 
        'prime_electronic_store_footer_setting', 
        array(
            'default' => true,
            'sanitize_callback' => 'prime_electronic_store_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control(
        'prime_electronic_store_footer_setting',
        array(
            'label'       => __( 'Show Footer Copyright', 'prime-electronic-store' ),
            'section'     => 'prime_electronic_store_footer_section',
            'type'        => 'checkbox',
        )
    );
    
    /** Copyright Text */
    $wp_customize->add_setting(
        'prime_electronic_store_footer_copyright_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'prime_electronic_store_footer_copyright_text',
        array(
            'label' => __( 'Copyright Info', 'prime-electronic-store' ),
            'section' => 'prime_electronic_store_footer_section',
            'type' => 'text',
        )
    );  
$wp_customize->add_setting('prime_electronic_store_footer_background_image',
        array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        )
    );


    $wp_customize->add_control(
         new WP_Customize_Cropped_Image_Control($wp_customize, 'prime_electronic_store_footer_background_image',
            array(
                'label' => esc_html__('Footer Background Image', 'prime-electronic-store'),
                'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'prime-electronic-store'), 1024, 800),
                'section' => 'prime_electronic_store_footer_section',
                'width' => 1024,
                'height' => 800,
                'flex_width' => true,
                'flex_height' => true,
                'priority' => 100,
            )
        )
    );

    /* Footer Background Color*/
    $wp_customize->add_setting(
        'prime_electronic_store_footer_background_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'prime_electronic_store_footer_background_color',
            array(
                'label' => __('Footer Widget Area Background Color', 'prime-electronic-store'),
                'section' => 'prime_electronic_store_footer_section',
                'type' => 'color',
            )
        )
    );

    // 404 PAGE SETTINGS
    $wp_customize->add_section(
        'prime_electronic_store_404_section',
        array(
            'title' => __( '404 Page Settings', 'prime-electronic-store' ),
            'priority' => 70,
        )
    );
   
    $wp_customize->add_setting('404_page_image', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw', // Sanitize as URL
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '404_page_image', array(
        'label' => __('404 Page Image', 'prime-electronic-store'),
        'section' => 'prime_electronic_store_404_section',
        'settings' => '404_page_image',
    )));

    $wp_customize->add_setting('404_pagefirst_header', array(
        'default' => __('404', 'prime-electronic-store'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
    ));

    $wp_customize->add_control('404_pagefirst_header', array(
        'type' => 'text',
        'label' => __('Heading', 'prime-electronic-store'),
        'section' => 'prime_electronic_store_404_section',
    ));

    // Setting for 404 page header
    $wp_customize->add_setting('404_page_header', array(
        'default' => __('Sorry, that page can\'t be found!', 'prime-electronic-store'),
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field', // Sanitize as text field
    ));

    $wp_customize->add_control('404_page_header', array(
        'type' => 'text',
        'label' => __('Heading', 'prime-electronic-store'),
        'section' => 'prime_electronic_store_404_section',
    ));
    function prime_electronic_store_sanitize_choices( $input, $setting ) {
        global $wp_customize; 
        $control = $wp_customize->get_control( $setting->id ); 
        if ( array_key_exists( $input, $control->choices ) ) {
            return $input;
        } else {
            return $setting->default;
        }
    }

    function prime_electronic_store_sanitize_choicess($input) {
    $valid = array(
        'Arial'          => 'Arial, sans-serif',
        'Verdana'        => 'Verdana, sans-serif',
        'Helvetica'      => 'Helvetica, sans-serif',
        'Times New Roman'=> '"Times New Roman", serif',
        'Georgia'        => 'Georgia, serif',
        'Courier New'    => '"Courier New", monospace',
        'Trebuchet MS'   => '"Trebuchet MS", sans-serif',
        'Tahoma'         => 'Tahoma, sans-serif',
        'Palatino'       => '"Palatino Linotype", serif',
        'Garamond'       => 'Garamond, serif',
        'Impact'         => 'Impact, sans-serif',
        'Comic Sans MS'  => '"Comic Sans MS", cursive, sans-serif',
        'Lucida Sans'    => '"Lucida Sans Unicode", sans-serif',
        'Arial Black'    => '"Arial Black", sans-serif',
        'Gill Sans'      => '"Gill Sans", sans-serif',
        'Segoe UI'       => '"Segoe UI", sans-serif',
        'Open Sans'      => '"Open Sans", sans-serif',
        'Roboto'         => 'Roboto, sans-serif',
        'Lato'           => 'Lato, sans-serif',
        'Montserrat'     => 'Montserrat, sans-serif',
    );

    return (array_key_exists($input, $valid)) ? $input : '';
}

}
add_action( 'customize_register', 'prime_electronic_store_customize_register' );
endif;

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function prime_electronic_store_customize_preview_js() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $prime_electronic_store_build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $prime_electronic_store_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'prime_electronic_store_customizer', get_template_directory_uri() . '/js' . $prime_electronic_store_build . '/customizer' . $prime_electronic_store_suffix . '.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'prime_electronic_store_customize_preview_js' );