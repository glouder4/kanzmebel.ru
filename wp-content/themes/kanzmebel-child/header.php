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
            <div id="mobile-sm-menu" class="col-12">
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
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Каталог
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </li>
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
            <!--<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            </div>-->
        </div>
    </nav>
</header>
