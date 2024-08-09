<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container bg-white border-radius-lg">
            <h2 class="pt-2">Edit Employee</h2>
            <hr>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('update-employee', $employee->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <div id="user-fields">
                    <div class="user-group">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $employee->nik) }}" required>
                            @error('nik')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $employee->nama) }}" required>
                            @error('nama')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" name="organization" id="organization" class="form-control" value="{{ old('organization', $employee->organization) }}" required>
                            @error('organization')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="job_position" class="form-label">Job Position</label>
                            <input type="text" name="job_position" id="job_position" class="form-control" value="{{ old('job_position', $employee->job_position) }}" required>
                            @error('job_position')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="job_level" class="form-label">Job Level</label>
                            <input type="text" name="job_level" id="job_level" class="form-control" value="{{ old('job_level', $employee->job_level) }}" required>
                            @error('job_level')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="branch_name" class="form-label">Branch Name</label>
                            <input type="text" name="branch_name" id="branch_name" class="form-control" value="{{ old('branch_name', $employee->branch_name) }}" required>
                            @error('branch_name')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="poh" class="form-label">POH</label>
                            <input type="text" name="poh" id="poh" class="form-control" value="{{ old('poh', $employee->poh) }}">
                            @error('poh')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark" id="submit-button">Update</button>
            </form>

        </div><x-app.footer />
    </main>
</x-app-layout>