<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="/inventory/donate" class="mb-2">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Donate Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Recipient -->
                    <div class="form-group mb-3">
                        <label class="text-secondary">Recipient</label>
                        <select name="recipient_id" class="form-select" required>
                            @foreach($recipients as $recipient)
                                <option value="{{$recipient->id}}">{{$recipient->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Items container -->
                    <div id="items-container">
                        <div class="row g-2 mb-2 item-row">
                            <div class="col-md-7">
                                <label class="text-secondary">Item</label>
                                <select class="form-select" name="items[0][item_id]" required>
                                    @foreach($items as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="text-secondary">Quantity</label>
                                <input min="1" class="form-control" type="number" name="items[0][quantity]" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-item w-100">X</button>
                            </div>
                        </div>
                    </div>

                    <!-- Add more items -->
                    <button type="button" id="add-item" class="btn btn-outline-success btn-sm">+ Add Item</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let itemIndex = 1;
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'g-2', 'mb-2', 'item-row');
        newRow.innerHTML = `
            <div class="col-md-7">
                <select class="form-select" name="items[${itemIndex}][item_id]" required>
                    @foreach($items as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input min="1" class="form-control" type="number" name="items[${itemIndex}][quantity]" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item w-100">X</button>
            </div>
        `;
        container.appendChild(newRow);
        itemIndex++;
    });

    // Remove item row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.item-row').remove();
        }
    });
</script>
