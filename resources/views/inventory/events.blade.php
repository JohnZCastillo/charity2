@extends('layouts.index')

@section('body')

    <div class="p-2 bg-light h-100">

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

                    <button data-bs-toggle="modal" data-bs-target="#eventModal" type="button"
                            class="text-nowrap btn btn-primary">New Event
                    </button>
                </div>

                <div class="col-sm-12 d-flex align-items-center mt-2 gap-2 flex-wrap flex-md-nowrap ">
                    <div class="d-flex align-items-center gap-2">
                        <label class="text-nowrap">Order By</label>
                        <select class="form-select" id="orderBy" name="order">
                            <option @selected($app->request->order == 'title') value="title">Title</option>
                            <option @selected($app->request->order == 'location') value="location">Location</option>
                            <option @selected($app->request->order == 'start') value="start">Start</option>
                            <option @selected($app->request->order == 'end') value="end">End</option>
                            <option @selected($app->request->order == 'created_at') value="created_at">Created At</option>
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

        <div class="mt-3 p-2 shadow rounded bg-white">

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>description</th>
                        <th>location</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($events as $event)
                        <tr>
                            <td class="text-capitalize">{{$event->title}}</td>
                            <td class="text-capitalize">{{$event->description}}</td>
                            <td class="text-capitalize">{{$event->location}}</td>
                            <td class="text-capitalize">{{$event->start->format('y-m-d')}}</td>
                            <td class="text-capitalize">{{$event->end->format('y-m-d')}}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a type="button" href="/inventory/events/{{$event->id}}" class="btn btn-secondary">Edit</a>
                                    <form data-confirmation="Are you sure you want to delete this event?"
                                          class="confirmation" method="POST" action="/inventory/events/{{$event->id}}">
                                        @csrf
                                        @method('DELETE')
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
                {{$events->links()}}
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="eventModal">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" method="POST" action="/inventory/event">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" accept="image/*" class="form-control" name="images[]" multiple>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" class="form-control" name="location">
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-sm-12 col-md-6 form-group p-0">
                                <label>Start</label>
                                <input type="datetime-local" class="form-control" name="start">
                            </div>
                            <div class="col-sm-12 col-md-6 form-group p-0">
                                <label>End</label>
                                <input type="datetime-local" class="form-control" name="end">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
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
