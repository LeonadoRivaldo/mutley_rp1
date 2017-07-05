//MODULO DE CONTROLE COOKIES
var cookieController = function() {

    //cria cookie 
    var setCookie = function (cname, cvalue, expdays) {
        var d = new Date();
        d.setTime(d.getTime() + expdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    //procura cookie 
    var getCookie = function(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    var eraseCookie = function(name) {
        setCookie(name, "", -1);
    }

    return {
        setCookie: setCookie,
        getCookie: getCookie,
        eraseCookie: eraseCookie
    }
}
