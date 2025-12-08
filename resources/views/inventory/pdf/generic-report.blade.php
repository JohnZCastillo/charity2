<div>
    <h1 class="text-center">Inventory Report for <span class="text-capitalize"> {{$type}} </span></h1>
    <p class="small text-center mb-0">Coverage: {{$from->format('Y-m')}}</p>
    <p class="small text-center mb-2">Generated On: {{$generated->format('Y-m-d')}} Generated
        By: {{auth()->user()->name}}</p>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Donor</th>
                <th>Item Name</th>
                <th>Description</th>
                <th>Received This Month</th>
                <th>Distributed</th>
                <th>On Hand</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{$item->donor ?? 'Anonymous'}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->totalQuantityForMonth ?? 0}}</td>
                    <td>{{$item->lessQuantity ?? 0}}</td>
                    <td>{{$item->remainingStock ?? 0}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>