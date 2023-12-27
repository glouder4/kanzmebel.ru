// Слайдер доп.товаров
document.addEventListener("DOMContentLoaded", () => {
   const swiper = new Swiper('#related_products ul.products', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        initialSlide: 0,
        effects: 'coverflow',
        coverflowEffect:{
            rotate: 0,
            slideShadows: false,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            // when window width is >= 320px
            375: {
                slidesPerView: 1,
                spaceBetween: 1
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
});