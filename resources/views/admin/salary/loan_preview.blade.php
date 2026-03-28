@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Loan Deduction')
@section('content')
    <div class="content">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Loan Deduction - {{ $monthName }} / {{ $yearName }}
                </h5>
                <a href="{{ route('admin.salary.Processing', ['year' => $year, 'month' => $month]) }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form id="loanForm">
                    @csrf
                    <input type="hidden" name="year" value="{{ $year }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    @if ($loans->count() == 0)
                        <div class="alert alert-info">
                            No active loans found for this month.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Loan Amount</th>
                                        <th>Interest (%)</th>
                                        <th>Total EMI</th>
                                        <th>EMI Amount</th>
                                        <th>Deduction</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td>
                                                {{ $loan->employee->name ?? 'N/A' }}
                                            </td>

                                            <td>{{ $loan->loan_amount }}</td>

                                            <td>{{ $loan->interest_rate }}%</td>

                                            <td>{{ $loan->no_of_emi }}</td>

                                            <td>{{ round($loan->emi_amount, 2) }}</td>

                                            <td>
                                                <input type="number" name="loan[{{ $loan->employee_id }}][amount]"
                                                    value="{{ round($loan->emi_amount, 2) }}" class="form-control">

                                                <input type="hidden" name="loan[{{ $loan->employee_id }}][loan_id]"
                                                    value="{{ $loan->id }}">
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif
                    <button type="button" id="submitLoanBtn"class="btn mt-3 w-auto {{ $loanVerified ? 'btn-warning' : 'btn-success' }}">
                        <span class="btn-text">
                            {{ $loanVerified ? 'Already Verified (Click to Re-Verify)' : 'Verify Loan Deduction' }}
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
        document.getElementById('submitLoanBtn').addEventListener('click', function() {

            let btn = this;
            let loader = btn.querySelector('.btn-loader');
            let text = btn.querySelector('.btn-text');

            // Disable + loader
            btn.disabled = true;
            loader.classList.remove('d-none');
            text.classList.add('d-none');

            let formData = new FormData(document.getElementById('loanForm'));

            fetch("{{ route('admin.salary.loan.verify') }}", {
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
                            text: data.message || 'Loan verified successfully!'
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
