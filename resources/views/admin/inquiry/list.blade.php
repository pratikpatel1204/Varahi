@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Product Inquiry')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h3 class="mb-0">Product Inquiry</h3>
                <a href="{{ route('employee.inquiry.list') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add Inquiry
                </a>
            </div>
        </div>
    </div>
@endsection
