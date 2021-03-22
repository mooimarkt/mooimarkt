function RegValidator(Fields) {

    if(typeof Fields == "object"){

        let res = [];

        for(let field_name in Fields){

            let pass = true;

            if(typeof Fields[field_name].el != 'undefined'){

                let val = Fields[field_name].el.value;

                Fields[field_name].el.classList.remove('error');

                pass = !(typeof Fields[field_name].len != "undefined" &&
                isFinite(Fields[field_name].len) &&
                Fields[field_name].len > val.length);

                pass = pass && typeof Fields[field_name].eq != "undefined" ? val == Fields[field_name].eq : pass;

                pass = pass && typeof Fields[field_name].eqEl != "undefined" ? val == Fields[field_name].eqEl.value : pass;

                pass = pass && typeof Fields[field_name].reg != "undefined" ? Fields[field_name].reg.test(val) : pass;

                if(!pass){

                    Fields[field_name].el.classList.add('error');

                    res.push(field_name);

                    Fields[field_name].el.onkeyup = function () {

                        let obj = {};
                        obj[field_name] = Fields[field_name];

                        RegValidator(obj);

                    }

                }

            }

        }

        return res.length <= 0;

    }

    return false;

}