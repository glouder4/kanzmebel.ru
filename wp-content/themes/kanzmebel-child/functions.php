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
//Отключили лишнее

//Добавляем новое

//Настройки темы

add_action( 'customize_register', 'kanzmebel_theme_customize_register' );
function kanzmebel_theme_customize_register( $wp_customize ) {
    // Здесь делаем что-либо с $wp_customize - объектом класса WP_Customize_Manager, например

    //Свойства сайта title_tagline
    $wp_customize->remove_setting('custom_logo');
    $wp_customize->add_setting( 'main_logo' );
    $wp_customize->add_setting( 'mobile_logo' );
    $wp_customize->add_control(
        new WP_Customize_Upload_Control(
            $wp_customize,
            'main_logo_control',
            array(
                'label'    => 'Основной логотип',
                'settings' => 'main_logo',
                'section'  => 'title_tagline'
            )
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Upload_Control(
            $wp_customize,
            'mobile_logo_control',
            array(
                'label'    => 'Мобильный логотип',
                'settings' => 'mobile_logo',
                'section'  => 'title_tagline'
            )
        )
    );


    /*$theme_settings->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'true_logo_control',
            array(
                'label'    => 'Мобильный логотип сайта',
                'settings' => 'mobile_logo',
                'section'  => 'true_header_section'
            )
        )
    );*/

    // Действия с панелями
    /*$wp_customize->add_panel();     // добавить панель
    $wp_customize->get_panel();     // получить панель
    $wp_customize->remove_panel();  // удалить панель

    // Действия с секциями
    $wp_customize->add_section();    // добавить секцию
    $wp_customize->get_section();    // получить секцию
    $wp_customize->remove_section(); // удалить секцию

    // Действия с настройками
    $wp_customize->add_setting();    // добавить настройку
    $wp_customize->get_setting();    // получить настройку
    $wp_customize->remove_setting(); // удалить настройку

    // Действия с элементами управления
    $wp_customize->add_control();    // добавить элемент управления
    $wp_customize->get_control();    // получить элемент управления
    $wp_customize->remove_control(); // удалить элемент управления*/
}

if( function_exists('acf_add_options_page') ) {
    $args = array(
        'page_title' => 'Настройки темы', //Заголовок страницы
        'menu_title' => 'Настройки темы', //Заголовок в меню
        'menu_slug' => 'theme-options', //Адрес страницы
        'capability' => 'edit_posts', //Кто может редактировать
    );
    acf_add_options_page($args);
}
//Настройки шаблона
add_filter('woocommerce_currency_symbol', 'kanzmebel_theme_settings', 9999, 2);

function kanzmebel_theme_settings( $valyuta_symbol, $valyuta_code ) {
    if( $valyuta_code === 'RUB' ) {
        return 'р.';
    }
    return $valyuta_symbol;
}

function theme_kazmebel_header_metadata() {
    //session_start();
    $token = bin2hex(random_bytes(16));

    if( isset($_SESSION['csrf_token']) ){
        foreach ($_SESSION as $key => $item){
            unset($_SESSION[$key]);
        }
    }

    $_SESSION['csrf_token'] = $token;
    $_SESSION["token-expire"] = time() + 3600; // 1 hour = 3600 secs
    ?>
        <meta name="csrf-token" content="<?=$_SESSION['csrf_token'];?>">
    <?php
}
add_action( 'wp_head', 'theme_kazmebel_header_metadata' );

function kanzmebel_scripts(){
    if( !is_admin() ) {
        //wp_enqueue_script( 'jquery.min', get_stylesheet_directory_uri() . '/js/jquery-3.7.1.min.js' );
        wp_enqueue_script('popper.min', get_stylesheet_directory_uri() . '/js/popper.min.js');
        wp_enqueue_script('bootstrap-5', get_stylesheet_directory_uri() . '/js/bootstrap/bootstrap.js');
        wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/js/fancybox.js');
        wp_enqueue_script('general', get_stylesheet_directory_uri() . '/js/general.js', array('fancybox'));


        wp_enqueue_style('bootstrap-5', get_stylesheet_directory_uri() . '/css/bootstrap/bootstrap.css');
        wp_enqueue_style('general', get_stylesheet_directory_uri() . '/css/general.css', array('bootstrap-5'));
        wp_enqueue_style('main_header', get_stylesheet_directory_uri() . '/css/main_header.css', array('general'));
        wp_enqueue_style('main_footer', get_stylesheet_directory_uri() . '/css/main_footer.css', array('general'));

        wp_enqueue_style('fancybox', get_stylesheet_directory_uri() . '/css/fancybox.css');

        // Главная страница
        if (is_page(17)) {
            wp_enqueue_style('main_page', get_stylesheet_directory_uri() . '/css/main_page.css', array('general'));
            wp_enqueue_style('adaptive_slider', get_stylesheet_directory_uri() . '/css/adaptive_slider.css', array('main_page'));
            wp_enqueue_style('shop_page', get_stylesheet_directory_uri() . '/css/shop_page.css', array('general'));
            wp_enqueue_style('shop_page-wc', get_stylesheet_directory_uri() . '/css/shop-page-wc.css', array('shop_page'));

            wp_enqueue_script('adaptive_slider', get_stylesheet_directory_uri() . '/js/adaptive_slider.js');
            wp_enqueue_script('mainpage-index', get_stylesheet_directory_uri() . '/js/mainpage-index.js');
        } else if (is_shop()) {
            wp_enqueue_style('shop_page', get_stylesheet_directory_uri() . '/css/shop_page.css', array('general'));
            wp_enqueue_style('shop_page-wc', get_stylesheet_directory_uri() . '/css/shop-page-wc.css', array('shop_page'));

            wp_enqueue_script('shop-index', get_stylesheet_directory_uri() . '/js/shop-index.js');
        } else if (is_product_category()) {
            wp_enqueue_style('shop_page', get_stylesheet_directory_uri() . '/css/shop_page.css', array('general'));
            wp_enqueue_style('shop_page-wc', get_stylesheet_directory_uri() . '/css/shop-page-wc.css', array('shop_page'));
            wp_enqueue_style('shop_cat', get_stylesheet_directory_uri() . '/css/shop-cat.css', array('general', 'shop_page'));

            wp_enqueue_script('shop-index', get_stylesheet_directory_uri() . '/js/shop-index.js');
        } else if (is_product()) {
            wp_enqueue_style('adaptive_slider', get_stylesheet_directory_uri() . '/css/adaptive_slider.css', array());
            wp_enqueue_style('shop_page', get_stylesheet_directory_uri() . '/css/shop_page.css', array('general'));
            wp_enqueue_style('shop_product_page', get_stylesheet_directory_uri() . '/css/shop-product-page.css', array('general'));

            wp_enqueue_script('adaptive_slider', get_stylesheet_directory_uri() . '/js/adaptive_slider.js');
            wp_enqueue_script('product-index', get_stylesheet_directory_uri() . '/js/product-index.js');
        }
        else if(is_cart()){
            wp_enqueue_style('cart_page', get_stylesheet_directory_uri() . '/css/cart_page.css', array());
        }
        else if(is_checkout()){
            wp_enqueue_style('checkout_page', get_stylesheet_directory_uri() . '/css/checkout_page.css', array());
        }
        else if (is_page()) {
            wp_enqueue_style('another_page', get_stylesheet_directory_uri() . '/css/another_page.css', array());
        }
        else if(is_single()){
            wp_enqueue_style('single_page', get_stylesheet_directory_uri() . '/css/single-page.css', array());
        }
    }
}
add_action( 'wp_enqueue_scripts', 'kanzmebel_scripts',25 );


/*add_filter( 'style_loader_tag',  'preload_filter', 10, 2 );
function preload_filter( $html, $handle ){
    if (strcmp($handle, 'bootstrap-5') == 0) {
        $html = str_replace("rel='stylesheet'", "rel='preload' as='style' ", $html);
    }
    return $html;
}*/

add_filter("script_loader_tag", "add_module_to_my_script", 10, 3);
function add_module_to_my_script($tag, $handle, $src)
{
    if ("mainpage-index" === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    if ("shop-index" === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }

    return $tag;
}

function woocommerce_template_loop_product_link_open(){
    global $product;
    echo '<a href="'.get_permalink($product->get_id()).'" title="'.$product->get_title().'" itemprop="url">';
}
function woocommerce_template_loop_product_title() {
    global $product;

    echo '<h2 itemprop="name" class="product_name ' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . $product->get_title() . '</h2>';
}

function woocommerce_loop_body_data_action(){
    global $product;
    $height = $product->get_height();
    $width = $product->get_width() ;
    $length = $product->get_length();

    echo '<p class="product_dimensions">'.$length.'x'.$width.'x'.$height.'мм </p>';
}
add_action( 'woocommerce_loop_body_data', 'woocommerce_loop_body_data_action' );

function woocommerce_template_loop_price(){
    global $product;

    echo '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer"> <span itemprop="price" class="product_price">'.wc_price($product->get_price(),array()).'</span><meta itemprop="priceCurrency" content="RUB" /><link itemprop="availability" href="https://schema.org/InStock" /></div>';
}


add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_price_range_query_var', 10, 2 );
function handle_price_range_query_var( $query, $query_vars ) {
    return $query;
}

function woocommerce_pre_get_posts( $q ){
    //if( isset($q->queried_object) && isset($q->queried_object->ID) && $q->queried_object->ID == 39 ){
    if ( is_shop()) {
        //print_r($q);
    }

    return $q;
}
add_action('pre_get_posts','woocommerce_pre_get_posts');

function custom_modify_args($args = array()){
    $post = file_get_contents('php://input');
    if( isset($post) && !is_null($post) ){
        $post = json_decode($post,true);
    }

    $action = null;

    if( isset($_GET['action']) ){

        $action = $_GET['action'];
    }
    else if( isset($_POST['action']) ){
        $action = $_POST['action'];
    }
    else if( isset($post['action']) ){
        $action = $post['action'];
    }

    $taxonomies = null;

    if (is_product_category()){
        global $wp_query;
        $taxonomies = array($wp_query->get_queried_object()->term_id);
    }
    else{
        if( isset($_GET['taxonomies']) ){

            $taxonomies = explode('_',$_GET['taxonomies']);
        }
        else if( isset($_POST['taxonomies']) ){
            $taxonomies = explode('_',$_POST['taxonomies']);
        }
        else if( isset($post['taxonomies']) && $post['taxonomies'] != "" ){
            $taxonomies = explode('_',$post['taxonomies']);
        }
    }


    $price_range = null;

    if( ! empty( $_GET['price_range'] ) ){
        $price_range = explode('|',$_GET['price_range']);
    }
    else if( ! empty( $_POST['price_range'] ) ){
        $price_range = explode('|',$_POST['price_range']);
    }
    else if( ! empty( $post['price_range'] ) ){
        $price_range = explode('|',$post['price_range']);
    }

    $page = 0;

    if( ! empty( $_GET['page'] ) ){
        $page = $_GET['page'];
    }
    else if( ! empty( $_POST['page'] ) ){
        $page = $_POST['page'];
    }
    else if( ! empty( $post['page'] ) ){
        $page = $post['page'];
    }

    $products_per_page  = apply_filters('loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page());

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $products_per_page,
        'offset' => $page*$products_per_page,
        'current_page' => ($page+1),
        'total_pages' => null,
        'action' => $action
    );
    if( !empty($taxonomies) && count($taxonomies) > 0 ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $taxonomies,
                'operator' => 'IN',
            )
        );
    }
    if( !is_null($price_range) ){
        $args['meta_query'] = array(
            array(
                'key' => '_price',
                'value' => $price_range,
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        );
    }

    if (is_product_category()){
        global $wp_query;

        $args['parent_category'] = $wp_query->get_queried_object()->term_id;
    }

    $product_post_objects = get_posts($args);

    $ids = array_map(function($e) {
        return $e->ID;
    }, $product_post_objects);

    $args['include_product_ids'] = $ids;
    $args['total_pages'] = ceil(count($ids)/$args['posts_per_page']);

    return $args;
}


add_filter( 'woocommerce_product_additional_information_heading', 'kanzmebel_rename_description_tab' );
add_filter( 'woocommerce_product_related_products_heading', 'kanzmebel_rename_description_tab' );
function kanzmebel_rename_description_tab( $title ) {
    if( $title == 'Детали' ){
        $title = 'Характеристики';
    }
    if( $title == 'Похожие товары' ){
        $title = 'Смотрите также';
    }
    return $title;

}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function kanzmebel_get_related_products_action(){
    global $product;
    if( ! is_a( $product, 'WC_Product' ) ){
        $product = wc_get_product(get_the_id());
    }
    woocommerce_related_products( array(
        'posts_per_page' => 4,
        'columns'        => 4,
        'orderby'        => 'rand'
    ) );
}
add_action('kanzmebel_get_related_products','kanzmebel_get_related_products_action');


add_action( 'after_setup_theme', 'remove_default_menu', 11 );

// This theme uses wp_nav_menu() in two locations.
register_nav_menus(
    array(
        'main-menu' => __( 'Основное меню', 'twentynineteen' ),
        //'footer-menu' => __( 'Меню в футере', 'twentynineteen' ),
        'social' => __( 'Social Links Menu', 'twentynineteen' ),
        //'mobile-menu' => __( 'Мобильное меню', 'twentynineteen' ),
    )
);
function remove_default_menu(){
    unregister_nav_menu('menu-1');
    unregister_nav_menu('footer');
    unregister_nav_menu('social');
}


function add_additional_class_on_li($classes, $item, $args) {
    if( in_array('menu-item-has-children',$classes) ){
        $classes[] = 'dropdown';
    }

    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }

    if( $item->menu_item_parent > 0 ) {
        $classes[] = 'dropdown-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

add_filter( 'nav_menu_link_attributes', 'nav_menu_link_class', 10, 2 );
function nav_menu_link_class( $atts, $item ) {
    /*if( !$item->has_children && $item->menu_item_parent > 0 ) {
        $class         = 'has-ripple';
        $atts['class'] = $class;
    }*/
    if( !$item->has_children && $item->menu_item_parent > 0 ) {
        $class = 'dropdown-item';
        $atts['class'] = $class;
    }
    if( in_array('menu-item-has-children',$item->classes) ){
        $atts['class'] = 'dropdown-toggle';
        $atts['role'] = 'button';
        $atts['data-bs-toggle'] = 'dropdown';
        $atts['aria-expanded'] = 'false';
    }
    /*if( $item->ID == 162 ){
        print_r($item);
        die();
    }*/

    return $atts;
}
add_filter( 'nav_menu_submenu_css_class', 'wp_kama_nav_menu_submenu_css_class_filter', 10, 3 );

function wp_kama_nav_menu_submenu_css_class_filter( $classes, $args, $depth ){
    $classes[] = 'dropdown-menu';
    return $classes;
    // filter...
    return $classes;
}
add_filter( 'use_block_editor_for_post_type', '__return_false' );

add_filter( 'woocommerce_checkout_fields', 'truemisha_del_fields', 25 );

function truemisha_del_fields( $fields ) {

    // оставляем эти поля
    // unset( $fields[ 'billing' ][ 'billing_first_name' ] ); // имя
    // unset( $fields[ 'billing' ][ 'billing_last_name' ] ); // фамилия
    // unset( $fields[ 'billing' ][ 'billing_phone' ] ); // телефон
    // unset( $fields[ 'billing' ][ 'billing_email' ] ); // емайл
    //$fields[ 'billing' ][ 'billing_address_1' ]['placeholder'] = 'Адрес доставки';

    // удаляем все эти поля
    unset( $fields[ 'billing' ][ 'billing_company' ] ); // компания
    //unset( $fields[ 'billing' ][ 'billing_country' ] ); // страна
    //unset( $fields[ 'billing' ][ 'billing_address_1' ] ); // адрес 1
    unset( $fields[ 'billing' ][ 'billing_address_2' ] ); // адрес 2
    //unset( $fields[ 'billing' ][ 'billing_city' ] ); // город
    unset( $fields[ 'billing' ][ 'billing_state' ] ); // регион, штат
    unset( $fields[ 'billing' ][ 'billing_postcode' ] ); // почтовый индекс
    unset( $fields[ 'order' ][ 'order_comments' ] ); // заметки к заказу

    return $fields;

}