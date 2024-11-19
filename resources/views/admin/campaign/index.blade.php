@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>KISS Project Manager</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Project Manager</div>
        </div>
    </div>
    <div class="section-body">

        @include('admin.campaign.flash')
        @include('admin.campaign._filter')

        <div id="#mainFrame" class="row" style="margin-top: 15px;">

            @foreach ($campaigns as $campaign)

                <div id="#objectFrame" class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $campaign->name }}
                                <span class="float-right">

                                <a  href="javascript:void(0);"
                                    class="close"
                                    data-id=""
                                    data-campaign-id="{{ $campaign->id }}"
                                    onclick="delete_campaign($(this));">
                                <i class="fa fa-times"></i>
                                </a>

                                <a  href="javascript:void(0);"
                                    class="duplicate"
                                    data-id=""
                                    data-campaign-id="{{ $campaign->id }}"
                                    data-toggle="modal"
                                    data-target="#DuplicateModal"
                                    data-campaign-brand="{{ $campaign->campaign_brand }}"
                                    data-campaign-name="{{ $campaign->name }}"
                                    >
                                <i class="fa fa-copy"></i>
                                </a>
                            </span>
                            </h4>

                        </div>


                        <div class="card-body" style="display: flex;">
                            <div class="col-md-6" style="border-right:1px solid #eee; padding: 0px 0px 0px 0px;">
                                <div class="form-group">
                                    <div class="input-group info" style="display: block; ">
                                        <div >
                                            <b>Brand:</b>
                                            {{ $campaign->brands->campaign_name }}
                                        </div>
                                        <div id='campaignID'>
                                            <b>Project:</b>
                                            # {{ $campaign->id }}
                                        </div>
                                        <div>
                                            <b>Created By:</b>
                                            {{ $campaign->author->first_name }} {{ $campaign->author->last_name }}
                                        </div>
                                        <div>
                                            <b>Status:</b>
                                            {{ ucwords($campaign->status) }}
                                        </div>
                                    </div>
                                    <div style="padding-top: 15px;">
                                        <a id="openButton" href="{{ url('admin/campaign/'. $campaign->id .'/edit') }}">
                                            <button type="button" class="btn-sm design-white-project-btn">Open</button>
                                        </a>
{{--                                        <a id="openButton" href="{{ url('admin/campaign/'. $campaign->id .'/edit')}}" class="btn btn-block btn-light">--}}
{{--                                            Open--}}
{{--                                        </a>--}}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6 asset_scroll">
                                <div class="row" style="font-size: 12px;">
                                    <div class="col-sm-6" style="padding: 0px 0px 0px 2px;">
                                        <div style="margin-top:0px;">
                                            <b>Assets:</b>
                                        </div>
                                        <?php $assets = \App\Repositories\Admin\CampaignRepository::get_assets($campaign->id); ?>
                                        <?php if(!empty($assets)){
                                        foreach ($assets as $asset){?>
                                        <div>
                                            <?php
                                                $asset_type = $asset->type;
                                                if($asset_type == 'website_banners') {
                                                    $asset_type = 'web_banners';
                                                }else if($asset_type == 'a_content') {
                                                    $asset_type = 'a+_content';
                                                }else if($asset_type == 'image_request') {
                                                    $asset_type = 'img_request';
                                                }else if($asset_type == 'programmatic_banners') {
                                                    $asset_type = 'pgm_banners';
                                                }else if($asset_type == 'topcategories_copy') {
                                                    $asset_type = 'top_copy';
                                                }
                                            echo ucwords(str_replace('_', ' ', $asset_type))

                                            ?></div>
                                        <?php   }
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-6" style="padding: 0px 0px 0px 12px;">
                                        <div style="margin-top:0px;">
                                            <b>Due:</b>
                                        </div>
                                        <?php $assets = \App\Repositories\Admin\CampaignRepository::get_assets($campaign->id); ?>
                                        <?php if(!empty($assets)){
                                        foreach ($assets as $asset){?>
                                        <div><?php echo date('m/d/Y', strtotime($asset->due))  ?></div>
                                        <?php   }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $campaigns->appends(['q' => !empty($filter['q']) ? $filter['q'] : ''])->links() }}
    </div>
</section>




