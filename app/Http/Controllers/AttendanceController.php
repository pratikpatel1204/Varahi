<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function attendance_punch(Request $request)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'in_time' => 'nullable',
            'out_time' => 'nullable',
            'reason' => 'nullable|string'
        ]);

        $user = auth()->user();

        $today = now()->toDateString();
        $todayDate = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)->whereDate('date', $today)->first();

        if (!$attendance) {
            $attendance = Attendance::where('user_id', $user->id)->whereNull('punch_out')->latest('date')->first();
        }

        if ($request->type === 'in') {

            if ($attendance) {
                return response()->json([
                    'message' => 'Already punched in'
                ], 400);
            }

            Attendance::create([
                'user_id'   => $user->id,
                'date'      => $today,
                'year'      => $todayDate->year,
                'month'     => $todayDate->format('F'),
                'punch_in'  => $request->in_time ?? now()->format('H:i:s'),
                'status'    => 'Pending',
                'reporting_manager_id' => $user->reporting_manager ?? null,
            ]);

            return response()->json([
                'message' => 'Punch In successful'
            ]);
        }

        if ($request->type === 'out') {

            if (!$attendance) {
                return response()->json([
                    'message' => 'Punch In first'
                ], 400);
            }

            if ($attendance->punch_out) {
                return response()->json([
                    'message' => 'Already punched out'
                ], 400);
            }

            // Use provided or current time
            $inTime = $request->in_time ?? $attendance->punch_in;
            $outTime = $request->out_time ?? now()->format('H:i:s');

            // Convert to Carbon
            $in = Carbon::parse($inTime);
            $out = Carbon::parse($outTime);

            // Calculate total hours
            $totalSeconds = $out->diffInSeconds($in);
            $totalHours = gmdate('H:i:s', $totalSeconds);

            if ($request->custom == 1) {
                $attendance->update([
                    'punch_in'   => $inTime, // update if custom
                    'punch_out'  => $outTime,
                    'total_hours' => $totalHours,
                    'is_manual'  => 1,
                    'reason'     => $request->reason,
                    'status'     => 'Pending',
                    'reporting_manager_id' => $user->reporting_manager ?? null,
                ]);
            } else {
                $attendance->update([
                    'punch_out'  => $outTime,
                    'total_hours' => $totalHours,
                    'is_manual'  => 0,
                    'status'     => 'Approved',
                    'reporting_manager_id' => $user->reporting_manager ?? null,
                ]);
            }
            return response()->json([
                'message' => 'Punch Out successful'
            ]);
        }
    }

    public function employee_my_attendance(Request $request)
    {
        $user = auth()->user();

        $month = $request->month ?? Carbon::now()->month;
        $year  = $request->year ?? Carbon::now()->year;

        $today = Carbon::today()->format('Y-m-d');

        // ✅ Attendance data
        $attendances = Attendance::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));

        // ✅ Approved leaves
        $leaves = Leave::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->whereYear('from_date', $year)
            ->whereMonth('from_date', $month)
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

        // ✅ Build calendar
        $start = Carbon::create($year, $month)->startOfMonth();
        $end   = Carbon::create($year, $month)->endOfMonth();

        $calendar = [];

        while ($start <= $end) {

            $date = $start->format('Y-m-d');

            // 🔥 FUTURE DATE → EMPTY
            if ($date > $today) {
                $calendar[$date] = [
                    'status' => '',
                    'color'  => '#ffffff'
                ];
            }

            // 🔥 ATTENDANCE FIRST PRIORITY
            elseif (isset($attendances[$date])) {

                $att = $attendances[$date];

                // ✅ PRESENT (override leave)
                if ($att->punch_in && $att->punch_out && $att->is_manual == 0 && $att->status == 'Approved') {
                    $calendar[$date] = [
                        'status' => 'P',
                        'color'  => '#28a745'
                    ];
                }

                // ✅ MANUAL PENDING
                elseif ($att->punch_in && $att->is_manual == 1 && $att->status == 'Pending') {
                    $calendar[$date] = [
                        'status' => 'AP',
                        'color'  => '#ffc107'
                    ];
                }

                // ❌ REJECTED
                elseif ($att->status == 'Rejected') {
                    $calendar[$date] = [
                        'status' => 'A',
                        'color'  => '#dc3545'
                    ];
                }

                // fallback
                else {
                    $calendar[$date] = [
                        'status' => 'A',
                        'color'  => '#dc3545'
                    ];
                }
            }

            // 🔥 LEAVE (only if no attendance)
            elseif (isset($leaveDates[$date])) {
                $calendar[$date] = [
                    'status' => 'L',
                    'color'  => '#17a2b8'
                ];
            }

            // ❌ NO ENTRY → ABSENT
            else {
                $calendar[$date] = [
                    'status' => 'A',
                    'color'  => '#dc3545'
                ];
            }

            $start->addDay();
        }

        // ✅ Convert to FullCalendar events
        $events = [];

        foreach ($calendar as $date => $data) {

            $textColor = '#ffffff';

            if ($data['status'] == 'AP' || $data['status'] == '') {
                $textColor = '#000000';
            }

            $events[] = [
                'title' => $data['status'],
                'start' => $date,
                'backgroundColor' => $data['color'],
                'borderColor'     => $data['color'],
                'textColor'       => $textColor,
            ];
        }

        return view('employee.attendance.my_attendance', compact('events', 'month', 'year'));
    }

    public function attendance_request(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        $query = Attendance::managerScope(auth()->user())
            ->with(['user', 'approver'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year);

        // Default: Pending (if no status filter)
        if ($request->status) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'Pending');
        }

        $pendingAttendance = $query->latest()->get();

        return view('employee.attendance.attendance_requests', compact(
            'pendingAttendance',
            'month',
            'year'
        ));
    }

    public function attendance_approve(Request $request)
    {
        $attendance = Attendance::findOrFail($request->id);

        $attendance->update([
            'is_manual' => 0,
            'status' => 'Approved',
            'approved_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance Approved Successfully'
        ]);
    }

    public function attendance_reject(Request $request)
    {
        $request->validate([
            'reject_comment' => 'required|string|max:255'
        ]);

        $attendance = Attendance::findOrFail($request->id);

        $attendance->update([
            'is_manual' => 0,
            'status' => 'Rejected',
            'reject_comment' => $request->reject_comment,
            'approved_by' => auth()->id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance Rejected Successfully'
        ]);
    }
}
