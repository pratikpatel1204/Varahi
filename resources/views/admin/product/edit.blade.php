@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Edit Product')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Edit Product</h3>
                <a href="{{ route('employee.product.list') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form id="productForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">

                    <div class="row">

                        {{-- NAME --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                            <small class="text-danger error-name"></small>
                        </div>

                        {{-- CATEGORY --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->name }}"
                                        {{ $product->category == $cat->name ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-danger error-category"></small>
                        </div>

                        {{-- PRICE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                            <small class="text-danger error-price"></small>
                        </div>

                        {{-- STOCK --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                            <small class="text-danger error-stock"></small>
                        </div>

                        {{-- IMAGE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control">
                            <small class="text-danger error-image"></small>

                            @if ($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->image) }}" width="80">
                                </div>
                            @endif
                        </div>

                        {{-- STATUS --}}
                        <div class="col-md-6 mb-3 d-flex align-items-center">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                    {{ $product->status ? 'checked' : '' }}>

                                <label class="form-check-label" id="statusLabel">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="text-end">
                        <button type="button" id="submitProductBtn" class="btn btn-primary">
                            <span class="btn-text">
                                <i class="fa fa-save"></i> Update Product
                            </span>
                            <span class="spinner-border spinner-border-sm d-none btn-loader"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- STATUS TOGGLE --}}
    <script>
        $(document).ready(function() {

            $('#status').on('change', function() {
                $('#statusLabel').text($(this).is(':checked') ? 'Active' : 'Inactive');
            });

        });
    </script>

    {{-- AJAX UPDATE --}}
    <script>
        $(document).ready(function() {

            $('#submitProductBtn').click(function() {

                let btn = $(this);
                let loader = btn.find('.btn-loader');
                let text = btn.find('.btn-text');

                $('[class^="error-"]').text('');
                $('.form-control').removeClass('is-invalid');

                let formData = new FormData($('#productForm')[0]);

                btn.prop('disabled', true);
                loader.removeClass('d-none');
                text.addClass('d-none');

                $.ajax({
                    url: "{{ route('employee.product.update') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {

                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');

                        if (response.status) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: response.message,
                            }).then(() => {
                                window.location.href =
                                    "{{ route('employee.product.list') }}";
                            });

                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },

                    error: function(xhr) {

                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                $('.error-' + key).text(value[0]);
                                $('[name="' + key + '"]').addClass('is-invalid');
                            });
                        } else {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    }
                });

            });

        });
    </script>
@endsection
