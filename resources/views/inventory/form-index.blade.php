@extends('layouts.index')

@section('title', 'All Forms')

@section('body')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<div class="container py-4">


    <div class="p-2">
        <h4 class="fw-bold">Form Builder</h4>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">📋 Saved Forms</h2>
        <a href="{{ route('form-builder.create') }}" class="btn btn-success rounded">
            <i class="fa fa-plus me-1"></i> Create New Form
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded shadow-sm">{{ session('success') }}</div>
    @endif

    @if($forms->count())
        <div class="row g-3">
            @foreach($forms as $form)
                <div class="col-md-6 col-lg-4" title="Click to view, edit, view response or delete form">
                    <a href="{{ route('form-builder.show', $form->id) }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-dark border-2 hover-shadow">
                            <div class="card-body">
                                <h5 class="card-title mb-1 text-primary">
                                    {{ $form->title ?? 'Untitled Form' }}
                                </h5>
                                <p class="text-muted mb-2">
                                    <small><i class="fa fa-calendar-alt me-1"></i> {{ $form->created_at->format('F j, Y') }}</small>
                                </p>
                                <span class="badge bg-success">
                                    <i class="fa fa-users me-1"></i>
                                    {{ $form->responses()->count() ?? 0 }} Responses
                                </span>
                            </div>
                            <div class="card-footer bg-light d-flex justify-content-between">
                                <small class="text-muted">Last updated: {{ $form->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center p-4 rounded shadow-sm">
            No forms created yet. Start by clicking "Create New Form".
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        transition: 0.2s ease-in-out;
    }
</style>
@endsection
