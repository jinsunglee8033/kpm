<form method="GET" action="{{ route('asset.approval_copy') }}">
    <div class="form-row" style="background-color: white; margin: -16px 0px 0px 0px; padding: 0px 0px 0px 12px;">
        <hr width="99%" />
        <div class="form-group col-md-2">
            <input type="text" name="q" class="design-field" id="q" placeholder="Project Name" value="{{ !empty($filter['q']) ? $filter['q'] : '' }}">
        </div>
        <div class="form-group col-md-2">
            <select class="design-select" name="brand_id">
                <option value="">Select Brand</option>
                @foreach ($brands as $key => $value)
                    <option value="{{ $key }}" @if( $key == $brand_id) selected="selected" @endif >
                        {{$value}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="campaign_id" class="design-field" id="q" placeholder="Project ID" value="{{ !empty($filter['campaign_id']) ? $filter['campaign_id'] : '' }}">
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="asset_id" class="design-field" id="q" placeholder="Asset ID" value="{{ !empty($filter['asset_id']) ? $filter['asset_id'] : '' }}">
        </div>
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
{{--        <div class="form-group col-md-2">--}}
{{--        </div>--}}
        <div class="form-group col-md-2">
            <button class="design-btn">Apply</button>
        </div>
</div>
        <div class="form-row" style="background-color: white; margin: 0px 0px 0px 0px; padding: 0px 0px 0px 12px;">
            <div class="form-group col-md-12 switch-group">
                <a class="switch-link active" href="{{ url('admin/asset_approval_copy') }}">Asset Approval (<?php echo count($asset_list); ?>)</a>
                <span class="sp"></span>
                <a class="switch-link" href="{{ route('copy.approval') }}">Ticket Approval (<?php echo count($copy_list); ?>)</a>

            </div>
        </div>
</form>
 
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
    font-weight: 600 !important;
}
span.sp{
    margin: auto 0.6rem;
    border-left: 1px solid #959292;
    padding: 4px 0;
}



</style>   