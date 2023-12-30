import Essentional from "./essentional.js";

export default class ShopPageCatalog extends Essentional{
    constructor(catalog,filter_btn,filters,load_products = true) {
        super(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        if( catalog == undefined || catalog == null ){
            console.log('catalog is mismatch')
            return 'catalog is mismatch';
        }
        if( filter_btn == undefined || filter_btn == null ){
            console.log('filter_btn is mismatch')
            return 'filter_btn is mismatch';
        }
        if( filters == undefined || filters == null ){
            console.log('filters is mismatch')
            return 'filters is mismatch';
        }

        if( filters.querySelector('.close') == undefined ){
            console.log('filters .close is mismatch');
            return 'filters .close is mismatch';
        }
        if( document.getElementById('catalog-data-products') == undefined ){
            console.log('catalog-data-products is mismatch')
            return 'catalog-data-products is mismatch';
        }
        /*if( document.getElementById('catalog-data-pagination') == undefined ){
            console.log('catalog-data-pagination is mismatch')
            return 'catalog-data-pagination is mismatch';
        }*/
        if( document.getElementById('filters-submit_btn') == undefined ){
            console.log('filters-submit_btn is mismatch')
            return 'filters-submit_btn is mismatch';
        }


        this.catalog = catalog;
        this.filter_btn = filter_btn;
        this.filters = filters;
        this.load_products  = load_products;
        this.endpoint = this.catalog.getAttribute('data-endpoint');
        //this.pagination = document.getElementById('catalog-data-pagination');

        this.catalog_page = 0;

        this.apply_filters_btn = document.getElementById('filters-submit_btn');

        let _this = this;

        this.filters.querySelector('.close').addEventListener('click',function(){
            _this.filters.classList.remove('show');
        })

        Array.from(this.filter_btn).map(function (btn){
            btn.addEventListener('click',function(){
                _this.openFilters();
            });
        })
        this.apply_filters_btn.addEventListener('click',function(){
            _this.applyFilters();
        });

        this.filter_settings = {};

        if( _this.load_products ){
            let data = {
                'action': 'get_products',
                'paged': this.catalog_page
            };
            this.makeRequest(this.catalog.getAttribute('data-endpoint'),JSON.stringify(data),'POST').then(function(data){
                _this.appendProducts(data);
            });
        }

        if( window.innerWidth >= 1200 ) {
            this.openFilters();
        }
    }
    applyFilters(){
        let _this = this;
        const form = this.filters.querySelector('form');

        let data = this.filter_settings;
        data.action = 'get_products';
        data.taxonomies = '';
        data['paged'] = this.catalog_page;
        data['csrf_token'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Array.from(
            new FormData(form),
            function(e) { return e.map(encodeURIComponent).join('='); }
        ).map(function (val){
            let key = val.split('=')[0];
            let value = val.split('=')[1];

            if( key.split('taxonomy-')[1] != undefined ){
                value = key.split('taxonomy-')[1];

                //_this.filter_settings.taxonomies.push(value);

                if( data.taxonomies == '' ) _this.filter_settings.taxonomies += value;
                else _this.filter_settings.taxonomies += '_'+value;
            }
            else{
                _this.filter_settings[key] = value;
            }
        });



        this.filters.classList.remove('show');

        if( this.load_products ){
            if( this.filter_settings.hasOwnProperty('price_min') && this.filter_settings.hasOwnProperty('price_max') ){
                this.filter_settings.price_range = this.filter_settings.price_min+'|'+this.filter_settings.price_max;
            }

            this.makeRequest(this.catalog.getAttribute('data-endpoint'),JSON.stringify(data),'POST').then(function(data){
                _this.appendProducts(data);
            });
        }
        else{
            let exclude = ['taxonomies','action','price_min','price_max'];
            let request = '?';
            Object.keys(_this.filter_settings).forEach(function(key,val){
                if( !exclude.includes(key) ) request += key+'='+_this.filter_settings[key]+'&';
            });

            if( _this.filter_settings.hasOwnProperty('taxonomies') && _this.filter_settings['taxonomies'].length > 0 ){
                request += 'taxonomies=';
                _this.filter_settings['taxonomies'].map(function (tax){
                    request += tax+'_';
                });
                request = request.substring(0, request.length - 1);
            }
            else  if( _this.filter_settings.hasOwnProperty('price_min') && _this.filter_settings.hasOwnProperty('price_max') ){
                request += '&price_range='+_this.filter_settings.price_min+'|'+_this.filter_settings.price_max;
            }
            else request = request.substring(0, request.length - 1);

            window.location.href = location.protocol + '//' + location.host + location.pathname+request;
        }
    }
    openFilters(){
        this.filters.classList.add('show');

        let rangeMin = 100;
        const range = document.querySelector(".range-selected");
        const rangeInput = document.querySelectorAll(".range-input input");
        const rangePrice = document.querySelectorAll(".range-price input");
        rangeInput.forEach((e) => {
            let minRange = parseInt(rangeInput[0].value);
            let maxRange = parseInt(rangeInput[1].value);
            if (maxRange - minRange < rangeMin) {
                console.log(e)
                if ( e.className === 'min' || e.target.className === "min") {
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
        //this.pagination.innerHTML = '';
        this.appendHtml(document.getElementById('catalog-data-products'),data);
        //this.appendHtml(this.pagination,data['pagination']);


        /*Array.from(_this.pagination.querySelectorAll('.pagination')).map(function(paginate){
            paginate.addEventListener('click',function(){
                _this.catalog_page = paginate.getAttribute('data-page');
                _this.applyFilters();
            });
        });*/
    }
}