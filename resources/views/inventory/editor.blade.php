@extends('layouts.index')

@section('body')

    <div class="container py-4 bg-light min-vh-100">
        @if ($errors->any())
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
        @if ($errors->count() > 1)
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ $errors->first() }}
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- General Message --}}
        @if (session('message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    <h1 class="mb-4">Page Content Management</h1>

    <ul class="nav nav-tabs mb-4" id="cmsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="nav-tav" data-bs-toggle="tab" data-bs-target="#editNav" type="button" role="tab">Navigation</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Home Page</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">About Page</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donateus-tab" data-bs-toggle="tab" data-bs-target="#donateus" type="button" role="tab">Donate Page</button>
        </li>
        
    </ul>

    <div class="tab-content" id="cmsTabContent">

        <div class="tab-pane fade show active" id="editNav" role="tabpanel" aria-labelledby="nav-tav">
            <form method="POST" action="{{ route('navigation-content.update', ['id' =>  $navigation->id]) }}">

                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label>Mobile Number</label>
                    <input name="mobile" value="{{ $navigation->email ?? '' }}" class="form-control">
                </div>
                
                <div class="mb-3">
                    <label>Telephone</label>
                    <input name="email" value="{{ $navigation->mobile ?? '' }}" class="form-control">
                </div>

                <div class="container">

                    <p>Social Links</p>

                    <div class="row">
                        @foreach ($navigation->socials as $social)
                            <div class="col-6">
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text h-100" id="basic-addon1">
                                            {!! $social->icon !!}
                                        </span>
                                    </div>
                                    <input name="social[{{$social->id}}]" value="{{$social->link}}" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex items-center justify-end">
                    <button class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>

        <!-- Home Page Content Editor -->
        <div class="tab-pane fade" id="home" role="tabpanel">
            <form id="homeForm" method="POST" action="{{ route('home.cms.update', ['page' => 'home']) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="accordion" id="cmsAccordion">

                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="headingHomeContent">
                            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHomeContent">
                                Home Page Content
                            </button>
                        </h2>
                        <div id="collapseHomeContent" class="accordion-collapse collapse" data-bs-parent="#cmsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label>Main Title</label>
                                    <input name="main_title" value="{{ $home->main_title ?? '' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Sub Title</label>
                                    <textarea name="sub_title" rows="4" class="form-control">{{ $home->sub_title ?? '' }}</textarea>
                                </div>
                               <div class="mb-3">
                                            <label>Hero Images (for Carousel Sliding Photos)</label>
                                            <input type="file" name="hero_images[]" class="form-control" accept="image/*" multiple>

                                            @if (!empty($home->hero_images))
                                                <div class="mt-2 d-flex flex-wrap gap-2">
                                                    @foreach ($home->hero_images as $img)
                                                        <div>
                                                            <img src="{{ asset($img) }}" width="200" class="rounded shadow mb-2">
                                                            <input type="checkbox" name="existing_hero_images[]" value="{{ $img }}" checked> Keep
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                <div class="mb-3">
                                    <label>CTA Button Text</label>
                                    <input name="cta_button" value="{{ $home->cta_button ?? '' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="headingContact">
                            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact">
                                Contact Information
                            </button>
                        </h2>
                        <div id="collapseContact" class="accordion-collapse collapse" data-bs-parent="#cmsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label>Contact Email</label>
                                    <input name="contact_email" value="{{ $home->contact_email ?? '' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <input name="address" value="{{ $home->address ?? '' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Telephone</label>
                                    <input name="telephone" value="{{ $home->telephone ?? '' }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="headingAbout">
                            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAbout">
                                About Us Section
                            </button>
                        </h2>
                        <div id="collapseAbout" class="accordion-collapse collapse" data-bs-parent="#cmsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label>About Title</label>
                                    <input name="about_title" value="{{ $home->about_title ?? '' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>About Description</label>
                                    <textarea name="about_description" class="form-control" rows="5">{{ $home->about_description ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label>About Images (you can select two)</label>
                                    <input name="about_images[]" type="file" class="form-control" multiple>
                                </div>

                                @if(!empty($home->about_images))
                                    <div class="row mt-2">
                                        @foreach($home->about_images as $image)
                                            <div class="col-4 mb-2">
                                                <img src="{{ $image }}" class="img-fluid rounded shadow" style="height: 100px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="headingSectionCards">
                            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSectionCards">
                                Section Cards
                            </button>
                        </h2>
                        <div id="collapseSectionCards" class="accordion-collapse collapse" data-bs-parent="#cmsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label>Section Title</label>
                                    <input name="section_title" value="{{ $home->section_title ?? '' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Section Subtitle</label>
                                    <input name="section_subtitle" value="{{ $home->section_subtitle ?? '' }}" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Section Cards</label>
                                    <div id="section-cards-container">
                                        @foreach (($home->section_cards ?? []) as $i => $card)
                                            <div class="card p-3 mb-2 draggable-card">
                                                <button type="button" class="btn-close float-end remove-card-btn"></button>
                                                <label>Title</label>
                                                <input name="section_cards[{{ $i }}][title]" value="{{ $card['title'] ?? '' }}" class="form-control mb-2">
                                                <label>Description</label>
                                                <textarea name="section_cards[{{ $i }}][description]" rows="3" class="form-control">{{ $card['description'] ?? '' }}</textarea>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-section-card">+ Add Section Card</button>
                                </div>
                            </div>
                        </div>
                    </div>

                
                 <!-- Additional Sections -->
            <div class="accordion-item mb-3">
                <h2 class="accordion-header" id="headingAdditionalSections">
                    <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdditionalSections">
                        Additional Dynamic Sections
                    </button>
                </h2>
                <div id="collapseAdditionalSections" class="accordion-collapse collapse" data-bs-parent="#cmsAccordion">
                    <div class="accordion-body">
                        <div id="additional-sections-container">
                            @foreach (($home->additional_sections ?? []) as $i => $section)
                                <div class="card p-3 mb-3">
                                    <button type="button" class="btn-close float-end remove-card-btn"></button>
                                    <label>Title</label>
                                    <input name="additional_sections[{{ $i }}][title]" value="{{ $section['title'] ?? '' }}" class="form-control mb-2">
                                    <label>Subtitle</label>
                                    <input name="additional_sections[{{ $i }}][subtitle]" value="{{ $section['subtitle'] ?? '' }}" class="form-control mb-2">
                                    <label>Description</label>
                                    <textarea name="additional_sections[{{ $i }}][description]" class="form-control mb-2">{{ $section['description'] ?? '' }}</textarea>
                                    <label>Image</label>
                                    <input type="file" name="additional_sections[{{ $i }}][image]" class="form-control mb-2 image-input" accept="image/*">
                                    <input type="hidden" name="additional_sections[{{ $i }}][existing_image]" value="{{ $section['image'] ?? '' }}">
                                    @if (!empty($section['image']))
                                        <div class="image-preview mt-2">
                                            <img src="{{ asset($section['image']) }}" width="100" class="rounded shadow">
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-additional-section">+ Add Section</button>
                    </div>
                </div>
            </div>



                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="headingTeam">
                            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTeam">
                                Team Members
                            </button>
                        </h2>
                        <div id="collapseTeam" class="accordion-collapse collapse" data-bs-parent="#cmsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label>Team Title</label>
                                    <input name="team_title" value="{{ $home->team_title ?? '' }}" class="form-control">
                                </div>
                                <div id="team-members-container">
                                    @foreach (($home->team_members ?? []) as $i => $member)
                                        <div class="card p-3 mb-2 draggable-card">
                                            <button type="button" class="btn-close float-end remove-card-btn"></button>
                                            <label>Name</label>
                                            <input name="team_members[{{ $i }}][name]" value="{{ $member['name'] }}" class="form-control mb-2">
                                            <label>Image</label>
                                            <input type="file" name="team_members[{{ $i }}][image]" class="form-control mb-2 image-input">
                                            <input type="hidden" name="team_members[{{ $i }}][existing_image]" value="{{ $member['image'] }}">
                                            @if (!empty($member['image']))
                                                <div class="mt-2 image-preview">
                                                    <img src="{{ $member['image'] }}" alt="Team Member Image" width="100" class="rounded">
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-team-member">+ Add Team Member</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>

            </form>
        </div>

        <!-- About Page -->
        <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
          @include('inventory.edit-about')
        </div>

        <div class="tab-pane fade" id="donateus" role="tabpanel" aria-labelledby="donateus-tab">
            @include('inventory.edit-donate-us')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupDynamicCards(containerId, addBtnId, prefix) {
        let container = document.getElementById(containerId);
        let addBtn = document.getElementById(addBtnId);
        let index = container.children.length;

        addBtn.addEventListener('click', () => {
            const card = document.createElement('div');
            card.classList.add('card', 'p-3', 'mb-2', 'draggable-card');

            if (prefix === 'team_members') {
                card.innerHTML = `
                    <button type="button" class="btn-close float-end remove-card-btn"></button>
                    <label>Name</label>
                    <input name="${prefix}[${index}][name]" class="form-control mb-2">
                    <label>Image</label>
                    <input type="file" name="${prefix}[${index}][image]" class="form-control mb-2 image-input">
                    <div class="image-preview mt-2"></div>
                `;
            } else {
                card.innerHTML = `
                    <button type="button" class="btn-close float-end remove-card-btn"></button>
                    <label>Title</label>
                    <input name="${prefix}[${index}][title]" class="form-control mb-2">
                    <label>Description</label>
                    <textarea name="${prefix}[${index}][description]" rows="3" class="form-control"></textarea>
                `;
            }

            container.appendChild(card);
            index++;
        });

        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-card-btn')) {
                e.target.closest('.draggable-card').remove();
            }
        });

        container.addEventListener('change', (e) => {
            if (e.target.classList.contains('image-input')) {
                const previewDiv = e.target.closest('.draggable-card').querySelector('.image-preview');
                previewDiv.innerHTML = '';
                const file = e.target.files[0];
                if (file) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.width = 100;
                    img.classList.add('rounded');
                    previewDiv.appendChild(img);
                }
            }
        });

        Sortable.create(container, {
            handle: '.card',
            animation: 150,
            onEnd: () => {
                [...container.children].forEach((el, i) => {
                    el.querySelectorAll('input, textarea').forEach(input => {
                        input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
                    });
                });
            }
        });
    }

    setupDynamicCards('section-cards-container', 'add-section-card', 'section_cards');
    setupDynamicCards('team-members-container', 'add-team-member', 'team_members');
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let sectionIndex = document.querySelectorAll('#additional-sections-container .card').length;

    document.getElementById('add-additional-section').addEventListener('click', () => {
        const container = document.getElementById('additional-sections-container');

        const card = document.createElement('div');
        card.classList.add('card', 'p-3', 'mb-3');
        card.innerHTML = `
                <button type="button" class="btn-close float-end remove-card-btn"></button>
                <label>Title</label>
                <input name="additional_sections[${sectionIndex}][title]" class="form-control mb-2">
                <label>Subtitle</label>
                <input name="additional_sections[${sectionIndex}][subtitle]" class="form-control mb-2">
                <label>Description</label>
                <textarea name="additional_sections[${sectionIndex}][description]" class="form-control mb-2"></textarea>
                <label>Image</label>
                <input type="file" name="additional_sections[${sectionIndex}][image]" class="form-control mb-2 image-input">
                <div class="image-preview mt-2"></div>
            `;

        container.appendChild(card);
        sectionIndex++;
    });

    document.getElementById('additional-sections-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-card-btn')) {
            e.target.closest('.card').remove();
        }
    });

    document.getElementById('additional-sections-container').addEventListener('change', function(e) {
        if (e.target.classList.contains('image-input')) {
            const file = e.target.files[0];
            if (file) {
                const previewDiv = e.target.closest('.card').querySelector('.image-preview');
                previewDiv.innerHTML = '';
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 100;
                img.classList.add('rounded', 'shadow');
                previewDiv.appendChild(img);
            }
        }
    });
});
</script>
@endsection
@section('title', 'Editor')
