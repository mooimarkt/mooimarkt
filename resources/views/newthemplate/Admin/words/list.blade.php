@include("newthemplate.Admin.header")

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Words
        </h1>
        <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                <li class="breadcrumb-item active">Words</li>
            </ol>
        </div><!-- /.col -->

    </section>

    <section class="content">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-body">
                    <style>
                        .table {
                            margin: 15px 0 0;
                        }

                        .subdomain_languages_s table a {
                            margin: 0 5px;
                        }

                        .subdomain_languages_s input[type=text] {
                            padding: 5px;
                            border: 0;
                            width: 100%;
                        }

                        .header-buttons {
                            margin-bottom: 15px;
                        }

                        input[type=search] {
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            color: #495057;
                            background-color: #ffffff;
                            background-clip: padding-box;
                            border: 1px solid #ced4da;
                            border-radius: 0.25rem;
                            box-shadow: inset 0 0 0 transparent;
                            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                        }

                        select {
                            padding: 0.375rem 0.75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            color: #495057;
                            background-color: #ffffff;
                            background-clip: padding-box;
                            border: 1px solid #ced4da;
                            border-radius: 0.25rem;
                            box-shadow: inset 0 0 0 transparent;
                            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                        }


                        .dataTables_wrapper .dataTables_paginate .paginate_button,
                        .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
                        .dataTables_wrapper .dataTables_paginate .paginate_button:active {
                            background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%);
                            border: 1px solid #ddd;
                            box-shadow: inset 0 0 0px #111;
                            position: relative;
                            float: left;
                            padding: 6px 12px;
                            margin-left: -1px;
                            line-height: 1.42857143;
                            color: #337ab7 !important;
                            text-decoration: none;
                            background-color: #fff;
                        }

                        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                            color: #333 !important;
                            background-color: #fff;
                            border: 1px solid #ddd;
                            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #fff));
                        }

                        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
                            cursor: default;
                            color: #666 !important;
                            border: 1px solid #ddd;
                            background: #ffffff;
                            box-shadow: none;
                        }

                        table.dataTable thead th, table.dataTable thead td {
                            border-bottom: 0px solid #111;
                        }
                    </style>

                    <div class="header-buttons">
                        <a href="#" id="add-word" class="btn btn-info">Add word</a>
                        <a href="{{ route('words.export') }}" style="margin-left: 10px;"
                           class="btn btn-success">Export</a>
                        <a href="{{ route('words.import') }}" class="btn btn-success">Import</a>
                    </div>
                    <form action="{{ route('words.create') }}" method="POST" class="" id="addNewWordForm"
                          style="display: none;">
                        <input type="text" name="word" required class="form-control" placeholder="Enter new word">

                        <div class="col-6 row">
                            <button type="submit" class="btn btn-warning my-2" id="save-word">Save</button>
                            <button type="button" id="hideAddNewWord" class="btn btn-danger my-2 ml-1">Remove</button>
                        </div>
                    </form>

                    <div class="subdomain_languages_s">
                        <table class="table table-bordered table-hover table-words" id="table-words">
                            <thead>
                            <tr>
                                <th>Word</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <br>
                        <br>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- /.content -->
@include("newthemplate.Admin.footer")