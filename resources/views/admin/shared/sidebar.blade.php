@php
    $activeClass = 'active';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard')}}">ECOM PROJECT MANAGER</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/')}}">KPM</a>
    </div>
    <ul class="sidebar-menu">

        <li class="{{ ($currentAdminMenu == 'dashboard') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dashboard') }}"><i class="fas fa-cog fa-spin"></i> <span>Dashboard</span></a></li>

{{--        <?php if(auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="menu-header">Form Request</li>--}}
{{--        <li class="{{ ($currentAdminMenu == 'qr_code') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/create_qr_code') }}"><i class="fas fa-qrcode"></i> <span>QR Code</span></a></li>--}}
{{--        <li class="{{ ($currentAdminMenu == 'index_qr_code') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/index_qr_code') }}"><i class="fas fa-qrcode"></i> <span>QR Code Management</span></a></li>--}}
{{--        <?php } ?>--}}

        <li class="menu-header">Projects</li>
        <li class="{{ ($currentAdminMenu == 'campaign') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/campaign') }}"><i class="fas fa-calendar"></i> <span>Project Manager</span></a></li>
        <li class="{{ ($currentAdminMenu == 'archives') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/archives') }}"><i class="fas fa-archive"></i> <span>Project Archives</span></a></li>

        <?php if(auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'deleted') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/deleted') }}"><i class="fas fa-trash"></i> <span>Project Deleted</span></a></li>
        <?php } ?>
        <li class="menu-header">ECOM Operations Team</li>

        <li class="{{ ($currentAdminMenu == 'asset_jira_kec') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_kec') }}"><i class="fas fa-th"></i> <span>All Status Board</span></a></li>

        <li class="menu-header">Copy Team</li>
        <?php if(auth()->user()->role == 'copywriter manager' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval_copy') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval_copy') }}"><i class="fas fa-list-ul"></i> <span>Copy List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'copywriter' || auth()->user()->role == 'copywriter manager' || auth()->user()->role == 'creative director' || auth()->user()->role == 'web production manager' || auth()->user()->role == 'content manager'|| auth()->user()->role == 'creative senior director' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_copywriter') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_copywriter') }}"><i class="fas fa-th"></i> <span>Status Board (Copy)</span></a></li>
        <?php } ?>
{{--        <?php if(auth()->user()->role == 'copywriter manager' || auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'asset_kpi_copy') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_kpi_copy') }}"><i class="fas fa-signal"></i> <span>KPI (Copy)</span></a></li>--}}
{{--        <?php } ?>--}}

        
        <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'developer manager'){ ?>
        <li class="{{ ($currentAdminMenu == 'copy_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/copy_approval') }}"><i class="fas fa-list-ul"></i> <span>Ticket Approval List</span></a></li>
        <?php } ?>
        <li class="{{ ($currentAdminMenu == 'copy_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/copy_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Ticket)</span></a></li>
        <li class="{{ ($currentAdminMenu == 'copy_archives') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/copy_archives') }}"><i class="fas fa-list-ul"></i> <span>Ticket Archives List</span></a></li>   

        <li class="menu-header">Creative Web Designers</li>
        <?php if(auth()->user()->role == 'creative director' || auth()->user()->role == 'admin'  || auth()->user()->role == 'creative senior director'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval') }}"><i class="fas fa-list-ul"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->team == 'Creative' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Creative)</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'creative director' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_kpi') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_kpi') }}"><i class="fas fa-signal"></i> <span>KPI (Creative)</span></a></li>
        <?php } ?>

        <li class="menu-header">Creative Content Team</li>
        <?php if(auth()->user()->role == 'content manager' || auth()->user()->role == 'admin' || auth()->user()->role == 'creative senior director'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval_content') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval_content') }}"><i class="fas fa-list-ul"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'content manager' || auth()->user()->role == 'content creator' || auth()->user()->role == 'admin' || auth()->user()->role == 'creative senior director'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_content') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_content') }}"><i class="fas fa-th"></i> <span>Status Board (Content)</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'content manager'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_kpi_content') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_kpi_content') }}"><i class="fas fa-signal"></i> <span>KPI (Content)</span></a></li>
        <?php } ?>

        <li class="menu-header">ECOM Web Production</li>
        <?php if(auth()->user()->role == 'web production manager' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_approval_web') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_approval_web') }}"><i class="fas fa-list-ul"></i> <span>Approval List</span></a></li>
        <?php } ?>
        <?php if(auth()->user()->role == 'web production manager' || auth()->user()->role == 'web production' || auth()->user()->role == 'admin'){ ?>
        <li class="{{ ($currentAdminMenu == 'asset_jira_web') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_jira_web') }}"><i class="fas fa-th"></i> <span>Status Board (Web)</span></a></li>
        <?php } ?>
{{--        <?php if(auth()->user()->role == 'admin'){ ?>--}}
{{--        <li class="{{ ($currentAdminMenu == 'asset_kpi_web') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_kpi_web') }}"><i class="fas fa-signal"></i> <span>KPI (Web)</span></a></li>--}}
{{--        <?php } ?>--}}

<li class="menu-header">Account</li>
            <?php if(auth()->user()->role == 'admin'){ ?>
            <li class="{{ ($currentAdminMenu == 'users') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/users')}}"><i class="fas fa-user"></i> <span>Users</span></a></li>
            <?php } ?>
            <li class="menu-header">Settings</li>
            <li class="{{ ($currentAdminMenu == 'asset_lead_time') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_lead_time')}}"><i class="fas fa-hourglass-start"></i> <span>Asset Lead Time</span></a></li>
            <?php if(auth()->user()->role == 'admin'){ ?>
            <li class="{{ ($currentAdminMenu == 'asset_owners') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/asset_owners')}}"><i class="fas fa-address-book"></i> <span>Asset Owners</span></a></li>
            <li class="{{ ($currentAdminMenu == 'brands') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/brands')}}"><i class="fas fa-bold"></i> <span>Brands</span></a></li>
            <?php } ?>

{{-- This module was holded --}}
       <?php if(!$this_is_module="holded"){ ?>
            <li class="menu-header">ECOM Dev Team</li>
            <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'developer manager'){ ?>
            <li class="{{ ($currentAdminMenu == 'dev_approval') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dev_approval') }}"><i class="fas fa-list-ul"></i> <span>Approval List</span></a></li>
            <?php } ?>
            <li class="{{ ($currentAdminMenu == 'dev_jira') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dev_jira') }}"><i class="fas fa-th"></i> <span>Status Board (Dev)</span></a></li>
            <li class="{{ ($currentAdminMenu == 'dev_archives') ? $activeClass : '' }}"><a class="nav-link" href="{{ url('admin/dev_archives') }}"><i class="fas fa-list-ul"></i> <span>Archives List</span></a></li>

        <?php } ?>


    </ul>
</aside>
