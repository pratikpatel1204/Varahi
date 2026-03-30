@extends('admin.layout.main-layout')

@section('content')
<div class="content">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-end flex-wrap">

            {{-- LEFT: Filters --}}
            <div class="d-flex align-items-end flex-wrap">

                <div class="me-2 mb-2">
                    <label>Choose Site</label>
                    <select id="site_filter" class="form-select">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->company_name }}</option>
                        @endforeach
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

            {{-- RIGHT: Bulk Reprint --}}
            <div class="d-flex align-items-end flex-wrap">
                <div class="mb-2">
                    <button id="bulkReprintBtn" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-printer me-2"></i>
                        Bulk Reprint
                        <span id="selectedCount" class="badge bg-white text-primary ms-2">0</span>
                    </button>
                </div>
            </div>

        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="idCardReportTable">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>S.No</th>
                            <th>Emp ID</th>
                            <th>Site Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
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

{{-- Global functions --}}
<script>

function openPrintWindow(cards) {
    let printContent = `<!DOCTYPE html><html><head><title>ID Cards</title>
        <style>
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; color-adjust: exact !important; box-sizing: border-box; }
            body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #fff; }
            .cards-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
            .card-wrapper { width: 320px; page-break-inside: avoid; break-inside: avoid; }
            @media print {
                * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
                @page { size: A4; margin: 15mm; }
                body { margin: 0; padding: 0; }
                .cards-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; }
                .card-wrapper { width: 320px; page-break-inside: avoid; break-inside: avoid; }
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

function reprintIdCard(id) {
    Swal.fire({
        title: 'Loading...',
        text: 'Preparing ID card...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajax({
        url: "{{ route('admin.id.cards.reprint') }}",
        type: "GET",
        data: { ids: [id] },
        success: function (response) {
            Swal.close();
            if (!response.cards || response.cards.length === 0) {
                Swal.fire('Error', 'No ID card found', 'error');
                return;
            }
            console.log(response.cards);

            openPrintWindow(response.cards);
        },
        error: function (xhr) {
            Swal.close();
            Swal.fire('Error', xhr.responseJSON?.error ?? 'Something went wrong', 'error');
        }
    });
}

function deleteIdCard(id) {
    Swal.fire({
        title: 'Confirm Delete?',
        text: 'ID card record delete ho jayega.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33'
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/id-cards/delete') }}/" + id,
                type: "POST",
                data: { _token: "{{ csrf_token() }}" , _method: "DELETE" },
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {
                        $('#idCardReportTable').DataTable().ajax.reload();
                    });
                },
                error: function () {
                    Swal.fire('Error', 'Delete failed', 'error');
                }
            });
        }
    });
}

</script>

<script>
$(document).ready(function () {

    let table = $('#idCardReportTable').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: {
            url: "{{ route('admin.id.cards.ajaxWith') }}",
            type: "POST",
            data: function (d) {
                d._token          = "{{ csrf_token() }}";
                d.site            = $('#site_filter').val();
                d.employee_search = $('#employee_search').val();
            }
        },
        columns: [
            {
                data: null, orderable: false, searchable: false,
                render: function (data) {
                    return `<input type="checkbox" class="emp-checkbox" value="${data.id}">`;
                }
            },
            {
                data: null, orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'employee_code', name: 'employee_code' },
            { data: 'company_name' },
            { data: 'name',          name: 'name' },
            { data: 'email',         name: 'email' },
            { data: 'phone',         name: 'phone' },
            {
                data: 'action', name: 'action',
                orderable: false, searchable: false,
                render: function (data) { return data; }
            },
        ],
        order: [[1, 'asc']]
    });

    // Track selected IDs
    let selectedIds = new Set();

    $('#idCardReportTable tbody').on('change', '.emp-checkbox', function () {
        let id = $(this).val();
        $(this).is(':checked') ? selectedIds.add(id) : selectedIds.delete(id);
        $('#select-all').prop('checked', false);
        updateBtn();
    });

    $('#select-all').on('change', function () {
        let checked = $(this).is(':checked');
        $('#idCardReportTable tbody .emp-checkbox').each(function () {
            $(this).prop('checked', checked);
            checked ? selectedIds.add($(this).val()) : selectedIds.delete($(this).val());
        });
        updateBtn();
    });

    table.on('draw', function () {
        $('#idCardReportTable tbody .emp-checkbox').each(function () {
            if (selectedIds.has($(this).val())) $(this).prop('checked', true);
        });
        let allChecked = $('#idCardReportTable tbody .emp-checkbox').length > 0 &&
            $('#idCardReportTable tbody .emp-checkbox:not(:checked)').length === 0;
        $('#select-all').prop('checked', allChecked);
    });

    function updateBtn() {
        let count = selectedIds.size;
        $('#selectedCount').text(count);
        $('#bulkReprintBtn').prop('disabled', count === 0);
    }

    // Filter
    $('#filterBtn').on('click', function () { table.ajax.reload(); });

    // Reset
    $('#resetBtn').on('click', function () {
        $('#site_filter').val('');
        $('#employee_search').val('');
        selectedIds.clear();
        updateBtn();
        table.search('').columns().search('').draw();
    });

    // Bulk Reprint
    $('#bulkReprintBtn').on('click', function () {
        if (selectedIds.size === 0) {
            Swal.fire('Warning', 'Please select at least one employee.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: "{{ route('admin.id.cards.reprint') }}",
            type: "GET",
            data: { ids: Array.from(selectedIds) },
            success: function (response) {
                Swal.close();

                if (!response.cards || response.cards.length === 0) {
                    Swal.fire('Error', 'No ID cards found', 'error');
                    return;
                }

                openPrintWindow(response.cards);
                selectedIds.clear();
                updateBtn();
            },
            error: function (xhr) {
                Swal.close();
                Swal.fire('Error', xhr.responseJSON?.error ?? 'Failed', 'error');
            }
        });
    });

});
</script>
@endsection
