let SimpleSave = function (options,$) {

    let Defaults = {
        url:"/searches/api",
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

    this.Update = function (sid,search) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"update",sid,search },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.Remove = function (sid) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"remove",sid },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };

    this.Create = function (search) {

        return new Promise(function (resolve,rej) {

            $.post(Options.url,{ action:"create",search },
                new Handler(resolve,rej))
                .fail(new Fail(rej))

        });

    };


};