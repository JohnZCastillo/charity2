@extends('layouts.charity')

@section('title','Payment Success')

@section('body')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 p-4 text-center" style="max-width: 500px; border-radius: 20px;">
        <div class="mb-4">
            <div class="bg-success text-white rounded-circle d-inline-flex justify-content-center align-items-center" 
                 style="width: 100px; height: 100px; font-size: 3rem; animation: pop 0.5s ease;">
                ✅
            </div>
        </div>
        
        <h2 class="text-success fw-bold">Payment Successful!</h2>
        <p class="text-muted">
            🎉 Thank you for supporting our cause. Your transaction has been completed successfully.
        </p>

        {{-- Show donation details --}}
        @if(isset($drive) && isset($amount))
            <div class="mt-3">
                <h5 class="fw-bold">Donation Drive:</h5>
                <p class="text-dark">{{ $drive->title }}</p>

                <h5 class="fw-bold">Amount Donated:</h5>
                <p class="text-dark">₱{{ number_format($amount, 2) }}</p>
            </div>
        @endif

        {{-- Show receipt if available --}}
        @if(isset($receipt) && $receipt)
            <div class="mt-4">
                <a href="{{ $receipt }}" target="_blank" 
                   class="btn btn-outline-success shadow-sm px-4" style="border-radius: 30px;">
                    📄 View Official Receipt
                </a>
            </div>
        @endif

        <a href="{{ url('/') }}" class="btn btn-lg btn-primary mt-4 shadow-sm px-4" 
           style="border-radius: 30px;">Go Back Home</a>
    </div>
</div>

{{-- Small Animation --}}
<style>
@keyframes pop {
  0% { transform: scale(0.5); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
</style>
@endsection
