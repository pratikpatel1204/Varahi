<?php $__env->startSection('title', config('app.name') . ' || Profile Details'); ?>
<?php $__env->startSection('content'); ?>
    <div class="content">
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
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6>Basic information</h6>
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
                                        <?php echo e(optional($employee->profile)->about); ?>

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
                                            <div class="row g-3">
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Confirmation Date</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->confirmation_date ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Planned Join Date</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->planned_join_date ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Joined On</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->joined_on ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Probation (Months)</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->probation_period ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Notice Period (Months)</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->notice_period ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Previous Exp (Years)</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->previous_experience ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="p-3 border rounded h-100">
                                                        <span class="text-dark">Total Exp (Years)</span>
                                                        <div class="fw-semibold">
                                                            <?php echo e(optional($employee->profile)->total_experience ?? 'N/A'); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <div class="row g-3">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Bank Name</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->bank_name ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Branch</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->branch ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">IFSC</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->ifsc_code ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Account No</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->account_number ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Account Holder</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->account_holder_name ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <h6 class="mb-3 fw-bold">PF Information</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">UAN / PF Member ID</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->uan_number ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">PF Account Number</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_account_number ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">PF Applicable</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_applicable ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">PF Join Date</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_join_date ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">PF Exit Date</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_exit_date ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Contribution Type</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_contribution_type ?? 'Full Wages'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Name as per PF</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_name ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">DOB (PF)</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_dob ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">PF Document</span>
                                                    <div class="fw-semibold">
                                                        <?php if($employee->profile?->pf_document): ?>
                                                            <a href="<?php echo e(asset($employee->profile->pf_document)); ?>"
                                                                target="_blank">
                                                                View Document
                                                            </a>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Previous PF Details</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->pf_previous_details ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="mb-3 fw-bold">ESI Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">ESIC Number</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->esic_number ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">ESIC Applicable</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->esic_applicable ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Join Date</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->esic_join_date ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Exit Date</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->esic_exit_date ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Name (ESIC)</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->esic_name ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">DOB (ESIC)</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->esic_dob ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                            <div class="row g-3">
                                                <?php if($education && $education->count()): ?>
                                                    <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $educ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-md-12">
                                                            <div class="border rounded p-3 h-100 shadow-sm">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                    <h5 class="mb-0 fw-bold text-primary"><?php echo e($educ->qualification); ?></h5>
                                                                    <?php if($educ->document): ?>
                                                                        <a href="<?php echo e(asset($educ->document)); ?>"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-outline-primary">
                                                                            <i class="ti ti-eye"></i>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="row g-2">
                                                                    <div class="col-4">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Area</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->qualification_area ?? '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Course</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->course ?? '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Institute</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->institution_name ?? '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>                                                                                                                                      
                                                                    <div class="col-4">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Grade</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->grade ?? '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>                                                                                                                                                                                                       
                                                                    <div class="col-4">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">From</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->start_date ? \Carbon\Carbon::parse($educ->start_date)->format('d M Y') : '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>         
                                                                    <div class="col-4">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">To</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->end_date ? \Carbon\Carbon::parse($educ->end_date)->format('d M Y') : '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>                                                                                                                                                                                                                                                                                                                                           
                                                                    <div class="col-12">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Remark</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($educ->remark ?? '-'); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="col-12">
                                                        <div class="text-center text-muted py-4">
                                                            No education records found
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
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
                                            <div class="row g-3">
                                                <?php if($experience && $experience->count()): ?>
                                                    <?php $__currentLoopData = $experience; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-md-12">
                                                            <div class="border rounded p-3 h-100 shadow-sm bg-white">                                                               
                                                                <div class="row g-2 mt-2">
                                                                    <div class="col-6">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Company</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($exp->company); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>                                                                      
                                                                    <div class="col-6">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">Designation</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($exp->designation); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>                                                                      
                                                                    <div class="col-6">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">From</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e(\Carbon\Carbon::parse($exp->start_date)->format('d M Y')); ?>

                                                                            </div>
                                                                        </div>                                                                      
                                                                    </div>                                                                      
                                                                    <div class="col-6">
                                                                        <div class="p-3 border rounded h-100">
                                                                            <span class="text-dark">To</span>
                                                                            <div class="fw-semibold">
                                                                                <?php echo e($exp->is_present ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('d M Y')); ?>

                                                                            </div>
                                                                        </div>                                                                          
                                                                    </div>                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div class="col-12">
                                                        <div class="text-center text-muted py-4">
                                                            No experience records found
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
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
                                            <div class="d-flex">
                                                <a href="#"
                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseaddress">
                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseaddress" class="accordion-collapse collapse border-top"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h6 class="mb-3 fw-bold">Present Address</h6>
                                        <div class="row g-3 mb-4">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">City</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->present_city ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">State</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->present_state ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Country</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->present_country ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Pincode</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->present_pincode ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Address</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->present_address ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="mb-3 fw-bold">Permanent Address</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">City</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->permanent_city ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">State</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->permanent_state ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Country</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->permanent_country ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Pincode</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->permanent_pincode ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="p-3 border rounded h-100">
                                                    <span class="text-dark">Address</span>
                                                    <div class="fw-semibold">
                                                        <?php echo e(optional($employee->profile)->permanent_address ?? 'N/A'); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/employees/profile_details.blade.php ENDPATH**/ ?>