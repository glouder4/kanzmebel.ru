<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

session_start();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body>
<?php wp_body_open(); ?>

<?php
    $custom_logo_id = get_theme_mod( 'main_logo' );
?>
<div class="modal fade" id="writeUs" tabindex="-1" aria-labelledby="writeUsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="writeUsLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<header id="main-header">
    <nav class="navbar navbar-expand-lg p-0">
        <div class="container p-0">
            <div id="mobile-sm-menu" class="col-12 d-lg-none">
                <div class="d-flex flex-row m-0 justify-content-between align-items-center">
                    <div id="mobile_logo-wrapper">
                        <img src="<?=get_theme_mod( 'mobile_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">
                    </div>
                    <div id="mobile_button-wrapper">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Развернуть меню">
                            <svg width="22" height="2" viewBox="0 0 22 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="22" height="2" fill="#FFF9F9"/>
                            </svg>
                            <svg width="22" height="2" viewBox="0 0 22 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="22" height="2" fill="#FFF9F9"/>
                            </svg>
                            <svg width="22" height="2" viewBox="0 0 22 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="22" height="2" fill="#FFF9F9"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div id="mobile_navigation">
                        <div id="close-mobile_navigation" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Свернуть меню">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" fill="#FFF9F9"/>
                                <rect x="12.22" y="9.81" width="23.9992" height="1.99405" transform="rotate(45 12.22 9.81)" fill="#555049"/>
                                <rect x="10.8101" y="26.78" width="23.9992" height="1.99405" transform="rotate(-45 10.8101 26.78)" fill="#555049"/>
                            </svg>
                        </div>

                        <div id="mobile_navigation-data">
                            <div class="d-flex flex-column">
                                <div id="mobile_navigation-data_logo">
                                    <img src="<?=get_theme_mod( 'main_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">
                                </div>
                                <div id="mobile_navigation-data_menu">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#">Главная</a>
                                        </li>
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

                                            if( $categories ) { ?>
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Каталог
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <?php
                                                        foreach ($categories as $cat) { ?>
                                                            <li><a class="dropdown-item" href="<?=get_term_link( $cat->slug, 'product_cat' );?>"><?=$cat->name;?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                        <?php    }
                                        ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Коллекции
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#">О фабрике</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Для клиента
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#">Сотрудничество</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#">Контакты</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="mobile_navigation-data_actions">
                                <button type="button" id="writeUsBtn" class="btn" data-bs-toggle="modal" data-bs-target="#writeUs">
                                    Написать нам
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="lg-menu" class="d-none d-lg-flex w-100">
                <div id="lg-menu-wrapper" class="d-flex w-100 flex-row m-0 justify-content-between align-items-center">
                    <div id="lg_logo-wrapper">
                        <img src="<?=get_theme_mod( 'main_logo' );?>" alt="<?=get_bloginfo( 'name' );?>">
                    </div>
                    <div id="lg_navbar-wrapper">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#">О фабрике</a>
                            </li>
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

                            if( $categories ) { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Каталог
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php
                                        foreach ($categories as $cat) { ?>
                                            <li><a class="dropdown-item" href="<?=get_term_link( $cat->slug, 'product_cat' );?>"><?=$cat->name;?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php    }
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Для клиента
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#">Сотрудничество</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#">Контакты</a>
                            </li>
                        </ul>
                    </div>
                    <div id="lg_phone" class="d-flex flex-column align-items-end">
                        <a href="#" id="phone_link" class="d-flex flex-row">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.125 15C12.3334 15 10.5869 14.6006 8.88582 13.8017C7.18417 13.0033 5.67722 11.9478 4.365 10.635C3.05222 9.32277 1.99667 7.81583 1.19833 6.11417C0.399445 4.41305 0 2.66666 0 0.875C0 0.625 0.0833333 0.416666 0.25 0.25C0.416666 0.0833333 0.625 0 0.875 0H4.25C4.44445 0 4.61806 0.0624999 4.77083 0.1875C4.92361 0.3125 5.01389 0.472222 5.04167 0.666666L5.58333 3.58333C5.61111 3.77778 5.60778 3.95472 5.57333 4.11416C5.53834 4.27417 5.45833 4.41667 5.33333 4.54167L3.33334 6.58333C3.91667 7.58333 4.64584 8.52083 5.52083 9.39582C6.39583 10.2709 7.36111 11.0277 8.41667 11.6666L10.375 9.70835C10.5 9.58332 10.6633 9.48944 10.865 9.42671C11.0661 9.36441 11.2639 9.34721 11.4583 9.375L14.3333 9.95832C14.5278 9.99997 14.6875 10.0936 14.8125 10.2392C14.9375 10.3853 15 10.5556 15 10.75V14.125C15 14.375 14.9167 14.5834 14.75 14.75C14.5834 14.9167 14.375 15 14.125 15Z" fill="#656F6B"/>
                            </svg>
                            8 (915) 419-44-02
                        </a>
                        <div type="button" data-bs-toggle="modal" data-bs-target="#writeUs">Заказать звонок</div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
