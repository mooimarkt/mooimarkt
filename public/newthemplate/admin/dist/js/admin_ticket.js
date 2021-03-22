jQuery(function ($) {

    let $body = $('body');
    let $ticket_check = $('.ticket-check');
    let $checkbox_toggle = $('.checkbox-toggle');
    let $checkbox_toggle_i = $checkbox_toggle.find('i.fa-square-o');

    let Tickets = new Ticket({}, $);
    let Timers = [0];
    let CommentLoader = new TextLoader($("#comment-label"));

    $checkbox_toggle.click(function () {

        if ($checkbox_toggle_i.hasClass("fa-square")) {

            $checkbox_toggle_i.removeClass("fa-square").addClass('fa-square-o');

            $ticket_check.each(function () {

                if (this.checked) {
                    this.checked = false;
                }

            });

        } else {

            $checkbox_toggle_i.removeClass("fa-square-o").addClass('fa-square');

            $ticket_check.each(function () {

                if (!this.checked) {
                    this.checked = true;
                }

            });

        }

    });

    $('#comment').on('keyup',function () {

        clearTimeout(Timers[0]);

        Timers[0] = setTimeout(function () {

            CommentLoader.setTitle("Saving");
            CommentLoader.startLoading();

            Tickets.Update(
                this.dataset.id,
                {comment: this.value}
            )
                .then(function () {

                    CommentLoader.stopLoading();
                    CommentLoader.showMesage("Saved");

            })
                .catch(function (msg) {

                CommentLoader.stopLoading();
                CommentLoader.showMesage("Error");

                swal('Error',msg,'error');

            })

        }.bind(this),1500);

    })

    $('.tickets-approve').click(function () {

        let Requests = [];

        $ticket_check.each(function () {

            if (this.checked) {

                try {

                    let This = $(this);

                    This.hide();
                    This.before(`<i class="fa fa-spinner check_cpiner"></i>`);

                    Requests.push(Tickets.Update(
                        this.dataset.id,
                        {status: "approved"}
                    ));

                } catch (e) {
                    swal("Error", e.message, 'error');
                }

            }

        });

        GroupLoad(Requests);

    });

    $('.tickets-reject').click(function () {

        let Requests = [];

        $ticket_check.each(function () {

            if (this.checked) {

                try {

                    let This = $(this);

                    This.hide();
                    This.before(`<i class="fa fa-spinner check_cpiner"></i>`);

                    Requests.push(Tickets.Update(
                        this.dataset.id,
                        {status: "rejected"}
                    ));

                } catch (e) {
                    swal("Error", e.message, 'error');
                }

            }

        });

        GroupLoad(Requests);

    });

    $('.tickets-remove').click(function () {

        let Requests = [];

        $ticket_check.each(function () {

            if (this.checked) {

                try {

                    let This = $(this);

                    This.hide();
                    This.before(`<i class="fa fa-spinner check_cpiner"></i>`);

                    Requests.push(Tickets.Remove(
                        this.dataset.id,
                    ));

                } catch (e) {
                    swal("Error", e.message, 'error');
                }

            }

        });

        GroupLoad(Requests);

    });

    $('.tickets-read').click(function () {

        let Requests = [];

        $ticket_check.each(function () {

            if (this.checked) {

                try {

                    let This = $(this);

                    This.hide();
                    This.before(`<i class="fa fa-spinner check_cpiner"></i>`);

                    Requests.push(Tickets.Update(
                        this.dataset.id,
                        {status: "in_progress"}
                    ));

                } catch (e) {
                    swal("Error", e.message, 'error');
                }

            }

        });

        GroupLoad(Requests);

    });

    $body.on('click', '*[data-change-ticket]', function () {

        try {

            Tickets.Update(
                this.dataset.id,
                JSON.parse(this.dataset.changeTicket)
            )
                .then(function (resp) {

                    location.reload();

                })
                .catch(function (msg) {

                    console.log(msg);

                    swal("Error", msg, "error");

                });

        } catch (e) {
            swal("Error", e.message, "error");
        }

    })

    $body.on('click', '*[data-remove-ticket]', function () {

        try {

            Tickets.Remove(
                this.dataset.removeTicket
            )
                .then(function (resp) {

                    location.reload();

                })
                .catch(function (msg) {

                    console.log(msg);

                    swal("Error", msg, "error");

                });

        } catch (e) {
            swal("Error", e.message, "error");
        }

    })


    $body.on('click', '*[data-unblock-ad]', function () {

        try {

            Tickets.UlockAd(
                this.dataset.unblockAd
            )
                .then(function (resp) {

                    location.reload();

                })
                .catch(function (msg) {

                    console.log(msg);

                    swal("Error", msg, "error");

                });

        } catch (e) {
            swal("Error", e.message, "error");
        }

    })

    $body.on('click', '*[data-block-ad]', function () {

        try {

            Tickets.BlockAd(
                this.dataset.blockAd
            )
                .then(function (resp) {

                    location.reload();

                })
                .catch(function (msg) {

                    console.log(msg);

                    swal("Error", msg, "error");

                });

        } catch (e) {
            swal("Error", e.message, "error");
        }

    })

    $body.on('click', '*[data-remove-ad]', function () {

        try {

            Tickets.RemoveAd(
                this.dataset.removeAd
            )
                .then(function (resp) {

                    location.reload();

                })
                .catch(function (msg) {

                    console.log(msg);

                    swal("Error", msg, "error");

                });

        } catch (e) {
            swal("Error", e.message, "error");
        }

    });

    $body.on('click', "*[data-chatwith]", function () {

        $.ajax({
            type: 'POST',
            url: '/GetChat',
            data: {_token: $('meta[name="csrf-token"]').attr('content'), adId: $(this).data('chatwith')},
            success: function (data) {

                if (data.status == 'success') {
                    window.location.href = '/dialog/' + data.id;
                } else {

                    let msg = new TextLoader($(this));

                    if (typeof data.code != "unedfined") {

                        switch (data.code) {
                            case 1:
                                msg.showMesage("Please Auth.");
                                break;
                            case 2:
                                msg.showMesage("Ad not exists");
                                break;
                            case 3:
                                msg.showMesage("You can`t write yourself");
                                break;

                            default:
                                msg.showMesage("Unexpected error code");
                                break;
                        }

                    } else {
                        msg.showMesage("Unexpected responce");
                    }

                }

            }.bind(this)
        });

        return false;
    });

    function GroupLoad(Requests) {

        if (Requests.length > 0) {

            Promise.all(Requests)
                .then(function () {
                    $ticket_check.show();
                    $('.check_cpiner').remove();
                    location.reload();
                })
                .catch(function (msg) {
                    $ticket_check.show();
                    $('.check_cpiner').remove();
                    swal("Error", msg, "error");
                })

        }

    }

});