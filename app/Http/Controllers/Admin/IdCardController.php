<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\IdCard;
use App\Models\IdCardTemplate;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class IdCardController extends Controller
{
    // ── Generate Page ─────────────────────────────────────
    public function index()
    {
        $sites             = SiteSetting::orderBy('company_name')->get();
        $totalUsers    = User::count();
        $activeUsers   = User::whereNull('deleted_at')->count();
        $inactiveUsers = User::whereNotNull('deleted_at')->count();
        // $newJoiners        = User::whereMonth('joining_date', now()->month)
        //                              ->whereYear('joining_date', now()->year)->count();

        return view('admin.id_cards.index', compact(
            'sites', 'totalUsers', 'activeUsers', 'inactiveUsers'
        ));
    }

 // ── Ajax - Users without ID card ──────────────────
// ── Ajax - Users without ID card ──────────────────
public function ajaxWithoutIdCard(Request $request)
{
    $alreadyGeneratedIds = IdCard::pluck('employee_id')->toArray();

    $query = User::with(['designation', 'department', 'bloodGroup'])
                ->whereNull('deleted_at')
                ->whereNotIn('id', $alreadyGeneratedIds)
                ->whereHas('roles', function ($q) {
                    $q->where('id', '!=', 1);  // ✅ Spatie role check
                });

    if ($request->filled('User_search')) {
        $s = $request->User_search;
        $query->where(function ($q) use ($s) {
            $q->where('name', 'like', "%$s%")
              ->orWhere('User_code', 'like', "%$s%")
              ->orWhere('email', 'like', "%$s%")
              ->orWhere('phone', 'like', "%$s%");
        });
    }

    $draw            = intval($request->input('draw'));
    $start           = intval($request->input('start'));
    $length          = intval($request->input('length'));
    $recordsTotal    = (clone $query)->count();
    $recordsFiltered = (clone $query)->count();
    $Users           = $query->skip($start)->take($length)->get();

    $globalSite = SiteSetting::first();

    $data = [];
    foreach ($Users as $emp) {
        $data[] = [
            'id'            => $emp->id,
            'employee_code'     => $emp->employee_code,
            'name'          => $emp->name,
            'company_name'  => optional($globalSite)->company_name ?? '-',
            'designation'   => optional($emp->designation)->name ?? '-',
            'department'    => optional($emp->department)->name ?? '-',
            'email'         => $emp->email,
            'phone'         => $emp->phone,
        ];
    }

    return response()->json([
        'draw'            => $draw,
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $data,
    ]);
}

// ── Ajax - Users with ID card (Report) ────────────
// ── Ajax - Users with ID card (Report) ────────────
public function ajaxWithIdCard(Request $request)
{
    $alreadyGeneratedIds = IdCard::pluck('employee_id')->toArray();

    $query = User::with(['designation', 'department', 'bloodGroup'])
        ->whereNull('deleted_at')
        ->whereIn('id', $alreadyGeneratedIds)
        // Exclude super_admin by role id (id != 1)
        ->whereHas('roles', function ($q) {
            $q->where('id', '!=', 1);
            // ->where('guard_name', 'web');
        });

    if ($request->filled('User_search')) {
        $s = $request->User_search;
        $query->where(function ($q) use ($s) {
            $q->where('name', 'like', "%$s%")
              ->orWhere('employee_code', 'like', "%$s%")
              ->orWhere('email', 'like', "%$s%")
              ->orWhere('phone', 'like', "%$s%");
        });
    }

    $draw            = intval($request->input('draw'));
    $start           = intval($request->input('start'));
    $length          = intval($request->input('length'));
    $recordsTotal    = (clone $query)->count();
    $recordsFiltered = (clone $query)->count();
    $users           = $query->skip($start)->take($length)->get();

    $globalSite = SiteSetting::first();

    $data = [];
    foreach ($users as $emp) {
        $empId  = $emp->id;
        $action = '<div class="d-flex gap-1">
            <button class="btn btn-sm btn-success" onclick="reprintIdCard(' . $empId . ')">
                <i class="ti ti-printer"></i> Reprint
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteIdCard(' . $empId . ')">
                <i class="ti ti-trash"></i> Delete
            </button>
        </div>';

        $data[] = [
            'id'            => $emp->id,
            'employee_code' => $emp->employee_code,
            'name'          => $emp->name,
            'company_name'  => optional($globalSite)->company_name ?? '-',
            'designation'   => optional($emp->designation)->name ?? '-',
            'email'         => $emp->email,
            'phone'         => $emp->phone,
            'action'        => $action,
        ];
    }

    return response()->json([
        'draw'            => $draw,
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $data,
    ]);
}


// ── Template Edit ─────────────────────────────────────
// ── Template Edit ─────────────────────────────────────
public function templateEdit($id)
{
    $template = IdCardTemplate::findOrFail($id);

    // Sirf non-super_admin users (role id != 1) ko lao
    $Users = User::with(['designation', 'department', 'bloodGroup'])
        ->whereHas('roles', function ($q) {
            $q->where('id', '!=', 1);
        })
        ->orderBy('name')
        ->get();

    $sites = SiteSetting::first(); // single global site

    return view('admin.id_cards.template_edit', compact('template', 'Users', 'sites'));
}
// ── Generate ID Cards ─────────────────────────────────
// ── Generate ID Cards ─────────────────────────────────
public function generate(Request $request)
{
    $ids      = $request->input('ids', []);
    $template = IdCardTemplate::where('is_active', true)->first();

    if (!$template) return response()->json(['error' => 'No active template found'], 404);
    if (empty($ids)) return response()->json(['error' => 'No Users selected'], 400);

    $users = User::with(['designation', 'department', 'bloodGroup'])
        ->whereIn('id', $ids)
        // Optional: ensure we don’t generate for super_admin
        ->whereHas('roles', function ($q) {
            $q->where('id', '!=', 1);
        })
        ->get();

    if ($users->isEmpty()) return response()->json(['error' => 'Users not found'], 404);

    $site  = SiteSetting::first(); // global site for all
    $cards = [];

    foreach ($users as $emp) {
        $snapshot = [
            'employee_id'        => $emp->id,
            'template_id'        => $template->id,
            'generated_by'       => auth()->id(),
            'employee_code'      => $emp->employee_code ?? '',
            'name'               => $emp->name ?? '',
            'email'              => $emp->email ?? '',
            'phone'              => $emp->phone ?? '',
            'gender'             => $emp->gender ?? '',
            'dob'                => $emp->dob ?? '',
            'designation'        => optional($emp->designation)->name ?? '',
            'department'         => optional($emp->department)->name ?? '',
            'blood_group'        => optional($emp->bloodGroup)->name ?? '',
            'site_name'          => optional($site)->company_name ?? '',
            'joining_date'       => $emp->joining_date ?? '',
            'present_address'    => $emp->present_address ?? '',
            'present_city'       => $emp->present_city ?? '',
            'present_state'      => $emp->present_state ?? '',
            'emergency_phone_1'  => $emp->emergency_phone_1 ?? '',
            'company_name'       => optional($site)->company_name ?? '',
            'company_phone'      => optional($site)->phone ?? '',
            'company_address'    => optional($site)->address ?? '',
            'company_logo'       => $site->company_logo ?? '',
            'profile_image'      => $emp->profile_image ?? '',
        ];

        $content = $template->content;

        // Support both {employee_code} and legacy {User_code}
        $replacements = [
            '{name}'              => $snapshot['name'],
            '{employee_code}'     => $snapshot['employee_code'],
            '{User_code}'         => $snapshot['employee_code'],
            '{email}'             => $snapshot['email'],
            '{phone}'             => $snapshot['phone'],
            '{gender}'            => $snapshot['gender'],
            '{dob}'               => $snapshot['dob'],
            '{designation}'       => $snapshot['designation'],
            '{department}'        => $snapshot['department'],
            '{blood_group}'       => $snapshot['blood_group'],
            '{site_name}'         => $snapshot['site_name'],
            '{joining_date}'      => $snapshot['joining_date'],
            '{present_address}'   => $snapshot['present_address'],
            '{present_city}'      => $snapshot['present_city'],
            '{present_state}'     => $snapshot['present_state'],
            '{emergency_phone_1}' => $snapshot['emergency_phone_1'],
            '{company_name}'      => $snapshot['company_name'],
            '{company_phone}'     => $snapshot['company_phone'],
            '{company_address}'   => $snapshot['company_address'],
            '{company_logo}'      => $snapshot['company_logo']
                ? '<img src="'.asset($snapshot['company_logo']).'" style="max-height:60px;" alt="Logo">'
                : '',
            '{profile_image}'     => $snapshot['profile_image']
                ? '<img src="'.asset($snapshot['profile_image']).'" style="width:100%;height:100%;object-fit:cover;" alt="Photo">'
                : '<div style="width:100%;height:100%;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:30px;color:#999;">👤</div>',
            '{date}'              => now()->format('d M, Y'),
        ];

        $content = str_replace(array_keys($replacements), array_values($replacements), $content);
        $snapshot['generated_content'] = $content;

        IdCard::updateOrCreate(
            ['employee_id' => $emp->id, 'template_id' => $template->id],
            $snapshot
        );

        $cards[] = $content;
    }

    return response()->json(['cards' => $cards]);
}

    // ── Reprint ───────────────────────────────────────────
    public function reprint(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) return response()->json(['error' => 'No Users selected'], 400);

        $idCards = IdCard::whereIn('employee_id', $ids)->get();
        if ($idCards->isEmpty()) return response()->json(['error' => 'No ID cards found'], 404);

        $cards = $idCards->pluck('generated_content')->toArray();
        return response()->json(['cards' => $cards]);
    }

    // ── Delete ────────────────────────────────────────────
    public function delete($id)
    {
        IdCard::where('employee_id', $id)->delete();
        return response()->json(['success' => true]);
    }

    // ── Template Index ────────────────────────────────────
    public function templateIndex()
    {
        $templates = IdCardTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.id_cards.template_index', compact('templates'));
    }


    // ── Template Update ───────────────────────────────────
    public function templateUpdate(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'content' => 'required',
        ]);

        IdCardTemplate::where('id', $id)->update([
            'name'    => $request->name,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.id.card.template.index')
                         ->with('success', 'Template updated successfully!');
    }

    // ── Template Toggle Active ────────────────────────────
    public function templateToggle($id)
    {
        IdCardTemplate::query()->update(['is_active' => 0]);
        IdCardTemplate::where('id', $id)->update(['is_active' => 1]);
        return response()->json(['success' => true]);
    }

    // ── Report Page ───────────────────────────────────────
    public function report()
    {
        $sites = SiteSetting::orderBy('company_name')->get();
        return view('admin.id_cards.report', compact('sites'));
    }
}
