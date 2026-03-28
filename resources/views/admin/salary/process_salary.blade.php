@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Salary Processing')
@section('content')
    <div class="content">
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Salary Processing for {{ $monthName }} {{ $yearName }}</h5>
                @if ($SalaryVerified)
                    <span class="badge bg-success">Salary Processed</span>
                @else
                    <span class="badge bg-warning">Pending</span>
                @endif
                <a href="{{ route('admin.salary.Processing', ['year' => $yearName, 'month' => $monthName]) }}"
                    class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form method="POST">
                        @csrf
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Emp Code</th>
                                    <th>Emp Name</th>
                                    <th>Designation</th>
                                    <th>Account</th>
                                    <th>IFSC</th>
                                    <th>Month Days</th>
                                    <th>Present</th>
                                    <th>Holiday</th>
                                    <th>Weekend</th>
                                    <th>Leave</th>
                                    <th>Absent</th>
                                    <th>Paybled Days</th>
                                    @php
                                        $earningTypes = $employees->first()?->earnings->pluck('salary_type_name') ?? [];
                                    @endphp
                                    @foreach ($earningTypes as $type)
                                        <th>{{ $type }}</th>
                                    @endforeach
                                    @php
                                        $deductionTypes =
                                            $employees->first()?->deductions->pluck('salary_type_name') ?? [];
                                    @endphp
                                    @foreach ($deductionTypes as $type)
                                        <th>{{ $type }}</th>
                                    @endforeach
                                    @php
                                        $netsTypes = $employees->first()?->net->pluck('salary_type_name') ?? [];
                                    @endphp
                                    @foreach ($netsTypes as $type)
                                        <th>{{ $type }}</th>
                                    @endforeach
                                    <th>Loan</th>
                                    <th>Expense</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $emp)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                            <input type="hidden" name="employee_id[]" value="{{ $emp->id }}">
                                            <input type="hidden" name="year" value="{{ $yearName }}">
                                            <input type="hidden" name="month" value="{{ $monthName }}">
                                        </td>
                                        <td>
                                            {{ $emp->employee_code }}
                                            <input type="hidden" name="emp_code[{{ $emp->id }}]"
                                                value="{{ $emp->employee_code }}">
                                        </td>
                                        <td>
                                            {{ $emp->name }}
                                            <input type="hidden" name="emp_name[{{ $emp->id }}]"
                                                value="{{ $emp->name }}">
                                        </td>
                                        <td>
                                            {{ $emp->designation->name ?? 'N/A' }}
                                            <input type="hidden" name="designation[{{ $emp->id }}]"
                                                value="{{ $emp->designation->name ?? 'N/A' }}">
                                        </td>
                                        <td>
                                            {{ $emp->profile?->account_number ?? 'N/A' }}
                                            <input type="hidden" name="account_number[{{ $emp->id }}]"
                                                value="{{ $emp->profile?->account_number ?? 'N/A' }}">
                                        </td>
                                        <td>
                                            {{ $emp->profile?->ifsc_code ?? 'N/A' }}
                                            <input type="hidden" name="ifsc[{{ $emp->id }}]"
                                                value="{{ $emp->profile?->ifsc_code ?? 'N/A' }}">
                                        </td>
                                        <td>
                                            {{ $monthdays }}
                                            <input type="hidden" name="month_days[{{ $emp->id }}]"
                                                value="{{ $monthdays }}">
                                        </td>
                                        <td>
                                            {{ $emp->emppresent }}
                                            <input type="hidden" name="present[{{ $emp->id }}]"
                                                value="{{ $emp->emppresent }}">
                                        </td>
                                        <td>
                                            {{ $emp->holidays }}
                                            <input type="hidden" name="holidays[{{ $emp->id }}]"
                                                value="{{ $emp->holidays }}">
                                        </td>
                                        <td>
                                            {{ $sundaysCount }}
                                            <input type="hidden" name="weekends[{{ $emp->id }}]"
                                                value="{{ $sundaysCount }}">
                                        </td>
                                        <td>
                                            {{ $emp->leaveDays }}
                                            <input type="hidden" name="leaves[{{ $emp->id }}]"
                                                value="{{ $emp->leaveDays }}">
                                        </td>
                                        <td>
                                            {{ $emp->absents }}
                                            <input type="hidden" name="absents[{{ $emp->id }}]"
                                                value="{{ $emp->absents }}">
                                        </td>
                                        <td>
                                            {{ $emp->paybledays }}
                                            <input type="hidden" name="paybled_days[{{ $emp->id }}]"
                                                value="{{ $emp->paybledays }}">
                                        </td>
                                        @foreach ($emp->earnings as $earning)
                                            <td>
                                                {{ number_format($earning->amount, 2) }}
                                                <input type="hidden"
                                                    name="earnings[{{ $emp->id }}][{{ $earning->salary_type_name }}]"
                                                    value="{{ $earning->amount }}">
                                            </td>
                                        @endforeach
                                        @foreach ($emp->deductions as $deduction)
                                            <td>
                                                {{ number_format($deduction->amount, 2) }}
                                                <input type="hidden"
                                                    name="deductions[{{ $emp->id }}][{{ $deduction->salary_type_name }}]"
                                                    value="{{ $deduction->amount }}">
                                            </td>
                                        @endforeach
                                        @foreach ($emp->net as $nets)
                                            <td>
                                                {{ number_format($nets->amount, 2) }}
                                                <input type="hidden"
                                                    name="net[{{ $emp->id }}][{{ $nets->salary_type_name }}]"
                                                    value="{{ $nets->amount }}">
                                            </td>
                                        @endforeach
                                        <td>
                                            {{ number_format($emp->loanEmi, 2) }}
                                            <input type="hidden" name="loan[{{ $emp->id }}]"
                                                value="{{ $emp->loanEmi }}">
                                        </td>
                                        <td>
                                            {{ number_format($emp->expenseTotal, 2) }}
                                            <input type="hidden" name="expense[{{ $emp->id }}]"
                                                value="{{ $emp->expenseTotal }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="mt-3 text-end">
                    <button type="button" id="submitSalaryBtn"
                        class="btn {{ $SalaryVerified ? 'btn-warning' : 'btn-success' }}">
                        <span class="btn-text">
                            <i class="fa fa-save"></i>
                            {{ $SalaryVerified ? 'Already Verified (Click to Re-Verify)' : 'Process Salary' }}
                        </span>
                        <span class="spinner-border spinner-border-sm d-none" id="btnLoader"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#submitSalaryBtn').on('click', function() {

                let btn = $(this);
                let loader = $('#btnLoader');
                let text = $('.btn-text');

                // show loader
                btn.prop('disabled', true);
                loader.removeClass('d-none');
                text.addClass('d-none');

                $.ajax({
                    url: "{{ route('admin.salary.process.save') }}",
                    type: "POST",
                    data: $('form').serialize(),

                    success: function(response) {

                        // hide loader
                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message ??
                                    'Salary processed successfully',
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message ?? 'Something went wrong',
                                confirmButtonColor: '#d33'
                            });
                        }
                    },

                    error: function(xhr) {

                        btn.prop('disabled', false);
                        loader.addClass('d-none');
                        text.removeClass('d-none');

                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });

            });

        });
    </script>
@endsection
