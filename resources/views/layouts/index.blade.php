<!DOCTYPE html >
<html data-theme="cupcake" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 @php
        use App\Models\HomeContent;

         $home = HomeContent::first();

     @endphp

    <title>@yield('title')</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset($home->system_logo ?? 'img/favicon.ico') }}">
 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="/css/sweet-alert.css">

    <script src="/js/sweet-alert.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link rel="stylesheet" href="{{asset('/css/flatly-bootstrap.min.css') }}" >

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
            crossorigin="anonymous"></script>
     <!-- TOASTR CSS -->
   <link rel="stylesheet" href="{{asset('/toastr/build/toastr.min.css') }}" >
    @yield('files')

    @yield('styles')

    <style>

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .full-screen {
            height: 100vh;
            max-height: calc(100vh - 56px);
        }

        .active {
            background-color: #f1faee
        }

        .link:hover {
            background-color: #f1faee
        }

        .form-check-input{
            border: 1px solid black !important;
        }
    </style>

    <!-- font awesome cdn -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body>


<div class="bg-gray-200 h-screen">

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #a8dadc !important;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-md-none">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/items">Commodities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/donors">Benefactors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/recipients">Beneficiaries</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/donation-drive">Donation Drive</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/announcements">Announcements</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/inquiries">Inquiries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/appointments">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/form/list">Form Builder</a>
                    </li>
                      <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('activity-logs.index') }}">Activity Logs</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/editor">Editor</a>
                    </li>
                    @can('view',\Illuminate\Support\Facades\Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/inventory/users">Users</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/inventory/account">Account</a>
                    </li>
                </ul>
            </div>
            <form data-confirmation="Are you sure you want to logout?" class="confirmation d-none d-md-block"
                  action="/inventory/logout" method="POST">
                @csrf
                <button class="btn btn-secondary" type="Submit">Logout</button>
            </form>
        </div>
    </nav>

    <main class="d-flex mx-0 full-screen">
        <aside class="px-0 d-none d-md-block">
            <ul class="h-100 list-group list-group-flush">
                <li class="link {{ request()->is('inventory/dashboard') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/dashboard">
                        <i class="bx bx-sm bx-bar-chart"></i>

                        <span class="d-none d-lg-block">Dashboard</span>
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/items') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/items">
                        <i class="bx bx-sm bx-package"></i>

                        <span class="d-none d-lg-block">Commodities</span>
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/donors') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/donors">
                        <i class="bx bx-sm bx-user-check"></i>
                        <span class="d-none d-lg-block">Benefactors</span>
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/recipients') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/recipients">
                        <i class="bx bx-sm bx-user-minus"></i>
                        <span class="d-none d-lg-block">Beneficiares</span>
                    </a>
                </li>

                <li class="link {{ request()->is('inventory/donation-drive') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/donation-drive">
                        <i class='bx bx-sm bx-donate-heart'></i>
                        <span class="d-none d-lg-block">Donation Drive</span>
                    </a>
                </li>

                <li class="link {{ request()->is('inventory/announcements') ? 'active' : '' }}">

                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/announcements">
                        <i class='bx bx-sm bxs-megaphone'></i>
                        <span class="d-none d-lg-block">Announcements</span>
                    </a>
                </li>

                <li class="link {{ request()->is('inventory/inquiries') ? 'active' : '' }}">

                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/inquiries">
                        <i class="bx bx-sm bx-notepad"></i>
                        <span class="d-none d-lg-block">Inquiries</span>
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/events') ? 'active' : '' }}">

                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/events">
                        <i class="bx bx-sm bx-calendar-event"></i>
                        <span class="d-none d-lg-block">Events</span>
                    </a>
                </li>
                <li class="link {{ request()->is('inventory/appointments') ? 'active' : '' }}">

                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/appointments">
                        <i class='bx bx-sm bx-calendar'></i>
                        <span class="d-none d-lg-block">Appointments</span>
                    </a>
                </li>
            
                {{-- <li class="link {{ request()->is('inventory/appointment-slot') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/appointment-slot">
                        <i class='bx bx-sm bx-calendar-edit'></i>
                        <span class="d-none d-lg-block">Appointment Slot</span>
                    </a>
                </li> --}}

                 <!-- FORM GENERATION -->
                <li class="link {{ request()->is('/inventory/form/list') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                    href="/inventory/form/list">
                        <i class='bx bx-sm bx-file'></i> <!-- Icon for form generation (e.g., file) -->
                        <span class="d-none d-lg-block">Form Builder</span>
                    </a>
                </li>

                <li class="link {{ request()->routeIs('activity-logs.index') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                    href="{{ route('activity-logs.index') }}">
                        <i class='bx bx-history bx-sm'></i>
                        <span class="d-none d-lg-block">Activity Log</span>
                    </a>
                </li>


                <li class="link {{ request()->is('inventory/editor') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/editor">
                        <i class='bx bx-sm bx-edit'></i>
                        <span class="d-none d-lg-block">Editor</span>
                    </a>
                </li>

              
                @can('view',\Illuminate\Support\Facades\Auth::user())
                    <li class="link {{ request()->is('inventory/users') ? 'active' : '' }}">
                        <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                           href="/inventory/users">
                            <i class='bx bx-sm bx-user-plus'></i>
                            <span class="d-none d-lg-block">Users</span>
                        </a>
                    </li>
                @endcan
                <li class="link {{ request()->is('inventory/account') ? 'active' : '' }}">
                    <a class="list-group-item list-group-item-action bg-transparent border-0 d-flex align-items-center gap-2"
                       href="/inventory/account">
                        <i class='bx bx-sm bx-user-circle'></i>
                        <span class="d-none d-lg-block">Account</span>
                    </a>
                </li>
             

               
                <!-- ACTIVITY LOGS -->
            
            </ul>
        </aside>
        <section class="flex-fill px-0 h-100" style="min-width: 0">
            @yield('body')
        </section>
    </main>

</div>

<script>

    const confirmation = document.querySelectorAll('.confirmation');

    function reloadOnEmpty(formID, searchID) {

        const form = document.querySelector(formID);
        const search = document.querySelector(searchID);

        search.addEventListener('input', () => {
            if (!search.value.length) {
                form.submit();
            }
        })
    }

    function submitFormOnChange(formID, ...inputs) {

        const form = document.querySelector(formID);

        inputs.forEach(input => {

            console.log(input);

            const formControl = document.querySelector(input);

            formControl.addEventListener('change', () => {
                form.submit();
            })
        })
    }

    confirmation.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const message = form.dataset.confirmation;

            Swal.fire({
                title: message,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        })
    })

    function back() {
        history.back();
    }

</script>

<!-- TOASTER JS -->
<script src="{{ asset('/toastr/build/toastr.min.js') }}"></script>
<script>
    // Check for the flash message and display it
    @if(session('success'))
        toastr.success('{{ session('success') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    @if(session('status'))
        toastr.success('{{ session('status') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif
    @if(session('message'))
        toastr.success('{{ session('message') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    @if(session('error'))
        toastr.error('{{ session('error') }}', 'Error', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    // Display validation errors
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}', 'Validation Error', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
        @endforeach
    @endif
</script>
@yield('scripts')

</body>
</html>
