@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Category List')

@section('content')
    <div class="content">

        {{-- CARD --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Category List</h5>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add_category" class="btn btn-primary">
                    Add Category
                </a>
            </div>

            <div class="card-body">
                <table class="table table-bordered" id="categoryTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row->name }}</td>
                                <td>
                                    {!! $row->status
                                        ? '<span class="badge bg-success">Active</span>'
                                        : '<span class="badge bg-danger">Inactive</span>' !!}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary editBtn" data-id="{{ $row->id }}"
                                        data-name="{{ $row->name }}" data-status="{{ $row->status }}"
                                        data-bs-toggle="modal" data-bs-target="#edit_category">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= ADD MODAL ================= --}}
    <div class="modal fade" id="add_category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addForm">
                    @csrf
                    <div class="modal-header">
                        <h5>Add Category</h5>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="">Select</option>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger error-status"></span>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-save">
                            <span class="btn-text">Save</span>
                            <span class="btn-loader d-none">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= EDIT MODAL ================= --}}
    <div class="modal fade" id="edit_category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm">
                    @csrf
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-header">
                        <h5>Edit Category</h5>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control">
                            <span class="text-danger error-name"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger error-status"></span>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-update">
                            <span class="btn-text">Update</span>
                            <span class="btn-loader d-none">Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        $(document).ready(function() {

            $('#categoryTable').DataTable();

            // EDIT BUTTON CLICK
            $('.editBtn').click(function() {
                $('#edit_id').val($(this).data('id'));
                $('#edit_name').val($(this).data('name'));
                $('#edit_status').val($(this).data('status'));
            });

            // COMMON FUNCTION
            function handleValidationErrors(form, errors) {
                form.find('.text-danger').html('');
                form.find('.form-control, .form-select').removeClass('is-invalid');

                $.each(errors, function(key, value) {
                    form.find('[name="' + key + '"]').addClass('is-invalid');
                    form.find('.error-' + key).html(value[0]);
                });
            }

            function toggleLoader(btn, show) {
                if (show) {
                    btn.find('.btn-text').addClass('d-none');
                    btn.find('.btn-loader').removeClass('d-none');
                    btn.prop('disabled', true);
                } else {
                    btn.find('.btn-text').removeClass('d-none');
                    btn.find('.btn-loader').addClass('d-none');
                    btn.prop('disabled', false);
                }
            }

            // ================= ADD =================
            $('#addForm').submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('.btn-save');

                toggleLoader(btn, true);

                $.ajax({
                    url: "{{ route('admin.category.store') }}",
                    type: "POST",
                    data: form.serialize(),

                    success: function(res) {
                        toggleLoader(btn, false);

                        if (res.status) {
                            toastr.success(res.message);
                            $('#add_category').modal('hide');
                            location.reload();
                        }
                    },

                    error: function(xhr) {
                        toggleLoader(btn, false);

                        if (xhr.status === 422) {
                            handleValidationErrors(form, xhr.responseJSON.errors);
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    }
                });
            });

            // ================= UPDATE =================
            $('#editForm').submit(function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('.btn-update');

                toggleLoader(btn, true);

                $.ajax({
                    url: "{{ route('admin.category.update') }}",
                    type: "POST",
                    data: form.serialize(),

                    success: function(res) {
                        toggleLoader(btn, false);

                        if (res.status) {
                            toastr.success(res.message);
                            $('#edit_category').modal('hide');
                            location.reload();
                        }
                    },

                    error: function(xhr) {
                        toggleLoader(btn, false);

                        if (xhr.status === 422) {
                            handleValidationErrors(form, xhr.responseJSON.errors);
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    }
                });
            });

        });
    </script>
@endsection
