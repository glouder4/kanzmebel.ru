import ShopPageCatalog from "./shop-catalog.js";

export default class ShopPage{
    constructor() {
        this.catalog = null;

        this.init();
    }
    initialiseCatalog(catalog,filter_btn,filters,load_products = true){
        if ( catalog != null && filter_btn != null && filters != null ){
            this.catalog = new ShopPageCatalog(catalog,filter_btn,filters,load_products);
        }
    }
    init(){

    }
}