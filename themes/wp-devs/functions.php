<?php

require get_template_directory() . '/inc/customizer.php';

function modify_body_classes($classes , $class){
	if ( !is_singular() ) {
		
		$class[] = 'test-nehad-singular';
		$classes = array_merge($classes, $class);
	}
	return $classes;
 }
 add_filter('body_class' , 'modify_body_classes' , 10 , 2);


	// Set content-width.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 580;
	}


function wpdevs_load_scripts(){
    wp_enqueue_style( 'wpdevs-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ), 'all' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap', array(), null );
    wp_enqueue_script( 'dropdown', get_template_directory_uri() . '/js/dropdown.js', array(), '1.0', true );

    wp_enqueue_style(
        'fancy-quote-css', // Handle for the style
        get_stylesheet_directory_uri() . '/fancy-quote.css', // Path to the CSS file
        array(),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'wpdevs_load_scripts' );

function wpdevs_config(){

    $textdomain = 'wp-devs';
    load_theme_textdomain( $textdomain, get_template_directory() . '/languages/' );

    register_nav_menus(
        array(
            'wp_devs_main_menu' => esc_html__( 'Main Menu', 'wp-devs' ),
            'wp_devs_footer_menu' => esc_html__( 'Footer Menu', 'wp-devs' )
        )
    );

    $args = array(
        'height'    => 225,
        'width'     => 1920
    );
    add_theme_support( 'custom-header', $args );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'width' => 200,
        'height'    => 110,
        'flex-height'   => true,
        'flex-width'    => true
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ));
    add_theme_support( 'title-tag' );

    // add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );

    add_theme_support( 'wp-block-styles' );




    // add_theme_support( 'editor-color-palette', array(
    //     array(
    //         'name'  => __( 'Primary', 'wp-devs' ),
    //         'slug'  => 'primary',
    //         'color' => '#001E32'
    //     ),
    //     array(
    //         'name'  => __( 'Secondary', 'wp-devs' ),
    //         'slug'  => 'secondary',
    //         'color' => '#CFAF07'
    //     )
    // ) );
    // add_theme_support( 'disable-custom-colors' );

}
add_action( 'after_setup_theme', 'wpdevs_config', 0 );




// Registers a new block style.
 
// function my_custom_block_styles() {
//     register_block_style(
//         'core/button', // The block to add the style to
//         array(
//             'name'  => 'my-custom-style', // The name of the style variation
//             'label' => __('My Custom Style', 'text-domain'), // The label shown in the editor
//             'inline_style' => '.wp-block-button.is-style-my-custom-style { color: red; }' // Optional custom CSS
//         )
//     );
// }
// add_action('init', 'my_custom_block_styles');
// function register_custom_block_styles() {
//     register_block_style(
//         'core/quote', 
//         array(
//             'name'         => 'fancy-quote', // Unique name for the style
//             'label'        => __('Fancy Quote'), // Label for the style
//             'style_handle' => 'fancy-quote-css' // Handle for the style's CSS
//         )
//     );
//     register_block_style(
//          "core/paragraph",
//         // 'core/gallery', 
//         array(
//             'name'         => 'fancy-paragraph' , // Unique name for the style ID
//             'label'        => __('Fancy  paragraph'), // Label for the style
//             'style_handle' => 'fancy-quote-css' // Handle for the style's CSS
//         )
//     );
//     register_block_style(
//          "core/group",

//         array(
//             'name'         => 'fancy-block-group' , // Unique name for the style ID
//             'label'        => __('Fancy Block Group'), // Label for the style
//             'style_handle' => 'fancy-quote-css' // Handle for the style's CSS
//         )
//     );

//     register_block_style(
//        'core/gallery', 
//        array(
//            'name'         => 'fancy-gallery' , // Unique name for the style ID
//            'label'        => __('Fancy Gallery'), // Label for the style
//            'style_handle' => 'fancy-quote-css' // Handle for the style's CSS
//        )
//    );
// }
// add_action('init', 'register_custom_block_styles');

// function wpdevs_register_block_styles(){
//     wp_register_style( 'wpdevs-block-style', get_template_directory_uri() . '/block-style.css' );
//     register_block_style(
//         'core/quote',
//         array(
//             'name'  => 'red-quote',
//             'label' => 'Red Quote',
//             'is_default'    => true,
//             //'inline_style'  => '.wp-block-quote.is-style-red-quote { border-left: 7px solid #ff0000; background: #f9f3f3; padding: 10px 20px; }',
//             'style_handle' => 'wpdevs-block-style'
//         )
//     );
// }
// add_action( 'init', 'wpdevs_register_block_styles' );



add_action( 'widgets_init', 'wpdevs_sidebars' );
function wpdevs_sidebars(){
    register_sidebar(
        array(
            'name'  => esc_html__( 'Blog Sidebar', 'wp-devs' ),
            'id'    => 'sidebar-blog',
            'description'   => esc_html__( 'This is the Blog Sidebar. You can add your widgets here.', 'wp-devs' ),
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
    register_sidebar(
        array(
            'name'  => esc_html__( 'Service 1', 'wp-devs' ),
            'id'    => 'services-1',
            'description'   => esc_html__( 'First Service Area', 'wp-devs' ),
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
    register_sidebar(
        array(
            'name'  => esc_html__( 'Service 2', 'wp-devs' ),
            'id'    => 'services-2',
            'description'   => esc_html__( 'Second Service Area', 'wp-devs' ),
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
    register_sidebar(
        array(
            'name'  => esc_html__( 'Service 3', 'wp-devs' ),
            'id'    => 'services-3',
            'description'   => esc_html__( 'Third Service Area', 'wp-devs' ),
            'before_widget' => '<div class="widget-wrapper">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        )
    );
}

if ( ! function_exists( 'wp_body_open' ) ){
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}