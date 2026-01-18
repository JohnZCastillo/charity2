@extends('layouts.index')

@section('body')

    <div class="p-2 bg-light h-100">

        <div class="p-2">
            <h4 class="fw-bold">Users</h4>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        @endif

        <div class="mt-2">

            <form id="searchForm" class="form">
                <div class="d-flex align-items-center gap-1 mx-0 flex-wrap flex-md-nowrap">
                    <input id="searchInput" value="{{$app->request->search}}" placeholder="Search"
                           type="search"
                           name="search"
                           class="form-control">

                    <button data-bs-toggle="modal" data-bs-target="#addUserModal" type="button"
                            class="text-nowrap btn btn-primary">New User
                    </button>
                </div>

                <div class="col-sm-12 d-flex align-items-center mt-2 gap-2 flex-wrap flex-md-nowrap ">
                    <div class="d-flex align-items-center gap-2">
                        <label class="text-nowrap">Order By</label>
                        <select class="form-select" id="orderBy" name="order">
                            <option @selected($app->request->order == 'name') value="name">Name</option>
                            <option @selected($app->request->order == 'email') value="email">Email</option>
                            <option @selected($app->request->order == 'created_at') value="created_at">Date Added</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <label class="text-nowrap">Sort by</label>
                        <select class="form-select" id="sortBy" name="sort">
                            <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                            <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-3 p-2 rounded bg-white">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Added Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse ($users as $user)
                        <tr>
                            <td class="text-capitalize">{{$user->name}}</td>
                            <td class="text-capitalize">{{$user->email}}</td>
                            <td class="text-capitalize">{{$user->created_at->format('F d, Y h:i A')}}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <form data-confirmation="Are you sure you want to delete user {{$user->name}}?"
                                            class="confirmation" method="POST"
                                            action="/inventory/users/archived/{{$user->id}}">
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr style="line-height: 300px">
                            <td colspan="4" class="text-center text-secondary">EMPTY</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>

            <div class="py-2">
                {{$users->links()}}
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="addUserModal">
        <div class="modal-dialog">
            <form method="POST" action="/inventory/users">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Confirm Password</label>
                            <input id="password2" type="password" class="form-control" name="password2" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy');
        })
    </script>
@endsection
