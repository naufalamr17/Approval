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
            <form action="{{ route('store-form') }}" method="POST">
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
                            <input class="form-check-input" type="checkbox" name="transportation[{{ $index }}][]" value="Plane" id="transportation_plane_{{ $index }}">
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

                <hr>
                @endforeach

                <!-- <div class="mb-3">
                    <label for="grand_total" class="form-label">Grand Total</label>
                    <input type="number" class="form-control" name="grand_total" id="grand_total" required readonly>
                </div> -->

                <button type="submit" class="btn btn-dark">Submit FPD</button>
            </form>

        </div><x-app.footer />
    </main>

    <script>
        function calculateMealAllowanceDays(startDate, endDate) {
            if (!startDate || !endDate) return 0;

            const start = new Date(startDate);
            const end = new Date(endDate);
            const timeDiff = end - start;
            const days = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Adding 1 to include both start and end dates

            return days;
        }

        function toggleCashAdvanceAmount(index) {
            const checkbox = document.getElementById(`allowance_cash_advance_${index}`);
            const amountDiv = document.getElementById(`cash_advance_amount_div_${index}`);
            amountDiv.style.display = checkbox.checked ? 'block' : 'none';
            updateTotalAmount(index);
        }

        function toggleMealAllowanceDays(index) {
            const checkbox = document.getElementById(`allowance_meal_allowance_${index}`);
            const daysDiv = document.getElementById(`meal_allowance_days_div_${index}`);
            daysDiv.style.display = checkbox.checked ? 'block' : 'none';
            updateTotalAmount(index);
        }

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

        document.querySelectorAll('input[name^="cash_advance_amount"]').forEach(function(input) {
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

        document.querySelectorAll('input[name^="meal_allowance_days"]').forEach(function(input) {
            input.addEventListener('input', function() {
                const index = this.id.split('_').pop();
                updateTotalAmount(index);
            });
        });

        document.querySelectorAll('input[id^="total_amount_"]').forEach(function(input) {
            input.addEventListener('input', updateGrandTotal);
        });

        // Initialize calculations
        @foreach (session('names', []) as $index => $name)
            updateTotalAmount({{ $index }});
        @endforeach
        updateGrandTotal(); // Initialize grand total calculation
    </script>

</x-app-layout>