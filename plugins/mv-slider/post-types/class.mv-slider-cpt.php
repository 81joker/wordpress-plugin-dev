<?php 

if ( !class_exists('MV_Slider_Post_Type') ){
    class MV_Slider_Post_Type {
        function __construct()
        {
            add_action( 'init', array($this , 'create_post_type'));
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            // To save data from metabox
            add_action( 'save_post', array($this , 'save_post') ,$priority = 10  , $accepted_args = 2 );
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
            require_once( MV_SLIDER_PATH . 'views/mv-slider_metabox.php' );
        }

        public function save_post( $post_id ){
            if( isset( $_POST['mv_slider_nonce'] ) ){
                if( ! wp_verify_nonce( $_POST['mv_slider_nonce'], 'mv_slider_nonce' ) ){
                    return;
                }
            }

            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'mv-slider' ){
                if( ! current_user_can( 'edit_page', $post_id ) ){
                    return;
                }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
                $old_link_text = get_post_meta( $post_id, 'mv_slider_link_text', true );
                $new_link_text = $_POST['mv_slider_link_text'];
                $old_link_url = get_post_meta( $post_id, 'mv_slider_link_url', true );
                $new_link_url = $_POST['mv_slider_link_url'];

                if( empty( $new_link_text )){
                    update_post_meta( $post_id, 'mv_slider_link_text', 'Add some text' );
                }else{
                    update_post_meta( $post_id, 'mv_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                }

                if( empty( $new_link_url )){
                    update_post_meta( $post_id, 'mv_slider_link_url', '#' );
                }else{
                    update_post_meta( $post_id, 'mv_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                }
                
                
            }
        }
    }
}