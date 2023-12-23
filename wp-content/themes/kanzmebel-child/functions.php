<?php
remove_theme_support( 'automatic-feed-links' );
remove_theme_support( 'html5' );
remove_theme_support( 'customize-selective-refresh-widgets' );
remove_theme_support( 'wp-block-styles' );
remove_theme_support( 'align-wide' );
remove_theme_support( 'editor-styles' );
remove_theme_support( 'style-editor.css' );
remove_theme_support( 'editor-font-sizes' );
remove_theme_support( 'editor-color-palette' );
remove_theme_support( 'responsive-embeds' );
remove_theme_support( 'custom-line-height' );

if(function_exists('twentynineteen_widgets_init')){
    function twentynineteen_widgets_init(){
        return ;
    }
}
if( function_exists('twentynineteen_excerpt_more') ){
    function twentynineteen_excerpt_more( $link ) {
        return;
    }
}
if( function_exists('twentynineteen_content_width') ) {
    function twentynineteen_content_width()
    {
        return;
    }
}

if( function_exists('twentynineteen_scripts') ) {
    function twentynineteen_scripts()
    {
        return '';
    }
}
if( function_exists('twentynineteen_skip_link_focus_fix') ) {
    function twentynineteen_skip_link_focus_fix()
    {
        return;
    }
}
if( function_exists('twentynineteen_editor_customizer_styles') ) {
    function twentynineteen_editor_customizer_styles()
    {
        return;
    }
}
if( function_exists('twentynineteen_colors_css_wrap') ) {
    function twentynineteen_colors_css_wrap()
    {
        return;
    }
}

wp_deregister_script('wp-emoji-release.min.js');

remove_action('wp_head', 'rest_output_link_wp_head', 10);

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version


function ny_disable_feed() {
    wp_redirect( get_option( 'siteurl' ), 301 );
}
add_action( 'do_feed', 'ny_disable_feed', 1 );
add_action( 'do_feed_rdf', 'ny_disable_feed', 1 );
add_action( 'do_feed_rss', 'ny_disable_feed', 1 );
add_action( 'do_feed_rss2', 'ny_disable_feed', 1 );
add_action( 'do_feed_atom', 'ny_disable_feed', 1 );
function ny_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'ny_remove_recent_comments_style' );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
function ny_remove_x_pingback( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
}
add_filter( 'wp_headers', 'ny_remove_x_pingback' );
header_remove( 'x-powered-by' );

function disable_emoji_feature() {

    // Prevent Emoji from loading on the front-end
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    // Remove from admin area also
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    // Remove from RSS feeds also
    remove_filter( 'the_content_feed', 'wp_staticize_emoji');
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji');

    // Remove from Embeds
    remove_filter( 'embed_head', 'print_emoji_detection_script' );

    // Remove from emails
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    // Disable from TinyMCE editor. Currently disabled in block editor by default
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );

    /** Finally, prevent character conversion too
     ** without this, emojis still work
     ** if it is available on the user's device
     */

    add_filter( 'option_use_smilies', '__return_false' );

}

function disable_emojis_tinymce( $plugins ) {
    if( is_array($plugins) ) {
        $plugins = array_diff( $plugins, array( 'wpemoji' ) );
    }
    return $plugins;
}

add_action('init', 'disable_emoji_feature');

function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
    wp_dequeue_style('twentynineteen-style');
    wp_deregister_style('global-styles-inline');
    wp_dequeue_style('twentynineteen-print-style');
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

add_action( 'wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 20 );
function mywptheme_child_deregister_styles() {
    wp_dequeue_style( 'classic-theme-styles' );
}

remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

function kanzmebel_scripts(){
    return '';
}
add_action( 'wp_enqueue_scripts', 'kanzmebel_scripts' );