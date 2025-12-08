@extends('layouts.charity')

@section('title','Payment Cancelled')

@section('body')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0 p-4 text-center" style="max-width: 500px; border-radius: 20px;">
        <div class="mb-4">
            <div class="bg-danger text-white rounded-circle d-inline-flex justify-content-center align-items-center" 
                 style="width: 100px; height: 100px; font-size: 3rem; animation: shake 0.5s ease;">
                ❌
            </div>
        </div>

        <h2 class="text-danger fw-bold">Payment Cancelled</h2>
        <p class="text-muted">Your payment was not completed. You may try again below.</p>

        <a href="{{ url('/') }}" class="btn btn-lg btn-warning mt-3 shadow-sm px-4" 
           style="border-radius: 30px;">🔄 Try Again</a>
    </div>
</div>

{{-- Small Animation --}}
<style>
@keyframes shake {
  0% { transform: translateX(0); }
  25% { transform: translateX(-5px); }
  50% { transform: translateX(5px); }
  75% { transform: translateX(-5px); }
  100% { transform: translateX(0); }
}
</style>
@endsection
