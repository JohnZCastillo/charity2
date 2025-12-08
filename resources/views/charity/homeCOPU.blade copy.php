@extends('layouts.charity')

@section('title','Charity')

@section('body')
    @php
        use App\Models\HomeContent;

         $home = HomeContent::first();

     @endphp
    <div class="slider-area hero-container py-5" style="background-image: url('{{ asset($home->hero_image ?? 'img/hero/hero.png') }}'); background-repeat: no-repeat; background-size: unset; background-position: center;">
        <div class="slider-active">
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10">
                            <div class="hero__caption text-primary">
                               <h1 data-animation="fadeInUp" data-delay=".6s" class="fw-bold hero-title">
                                {!! nl2br(e($home->main_title)) !!}
                                </h1>

                                <p data-animation="fadeInUp" data-delay=".8s">
                                    {!! nl2br(e($home->sub_title)) !!}
                                </p>

                                <div class="row mx-0 gap-1 align-items-center ">

                                    <div class="col-12 col-md-4">

                                        <button type="button" data-bs-toggle="modal" data-bs-target="#donateMoneyModal"
                                        class="btn btn-success text-white rounded-0 px-5 py-3"
                                        data-animation="fadeInLeft"
                                        data-delay=".8s">
                                        {{ $home->cta_button ?? 'Donate' }}
                                        </button>

                                    </div>

                                    <div class="col-12 col-md-5">
                                        <a href="#"
                                           class="d-flex align-items-center text-decoration-none gap-2"
                                           data-animation="fadeInRight" data-delay="1.0s">
                                            <i class="flaticon-null text-success" style="font-size: 30px"></i>
                                            <p class="mb-0"> {{ $home->telephone ?? '' }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="our-cases-area section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-10 col-sm-10">
                    <div class="text-primary text-center mb-5">
                        <span class="text-success fw-bold">Our Announcement and Fund Raising you can see</span>
                        <h2 class="fw-bold text-title">Explore our latest Fund <br> Raising </h2>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                @foreach($donations as $donation)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="single-cases mb-40">
                            <div class="overflow-hidden">
                                <img class="w-100 scale" style="height: 340px"
                                     src="{{\Illuminate\Support\Facades\Storage::url($donation->image)}}" alt="">
                            </div>
                            <div class="cases-caption">
                                <h3><a class="text-decoration-none" href="#">{{$donation->title}}</a></h3>
                                <!-- Progress Bar -->
                                <div class="single-skill mb-15">
                                    <div class="bar-progress">
                                        <div id="bar1" class="barfiller">
                                            <div class="tipWrap">
                                                <span class="tip"></span>
                                            </div>
                                            <span class="fill"
                                                  data-percentage="{{\App\Helpers\CurrencyFormatter::percent($donation->raised, $donation->goal)}}"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="prices d-flex justify-content-between text-primary">
                                    <p>
                                        Raised:<span> {{\App\Helpers\CurrencyFormatter::currency($donation->raised)}}</span>
                                    </p>
                                    <p>Goal:<span> {{\App\Helpers\CurrencyFormatter::currency($donation->goal)}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <section class="featured-job-area section-padding section-bg2"
             data-background="assets/img/gallery/section_bg03.png">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 col-md-10 col-sm-12">
                    <!-- Section Tittle -->
                    <div class="text-primary text-center mb-5">
                        <span class="text-success fw-bold">What we are doing</span>
                        <h2 class="fw-bold text-title">We arrange many social events for charity donations</h2>
                    </div>
                </div>
            </div>
            <div class="row mx-0 align-items-center">
                @foreach($events as $event)
                    <div class="col-12 mb-2">
                        <div class="row mx-0">
                            <div class="col-12 col-md-3 overflow-hidden">
                                <img style="height: 340px" class="w-100 scale"
                                     src="{{\Illuminate\Support\Facades\Storage::url($event->image->path)}}">
                            </div>
                            <div class="col-12 col-md-9">
                                <div class="d-flex align-items-center justify-content-start h-100">
                                    <div>
                                        <a class="text-decoration-none" href="#">
                                            <h4 class="text-capitalize text-sub-title fw-bold">{{$event->title}}</h4>
                                        </a>
                                        <div
                                            class="d-flex flex-column gap-2 flex-lg-row gap-lg-5 w-100 text-primary text-capitalize">
                                            <p class="mb-0"><i
                                                    class="far fa-clock me-2"></i>Time: {{$event->start->format('H:i a')}}
                                            </p>
                                            <p class="mb-0"><i
                                                    class="fas fa-sort-amount-down me-2"></i>Date: {{$event->start->format('M d, Y')}}
                                            </p>
                                            <p class="mb-0"><i
                                                    class="fas fa-map-marker-alt me-2"></i>Place: {{$event->place}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="container section-padding">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-10">
                <!-- Section Tittle -->
                <div class="text-primary text-center mb-5">
                    <span class="text-success fw-bold">{{$home->section_title  ?? 'What we are doing'}}</span>
                    <h2 class="fw-bold text-title">{{$home->section_subtitle  ?? 'Default Sub Title'}}</h2>
                </div>
            </div>
        </div>
       <div class="row">
            @foreach ($home->section_cards ?? [] as $card)
                <div class="mb-2 col-12 col-lg-4">
                    <div class="h-100 text-center {{ $loop->index === 1 ? 'bg-success rounded p-2' : '' }}">
                        <div class="{{ $loop->index === 1 ? 'text-white' : 'text-primary' }}">
                            <h5 class="fw-bold mb-3">{{ $card['title'] ?? 'Untitled' }}</h5>
                            <p class="{{ $loop->index === 1 ? '' : 'text-secondary' }}">
                                {{ $card['description'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

<section class="container section-padding">
    <div class="row mx-0">
        <div class="col-lg-6 col-12">
            <div class="text-primary">
                <div class="fw-bold mb-3">
                    <span class="text-success">{{ $home->about_subtitle ?? 'About Our Charity' }}</span>
                    <h2 class="text-title fw-bold">{{ $home->about_title ?? 'Default Title' }}</h2>
                </div>
                <p>
                    {{ $home->about_description ?? 'About Us' }}
                </p>
                <a href="/charity/about-us" class="fw-bold btn btn-success px-4 py-2 rounded-0 text-white">About US</a>
            </div>
        </div>

        <div class="col-lg-6 d-none d-lg-block position-relative">
            @if(!empty($home->about_images) && is_array($home->about_images))
                @foreach($home->about_images as $index => $image)
                    <div class="position-absolute {{ $loop->first ? 'top-0 end-0' : 'bottom-0 start-0 pt-2 pe-2 bg-success shadow' }}"
                         style="{{ $loop->first ? 'top: -50px; right: 0;' : 'bottom: -50px; left: 0; z-index: 5;' }}">
                        <img src="{{ $image }}" style="{{ $loop->first ? 'width: 354px; height: 453px;' : 'width: 250px; height: 288px;' }}">
                    </div>
                @endforeach
            @else
                {{-- fallback if no images --}}
                <div class="position-absolute" style="top: -50px; right: 0">
                    <img src="/img/gallery/gallery-1.jpeg" style="width: 354px; height: 453px">
                </div>
                <div class="position-absolute pt-2 pe-2 bg-success shadow" style="bottom: -50px; left: 0; z-index: 5">
                    <img src="/img/gallery/gallery-2.jpeg" style="width: 250px; height: 288px">
                </div>
            @endif
        </div>
    </div>
</section>


@foreach ($home->additional_sections ?? [] as $i => $section)
    <section class="py-5 {{ $i % 2 == 0 ? 'bg-light' : 'bg-white' }}">
        <div class="container">
            <div class="row align-items-center g-4">

                <!-- Text Section -->
                <div class="col-lg-6 {{ $i % 2 == 1 ? 'order-lg-2' : '' }}">
                    <div class="p-4 bg-white shadow rounded h-100">
                        @if (!empty($section['subtitle']))
                            <h6 class="text-uppercase text-success fw-semibold mb-2">{{ $section['subtitle'] }}</h6>
                        @endif

                        <h3 class="fw-bold text-primary mb-3">
                            {{ $section['title'] ?? 'Untitled Section' }}
                        </h3>

                        <p class="text-secondary mb-4">
                            {{ $section['description'] ?? 'No description available.' }}
                        </p>

                        @if (!empty($section['button_text']) && !empty($section['button_link']))
                            <a href="{{ $section['button_link'] }}" class="btn btn-success text-white fw-semibold px-4 py-2">
                                {{ $section['button_text'] }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Image Section -->
                <div class="col-lg-6 {{ $i % 2 == 1 ? 'order-lg-1' : '' }}">
                    @if (!empty($section['image']))
                        <div class="position-relative">
                            <img src="{{ asset($section['image']) }}" class="img-fluid rounded shadow-lg" style="object-fit: unset; height: 100%; max-height: 460px;">
                        </div>
                    @else
                        <div class="bg-secondary-subtle d-flex justify-content-center align-items-center rounded" style="height: 300px;">
                            <span class="text-muted">No Image Provided</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endforeach

<!-- Team Section -->
<section class="container section-padding">
    <div class="row mx-0 justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-10 col-sm-10">
            <div class="text-primary text-center mb-5">
                <span class="text-success fw-bold">{{ $home->section_title ?? 'Team' }}</span>
                <h2 class="text-title fw-bold">{{ $home->team_title ?? 'Team Members' }}</h2>
            </div>
        </div>
    </div>
    <div class="row mx-0">
        @foreach ($home->team_members ?? [] as $member)
            <div class="col-lg-3 col-sm-6 col-12 mb-4">
                <div class="single-team">
                    <div class="team-img">
                        <img class="w-100" style="height: 340px; object-fit: unset;" src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}">
                    </div>
                    <div class="team-caption text-center mt-2">
                        <p class="text-secondary fw-bold">{{ $member['name'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>


</div>
</div>
    <div class="modal fade" id="donateMoneyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-primary">
                <form method="POST" action="/charity/check-donate">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Donate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>What would you like to donate?</h3>
                        <div class="mb-2">
                            <label for="type">Type</label>
                            <select id="type" class="form-select" name="type" required>
                                <option value="gcash">Cash (GCash)</option>
                                <option value="cash">Cash (Personal)</option>
                                <option value="goods">Goods</option>
                                <option value="medicines">Medicines</option>
                                <option value="clothes">Clothes</option>
                                <option value="supplies">Supplies</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success text-white">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
