@extends('layouts.index')
@section('title','Items')
@section('files')
    <link href="/light-box/css/lightbox.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/autocomplete.css">

    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.9/dist/autoComplete.min.js"></script>
    <script src="/light-box/js/lightbox-plus-jquery.js"></script>
@endsection

@section('styles')
    <style>

        td {
            vertical-align: center;
        }

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
        <h4 class="fw-bold">Commodities</h4>
    </div>
           


{{-- Error Message --}}
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
        <form id="searchForm" class="mb-2">
            <div class="row mx-0">

                <div class="col-12 d-flex align-items-center gap-2 mb-2">
                    <input id="searchInput" value="{{$app->request->search}}" placeholder="Search" type="search"
                           name="search"
                           class="form-control">

                    <button type="button" class="btn btn-secondary text-nowrap" data-bs-toggle="modal"
                            data-bs-target="#itemModal">New Item
                    </button>

                </div>

                <div class="col-6 col-md-3 d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'code') value="code">Code</option>
                        <option @selected($app->request->order == 'name') value="name">Name</option>
                        <option @selected($app->request->order == 'stock') value="stock">Stock</option>
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
                        @foreach(\App\Enums\ItemStatus::cases() as $status)
                            <option class="text-uppercase"
                                    @selected($app->request->status ==$status->value) value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="d-flex gap-2 px-2">
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning">
                Donate
            </button>

            <button type="button" data-bs-toggle="modal" data-bs-target="#stockInModal" class="btn btn-success">
                Add Stock
            </button>
        </div>

        <!-- Modal -->
        <x-donation/>
        <x-stock-in-form/>

        <div class="mt-3 p-2 shadow rounded bg-white">

            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <td>Code</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Donor</td>
                        <td>Category</td>
                        <td>Size</td>
                        <td>Gender</td>
                        <td>Status</td>
                        <td>Expired</td>
                        <td>Expiration Date</td>
                        <td>Expiration Status</td>
                        <td>Stock</td>
                        <td>Donated Date</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->code}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                            <td>
                                @if($item->donor)
                                    {{$item->donor->name}}
                                @else
                                    <span>none</span>
                                @endif
                            </td>
                            <td>
                                @if($item->category)
                                    {{$item->category->name}}
                                @else
                                    <span>none</span>
                                @endif
                            </td>
                            <td>
                                @if($item->size)
                                    {{$item->size->name}}
                                @else
                                    <span>none</span>
                                @endif
                            </td>
                            <td>
                                @if($item->gender)
                                    {{$item->gender->name}}
                                @else
                                    <span>none</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge pill-{{$item->status}}">{{$item->status}}</span>
                            </td>
                            <td>{{$item->expired ?? 0}}</td>
                            <td>{{ $item->next_expiration_date ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $status = $item->expiration_status;
                                    $badgeClass = match($status) {
                                        'Expired' => 'bg-danger',
                                        'Expiring Soon' => 'bg-warning',
                                        'Valid' => 'bg-success',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>

                            <td>{{$item->stock ?? 0}}</td>
                            <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>

                            <td>
                                <div class="d-flex gap-2 align-items-center flex-nowrap">

                                    <a class="btn btn-secondary" type="button" href="/inventory/items/{{$item->id}}">
                                        <i class="fas fa-eye"></i> View
                                    </a>

                                    <form data-confirmation="Are you sure you want to delete this item?"
                                          class="confirmation" method="POST" action="/item/{{$item->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fas fa-trash"></i> Delete
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
                {{ $items->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" class="w-full" method="POST" action="/item">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input name="item_gender_id" type="hidden" class="d-none">
                        <input name="item_size_id" type="hidden" class="d-none">

                        <div class="form-group mb-1">
                            <label class="label-text">Code</label>
                            <input name="code" type="text" class="form-control" required/>
                        </div>

                        <div class="form-group mb-1">
                            <label class="label-text">Name</label>
                            <input name="name" type="text" class="form-control" required/>
                        </div>

                        <div class="form-group mb-1">
                            <label class="label-text">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>

                        <div class="form-group mb-1">
                            <label class="label-text">Status</label>
                            <select name="status" class="form-select" required>
                                <option disabled selected>Select</option>
                                @foreach(\App\Enums\ItemStatus::cases() as $status)
                                    <option value="{{$status->value}}">{{$status->value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-1">
                            <label class="label-text">Stock</label>
                            <input name="stock" type="number" min="1" class="form-control" required/>
                        </div>

                        <div class="form-group mb-1">
                            <label class="label-text">Expiration (Optional)</label>
                            <input name="expiration" type="date" class="form-control"/>
                        </div>

                        <div class="form-group mb-1">
                            <label for="category" class="label-text">Category</label>
                            <select id="category" class="form-select" name="category">
                                @foreach(\App\Enums\ItemType::cases() as $type)
                                    @continue($type === \App\Enums\ItemType::GENERAL)
                                    <option value="{{$type->value}}">{{$type->value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-1">
                            <label for="gender" class="label-text">Gender</label>
                            <input placeholder="Optional" name="gender" id="gender" class="w-100 text-dark">
                        </div>

                        <div class="form-group mb-1">
                            <label for="size" class="label-text">Size</label>
                            <input name="size" placeholder="Optional" id="size" class="w-100 text-dark">
                        </div>

                        <div class="form-group mb-1">
                            <label for="donor" class="label-text">Donor</label>
                            <input name="account_id" type="hidden" class="d-none">
                            <input name="donor" placeholder="Optional" id="donor"
                                   class="w-100 text-dark">
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

        const donorInput = document.querySelector('#donor');
        const hiddenAccountInput = document.querySelector("input[name='account_id']");

        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput',);
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy', '#searchStatus');
        })

        document.addEventListener('DOMContentLoaded', () => {
            addAutocomplete('#gender',@json($genders));
            addAutocomplete('#size',@json($sizes));
            addAutocomplete('#donor',@json($donors), function (donor) {
                hiddenAccountInput.value = donor.id;
            });
        })

        function addAutocomplete(selector, src, cb = null) {

            new autoComplete(
                {
                    selector: selector,
                    data: {
                        keys: ['name'],
                        src: src,
                        cache: true,
                    },
                    resultsList: {
                        noResults: true,
                    },
                    events: {
                        input: {
                            selection: (event) => {

                                event.target.value = event.detail.selection.value.name;

                                if (cb) {
                                    cb(event.detail.selection.value);
                                }
                            }
                        }
                    },
                },
            );
        }

        donorInput.addEventListener('keyup', function () {
            hiddenAccountInput.value = null;
        })

    </script>
@endsection
