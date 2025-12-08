@extends('inventory.pdf.recipient-report-layout')

@section('body')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Recipient</th>
            <th>Address</th>
            <th>Purpose</th>
            <th>Distributed Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($donations as $donation)
            <tr>
            <td>{{$donation->recipient?->name}}</td>
                <td>{{$donation->recipient?->address->address}}</td>
                <td>{{$donation->purpose}}</td>
                </td>
                {{\App\Helpers\CurrencyFormatter::currency( $donation->amount)}}
                </td>
            </tr>
        @empty
            <tr>
            <td class="text-secondary mh-100 text-center" colspan="4">EMPTY</td>
            </tr>
        @endforelse


        </tbody>
    </table>
@endsection