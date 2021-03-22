jQuery(function ($) {

    if ($('#search_form_index_tag').length > 0) {

        let $body = $('body');
        let $form = $('#search_form_index_tag');
        let form = $form.get(0);
        let $input = $(form.search);
        let $submit = $(form.submit);
        let Timers = [0, 0, 0];
        let Notified = localStorage.getItem("TagNotify") != null;
        let $notify = $form.find(".notify");
        let $sub_filt_cont = $('.sub-filter-container');

        $form.on('submit', function (e) {
            $('#search_form_index_tag input[name="tags[]"]').remove();

            $('.sub-filter-container .sub-filt-bl').each(function(i,elem) {
                $form.append('<input type="hidden" name="tags[]" value="'+$(elem).data('val')+'">');
            });
        });

        $input.on('keydown', function (e) {

            if (e.keyCode == 13) {

                AddTag();
                return false;

            } else {

                showTagNotify();

            }

        });

        function showTagNotify() {

            if (Notified) return;

            delayTagNotify();

            Timers[0] = setTimeout(function () {

                $notify.show();
                Notified = true;

                Timers[1] = setTimeout(function () {
                    $notify.fadeOut(500);
                }, 3000);

            }, 600);

        }

        function delayTagNotify() {

            if ($notify.is(":hidden")) {

                clearTimeout(Timers[0]);
                clearTimeout(Timers[1]);

            }

        }

        function AddTag() {

            var val = $input.val();

            if (val.length > 0) {

                var sval = val.replace(/\s/, "_").replace(/[^0-9a-zA-Z_]/g, "-").toLowerCase();

                if ($sub_filt_cont.find(".blue_btn[data-val^=" + sval + "]").length <= 0) {

                    $sub_filt_cont.append(`
                       <div class="blue_btn sub-filt-bl" data-val="${sval}">
                           <span>${val}</span>
                           <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove">
                       </div>
                   `);

                }

                $input.val("");

                localStorage.setItem("TagNotify", 1);

            }

        }

        $body.on('click', '.blue_btn .close_sb_f', function () {
            $(this).parents('.blue_btn').remove();
        })
    }

});