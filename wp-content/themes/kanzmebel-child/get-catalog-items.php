<?php
ini_set ( 'display_errors', 1 );
error_reporting ( E_ALL );

session_start();
global $session;
print_r($_SESSION);

require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');

$headers = apache_request_headers();
$csrf_token = ( isset($headers['x-csrf-token']) ) ? $headers['x-csrf-token'] : null;

$post = file_get_contents('php://input');

function product_catalog_template($product_id,$link,$image,$product_name,$length,$width,$height,$price,$alt){
    $product = '';

    $product .= '<div class="catalog_item" itemscope itemtype="https://schema.org/Product">';
        $product .= '<a href="'.$link.'" title="'.$product_name.'" itemprop="url">';
            $product .= '<img src="'.$image.'" data-id="'.$product_id.'" itemprop="image" alt="'.$alt.'">';
            $product .= '<p class="product_name" itemprop="name">'.$product_name.'</p>';
            $product .= '<p class="product_dimensions">'.$length.'x'.$width.'x'.$height.'мм </p>';
            $product .= '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
            $product .= '<span itemprop="price" class="product_price">'.$price.'</span>';
            $product .= '<meta itemprop="priceCurrency" content="RUB" />';
            $product .= '<link itemprop="availability" href="https://schema.org/InStock" />';
            $product .= '</div>';
        $product .= '</a>';
    $product .= '</div>';

    return $product;
}
function product_pagination($current_page,$total_pages){
    //$current_page = 10;
    //$total_pages = 100;
    if( $total_pages <= 1) return ;
    $is_centered = ($total_pages > 6) ? 'justify-content-between' : 'justify-content-center gap-1';

    $counter = 0;

    $pagination = '';

    $pagination .= '<ul class="'.$is_centered.'">';

    if( $total_pages > 6 ){
        if( $current_page - 6 >= 1 && ($total_pages - $current_page > 6)  ){
            $init_page = $current_page - 2;

            for ($page = $init_page; $page <= $total_pages; $page++){
                if( $counter == 1 ){
                    $pagination .= '<li>...</li>';
                }
                else if( $counter == 0 ){
                    $pagination .= '<li class="pagination" data-page="0">1</li>';
                }
                else if( $counter == 5 ){
                    $pagination .= '<li>...</li>';
                }
                else if( $counter == 6 ){
                    $pagination .= '<li class="pagination" data-page="'.($total_pages-1).'">'.($total_pages).'</li>';

                    break;
                }
                else{
                    $is_active = ($current_page == $page) ? "active" : "";
                    $pagination .= '<li class="pagination '. $is_active .'" data-page="'.($page-1).'">'.($page).'</li>';
                }

                $counter++;
            }
        }
        else if($total_pages - $current_page < 6){
            $pagination .= '<li class="pagination" data-page="0">1</li>';
            $pagination .= '<li>...</li>';
            $pagination .= '<li class="pagination" data-page="'.($current_page-2).'">'.($current_page-1).'</li>';
            $pagination .= '<li class="pagination active" data-page="'.($current_page-1).'">'.($current_page).'</li>';
            $pagination .= '<li class="pagination" data-page="'.$current_page.'">'.($current_page+1).'</li>';
            if($total_pages - $current_page > 3) $pagination .= '<li>...</li>';
            $pagination .= '<li class="pagination" data-page="'.($total_pages-1).'">'.($total_pages).'</li>';
        }
        else if($current_page - 6 >= 1){
            $init_page = 1;
            for ($page = $init_page; $page <= $total_pages; $page++){
                if( $counter == 5 ){
                    $pagination .= '<li>...</li>';
                }
                else if( $counter == 6 ){
                    $pagination .= '<li class="pagination" data-page="'.($total_pages-1).'">'.($total_pages).'</li>';

                    break;
                }
                else{
                    $is_active = ($current_page == $page) ? "active" : "";
                    $pagination .= '<li class="pagination '. $is_active .'" data-page="'.($page-1).'">'.($page).'</li>';
                }

                if($counter == 6) break;

                $counter++;
            }
        }
        else if( $current_page <= 6 ){
            $init_page = 1;

            for ($page = $init_page; $page <= $total_pages; $page++){
                if($current_page > 3 && $counter == 1) {
                    $pagination .= '<li>...</li>';
                }
                else if( $counter == 0 ){
                    $pagination .= '<li class="pagination" data-page="0">1</li>';
                }
                else if( $counter == 5 ){
                    $pagination .= '<li>...</li>';
                }
                else if( $counter == 6 ){
                    $pagination .= '<li class="pagination" data-page="'.($total_pages-1).'">'.($total_pages).'</li>';

                    break;
                }
                else  $pagination .= '<li class="pagination" data-page="'.$current_page.'">'.($current_page+1).'</li>';
            }
        }
    }
    else{
        $init_page = 1;
        for ($page = $init_page; $page <= $total_pages; $page++){
            $is_active = ($current_page == ($page-1)) ? "active" : "";
            $pagination .= '<li class="pagination '. $is_active .'" data-page="'.($page-1).'">'.($page).'</li>';
        }
    }

    $pagination .= '</ul>';

    return $pagination;
}

if( isset($post) && !is_null($post) ){
    $post = json_decode($post,true);
}

/*if (
    isset($csrf_token) &&
    isset($_SESSION["csrf_token"]) &&
    isset($_SESSION["token-expire"]) &&
    ( ($_SESSION["csrf_token"]==$csrf_token) ||
        ( isset($post["csrf_token"]) && $post["csrf_token"]==$csrf_token) )
) {
    if (time() >= $_SESSION["token-expire"]) {
        exit("Token expired. Please reload form.");
    }*/

    $args = custom_modify_args();
    if( $args['action'] == 'get_products' ){

        $products = get_posts($args);
        $args['total_pages'] = ceil(count($products)/$args['posts_per_page']);

        wc_set_loop_prop('current_page', $args['current_page']);
        wc_set_loop_prop('is_paginated', wc_string_to_bool(true));
        wc_set_loop_prop('page_template', get_page_template_slug());
        wc_set_loop_prop('per_page', $args['posts_per_page']);
        wc_set_loop_prop('total', count($products));
        wc_set_loop_prop('total_pages', $args['total_pages']);

        if($products) {
            //do_action('woocommerce_before_shop_loop');
                woocommerce_product_loop_start();
                    foreach($products as $featured_product) {
                        $post_object = get_post($featured_product);
                        setup_postdata($GLOBALS['post'] =& $post_object);
                        wc_get_template_part('content', 'product');
                    }
                wp_reset_postdata();
            woocommerce_product_loop_end();
            //do_action('woocommerce_after_shop_loop');
        } else {
            do_action('woocommerce_no_products_found');
        }

        //$pagination_response = product_pagination($args['page'],$args['total_pages']);

        /*$response = [
                'total_pages' => $args['total_pages'],
                'current_page' => 1,
                'products' => $product_response,
                'pagination' => $pagination_response
        ];

        print_r(json_encode($response));*/
    }
/*}
else{
    print_r($_SESSION); echo '<br/>';
    echo $csrf_token.' | '.$_SESSION["csrf_token"];
    echo '<br/>csrf mismatch';
}*/