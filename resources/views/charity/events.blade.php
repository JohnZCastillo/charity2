@extends('layouts.charity')

@section('title','Charity')

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

@endsection

@section('body')
    <div class="container py-2 text-primary">

        <div class="py-5">
            <h2 class="text-center fw-bold hero-title">We arrange many social events for charity donations</h2>
        </div>

        <div class="row justify-content-center section-padding">
            @forelse($events as $event)
                <div class="col-lg-9 col-md-12">
                    <div class="">
                        <div class="company-img">
                            <div class="d-flex align-items-center gap-2 pb-2 overflow-auto" id="lightgallery">
                                @foreach($event->images as $image)
                                    <a href="{{\Illuminate\Support\Facades\Storage::url($image->path)}}">
                                        <img style="width: 300px; height: 300px" alt="img1"
                                             src="{{\Illuminate\Support\Facades\Storage::url($image->path)}}"/>
                                    </a>
                                @endforeach
                            </div>
                            <div class="job-tittle">
                                <h2 class="text-capitalize text-heading fw-bold">{{$event->title}}</h2>
                                <p class="mb-2">{{$event->description}}</p>
                                <ul class="row mx-0 list-inline">
                                    <li class="col-12 col-lg-4 mb-2">
                                        <i class="far fa-clock"></i>
                                        <span>Time: {{$event->start->format('h:i a')}}</span>
                                    </li>
                                    <li class="col-12 col-lg-4 mb-2">
                                        <i class="fas fa-sort-amount-down mr-1"></i>
                                        <span>Date: {{$event->start->format('Y-m-d')}}</span>
                                    </li>
                                    <li class="col-12 col-lg-4 mb-2">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Location: {{$event->location}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 d-flex align-items-center justify-content-center" style="height: 300px">
                    <p class="text-secondary mb-0">No Events Yet</p>
                </div>
            @endforelse
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
