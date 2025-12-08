@extends('layouts.charity')

@section('title','Charity')

@section('styles')
    <style>
        .announcement-holder p {
            margin: 0;
        }

        .announcement-holder img {
            max-width: 100%;
            max-height: 600px;
        }

    </style>
@endsection

@section('body')
    <div class="container section-padding text-primary announcement-holder">
        @forelse($announcements as $announcement)

            <div class="mx-auto">

                <h2 class="text-heading fw-bold text-success">{{$announcement->title}}</h2>

                <div>
                    {!! $announcement->content !!}
                </div>
            </div>

            <hr class="mb-2">
        @empty

            <div class="d-flex align-items-center justify-content-center" style="height: 400px">
                <p class="text-secondary">No Announcement Yet</p>
            </div>
        @endforelse
    </div>
@endsection
