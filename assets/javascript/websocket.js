if (window.jQuery === undefined)
    throw new Error('The jQuery library is not loaded. The WebSockets plugin cannot be initialized.');

if (window.WebSocket === undefined)
    throw new Error('Your browser does not support WebSockets API. The WebSockets plugin cannot be initialized.');

+function ($) { "use strict";
    var
               NAMESPACE = 'websocket',
            TRIGGER_ATTR = NAMESPACE + '-event',
           LISTENER_ATTR = NAMESPACE + '-on',
        TRIGGER_SELECTOR = '[data-' + TRIGGER_ATTR + ']';

    var properties = queryStringToObject(getQueryString(), true),
         websocket = null;

    function init() {
        websocket = new WebSocket(properties.uri);
        websocket.onmessage = onMessage;
    }

    function onMessage(message) {
        var event = JSON.parse(message.data);

        if (!event.name) {
            throw new Error('Invalid event name.');
        }

        var attrName = LISTENER_ATTR + event.name,
            selector = '[data-' + attrName + ']';

        $(document).trigger(jQuery.Event(NAMESPACE + ':' + event.name, {payload: event.payload}));

        $(selector).each(function () {
            eval('(function(event) {' + $(this).data(attrName) + '}.call(this, event))');
        });
    }

    function websocketSend() {
        var $el   = $(this),
            $form = $el.closest('form'),
            data  = queryStringToObject($form.serialize()),
            eventName = $el.data(TRIGGER_ATTR);

        var event = {
            name: eventName,
            payload: data
        };

        websocket.send(JSON.stringify(event));
    }

    $.fn.websocketSend = websocketSend;

    $(document).on('submit', TRIGGER_SELECTOR, function (event) {
        $(this).websocketSend();
        event.preventDefault();
    });

    function queryStringToObject(queryString, decode) {
        var query = queryString.split('&'),
              obj = {};

        for (var i = 0, l = query.length; i < l; i++) {
            var keyVal = query[i].split('=');
            obj[keyVal[0]] = decode ? decodeURIComponent(keyVal[1]) : keyVal[1];
        }

        return obj;
    }

    function getQueryString() {
        var scriptTags = document.getElementsByTagName('script');
        return scriptTags[scriptTags.length - 1].src.split('?')[1];
    }

    init();
}(jQuery);
