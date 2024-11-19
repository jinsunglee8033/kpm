@extends('layouts.dashboard')
 
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Copy Ticket Approval List</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Copywriter Tickets Approval List</div> 
        </div>        
    </div>
    <div class="section-header" style="padding:0px;">
        <div class="form-group col-md-12 switch-group">
            <a class="switch-link" href="{{ url('admin/asset_approval_copy') }}">Asset Approval (<?php echo count($asset_list); ?>)</a>
            <span class="sp"></span>
            <a class="switch-link active" href="{{ route('copy.approval') }}">Ticket Approval (<?php echo count($copy_list); ?>)</a>
        </div>
    </div>

    <div class="section-body">

        @include('admin.shared.flash')

        <div class="row" style="margin-top: 15px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Task ID</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Requested By</th>
                                        <th>Priority</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>

                                    @foreach ($copy_list as $copy)
                                        <tr>
                                            <td>{{ $copy->copy_id }}</td>
                                            <td>{{ $copy->title }}</td>
                                            <td>{{ $copy->type }}</td>
                                            <td>{{ $copy->requested_by}}</td>
                                            <td>{{ $copy->priority}}</td>
                                            <td>{{ date('m/d/Y', strtotime($copy->created_at)) }}</td>
                                            <td>
                                                <a href="{{ url('admin/copy/'. $copy->copy_id .'/edit')}}" class="btn btn-primary" style="border-radius: 20px; font-size: x-small;">
                                                    Task Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   

<style>

    .switch-group{
        margin-left: 7px;
    }    
    a.switch-link{
        font-size: 1rem;
        color: #959292;
        font-weight: 600;
    }
    a.switch-link:hover,a.switch-link.active{
        font-size: 1rem;
        color: #333333;
        text-decoration:none;
        font-weight: 600;
    }
    .switch-group > span.sp{
        margin: auto 0.6rem;
        border-left: 1px solid #959292;
        padding: 4px 0;
    }

</style> 

@endsection
