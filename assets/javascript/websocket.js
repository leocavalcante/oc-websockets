if (window.jQuery === undefined)
    throw new Error('The jQuery library is not loaded. The October CMS framework cannot be initialized.');

+function ($) { "use strict";
    var scriptTags = document.getElementsByTagName('script');
    var scriptTag = scriptTags[scriptTags.length - 1];
    var scriptSrc = scriptTag.src;
    var queryString = scriptSrc.split('?')[1];
    var query = queryString.split('&');
    var props = {};

    for (var i = 0, l = query.length; i < l; i++) {
        var keyVal = query[i].split('=');
        props[keyVal[0]] = decodeURIComponent(keyVal[1]);
    }

    var ws = new WebSocket(props.uri);

    ws.onmessage = function (msg) {
        var data = JSON.parse(msg.data);

        $(document).trigger(jQuery.Event('ws:'+data.event, data));

        $('[data-ws-on'+data.event+']').each(function () {
            eval('(function(data) {'+$(this).data('ws-on'+data.event)+'}.call(this, data))');
        });
    };

    $.fn.wsSend = function () {
        var $this = $(this);
        var form  = $this.closest('form');
        var data  = form.serializeObject();

        data.event = $this.data('ws-send');
        ws.send(JSON.stringify(data));
    }

    $(document).on('submit', '[data-ws-send]', function documentOnsubmit () {
        $(this).wsSend();
        return false;
    });

    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
}(jQuery);
