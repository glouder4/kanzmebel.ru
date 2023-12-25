import MainPageSlider from "./mainpage-slider.js";

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
    init(){

    }
}