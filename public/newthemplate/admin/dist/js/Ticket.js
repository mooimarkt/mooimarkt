let Ticket = function (options,$) {

    let Defaults = {
        url:"/admin/tickets/api",
    };

    let Options = Object.assign(Defaults,options);

    let Handler = function (resolve,rej) {

        return function (res) {

            if(res.status == "success"){

                resolve(res);

            }else{

                rej(typeof res.message != "undefined" ? res.message : "Unexpected responce");

            }

        }

    };

    let Fail = function (rej) {

        return function (res) {

            if (
                typeof res.responseJSON == "object" &&
                typeof res.responseJSON.errors == "object"
            ) {

                let msg = "";

                for (let Field in res.responseJSON.errors) {

                    msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                }

                rej(msg);

            } else {

                rej("Unexpected response");
                console.error("Respose: ", res);

            }

        }

    };

    this.Update = function (tid,ticket) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"update",tid,ticket },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.Remove = function (tid) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"remove",tid },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.Create = function (ticket) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"create",ticket },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.BlockAd = function (tid) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"blockad",tid },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.UlockAd = function (tid) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"unblock",tid },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.RemoveAd = function (tid) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"removead",tid },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

};