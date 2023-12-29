<?php
    $social_links =  get_field('социальная_сеть', 'option');

    $contacts =  get_field('контакты', 'option');
?>
<footer id="main_footer">
    <div class="container">
        <div id="mobile_footer" class="d-flex d-md-none flex-column">
            <div id="mobile_footer-logo">
                <img src="<?=get_theme_mod( 'main_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">
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
                <p>MISTER ROOM <?=date('Y');?>. ВСЕ ПРАВА ЗАЩИЩЕНЫ</p>
                <p><?=$additional_data['название_ип'];?></p>
                <p>ИНН <?=$additional_data['инн'];?></p>
                <p>ОГРН <?=$additional_data['огрн'];?></p>
            </div>
        </div>

        <div id="md_footer" class="d-none d-md-flex flex-row flex-wrap justify-content-between">
            <div id="md_footer-logo">
                <img src="<?=get_theme_mod( 'main_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">

                <div id="lg_footer-special_data" class="w-100 d-flex justify-content-between">
                    <?php
                    $additional_data =  get_field('о_компании', 'option');
                    ?>
                    <p>MISTER ROOM <?=date('Y');?>. ВСЕ ПРАВА ЗАЩИЩЕНЫ</p>
                    <p><?=$additional_data['название_ип'];?></p>
                    <p>ИНН <?=$additional_data['инн'];?></p>
                    <p>ОГРН <?=$additional_data['огрн'];?></p>
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
                            foreach ($categories as $cat) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="<?=get_term_link( $cat->term_id ); ?>"><?=$cat->name;?></a>
                                </li>

                            <?php    $categories_counter ++; if( $categories_counter == 5 ) break;}
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
                <p>MISTER ROOM <?=date('Y');?>. ВСЕ ПРАВА ЗАЩИЩЕНЫ</p>
                <p><?=$additional_data['название_ип'];?></p>
                <p>ИНН <?=$additional_data['инн'];?></p>
                <p>ОГРН <?=$additional_data['огрн'];?></p>
            </div>
        </div>
    </div>
</footer>

<div id="cookie_notification">
    <p>Мы используем файлы cookie на этом сайте для улучшения работы</p>
    <button class="button cookie_accept">Ок</button>
</div>

<?php wp_footer(); ?>

</body>
</html>
