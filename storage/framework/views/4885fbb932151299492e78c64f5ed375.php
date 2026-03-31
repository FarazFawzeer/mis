

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.partials.page-title', ['title' => 'Employees', 'subtitle' => 'Profile'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
        .employee-view-page .main-card,
        .employee-view-page .section-card,
        .employee-view-page .summary-card,
        .employee-view-page .dynamic-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            background: #fff;
            box-shadow: none;
        }

        .employee-view-page .main-card .card-header,
        .employee-view-page .section-card .card-header,
        .employee-view-page .dynamic-card .card-header {
            background: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 16px 20px;
        }

        .employee-view-page .main-card .card-body,
        .employee-view-page .section-card .card-body,
        .employee-view-page .dynamic-card .card-body {
            padding: 20px;
        }

        .employee-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .employee-topbar-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .profile-hero {
            border: 1px solid rgba(0, 0, 0, 0.07);
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 22px;
            background: #fff;
        }

        .profile-name {
            font-size: 26px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .profile-meta {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .profile-meta strong {
            color: #212529;
            font-weight: 600;
        }

        .status-badge-clean {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .status-badge-clean.active {
            color: #198754;
            background: rgba(25, 135, 84, 0.08);
            border-color: rgba(25, 135, 84, 0.18);
        }

        .status-badge-clean.inactive {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.08);
            border-color: rgba(220, 53, 69, 0.18);
        }

        .summary-card {
            padding: 16px 18px;
            height: 100%;
        }

        .summary-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: 700;
            color: #212529;
            line-height: 1.4;
            word-break: break-word;
        }

        .section-heading {
            font-size: 15px;
            font-weight: 700;
            color: #212529;
            margin: 0;
        }

        .section-subtext {
            font-size: 13px;
            color: #6c757d;
            margin-top: 4px;
            margin-bottom: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 14px;
        }

        .info-item {
            grid-column: span 4;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 14px 16px;
            min-height: 84px;
            background: #fff;
        }

        .info-item.span-6 {
            grid-column: span 6;
        }

        .info-item.span-8 {
            grid-column: span 8;
        }

        .info-item.span-12 {
            grid-column: span 12;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.35px;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
            line-height: 1.5;
            word-break: break-word;
        }

        .remarks-box {
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 16px;
            min-height: 90px;
            background: #fff;
            color: #212529;
            line-height: 1.7;
            white-space: pre-line;
        }

        .checklist-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 12px;
        }

        .checklist-item {
            grid-column: span 3;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 14px 14px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            min-height: 64px;
        }

        .checklist-name {
            font-size: 13px;
            font-weight: 600;
            color: #212529;
        }

        .check-badge {
            min-width: 54px;
            text-align: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .check-badge.yes {
            color: #198754;
            background: rgba(25, 135, 84, 0.08);
            border: 1px solid rgba(25, 135, 84, 0.15);
        }

        .check-badge.no {
            color: #6c757d;
            background: #f8f9fa;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .dynamic-list {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 14px;
        }

        .dynamic-item {
            grid-column: span 6;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 12px;
            padding: 14px 16px;
            background: #fff;
        }

        .dynamic-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.35px;
            margin-bottom: 6px;
        }

        .dynamic-value {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
            line-height: 1.6;
            word-break: break-word;
        }

        .empty-state-clean {
            border: 1px dashed rgba(0, 0, 0, 0.12);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            color: #6c757d;
            background: #fcfcfc;
        }

        @media (max-width: 991px) {
            .info-item,
            .info-item.span-6,
            .info-item.span-8,
            .checklist-item,
            .dynamic-item {
                grid-column: span 6;
            }
        }

        @media (max-width: 767px) {
            .profile-name {
                font-size: 22px;
            }

            .info-item,
            .info-item.span-6,
            .info-item.span-8,
            .info-item.span-12,
            .checklist-item,
            .dynamic-item {
                grid-column: span 12;
            }
        }
    </style>

    <div class="employee-view-page">
        <div class="card main-card mb-4">
            <div class="card-header">
                <div class="employee-topbar">
                    <h5 class="card-title mb-0">Employee Profile</h5>

                    <div class="employee-topbar-actions">
                        <a href="<?php echo e(route('admin.employees.edit', $employee->id)); ?>" class="btn btn-warning btn-sm" style="width: 150px;">
                            Edit Employee
                        </a>
                        <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-light btn-sm" style="width: 150px;">
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                
                <div class="profile-hero">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <div class="profile-name"><?php echo e($employee->full_name ?? '-'); ?></div>

                            <div class="profile-meta">
                                Employee No: <strong><?php echo e($employee->employee_no ?? '-'); ?></strong>
                            </div>

                            <div class="profile-meta">
                                <?php echo e($employee->designation ?? 'No Designation'); ?>

                                <?php if($employee->department): ?>
                                    • <?php echo e($employee->department); ?>

                                <?php endif; ?>
                            </div>

                            <div class="profile-meta">
                                <?php if($employee->service_number): ?>
                                    Service No: <strong><?php echo e($employee->service_number); ?></strong>
                                <?php endif; ?>

                                <?php if($employee->rank): ?>
                                    <?php if($employee->service_number): ?> • <?php endif; ?>
                                    Rank: <strong><?php echo e($employee->rank); ?></strong>
                                <?php endif; ?>

                                <?php if($employee->site_location): ?>
                                    <?php if($employee->service_number || $employee->rank): ?> • <?php endif; ?>
                                    Site: <strong><?php echo e($employee->site_location); ?></strong>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-lg-4 text-lg-end">
                            <?php if($employee->status == 'Active'): ?>
                                <span class="status-badge-clean active">Active</span>
                            <?php else: ?>
                                <span class="status-badge-clean inactive">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="summary-card">
                            <div class="summary-label">Phone</div>
                            <div class="summary-value"><?php echo e($employee->phone ?? '-'); ?></div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="summary-card">
                            <div class="summary-label">Email</div>
                            <div class="summary-value"><?php echo e($employee->email ?? '-'); ?></div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="summary-card">
                            <div class="summary-label">Join Date</div>
                            <div class="summary-value"><?php echo e(optional($employee->join_date)->format('Y-m-d') ?? '-'); ?></div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="summary-card">
                            <div class="summary-label">Salary</div>
                            <div class="summary-value">
                                <?php echo e($employee->salary !== null ? number_format($employee->salary, 2) : '-'); ?>

                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Basic Employee Details</h6>
                        <p class="section-subtext">Core employee identification and contact details.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Employee Number</div>
                                <div class="info-value"><?php echo e($employee->employee_no ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Full Name</div>
                                <div class="info-value"><?php echo e($employee->full_name ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Name With Initials</div>
                                <div class="info-value"><?php echo e($employee->name_with_initials ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">NIC</div>
                                <div class="info-value"><?php echo e($employee->nic ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Phone</div>
                                <div class="info-value"><?php echo e($employee->phone ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value"><?php echo e($employee->email ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Record Information</h6>
                        <p class="section-subtext">System and employment record details.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Record Date</div>
                                <div class="info-value"><?php echo e(optional($employee->rec_date)->format('Y-m-d') ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Join Date</div>
                                <div class="info-value"><?php echo e(optional($employee->join_date)->format('Y-m-d') ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <?php if($employee->status == 'Active'): ?>
                                        <span class="status-badge-clean active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge-clean inactive">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Personal Information</h6>
                        <p class="section-subtext">Personal profile and location-related details.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Date of Birth</div>
                                <div class="info-value"><?php echo e(optional($employee->dob)->format('Y-m-d') ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Age</div>
                                <div class="info-value"><?php echo e($employee->age ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">District</div>
                                <div class="info-value"><?php echo e($employee->district ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">GS Division</div>
                                <div class="info-value"><?php echo e($employee->gs_division ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Police Station</div>
                                <div class="info-value"><?php echo e($employee->police_station ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Nationality</div>
                                <div class="info-value"><?php echo e($employee->nationality ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Religion</div>
                                <div class="info-value"><?php echo e($employee->religion ?? '-'); ?></div>
                            </div>

                            <div class="info-item span-8">
                                <div class="info-label">Address</div>
                                <div class="info-value"><?php echo e($employee->address ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Job Information</h6>
                        <p class="section-subtext">Official job, site, and department details.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Service Number</div>
                                <div class="info-value"><?php echo e($employee->service_number ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Rank</div>
                                <div class="info-value"><?php echo e($employee->rank ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Site / Location</div>
                                <div class="info-value"><?php echo e($employee->site_location ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">VO</div>
                                <div class="info-value"><?php echo e($employee->vo ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Department</div>
                                <div class="info-value"><?php echo e($employee->department ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Designation</div>
                                <div class="info-value"><?php echo e($employee->designation ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Close Relation / Emergency</h6>
                        <p class="section-subtext">Emergency contact and relationship details.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Close Relation</div>
                                <div class="info-value"><?php echo e($employee->close_relation ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Relationship</div>
                                <div class="info-value"><?php echo e($employee->relationship ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">CR Contact</div>
                                <div class="info-value"><?php echo e($employee->cr_contact ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Education & Experience</h6>
                        <p class="section-subtext">Academic background and work experience information.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Education</div>
                                <div class="info-value"><?php echo e($employee->education ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Other Qualification</div>
                                <div class="info-value"><?php echo e($employee->other_qualification ?? '-'); ?></div>
                            </div>

                            <div class="info-item span-6">
                                <div class="info-label">Previous Experience</div>
                                <div class="info-value"><?php echo e($employee->previous_experience ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Period</div>
                                <div class="info-value"><?php echo e($employee->experience_period ?? '-'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Bank & Salary Information</h6>
                        <p class="section-subtext">Payroll and bank account details.</p>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Bank Name</div>
                                <div class="info-value"><?php echo e($employee->bank_name ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Account Number</div>
                                <div class="info-value"><?php echo e($employee->account_number ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Branch</div>
                                <div class="info-value"><?php echo e($employee->branch ?? '-'); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Salary</div>
                                <div class="info-value">
                                    <?php echo e($employee->salary !== null ? number_format($employee->salary, 2) : '-'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-4">
                    <div class="card-header">
                        <h6 class="section-heading">Document / Compliance Checklist</h6>
                        <p class="section-subtext">Quick status of employee document availability.</p>
                    </div>
                    <div class="card-body">
                        <div class="checklist-grid">
                            <?php
                                $documents = [
                                    'M/UM' => $employee->doc_m_um,
                                    'Pension' => $employee->doc_pension,
                                    'I.AL' => $employee->doc_i_al,
                                    '2.CA' => $employee->doc_2_ca,
                                    '3.WCL' => $employee->doc_3_wcl,
                                    '4.NIC C' => $employee->doc_4_nic_c,
                                    '5.BC' => $employee->doc_5_bc,
                                    '6.GNC' => $employee->doc_6_gnc,
                                    '7.PR' => $employee->doc_7_pr,
                                    '8.EC' => $employee->doc_8_ec,
                                    '9.QC' => $employee->doc_9_qc,
                                    '10.CHC' => $employee->doc_10_chc,
                                    '11.PO' => $employee->doc_11_po,
                                    '12.FP' => $employee->doc_12_fp,
                                    '13.B/A' => $employee->doc_13_ba,
                                ];
                            ?>

                            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docLabel => $docValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="checklist-item">
                                    <div class="checklist-name"><?php echo e($docLabel); ?></div>
                                    <div class="check-badge <?php echo e($docValue ? 'yes' : 'no'); ?>">
                                        <?php echo e($docValue ? 'Yes' : 'No'); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card section-card mb-0">
                    <div class="card-header">
                        <h6 class="section-heading">Remarks</h6>
                        <p class="section-subtext">Additional notes related to this employee.</p>
                    </div>
                    <div class="card-body">
                        <div class="remarks-box">
                            <?php echo e($employee->remarks ?? '-'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mb-3">
            <h5 class="mb-0">Dynamic Sections</h5>
            <p class="text-muted mb-0 mt-1" style="font-size: 13px;">
                Additional custom employee details added through dynamic sections.
            </p>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $employee->detailSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card dynamic-card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"><?php echo e($section->section_title); ?></h6>
                </div>

                <div class="card-body">
                    <?php if($section->fields->count()): ?>
                        <div class="dynamic-list">
                            <?php $__currentLoopData = $section->fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="dynamic-item">
                                    <div class="dynamic-label"><?php echo e($field->field_label); ?></div>
                                    <div class="dynamic-value"><?php echo e($field->field_value ?? '-'); ?></div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state-clean">
                            No details added in this section.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="card dynamic-card">
                <div class="card-body">
                    <div class="empty-state-clean">
                        No dynamic sections added for this employee.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vertical', ['subtitle' => 'Employee View'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Personal Projects\Infotech\mis\resources\views/backend/pages/employees/show.blade.php ENDPATH**/ ?>