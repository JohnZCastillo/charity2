@extends('layouts.index')


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

    <div class="bg-light p-2 h-100">

        @if($errors->any())
            <div class="container-fluid">
                <div class="alert alert-danger" role="alert">
                    {{$errors->first()}}
                </div>
            </div>
        @endif

        @if($item->expiring)
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Expiring Alert!</h4>
                <p>A Total of {{$item->expiring}} {{$item->name}} will expires within 7 days!</p>
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between flex-wrap">

            <h1 class="text-xl font-bold text-gray-700">ITEM</h1>

            <div class="d-flex align-items-center gap-2">

                <button class="btn btn-secondary" onclick="back()">Back</button>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal">
                    Edit
                </button>
            </div>

        </div>

        <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form enctype="multipart/form-data" method="POST"
                      action="/item/{{$item->id}}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Update Item</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label class="label-text">Image</label>
                                <input name="image" type="file" accept="image/*" class="form-control"/>
                            </div>

                            <div class="form-group">
                                <label class="label-text">Code</label>
                                <input value="{{$item->code}}" name="code" type="text" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="label-text">Name</label>
                                <input value="{{$item->name}}" name="name" type="text" class="form-control" required/>
                            </div>

                            <div class="form-group">
                                <label class="label-text">Description</label>
                                <textarea name="description" class="form-control"
                                          required>{{$item->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="label-text">Status</label>
                                <select name="status" class="form-select" required>
                                    <option disabled selected>Select</option>
                                    @foreach(\App\Enums\ItemStatus::cases() as $status)
                                        <option
                                            @selected($item->status == $status) value="{{$status->value}}">{{$status->value}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="d-flex gap-2 align-items-center mt-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-2 row mx-0">

            <div class="col-sm-12 col-md-6">
                <div class="d-flex align-items-center justify-content-center">
                    @if($item->attachment)
                        <img class="img-fluid"
                             src="{{\Illuminate\Support\Facades\Storage::url($item->attachment->file)}}">
                    @endif
                </div>
            </div>

            <div class="table-responsive mb-2">
                <table class="table table-striped table-bordered">
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
                        <td>Stock</td>
                    </tr>
                    </thead>
                    <tbody>
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
                        <td>{{$item->stock ?? 0}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="row mx-0 mb-2">
                <div class="col-12 col-md-6 mb-2">
                    <h6>Stock In History</h6>
                    <ul class="list-group">
                        @forelse($item->stockins as $stockIn)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Added {{$stockIn->quantity}} {{$item->name}}</div>
                                    <p class="small">Expires at {{$stockIn->expiration->format('Y-m-d')}}</p>
                                </div>
                                <span class="text-secondary">{{$stockIn->created_at->format('Y-m-d')}}</span>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-center align-items-start">
                                <span class="text-secondary">EMPTY</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-12 col-md-6 mb-2">
                    <h6>Stock Out History</h6>
                    <ul class="list-group">
                        @forelse($item->stockOuts as $stockOut)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Remove {{$stockOut->quantity}} {{$item->name}}</div>
                                    <p class="small">Note: {{$stockOut->note}}</p>
                                </div>
                                <span class="text-secondary">{{$stockOut->created_at->format('F d, Y h:i A')}}</span>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-center align-items-start">
                                <span class="text-secondary">EMPTY</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>


            @if($errors->any())
                {{ $errors->first() }}
            @endif
        </div>
    </div>
@endsection

