<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeSalaryType;
use App\Models\EmployeeSalaryYear;
use App\Models\ExpenseReimbursement;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LoanManagement;
use App\Models\Month;
use App\Models\MonthlyWorkingDay;
use App\Models\SalaryDetail;
use App\Models\SalaryLoanDeduction;
use App\Models\SalaryProcessStatus;
use App\Models\User;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalaryProcessingController extends Controller
{
    public function salary_processing(Request $request)
    {
        $years = Year::all();
        $months = Month::all();

        $selectedYear = $request->year;
        $selectedMonth = $request->month;

        return view('admin.salary.process', compact(
            'years',
            'months',
            'selectedYear',
            'selectedMonth'
        ));
    }
    public function salary_process_status(Request $request)
    {
        $status = SalaryProcessStatus::where('year', $request->year)
            ->where('month', $request->month)->first();
        return response()->json($status);
    }

    public function salary_attendance_preview(Request $request)
    {
        $year  = $request->year;
        $month = $request->month;

        // Default empty values
        $rows = [];
        $attendanceVerified = 0;
        $totalWorkingDays = 0;
        $holidayDaysCount = 0;

        if ($year && $month) {

            // Get Year & Month IDs
            $yearData  = Year::where('year', $year)->first();
            $monthData = Month::where('month_name', $month)->first();

            if ($yearData && $monthData) {

                $yearId  = $yearData->id;
                $monthNumber = \Carbon\Carbon::parse($month)->month;

                // Working Days
                $workingDays = MonthlyWorkingDay::where('year_id', $yearId)
                    ->where('month_id', $monthData->id)
                    ->first();

                $totalWorkingDays = $workingDays->total_days ?? 0;

                // Holidays in this month
                $holidays = Holiday::where('year_id', $yearId)
                    ->where('status', 'Active')
                    ->where(function ($q) use ($monthNumber, $year) {
                        $q->whereMonth('from_date', $monthNumber)
                            ->orWhereMonth('to_date', $monthNumber);
                    })
                    ->get();

                // Count total holiday days in the month
                $holidayDaysCount = 0;
                foreach ($holidays as $holiday) {
                    $start = \Carbon\Carbon::parse($holiday->from_date);
                    $end = \Carbon\Carbon::parse($holiday->to_date);

                    // Make sure the holiday range overlaps the current month
                    $start = $start->month < $monthNumber ? \Carbon\Carbon::create($year, $monthNumber, 1) : $start;
                    $end = $end->month > $monthNumber ? \Carbon\Carbon::create($year, $monthNumber, \Carbon\Carbon::create($year, $monthNumber, 1)->daysInMonth) : $end;

                    $holidayDaysCount += $start->diffInDays($end) + 1;
                }

                // Attendance
                $attendances = Attendance::with('user')
                    ->where('year', $year)
                    ->where('month', $month)
                    ->get()
                    ->groupBy('user_id');

                foreach ($attendances as $userId => $records) {

                    $user = $records->first()->user;

                    $presentDays = $records->where('status', 'Approved')->count();

                    // Leaves
                    $leaves = Leave::with('leaveType')
                        ->where('user_id', $userId)
                        ->where('status', 'Approved')
                        ->whereYear('from_date', $year)
                        ->whereMonth('from_date', $monthNumber)
                        ->get();

                    $leaveTypeWise = $leaves->groupBy('leave_type_id');

                    $sickLeave   = optional($leaveTypeWise->get(1))->sum('days') ?? 0;
                    $casualLeave = optional($leaveTypeWise->get(2))->sum('days') ?? 0;
                    $paidLeave   = optional($leaveTypeWise->get(3))->sum('days') ?? 0;

                    $totalLeave = $leaves->sum('days');

                    $payableDays = $presentDays + $paidLeave;

                    // Include holidays in absent calculation
                    $absentDays = max($totalWorkingDays - ($presentDays + $totalLeave + $holidayDaysCount), 0);

                    $rows[] = [
                        'employee_id'   => $userId,
                        'employee_name' => $user->name ?? '-',
                        'employee_code' => $user->employee_code ?? '-',

                        'total_days'    => $totalWorkingDays,
                        'present_days'  => $presentDays,

                        'sick_leave'    => $sickLeave,
                        'casual_leave'  => $casualLeave,
                        'paid_leave'    => $paidLeave,

                        'leave_days'    => $totalLeave,
                        'holiday_days'  => $holidayDaysCount,
                        'payable_days'  => $payableDays,
                        'absent_days'   => $absentDays,
                    ];
                }

                // Salary Process Status
                $status = SalaryProcessStatus::where('year', $year)
                    ->where('month', $month)
                    ->first();

                $attendanceVerified = $status->attendance_verified ?? 0;
            }
        }

        return view('admin.salary.attendance_preview', compact(
            'rows',
            'year',
            'month',
            'attendanceVerified',
            'totalWorkingDays',
            'holidayDaysCount'
        ));
    }

    public function salary_attendance_show($employee_id, $month, $year)
    {
        $user = User::findOrFail($employee_id);

        $today = Carbon::today()->format('Y-m-d');

        $monthNumber = date('m', strtotime($month));

        $attendances = Attendance::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNumber)
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));

        $leaves = Leave::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->whereYear('from_date', $year)
            ->whereMonth('from_date', $monthNumber)
            ->get();

        $leaveDates = [];
        foreach ($leaves as $leave) {
            $start = Carbon::parse($leave->from_date);
            $end   = Carbon::parse($leave->to_date);

            while ($start <= $end) {
                $leaveDates[$start->format('Y-m-d')] = true;
                $start->addDay();
            }
        }

        $start = Carbon::create($year, $monthNumber)->startOfMonth();
        $end   = Carbon::create($year, $monthNumber)->endOfMonth();

        $calendar = [];

        while ($start <= $end) {
            $date = $start->format('Y-m-d');

            if ($date > $today) {
                $calendar[$date] = ['status' => '', 'color' => '#ffffff'];
            } elseif (isset($attendances[$date])) {
                $att = $attendances[$date];

                if ($att->punch_in && $att->punch_out && $att->is_manual == 0 && $att->status == 'Approved') {
                    $calendar[$date] = ['status' => 'P', 'color' => '#28a745'];
                } elseif ($att->punch_in && $att->is_manual == 1 && $att->status == 'Pending') {
                    $calendar[$date] = ['status' => 'AP', 'color' => '#ffc107'];
                } elseif ($att->status == 'Rejected') {
                    $calendar[$date] = ['status' => 'A', 'color' => '#dc3545'];
                } else {
                    $calendar[$date] = ['status' => 'A', 'color' => '#dc3545'];
                }
            } elseif (isset($leaveDates[$date])) {
                $calendar[$date] = ['status' => 'L', 'color' => '#17a2b8'];
            } else {
                $calendar[$date] = ['status' => 'A', 'color' => '#dc3545'];
            }

            $start->addDay();
        }

        $events = [];
        foreach ($calendar as $date => $data) {
            $textColor = ($data['status'] == 'AP' || $data['status'] == '') ? '#000000' : '#ffffff';
            $events[] = [
                'title' => $data['status'],
                'start' => $date,
                'backgroundColor' => $data['color'],
                'borderColor' => $data['color'],
                'textColor' => $textColor,
            ];
        }

        return view('admin.salary.attendance_change', compact('events', 'month', 'year', 'user'));
    }

    public function salary_attendance_update(Request $request)
    {
        try {
            $userId = $request->id;
            $dates  = $request->dates ?? [];
            $year   = $request->year;
            $month  = $request->month;

            // ✅ Validation
            if (!$userId || !$year || !$month) {
                return response()->json([
                    'status' => false,
                    'message' => 'Required data missing'
                ]);
            }

            if (empty($dates)) {
                return response()->json([
                    'status' => false,
                    'message' => 'No dates selected'
                ]);
            }

            $today = Carbon::today();

            foreach ($dates as $date) {

                $parsedDate = Carbon::parse($date);

                // ✅ Skip today & future
                if ($parsedDate->gte($today)) {
                    continue;
                }

                $formattedDate = $parsedDate->format('Y-m-d');

                // ✅ Find existing record
                $existing = Attendance::where('user_id', $userId)
                    ->where('date', $formattedDate)
                    ->first();

                // ✅ Skip if AUTO attendance already complete
                if (
                    $existing &&
                    $existing->punch_in &&
                    $existing->punch_out &&
                    $existing->is_manual == 0
                ) {
                    continue;
                }
                $punchIn  = $existing->punch_in ?? '09:00:00';
                $punchOut = $existing->punch_out ?? '18:00:00';
                $totalHours = Carbon::parse($punchIn)->diff(Carbon::parse($punchOut))->format('%H:%I:%S');

                // ✅ Prepare common data
                $data = [
                    'punch_in'    => $punchIn,
                    'punch_out'   => $punchOut,
                    'total_hours' => $totalHours,
                    'status'    => 'Approved',
                    'is_manual' => 0,
                    'year'      => $parsedDate->year,
                    'month'     => $parsedDate->format('F'),
                ];

                // ✅ Update or Create
                if ($existing) {
                    $existing->update($data);
                } else {
                    Attendance::create(array_merge($data, [
                        'user_id' => $userId,
                        'date'    => $formattedDate,
                    ]));
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Attendance updated successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function salary_attendance_store(Request $request)
    {
        try {
            $rows  = $request->rows ?? [];
            $year  = $request->year;
            $month = $request->month;

            if (!$year || !$month) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid data'
                ]);
            }

            foreach ($rows as $row) {

                EmployeeAttendance::updateOrCreate(
                    [
                        'employee_id' => $row['employee_id'],
                        'year'        => $year,
                        'month'       => $month,
                    ],
                    [
                        'employee_name' => $row['employee_name'],
                        'employee_code' => $row['employee_code'],

                        'total_days'    => $row['total_days'],
                        'present_days'  => $row['present_days'],

                        'sick_leave'    => $row['sick_leave'],
                        'casual_leave'  => $row['casual_leave'],
                        'paid_leave'    => $row['paid_leave'],
                        'holiday_days'  => $row['holiday_days'],
                        'leave_days'    => ($row['sick_leave'] + $row['casual_leave'] + $row['paid_leave']),
                        'absent_days'   => $row['absent_days'],
                        'payable_days'  => $row['payable_days'],
                    ]
                );
            }

            SalaryProcessStatus::updateOrCreate(
                [
                    'year'  => $year,
                    'month' => $month,
                ],
                [
                    'attendance_verified' => 1
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Attendance finalized & verified successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function salary_loan_preview(Request $request)
    {
        $year  = $request->year;
        $month = $request->month;

        $monthNumber = Carbon::parse($month)->month;

        $startOfMonth = Carbon::create($year, $monthNumber)->startOfMonth();
        $endOfMonth   = Carbon::create($year, $monthNumber)->endOfMonth();

        $loans = LoanManagement::with('employee')
            ->where('status', 'approved')
            ->whereDate('emi_start_date', '<=', $endOfMonth)
            ->whereDate('emi_end_date', '>=', $startOfMonth)
            ->get();

        $status = SalaryProcessStatus::where('year', $year)
            ->where('month', $month)
            ->first();

        $loanVerified = $status->loan_verified ?? 0;

        return view('admin.salary.loan_preview', [
            'loans'        => $loans,
            'yearName'     => $year,
            'monthName'    => $month,
            'year'         => $year,
            'month'        => $month,
            'loanVerified' => $loanVerified
        ]);
    }
    public function salary_loan_verify(Request $request)
    {

        if (!$request->year || !$request->month) {
            return response()->json([
                'status' => false,
                'message' => 'Year & Month required'
            ]);
        }

        if ($request->loan) {

            foreach ($request->loan as $employee_id => $loanData) {

                SalaryLoanDeduction::updateOrCreate(
                    [
                        'employee_id' => $employee_id,
                        'loan_id'     => $loanData['loan_id'],
                        'year'        => $request->year,
                        'month'       => $request->month,
                    ],
                    [
                        'deduction_amount' => $loanData['amount'],
                    ]
                );
            }
        }

        SalaryProcessStatus::updateOrCreate(
            [
                'year'  => $request->year,
                'month' => $request->month,
            ],
            [
                'loan_verified' => 1
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Loan verified successfully!'
        ]);
    }
    public function salary_expense_preview(Request $request)
    {
        $year  = $request->year;
        $month = $request->month;

        if (!$year || !$month) {
            return back()->with('error', 'Year & Month required');
        }

        $expenses = ExpenseReimbursement::where('year_id', $year)
            ->where('entry_month', $month)
            ->where('status', 'approved')
            ->get();

        $status = SalaryProcessStatus::where('year', $year)
            ->where('month', $month)
            ->first();

        $expenseVerified = $status->expense_verified ?? 0;

        return view('admin.salary.expense_preview', compact(
            'expenses',
            'year',
            'month',
            'expenseVerified'
        ));
    }
    public function salary_expense_verify(Request $request)
    {
        try {

            if ($request->has('expense')) {

                foreach ($request->expense as $entry_id => $amount) {

                    $expense = ExpenseReimbursement::find($entry_id);

                    if (!$expense) continue;

                    // ✅ Only update if value changed
                    if ((float)$expense->amount !== (float)$amount) {

                        $expense->update([
                            'amount' => $amount
                        ]);
                    }
                }
            }

            // ✅ Use Eloquent Model (BEST PRACTICE)
            SalaryProcessStatus::updateOrCreate(
                [
                    'year'  => $request->year,
                    'month' => $request->month,
                ],
                [
                    'expense_verified' => 1
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Expense verified successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function salary_process_verify(Request $request)
    {
        $yearName  = $request->year;
        $monthName = $request->month;

        if (!$yearName || !$monthName) {
            return back()->with('error', 'Year & Month required');
        }

        $yearModel = Year::where('year', $yearName)->first();
        if (!$yearModel) {
            return back()->with('error', 'Invalid Year');
        }
        $yearId = $yearModel->id;

        $monthModel = Month::where('month_name', $monthName)->first();
        if (!$monthModel) {
            return back()->with('error', 'Invalid Month');
        }
        $monthId = $monthModel->id;
        $monthdays = $monthModel->no_of_days;

        $monthNumber = Carbon::parse("1 $monthName $yearName")->month;

        $monthStart = Carbon::create($yearName, $monthNumber, 1)->startOfDay();
        $monthEnd = Carbon::create($yearName, $monthNumber, 1)->endOfMonth()->endOfDay();

        $sundaysCount = 0;
        $currentDay = $monthStart->copy();
        while ($currentDay->lte($monthEnd)) {
            if ($currentDay->isSunday()) {
                $sundaysCount++;
            }
            $currentDay->addDay();
        }

        $attendanceEmployeeCodes = EmployeeAttendance::where('year', $yearName)
            ->where('month', $monthName)
            ->pluck('employee_id');

        $employees = User::with(['designation', 'profile'])->whereIn('id', $attendanceEmployeeCodes)
            ->whereNull('deleted_at')->get();

        $attendanceData = EmployeeAttendance::where('year', $yearName)
            ->where('month', $monthName)->get()->keyBy('employee_code');

        $workingDays = MonthlyWorkingDay::where('year_id', $yearId)
            ->where('month_id', $monthId)->value('total_days') ?? 0;

        $salaryData = EmployeeSalaryYear::where('year', $yearName)->get()->keyBy('employee_id');

        $employeeTypeValues = EmployeeSalaryType::with('salaryType')
            ->where('year', $yearName)
            ->get()
            ->groupBy('employee_id');

        $otherDeductions = ExpenseReimbursement::where('year_id', $yearName)
            ->where('entry_month', $monthName)
            ->get()
            ->groupBy('employee_id')
            ->map(function ($items) {
                return $items->sum('amount');
            });

        $approvedLeaves = Leave::where('status', 'approved')
            ->whereDate('from_date', '<=', $monthEnd)
            ->whereDate('to_date', '>=', $monthStart)
            ->get()
            ->groupBy('user_id')
            ->map(function ($leaves) use ($monthStart, $monthEnd) {
                return $leaves->sum(function ($leave) use ($monthStart, $monthEnd) {
                    $start = Carbon::parse($leave->from_date)->max($monthStart);
                    $end = Carbon::parse($leave->to_date)->min($monthEnd);
                    return $start->diffInDays($end) + 1; // inclusive days
                });
            });

        $loanEmiData = LoanManagement::whereDate('emi_start_date', '<=', $monthEnd)
            ->whereDate('emi_end_date', '>=', $monthStart)
            ->whereIn('employee_id', $employees->pluck('id'))
            ->get()
            ->groupBy('employee_id')
            ->map(function ($loans) use ($monthStart, $monthEnd) {
                return $loans->sum(function ($loan) use ($monthStart, $monthEnd) {
                    $emiStart = Carbon::parse($loan->emi_start_date)->max($monthStart);
                    $emiEnd = Carbon::parse($loan->emi_end_date)->min($monthEnd);
                    $months = $emiStart->diffInMonths($emiEnd) + 1;
                    return $loan->emi_amount * $months;
                });
            });

        foreach ($employees as $emp) {
            $attendance   = $attendanceData[$emp->employee_code] ?? null;
            $salaryInfo   = $salaryData->get($emp->id);
            $typeValues   = $employeeTypeValues->get($emp->id);
            $loanEmi      = $loanEmiData->get($emp->id) ?? 0;

            $presentDays  = $attendance->present_days ?? 0;
            $holidayDays  = $attendance->holiday_days ?? 0;
            $absents      = $attendance->absent_days ?? 0;
            $leaveDays    = $approvedLeaves->get($emp->id) ?? 0;
            $expenseTotal = $otherDeductions->get($emp->id) ?? 0;

            $emp->emppresent   = $presentDays;
            $emp->holidays     = $holidayDays;
            $emp->absents      = $absents;
            $emp->leaveDays    = $leaveDays;
            $emp->expenseTotal = $expenseTotal;

            $emp->paybledays   = $presentDays + $holidayDays + $sundaysCount + $leaveDays;
            $emp->loanEmi = $loanEmi;

            // Employee salary types (Earning / Deduction)
            $types = $employeeTypeValues->get($emp->id) ?? collect();

            $emp->earnings   = $types->where('salary_type', 'Earning')->values();
            $emp->deductions = $types->where('salary_type', 'Deduction')->values();
            $emp->net = $types->where('salary_type', 'Net')->values();
        }

        $SalaryVerified = SalaryProcessStatus::where('year', $yearName)
            ->where('month', $monthName)
            ->value('salary_processed');

        return view('admin.salary.process_salary', compact(
            'employees',
            'attendanceData',
            'monthdays',
            'workingDays',
            'sundaysCount',
            'yearId',
            'monthId',
            'monthName',
            'yearName',
            'SalaryVerified'
        ));
    }

    public function salary_process_save(Request $request)
    {
        if (!$request->employee_id || count($request->employee_id) == 0) {
            return response()->json([
                'status' => false,
                'message' => 'No employee data found'
            ]);
        }

        foreach ($request->employee_id as $empId) {
            $newTypes = [];
            $attendanceFields = [
                'emp_code',
                'emp_name',
                'designation',
                'account_number',
                'ifsc',
                'month_days',
                'present',
                'holidays',
                'weekends',
                'leaves',
                'absents',
                'paybled_days',
            ];
            foreach ($attendanceFields as $field) {
                $newTypes[] = $field;
                if (isset($request->{$field}[$empId])) {
                    SalaryDetail::updateOrCreate(
                        [
                            'employee_id' => $empId,
                            'year'        => $request->year,
                            'month'       => $request->month,
                            'type'        => $field,
                        ],
                        [
                            'category' => 'attendance',
                            'value'    => $request->{$field}[$empId],
                        ]
                    );
                }
            }
            if (isset($request->earnings[$empId])) {
                foreach ($request->earnings[$empId] as $type => $value) {
                    $newTypes[] = $type;
                    SalaryDetail::updateOrCreate(
                        [
                            'employee_id' => $empId,
                            'year'        => $request->year,
                            'month'       => $request->month,
                            'type'        => $type,
                        ],
                        [
                            'category' => 'earning',
                            'value'    => $value,
                        ]
                    );
                }
            }
            if (isset($request->deductions[$empId])) {
                foreach ($request->deductions[$empId] as $type => $value) {

                    $newTypes[] = $type;

                    SalaryDetail::updateOrCreate(
                        [
                            'employee_id' => $empId,
                            'year'        => $request->year,
                            'month'       => $request->month,
                            'type'        => $type,
                        ],
                        [
                            'category' => 'deduction',
                            'value'    => $value,
                        ]
                    );
                }
            }
            if (isset($request->net[$empId])) {
                foreach ($request->net[$empId] as $type => $value) {
                    $newTypes[] = $type;
                    SalaryDetail::updateOrCreate(
                        [
                            'employee_id' => $empId,
                            'year'        => $request->year,
                            'month'       => $request->month,
                            'type'        => $type,
                        ],
                        [
                            'category' => 'net',
                            'value'    => $value,
                        ]
                    );
                }
            }
            if (isset($request->loan[$empId])) {
                $newTypes[] = 'Loan';
                SalaryDetail::updateOrCreate(
                    [
                        'employee_id' => $empId,
                        'year'        => $request->year,
                        'month'       => $request->month,
                        'type'        => 'Loan',
                    ],
                    [
                        'category' => 'deduction',
                        'value'    => $request->loan[$empId],
                    ]
                );
            }
            if (isset($request->expense[$empId])) {
                $newTypes[] = 'Expense';
                SalaryDetail::updateOrCreate(
                    [
                        'employee_id' => $empId,
                        'year'        => $request->year,
                        'month'       => $request->month,
                        'type'        => 'Expense',
                    ],
                    [
                        'category' => 'deduction',
                        'value'    => $request->expense[$empId],
                    ]
                );
            }

            SalaryDetail::where('employee_id', $empId)
                ->where('year', $request->year)
                ->where('month', $request->month)
                ->whereNotIn('type', $newTypes)
                ->delete();
        }

        SalaryProcessStatus::updateOrCreate(
            [
                'year'  => $request->year,
                'month' => $request->month,
            ],
            [
                'salary_processed' => 1
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Salary synced successfully (create, update, delete done)'
        ]);
    }
    public function salary_slip(Request $request)
    {
        if (!$request->year || !$request->month) {
            return response()->json([
                'status' => false,
                'message' => 'Year and Month are required'
            ]);
        }

        $employeeIds = SalaryDetail::where('year', $request->year)
            ->where('month', $request->month)
            ->distinct()
            ->pluck('employee_id');

        $employees = User::whereIn('id', $employeeIds)->get();

        $year = $request->year;
        $month = $request->month;

        return view('admin.salary.salary_slip', compact(
            'employees',
            'year',
            'month'
        ));
    }
    public function generate_Salary_Slip(Request $request)
    {
        $employees = $request->employees;

        if (!$employees || count($employees) == 0) {
            return back()->with('error', 'No employee selected');
        }

        $data = SalaryDetail::where('year', $request->year)
            ->where('month', $request->month)
            ->whereIn('employee_id', $employees)
            ->get()
            ->groupBy('employee_id');

        return view('admin.salary.generate_slip', compact('data'));
    }
}
