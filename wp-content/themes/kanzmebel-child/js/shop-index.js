import ShopPageCatalog from "./shop_page.js";

let shop = new ShopPageCatalog(document.getElementById('shop-catalog'),
    document.querySelectorAll('.catalog_filters-btn'),
    document.getElementById('catalog_filters'));


if ( document.getElementById('shop-catalog') != null ) {
    shop.initialiseCatalog(
        document.getElementById('shop-catalog'),
        document.querySelectorAll('.catalog_filters-btn'),
        document.getElementById('catalog_filters'),
        false
    );
}