<div class="modal fade" id="DuplicateModal" tabindex="-1" role="dialog" aria-labelledby="DuplicateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Duplicate Campaign</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="msg"></div>
      <div class="modal-body">
        <form id="modalForm">
        @method('PUT')
        @csrf
          <div class="form-group">
          <label  class="col-form-label">Brand:</label>
          <select id="campaignBrand" name="campaignBrand" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected>Choose Brand</option>
            <?php $brands = \App\Repositories\Admin\CampaignBrandsRepository::staticfindAll(); ?>
            <?php if(!empty($brands)){
                foreach ($brands as $brand){?>
                <option value="<?php echo $brand->id;  ?>"><?php echo $brand->campaign_name;  ?></option>
                <?php  } ?>
            <?php  } ?>

        </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">New Project Title:</label>
            <textarea id="campaignName" class="form-control" style="height:100px;" name="campaignName" id="campaign_title"></textarea>
          </div>
        </form>
      </div>
      <div id='modal-footer' class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button id="duplicateButton" type="button" class="btn btn-primary">Duplicate</button>
      </div>




    </div>
                                    </div>

    <script type="text/javascript">

        function delete_campaign(el) {
            if (confirm("Are you sure to DELETE this project?") == true) {
                let c_id = $(el).attr('data-campaign-id');
                $.ajax({
                    url: "<?php echo url('/admin/campaign/campaignRemove'); ?>"+"/"+c_id,
                    type: "GET",
                    datatype: "json",
                    success: function(response) {
                        if(response == 'success'){
                            $(el).parent().parent().parent().parent().parent().fadeOut( "slow", function() {
                                $(el).parent().parent().parent().parent().parent().remove();
                            });
                        }else{
                            alert(response);
                        }
                    },
                })
            }
        }

    $(document).ready(function() {
        $('#DuplicateModal').on('show.bs.modal', function (el) {
        var button = $(el.relatedTarget)
        var campaign_id = button.data('campaign-id')
        var campaign_brand = button.data('campaign-brand');
        var campaign_name = button.data('campaign-name');
        var modal = $(this)

        modal.find('.modal-title').text('Duplicate project #' + campaign_id +" information.")
        $('#campaignName').val(campaign_name);
        $('select#campaignBrand option[value="' + campaign_brand +'"]').prop("selected", true);

        $('#duplicateButton').on('click', function(e) {
        $(this).prop('disabled', true).text('Duplicating...');
        var msg = "Duplicate Starting..."
        var msgBody = '<div class="alert alert-success" role="alert">'+msg+'</div>';
        $('#msg').html(msgBody);

            $.ajax({
                    url: "<?php echo url('/admin/campaign/duplicate'); ?>"+"/"+campaign_id,
                    type: "GET",
                    datatype: "json",
                    data:$("#modalForm").serialize(),
                    success: function(response) {
                        status = JSON.parse(JSON.stringify(response.status));
                        msg    = JSON.parse(JSON.stringify(response.msg));
                        id     = JSON.parse(JSON.stringify(response.id));

                        if(status == 'success'){
                            console.log('duplication started');
                            let obj = button.parent().parent().parent().parent().parent();
                            let parentBox = obj.parent();
                            let objClone = obj.clone();
                            let cardInfoID = objClone.find(".form-group .input-group #campaignID");
                            let closeButton = objClone.find(" div.card-header > h4 > span > a.close");
                            let duplicateButton = objClone.find("div.card-header > h4 > span > a.duplicate");
                            let openButton = objClone.find(".card-body .col-md-6 .form-group div a#openButton");


                            cardInfoID.html("<b>Project:</b> # "+id);
                            closeButton.attr('data-campaign-id',closeButton.attr('data-campaign-id').replace(campaign_id, id));
                            duplicateButton.attr('data-campaign-id',duplicateButton.attr('data-campaign-id').replace(campaign_id, id));
                            //openButton.attr('href',openButton.attr('href').replace(campaign_id, id));
                            parentBox.prepend(objClone);
                            $(this).prop('disabled', false).text('Done'); ;



                            msgBody = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                      msg+'</div>';

                            $('#msg').html(msgBody);



                            const TimeoutMsg = setTimeout(function(){
                                msgBody = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                          'Duplicate Finish.'+
                                          '</div>';
                                $('#msg').html(msgBody);
                                setTimeout(function(){ $('#DuplicateModal').modal("hide"); location.reload(); }, 1000);
                            }, 1000);







                        }else{
                            // alert(response);
                            console.log("Error ocurred in duplicating process.");
                        }
                    },
                });

                console.log('Clicked Send Button...');
        });

        });
    });






    </script>

@endsection
