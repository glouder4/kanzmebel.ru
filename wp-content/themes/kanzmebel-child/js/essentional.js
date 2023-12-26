function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}
export default class Essentional{
    constructor(csrf) {
        if( csrf == undefined ) return 'csrf token mismatch';
        this.csrf = csrf;
    }
    makeRequest(url,data,type = 'GET'){
        let _this = this;

        return new Promise((resolve,reject) => {
            let post = data;
            let xhr = new XMLHttpRequest()
            xhr.open(type, url, true);
            xhr.setRequestHeader("X-CSRF-TOKEN", _this.csrf);
            xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
            xhr.send(post);
            xhr.onload = function () {
                if(xhr.status === 200) {
                    let games = ( isJson(xhr.response) == true ) ? JSON.parse(xhr.response) : xhr.response;
                    resolve(games);
                }
                else{
                    reject(xhr.response);
                }
            }
        });
    }
}

