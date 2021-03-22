<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Mooimarkt © </strong>2005-{{date('Y')}}
    <div class="float-right d-none d-sm-inline-block">
        All Rights Reserved
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="/newthemplate/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
{{--<script src="/newthemplate/admin/dist/js/sweetalert.min.js"></script>--}}

<!-- Sweet Alert 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.25.6/sweetalert2.all.min.js"></script>

<!-- Sweetalert 2 -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">

<script src="/newthemplate/js/ajax-setup.js"></script>
<script src="/newthemplate/js/TextLoader.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/newthemplate/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
@if($Page == "dashboard")
    <script src="/newthemplate/admin/plugins/morris/morris.min.js"></script>
@endif
<!-- Sparkline -->
<script src="/newthemplate/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
@if($Page == "dashboard")
    <script src="/newthemplate/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/newthemplate/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
@endif
<!-- jQuery Knob Chart -->
<script src="/newthemplate/admin/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="/newthemplate/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/newthemplate/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/newthemplate/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/newthemplate/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/newthemplate/admin/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/newthemplate/admin/dist/js/adminlte.js"></script>
@if ($Page == 'listing-management')
    <script src="/js/fileupload/vendor/jquery.ui.widget.js"></script>
    <script src="/js/fileupload/jquery.iframe-transport.js"></script>
    <script src="/js/fileupload/jquery.fileupload.js"></script>
@endif
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@if(in_array($Page,['edit-page',"add-page"]))
    <script src="/newthemplate/admin/plugins/ckeditor/ckeditor.js"></script>
    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            ClassicEditor
                .create(document.querySelector('#editor1'))
                .then(function (editor) {
                    console.log(editor);
                })
                .catch(function (error) {
                    console.error(error)
                })

        })
    </script>
@endif
@if($Page == "dashboard")
    <script src="/newthemplate/admin/dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->

    <script src="/newthemplate/admin/dist/js/demo.js"></script>
@endif


<!-- FLOT CHARTS -->
@if($Page == "dashboard")
    <script src="/newthemplate/admin/plugins/flot/jquery.flot.min.js"></script>
    <script src="/newthemplate/admin/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="/newthemplate/admin/plugins/flot/jquery.flot.categories.min.js"></script>
    @if (isset($monthData))
        <script>
            /*
             * BAR CHART
             * ---------
             */

            var bar_data = {
                // data : [['January', 10], ['February', 8], ['March', 4], ['April', 13], ['May', 17], ['June', 9]],
                data: [@foreach ($monthData as $data)['{{ date("F", mktime(0, 0, 0, $data->month, 1)) }}', {{ $data->num }}]{{ (!$loop->last) ? ', ' : '' }}@endforeach],
                color: '#3c8dbc'
            }
            $.plot('#bar-chart', [bar_data], {
                grid: {
                    borderWidth: 1,
                    borderColor: '#f3f3f3',
                    tickColor: '#f3f3f3'
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.5,
                        align: 'center'
                    }
                },
                xaxis: {
                    mode: 'categories',
                    tickLength: 0
                },
                legend: {
                    show: true,
                }
            })
            /* END BAR CHART */
        </script>
    @endif
@endif
@if($Page == "listing-management")
    <script src="/newthemplate/admin/dist/js/owl.carousel.min.js"></script>
    <script src="/newthemplate/admin/dist/js/app.js"></script>
@endif
@if(in_array($Page,['listings','pages']))
    <script src="/newthemplate/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#example1').DataTable({
                'paging': false,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': false,
                'autoWidth': true
            })
        })
    </script>
@endif

@if(in_array($Page,['meetings','payments',"users"]))

    <script src="/newthemplate/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $('#example1').DataTable();
            // $('#example2').DataTable({
            //     'paging'      : true,
            //     'lengthChange': false,
            //     'searching'   : false,
            //     'ordering'    : true,
            //     'info'        : true,
            //     'autoWidth'   : false
            // })
        })
    </script>

@endif

@if($Page == "users" || $Page == "meetings")
    <script src="/newthemplate/admin/dist/js/admin_users.js"></script>
@endif

