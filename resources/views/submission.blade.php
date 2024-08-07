<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />

        <div class="container bg-white border-radius-lg">
            <h2 class="pt-2">Pengajuan</h2>
            <hr>

            <form action="{{ route('store-submission') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis" id="jenis" class="form-control jenis-select" required>
                        <option value="" disabled selected>Pilih Jenis</option>
                        <option value="Cuti Roster">Cuti Roster</option>
                        <option value="Onboarding">Onboarding</option>
                        <option value="PerDin">PerDin (Perjalanan Dinas)</option>
                        <option value="Onsite">Onsite</option>
                    </select>
                    @error('jenis')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark" name="submit_button" value="submit">Submit</button>
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

</x-app-layout>