jQuery(function ($) {

    let Rates = {

    };

    $('body')
        .on('click','.rating_block',function () {


        if(this.classList.contains('active')){

            this.classList.remove("active");
            this.previousElementSibling ? this.previousElementSibling.classList.add("active") : this.nextElementSibling.classList.add("active");

        }else{

            this.classList.add("active");
            this.previousElementSibling ? this.previousElementSibling.classList.remove("active") : this.nextElementSibling.classList.remove("active");

        }


    })
        .on('click','.rate-box .swal-button--confirm',function () {

            let rate = $('.rating_block.rate_plus.active').length - $('.rating_block.rate_minus.active').length;
            let holder = $('.swal-rate-holder');
            let activity = holder.data('activity');
            let rid = holder.data('rid');

            $.ajax({
                url: '/activity/' + activity,
                type: 'POST',
                dataType: 'json',
                data: {_method: 'patch', mark: rate},
            })
                .done(function (res) {

                    $('.gold_star.rating-stars[data-rid='+rid+']').attr('data-rated',"true")
                        .attr('data-rate',rate);

                    Rates[rid].setRateing(rate);

                })
                .fail(function (res) {

                    if( typeof res.responseJSON.error == "string" ){

                        swal("Error",res.responseJSON.error,'error');
                        return;
                    }

                    if (
                        typeof res.responseJSON == "object" &&
                        typeof res.responseJSON.errors == "object"
                    ) {

                        let msg = "";

                        for (let Field in res.responseJSON.errors) {

                            msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";

                        }

                        swal("Error",msg,'error');

                    } else {

                        swal("Error","Unexpected response",'error');
                        console.error("Respose: ", res);

                    }

                })
                .always(function () {
                    console.log("complete");
                });

        });

    $('.gold_star.rating-stars').click(function () {

        if (this.dataset.rated == "false") {

            let html = document.createElement("div");
            html.setAttribute('data-activity',this.dataset.activity);
            html.setAttribute('data-rid',this.dataset.rid);
            html.classList.add('swal-rate-holder');
            let questions = this.dataset.type == 'meeting' ?
                [
                    "Confirm meet up time, date, location",
                    "Show Up",
                    "Punctual",
                    "Product Match",
                    "Good Overall Experience",
                ] : [
                    "Upload shipping tracking code",
                    "Agree payment term and amount",
                    "On time Shipment",
                    "Product Match",
                    "Good Overall Experience"
                ];
            html.innerHTML = (() => {

                return (questions.map(question => {
                    return `<div class="question-row">
                                <span class="question">${question}</span>
                                <span class="actions">
                                    <div class="rating_block rate_plus">
                                        <img src="/newthemplate/img/pr_like.svg" alt="Alternate Text">
                                        <span>+1</span>
                                    </div>
                                    <div class="rating_block rate_minus">
                                        <img src="/newthemplate/img/pr_dislike.svg" alt="Alternate Text">
                                        <span>-1</span>
                                    </div>
                                </span>
                             </div>`
                })).join("");

            })();

            swal({
                title: "Rate",
                content: html,
                className:'rate-box'
            })

        }

    });

    $('.rating-stars').each(function (i) {

        this.dataset.rid = i;

        Rates[i] = $(this).starsRateing({
            width: 40,
            heigth: 40,
            showRate: false,
            rate: this.dataset.rate ? this.dataset.rate : 0,
            disabled: true,
            rateStep: 1,
            onRate: function (rate) {
                var activity = $(this).data('activity');

                $.ajax({
                    url: '/activity/' + activity,
                    type: 'POST',
                    dataType: 'json',
                    data: {_method: 'patch', mark: rate},
                })
                    .done(function () {
                        console.log("success");
                    })
                    .fail(function () {
                        console.log("error");
                    })
                    .always(function () {
                        console.log("complete");
                    });
            }
        });

    });


});