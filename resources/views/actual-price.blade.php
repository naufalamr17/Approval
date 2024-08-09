<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container bg-white border-radius-lg">
            <h2 class="pt-2">Input Actual Price</h2>
            <hr>

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('update-actual', $price->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <div id="user-fields">
                    <div class="user-group">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $price->price) }}" readonly>
                            @error('price')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="actual_price" class="form-label">Actual Price</label>
                            <input type="text" name="actual_price" id="actual_price" class="form-control" required>
                            @error('actual_price')
                            <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="same_as_price">
                            <label class="form-check-label" for="same_as_price">Same as Initial Price</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark" id="submit-button">Update</button>
            </form>

        </div>
        <x-app.footer />
    </main>
</x-app-layout>

<script>
    document.getElementById('same_as_price').addEventListener('change', function() {
        const actualPriceInput = document.getElementById('actual_price');
        const initialPrice = document.getElementById('price').value;

        if (this.checked) {
            actualPriceInput.value = initialPrice;
        } else {
            actualPriceInput.value = '';
        }
    });
</script>