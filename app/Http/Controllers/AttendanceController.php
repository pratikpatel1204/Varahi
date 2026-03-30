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
            'type'                => 'required|in:in,out',
            'in_time'             => 'nullable',
            'out_time'            => 'nullable',
            'punch_out_date'      => 'nullable|date',
            'reason'              => 'nullable|string',
            'custom'              => 'nullable|in:0,1',
            'punch_in_latitude'   => 'nullable|numeric',
            'punch_in_longitude'  => 'nullable|numeric',
            'punch_out_latitude'  => 'nullable|numeric',
            'punch_out_longitude' => 'nullable|numeric',
            'punch_in_photo'      => 'nullable|string',
            'punch_out_photo'     => 'nullable|string',
        ]);

        $user  = auth()->user();
        $today = now()->toDateString();

        // ══════════════════════════════════════════════════
        // CONFIGURATION - Timing Rules
        // ══════════════════════════════════════════════════
        $LATE_PUNCH_IN_TIME = '10:00';    // 10:00 AM ke baad reason mandatory
        $EARLY_PUNCH_OUT_TIME = '19:00'; // 7:00 PM se pehle reason mandatory

        // ── Photo save helper ──────────────────────────────
        $savePhoto = function (?string $base64, string $prefix) use ($user): ?string {
            if (!$base64) return null;
            try {
                $data     = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
                $decoded  = base64_decode($data);
                if (!$decoded) return null;
                $dir      = public_path('uploads/attendance');
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                $filename = $prefix . '_' . $user->id . '_' . time() . '.jpg';
                file_put_contents($dir . '/' . $filename, $decoded);
                return 'uploads/attendance/' . $filename;
            } catch (\Throwable $e) {
                return null;
            }
        };

        // ── Aaj ki attendance ──────────────────────────────
        $todayAttendance = Attendance::where('user_id', $user->id)
                            ->whereDate('date', $today)
                            ->first();

        // ── Pichle din ki incomplete attendance ─────────────
        $prevIncomplete = Attendance::where('user_id', $user->id)
                            ->whereNull('punch_out')
                            ->whereDate('date', '<', $today)
                            ->latest('date')
                            ->first();

        // ══════════════════════════════════════════════════
        // PUNCH IN
        // ══════════════════════════════════════════════════
        if ($request->type === 'in') {

            if ($prevIncomplete) {
                return response()->json([
                    'message'  => 'incomplete_prev',
                    'prev_date'=> $prevIncomplete->date,
                    'punch_in' => $prevIncomplete->punch_in,
                ], 422);
            }

            if ($todayAttendance) {
                return response()->json(['message' => 'Already punched in today'], 400);
            }

            // ✅ Punch In Time decide karo
            $punchInTime = $request->in_time
                ? Carbon::parse($request->in_time)->format('H:i:s')
                : now()->format('H:i:s');

            $attendanceDate = $today;
            if ($request->in_time) {
                $enteredTs = Carbon::today()->setTimeFromTimeString($punchInTime);
                if ($enteredTs->greaterThan(now()->addMinutes(10))) {
                    $attendanceDate = Carbon::yesterday()->toDateString();
                }
            }

            // ══════════════════════════════════════════════════
            // ✅ VALIDATION: Late Punch In (10:00 AM ke baad)
            // ══════════════════════════════════════════════════
            $punchInHourMinute = Carbon::parse($punchInTime)->format('H:i');

            if ($punchInHourMinute > $LATE_PUNCH_IN_TIME) {
                // Agar custom=1 hai toh reason already hoga
                // Agar normal punch in hai toh reason check karo
                if ($request->custom != 1 && !$request->reason) {
                    return response()->json([
                        'message' => 'Late punch in detected. Reason is required for punch in after 10:00 AM.',
                        'require_reason' => true,
                        'type' => 'late_punch_in'
                    ], 422);
                }
            }

            $photo = $savePhoto($request->punch_in_photo, 'punch_in');

            Attendance::create([
                'user_id'              => $user->id,
                'date'                 => $attendanceDate,
                'year'                 => Carbon::parse($attendanceDate)->year,
                'month'                => Carbon::parse($attendanceDate)->format('F'),
                'punch_in'             => $punchInTime,
                'punch_in_latitude'    => $request->punch_in_latitude,
                'punch_in_longitude'   => $request->punch_in_longitude,
                'punch_in_photo'       => $photo,
                'is_manual'            => $request->custom == 1 ? 1 : 0,
                'reason'               => $request->reason,
                'status'               => $request->custom == 1 ? 'Pending' : 'Approved',
                'reporting_manager_id' => $user->reporting_manager ?? null,
            ]);

            return response()->json(['message' => 'Punch In successful']);
        }

        // ══════════════════════════════════════════════════
        // PUNCH OUT
        // ══════════════════════════════════════════════════
