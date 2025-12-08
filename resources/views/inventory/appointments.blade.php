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
        </div>

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
        </div>
    </form>

    {{-- ================= PENDING + CONFIRMED ================= --}}
    <h5 class="mt-3">⏳ Pending & Confirmed Appointments</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Message</th>
                <th>Type</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($appointments->whereIn('status',['pending','rescheduled','confirmed']) as $appointment)
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
                    <td>{{$appointment->type->value}}</td>
                    <td>{{$appointment->date}}</td>
                    <td>{{$appointment->start}}</td>
                    <td>{{$appointment->end}}</td>
                    <td>
                        @if($appointment->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($appointment->status == 'rescheduled')
                            <span class="badge bg-dark">Rescheduled</span>
                        @elseif($appointment->status == 'confirmed')
                            <span class="badge bg-info">Confirmed</span>
                        @endif
                    </td>
                    <td class="d-flex gap-1">
                        @if($appointment->status == 'pending')
                            <!-- Confirm -->
                            <form method="POST" action="{{ route('appointments.confirm', $appointment->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-primary">Confirm</button>
                            </form>
                        @endif

                        @if($appointment->status == 'confirmed')
                            <!-- Done -->
                            <form method="POST" action="{{ route('appointments.done', $appointment->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-success">Done</button>
                            </form>

                            <!-- Unaccomplished -->
                            <form method="POST" action="{{ route('appointments.undone', $appointment->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-danger">Unaccomplished</button>
                            </form>
                        @endif
                    </td>
                
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-secondary">No Pending/Confirmed Appointments</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= ACCOMPLISHED + UNACCOMPLISHED ================= --}}
    <h5 class="mt-3">✅ Completed Appointments</h5>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Message</th>
                <th>Type</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($appointments->whereIn('status',['done','undone']) as $appointment)
                <tr>
                    <td>{{$appointment->name}}</td>
                    <td>{{$appointment->email}}</td>
                    <td>{{$appointment->contact}}</td>
                    <td>{{$appointment->message}}</td>
                    <td>{{$appointment->type->value}}</td>
                    <td>{{$appointment->date}}</td>
                    <td>{{$appointment->start}}</td>
                    <td>{{$appointment->end}}</td>
                    <td>
                        @if($appointment->status == 'done')
                            <span class="badge bg-success">Accomplished</span>
                        @elseif($appointment->status == 'undone')
                            <span class="badge bg-danger">Unaccomplished</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-secondary">No Completed Appointments</td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy',);
        })
    </script>
    <script>
$(document).ready(function () {
    $(document).on("click", ".sendReply", function () {
        var appointmentId = $(this).data('id');
        var email = $(this).data('email');

        console.log("Clicked ID:", appointmentId, "Email:", email);

        $("#modal_appointment_id").val(appointmentId);
        $("#modal_email").val(email);
    });
});
</script>
@endsection
