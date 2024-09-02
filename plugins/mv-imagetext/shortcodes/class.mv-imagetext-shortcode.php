<?php 


if (! class_exists('MV_ImageText_Shortcode')) {
    class MV_ImageText_Shortcode{

        public function __construct()
        {
            // add_shortcode( $tag:string, $callback:callable )
            add_shortcode( 'mv_imagetext', array($this,  'add_shortcode' ));
        }

        public function add_shortcode($atts = array() , $content = null , $tag = ''){

            // This makes our attributies always recive lowercase letters
            $atts  = array_change_key_case((array)$atts , CASE_LOWER);

            // To do default value for this 
            // or 
            // doesn't pass any at all, we can tell the shortcode how to behave.
            // In our case, we know that the shortcode will receive two attributes: ID, to choose which slide

            // The extract function, what it does is it takes each item from this array
            // and turns it into a variable. So, for example, the id item here would be converted to the variable
            extract(
                shortcode_atts( 
                    array(
                    'id'=> '',
                    'orderby' => 'date'
                 ),
                //  This is the list of attributes passed by the user in the shortcode. If the user passes any
                //  attribute that is not on this list up here, it will be ignored, ok? And the third parameter,
                 $atts,
    
                //  optional this time, is the $tag... this parameter up here, in the add_shortcode... This allows us to
                //   create a specific filter for our shortcode
                $tag
                )
            );

            if (! empty($id)) {

                $id = array_map('absint' , explode(',' , $id));
            }
            
                       
            ob_start();
            require( MV_ImageText_PATH . 'views/mv-imagetext_shortcode.php' );
            wp_enqueue_script( 'mv-imagetext-main-jq' );
            // wp_enqueue_script( 'mv-imagetext-options-js' );
            wp_enqueue_style( 'mv-imagetext-main-css' );
            wp_enqueue_style( 'mv-imagetext-style-css' );
            // mv_slider_options();
            return ob_get_clean();
        }

    }
}