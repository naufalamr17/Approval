<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />

        <div class="container bg-white border-radius-lg">
            <h2 class="pt-2">Surat Tugas Perjalanan Dinas</h2>
            <hr>

            <form action="{{ route('store-surat-tugas') }}" method="POST">
                @csrf

                <div id="nik-container">
                    <div class="mb-2 nik-item">
                        <label for="nik" class="form-label">NIK</label>
                        <input list="nik-options" name="nik[]" class="form-control nik-input" placeholder="Select NIK" required>
                        <datalist id="nik-options">
                            @foreach ($employee as $item)
                            <option value="{{ $item->nik }}">{{ $item->nama }} - {{ $item->nik }}</option>
                            @endforeach
                        </datalist>
                        @error('nik')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror

                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control name-input mb-1" name="name[]" value="{{ old('name') }}" readonly>
                        @error('name')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror

                        <label for="position" class="form-label">Jabatan</label>
                        <input type="text" class="form-control position-input mb-1" name="position[]" value="{{ old('position') }}" readonly>
                        @error('position')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror

                        <button type="button" class="btn btn-sm btn-danger remove-nik-item">Remove</button>
                    </div>
                </div>

                <button type="button" id="add-nik-item" class="btn btn-sm btn-secondary">Add NIK</button>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="destination_place" class="form-label">Tujuan Tempat</label>
                    <input type="text" class="form-control" id="destination_place" name="destination_place" value="{{ old('destination_place') }}">
                    @error('destination_place')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="activity_purpose" class="form-label">Tujuan Kegiatan</label>
                    <textarea class="form-control" id="activity_purpose" name="activity_purpose" rows="4">{{ old('activity_purpose') }}</textarea>
                    @error('activity_purpose')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark" name="submit_button" value="submit">Submit</button>
                <button type="submit" class="btn btn-primary" name="submit_button" value="next_to_fpd">Next to FPD</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const employees = @json($employee -> mapWithKeys(function($item) {
                return [$item -> nik => ['nama' => $item -> nama, 'jabatan' => $item -> job_level]]; // Assuming 'poh' contains job level data
            }));

            function updateInputs(nikInput, nameInput, positionInput) {
                const selectedNik = nikInput.value;
                if (employees[selectedNik]) {
                    nameInput.value = employees[selectedNik].nama;
                    positionInput.value = employees[selectedNik].jabatan;
                } else {
                    nameInput.value = '';
                    positionInput.value = '';
                }
            }

            function addNikItem() {
                const nikContainer = document.getElementById('nik-container');
                const newNikItem = document.createElement('div');
                newNikItem.classList.add('mb-3', 'nik-item');

                newNikItem.innerHTML = `
            <label for="nik" class="form-label">NIK</label>
            <input list="nik-options" name="nik[]" class="form-control nik-input" placeholder="Select NIK" required>
            <datalist id="nik-options">
                @foreach ($employee as $item)
                <option value="{{ $item->nik }}">{{ $item->nama }} - {{ $item->nik }}</option>
                @endforeach
            </datalist>
            @error('nik')
            <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control name-input mb-1" name="name[]" value="{{ old('name') }}" readonly>
            @error('name')
            <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <label for="position" class="form-label">Jabatan</label>
            <input type="text" class="form-control position-input mb-1" name="position[]" value="{{ old('position') }}" readonly>
            @error('position')
            <span class="text-danger text-sm">{{ $message }}</span>
            @enderror

            <button type="button" class="btn btn-sm btn-danger remove-nik-item">Remove</button>
        `;

                nikContainer.appendChild(newNikItem);

                const nikInput = newNikItem.querySelector('.nik-input');
                const nameInput = newNikItem.querySelector('.name-input');
                const positionInput = newNikItem.querySelector('.position-input');

                nikInput.addEventListener('input', function() {
                    updateInputs(nikInput, nameInput, positionInput);
                });

                newNikItem.querySelector('.remove-nik-item').addEventListener('click', function() {
                    newNikItem.remove();
                });
            }

            document.getElementById('add-nik-item').addEventListener('click', addNikItem);

            // Add event listener to existing NIK input
            document.querySelectorAll('.nik-item').forEach(item => {
                const nikInput = item.querySelector('.nik-input');
                const nameInput = item.querySelector('.name-input');
                const positionInput = item.querySelector('.position-input');

                nikInput.addEventListener('input', function() {
                    updateInputs(nikInput, nameInput, positionInput);
                });

                item.querySelector('.remove-nik-item').addEventListener('click', function() {
                    item.remove();
                });
            });
        });
    </script>

</x-app-layout>