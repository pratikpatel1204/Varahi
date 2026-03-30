@extends('admin.layout.main-layout')

@section('content')
<div class="content">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ID Card Templates</h5>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Template Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $key => $template)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $template->name }}</td>
                            <td>
                                @if($template->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $template->created_at->format('d M, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.id.card.template.edit', $template->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="ti ti-edit"></i> Edit
                                </a>


                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No templates found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    $(document).on('click', '.toggleBtn', function () {
        let id  = $(this).data('id');
        let btn = $(this);

        Swal.fire({
            title: 'Set as Active?',
            text: 'Existing active template will be deactivated.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Set Active',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/id-card-template/toggle/' + id,
                    type: 'POST',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: 'Template set as active.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function () {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

});
</script>
@endsection
