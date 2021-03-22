jQuery(function ($) {

    let $user_form = $('#user-form');
    let $profile_user_img = $('.profile-user-img');

    $('#userPhotoUpload').fileupload({
        dataType: 'json',
        singleFileUploads: true,
        done: function (e, data) {

            if(
                data.result.errors == 0 &&
                Array.isArray(data.result.images) &&
                data.result.images.length > 0
            ){

                $profile_user_img.attr('src',data.result.images[0])

            }

        },
        fail: function (e, data) {
            swal(data);
        }
    });

    $user_form.on('submit', function (e) {
        e.preventDefault();

        let user = {
            name: this.name.value,
            lname: this.lname.value,
            email: this.email.value,
            password: this.password.value,
        };

        User(user)
            .then(function () {

                swal("Created", "User Created!", "success");

            })
            .catch(function (msg) {



                swal("Error",{
                    content:(()=>{
                        let el = document.createElement("div");
                        el.innerHTML = msg;
                        return el;
                    })(),
                    icon:"error"
                });

            })

    });


    function User(user) {

        return new Promise(function (resolve, rej) {

            if (typeof user == "object") {

                $.post('/admin/users/user', {
                    user: user
                }, function (res) {

                    if (res.status == "success") {

                        resolve(res);

                    } else {

                        rej(resp.message ? resp.message : "Unexpected responce");

                    }

                }).fail(new PostFail(rej))

            }

        })

    }

    function PostFail(rej) {

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

    }

});