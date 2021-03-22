
    <!--baner-footer-->
    <section id="baner-footer" class="baner-footer">
        <div class="container container-baner-footer">
            <h2><span>PLEASE SHARE</span> YOUR B4MX EXPERIENCE WITH US</h2>
            <div class="messenger"><form action="/messages-list"><button type="submit">Send to Messenger</button></form></div>
        </div>
    </section>
    <!--baner-footer end-->
    <!--footer-->
    <footer id="footer" class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="logo-footer">
                    <a class="brand" href="/"><img src="/newthemplate/img/logo.svg" /></a>
                </div>
                <ul class="footer-menu">
                    <li><a href="/terms" class="border-a">Term of use</a></li>
                    <li><a href="/policy" class="border-a">Privacy Policy</a></li>
                    <li><a href="/pricing" class="border-a">Pricing</a></li>
                    <li><a href="/contact-us" class="border-a">Contact Us</a></li>
                </ul>
                <ul class="social-icon">
                    <li>
                        <a href="/share/facebook" onclick="window.open(this.href,'facebook','width=500,height=700');return false;" class="facebook">
                            <img src="/newthemplate/img/facebook.svg" />
                            <span>Liked {{intval(App\Option::getSetting("social_count_facebook"))}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/share/twitter" onclick="window.open(this.href,'twitter','width=500,height=700');return false;" target="_blank" class="twitter">
                            <img src="/newthemplate/img/twitter.svg"/>
                            <span>Liked {{intval(App\Option::getSetting("social_count_twitter"))}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/share/pinterest" onclick="window.open(this.href,'pinterest','width=500,height=700');return false;" target="_blank" class="pinterest">
                            <img src="/newthemplate/img/pinterest.svg"/>
                            <span>Liked {{intval(App\Option::getSetting("social_count_pinterest"))}}</span>
                        </a>
                    </li>
                    <li>
                        <a href="/share/instagramm" onclick="window.open(this.href,'instagramm','width=500,height=700');return false;" target="_blank" class="instagram">
                            <img src="/newthemplate/img/in.svg"/>
                            <span>Liked {{intval(App\Option::getSetting("social_count_instagramm"))}}</span>
                        </a>
                    </li>
                </ul>
                <div class="select-grup">
                    <select class="language">
                      <option value="">English</option>
                      <option value="1">China</option>
                      <option value="2">Arabian</option>
                    </select>

                    <select id="currency">
                        @php
                            $currencies = array('default', 'USD', 'EUR', 'GBP');
                        @endphp
                        @foreach ($currencies as $currency)
                        <option value="{{ $currency }}"{{ session()->get('currency', 'default') == $currency ? ' selected' : '' }}>{{ $currency }}</option>
                        @endforeach
                    </select>
                  </div>
            </div>
        </div>
        <div class="copyright"><p>© 2005-{{date('Y')}} All Rights Reserved</p></div>
    </footer>
</div>
    <!-- footer end -->   
	<script src="/newthemplate/bower_components/jquery/jquery.min.js"></script>
    <script src="/newthemplate/bower_components/swiper/dist/js/swiper.js"></script>
    <!-- build:js js/main.js -->
    <script src="/newthemplate/js/JavaScript.js"></script>
    <script src="/newthemplate/js/TextLoader.js"></script>
    <script src="/newthemplate/js/Finder.js"></script>
    <script src="/newthemplate/js/SimpleSave.js"></script>
    <script src="/newthemplate/js/Validator.js"></script>
    <script src="/newthemplate/js/jquery.3.3.1.js"></script>
    <script src="/newthemplate/js/ajax-setup.js"></script>
    <script src="/newthemplate/js/wow.js"></script>
    <script src="/newthemplate/js/favorite.js"></script>
    <script>new WOW().init();</script>
    <script src="/newthemplate/js/app.js"></script>
    <script src="/newthemplate/js/login.js"></script>

    <script src="/newthemplate/js/max.js"></script>

    <script src="/js/fileupload/vendor/jquery.ui.widget.js"></script>
    <script src="/js/fileupload/jquery.iframe-transport.js"></script>
    <script src="/js/fileupload/jquery.fileupload.js"></script>
    <script src="/newthemplate/js/jquery.easy-autocomplete.js"></script>
    <script src="/newthemplate/js/sweetalert.min.js"></script>
    <script src="/newthemplate/bower_components/star-rateing/star-rating.js"></script>
    <script src="/newthemplate/js/activities.js"></script>
    <script src="/newthemplate/bower_components/select2/js/select2.min.js"></script>
    <script src="/newthemplate/js/jquery.mask.js"></script>

    @if(isset($Page) && $Page == "place_add")
        <script src="/newthemplate/bower_components/select2/js/select2.min.js"></script>
        <script src="/newthemplate/js/place_add.js"></script>
    @endif

    @if(isset($Page) && $Page == "add-listing")
        <script src="/newthemplate/js/search.js"></script>
    @endif

    @if(isset($Page) && $Page == "my_seved_searches")
        <script src="/newthemplate/js/my_seved_searches.js"></script>
    @endif

    @if(isset($Page) && $Page == "getProfilePage")
    <script type="text/javascript">
         $('form#profile-settings').on('submit', function() {
            if (typeof $('input[name="subscription"]:checked').data('price') != 'undefined') {
              $('input[name="price_subscription"]').val($('input[name="subscription"]:checked').data('price'));
            }
         });

         $('label.period').on('click', function() {
            $('label.period').css('background', '#fff');
            $('label.period').css('color', '#000');

            $(this).css('background', '#0084ff');
            $(this).css('color', '#fff');
         });

         $('input[name="Period"]').on('change', function() {
            var period = parseInt($(this).val());
            console.log(period);
            if (period == 12) {
               $('.place_price_block').each(function(i,elem) {
                  let price = $(elem).find('input[name="subscription"]').data('price');
                  price = price - (price / 100 * 5);
                  $(elem).find('input[name="subscription"]').attr('data-price', price);
                  $(elem).find('.pack_price').text(price);
               });
            } else {
               $('.place_price_block').each(function(i,elem) {
                  $(elem).find('input[name="subscription"]').attr('data-price', $(elem).find('input[name="subscription"]').data('realprice'));
                  $(elem).find('.pack_price').text($(elem).find('input[name="subscription"]').data('realprice'));
               });
            }
         });

         var $voucher = $('#voucher');
         $voucher.change(function(event) {
           $.ajax({
               url: '/voucher-trader/check',
               type: 'POST',
               dataType: 'json',
               data: {
                   voucherCode: $(this).val()
               },
           })
           .done(function(data) {
               $.each(data, function(index, el) {
                   $('label[for=adsSelectedType' + (index + 1) + '] .pl-pr-left span').text(el);
                   $('#adsSelectedType' + (index + 1)).attr('data-price', el);
               });
           })
           .fail(function() {
               console.log('voucherCode not found or load error');
           });

         });

        $('#avatar').fileupload({
            dataType: 'json',
            url: '/updateUserAvatar',
            done: function (e, data) {
                $('.avatar').attr('src', data.result.avatar);
                $('.deleteAvatar').show();
            },
            fail: function (e, data) {
                swal('Update error!');
            }
        });

        $('.deleteAvatar').click(function () {
            $this = $(this);
            swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: {
                cancel: true,
                confirm: {
                        text: "Delete",
                        closeModal: false,
                    }
                },
                dangerMode: true,
            }).then((value) => {
                if (value) {
                    $.ajax({
                       url: '/updateUserAvatar',
                       type: 'POST',
                       dataType: 'json',
                       data: { _method: 'delete', delete: true },
                    }).done(function(data) {
                        $('.avatar').attr('src', data.avatar);
                        $('.deleteAvatar').hide();
                        swal.close();
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        var responseText = jQuery.parseJSON(jqXHR.responseText);
                        swal({
                            title: 'Error! ' + responseText.message,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
    @endif

    @if(isset($Page) && $Page == "profile")
        <script type="text/javascript">
            $('.mark').click(function() {
                var mark        = $(this).data('mark');
                var activity    = $(this).data('activity');

                $.ajax({
                    url: '/activity/' + activity,
                    type: 'POST',
                    dataType: 'json',
                    data: { _method: 'patch', mark: mark},
                })
                .done(function() {
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });

            });
        </script>
    @endif


    <script src="/newthemplate/bower_components/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script src="/newthemplate/js/chat.js?v=11"></script>
    
    <script src="/js/emoji/config.js"></script>
    <script src="/js/emoji/emoji-picker.js"></script>
    <script src="/js/emoji/jquery.emojiarea.js"></script>
    <script src="/js/emoji/util.js"></script>

    <script src="/newthemplate/js/search.js"></script>
    <script src="/newthemplate/js/filter.js"></script>

    {{-- <script type="text/javascript">
        jQuery('.datetimepicker').datetimepicker({value:'2015/04/15 05:06'});
    </script> --}}

    <script type="text/javascript">
      $(document).ready(function() {

         if ($('#CountryFilter').length > 0)
             $('#CountryFilter').select2({
                 ajax: {
                   url: '/ajax_filter_country',
                   dataType: 'json',
                   data: function (params) {
                     var result = {
                       term: (typeof params.term != null) ? params.term : null
                     }

                     return result;
                   }
                 }
             });

         if ($('#CountryRegisterFilter').length > 0)
             $('#CountryRegisterFilter').select2({
                 ajax: {
                   url: '/ajax_filter_country',
                   dataType: 'json',
                   data: function (params) {
                     var result = {
                       term: (typeof params.term != null) ? params.term : null
                     }

                     return result;
                   }
                 }
             });

         if ($('#CityFilter').length > 0)
             $('#CityFilter').select2({
                 ajax: {
                   url: '/ajax_filter_country',
                   dataType: 'json',
                   data: function (params) {
                     var result = {
                       country: $('#CountryFilter').val(),
                       term: (typeof params.term != null) ? params.term : null
                     }

                     return result;
                   }
                 }
             });

         $('#CountryFilter').on('change', function() {
            $('#CityFilter').removeAttr('disabled');
         });


         if ($('#FilterBrand').length > 0) {

             $('#FilterBrand').select2({
                 ajax: {
                   url: '/ajax_filter',
                   dataType: 'json',
                   data: function (params) {
                     var result = {
                       type: 'brand',
                       term: (typeof params.term != null) ? params.term : null
                     }

                     if ($('#subCategoryId').length > 0)
                       result['type_val_sub'] = $('#subCategoryId option:checked').data('model');

                     return result;
                   }
                 }
             });

             if ($('#FilterBrand2').length > 0)
                $('#FilterBrand2').select2({
                    ajax: {
                      url: '/ajax_filter',
                      dataType: 'json',
                      data: function (params) {
                        var result = {
                          type: 'brand',
                          term: (typeof params.term != null) ? params.term : null
                        }

                        return result;
                      }
                    }
                });

             if ($('select#FilterType').length > 0)
                $('#FilterType').select2({
                    ajax: {
                      url: '/ajax_filter',
                      dataType: 'json',
                      data: function (params) {
                        return {
                          type: 'type',
                          term: (typeof params.term != null) ? params.term : null,
                          brand: $('#FilterBrand').val()
                        }
                      }
                    }
                });

             if ($('#FilterType2').length > 0)
                $('#FilterType2').select2({
                    ajax: {
                      url: '/ajax_filter',
                      dataType: 'json',
                      data: function (params) {
                        return {
                          type: 'type',
                          term: (typeof params.term != null) ? params.term : null,
                          brand: $('#FilterBrand2').val()
                        }
                      }
                    }
                });

             if ($('#FilterModel').length > 0)
                $('#FilterModel').select2({
                    ajax: {
                      url: '/ajax_filter',
                      dataType: 'json',
                      data: function (params) {
                        var result = {
                          type: 'model',
                          term: (typeof params.term != null) ? params.term : null,
                          brand: $('#FilterBrand').val(),
                          type_val: $('#FilterType').val()
                        }

                        if ($('#subCategoryId').length > 0)
                          result['type_val_sub'] = $('#subCategoryId option:checked').data('model');

                        return result;
                      }
                    }
                });

             if ($('#FilterModel2').length > 0)
                $('#FilterModel2').select2({
                    ajax: {
                      url: '/ajax_filter',
                      dataType: 'json',
                      data: function (params) {
                        var result = {
                          type: 'model',
                          term: (typeof params.term != null) ? params.term : null,
                          brand: $('#FilterBrand2').val(),
                          type_val: $('#FilterType2').val()
                        }

                        return result;
                      }
                    }
                });

             if ($('#FilterBrand').length > 0 && $('select#FilterType').length == 0)
                $('#FilterBrand').on('change', function() {
                  $('#FilterModel').removeAttr('disabled');
                });

             $('#FilterBrand').on('change', function() {
               $('#FilterType').removeAttr('disabled');
             });

             $('#FilterBrand2').on('change', function() {
               $('#FilterType2').removeAttr('disabled');
             });

             $('#FilterType').on('change', function() {
               $('#FilterModel').removeAttr('disabled');
             });

             $('#FilterType2').on('change', function() {
               $('#FilterModel2').removeAttr('disabled');
             });
         }

         $('#cardnum').on('keyup', function() {
         	$.ajax({
         		type: 'POST',
         		url: '/card_detect',
               data: {card_name: $(this).val(), _token: $('input[name="_token"]').val()},
         		success: function(data){
                  if (data.status == 'success') {
                     if (data.type == 'Amex') {
                        $('#cvv').attr('placeholder', '****');
                        $('#cvv').attr('maxlength', '4');
                     } else {
                        $('#cvv').attr('placeholder', '***');
                        $('#cvv').attr('maxlength', '3');
                     }
                  }
         		}
         	});
         });
      });
    </script>

</body>
</html>