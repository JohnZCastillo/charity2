@extends('layouts.charity')

@section('title','Charity')

@section('body')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @php
        use App\Models\HomeContent;

         $home = HomeContent::first();

     @endphp
    <style>
    section {
    margin-top: 80px;
    margin-bottom: 80px;
    }

    .hero-container {
        position: relative;
        min-height: 600px;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* Curved background overlay */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.85);
        clip-path: ellipse(85% 100% at 10% 50%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 3rem;
        line-height: 1.2;
    }

    .hero-carousel img {
        object-fit: unset;
        height: 450px;
        border-radius: 15px;
    }
    .announcement-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s ease;
    }

    .announcement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.1);
    }

    .announcement-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #198754;
    }

    .announcement-meta {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .no-announcement {
        text-align: center;
        font-size: 1.2rem;
        color: #6c757d;
        font-style: italic;
    }

</style>

<div class="slider-area hero-container">
    <div class="hero-overlay"></div>

    <div class="container hero-content">
        <div class="row align-items-center">
            
            {{-- Left Section: Text --}}
            <div class="col-lg-6 col-md-12 mb-4" data-aos="fade-right">
                <h1 class="fw-bold text-success hero-title" >
                    {!! nl2br(e($home->main_title)) !!}
                </h1>

                <p class="lead text-dark mb-4">
                    {!! nl2br(e($home->sub_title)) !!}
                </p>

                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <button type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#donateMoneyModal"
                            class="btn btn-success px-5 py-3 rounded-3 shadow">
                        {{ $home->cta_button ?? 'Donate' }}
                    </button>

                    <a href="tel:{{ $home->telephone ?? '' }}"
                       class="d-flex align-items-center text-decoration-none text-dark fw-semibold">
                        <i class="bi bi-telephone-fill text-success me-2 fs-4"></i>
                        <span>{{ $home->telephone ?? '' }}</span>
                    </a>
                </div>
            </div>

            {{-- Right Section: Carousel --}}
            <div class="col-lg-6 col-md-12 hero-carousel" data-aos="fade-left">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($home->hero_images ?? [
                            'https://picsum.photos/id/1018/800/450',
                            'https://picsum.photos/id/1025/800/450',
                            'https://picsum.photos/id/1035/800/450'
                        ] as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset($image) }}" class="d-block w-100" alt="Hero Slide {{ $index+1 }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Controls --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<section class="featured-job-area section-padding section-bg2" 
         data-background="{{ asset('assets/img/gallery/section_bg03.png') }}">

    <div class="container py-5">
        
        <!-- Announcements -->
        <div class="mb-5" data-aos="zoom-in">
            <h2 class="fw-bold mb-4 text-success border-bottom pb-2 text-center">📢 Announcements</h2>

            <div class="row g-4">
                @forelse($announcements as $announcement)
                    <div class="col-12 col-md-6" data-aos="zoom-in">
                        <div class="announcement-card h-100">
                            @if($announcement->image)
                                <img src="{{ Storage::url($announcement->image) }}" class="img-fluid rounded mb-3" alt="Announcement Image">
                            @endif

                            <h3 class="announcement-title">{{ $announcement->title }}</h3>
                            <div class="announcement-meta">
                                Posted by <strong>{{ $announcement->user->name ?? 'Admin' }}</strong>
                                on {{ $announcement->created_at->format('F j, Y') }}
                            </div>
                            <div class="announcement-content">
                                {!! Str::limit(strip_tags($announcement->content), 200, '...') !!}
                            </div>
                            <a href="{{ route('announcements.show', $announcement->id) }}" class="btn btn-outline-success mt-3">
                                Read More
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="no-announcement" data-aos="fade-up">No Announcements Yet</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $announcements->links() }}
            </div>
        </div>

        <!-- Donation Drive -->
        <div data-aos="zoom-in">
            <h2 class="fw-bold mb-4 text-success border-bottom pb-2 text-center">🎁 Donation Drive</h2>

            <div class="row g-4">
                @foreach($donations as $donation)
                    <div class="col-12 col-md-6 col-lg-4"  data-aos="flip-left">
                        <div class="single-cases h-100 shadow-sm rounded">
                            <img class="w-100 rounded-top" style="height: 340px; object-fit: unsetr"
                                 src="{{ Storage::url($donation->image) }}" alt="Donation Image">

                            <div class="cases-caption p-3">
                                <h4 class="fw-bold">
                                    <a class="text-decoration-none text-dark" href="#">
                                        {{ $donation->title }}
                                    </a>
                                </h4>

                                <!-- Progress Bar -->
                                <div class="progress my-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ \App\Helpers\CurrencyFormatter::percent($donation->raised, $donation->goal) }}%"
                                         aria-valuenow="{{ $donation->raised }}" aria-valuemin="0" aria-valuemax="{{ $donation->goal }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between small text-muted">
                                    <span>Raised: {{ \App\Helpers\CurrencyFormatter::currency($donation->raised) }}</span>
                                    <span>Goal: {{ \App\Helpers\CurrencyFormatter::currency($donation->goal) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
<!-- Donor Logs -->
<div class="mt-5" data-aos="fade-up">
    <h2 class="fw-bold mb-4 text-success border-bottom pb-2 text-center">🙏 Donor Logs</h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped align-middle text-center" id="donorLogsTable">
            <thead class="table-success">
                <tr>
                    <th>Date</th>
                    <th>Donor</th>
                    <th>Food Item / Goods</th>
                    <th>Donation Type</th>
                </tr>
            </thead>
            <tbody id="donorLogsBody">
                <tr>
                    <td colspan="5" class="text-muted">Loading donor logs...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center" id="donorLogsPagination"></div>
</div>


    </div>
</section>

<section class="featured-job-area section-padding section-bg2"
         data-background="{{ asset('assets/img/gallery/section_bg03.png') }}" data-aos="zoom-in">
    <div class="container">
        <!-- Section Title -->
        <div class="row justify-content-center mb-5">
            <div class="col-xl-7 col-lg-9 col-md-10 text-center">
                <span class="text-success fw-bold d-block mb-2">What We Are Doing</span>
                <h2 class="fw-bold text-title text-primary">
                    We arrange many social events for charity donations
                </h2>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row g-4 justify-content-center">
            @forelse($events->take(5) as $event)
                <div class="col-12 col-md-6 col-lg-4" data-aos="zoom-in">
                    <div class="card shadow-sm border-0 rounded-3 event-card h-100">
                        <!-- Event Image -->
                        <img src="{{\Illuminate\Support\Facades\Storage::url($event->image->path)}}"
                             class="img-fluid rounded-top object-fit-unset"
                             alt="{{ $event->title }}"
                             style="height: 340px; width: 100%;">

                        <!-- Event Content -->
                        <div class="card-body">
                            <a href="{{ route('events.show', $event->id) }}" title="Click to view this Event">
                                <h5 class="fw-bold text-primary text-capitalize mb-3">
                                    {{ $event->title }}
                                </h5>
                            </a>

                            <div class="d-flex flex-column gap-2 text-muted small">
                                <p class="mb-0"><i class="far fa-clock me-2 text-success"></i>
                                    {{ $event->start->format('h:i A') }}
                                </p>
                                <p class="mb-0"><i class="fas fa-calendar-alt me-2 text-info"></i>
                                    {{ $event->start->format('M d, Y') }}
                                </p>
                                <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                    {{ $event->place }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No events available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        @if($events->count() > 5)
            <div class="text-center mt-4">
                <a href="{{ route('events.index') }}" class="btn btn-success px-4 py-2">
                    View All Events
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Extra Styling -->
<style>
    .event-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .object-fit- {unset
        object-fit: unset;
    }
</style>


    <div class="container section-padding" data-aos="zoom-in">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-10" data-aos="fade-up">
                <!-- Section Tittle -->
                <div class="text-primary text-center mb-5" >
                    <span class="text-success fw-bold">{{$home->section_title  ?? 'What we are doing'}}</span>
                    <h2 class="fw-bold text-title">{{$home->section_subtitle  ?? 'Default Sub Title'}}</h2>
                </div>
            </div>
        </div>
       <div class="row">
            @foreach ($home->section_cards ?? [] as $card)
                <div class="mb-2 col-12 col-lg-4">
                    <div class="h-100 text-center  rounded p-2 {{ $loop->index === 1 ? 'bg-success' : '' }}">
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

<section class="container section-padding" data-aos="zoom-in">
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
                <a href="/charity/about-us" class="fw-bold btn btn-success px-4 py-2 rounded-0 text-white">See More</a>
            </div>
        </div>

        <div class="col-lg-6 d-none d-lg-block position-relative">
            @if(!empty($home->about_images) && is_array($home->about_images))
                @foreach($home->about_images as $index => $image)
                    <div class="position-absolute {{ $loop->first ? 'top-0 end-0' : 'bottom-0 start-0 pt-2 pe-2 bg-success shadow' }}"
                         style="{{ $loop->first ? 'top: -50px; right: 0;' : 'bottom: -50px; left: 0; z-index: 5;' }}"  data-aos="fade-left">
                        <img src="{{ $image }}" 
                             class="img-fixed {{ $loop->first ? 'img-large' : 'img-small' }}">
                    </div>
                @endforeach
            @else
                {{-- fallback if no images --}}
                <div class="position-absolute" style="top: -50px; right: 0">
                    <img src="/img/gallery/gallery-1.jpeg" class="img-fixed img-large">
                </div>
                <div class="position-absolute pt-2 pe-2 bg-success shadow" style="bottom: -50px; left: 0; z-index: 5">
                    <img src="/img/gallery/gallery-2.jpeg" class="img-fixed img-small">
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .img-fixed {
        object-fit: contain; /* keeps ratio but fills box */
        object-position: center; /* centers the crop */
        display: block;
        width: 100%;
        height: 100%;
    }

    .img-large {
        width: 354px;
        height: 453px;
    }

    .img-small {
        width: 250px;
        height: 288px;
    }
</style>

@foreach ($home->additional_sections ?? [] as $i => $section)
    <section class="py-4 {{ $i % 2 == 0 ? 'bg-light' : 'bg-white' }}" data-aos="fade-right">
        <div class="container">
            <div class="row align-items-center g-4">

                <!-- Text Section -->
                <div class="col-lg-6 d-flex {{ $i % 2 == 1 ? 'order-lg-2' : '' }}">
                    <div class="p-4 bg-white shadow rounded w-100 d-flex flex-column justify-content-center">
                        @if (!empty($section['subtitle']))
                            <h6 class="text-uppercase text-success fw-semibold mb-2">
                                {{ $section['subtitle'] }}
                            </h6>
                        @endif

                        <h3 class="fw-bold text-primary mb-3">
                            {{ $section['title'] ?? 'Untitled Section' }}
                        </h3>

                        <p class="text-secondary mb-4">
                            {{ $section['description'] ?? 'No description available.' }}
                        </p>

                        @if (!empty($section['button_text']) && !empty($section['button_link']))
                            <a href="{{ $section['button_link'] }}" 
                               class="btn btn-success text-white fw-semibold px-4 py-2 align-self-start">
                                {{ $section['button_text'] }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Image Section -->
                <div class="col-lg-6 d-flex {{ $i % 2 == 1 ? 'order-lg-1' : '' }}">
                    @if (!empty($section['image']))
                        <div class="position-relative w-100 d-flex justify-content-center">
                            <img src="{{ asset($section['image']) }}" 
                                class="img-fluid rounded shadow-lg" 
                                style="max-height: 420px; object-fit: contain; cursor:pointer;"
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal{{ $i }}"
                                title="Click to enlarge view" />
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $i }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $i }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content bg-transparent border-0">
                                    <div class="modal-body text-center p-0 position-relative">
                                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                        <img src="{{ asset($section['image']) }}" class="img-fluid rounded shadow-lg" style="max-height: 90vh; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>


                    @else
                        <div class="bg-secondary-subtle d-flex justify-content-center align-items-center rounded w-100" style="height: 280px;">
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
            <div class="col-lg-3 col-sm-6 col-12 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
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
                                <option value="gcash">Bank / E-Wallet</option>
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

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000, // animation duration
        once: true,     // whether animation should happen only once
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function fetchDonorLogs(page = 1) {
        $.ajax({
            url: "{{ route('donor.logs.fetch') }}?page=" + page,
            type: "GET",
            success: function(response) {
                let tbody = $("#donorLogsBody");
                tbody.empty();

                if (response.data.length === 0) {
                    tbody.append(`<tr><td colspan="5" class="text-muted">No donor logs available yet.</td></tr>`);
                } else {
                    response.data.forEach(log => {
                        tbody.append(`
                            <tr>
                                <td>${log.date}</td>
                                <td>${log.contributor_name}</td>
                                <td>${log.item}</td>
                                <td>${log.donation_type}</td>
                            </tr>
                        `);
                    });
                }

                // Render pagination
                $("#donorLogsPagination").html(response.pagination);
            },
            error: function() {
                $("#donorLogsBody").html(`<tr><td colspan="5" class="text-danger">Failed to load donor logs.</td></tr>`);
            }
        });
    }

    // Initial load
    $(document).ready(function() {
        fetchDonorLogs();

        // Handle pagination click
        $(document).on("click", "#donorLogsPagination a", function(e) {
            e.preventDefault();
            let page = $(this).attr("href").split("page=")[1];
            fetchDonorLogs(page);
        });
    });
</script>


@endsection
