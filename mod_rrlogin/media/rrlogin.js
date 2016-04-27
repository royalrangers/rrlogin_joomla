var Rrlogin = Rrlogin || {

    initialize:function () {
        var block = document.getElementById('rrlogin-buttons');
        if (block === null) return;
        var elements = block.getElementsByTagName('a');
        var params = "resizable=yes,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes";
        for (var i = 0; i < elements.length; i++) {
            if(elements[i].getAttribute('id') == 'uLogin'){
                continue;
            }
            elements[i].onclick = function (e) {
                if (typeof(PopUpWindow) == 'window') {
                    PopUpWindow.close();
                }
                var el = this.getElementsByTagName('span');
                var size = Rrlogin.getPopUpSize(el[0].className);
                var win_size = Rrlogin.WindowSize();
                var centerWidth = (win_size.width - size.width) / 2;
                var centerHeight = (win_size.height - size.height) / 2;
                var PopUpWindow = window.open(
                    this.href,
                    'LoginPopUp',
                    'width=' + size.width
                        + ',height=' + size.height
                        + ',left=' + centerWidth
                        + ',top=' + centerHeight
                        + ',' + params
                );
                PopUpWindow.focus();
                return false;
            }

        }

    },

    WindowSize:function () {
        var myWidth = 0, myHeight = 0, size = {width:0, height:0};
        if (typeof( window.innerWidth ) == 'number') {
            //Non-IE
            myWidth = window.innerWidth;
            myHeight = window.innerHeight;
        } else if (document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight )) {
            //IE 6+ in 'standards compliant mode'
            myWidth = document.documentElement.clientWidth;
            myHeight = document.documentElement.clientHeight;
        } else if (document.body && ( document.body.clientWidth || document.body.clientHeight )) {
            //IE 4 compatible
            myWidth = document.body.clientWidth;
            myHeight = document.body.clientHeight;
        }
        size.width = myWidth;
        size.height = myHeight;

        return size;
    },

    getPopUpSize:function (el) {
        var size = {width:0, height:0};

        switch (el) {
            case 'vkontakterrlogin':
                size = {width:900, height:550};
                break;
            case 'googlerrlogin':
                size = {width:450, height:450};
                break;
            case 'facebookrrlogin':
                size = {width:1200, height:600};
                break;
            case 'twitterrrlogin':
                size = {width:450, height:550};
                break;
            case 'yandexrrlogin':
                size = {width:900, height:550};
                break;
            case 'linkedinrrlogin':
                size = {width:350, height:450};
                break;
            case 'odnoklassnikirrlogin':
                size = {width:550, height:250};
                break;
            case 'mailrrlogin':
                size = {width:450, height:325};
                break;
            default:
                size = {width:900, height:550};
                break;
        }

        return size;
    },

    addListener:function (obj, type, listener) {
        if (obj.addEventListener) {
            obj.addEventListener(type, listener, false);
            return true;
        } else if (obj.attachEvent) {
            obj.attachEvent('on' + type, listener);
            return true;
        }
        return false;
    },

    loadModuleAjax:function () {
        Rrlogin.getUrl('/index.php?option=com_rrlogin&task=load_module_ajax');

    },

    printProviders:function (resp) {
        document.getElementById('mod_rrlogin').innerHTML = resp;
        Rrlogin.initialize();
    },

    getXmlHttp:function () {
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } catch (ee) {
            }
        }
        if (typeof XMLHttpRequest != 'undefined') {
            return new XMLHttpRequest();
        }
    },

    getUrl:function (url) {
        var xmlhttp = Rrlogin.getXmlHttp();
        xmlhttp.open("GET", url);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4) {
                var resp = xmlhttp.responseText;
                Rrlogin.printProviders(resp);
            }
        }
        xmlhttp.send(null);
    }

};

Rrlogin.addListener(window, 'load', function () {
    Rrlogin.initialize();
});