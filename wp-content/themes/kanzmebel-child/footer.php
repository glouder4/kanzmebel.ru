<?php
    $social_links =  get_field('социальная_сеть', 'option');

    $contacts =  get_field('контакты', 'option');
?>
<footer id="main_footer">
    <div class="container">
        <div id="mobile_footer" class="d-flex d-md-none flex-column">
            <div id="mobile_footer-logo">
                <img src="<?=get_theme_mod( 'footer_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">
            </div>
            <div id="mobile_footer-for_clients">
                <span class="h3">ДЛЯ КЛИЕНТА</span>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                        $items = wp_get_nav_menu_items( 19, [
                            'output_key'  => 'menu_order',
                        ] );

                        $item_menu_id = null;
                        foreach($items as $menu_item){
                            if( $menu_item->post_title == 'Для клиента' ){
                                $item_menu_id = $menu_item->ID;
                                break;
                            }
                        }
                    ?>

                    <?php
                        if( !is_null($item_menu_id) ){
                            foreach($items as $menu_item){
                                if( $menu_item->menu_item_parent == $item_menu_id ){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="<?=$menu_item->url;?>"><?=$menu_item->title;?></a>
                                    </li>
                            <?php    }
                            }
                        }
                    ?>
                </ul>
            </div>

            <div id="mobile_footer-contacts">
                <span class="h3">КОНТАКТЫ</span>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="tel:<?=$contacts['телефон']['ссылка'];?>"><?=$contacts['телефон']['телефон'];?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="mailto:<?=$contacts['email'];?>"><?=$contacts['email'];?></a>
                    </li>
                </ul>
            </div>

            <div id="mobile_footer-social_links">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    foreach ($social_links as $social_link){ ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?=$social_link['ссылка'];?>">
                                <?=$social_link['иконка'];?>
                            </a>
                        </li>
                    <?php    }
                    ?>
                </ul>
            </div>

            <div id="mobile_footer-special_data">
                <?php
                $additional_data =  get_field('о_компании', 'option');
                ?>
                <p><?=get_bloginfo('name');?> <?=date('Y');?>. ВСЕ ПРАВА ЗАЩИЩЕНЫ</p>
                <p><?=($additional_data['инн'] != '') ? $additional_data['название_ип'] : '';?></p>
                <p><?=($additional_data['инн'] != '') ? 'ИНН: '.$additional_data['инн'] : '';?></p>
                <p><?=($additional_data['огрн'] != '') ? 'ОГРН: '.$additional_data['огрн'] : '';?></p>
            </div>
        </div>

        <div id="md_footer" class="d-none d-md-flex flex-row flex-wrap justify-content-between">
            <div id="md_footer-logo">
                <img src="<?=get_theme_mod( 'main_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">

                <div id="lg_footer-special_data" class="w-100 justify-content-between">
                    <?php
                    $additional_data =  get_field('о_компании', 'option');
                    ?>
                    <p><?=get_bloginfo('name');?> <?=date('Y');?>. ВСЕ ПРАВА ЗАЩИЩЕНЫ</p>
                    <p><?=($additional_data['инн'] != '') ? $additional_data['название_ип'] : '';?></p>
                    <p><?=($additional_data['инн'] != '') ? 'ИНН: '.$additional_data['инн'] : '';?></p>
                    <p><?=($additional_data['огрн'] != '') ? 'ОГРН: '.$additional_data['огрн'] : '';?></p>
                </div>
            </div>
            <div id="md_footer-categories">
                <span class="h3">Категории</span>

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
                        'exclude'      => array(15),
                        'include'      => '',
                        'pad_counts'   => false,
                        // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
                    ] );

                    $categories_counter = 0;
                    if( $categories ) {
                        ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <?php
                            foreach ($categories as $cat) { if( $cat->parent == 0 ): ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="<?=get_term_link( $cat->term_id ); ?>"><?=$cat->name;?></a>
                                </li>

                            <?php    $categories_counter ++; if( $categories_counter == 5 ) break; endif; }
                            ?>
                        </ul>
                    <?php }
                    ?>
            </div>
            <div id="md_footer-for_clients">
                <span class="h3">ДЛЯ КЛИЕНТА</span>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if( !is_null($item_menu_id) ){
                        foreach($items as $menu_item){
                            if( $menu_item->menu_item_parent == $item_menu_id ){ ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="<?=$menu_item->url;?>"><?=$menu_item->title;?></a>
                                </li>
                            <?php    }
                        }
                    }
                    ?>
                </ul>
            </div>
            <div id="md_footer-contacts">
                <span class="h3">КОНТАКТЫ</span>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="tel:<?=$contacts['телефон']['ссылка'];?>"><?=$contacts['телефон']['телефон'];?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="mailto:<?=$contacts['email'];?>"><?=$contacts['email'];?></a>
                    </li>
                </ul>

                <div id="md_footer-social_links">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php
                        foreach ($social_links as $social_link){ ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="<?=$social_link['ссылка'];?>">
                                    <?=$social_link['иконка'];?>
                                </a>
                            </li>
                        <?php    }
                        ?>
                    </ul>
                </div>
            </div>
            <div id="md_footer-special_data" class="w-100 d-flex justify-content-between">
                <?php
                    $additional_data =  get_field('о_компании', 'option');
                ?>
                <p><?=get_bloginfo('name');?> <?=date('Y');?>. ВСЕ ПРАВА ЗАЩИЩЕНЫ</p>
                <p><?=($additional_data['инн'] != '') ? $additional_data['название_ип'] : '';?></p>
                <p><?=($additional_data['инн'] != '') ? 'ИНН: '.$additional_data['инн'] : '';?></p>
                <p><?=($additional_data['огрн'] != '') ? 'ОГРН: '.$additional_data['огрн'] : '';?></p>
            </div>
        </div>
    </div>
</footer>

<div id="cookie_notification">
    <p>Мы используем файлы cookie на этом сайте для улучшения работы</p>
    <button class="button cookie_accept">Ок</button>
</div>


<div id="page_links">
    <div id="cart_link">
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" rel="nofollow">
           <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.29977 5H21L19 12H7.37671M20 16H8L6 3H3M9 20C9 20.5523 8.55228 21 8 21C7.44772 21 7 20.5523 7 20C7 19.4477 7.44772 19 8 19C8.55228 19 9 19.4477 9 20ZM20 20C20 20.5523 19.5523 21 19 21C18.4477 21 18 20.5523 18 20C18 19.4477 18.4477 19 19 19C19.5523 19 20 19.4477 20 20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
           </svg>
        </a>
    </div>
    <div id="page_up" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_25_2420)">
                <path d="M40 20C40 8.95431 31.0457 0 20 0C8.95431 0 0 8.95431 0 20C0 31.0457 8.95431 40 20 40C31.0457 40 40 31.0457 40 20Z" fill="white" fill-opacity="0.6"/>
                <path d="M12.8 17.6L20 10.4L27.2 17.6" stroke="#656F6B" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 11.36V28.72" stroke="#656F6B" stroke-linecap="round"/>
            </g>
            <defs>
                <clipPath id="clip0_25_2420">
                    <rect width="40" height="40" fill="white"/>
                </clipPath>
            </defs>
        </svg>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
