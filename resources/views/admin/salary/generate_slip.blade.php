@extends('admin.layout.main-layout')
@section('title', config('app.name') . ' || Salary Slip')
@section('content')
    <style>
        @media print {
            .card {
                height: 90%;
            }
        }

        @media print {

            body {
                margin: 0;
                padding: 0;
            }

            .card {
                page-break-after: always;
                break-after: page;
                border: none !important;
                box-shadow: none !important;
            }

            .card:last-child {
                page-break-after: auto;
            }

            .container,
            .content {
                width: 100% !important;
            }

            .btn {
                display: none !important;
            }
        }

        @media print {
            .no-print {
                display: none !important;
            }
            .mobile-user-menu{                
                display: none !important;
            }
            .header{            
                display: none !important;
            }
            .footer{            
                display: none !important;
            }
        }
    </style>
    <div class="content">
        <div class="card mb-3 no-print">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Salary Slip</h4>
                <h4 class="mb-0">
                    {{ request()->month }} / {{ request()->year }}
                </h4>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
        @foreach ($data as $empId => $details)
            @php
                $emp = \App\Models\User::with(['profile', 'department', 'designation'])->find($empId);

                $attendance = $details->where('category', 'attendance')->pluck('value', 'type');
                $earnings = $details->where('category', 'earning');
                $deductions = $details->where('category', 'deduction');
                $net = $details->where('category', 'net');
                $netSalary = $net->first()->value;
            @endphp
            <div class="card mb-4 shadow-sm print-page">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center border-bottom mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-2">
                                    <img src="{{ asset('admin/img/logo.png') }}" class="img-fluid" alt="logo">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" text-end mb-3">
                                <h5 class="text-gray mb-1">Salary Month :
                                    <span class="text-primary">{{ request()->month }} {{ request()->year }}</span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row border-bottom mb-3">
                        <div class="col-md-8 mb-3">
                            <h4>Employee Information</h4>
                        </div>
                        <div class="col-md-4 mb-3">
                            <h4>Attendance Details</h4>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Name</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $emp->name ?? '-' }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">ID</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $emp->employee_code ?? '-' }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Department</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    {{ optional($emp->department)->name ?? '-' }}
                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Designation</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    {{ optional($emp->designation)->name ?? '-' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">UAN Number</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    {{ optional($emp->profile)->uan_number ?? '-' }}
                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">PF Number</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    {{ optional($emp->profile)->pf_account_number ?? '-' }}
                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">IFSC Code</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    {{ optional($emp->profile)->ifsc_code ?? '-' }}
                                </span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">ESIC Number</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">
                                    {{ optional($emp->profile)->esic_number ?? '-' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Working Days</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['month_days'] ?? 0 }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Present Days</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['present'] ?? 0 }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Week Off</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['weekends'] ?? 0 }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Holidays</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['holidays'] ?? 0 }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Leave</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['leaves'] ?? 0 }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Absents</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['absents'] ?? 0 }}</span>
                            </p>
                            <p class="mb-1 d-flex">
                                <span style="width: 100px;">Payable Days</span>
                                <span>:</span>
                                <span class="ms-2 text-dark">{{ $attendance['paybled_days'] ?? 0 }}</span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <h5 class="text-center mb-4">Salary Slip for Month of {{ request()->month }} -
                            {{ request()->year }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="list-group mb-3">
                                    <div class="list-group-item bg-light p-3 border-bottom-0">
                                        <h6>Earnings</h6>
                                    </div>
                                    @foreach ($earnings as $item)
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0">{{ $item->type }}</p>
                                                <h6 class="fw-medium">{{ number_format($item->value, 2) }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="list-group mb-3">
                                    <div class="list-group-item bg-light p-3 border-bottom-0">
                                        <h6>Deductions</h6>
                                    </div>
                                    @foreach ($deductions as $item)
                                        <div class="list-group-item">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="mb-0">{{ $item->type }}</p>
                                                <h6 class="fw-medium">{{ number_format($item->value, 2) }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="list-group mb-3">
                                <div class="list-group-item bg-light">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="mb-0">Net Salary</h6>
                                        <h6 class="fw-medium">
                                            ₹ {{ number_format($netSalary, 2) }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
