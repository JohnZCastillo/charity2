@extends('layouts.charity')

@section('title','About Us')

@section('files')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    {{-- AOS CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #F5F5F5;
        color: #2f3b2e;
    }
    .vision-card .card-container {
    margin-right: 15px;
    }

    @media (max-width: 991px) {
        .vision-card .card-container {
            margin-right: 0;
        }
    }

    .section-padding {
    padding: 40px 5px; /* reduced vertical padding */
    }

    .container.section-padding + .container.section-padding {
    padding-top: 30px;
    padding-bottom: 30px;
    }

    .hero-header {
        background-color: #e8dfd3; /* beige */
        padding: 60px 20px;
        text-align: center;
    }

    .hero-header h2 {
        color: #3b4d3a;
        font-weight: 600;
    }

    /* Wrapper for each alternating section */
    .alt-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 24px;
        gap: 30px; /* consistent spacing */
        background-color: #fff; /* white spacing around item */
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        /* Removed position: relative */
    }

    /* Reverse order for even sections */
    .alt-section.flex-row-reverse {
        flex-direction: row-reverse;
    }

    .alt-section .image-wrapper {
        flex: 1 1 50%;
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        width: 100%;
        max-width: 600px;    /* max width of image container */
        max-height: 400px;   /* max height to prevent huge images */
        height: 400px;       /* fixed height for consistent box size */
        /* Removed padding-top */
    }

    .alt-section .image-wrapper img {
        position: absolute;
        top: 50%;
        left: 50%;
        width: auto;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        transform: translate(-50%, -50%);
        object-fit: contain; /* show full image without cropping */
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .alt-section .text-box {
        flex: 1 1 40%;
        background-color: #e8dfd3; /* beige */
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        position: relative; /* changed from absolute */
        max-width: 400px;
        color: #2f3b2e;
        /* Removed top, right, left, transform */
    }

    /* Text styling */
    .text-box h3 {
        font-style: italic;
        font-weight: 600;
        margin-bottom: 20px;
        color: #3b4d3a;
    }

    .text-box p, .text-box ul {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #2f3b2e;
    }

    .text-box ul {
        padding-left: 20px;
        margin-top: 0;
    }

    .text-box li {
        margin-bottom: 8px;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .alt-section {
            flex-direction: column !important;
        }

        .alt-section .image-wrapper {
            height: auto; /* allow natural height */
            max-height: none;
            width: 100%;
        }

        .alt-section .text-box {
            max-width: 100%;
            margin-top: 20px;
            padding: 20px 15px;
            box-shadow: none;
            background-color: transparent;
            border-radius: 0;
            position: relative;
        }
    }

    /* Section Cards */
    .card-container {
        background-color: #e8dfd3; /* beige */
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .highlight-card {
        background-color: #3b4d3a;
        color: #fff;
        border-radius: 20px;
        padding: 30px;
    }

    .highlight-card h5,
    .highlight-card p {
        color: #fff;
    }

    /* Team Cards */
    .team-card img {
        border-radius: 20px;
        height: 280px;
        object-fit: unset;
    }

    h2.text-title {
        color: #3b4d3a;
        font-weight: 700;
    }
</style>

@endsection

@section('body')
@php
    use App\Models\AboutContent;
    use App\Models\HomeContent;

    $aboutSections = AboutContent::orderBy('order')->get()->groupBy('group');
    $home = HomeContent::first();
@endphp

<div class="text-primary">

    {{-- HERO SECTION --}}
    <div class="hero-header" data-aos="fade-down">
        <h2>About Us</h2>
    </div>

    {{-- ABOUT SECTIONS --}}
    <div class="container section-padding">
        @if($aboutSections->has('general'))
            @foreach($aboutSections['general']->whereIn('type', ['text','image','list']) as $section)
                <div 
                    class="row p-5 bg-white shadow rounded mb-3   {{ $loop->iteration % 2 == 0 ? 'flex-row-reverse' : '' }}"
                    data-aos="{{ $loop->iteration % 2 == 0 ? 'fade-left' : 'fade-right' }}"
                >
                    <div class="col-sm col-md-6 image-wrapper mb-3">
                        @if($section->image)
                            <img  style="max-height: 400px;" class="img-fluid  w-100" src="{{ $section->image }}" alt="{{ $section->title }}">
                        @endif
                    </div>
                    <div class="col-sm col-md-6 text-box">
                        <h3 class="mb-2"><em>{{ $section->title }}</em></h3>
                        @if($section->type === 'list')
                            <ul>
                                @foreach(explode("\n", $section->content) as $item)
                                    @if(trim($item) !== '')
                                        <li>{{ trim($item) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $section->content }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- SECTION CARDS --}}
    <div class="container section-padding">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10 text-center" data-aos="fade-up">
                <span  class="text-success fw-bold">{{ $home->section_title ?? 'What we are doing' }}</span>
                <h2 class="fw-bold text-title text-white">{{ $home->section_subtitle ?? 'Default Sub Title' }}</h2>
            </div>
        </div>
        <div class="row mt-4">
            @foreach ($home->section_cards ?? [] as $card)
                <div class="col-lg-4 col-md-6 col-12 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="{{ $loop->index === 1 ? 'highlight-card' : 'card-container text-primary' }}">
                        <h5 class="fw-bold mb-3">{{ $card['title'] ?? 'Untitled' }}</h5>
                        <p>{{ $card['description'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- VISION / MISSION / OBJECTIVES --}}
@if($aboutSections->has('vision_mission'))
<div class="container section-padding text-center vision-card">
    <div class="row g-4 justify-content-center">
        @foreach($aboutSections['vision_mission'] as $section)
            <div class="col-md-4 col-sm-6 col-12 p-3 card-container" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 150 }}">
                <h3 class="fw-bold">{{ $section->title }}</h3>
                <p>{{ $section->content }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif


    {{-- PROGRAMS --}}
    <div class="container section-padding">
        <h2 class="fw-bold text-title text-center text-white" data-aos="fade-up">Programs</h2>
        @foreach(['programs', 'spiritual_activities', 'eligibility', 'referral_system'] as $group)
            @if($aboutSections->has($group))
                @foreach($aboutSections[$group]->where('type', 'list') as $section)
                    <div class="mb-4 card-container" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <h3>{{ $section->title }}</h3>
                        <ul>
                            @foreach(explode("\n", $section->content) as $item)
                                <li>{{ trim($item) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>

    {{-- TEAM MEMBERS --}}
    <section class="container section-padding">
        <div class="text-center text-white" data-aos="fade-up">
            <span class="text-success fw-bold">{{ $home->section_title ?? 'Team' }}</span>
            <h2 class="text-title fw-bold">{{ $home->team_title ?? 'Team Members' }}</h2>
        </div>
        <div class="row">
            @foreach ($home->team_members ?? [] as $member)
                <div class="col-lg-3 col-sm-6 col-12 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="team-card card-container text-center">
                        <img class="w-100 mb-3" src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}">
                        <p class="fw-bold">{{ $member['name'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>



    {{-- AOS JS --}}
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
        });
    </script>
@endsection
