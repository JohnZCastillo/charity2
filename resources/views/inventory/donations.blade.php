@extends('layouts.index')
@section('title', 'Donation Drive')
@section('body')

    <div class="p-2 h-100 bg-light">

    @if ($errors->any())
   <div class="alert alert-warning alert-dismissible fade show" role="alert">
        @if ($errors->count() > 1)
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @else
            {{ $errors->first() }}
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- General Message --}}
        @if (session('message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <form id="searchForm" class="form mb-2">
            <div class="d-flex align-items-center gap-1 mx-0 flex-wrap flex-md-nowrap">
                <input id="searchInput" value="{{$app->request->search}}" placeholder="Search"
                       type="search"
                       name="search"
                       class="form-control">
            </div>

            <div class="col-sm-12 d-flex align-items-center mt-2 gap-2 flex-wrap flex-md-nowrap ">
                <div class="d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'created_at') value="created_at">Date</option>
                        <option @selected($app->request->order == 'title') value="title">Title</option>
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

        <div class="d-flex gap-2 mb-2 py-2">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                New
            </button>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFundModal">
                Add Fund
            </button>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#donateModal">
                Donate
            </button>

            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#expendModal">
                Expense
            </button>

        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Raised</th>
                    <th>Goal</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($donations as $donation)
                    <tr>
                        <td>{{$donation->title}}</td>
                        <td>{{  \App\Helpers\CurrencyFormatter::currency($donation->raised)}}</td>
                        <td>{{  \App\Helpers\CurrencyFormatter::currency($donation->goal)}}</td>
                        <td>{{$donation->created_at->format('F d, Y h:i A')}}</td>
                        <td>
                            @if($donation->status === 'accomplished')
                                <span class="badge bg-success">Accomplished</span>
                            @else
                                <span class="badge bg-danger">Unaccomplished</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-1">

                                <x-donation-drive-form :donationDrive="$donation"/>

                                <a class="btn btn-primary" href="/inventory/donation-drive/{{$donation->id}}"><i class="fas fa-eye"></i> View</a>

                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#donationDriveUpdateModal{{$donation->id}}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                              <a href="{{ route('donations-drive.report', $donation->id) }}" class="btn btn-info">
                                    <i class="fas fa-file-alt"></i> Report
                                </a>

                               @if($donation->status === 'unaccomplished')
                                    <!-- Show Accomplish Button -->
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#donationAccomplishModal{{$donation->id}}">
                                        <i class="fas fa-check"></i> Accomplish
                                    </button>
                                @else
                                    <!-- Show Unaccomplish Button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#donationUnaccomplishModal{{$donation->id}}">
                                        <i class="fas fa-times"></i> Unaccomplish
                                    </button>
                                @endif
                                <!-- <form method="POST" action="/inventory/donation-drive/{{$donation->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form> -->

                                <!-- accomplish and unaccomplish modal -->
                                <!-- Accomplish Modal -->
                                <div class="modal fade" id="donationAccomplishModal{{$donation->id}}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('donations.updateStatus', $donation->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="accomplished">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Mark as Accomplished</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to mark <strong>{{ $donation->title }}</strong> as accomplished?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Yes, Accomplish</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                </div>

                                <!-- Unaccomplish Modal -->
                                <div class="modal fade" id="donationUnaccomplishModal{{$donation->id}}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('donations.updateStatus', $donation->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="unaccomplished">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Mark as Unaccomplished</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to mark <strong>{{ $donation->title }}</strong> as unaccomplished?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Yes, Unaccomplish</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr style="line-height: 200px">
                        <td colspan="5" class="text-center text-secondary">EMPTY</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="container">
                {{$donations->links()}}
            </div>
        </div>
    </div>


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/inventory/donation-drive" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Donation Drive</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Goal</label>
                            <input min="1" type="number" name="goal" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="addFundModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/inventory/donate-fund" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Fund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="receipt">Receipt</label>
                            <input type="file" name="receipt" id="receipt" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-2">
                            <label for="from">Donor</label>
                            <input type="text" name="from" id="donor" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label for="amount">Amount</label>
                            <input min="1" type="number" name="amount" id="amount" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label for="email">Email (Optional)</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="type">Type</label>
                            <select class="form-select" name="type" id="type" required>
                                @foreach(\App\Enums\MoneyType::cases() as $type)
                                    <option value="{{$type->value}}">{{$type->value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="fund">Fund</label>
                            <select class="form-select" name="donation_drive_id" id="fund" required>
                                <option disabled selected>-- Select Fund --</option>
                                @foreach($funds as $fund)
                                    <option value="{{$fund->id}}">{{$fund->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="donateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/inventory/donate-expense">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Donate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="recipient">Recipient</label>
                            <select id="recipient" name="recipient" class="form-select" required>
                                @foreach($recipients as $recipient)
                                    <option value="{{$recipient->id}}">{{$recipient->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="amount">Amount</label>
                            <input class="form-control" id="amount" type="number" min="0" name="amount" required>
                        </div>
                        <div class="mb-1">
                            <label for="purpose">Purpose</label>
                            <input class="form-control" id="purpose" type="text" name="purpose" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="expendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/inventory/expense" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Expense Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="receipt">Receipt</label>
                            <input type="file" name="receipt" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-1">
                            <label for="purpose">Purpose</label>
                            <input id="purpose" type="text" name="purpose" class="form-control" required>
                        </div>
                        <div class="mb-1">
                            <label for="amount">Amount</label>
                            <input class="form-control" id="amount" type="number" min="0" name="amount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy',);
        })
    </script>
@endsection
