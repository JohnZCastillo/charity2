@extends('layouts.charity')

@section('title','View Announcement')

@section('styles')
    <style>
        .announcement-holder {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
        }

        .announcement-holder h2 {
            font-size: 2rem;
            color: #198754; /* Bootstrap success color */
            margin-bottom: 1rem;
        }

        .announcement-holder p {
            margin-bottom: 1rem;
            line-height: 1.6;
            font-size: 1.05rem;
        }

        .announcement-holder img {
            display: block;
            margin: 1rem auto;
            border-radius: 10px;
            max-width: 100%;
            max-height: 600px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .back-btn {
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('body')
    <div class="container section-padding">
        <div class="back-btn">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="announcement-holder mx-auto">
            <h2 class="fw-bold">{{$announcement->title}}</h2>
            <div class="announcement-content">
                {!! $announcement->content !!}
            </div>
        </div>
    </div>
@endsection
