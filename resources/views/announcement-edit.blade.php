@extends('layouts.index')

@section('files')
    <script src="/quill/quill.js"></script>
    <script src="/quill/quill-resize-module.min.js"></script>
    <link href="/quill/quill.snow.css" rel="stylesheet"/>
@endsection

@section('body')

    <div class="p-2">

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">{{$errors->first()}}</p>
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="alert alert-success" role="alert">
                <p class="mb-0">{{\Illuminate\Support\Facades\Session::get('message')}}</p>
            </div>
        @endif

        <form method="POST" action="/inventory/announcement/{{$announcement->id}}" id="announcementForm">

            @method('PATCH')
            @csrf

            <div class="mb-2">
                <input value="{{$announcement->title}}" name="title" type="text" class="form-control"
                       placeholder="Title"/>
            </div>

            <div id="editor"></div>

            <textarea id="content" name="content" type="hidden" class="d-none"></textarea>

            <div class="d-flex align-items-center gap-2 mt-2">
                <a href="/inventory/announcements" type="button" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        const announcementForm = document.querySelector('#announcementForm');

        var Parchment = Quill.import('parchment');

        var BaseImageFormat = Quill.import('formats/image');
        const ImageFormatAttributesList = [
            'alt',
            'height',
            'width',
            'style'
        ];

        class ImageFormat extends BaseImageFormat {
            static formats(domNode) {
                return ImageFormatAttributesList.reduce(function(formats, attribute) {
                    if (domNode.hasAttribute(attribute)) {
                        formats[attribute] = domNode.getAttribute(attribute);
                    }
                    return formats;
                }, {});
            }
            format(name, value) {
                if (ImageFormatAttributesList.indexOf(name) > -1) {
                    if (value) {
                        this.domNode.setAttribute(name, value);
                    } else {
                        this.domNode.removeAttribute(name);
                    }
                } else {
                    super.format(name, value);
                }
            }
        }

        Quill.register(ImageFormat, true);
        Quill.register("modules/resize", window.QuillResizeModule);

        var icons = Quill.import('ui/icons');

        icons['code-block'] = '<i class="fa-regular fa-file"></i>';

        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],          // Basic text formatting
            [{'list': 'ordered'}, {'list': 'bullet'}],       // Lists
            ['blockquote',],                      // Block-level elements
            [{'size': ['small', 'normal', 'large', 'huge']}],
            [{'header': [1, 2, 3, 4, 5, 6, false]}],          // Headers
            [{'color': []}, {'background': []}],            // Text color and background
            [{'font': []}],                                   // Font family
            [{'align': []}],                                  // Text alignment
            [{'script': 'sub'}, {'script': 'super'}],        // Superscript and subscript
            [{'indent': '-1'}, {'indent': '+1'}],            // Indentation
            ['image',],                        // Links, images, and videos
            ['clean'],                                          // Clear formatting
        ];

        var quill = new Quill("#editor", {
            theme: "snow",
            modules: {
                toolbar: toolbarOptions,
                resize: {},
            },
        });

        quill.getModule("toolbar").addHandler("image", function () {

            // Create an input element to select the image file
            const input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");
            input.click();

            // Handle the image file selection
            input.onchange = async function () {
                const file = input.files[0];

                // Create a FormData object to store the image file
                const formData = new FormData();
                formData.append("image", file);

                // Log the image uploading process
                console.log("Uploading image:", file.name);
                try {

                    // Send the image file to the server using Fetch
                    const result = await fetch("/announcement-attachment", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": '{{csrf_token()}}'
                        }
                    });

                    const data = await result.json();

                    console.log(data);

                    if (!result.ok) {
                        throw new Error("Error uploading file");
                    }

                    const range = quill.getSelection() ?? {index: 0, length: 0};

                    quill.insertEmbed(range.index, "image", data.file);
                } catch (error) {
                    console.log(error.message)
                }
            };
        });

        announcementForm.addEventListener("submit", (event) => {
            event.preventDefault();
            document.querySelector('#content').innerHTML = document.querySelector(".ql-editor").innerHTML;
            announcementForm.submit();
        });

        window.addEventListener('load', () => {
            quill.clipboard.dangerouslyPasteHTML(`{!! $announcement->content !!}`)
        })

    </script>
@endsection