@if($Page == "add-user")
    <script src="/js/fileupload/jquery.fileupload.js"></script>
    <script src="/newthemplate/admin/dist/js/admin_users_ad.js"></script>
    <script type="text/javascript">
        // $('#avatar').fileupload({
        //     dataType: 'json',
        //     url: '/updateUserAvatar',
        //     done: function (e, data) {
        //         $('.avatar').attr('src', data.result.avatar);
        //         $('.deleteAvatar').show();
        //     },
        //     fail: function (e, data) {
        //         swal('Update error!');
        //     }
        // });
    </script>
@endif

@if($Page == "voucher")
    <script src="/newthemplate/admin/dist/js/voucher.js"></script>
@endif

@if($Page == "voucher-trader")
    <script src="/newthemplate/admin/dist/js/voucher-trader.js"></script>
@endif

@if(in_array($Page,['tickets','ticket']))
    <script src="/newthemplate/admin/dist/js/admin_ticket.js"></script>
    <script src="/newthemplate/admin/dist/js/Ticket.js"></script>
@endif

@if($Page == "pages")
    <script type="text/javascript">
        $('.deletePage').click(function () {
            $this = $(this);
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then((isConfirm) => {
                if (isConfirm.value === true) {
                    $.ajax({
                        url: '/admin/pages/' + $(this).data('page'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(4)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif

@if($Page == "google-sheets")
    <script type="text/javascript">
        $(".optionsUpload").change(function () {
            $("#optionsUpload").submit();
        });

        function prettyPrint(elem) {
            var ugly = $(elem).val();
            console.log(ugly);
            var obj = JSON.parse(ugly);
            var pretty = JSON.stringify(obj, undefined, 4);
            $(elem).val(pretty);
        }

        $('.export').click(function () {
            swal({
                title: "Export?",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: "Export",
                        closeModal: false,
                    }
                },
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: '/google/export',
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'patch'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                            button: "Open Spreadsheet!",
                        }).then((value) => {
                            if (value) {
                                window.open('https://docs.google.com/spreadsheets/d/1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY/edit#gid=50969847');
                            }
                        });

                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        var responseText = jQuery.parseJSON(jqXHR.responseText);
                        swal({
                            title: 'Error! ' + responseText.error.message,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif

@if($Page == "category")
    <script type="text/javascript">
        $('.deleteCategory').click(function () {
            $this = $(this);
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then((isConfirm) => {
                if (isConfirm.value === true) {
                    $.ajax({
                        url: '/admin/category/' + $(this).data('cid'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(4)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif

@if($Page == "subcategory")
    <script type="text/javascript">
        $('.deleteSubCategory').click(function () {
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
                        url: '/admin/subcategory/' + $(this).data('sid'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(5)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif

@if($Page == "settings")
    <script src="/newthemplate/admin/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/mooimarkt/assets/jquery/jquery.uploadPreview.min.js"></script>
    <script type="text/javascript">
        /*function readURL(input) {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $('#image_slider').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
        }
        }
        $("#imgInput").change(function(){
        readURL(this);
        });*/

        $(document).ready(function () {
            $(document).on('click', '.image-upload', function () {
                var classNamePreview = '#' + $(this).parent().attr('id')
                var classNameUpload = '#' + $(this).attr('id')
                console.log(classNamePreview)
                console.log(classNameUpload)
                $.uploadPreview({
                    input_field: classNameUpload,   // Default: .image-upload
                    preview_box: classNamePreview,  // Default: .image-preview
                    // label_field: ".image-label",    // Default: .image-label
                    label_default: "Choose File",   // Default: Choose File
                    label_selected: "Change File",  // Default: Change File
                    no_label: false                 // Default: false
                });
            })

        });

        /*   $(function text() {
               $("textarea").each(function(){
                   var txt = '.'+$( this ).attr('class');
                   ClassicEditor
                       .create(document.querySelector(txt))
                       .then(function (editor) {
                           console.log(editor);
                       })
                       .catch(function (error) {
                           console.error(error)
                       })
               });
           })*/


        $(function () {
            $("textarea").each(function () {
                var txt = '.' + $(this).attr('class');
                ClassicEditor
                    .create(document.querySelector(txt))
                    .then(function (editor) {
                        console.log(editor);
                    })
                    .catch(function (error) {
                        console.error(error)
                    })
            });
        })

        var count = {{ count(json_decode(\App\Option::getSetting("opt_slider")))+1 }};
        $('.add-slider').click(function (e) {
            e.preventDefault()
            $('.sliders').append(
                '<div class="slider">\n' +
                '                                        <button type="button" class="btn btn-danger btn-sm delete-slider pull-right" style=" margin-top: -15px;"><i class="fa fa-times"></i></button>\n' +
                '                                        <div class="row">\n' +
                '                                            <div class="input-group col-md-4">\n' +
                '                                                <div class="image-preview" id="image-preview' + count + '">\n' +
                '                                                    <label for="image-upload" class="image-label">Choose File</label>\n' +
                '                                                    <input type="file" name="opt_slider[' + count + '][image_url]" class="image-upload" id="image-upload' + count + '" />\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="col-md-8">\n' +
                '                                                <div class="form-group">\n' +
                '                                                    <label for="">Text</label>\n' +
                '                                                    <textarea class="editor' + count + '" style="width: 100%" rows="5" name="opt_slider[' + count + '][slider_content]"></textarea>\n' +
                '                                                    <br>\n' +
                '                                                    <div class="checkbox" id="add-link">\n' +
                '                                                        <label>\n' +
                '                                                            <input type="checkbox" onclick="javascript: getLink(\'.link_field' + count + '\', this)"> Add link\n' +
                '                                                        </label>\n' +
                '                                                    </div>\n' +
                '                                                    <div class="row">\n' +
                '                                                        <div class="col-md-4">\n' +
                '                                                            <label for="">Name</label>\n' +
                '                                                            <input  type="text" class="form-control link_field' + count + '"\n' +
                '                                                                    name="opt_slider[' + count + '][url_name]" disabled\n' +
                '                                                                    value="" placeholder="Save now">\n' +
                '                                                        </div>\n' +
                '                                                        <div class="col-md-8">\n' +
                '                                                            <label for="">Url</label>\n' +
                '                                                            <input  type="text" class="form-control link_field' + count + '"\n' +
                '                                                                    name="opt_slider[' + count + '][url_link]" disabled\n' +
                '                                                                    value="" placeholder="/our-story">\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    <hr>\n' +
                '                                    </div>'
            )
            $(function () {
                var txt = '.' + 'editor' + (count - 1);
                ClassicEditor
                    .create(document.querySelector(txt))
                    .then(function (editor) {
                        console.log(editor);
                    })
                    .catch(function (error) {
                        console.error(error)
                    })
            })
            count++;
        })


        $(document).on('click', '.delete-slider', function (e) {
            e.preventDefault()
            var imageName = $(this).parent().find('.text_image_url').val()

            $.ajax({
                url: '/options/delete-slider',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'JSON',
                data: {
                    imageName: imageName
                },
                success: function (data) {
                    console.log(data)
                }
            });

            $(this).parent().remove()
        })

        function getLink(className, e) {
            $(className).attr('disabled', !e.checked);
        }
    </script>
@endif

@if(in_array($Page,['words', 'words-edit']))
    <script src="/newthemplate/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        var table = $('#table-words').DataTable({
            paging: true,
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: "{{ route('words.list') }}",
            columns: [
                {data: 'word', name: 'word'},
                {data: 'action', name: 'action'}
            ]
        });

        $("#add-word").click(function (e) {
            e.preventDefault();

            $('#addNewWordForm').show();
        });

        $('#hideAddNewWord').click(function () {
            $('#addNewWordForm input').val('');
            $('#addNewWordForm').hide();
        });

        $(document).on("click", "#save-word", function (e) {
            e.preventDefault();

            let $form = $('#addNewWordForm');

            // var inputs = $(this).parents('tr').find('input');
            // var values = {};
            // $.each(inputs, function (key, val) {
            //     if ($(val).val() == '') {
            //         $(val).css('border', 'red 1px solid');
            //     } else {
            //         $(val).css('border', 'none');
            //     }
            //     values[$(val).attr('name')] = $(val).val();
            // });
            //
            // var target = $(this);

            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: {
                    word: $form.find('input[name="word"]').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $form.find('input[name="word"]').val('');

                        table.page('last').draw(false);
                        // table.ajax.reload(null, false);
                    }
                }
            });
        });


        $(document).on("click", ".delete-word", function (e) {
            e.preventDefault();
            var target = $(this);
            var id = target.parents('tr').data('id');

            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then(function (isConfirm) {
                if (isConfirm.value === true) {
                    if (id) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('words.delete') }}',
                            data: {'id': id},
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                if (response.status == 'success') {
                                    target.parents('tr').remove();
                                }
                            }
                        });
                    } else {
                        target.parents('tr').remove();
                    }
                }
            })
        });

        $(document).on('change', ".table-words input", function () {
            var id = $(this).parents('tr').data('id');
            var name = $(this).attr('name');
            var val = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('words.update') }}',
                data: {'id': id, 'name': name, 'value': val},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                }
            });

        });
    </script>
@endif

@if($Page == "qaCategories")
    <script type="text/javascript">
        $('.deleteCategory').click(function (e) {
            e.preventDefault();
            $this = $(this);
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then((isConfirm) => {
                if (isConfirm.value === true) {
                    $.ajax({
                        url: '/admin/qa/category/delete/' + $(this).data('cid'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(5)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif
@if($Page == "qaItems")
    <script type="text/javascript">
        $('.deleteItem').click(function () {
            $this = $(this);
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then((isConfirm) => {
                if (isConfirm.value === true) {
                    $.ajax({
                        url: '/admin/qa/item/delete/' + $(this).data('cid'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(4)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif
@if($Page == "howWorksCategories")
    <script type="text/javascript">
        $('.deleteCategory').click(function () {
            $this = $(this);
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then((isConfirm) => {
                if (isConfirm.value === true) {
                    $.ajax({
                        url: '/admin/howWorks/category/delete/' + $(this).data('cid'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(3)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif

@if($Page == "howWorksItems")
    <script type="text/javascript">
        $('.deleteItem').click(function () {
            $this = $(this);
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
            }).then((isConfirm) => {
                if (isConfirm.value === true) {
                    $.ajax({
                        url: '/admin/howWorks/item/delete/' + $(this).data('cid'),
                        type: 'POST',
                        dataType: 'json',
                        data: {_method: 'delete'},
                    }).done(function (data) {
                        swal({
                            title: data.success,
                            icon: "success",
                        });
                        $this.closest('tr').find('td:nth-child(5)').html('<p class="text-danger">Deleted</p>');
                    }).fail(function (res) {
                        let html = document.createElement("div");
                        for (let Field in res.responseJSON.errors) {
                            html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                        }
                        swal({
                            title: "Error!",
                            content: html,
                            icon: "error",
                        });
                    });
                }
            });
        });
    </script>
@endif

@if($Page == "filters")
    <script src="/mooimarkt/js/nested.js"></script>
    <script>
        (function () {
            $.post('<?= route('admin.filters.sortAjax', ['subCategoryId' => $subCategory->id]); ?>', {_token: '<?= csrf_token() ?>'}, function (data) {
                $('#sortableResult').html(data);
            });


            $('#save').on('click', function () {
                sortable = $('.sortable').nestedSortable('toArray');

                $('#sortableResult').slideUp(function () {
                    $.post('{{ route('admin.filters.sortAjax', ['subCategoryId' => $subCategory->id]) }}', {
                        sortable: sortable,
                        _token: '<?= csrf_token() ?>'
                    }, function (data) {
                        $('.sortableResult').html(data);
                        $('#sortableResult').slideDown();
                    });
                });

            });

        })();
    </script>
@endif

@if($Page == "filters-create" || $Page == "filters-edit")
    <script src="/mooimarkt/js/nested.js"></script>
    <script>
        $("select[name='parent_id']").change(function () {
            if ($(this).val().includes('category')) {
                $("select[name='template']").attr('disabled', false);
                $("select[name='template']").parent().show();
            } else {
                $("select[name='template']").attr('disabled', true);
                $("select[name='template']").parent().hide();
            }
        });
    </script>
    @endif

    </body>
    </html>
