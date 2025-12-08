@extends('layouts.index')

@section('title', 'Edit Form: ' . ($form->title ?? 'Untitled'))

@section('body')
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

    #form-preview {
        background: #ffffff;
        min-height: 150px;
        border-radius: 6px;
        padding: 1rem;
        border: 1px solid #ccc;
    }

    #floatingMenuToggle {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        background-color: #0d6efd;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 55px;
        height: 55px;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
    }

    #floatingMenuToggle:hover {
        background-color: #0b5ed7;
    }
    #floatingMenu {
    position: fixed;
    bottom: 90px;
    right: 20px;
    z-index: 1040;
    display: none;
    flex-direction: column;
    gap: 10px;
    transition: all 0.3s ease;
}

    #floatingMenu.show {
        display: flex;
    }
    .floating-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        font-size: 14px;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Form</h2>
        <a href="{{ route('form-builder.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left"></i> Back to Forms
        </a>
    </div>

    <form method="POST" action="{{ route('form-builder.update', $form->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Form Title</label>
            <input type="text" name="title" class="form-control" value="{{ $form->title }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Limit Number of Respondents (Leave blank for unlimited)</label>
            <input type="number" name="response_limit" class="form-control" value="{{ $form->response_limit }}" >
        </div>

        <div id="form-fields" class="mb-4"></div>

        <input type="hidden" name="form_structure" id="form_structure">
        <button type="submit" class="btn btn-success">Update Form</button>
    </form>

    <hr>
    <h4>Live Preview</h4>
    <div id="form-preview"></div>

    <!-- Floating Menu Button -->
    <button id="floatingMenuToggle" onclick="toggleFloatingMenu()">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Floating Field Buttons -->
    <div id="floatingMenu" class="flex-column">
        <button type="button" class="btn btn-primary floating-btn" onclick="addField('text')" title="Add Text Input">
            <i class="fa fa-font"></i> Text Input
        </button>
        <button type="button" class="btn btn-secondary floating-btn" onclick="addField('textarea')" title="Add WYSIWYG">
            <i class="fa fa-edit"></i> WYSIWYG
        </button>
        <button type="button" class="btn btn-success floating-btn" onclick="addField('radio')" title="Add Radio Group">
            <i class="fa fa-dot-circle"></i> Radio Group
        </button>
        <button type="button" class="btn btn-warning floating-btn" onclick="addField('checkbox')" title="Add Checkbox Group">
            <i class="fa fa-check-square"></i> Checkboxes
        </button>
        <button type="button" class="btn btn-info floating-btn" onclick="addField('select')" title="Add Dropdown">
            <i class="fa fa-caret-down"></i> Dropdown
        </button>
        <button type="button" class="btn btn-dark floating-btn" onclick="addField('upload')" title="Add File Upload">
            <i class="fa fa-upload"></i> File Upload
        </button>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
let fields = @json($structure);
let maxId = fields.length ? Math.max(...fields.map(f => f.id)) : 0;
let fieldCount = maxId + 1;

// ✅ Declare this OUTSIDE so onclick can access it
function toggleFloatingMenu() {
    const menu = document.getElementById('floatingMenu');
    menu.classList.toggle('show');
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('floatingMenu').classList.remove('show');
    renderFields(); // Only call render inside here
});


function renderFields() {
    document.getElementById('form-fields').innerHTML = '';
    fields.forEach(field => addField(field.type, field));
    updateJson();
}

