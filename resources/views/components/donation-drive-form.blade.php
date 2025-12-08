<div class="modal fade" id="donationDriveUpdateModal{{$donation->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="/inventory/donation-drive/{{$donation->id}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Donation Drive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <small class="text-secondary">Image Preview</small>
                    <div class="d-flex align-items-center justify-content-center overflow-hidden mb-2">
                        <img src="{{\Illuminate\Support\Facades\Storage::url($donation->image)}}" class="image-fluid"
                             style="max-height: 200px">
                    </div>
                    <div class="form-group mb-2">
                        <label>Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group mb-2">
                        <label>Title</label>
                        <input value="{{$donation->title}}" type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Goal</label>
                        <input value="{{$donation->goal}}" min="1" type="number" name="goal" class="form-control"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
