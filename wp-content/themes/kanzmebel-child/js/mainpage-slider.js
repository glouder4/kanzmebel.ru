export default class MainpageSlider{
    constructor(slider,expand_on) {
        if( slider == undefined || slider == null ) return 'slider is mismatch';
        this.slider = slider;
        this._w = window.innerWidth;
        this.expand_on = expand_on;

        this.slides = this.slider.querySelectorAll('.slide');

        let _this = this;
        window.addEventListener("resize", function(event) {
            _this.windowWidthChanged(window.innerWidth);
        });

        this.init();
    }
    windowWidthChanged(currentWidth){
        this._w = currentWidth;
        this.init();
    }
    getObject(){
        return this.slider;
    }
    init(){
        let _this = this;
        this.slides.forEach(function (slide){
            if( _this._w <= _this.expand_on ){
                if( slide.attributes.getNamedItem("data-mobile_slide") != null ){
                    slide.style.backgroundImage = 'url("'+slide.attributes.getNamedItem("data-mobile_slide").textContent+'")';
                }
            }
            else{
                if( slide.attributes.getNamedItem("data-main_slide") != null ){
                    slide.style.backgroundImage = 'url("'+slide.attributes.getNamedItem("data-main_slide").textContent+'")';
                }
            }
        });
    }
}