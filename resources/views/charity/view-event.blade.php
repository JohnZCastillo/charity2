@extends('layouts.charity')

@section('title','View Event')

@section('files')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.1/lightgallery.min.js"
            integrity="sha512-n82wdm8yNoOCDS7jsP6OEe12S0GHQV7jGSwj5V2tcNY/KM3z+oSDraUN3Hjf3EgOS9HWa4s3DmSSM2Z9anVVRQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.1/css/lightgallery-bundle.min.css"
          integrity="sha512-fXavT4uA4L0uTUFHC275D7zd751ohbSuD6VUMc5JysWfmR+NxTI3w7etE7N9hjTETcoh0w0V+24Cel4xXnqvCg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.1/plugins/thumbnail/lg-thumbnail.umd.min.js"
            integrity="sha512-LSba/xXeuJPM4UOIjCD/+BHni4hA4YEhZ/2j10PioYCViZdDrUrPYAHuWDm247bpVj3DujAbeBseqkHbMUUzDA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.8.1/plugins/zoom/lg-zoom.umd.min.js"
            integrity="sha512-kb+bFSTztWA/jCvJQJ+fQdvjsD1zUJ3FNVvhkZg4boL4DA2j8PytzjFFoXepCstLzW4fBX/mACT2d8yTmjGZSg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .event-wrapper {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .event-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .event-header h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #0d2c66;
        }

        .event-body {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            gap: 1.5rem;
        }

        .event-body .event-image {
            flex: 0 0 300px;
            max-width: 300px;
        }

        .event-body .event-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }

        .event-body .event-details {
            flex: 1;
            color: #333;
        }

        .event-details h3 {
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            color: #111;
        }

        .event-details p {
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            color: #444;
        }

        .event-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            font-size: 1rem;
            color: #222;
        }

        .event-meta div i {
            margin-right: 6px;
        }

        .back-btn {
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('body')
    <div class="container py-4">

        <!-- Back Button -->
        <div class="back-btn">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- Event Card -->
        <div class="event-wrapper">

            <!-- Heading -->
            <div class="event-header">
                <h2>We arrange many social events for charity donations</h2>
            </div>

            <!-- Event Body -->
            <div class="event-body">

                <!-- Image -->
                <div class="event-image" id="lightgallery">
                    @if($event->images->count() > 0)
                        <a href="{{ Storage::url($event->images->first()->path) }}">
                            <img src="{{ Storage::url($event->images->first()->path) }}" alt="Event Image">
                        </a>
                    @else
                        <img src="/default-event.png" alt="Default Event Image">
                    @endif
                </div>

                <!-- Details -->
                <div class="event-details">
                    <h3>{{ $event->title }}</h3>
                    <p>{{ $event->description }}</p>

                    <div class="event-meta">
                        <div><i class="far fa-clock text-success"></i> <strong>Time:</strong> {{ $event->start->format('h:i a') }}</div>
                        <div><i class="fas fa-calendar-alt text-primary"></i> <strong>Date:</strong> {{ $event->start->format('F j, Y') }}</div>
                        <div><i class="fas fa-map-marker-alt text-danger"></i> <strong>Location:</strong> {{ $event->location }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        lightGallery(document.getElementById('lightgallery'), {
            plugins: [lgZoom, lgThumbnail],
            licenseKey: 'your_license_key',
            speed: 500,
            thumbnail: true,
            download: false,
        });
    </script>
@endsection
