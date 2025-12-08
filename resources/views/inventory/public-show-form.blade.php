<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $form->title ?? 'Public Form' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($home->system_logo ?? 'img/favicon.ico') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- QR Code -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f1f3f4;
        }

        .form-card {
            background: #fff;
            max-width: 720px;
            margin: auto;
            margin-top: 3rem;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .form-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-footer {
            text-align: center;
            color: #888;
            font-size: 0.85rem;
            margin-top: 4rem;
            padding-bottom: 2rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.3rem;
        }

        .form-section {
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="form-card">
        <div class="mb-4">
            <div class="form-title">{{ $form->title ?? 'Untitled Form' }}</div>
            <div class="form-subtitle">Please fill out this form</div>
        </div>
        @if ($errors->has('form_limit'))
            <div class="alert alert-danger">
                <strong>{{ $errors->first('form_limit') }}</strong>
            </div>
        @endif

    


        @php
            $fields = is_array($form->structure) ? $form->structure : json_decode($form->structure, true);
            $formUrl = route('form.public.show', $form->id);
        @endphp

        <form method="POST" action="{{ route('form-builder.submission', $form->id) }}" enctype="multipart/form-data">
    @csrf

    @foreach ($fields as $field)
        <div class="form-section">
            <label class="form-label">
                {{ $field['label'] ?? 'Field' }}
                @if(!empty($field['required'])) <span class="text-danger">*</span> @endif
            </label>

            @switch($field['type'])
                @case('text')
                    <input type="text" name="field_{{ $field['id'] }}" class="form-control" {{ !empty($field['required']) ? 'required' : '' }}>
                    @break
                    @case('textarea')
                            @php
                                $htmlContent = $field['options'] ?? '';
                                $hasContent = trim(strip_tags($htmlContent)) !== '';
                            @endphp

                            @if($hasContent)
                                <div class="border p-2 bg-light" style="min-height: 120px;">
                                    {!! $htmlContent !!}
                                </div>
                            @else
                                <textarea name="field_{{ $field['id'] }}" 
                                        class="form-control" 
                                        rows="4" 
                                        {{ !empty($field['required']) ? 'required' : '' }}></textarea>
                            @endif
                            @break
                @case('radio')
                    @foreach($field['options'] ?? [] as $opt)
                        <div class="form-check">
                            <input type="radio" name="field_{{ $field['id'] }}" value="{{ $opt }}" class="form-check-input" {{ !empty($field['required']) ? 'required' : '' }}>
                            <label class="form-check-label">{{ $opt }}</label>
                        </div>
                    @endforeach
                    @break

                @case('checkbox')
                    @foreach($field['options'] ?? [] as $opt)
                        <div class="form-check">
                            <input type="checkbox" name="field_{{ $field['id'] }}[]" value="{{ $opt }}" class="form-check-input">
                            <label class="form-check-label">{{ $opt }}</label>
                        </div>
                    @endforeach
                    @break

                @case('select')
                    <select name="field_{{ $field['id'] }}" class="form-select" {{ !empty($field['required']) ? 'required' : '' }}>
                        @foreach($field['options'] ?? [] as $opt)
                            <option value="{{ $opt }}">{{ $opt }}</option>
                        @endforeach
                    </select>
                    @break

                @case('upload')
                    <input type="file" name="field_{{ $field['id'] }}" class="form-control"
                        {{ !empty($field['required']) ? 'required' : '' }}
                        {{ isset($field['options']) && is_array($field['options']) ? 'accept=' . implode(',', array_map(fn($ext) => '.' . $ext, $field['options'])) : '' }}
                    >
                    @if(isset($field['maxSize']))
                        <small class="text-muted">Max size: {{ $field['maxSize'] }} MB</small>
                    @endif
                    @break

                @default
                    <p class="text-muted">Unknown field type.</p>
            @endswitch
        </div>
    @endforeach

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                    Submit
                </button>
            </div>
        </form>

        @if(session('submitted'))
    <!-- Modal -->
    <div class="modal fade" id="submittedModal" tabindex="-1" aria-labelledby="submittedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="submittedModalLabel">Form Submitted</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6 class="text-success">🎉 Thank you for your response!</h6>
                    </div>
                    <p>Your responses:</p>
                    <ul>
                        @foreach(session('submitted') as $key => $value)
                            <li>
                                <strong>{{ $key }}:</strong><br>
                                @if(is_string($value) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $value))
                                    <img src="{{ asset($value) }}" alt="{{ $key }}" class="img-fluid rounded mt-2" style="max-width: 200px;">
                                @elseif(is_array($value))
                                    {{ implode(', ', $value) }}
                                @else
                                    {{ $value }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Show modal on page load -->
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var submittedModal = new bootstrap.Modal(document.getElementById('submittedModal'));
            submittedModal.show();
        });
    </script>
@endif

    </div>

    <div class="form-footer text-center mt-4 text-muted">
    &copy; {{ date('Y') }} Missionaries of Charity Brothers — Empowering communities through better forms
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
