@extends('layouts.index')

@section('body')

    <div class="p-2 h-100 bg-light">


        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        @endif

            @if(\Illuminate\Support\Facades\Session::get('message'))
                <div class="alert alert-success" role="alert">
                    {{\Illuminate\Support\Facades\Session::get('message')}}
                </div>
            @endif

        <div class="h-100">

            <div class="w-75 mx-auto">

                <h1>User Account</h1>
                <hr>
                <div class="form-group mb-2">
                    <label>Email</label>
                    <input value="{{$user->email}}" name="text" type="text" class="form-control" readonly>
                </div>

                <div class="form-group mb-2">
                    <label>Name</label>
                    <input value="{{$user->name}}" name="text" type="text" class="form-control" readonly>
                </div>

                <div class="row mb-2 gap-2 mx-0">

                    <button type="button" class="btn btn-primary col-12 col-sm-3 mb-2" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                        Update Account
                    </button>

                    <button type="button" class="btn btn-secondary col-12 col-sm-3 mb-2" data-bs-toggle="modal"
                            data-bs-target="#updatePasswordModal">
                        Update Password
                    </button>
                </div>
            </div>

            <form data-confirmation="Are you sure you want to logout?" class="d-md-none confirmation  mt-3 w-75 mx-auto"
                  action="/inventory/logout" method="POST">
                @csrf
                <button class="btn btn-secondary" type="Submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/inventory/account">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input id="editEmail" value="{{$user->email}}" name="email" type="email"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input id="editName" value="{{$user->name}}" name="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/inventory/account">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input name="newPassword" type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input name="confirmPassword" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection