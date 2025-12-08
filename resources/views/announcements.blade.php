@extends('layouts.index')

@section('body')

    <div class="p-2">
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif

        <div class="mt-2 grid grid-rows-1  grid-cols-12 gap-2">

            <form id="searchForm" class="col-span-10">


                <div class="row mx-0">

                    <div class="col-12 col-md-10">
                        <input id="searchInput" value="{{$app->request->search}}"
                               placeholder="Search"
                               type="search"
                               name="search"
                               class="form-control">

                    </div>

                    <a type="button" href="/create-announcement" class="mt-2 mt-md-0 col-12 col-md-2 btn btn-secondary">New Announcement</a>
                </div>

                <div class="row mx-0 mt-2">

                    <div class="col-6 col-md-3">

                        <div class="d-flex align-items-center gap-2">
                            <label class="text-nowrap">Order By</label>
                            <select class="form-select" id="orderBy" name="order">
                                <option @selected($app->request->order == 'title') value="title">Title</option>
                                <option @selected($app->request->order == 'created_at') value="created_at">Date</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-nowrap">Sort by</label>
                            <select class="form-select" id="sortBy" name="sort">
                                <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                                <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-3 p-2 shadow rounded bg-white">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($announcements as $announcement)
                        <tr>
                            <td class="text-capitalize">{{$announcement->title}}</td>
                            <td class="text-capitalize">
                                @if($announcement->user)
                                    {{$announcement->user->name}}
                                @endif
                            </td>
                            <td class="text-capitalize">{{$announcement->created_at->format('Y-m-d')}}</td>
                            <td class="text-capitalize">
                                <div class="d-flex gap-2 items-center">

                                    <a href="/inventory/announcement/{{$announcement->id}}" type="button"
                                       class="btn btn-primary">Edit</a>

                                    <form data-confirmation="Are you sure you want to delete this announcement?"
                                          class="confirmation" method="POST"
                                          action="/inventory/announcement/{{$announcement->id}}">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="py-2">
                {{$announcements->links()}}
            </div>
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
