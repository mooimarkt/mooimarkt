jQuery(function ($) {

    var $password_restore = $('#password-restore');

    if($password_restore.length > 0){

        var $popup = $password_restore.find('input[type=submit]');
        var Loader_res = new TextLoader($popup);

        $password_restore.on('submit',function (e) {

            e.preventDefault();

            Loader_res.setTitle("Restoring");
            Loader_res.startLoading();

            $.post('/forgetPasswordAjax', $password_restore.serialize(), function (res) {

                Loader_res.stopLoading();

                if(res.status == "success"){

                    Loader_res.showMesage("We sent email to you");

                }else{

                    Loader_res.showMesage(res.message ? res.message : "Unexpected Responce");

                }


            }).fail(function (res) {

                Loader_res.stopLoading();
                Loader_res.showMesage("Error");

                if (
                    typeof res.responseJSON == "object" &&
                    typeof res.responseJSON.errors == "object"
                ) {

                    let msg = "";

                    for (let Field in res.responseJSON.errors) {

                        msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                    }

                    Loader_res.showMesage(msg);

                } else {

                    Loader_res.showMesage("Unexpected response");
                    console.error("Respose: ", res);

                }

            });

        })

    }


    if ($('#auth-form-popup').length > 0) {
       var $auth_form_popup = $('#auth-form-popup');
       var auth_form_popup = $auth_form_popup.get(0);
       var $submit_popup = $auth_form_popup.find('input[type=submit]');
       var Loader_popup = new TextLoader($submit_popup);

       $auth_form_popup.on('submit',function (e) {
           e.preventDefault();
           Loader_popup.setTitle("Auth");
           Loader_popup.startLoading();

           $.post('/ajaxlogin', $auth_form_popup.serialize(), function (res) {
               Loader_popup.stopLoading();

               if(res.status == "success"){
                   Loader_popup.showMesage("Logined! Redirecting");
                   location.href = "/";
               }else{
                   Loader_popup.showMesage(res.message ? res.message : "Unexpected Responce");
               }

           }).fail(function (res) {
               Loader_popup.stopLoading();
               Loader_popup.showMesage("Error");

               if (
                   typeof res.responseJSON == "object" &&
                   typeof res.responseJSON.errors == "object"
               ) {
                   let msg = "";
                   for (let Field in res.responseJSON.errors) {

                       msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                   }
                   Loader_popup.showMesage(msg);

               } else {
                   Loader_popup.showMesage("Unexpected response");
                   console.error("Respose: ", res);
               }
           });
       });
    }

    if ($('#auth-form').length > 0) {
       var $auth_form = $('#auth-form');
       var auth_form = $auth_form.get(0);
       var $submit = $auth_form.find('input[type=submit]');

       var Loader = new TextLoader($submit);

       $auth_form.on('submit',function (e) {
           e.preventDefault();

           Loader.setTitle("Auth");
           Loader.startLoading();

           $.post('/ajaxlogin', $auth_form.serialize(), function (res) {

               Loader.stopLoading();

               if(res.status == "success"){

                   Loader.showMesage("Logined! Redirecting");

                   location.href = "/";

               }else{

                   Loader.showMesage(res.message ? res.message : "Unexpected Responce");

               }


           }).fail(function (res) {

               Loader.stopLoading();
               Loader.showMesage("Error");

               if (
                   typeof res.responseJSON == "object" &&
                   typeof res.responseJSON.errors == "object"
               ) {

                   let msg = "";

                   for (let Field in res.responseJSON.errors) {

                       msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                   }

                   Loader.showMesage(msg);

               } else {

                   Loader.showMesage("Unexpected response");
                   console.error("Respose: ", res);

               }

           });

       });
    }

    if ($('#register-form').length > 0) {
       var $register_form = $('#register-form');
       var register_form = $register_form.get(0);
       var $submit_register = $register_form.find('input[type=submit]');

       var LoaderRegister = new TextLoader($submit_register);

       $register_form.on('submit',function (e) {
           e.preventDefault();

           LoaderRegister.setTitle("Register");
           LoaderRegister.startLoading();

           $.post('/registerUserAjax', $register_form.serialize(), function (res) {

               LoaderRegister.stopLoading();

               if(res.status == "success"){

                   LoaderRegister.showMesage("Registered!");
                   $register_form[0].reset();

               }else{

                   LoaderRegister.showMesage(res.message ? res.message : "Unexpected Responce");

               }


           }).fail(function (res) {

               LoaderRegister.stopLoading();
               LoaderRegister.showMesage("Error");

               if (
                   typeof res.responseJSON == "object" &&
                   typeof res.responseJSON.errors == "object"
               ) {

                   let msg = "";

                   for (let Field in res.responseJSON.errors) {

                       msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                   }

                   LoaderRegister.showMesage(msg);

               } else {

                   LoaderRegister.showMesage("Unexpected response");
                   console.error("Respose: ", res);

               }

           });

       });
    }

    if ($('#register-form-popup').length > 0) {
       var $register_form_popup = $('#register-form-popup');
       var register_form_popup = $register_form_popup.get(0);
       var $submit_register_popup = $register_form_popup.find('input[type=submit]');

       var LoaderRegister_popup = new TextLoader($submit_register_popup);

       $register_form_popup.on('submit',function (e) {
           e.preventDefault();

           LoaderRegister_popup.setTitle("Register");
           LoaderRegister_popup.startLoading();

           $.post('/registerUserAjax', $register_form_popup.serialize(), function (res) {

               LoaderRegister_popup.stopLoading();

               if(res.status == "success"){

                   LoaderRegister_popup.showMesage("Registered!");
                   $register_form_popup[0].reset();

               }else{

                   LoaderRegister_popup.showMesage(res.message ? res.message : "Unexpected Responce");

               }


           }).fail(function (res) {

               LoaderRegister_popup.stopLoading();
               LoaderRegister_popup.showMesage("Error");

               if (
                   typeof res.responseJSON == "object" &&
                   typeof res.responseJSON.errors == "object"
               ) {

                   let msg = "";

                   for (let Field in res.responseJSON.errors) {

                       msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                   }

                   LoaderRegister_popup.showMesage(msg);

               } else {

                   LoaderRegister_popup.showMesage("Unexpected response");
                   console.error("Respose: ", res);

               }

           });

       });
    }


});