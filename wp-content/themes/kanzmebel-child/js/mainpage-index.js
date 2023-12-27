import Main_page from './main_page.js';
import ShopPageCatalog from "./shop_page.js";

let main_page = new Main_page();


if ( document.getElementById('mainCarousel') != null ){
    main_page.initialiseSlider(document.getElementById('mainCarousel'),800);
}

let shop = new ShopPageCatalog(document.getElementById('shop-catalog'),
    document.querySelectorAll('.catalog_filters-btn'),
    document.getElementById('catalog_filters'));


if ( document.getElementById('shop-catalog') != null ) {
    shop.initialiseCatalog(
        document.getElementById('shop-catalog'),
        document.querySelectorAll('.catalog_filters-btn'),
        document.getElementById('catalog_filters'),
        true
    );
}
// Слайдер интерьера
document.addEventListener("DOMContentLoaded", () => {
    let effects = 'cards';
    let coverflowEffect = {
        perSlideOffset: 4,
        perSlideRotate: 1,
        rotate: 10,
        slideShadows: false,
    }
    if( window.innerWidth >= 768 ){
        effects = 'coverflow';
        coverflowEffect = {
            rotate: 0,
            slideShadows: false,
        }
    }
    const swiper = new Swiper('#interior_slider-swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        initialSlide: 1,
        effect: effects,
        coverflowEffect: coverflowEffect,

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            // when window width is >= 320px
            375: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 0
            },
            991: {
                slidesPerView: 3,
                spaceBetween: 0
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 3
            },
            1400: {
                slidesPerView: 4,
                spaceBetween: 5
            },
        }
    });

    const news_swiper = new Swiper('#news_slider', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        effect: 'coverflow',
        coverflowEffect: {
            rotate: 30,
            slideShadows: false,
        },
        breakpoints: {
            // when window width is >= 320px
            375: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 0
            },
            991: {
                slidesPerView: 3,
                spaceBetween: 0
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 0
            },
        }
    });
});