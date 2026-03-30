@extends('admin.layout.main-layout')

@section('content')
<div class="content">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit ID Card Template</h5>
            <a href="{{ route('admin.id.card.template.index') }}" class="btn btn-secondary btn-sm">
                <i class="ti ti-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.id.card.template.update', $template->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- remove if your route expects POST --}}

                {{-- Template Name --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Template Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $template->name) }}" required>
                </div>

                {{-- Available Placeholders --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Available Placeholders</label>

                    {{-- Company --}}
                    <div class="mb-2">
                        <small class="text-uppercase fw-bold text-muted"
                               style="font-size:10px; letter-spacing:1px;">
                            <i class="ti ti-building me-1"></i> Company Info
                        </small>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @php
                            $companyPlaceholders = [
                                '{company_name}'    => 'Company Name',
                                '{company_phone}'   => 'Company Phone',
                                '{company_address}' => 'Company Address',
                                '{company_logo}'    => 'Company Logo',
                            ];
                            @endphp
                            @foreach($companyPlaceholders as $key => $label)
                            <span class="badge border"
                                  style="cursor:pointer;font-size:12px;padding:6px 10px;
                                         background:#fff3e0;color:#e65100;border-color:#ffcc80 !important;"
                                  onclick="insertPlaceholder('{{ $key }}')"
                                  title="{{ $key }}">
                                <i class="ti ti-building me-1" style="font-size:10px;"></i>{{ $label }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Employee --}}
                    <div class="mb-2">
                        <small class="text-uppercase fw-bold text-muted"
                               style="font-size:10px; letter-spacing:1px;">
                            <i class="ti ti-user me-1"></i> Employee Info
                        </small>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            @php
                            $employeePlaceholders = [
                                '{name}'              => 'Name',
                                '{employee_code}'     => 'Emp Code',
                                '{email}'             => 'Email',
                                '{phone}'             => 'Phone',
                                '{gender}'            => 'Gender',
                                '{dob}'               => 'Date of Birth',
                                '{joining_date}'      => 'Joining Date',
                                '{designation}'       => 'Designation',
                                '{department}'        => 'Department',
                                '{site_name}'         => 'Site Name',
                                '{blood_group}'       => 'Blood Group',
                                '{profile_image}'     => 'Profile Photo',
                                '{emergency_phone_1}' => 'Emergency Phone',
                                '{date}'              => 'Current Date',
                            ];
                            @endphp
                            @foreach($employeePlaceholders as $key => $label)
                            <span class="badge border"
                                  style="cursor:pointer;font-size:12px;padding:6px 10px;
                                         background:#e8f0fe;color:#1a3c5e;border-color:#b0c8f0 !important;"
                                  onclick="insertPlaceholder('{{ $key }}')"
                                  title="{{ $key }}">
                                <i class="ti ti-user me-1" style="font-size:10px;"></i>{{ $label }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <small class="text-muted mt-1 d-block">
                        <i class="ti ti-info-circle me-1"></i>
                        Click any placeholder to insert it at cursor position in the editor.
                    </small>
                </div>

                {{-- Preview Controls --}}
                <div class="card border mb-3" style="background:#f8fafc;">
                    <div class="card-body py-3">
                        <label class="form-label fw-semibold mb-2">
                            <i class="ti ti-eye me-1"></i> Preview with Real Employee Data
                        </label>
                        <div class="row align-items-end g-2">



                            <div class="col-md-2">
                                <label class="form-label mb-1" style="font-size:12px;">Search</label>
                                <input type="text" id="searchEmployee"
                                       class="form-control form-control-sm"
                                       placeholder="Name or Code...">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1" style="font-size:12px;">Select Employee</label>
                                <select id="previewEmployee" class="form-select form-select-sm">
                                    <option value="">-- Use Dummy Data --</option>
                                    @foreach($Users as $emp)
                                    <option value="{{ $emp->id }}"
                                        data-name="{{ $emp->name }}"
                                        data-code="{{ $emp->employee_code }}"
                                        data-email="{{ $emp->email }}"
                                        data-phone="{{ $emp->phone }}"
                                        data-gender="{{ $emp->gender }}"
                                        data-dob="{{ $emp->dob }}"
                                        data-joining="{{ $emp->joining_date }}"
                                        data-designation="{{ optional($emp->designation)->name }}"
                                        data-department="{{ optional($emp->department)->name }}"
                                        data-site="{{$sites->company_name}}"
                                        data-blood-group="{{ optional($emp->bloodGroup)->name }}"
                                        data-emergency-phone1="{{ $emp->emergency_phone_1 }}"
                                        data-profile-image="{{ $emp->profile_image ? asset( $emp->profile_image) : '' }}"
                                        data-company-name="{{ $sites->company_name}}"
                                        data-company-phone="{{ $sites->phone }}"
                                        data-company-address="{{ $sites->address }}"
                                        data-company-logo="{{ asset($sites->company_logo) ?? '' }}">
                                        {{ $emp->employee_code }} - {{ $emp->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 d-flex gap-2">
                                <button type="button" class="btn btn-info btn-sm" id="previewBtn">
                                    <i class="ti ti-eye me-1"></i> Preview
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" id="resetPreviewBtn">
                                    <i class="ti ti-refresh me-1"></i> Reset
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Template Content --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Template Content (HTML)</label>
                    <textarea name="content" id="templateContent" class="form-control"
                              rows="25"
                              style="font-family:monospace; font-size:13px;">{{ old('content', $template->content) }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Save Template
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>



<script>
    // Global so badges can call it
    function insertPlaceholder(placeholder) {
        const textarea = document.getElementById('templateContent');
        const start    = textarea.selectionStart;
        const end      = textarea.selectionEnd;
        const text     = textarea.value;
        textarea.value = text.substring(0, start) + placeholder + text.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + placeholder.length;
        textarea.focus();
    }

    function filterEmployeeDropdown() {
        const siteFilter   = (document.getElementById('filterSite').value || '').toLowerCase();
        const searchFilter = (document.getElementById('searchEmployee').value || '').toLowerCase();
        const select       = document.getElementById('previewEmployee');
        const options      = Array.from(select.options);

        options.forEach(opt => {
            if (!opt.value) return; // skip dummy option
            const site        = (opt.getAttribute('data-site') || '').toLowerCase();
            const text        = (opt.text || '').toLowerCase();
            const siteMatch   = !siteFilter || site.includes(siteFilter);
            const searchMatch = !searchFilter || text.includes(searchFilter);
            opt.style.display = (siteMatch && searchMatch) ? '' : 'none';
        });

        select.value = ''; // reset selection after filtering
    }

    document.addEventListener('DOMContentLoaded', function () {
        const filterSiteInput      = document.getElementById('filterSite');
        const searchEmployeeInput  = document.getElementById('searchEmployee');
        const resetPreviewBtn      = document.getElementById('resetPreviewBtn');
        const previewEmployeeInput = document.getElementById('previewEmployee');
        const previewBtn           = document.getElementById('previewBtn');

        if (filterSiteInput) {
            filterSiteInput.addEventListener('change', filterEmployeeDropdown);
        }
        if (searchEmployeeInput) {
            searchEmployeeInput.addEventListener('input', filterEmployeeDropdown);
        }
        if (resetPreviewBtn) {
            resetPreviewBtn.addEventListener('click', function () {
                if (previewEmployeeInput) previewEmployeeInput.value = '';
                if (filterSiteInput) filterSiteInput.value = '';
                if (searchEmployeeInput) searchEmployeeInput.value = '';
                filterEmployeeDropdown();
            });
        }

        if (previewBtn) {
            previewBtn.addEventListener('click', function () {
                const contentEl = document.getElementById('templateContent');
                const selectEl  = document.getElementById('previewEmployee');
                const content   = contentEl ? contentEl.value : '';
                const opt       = selectEl && selectEl.selectedIndex >= 0 ? selectEl.options[selectEl.selectedIndex] : null;

                let data = {};
                if (selectEl && selectEl.value && opt && opt.value) {
                    data = {
                        'name'              : opt.getAttribute('data-name')          || '',
                        'employee_code'     : opt.getAttribute('data-code')          || '',
                        'email'             : opt.getAttribute('data-email')         || '',
                        'phone'             : opt.getAttribute('data-phone')         || '',
                        'gender'            : opt.getAttribute('data-gender')        || '',
                        'dob'               : opt.getAttribute('data-dob')           || '',
                        'joining_date'      : opt.getAttribute('data-joining')       || '',
                        'designation'       : opt.getAttribute('data-designation')   || '',
                        'department'        : opt.getAttribute('data-department')    || '',
                        'site_name'         : opt.getAttribute('data-site')          || '',
                        'blood_group'       : opt.getAttribute('data-blood-group')   || '',
                        'emergency_phone_1' : opt.getAttribute('data-emergency-phone1') || '',
                        'profile_image'     : opt.getAttribute('data-profile-image')
                                                ? '<img src="' + opt.getAttribute('data-profile-image') + '" style="width:100%;height:100%;object-fit:cover;" alt="Photo">'
                                                : '<div style="width:100%;height:100%;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:30px;">👤</div>',
                        'company_name'      : opt.getAttribute('data-company-name')    || '',
                        'company_phone'     : opt.getAttribute('data-company-phone')   || '',
                        'company_address'   : opt.getAttribute('data-company-address') || '',
                        'company_logo'      : opt.getAttribute('data-company-logo')
                                                ? '<img src="' + opt.getAttribute('data-company-logo') + '" style="max-height:60px;" alt="Logo">'
                                                : '',
                    };
                } else {
                    // Dummy data fallback
                    data = {
                        'name'              : 'John Doe',
                        'employee_code'     : 'EMP-001',
                        'email'             : 'john@example.com',
                        'phone'             : '+91-9999999999',
                        'gender'            : 'Male',
                        'dob'               : '01 Jan, 1995',
                        'joining_date'      : '01 Apr, 2025',
                        'designation'       : 'Software Engineer',
                        'department'        : 'IT Department',
                        'site_name'         : 'Head Office',
                        'blood_group'       : 'B+',
                        'emergency_phone_1' : '+91-8888888888',
                        'profile_image'     : '<div style="width:100%;height:100%;background:#ddd;display:flex;align-items:center;justify-content:center;font-size:30px;">👤</div>',
                        'company_name'      : 'YOUR COMPANY NAME',
                        'company_phone'     : '+91-XXXXXXXXXX',
                        'company_address'   : '123, Business Park, Mumbai',
                        'company_logo'      : '',
                    };
                }

                // Override company/site info using selected site from site settings
                const siteOption = filterSiteInput && filterSiteInput.selectedIndex >= 0
                    ? filterSiteInput.options[filterSiteInput.selectedIndex]
                    : null;

                if (siteOption && siteOption.value) {
                    const siteName = siteOption.getAttribute('data-company-name') || siteOption.value;
                    const sitePhone = siteOption.getAttribute('data-phone') || '';
                    const siteAddress = siteOption.getAttribute('data-address') || '';

                    data.site_name = siteName;
                    data.company_name = siteName;

                    if (sitePhone) {
                        data.company_phone = sitePhone;
                    }
                    if (siteAddress) {
                        data.company_address = siteAddress;
                    }
                }

                // Replace placeholders
                let preview = content;
                for (let key in data) {
                    const escaped = key.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const regex   = new RegExp('\\{' + escaped + '\\}', 'g');
                    preview       = preview.replace(regex, data[key] || '');
                }

                // Replace {date}
                const today = new Date().toLocaleDateString('en-IN', {
                    day: '2-digit', month: 'short', year: 'numeric'
                });
                preview = preview.replace(/\{date\}/g, today);

                // Open preview window
                const win = window.open('', '_blank', 'width=500,height=700');
                win.document.write(
                    '<!DOCTYPE html><html><head>'
                    + '<title>ID Card Preview - ' + (data['name'] || 'Preview') + '</title>'
                    + '<style>'
                    + '* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }'
                    + 'body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; display:flex; justify-content:center; }'
                    + 'table { border-collapse: collapse; }'
                    + 'td { border: none; }'
                    + '</style>'
                    + '</head><body>' + preview + '</body></html>'
                );
                win.document.close();
            });
        }
    });
</script>
@endsection
