<?php 

if ( !class_exists('MV_Slider_Post_Type') ){
    class MV_Slider_Post_Type {
        function __construct()
        {
            add_action( 'init', array($this , 'create_post_type'));
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        }
        public function create_post_type(){
              // My Slider Post Type
            // register_post_type('slider', array(
            //     'show_in_rest' => true,
            //     'supports' => array('title', 'editor', 'thumbnail'),
            //     'public' => true,
            //     'labels' => array(
            //     'name' => 'Sliders',
            //     'add_new_item' => 'Add New Slider',
            //     'edit_item' => 'Edit Slider',
            //     'all_items' => 'All Sliders',
            //     'singular_name' => 'Slider'
            //     ),
            //     'menu_icon' => 'dashicons-welcome-learn-more'
            // ));
            register_post_type(
                'mv-slider',
                array(
                    'label' => 'Slider',
                    'description'   => 'Sliders',
                    'labels' => array(
                        'name'  => 'Sliders',
                        'singular_name' => 'Slider'
                    ),
                    'public'    => true,
                    'supports'  => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'  => false,
                    'show_ui'   => true,
                    'show_in_menu'  => true,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export'    => true,
                    'has_archive'   => false,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'  => true,
                    'menu_icon' => 'dashicons-images-alt2',

                    // This is alternitive method for register meta box add_meta_boxes
                  //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' )
                )
            );
        }
        public function add_meta_boxes(){
            // add_meta_box( $id:string, $title:string, $callback:callable, $screen:string|array|WP_Screen|null, $context:string, $priority:string, $callback_args:array|null )
            add_meta_box(
                'mv_slider_meta_box',
                'Link Options',
                array( $this, 'add_inner_meta_boxes' ),
                'mv-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes( $post ){
            require_once(MV_SLIDER_PATH.'views/mv-slider_metabox.php');
        }
    }
}