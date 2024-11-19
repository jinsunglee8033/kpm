@extends('layouts.dashboard')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        @include('admin.campaign.flash')

        <div class="row">

            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ url('admin/campaign')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>KPM</h4>
                            </div>
                            <div class="card-body">
                                Project Manager
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1"
                     data-toggle="modal"
                     data-target="#myModal-qr">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Form Request</h4>
                        </div>
                        <div class="card-body">
                            QR Code Form
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1"
                     data-toggle="modal"
                     data-target="#myModal-coupon">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Form Request</h4>
                        </div>
                        <div class="card-body">
                            Coupon Code Form
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-1"
                     data-toggle="modal"
                     data-target="#myModal-analytic">
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-server" aria-hidden="true"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Form Request</h4>
                        </div>
                        <div class="card-body">
                            Analytic Report Request Form
                        </div>
                    </div>
                </div>
            </div>

        

            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ url('admin/copy/create')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>KPM</h4>
                            </div>
                            <div class="card-body">
                                Copy Ticket Request Form
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </section>


    <div class="modal fade" id="myModal-qr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">QR Code Request</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                            <label style="color: #b91d19; font-size: medium">QR Code Form Link - https://app.smartsheet.com/b/form/e0c97cdbdc7b4ecaaebb269ca32e79e1</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <iframe id="cartoonVideo" width="1080" height="1000" src="https://app.smartsheet.com/b/form/e0c97cdbdc7b4ecaaebb269ca32e79e1" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal-coupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Coupon Code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label style="color: #b91d19; font-size: medium">Coupon Code Form Link - https://app.smartsheet.com/b/form/fc883f81ce8e40d5b58c68c636998f37</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <iframe id="cartoonVideo" width="1080" height="1000" src="https://app.smartsheet.com/b/form/fc883f81ce8e40d5b58c68c636998f37" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal-analytic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Performance Marketing Analytic Report</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label style="color: #b91d19; font-size: medium">Analytic Report Request Form Link - https://app.smartsheet.com/b/form/38e9b1c33c914b14904eebc0f133b33c</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <iframe id="cartoonVideo" width="1080" height="1000" src="https://app.smartsheet.com/b/form/38e9b1c33c914b14904eebc0f133b33c" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection
