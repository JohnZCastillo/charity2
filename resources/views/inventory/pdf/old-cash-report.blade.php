<div>
    <h1 class="text-center">Inventory Report for <span class="text-capitalize"> {{$type}} </span></h1>
    <p class="small text-center mb-0">Coverage: {{$from->format('Y-m')}}</p>
    <p class="small text-center mb-2">Generated On: {{$generated->format('Y-m-d')}} Generated
        By: {{auth()->user()->name}}</p>


    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Received this month</th>
            <th>Expenses this month</th>
            <th>Remaining Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{\App\Helpers\CurrencyFormatter::format($monthlyDonation)}}</td>
            <td>{{\App\Helpers\CurrencyFormatter::format($expenses)}}</td>
            <td>{{\App\Helpers\CurrencyFormatter::format($totalDonation)}}</td>
        </tr>
        </tbody>
    </table>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Donor</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($donations as $donation)
                <tr>
                    <td>{{$donation->from ?? 'Anonymous'}}</td>
                    <td>{{  \App\Helpers\CurrencyFormatter::format( $donation->amount)}}</td>
                    <td>{{$donation->created_at->format('Y-m-d')}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>