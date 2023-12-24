<?php
ini_set ( 'display_errors', 1 );
error_reporting ( E_ALL );

require_once($_SERVER['DOCUMENT_ROOT'] .'/wp-load.php');

session_start();

$headers = apache_request_headers();
$csrf_token = ( isset($headers['X-CSRF-TOKEN']) ) ? $headers['X-CSRF-TOKEN'] : null;

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
            $pagination .= '<li class="pagination" data-page="0">1</li>';
            if($current_page > 3)$pagination .= '<li>...</li>';
            $pagination .= '<li class="pagination" data-page="'.($current_page-2).'">'.($current_page-1).'</li>';
            $pagination .= '<li class="pagination active" data-page="'.($current_page-1).'">'.($current_page).'</li>';
            $pagination .= '<li class="pagination" data-page="'.$current_page.'">'.($current_page+1).'</li>';
            $pagination .= '<li>...</li>';
            $pagination .= '<li class="pagination" data-page="'.($total_pages-1).'">'.($total_pages).'</li>';
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

if (
    isset($headers['X-CSRF-TOKEN']) &&
    isset($_SESSION["csrf_token"]) &&
    isset($_SESSION["token-expire"]) &&
    $_SESSION["csrf_token"]==$headers['X-CSRF-TOKEN']
) {
    if (time() >= $_SESSION["token-expire"]) {
        exit("Token expired. Please reload form.");
    }

    if( isset($post) && !is_null($post) ){
        $post = json_decode($post,true);
    }
    $action = $post['action'];
    if( $action == 'get_products' ){
        $taxonomies = $post['taxonomies'];
        $price_min = $post['price_min'];
        $price_max = $post['price_max'];
        $page = (isset($post['page'])) ? $post['page'] : 0;

        $query = new WC_Product_Query( array(
            'limit' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'return' => 'objects',
        ) );
        $products = $query->get_products();
        $total_pages = ceil(count($products)/10);

        $products = array_slice($products, 10*$page, 10);

        $product_response = '';
        foreach ($products as $product){
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );
            $height = $product->get_height();
            $width = $product->get_width() ;
            $length = $product->get_length();

            $attrs = wc_get_product_attachment_props(get_post_thumbnail_id( $product->id ),$product);

            $product_response .= product_catalog_template(
                $product->id,
                get_permalink($product->id),
                $image[0],
                $product->name,
                $length,
                $width,
                $height,
                wc_price($product->get_price(),array()),
                $attrs['alt']
            );
        }

        $pagination_response = product_pagination($page,$total_pages);

        $response = [
                'total_pages' => $total_pages,
                'current_page' => 1,
                'products' => $product_response,
                'pagination' => $pagination_response
        ];

        print_r(json_encode($response));
    }
}
else{
    echo 'csrf mismatch';
}