function addField(type, data = null) {
    const id = data?.id ?? fieldCount++;
    const label = data?.label || '';
    const options = data?.options || (type === 'textarea' ? '' : []);
    const maxSize = data?.maxSize || 2;
    const required = data?.required || false;

    if (!data) {
        fields.push({ id, type, label, options, required });
    }

    let html = `<div class="field-box mb-3" data-id="${id}">
        <div class="field-controls">
            <label>Field Label</label>
            <input type="text" class="form-control mb-2" value="${label}" oninput="updateField(${id}, this.value)">
            <input type="hidden" data-type="${type}">`;

    if (type === 'textarea') {
        html += `<div id="quill-editor-${id}" style="height: 150px;"></div>
                 <input type="hidden" id="quill-content-${id}" value="${options}">`;
    } else if (["radio", "checkbox", "select"].includes(type)) {
        html += `<label>Options <small>(comma-separated)</small></label>
                 <input type="text" class="form-control" value="${Array.isArray(options) ? options.join(', ') : ''}" oninput="updateOptions(${id}, this.value)">`;
    } else if (type === 'upload') {
        html += `<label>Allowed File Extensions <small>(comma-separated)</small></label>
                 <input type="text" class="form-control mb-2" value="${Array.isArray(options) ? options.join(', ') : ''}" oninput="updateOptions(${id}, this.value)">
                 <label>Max Size (MB)</label>
                 <input type="number" class="form-control" value="${maxSize}" oninput="updateMaxSize(${id}, this.value)">`;
    }

    html += `<div class="form-check mt-2">
        <input type="checkbox" class="form-check-input" id="required-${id}" ${required ? 'checked' : ''} onchange="toggleRequired(${id}, this.checked)">
        <label class="form-check-label" for="required-${id}">Required</label>
    </div>
    <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeField(${id})"><i class="fa fa-trash"></i> Remove</button>
    </div></div>`;

    document.getElementById('form-fields').insertAdjacentHTML('beforeend', html);

    if (type === 'textarea') {
        const quill = new Quill(`#quill-editor-${id}`, {
            theme: 'snow',
            placeholder: 'Enter content...',
            modules: { toolbar: [['bold', 'italic'], ['link'], [{ 'list': 'bullet' }]] }
        });
        quill.root.innerHTML = options;
        quill.on('text-change', function () {
            const html = quill.root.innerHTML;
            document.getElementById(`quill-content-${id}`).value = html;
            updateOptions(id, html);
        });
    }

    renderPreview();
}

function updateField(id, label) {
    const field = fields.find(f => f.id === id);
    if (field) field.label = label;
    updateJson();
}

function updateOptions(id, value) {
    const field = fields.find(f => f.id === id);
    if (field) field.options = field.type === 'textarea' ? value : value.split(',').map(s => s.trim());
    updateJson();
}

function updateMaxSize(id, size) {
    const field = fields.find(f => f.id === id);
    if (field) field.maxSize = parseFloat(size) || 1;
    updateJson();
}

function toggleRequired(id, value) {
    const field = fields.find(f => f.id === id);
    if (field) field.required = value;
    updateJson();
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
        label.classList.add('form-label');
        label.textContent = field.label;
        container.appendChild(label);

        switch (field.type) {
            case 'text':
                container.innerHTML += `<input type="text" class="form-control" ${field.required ? 'required' : ''}>`;
                break;
            case 'textarea':
                const wysiwyg = document.createElement('div');
                wysiwyg.className = 'border p-2 bg-white';
                wysiwyg.innerHTML = field.options;
                container.appendChild(wysiwyg);
                break;
            case 'radio':
                field.options.forEach(opt => {
                    const radio = document.createElement('div');
                    radio.classList.add('form-check', 'form-check-inline');
                    radio.innerHTML = `<input type="radio" class="form-check-input" name="radio-${field.id}" ${field.required ? 'required' : ''}> ${opt}`;
                    container.appendChild(radio);
                });
                break;
            case 'checkbox':
                field.options.forEach(opt => {
                    const checkbox = document.createElement('div');
                    checkbox.classList.add('form-check', 'form-check-inline');
                    checkbox.innerHTML = `<input type="checkbox" class="form-check-input" ${field.required ? 'required' : ''}> ${opt}`;
                    container.appendChild(checkbox);
                });
                break;
            case 'upload':
                container.innerHTML += `<input type="file" class="form-control" ${field.required ? 'required' : ''}>`;
                break;
            case 'select':
                const select = document.createElement('select');
                select.classList.add('form-select');
                if (field.required) select.required = true;
                field.options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt;
                    option.textContent = opt;
                    select.appendChild(option);
                });
                container.appendChild(select);
                break;
        }

        preview.appendChild(container);
    });
}

document.addEventListener('DOMContentLoaded', renderFields);
</script>

<!-- back to top -->
 <style>
 #backToTop {
    position: fixed;
    bottom: 90px; /* same as floatingMenu's bottom, but higher */
    right: 30px; /* align with the floating button */
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
