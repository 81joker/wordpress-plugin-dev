<?php 

if ( !class_exists('MV_Slider_Post_Type') ){
    class MV_Slider_Post_Type {
        function __construct()
        {
            add_action( 'init', array($this , 'create_post_type'));
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            // To save data from metabox
            add_action( 'save_post', array($this , 'save_post') ,$priority = 10  , $accepted_args = 2 );
            // Customizing Admin Columns
            add_filter( 'manage_mv-slider_posts_columns', array( $this, 'mv_slider_cpt_columns' ) );
            // Query metadata slider in columns
            add_action( 'manage_mv-slider_posts_custom_column', array( $this, 'mv_slider_custom_columns'), 10, 2 );
            // Table sortable columns for a specific screen.
            add_filter( 'manage_edit-mv-slider_sortable_columns', array( $this, 'mv_slider_sortable_columns' ) );


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
                    'label' => esc_html__( 'Slider', 'mv-slider' ),
                    'description'   => esc_html__( 'Sliders', 'mv-slider' ),
                    'labels' => array(
                        'name'  => esc_html__( 'Sliders', 'mv-slider' ),
                        'singular_name' => esc_html__( 'Slider', 'mv-slider' ),
                    ),
                    'public'    => true,
                    'supports'  => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'  => false,
                    'show_ui'   => true,
                    'show_in_menu'  => false,
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

        // Customizing Admin Columns
        public function mv_slider_cpt_columns( $columns ){
            $columns['mv_slider_link_text'] = esc_html__( 'Link Text', 'mv-slider' );
            $columns['mv_slider_link_url'] = esc_html__( 'Link URL', 'mv-slider' );
            return $columns;
        }
         // Query metadata slider in columns
        public function mv_slider_custom_columns( $column, $post_id ){
            switch( $column ){
                case 'mv_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'mv_slider_link_text', true ) );
                break;
                case 'mv_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'mv_slider_link_url', true ) );
                break;                
            }
        }

        // Table sortable columns for a specific screen.
        public function mv_slider_sortable_columns( $columns ){
            $columns['mv_slider_link_text'] = 'mv_slider_link_text';
            return $columns;
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