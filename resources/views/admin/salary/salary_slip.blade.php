@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Salary Slip')
@section('content')
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Salary Slip - {{ $month }} / {{ $year }}
                </h5>
                <a href="{{ route('admin.salary.Processing', ['year' => $year, 'month' => $month]) }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <button type="button" id="generateSlipBtn" class="btn btn-success btn-sm">
                    <span class="btn-text">
                        <i class="fa fa-file-pdf"></i> Generate Slip
                    </span>
                    <span class="spinner-border spinner-border-sm d-none" id="btnLoader"></span>
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="employeeTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $emp)
                            <tr>
                                <td>
                                    <input type="checkbox" class="empCheckbox" value="{{ $emp->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $emp->employee_code ?? '-' }}</td>
                                <td>{{ $emp->name }}</td>
                                <td>{{ $emp->department->name ?? '-' }}</td>
                                <td>{{ $emp->designation->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // ✅ DataTable init
            $('#employeeTable').DataTable();

            // ✅ Select All
            $('#selectAll').on('click', function() {
                $('.empCheckbox').prop('checked', this.checked);
            });

            // ✅ Uncheck Select All if any unchecked
            $(document).on('click', '.empCheckbox', function() {
                if (!$(this).prop('checked')) {
                    $('#selectAll').prop('checked', false);
                }

                // If all checked → check selectAll
                if ($('.empCheckbox:checked').length === $('.empCheckbox').length) {
                    $('#selectAll').prop('checked', true);
                }
            });

            // ✅ Generate Button Click
            $('#generateSlipBtn').click(function() {

                let selected = [];

                $('.empCheckbox:checked').each(function() {
                    selected.push($(this).val());
                });

                // ❌ validation
                if (selected.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Employee',
                        text: 'Please select at least one employee'
                    });
                    return;
                }

                // ✅ create dynamic form for POST in new tab
                let form = $('<form>', {
                    action: "{{ route('admin.salary.slip.generate') }}",
                    method: 'POST',
                    target: '_blank'
                });

                form.append('@csrf');

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'year',
                    value: "{{ $year }}"
                }));

                form.append($('<input>', {
                    type: 'hidden',
                    name: 'month',
                    value: "{{ $month }}"
                }));

                // append selected employees
                selected.forEach(function(id) {
                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'employees[]',
                        value: id
                    }));
                });

                $('body').append(form);
                form.submit();
                form.remove();
            });

        });
    </script>
@endsection
