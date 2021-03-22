jQuery(function ($) {

    let $body = $('body');
    let $delete_meeting = $('.delete_meeting');
    // let $confirm_user = $('.confirm_meeting');
    let $delete_user = $('.delete_user');
    let $confirm_user = $('.confirm_user');
    let $toggle_data = $('*[data-tgl]');

    $delete_user.click(function () {

        swal({
            title: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
        }).then((isConfirm) => {
            if (isConfirm.value === true) {

                    $.post("/admin/users/remove/" + this.dataset.uid, function (resp) {

                        if (resp.status == "success") {

                            swal("Removed!", {
                                icon: "success",
                            }).then(function () {
                                location.reload();
                            });

                        } else {
                            swal("Error", resp.message, "error");
                        }

                    }).fail(new PostFail());

                } else {
                    swal("Canceled");
                }
            });

    });

    $delete_meeting.click(function () {

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will be able to recover this activity",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: {
                    text: "Delete",
                    closeModal: false,
                }
            },
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post("/admin/meetings/remove/" + this.dataset.aid, function (resp) {

                        if (resp.status == "success") {

                            swal("Removed!", {
                                icon: "success",
                            }).then(function () {
                                location.reload();
                            });

                        } else {
                            swal("Error", resp.message, "error");
                        }

                    }).fail(new PostFail());

                } else {
                    swal("Canceled");
                }
            });

    });

    $confirm_user.click(function () {

        let Loader = new TextLoader($(this));

        Loader.setTitle("Confirmation");
        Loader.startLoading();

        $.post("/admin/users/confirm/" + this.dataset.uid, function (resp) {

            Loader.stopLoading();

            if (resp.status == "success") {

                Loader.showMesage("Confirmed!");

            } else {
                swal("Error", resp.message, "error");
            }


        }).fail(new PostFail(Loader))


    });

    $toggle_data.click(function (e) {
        e.preventDefault();

        let vals = this.dataset.vals;
        let prev_el = this.previousElementSibling;
        let text = prev_el.textContent.replace(/(^\s+|\s+$)/gm,"");

        vals = vals.split(",");

        switch (this.dataset.tgl) {
            case "toggle":

                let i = vals.indexOf(text);
                i = i >= vals.length - 1 ? 0 : i + 1;
                prev_el.textContent = vals[i];

                if(typeof this.dataset.rest != "undefined"){

                   let classes = this.dataset.rest.split("|");
                   let This = $(this);

                   if(classes.length > 1){

                       This = This.parents(classes[0])

                   }

                    This.find(classes.length > 1 ? classes[1] : classes[0])
                        .not(prev_el).html(vals[i >= vals.length - 1 ? 0 : i + 1]);


                }

                break;
            case "select":

                if(prev_el.getElementsByTagName("select").length > 0){return;}

                let uid = "select_" + ((Date.now() + (Math.random())).toString(36).replace(/\./, Math.ceil(Math.random() * 100)));

                prev_el.innerHTML = `
                    <select id="${uid}">
                        ${(vals.map((val,i) => { return `<option ${text==val ? "selected" : ""} value="${i}">${val}</option>` })).join("")}
                    </select>
               `;

                let select = document.getElementById(uid);
                select.focus();
                select.click();
                select.onblur = new OnBlur(vals);

                function OnBlur(valss) {

                    return function () {

                        let val = this.value;
                        val = parseInt(val);
                        val = isNaN(val) ? this.value : valss[val];

                        this.outerHTML = val;

                    }

                }

                break;

        }


    });

    $body.on('click','.retailer',function () {

        let Loader = new TextLoader($(this));

        Loader.setTitle("Changing");
        Loader.startLoading();

        $.post("/admin/users/retailer/"+this.dataset.uid,{
            is_retailer: this.classList.contains("individual") ? ( this.previousElementSibling.innerHTML == "Yes" ? 0 : 1 ) : ( this.previousElementSibling.innerHTML == "Yes" ? 1 : 0 ),
        },function (resp) {

            Loader.stopLoading();

            if (resp.status == "success") {

                Loader.showMesage("Saved");

            } else {

                Loader.showMesage("Error");
                swal("Error", resp.message, "error");

            }

        }).fail(new PostFail(Loader))

    });

    $body.on('change','.user-type select',function () {

        let $This = $(this);
        let $Parent = $This.parents(".user-type");

        let Loader = new TextLoader($Parent.find("*[data-tgl]"));

        Loader.setTitle("Changing");
        Loader.startLoading();

        $.post("/admin/users/type/" + ($Parent.data('uid')),{
            type:this.value
        }, function (resp) {

            Loader.stopLoading();

            if (resp.status == "success") {

                Loader.showMesage("Saved");

            } else {

                Loader.showMesage("Error");
                swal("Error", resp.message, "error");

            }


        }).fail(new PostFail(Loader))

    });

    function PostFail(loader) {

        return function (res) {

            if (typeof loader == "object") {

                loader.stopLoading();
                loader.showMesage("Error");

            }

            if (
                typeof res.responseJSON == "object" &&
                typeof res.responseJSON.errors == "object"
            ) {

                let msg = "";

                for (let Field in res.responseJSON.errors) {

                    msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', '));

                }

                swal("Error", msg, "error");


            } else {

                swal("Error", "Unexpected response", "error");
                console.error("Respose: ", res);

            }

        }

    }

});