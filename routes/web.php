<?php

use App\Http\Controllers\admin\AdminWorkingDaysController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\admin\AssetController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\admin\BloodGroupController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\DesignationController;
use App\Http\Controllers\Admin\DesignationLeaveController;
use App\Http\Controllers\Admin\DesignationWorkingDayController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployerEsicController;
use App\Http\Controllers\Admin\ExpenseReimbursementController;
use App\Http\Controllers\admin\HolidayController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\LoanManagementController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PFController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\QualificationAreaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SalaryProcessingController;
use App\Http\Controllers\Admin\SalaryTypeController;
use App\Http\Controllers\Admin\IdCardController;
use App\Http\Controllers\Admin\SubDepartmentController;
use App\Http\Controllers\Admin\WorkingDayController;
use App\Http\Controllers\Admin\YearController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache cleared!";
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'loginSubmit'])->name('login.submit');
    Route::get('forgot-password', [AdminAuthController::class, 'show_forgot_password_Form'])->name('forgot.password');
    Route::post('forgot-password-check', [AdminAuthController::class, 'forgot_password_check'])->name('forgot.password.check');
    Route::get('otp-verification/{id}', [AdminAuthController::class, 'otp_Verification_Form'])->name('otp.verification');
    Route::post('verify-otp', [AdminAuthController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('resend-otp', [AdminAuthController::class, 'resendOtp'])->name('resend.otp');
    Route::get('reset-password/{id}', [AdminAuthController::class, 'reset_password'])->name('reset.password');
    Route::post('reset-password-submit', [AdminAuthController::class, 'reset_password_submit'])->name('reset.password.submit');

    Route::get('/get-subdepartments/{id}', [DashboardController::class, 'get_subdepartments'])->name('get.subdepartments');
    Route::get('/get-reporting-manager/{designation}', [DashboardController::class, 'get_reporting_manager'])->name('get.reporting.manager');

    Route::middleware(['auth:admin'])->group(function () {

        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::post('profile-update', [AdminAuthController::class, 'profile_update'])->name('profile.update');

        Route::middleware(['permission:View dashboard|Employee dashboard'])->group(function () {
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        });

        Route::middleware(['permission:View Roles'])->group(function () {
            Route::get('/roles', [RoleController::class, 'role_list'])->name('roles.list');
        });

        Route::middleware(['permission:Edit Roles'])->group(function () {
            Route::get('/roles-edit/{id}', [RoleController::class, 'role_edit'])->name('roles.edit');
            Route::post('/roles-update', [RoleController::class, 'role_update'])->name('roles.update');
        });
        Route::middleware(['permission:View Permissions'])->group(function () {
            Route::get('/permissions', [PermissionController::class, 'permissions_list'])->name('permissions.list');
        });
        Route::middleware(['permission:Create Permissions'])->group(function () {
            Route::get('/create-permissions', [PermissionController::class, 'permissions_create'])->name('permissions.create');
            Route::post('/permissions-store', [PermissionController::class, 'permissions_store'])->name('permissions.store');
        });
        Route::middleware(['permission:Edit Permissions'])->group(function () {
            Route::get('/permissions-edit/{id}', [PermissionController::class, 'permissions_edit'])->name('permissions.edit');
            Route::post('/permissions-update', [PermissionController::class, 'permissions_update'])->name('permissions.update');
        });

        Route::prefix('designation-working-days')->middleware(['permission:View Working Days'])->group(function () {
            Route::get('/', [DesignationWorkingDayController::class, 'index'])->name('designation-working-days.index');
            Route::get('{id}/edit', [DesignationWorkingDayController::class, 'edit'])->name('designation-working-days.edit');
            Route::post('{id}/update', [DesignationWorkingDayController::class, 'update'])->name('designation-working-days.update');
            Route::get('{id}/get-days', [DesignationWorkingDayController::class, 'getDays'])->name('designation-working-days.get-days');
            Route::post('save-modal', [DesignationWorkingDayController::class, 'saveFromModal'])->name('designation-working-days.save-modal');
        });

        Route::prefix('designation-leaves')->middleware(['permission:View Leaves'])->group(function () {
            Route::get('/', [DesignationLeaveController::class, 'index'])->name('designation.leaves.index');
            Route::get('{id}/get', [DesignationLeaveController::class, 'getData'])->name('designation.leaves.get');
            Route::post('save', [DesignationLeaveController::class, 'store'])->name('designation.leaves.save');
        });

        Route::prefix('years')->middleware(['permission:View Years'])->group(function () {
            Route::get('/', [YearController::class, 'index'])->name('years.index');
            Route::post('store', [YearController::class, 'store'])->name('years.store');
            Route::get('edit/{id}', [YearController::class, 'edit'])->name('years.edit');
            Route::post('update/{id}', [YearController::class, 'update'])->name('years.update');
            Route::post('delete/{id}', [YearController::class, 'delete'])->name('years.delete');
        });

        Route::middleware(['permission:View Salary Types'])->group(function () {
            Route::get('salary-types', [SalaryTypeController::class, 'index'])->name('salary-types.index');
            Route::post('salary-types', [SalaryTypeController::class, 'store'])->name('salary-types.store');
            Route::put('salary-types/{salary_type}', [SalaryTypeController::class, 'update'])->name('salary-types.update');
            Route::delete('salary-types/{salary_type}', [SalaryTypeController::class, 'destroy'])->name('salary-types.destroy');
        });

        Route::prefix('pf-setting')->middleware(['permission:View PF'])->group(function () {
            Route::get('/', [PFController::class, 'index'])->name('pf.index');
            Route::post('save', [PFController::class, 'store'])->name('pf.store');
        });

        Route::prefix('esic-settings')->middleware(['permission:View ESIC'])->group(function () {
            Route::get('/', [EmployerEsicController::class, 'index'])->name('esic.index');
            Route::post('save', [EmployerEsicController::class, 'store'])->name('esic.store');
        });

        Route::prefix('monthly_working-days')->middleware(['permission:View Monthly Working'])->group(function () {
            Route::get('/', [AdminWorkingDaysController::class, 'create'])->name('monthly_working.create');
            Route::post('/', [AdminWorkingDaysController::class, 'store'])->name('monthly_working.store');
        });

        Route::prefix('departments')->middleware(['permission:View Departments'])->group(function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
            Route::post('/store', [DepartmentController::class, 'store'])->name('departments.store');
            Route::post('/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
            Route::get('/delete/{id}', [DepartmentController::class, 'delete'])->name('departments.delete');
        });

        Route::prefix('sub-departments')->middleware(['permission:View Departments'])->group(function () {
            Route::get('/', [SubDepartmentController::class, 'index'])->name('sub-departments.index');
            Route::post('/store', [SubDepartmentController::class, 'store'])->name('sub-departments.store');
            Route::post('/update', [SubDepartmentController::class, 'update'])->name('sub-departments.update');
            Route::get('/delete/{id}', [SubDepartmentController::class, 'delete'])->name('sub-departments.delete');
        });

        Route::prefix('designations')->middleware(['permission:View Designations'])->group(function () {
            Route::get('/', [DesignationController::class, 'index'])->name('designations.index');
            Route::post('/store', [DesignationController::class, 'store'])->name('designations.store');
            Route::post('/update', [DesignationController::class, 'update'])->name('designations.update');
            Route::get('/delete/{id}', [DesignationController::class, 'delete'])->name('designations.delete');
        });

        Route::prefix('blood-groups')->middleware(['permission:View Blood Groups'])->group(function () {
            Route::get('/', [BloodGroupController::class, 'index'])->name('blood-groups.index');
            Route::post('/store', [BloodGroupController::class, 'store'])->name('blood-groups.store');
            Route::post('/update', [BloodGroupController::class, 'update'])->name('blood-groups.update');
            Route::get('/delete/{id}', [BloodGroupController::class, 'delete'])->name('blood-groups.delete');
        });

        Route::prefix('holidays')->middleware(['permission:View Holidays'])->group(function () {
            Route::get('/', [HolidayController::class, 'index'])->name('holidays.index');
            Route::post('/store', [HolidayController::class, 'store'])->name('holidays.store');
            Route::post('/update', [HolidayController::class, 'update'])->name('holidays.update');
            Route::get('/delete/{id}', [HolidayController::class, 'delete'])->name('holidays.delete');
        });

        Route::prefix('leave-types')->middleware(['permission:View Leave Types'])->group(function () {
            Route::get('/', [LeaveTypeController::class, 'index'])->name('leave-types.index');
            Route::post('/store', [LeaveTypeController::class, 'store'])->name('leave-types.store');
            Route::post('/update', [LeaveTypeController::class, 'update'])->name('leave-types.update');
            Route::get('/delete/{id}', [LeaveTypeController::class, 'delete'])->name('leave-types.delete');
        });

        Route::prefix('qualification-areas')->middleware(['permission:View Qualification'])->group(function () {
            Route::get('/', [QualificationAreaController::class, 'index'])->name('qualification.areas.index');
            Route::post('/store', [QualificationAreaController::class, 'store'])->name('qualification.areas.store');
            Route::post('/update', [QualificationAreaController::class, 'update'])->name('qualification.areas.update');
            Route::post('/delete/{id}', [QualificationAreaController::class, 'delete'])->name('qualification.areas.delete');
        });

        Route::prefix('working-days')->middleware(['permission:Working Days Master'])->group(function () {
            Route::get('/', [WorkingDayController::class, 'index'])->name('working.days.index');
            Route::post('/store', [WorkingDayController::class, 'store'])->name('working.days.store');
            Route::post('/update', [WorkingDayController::class, 'update'])->name('working.days.update');
            Route::delete('/delete/{id}', [WorkingDayController::class, 'delete'])->name('working.days.delete');
        });

        Route::prefix('courses')->middleware(['permission:View Courses'])->group(function () {
            Route::get('/', [CourseController::class, 'index'])->name('courses.index');
            Route::post('/store', [CourseController::class, 'store'])->name('courses.store');
            Route::post('/update', [CourseController::class, 'update'])->name('courses.update');
            Route::delete('/delete/{id}', [CourseController::class, 'delete'])->name('courses.delete');
        });

        Route::prefix('employees')->middleware(['permission:View Employees'])->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
            Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
            Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
            Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
            Route::post('/update', [EmployeeController::class, 'update'])->name('employees.update');
            Route::post('/delete/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');

            Route::get('/salary', [EmployeeController::class, 'get_employees_salary'])->name('get.employees.salary');
            Route::get('/create-salary/{id}', [EmployeeController::class, 'employees_create_salary'])->name('employees.create.salary');
            Route::post('/store-salary', [EmployeeController::class, 'employees_store_salary'])->name('employees.store.salary');
            Route::get('/edit-salary/{id}', [EmployeeController::class, 'employees_edit_salary'])->name('employees.edit.salary');

            Route::get('/view/{id}', [EmployeeController::class, 'view'])->name('employees.view');
            Route::post('/profile-update', [EmployeeController::class, 'profile_update'])->name('employees.profile.update');
            Route::post('/basic-update', [EmployeeController::class, 'basic_update'])->name('employee.basic.update');
            Route::post('/personal-update', [EmployeeController::class, 'personal_update'])->name('employees.personal.update');
            Route::post('/emergency-update', [EmployeeController::class, 'emergency_update'])->name('employee.emergency.update');
            Route::post('/about-update', [EmployeeController::class, 'about_update'])->name('employee.about.update');
            Route::post('/job-info-update', [EmployeeController::class, 'job_info_update'])->name('employee.job.info.update');
            Route::post('/bank-update', [EmployeeController::class, 'bank_update'])->name('employee.bank.update');
            Route::post('/pf-esi-update', [EmployeeController::class, 'pf_esi_update'])->name('employee.Pf.Esi.update');
            Route::post('/address-update', [EmployeeController::class, 'address_update'])->name('employee.address.update');
            Route::post('/education-update', [EmployeeController::class, 'education_update'])->name('employee.education.update');
            Route::delete('/education-delete/{id}', [EmployeeController::class, 'education_delete'])->name('employee.education.delete');
            Route::post('/experience-update', [EmployeeController::class, 'experience_update'])->name('employee.experience.update');
            Route::delete('/experience-delete/{id}', [EmployeeController::class, 'experience_delete'])->name('employee.experience.delete');
        });

        Route::prefix('assets')->middleware(['permission:View Assets'])->group(function () {
            Route::get('/', [AssetController::class, 'index'])->name('assets.index');
            Route::post('/store', [AssetController::class, 'store'])->name('assets.store');
            Route::post('/update', [AssetController::class, 'update'])->name('assets.update');
            Route::delete('/delete/{id}', [AssetController::class, 'delete'])->name('assets.delete');
        });

        Route::prefix('assign-assets')->middleware(['permission:Assign Assets'])->group(function () {
            Route::get('/', [AssetController::class, 'assign_assets_index'])->name('assign.assets.index');
            Route::get('/get-assign-assets/{id}', [AssetController::class, 'get_assigned_assets'])->name('get.assigned.assets');
            Route::post('/store', [AssetController::class, 'assign_assets_store'])->name('assign.assets.store');
        });

        Route::prefix('assets.history')->middleware(['permission:View Asset History'])->group(function () {
            Route::get('/', [AssetController::class, 'assets_history'])->name('assets.history');
            Route::get('/get-assign-assets/{id}', [AssetController::class, 'get_assigned_assets'])->name('get.assigned.assets');
            Route::get('/ajax', [AssetController::class, 'assets_history_ajax'])->name('assets.history.ajax');
            Route::get('/return/{id}', [AssetController::class, 'assets_return'])->name('assets.return');
        });

        Route::prefix('loan')->middleware(['permission:Loan Management'])->group(function () {
            Route::get('/create', [LoanManagementController::class, 'loans_create'])->name('loans.create');
            Route::post('/store', [LoanManagementController::class, 'loans_store'])->name('loans.store');
            Route::get('/request', [LoanManagementController::class, 'loans_request'])->name('loan.request');
            Route::post('/update-status', [LoanManagementController::class, 'loans_update_status'])->name('loans.update.status');
        });

        Route::prefix('expense-reimbursement')->middleware(['permission:Expense Reimbursement'])->group(function () {
            Route::get('/list', [ExpenseReimbursementController::class, 'expense_reimbursement_list'])->name('expense.reimbursement.list');
            Route::get('/create', [ExpenseReimbursementController::class, 'expense_reimbursement_create'])->name('expense.reimbursement.create');
            Route::post('/store', [ExpenseReimbursementController::class, 'expense_reimbursement_store'])->name('expense.reimbursement.store');
            Route::post('/update-status', [ExpenseReimbursementController::class, 'expense_reimbursement_update_status'])->name('expense.reimbursement.update.status');
        });

        Route::prefix('Salary')->middleware(['permission:Process Salary'])->group(function () {
            Route::get('/Processing', [SalaryProcessingController::class, 'salary_processing'])->name('salary.Processing');
            Route::get('/process-status', [SalaryProcessingController::class, 'salary_process_status'])->name('salary.process.status');
            Route::get('/attendance-preview', [SalaryProcessingController::class, 'salary_attendance_preview'])->name('salary.attendance.preview');
            Route::post('/attendance-store', [SalaryProcessingController::class, 'salary_attendance_store'])->name('salary.attendance.store');
            Route::get('/loan-preview', [SalaryProcessingController::class, 'salary_loan_preview'])->name('salary.loan.preview');
            Route::post('/loan-verify', [SalaryProcessingController::class, 'salary_loan_verify'])->name('salary.loan.verify');
            Route::get('/expense-preview', [SalaryProcessingController::class, 'salary_expense_preview'])->name('salary.expense.preview');
            Route::post('/expense-verify', [SalaryProcessingController::class, 'salary_expense_verify'])->name('salary.expense.verify');
            Route::get('/process-verify', [SalaryProcessingController::class, 'salary_process_verify'])->name('salary.process.verify');
            Route::Post('/process-save', [SalaryProcessingController::class, 'salary_process_save'])->name('salary.process.save');
            Route::post('/slip-generate', [SalaryProcessingController::class, 'generate_Salary_Slip'])->name('salary.slip.generate');
            Route::get('/salary-slip', [SalaryProcessingController::class, 'salary_slip'])->name('salary.slip.page');

            Route::get('/attendance/{employee_id}/{month}/{year}', [SalaryProcessingController::class, 'salary_attendance_show'])->name('salary.attendance.show');
            Route::post('/attendance-update', [SalaryProcessingController::class, 'salary_attendance_update'])->name('salary.attendance.update');
        });

        Route::prefix('category')->middleware(['permission:Category Master'])->group(function () {
            Route::get('/list', [CategoryController::class, 'category_list'])->name('category.list');
            Route::post('/store', [CategoryController::class, 'category_store'])->name('category.store');
            Route::post('/update', [CategoryController::class, 'category_update'])->name('category.update');
        });


        // ID Card Generate
Route::get('id-cards',                    [IdCardController::class, 'index'])->name('id.cards.index');
Route::post('id-cards/ajax-without',      [IdCardController::class, 'ajaxWithoutIdCard'])->name('id.cards.ajaxWithout');
Route::get('id-cards/generate',           [IdCardController::class, 'generate'])->name('id.cards.generate');
Route::get('id-cards/reprint',            [IdCardController::class, 'reprint'])->name('id.cards.reprint');
Route::delete('id-cards/delete/{id}',     [IdCardController::class, 'delete'])->name('id.cards.delete');

// ID Card Report
Route::get('id-cards/report',             [IdCardController::class, 'report'])->name('id.cards.report');
Route::post('id-cards/ajax-with',         [IdCardController::class, 'ajaxWithIdCard'])->name('id.cards.ajaxWith');

// ID Card Template
Route::get('id-card-template',            [IdCardController::class, 'templateIndex'])->name('id.card.template.index');
Route::get('id-card-template/edit/{id}',  [IdCardController::class, 'templateEdit'])->name('id.card.template.edit');
Route::post('id-card-template/update/{id}',[IdCardController::class, 'templateUpdate'])->name('id.card.template.update');
Route::post('id-card-template/toggle/{id}',[IdCardController::class, 'templateToggle'])->name('id.card.template.toggle');
   Route::resource('site-settings',SiteSettingController::class);
    });
});

