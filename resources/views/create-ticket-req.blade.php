<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />

        <div class="container bg-white border-radius-lg">
            <h2 class="pt-2">Ticket Request</h2>
            <hr>

            <form action="{{ route('store-ticket-request') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf

                <div class="mb-3">
                    <label for="jenis_tiket" class="form-label">Jenis Tiket</label>
                    <select name="jenis_tiket" id="jenis_tiket" class="form-control">
                        <option value="tiket keberangkatan">Tiket Keberangkatan</option>
                        <option value="tiket kepulangan">Tiket Kepulangan</option>
                    </select>
                    @error('jenis_tiket')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div id="user-fields">
                    <div class="user-group">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input list="nik-options" name="nik[]" id="nik" class="form-control nik-input" placeholder="Select NIK" required>
                            <datalist id="nik-options">
                                @foreach ($employee as $item)
                                <option value="{{ $item->nik }}">{{ $item->nama }} - {{ $item->nik }}</option>
                                @endforeach
                            </datalist>
                            @error('nik')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Additional fields for Onboarding -->
                        <div id="onboarding-fields" style="display:none;">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name[]" id="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="job_level" class="form-label">Job Level</label>
                                <input list="job_levels" name="job_level[]" id="job_level" class="form-control">
                                <datalist id="job_levels">
                                    @foreach ($jobLevels as $jobLevel)
                                    <option value="{{ $jobLevel }}">
                                        @endforeach
                                </datalist>
                            </div>
                            <div class="mb-3">
                                <label for="organization" class="form-label">Department</label>
                                <input list="departments" name="organization[]" id="organization" class="form-control">
                                <datalist id="departments">
                                    @foreach ($departments as $department)
                                    <option value="{{ $department }}">
                                        @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="poh" class="form-label">POH</label>
                            <input type="text" name="poh[]" id="poh" class="form-control" required>
                            @error('poh')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3" style="display:none;">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select name="jenis[]" id="jenis" class="form-control jenis-select" required>
                                <!-- <option value="" disabled>Pilih Jenis</option> -->
                                <option value="Cuti Roster" {{ session('jenis') == 'Cuti Roster' ? 'selected' : 'disabled' }}>Cuti Roster</option>
                                <option value="Onboarding" {{ session('jenis') == 'Onboarding' ? 'selected' : 'disabled' }}>Onboarding</option>
                                <option value="Onsite" {{ session('jenis') == 'Onsite' ? 'selected' : 'disabled' }}>Onsite</option>
                            </select>
                            @error('jenis')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Keberangkatan -->
                            <div class="col-md-6 order-md-1 mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date[]" id="start_date" class="form-control" required>
                                @error('start_date')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Kepulangan -->
                            <div class="col-md-6 order-md-2 mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date[]" id="end_date" class="form-control" required>
                                @error('end_date')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="flight_date" class="form-label">Tanggal Penerbangan</label>
                            <input type="date" name="flight_date[]" id="flight_date" class="form-control" required>
                            @error('flight_date')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="route" class="form-label">Rute</label>
                                <input type="text" name="route[]" id="route" class="form-control" required>
                                @error('route')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="destination" class="form-label">Destination</label>
                                <input type="text" name="destination[]" id="destination" class="form-control" required>
                                @error('route')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="departure_airline" class="form-label">Maskapai</label>
                            <select name="departure_airline[]" id="departure_airline" class="form-control" required>
                                <option value="">Select Airline</option>
                                <option value="Garuda Indonesia">Garuda Indonesia</option>
                                <option value="Lion Air">Lion Air</option>
                                <option value="Sriwijaya Air">Sriwijaya Air</option>
                                <option value="Citilink">Citilink</option>
                                <option value="AirAsia">AirAsia</option>
                                <!-- Add more airlines as needed -->
                            </select>
                            @error('departure_airline')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 order-md-1 mb-3">
                                <label for="flight_time" class="form-label">Jam keberangkatan</label>
                                <input type="time" name="flight_time[]" id="flight_time" class="form-control" required>
                                @error('flight_time')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 order-md-2 mb-3">
                                <label for="flight_time_end" class="form-label">Jam Sampai</label>
                                <input type="time" name="flight_time_end[]" id="flight_time_end" class="form-control" required>
                                @error('flight_time')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Penerbangan</label>
                            <select name="status[]" id="status" class="form-control" required>
                                <option value="" disabled selected>Select Status</option>
                                <option value="Direct">Direct</option>
                                <option value="Transit">Transit</option>
                            </select>
                            @error('status')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" name="price[]" id="price" class="form-control" required>
                            @error('price')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Keterangan</label>
                            <textarea name="remarks[]" id="remarks" class="form-control" required>-</textarea>
                            @error('remarks')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ticket_screenshot" class="form-label">Upload SS Tiket yang mau diajukan</label>
                            <input type="file" name="ticket_screenshot[]" id="ticket_screenshot" class="form-control" required>
                            @error('ticket_screenshot')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="button" class="btn btn-danger remove-user">Delete</button>
                        <hr>
                    </div>
                </div>

                <button type="button" class="btn btn-success" id="add-user">Add User</button>
                <button type="submit" class="btn btn-dark" id="submit-button">Submit</button>
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
        const employees = @json($employee -> mapWithKeys(function($item) {
            return [$item -> nik => $item -> poh];
        }));
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('jenis');
            const nikInput = document.getElementById('nik');
            const onboardingFields = document.getElementById('onboarding-fields');

            function toggleOnboardingFields() {
                if (jenisSelect.value === 'Onboarding') {
                    nikInput.value = '';
                    nikInput.disabled = true;
                    onboardingFields.style.display = 'block';
                } else {
                    nikInput.value = '';
                    nikInput.disabled = false;
                    onboardingFields.style.display = 'none';
                }
            }

            jenisSelect.addEventListener('change', toggleOnboardingFields);

            // Run once on page load in case 'jenis' is already set to 'Onboarding'
            toggleOnboardingFields();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('add-user').addEventListener('click', function() {
                const userFields = document.getElementById('user-fields');
                const newUserGroup = userFields.querySelector('.user-group').cloneNode(true);

                newUserGroup.querySelectorAll('input').forEach(input => input.value = '');

                newUserGroup.querySelector('.remove-user').addEventListener('click', function() {
                    newUserGroup.remove();
                });

                userFields.appendChild(newUserGroup);
            });

            // document.querySelectorAll('.remove-user').forEach(function(button) {
            //     button.addEventListener('click', function() {
            //         button.closest('.user-group').remove();
            //     });
            // });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userFieldsContainer = document.getElementById('user-fields');

            userFieldsContainer.addEventListener('input', function(event) {
                if (event.target.classList.contains('nik-input')) {
                    const nik = event.target.value;
                    const pohInput = event.target.closest('.user-group').querySelector('#poh');
                    if (employees[nik]) {
                        pohInput.value = employees[nik];
                    } else {
                        pohInput.value = '';
                    }
                }
            });

            // Initial check for each user group in case there are pre-filled values
            document.querySelectorAll('.nik-input').forEach(function(input) {
                input.dispatchEvent(new Event('input'));
            });

            const datalist = document.getElementById('nik-options');
            const submitButton = document.getElementById('submit-button');

            // function validateNikInput(nikInput) {
            //     let timeout = null;

            //     nikInput.addEventListener('input', function() {
            //         clearTimeout(timeout); // Clear the previous timeout if there's one

            //         timeout = setTimeout(function() {
            //             console.log(nikInput.value);
            //             let valid = false;
            //             for (let option of datalist.options) {
            //                 if (nikInput.value === option.value) {
            //                     valid = true;
            //                     break;
            //                 }
            //             }

            //             // Disable submit button if there is any duplicate
            //             let hasDuplicate = false;
            //             document.querySelectorAll('.nik-input').forEach(input => {
            //                 if (input !== nikInput && input.value === nikInput.value) {
            //                     hasDuplicate = true;
            //                 }
            //             });

            //             submitButton.disabled = !valid || hasDuplicate;
            //         }, 2000); // 2000 milliseconds = 2 seconds
            //     });

            //     // Initial check in case the input already has a value
            //     nikInput.dispatchEvent(new Event('input'));
            // }

            // Apply validation to the initial input
            document.querySelectorAll('.nik-input').forEach(validateNikInput);

            // Add user field functionality
            // document.getElementById('add-user').addEventListener('click', function() {
            //     var userGroup = document.querySelector('.user-group');
            //     var clone = userGroup.cloneNode(true);
            //     clone.querySelectorAll('input, select, textarea').forEach(function(input) {
            //         input.value = '';
            //     });

            //     const nikInput = clone.querySelector('.nik-input');
            //     validateNikInput(nikInput);

            //     document.getElementById('user-fields').appendChild(clone);
            // });

            // Remove user field functionality
            document.getElementById('user-fields').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-user')) {
                    if (document.querySelectorAll('.user-group').length > 1) {
                        e.target.parentElement.remove();
                    }
                }
            });
        });
    </script>

</x-app-layout>