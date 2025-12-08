@extends('layouts.charity')

@section('title','Charity')

@section('body')
<div class="container">
    <form id="payment-form" class="card p-4 shadow rounded" style="max-width: 400px; margin: auto;">
        @csrf
        <h4 class="mb-3 text-center">Pay with GCash</h4>

        {{-- Donor Name --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Your Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Juan Dela Cruz" required>
        </div>

        {{-- Donor Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="juan@email.com" required>
        </div>
        {{-- Donor Mobile --}}
        <div class="mb-3">
            <label for="mobile" class="form-label fw-bold">Mobile Number</label>
            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="09171234567" required>
        </div>
        {{-- Amount --}}
        <div class="mb-3">
            <label for="amount" class="form-label fw-bold">Enter Amount (₱)</label>
            <div class="input-group">
                <span class="input-group-text">₱</span>
                <input type="number" name="amount" id="amount" class="form-control" placeholder="100" required min="1">
            </div>
        </div>

        {{-- Donation Drive --}}
        <div class="mb-3">
            <label for="donation_drive_id" class="form-label fw-bold">Donation Drive</label>
            <select class="form-select" name="donation_drive_id" id="donation_drive_id" required>
                @foreach($drives as $drive)
                    <option value="{{ $drive->id }}">{{ $drive->title }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100 fw-bold">
            <i class="bi bi-wallet2"></i> Pay with GCash
        </button>

        <div id="payment-status" class="mt-3 text-center"></div>
    </form>
</div>

<script>
document.getElementById('payment-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        mobile: document.getElementById('mobile').value,
        amount: document.getElementById('amount').value,
        donation_drive_id: document.getElementById('donation_drive_id').value
    };

    let statusBox = document.getElementById('payment-status');
    statusBox.innerHTML = '<div class="text-info">Processing payment...</div>';

    try {
        let response = await fetch("{{ route('payment.checkout') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(formData)
        });

        let data = await response.json();

        if (data.checkout_url) {
            statusBox.innerHTML = '<div class="text-success">Redirecting to GCash...</div>';
            window.location.href = data.checkout_url;
        } else {
            statusBox.innerHTML = '<div class="text-danger">Error: ' + (data.message || 'Unable to process payment') + '</div>';
        }
    } catch (error) {
        statusBox.innerHTML = '<div class="text-danger">Something went wrong. Please try again.</div>';
        console.error(error);
    }
});
</script>
@endsection
