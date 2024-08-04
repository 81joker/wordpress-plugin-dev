<?php 

if( ! class_exists( 'MV_Slider_Settings' )){
    class MV_Slider_Settings{

        public static $options;

        public function __construct(){
            self::$options = get_option( 'mv_slider_options' );
            // var_dump( self::$options);
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        public function admin_init(){
            // To save the slider sittings database
            // register_setting( $option_group:string, $option_name:string, $args:array )
            /*
                    `register_setting()` هي إحدى دوال WordPress المستخدمة لتسجيل إعدادات (settings) جديدة في قاعدة بيانات موقع WordPress.

                        يتم استخدامها بشكل شائع في إضافات (plugins) وقوالب (themes) لتسجيل مجموعة من الإعدادات والخيارات التي يمكن للمستخدم تخصيصها من لوحة التحكم.

                        في هذا المثال الخاص:

                        1. `'mv_slider_group'`: هذا هو اسم المجموعة التي ستُسجل فيها الإعدادات. يمكن استخدام أي اسم مناسب هنا.

                        2. `'mv_slider_options'`: هذا هو اسم الخيار (option) الذي سيتم تسجيله في قاعدة بيانات WordPress. يمكن استخدام أي اسم مناسب هنا.

                        3. `array( $this, 'mv_slider_validate' )`: هذا هو الخيار الثالث والذي يتضمن وظيفة التحقق (validation function) التي سيتم استدعاؤها عند حفظ الإعدادات.
                         في هذه الحالة، الوظيفة `mv_slider_validate()` سيتم استدعاؤها لتحقق من صحة قيم الإعدادات قبل حفظها في قاعدة البيانات.

                        بشكل عام، `register_setting()` تُستخدم لتسجيل مجموعة من الإعدادات في موقع WordPress والتي يمكن للمستخدم الوصول إليها وتخصيصها من لوحة التحكم. كما أنها تسمح بتحقق من صحة الإعدادات قبل حفظها في قاعدة البيانات.

            */
            register_setting('mv_slider_group' , 'mv_slider_options' , array( $this, 'mv_slider_validate' ) );


            add_settings_section(
                'mv_slider_main_section',
                'How does it work?',
                null,
                'mv_slider_page1'
            );

            add_settings_section(
                'mv_slider_second_section',
                'Other Plugin Options',
                null,
                'mv_slider_page2'
            );

            add_settings_field(
                'mv_slider_shortcode',
                'Shortcode',
                array( $this, 'mv_slider_shortcode_callback' ),
                'mv_slider_page1',
                'mv_slider_main_section'
            );
            add_settings_field(
                'mv_slider_title',
                'Slider Title',
                array( $this, 'mv_slider_title_callback' ),
                'mv_slider_page2',
                'mv_slider_second_section',
                array(
                    'label_for' => 'mv_slider_title'
                )
            );

            add_settings_field(
                'mv_slider_bullets',
                'Display Bullets',
                array( $this, 'mv_slider_bullets_callback' ),
                'mv_slider_page2',
                'mv_slider_second_section',
                array(
                    'label_for' => 'mv_slider_bullets'
                )
            );

            add_settings_field(
                'mv_slider_style',
                'Slider Style',
                array( $this, 'mv_slider_style_callback' ),
                'mv_slider_page2',
                'mv_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'mv_slider_style'
                )
            );

        }

        public function mv_slider_shortcode_callback(  $args ){
            ?>
            <span>Use the shortcode [mv_slider] to display the slider in any page/post/widget</span>
            <?php
        }

        public function mv_slider_title_callback(){
            ?>
                <input 
                type="text" 
                name="mv_slider_options[mv_slider_title]" 
                id="mv_slider_title"
                value="<?php echo isset( self::$options['mv_slider_title'] ) ? esc_attr( self::$options['mv_slider_title'] ) : ''; ?>"
                >
            <?php
        }
        
        public function mv_slider_bullets_callback( $args ){
            ?>
                <input 
                    type="checkbox"
                    name="mv_slider_options[mv_slider_bullets]"
                    id="mv_slider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['mv_slider_bullets'] ) ){
                            checked( "1", self::$options['mv_slider_bullets'], true );
                        }    
                    ?>
                />
                <label for="mv_slider_bullets">Whether to display bullets or not</label>
                
            <?php
        }

        public function mv_slider_style_callback( $args ){
            ?>
            <select 
                id="mv_slider_style" 
                name="mv_slider_options[mv_slider_style]">
                <?php 
                foreach( $args['items'] as $item ):
                ?>
                    <option value="<?php echo esc_attr( $item ); ?>" 
                        <?php 
                        isset( self::$options['mv_slider_style'] ) ? selected( $item, self::$options['mv_slider_style'], true ) : ''; 
                        ?>
                    >
                        <?php echo esc_html( ucfirst( $item ) ); ?>
                    </option>                
                <?php endforeach; ?>
            </select>
            <?php
        }

        public function mv_slider_validate( $input ){
            $new_input = array();
            // foreach( $input as $key => $value ){
            //     $new_input[$key] = sanitize_text_field( $value );
            // }
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'mv_slider_title':
                        if( empty( $value )){
                            add_settings_error( 'mv_slider_options', 'mv_slider_message', 'The title field can not be left empty', 'error' );
                            $value = 'Please, type some text';
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    // case 'mv_slider_int':
                    //     $new_input[$key] = absint( $value );
                    // break;
                    // case 'mv_slider_url':
                    //     $new_input[$key] = esc_url( $value );
                    // break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }
        
    }
}

