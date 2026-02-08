@extends('layouts.index')

@section('body')

    <div class="p-2 h-100 bg-light">

        <div class="p-2">
            <h4 class="fw-bold">Inquiries</h4>
        </div>

 @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif



        <form id="searchForm" class="form mb-2">
            <div class="d-flex align-items-center gap-1 mx-0 flex-wrap flex-md-nowrap">
                <input id="searchInput" value="{{$app->request->search}}" placeholder="Search"
                       type="search"
                       name="search"
                       class="form-control">
            </div>

            <div class="col-sm-12 d-flex align-items-center mt-2 gap-2 flex-wrap flex-md-nowrap ">
                <div class="d-flex align-items-center gap-2">
                    <label class="text-nowrap">Order By</label>
                    <select class="form-select" id="orderBy" name="order">
                        <option @selected($app->request->order == 'created_at') value="created_at">Date</option>
                        <option @selected($app->request->order == 'name') value="name">Name</option>
                        <option @selected($app->request->order == 'email') value="email">Email</option>
                        <option @selected($app->request->order == 'subject') value="subject">Subject</option>
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


        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
              <tbody>
                    @foreach($inquiries as $inquiry)
                        <tr class="{{ $inquiry->is_read ? '' : 'fw-bold table-warning' }}">
                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->subject }}</td>
                            <td>{{ $inquiry->message }}</td>
                            <td>{{ $inquiry->created_at->format('Y-m-d H:i a') }}</td>
                            <td class="d-flex flex-wrap">
                                <!-- Reply Button -->
                                <button class="btn btn-sm btn-primary m-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#replyModal" 
                                        data-id="{{ $inquiry->id }}" 
                                        data-email="{{ $inquiry->email }}"
                                        data-name="{{ $inquiry->name }}"
                                        data-subject="{{ $inquiry->subject }}">
                                    <i class="fas fa-reply"></i> Reply
                                </button>

                                <!-- Mark as Read -->
                                @if(!$inquiry->is_read)
                                    <form action="{{ route('inquiries.read', $inquiry->id) }}" method="POST" class="m-2">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Mark as Read
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete Button -->
                                {{-- <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST" class="m-2" 
                                    onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <div class="container">
                {{$inquiries->links()}}
            </div>
        </div>

    </div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form method="POST" action="{{ route('inquiries.reply') }}">
            @csrf
            <input type="hidden" name="inquiry_id" id="replyInquiryId">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-envelope-paper"></i> Reply to Inquiry
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-bold">Email</label>
                            <input type="email" name="email" id="replyEmail" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold">Subject</label>
                            <input type="text" name="subject" id="replySubject" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="fw-bold">Message</label>
                            <textarea name="message" rows="10" class="form-control" style="min-height: 300px;" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send"></i> Send Reply
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        window.addEventListener('load', () => {
            reloadOnEmpty('#searchForm', '#searchInput');
            submitFormOnChange('#searchForm', '#orderBy', '#sortBy', );
        })
    </script>

<script>
    const replyModal = document.getElementById('replyModal');
    replyModal.addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        let email = button.getAttribute('data-email');
        let name = button.getAttribute('data-name');
        let subject = button.getAttribute('data-subject');

        document.getElementById('replyInquiryId').value = id;
        document.getElementById('replyEmail').value = email;
        document.getElementById('replySubject').value = "Re: " + subject;
    });
</script>

@endsection
