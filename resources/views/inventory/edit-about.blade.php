<div class="tab-pane fade show active" id="about" role="tabpanel">
    @php
    $bgColors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger', 'bg-secondary', 'bg-dark'];
@endphp
    
<div class="d-flex justify-content-between align-items-center mb-3">
        <strong>About Page Sections</strong>
        <button class="btn btn-sm btn-success" onclick="addAboutCard()">+ Add Section</button>
    </div>

    <div id="aboutSortable" class="row g-3">
        @foreach($sections as $section)
    <div class="col-12" data-id="{{ $section->id }}">
        <div class="card shadow-sm" id="about-card-{{ $section->id }}">
            <div class="card-header d-flex justify-content-between align-items-center bg-secondary text-white"
                    style="cursor: pointer;"
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapse-{{ $section->id }}">

                <strong>{{ $section->title ?: 'Untitled Section' }}</strong>
                <!-- <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $section->id }}">
                    Edit
                </button> -->
            </div>

            <div class="collapse" id="collapse-{{ $section->id }}">
                <div class="card-body">
                    <form class="about-edit-form" data-id="{{ $section->id }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $section->id }}">

                        <div class="mb-2">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $section->title }}">
                        </div>

                      <div class="mb-2 content-wrapper">
                        <label class="form-label">Content</label>

                        {{-- Default textarea (shown if type=text) --}}
                        <textarea name="content" class="form-control content-text" rows="3" 
                            style="{{ $section->type === 'text' ? '' : 'display:none;' }}">{{ $section->content }}</textarea>

                        {{-- List inputs (shown if type=list) --}}
                        <div class="content-list" style="{{ $section->type === 'list' ? '' : 'display:none;' }}">
                            @if($section->type === 'list')
                                @foreach(explode("\n", $section->content) as $line)
                                    <div class="d-flex mb-2 list-item">
                                        <input type="text" name="content_list[]" class="form-control" value="{{ $line }}">
                                        <button type="button" class="btn btn-sm btn-danger ms-2 remove-list-item">&times;</button>
                                    </div>
                                @endforeach
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-primary add-list-item mt-2">+ Add Item</button>
                        </div>
                    </div>

                        <div class="mb-2">
                            <label class="form-label">Group</label>
                            <select name="group" class="form-control">
                            <option value="general" {{ $section->group === 'general' ? 'selected' : '' }}>General</option>
                                <option value="vision_mission" {{ $section->group === 'vision_mission' ? 'selected' : '' }}>Vision & Mission</option>
                                <option value="programs" {{ $section->group === 'programs' ? 'selected' : '' }}>Programs</option>
                                <option value="spiritual_activities" {{ $section->group === 'spiritual_activities' ? 'selected' : '' }}>Spiritual Activities</option>
                                <option value="referral_system" {{ $section->group === 'referral_system' ? 'selected' : '' }}>Referral System</option>
                                <option value="eligibility" {{ $section->group === 'eligibility' ? 'selected' : '' }}>Eligibility</option>
                                <option value="founding" {{ $section->group === 'founding' ? 'selected' : '' }}>Founding</option>
                                <option value="philippine_chapter" {{ $section->group === 'philippine_chapter' ? 'selected' : '' }}>Philippine Chapter</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-control">
                                <option value="text" {{ $section->type === 'text' ? 'selected' : '' }}>Text</option>
                                <option value="list" {{ $section->type === 'list' ? 'selected' : '' }}>List</option>
                                <option value="image" {{ $section->type === 'image' ? 'selected' : '' }}>Image</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($section->image)
                                <img src="{{ $section->image }}" class="mt-2" style="max-height: 120px;">
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteAbout({{ $section->id }})">Delete</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    document.querySelectorAll('.about-edit-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const id = this.dataset.id;
        const formData = new FormData(this);

        fetch(`/cms/about/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        }).then(res => res.json())
          .then(res => {
              alert('Saved!');
              window.location.reload(); 
          })
          .catch(() => alert('Save failed.'));
    });
});


    function deleteAbout(id) {
        if (!confirm('Delete this section?')) return;
        fetch(`/cms/about/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        }).then(() => {
            document.getElementById(`about-card-${id}`).remove();
            alert('Deleted!');
            window.location.reload();
        });
    }

    function addAboutCard() {
    const card = `
        <div class="col-12">
            <div class="card p-3 shadow-sm">
                <form method="POST" action="/cms/about" class="about-edit-form" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="mb-2 content-wrapper">
                        <label class="form-label">Content</label>
                        
                        <!-- Default textarea -->
                        <textarea name="content" class="form-control content-text" rows="3"></textarea>

                        <!-- List wrapper (hidden initially) -->
                        <div class="content-list" style="display:none;">
                            <button type="button" class="btn btn-sm btn-outline-primary add-list-item mt-2">+ Add Item</button>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Group</label>
                        <select name="group" class="form-control">
                            <option value="general" selected>General Purpose</option>
                             <option disabled value="vision_mission">Vision & Mission</option>
                            <option disabled value="programs">Programs</option>
                            <option disabled value="spiritual_activities">Spiritual Activities</option>
                            <option disabled value="referral_system">Referral System </option>
                            <option disabled value="eligibility">Eligibility</option>
                            <option disabled value="founding">Founding</option>
                            <option disabled value="philippine_chapter">Philippine Chapter</option> 
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="text">Text</option>
                            <option value="list">List</option>
                            <option value="image">Image</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success btn-sm float-end">Save</button>
                </form>
            </div>
        </div>`;
    document.getElementById('aboutSortable').insertAdjacentHTML('beforeend', card);
}


   new Sortable(document.getElementById('aboutSortable'), {
    animation: 150,
    onEnd: function () {
        const order = Array.from(document.querySelectorAll('#aboutSortable [data-id]')).map((el, i) => ({
            id: el.dataset.id,
            order: i
        }));

        fetch("{{ route('about.reorder') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order })
        }).then(res => res.json())
          .then(data => console.log('Reorder response:', data))
          .catch(err => console.error('Reorder error:', err));
    }
});

</script>
<script>
    document.addEventListener('change', function(e) {
    if (e.target.name === 'type') {
        const form = e.target.closest('form');
        const textArea = form.querySelector('.content-text');
        const listWrapper = form.querySelector('.content-list');

        if (e.target.value === 'text') {
            textArea.style.display = '';
            listWrapper.style.display = 'none';
        } else if (e.target.value === 'list') {
            textArea.style.display = 'none';
            listWrapper.style.display = '';
        } else {
            textArea.style.display = 'none';
            listWrapper.style.display = 'none';
        }
    }
});

// Add new list item
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-list-item')) {
        const wrapper = e.target.closest('.content-list');
        const newItem = document.createElement('div');
        newItem.classList.add('d-flex', 'mb-2', 'list-item');
        newItem.innerHTML = `
            <input type="text" name="content_list[]" class="form-control" value="">
            <button type="button" class="btn btn-sm btn-danger ms-2 remove-list-item">&times;</button>
        `;
        wrapper.insertBefore(newItem, e.target);
    }

    if (e.target.classList.contains('remove-list-item')) {
        e.target.closest('.list-item').remove();
    }
});

</script>
