import Essentional from "./essentional.js";

export default class MainPageCatalog extends Essentional{
    constructor(catalog,filter_btn,filters) {
        super(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        if( catalog == undefined || catalog == null ) return 'catalog is mismatch';
        if( filter_btn == undefined || filter_btn == null ) return 'filter_btn is mismatch';
        if( filters == undefined || filters == null ) return 'filters is mismatch';

        if( filters.querySelector('.close') == undefined ) return 'filters .close is mismatch';
        if( document.getElementById('catalog-data-products') == undefined ) return 'catalog-data-products is mismatch';
        if( document.getElementById('catalog-data-pagination') == undefined ) return 'catalog-data-pagination is mismatch';
        if( document.getElementById('filters-submit_btn') == undefined ) return 'filters-submit_btn is mismatch';

        this.catalog = catalog;
        this.filter_btn = filter_btn;
        this.filters = filters;
        this.pagination = document.getElementById('catalog-data-pagination');

        this.catalog_page = 0;

        this.apply_filters_btn = document.getElementById('filters-submit_btn');

        let _this = this;

        this.filters.querySelector('.close').addEventListener('click',function(){
            _this.filters.classList.remove('show');
        })
        this.filter_btn.addEventListener('click',function(){
            _this.openFilters();
        });
        this.apply_filters_btn.addEventListener('click',function(){
            _this.applyFilters();
        });

        this.filter_settings = {};

        let data = {
            'action': 'get_products',
            'page': this.catalog_page
        };
        this.makeRequest(this.catalog.getAttribute('data-endpoint'),JSON.stringify(data),'POST').then(function(data){
            _this.appendProducts(data);
        });
    }
    applyFilters(){
        let _this = this;
        const form = this.filters.querySelector('form');

        let data = this.filter_settings;
        data.action = 'get_products';
        data.taxonomies = [];
        data.page = this.catalog_page;

        Array.from(
            new FormData(form),
            function(e) { return e.map(encodeURIComponent).join('='); }
        ).map(function (val){
            let key = val.split('=')[0];
            let value = val.split('=')[1];

            if( key.split('taxonomy-')[1] != undefined ){
                value = key.split('taxonomy-')[1];

                _this.filter_settings.taxonomies.push(value);
            }
            else{
                _this.filter_settings[key] = value;
            }
        });

        this.filters.classList.remove('show');
        this.makeRequest(this.catalog.getAttribute('data-endpoint'),JSON.stringify(_this.filter_settings),'POST').then(function(data){
            _this.appendProducts(data);
        });
    }
    openFilters(){
        this.filters.classList.add('show');

        let rangeMin = 100;
        const range = document.querySelector(".range-selected");
        const rangeInput = document.querySelectorAll(".range-input input");
        const rangePrice = document.querySelectorAll(".range-price input");
        rangeInput.forEach((input) => {
            let minRange = parseInt(rangeInput[0].value);
            let maxRange = parseInt(rangeInput[1].value);
            if (maxRange - minRange < rangeMin) {
                if (e.target.className === "min") {
                    rangeInput[0].value = maxRange - rangeMin;
                } else {
                    rangeInput[1].value = minRange + rangeMin;
                }
            } else {
                rangePrice[0].value = minRange;
                rangePrice[1].value = maxRange;
                range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
                range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
            }
        });

        rangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minRange = parseInt(rangeInput[0].value);
                let maxRange = parseInt(rangeInput[1].value);
                if (maxRange - minRange < rangeMin) {
                    if (e.target.className === "min") {
                        rangeInput[0].value = maxRange - rangeMin;
                    } else {
                        rangeInput[1].value = minRange + rangeMin;
                    }
                } else {
                    rangePrice[0].value = minRange;
                    rangePrice[1].value = maxRange;
                    range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
                    range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
                }
            });
        });

        rangePrice.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minPrice = rangePrice[0].value;
                let maxPrice = rangePrice[1].value;
                if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput[1].max) {
                    if (e.target.className === "min") {
                        rangeInput[0].value = minPrice;
                        range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                    } else {
                        rangeInput[1].value = maxPrice;
                        range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                    }
                }

                this.filter_settings.min_price = minPrice;
                this.filter_settings.max_price = maxPrice;
            });
        });
    }

    appendHtml(el, str) {
        var div = document.createElement('div'); //container to append to
        div.innerHTML = str;
        while (div.children.length > 0) {
            el.appendChild(div.children[0]);
        }
    }
    appendProducts(data){
        let _this = this;
        document.getElementById('catalog-data-products').innerHTML = '';
        this.pagination.innerHTML = '';
        this.appendHtml(document.getElementById('catalog-data-products'),data['products']);
        this.appendHtml(this.pagination,data['pagination']);


        Array.from(_this.pagination.querySelectorAll('.pagination')).map(function(paginate){
            paginate.addEventListener('click',function(){
                _this.catalog_page = paginate.getAttribute('data-page');
                _this.applyFilters();
            });
        });
    }
}