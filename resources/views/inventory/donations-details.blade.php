@extends('layouts.index')

@section('body')

    <div class="p-2 h-100 bg-light">


        <form id="searchForm" class="form mb-2">
            <div class="d-flex align-items-center gap-1 mx-0 flex-wrap flex-md-nowrap">
                <input id="searchInput" value="{{$app->request->search}}" placeholder="Search"
                       type="search"
                       name="search"
                       class="form-control">

                <a type="button" class="btn btn-primary" href="{{ route('donationdrive.index') }}">
                    Back
                </a>
            </div>

            <div class="col-sm-12 d-flex align-items-center mt-2 gap-2 flex-wrap flex-md-nowrap ">
                <div class="d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'created_at') value="created_at">Date</option>
                        <option @selected($app->request->order == 'from') value="from">From</option>
                        <option @selected($app->request->order == 'amount') value="amount">Amount</option>
                    </select>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <label class="text-nowrap">Sort by</label>
                    <select class="form-select" id="sortBy" name="sort">
                        <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                        <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                    </select>
                </div>
            </div>
        </form>


        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>From</th>
                    <th>Method</th>
                    <th>Receipt</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($donations as $donation)
                    <tr>
                        <td>{{$donation->from ?? 'anonymous'}}</td>
                        <td>{{$donation->type->value}}</td>
                        <td>
                            @if($donation->receipt)
                                <img style="width: 50px; height: 50px" src="{{\Illuminate\Support\Facades\Storage::url($donation->receipt)}}">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{$donation->email ?? 'N/A'}}</td>
                        <td>{{  \App\Helpers\CurrencyFormatter::currency($donation->amount)}}</td>
                        <td>{{ $donation->created_at->format('F d, Y h:i A') }}</td>
                        <td>
                            @if($donation->confirmed)
                                <span class="text-success fw-bold">CONFIRMED</span>
                            @else
                                <button type="button" 
                                        class="btn btn-primary btn-confirm" 
                                        data-id="{{ $donation->id }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#confirmModal">
                                    <i class="fas fa-check"></i> Confirm
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr style="line-height: 200px">
                        <td colspan="3" class="text-center text-secondary">EMPTY</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="container">
                {{$donations->links()}}
            </div>
        </div>
    </div>



<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="confirmForm" method="POST" action="{{ route('donation.confirm') }}">
      @csrf
      <input type="hidden" name="donation_id" id="donationId">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">Confirm Donation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p>Are you sure you want to confirm this donation?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Confirm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let confirmButtons = document.querySelectorAll('.btn-confirm');
    let donationIdInput = document.getElementById('donationId');

    confirmButtons.forEach(button => {
        button.addEventListener('click', function () {
            let donationId = this.getAttribute('data-id');
            donationIdInput.value = donationId;
        });
    });
});
</script>

@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy',);
        })

        function back() {
            history.back();
        }
    </script>
@endsection
