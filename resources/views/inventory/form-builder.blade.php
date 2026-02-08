@extends('layouts.index')

@section('title', 'Form Generator')

@section('body')
<!-- Quill Styles -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

<style>
    .field-box {
        background: #f9f9f9;
        border-left: 4px solid #0d6efd;
        padding: 1rem;
        border-radius: 6px;
        position: relative;
    }
    .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .field-controls label {
        font-weight: bold;
    }
    #form-preview {
        background: #ffffff;
        min-height: 150px;
        border-radius: 6px;
    }
    .floating-menu {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    .floating-menu .menu-items {
        display: none;
        flex-direction: column;
        margin-bottom: 10px;
        width: 220px;
        transition: all 0.3s ease-in-out;
    }
    .floating-menu.show .menu-items {
        display: flex;
    }
</style>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Form Builder</h2>
        <a href="{{ route('form-builder.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to Forms</a>
    </div>

    <form method="POST" action="{{ route('form-builder.store') }}">
        @csrf

        <div class="mb-3">
            <label for="form-title" class="form-label">Form Title</label>
            <input type="text" name="title" id="form-title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Limit Number of Respondents</label>
            <input type="number" name="response_limit" class="form-control" min="1" placeholder="Leave blank for unlimited">
        </div>


        <div id="form-fields" class="mb-4"></div>

        <input type="hidden" name="form_structure" id="form_structure">
        <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Save Form</button>
    </form>
    <hr>
    <h4>Live Preview</h4>
    <div id="form-preview" class="p-3 border"></div>

    <!-- Floating Button Menu -->
<div class="floating-menu">
    <button class="btn btn-primary rounded-circle shadow-lg" onclick="toggleFieldMenu()" title="Add Field">
        <i class="fa fa-plus"></i>
    </button>
    <div class="menu-items shadow p-3 rounded bg-white border">
        <button class="btn btn-primary mb-2 w-100" onclick="addField('text')" title="Text Input">
            <i class="fa fa-font me-1"></i>Add Text
        </button>
        <button class="btn btn-secondary mb-2 w-100" onclick="addField('textarea')" title="WYSIWYG Textarea">
            <i class="fa fa-edit me-1"></i>Add WYSIWYG
        </button>
        <button class="btn btn-success mb-2 w-100" onclick="addField('radio')" title="Radio Group">
            <i class="fa fa-dot-circle me-1"></i> Add Radio
        </button>
        <button class="btn btn-warning mb-2 w-100" onclick="addField('checkbox')" title="Checkbox Group">
            <i class="fa fa-check-square me-1"></i> Add Checkbox
        </button>
        <button class="btn btn-info mb-2 w-100" onclick="addField('select')" title="Dropdown Select">
            <i class="fa fa-caret-down me-1"></i> Add Dropdown
        </button>
        <button class="btn btn-dark mb-2 w-100" onclick="addField('upload')" title="File Upload">
            <i class="fa fa-upload me-1"></i> Add Upload
        </button>
    </div>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
let fieldCount = 0;
let fields = [];

function toggleFieldMenu() {
    document.querySelector('.floating-menu').classList.toggle('show');
}

function addField(type) {
    const id = fieldCount++;
    let html = `<div class="field-box mb-3" data-id="${id}">
        <div class="field-controls">
            <label>Field Label</label>
            <input type="text" class="form-control mb-2" oninput="updateField(${id}, this.value)">
            <input type="hidden" data-type="${type}">`;

    if (type === 'textarea') {
        html += `<div id="quill-editor-${id}" style="height: 150px;"></div>
                 <input type="hidden" id="quill-content-${id}">`;
    } else if (["radio", "checkbox", "select"].includes(type)) {
        html += `<label>Options <small class="text-muted">(comma-separated)</small></label>
                 <input type="text" class="form-control mb-2" oninput="updateOptions(${id}, this.value)">`;
    } else if (type === 'upload') {
        html += `
            <label>Allowed File Types <small class="text-muted">(comma-separated: e.g., jpg,png,mp4,pdf)</small></label>
            <input type="text" class="form-control mb-2" oninput="updateOptions(${id}, this.value)">
            <label>Max Size (MB)</label>
            <input type="number" class="form-control mb-2" min="1" oninput="updateMaxSize(${id}, this.value)">
        `;
    }

    html += `<div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" id="required-${id}" onchange="toggleRequired(${id}, this.checked)">
                <label class="form-check-label" for="required-${id}">Required</label>
            </div>
            <button type="button" class="btn btn-sm  btn-danger remove-btn" onclick="removeField(${id})"><i class="fa fa-trash"></i> Remove</button>
        </div>
    </div>`;

    document.getElementById('form-fields').insertAdjacentHTML('beforeend', html);

    fields.push({
        id,
        type,
        label: '',
        options: type === 'textarea' ? '' : [],
        required: false,
        maxSize: null,
    });

    if (type === 'textarea') {
        const quill = new Quill(`#quill-editor-${id}`, {
            theme: 'snow',
            placeholder: 'Enter content...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }]
                ]
            }
        });

        quill.on('text-change', function () {
            const html = quill.root.innerHTML;
            document.getElementById(`quill-content-${id}`).value = html;
            updateOptions(id, html);
        });
    }

    updateJson();
}


