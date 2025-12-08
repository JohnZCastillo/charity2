@extends('inventory.pdf.recipient-report-layout')

@section('body')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Recipient</th>
            <th>Address</th>
            <th>Item Name</th>
            <th>Description</th>
            <th>Distributed Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($donations as $donation)
            <tr>
                <td>{{$donation->recipient->name}}</td>
                <td>{{$donation->recipient->address->address}}</td>
                <td>{{$donation->item->name}}</td>
                <td>{{$donation->item->description}}</td>
                <td>
                    {{$donation->quantity  > 1 ? $donation->quantity  . ' pcs' : $donation->quantity  . ' pc'}}
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-secondary mh-100 text-center" colspan="5">EMPTY</td>
            </tr>
        @endforelse


        </tbody>
    </table>
@endsection