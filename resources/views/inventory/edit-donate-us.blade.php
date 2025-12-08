<div class="tab-pane fade show active" id="donate" role="tabpanel">
    @php
    $bgColors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger', 'bg-secondary', 'bg-dark'];
@endphp
    
<div class="d-flex justify-content-between align-items-center mb-3">
        <strong>Donate Sections</strong>
    </div>
<div class="accordion-item mb-3">
    <h2 class="accordion-header" id="headingHomeContent">
        <button class="accordion-button collapsed bg-secondary text-white"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseHomeContent">
           QR Code
        </button>
    </h2>
    <div id="collapseHomeContent" class="accordion-collapse collapse"
         data-bs-parent="#cmsAccordion">
        <div class="accordion-body">
            <form id="qrCodeForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>QR Code Image</label>
                    <input type="file" name="qr_code_path" class="form-control" accept="image/*">

                    <div class="mt-2" id="qrPreview">
                        @if (!empty($home->qr_code_path))
                            <img src="{{ asset($home->qr_code_path) }}" width="200" class="rounded shadow">
                        @endif
                    </div>

                    <input type="hidden" name="existing_qr_code_path" value="{{ $home->qr_code_path ?? '' }}">
                </div>

                <button type="submit" class="btn btn-success">Save QR Code</button>
            </form>
        </div>
    </div>
</div>
</div>
<!-- AJAX Script -->
<script>
document.getElementById('qrCodeForm').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('home.qr.update') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            alert(data.message);
            document.getElementById('qrPreview').innerHTML =
                `<img src="${data.qr_code_path}" width="200" class="rounded shadow">`;
        } else {
            alert("Something went wrong.");
        }
    })
    .catch(err => console.error(err));
});
</script>




