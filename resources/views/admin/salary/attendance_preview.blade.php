@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Attendance Preview')
@section('content')
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Attendance Preview - {{ $month }} {{ $year }}
                </h5>
                <h5 class="mb-0">
                    <strong>Total Working Days:</strong> {{ $totalWorkingDays }}
                </h5>
                <a href="{{ route('admin.salary.Processing', ['year' => $year, 'month' => $month]) }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form id="attendancePreviewForm">
                    @csrf

                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Action</th>
                                    <th>Employee</th>
                                    <th>Total Days</th>
                                    <th>Present</th>
                                    <th>Holiday</th>
                                    <th>Sick Leave</th>
                                    <th>Casual Leave</th>
                                    <th>Paid Leave</th>
                                    <th>Absent</th>
                                    <th>Payable Days</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $index => $row)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.salary.attendance.show', ['employee_id' => $row['employee_id'], 'month' => $month, 'year' => $year]) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $row['employee_name'] }}
                                            <br>
                                            {{ $row['employee_code'] }}
                                            <input type="hidden" name="rows[{{ $index }}][employee_name]"
                                                value="{{ $row['employee_name'] }}">
                                            <input type="hidden" name="rows[{{ $index }}][employee_code]"
                                                value="{{ $row['employee_code'] }}">
                                            <input type="hidden" name="rows[{{ $index }}][employee_id]"
                                                value="{{ $row['employee_id'] }}">
                                        </td>
                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="total_days">
                                                {{ $row['total_days'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][total_days]"
                                                value="{{ $row['total_days'] }}">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="present_days">
                                                {{ $row['present_days'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][present_days]"
                                                value="{{ $row['present_days'] }}">
                                        </td>
                                        <td>
                                            <div class="cell-value">{{ $row['holiday_days'] ?? 0 }}</div>
                                            <input type="hidden" name="rows[{{ $index }}][holiday_days]" value="{{ $row['holiday_days'] ?? 0 }}">
                                        </td>
                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="sick_leave">
                                                {{ $row['sick_leave'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][sick_leave]"
                                                value="{{ $row['sick_leave'] }}">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="casual_leave">
                                                {{ $row['casual_leave'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][casual_leave]"
                                                value="{{ $row['casual_leave'] }}">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="paid_leave">
                                                {{ $row['paid_leave'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][paid_leave]"
                                                value="{{ $row['paid_leave'] }}">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="absent_days">
                                                {{ $row['absent_days'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][absent_days]"
                                                value="{{ $row['absent_days'] }}">
                                        </td>

                                        <td>
                                            <div contenteditable="true" class="cell-value" data-row="{{ $index }}"
                                                data-col="payable_days">
                                                {{ $row['payable_days'] }}
                                            </div>
                                            <input type="hidden" name="rows[{{ $index }}][payable_days]"
                                                value="{{ $row['payable_days'] }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-danger">No Attendance Data Found</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <button type="button" id="submitBtn"
                        class="btn mt-3 w-auto {{ $attendanceVerified ? 'btn-warning' : 'btn-success' }}">

                        <span class="btn-text">
                            {{ $attendanceVerified ? 'Already Verified (Click to Re-Verify)' : 'Finalize & Verify' }}
                        </span>

                        <span class="btn-loader d-none">
                            <span class="spinner-border spinner-border-sm"></span> Processing...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.cell-value').forEach(cell => {
            cell.addEventListener('input', function() {
                const row = this.dataset.row;
                const col = this.dataset.col;
                const hiddenInput = document.querySelector(`input[name="rows[${row}][${col}]"]`);
                hiddenInput.value = this.textContent.trim();
            });
        });

        document.getElementById('submitBtn').addEventListener('click', function() {

            let btn = this;
            let loader = btn.querySelector('.btn-loader');
            let text = btn.querySelector('.btn-text');

            btn.disabled = true;
            loader.classList.remove('d-none');
            text.classList.add('d-none');

            let formData = new FormData(document.getElementById('attendancePreviewForm'));

            fetch("{{ route('admin.salary.attendance.store') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {

                    btn.disabled = false;
                    loader.classList.add('d-none');
                    text.classList.remove('d-none');

                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message || 'Attendance Verified!'
                        }).then(() => location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Something went wrong'
                        });
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    loader.classList.add('d-none');
                    text.classList.remove('d-none');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!'
                    });
                });
        });
    </script>
@endsection
