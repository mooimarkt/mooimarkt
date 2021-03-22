let Finder = function (Options, $) {

    let Defaults = {
        ads: {
            url: "/query/ads",
        },
        themplate: function () {
        }
    };

    let TypeDefaults = {
        url: "",
        type: "get",
        paginate: 'page',
        page: 1,
        query: {}
    };

    Options = Object.assign(Defaults, Options);

    this.Html = function (themplate, data) {

        return new Promise(function (resolve, rej) {

            Options.themplate = typeof themplate == 'function' ? themplate : Options.themplate;

            if (
                typeof data != "undefined" &&
                typeof Options.themplate != "undefined"
            ) {

                if (typeof data.then == "function") {

                    data
                        .then(res => resolve(Options.themplate(res)))
                        .catch(res => rej(res))

                } else {

                    resolve(Options.themplate(data))

                }

            }

        });

    };

    this.Next = function (type) {

        return new Promise(function (res, rej) {

            if (
                typeof type != "undefined" &&
                typeof Options[type] == "object" &&
                typeof Options[type].url == "string" &&
                typeof Options[type].query == "object"
            ) {

                Options[type] = Object.assign(TypeDefaults, Options[type]);

                Options[type].page++;
                Options[type].query[Options[type].paginate] = Options[type].page;

                res(this.Get(type, Options[type].query));

            }

            rej();

        }.bind(this))

    };

    this.Get = function (type, query) {

        return new Promise(function (resolve, rej) {

            if (
                typeof type != "undefined" &&
                typeof Options[type] == "object" &&
                typeof Options[type].url == "string"
            ) {

                Options[type] = Object.assign(TypeDefaults, Options[type]);

                query = typeof  query != 'undefined' ? query : {};

                Options[type].query = query;
                Options[type].page = typeof Options[type].query[Options[type].paginate] == "number" ? Options[type].query[Options[type].paginate] : 1;

                $[
                    typeof Options[type].type != "undefined" ? Options[type].type : "post"
                    ](
                    Options[type].url, query, res => resolve(res)).fail(function (res) {

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

                });


            }

        })

    }

};