@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Create Inquiry')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Create Inquiry</h3>
                <a href="{{ route('employee.product.list') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form id="InquiryForm" enctype="multipart/form-data">
                    <div class="row">

                        {{-- Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control">
                            <small class="text-danger error-name"></small>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control">
                            <small class="text-danger error-email"></small>
                        </div>

                        {{-- Mobile --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile No <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control">
                            <small class="text-danger error-mobile"></small>
                        </div>

                        {{-- State --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control">
                            <small class="text-danger error-state"></small>
                        </div>

                        {{-- City --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control">
                            <small class="text-danger error-city"></small>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="address" class="form-control" rows="3"></textarea>
                            <small class="text-danger error-address"></small>
                        </div>

                        {{-- Multiple Products --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Select Products <span class="text-danger">*</span></label>
                            <select name="products[]" class="form-control select2" multiple>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger error-products"></small>
                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="button" id="submitInquiryBtn" class="btn btn-success">
                            <span class="btn-text">
                                <i class="fa fa-save"></i> Save Inquiry
                            </span>
                            <span class="spinner-border spinner-border-sm d-none btn-loader"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
