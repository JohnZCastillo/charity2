@extends('inventory.pdf.donor-report-layout')

@section('body')
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Donor</th>
            <th>Through</th>
            <th>Donated Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($items as $item)
            <tr>
                <td>{{$item->from ?? 'Anonymous'}}</td>
                <td>{{$item->type}}</td>
                <td>
                    {{\App\Helpers\CurrencyFormatter::currency( $item->amount)}}
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-secondary mh-100 text-center" colspan="3">EMPTY</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection