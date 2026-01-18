@extends('layouts.index')

@section('styles')
<style>
    .pill-enabled {
        background-color: var(--bs-success);
    }

    .pill-disabled {
        background-color: var(--bs-secondary);
    }
</style>
@endsection

@section('body')

    <div class="p-2 bg-light h-100">

     <div class="p-2">
        <h4 class="fw-bold">Beneficiares</h4>
    </div>
           

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <form id="searchForm">

            <div class="row mx-0">

                <div class="col-12 d-flex align-items-center gap-2 mb-2">
                    <input id="searchInput" value="{{$app->request->search}}" placeholder="Search" type="search"
                           name="search"
                           class="form-control">

                    <button type="button" class="btn btn-secondary text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#donorModal">New Recipient
                    </button>

                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'code') value="code">Code</option>
                        <option @selected($app->request->order == 'name') value="name">Name</option>
                    </select>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Sort by</label>
                    <select class="form-select" id="sortBy" name="sort">
                        <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                        <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                    </select>
                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Status</label>
                    <select class="form-select text-uppercase" id="searchStatus" name="status">
                        <option value="ALL">All</option>
                        @foreach(\App\Enums\UserStatus::cases() as $status)
                            <option class="text-uppercase" @selected($app->request->status ==$status->value) value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </form>

        <div class="mt-3 p-2 shadow rounded bg-white">

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td>Recipient ID</td>
                        <td>Name</td>
                        <td>Mobile</td>
                        <td>Email</td>
                        <td>Address</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($recipients as $recipient)
                        <tr>
                            <td>{{$recipient->code}}</td>
                            <td>{{$recipient->name}}</td>
                            <td>{{$recipient->mobile}}</td>
                            <td>{{$recipient->email}}</td>
                            <td>{{$recipient->address->address}}</td>
                            <td>
                                <div class="badge pill-{{$recipient->status}}">{{$recipient->status}}</div>
                            </td>
                            <td>
                                <div class="d-flex gap-2 align-items-center flex-nowrap">

                                    <a class="btn btn-secondary" type="button" href="/inventory/recipients/{{$recipient->id}}">
                                        edit
                                    </a>

                                    <form data-confirmation="Are you sure you want to delete this recipient?"
                                        class="confirmation" method="POST" action="{{ route('recipient.delete', $recipient->id) }}">
                                    @csrf
                                    @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            Archived
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="py-2">
                {{ $recipients->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="donorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" class="w-full" method="POST" action="/inventory/recipient">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Recipient</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label class="label-text">Recipient Code</label>
                            <input name="code" type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Name</label>
                            <input name="name" type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Mobile</label>
                            <input name="mobile" type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Email</label>
                            <input name="email" type="email" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Address</label>
                            <input name="address" type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label class="label-text">Status</label>
                            <select name="status" class="form-select">
                                <option disabled selected>Select</option>
                                @foreach(\App\Enums\UserStatus::cases() as $status)
                                    <option value="{{$status->value}}">{{$status->value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy','#searchStatus');
        })
    </script>
@endsection
