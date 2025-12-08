@extends('layouts.index')
@section('title', $donation->title . ' | Donation Drive Report')

@section('body')
<div class="container mt-4">

    <!-- Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <h2>{{ $donation->title }} - Report</h2>

    <div class="row mt-4">
        <!-- Summary Cards -->
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Total Donations</h5>
                    <h3>₱{{ number_format($totalAmount, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Number of Donors</h5>
                    <h3>{{ $donorCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body">
                    <h5>Goal</h5>
                    <h3>₱{{ number_format($donation->goal, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Graph -->
    <div class="card mt-4 shadow" id="chartCard">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5>Monthly Donations</h5>
                <div>
                    <button class="btn btn-success btn-sm me-2 export-ignore" onclick="saveChartPng()">
                        <i class="fas fa-file-image"></i> PNG
                    </button>
                    <button class="btn btn-danger btn-sm export-ignore" onclick="savePdf('chartCard', 'donation_chart.pdf')">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>
            </div>
            <canvas id="donationChart"></canvas>
        </div>
    </div>

    <!-- Table -->
    <div class="card mt-4 shadow" id="tableCard">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5>Confirmed Donations</h5>
                <div>
                    <button class="btn btn-success btn-sm me-2 export-ignore" onclick="saveTablePng()">
                        <i class="fas fa-file-image"></i> PNG
                    </button>
                    <button class="btn btn-danger btn-sm export-ignore" onclick="savePdf('tableCard', 'donation_table.pdf')">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>
            </div>
            <table class="table table-striped" id="donationTable">
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donation->donations as $d)
                        <tr>
                            <td>{{ $d->from ?? 'Anonymous' }}</td>
                            <td>₱{{ number_format($d->amount, 2) }}</td>
                            <td>{{ $d->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js + html2pdf.js + html2canvas -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    // Chart.js
    const ctx = document.getElementById('donationChart').getContext('2d');
    const donationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Monthly Donations',
                data: @json($values),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Save chart as PNG (ignores export buttons)
    function saveChartPng() {
        html2canvas(document.getElementById('chartCard'), {
            ignoreElements: (el) => el.classList.contains('export-ignore')
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'donation_chart.png';
            link.href = canvas.toDataURL();
            link.click();
        });
    }

    // Save table as PNG (ignores export buttons)
    function saveTablePng() {
        html2canvas(document.getElementById('tableCard'), {
            ignoreElements: (el) => el.classList.contains('export-ignore')
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'donation_table.png';
            link.href = canvas.toDataURL();
            link.click();
        });
    }

    // Save card (chart or table) as PDF (ignores export buttons)
    function savePdf(elementId, filename) {
        const element = document.getElementById(elementId);
        html2pdf().from(element).set({
            margin: 10,
            filename: filename,
            html2canvas: { 
                scale: 2,
                ignoreElements: (el) => el.classList.contains('export-ignore')
            },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        }).save();
    }
</script>
@endsection
