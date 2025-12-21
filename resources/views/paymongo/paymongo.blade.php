@extends('layouts.charity')

@section('title','Charity')

@section('body')
<div class="container p-5 ">
    <form id="payment-form" class="card p-4 shadow rounded"  action="{{ route('payment.checkout') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h4 class="mb-3 text-center">Pay with GCash</h4>

        <div class="row">
            <div class="col-12 col-md-6">
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

                 {{-- Donor Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Attach Receipt</label>
                    <input type="file" name="receipt" id="receipt" class="form-control" required>
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

            </div>
            <div class="col-12 col-md-6">
                 <img src="{{Storage::url('qr_image.jpg')}}" alt="profile Pic" class="img-fluid">
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100 fw-bold">
            <i class="bi bi-wallet2"></i> Pay with GCash
        </button>

        <div id="payment-status" class="mt-3 text-center"></div>
    </form>
</div>

@endsection