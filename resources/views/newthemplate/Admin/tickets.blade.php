@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inbox</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Home</a></li>
                        <li class="breadcrumb-item active">Tickets</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tickets</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item active">
                                <a href="/admin/tickets?type=created" class="nav-link">
                                    <i class="fa fa-inbox"></i> New Tickets
                                    <span class="badge bg-primary float-right">{{is_null($Counts[0]->created) ? 0 : $Counts[0]->created}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/tickets?type=in_progress" class="nav-link">
                                    <i class="fa fa-question-circle"></i> Under consideration
                                    <span class="badge bg-primary float-right">{{is_null($Counts[0]->in_progress) ? 0 : $Counts[0]->in_progress}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/tickets?type=approved" class="nav-link">
                                    <i class="fa fa-check-circle"></i> Approved
                                    <span class="badge bg-primary float-right">{{is_null($Counts[0]->approved) ? 0 : $Counts[0]->approved}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/tickets?type=rejected" class="nav-link">
                                    <i class="fa fa-trash"></i> Rejected
                                    <span class="badge bg-primary float-right">{{is_null($Counts[0]->rejected) ? 0 : $Counts[0]->rejected}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /. box -->

                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Tickets - new</h3>

                        <!--<div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search Mail">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Check All"><i
                                        class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm tickets-approve" title="Approve"><i
                                            class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-default btn-sm tickets-reject" title="Reject"><i
                                            class="fa fa-close"></i></button>
                                <button type="button" class="btn btn-default btn-sm tickets-remove" title="Remove (forever)"><i
                                            class="fa fa-trash"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm tickets-read" title="Read"><i class="fa fa-eye"></i>
                            </button>
                            <div class="float-right">
                                {{ $Tickets->firstItem() }}-{{ $Tickets->lastItem() }}/{{ $Tickets->total() }}
                                <div class="btn-group">
                                    @if($Tickets->currentPage() > 1)
                                        <a href="{{$Tickets->appends(request()->input())->previousPageUrl()}}" type="button" class="btn btn-default btn-sm"><i
                                                    class="fa fa-chevron-left"></i></a>
                                    @endif
                                    @if($Tickets->hasMorePages())
                                        <a href="{{$Tickets->appends(request()->input())->nextPageUrl()}}" type="button" class="btn btn-default btn-sm"><i
                                                    class="fa fa-chevron-right"></i></a>
                                    @endif
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.float-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>

                                @foreach($Tickets as $ticket)

                                    <tr>
                                        <td><input type="checkbox" class="ticket-check" data-id="{{$ticket->id}}"></td>
                                        <td class="mailbox-star"><a href="#"><i class="fa fa-star{{$ticket->important ? "" : "-o"}} text-warning"></i></a>
                                        </td>
                                        <td class="mailbox-name"><a href="/admin/tickets/{{$ticket->id}}"><b>{{$ticket->type}}</b> - {{!is_null($ticket->Ad) ? $ticket->Ad->adsName : "*deleted*"}}</a></td>
                                        <td class="mailbox-subject"><b>{{$ticket->name}}</b> - {{$ticket->reason}}</td>
                                        <td class="mailbox-attachment">{{$ticket->status}}</td>
                                        <td class="mailbox-date">{{$ticket->created_at->diffForHumans()}}</td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer p-0">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle" title="Check All"><i
                                        class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm tickets-approve" title="Approve"><i
                                            class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-default btn-sm tickets-reject" title="Reject"><i
                                            class="fa fa-close"></i></button>
                                <button type="button" class="btn btn-default btn-sm tickets-remove" title="Remove (forever)"><i
                                            class="fa fa-trash"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm tickets-read" title="Read"><i class="fa fa-eye"></i>
                            </button>

                            <div class="float-right">
                                {{ $Tickets->firstItem() }}-{{ $Tickets->lastItem() }}/{{ $Tickets->total() }}
                                <div class="btn-group">
                                    @if($Tickets->currentPage() > 1)
                                    <a href="{{$Tickets->appends(request()->input())->previousPageUrl()}}" type="button" class="btn btn-default btn-sm"><i
                                                class="fa fa-chevron-left"></i></a>
                                    @endif
                                    @if($Tickets->hasMorePages())
                                    <a href="{{$Tickets->appends(request()->input())->nextPageUrl()}}" type="button" class="btn btn-default btn-sm"><i
                                                class="fa fa-chevron-right"></i></a>
                                    @endif
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.float-right -->
                        </div>
                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@include("newthemplate.Admin.footer")