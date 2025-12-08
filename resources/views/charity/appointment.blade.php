@extends('layouts.charity')

@section('files')
    {{--    <link rel="stylesheet" href="/css/appointment.css">--}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src='/js/moment.js'></script>
    <script src='/js/sweet-alert.js'></script>


    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

    {{--    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
@endsection

@section('styles')
    <style>
        .pointer:hover {
            cursor: pointer !important;
            background-color: #5fcf80;
        }

        .fc-header-toolbar {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .fc-toolbar-chunk:nth-child(3) {
            display: flex;
            gap: 5px;
        }


    </style>
@endsection

@section('title','Appointment')

@section('body')

    <div class="container-fluid pt-2">
        <div class="pt-2">
            <h1>Appointment Request Form</h1>
            <p>Make your appointments more easier</p>
        </div>

        @if(\Illuminate\Support\Facades\Session::get('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Appointment success!</h4>
                <div>
                    {{\Illuminate\Support\Facades\Session::get('message')}}
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="py-2">
            <div class="row mx-0">
                <div id="calendar" class='col-12 col-md-8 mb-2'>
                    <!-- Auto Generated Calendar  -->
                </div>
                <div class="p-3 col-12 col-md-4 mb-2 bg-light rounded">

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{$errors->first()}}
                        </div>
                    @endif


                    <form id="appointmentForm" method="POST" action="/inventory/appointments">
                        @csrf

                        <div class="mb-2">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" readonly>
                        </div>

                        <div class="mb-2 row mx-0">

                            <div class="col-6 ps-0 position-relative">
                                <label for="start">Start</label>
                                <select class="form-select" id="start" name="start" required>
                                    <option selected disabled>Select time</option>
                                </select>
                            </div>

                            <div class="col-6 pe-0">
                                <label for="end">End</label>
                                <select class="form-select" id="end" name="end" required>
                                    <option selected disabled>Select time</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label for="contact">Contact Number</label>
                            <input minlength="11" maxlength="11" type="tel" id="contact" name="contact"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-2">
                            <label for="appointment_for">Appointment for:</label>
                            <select class="text-capitalize form-select" id="appointment_for" name="type" required>
                                @foreach(\App\Enums\AppointmentType::cases() as $type)
                                    <option class="text-capitalize" value="{{$type->value}}">{{$type->value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="appointment_description">Appointment Description:</label>
                            <textarea class="form-control" id="appointment_description" name="message"
                                      placeholder="I wish to get an appointment to give donations" required></textarea>
                        </div>
                        <div class="grid mb-2">
                            <button type="submit" class="py-4 col-12 btn btn-success text-white ">Request For
                                Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>

        const appointmentForm = document.querySelector('#appointmentForm');
        const date = document.querySelector('#date');
        const start = document.querySelector('#start');
        const end = document.querySelector('#end');

        document.addEventListener('DOMContentLoaded', function () {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                eventClick: function (info) {
                    date.value = info.event.extendedProps.test;
                    getAvailableTime(date.value);
                },
                events: @json($slots),
                eventDisplay: 'block',
                displayEventTime: false,
                eventContent: function (arg) {
                    let eventInfo = document.createElement('div');
                    eventInfo.classList.add('text-center', 'text-uppercase')
                    eventInfo.innerHTML = `<strong>Available</strong>`;
                    return {domNodes: [eventInfo]};
                },
                eventOrder: 'type',
            });
            calendar.render();
        });

        appointmentForm.addEventListener('submit', (e) => {

            e.preventDefault();

            if (!date.value) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select appointment date',
                    icon: 'error',
                    confirmButtonText: 'Close'
                })
                return;
            }

            appointmentForm.submit();
        })

        async function getAvailableTime(date) {

            const response = await fetch(`/api/slot/${date}`);
            const slots = await response.json();

            start.innerHTML = null;
            end.innerHTML = null;

            const basicOption = {
                value: null,
                text: 'Select Text',
                selected: true,
                disabled: true,
            };

            createOptionTag(basicOption,start);
            createOptionTag(basicOption,end);

            slots.forEach(slot => {
                createOptionTag({value: slot, text: slot},start);
                createOptionTag({value: slot, text: slot},end);
            })

            function createOptionTag({value,text,selected = false, disabled = false}, parentElement){

                const optionTag = document.createElement('option');

                optionTag.value = value;
                optionTag.text = text;
                optionTag.disabled = disabled;
                optionTag.selected = selected;

                parentElement.appendChild(optionTag);
            }

        }



        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '08:00 am',
            maxTime: '06:00 pm',
            defaultTime: '08:00 am',
            startTime: '08:00 am',
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            disableTimeRanges: [
                ['08:00 am', '09:00 am']
            ]
        });
    </script>
@endsection
