@extends('layouts.index')
@section('title', 'Activity Log')
@section('body')
<div class="container mt-4">
    <h4 class="mb-3"><i class="bx bx-history"></i> Activity Logs</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search logs...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="logsTable">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $index => $log)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>{{ $log->activity }}</td>
                        <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No activity logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Results info (hidden until searching) -->
    <div id="resultsInfo" class="mb-2" style="display:none;"></div>

    <!-- Keep Laravel pagination (this shows "Showing 1 to X of Y results") -->
    {{ $logs->links() }}
</div>

<!-- Client-side Search Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const table = document.getElementById("logsTable");
    const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    const resultsInfo = document.getElementById("resultsInfo");

    const total = {{ $logs->total() }}; // total across all pages
    const start = {{ $logs->firstItem() }};
    const end = {{ $logs->lastItem() }};

    function updateResultsInfo(visibleCount) {
        resultsInfo.style.display = "block";
        if (visibleCount === 0) {
            resultsInfo.textContent = `No matching results found (filtered from ${total} total)`;
        } else {
            resultsInfo.textContent = `Showing ${visibleCount} results (filtered from ${total} total)`;
        }
    }

    searchInput.addEventListener("keyup", function () {
        const filter = searchInput.value.toLowerCase();
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let text = row.textContent.toLowerCase();

            if (text.indexOf(filter) > -1) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        }

        if (filter.trim() === "") {
            resultsInfo.style.display = "none"; // hide again if search is cleared
        } else {
            updateResultsInfo(visibleCount);
        }
    });
});
</script>
@endsection
