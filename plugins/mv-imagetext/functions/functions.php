<?php
if( ! function_exists( 'mv_imagetext_get_placeholder_image' )){
// if( ! function_exists( 'mv_slider_get_placeholder_image' )){
    function mv_imagetext_get_placeholder_image(){
        return "<img src='" . MV_ImageText_URL . "assets/images/default.jpg' class='img-fluid wp-post-image' />";
    }
}


//TODO reverice div
// if( ! function_exists( 'mv_slider_options' )){
//     function mv_slider_options(){
//         $show_bullets = isset( MV_Slider_Settings::$options['mv_slider_bullets'] ) && MV_Slider_Settings::$options['mv_slider_bullets'] == 1 ? true : false;

//         // wp_register_script( 'mv-slider-options-js', MV_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), MV_SLIDER_VERSION, true );
//         wp_enqueue_script( 'mv-slider-options-js', MV_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), MV_SLIDER_VERSION, true );

//         // wp_localize_script( $handle:string, $object_name:string, $l10n:array )
//         wp_localize_script( 'mv-slider-options-js', 'SLIDER_OPTIONS', array(
//             'controlNav' => $show_bullets
//         ) );
//     }
// }
