<?php
    /*
    Template name: Шаблон главной страницы
    Template post type: page
*/
?>

<?php
    get_header();
?>
<?php
    //foreach (get_fields('слайдер'))
    $slider = get_fields(get_the_ID(),'слайдер');
    if( isset($slider['слайдер']) && ( !is_null($slider['слайдер']) ) && ( $slider['слайдер'] != '' )
        && ( isset($slider['слайдер']['слайды']) )  && ( !is_null($slider['слайдер']['слайды']) ) && ( $slider['слайдер']['слайды'] != '' )
    ){
        ?>
        <section id="main-slider">
            <div class="container">
                <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                            foreach ($slider['слайдер']['слайды'] as $key => $slide){ ?>
                                <div class="slide carousel-item <?=($key == 0) ? 'active' : ''; ?>" data-mobile_slide="<?=$slide['мобильное_изображение'];?>" data-main_slide="<?=$slide['основное_изображение'];?>">
                                    <div class="slide_data <?=($slide['добавить_затемнение'][0] == 'Да') ? 'darked' : '';?>">
                                        <p class="h3 title m-0"><?=$slide['заголовок'];?></p>

                                        <a href="<?=$slide['ссылка'];?>" class="link_btn"><?=$slide['надпись_на_кнопке'];?></a>
                                    </div>
                                </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php }
?>

<?php
if ( class_exists( 'WooCommerce' ) ) {

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

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'numberposts' => 8
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

    ?>
   <section id="shop-catalog" class="catalog" data-endpoint="<?=get_stylesheet_directory_uri().'/get-catalog-items.php';?>">
       <div class="container">
           <div class="section-title">
               <h2 class="title">Каталог</h2>

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
                    <div id="catalog-data-products" class="catalog-data-products woocommerce">
                        <div class="catalog_preloader">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only"></span>
                            </div>
                            Товары загружаются..
                        </div>
                    </div>
                   <div id="catalog-data-pagination" class="catalog-data-pagination">
                   </div>
               </div>
           </div>
       </div>
   </section>
<?php }
?>

<section id="another-info">
    <div class="container p-md-0">
        <div class="d-flex flex-column flex-md-row justify-content-md-between">
            <div class="d-flex order-1 order-md-1">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_25_2257)">
                        <path d="M25 49.6426C38.6099 49.6426 49.6429 38.6097 49.6429 24.9998C49.6429 11.3899 38.6099 0.356934 25 0.356934C11.3902 0.356934 0.357178 11.3899 0.357178 24.9998C0.357178 38.6097 11.3902 49.6426 25 49.6426Z" stroke="#656F6B" stroke-width="0.714286"/>
                        <path d="M33.8916 32.7422L32.266 31.1166V29.0146H30.6404V31.7896L32.7423 33.8915L33.8916 32.7422Z" fill="#656F6B"/>
                        <path d="M31.4532 37.1427C30.328 37.1427 29.2279 36.809 28.2922 36.1838C27.3566 35.5586 26.6273 34.6701 26.1967 33.6304C25.7661 32.5908 25.6534 31.4468 25.873 30.3431C26.0925 29.2394 26.6343 28.2256 27.43 27.4299C28.2257 26.6342 29.2395 26.0923 30.3432 25.8728C31.447 25.6532 32.5909 25.7659 33.6306 26.1966C34.6702 26.6271 35.5588 27.3564 36.184 28.2921C36.8092 29.2277 37.1429 30.3278 37.1429 31.4531C37.1412 32.9615 36.5412 34.4077 35.4745 35.4743C34.4079 36.541 32.9617 37.141 31.4532 37.1427ZM31.4532 27.3891C30.6495 27.3891 29.8637 27.6274 29.1954 28.074C28.527 28.5205 28.0062 29.1552 27.6986 29.8978C27.391 30.6404 27.3105 31.4576 27.4673 32.2459C27.6241 33.0343 28.0112 33.7584 28.5795 34.3268C29.1479 34.8951 29.872 35.2822 30.6604 35.439C31.4487 35.5958 32.2659 35.5153 33.0085 35.2077C33.7511 34.9001 34.3858 34.3793 34.8324 33.7109C35.2789 33.0426 35.5172 32.2568 35.5172 31.4531C35.5162 30.3756 35.0877 29.3425 34.3257 28.5806C33.5638 27.8186 32.5307 27.3901 31.4532 27.3891ZM24.9508 34.7043C22.3648 34.7015 19.8856 33.673 18.057 31.8444C16.2285 30.0159 15.2 27.5366 15.1972 24.9506H13.5715C13.575 27.9676 14.775 30.8599 16.9082 32.9932C19.0415 35.1265 21.9339 36.3265 24.9508 36.3299V34.7043ZM21.6996 18.4482H17.699C19.0142 16.9756 20.746 15.9374 22.6647 15.4713C24.5834 15.0053 26.5985 15.1334 28.4427 15.8386C30.287 16.5438 31.8734 17.7928 32.9917 19.4201C34.11 21.0474 34.7072 22.9761 34.7045 24.9506H36.3301C36.3337 22.6884 35.6618 20.4766 34.4006 18.5986C33.1394 16.7206 31.3462 15.2618 29.2509 14.4092C27.1555 13.5565 24.8533 13.3488 22.6391 13.8127C20.425 14.2765 18.3997 15.3908 16.8227 17.0128V13.5713H15.1972V20.0738H21.6996V18.4482Z" fill="#656F6B"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_25_2257">
                            <rect width="50" height="50" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                <p>Срок изготовления<br/>40 рабочих дней</p>
            </div>
            <div class="d-flex order-2 order-md-3">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_25_2250)">
                        <path d="M25 49.6426C38.6099 49.6426 49.6429 38.6097 49.6429 24.9998C49.6429 11.3899 38.6099 0.356934 25 0.356934C11.3902 0.356934 0.357178 11.3899 0.357178 24.9998C0.357178 38.6097 11.3902 49.6426 25 49.6426Z" stroke="#656F6B" stroke-width="0.714286"/>
                        <path d="M25.051 12.9451C24.507 13.2452 24.7384 14.108 25.3574 14.108C25.6763 14.108 25.9826 13.8017 25.9826 13.489C25.9826 13.0201 25.4637 12.7137 25.051 12.9451Z" fill="#656F6B"/>
                        <path d="M22.0435 13.3014C20.0865 13.8267 18.2233 14.8958 16.6789 16.3902C15.566 17.453 14.8095 18.4972 14.128 19.8914C11.0706 26.1189 13.7216 33.6593 20.024 36.6604C23.4316 38.2798 27.4394 38.2548 30.8282 36.5917C37.0306 33.5404 39.6003 26.1376 36.6117 19.929C35.2174 17.0467 32.7227 14.7707 29.734 13.6516C28.7837 13.2952 28.1834 13.1577 27.9458 13.2327C27.6957 13.3202 27.5457 13.539 27.5457 13.8142C27.5457 14.1518 27.7395 14.3394 28.2522 14.4832C31.2096 15.3334 33.4854 17.0467 35.0173 19.5789C37.3682 23.4616 37.0806 28.5386 34.3045 32.1712C32.6789 34.297 30.3154 35.8039 27.7332 36.3541C23.7504 37.2106 19.5739 35.8289 16.9103 32.7777C13.0338 28.3447 13.1964 21.7484 17.2854 17.5218C18.636 16.1338 20.3492 15.1022 22.2436 14.5519C22.9752 14.3394 23.1689 14.183 23.1689 13.8204C23.1689 13.539 23.0252 13.3202 22.7813 13.2389C22.55 13.1577 22.6125 13.1514 22.0435 13.3014Z" fill="#656F6B"/>
                        <path d="M25.0194 15.7023C24.7255 15.8086 24.4317 16.0712 24.3129 16.3463C24.2628 16.4651 24.194 16.884 24.1628 17.2842C24.1002 18.0282 23.969 18.5034 23.5751 19.4162C23.4813 19.6413 23.325 20.2102 23.225 20.6917C22.9873 21.8609 22.8373 22.0797 22.4747 21.7734L22.2808 21.6108H20.4051H18.5294L18.348 21.7921L18.1667 21.9735V26.9566V31.9398L18.348 32.1211L18.5294 32.3025H20.4114H22.2871L22.4934 32.1211C22.7435 31.9022 22.7247 31.9022 24.3879 32.3462L25.5133 32.6463H28.2018H30.8904L31.253 32.4775C32.1846 32.0398 32.8224 30.9707 32.7098 30.0328C32.6786 29.7452 32.6911 29.7015 32.8724 29.4951C32.9787 29.3763 33.1412 29.12 33.2288 28.9261C33.3663 28.6322 33.3913 28.4947 33.3976 27.957C33.4038 27.3442 33.4101 27.3192 33.629 26.9879C33.9165 26.5565 34.0729 25.95 34.0291 25.4935C33.9916 25.156 33.9916 25.1497 34.2667 24.9121C35.2858 24.018 35.017 22.3486 33.7727 21.7859C33.4601 21.6421 33.4101 21.6421 30.6465 21.6108L27.8455 21.5795L27.6892 21.2857C27.4453 20.8167 27.439 20.4291 27.6642 19.7476C27.7705 19.4287 27.8767 18.966 27.8955 18.716C28.008 17.3717 27.1515 16.065 25.926 15.7085C25.5133 15.5897 25.3382 15.5897 25.0194 15.7023ZM26.0885 17.2029C26.645 17.678 26.7888 18.5221 26.4637 19.4225C26.2386 20.0415 26.1948 20.5854 26.3199 21.1294L26.4199 21.5545L26.1698 21.7921C25.901 22.0422 25.8572 22.2235 25.9947 22.5174C26.151 22.8613 26.126 22.8613 29.7837 22.8613H33.1537L33.3663 23.0051C33.6477 23.1927 33.729 23.4803 33.5852 23.7742C33.4289 24.1055 33.1975 24.1743 32.2034 24.1743C31.028 24.1743 30.7966 24.2868 30.7966 24.8495C30.7966 25.0246 30.8404 25.1309 30.9592 25.2435C31.1092 25.381 31.178 25.3935 31.9408 25.4248L32.7661 25.456L32.7536 25.7499C32.7411 26.2814 32.3597 26.6752 31.8595 26.6752C31.5657 26.6752 31.2968 26.9691 31.2968 27.2817C31.303 27.6569 31.5844 27.9257 31.9783 27.9257C32.1409 27.9257 32.1721 27.9507 32.1721 28.0633C32.1659 28.4947 31.7282 28.9887 31.3468 28.9887C31.0967 28.9887 30.8591 29.12 30.7591 29.3075C30.5402 29.739 30.7528 30.1579 31.2218 30.2204C31.4844 30.2579 31.4906 30.2642 31.4531 30.4517C31.3906 30.7643 31.103 31.1332 30.7966 31.2895C30.5152 31.4333 30.509 31.4333 28.0768 31.4146L25.6384 31.3958L24.4192 31.0707C23.7501 30.8956 23.0936 30.7331 22.9623 30.708L22.731 30.6705L22.7435 26.9504L22.7622 23.2302L23.1374 23.0801C23.6501 22.8738 24.0502 22.4424 24.2191 21.911C24.2941 21.6921 24.4067 21.2107 24.4817 20.8355C24.563 20.4166 24.713 19.9164 24.8818 19.5225C25.2132 18.7472 25.3507 18.222 25.3945 17.5342C25.4132 17.2529 25.4383 16.984 25.4508 16.9402C25.4883 16.8215 25.7947 16.9527 26.0885 17.2029ZM21.4805 26.9566V31.052H20.4489H19.4172V26.9566V22.8613H20.4489H21.4805V26.9566Z" fill="#656F6B"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_25_2250">
                            <rect width="50" height="50" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                <p>Гарантия 18 месяцев</p>
            </div>
            <div class="d-flex order-3 order-md-2">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_25_2244)">
                        <path d="M25 49.6426C38.6099 49.6426 49.6429 38.6097 49.6429 24.9998C49.6429 11.3899 38.6099 0.356934 25 0.356934C11.3902 0.356934 0.357178 11.3899 0.357178 24.9998C0.357178 38.6097 11.3902 49.6426 25 49.6426Z" stroke="#656F6B" stroke-width="0.714286"/>
                        <path d="M21.4238 12.6331C21.2577 12.6966 21.0329 12.9848 20.0068 14.4263L19.0296 15.7993L17.2706 16.3563C16.049 16.7374 15.4724 16.9426 15.3747 17.0306C15.1012 17.2553 15.0962 17.2993 15.0962 19.3368V21.2131L13.9969 22.6986C13.3079 23.6367 12.8877 24.2474 12.8682 24.3452C12.8535 24.4331 12.8535 24.5797 12.8682 24.6628C12.8877 24.7654 13.3079 25.3761 13.9969 26.3143L15.0962 27.7997V29.676C15.0962 31.7135 15.1012 31.7575 15.3747 31.9822C15.4724 32.0702 16.049 32.2754 17.2706 32.6565L19.0296 33.2136L20.0654 34.6598C20.6322 35.4612 21.1649 36.1746 21.2479 36.2527C21.5362 36.5313 21.6486 36.5117 23.6128 35.8521L25.3669 35.2657L27.1064 35.8472C28.0641 36.1648 28.924 36.4286 29.012 36.4286C29.2221 36.4286 29.4127 36.326 29.5886 36.1208C29.6667 36.0328 30.17 35.339 30.7075 34.5866L31.6799 33.2184L33.4389 32.6614C34.6653 32.2754 35.2419 32.0702 35.3444 31.9822C35.6132 31.7575 35.6181 31.7135 35.6181 29.676V27.7997L36.7174 26.3143C37.4064 25.3761 37.8266 24.7654 37.8462 24.6676C37.8608 24.5797 37.8608 24.4331 37.8462 24.3501C37.8266 24.2474 37.4064 23.6367 36.7174 22.6986L35.6181 21.2131V19.3368C35.6181 17.2993 35.6132 17.2553 35.3444 17.0306C35.2419 16.9426 34.6653 16.7374 33.4389 16.3514L31.6799 15.7944L30.6489 14.3481C30.0821 13.5516 29.5494 12.8383 29.4664 12.7601C29.183 12.4865 29.0657 12.5061 27.1113 13.1608L25.3718 13.7422L23.6421 13.1656C21.9515 12.5988 21.6681 12.5305 21.4238 12.6331ZM23.6226 14.7341C24.5069 15.0273 25.2887 15.2716 25.3572 15.2716C25.4256 15.2716 26.2074 15.0321 27.0917 14.7341C27.9762 14.4409 28.7139 14.2162 28.7335 14.2357C28.753 14.2553 29.2074 14.8905 29.7449 15.6429C30.4974 16.6935 30.7662 17.0355 30.8883 17.0941C30.9762 17.1332 31.7384 17.3824 32.5789 17.6463L34.1034 18.1251V19.8499C34.1034 21.3206 34.1132 21.6041 34.1815 21.7262C34.2207 21.8093 34.6848 22.4542 35.2077 23.1627C35.7304 23.8712 36.1556 24.4722 36.1556 24.5064C36.1556 24.5406 35.7304 25.1416 35.2077 25.8501C34.6848 26.5586 34.2207 27.2036 34.1815 27.2866C34.1132 27.4088 34.1034 27.6922 34.1034 29.1581V30.8877L32.5789 31.3666C31.7384 31.6304 30.9762 31.8796 30.8883 31.9236C30.7662 31.9773 30.4974 32.3145 29.7449 33.3699C29.2074 34.1223 28.753 34.7576 28.7335 34.7771C28.7139 34.7966 27.9762 34.5719 27.0917 34.2787C26.2074 33.9807 25.4256 33.7413 25.3572 33.7413C25.2887 33.7413 24.5069 33.9807 23.6226 34.2787C22.7382 34.5719 22.0004 34.7966 21.9808 34.7771C21.9613 34.7576 21.5069 34.1223 20.9694 33.3699C20.2169 32.3193 19.9482 31.9773 19.826 31.9236C19.7381 31.8796 18.9759 31.6304 18.1403 31.3666L16.6109 30.8828V29.1825C16.6109 27.8583 16.5963 27.4479 16.5425 27.3257C16.5083 27.2378 16.0442 26.5781 15.5164 25.8648C14.9887 25.1514 14.5587 24.5406 14.5587 24.5064C14.5587 24.4722 14.9887 23.8614 15.5164 23.1481C16.0442 22.4347 16.5083 21.7751 16.5425 21.6871C16.5963 21.565 16.6109 21.1545 16.6109 19.8303V18.1251L18.1403 17.6463C18.9759 17.3824 19.7381 17.1332 19.826 17.0892C19.9482 17.0355 20.2218 16.6886 20.9938 15.6087C21.5509 14.8318 22.0052 14.1966 22.0052 14.1966C22.0102 14.1966 22.7382 14.4361 23.6226 14.7341Z" fill="#656F6B"/>
                        <path d="M29.1928 21.0812C29.1147 21.1301 27.9127 22.3076 26.5299 23.6953C25.1471 25.083 23.994 26.2165 23.9647 26.2165C23.9353 26.2165 23.3979 25.6986 22.7675 25.0634C22.1373 24.4331 21.5607 23.881 21.4874 23.8419C21.1698 23.6757 20.7203 23.8175 20.5346 24.1448C20.3978 24.3794 20.3929 24.5992 20.515 24.8387C20.6372 25.0732 23.481 27.9022 23.6618 27.9707C23.8572 28.044 24.121 28.0391 24.3018 27.9511C24.5413 27.8387 30.1261 22.2245 30.219 22.0047C30.3167 21.7652 30.3118 21.5845 30.1994 21.3792C30.0088 21.0128 29.5251 20.8711 29.1928 21.0812Z" fill="#656F6B"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_25_2244">
                            <rect width="50" height="50" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                <p>Фурнитура европейского<br/>производства фирмы Hettich</p>
            </div>
        </div>
    </div>
