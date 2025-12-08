<!DOCTYPE html >
<html data-theme="cupcake" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="/css/sweet-alert.css">
    <script src="/js/sweet-alert.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>

    {{--    @vite('resources/css/app.css')--}}

    @yield('files')

    @yield('styles')

    <style>
        .full-screen {
            height: 100vh;
            max-height: 100vh;
        }
    </style>
</head>
<body>

<div class="full-screen bg-light">
    <main class="h-100 d-flex align-items-center justify-content-center px-2">
        <form method="POST" action="/inventory/login" class="bg-white form mx-auto w-100 rounded shadow py-4 px-2" style="max-width: 600px">
            @csrf
            <h1 class="fw-bold text-uppercase text-secondary">Inventory System Login</h1>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="mt-2 btn btn-success">Login</button>

            <small class="d-block text-danger text-center">
                @if($errors->any())
                    {{$errors->first()}}
                @endif
            </small>
        </form>
    </main>
</div>
</body>
</html>
