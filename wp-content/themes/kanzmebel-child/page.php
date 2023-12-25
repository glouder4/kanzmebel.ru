<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
?>

<?php
        if(is_shop()){
            $post = file_get_contents('php://input');
            if( isset($post) && !is_null($post) ){
                $post = json_decode($post,true);
            }

            //Здесь точно работает фильтр по категориям
            $taxonomies = null;
            if( isset($_GET['taxonomies']) ){

                $taxonomies = explode('_',$_GET['taxonomies']);
            }
            else if( isset($_POST['taxonomies']) ){
                $taxonomies = explode('_',$_POST['taxonomies']);
            }
            else if( isset($post['taxonomies']) && $post['taxonomies'] != "" && count($post['taxonomies']) > 0 ){
                $taxonomies = explode('_',$post['taxonomies']);
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

            /*$args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $taxonomies,
                        'operator' => 'IN',
                    )
                ),
                'meta_query' => array(
                    array(
                        'key' => '_price',
                        'value' => array(200000, 300000),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    )
                )
            );*/

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
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


            $products = get_posts( $args );
            //print_r(count($products));

            ?>
            <div id="shop-catalog" class="catalog shop-catalog shop_page">
                <div class="container">
                    <div class="section-title">
                        <h1 class="title">Каталог</h1>

                        <div class="d-none d-lg-flex catalog_filters-btn m-0">
                            <svg width="11" height="18" viewBox="0 0 11 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_25_2134)">
                                    <path d="M2.38499 4.47713V0.625916H1.34436V4.47713C0.957086 4.59006 0.616893 4.82553 0.374845 5.14819C0.132797 5.47085 0.00195313 5.86329 0.00195312 6.26662C0.00195313 6.66994 0.132797 7.06239 0.374845 7.38505C0.616893 7.70771 0.957086 7.94317 1.34436 8.05611V17.8341H2.38499V8.05611C2.77227 7.94317 3.11246 7.70771 3.35451 7.38505C3.59656 7.06239 3.7274 6.66994 3.7274 6.26662C3.7274 5.86329 3.59656 5.47085 3.35451 5.14819C3.11246 4.82553 2.77227 4.59006 2.38499 4.47713Z" fill="#555049"/>
                                    <path d="M10.9998 12.1934C10.9997 11.7899 10.8686 11.3973 10.6262 11.0746C10.3838 10.7519 10.0432 10.5166 9.65562 10.4039V0.625916H8.61499V10.4039C8.22772 10.5169 7.88752 10.7523 7.64547 11.075C7.40343 11.3977 7.27258 11.7901 7.27258 12.1934C7.27258 12.5968 7.40343 12.9892 7.64547 13.3119C7.88752 13.6345 8.22772 13.87 8.61499 13.9829V17.8341H9.65562V13.9829C10.0432 13.8703 10.3838 13.635 10.6262 13.3123C10.8686 12.9896 10.9997 12.597 10.9998 12.1934Z" fill="#555049"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_25_2134">
                                        <rect width="11" height="17.34" fill="white" transform="translate(0 0.559998)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            Фильтры
                        </div>
                    </div>
                    <div class="section_data">
                        <div id="catalog_filters-btn" class="catalog_filters-btn d-lg-none w-100">
                            <svg width="11" height="18" viewBox="0 0 11 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_25_2134)">
                                    <path d="M2.38499 4.47713V0.625916H1.34436V4.47713C0.957086 4.59006 0.616893 4.82553 0.374845 5.14819C0.132797 5.47085 0.00195313 5.86329 0.00195312 6.26662C0.00195313 6.66994 0.132797 7.06239 0.374845 7.38505C0.616893 7.70771 0.957086 7.94317 1.34436 8.05611V17.8341H2.38499V8.05611C2.77227 7.94317 3.11246 7.70771 3.35451 7.38505C3.59656 7.06239 3.7274 6.66994 3.7274 6.26662C3.7274 5.86329 3.59656 5.47085 3.35451 5.14819C3.11246 4.82553 2.77227 4.59006 2.38499 4.47713Z" fill="#555049"/>
                                    <path d="M10.9998 12.1934C10.9997 11.7899 10.8686 11.3973 10.6262 11.0746C10.3838 10.7519 10.0432 10.5166 9.65562 10.4039V0.625916H8.61499V10.4039C8.22772 10.5169 7.88752 10.7523 7.64547 11.075C7.40343 11.3977 7.27258 11.7901 7.27258 12.1934C7.27258 12.5968 7.40343 12.9892 7.64547 13.3119C7.88752 13.6345 8.22772 13.87 8.61499 13.9829V17.8341H9.65562V13.9829C10.0432 13.8703 10.3838 13.635 10.6262 13.3123C10.8686 12.9896 10.9997 12.597 10.9998 12.1934Z" fill="#555049"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_25_2134">
                                        <rect width="11" height="17.34" fill="white" transform="translate(0 0.559998)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            Фильтры
                        </div>

                        <div id="catalog_filters" class="">
                            <form action="" id="filters_form">
                                <div id="catalog_filters-close" class="close w-100 d-flex justify-content-start">
                                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="40" height="40" fill="#FFF9F9"/>
                                        <rect x="12.22" y="9.81" width="23.9992" height="1.99405" transform="rotate(45 12.22 9.81)" fill="#555049"/>
                                        <rect x="10.8101" y="26.78" width="23.9992" height="1.99405" transform="rotate(-45 10.8101 26.78)" fill="#555049"/>
                                    </svg>
                                </div>
                                <div id="categories">
                                    <span class="h5">Категории</span>
                                    <?php
                                    $categories = get_categories( [
                                        'taxonomy'     => 'product_cat',
                                        'type'         => 'post',
                                        'child_of'     => 0,
                                        'parent'       => '',
                                        'orderby'      => 'name',
                                        'order'        => 'ASC',
                                        'hide_empty'   => 1,
                                        'hierarchical' => 1,
                                        'exclude'      => '',
                                        'include'      => '',
                                        'pad_counts'   => false,
                                        // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
                                    ] );

                                    if( $categories ) {
                                        ?>
                                        <ul class="mt-3">
                                            <?php
                                            foreach ($categories as $cat) { ?>

                                                <li class="category-item" data-id="<?=$cat->term_id;?>">
                                                    <input type="checkbox" class="taxonomy" name="taxonomy-<?=$cat->term_id;?>" data-id="<?=$cat->slug;?>"/> <?=$cat->name;?>
                                                </li>

                                            <?php    }
                                            ?>
                                        </ul>
                                    <?php }
                                    ?>
                                </div>

                                <?php

                                    $min_price = 0;
                                    $max_price = 1000;
                                    if(!empty($products)){
                                        $min_price = wc_get_product($products[0]->ID)->get_price();
                                        $max_price = wc_get_product($products[count($products)-1])->get_price();
                                        if( $min_price == $max_price ){
                                            $min_price = 0;
                                        }

                                        ?>

                                        <div id="price_filter">
                                            <span class="h5">Цена</span>
                                            <div class="range">
                                                <div class="range-slider">
                                                    <span class="range-selected"></span>
                                                </div>
                                                <div class="range-input">
                                                    <input type="range" class="min" min="0" max="<?=$max_price;?>" value="<?=$min_price;?>" step="10">
                                                    <input type="range" class="max" min="0" max="<?=$max_price;?>" value="<?=$max_price;?>" step="10">
                                                </div>
                                                <div class="range-price">
                                                    <input type="number" name="price_min" value="<?=$min_price;?>">
                                                    —
                                                    <input type="number" name="price_max" value="<?=$max_price;?>">
                                                </div>
                                            </div>
                                        </div>

                                    <?php }
                                ?>

                                <div id="submit_action">
                                    <button type="button" class="btn btn-secondary" id="filters-submit_btn">Применить</button>
                                </div>
                            </form>
                        </div>
                        <div id="catalog-data" class="catalog-data">
                            <div id="catalog-data-products" class="catalog-data-products">
                                <div class="woocommerce">
                                    <ul class="products">
                                        <?php
                                        // Start the Loop.
                                        //while ( have_posts() ) :
                                        //the_post();
                                        //get_template_part('template-parts/content/loop-product', 'page');
                                        //endwhile; // End the loop.

                                        if(!empty($products)){
                                            global $product;
                                            foreach ($products as $local_product){
                                                $product = wc_get_product($local_product->ID);

                                                get_template_part('woocommerce/content', 'product');
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div id="catalog-data-pagination" class="catalog-data-pagination">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php   }
        else{ ?>
            <div id="primary" class="content-area">
                <main id="main3" class="site-main">

                    <?php

                    // Start the Loop.
                    while ( have_posts() ) :
                        the_post();

                        get_template_part( 'template-parts/content/content', 'page' );

                        // If comments are open or we have at least one comment, load up the comment template.
                        /*if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }*/

                    endwhile; // End the loop.
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->
 <?php        }
?>

<?php
get_footer();
