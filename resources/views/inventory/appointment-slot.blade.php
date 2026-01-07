@extends('layouts.index')

@section('files')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src='/js/moment.js'></script>
    <script src='/js/sweet-alert.js'></script>
@endsection

@section('styles')
    <style>
        /* Calendar Container */
        #calendar-container {
            max-width: 1500px; /* make it smaller */
            margin: 10px auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        /* Calendar Events */
        .fc .fc-daygrid-day-frame {
            padding: 6px;
        }

        .fc .fc-toolbar-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .fc .fc-button {
            border-radius: 6px;
            padding: 5px 12px;
        }

        .fc-event {
            font-size: 0.9rem;
            border: none !important;
        }

        /* Hover effect for events */
        .fc-event:hover {
            opacity: 0.9;
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }

        /* Buttons */
        .btn-custom {
            border-radius: 8px;
            padding: 8px 18px;
        }
    </style>
@endsection

@section('body')

    <div class="p-3 h-100 bg-light">

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
        @endif

        <!-- Action Button -->
        <div class="d-flex justify-content-between mb-3">

            <button class="btn btn-secondary" onclick="back()">Back</button>


            <button type="button" class="btn btn-primary btn-custom shadow-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-calendar-x"></i> Block Date
            </button>
        </div>

        <!-- Calendar -->
        <div id="calendar-container">
            <div id='calendar'></div>
        </div>

        <!-- Block Date Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <form method="POST" action="/inventory/block-appointment-slot">
                    @csrf
                    <div class="modal-content rounded-3 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Block Date</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="date" class="fw-semibold">Date</label>
                                <input id="date" type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Block</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Slot Modal -->
        <div class="modal fade" id="editSlotModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <form method="POST" action="/inventory/appointment-slot">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content rounded-3 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Unblock Date</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input id="editID" type="hidden" name="date">
                            <p class="mb-0 text-muted">
                                Are you sure you want to <strong>make this day available</strong> again?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const editSlotModal = new bootstrap.Modal(document.getElementById('editSlotModal'));
        const editSlotID = document.querySelector('#editID');

        function showEditSlotModal(date) {
            editSlotID.value = date;
            editSlotModal.show();
        }

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 750, // smaller calendar height
                eventClick: function (info) {
                    if (info.event.extendedProps.capacity === -1) {
                        showEditSlotModal(info.event.extendedProps.test);
                    }
                },
                events: @json($slots),
                eventDisplay: 'block',
                displayEventTime: false,
                eventContent: function (arg) {
                    let eventInfo = document.createElement('div');
                    eventInfo.classList.add('text-center', 'fw-semibold', 'rounded', 'px-1', 'py-1', 'text-white');
                    if (arg.event.extendedProps.capacity === -1) {
                        eventInfo.classList.add('bg-danger');
                        eventInfo.innerHTML = `<small>Unavailable</small>`;
                    } else {
                        eventInfo.classList.add('bg-success');
                        eventInfo.innerHTML = `<small>Available</small>`;
                    }
                    return {domNodes: [eventInfo]};
                },
                eventOrder: 'type',
            });

            calendar.render();
        });
    </script>
@endsection
