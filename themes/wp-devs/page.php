<?php get_header(); ?>
<?php /* do_shortcode( $content:string, $ignore_html:boolean );  */?>
<?php echo do_shortcode("[mv_slider]Slider Dev[/mv_slider] "); ?>

<?php if(header_image()): ?>
    <img src="<?php header_image(); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" alt="" />
<?php endif; ?>


        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="container">
                        <div class="page-item">
                            <?php 
                                while( have_posts() ) : the_post();
                                get_template_part( 'parts/content', 'page' );

                                if( comments_open() || get_comments_number() ){
                                    comments_template();
                                }
                                endwhile;
                            ?>                                
                        </div>
                    </div>
                </main>
            </div>
        </div>
<?php get_footer(); ?>