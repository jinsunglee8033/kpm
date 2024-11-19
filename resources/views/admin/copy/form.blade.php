@extends('layouts.dashboard')

@section('content') 

{{--    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet">--}}
{{--    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=6k40mnsmx70j0s3xt18143p5x2tq53p5d0kftr23w7kntoec"></script>--}}
{{--    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>--}}
{{--    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>--}}

    <link href="https://kissdigital.group/js/jquery-ui.css" rel="Stylesheet">
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=qyql6dcovykms8pye5ba3sqvichqs41yambv2r1q1um0j5vc"></script>
    <script src="https://kissdigital.group/js/jquery-ui.js" ></script>
    <script src="https://kissdigital.group/js/jquery-migrate-3.0.0.min.js"></script>
    <style>
        .create_note::before {
            white-space: pre;
        }
    </style>


    <section class="section">
        @include('admin.campaign.flash')
        <div class="section-header">
            <h1>Copy Ticket Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/copy_jira') }}">ECOM Copywriter Ticket Request Form</a></div>
                <div class="breadcrumb-item">Create a Ticket</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">{{ empty($copy) ? 'Create a Ticket' : 'Update a Ticket' }}</h2>
            <div class="row">
                <div class="col-lg-6">
                    @if (empty($copy ?? '' ?? ''))
                        <form method="POST" action="{{ route('copy.store') }}" enctype="multipart/form-data">
                    @else
                        <form method="POST" action="{{ route('copy.update', $copy->id) }}" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ $copy->id }}" />
                            @method('PUT')
                    @endif
                    @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ empty($copy) ? 'Create a Copy Request' : 'Update Request' }}</h4>
                                </div>

                                <div class="card-body">

                                    <div class="col">
                                        <div class="form-group">
                                            <label>Request Description <b style="color: #b91d19">*(required)</b></label>
                                            <input type="text" name="title" required
                                                   class="form-control @error('title') is-invalid @enderror @if (!$errors->has('title') && old('title')) is-valid @endif"
                                                   value="{{ old('title', !empty($copy) ? $copy->title : null) }}">
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Copy Request Type: <b style="color: #b91d19">*(required)</b></label>
                                            <div class="selectgroup selectgroup-pills">
                                                <?php foreach($types as $key => $value): ?>
                                                    <label class="selectgroup-item">
                                                        <input type="radio" name="type" value="{{ $key }}"
                                                               class="selectgroup-input" {{ $key == old('type', $type) ? 'checked' : '' }} required>
                                                        <span class="selectgroup-button" data-toggle="tooltip"
                                                              data-original-title="{{ $value }}">{{ $key }}</span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