// ══════════════════════════════════════════════════
// PUNCH OUT
// ══════════════════════════════════════════════════
if ($request->type === 'out') {
    $target = $prevIncomplete ?? $todayAttendance;

    if (!$target) {
        return response()->json(['message' => 'No active punch in found'], 400);
    }

    if ($target->punch_out) {
        return response()->json(['message' => 'Already punched out'], 400);
    }

    $photo = $savePhoto($request->punch_out_photo, 'punch_out');

    // ✅ Helper function to extract ONLY time (H:i:s) from any format
    $extractTime = function ($time) {
        if (!$time) return now()->format('H:i:s');
        try {
            return Carbon::parse($time)->format('H:i:s');
        } catch (\Exception $e) {
            return now()->format('H:i:s');
        }
    };

    // ✅ Get raw values
    $rawInTime  = $request->in_time ?? $target->punch_in;
    $rawOutTime = $request->out_time ?? now();

    // ✅ Extract ONLY time part (H:i:s) - removes date if present
    $inTime  = $extractTime($rawInTime);
    $outTime = $extractTime($rawOutTime);

    // ✅ Punch out date
    if ($request->punch_out_date) {
        $punchOutDate = Carbon::parse($request->punch_out_date)->format('Y-m-d');
    } elseif ($target->date && Carbon::parse($target->date)->lt(Carbon::today())) {
        $punchOutDate = Carbon::today()->format('Y-m-d');
    } else {
        $punchOutDate = $today;
    }

    // ✅ Dates properly format karo
    $punchInDate  = Carbon::parse($target->date)->format('Y-m-d');
    $punchOutDate = Carbon::parse($punchOutDate)->format('Y-m-d');

    // ✅ Create Carbon objects with proper date and time
    $in  = Carbon::createFromFormat('Y-m-d H:i:s', "{$punchInDate} {$inTime}");
    $out = Carbon::createFromFormat('Y-m-d H:i:s', "{$punchOutDate} {$outTime}");

    // ✅ Overnight case - if punch out is on same day and before punch in time
    if ($punchOutDate === $punchInDate && $out->lt($in)) {
        $out->addDay();
        $punchOutDate = Carbon::parse($punchOutDate)->addDay()->format('Y-m-d');
    }

    $totalSeconds = $out->diffInSeconds($in);
    $totalHours   = gmdate('H:i:s', $totalSeconds);

    if ($request->custom == 1) {
        $target->update([
            'punch_in'             => $inTime,
            'punch_out'            => $outTime,
            'punch_out_date'       => $punchOutDate,
            'total_hours'          => $totalHours,
            'is_manual'            => 1,
            'reason'               => $request->reason,
            'status'               => 'Pending',
            'punch_out_latitude'   => $request->punch_out_latitude,
            'punch_out_longitude'  => $request->punch_out_longitude,
            'punch_out_photo'      => $photo,
            'reporting_manager_id' => $user->reporting_manager ?? null,
        ]);
    } else {
        $target->update([
            'punch_out'            => $outTime,
            'punch_out_date'       => $punchOutDate,
            'total_hours'          => $totalHours,
            'is_manual'            => 0,
            'reason'               => $request->reason,
            'status'               => 'Approved',
            'punch_out_latitude'   => $request->punch_out_latitude,
            'punch_out_longitude'  => $request->punch_out_longitude,
            'punch_out_photo'      => $photo,
            'reporting_manager_id' => $user->reporting_manager ?? null,
        ]);
    }

    return response()->json(['message' => 'Punch Out successful']);
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
