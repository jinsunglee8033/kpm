@extends('layouts.dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Brand Management</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active">Brands</div>
        </div>
    </div>
    <div class="section-body">
        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('admin.shared.flash')
                        @include('admin.brands._filter')
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-md">
                                <thead>
                                    <th>Brand Name</th>
{{--                                    <th width="25%">Action</th>--}}
                                </thead>
                                <tbody>
                                    @forelse ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->campaign_name}}</td>
{{--                                            <td>--}}
{{--                                                <a href="{{ url('admin/brands/'. $brand->id) }}" class="btn btn-sm btn-danger" onclick="--}}
{{--                                                    event.preventDefault();--}}
{{--                                                    if (confirm('Do you want to remove this Brand?')) {--}}
{{--                                                    document.getElementById('delete-brand-{{ $brand->id }}').submit();--}}
{{--                                                    }">--}}
{{--                                                    <i class="far fa-trash-alt"></i> Delete--}}
{{--                                                </a>--}}
{{--                                                <form id="delete-brand-{{ $brand->id }}" action="{{ url('admin/brands/'. $brand->id) }}" method="POST">--}}
{{--                                                    <input type="hidden" name="_method" value="DELETE">--}}
{{--                                                    @csrf--}}
{{--                                                </form>--}}
{{--                                            </td>--}}
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
