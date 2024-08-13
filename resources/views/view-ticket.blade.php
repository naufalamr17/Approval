<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />

        <div class="container bg-white border-radius-lg">
            <h1 class="pt-2">Edit Ticket Request</h1>
            <hr>

            <form action="{{ route('update-ticket-request', $ticketRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $ticketRequest->nik) }}" readonly>
                    @error('nik')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="poh" class="form-label">POH</label>
                    <input type="text" class="form-control" id="poh" name="poh" value="{{ old('poh', $ticketRequest->poh) }}">
                    @error('poh')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ old('jenis', $ticketRequest->jenis) }}">
                    @error('jenis')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $ticketRequest->start_date) }}">
                        @error('start_date')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $ticketRequest->end_date) }}">
                        @error('end_date')
                        <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="flight_date" class="form-label">Tanggal Penerbangan</label>
                    <input type="date" class="form-control" id="flight_date" name="flight_date" value="{{ old('flight_date', $ticketRequest->flight_date) }}">
                    @error('flight_date')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="route" class="form-label">Rute</label>
                    <input type="text" class="form-control" id="route" name="route" value="{{ old('route', $ticketRequest->route) }}">
                    @error('route')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="departure_airline" class="form-label">Maskapai Keberangkatan</label>
                    <input type="text" class="form-control" id="departure_airline" name="departure_airline" value="{{ old('departure_airline', $ticketRequest->departure_airline) }}">
                    @error('departure_airline')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="flight_time" class="form-label">Waktu Penerbangan</label>
                    <input type="time" class="form-control" id="flight_time" name="flight_time" value="{{ old('flight_time', $ticketRequest->flight_time) }}">
                    @error('flight_time')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $ticketRequest->status) }}">
                    @error('status')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $ticketRequest->price) }}">
                    @error('price')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Catatan</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="4">{{ old('remarks', $ticketRequest->remarks) }}</textarea>
                    @error('remarks')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ticket_screenshot" class="form-label">Screenshot Tiket</label>
                    <input type="file" class="form-control" id="ticket_screenshot" name="ticket_screenshot" accept="image/*">
                    @if ($ticketRequest->ticket_screenshot)
                    <img src="{{ asset('storage/' . $ticketRequest->ticket_screenshot) }}" alt="Current Screenshot" class="img-fluid mt-2" style="max-width: 50%;">
                    @endif
                    @error('ticket_screenshot')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <a href="{{ route('ticket-request') }}" class="btn btn-white">Cancel</a>
                <button type="submit" class="btn btn-dark">Update</button>
            </form>
        </div>

        <x-app.footer />
    </main>

    <!-- Include Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</x-app-layout>