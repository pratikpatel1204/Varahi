<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\DesignationLeaveType;
use App\Models\Leave;
use App\Models\SubDepartment;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        if ($user->can('View dashboard')) {
            return view('admin.admin_dashboard');
        }

        elseif ($user->can('Employee dashboard')) {

            $id = $user->id;

            $employee = User::with([
                'profile',
                'department',
                'subDepartment',
                'designation',
                'manager',
                'salaryYears.year'
            ])->findOrFail($id);

            $leaves = DesignationLeaveType::with('leaveType')
                ->where('role_id', $employee->designation->id)
                ->get();

            $totalleaves = $leaves->sum('total_days');

            $takenLeaves = Leave::where('user_id', $id)
                ->where('status', 'Approved')
                ->sum('days');

            $pendingLeaves = Leave::where('user_id', $id)
                ->where('status', 'Pending')
                ->sum('days');

            $remainingLeaves = $totalleaves - $takenLeaves;

            $notifications = Leave::where('user_id', $id)
                ->whereIn('status', ['Approved', 'Rejected'])
                ->where('is_read', 0)
                ->latest()
                ->get();

            $today = Carbon::today();

            $attendance = Attendance::where('user_id', $id)
                ->whereDate('date', $today)
                ->first();
           
            if (!$attendance) {
                $attendance = Attendance::where('user_id', $id)->whereNull('punch_out')->latest('date')->first();
            }
            $weekStart = Carbon::now()->startOfWeek();
            $weekEnd   = Carbon::now()->endOfWeek();

            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd   = Carbon::now()->endOfMonth();

            $weekAttendance = Attendance::where('user_id', $id)
                ->whereBetween('date', [$weekStart, $weekEnd])
                ->where('status', 'Approved')
                ->get();

            $monthAttendance = Attendance::where('user_id', $id)
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->where('status', 'Approved')
                ->get();

            $toSeconds = function ($time) {
                if (!$time) return 0;
                [$h, $m, $s] = explode(':', $time);
                return ($h * 3600) + ($m * 60) + $s;
            };

            $formatTime = function ($seconds) {
                $h = floor($seconds / 3600);
                $m = floor(($seconds % 3600) / 60);
                return sprintf('%02d:%02d', $h, $m);
            };

            $weekSeconds = $weekAttendance->sum(fn($a) => $toSeconds($a->total_hours));
            $monthSeconds = $monthAttendance->sum(fn($a) => $toSeconds($a->total_hours));

            $weekHours = $formatTime($weekSeconds);
            $monthHours = $formatTime($monthSeconds);

            $dailyLimit = 9 * 3600;

            $weekOvertimeSec = $weekAttendance->sum(function ($a) use ($toSeconds, $dailyLimit) {
                $sec = $toSeconds($a->total_hours);
                return $sec > $dailyLimit ? $sec - $dailyLimit : 0;
            });

            $monthOvertimeSec = $monthAttendance->sum(function ($a) use ($toSeconds, $dailyLimit) {
                $sec = $toSeconds($a->total_hours);
                return $sec > $dailyLimit ? $sec - $dailyLimit : 0;
            });

            $weekOvertime = $formatTime($weekOvertimeSec);
            $monthOvertime = $formatTime($monthOvertimeSec);

            $year = now()->year;

            $yearAttendance = Attendance::where('user_id', $id)
                ->whereYear('date', $year)
                ->get();

            $presentCount = $yearAttendance->filter(function ($a) {
                return $a->punch_in && $a->punch_out && $a->is_manual == 0 && $a->status == 'Approved';
            })->count();

            $apCount = $yearAttendance->filter(function ($a) {
                return $a->is_manual == 1 && $a->status == 'Pending';
            })->count();

            $absentCount = $yearAttendance->filter(function ($a) {
                return $a->status == 'Rejected' || (!$a->punch_in && !$a->punch_out);
            })->count();

            $leaveTypeData = Leave::with('leaveType')
                ->where('user_id', $id)
                ->where('status', 'Approved')
                ->whereYear('from_date', $year)
                ->get()
                ->groupBy(function ($leave) {
                    return $leave->leaveType->name ?? 'Other';
                })
                ->map(function ($items) {
                    return $items->sum('days');
                });

            $leaveCount = $leaveTypeData->sum(); 
            $leaveLabels = $leaveTypeData->keys();
            $leaveValues = $leaveTypeData->values();

            return view('admin.employee_dashboard', compact(
                'employee',
                'leaves',
                'totalleaves',
                'takenLeaves',
                'pendingLeaves',
                'remainingLeaves',
                'notifications',
                'attendance',
                'weekHours',
                'monthHours',
                'weekOvertime',
                'monthOvertime',
                'presentCount',
                'apCount',
                'absentCount',
                'leaveCount',
                'leaveTypeData',
                'leaveLabels',
                'leaveValues'
            ));
        }

        else {
            return view('admin.admin_dashboard');
        }
    }

    public function get_subdepartments($id)
    {
        $subs = SubDepartment::where('department_id', $id)->get();
        return response()->json($subs);
    }

    public function get_reporting_manager($designationId)
    {
        $managers = User::where(function ($query) use ($designationId) {
            $query->where('role', $designationId)->orWhere('role', 'super admin');
        })->get(['id', 'name']);

        return response()->json($managers);
    }
}
