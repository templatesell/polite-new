<?php
/**
 * Recommended way to include parent theme styles.
 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
 *
 */
/**
 * Loads the child theme textdomain.
 */
function polite_new_load_language() {
    load_child_theme_textdomain( 'polite-new' );
}
add_action( 'after_setup_theme', 'polite_new_load_language' );

/**
 * Enqueue Style for child theme.
 */
add_action( 'wp_enqueue_scripts', 'polite_new_enqueue_scripts');
function polite_new_enqueue_scripts() {

        /*google font  */
    global $polite_theme_options;
    $polite_new_name_font_url   = esc_attr( $polite_theme_options['polite-font-family-url'] );  

    wp_enqueue_style( 'polite-new-fonts', '//fonts.googleapis.com/css2?family='.$polite_new_name_font_url );

    $parent_style = 'polite-style-child';
    $polite_new_version = wp_get_theme(get_template())->get( 'Version' );

    wp_enqueue_style('polite-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'polite-new-style', get_stylesheet_directory_uri() . '/style.css', array(), $polite_new_version );;
}

/**
 * Polite Theme Customizer and overide from child theme
 *
 * @package Polite
 */

if ( !function_exists('polite_default_theme_options_values') ) :

    function polite_default_theme_options_values() {

        $default_theme_options = array(

            /*Logo Options*/
            'polite_logo_width_option' => '500',

            /*Top Header*/
            'polite_enable_top_header'=> 0, 
            'polite_enable_top_header_social'=> 0,
            'polite_enable_top_header_menu'=> 0,

           /*Header Options*/
            'polite_enable_offcanvas'  => 0,
            'polite_enable_search'  => 0,

            /*Menu Options*/
            'polite_mobile_menu_text'  => esc_html__('Menu','polite-new'),
            'polite_mobile_menu_option'=> 'menu-text',

            /*Header Image*/
            'polite_enable_header_image_overlay'=> 0,
            'polite_slider_overlay_color'=> '#000000',
            'polite_slider_overlay_transparent'=> '0.1',
            'polite_header_image_height'=> '100',

            /*Colors Options*/
            'polite_primary_color'              => '#d42929',

            /*Slider Options*/
            'polite_enable_slider'      => 1,
            'polite-select-category'    => 0,
    
            /*Boxes Section */
            'polite_enable_promo'       => 1,
            'polite-promo-select-category'=> 0,
            
            /*Blog Page*/
            'polite-sidebar-blog-page' => 'no-sidebar',
            'polite-column-blog-page'  => 'masonry-post',
            'polite-blog-image-layout' => 'full-image',
            'polite-content-show-from' => 'excerpt',
            'polite-excerpt-length'    => 25,
            'polite-pagination-options'=> 'ajax',
            'polite-read-more-text'    => '',
            'polite-show-hide-share'   => 1,
            'polite-show-hide-category'=> 1,
            'polite-show-hide-date'=> 1,
            'polite-show-hide-author'=> 1,
            'polite-show-hide-read-time'=>1,
            'polite-font-family-url'=>'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap',
            'polite-blog-exclude-category'=> '',

            /*Single Page */
            'polite-single-page-featured-image' => 1,
            'polite-single-page-related-posts'  => 0,
            'polite-single-page-related-posts-title' => esc_html__('Related Posts','polite-new'),
            'polite-sidebar-single-page'=> 'single-right-sidebar',
            'polite-single-social-share' => 1,


            /*Sticky Sidebar*/
            'polite-enable-sticky-sidebar' => 1,

            /*Footer Section*/
            'polite-footer-copyright'  => esc_html__('Copyright All Rights Reserved 2021','polite-new'),

            /*Breadcrumb Options*/
            'polite-extra-breadcrumb' => 1,
            'polite-breadcrumb-selection-option'=> 'theme',

        );
return apply_filters( 'polite_default_theme_options_values', $default_theme_options );
}
endif;

function polite_new_sanitize_select( $input, $setting ) {
    $choices = $setting->manager->get_control( $setting->id )->choices;
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function polite_new_customize_register( $wp_customize ) {

   $default = polite_default_theme_options_values();


    /*Read time Show hide*/
    $wp_customize->add_setting('polite_options[polite-show-hide-read-time]', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => $default['polite-show-hide-read-time'],
        'sanitize_callback' => 'polite_sanitize_checkbox'
    ));

    $wp_customize->add_control('polite_options[polite-show-hide-read-time]', array(
        'label' => __('Show Read Time', 'polite-new'),
        'description' => __('Option to hide the read time on the blog page.', 'polite-new'),
        'section' => 'polite_blog_page_section',
        'settings' => 'polite_options[polite-show-hide-read-time]',
        'type' => 'checkbox',
        'priority' => 15,
    ));
        /*Blog Page Show content from*/
    $wp_customize->add_setting('polite_options[polite-content-show-from]', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
        'default' => $default['polite-content-show-from'],
        'sanitize_callback' => 'polite_sanitize_select'
    ));

    $wp_customize->add_control('polite_options[polite-content-show-from]', array(
        'choices' => array(
            'excerpt' => __('Show from Excerpt', 'polite-new'),
            'content' => __('Show from Content', 'polite-new'),
            'hide'    => __('Hide Content', 'polite-new'),
        ),
        'label' => __('Select Content Display From', 'polite-new'),
        'description' => __('You can enable excerpt from Screen Options inside post section of dashboard', 'polite-new'),
        'section' => 'polite_blog_page_section',
        'settings' => 'polite_options[polite-content-show-from]',
        'type' => 'select',
        'priority' => 15,
    ));

    /*Font Family URL*/
        $wp_customize->add_setting( 'polite_options[polite-font-family-url]', array(
            'capability'        => 'edit_theme_options',
            'transport' => 'refresh',
            'default'           => $default['polite-font-family-url'],
            'sanitize_callback' => 'polite_new_sanitize_select'
        ) );
        $choices = polite_new_google_fonts();
        $wp_customize->add_control( 'polite_options[polite-font-family-url]', array(
            'label'     => __( 'URL of Font Family', 'polite-new' ),
            'description' => sprintf('%1$s <a href="%2$s" target="_blank">%3$s</a> %4$s',
                        __( 'Select the font here. More options are available', 'polite-new' ),
                        esc_url('https://www.templatesell.com/item/polite-plus-masonry-wordpress-theme/'),
                        __('in the premium version Polite Plus' , 'polite-new'),
                        __('check now.' ,'polite-new')
            ),
            'choices'   => $choices,
            'section'   => 'polite_blog_page_section',
            'settings'  => 'polite_options[polite-font-family-url]',
            'type'      => 'select',
            'priority'  => 12,
        ) );


}
add_action( 'customize_register', 'polite_new_customize_register', 999 );


