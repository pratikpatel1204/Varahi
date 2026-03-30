<?php $__env->startSection('content'); ?>
<div class="content">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-end flex-wrap">

            <div class="d-flex align-items-end flex-wrap">
                <div class="me-2 mb-2">
                    <label>Choose Site</label>
                    <select id="site_filter" class="form-select">
                        <option value="">All Sites</option>
                        <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($site->id); ?>"><?php echo e($site->company_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="me-2 mb-2">
                    <label>Search Employee</label>
                    <input type="text" id="employee_search" class="form-control"
                           placeholder="Search by code, name, email, phone...">
                </div>
                <div class="me-2 mb-2">
                    <button id="filterBtn" class="btn btn-info">
                        <i class="ti ti-filter"></i> Filter
                    </button>
                </div>
                <div class="me-2 mb-2">
                    <button id="resetBtn" class="btn btn-danger">
                        <i class="ti ti-refresh me-1"></i> Reset
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-end flex-wrap">
                <div class="mb-2">
                    <button id="generateBtn" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-credit-card me-2"></i>
                        Generate ID Card
                        <span id="selectedCount" class="badge bg-white text-primary ms-2">0</span>
                    </button>
                </div>
            </div>

        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="idCardTable">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>S.No</th>
                            <th>Emp ID</th>
                            <th>Site Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {

    let table = $('#idCardTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: {
            url: "<?php echo e(route('admin.id.cards.ajaxWithout')); ?>",
            type: "POST",
            data: function (d) {
                d._token          = "<?php echo e(csrf_token()); ?>";
                d.site            = $('#site_filter').val();
                d.employee_search = $('#employee_search').val();
            }
        },
        columns: [
            { data: null, orderable: false, searchable: false,
              render: function (data) { return `<input type="checkbox" class="emp-checkbox" value="${data.id}">`; }},
            { data: null, orderable: false, searchable: false,
              render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }},
            { data: 'employee_code', name: 'employee_code' },
            { data: 'company_name' },
            { data: 'designation',   name: 'designation' },
            { data: 'department',    name: 'department' },
            { data: 'name',          name: 'name' },
            { data: 'email',         name: 'email' },
            { data: 'phone',         name: 'phone' },
        ],
        order: [[1, 'asc']]
    });

    let selectedIds = new Set();

    $('#idCardTable tbody').on('change', '.emp-checkbox', function () {
        let id = $(this).val();
        $(this).is(':checked') ? selectedIds.add(id) : selectedIds.delete(id);
        updateBtn();
    });

    $('#select-all').on('change', function () {
        let checked = $(this).is(':checked');
        $('#idCardTable tbody .emp-checkbox').each(function () {
            $(this).prop('checked', checked);
            checked ? selectedIds.add($(this).val()) : selectedIds.delete($(this).val());
        });
        updateBtn();
    });

    table.on('draw', function () {
        $('#idCardTable tbody .emp-checkbox').each(function () {
            if (selectedIds.has($(this).val())) $(this).prop('checked', true);
        });
    });

    function updateBtn() {
        let count = selectedIds.size;
        $('#selectedCount').text(count);
        $('#generateBtn').prop('disabled', count === 0);
    }

    $('#filterBtn').on('click', function () { table.ajax.reload(); });

    $('#resetBtn').on('click', function () {
        $('#site_filter').val('');
        $('#employee_search').val('');
        selectedIds.clear();
        updateBtn();
        table.search('').columns().search('').draw();
    });

    $('#generateBtn').on('click', function () {
        if (selectedIds.size === 0) {
            Swal.fire('Warning', 'Please select at least one employee.', 'warning');
            return;
        }

        Swal.fire({ title: 'Generating...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: "<?php echo e(route('admin.id.cards.generate')); ?>",
            type: "GET",
            data: { ids: Array.from(selectedIds) },
            success: function (response) {
                Swal.close();

                if (!response.cards || response.cards.length === 0) {
                    Swal.fire('Error', 'No ID cards generated.', 'error');
                    return;
                }

                openPrintWindow(response.cards);
                selectedIds.clear();
                updateBtn();
                table.ajax.reload();
            },
            error: function (xhr) {
                Swal.close();
                Swal.fire('Error', xhr.responseJSON?.error ?? 'Failed', 'error');
            }
        });
    });

function openPrintWindow(cards) {
    let printContent = `<!DOCTYPE html><html><head><title>ID Cards</title>
        <style>
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                box-sizing: border-box;
            }
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
                background: #fff;
            }
            .cards-grid {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            .card-wrapper {
                width: 320px;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            @media print {
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                @page {
                    size: A4;
                    margin: 15mm;
                }
                body {
                    margin: 0;
                    padding: 0;
                }
                .cards-grid {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 15px;
                }
                .card-wrapper {
                    width: 320px;
                    page-break-inside: avoid;
                    break-inside: avoid;
                }
            }
        </style></head><body>
        <div class="cards-grid">`;

    cards.forEach(function (card) {
        printContent += `<div class="card-wrapper">${card}</div>`;
    });

    printContent += `</div></body></html>`;

    let win = window.open('', '_blank', 'width=1000,height=800');
    win.document.write(printContent);
    win.document.close();
    win.onload = function () { win.focus(); win.print(); };
}
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.main-layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Varahi\resources\views/admin/id_cards/index.blade.php ENDPATH**/ ?>