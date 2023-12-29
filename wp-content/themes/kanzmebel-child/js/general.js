document.addEventListener("DOMContentLoaded", () => {
    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });

    function checkCookies(){
        let cookieDate = localStorage.getItem('cookieDate');
        let cookieNotification = document.getElementById('cookie_notification');
        let cookieBtn = cookieNotification.querySelector('.cookie_accept');

        // Если записи про кукисы нет или она просрочена на 1 год, то показываем информацию про кукисы
        if( !cookieDate || (+cookieDate + 31536000000) < Date.now() ){
            cookieNotification.classList.add('show');
        }

        // При клике на кнопку, в локальное хранилище записывается текущая дата в системе UNIX
        cookieBtn.addEventListener('click', function(){
            localStorage.setItem( 'cookieDate', Date.now() );
            cookieNotification.classList.remove('show');
        })
    }
    checkCookies();
});

window.addEventListener("DOMContentLoaded", function() {
    function maskTelInput(inputs){
        [].forEach.call( inputs, function(input) {
            var keyCode;
            function mask(event) {
                event.keyCode && (keyCode = event.keyCode);
                var pos = this.selectionStart;
                if (pos < 3) event.preventDefault();
                var matrix = "+7 (___) ___ __-__",
                    i = 0,
                    def = matrix.replace(/\D/g, ""),
                    val = this.value.replace(/\D/g, ""),
                    new_value = matrix.replace(/[_\d]/g, function(a) {
                        return i < val.length ? val.charAt(i++) : a
                    });
                i = new_value.indexOf("_");
                if (i != -1) {
                    i < 5 && (i = 3);
                    new_value = new_value.slice(0, i)
                }
                var reg = matrix.substr(0, this.value.length).replace(/_+/g,
                    function(a) {
                        return "\\d{1," + a.length + "}"
                    }).replace(/[+()]/g, "\\$&");
                reg = new RegExp("^" + reg + "$");
                if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) {
                    this.value = new_value;
                }
                if (event.type == "blur" && this.value.length < 5) {
                    this.value = "";
                }
            }

            input.addEventListener("input", mask, false);
            input.addEventListener("focus", mask, false);
            input.addEventListener("blur", mask, false);
            input.addEventListener("keydown", mask, false);

        });
    }
    maskTelInput(document.querySelectorAll('input[type="phone"]'));
    maskTelInput(document.querySelectorAll('input[type="tel"]'));


    function send_smtp_data(form){
        let name = form.querySelector('input[type="name"]').value;
        let phone = form.querySelector('input[type="phone"]').value;
        let email = form.querySelector('input[type="email"]').value;

        if( name != "" && phone != "" && email != "" ){
            let data = new FormData();
            data.append('_wpcf7',220);
            data.append('_wpcf7_version','5.8.5');
            data.append('_wpcf7_locale','ru_RU');
            data.append('_wpcf7_unit_tag','wpcf7-f220-o1');
            data.append('wpcf7_container_post',0);
            data.append('_wpcf7_posted_data_hash','');

            data.append('text-622',name);
            data.append('tel-566',phone);
            data.append('email-72',email);
            /*let data = {
                '_wpcf7' : 220,
                '_wpcf7_version': '5.8.5',
                '_wpcf7_locale': 'ru_RU',
                '_wpcf7_unit_tag': 'wpcf7-f220-o1',
                'wpcf7_container_post': 0,
                '_wpcf7_posted_data_hash': '',
                'text-622': name,
                'tel-566': phone,
                'email-72': email
            };*/

            let post = data;//JSON.stringify(data);
            let xhr = new XMLHttpRequest()
            xhr.open('POST', '/wp-json/contact-form-7/v1/contact-forms/220/feedback', true);
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
            xhr.send(post);
            xhr.onload = function () {
                console.log(xhr)
                if(xhr.status === 200) {

                }
                else{
                }
            }
        }
    }
    let smtp_form_buttons = document.querySelectorAll('.smtp_send_form');

    Array.from(smtp_form_buttons).map(function(button){
        button.addEventListener('click',function(){
            send_smtp_data(button.parentNode);
        });
    });
});