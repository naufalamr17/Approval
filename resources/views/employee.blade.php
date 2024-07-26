<x-app-layout>
    <style>
        .dataTables_processing {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            text-align: center;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_processing {
            display: block;
        }

        .dataTables_wrapper .dataTables_wrapper table {
            visibility: hidden;
        }
    </style>
    <style>
        #toast-container {
            position: fixed;
            top: 0;
            right: 0;
            padding: 1rem;
            z-index: 1050;
            /* Pastikan di atas elemen lain */
        }
    </style>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div id="toast-container" class="position-fixed top-0 end-0 p-3">
                <!-- Toast placeholder -->
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Employees</h6>
                                    <p class="text-sm mb-sm-0">These are details about the Employees</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <div class="input-group input-group-sm ms-auto me-2">
                                        <span class="input-group-text text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                                </path>
                                            </svg>
                                        </span>
                                        <input type="text" id="searchbox" class="form-control form-control-sm" placeholder="Search">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0 me-2" id="exportExcelButton">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center px-3 mt-2 mb-1">
                            <p class="mb-0 me-3 d-flex align-items-center">
                                Show
                                <select id="entries-select" class="form-select form-select-sm mx-2">
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                    <option value="-1">-1</option>
                                </select>
                                entries
                            </p>
                            <p class="mb-0 d-flex align-items-center ms-auto">
                                Org
                                <select id="filter-organization" class="form-select form-select-sm mx-2">
                                    <option value="">All Organizations</option>
                                    @foreach($organizations as $organization)
                                    <option value="{{ $organization }}">{{ $organization }}</option>
                                    @endforeach
                                </select>
                            </p>
                        </div>

                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="letter table align-items-center justify-content-center mb-0" id="letter">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">No</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">NIK</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Organization</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Job Position</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Job Level</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Branch Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">POH</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <p class="px-3 mt-2" id="showingIndicator">Showing ... to ...</p>
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <button class="btn btn-sm btn-white d-sm-block d-none mb-0" id="previousPage">Previous</button>
                                <nav aria-label="..." class="ms-auto">
                                    <ul class="pagination pagination-light mb-0" id="pagination">
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link font-weight-bold">1</span>
                                        </li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold" href="javascript:;">2</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold d-sm-inline-flex d-none" href="javascript:;">3</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold" href="javascript:;">...</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold d-sm-inline-flex d-none" href="javascript:;">8</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold" href="javascript:;">9</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold" href="javascript:;">10</a></li>
                                    </ul>
                                </nav>
                                <button class="btn btn-sm btn-white d-sm-block d-none mb-0 ms-auto" id="nextPage">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-app.footer />
    </main>

    <!-- Include Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DataTable initialization and configuration
            $(document).ready(function() {
                var table = $('.letter').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('employees') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'nama',
                            name: 'nama'
                        },
                        {
                            data: 'organization',
                            name: 'organization'
                        },
                        {
                            data: 'job_position',
                            name: 'job_position'
                        },
                        {
                            data: 'job_level',
                            name: 'job_level'
                        },
                        {
                            data: 'branch_name',
                            name: 'branch_name'
                        },
                        {
                            data: 'poh',
                            name: 'poh'
                        }
                    ],
                    dom: '<"top">tr<"bottom"><"clear">',
                    language: {
                        processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> Processing...'
                    },
                    initComplete: function() {
                        this.api().on('processing.dt', function(e, settings, processing) {
                            if (processing) {
                                $('#letter').css('visibility', 'hidden');
                            } else {
                                $('#letter').css('visibility', 'visible');
                            }
                        });
                    },
                    drawCallback: function(settings) {
                        var pagination = $('#pagination');
                        pagination.html('');
                        var pageInfo = table.page.info();
                        var totalPages = pageInfo.pages;
                        var currentPage = pageInfo.page;

                        // Always show the first page
                        pagination.append('<li class="page-item ' + (currentPage === 0 ? 'active' : '') + '"><a class="page-link border-0 font-weight-bold" href="#">1</a></li>');

                        // Show "..." if there are more than 1 page before the current page
                        if (currentPage > 1) {
                            pagination.append('<li class="page-item"><a class="page-link border-0 font-weight-bold" href="#">...</a></li>');
                        }

                        // Show pages around the current page
                        for (var i = Math.max(1, currentPage - 1); i <= Math.min(currentPage + 1, totalPages - 1); i++) {
                            pagination.append('<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link border-0 font-weight-bold" href="#">' + (i + 1) + '</a></li>');
                        }

                        // Show "..." if there are more than 1 page after the current page
                        if (currentPage < totalPages - 2) {
                            pagination.append('<li class="page-item"><a class="page-link border-0 font-weight-bold" href="#">...</a></li>');
                        }

                        // Always show the last page
                        if (totalPages > 1) {
                            // Avoid appending the last page twice
                            if (pagination.children().last().text() !== totalPages.toString()) {
                                pagination.append('<li class="page-item ' + (currentPage === totalPages - 1 ? 'active' : '') + '"><a class="page-link border-0 font-weight-bold" href="#">' + totalPages + '</a></li>');
                            }
                        }

                        // Update the showing indicator
                        var start = pageInfo.start + 1;
                        var end = pageInfo.end;
                        var total = pageInfo.recordsTotal;
                        $('#showingIndicator').text('Showing ' + start + ' to ' + end + ' of ' + total + ' entries');

                        // Update the entries count
                        var entriesCount = table.page.info().length;
                        $('#entries-count').text(entriesCount);
                    }
                });

                $('#pagination').on('click', 'a', function(e) {
                    e.preventDefault();
                    var page = parseInt($(this).text(), 10) - 1;
                    table.page(page).draw('page');
                });

                $('#previousPage').on('click', function() {
                    table.page('previous').draw('page');
                });

                $('#nextPage').on('click', function() {
                    table.page('next').draw('page');
                });

                $('#searchbox').on('keyup', function() {
                    table.search(this.value).draw();
                    if (this.value.length >= 13) {
                        setTimeout(() => {
                            this.select();
                        }, 2000);
                    }
                });

                // Filter organization
                $('#filter-organization').on('change', function() {
                    // Mendapatkan nilai yang dipilih
                    var selectedValue = this.value;

                    // Mencetak nilai ke konsol untuk debugging
                    console.log('Selected Value:', selectedValue);

                    // Menerapkan filter pada kolom yang sesuai
                    table.search(selectedValue, true, false).draw();
                });


                // Entries per page functionality
                $('#entries-select').on('change', function() {
                    var value = $(this).val();
                    table.page.len(parseInt(value)).draw();
                });

                // Export to Excel functionality
                $('#exportExcelButton').on('click', function() {
                    const sheetName = 'Report';
                    const fileName = 'AssignmentLetter';

                    const table = document.getElementById('letter');

                    // Memastikan tabel ditemukan sebelum melanjutkan
                    if (!table) {
                        console.error('Tabel tidak ditemukan.');
                        return;
                    }

                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.table_to_sheet(table);

                    const range = XLSX.utils.decode_range(ws['!ref']);

                    // Kolom yang ingin diexport (indeks kolom dimulai dari 0)
                    const columnsToExport = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];

                    const filteredData = [];
                    for (let R = range.s.r; R <= range.e.r; ++R) {
                        const row = [];
                        for (let C = 0; C < columnsToExport.length; ++C) {
                            const colIndex = columnsToExport[C];
                            const cellAddress = XLSX.utils.encode_cell({
                                r: R,
                                c: colIndex
                            });
                            if (!ws[cellAddress]) continue;
                            row.push(ws[cellAddress].v);
                        }
                        filteredData.push(row);
                    }

                    // Buat sheet baru dengan data yang difilter
                    const newWs = XLSX.utils.aoa_to_sheet(filteredData);

                    const newRange = XLSX.utils.decode_range(newWs['!ref']);

                    // Autofit width untuk setiap kolom
                    const colWidths = [];
                    for (let C = newRange.s.c; C <= newRange.e.c; ++C) {
                        let maxWidth = 0;
                        for (let R = newRange.s.r; R <= newRange.e.r; ++R) {
                            const cellAddress = XLSX.utils.encode_cell({
                                r: R,
                                c: C
                            });
                            if (!newWs[cellAddress]) continue;
                            const cellTextLength = XLSX.utils.format_cell(newWs[cellAddress]).length;
                            maxWidth = Math.max(maxWidth, cellTextLength);
                        }
                        colWidths[C] = {
                            wch: maxWidth + 2
                        };
                    }
                    newWs['!cols'] = colWidths;

                    XLSX.utils.book_append_sheet(wb, newWs, sheetName);

                    XLSX.writeFile(wb, fileName + '.xlsx');
                });
            });

            // Toast notification
            $(document).ready(function() {
                @if(session('success'))
                var toastContainer = $('#toast-container');
                var toastHtml = `
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">MLP Approval</strong>
                    </div>
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            `;
                toastContainer.append(toastHtml);
                var toastElement = toastContainer.find('.toast');
                var toast = new bootstrap.Toast(toastElement[0]);
                toast.show();
                @elseif(session('error'))
                var toastContainer = $('#toast-container');
                var toastHtml = `
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">MLP Approval</strong>
                    </div>
                    <div class="toast-body bg-danger">
                        {{ session('error') }}
                    </div>
                </div>
            `;
                toastContainer.append(toastHtml);
                var toastElement = toastContainer.find('.toast');
                var toast = new bootstrap.Toast(toastElement[0]);
                toast.show();
                @endif
            });
        });
    </script>

</x-app-layout>