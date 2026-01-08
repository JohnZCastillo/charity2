@extends('layouts.index')
@section('title','Appointment')
@section('body')

<div class="p-2 h-100 bg-light">

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
        </div>
    @endif

    {{-- Search + Filters --}}
    <form id="searchForm" class="form mb-2">
        <div class="d-flex align-items-center gap-1 mx-0 flex-wrap flex-md-nowrap">
            <input id="searchInput" value="{{$app->request->search}}" placeholder="Search"
                   type="search" name="search" class="form-control">

            <a href="/inventory/appointment-slot" class="ms-auto d-block btn btn-secondary text-nowrap">Appointment Slot</a>
        </div>

         <input type="hidden" name="hiddenFilter" id="hiddenFilter" class="d-none">

        <div class="col-sm-12 d-flex align-items-center mt-2 gap-2 flex-wrap flex-md-nowrap ">
            <div class="d-flex align-items-center gap-2">
                <label class="text-nowrap">Order By</label>
                <select class="form-select" id="orderBy" name="order">
                    <option @selected($app->request->order == 'created_at') value="created_at">Date</option>
                    <option @selected($app->request->order == 'name') value="name">Name</option>
                    <option @selected($app->request->order == 'email') value="email">Email</option>
                </select>
            </div>

            <div class="d-flex align-items-center gap-2">
                <label class="text-nowrap">Sort by</label>
                <select class="form-select" id="sortBy" name="sort">
                    <option @selected($app->request->sort == 'desc') value="desc">Descending</option>
                    <option @selected($app->request->sort == 'asc') value="asc">Ascending</option>
                </select>
            </div>

            <div class="d-flex align-items-center gap-2">
                <label class="text-nowrap">Status</label>
                <select class="form-select absolute" id="status" name="status">
                    <option value="">All</option>
                    <option value="undone" @selected($app->request->status == 'undone')>Unaccomplish</option>
                    <option value="done" @selected($app->request->status == 'done')>Accomplish</option>
                    <option value="pending" @selected($app->request->status == 'pending')>Pending</option>
                    <option value="reschedule" @selected($app->request->status == 'reschedule')>Reschedule</option>
                    <!-- <option value="meeting" @selected($app->request->hiddenFilter == 'meeting')>Meeting</option>
                    <option value="asking for help" @selected($app->request->hiddenFilter == 'asking for help')>Asking for Help</option>
                    <option value="donation" @selected($app->request->hiddenFilter == 'donation')>Donation</option>
                    <option value="visit" @selected($app->request->hiddenFilter == 'visit')>Visitation for Children</option>
                    <option value="others" @selected($app->request->hiddenFilter == 'others')>Others</option> -->
                </select>
            </div>

            <div class="d-flex align-items-center gap-2">
                <label class="text-nowrap">Type</label>
                <select class="form-select absolute" id="type" name="type">
                    <option value="">All</option>
                    <option value="meeting" @selected($app->request->type == 'meeting')>Meeting</option>
                    <option value="asking for help" @selected($app->request->type == 'asking for help')>Asking for Help</option>
                    <option value="donation" @selected($app->request->type == 'donation')>Donation</option>
                    <option value="visit" @selected($app->request->type == 'visit')>Visitation for Children</option>
                    <option value="others" @selected($app->request->type == 'others')>Others</option>
                </select>
            </div>

        </div>
    </form>

    <h5 class="mt-3">Appointments</h5>
    <div class="table-responsive mb-4 min-vh-100">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Message</th>
                <th>Note</th>
                <th>Type</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($appointments as $appointment)
                <tr>
                    <td>{{$appointment->name}}</td>
                   <td>
                      <a href="#"
                        class="sendReply"
                        data-bs-toggle="modal"
                        data-bs-target="#replyModal"
                        data-id="{{ $appointment->id }}"
                        data-email="{{ $appointment->email }}" title="Click to send a Reschedule Email">
                        {{ $appointment->email }}
                       </a>
                    </td>
                    <td>{{$appointment->contact}}</td>
                    <td>{{$appointment->message}}</td>
                    <td>{{$appointment->note}}</td>
                    <td>{{$appointment->type->value}}</td>
                    <td>{{$appointment->date}}</td>
                    <td>{{$appointment->start}}</td>
                    <td>{{$appointment->end}}</td>
                    
                    <td>
                        @if($appointment->status == 'pending')
                            <span class="badge bg-warning" style="width: 105px">Pending</span>
                        @elseif($appointment->status == 'rescheduled')
                            <span class="badge bg-dark" style="width: 105px">Rescheduled</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge bg-info" style="width: 105px">Confirmed</span>
                        @elseif($appointment->status == 'cancelled')
                            <span class="badge bg-secondary" style="width: 105px">Cancelled</span>
                        @elseif($appointment->status == 'done')
                            <span class="badge bg-success" style="width: 105px">Accomplished</span>
                        @elseif($appointment->status == 'undone')
                            <span class="badge bg-danger" style="width: 105px">Unaccomplished</span>
                        @endif
                    </td>
                    <td>
                        @if($appointment->status == 'pending' || $appointment->status == 'confirmed' )
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <ul class="dropdown-menu">
                                    @if($appointment->status == 'pending')
                                        <li>
                                            <form class="w-100"   method="POST" action="{{ route('appointments.confirm', $appointment->id) }}">
                                                @csrf
                                                <button class='dropdown-item text-start'>
                                                    Confirm
                                                </button>
                                            </form>
                                        </li>
                                        
                                        <li>
                                            <a href="#"
                                                class="w-100 dropdown-item text-start sendReply"
                                                data-bs-toggle="modal"
                                                data-bs-target="#replyModal"
                                                data-id="{{ $appointment->id }}"
                                                data-email="{{ $appointment->email }}">
                                                    Reschedule      
                                            </a>
                                        </li>
                                        <li>
                                        <a href="#"
                                                class="w-100 dropdown-item text-start sendCancelReply"
                                                data-bs-toggle="modal"
                                                data-bs-target="#cancelModal"
                                                data-id="{{ $appointment->id }}"
                                                data-email="{{ $appointment->email }}">
                                                    Cancel
                                            </a>
                                        </li>
                                    @elseif($appointment->status == 'confirmed')
                                        <li>
                                            <form class="w-100" method="POST" action="{{ route('appointments.done', $appointment->id) }}">
                                                @csrf
                                                <button class="dropdown-item text-start">Accomplished</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form class='w-100' method="POST" action="{{ route('appointments.undone', $appointment->id) }}">
                                                @csrf
                                                <button class="dropdown-item text-start">Unaccomplished</button>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <button disabled class="dropdown-item text-start">No Action Needed</button>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                        {{-- @if($appointment->status == 'pending')
                            <!-- Confirm -->
                            <form method="POST" action="{{ route('appointments.confirm', $appointment->id) }}">
                                @csrf
                                <button 
                                    class="btn btn-sm btn-primary"
                                    style="width: 120px;"
                                >
                                    Confirm
                                </button>
                            </form>

                            <a href="#"
                                class="btn btn-sm btn-secondary sendReply"
                                style="width: 120px;"
                                data-bs-toggle="modal"
                                data-bs-target="#replyModal"
                                data-id="{{ $appointment->id }}"
                                data-email="{{ $appointment->email }}">
                                 Reschedule      
                            </a>

                            
                            <a href="#"
                                class="btn btn-sm btn-danger sendCancelReply"
                                style="width: 120px;"
                                data-bs-toggle="modal"
                                data-bs-target="#cancelModal"
                                data-id="{{ $appointment->id }}"
                                data-email="{{ $appointment->email }}">
                                 Cancel
                            </a>
                        @endif

                        @if($appointment->status == 'confirmed')
                            <!-- Done -->
                            <form method="POST" action="{{ route('appointments.done', $appointment->id) }}">
                                @csrf
                                <button style="width: 120px;" class="btn btn-sm btn-success">Accomplished</button>
                            </form>

                            <!-- Unaccomplished -->
                            <form method="POST" action="{{ route('appointments.undone', $appointment->id) }}">
                                @csrf
                               
                                <button  style="width: 120px;" class="btn btn-sm btn-danger">Unaccomplished</button>
                            </form>
                        @endif --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center text-secondary">No Appointments</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
  
    <div class="container mt-3">
        {{$appointments->links()}}
    </div>

</div>


<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="replyForm" method="POST" action="{{ route('appointments.reschedule') }}">
      
        @csrf
        <input type="hidden" name="appointment_id" id="modal_appointment_id">
        

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="replyModalLabel">Send Reschedule Notice</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span>&times;</span>
            </button>
          </div>


          <div class="modal-body">
             <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="email" id="modal_email" class="form-control">
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="Reschedule Notice">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="5">Dear Sir/Madam, 
                We would like to inform you that your appointment is being rescheduled. Kindly contact us for further details.

                Thank you, 
                Missionaries of Charity Brothers</textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send Email</button>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="replyForm" method="POST" action="{{ route('appointments.cancel') }}">

        @csrf
       <input type="hidden" name="appointment_id" id="cancel_appointment_id">
        

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="replyModalLabel">Send Cancel Notice</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span>&times;</span>
            </button>
          </div>

          <div class="modal-body">
             <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="email" id="cancel_modal_email" class="form-control">
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="Cancel Notice">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="5">Dear Sir/Madam, 
                We would like to inform you that your appointment is cancelled. Kindly contact us for further details.

                Thank you, 
                Missionaries of Charity Brothers</textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send Email</button>
          </div>
        </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy','#status', '#type');
        })
    </script>
    <script>
        
    $(document).ready(function () {
        $(document).on("click", ".sendReply", function () {
    
            var appointmentId = $(this).data('id');
            var email = $(this).data('email');

            $("#modal_appointment_id").val(appointmentId);
            $("#modal_email").val(email);
        });

         $(document).on("click", ".sendCancelReply", function () {
    
            var appointmentId = $(this).data('id');
            var email = $(this).data('email');

            console.log('fucking email: ', email);

            $("#cancel_appointment_id").val(appointmentId);
            $("#cancel_modal_email").val(email);
        });

        // document.querySelector('#filter').addEventListener('change', (e)=>{
        //     document.querySelector('#hiddenFilter').value = e.target.value;
        //     const form = document.querySelector('#searchForm')
        //     form.submit();
        // })

        //  document.querySelector('#filter2').addEventListener('change', (e)=>{
        //     document.querySelector('#filter2').value = e.target.value;
        //     const form = document.querySelector('#searchForm')
        //     form.submit();
        // })
    });

</script>
@endsection
