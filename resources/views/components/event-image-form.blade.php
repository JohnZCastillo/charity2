<div class="rounded p-2 border border-secondary">
    <form method="POST" action="/inventory/event-image/{{$image->id}}">
        @csrf
        @method('DELETE')
        <div class="position-relative">
            <img style="width: 200px; height: 200px" src="{{\Illuminate\Support\Facades\Storage::url($image->path)}}">
            <button type="submit" class="position-absolute btn btn-link text-danger" style="top: 10px; right: 0">
                <i class='bx bx-sm bxs-trash'></i>
            </button>
        </div>
    </form>
</div>