Route::prefix('employee')->name('employee.')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {

        Route::post('/leave-store', [LeaveController::class, 'leave_store'])->name('leave.store');
        Route::get('/get-leave-details', [LeaveController::class, 'get_Leave_Details'])->name('leave.details');
        Route::post('/leave/mark-read', [LeaveController::class, 'leave_mark_Read'])->name('leave.mark.read');

        Route::post('/attendance/punch', [AttendanceController::class, 'attendance_punch'])->name('attendance.punch');

        Route::prefix('profile')->middleware(['permission:Employee Profile'])->group(function () {
            Route::get('/', [EmployeeController::class, 'employee_profile'])->name('profile');
        });

        Route::prefix('leaves')->middleware(['permission:Employee My Leaves'])->group(function () {
            Route::get('/', [LeaveController::class, 'employee_my_leaves'])->name('my.leaves');
        });

        Route::prefix('leave-requests')->middleware(['permission:Employee Leaves Request'])->group(function () {
            Route::get('/', [LeaveController::class, 'leave_request'])->name('leave.requests');
            Route::post('/approve', [LeaveController::class, 'leave_request_approve'])->name('leave.request.approve');
            Route::post('/reject', [LeaveController::class, 'leave_request_reject'])->name('leave.request.reject');
            Route::get('get-types/{user}', [LeaveController::class, 'get_Leave_Types']);
            Route::post('/admin-store', [LeaveController::class, 'admin_leave_store'])->name('admin.leave.store');
        });

        Route::prefix('attendance')->middleware(['permission:My Attendance'])->group(function () {
            Route::get('/', [AttendanceController::class, 'employee_my_attendance'])->name('my.attendance');
        });

        Route::prefix('attendance-request')->middleware(['permission:Attendance Request'])->group(function () {
            Route::get('/', [AttendanceController::class, 'attendance_request'])->name('attendance.request');
            Route::post('/attendance-approve', [AttendanceController::class, 'attendance_approve'])->name('attendance.request.approve');
            Route::post('/attendance-reject', [AttendanceController::class, 'attendance_reject'])->name('attendance.request.reject');
        });

        Route::prefix('product')->middleware(['permission:Product Master'])->group(function () {
            Route::get('/list', [ProductController::class, 'product_list'])->name('product.list');
            Route::get('/create', [ProductController::class, 'product_create'])->name('product.create');
            Route::post('/store', [ProductController::class, 'product_store'])->name('product.store');
            Route::get('/edit/{id}', [ProductController::class, 'product_edit'])->name('product.edit');
            Route::post('/update', [ProductController::class, 'product_update'])->name('product.update');
        });

        Route::prefix('inquiry')->middleware(['permission:Product Inquiry'])->group(function () {
            Route::get('/list', [InquiryController::class, 'inquiry_list'])->name('inquiry.list');
            Route::get('/create', [InquiryController::class, 'inquiry_create'])->name('inquiry.create');
            Route::post('/store', [InquiryController::class, 'inquiry_store'])->name('inquiry.store');
            Route::get('/edit/{id}', [InquiryController::class, 'inquiry_edit'])->name('inquiry.edit');
            Route::post('/update', [InquiryController::class, 'inquiry_update'])->name('inquiry.update');
        });
    });
});

Route::get('/', [AdminAuthController::class, 'showLoginForm']);

Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('front.privacy.policy');
Route::get('/terms-conditions', [HomeController::class, 'terms_conditions'])->name('front.terms.conditions');
