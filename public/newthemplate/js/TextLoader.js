function TextLoader($el, options) {
    if ($el.length == 0)
        return;

    options = typeof options == "object" ? options : {};

    let is_input = $el.get(0).nodeName == "INPUT";
    let tlId = $el.data('tlId');
    let html = is_input ? $el.val() : $el.html();
    let timers = [0, 0, 0];
    let cc = 0;
    let interval = 100;
    let title = "Loading";
    let Options = Object.assign({
        showClass: false,
        showTime: 2,
    }, options);

    let getTlId = function () {
        return Date.now().toString(36);
    };

    if (typeof tlId == "undefined") {
        tlId = getTlId();
        $el.attr('data-tl-id', tlId);

        TextLoader.defaults[tlId] = html;
    } else {
        html = TextLoader.defaults[tlId];
    }

    this.startLoading = function () {

        clearInterval(timers[0]);
        clearInterval(timers[1]);

        timers[0] = setInterval(function () {
            cc = cc > 3 ? 0 : cc + 1;
            if (is_input) {
                $el.val(title + ((new Array(cc)).join(".")));
            } else {
                $el.html(title + ((new Array(cc)).join(".")));
            }

        }, interval);

        timers[1] = setTimeout(function () {

            this.stopLoading();

        }.bind(this), 60000);

    };

    this.stopLoading = function () {

        clearInterval(timers[0]);
        clearInterval(timers[1]);
        if (is_input) {
            $el.val(html);
        } else {
            $el.html(html);
        }
        title = "Loading";

    };

    this.setTitle = function (t) {

        cc = 0;
        title = typeof t == "string" ? t : title;

    };

    this.hideLoader = function () {

        this.stopLoading();
        $el.hide();

    };

    this.showLoader = function () {
        $el.show();
    };

    this.showMesage = function (msg) {

        clearTimeout(timers[2]);

        if (typeof msg == "string") {

            if (is_input) {
                $el.val(msg);
            } else {
                $el.html(msg);
            }

            if (Options.showClass) {

                $el.addClass(Options.showClass);

            }

            timers[2] = setTimeout(function () {
                if (is_input) {
                    $el.val(html);
                } else {
                    $el.html(html);
                }
                if (Options.showClass) {
                    $el.removeClass(Options.showClass);
                }
            }, Options.showTime * 1000);

        }

    }

}

TextLoader.__proto__.defaults = {};