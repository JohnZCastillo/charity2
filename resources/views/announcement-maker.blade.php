@extends('layouts.index')

@section('files')
    <script src="/quill/quill.js"></script>
    <script src="/quill/quill-resize-module.min.js"></script>
    <link href="/quill/quill.snow.css" rel="stylesheet"/>
@endsection

@section('body')

    <div class="p-2 bg-light h-100">

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <p class="mb-0">{{$errors->first()}}</p>
            </div>
        @endif

        <form method="POST" action="/announcement" id="announcementForm">

            @csrf

            <div class="mb-2">
                <input  name="title" type="text" class="form-control" placeholder="Title" required/>
            </div>

            <div id="editor"></div>

            <textarea id="content" name="content" type="hidden" class="d-none"></textarea>

            <div class="d-flex align-items-center gap-2 mt-2">
                <a href="/inventory/announcements" type="button" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        const announcementForm = document.querySelector('#announcementForm');

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
            document.querySelector('#content').innerHTML = quill.getSemanticHTML();
            announcementForm.submit();
        });

    </script>
@endsection
