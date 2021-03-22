let Elavon = function (Options, $) {

    let Dafults = {
        pay_url: "/pay_cc",
    };

    Options = Object.assign(Dafults, Options);

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

    let Card = function (card) {

        let Dafults = {
            'num': 0,
            'exp': 0,
            'cvv': 0,
            'type': 0,
            'name': "#$noname$#",
        };

        let CardProto = function () {

            let CredOptions = {
                Reg:[
                    /^4[0-9]{6,}$/,//VISA
                    /^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$/,//mc
                    /^3[47][0-9]{5,}$/,//amex
                    /^6(?:011|5[0-9]{2})[0-9]{3,}$/,//cb Discover
                    /^3(?:0[0-5]|[68][0-9])[0-9]{4,}$/,//dinners
                    /^(?:2131|1800|35[0-9]{3})[0-9]{3,}$/,//jcb
                ]
            };

            this.getCardType = function () {

                for(let i in CredOptions.Reg){

                    i = parseInt(i);

                    if(CredOptions.Reg[i].test(this.num)){

                        return i+1;

                    }

                }

                return 0

            };

            this.Type = function () {

                switch (this.type){
                    case 1:
                        return "Visa";
                    case 2:
                        return "MasterCard";
                    case 3:
                        return "American Express";
                    case 4:
                        return "Discover";
                    case 5:
                        return "Diners Club";
                    case 6:
                        return "JCB";
                    default:
                        return "Untyped";
                }

            };

            this.Prepare = function () {

                if(this.type == 0){

                    this.type = this.getCardType();

                }

                if(this.name == "#$noname$#"){
                    delete this.name;
                }

            }

        };

        card = Object.assign(Dafults, card);

        card.__proto__ = new CardProto();

        card.Prepare();

        return card;

    };

    this.Card = function (card) {

        return new Card(card);

    };

    this.Pay = function (summ, card) {

        return new Promise(function (resolve, rej) {

            $.post(Options.pay_url + "/" + summ, card, function (resp) {

                if (resp.status == "success") {

                    resolve(resp);

                } else {

                    rej(typeof resp.message != "undefined" ? resp.message : "Unexpected Responce")

                }

            }).fail(new Fail(rej));

        })

    }

};