/* Word read count Pagination */
if (!function_exists('polite_new_read_time')) :
    /**
     * @param $content
     *
     * @return string
     */
    function polite_new_read_time()
    {
        $content = apply_filters('the_content', get_post_field('post_content'));
        $read_words = 200;
        $decode_content = html_entity_decode($content);
        $filter_shortcode = do_shortcode($decode_content);
        $strip_tags = wp_strip_all_tags($filter_shortcode, true);
        $count = str_word_count($strip_tags);
        $word_per_min = (absint($count) / $read_words);
        $word_per_min = ceil($word_per_min);

        if (absint($word_per_min) > 0) {
            $word_count_strings = sprintf(_n('%s Min Reading', '%s Min Reading', number_format_i18n($word_per_min), 'polite-new'), number_format_i18n($word_per_min));
            if ('post' == get_post_type()):
                echo '<span class="min-read">';
                echo esc_html($word_count_strings);
                echo '</span>';
            endif;

        }
    }
endif;



/**
 * Google Fonts
 *
 * @param null
 * @return array
 *
 * @since Polite 1.0.0
 *
 */
if (!function_exists('polite_new_google_fonts')) :
    function polite_new_google_fonts()
    {
        $polite_new_google_fonts = array(
            'Mulish:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap' => 'Mulish',
            'Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap' => 'Lato',
            'Open+Sans' => 'Open Sans',
            'Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap' => 'Montserrat',
            'Alegreya:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' => 'Alegreya',
            'Alex+Brush&display=swap' => 'Alex Brush',
            'Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap'=>'Lora'
        );
        return apply_filters('polite_new_google_fonts', $polite_new_google_fonts);
    }
endif;


/**
 * Enqueue the list of fonts.
 */
function polite_new_customizer_fonts()
{
    wp_enqueue_style('polite_new_customizer_fonts', 'https://fonts.googleapis.com/css?family=Mulish|Lato|Open+Sans| Montserrat|Alegreya|Lora', array(), null);
}

add_action('customize_controls_print_styles', 'polite_new_customizer_fonts');
add_action('customize_preview_init', 'polite_new_customizer_fonts');

add_action(
    'customize_controls_print_styles',
    function (){
        ?>
        <style>
            <?php
            $arr = array( 'Mulish','Lato','Open+Sans',' Montserrat','Alegreya', 'Lora');

            foreach ( $arr as $font ) {
                $font_family = str_replace("+", " ", $font);
                echo '.customize-control select option[value*="' . $font . '"] {font-family: ' . $font_family . '; font-size: 22px;}';
            }
            ?>
        </style>
        <?php
    }
);



if (!function_exists('polite_new_dynamic_css')) :

    function polite_new_dynamic_css()
    {
        global $polite_theme_options;
        $polite_new_google_fonts = polite_new_google_fonts(); 
        $polite_font_family = $polite_theme_options['polite-font-family-url'];       
        /* Paragraph Font Options */
        $polite_font_body_family = esc_attr($polite_new_google_fonts[$polite_font_family] );

        $custom_css = '';
        //Paragraph Font Options 
        if (!empty($polite_font_body_family)) {
            $custom_css .= "
            body,
            .entry-content p{ 
                font-family:".$polite_font_body_family."; 
                font-weight:normal;
            }";
        }

        wp_add_inline_style('polite-style', $custom_css);
    }
endif;
add_action('wp_enqueue_scripts', 'polite_new_dynamic_css', 99);