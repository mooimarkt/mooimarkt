@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Compose</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Home</a></li>
                        <li class="breadcrumb-item active">Ticket #{{$Ticket->id}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <a href="/admin/tickets" class="btn btn-primary btn-block mb-3">Back to all tickets</a>

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
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Ticket #{{$Ticket->id}}</h3>

                            <div class="card-tools">
                                @if($Ticket->status == "approved")
                                    <button style="background-color: rgb(4, 183, 23); color: white;" disabled
                                            type="button" class="btn btn-default btn-sm" title="Approved"><i
                                                class="fa fa-check"></i> Approved
                                    </button>
                                @endif
                                @if($Ticket->status == "rejected")
                                    <button style="background-color: rgb(183, 52, 31); color: white;" disabled
                                            type="button" class="btn btn-default btn-sm" title="Rejected"><i
                                                class="fa fa-close"></i> Rejected
                                    </button>
                                @endif
                                <button type="button"
                                        data-change-ticket='{"important":{{$Ticket->important ? "0" : "1"}}}'
                                        data-id="{{$Ticket->id}}" class="btn btn-default btn-sm" title="Approve"><i
                                            class="fa {{$Ticket->important ? "" : "fa-exclamation-circle"}}"></i> {{$Ticket->important ? "Mark as normal" : "Mark as important"}}
                                </button>
                                @if($Ticket->id > 1)
                                    <a href="/admin/tickets/{{$Ticket->id-1}}" class="btn btn-tool"
                                       data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                                @endif
                                <a href="/admin/tickets/{{$Ticket->id+1}}" class="btn btn-tool" data-toggle="tooltip"
                                   title="Next"><i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mailbox-read-info">
                                <h5>{{!is_null($Ticket->Ad) ? $Ticket->Ad->adsName : "*DELETED*"}} -
                                    ({{ucfirst($Ticket->type)}})</h5>
                                <h6>From: <a href="mailto:{{$Ticket->email}}">{{$Ticket->name}}</a>
                                    <span class="mailbox-read-time float-right">{{$Ticket->created_at->diffForHumans()}}</span>
                                </h6>
                            </div>
                            <!-- /.mailbox-read-info -->
                            <div class="mailbox-controls with-border text-center">
                                @if(!is_null($Ticket->Ad))
                                    <a target="_blank" href="/add-details/{{$Ticket->Ad->id}}"
                                       class="btn btn-default btn-sm" title="Show Ad"><i class="fa fa-newspaper-o"></i>
                                        Show Ad</a>
                                    <span>|</span>
                                    <button href="#" data-chatwith="{{$Ticket->Ad->id}}" class="btn btn-default btn-sm" title="Chat with Seller"><i
                                                class="fa fa-envelope"></i> Chat with Seller
                                    </button>
                                @endif
                                <a href="mailto:{{$Ticket->email}}" class="btn btn-default btn-sm"
                                   title="Chat with Seller"><i class="fa fa-envelope"></i> Mail to user</a>
                                @if(!is_null($Ticket->Ad))
                                    <span>|</span>
                                    @if(strpos($Ticket->Ad->adsStatus,"blocked-") === 0)
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-unblock-ad="{{$Ticket->id}}" title="Block Ad"><i
                                                    class="fa fa-play"></i> Unblock Ad
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-default btn-sm"
                                                data-block-ad="{{$Ticket->id}}" title="Block Ad"><i
                                                    class="fa fa-pause"></i> Block Ad
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-default btn-sm"
                                            data-remove-ad="{{$Ticket->id}}" title="Remove Ad"><i
                                                class="fa fa-trash"></i> Remove Ad
                                    </button>
                                @endif
                            </div>
                            <!-- /.mailbox-controls -->
                            <div class="mailbox-read-info" style="padding-bottom: 30px;">
                                {{$Ticket->reason}}
                            </div>
                            <div class="mailbox-read-message">
                                <div class="form-group">
                                    <label id="comment-label">Comment</label>
                                    <textarea class="form-control" data-id="{{$Ticket->id}}" id="comment" rows="3" placeholder="Comment ...">{{$Ticket->comment}}</textarea>
                                </div>
                            </div>
                            <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer bg-white">
                            <!-- <ul class="mailbox-attachments clearfix">
                                 <li>
                                     <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                     <div class="mailbox-attachment-info">
                                         <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Sep2014-report.pdf</a>
                                         <span class="mailbox-attachment-size">
                           1,245 KB
                           <a href="#" class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                         </span>
                                     </div>
                                 </li>
                                 <li>
                                     <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>

                                     <div class="mailbox-attachment-info">
                                         <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> App Description.docx</a>
                                         <span class="mailbox-attachment-size">
                           1,245 KB
                           <a href="#" class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                         </span>
                                     </div>
                                 </li>
                                 <li>
                                     <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo1.png" alt="Attachment"></span>

                                     <div class="mailbox-attachment-info">
                                         <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo1.png</a>
                                         <span class="mailbox-attachment-size">
                           2.67 MB
                           <a href="#" class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                         </span>
                                     </div>
                                 </li>
                                 <li>
                                     <span class="mailbox-attachment-icon has-img"><img src="../../dist/img/photo2.png" alt="Attachment"></span>

                                     <div class="mailbox-attachment-info">
                                         <a href="#" class="mailbox-attachment-name"><i class="fa fa-camera"></i> photo2.png</a>
                                         <span class="mailbox-attachment-size">
                           1.9 MB
                           <a href="#" class="btn btn-default btn-sm float-right"><i class="fa fa-cloud-download"></i></a>
                         </span>
                                     </div>
                                 </li>
                             </ul> -->
                        </div>
                        <!-- /.card-footer -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="button" data-remove-ticket="{{$Ticket->id}}"
                                        class="btn btn-default btn-sm" title="Remove (forever)"><i
                                            class="fa fa-trash"></i> Remove Ticket
                                </button>
                            </div>

                            @if($Ticket->status == "approved")
                                <button type="button" data-change-ticket='{"status":"rejected"}'
                                        data-id="{{$Ticket->id}}" class="btn btn-default btn-sm" title="Reject"><i
                                            class="fa fa-close"></i> Reject
                                </button>
                            @elseif($Ticket->status == "rejected")
                                <button type="button" data-change-ticket='{"status":"approved"}'
                                        data-id="{{$Ticket->id}}" class="btn btn-default btn-sm" title="Approve"><i
                                            class="fa fa-check"></i> Approve
                                </button>
                            @else
                                <button type="button" data-change-ticket='{"status":"approved"}'
                                        data-id="{{$Ticket->id}}" class="btn btn-default btn-sm" title="Approve"><i
                                            class="fa fa-check"></i> Approve
                                </button>
                                <button type="button" data-change-ticket='{"status":"rejected"}'
                                        data-id="{{$Ticket->id}}" class="btn btn-default btn-sm" title="Reject"><i
                                            class="fa fa-close"></i> Reject
                                </button>
                            @endif
                        </div>
                        <!-- /.card-footer -->
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