</section>

<section class="additional-data" style="background-color: #EFEEED;">
    <div class="container">
        <div class="section-data">
            <p>На фабрике Mister Room
                работают перфекционисты
                своего дела, каждый элемент
                проходит многоэтапный контроль
                качества, прежде чем стать
                частью изделия</p>

            <a href="#" class="btn link_btn" data-bs-toggle="modal" data-bs-target="#writeUs">Подробнее о фабрике</a>
        </div>
    </div>
</section>

<?php
if ( class_exists( 'WooCommerce' ) ) {

    ?>
    <section id="popular-catalog" class="catalog">
        <div class="container">
            <div class="section-title">
                <h2 class="title">Популярные модели</h2>
            </div>
            <div class="section_data">
                <div class="catalog-data">
                    <div class="catalog-data-products">
                    <?php

                    $query = new WC_Product_Query( array(
                        'limit' => 8,
                        'orderby' => 'total_sales',
                        'order' => 'DESC',
                        'return' => 'objects',
                    ) );
                    $products = $query->get_products();

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

                    $product_response = '';
                    foreach ($products as $product){
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );
                        $height = $product->get_height();
                        $width = $product->get_width() ;
                        $length = $product->get_length();

                        $attrs = wc_get_product_attachment_props(get_post_thumbnail_id( $product->get_id() ),$product);

                        $product_response .= product_catalog_template(
                            $product->get_id(),
                            get_permalink($product->get_id()),
                            $image[0],
                            $product->get_title(),
                            $length,
                            $width,
                            $height,
                            wc_price($product->get_price(),array()),
                            $attrs['alt']
                        );
                    }

                    echo $product_response;
                    ?>
                </div>
                </div>
            </div>
        </div>
    </section>
