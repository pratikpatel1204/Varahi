@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Dashboard')
@section('content')
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-1">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">Superadmin</li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Welcome Wrap -->
        <div class="welcome-wrap mb-2 p-2">
            <div class=" d-flex align-items-center justify-content-between flex-wrap">
                <h2 class="text-white">Welcome Back, {{ auth()->user()->name }}</h2>
            </div>
            <div class="welcome-bg">
                <img src="{{ asset('admin/img/bg/welcome-bg-02.svg') }}" alt="img" class="welcome-bg-01"
                    style="height: 50px;">
                <img src="{{ asset('admin/img/bg/welcome-bg-03.svg') }}" alt="img" class="welcome-bg-02"
                    style="top: -25px;">
                <img src="{{ asset('admin/img/bg/welcome-bg-01.svg') }}" alt="img" class="welcome-bg-03">
            </div>
        </div>
        <!-- /Welcome Wrap -->    
    </div>
@endsection
