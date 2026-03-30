<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeEducation;
use App\Models\EmployeeExperience;
use App\Models\EmployeeFamily;
use App\Models\EmployeeAsset;
use App\Models\EmployeeSalaryType;
use App\Models\EmployeeAddon;
use App\Models\QualificationArea;
use App\Models\Department;
use App\Models\BloodGroup;
use App\Models\Year;
use App\Models\EmployeeSalaryYear;
use App\Models\Designation;
use App\Models\Course;
use App\Models\SiteSetting;
use App\Models\SalaryType;
use App\Models\AddonType;
use App\Models\DesignationLeaveType;
use App\Models\DesignationWorkingDay;
use App\Models\EmployeeProfile;
use App\Models\Holiday;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $totalEmployees = User::where('role', '!=', 'super admin')->count();

        $activeEmployees = User::where('role', '!=', 'super admin')
            ->where('status', 1)
            ->count();

        $inactiveEmployees = User::where('role', '!=', 'super admin')
            ->where('status', 0)
            ->count();

        $newJoiners = User::where('role', '!=', 'super admin')
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $employees = User::where('role', '!=', 'super admin')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.employees.index', compact(
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'newJoiners',
            'employees'
        ));
    }

    public function get_employees_salary(Request $request)
    {
        $empid = $request->id;
        $salaries = EmployeeSalaryYear::where('employee_id', $empid)->latest()->get();
        return response()->json([
            'html' => view('admin.employees.emp_salary_details', compact('salaries', 'empid'))->render()
        ]);
    }
    public function employees_store_salary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'      => 'required|exists:users,id',
            'year'          => 'required',
            'salary_basis'     => 'required|in:monthly,daily',
            'payment_type'     => 'required|in:bank,cash,cheque',

            'gross_Salary'     => 'required|numeric|min:0',
            'total_earning'    => 'required|numeric|min:0',
            'total_deduction'  => 'required|numeric|min:0',
            'net_salary'       => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        EmployeeSalaryYear::updateOrCreate(
            [
                'employee_id' => $request->employee_id,
                'year'     => $request->year,
            ],
            [
                'salary_basis'  => $request->salary_basis,
                'payment_type'  => $request->payment_type,
                'gross_Salary' => $request->gross_Salary,
            ]
        );

        foreach ($request->earnings as $typeId => $amount) {
            $salaryType = SalaryType::find($typeId);
            EmployeeSalaryType::updateOrCreate(
                [
                    'employee_id'       => $request->employee_id,
                    'year'              => $request->year,
                    'salary_type_name'  => $salaryType->name,
                ],
                [
                    'salary_value'       => $salaryType->value,
                    'salary_value_type'  => $salaryType->value_type,
                    'salary_type'        => $salaryType->type,
                    'amount'             => $amount ?? 0,
                ]
            );
        }

        foreach ($request->deductions as $typeId => $amount) {
            $salaryType = SalaryType::find($typeId);
            EmployeeSalaryType::updateOrCreate(
                [
                    'employee_id'       => $request->employee_id,
                    'year'              => $request->year,
                    'salary_type_name'  => $salaryType->name,
                ],
                [
                    'salary_value'       => $salaryType->value,
                    'salary_value_type'  => $salaryType->value_type,
                    'salary_type'        => $salaryType->type,
                    'amount'             => $amount ?? 0,
                ]
            );
        }

        EmployeeSalaryType::updateOrCreate(
            [
                'employee_id'      => $request->employee_id,
                'year'             => $request->year,
                'salary_type_name' => 'Total Earnings',
            ],
            [
                'salary_value'      => 0,
                'salary_value_type' => 'fixed',
                'salary_type'       => 'Earning',
                'amount'            => $request->total_earning ?? 0,
            ]
        );

        EmployeeSalaryType::updateOrCreate(
            [
                'employee_id'      => $request->employee_id,
                'year'             => $request->year,
                'salary_type_name' => 'Total Deductions',
            ],
            [
                'salary_value'      => 0,
                'salary_value_type' => 'fixed',
                'salary_type'       => 'Deduction',
                'amount'            => $request->total_deduction ?? 0,
            ]
        );

        EmployeeSalaryType::updateOrCreate(
            [
                'employee_id'      => $request->employee_id,
                'year'             => $request->year,
                'salary_type_name' => 'Net Salary',
            ],
            [
                'salary_value'      => 0,
                'salary_value_type' => 'fixed',
                'salary_type'       => 'Net',
                'amount'            => $request->net_salary ?? 0,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Salary saved successfully'
        ]);
    }

    public function employees_create_salary($empid)
    {
        $years = Year::orderBy('year', 'desc')->get();
        $salaryTypes = SalaryType::get();

        return view('admin.employees.create_salary', compact(
            'years',
            'salaryTypes',
            'empid'
        ));
    }
    public function create()
    {
        $designations = Role::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();
        $years = Year::orderBy('year', 'desc')->get();
        $salaryTypes = SalaryType::get();
        $addonTypes = AddonType::where('status', 1)->get();

        return view('admin.employees.create', compact(
            'designations',
            'departments',
            'years',
            'salaryTypes',
            'addonTypes'
        ));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->whereNull('deleted_at'),
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users')->whereNull('deleted_at'),
            ],

            'name'  => 'required|string|max:150',
            'phone' => 'required|digits_between:10,12',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:500',

            'designation' => 'required',
            'department_id' => 'required|exists:departments,id',
            'sub_department_id' => 'nullable|exists:sub_departments,id',
            'reporting_manager' => 'nullable|exists:users,id',

            'password' => 'required|string|min:6|confirmed',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'skill_type' => 'required|in:skilled,semi_skilled,non_skilled',

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();


        $profileimage = null;
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/profile/';
            $file->move(public_path($path), $filename);
            $profileimage = $path . $filename;
        }

        $employee = User::create([
            'employee_code'     => $request->employee_code,
            'name'              => $request->name,
            'role'              => $request->designation,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'show_password'     => $request->password,
            'phone'             => $request->phone,
            'gender'            => $request->gender,
            'dob'               => $request->dob,
            'address'           => $request->address,
            'department_id'     => $request->department_id,
            'sub_department_id' => $request->sub_department_id,
            'reporting_manager' => $request->reporting_manager,
            'skill_type'        => $request->skill_type,
            'profile_image'     => $profileimage,
            'status'            => 1,
            'pf_applicable'     => $request->has('pf_applicable'),
            'esic_applicable'   => $request->has('esic_applicable'),
        ]);

        $employee->assignRole($request->designation);

        return response()->json([
            'status' => true,
            'message' => 'Employee Added Successfully'
        ]);
    }

    public function edit($id)
    {
        $employee = User::with(['salaryYears.year', 'employeeSalaryTypes', 'salaryAddons'])->findOrFail($id);
        $designations = Role::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->get();
        $years = Year::orderBy('year', 'desc')->get();
        $salaryTypes = SalaryType::all();
        $addonTypes = AddonType::where('status', 1)->get();

        return view('admin.employees.edit', compact('employee', 'designations', 'departments', 'years', 'salaryTypes', 'addonTypes'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'employee_code' => [
                'required',
                'max:50',
                Rule::unique('users', 'employee_code')
                    ->ignore($request->id, 'id')
                    ->whereNull('deleted_at'),
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')
                    ->ignore($request->id, 'id')
                    ->whereNull('deleted_at'),
            ],

            'name'  => 'required|string|max:150',
            'phone' => 'required|digits_between:10,12',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:500',

            'designation' => 'required',
            'department_id' => 'required|exists:departments,id',
            'sub_department_id' => 'nullable|exists:sub_departments,id',
            'reporting_manager' => 'nullable|exists:users,id',

            'password' => 'nullable|string|min:6|confirmed',

            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'skill_type' => 'required|in:skilled,semi_skilled,non_skilled',

            'salaries.*.year_id' => 'required|distinct',
            'salaries.*.salary_amount' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ FIND EMPLOYEE
        $employee = User::findOrFail($request->id);

        /* ================= BASIC UPDATE ================= */

        $employee->employee_code     = $request->employee_code;
        $employee->name              = $request->name;
        $employee->email             = $request->email;
        $employee->phone             = $request->phone;
        $employee->gender            = $request->gender;
        $employee->dob               = $request->dob;
        $employee->address           = $request->address;

        $employee->role              = $request->designation; // if column exists
        $employee->department_id     = $request->department_id;
        $employee->sub_department_id = $request->sub_department_id;
        $employee->reporting_manager = $request->reporting_manager;
        $employee->skill_type        = $request->skill_type;

        $employee->pf_applicable     = $request->has('pf_applicable');
        $employee->esic_applicable   = $request->has('esic_applicable');

        // ✅ PASSWORD (ONLY IF FILLED)
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
            $employee->show_password = $request->password; // optional
        }

        // ✅ IMAGE UPDATE
        if ($request->hasFile('profile_image')) {

            if ($employee->profile_image && file_exists(public_path($employee->profile_image))) {
                unlink(public_path($employee->profile_image));
            }

            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/employees'), $filename);

            $employee->profile_image = 'uploads/employees/' . $filename;
        }

        // ✅ SAVE USER
        $employee->save();

        // ✅ UPDATE ROLE (Spatie)
        if ($request->designation) {
            $employee->syncRoles([$request->designation]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Employee Updated Successfully'
        ]);
    }

    public function delete($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();

        return response()->json([
            'status' => true,
            'message' => 'Employee deleted successfully'
        ]);
    }

    public function view($id)
    {
        $employee = User::with(['profile', 'department', 'subDepartment', 'designation', 'manager', 'salaryYears.year'])->findOrFail($id);
        $assets = EmployeeAsset::with('asset')->where('employee_id', $id)->orderBy('assigned_on', 'desc')->paginate(5);
        $departments  = Department::where('status', 'Active')->get();
        $designations = Role::select('id', 'name')->get();
        $manager = USer::where('id', $employee->reporting_manager)->first();

        $employees = USer::where('status', 1)->get();
        $bloodGroups  = BloodGroup::where('status', 1)->get();
        $qualificationAreas = QualificationArea::where('status', 1)->get();
        $courses = Course::where('status', 1)->get();

        $education = EmployeeEducation::where('employee_id', $employee->id)
            ->orderBy('id', 'desc')->get();

        $experience = EmployeeExperience::where('employee_id', $employee->id)
            ->orderBy('id', 'desc')->get();

        $assets = EmployeeAsset::with('asset')
            ->where('employee_id', $employee->id)
            ->orderBy('assigned_on', 'desc')
            ->paginate(5);

        $working_days = DesignationWorkingDay::with('workingDay')
            ->where('designation_id', $employee->designation->id)
            ->get()
            ->pluck('workingDay.day_name')
            ->toArray();

        $leaves = DesignationLeaveType::with('leaveType')
            ->where('role_id', $employee->designation->id)
            ->get();

        $currentYear = date('Y');

        $year = Year::where('year', $currentYear)->first();

        $yearId = $year ? $year->id : null;

        $holidays = [];
        if ($yearId) {
            $holidays = Holiday::where('year_id', $yearId)->where('status', 'Active')
                ->orderBy('from_date', 'asc')->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->from_date)->format('F');
                });
        }

        $salaryYears = EmployeeSalaryYear::with('year')
            ->where('employee_id', $employee->id)
            ->orderBy('year', 'desc')
            ->get();

        return view(
            'admin.employees.view',
            compact(
                'employee',
                'assets',
                'departments',
                'designations',
                'employees',
                'manager',
                'bloodGroups',
                'qualificationAreas',
                'courses',
                'working_days',
                'leaves',
                'holidays',
                'salaryYears',
                'education',
                'experience'
            )
        );
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|exists:roles,name',
            'department_id' => 'required|exists:departments,id',
            'sub_department_id' => 'nullable|exists:sub_departments,id',
            'reporting_manager' => 'nullable|exists:users,id|not_in:' . $request->id,
            'status' => 'required|in:0,1',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'joining_date' => 'nullable|date',
            'experience_years' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();

        try {
            $employee = User::findOrFail($request->id);

            if ($request->hasFile('profile_image')) {

                if ($employee->profile_image && file_exists(public_path($employee->profile_image))) {
                    unlink(public_path($employee->profile_image));
                }

                $file = $request->file('profile_image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/employees/' . $filename;

                $file->move(public_path('uploads/employees'), $filename);

                $employee->profile_image = $path;
            }

            $employee->update([
                'name'              => $request->name,
                'role'              => $request->designation,
                'department_id'     => $request->department_id,
                'sub_department_id' => $request->sub_department_id,
                'reporting_manager' => $request->reporting_manager,
                'status'            => $request->status,
            ]);

            $employee->syncRoles([$request->designation]);

            EmployeeProfile::updateOrCreate(
                ['employee_id' => $employee->id],
                [
                    'joining_date' => $request->joining_date,
                    'experience_years' => $request->experience_years,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Employee profile updated successfully'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function basic_update(Request $request)
    {
        $employee = User::findOrFail($request->id);

        $request->validate([
            'phone'   => 'required|string|max:15',
            'email'   => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($employee->id)->whereNull('deleted_at'),
            ],
            'gender'  => 'required|in:male,female',
            'dob'     => 'required|date',
            'address' => 'required|string|max:500',
        ]);

        $employee->update([
            'phone'   => $request->phone,
            'email'   => $request->email,
            'gender'  => $request->gender,
            'dob'     => $request->dob,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Basic information updated successfully'
        ]);
    }

    public function personal_update(Request $request)
    {
        DB::beginTransaction();

        try {
            $employee = User::findOrFail($request->id);

            $validator = Validator::make($request->all(), [
                'passport_no'        => 'nullable|string|max:50',
                'passport_expiry'    => 'nullable|date',
                'blood_group_id'     => 'nullable|exists:blood_groups,id',
                'father_name'        => 'nullable|string|max:255',

                'aadhaar_no'         => 'nullable|digits:12',
                'aadhaar_photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

                'pan_no'             => ['nullable', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
                'pan_photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:4096',

                'nationality'        => 'nullable|string|max:100',
                'religion'           => 'nullable|string|max:100',

                'marital_status'     => 'nullable|in:Yes,No',
                'spouse_employment'  => 'nullable|string|max:255',
                'children'           => 'nullable|integer|min:0',

                'differently_abled'  => 'nullable|in:Yes,No',
                'personal_email'     => 'nullable|email|max:150',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $profile = EmployeeProfile::where('employee_id', $employee->id)->first();

            $aadhaarPath = $profile->aadhaar_photo ?? null;

            if ($request->hasFile('aadhaar_photo')) {

                if ($aadhaarPath && file_exists(public_path($aadhaarPath))) {
                    unlink(public_path($aadhaarPath));
                }

                $file = $request->file('aadhaar_photo');
                $filename = time() . '_aadhaar_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/employees/' . $filename;

                $file->move(public_path('uploads/employees'), $filename);

                $aadhaarPath = $path;
            }

            $panPath = $profile->pan_photo ?? null;

            if ($request->hasFile('pan_photo')) {

                if ($panPath && file_exists(public_path($panPath))) {
                    unlink(public_path($panPath));
                }

                $file = $request->file('pan_photo');
                $filename = time() . '_pan_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/employees/' . $filename;

                $file->move(public_path('uploads/employees'), $filename);

                $panPath = $path;
            }

            if ($request->marital_status == 'No') {
                $request->merge([
                    'spouse_employment' => null,
                    'children' => 0
                ]);
            }

            EmployeeProfile::updateOrCreate(
                ['employee_id' => $employee->id],
                [
                    'passport_no'        => $request->passport_no,
                    'passport_expiry'    => $request->passport_expiry,
                    'blood_group_id'     => $request->blood_group_id,
                    'father_name'        => $request->father_name,
                    'aadhaar_no'         => $request->aadhaar_no,
                    'aadhaar_photo'      => $aadhaarPath,
                    'pan_no'             => $request->pan_no,
                    'pan_photo'          => $panPath,
                    'nationality'        => $request->nationality,
                    'religion'           => $request->religion,
                    'marital_status'     => $request->marital_status,
                    'spouse_employment'  => $request->spouse_employment,
                    'children'           => $request->children,
                    'differently_abled'  => $request->differently_abled,
                    'personal_email'     => $request->personal_email,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Personal details updated successfully'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function emergency_update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'emergency_name_1'      => 'required|string|max:100',
                'emergency_relation_1'  => 'required|string|max:100',
                'emergency_phone_1'     => 'required|string|max:20',
                'emergency_name_2'      => 'nullable|string|max:100',
                'emergency_relation_2'  => 'nullable|string|max:100',
                'emergency_phone_2'     => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // ✅ Get profile by employee_id (NOT id)
            $profile = EmployeeProfile::where('employee_id', $request->id)->first();

            if (!$profile) {
                // Create profile if not exists
                $profile = new EmployeeProfile();
                $profile->employee_id = $request->id;
            }

            // ✅ Update fields
            $profile->emergency_name_1     = $request->emergency_name_1;
            $profile->emergency_relation_1 = $request->emergency_relation_1;
            $profile->emergency_phone_1    = $request->emergency_phone_1;
            $profile->emergency_name_2     = $request->emergency_name_2;
            $profile->emergency_relation_2 = $request->emergency_relation_2;
            $profile->emergency_phone_2    = $request->emergency_phone_2;

            $profile->save();

            return response()->json([
                'status' => true,
                'message' => 'Emergency contact updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function about_update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'about' => 'nullable|string|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            $profile = EmployeeProfile::where('employee_id', $request->id)->first();
            if (!$profile) {
                $profile = new EmployeeProfile();
                $profile->employee_id = $request->id;
            }
            $profile->about = $request->about;
            $profile->save();
            return response()->json([
                'status' => true,
                'message' => 'About updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function job_info_update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'confirmation_date'   => 'nullable|date',
                'planned_join_date'   => 'nullable|date',
                'joined_on'           => 'nullable|date',
                'probation_period'    => 'nullable|integer|min:0',
                'notice_period'       => 'nullable|integer|min:0',
                'previous_experience' => 'nullable|numeric|min:0',
                'total_experience'    => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            EmployeeProfile::updateOrCreate(
                ['employee_id' => $request->id],
                [
                    'confirmation_date'   => $request->confirmation_date,
                    'planned_join_date'   => $request->planned_join_date,
                    'joined_on'           => $request->joined_on,
                    'probation_period'    => $request->probation_period,
                    'notice_period'       => $request->notice_period,
                    'previous_experience' => $request->previous_experience,
                    'total_experience'    => $request->total_experience,
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Job info updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function bank_update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'bank_name'           => 'required|string|max:100',
                'account_number'      => 'nullable|string|max:30',
                'ifsc_code'           => 'required|string',
                'branch'              => 'required|string|max:100',
                'account_holder_name' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            EmployeeProfile::updateOrCreate(
                ['employee_id' => $request->id],
                [
                    'bank_name'           => $request->bank_name,
                    'account_number'      => $request->account_number,
                    'ifsc_code'           => strtoupper($request->ifsc_code),
                    'branch'              => $request->branch,
                    'account_holder_name' => $request->account_holder_name,
                ]
            );

            return response()->json([
                'status' => true,
                'message' => 'Bank details updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pf_esi_update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                // PF
                'uan_number'            => 'nullable|string|max:50',
                'pf_account_number'     => 'nullable|string|max:50',
                'pf_applicable'         => 'nullable|in:Yes,No',
                'pf_join_date'          => 'nullable|date',
                'pf_exit_date'          => 'nullable|date|after_or_equal:pf_join_date',
                'pf_contribution_type'  => 'nullable|string|max:50',
                'pf_document'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
                'pf_name'               => 'nullable|string|max:100',
                'pf_dob'                => 'nullable|date',
                'pf_previous_details'   => 'nullable|string',

                // ESI
                'esic_number'           => 'nullable|string|max:50',
                'esic_applicable'       => 'nullable|in:Yes,No',
                'esic_join_date'        => 'nullable|date',
                'esic_exit_date'        => 'nullable|date|after_or_equal:esic_join_date',
                'esic_name'             => 'nullable|string|max:100',
                'esic_dob'              => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $profile = EmployeeProfile::where('employee_id', $request->id)->first();

            if (!$profile) {
                $profile = new EmployeeProfile();
                $profile->employee_id = $request->id;
            }

            $pfDocumentPath = $profile->pf_document ?? null;

            if ($request->hasFile('pf_document')) {

                if ($pfDocumentPath && file_exists(public_path($pfDocumentPath))) {
                    unlink(public_path($pfDocumentPath));
                }

                $file = $request->file('pf_document');
                $filename = time() . '_pf_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/employees/' . $filename;

                $file->move(public_path('uploads/employees'), $filename);

                $pfDocumentPath = $path;
            }

            $profile->update([
                // PF
                'uan_number'           => $request->uan_number,
                'pf_account_number'    => $request->pf_account_number,
                'pf_applicable'        => $request->pf_applicable,
                'pf_join_date'         => $request->pf_join_date,
                'pf_exit_date'         => $request->pf_exit_date,
                'pf_contribution_type' => $request->pf_contribution_type,
                'pf_document'          => $pfDocumentPath,
                'pf_name'              => $request->pf_name,
                'pf_dob'               => $request->pf_dob,
                'pf_previous_details'  => $request->pf_previous_details,

                // ESI
                'esic_number'          => $request->esic_number,
                'esic_applicable'      => $request->esic_applicable,
                'esic_join_date'       => $request->esic_join_date,
                'esic_exit_date'       => $request->esic_exit_date,
                'esic_name'            => $request->esic_name,
                'esic_dob'             => $request->esic_dob,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'PF & ESI details updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function address_update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'present_city'     => 'nullable|string|max:100',
                'present_state'    => 'nullable|string|max:100',
                'present_country'  => 'nullable|string|max:100',
                'present_pincode'  => 'nullable|digits:6',
                'present_address'  => 'nullable|string',

                'permanent_city'     => 'nullable|string|max:100',
                'permanent_state'    => 'nullable|string|max:100',
                'permanent_country'  => 'nullable|string|max:100',
                'permanent_pincode'  => 'nullable|digits:6',
                'permanent_address'  => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            EmployeeProfile::updateOrCreate(
                ['employee_id' => $request->id],
                $request->only([
                    'present_city',
                    'present_state',
                    'present_country',
                    'present_pincode',
                    'present_address',
                    'permanent_city',
                    'permanent_state',
                    'permanent_country',
                    'permanent_pincode',
                    'permanent_address'
                ])
            );

            return response()->json([
                'status' => true,
                'message' => 'Address updated successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
    public function education_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'        => 'required|exists:users,id',
            'qualification'      => 'required|string|max:255',
            'institution_name'   => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',

            'qualification_area' => 'nullable|string|max:255',
            'course'             => 'nullable|string|max:255',
            'grade'              => 'nullable|string|max:50',
            'remark'             => 'nullable|string|max:255',
            'document'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $education = null;
        if ($request->filled('education_id')) {
            $education = EmployeeEducation::find($request->education_id);
        }

        $documentPath = $education->document ?? null;

        if ($request->hasFile('document')) {

            if ($documentPath && file_exists(public_path($documentPath))) {
                unlink(public_path($documentPath));
            }

            $file = $request->file('document');
            $filename = time() . '_document_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/employees'), $filename);

            $documentPath = 'uploads/employees/' . $filename;
        }

        $data = [
            'employee_id'        => $request->employee_id,
            'qualification'      => $request->qualification,
            'qualification_area' => $request->qualification_area,
            'course'             => $request->course,
            'institution_name'   => $request->institution_name,
            'grade'              => $request->grade,
            'remark'             => $request->remark,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'document'           => $documentPath,
        ];

        if ($education) {
            $education->update($data);
            $message = 'Education updated successfully';
        } else {
            EmployeeEducation::create($data);
            $message = 'Education added successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function education_delete($id)
    {
        $education = EmployeeEducation::find($id);

        if (!$education) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        if ($education->document && file_exists(public_path($education->document))) {
            unlink(public_path($education->document));
        }

        $education->delete();

        return response()->json([
            'status' => true,
            'message' => 'Education deleted successfully'
        ]);
    }
    public function experience_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,id',
            'company'     => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'start_date'  => 'required|date',

            // ✅ Only required when NOT currently working
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // ✅ Handle checkbox
        $isPresent = $request->has('is_present') ? 1 : 0;

        $data = [
            'employee_id' => $request->employee_id,
            'company'     => $request->company,
            'designation' => $request->designation,
            'start_date'  => $request->start_date,
            'is_present'  => $isPresent,
        ];

        // ✅ Logic: if present → end_date = null
        if ($isPresent) {
            $data['end_date'] = null;
        } else {
            $data['end_date'] = $request->end_date;
        }

        // ✅ Update or Create
        if ($request->experience_id) {
            EmployeeExperience::findOrFail($request->experience_id)->update($data);
            $message = "Experience updated successfully";
        } else {
            EmployeeExperience::create($data);
            $message = "Experience added successfully";
        }

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function experience_delete($id)
    {
        $exp = EmployeeExperience::find($id);

        if (!$exp) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        $exp->delete();

        return response()->json([
            'status' => true,
            'message' => 'Experience deleted successfully'
        ]);
    }

    public function employee_profile()
    {
        $id = auth()->user()->id;

        $employee = User::with(['profile', 'department', 'subDepartment', 'designation', 'manager', 'salaryYears.year'])->findOrFail($id);

        $assets = EmployeeAsset::with('asset')->where('employee_id', $id)->orderBy('assigned_on', 'desc')->get();

        $education = EmployeeEducation::where('employee_id', $id)->latest()->get();
        $experience = EmployeeExperience::where('employee_id', $id)->latest()->get();

        $working_days = DesignationWorkingDay::with('workingDay')
            ->where('designation_id', $employee->designation->id ?? null)
            ->get()
            ->pluck('workingDay.day_name')
            ->toArray();

        $leaves = DesignationLeaveType::with('leaveType')
            ->where('role_id', $employee->designation->id ?? null)
            ->get();

        $currentYear = date('Y');
        $year = Year::where('year', $currentYear)->first();

        $holidays = [];

        if ($year) {
            $holidays = Holiday::where('year_id', $year->id)
                ->where('status', 'Active')
                ->orderBy('from_date', 'asc')
                ->get()
                ->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->from_date)->format('F');
                });
        }

        $salaryYears = EmployeeSalaryYear::with('year')
            ->where('employee_id', $id)
            ->latest('year')
            ->get();

        return view(
            'admin.employees.profile_details',
            compact(
                'employee',
                'assets',
                'working_days',
                'leaves',
                'holidays',
                'salaryYears',
                'education',
                'experience'
            )
        );
    }
}
