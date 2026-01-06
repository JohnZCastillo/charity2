@extends('layouts.index')

@section('title', 'Responses for ' . ($form->title ?? 'Untitled'))

@section('body')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

<style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 12px; }
    .chart-container { height: 300px; position: relative; }
    .scrollable-table { max-height: 400px; overflow-y: auto; }
    .table td, .table th { vertical-align: top; }
    #backToTop {
        position: fixed; bottom: 20px; right: 30px; z-index: 99;
        background: #0d6efd; color: white; padding: 15px; border-radius: 10px;
        cursor: pointer; border: none;
    }
    #backToTop:hover { background: #084298; }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">{{ $form->title ?? 'Untitled Form' }} - Responses</h2>
            <p class="text-muted">Total responses: {{ $form->responses->count() }}</p>
        </div>
        <a href="{{ route('form-builder.index') }}" class="btn btn-outline-secondary">&larr; Back to Forms</a>
    </div>

    <form method="GET" class="row g-3 align-items-end mb-4">

        <input type="hidden" class="d-none" name="event_id" value="{{ request('event_id') }}">

        <div class="col-md-3">
            <label class="form-label">From</label>
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">To</label>
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">Group By</label>
            <select name="group" class="form-select">
                <option value="">None</option>
                <option value="week" {{ request('group') == 'week' ? 'selected' : '' }}>Week</option>
                <option value="month" {{ request('group') == 'month' ? 'selected' : '' }}>Month</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary w-100" type="submit"><i class="fa fa-filter me-1"></i> Filter</button>
            <button type="button" class="btn btn-success w-100" onclick="exportToExcel()">
                <i class="fa fa-file-excel me-1"></i> Excel
            </button>
        </div>
    </form>

    <div class="mb-3">
        <label class="form-label fw-semibold">Filter by Question:</label>
        <select class="form-select" id="questionFilter" onchange="filterCharts()">
            <option value="all">All Questions</option>
            @foreach(array_keys($form->responses->flatMap->response->toArray()) as $key)
                <option value="{{ 'chart_' . md5($key) }}">{{ $key }}</option>
            @endforeach
        </select>
    </div>

    @php
        $filtered = $form->responses->filter(function($r) {
            $from = request('from');
            $to = request('to');
            if ($from && $r->created_at->lt($from)) return false;
            if ($to && $r->created_at->gt($to . ' 23:59:59')) return false;
            return true;
        });

        $grouped = request('group') === 'month'
            ? $filtered->groupBy(fn($r) => $r->created_at->format('Y-m'))
            : (request('group') === 'week'
                ? $filtered->groupBy(fn($r) => $r->created_at->startOfWeek()->format('Y-m-d'))
                : collect(['All' => $filtered]));

        $aggregated = [];
        foreach ($filtered as $response) {
            foreach ($response->response as $label => $answer) {
                foreach (explode(', ', is_array($answer) ? implode(', ', $answer) : $answer) as $a) {
                    $aggregated[$label][$a] = ($aggregated[$label][$a] ?? 0) + 1;
                }
            }
        }
    @endphp

    @foreach($grouped as $period => $responses)
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">{{ $period }}</h5>
                <span class="text-muted">Responses: {{ $responses->count() }}</span>
            </div>
            <div class="card-body scrollable-table p-0">
                <table class="table table-hover table-sm mb-0" id="responsesTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Submitted</th>
                            @foreach($form->labels() as $label)
                                 <th>{{$label}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($responses as $i => $res)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $res->created_at->format('Y-m-d h:i A') }}</td>
                                @foreach($res->response as $k => $v)
                                    <td>
                                            @if(is_string($v) && str_starts_with($v, 'forms/'))
                                            @php
                                                $ext = strtolower(pathinfo($v, PATHINFO_EXTENSION));
                                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                                $fileUrl = asset($v);
                                            @endphp
                                            @if($isImage)
                                                <br><img src="{{ $fileUrl }}" class="img-thumbnail mt-2" style="max-width: 150px;">
                                                <div><a href="{{ $fileUrl }}" target="_blank">View Full Image</a></div>
                                            @else
                                                <br><a href="{{ $fileUrl }}" class="btn btn-sm btn-outline-primary mt-1" target="_blank">
                                                    <i class="fa fa-download"></i> Download File
                                                </a>
                                            @endif
                                        @elseif(is_array($v))
                                            {{ implode(', ', $v) }}
                                        @else
                                            {{ $v }}
                                        @endif
                                    </td>
                                @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">No responses for this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <button class="btn btn-dark mb-4" onclick="downloadAllChartsAsPDF()">Download All Charts as PDF</button>
</div>

<button onclick="topFunction()" id="backToTop" title="Go to top">
    <i class="fas fa-arrow-up"></i>
</button>
<script>
function topFunction() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
function filterCharts() {
    const selected = document.getElementById('questionFilter').value;
    document.querySelectorAll('.chart-wrapper').forEach(div => {
        const chartId = div.id.replace('_wrapper', '');
        div.style.display = (selected === 'all' || selected === chartId) ? 'block' : 'none';
    });
}
function downloadChart(chartId, format) {
    const canvas = document.querySelector(`#${chartId}_canvas`);
    html2canvas(canvas).then(cnv => {
        const img = cnv.toDataURL('image/png');
        if (format === 'png') {
            const link = document.createElement('a');
            link.href = img;
            link.download = chartId + '.png';
            link.click();
        } else {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();
            pdf.addImage(img, 'PNG', 10, 10, 190, 0);
            pdf.save(chartId + '.pdf');
        }
    });
}
function downloadAllChartsAsPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF();
    let yOffset = 10;
    const canvases = document.querySelectorAll('.chart-wrapper canvas');
    let i = 0;
    function next() {
        if (i >= canvases.length) return pdf.save('all_charts.pdf');
        html2canvas(canvases[i]).then(cnv => {
            const img = cnv.toDataURL('image/png');
            const imgProps = pdf.getImageProperties(img);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            if (yOffset + pdfHeight > pdf.internal.pageSize.getHeight()) {
                pdf.addPage();
                yOffset = 10;
            }
            pdf.addImage(img, 'PNG', 10, yOffset, pdfWidth - 20, pdfHeight);
            yOffset += pdfHeight + 10;
            i++;
            next();
        });
    }
    next();
}
function exportToExcel() {
    const table = document.querySelector("table[id^='responsesTable']");
    const wb = XLSX.utils.table_to_book(table, { sheet: "Responses" });
    XLSX.writeFile(wb, "form_responses.xlsx");
}
</script>
@endsection
