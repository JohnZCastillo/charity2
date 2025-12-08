@extends('layouts.index')

@section('title', $form->title ?? 'Form Preview')

@section('body')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>

<style>
    .form-container {
        max-width: 720px;
        margin: 0 auto;
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .form-id {
        font-size: 0.9rem;
        color: #666;
    }

    .form-label {
        font-weight: 500;
    }

    .question-block {
        padding: 1rem 0;
        border-bottom: 1px solid #eee;
    }

    #share-section {
        background: #f9f9f9;
        padding: 1rem;
        border-radius: 10px;
        max-width: 720px;
        margin: 0 auto 2rem auto;
    }
</style>

@php
    $formUrl = route('form.public.show', $form->id);
    $fields = is_array($form->structure) ? $form->structure : json_decode($form->structure, true);
@endphp

<div class="container py-5">

    {{-- Action Buttons --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-0">{{ $form->title ?? 'Untitled Form' }}</h2>
            <small class="text-muted">Form Respondents Limit: {{ $form->response_limit ?? 0 }}</small>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
              <!-- Share Button -->
            <button type="button" class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#shareModal">
                <i class="fa fa-share-alt me-1"></i> Share
            </button>
            <a href="{{ route('form-builder.responses', $form->id) }}" class="btn btn-dark rounded">
                <i class="fa fa-chart-bar me-1"></i> Statistics
            </a>

            <a href="{{ route('form-builder.edit', $form->id) }}" class="btn btn-success rounded">
                <i class="fa fa-edit me-1"></i> Edit Form
            </a>

            <form action="{{ route('form-builder.destroy', $form->id) }}" method="POST" 
                onsubmit="return confirm('Are you sure you want to delete this form?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger rounded">
                    <i class="fa fa-trash me-1"></i> Delete
                </button>
            </form>

            <a href="{{ route('form-builder.index') }}" class="btn btn-secondary rounded">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="shareModalLabel">Share this Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="input-group mb-2">
          <input type="text" class="form-control" id="form-link" value="{{ $formUrl }}" readonly>
          <button class="btn btn-outline-dark" type="button" onclick="copyLink()" title="Copy this Link">
              <i class="fa fa-copy"></i> Copy
          </button>
          <button class="btn btn-outline-success" type="button" onclick="saveQR()" title="Download QR Code">
              <i class="fa fa-qrcode"></i> QR
          </button>
        </div>
        <div class="text-center mt-4">
            <p class="mb-2 text-muted">Scan or download this QR code to access the form</p>
            <div id="qrcode" class="d-inline-block"></div>
        </div>

      </div>

    </div>
  </div>
</div>


    {{-- Form Container --}}
    <div class="form-container">
        <form method="POST" action="#" enctype="multipart/form-data">
            @csrf
            @foreach($fields as $field)
                <div class="question-block">
                    <label class="form-label">
                        {{ $field['label'] ?? 'Unnamed Field' }}
                        @if(!empty($field['required'])) <span class="text-danger">*</span> @endif
                    </label>
                    
                    @switch($field['type'])
                        @case('text')
                            <input type="text" 
                                   name="field_{{ $field['id'] }}" 
                                   class="form-control mt-1" 
                                   {{ !empty($field['required']) ? 'required' : '' }}>
                            @break

                            @case('textarea')
                                @php
                                    $content = trim(strip_tags($field['options'] ?? ''));
                                @endphp

                                @if(!empty($content))
                                    <div class="border p-2 bg-white">
                                        {!! $field['options'] !!}
                                    </div>
                                @else
                                    <textarea name="field_{{ $field['id'] }}" 
                                            class="form-control mt-1" 
                                            rows="4"
                                            {{ !empty($field['required']) ? 'required' : '' }}></textarea>
                                @endif
                                @break


                        @case('radio')
                            <div class="mt-2">
                                @foreach(($field['options'] ?? []) as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="field_{{ $field['id'] }}" 
                                               value="{{ $option }}"
                                               {{ !empty($field['required']) ? 'required' : '' }}>
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @break

                        @case('checkbox')
                            <div class="mt-2">
                                @foreach(($field['options'] ?? []) as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="field_{{ $field['id'] }}[]" 
                                               value="{{ $option }}">
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @break

                        @case('select')
                            <select name="field_{{ $field['id'] }}" 
                                    class="form-select mt-1"
                                    {{ !empty($field['required']) ? 'required' : '' }}>
                                @foreach(($field['options'] ?? []) as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                            @break

                        @case('upload')
                            <input type="file"
                                   name="field_{{ $field['id'] }}"
                                   class="form-control mt-1"
                                   {{ !empty($field['required']) ? 'required' : '' }}
                                   {{ isset($field['options']) && is_array($field['options']) && count($field['options']) ? 'accept=' . implode(',', array_map(fn($ext) => '.' . $ext, $field['options'])) : '' }}>
                            @if(isset($field['maxSize']))
                                <small class="text-muted">Max size: {{ $field['maxSize'] }} MB</small>
                            @endif
                            @break

                        @default
                            <p class="text-muted">Unknown field type.</p>
                    @endswitch
                </div>
            @endforeach

            <div class="text-end mt-4">
                <button type="button" class="btn btn-success btn-lg px-4" onclick="alert('This is just a test submission.')">
                    <i class="fa fa-paper-plane"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const shareModal = document.getElementById('shareModal');
    shareModal.addEventListener('shown.bs.modal', () => {
        const qrContainer = document.getElementById("qrcode");
        if (!qrContainer.hasChildNodes()) {
            new QRCode(qrContainer, {
                text: "{{ $formUrl }}",
                width: 128,
                height: 128
            });
        }
    });
});

function copyLink() {
    const linkInput = document.getElementById("form-link");
    linkInput.select();
    document.execCommand("copy");
    alert("Link copied to clipboard!");
}

function saveQR() {
    const qr = document.querySelector('#qrcode canvas');
    if (!qr) return alert('QR not found');
    const link = document.createElement('a');
    link.href = qr.toDataURL("image/png");
    link.download = "form_qr.png";
    link.click();
}
</script>

@endsection
