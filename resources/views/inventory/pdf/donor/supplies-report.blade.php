@extends('inventory.pdf.donor-report-layout')

@section('body')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Donor</th>
            <th>Address</th>
            <th>Item Name</th>
            <th>Description</th>
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
                <td>
                    {{$item->getInitQuantity()  > 1 ? $item->getInitQuantity()   . ' pcs' : $item->getInitQuantity()   . ' pc'}}
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