<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container bg-white border-radius-lg">
            <h2 class="pt-2">Form Perjalanan Dinas</h2>
            <hr>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <!-- resources/views/fpd_form.blade.php -->
            <form action="{{ route('store-form') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- No and Date -->
                <div class="mb-3">
                    <label for="no_surat" class="form-label">No</label>
                    <input type="text" class="form-control" name="no_surat" value="{{ session('no_stpd') }}" readonly>
                </div>

                <!-- Business Trip Details -->
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="{{ session('start_date') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="{{ session('end_date') }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="activity_purpose" class="form-label">Activity Purpose</label>
                    <textarea class="form-control" name="activity_purpose" rows="3" readonly>{{ session('activity_purpose') }}</textarea>
                </div>

                <hr>

                @foreach (session('names', []) as $index => $name)
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="name_{{ $index }}" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="names[]" id="name_{{ $index }}" value="{{ $name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="nik_{{ $index }}" class="form-label">NIK Karyawan</label>
                        <input type="text" class="form-control" name="niks[]" id="nik_{{ $index }}" value="{{ session('niks')[$index] }}" readonly>
                    </div>

                    <input type="hidden" id="job_level_{{ $index }}" data-job-level="{{ $employees[$index] }}">
                </div>

                <!-- Transportasi, Akomodasi, dan Uang Saku -->
                <div class="mb-3 row">
                    <!-- Transportation Options -->
                    <div class="col-md-4">
                        <label class="form-label">Transportation</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Plane" id="transportation_plane_{{ $index }}" onclick="toggleFlightDetails({{ $index }})">
                            <label class="form-check-label" for="transportation_plane_{{ $index }}">
                                Plane
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Public Transportation" id="transportation_public_{{ $index }}">
                            <label class="form-check-label" for="transportation_public_{{ $index }}">
                                Public Transportation
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Train" id="transportation_train_{{ $index }}">
                            <label class="form-check-label" for="transportation_train_{{ $index }}">
                                Train
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Rental Vehicle" id="transportation_rental_{{ $index }}">
                            <label class="form-check-label" for="transportation_rental_{{ $index }}">
                                Rental Vehicle
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Company Vehicle" id="transportation_company_{{ $index }}">
                            <label class="form-check-label" for="transportation_company_{{ $index }}">
                                Company Vehicle
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Other" id="transportation_other_{{ $index }}">
                            <label class="form-check-label" for="transportation_other_{{ $index }}">
                                Other
                            </label>
                        </div>
                    </div>

                    <!-- Accommodation Options -->
                    <div class="col-md-4">
                        <label class="form-label">Accommodation</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accommodation[{{ $index }}][]" value="Hotel" id="accommodation_hotel_{{ $index }}">
                            <label class="form-check-label" for="accommodation_hotel_{{ $index }}">
                                Hotel
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accommodation[{{ $index }}][]" value="Guest House" id="accommodation_guest_house_{{ $index }}">
                            <label class="form-check-label" for="accommodation_guest_house_{{ $index }}">
                                Guest House
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accommodation[{{ $index }}][]" value="Mess" id="accommodation_mess_{{ $index }}">
                            <label class="form-check-label" for="accommodation_mess_{{ $index }}">
                                Mess
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accommodation[{{ $index }}][]" value="Other" id="accommodation_other_{{ $index }}">
                            <label class="form-check-label" for="accommodation_other_{{ $index }}">
                                Other
                            </label>
                        </div>
                    </div>

                    <!-- Money Pocket & Meal Allowance -->
                    <div class="col-md-4">
                        <label class="form-label">Money Pocket & Meal Allowance</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowance[{{ $index }}][]" value="PocketMoney" id="allowance_pocket_money_{{ $index }}">
                            <label class="form-check-label" for="allowance_pocket_money_{{ $index }}">
                                Uang Saku
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowance[{{ $index }}][]" value="MealAllowance" id="allowance_meal_allowance_{{ $index }}" onclick="toggleMealAllowanceDays({{ $index }})">
                            <label class="form-check-label" for="allowance_meal_allowance_{{ $index }}">
                                Uang Makan
                            </label>
                        </div>
                        <div class="mb-3" id="meal_allowance_days_div_{{ $index }}" style="display: none;">
                            <label for="meal_allowance_days_{{ $index }}" class="form-label">Jumlah Hari</label>
                            <input type="number" class="form-control" name="meal_allowance_days[{{ $index }}]" id="meal_allowance_days_{{ $index }}" min="1">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowance[{{ $index }}][]" value="CashAdvance" id="allowance_cash_advance_{{ $index }}" onclick="toggleCashAdvanceAmount({{ $index }})">
                            <label class="form-check-label" for="allowance_cash_advance_{{ $index }}">
                                Cash Advance
                            </label>
                        </div>
                        <div class="mb-3" id="cash_advance_amount_div_{{ $index }}" style="display: none;">
                            <label for="cash_advance_amount_{{ $index }}" class="form-label">Jumlah Cash Advance</label>
                            <input type="number" class="form-control" name="cash_advance_amount[{{ $index }}]" id="cash_advance_amount_{{ $index }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="total_amount_{{ $index }}" class="form-label">Total Amount</label>
                    <input type="number" class="form-control" name="total_amounts[]" id="total_amount_{{ $index }}" readonly>
                </div>

                <!-- Flight Details Form -->
                <div id="flight_details_{{ $index }}" class="mb-3" style="display: none;">
                    <!-- Hidden Input for Ticket Type -->
                    <div class="mb-3">
                        <input type="hidden" name="jenis_tiket" value="tiket keberangkatan">
                    </div>

                    <!-- User Fields -->
                    <div id="user-fields">
                        <div class="user-group">
                            <!-- Hidden NIK Field -->
                            <div class="mb-3">
                                <input type="hidden" name="nik[{{ $index }}]" id="nik_{{ $index }}" class="form-control nik-input" value="{{ session('niks')[$index] }}">
                                @error('nik')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Hidden POH Field -->
                            <div class="mb-3">
                                <input type="hidden" name="poh[{{ $index }}]" id="poh_{{ $index }}" class="form-control" value="-">
                                @error('poh')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Field -->
                            <div class="mb-3">
                                <label for="jenis_{{ $index }}" class="form-label">Jenis</label>
                                <select name="jenis[{{ $index }}]" id="jenis_{{ $index }}" class="form-control jenis-select">
                                    <option value="" disabled>Pilih Jenis</option>
                                    <option value="Cuti Roster" disabled>Cuti Roster</option>
                                    <option value="Onboarding" disabled>Onboarding</option>
                                    <option value="Perjalanan Dinas" selected>PerDin (Perjalanan Dinas)</option>
                                    <option value="Onsite" disabled>Onsite</option>
                                </select>
                                @error('jenis')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Flight Date Field -->
                            <div class="mb-3">
                                <label for="flight_date_{{ $index }}" class="form-label">Tanggal Penerbangan</label>
                                <input type="date" name="flight_date[{{ $index }}]" id="flight_date_{{ $index }}" class="form-control">
                                @error('flight_date')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Route and Destination Fields -->
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="route_{{ $index }}" class="form-label">Rute</label>
                                    <input type="text" name="route[{{ $index }}]" id="route_{{ $index }}" class="form-control">
                                    @error('route')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="destination_{{ $index }}" class="form-label">Destination</label>
                                    <input type="text" name="destination[{{ $index }}]" id="destination_{{ $index }}" class="form-control">
                                    @error('destination')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Departure Airline Field -->
                            <div class="mb-3">
                                <label for="departure_airline_{{ $index }}" class="form-label">Maskapai</label>
                                <select name="departure_airline[{{ $index }}]" id="departure_airline_{{ $index }}" class="form-control">
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

                            <!-- Flight Time Fields -->
                            <div class="row">
                                <div class="col-md-6 order-md-1 mb-3">
                                    <label for="flight_time_{{ $index }}" class="form-label">Jam keberangkatan</label>
                                    <input type="time" name="flight_time[{{ $index }}]" id="flight_time_{{ $index }}" class="form-control">
                                    @error('flight_time')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 order-md-2 mb-3">
                                    <label for="flight_time_end_{{ $index }}" class="form-label">Jam Sampai</label>
                                    <input type="time" name="flight_time_end[{{ $index }}]" id="flight_time_end_{{ $index }}" class="form-control">
                                    @error('flight_time_end')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Field -->
                            <div class="mb-3">
                                <label for="status_{{ $index }}" class="form-label">Status Penerbangan</label>
                                <select name="status[{{ $index }}]" id="status_{{ $index }}" class="form-control">
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="direct">Direct</option>
                                    <option value="transit">Transit</option>
                                </select>
                                @error('status')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Price Field -->
                            <div class="mb-3">
                                <label for="price_{{ $index }}" class="form-label">Harga</label>
                                <input type="number" name="price[{{ $index }}]" id="price_{{ $index }}" class="form-control">
                                @error('price')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remarks Field -->
                            <div class="mb-3">
                                <label for="remarks_{{ $index }}" class="form-label">Keterangan</label>
                                <textarea name="remarks[{{ $index }}]" id="remarks_{{ $index }}" class="form-control">-</textarea>
                                @error('remarks')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Ticket Screenshot Upload -->
                            <div class="mb-3">
                                <label for="ticket_screenshot_{{ $index }}" class="form-label">Upload SS Tiket yang mau diajukan</label>
                                <input type="file" name="ticket_screenshot[{{ $index }}]" id="ticket_screenshot_{{ $index }}" class="form-control">
                                @error('ticket_screenshot')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="add_return_ticket" value="Plane" id="add_return_ticket_{{ $index }}" onclick="toggleReturnFlightDetails({{ $index }})">
                        <label class="form-check-label" for="add_return_ticket_{{ $index }}">
                            Return Ticket
                        </label>
                    </div>
                </div>

                <!-- Return Flight Details Div -->
                <div id="return_flight_details_{{ $index }}" class="mb-3" style="display: none;">

                    <!-- User Fields for Return Flight -->
                    <div id="user-fields-return">
                        <div class="user-group">
                            <!-- Hidden NIK Field -->
                            <div class="mb-3">
                                <input type="hidden" name="nik[{{ $index }}]" id="return_nik_{{ $index }}" class="form-control nik-input" value="{{ session('niks')[$index] }}">
                                @error('nik')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Hidden POH Field -->
                            <div class="mb-3">
                                <input type="hidden" name="poh[{{ $index }}]" id="return_poh_{{ $index }}" class="form-control" value="-">
                                @error('poh')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Field -->
                            <div class="mb-3">
                                <label for="return_jenis_{{ $index }}" class="form-label">Jenis</label>
                                <select name="return_jenis[{{ $index }}]" id="return_jenis_{{ $index }}" class="form-control jenis-select">
                                    <option value="" disabled>Pilih Jenis</option>
                                    <option value="Cuti Roster" disabled>Cuti Roster</option>
                                    <option value="Onboarding" disabled>Onboarding</option>
                                    <option value="Perjalanan Dinas" selected>PerDin (Perjalanan Dinas)</option>
                                    <option value="Onsite" disabled>Onsite</option>
                                </select>
                                @error('jenis')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Flight Date Field -->
                            <div class="mb-3">
                                <label for="return_flight_date_{{ $index }}" class="form-label">Tanggal Penerbangan</label>
                                <input type="date" name="return_flight_date[{{ $index }}]" id="return_flight_date_{{ $index }}" class="form-control">
                                @error('return_flight_date')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Route and Destination Fields -->
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="return_route_{{ $index }}" class="form-label">Rute</label>
                                    <input type="text" name="return_route[{{ $index }}]" id="return_route_{{ $index }}" class="form-control">
                                    @error('return_route')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="return_destination_{{ $index }}" class="form-label">Destination</label>
                                    <input type="text" name="return_destination[{{ $index }}]" id="return_destination_{{ $index }}" class="form-control">
                                    @error('return_destination')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Return Airline Field -->
                            <div class="mb-3">
                                <label for="return_airline_{{ $index }}" class="form-label">Maskapai</label>
                                <select name="return_airline[{{ $index }}]" id="return_airline_{{ $index }}" class="form-control">
                                    <option value="">Select Airline</option>
                                    <option value="Garuda Indonesia">Garuda Indonesia</option>
                                    <option value="Lion Air">Lion Air</option>
                                    <option value="Sriwijaya Air">Sriwijaya Air</option>
                                    <option value="Citilink">Citilink</option>
                                    <option value="AirAsia">AirAsia</option>
                                    <!-- Add more airlines as needed -->
                                </select>
                                @error('return_airline')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Return Flight Time Fields -->
                            <div class="row">
                                <div class="col-md-6 order-md-1 mb-3">
                                    <label for="return_flight_time_{{ $index }}" class="form-label">Jam keberangkatan</label>
                                    <input type="time" name="return_flight_time[{{ $index }}]" id="return_flight_time_{{ $index }}" class="form-control">
                                    @error('return_flight_time')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 order-md-2 mb-3">
                                    <label for="return_flight_time_end_{{ $index }}" class="form-label">Jam Sampai</label>
                                    <input type="time" name="return_flight_time_end[{{ $index }}]" id="return_flight_time_end_{{ $index }}" class="form-control">
                                    @error('return_flight_time_end')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Return Status Field -->
                            <div class="mb-3">
                                <label for="return_status_{{ $index }}" class="form-label">Status Penerbangan</label>
                                <select name="return_status[{{ $index }}]" id="return_status_{{ $index }}" class="form-control">
                                    <option value="" selected disabled>Pilih Status</option>
                                    <option value="direct">Direct</option>
                                    <option value="transit">Transit</option>
                                </select>
                                @error('return_status')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Return Price Field -->
                            <div class="mb-3">
                                <label for="return_price_{{ $index }}" class="form-label">Harga</label>
                                <input type="number" name="return_price[{{ $index }}]" id="return_price_{{ $index }}" class="form-control">
                                @error('return_price')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Return Remarks Field -->
                            <div class="mb-3">
                                <label for="return_remarks_{{ $index }}" class="form-label">Keterangan</label>
                                <textarea name="return_remarks[{{ $index }}]" id="return_remarks_{{ $index }}" class="form-control">-</textarea>
                                @error('return_remarks')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Return Ticket Screenshot Upload -->
                            <div class="mb-3">
                                <label for="return_ticket_screenshot_{{ $index }}" class="form-label">Upload SS Tiket yang mau diajukan</label>
                                <input type="file" name="return_ticket_screenshot[{{ $index }}]" id="return_ticket_screenshot_{{ $index }}" class="form-control">
                                @error('return_ticket_screenshot')
                                <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                @endforeach

                <!-- <div class="mb-3">
                    <label for="grand_total" class="form-label">Grand Total</label>
                    <input type="number" class="form-control" name="grand_total" id="grand_total"  readonly>
                </div> -->

                <button type="submit" class="btn btn-dark">Submit FPD</button>
            </form>

        </div><x-app.footer />
    </main>

    <script>
        // Function to toggle flight details visibility based on checkbox state
        function toggleFlightDetails(index) {
            const planeCheckbox = document.getElementById(`transportation_plane_${index}`);
            const flightDetailsDiv = document.getElementById(`flight_details_${index}`);
            flightDetailsDiv.style.display = planeCheckbox.checked ? 'block' : 'none';
        }

        // Function to toggle return flight details visibility
        function toggleReturnFlightDetails(index) {
            const planeCheckbox = document.getElementById(`add_return_ticket_${index}`);
            const returnFlightDetails = document.getElementById(`return_flight_details_${index}`);
            let startFlight = document.getElementById(`route_${index}`).value;
            let endFlight = document.getElementById(`destination_${index}`).value;
            let returnStartFlight = document.getElementById(`return_route_${index}`);
            let returnEndFlight = document.getElementById(`return_destination_${index}`);
            console.log(startFlight);
            returnFlightDetails.style.display = returnFlightDetails.style.display === 'none' ? 'block' : 'none';
            returnStartFlight.value = endFlight;
            returnEndFlight.value = startFlight;
        }

        // Function to calculate the number of days between two dates
        function calculateMealAllowanceDays(startDate, endDate) {
            if (!startDate || !endDate) return 0;

            const start = new Date(startDate);
            const end = new Date(endDate);
            const timeDiff = end - start;
            const days = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Adding 1 to include both start and end dates

            return days;
        }

        // Function to toggle cash advance amount visibility
        function toggleCashAdvanceAmount(index) {
            const checkbox = document.getElementById(`allowance_cash_advance_${index}`);
            const amountDiv = document.getElementById(`cash_advance_amount_div_${index}`);
            amountDiv.style.display = checkbox.checked ? 'block' : 'none';
            updateTotalAmount(index);
        }

        // Function to toggle meal allowance days input visibility
        function toggleMealAllowanceDays(index) {
            const checkbox = document.getElementById(`allowance_meal_allowance_${index}`);
            const daysDiv = document.getElementById(`meal_allowance_days_div_${index}`);
            daysDiv.style.display = checkbox.checked ? 'block' : 'none';
            updateTotalAmount(index);
        }

        // Function to update total amount based on allowances and inputs
        function updateTotalAmount(index) {
            const pocketMoneyChecked = document.querySelectorAll(`input[name="allowance[${index}][]"][value="PocketMoney"]:checked`).length;
            const mealAllowanceChecked = document.querySelectorAll(`input[name="allowance[${index}][]"][value="MealAllowance"]:checked`).length;
            const cashAdvanceAmount = document.getElementById(`cash_advance_amount_${index}`);
            const jobLevel = document.getElementById(`job_level_${index}`).dataset.jobLevel;

            const startDate = document.querySelector(`input[name="start_date"]`).value;
            const endDate = document.querySelector(`input[name="end_date"]`).value;

            const days = calculateMealAllowanceDays(startDate, endDate);

            let pocketMoneyAmount = 0;
            if (pocketMoneyChecked) {
                // Set amount based on job level
                switch (jobLevel) {
                    case 'General Manager':
                    case 'Deputy GM':
                        pocketMoneyAmount = 200000;
                        break;
                    case 'Manager':
                        pocketMoneyAmount = 150000;
                        break;
                    case 'Superintendent':
                    case 'Assistant Manager':
                        pocketMoneyAmount = 110000;
                        break;
                    case 'Supervisor':
                        pocketMoneyAmount = 100000;
                        break;
                    case 'Staff':
                    case 'Foreman':
                        pocketMoneyAmount = 80000;
                        break;
                    default:
                        pocketMoneyAmount = 50000;
                        break;
                }
            }

            let mealAllowanceAmount = 0;
            if (mealAllowanceChecked) {
                // Set amount based on job level
                switch (jobLevel) {
                    case 'General Manager':
                    case 'Deputy GM':
                        mealAllowanceAmount = 300000;
                        break;
                    case 'Manager':
                        mealAllowanceAmount = 270000;
                        break;
                    case 'Superintendent':
                    case 'Assistant Manager':
                        mealAllowanceAmount = 180000;
                        break;
                    case 'Supervisor':
                        mealAllowanceAmount = 150000;
                        break;
                    case 'Staff':
                    case 'Foreman':
                        mealAllowanceAmount = 135000;
                        break;
                    default:
                        mealAllowanceAmount = 120000;
                        break;
                }

                // Use number of days from input if available
                const mealAllowanceDaysInput = document.getElementById(`meal_allowance_days_${index}`);
                const mealDays = mealAllowanceDaysInput.value ? parseFloat(mealAllowanceDaysInput.value) : days;
                mealAllowanceAmount *= mealDays;
            }

            let totalAmount = 0;
            if (pocketMoneyChecked) totalAmount += pocketMoneyAmount * days;
            if (mealAllowanceChecked) totalAmount += mealAllowanceAmount;
            if (cashAdvanceAmount && cashAdvanceAmount.value) totalAmount += parseFloat(cashAdvanceAmount.value) || 0;

            document.getElementById(`total_amount_${index}`).value = totalAmount;

            updateGrandTotal(); // Ensure grand total is updated
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('input[id^="total_amount_"]').forEach(function(input) {
                grandTotal += parseFloat(input.value) || 0;
            });

            document.getElementById('grand_total').value = grandTotal;
        }

        // Event listeners for input changes
        document.querySelectorAll('input[id^="cash_advance_amount_"]').forEach(function(input) {
            input.addEventListener('input', function() {
                const index = this.id.split('_').pop();
                updateTotalAmount(index);
            });
        });

        document.querySelectorAll('input[name^="allowance"]').forEach(function(input) {
            input.addEventListener('change', function() {
                const index = this.id.split('_').pop();
                updateTotalAmount(index);
            });
        });

        document.querySelectorAll('input[id^="meal_allowance_days_"]').forEach(function(input) {
            input.addEventListener('input', function() {
                const index = this.id.split('_').pop();
                updateTotalAmount(index);
            });
        });

        document.querySelectorAll('input[id^="total_amount_"]').forEach(function(input) {
            input.addEventListener('input', updateGrandTotal);
        });

        @foreach(session('names', []) as $index => $name)
            // Initialize flight details and return flight details
            updateTotalAmount({{ $index }});
            toggleFlightDetails({{ $index }});
            toggleReturnFlightDetails({{ $index }});
            
            // Add event listener for the 'Tiket Pulang' button
            document.getElementById(`add_return_ticket_{{ $index }}`).addEventListener('click', function() {
                toggleReturnFlightDetails({{ $index }});
            });
            
            // Add event listener for the checkbox that toggles flight details
            document.getElementById(`transportation_plane_{{ $index }}`).addEventListener('change', function() {
                toggleFlightDetails({{ $index }});
            });
        @endforeach
        // Initialize grand total calculation
        updateGrandTotal();
    </script>
</x-app-layout>