{{--                                        <div class="form-group">--}}
{{--                                            <label>Copy Request Type</label>--}}
{{--                                            <select class="form-control" name="type">--}}
{{--                                                <option>Select</option>--}}
{{--                                                @foreach ($types as $value)--}}
{{--                                                    <option value="{{ $value }}" {{ $value == $type ? 'selected' : '' }}>--}}
{{--                                                        {{ $value }}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

                                        <div class="form-group">
                                            <label>Priority <b style="color: #b91d19">*(required)</b></label>
                                            <select class="form-control @error('priority') is-invalid @enderror @if (!$errors->has('priority') && old('priority')) is-valid @endif" name="priority" required>
                                                <option value="">Select</option>
                                                @if(empty(old('priority')))
                                                @foreach ($priorities as $key => $value)
                                                    <option value="{{ $key }}" {{ $key == $priority ? 'selected' : '' }} >
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                                @else
                                                @foreach ($priorities as $key => $value)
                                                    <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }} >
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Brand <b style="color: #b91d19">*(required - can choose more than one)</b></label>

                                            <div class="columns" style="column-count: 3;">
                                                <?php if ($domain != null) { ?>
                                                    @foreach($domains as $value)
                                                    <?php $checkbox_fields = explode(',', $domain); ?>
                                                        <div class="col-md">
                                                            <div class="form-check" style="padding-left: 0px;">
                                                                <input  <?php if (in_array($value, $checkbox_fields)) echo "checked" ?>
                                                                        type="checkbox"
                                                                        name="domain[]"
                                                                        value="{{ $value }}"
                                                                >
                                                                <label class="form-check-label " for="{{ $value }}">
                                                                {{ $value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                <?php }else{ ?>
                                                    @foreach($domains as $value)
                                                        <?php $checkbox_fields = explode(', ', $domain); ?>
                                                        <div class="col-md">
                                                            <div class="form-check" style="padding-left: 0px;">
                                                                <input
                                                                        type="checkbox"
                                                                        name="domain[]"
                                                                        value="{{ $value }}"
                                                                >
                                                                <label class="form-check-label " for="{{ $value }}">
                                                                    {{ $value }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                <?php } ?>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label>Request Details: <b style="color: #b91d19">*(required)</b></label>
                                            {!! Form::textarea('description', !empty($copy) ? $copy->description : null, ['class' => 'form-control summernote']) !!}
                                            @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div> 
                                        <?php $array = array('copy_to_do', 'copy_in_progress', 'copy_review', 'copy_done'); 
                                        if(Route::current()->getName()!="copy.create" && in_array($copy_status, $array)){ ?>
                                              
                                        <div class="form-group">
                                            <label>Copy Submission From Copywriter:</label>
                                            <textarea name="copy_submission" style="height:250px;background-color:#e3fdf4;" class="form-control @error('copy_submission') is-invalid @enderror @if (!$errors->has('copy_submission') && old('copy_submission')) is-valid @endif">{{ old('copy_submission', !empty($copy) ? $copy->copy_submission : '') }}</textarea>
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <?php }else{ ?>
                                            <div class="form-group" style="display:none;">
                                            <label>Copy Submission From Copywriter:</label>
                                            <textarea name="copy_submission" style="height:250px;background-color:#e3fdf4;" class="form-control @error('copy_submission') is-invalid @enderror @if (!$errors->has('copy_submission') && old('copy_submission')) is-valid @endif">{{ old('copy_submission', !empty($copy) ? $copy->copy_submission : '') }}</textarea>
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <?php } ?>

                                        <?php if (!empty($attach_files)): ?>
                                        <label>Attachments: </label>
                                        <br/>
                                        <?php foreach ($attach_files as $attachment): ?>
                                        <?php
                                        $file_ext = $attachment['file_ext'];
                                        if(strpos($file_ext, ".") !== false){
                                            $file_ext = substr($file_ext, 1);
                                        }
                                        $not_image = ['pdf','doc','docx','pptx','ppt','mp4','xls','xlsx','csv','zip'];
                                        $file_icon = env('AWS_BUCKET_HOST').env('AWS_BUCKET').'/'.$file_ext.'.png';
                                        $attachment_link = env('AWS_BUCKET_HOST').env('AWS_BUCKET') . $attachment['attachment'];
                                        $open_link = 'open_download';
                                        ?>
                                        <div class="attachment_wrapper">
                                            <?php $name = explode('/', $attachment['attachment']); ?>
                                            <?php $name = $name[count($name)-1]; ?>
                                            <?php $date = date('m/d/Y g:ia', strtotime($attachment['date_created'])); ?>
                                            <div class="attachement">{{ $name }}</div>

                                            <?php 
                                                                        $file_download_url = Storage::temporaryUrl( ltrim($attachment['attachment'],'/'), now()->addMinutes(60),
                                                                            [
                                                                                'ResponseContentType' => 'application/octet-stream',
                                                                                'ResponseContentDisposition' => 'attachment;',
                                                                            ]
                                                                        );
                                                            ?>

                                            <a onclick="remove_file($(this))"
                                               class="delete attachement close"
                                               title="Delete"
                                               data-file-name="<?php echo $name; ?>"
                                               data-attachment-id="<?php echo $attachment['attachment_id']; ?>">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <img title="<?php echo $name . ' (' . date('m/d/Y g:ia', strtotime($date)) . ')'; ?>"
                                                 data-file-date="<?php echo $date; ?>"
                                                 <?php
                                                 if (!in_array($file_ext, $not_image)) {
                                                 $file_icon = $attachment_link;
                                                 $open_link = 'open_image';
                                                 ?>
                                                 data-toggle="modal"
                                                 data-target="#exampleModal_<?php echo $attachment['attachment_id']; ?>"
                                                 <?php
                                                 }
                                                 ?>
                                                 onclick="<?php echo $open_link; ?>('<?php echo $file_download_url; ?>')"
                                                 src="<?php echo $file_icon; ?>"
                                                 class="thumbnail"/>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label>Upload Visual References or Briefs: <b style="color: #b91d19">(20MB Max)</b></label>
                                            <input type="file" id="c_attachment[]" name="c_attachment[]"
                                                   data-asset="default" multiple="multiple"
                                                   class="form-control c_attachment last_upload @error('c_attachment') is-invalid @enderror @if (!$errors->has('c_attachment') && old('c_attachment')) is-valid @endif"
                                                   value="{{ old('c_attachment', !empty($copy) ? $copy->id : null) }}">
                                            <a href="javascript:void(0);" onclick="another_upload($(this))" class="another_upload">[ Upload Another ]</a>
                                            @error('c_attachment')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        
                                       
                                    </div>

                                </div>

                                <div class="card-footer text-right">

                                    <?php if( ($copy_status == 'copy_to_do') && (auth()->user()->role=='admin' || auth()->user()->role=='copywriter' || auth()->user()->role=='copywriter manager') ) { ?>
                                    <button class="btn btn-success"
                                            to-do-id="<?php echo $copy->id; ?>"
                                            onclick="copy_work_start($(this))">
                                        Copy Start
                                    </button>
                                    <?php } ?>

                                    <?php if($copy_status == 'copy_in_progress' && (auth()->user()->role=='admin' || auth()->user()->role=='copywriter' || auth()->user()->role=='copywriter manager') ) { ?>
                                    <button class="btn btn-info"
                                            in-progress-id="<?php echo $copy->id; ?>"
                                            onclick="copy_work_finish($(this))">
                                        Copy Review
                                    </button>
                                    <?php } ?>

                                    <?php if($copy_status == 'copy_review' && (auth()->user()->role=='admin' || auth()->user()->id == $copy->request_by ) ) { ?>
                                    <button class="btn btn-info"
                                            review-id="<?php echo $copy->id; ?>"
                                            onclick="copy_work_done($(this))">
                                        Approved
                                    </button>
                                    <?php } ?>

                                    <?php if($copy_status == null || $copy_status == 'copy_requested') { ?>
                                    <button class="btn btn-primary">
                                        {{ empty($copy) ? 'Create' : 'Update' }}
                                    </button>
                                    <?php } ?>

                                </div>



                            </div> 

                        </form>

                    @if((!empty($copy)) && (auth()->user()->id == $copy->request_by) && $copy_status=="copy_review")                    
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Decline Reason From Ticket Owner:</label>
                                    <textarea id="declineReason" class="form-control" name="decline_reason" style="height:100px;"></textarea>
                                </div>        
                            </div>
                            <div class="card-footer text-right pt-0" >
                            <button class="btn btn-danger"
                                    decline-id="<?php echo $copy->id; ?>"
                                    onclick="copy_work_decline($(this))">
                                    Decline
                            </button>
                            </div>
                        </div>
                    @endif

                    @if((!empty($copy)) && (auth()->user()->role == 'copywriter manager') && $copy_status=="copy_requested")
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Decline Reason From Copy Team:</label>
                                    <textarea id="declineReason" class="form-control" name="decline_reason" style="height:100px;"></textarea>
                                </div>        
                            </div>
                            <div class="card-footer text-right pt-0" >
                            <button class="btn btn-danger"
                                    decline-id="<?php echo $copy->id; ?>"
                                    onclick="copy_work_decline($(this))">
                                    Decline
                            </button>
                            </div>
                        </div>


                        <div class="card">
                            <form method="POST" action="{{ route('copy.assign') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="c_id" value="{{ $copy->id }}">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Assign Copywriter:</label>
                                        <select id="assignInput" class="form-control @error('copywriter') is-invalid @enderror @if (!$errors->has('copywriter') && old('copywriter')) is-valid @endif" name="copywriter">
                                            <option value="">Select</option>
                                            @foreach ($copywriters as $copywriter)
                                                <option value="{{ $copywriter->id }}" {{ $copywriter->id == $copy->assign_to ? 'selected' : '' }}>
                                                    {{ $copywriter->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                     @enderror
                                </div>

                                <input type="hidden" name="copy_id" value="{{ $copy->copy_id }}">

                                <div class="card-footer text-right pt-0">
                                    <button id="assignButon" class="btn btn-danger">Assign</button>
                                </div>
                            </form>
                        </div>
                        

                    @endif
                </div>


                @if(!empty($copy))
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>CORRESPONDENCE</h4>
                            <div class=" text-right">
                                <button class="btn btn-primary" id="add_note_btn" onclick="click_add_note_btn()">Add Note</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col">
                                <section id="add_note" class="notes" style="display: none;">
                                    <div class="write note">
                                        <form method="POST" action="{{ route('copy.copy_add_note') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="c_id" value="{{ $copy->id }}">
                                            <input type="hidden" name="c_title" value="{{ $copy->title }}">
                                            <input type="hidden" id="email_list" name="email_list" value="">

                                            <textarea id="create_note" name="create_note" class="wysiwyg"></textarea>
                                            <div id="at_box" style="display: none">
                                                <input class="form-control" placeholder="Name" type="text"/>
                                            </div>
                                            <div class=" text-right">
                                                <button type="button" class="btn btn-primary" onclick="click_cancel_note_btn()">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Send Note</button>
                                            </div>
                                        </form>
                                    </div>
                                </section>

                                <div class="form-group">
                                    @foreach ($correspondences as $correspondence)

                                        <?php if(!empty($correspondence->users)) { ?>
                                    <?php $role = $correspondence->users->role ?>
                                    <?php $team = $correspondence->users->team ?>
                                    <?php $first_name = $correspondence->users->first_name . ' ' . $correspondence->users->last_name ?>
                                <?php }else{  ?>
                                <?php $role = '-' ?>
                                <?php $team = '-' ?>
                                <?php $first_name = 'Not Exist User' ?>
                                <?php } ?>

                                        <?php $color_role = strtolower(add_underscores($role)); ?>
                                        <div class="note">
                                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                                <li class="media">
                                                    <div class="media-body">
                                                        <div class="media-title-note {{$color_role}}" >
                                                            <div class="media-right"><div class="text-time">{{ date('m/d/y g:i A', strtotime($correspondence->created_at)) }}</div></div>
                                                            <div class="media-title mb-1">{{ $first_name }}</div>
                                                            <div class="text-time">{{ $team }} | {{ $role }}</div>
                                                        </div>
                                                        <div class="media-description text-muted" style="padding: 15px;">
                                                            {!! $correspondence->note !!}
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    @endforeach

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
        </div>

    </section>

    <?php if (!empty($attach_files)): ?>
    <?php foreach ($attach_files as $attachment): ?>
        <?php $attachment_link = env('AWS_BUCKET_HOST').env('AWS_BUCKET').$attachment['attachment']; ?>
            <?php 
                         $file_download_url = Storage::temporaryUrl( ltrim($attachment['attachment'],'/'), now()->addMinutes(5),
                            [
                                'ResponseContentType' => 'application/octet-stream',
                                'ResponseContentDisposition' => 'attachment;',
                            ]
                        );
            ?>    
    <div class="modal fade"
         id="exampleModal_<?php echo $attachment['attachment_id']; ?>"
         tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                                <span aria-hidden="true">
                                  ×
                              </span>
                    </button>
                </div>
                <!--Modal body with image-->
                <?php $name = explode('/', $attachment['attachment']); ?>
                <?php $name = $name[count($name)-1]; ?>
                <div class="modal-title text-lg-center">{{ $name }}</div>
                <div class="modal-body">
                    <img class="img-fluid" src="<?php echo $attachment_link; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-primary"
                            data-dismiss="modal"
                            onclick="open_download('<?php echo $file_download_url; ?>')">
                        Download
                    </button>
                    <button type="button"
                            class="btn btn-danger"
                            data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>

    <script>
        function another_upload(el) {
            upload_box = $('.c_attachment').prop('outerHTML');
            upload_name = $(el).prev().attr('name');
            upload_id = $(el).prev().attr('data-asset');
            $('.c_attachment').removeClass('last_upload');
            $(el).before(upload_box);
            $(el).prev().attr('name', upload_name);
        }

        function remove_file(el) {

            if (confirm("Are you sure to Delete File?") == true) {
                let id = $(el).attr('data-attachment-id');
                $.ajax({
                    url: "<?php echo url('/admin/copy/fileRemove'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response == 'success'){
                            $(el).parent().remove();
                            
                        }else{
                            alert(response);
                            
                        }
                    },
                })
            }

        }

        function open_download(link) {
            let click_link = document.createElement('a');
            click_link.href = link;
            image_arr = link.split('/');
            link = image_arr[image_arr.length-1];
            click_link.download = link;
            document.body.appendChild(click_link);
            click_link.click();
        }


    </script>

    <script>
        $(document).ready(function(){

            let assignInput  = $("#assignInput");
            let assignButon = $("#assignButon");

            assignButon.attr("disabled","disabled");

            assignInput.on("change",function(){
                if(assignInput.val()!=""){
                    assignButon.removeAttr("disabled");
                }else{
                    assignButon.attr("disabled","disabled");
                }
            });

        });

        function click_add_note_btn(){
            $("#add_note_btn").hide();
            $("#add_note").slideDown();

        }

        function click_cancel_note_btn(){
            $("#add_note_btn").show();
            $("#add_note").slideUp();
        }

        function copy_work_start(el){

            if (confirm("Ready to start the copy?") == true) {
                let id = $(el).attr('to-do-id');
                $.ajax({
                    url: "<?php echo url('/admin/copy/copy_in_progress'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function copy_work_finish(el){

            if (confirm("Is your copy ready to be sent to the requester?") == true) {
                let id = $(el).attr('in-progress-id');
                $.ajax({
                    url: "<?php echo url('/admin/copy/copy_review'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function copy_work_done(el){

            if (confirm("Have you sure the copy is complete?") == true) {
                let id = $(el).attr('review-id');
                $.ajax({
                    url: "<?php echo url('/admin/copy/copy_done'); ?>"+"/"+id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                })
            }
        }

        function copy_work_decline(el){
            <?php if (auth()->user()->role == 'copywriter manager'){ 
                $confirm_text = "this request?";
                }else{ 
                    $confirm_text="the copy?";
            } ?>
            if (confirm("Are you sure you want to decline <?php echo $confirm_text; ?>") == true) {
                let declineId = $(el).attr('decline-id');
                let data = {
                        id:declineId,
                        decline_reason:$("#declineReason").val()
                    }
                    
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "<?php echo url('/admin/copy/copy_decline'); ?>"+"/"+declineId,
                    type: 'GET',
                    dataType:'JSON',
                    data: data,
                    success: function(response){
                        console.log(response);
                        if(response != 'fail'){
                            alert('Success!');
                            window.location.reload(response);
                            $(el).remove();
                        }else{
                            alert('Error!');
                        }
                    },
                    error:function(error){
                        console.log(error.responseText);
                    }
                })
            }
        }       

    </script>

    <script type="text/javascript">

        tinymce.init({
            selector: '.wysiwyg',
            placeholder: 'To reference a specific asset please use the select field above. If you would like to notify a specific person type @ then enter the persons name in the field that appears. ',
            menubar: false,
            plugins: "paste",
            paste_as_text: true,
            init_instance_callback: function (editor) {
                editor.on('keypress', function (e) {
                    if (e.key == '@' && editor.id == 'create_note') {
                        $("#at_box").show();
                        $("#at_box input").attr('readonly', false);
                        $("#at_box input").focus();
                    }
                });
            }
        });

        arr = <?php echo json_encode($kiss_users); ?>;

        total = [];
        $.each(arr, function(k,v) {
            total.push(k);
        });

        var email_list=[];

        $("#at_box input").autocomplete({
            source: total,
            minLength: 0,
            select: function(event, ui) {
                $.each(arr, function(k,v) {
                    if (k == ui.item.label) {
                        email = arr[k];
                        email_list.push(email);
                        name = '@' + arr[k].split('@')[0];
                        tinymce.get("create_note").execCommand('mceInsertContent', false, name);
                        $('#email_list').val(email_list);
                        $('#at_box input').val('');
                        $('#at_box').hide();
                    }
                })
                return false;
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        });

    </script>

@endsection
