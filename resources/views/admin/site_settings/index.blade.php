@extends('admin.layout.main-layout')

@section('content')
<style>
    tr img{
        height:50px !important;
    }
</style>
<div class="content">
<div class="container-fluid">

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">Companies</h4>
@can('Add Site')
        <button class="btn btn-primary" id="addBtn">
            <i class="fas fa-plus"></i> Add Company
        </button>
    @endcan
    </div>


    <div class="card-body">

        <table class="table table-bordered table-striped" id="companyTable">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
@php
$sno = 1;
@endphp
                @foreach($companies as $c)

                <tr>

                    <td>{{ $c->id}}</td>

                    <td>
                        @if($c->company_logo)
                            <img src="{{ asset($c->company_logo) }}">
                        @endif
                    </td>

                    <td>{{ $c->company_name }}</td>
                    <td>{{ $c->company_mobile }}</td>

                    <td>
@can('Edit Site')
                        <button class="btn btn-sm btn-success editBtn"
                                data-id="{{ $c->id }}"
                                data-name="{{ $c->company_name }}"
                                data-mobile="{{ $c->company_mobile }}"
                                data-address="{{ $c->company_address }}">
                            <i class="fas fa-edit"></i>
                        </button>
    @endcan
    @can('Delete Site')
                        <button class="btn btn-sm btn-danger deleteBtn"
                                data-id="{{ $c->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
    @endcan
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</div>
</div>


<!-- ================= MODAL ================= -->

<div class="modal fade" id="companyModal">

<div class="modal-dialog modal-lg">
<div class="modal-content">

<form id="companyForm" enctype="multipart/form-data">

@csrf

<input type="hidden" name="id" id="company_id">

<div class="modal-header">
    <h5 class="modal-title">Company</h5>
    <button type="button" class="btn-close"
            data-bs-dismiss="modal"></button>
</div>


<div class="modal-body">

<div class="row">

    <div class="col-md-6 mb-2">
        <label>Name</label>
        <input type="text"
               name="company_name"
               id="company_name"
               class="form-control">
    </div>

    <div class="col-md-6 mb-2">
        <label>Mobile</label>
        <input type="text"
               name="company_mobile"
               id="company_mobile"
               class="form-control">
    </div>

    <div class="col-md-12 mb-2">
        <label>Address</label>
        <textarea name="company_address"
                  id="company_address"
                  class="form-control"></textarea>
    </div>

    <div class="col-md-12 mb-2">
        <label>Logo</label>
        <input type="file"
               name="company_logo"
               class="form-control">
    </div>

</div>

</div>


<div class="modal-footer">
    <button class="btn btn-success">
        Save
    </button>
</div>

</form>

</div>
</div>
</div>

@endsection




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#companyTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10
    });

    /* ================= ADD ================= */
    $('#addBtn').click(function(){
        $('#companyForm')[0].reset();
        $('#company_id').val('');
        $('#companyModal').modal('show');
    });

    /* ================= EDIT ================= */
    $(document).on('click', '.editBtn', function(){
        $('#company_id').val($(this).data('id'));
        $('#company_name').val($(this).data('name'));
        $('#company_mobile').val($(this).data('mobile'));
        $('#company_address').val($(this).data('address'));
        $('#companyModal').modal('show');
    });

    /* ================= SAVE ================= */
    $('#companyForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('admin.site-settings.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
                Swal.fire(
                    'Success',
                    'Company Saved Successfully',
                    'success'
                ).then(()=>{
                    location.reload();
                });
            }
        });
    });

    /* ================= DELETE ================= */
    $(document).on('click', '.deleteBtn', function(){
        let id = $(this).data('id');
        let url = "{{ route('admin.site-settings.destroy', ':id') }}";
        url = url.replace(':id', id);
        Swal.fire({
            title: 'Delete?',
            text: "This company will be deleted",
            icon: 'warning',
            showCancelButton: true
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _method: 'DELETE',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(){
                        Swal.fire(
                            'Deleted',
                            'Company Deleted',
                            'success'
                        ).then(()=>{
                            location.reload();
                        });
                    }
                });
            }
        });
    });
});
</script>

