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

            <form action="{{ route('store-form') }}" method="POST">
                @csrf

                <!-- No and Date -->
                <div class="mb-3">
                    <label for="no_surat" class="form-label">No</label>
                    <input type="text" class="form-control" name="no_surat" value="{{ $formPerdin->no_surat }}" readonly>
                </div>

                <!-- Business Trip Details -->
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $formPerdin->start_date }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $formPerdin->end_date }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="activity_purpose" class="form-label">Activity Purpose</label>
                    <textarea class="form-control" name="activity_purpose" rows="3" readonly>{{ $formPerdin->activity_purpose }}</textarea>
                </div>

                <hr>

                <!-- Single NIK Form -->
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $formPerdin->name }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="nik" class="form-label">NIK Karyawan</label>
                        <input type="text" class="form-control" name="nik" id="nik" value="{{ $formPerdin->nik }}" readonly>
                    </div>
                </div>

                <!-- Transportasi, Akomodasi, dan Uang Saku -->
                <div class="mb-3 row">
                    <!-- Transportation Options -->
                    <div class="col-md-4">
                        <label class="form-label">Transportation</label>
                        @foreach (json_decode($formPerdin->transportation, true) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="transportation[]" value="{{ $option }}" id="transportation_{{ $option }}" checked disabled>
                            <label class="form-check-label" for="transportation_{{ $option }}">
                                {{ $option }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Accommodation Options -->
                    <div class="col-md-4">
                        <label class="form-label">Accommodation</label>
                        @foreach (json_decode($formPerdin->accommodation, true) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="accommodation[]" value="{{ $option }}" id="accommodation_{{ $option }}" checked disabled>
                            <label class="form-check-label" for="accommodation_{{ $option }}">
                                {{ $option }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Money Pocket & Meal Allowance -->
                    <div class="col-md-4">
                        <label class="form-label">Money Pocket & Meal Allowance</label>
                        @foreach (json_decode($formPerdin->allowance, true) as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowance[]" value="{{ $option }}" id="allowance_{{ $option }}" checked disabled>
                            <label class="form-check-label" for="allowance_{{ $option }}">
                                {{ $option }}
                            </label>
                        </div>
                        @endforeach

                        @if (in_array('CashAdvance', json_decode($formPerdin->allowance, true)))
                        <div class="mb-3" id="cash_advance_amount_div" style="display: block;">
                            <label for="cash_advance_amount" class="form-label">Jumlah Cash Advance</label>
                            <input type="number" class="form-control" name="cash_advance_amount" id="cash_advance_amount" value="{{ $formPerdin->cash_advance_amount }}">
                        </div>
                        @else
                        <div class="mb-3" id="cash_advance_amount_div" style="display: none;">
                            <label for="cash_advance_amount" class="form-label">Jumlah Cash Advance</label>
                            <input type="number" class="form-control" name="cash_advance_amount" id="cash_advance_amount">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="number" class="form-control" name="total_amount" id="total_amount" value="{{ $formPerdin->total_amount }}" readonly>
                </div>

                <hr>

                <button type="submit" class="btn btn-dark">Submit FPD</button>
            </form>
        </div><x-app.footer />
    </main>

    <script>
        function toggleCashAdvanceAmount() {
            const checkbox = document.querySelector('input[name="allowance[]"][value="CashAdvance"]');
            const amountDiv = document.getElementById('cash_advance_amount_div');
            amountDiv.style.display = checkbox.checked ? 'block' : 'none';
        }

        // Initialize
        toggleCashAdvanceAmount();
    </script>
</x-app-layout>