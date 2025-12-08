@extends('layouts.charity')

@section('title','Charity')

@section('body')

@php
        use App\Models\HomeContent;

         $home = HomeContent::first();

     @endphp
    <div class="container section-padding text-primary announcement-holder">


        @if(\Illuminate\Support\Facades\Session::get('message'))
            <div class="alert alert-success" role="alert">
                {{\Illuminate\Support\Facades\Session::get('message')}}
            </div>
        @endif


        <div class="row mx-0">
            <div class="col-12 col-md-6">
                <div class="d-flex align-items-center justify-content-center">
                     @if (!empty($home->qr_code_path))
                            <img src="{{ asset($home->qr_code_path) }}" style="width: 400px; height: 400px" class="rounded shadow">
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-6 bg-light p-2">
                <form method="post" action="/charity/donate" enctype="multipart/form-data">

                    @csrf
                    <div class="mb-2">
                        <label>Receipt</label>
                        <input type="file" class="form-control" name="receipt" accept="image/*" required>
                    </div>

                    <div class="mb-2">
                        <label>Name </label>
                        <input type="text" class="form-control" name="from" required>
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-2">
                        <label>Amount</label>
                        <input type="number" min="0" class="form-control" name="amount" required>
                    </div>

                    <div class="mb-2">
                        <label>Donation Drive</label>
                        <select class="form-select" name="donation_drive_id" required>
                            @foreach($drives as $drive)
                                <option value="{{$drive->id}}">{{$drive->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-success">Donate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
