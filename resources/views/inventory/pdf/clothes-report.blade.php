
@extends('inventory.pdf.recipient-report-layout')

@section('body')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Donor</th>
            <th>Address</th>
            <th>Item Name</th>
            <th>Description</th>
            <th>Size</th>
            <th>Distributed Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($items as $item)
            <tr>
            <td>{{$item->donor?->name ?? 'Anonymous'}}</td>
                <td>{{$item->donor?->address->address}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->size->name}}</td>
                <td>
                    {{$donation->quantity  > 1 ? $donation->quantity  . ' pcs' : $donation->quantity  . ' pc'}}
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-secondary mh-100 text-center" colspan="6">EMPTY</td>
            </tr>
        @endforelse


        </tbody>
    </table>
@endsection