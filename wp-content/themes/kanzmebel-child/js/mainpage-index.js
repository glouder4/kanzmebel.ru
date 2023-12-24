import Main_page from './main_page.js';

let main_page = new Main_page();

if ( document.getElementById('mainCarousel') != null ){
    main_page.initialiseSlider(document.getElementById('mainCarousel'),800);
}
if ( document.getElementById('mainpage-catalog') != null && document.getElementById('catalog_filters-btn') != null ) {
    main_page.initialiseCatalog(
        document.getElementById('mainpage-catalog'),
        document.getElementById('catalog_filters-btn'),
        document.getElementById('catalog_filters')
    );
}