@extends('layouts.index')

@section('styles')
@endsection

@section('body')

    <div class="bg-light p-2">

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4>{{$errors->first()}}</h4>
            </div>
        @endif

        <h1 class="text-xl font-bold text-gray-700">EDIT RECIPIENT</h1>

        <div class="p-2 w-75 mx-auto">

            <form class="form" method="POST" action="/inventory/recipients/{{$recipient->id}}">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label class="label-text">Recipient Code</label>
                    <input value="{{$recipient->code}}" name="code" type="text" class="form-control"/>
                </div>

                <div class="form-group">
                    <label class="label-text">Name</label>
                    <input value="{{$recipient->name}}" name="name" type="text" class="form-control"/>
                </div>

                <div class="form-group">
                    <label class="label-text">Mobile</label>
                    <input value="{{$recipient->mobile}}" name="mobile" type="text" class="form-control"/>
                </div>

                <div class="form-group">
                    <label class="label-text">Email</label>
                    <input value="{{$recipient->email}}" name="email" type="email" class="form-control"/>
                </div>

                <div class="form-group">
                    <label class="label-text">Address</label>
                    <input value="{{$recipient->address->address}}" name="address" type="text" class="form-control"/>
                </div>

                <div class="form-group">
                    <label class="label-text">Status</label>
                    <select name="status" class="form-select">
                        @foreach(\App\Enums\UserStatus::cases() as $status)
                            <option
                                @selected($recipient->status == $status) value="{{$status->value}}">{{$status->value}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2 align-items-center mt-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/inventory/donors" type="button" class="btn btn-secondary">Back</a>
                </div>

            </form>
        </div>
    </div>
@endsection