function updateField(id, label) {
    const field = fields.find(f => f.id === id);
    if (field) field.label = label;
    updateJson();
}

function updateOptions(id, value) {
    const field = fields.find(f => f.id === id);
    if (field) {
        if (field.type === 'textarea') {
            field.options = value; // HTML string
        } else {
            field.options = (value || '').split(',').map(opt => opt.trim());
        }
    }
    updateJson();
}

function toggleRequired(id, isChecked) {
    const field = fields.find(f => f.id === id);
    if (field) {
        field.required = isChecked;
        updateJson();
    }
}

function updateMaxSize(id, value) {
    const field = fields.find(f => f.id === id);
    if (field) {
        field.maxSize = parseInt(value) || null;
        updateJson();
    }
}

function removeField(id) {
    document.querySelector(`[data-id="${id}"]`).remove();
    fields = fields.filter(f => f.id !== id);
    updateJson();
}

function updateJson() {
    document.getElementById('form_structure').value = JSON.stringify(fields);
    renderPreview();
}

function renderPreview() {
    const preview = document.getElementById('form-preview');
    preview.innerHTML = '';

    fields.forEach(field => {
        const container = document.createElement('div');
        container.classList.add('mb-3');

        const label = document.createElement('label');
        label.textContent = field.label;
        label.classList.add('form-label');
        container.appendChild(label);

        switch (field.type) {
            case 'text':
                container.innerHTML += `<input type="text" class="form-control">`;
                break;
            case 'textarea':
                const wysiwyg = document.createElement('div');
                wysiwyg.className = 'border p-2 bg-white';
                wysiwyg.innerHTML = field.options;
                container.appendChild(wysiwyg);
                break;
            case 'radio':
                field.options.forEach(opt => {
                    const radioLabel = document.createElement('label');
                    radioLabel.classList.add('form-check', 'form-check-inline');
                    radioLabel.innerHTML = `<input type="radio" name="radio-${field.id}" class="form-check-input"> ${opt}`;
                    container.appendChild(radioLabel);
                });
                break;
            case 'checkbox':
                field.options.forEach(opt => {
                    const checkboxLabel = document.createElement('label');
                    checkboxLabel.classList.add('form-check', 'form-check-inline');
                    checkboxLabel.innerHTML = `<input type="checkbox" class="form-check-input"> ${opt}`;
                    container.appendChild(checkboxLabel);
                });
                break;
            case 'select':
                const select = document.createElement('select');
                select.className = 'form-select';
                field.options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt;
                    option.textContent = opt;
                    select.appendChild(option);
                });
                container.appendChild(select);
                break;
                case 'upload':
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.className = 'form-control';
                    if (field.required) input.required = true;
                    container.appendChild(input);
                    break;

        }

        preview.appendChild(container);
    });
}
</script>



<!-- back to top -->
<style>
 #backToTop {
    position: fixed;
    bottom: 90px; /* same as floatingMenu's bottom, but higher */
    right: 20px; /* align with the floating button */
    z-index: 1000; /* higher than floatingMenuToggle (which is 1050) */
    background:rgb(2, 55, 146);
    color: white;
    padding: 12px 14px;
    border-radius: 10px;
    cursor: pointer;
    border: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}
#backToTop:hover {
    background: #084298;
}

 </style>
<button onclick="topFunction()" id="backToTop" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>
<script>
    function topFunction() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
