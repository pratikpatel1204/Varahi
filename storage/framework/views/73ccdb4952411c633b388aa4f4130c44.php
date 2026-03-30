<?php $__env->startSection('title', config('app.name') . ' || Employee Details'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0">
                    <a href="<?php echo e(route('admin.employees.index')); ?>">
                        <i class="ti ti-arrow-left me-2"></i>Employee Details
                    </a>
                </h6>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 ">
                <div class="card card-bg-1">
                    <div class="card-body p-0">
                        <span class="avatar avatar-xl avatar-rounded border border-2 border-white m-auto d-flex mb-2">
                            <?php if(!empty($employee->profile_image)): ?>
                                <img src="<?php echo e(asset($employee->profile_image)); ?>" alt="Employee Image">
                            <?php else: ?>
                                <img src="<?php echo e(asset('admin/img/person-dummy.jpg')); ?>" class="w-auto h-auto" alt="">
                            <?php endif; ?>
                        </span>
                        <div class="text-center px-3 pb-3 border-bottom">
                            <div class="mb-3">
                                <h5 class="d-flex align-items-center justify-content-center mb-1"> <?php echo e($employee->name); ?>

                                    <?php if($employee->status == 1): ?>
                                        <i class="ti ti-discount-check-filled text-success ms-1"></i>
                                    <?php endif; ?>
                                </h5>
                                <span class="badge badge-soft-dark fw-medium me-2">
                                    <i class="ti ti-point-filled me-1"></i>
                                    <?php echo e($employee->designation->name ?? 'N/A'); ?>

                                </span>
                                <span class="badge badge-soft-secondary fw-medium">
                                    <?php if(optional($employee->profile)->experience_years): ?>
                                        <?php echo e($employee->profile->experience_years); ?> years of Experience
                                    <?php else: ?>
                                        No Experience
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-id me-2"></i>
                                        Employee ID
                                    </span>
                                    <p class="text-dark">
                                        <?php echo e($employee->employee_code ?? '-'); ?>

                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-star me-2"></i>
                                        Department
                                    </span>
                                    <p class="text-dark">
                                        <?php echo e($employee->department->name ?? 'N/A'); ?>

                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-star me-2"></i>
                                        Sub Department
                                    </span>
                                    <p class="text-dark">
                                        <?php echo e($employee->subDepartment->name ?? 'N/A'); ?>

                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-calendar-check me-2"></i>
                                        Date Of Join
                                    </span>
                                    <p class="text-dark">
                                        <?php if(optional($employee->profile)->joining_date): ?>
                                            <?php echo e(\Carbon\Carbon::parse($employee->profile->joining_date)->format('d M Y')); ?>

                                        <?php elseif($employee->created_at): ?>
                                            <?php echo e(\Carbon\Carbon::parse($employee->created_at)->format('d M Y')); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-calendar-check me-2"></i>
                                        Reporting Manager
                                    </span>
                                    <div class="d-flex align-items-center">
                                        <p class="text-gray-9 mb-0"><?php echo e($manager->name ?? 'Not Assigned'); ?></p>
                                    </div>
                                </div>
                                <div class="row gx-2 mt-3">
                                    <div class="col-12">
                                        <a href="#" class="btn btn-dark w-100" data-bs-toggle="modal"
                                            data-bs-target="#edit_employee">
                                            <i class="ti ti-edit me-1"></i>Edit Info
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6>Basic information</h6>
                                <a href="javascript:void(0);" class="btn btn-dark btn-icon btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#edit_basic_info">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-phone me-2"></i>Phone
                                </span>
                                <p class="text-dark">
                                    <?php echo e($employee->phone ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-mail-check me-2"></i>Email
                                </span>
                                <a href="javascript:void(0)" class="text-info d-inline-flex align-items-center copy-email"
                                    data-email="<?php echo e($employee->email); ?>">
                                    <?php echo e($employee->email ?? '-'); ?><i class="ti ti-copy text-dark ms-2"></i>
                                </a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-gender-male me-2"></i>Gender
                                </span>
                                <p class="text-dark text-end">
                                    <?php echo e($employee->gender ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-cake me-2"></i>Birthday
                                </span>
                                <p class="text-dark text-end">
                                    <?php if($employee->dob): ?>
                                        <?php echo e(\Carbon\Carbon::parse($employee->dob)->format('d M Y')); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-map-pin-check me-2"></i>Address
                                </span>
                                <p class="text-dark text-end">
                                    <?php echo nl2br(e($employee->address ?? '-')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6>Personal Information</h6>
                                <a href="javascript:void(0);" class="btn btn-dark btn-icon btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#edit_personal">
                                    <i class="ti ti-edit"></i>
                                </a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-e-passport me-2"></i>Passport No</span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->passport_no ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-calendar-x me-2"></i>Passport Exp Date</span>
                                <p class="text-dark">
                                    <?php if(optional($employee->profile)->passport_expiry): ?>
                                        <?php echo e(\Carbon\Carbon::parse(optional($employee->profile)->passport_expiry)->format('d M Y')); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-id me-2"></i>Aadhaar No</span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->aadhaar_no ?? '-'); ?>

                                </p>
                            </div>
                            <?php if(optional($employee->profile)->aadhaar_photo): ?>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span>
                                        <i class="ti ti-photo me-2"></i>
                                        Aadhaar Photo
                                    </span>
                                    <a href="<?php echo e(asset(optional($employee->profile)->aadhaar_photo)); ?>" target="_blank"
                                        class="text-primary">
                                        View
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-credit-card me-2"></i>PAN No</span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->pan_no ?? '-'); ?>

                                </p>
                            </div>
                            <?php if(optional($employee->profile)->pan_photo): ?>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span><i class="ti ti-photo me-2"></i>PAN Photo</span>
                                    <a href="<?php echo e(asset(optional($employee->profile)->pan_photo)); ?>" target="_blank"
                                        class="text-primary">
                                        View
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-flag me-2"></i>Nationality</span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->nationality ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-bookmark-plus me-2"></i>Religion</span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->religion ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span><i class="ti ti-heart me-2"></i>Marital Status</span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->marital_status ?? '-'); ?>

                                </p>
                            </div>
                            <?php if(optional($employee->profile)->marital_status == 'Yes'): ?>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span><i class="ti ti-briefcase-2 me-2"></i>Spouse Employment</span>
                                    <p class="text-dark">
                                        <?php echo e(optional($employee->profile)->spouse_employment ?? '-'); ?>

                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>
                                        <i class="ti ti-baby-bottle me-2"></i>
                                        No. of Children
                                    </span>
                                    <p class="text-dark">
                                        <?php echo e(optional($employee->profile)->children ?? '0'); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span>
                                    <i class="ti ti-droplet me-2"></i>
                                    Blood Group
                                </span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->bloodGroup->name ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span>
                                    <i class="ti ti-wheelchair me-2"></i>
                                    Differently Abled
                                </span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->differently_abled ?? 'No'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span>
                                    <i class="ti ti-mail me-2"></i>
                                    Personal Email
                                </span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->personal_email ?? '-'); ?>

                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span>
                                    <i class="ti ti-user me-2"></i>
                                    Father Name
                                </span>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->father_name ?? '-'); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6>Emergency Contact Number</h6>
                    <a href="javascript:void(0);" class="btn btn-dark btn-icon btn-sm" data-bs-toggle="modal"
                        data-bs-target="#edit_emergency">
                        <i class="ti ti-edit"></i>
                    </a>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-inline-flex align-items-center">Primary</span>
                                    <h6 class="d-flex align-items-center fw-medium mt-1">
                                        <?php echo e(optional($employee->profile)->emergency_name_1 ?? '-'); ?>

                                        <span class="d-inline-flex mx-1">
                                            <i class="ti ti-point-filled text-danger"></i>
                                        </span>
                                        <?php echo e(optional($employee->profile)->emergency_relation_1 ?? '-'); ?>

                                    </h6>
                                </div>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->emergency_phone_1 ?? '-'); ?>

                                </p>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-inline-flex align-items-center">
                                        Secondary
                                    </span>
                                    <h6 class="d-flex align-items-center fw-medium mt-1">
                                        <?php echo e(optional($employee->profile)->emergency_name_2 ?? '-'); ?>

                                        <span class="d-inline-flex mx-1">
                                            <i class="ti ti-point-filled text-danger"></i>
                                        </span>
                                        <?php echo e(optional($employee->profile)->emergency_relation_2 ?? '-'); ?>

                                    </h6>
                                </div>
                                <p class="text-dark">
                                    <?php echo e(optional($employee->profile)->emergency_phone_2 ?? '-'); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="tab-content custom-accordion-items">
                    <div class="tab-pane active show" id="bottom-justified-tab1" role="tabpanel">
                        <div class="accordion accordions-items-seperate" id="accordionExample">
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingOne">
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h5>About Employee</h5>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#primaryBorderOne"
                                                aria-expanded="false" aria-controls="primaryBorderOne">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="primaryBorderOne" class="accordion-collapse collapse show border-top"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body mt-2">
                                        <form method="POST" id="AboutForm">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                                            <div class="mb-3">
                                                <label class="form-label">About Employee</label>
                                                <textarea name="about" rows="5" class="form-control" placeholder="Write about employee..."><?php echo e(optional($employee->profile)->about); ?></textarea>
                                                <span class="text-danger error-about"></span>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary" id="aboutBtn">
                                                    <span class="btn-text">Save</span>
                                                    <span class="btn-loader d-none">
                                                        <i class="spinner-border spinner-border-sm"></i> Saving...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingJoining">
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h5>Joining Details</h5>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#joiningBorder"
                                                aria-expanded="false" aria-controls="joiningBorder">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="joiningBorder" class="accordion-collapse collapse  border-top"
                                        aria-labelledby="headingJoining" data-bs-parent="#accordionExample">
                                        <div class="accordion-body mt-2">
                                            <form id="jobInfoForm">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                                                <div class="row">
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Confirmation Date</label>
                                                        <input type="date" name="confirmation_date"
                                                            value="<?php echo e(old('confirmation_date', optional($employee->profile)->confirmation_date ? optional($employee->profile)->confirmation_date->format('Y-m-d') : '')); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-confirmation_date"></span>
                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Planned Join Date</label>
                                                        <input type="date" name="planned_join_date"
                                                            value="<?php echo e(old('planned_join_date', $employee->profile?->planned_join_date?->format('Y-m-d'))); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-planned_join_date"></span>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Joined On</label>
                                                        <input type="date" name="joined_on"
                                                            value="<?php echo e(old('joined_on', $employee->profile?->joined_on?->format('Y-m-d'))); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-joined_on"></span>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Probation (Months)</label>
                                                        <input type="number" name="probation_period"
                                                            value="<?php echo e(old('probation_period', $employee->profile?->probation_period)); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-probation_period"></span>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Notice Period (Months)</label>
                                                        <input type="number" name="notice_period"
                                                            value="<?php echo e(old('notice_period', $employee->profile?->notice_period)); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-notice_period"></span>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Previous Exp (Years)</label>
                                                        <input type="number" step="0.1" name="previous_experience"
                                                            value="<?php echo e(old('previous_experience', $employee->profile?->previous_experience)); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-previous_experience"></span>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label">Total Exp (Years)</label>
                                                        <input type="number" step="0.1" name="total_experience"
                                                            value="<?php echo e(old('total_experience', $employee->profile?->total_experience)); ?>"
                                                            class="form-control">
                                                        <span class="text-danger error-total_experience"></span>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary" id="jobBtn">
                                                        <span class="btn-text">Save</span>
                                                        <span class="btn-loader d-none">
                                                            <i class="spinner-border spinner-border-sm"></i> Saving...
                                                        </span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <div class="accordion-header" id="headingTwo">
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h5>Bank Information</h5>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#primaryBorderTwo">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="primaryBorderTwo" class="accordion-collapse collapse border-top"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form id="bankForm">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Bank Name <small
                                                            class="text-danger">*</small></label>
                                                    <input type="text" name="bank_name"
                                                        value="<?php echo e(old('bank_name', $employee->profile?->bank_name)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-bank_name"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">IFSC Code <small
                                                            class="text-danger">*</small></label>
                                                    <input type="text" name="ifsc_code"
                                                        value="<?php echo e(old('ifsc_code', $employee->profile?->ifsc_code)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-ifsc_code"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Branch <small
                                                            class="text-danger">*</small></label>
                                                    <input type="text" name="branch"
                                                        value="<?php echo e(old('branch', $employee->profile?->branch)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-branch"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Account No</label>
                                                    <input type="number" name="account_number"
                                                        value="<?php echo e(old('account_number', $employee->profile?->account_number)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-account_number"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Account Holder Name <small
                                                            class="text-danger">*</small></label>
                                                    <input type="text" name="account_holder_name"
                                                        value="<?php echo e(old('account_holder_name', $employee->profile?->account_holder_name)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-account_holder_name"></span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary" id="bankBtn">
                                                    <span class="btn-text">Save</span>
                                                    <span class="btn-loader d-none">
                                                        <i class="spinner-border spinner-border-sm"></i> Saving...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="accordion-header" id="headingSalary">
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h5>Bank & Statutory Details</h5>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#collapseSalary">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseSalary" class="accordion-collapse collapse border-top"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form id="pfEsiForm">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                                            <div class="row">
                                                <h5 class="mb-3">PF Information</h5>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">UAN / PF Member ID</label>
                                                    <input type="text" name="uan_number"
                                                        value="<?php echo e(old('uan_number', $employee->profile?->uan_number)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-uan_number"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PF Account Number</label>
                                                    <input type="text" name="pf_account_number"
                                                        value="<?php echo e(old('pf_account_number', $employee->profile?->pf_account_number)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-pf_account_number"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PF Applicable</label>
                                                    <select name="pf_applicable" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            <?php echo e(old('pf_applicable', $employee->profile?->pf_applicable) == 'Yes' ? 'selected' : ''); ?>>
                                                            Yes</option>
                                                        <option value="No"
                                                            <?php echo e(old('pf_applicable', $employee->profile?->pf_applicable) == 'No' ? 'selected' : ''); ?>>
                                                            No</option>
                                                    </select>
                                                    <span class="text-danger error-pf_applicable"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PF Join Date</label>
                                                    <input type="date" name="pf_join_date"
                                                        value="<?php echo e(old('pf_join_date', $employee->profile?->pf_join_date?->format('Y-m-d'))); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-pf_join_date"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PF Exit Date</label>
                                                    <input type="date" name="pf_exit_date"
                                                        value="<?php echo e(old('pf_exit_date', $employee->profile?->pf_exit_date?->format('Y-m-d'))); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-pf_exit_date"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Contribution Type</label>
                                                    <input type="text" name="pf_contribution_type"
                                                        value="<?php echo e(old('pf_contribution_type', $employee->profile?->pf_contribution_type ?? 'Full Wages')); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-pf_contribution_type"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">PF Document</label>
                                                    <input type="file" name="pf_document" class="form-control">
                                                    <span class="text-danger error-pf_document"></span>

                                                    <?php if($employee->profile?->pf_document): ?>
                                                        <a href="<?php echo e(asset($employee->profile->pf_document)); ?>"
                                                            target="_blank">View</a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Name as per PF</label>
                                                    <input type="text" name="pf_name"
                                                        value="<?php echo e(old('pf_name', $employee->profile?->pf_name)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-pf_name"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">DOB as per PF</label>
                                                    <input type="date" name="pf_dob"
                                                        value="<?php echo e(old('pf_dob', $employee->profile?->pf_dob?->format('Y-m-d'))); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-pf_dob"></span>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label>Previous PF Details</label>
                                                    <textarea name="pf_previous_details" class="form-control"><?php echo e(old('pf_previous_details', $employee->profile?->pf_previous_details)); ?></textarea>
                                                    <span class="text-danger error-pf_previous_details"></span>
                                                </div>
                                                <h5 class="mb-3 mt-4">ESI Information</h5>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">ESIC IP Number</label>
                                                    <input type="text" name="esic_number"
                                                        value="<?php echo e(old('esic_number', $employee->profile?->esic_number)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-esic_number"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">ESIC Applicable</label>
                                                    <select name="esic_applicable" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            <?php echo e(old('esic_applicable', $employee->profile?->esic_applicable) == 'Yes' ? 'selected' : ''); ?>>
                                                            Yes</option>
                                                        <option value="No"
                                                            <?php echo e(old('esic_applicable', $employee->profile?->esic_applicable) == 'No' ? 'selected' : ''); ?>>
                                                            No</option>
                                                    </select>
                                                    <span class="text-danger error-esic_applicable"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Join Date</label>
                                                    <input type="date" name="esic_join_date"
                                                        value="<?php echo e(old('esic_join_date', $employee->profile?->esic_join_date?->format('Y-m-d'))); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-esic_join_date"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Exit Date</label>
                                                    <input type="date" name="esic_exit_date"
                                                        value="<?php echo e(old('esic_exit_date', $employee->profile?->esic_exit_date?->format('Y-m-d'))); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-esic_exit_date"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Name as per ESIC</label>
                                                    <input type="text" name="esic_name"
                                                        value="<?php echo e(old('esic_name', $employee->profile?->esic_name)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-esic_name"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">DOB (as per ESIC)</label>
                                                    <input type="date" name="esic_dob"
                                                        value="<?php echo e(old('esic_dob', $employee->profile?->esic_dob?->format('Y-m-d'))); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-esic_dob"></span>
                                                </div>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button type="submit" class="btn btn-primary" id="pfEsiBtn">
                                                    <span class="btn-text">Save</span>
                                                    <span class="btn-loader d-none">
                                                        <i class="spinner-border spinner-border-sm"></i> Saving...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="row">
                                    <div class="accordion-header" id="headingFour">
                                        <div class="accordion-button">
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <h5>Education Details</h5>
                                                <div class="d-flex">
                                                    <a href="#"
                                                        class="d-flex align-items-center collapsed collapse-arrow"
                                                        data-bs-toggle="collapse" data-bs-target="#primaryBorderFour">
                                                        <i class="ti ti-chevron-down fs-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="primaryBorderFour" class="accordion-collapse collapse border-top"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-end mb-3">
                                                <button class="btn btn-primary btn-sm" id="addEducationBtn">
                                                    <i class="ti ti-plus"></i> Add Education
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered align-middle" id="educationTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="140">Action</th>
                                                            <th>Qualification</th>
                                                            <th>Area</th>
                                                            <th>Course</th>
                                                            <th>Institute</th>
                                                            <th>Grade</th>
                                                            <th>Remark</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Document</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($education && $education->count()): ?>
                                                            <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $educ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-warning edit-btn"
                                                                            data-id="<?php echo e($educ->id); ?>"
                                                                            data-qualification="<?php echo e($educ->qualification); ?>"
                                                                            data-qualification_area="<?php echo e($educ->qualification_area); ?>"
                                                                            data-course="<?php echo e($educ->course); ?>"
                                                                            data-institution_name="<?php echo e($educ->institution_name); ?>"
                                                                            data-grade="<?php echo e($educ->grade); ?>"
                                                                            data-remark="<?php echo e($educ->remark); ?>"
                                                                            data-start_date="<?php echo e($educ->start_date); ?>"
                                                                            data-end_date="<?php echo e($educ->end_date); ?>"
                                                                            data-document="<?php echo e($educ->document); ?>">
                                                                            Edit
                                                                        </button>
                                                                        <button class="btn btn-sm btn-danger delete-btn"
                                                                            data-id="<?php echo e($educ->id); ?>">
                                                                            Delete
                                                                        </button>
                                                                    </td>
                                                                    <td><?php echo e($educ->qualification); ?></td>
                                                                    <td><?php echo e($educ->qualification_area ?? '-'); ?></td>
                                                                    <td><?php echo e($educ->course ?? '-'); ?></td>
                                                                    <td><?php echo e($educ->institution_name); ?></td>
                                                                    <td><?php echo e($educ->grade ?? '-'); ?></td>
                                                                    <td><?php echo e($educ->remark ?? '-'); ?></td>
                                                                    <td><?php echo e(\Carbon\Carbon::parse($educ->start_date)->format('d-m-Y')); ?>

                                                                    </td>
                                                                    <td><?php echo e(\Carbon\Carbon::parse($educ->end_date)->format('d-m-Y')); ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php if($educ->document): ?>
                                                                            <a href="<?php echo e(asset($educ->document)); ?>"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-info">
                                                                                View
                                                                            </a>
                                                                        <?php else: ?>
                                                                            -
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="11" class="text-center">No records found
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="row">
                                    <div class="accordion-header" id="headingFive">
                                        <div class="accordion-button collapsed">
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <h5>Experience</h5>
                                                <div class="d-flex">
                                                    <a href="#"
                                                        class="d-flex align-items-center collapsed collapse-arrow"
                                                        data-bs-toggle="collapse" data-bs-target="#primaryBorderFive"
                                                        aria-expanded="false" aria-controls="primaryBorderFive">
                                                        <i class="ti ti-chevron-down fs-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="primaryBorderFive" class="accordion-collapse collapse border-top"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-end mb-3">
                                                <button class="btn btn-primary btn-sm" id="addExperienceBtn">
                                                    <i class="ti ti-plus"></i> Add Experience
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th width="140">Action</th>
                                                            <th>Company</th>
                                                            <th>Designation</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th>Present</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if($experience && $experience->count()): ?>
                                                            <?php $__currentLoopData = $experience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-warning edit-exp-btn"
                                                                            data-id="<?php echo e($exp->id); ?>"
                                                                            data-company="<?php echo e($exp->company); ?>"
                                                                            data-designation="<?php echo e($exp->designation); ?>"
                                                                            data-start_date="<?php echo e($exp->start_date); ?>"
                                                                            data-end_date="<?php echo e($exp->end_date); ?>"
                                                                            data-is_present="<?php echo e($exp->is_present); ?>">
                                                                            Edit
                                                                        </button>
                                                                        <button
                                                                            class="btn btn-sm btn-danger delete-exp-btn"
                                                                            data-id="<?php echo e($exp->id); ?>">
                                                                            Delete
                                                                        </button>
                                                                    </td>
                                                                    <td><?php echo e($exp->company); ?></td>
                                                                    <td><?php echo e($exp->designation); ?></td>
                                                                    <td><?php echo e(\Carbon\Carbon::parse($exp->start_date)->format('d-m-Y')); ?>

                                                                    </td>
                                                                    <td>
                                                                        <?php echo e($exp->is_present ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('d-m-Y')); ?>

                                                                    </td>
                                                                    <td><?php echo e($exp->is_present ? 'Yes' : 'No'); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="6" class="text-center">No records found
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="accordion-header" id="alladdress">
                                    <div class="accordion-button">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h5>Address Details</h5>
                                            <a href="#" class="d-flex align-items-center collapsed collapse-arrow"
                                                data-bs-toggle="collapse" data-bs-target="#collapseaddress">
                                                <i class="ti ti-chevron-down fs-18"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseaddress" class="accordion-collapse collapse border-top"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form id="addressForm">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                                            <div class="row">
                                                <h5 class="mb-3">Present Address</h5>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" name="present_city"
                                                        value="<?php echo e(old('present_city', $employee->profile?->present_city)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-present_city"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">State</label>
                                                    <input type="text" name="present_state"
                                                        value="<?php echo e(old('present_state', $employee->profile?->present_state)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-present_state"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Country</label>
                                                    <input type="text" name="present_country"
                                                        value="<?php echo e(old('present_country', $employee->profile?->present_country)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-present_country"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Pincode</label>
                                                    <input type="number" name="present_pincode"
                                                        value="<?php echo e(old('present_pincode', $employee->profile?->present_pincode)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-present_pincode"></span>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Address</label>
                                                    <textarea name="present_address" class="form-control"><?php echo e(old('present_address', $employee->profile?->present_address)); ?></textarea>
                                                    <span class="text-danger error-present_address"></span>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label>
                                                        <input type="checkbox" id="sameAddress"> Same as Present Address
                                                    </label>
                                                </div>
                                                <h5 class="mb-3">Permanent Address</h5>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" name="permanent_city"
                                                        value="<?php echo e(old('permanent_city', $employee->profile?->permanent_city)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-permanent_city"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">State</label>
                                                    <input type="text" name="permanent_state"
                                                        value="<?php echo e(old('permanent_state', $employee->profile?->permanent_state)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-permanent_state"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Country</label>
                                                    <input type="text" name="permanent_country"
                                                        value="<?php echo e(old('permanent_country', $employee->profile?->permanent_country)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-permanent_country"></span>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Pincode</label>
                                                    <input type="number" name="permanent_pincode"
                                                        value="<?php echo e(old('permanent_pincode', $employee->profile?->permanent_pincode)); ?>"
                                                        class="form-control">
                                                    <span class="text-danger error-permanent_pincode"></span>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Address</label>
                                                    <textarea name="permanent_address" class="form-control"><?php echo e(old('permanent_address', $employee->profile?->permanent_address)); ?></textarea>
                                                    <span class="text-danger error-permanent_address"></span>
                                                </div>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button type="submit" class="btn btn-primary" id="addressBtn">
                                                    <span class="btn-text">Save</span>
                                                    <span class="btn-loader d-none">
                                                        <i class="spinner-border spinner-border-sm"></i> Saving...
                                                    </span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="contact-grids-tab p-0 mb-3">
                                        <ul class="nav nav-underline" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="assets-tab2" data-bs-toggle="tab"
                                                    data-bs-target="#assets" type="button" role="tab"
                                                    aria-selected="false">Assets</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="working-tab2" data-bs-toggle="tab"
                                                    data-bs-target="#working" type="button" role="tab"
                                                    aria-selected="false">Working Days</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="leave-tab" data-bs-toggle="tab"
                                                    data-bs-target="#leaves" type="button" role="tab">
                                                    Leave Quota
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="holiday-tab" data-bs-toggle="tab"
                                                    data-bs-target="#holidays" type="button" role="tab">
                                                    Holidays
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="salary-tab" data-bs-toggle="tab"
                                                    data-bs-target="#yearSalary" type="button" role="tab">
                                                    Year Wise Salary
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="myTabContent3">
                                        <div class="tab-pane fade show active" id="assets">
                                            <div id="assetContainer">
                                                <div class="row">
                                                    <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <div class="col-md-12 d-flex">
                                                            <div class="card flex-fill mb-3">
                                                                <div class="card-body">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-6">
                                                                            <h6 class="mb-1"><?php echo e($row->asset->name); ?>

                                                                            </h6>
                                                                            <p class="mb-0 text-muted">
                                                                                <span class="text-primary">
                                                                                    <?php echo e($row->asset->code ?? '-'); ?>

                                                                                </span>
                                                                                <i class="ti ti-point-filled mx-1"></i>
                                                                                Assigned on
                                                                                <?php echo e(\Carbon\Carbon::parse($row->assigned_on)->format('d M Y')); ?>

                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <span class="d-block mb-1">Assigned By</span>
                                                                            <span
                                                                                class="fw-normal"><?php echo e($row->assigned_by); ?></span>
                                                                        </div>
                                                                        <div class="col-md-2 text-end">
                                                                            <?php if($row->status == 'Assigned'): ?>
                                                                                <span
                                                                                    class="badge bg-success">Assigned</span>
                                                                            <?php else: ?>
                                                                                <span
                                                                                    class="badge bg-secondary">Returned</span>
                                                                                <div class="text-muted">
                                                                                    <?php echo e(\Carbon\Carbon::parse($row->return_date)->format('d M Y')); ?>

                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <div class="col-md-12">
                                                            <div class="alert alert-info text-center">
                                                                No Assets Assigned
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($assets->count() > 0 && $assets->hasPages()): ?>
                                                    <div class="mt-3 d-flex justify-content-center">
                                                        <?php echo $assets->links('pagination::bootstrap-5'); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="working" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card shadow-sm">
                                                        <div class="card-body">
                                                            <h5 class="mb-3 fw-bold">Employee Working Days</h5>
                                                            <?php
                                                                $allDays = [
                                                                    'Monday',
                                                                    'Tuesday',
                                                                    'Wednesday',
                                                                    'Thursday',
                                                                    'Friday',
                                                                    'Saturday',
                                                                    'Sunday',
                                                                ];
                                                            ?>
                                                            <div class="row g-3">
                                                                <?php $__currentLoopData = $allDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        $isWorking = in_array(
                                                                            $day,
                                                                            $working_days ?? [],
                                                                        );
                                                                    ?>
                                                                    <div class="col-lg-3 col-md-4 col-6">
                                                                        <div
                                                                            class="card text-center h-100 shadow-sm border-0">
                                                                            <div class="card-body">
                                                                                <h6 class="fw-semibold mb-3">
                                                                                    <?php echo e($day); ?>

                                                                                </h6>
                                                                                <?php if($isWorking): ?>
                                                                                    <span
                                                                                        class="badge bg-success w-100 py-2">
                                                                                        <i class="ti ti-check me-1"></i>
                                                                                        Working
                                                                                    </span>
                                                                                <?php else: ?>
                                                                                    <span
                                                                                        class="badge bg-danger w-100 py-2">
                                                                                        <i class="ti ti-x me-1"></i> Off
                                                                                    </span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="leaves" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="mb-3">Employee Leave Quota</h5>
                                                            <div class="row g-3">
                                                                <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <div class="col-md-3 col-6">
                                                                        <div
                                                                            class="border rounded p-3 text-center h-100 shadow-sm">
                                                                            <div class="fw-semibold text-dark mb-2">
                                                                                <?php echo e($leave->leaveType->name); ?>

                                                                            </div>
                                                                            <span class="badge bg-primary px-3 py-2">
                                                                                <?php echo e($leave->total_days); ?> Days
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    <div class="col-12">
                                                                        <div class="alert alert-warning text-center">
                                                                            No Leave Quota Assigned
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="holidays" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul class="nav nav-pills mb-3" id="holidayTab" role="tablist">
                                                        <?php $i = 0; ?>
                                                        <?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="nav-item me-1" role="presentation">
                                                                <button class="nav-link <?php echo e($i == 0 ? 'active' : ''); ?>"
                                                                    id="tab-<?php echo e($month); ?>" data-bs-toggle="pill"
                                                                    data-bs-target="#<?php echo e($month); ?>"
                                                                    type="button">
                                                                    <?php echo e(substr($month, 0, 3)); ?>

                                                                </button>
                                                            </li>
                                                            <?php $i++; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <?php $i = 0; ?>
                                                        <?php $__currentLoopData = $holidays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="tab-pane fade <?php echo e($i == 0 ? 'show active' : ''); ?>"
                                                                id="<?php echo e($month); ?>">
                                                                <div class="row g-3">
                                                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <div class="col-md-4 col-sm-6">
                                                                            <div class="card holiday-mini">
                                                                                <div class="card-body p-3">
                                                                                    <div class="small text-muted mb-1">
                                                                                        <i class="ti ti-calendar me-1"></i>
                                                                                        <?php if($h->from_date == $h->to_date): ?>
                                                                                            <?php echo e(\Carbon\Carbon::parse($h->from_date)->format('d M')); ?>

                                                                                        <?php else: ?>
                                                                                            <?php echo e(\Carbon\Carbon::parse($h->from_date)->format('d M')); ?>

                                                                                            -
                                                                                            <?php echo e(\Carbon\Carbon::parse($h->to_date)->format('d M')); ?>

                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                    <div class="fw-semibold mb-1">
                                                                                        <?php echo e($h->title); ?>

                                                                                    </div>
                                                                                    <span
                                                                                        class="badge bg-primary text-light small">
                                                                                        <?php echo e($h->type); ?>

                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if($list->count() == 0): ?>
                                                                        <div class="col-12 text-center text-muted">
                                                                            No Holidays
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <?php $i++; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="yearSalary" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php if($salaryYears->count()): ?>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered align-middle">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Year</th>
                                                                        <th>Salary Basis</th>
                                                                        <th>Payment Type</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $salaryYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php echo e($salary->year->year ?? 'N/A'); ?>

                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="badge bg-info-subtle text-info">
                                                                                    <?php echo e(ucfirst($salary->salary_basis)); ?>

                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="badge bg-secondary-subtle text-secondary">
                                                                                    <?php echo e(ucfirst($salary->payment_type)); ?>

                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                ₹
                                                                                <?php echo e(number_format($salary->salary_amount, 2)); ?>

                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="alert alert-warning mb-0">
                                                            No Salary Assigned Yet
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee -->
    <div class="modal fade" id="edit_employee">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <h4 class="modal-title me-2">Edit Employee</h4>
                        <span>Employee ID : <?php echo e($employee->employee_code); ?></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="EmployeeEditForm" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                    <div class="avatar avatar-xxl rounded-circle border border-dashed me-3">
                                        <?php if($employee->profile_image): ?>
                                            <img src="<?php echo e(asset($employee->profile_image)); ?>" class="rounded-circle"
                                                width="100">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('admin/img/person-dummy.jpg')); ?>" class="rounded-circle"
                                                width="100">
                                        <?php endif; ?>
                                    </div>
                                    <div class="profile-upload">
                                        <h6 class="mb-1">Upload Profile Image</h6>
                                        <p class="fs-12">Max 4 MB</p>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-sm btn-primary me-2" id="uploadBtn">
                                                Upload
                                            </button>
                                            <span id="fileName" class="text-muted fs-12">No file
                                                selected</span>
                                            <input type="file" name="profile_image" id="profileInput" class="d-none"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Name <small class="text-danger">*</small></label>
                                <input type="text" name="name" class="form-control"
                                    value="<?php echo e($employee->name); ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Employee Code <small class="text-danger">*</small></label>
                                <input type="text" name="employee_code" class="form-control"
                                    value="<?php echo e($employee->employee_code); ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Joining Date <small class="text-danger">*</small></label>
                                <input type="date" name="joining_date" class="form-control"
                                    value="<?php echo e($employee->joining_date); ?>">
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Experience <small class="text-danger">*</small></label>
                                    <input type="text" name="experience_years" class="form-control"
                                        value="<?php echo e(old('experience_years', $employee->experience_years ?? '')); ?>">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Department <small class="text-danger">*</small></label>
                                <select name="department_id" id="department" class="form-select">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($dept->id); ?>"
                                            <?php echo e(old('department_id', $employee->department_id) == $dept->id ? 'selected' : ''); ?>>
                                            <?php echo e($dept->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sub Department <small class="text-danger">*</small></label>
                                <select name="sub_department_id" id="sub_department" class="form-select">
                                    <option value="">Select Sub Department</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Designation <small class="text-danger">*</small></label>
                                <select name="designation" id="manager_designation" class="form-select">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $des): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($des->name); ?>"
                                            <?php echo e(old('designation', $employee->getRoleNames()->first()) == $des->name ? 'selected' : ''); ?>>
                                            <?php echo e($des->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Reporting Manager <small class="text-danger">*</small></label>
                                <select name="reporting_manager" id="reporting_manager" class="form-select">
                                    <option value="">Select Manager</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Status <small class="text-danger">*</small></label>
                                    <select name="status" class="form-select">
                                        <option value="1" <?php echo e($employee->status == 1 ? 'selected' : ''); ?>>
                                            Active
                                        </option>
                                        <option value="0" <?php echo e($employee->status == 0 ? 'selected' : ''); ?>>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer gap-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="updateEmployeeBtn">
                            <span class="btn-text">Save Changes</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Employee -->


    <!-- Edit Basic Info Modal -->
    <div class="modal fade" id="edit_basic_info">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Basic Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="EditBasicForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Phone <small class="text-danger">*</small></label>
                                <input type="text" name="phone" class="form-control"
                                    value="<?php echo e($employee->phone); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Email <small class="text-danger">*</small></label>
                                <input type="email" name="email" class="form-control"
                                    value="<?php echo e($employee->email); ?>">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Gender <small class="text-danger">*</small></label>
                                <select name="gender" class="form-select">
                                    <option value="">Select</option>
                                    <option value="male"
                                        <?php echo e(old('gender', $employee->gender) == 'male' ? 'selected' : ''); ?>>
                                        Male
                                    </option>
                                    <option value="female"
                                        <?php echo e(old('gender', $employee->gender) == 'female' ? 'selected' : ''); ?>>
                                        Female
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Date of Birth <small class="text-danger">*</small></label>
                                <input type="date" name="dob" class="form-control"
                                    value="<?php echo e($employee->dob); ?>">
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Address <small class="text-danger">*</small></label>
                                    <textarea name="address" rows="3" class="form-control"><?php echo e($employee->address); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="updateBasicBtn">
                            <span class="btn-text">Save Changes</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Basic Info Modal -->

    <!-- Edit Personal -->
    <div class="modal fade" id="edit_personal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Personal Info</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="EditPersonalForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body pb-0">
                        <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Passport No</label>
                                <input type="text" name="passport_no" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->passport_no); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Passport Expiry</label>
                                <input type="date" name="passport_expiry" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->passport_expiry); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group_id" class="form-select">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $bloodGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($group->id); ?>"
                                            <?php echo e(optional($employee->profile)->blood_group_id == $group->id ? 'selected' : ''); ?>>
                                            <?php echo e($group->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Father Name</label>
                                <input type="text" name="father_name" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->father_name); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Aadhaar No</label>
                                <input type="text" name="aadhaar_no" maxlength="12" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->aadhaar_no); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Aadhaar Photo</label>
                                <input type="file" name="aadhaar_photo" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN Card No</label>
                                <input type="text" name="pan_no" maxlength="10" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->pan_no); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">PAN Card Photo</label>
                                <input type="file" name="pan_photo" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Nationality</label>
                                <input type="text" name="nationality" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->nationality); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Religion</label>
                                <input type="text" name="religion" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->religion); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Marital Status</label>
                                <select name="marital_status" id="marital_status" class="form-select">
                                    <option value="">Select</option>
                                    <option value="Yes"
                                        <?php echo e(optional($employee->profile)->marital_status == 'Yes' ? 'selected' : ''); ?>>
                                        Yes
                                    </option>
                                    <option value="No"
                                        <?php echo e(optional($employee->profile)->marital_status == 'No' ? 'selected' : ''); ?>>
                                        No
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Spouse Employment</label>
                                <input type="text" name="spouse_employment" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->spouse_employment); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Children</label>
                                <input type="number" name="children" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->children); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Differently Abled</label>
                                <select name="differently_abled" class="form-select">
                                    <option value="No"
                                        <?php echo e(optional($employee->profile)->differently_abled == 'No' ? 'selected' : ''); ?>>
                                        No
                                    </option>
                                    <option value="Yes"
                                        <?php echo e(optional($employee->profile)->differently_abled == 'Yes' ? 'selected' : ''); ?>>
                                        Yes</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Personal Email</label>
                                <input type="email" name="personal_email" class="form-control"
                                    value="<?php echo e(optional($employee->profile)->personal_email); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="updatePersonalBtn">
                            <span class="btn-text">Save</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Personal -->

    <!-- Edit Emergency Contact -->
    <div class="modal fade" id="edit_emergency">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Emergency Contact Details</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="EmergencyForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body pb-0">
                        <input type="hidden" name="id" value="<?php echo e($employee->id); ?>">
                        <div class="row">
                            <h5 class="mb-3">Primary Contact Details</h5>
                            <div class="col-md-4 mb-3">
                                <label>Name <small class="text-danger">*</small></label>
                                <input type="text" name="emergency_name_1"
                                    value="<?php echo e(optional($employee->profile)->emergency_name_1); ?>" class="form-control">
                                <span class="text-danger error-emergency_name_1"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Relationship <small class="text-danger">*</small></label>
                                <input type="text" name="emergency_relation_1"
                                    value="<?php echo e(optional($employee->profile)->emergency_relation_1); ?>"
                                    class="form-control">
                                <span class="text-danger error-emergency_relation_1"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Phone No <small class="text-danger">*</small></label>
                                <input type="number" name="emergency_phone_1"
                                    value="<?php echo e(optional($employee->profile)->emergency_phone_1); ?>"
                                    class="form-control">
                                <span class="text-danger error-emergency_phone_1"></span>
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="mb-3">Secondary Contact Details</h5>
                            <div class="col-md-4 mb-3">
                                <label>Name</label>
                                <input type="text" name="emergency_name_2"
                                    value="<?php echo e(optional($employee->profile)->emergency_name_2); ?>" class="form-control">
                                <span class="text-danger error-emergency_name_2"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Relationship</label>
                                <input type="text" name="emergency_relation_2"
                                    value="<?php echo e(optional($employee->profile)->emergency_relation_2); ?>"
                                    class="form-control">
                                <span class="text-danger error-emergency_relation_2"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Phone No</label>
                                <input type="number" name="emergency_phone_2"
                                    value="<?php echo e(optional($employee->profile)->emergency_phone_2); ?>"
                                    class="form-control">
                                <span class="text-danger error-emergency_phone_2"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="emergencyBtn">
                            <span class="btn-text">Save</span>
                            <span class="btn-loader d-none">
                                <i class="spinner-border spinner-border-sm"></i> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Emergency Contact -->

    <!-- Education Modal -->
    <div class="modal fade" id="educationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="educationForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="education_id" id="education_id">
                    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo e($employee->id ?? ''); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title">Education</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Qualification <span class="text-danger">*</span></label>
                                <input type="text" name="qualification" id="qualification" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Qualification Area</label>
                                <select name="qualification_area" id="qualification_area" class="select2">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $qualificationAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($area->area_name); ?>"><?php echo e($area->area_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Upload Document</label>
                                <input type="file" name="document" id="document" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Institute <span class="text-danger">*</span></label>
                                <input type="text" name="institution_name" id="institution_name"
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Grade</label>
                                <input type="text" name="grade" id="grade" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Remark</label>
                                <input type="text" name="remark" id="remark" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Course</label>
                                <select name="course" id="course" class="form-select">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($course->course_name); ?>">
                                            <?php echo e($course->course_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">From <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">To <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success" id="saveBtn">
                            <span class="btn-text">Save</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="experienceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="experienceForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="experience_id" id="experience_id">
                    <input type="hidden" name="employee_id" value="<?php echo e($employee->id ?? ''); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title">Experience</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Company <span class="text-danger">*</span></label>
                                <input type="text" name="company" id="company" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Designation <span class="text-danger">*</span></label>
                                <input type="text" name="designation" id="designation" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>From <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="exp_start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>To</label>
                                <input type="date" name="end_date" id="exp_end_date" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>
                                    <input type="checkbox" name="is_present" id="is_present" value="1">
                                    Currently Working
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="saveExpBtn">
                            <span class="btn-text">Save</span>
                            <span class="btn-loader d-none">
                                <span class="spinner-border spinner-border-sm"></span>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addEducationBtn').addEventListener('click', function() {

            let form = document.getElementById('educationForm');

            form.reset();
            document.getElementById('education_id').value = '';

            let modal = new bootstrap.Modal(document.getElementById('educationModal'));
            modal.show();
        });
    </script>
    <script>
        $(document).on('click', '.edit-btn', function() {

            let btn = $(this);

            // Set values
            $("#education_id").val(btn.data('id'));
            $("#qualification").val(btn.data('qualification'));
            $("#qualification_area").val(btn.data('qualification_area')).trigger('change');
            $("#course").val(btn.data('course'));
            $("#institution_name").val(btn.data('institution_name'));
            $("#grade").val(btn.data('grade'));
            $("#remark").val(btn.data('remark'));
            $("#start_date").val(btn.data('start_date'));
            $("#end_date").val(btn.data('end_date'));
            // Open modal
            $("#educationModal").modal('show');
        });
    </script>
    <script>
        $(document).on('click', '.delete-btn', function() {
            let btn = $(this);
            let id = btn.data('id');
            let row = btn.closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to recover this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/employees/education-delete/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message || 'Record deleted successfully.',
                                    'success'
                                );
                                toastr.success(response.message || "Deleted successfully");
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || "Delete failed");
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $("#addExperienceBtn").click(function() {
            $("#experienceForm")[0].reset();
            $("#experience_id").val('');
            $("#experienceModal").modal('show');
        });
    </script>
    <script>
        $(document).on('click', '.edit-exp-btn', function() {

            let btn = $(this);

            $("#experience_id").val(btn.data('id'));
            $("#company").val(btn.data('company'));
            $("#designation").val(btn.data('designation'));
            $("#exp_start_date").val(btn.data('start_date'));
            $("#exp_end_date").val(btn.data('end_date'));

            $("#is_present").prop('checked', btn.data('is_present') == 1);

            $("#experienceModal").modal('show');
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#is_present").on("change", function() {

                if ($(this).is(":checked")) {
                    $("#exp_end_date")
                        .val('') // clear value
                        .prop("disabled", true) // disable field
                        .removeClass("is-invalid"); // remove validation error if any
                } else {
                    $("#exp_end_date").prop("disabled", false);
                }

            });

        });
    </script>
    <script>
        $(document).on('click', '.edit-exp-btn', function() {

            let isPresent = $(this).data('is_present');

            $("#is_present").prop('checked', isPresent == 1);

            $("#exp_end_date").val($(this).data('end_date'));

            // ✅ Apply logic again
            $("#is_present").trigger('change');

            $("#experienceModal").modal('show');
        });
    </script>
    <script>
        $("#experienceForm").submit(function(e) {
            e.preventDefault();

            let form = this;
            let btn = $("#saveExpBtn");
            let formData = new FormData(form);

            $(".error-text").remove();
            $(".is-invalid").removeClass("is-invalid");

            btn.prop("disabled", true);
            btn.find(".btn-text").addClass("d-none");
            btn.find(".btn-loader").removeClass("d-none");

            $.ajax({
                url: "<?php echo e(route('admin.employee.experience.update')); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    toastr.success(res.message);
                    $("#experienceModal").modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $("[name='" + field + "']");
                            if (field === 'is_present') {
                                input.closest('div').append(
                                    '<span class="text-danger error-text">' + messages[0] +
                                    '</span>'
                                );
                            } else {
                                input.addClass("is-invalid");

                                input.after(
                                    '<span class="text-danger error-text">' + messages[0] +
                                    '</span>'
                                );
                            }
                        });
                        toastr.error("Please fix validation errors");
                    }
                    if (xhr.status === 500) {
                        toastr.error(xhr.responseJSON?.message || "Server error");
                    }
                },
                complete: function() {
                    btn.prop("disabled", false);
                    btn.find(".btn-text").removeClass("d-none");
                    btn.find(".btn-loader").addClass("d-none");
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.delete-exp-btn', function() {

            let btn = $(this);
            let id = btn.data('id');
            let row = btn.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This record will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: '/admin/employees/experience-delete/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },

                        success: function(response) {

                            if (response.status) {

                                Swal.fire(
                                    'Deleted!',
                                    response.message || 'Deleted successfully',
                                    'success'
                                );

                                toastr.success(response.message || 'Deleted successfully');

                                // ✅ remove row without reload
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }
                        },

                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'Delete failed');
                        }
                    });
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $("#educationForm").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                let btn = $("#saveBtn");

                $(".error-text").remove();
                $(".is-invalid").removeClass("is-invalid");

                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".btn-loader").removeClass("d-none");

                $.ajax({
                    url: "<?php echo e(route('admin.employee.education.update')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message || "Saved successfully");
                            $("#educationModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                let input = $("[name='" + field + "']");
                                input.addClass("is-invalid");
                                if (input.hasClass("select2")) {
                                    input.next('.select2').after(
                                        '<span class="text-danger error-text">' +
                                        messages[0] + '</span>'
                                    );
                                } else {
                                    input.after(
                                        '<span class="text-danger error-text">' +
                                        messages[0] + '</span>'
                                    );
                                }
                            });
                            toastr.error("Please fix validation errors");
                        }
                        if (xhr.status === 500) {
                            toastr.error(xhr.responseJSON.message || "Server error");
                        }
                    },
                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".btn-loader").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script !src="">
        $('#uploadBtn').click(function() {
            $('#profileInput').click();
        });
        $('#profileInput').change(function() {
            let file = this.files[0];
            if (file) {
                $('#fileName').text(file.name);
            } else {
                $('#fileName').text('No file selected');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#EmployeeEditForm").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                let btn = $("#updateEmployeeBtn");

                $(".error-text").remove();
                $(".is-invalid").removeClass("is-invalid");

                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".btn-loader").removeClass("d-none");

                $.ajax({
                    url: "<?php echo e(route('admin.employees.profile.update')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            $("#editEmployeeModal").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                let input = $("[name='" + field + "']");
                                input.addClass("is-invalid");
                                input.after(
                                    '<span class="text-danger error-text">' +
                                    messages[0] +
                                    '</span>'
                                );
                            });
                            toastr.error("Please fix validation errors");
                        }
                        if (xhr.status === 500) {
                            toastr.error(xhr.responseJSON.message || "Server error");
                        }
                    },
                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".btn-loader").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#EditBasicForm").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                let btn = $("#updateBasicBtn");

                $(".error-text").remove();
                $(".is-invalid").removeClass("is-invalid");

                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".btn-loader").removeClass("d-none");

                $.ajax({
                    url: "<?php echo e(route('admin.employee.basic.update')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            $("#edit_basic_info").modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 800);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                let input = $("[name='" + field + "']");
                                input.addClass("is-invalid");
                                input.after(
                                    '<span class="text-danger error-text">' +
                                    messages[0] +
                                    '</span>'
                                );
                            });
                            toastr.error("Please fix validation errors");
                        }
                        if (xhr.status === 500) {
                            toastr.error(xhr.responseJSON.message || "Server error");
                        }
                    },
                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".btn-loader").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#EditPersonalForm").submit(function(e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                let btn = $("#updatePersonalBtn");

                $(".error-text").remove();
                $(".is-invalid").removeClass("is-invalid");

                btn.prop("disabled", true);
                btn.find(".btn-text").addClass("d-none");
                btn.find(".btn-loader").removeClass("d-none");

                $.ajax({
                    url: "<?php echo e(route('admin.employees.personal.update')); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            $("#edit_personal_info").modal('hide');
                            setTimeout(() => location.reload(), 800);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                let input = $("[name='" + field + "']");
                                input.addClass("is-invalid");
                                input.after(
                                    '<span class="text-danger error-text">' +
                                    messages[0] +
                                    '</span>'
                                );
                            });
                            toastr.error("Please fix validation errors");
                        }
                        if (xhr.status === 500) {
                            toastr.error(xhr.responseJSON.message || "Server error");
                        }
                    },
                    complete: function() {
                        btn.prop("disabled", false);
                        btn.find(".btn-text").removeClass("d-none");
                        btn.find(".btn-loader").addClass("d-none");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#EmergencyForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#emergencyBtn');

                // 🔹 Reset errors
                $('.is-invalid').removeClass('is-invalid');
                $('[class^="error-"]').text('');

                // 🔹 Show loader
                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.btn-loader').removeClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('admin.employee.emergency.update')); ?>",
                    type: "POST",
                    data: form.serialize(),

                    success: function(response) {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');
                        if (response.status) {
                            toastr.success(response.message);
                            $('#edit_emergency').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                let input = $("[name='" + field + "']");
                                input.addClass("is-invalid");

                                $('.error-' + field).text(messages[0]);
                            });
                            toastr.error("Please fix validation errors");
                        } else if (xhr.status === 500) {
                            toastr.error(xhr.responseJSON?.message || "Server error");
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });

            $('input').on('input', function() {
                $(this).removeClass('is-invalid');
                $('.error-' + $(this).attr('name')).text('');
            });

        });
    </script>
    <script>
        $(document).ready(function() {

            $('#AboutForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#aboutBtn');

                $('.is-invalid').removeClass('is-invalid');
                $('.error-about').text('');

                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.btn-loader').removeClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('admin.employee.about.update')); ?>",
                    type: "POST",
                    data: form.serialize(),

                    success: function(response) {

                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');

                        if (response.status) {
                            toastr.success(response.message);
                        }
                    },

                    error: function(xhr) {

                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.about) {
                                $('[name="about"]').addClass('is-invalid');
                                $('.error-about').text(errors.about[0]);
                            }
                            toastr.error("Please fix validation errors");
                        } else {
                            toastr.error("Something went wrong!");
                        }
                    }
                });
            });
            $('textarea[name="about"]').on('input', function() {
                $(this).removeClass('is-invalid');
                $('.error-about').text('');
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#jobInfoForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#jobBtn');

                // Reset errors
                $('.is-invalid').removeClass('is-invalid');
                $('[class^="error-"]').text('');

                // Loader
                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.btn-loader').removeClass('d-none');

                $.ajax({
                    url: "<?php echo e(route('admin.employee.job.info.update')); ?>",
                    type: "POST",
                    data: form.serialize(),
                    success: function(res) {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');
                        if (res.status) {
                            toastr.success(res.message);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, msg) {
                                let input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                $('.error-' + field).text(msg[0]);
                            });

                            toastr.error("Validation error");
                        } else {
                            toastr.error("Something went wrong");
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#bankForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = $('#bankBtn');

                // Reset errors
                $('.is-invalid').removeClass('is-invalid');
                $('[class^="error-"]').text('');

                // Loader
                btn.prop('disabled', true);
                btn.find('.btn-text').addClass('d-none');
                btn.find('.btn-loader').removeClass('d-none');
                $.ajax({
                    url: "<?php echo e(route('admin.employee.bank.update')); ?>",
                    type: "POST",
                    data: form.serialize(),
                    success: function(res) {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');
                        if (res.status) {
                            toastr.success(res.message);
                        }
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false);
                        btn.find('.btn-text').removeClass('d-none');
                        btn.find('.btn-loader').addClass('d-none');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, msg) {
                                let input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');
                                $('.error-' + field).text(msg[0]);
                            });
                            toastr.error("Validation error");
                        } else {
                            toastr.error("Something went wrong");
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $('#pfEsiForm').on('submit', function(e) {
            e.preventDefault();

            let btn = $('#pfEsiBtn');
            let formData = new FormData(this);

            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error-"]').text('');

            btn.prop('disabled', true);
            btn.find('.btn-text').addClass('d-none');
            btn.find('.btn-loader').removeClass('d-none');

            $.ajax({
                url: "<?php echo e(route('admin.employee.Pf.Esi.update')); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    btn.prop('disabled', false);
                    btn.find('.btn-text').removeClass('d-none');
                    btn.find('.btn-loader').addClass('d-none');
                    if (res.status) {
                        toastr.success(res.message);
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false);
                    btn.find('.btn-text').removeClass('d-none');
                    btn.find('.btn-loader').addClass('d-none');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, msg) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            $('.error-' + field).text(msg[0]);
                        });
                        toastr.error("Validation error");
                    } else {
                        toastr.error("Server error");
                    }
                }
            });
        });
    </script>
    <script>
        $('#addressForm').on('submit', function(e) {
            e.preventDefault();

            let btn = $('#addressBtn');
            let formData = $(this).serialize();

            $('.is-invalid').removeClass('is-invalid');
            $('[class^="error-"]').text('');

            btn.prop('disabled', true);
            btn.find('.btn-text').addClass('d-none');
            btn.find('.btn-loader').removeClass('d-none');
            $.ajax({
                url: "<?php echo e(route('admin.employee.address.update')); ?>",
                type: "POST",
                data: formData,
                success: function(res) {
                    btn.prop('disabled', false);
                    btn.find('.btn-text').removeClass('d-none');
                    btn.find('.btn-loader').addClass('d-none');
                    if (res.status) {
                        toastr.success(res.message || "Address updated successfully");
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false);
                    btn.find('.btn-text').removeClass('d-none');
                    btn.find('.btn-loader').addClass('d-none');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            $('.error-' + field).text(messages[0]);
                        });
                        toastr.error("Please fix validation errors");
                    }
                    if (xhr.status === 500) {
                        toastr.error(xhr.responseJSON.message || "Server error");
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            let selectedManager = "<?php echo e($employee->reporting_manager); ?>";

            $('#manager_designation').on('change', function() {
                let id = $(this).val();

                if (id) {
                    $.get("<?php echo e(route('admin.get.reporting.manager', ':id')); ?>".replace(':id', id),
                        function(
                            data) {

                            let html = '<option value="">Select</option>';

                            $.each(data, function(i, v) {
                                let selected = (v.id == selectedManager) ? 'selected' : '';
                                html +=
                                    `<option value="${v.id}" ${selected}>${v.name}</option>`;
                            });

                            $('#reporting_manager').html(html);
                        });
                }
            });

            // ✅ Trigger on page load
            $('#manager_designation').trigger('change');

            let dept = "<?php echo e($employee->department_id); ?>";
            let sub = "<?php echo e($employee->sub_department_id); ?>";

            function loadSub(deptId, selected = null) {
                if (!deptId) return;

                let url = "<?php echo e(route('admin.get.subdepartments', ':id')); ?>".replace(':id', deptId);

                $.get(url, function(data) {
                    let opt = '<option value="">Select</option>';

                    data.forEach(d => {
                        let isSelected = (d.id == selected) ? 'selected' : '';
                        opt += `<option value="${d.id}" ${isSelected}>${d.name}</option>`;
                    });

                    $('#sub_department').html(opt);
                });
            }

            // ✅ Load on edit
            if (dept) {
                loadSub(dept, sub);
            }

            // ✅ Change event
            $('#department').change(function() {
                loadSub($(this).val());
            });

        });

        $('#sameAddress').on('change', function() {
            if ($(this).is(':checked')) {
                $('[name="permanent_address"]').val($('[name="present_address"]').val());
                $('[name="permanent_city"]').val($('[name="present_city"]').val());
                $('[name="permanent_state"]').val($('[name="present_state"]').val());
                $('[name="permanent_country"]').val($('[name="present_country"]').val());
                $('[name="permanent_pincode"]').val($('[name="present_pincode"]').val());
            } else {
                $('[name^="permanent_"]').val('');
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/employees/view.blade.php ENDPATH**/ ?>