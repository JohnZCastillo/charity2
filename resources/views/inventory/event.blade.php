@extends('layouts.index')

@section('body')

    <div class="container-fluid h-100 bg-light pb-5 pt-2">
        @if($errors->any())
            <h4 class="text-danger">{{$errors->first()}}</h4>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('success'))
            <h4 class="text-success">{{\Illuminate\Support\Facades\Session::get('success')}}</h4>
        @endif

        <div class="mb-2 overflow-auto">
            <div class="d-flex align-items-center gap-2 pb-2">
                @foreach($event->images as $image)
                    <x-event-image-form :image="$image"/>
                @endforeach
            </div>
        </div>

        <form method="POST" action="/inventory/events/{{$event->id}}" enctype="multipart/form-data">

            @csrf
            @method('PATCH')

            <div class="form-group mb-2">
                <label for="title">Image</label>
                <input class="form-control" id="image" type="file" accept="image/*" name="images[]" multiple>
            </div>

            <div class="form-group mb-2">
                <label for="title">Title</label>
                <input class="form-control" id="title" type="text" name="title" value="{{$event->title}}" required>
            </div>

            <div class="form-group mb-2">
                <label for="description">Description</label>
                <textarea rows='5' class="form-control" name="description" id="description">{{$event->description}}</textarea>
            </div>

            <div class="form-group mb-2">
                <label for="description">Select Form</label>
                <select name='form_id' class="form-select">
                    <option value="0">None</option>
                    @foreach ($forms as $form)
                        <option   @selected($event->form_id) value="{{$form->id}}">{{$form->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label for="location">Location</label>
                <input class="form-control" id="location" type="text" name="location" value="{{$event->location}}"
                       required>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <label for="start">Start</label>
                    <input value="{{$event->start}}" class="form-control" type="datetime-local" name="start" id="start"
                           required>
                </div>

                <div class="col-sm-12 col-md-6">
                    <label for="end">End</label>
                    <input value="{{$event->end}}" class="form-control" type="datetime-local" name="end" id="end"
                           required>
                </div>
            </div>

            <div class="d-flex gap-3 align-items-center mt-2 pb-5">
                <a class="btn btn-secondary" type="button" href="/inventory/events">Back</a>
                <button class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>

@endsection
