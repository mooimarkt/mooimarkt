@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Meetings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Meetings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="box">
        <!-- /.box-header -->
        <div class="box-body box-user">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-sort="ascending"
                                    aria-label="Rendering engine: activate to sort column descending" style="">Meeting
                                    id
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending" style="">Ad
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending" style="">Seller Profile
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="">Date
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Engine version: activate to sort column ascending" style="">Buyer
                                    Profile
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="CSS grade: activate to sort column ascending" style="">View
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="CSS grade: activate to sort column ascending" style="">Content
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending" style="">Location
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="text-align:right; padding-right: 10px;padding-left:40px;">Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($meetings as $meeting)
                                <tr role="row" class="odd tr-style">
                                    <td class="sorting_1">{{ $meeting->id }}</td>
                                    <td><a href="{{ route('ads.add-details', ['Ad' => $meeting->ads_id]) }}">Ad</a></td>
                                    <td class="us_prof">
                                        <div class="us_ph"><img
                                                    src="{{ $meeting->seller->avatar }}"
                                                    alt="Alternate Text"/></div>
                                        <div class="us_txt">
                                            <div>{{ $meeting->seller->name }}</div>
                                            <a href="{{ route('profile.show', ['profile' => $meeting->seller_id]) }}"
                                               target="_blank">Profile</a>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $meeting->meeting }}
                                    </td>
                                    <td class="us_prof">
                                        <div class="us_ph"><img
                                                    src="{{ $meeting->buyer->avatar }}"
                                                    alt="Alternate Text"/></div>
                                        <div class="us_txt">
                                            <div>{{ $meeting->buyer->name }}</div>
                                            <a href="{{ route('profile.show', ['profile' => $meeting->buyer_id]) }}"
                                               target="_blank">Profile</a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('profile.show', ['profile' => $meeting->seller_id]) }}#timeline">View</a>
                                    </td>
                                    <td>
                                        <p>{{ $meeting->content }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $meeting->location }}</p>
                                    </td>
                                    {{-- <td class="user-type" data-uid="{{$meeting->seller->id}}">
                                        @php
                                        $userType = ["Untyped","B4MX User","Facebook User","Google User","Twitter User"];
                                        @endphp
                                        <div>{{$userType[!empty($meeting->seller->userType)?$meeting->seller->userType:0]}}</div>
                                        <a href="#" data-tgl='select' data-vals="{{implode(",",$userType)}}">change</a>
                                    </td> --}}
                                    <td>
                                        {{-- <button type="button" class="btn btn-block btn-success btn-sm">Confirm</button> --}}
                                        <button type="button" class="btn btn-block btn-danger btn-sm delete_meeting"
                                                data-aid="{{ $meeting->id }}">Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                            Showing {{ $meetings->firstItem() }} to {{ $meetings->lastItem() }}
                            of {{ $meetings->total() }} meetings
                        </div>
                    </div>
                {{$meetings->links()}}
                <!-- /.box-body -->
                </div>
                <div class=""></div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </div>
</div>
@include("newthemplate.Admin.footer")