<?php }
?>

<section class="additional-data light-items" style="background-color: #656F6B; margin-top: 30px;">
    <div class="container">
        <div class="section-data">
            <p style="color:#FFF9F9;">Нужен другой размер, цвет, хотите
                поменять ручки или не нашли
                подходящую модель? — Мы сделаем
                для вас уникальную мебель по
                индивидуальным параметрам</p>

            <a href="#" class="btn link_btn" data-bs-toggle="modal" data-bs-target="#writeUs">Оставить заявку</a>
        </div>
    </div>
</section>
<section id="interior">
    <div class="container">
        <div class="section_title">
            <h4 class="h4"><?=get_field('дополнительный_слайдер')['заголовок_блока'];?></h4>
        </div>
        <div id="interior_slider">
            <div id="interior_slider-swiper" class="swiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php
                    foreach(get_field('дополнительный_слайдер')['слайды'] as $slide){ ?>
                        <div class="swiper-slide slide">
                            <a href="<?=$slide['основной_слайд'];?>" data-fancybox="interior" class="swiper-slide slide">
                                <div class="slide_data">
                                    <div class="main_slide">
                                        <img src="<?=$slide['основной_слайд'];?>" alt="<?=$slide['основной_слайд'];?>">
                                    </div>
                                    <div class="mobile_slide">
                                        <img src="<?=$slide['мобильный_слайд'];?>" alt="<?=$slide['мобильный_слайд'];?>">
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php }
                    ?>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.5" width="24" height="24" rx="12" fill="#555049"/>
                        <g clip-path="url(#clip0_25_2339)">
                            <path d="M14.3738 17.6484L9.21938 12.5002L14.3738 7.35197" stroke="#FFF9F9" stroke-width="0.6443"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_25_2339">
                                <rect width="6" height="10.94" fill="white" transform="matrix(-1 0 0 -1 14.7 17.9702)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <div class="swiper-button-next">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect y="0.5" width="24" height="24" rx="12" fill="#555049"/>
                        <g clip-path="url(#clip0_25_2342)">
                            <path d="M9.62622 7.35156L14.7806 12.4998L9.62622 17.648" stroke="#FFF9F9" stroke-width="0.6443"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_25_2342">
                                <rect width="6" height="10.94" fill="white" transform="translate(9.30005 7.02979)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="news_list">
    <div class="container">
        <div class="section_title d-flex flex-row justify-content-between">
            <h5 class="h5">Полезная информация</h5>

            <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_25_2349)">
                    <path d="M25.5937 1.3125H0.65625C0.293813 1.3125 0 1.60631 0 1.96875V26.9062C0 27.2687 0.293813 27.5625 0.65625 27.5625H25.5937C25.9562 27.5625 26.25 27.2687 26.25 26.9062V1.96875C26.25 1.60631 25.9562 1.3125 25.5937 1.3125Z" fill="#BEBEBE" fill-opacity="0.3"/>
                    <path d="M57.0937 1.3125H32.1562C31.7938 1.3125 31.5 1.60631 31.5 1.96875V26.9062C31.5 27.2687 31.7938 27.5625 32.1562 27.5625H57.0937C57.4562 27.5625 57.75 27.2687 57.75 26.9062V1.96875C57.75 1.60631 57.4562 1.3125 57.0937 1.3125Z" fill="#BEBEBE" fill-opacity="0.3"/>
                    <path d="M10.3632 38.8106C10.3632 38.8106 4.96885 29.2031 2.69822 25.0425C-0.320524 19.5037 -0.819288 17.1675 1.2676 16.0125C2.56697 15.2906 4.3651 15.5925 5.4676 17.5087L8.0401 21.6038V5.55187C8.0401 5.55187 7.8826 1.3125 10.9013 1.3125C14.117 1.3125 13.8414 5.55187 13.8414 5.55187V13.3481C13.8414 13.3481 15.5345 12.1275 17.5164 12.6787C18.527 12.9544 19.7082 13.44 20.3382 15.0412C20.3382 15.0412 24.3676 13.0856 26.3757 17.2462C26.3757 17.2462 31.022 16.3275 31.022 21.1444C31.022 25.9613 25.2207 38.8106 25.2207 38.8106H10.3632Z" fill="#BEBEBE"/>
                </g>
                <defs>
                    <clipPath id="clip0_25_2349">
                        <rect width="42" height="42" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <div id="news_slider">
            <div class="swiper-wrapper">
            <?php
                // параметры по умолчанию
                $my_posts = get_posts( array(
                    'numberposts' => 15,
                    'category'    => 17,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'include'     => array(),
                    'exclude'     => array(),
                    'meta_key'    => '',
                    'meta_value'  =>'',
                    'post_type'   => 'post',
                    'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
                ) );

                global $post;

                foreach( $my_posts as $post ){
                    setup_postdata( $post );

                    $thumbnail_attributes = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    ?>
                    <div class="swiper-slide slide">
                        <a href="<?=get_permalink();?>">
                            <div class="news_card">
                                <div class="news_card-image">
                                    <img loading="lazy" src="<?=$thumbnail_attributes[0];?>" alt="<?=get_the_title();?>">
                                </div>
                                <div class="news_card-body">
                                    <h6 class="news_card-title"><?=get_the_title();?></h6>
                                    <span>
                                    Читать
                                    <svg width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.84449 8.93994L5.07887 8.18426L8.23086 5.03227H0.0675049V3.93852H8.23086L5.07887 0.796476L5.84449 0.0308506L10.299 4.4854L5.84449 8.93994Z" fill="#656F6B"/>
                                    </svg>
                                </span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }

                wp_reset_postdata(); // сброс
            ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();