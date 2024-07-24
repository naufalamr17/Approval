<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />

        <div class="container">
            <h1>Assignment Letter</h1>

            <form action="{{ route('update-surat-tugas', $suratTugas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $suratTugas->nik) }}">
                    @error('nik')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $suratTugas->name) }}">
                    @error('name')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="position" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $suratTugas->position) }}">
                    @error('position')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $suratTugas->start_date) }}">
                        @error('start_date')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $suratTugas->end_date) }}">
                        @error('end_date')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="destination_place" class="form-label">Tujuan Tempat</label>
                    <input type="text" class="form-control" id="destination_place" name="destination_place" value="{{ old('destination_place', $suratTugas->destination_place) }}">
                    @error('destination_place')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="activity_purpose" class="form-label">Tujuan Kegiatan</label>
                    <textarea class="form-control" id="activity_purpose" name="activity_purpose" rows="4">{{ old('activity_purpose', $suratTugas->activity_purpose) }}</textarea>
                    @error('activity_purpose')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <a href="{{ route('surat-tugas') }}" class="btn btn-white">Cancel</a>
                <button type="submit" class="btn btn-dark">Update</button>
                <a href="{{ route('approve-surat-tugas', $suratTugas->id) }}" class="btn btn-success" id="approveLink"">Approve</a>
                <a href="{{ route('reject-surat-tugas', $suratTugas->id) }}" class="btn btn-danger" id="rejectLink">Reject</a>
            </form>
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
        $(document).ready(function() {
            var table = $('.letter').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('surat-tugas') }}",
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'position',
                        name: 'position'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'destination_place',
                        name: 'destination_place'
                    },
                    {
                        data: 'activity_purpose',
                        name: 'activity_purpose'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                dom: '<"top">rt<"bottom"><"clear">',
                drawCallback: function(settings) {
                    var pagination = $('#pagination');
                    pagination.html('');
                    var pageInfo = table.page.info();
                    for (var i = 0; i < pageInfo.pages; i++) {
                        var activeClass = (i === pageInfo.page) ? 'active' : '';
                        pagination.append('<li class="page-item ' + activeClass + '"><a class="page-link border-0 font-weight-bold" href="#">' + (i + 1) + '</a></li>');
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

            // Filter status
            $('#filter-status').on('change', function() {
                table.column(8).search(this.value).draw(); // Kolom status adalah kolom ke-9 (index 8)
            });

            // Entries per page functionality
            $('#entries-select').on('change', function() {
                var value = $(this).val();
                table.page.len(parseInt(value)).draw();
            });


        });
    </script>

</x-app-layout>