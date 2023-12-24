import MainPageSlider from "./mainpage-slider.js";
import MainPageCatalog from "./mainpage-catalog.js";

export default class Main_page{
    constructor() {
        this.slider = null;
        this.catalog = null;

        this.init();
    }
    initialiseSlider(slider,expand_on){
        if ( slider != null ){
            this.slider = new MainPageSlider(slider,expand_on);
        }
    }
    initialiseCatalog(catalog,filter_btn,filters){
        if ( catalog != null && filter_btn != null && filters != null ){
            this.catalog = new MainPageCatalog(catalog,filter_btn,filters);
        }
    }
    init(){

    }
}