@extends('layouts.index')
@section('title','Dashboard')
@section('files')
    <script src="/js/apexcharts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        @media print {
            body {
                visibility: hidden;
            }

            #printBody {
                visibility: visible;
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endsection


@section('body')
    <div class="h-100 bg-light container-fluid">

        <div class="py-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportTypeModal">
                Reports
            </button>
        </div>

        <div class="row mx-0 align-items-center gap-2 mb-2">
    <!-- Donors -->
    <div class="col-12 col-md-2 flex-fill shadow p-3 rounded text-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="fw-bold mb-0">{{$donors ?? 0}}</h1>
            <i class="text-secondary bx bx-lg bx-user-check"></i>
        </div>
        <small class="text-secondary">Total Donors</small>
    </div>

    <!-- Recipients -->
    <div class="col-12 col-md-2 flex-fill shadow p-3 rounded text-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="fw-bold mb-0">{{$recipients ?? 0}}</h1>
            <i class="text-secondary bx bx-lg bx-user-minus"></i>
        </div>
        <small class="text-secondary">Total Recipients</small>
    </div>

    <!-- Items -->
    <div class="col-12 col-md-2 flex-fill shadow p-3 rounded text-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="fw-bold mb-0">{{$items ?? 0}}</h1>
            <i class="text-secondary bx bx-lg bx-package"></i>
        </div>
        <small class="text-secondary">Total Items</small>
    </div>

    <!-- Appointments -->
    <div class="col-12 col-md-2 flex-fill shadow p-3 rounded text-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="fw-bold mb-0">{{$totalAppointment ?? 0}}</h1>
            <i class="text-secondary bx bx-lg bx-calendar"></i>
        </div>
        <small class="text-secondary">New Appointments</small>
    </div>

    <!-- New Inquiry -->
    <div class="col-12 col-md-2 flex-fill shadow p-3 rounded text-center">
        <div class="d-flex flex-column align-items-center">
            <h1 class="fw-bold mb-0">{{ $inquiries ?? 0}}</h1>
            <i class="text-secondary bx bx-lg bx-envelope"></i>
        </div>
        <small class="text-secondary">Unread Inquiries</small>
    </div>
</div>

<!-- calendar -->
 <div class="row my-4">
    <div class="col-12">
        <div class="shadow p-3 rounded bg-white">
            <h4 class="fw-bold text-secondary mb-3">
                <i class="bx bx-calendar-event"></i> Confirmed Appointments (This Month)
            </h4>
            <div id="calendar"></div>
        </div>
    </div>
</div>


        <div id="wrapper">
            <div class="content-area">
                <div class="container-fluid">
                    <div class="main">
                        <div class="box box1">
                            <div id="spark1"></div>
                        </div>
                        <div class="row mt-5 mb-4">
                            <div class="col-md-4">
                                <div class="box">
                                    <div id="bar"> 
                                        @if (count($donatedItemHistory) <= 0)
                                            <div class='d-flex justify-content-center align-items-center'>
                                                <span class="text-secondary fs-1" >No Donation History Yet</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div id="bar2"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Low Stock Items (below 20 pcs)</h5>

                                        <!-- Burger Menu -->
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm" type="button" id="lowStockMenu"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="lowStockMenu">
                                                <li><a class="dropdown-item" href="#" onclick="saveAsPNG()">Save as PNG</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="saveAsPDF()">Save as PDF</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    @if($lowStockItem->isEmpty())
                                        <p class="text-muted">No low stock items 🎉</p>
                                    @else
                                        <div class="table-responsive" id="lowStockTableWrapper">
                                            <table class="table table-sm table-bordered table-striped">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th class="text-end">Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($lowStockItem as $item)
                                                        <tr>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->code }}</td>
                                                            <td class="text-end">
                                                                <span class="badge bg-danger">
                                                                    {{ $item->active_stock ?? 0 }} pcs
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <h4 class="text-secondary fw-bold">Stock Items</h4>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Item Stock</th>
                </tr>
                </thead>
                <tbody>
                @foreach($StockItems as $item)
                    <tr>
                        <td>{{$item->code}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->stock}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


          <div class="card shadow-sm mb-5"> <!-- Removed mb-5 -->
            <div class="card-body">
                <h2 class="fw-bold mb-4 text-success border-bottom pb-2 text-center">🙏 Donor Logs</h2>
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-center">
                        <thead class="table-success">
                            <tr>
                                <th>Date</th>
                                <th>Contributor</th>
                                <th>Food Item / Goods</th>
                                <th>Quantity</th>
                                <th>Donation Type</th>
                            </tr>
                        </thead>
                        <tbody id="donorLogsBody">
                            <tr>
                                <td colspan="5" class="text-muted">Loading donor logs...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center" id="donorLogsPagination"></div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="generateReportModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="generateReportForm" method="POST" action="/inventory/report">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Generate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="option" value="preview">

                        <div class="form-group mb-1">
                            <label for="from">From</label>
                            <input class="form-control" id="from" type="month" name="from" required>
                        </div>
                        <div class="form-group mb-1">
                            <label for="type">Type</label>
                            <select id="type" class="form-select" name="type" required>
                                <option disabled selected>Select Type</option>
                                <option value="cash">Cash</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generatedReportModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container-fluid">
                    <div id="printBody">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="downloadBtn" type="button" class="btn btn-primary" onclick="download()">Download
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printPdf()">Print</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportTypeModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="reportTypeForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel">Generate Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <select  class="form-select" id="reportType" required>
                           <option value="" selected disabled>Select</option>
                           @foreach (App\Enums\ReportType::cases() as $reportType )
                             <option value={{ $reportType->value }}>{{ $reportType->value }}</option>                               
                           @endforeach
                       </select>
                        <small class="text-danger d-none" id="reportTypeFormError">This field is required</small>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportLoading" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Generating Report...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center ">
                    <div class="spinner-border" role="status">
                             <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="recipientReportFormModal" aria-hidden="true" aria-labelledby="recipientReportFormModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="recipientReportForm" action="/recipient-report">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel2">Generate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            @csrf
                             <input id="reportTypeInput" type="hidden" class="d-none" name="reportType">

                            <div class="mb-2">
                                <label>From</label>
                                <input type="month" class="form-control" name="date" required>
                            </div>

                            <div class="mb-2">
                                <label>Type</label>
                                <select  class="form-select" name="type" required>
                                    @foreach($itemCategoryType as $itemType)
                                        <option value={{$itemType->id}}>{{$itemType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="expenseReportFormModal" aria-hidden="true" aria-labelledby="recipientReportFormModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="expenseReportForm" action="/recipient-report">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalToggleLabel2">Generate Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            @csrf
                             <input id="reportTypeInput2" type="hidden" class="d-none" name="reportType">

                            <div class="mb-2">
                                <label>From</label>
                                <input type="month" class="form-control" name="date" required>
                            </div>

                            <div class="mb-2">
                                <label>Type</label>
                                <select  class="form-select" name="type" required>
                                   <option value="organization">Expense for Organization</option>
                                   <option value="recipient">Donate for Beneficiaries</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 600,
        events: [
            @foreach($confirmedAppointments as $appt)
            {
                title: "{{ $appt->name }}",
                start: "{{ $appt->date }}T{{ $appt->start }}",
                end: "{{ $appt->date }}T{{ $appt->end }}",
                color: '#28a745',
                extendedProps: {
                    time: "{{ $appt->start }} - {{ $appt->end }}",
                    date: "{{ $appt->date }}",
                }
            },
            @endforeach
        ],
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventDidMount: function(info) {
            // Attach Bootstrap tooltip
            let tooltip = new bootstrap.Tooltip(info.el, {
                title: info.event.title + 
                       " (" + info.event.extendedProps.date + " " + info.event.extendedProps.time + ")",
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        }
    });

    calendar.render();
});
</script>

    <script>

        const reportForm = document.querySelector('#generateReportForm');
        const reportModal = new bootstrap.Modal(document.getElementById('generateReportModal'));
        const generatedReportModal = new bootstrap.Modal(document.getElementById('generatedReportModal'));
        const reportLoading = new bootstrap.Modal(document.getElementById('reportLoading'));
        const printBody = document.getElementById('printBody');
        const downloadBtn = document.getElementById('downloadBtn');

        const recipientReportForm =  document.querySelector('#recipientReportForm')
        const expenseReportForm =  document.querySelector('#expenseReportForm')

        const reportTypeForm =  document.querySelector('#reportTypeForm')


        const recipientReportFormModal =  new bootstrap.Modal('#recipientReportFormModal')
        const expenseReportFormModal =  new bootstrap.Modal('#expenseReportFormModal')

        const reportTypeModal =  new bootstrap.Modal('#reportTypeModal')

        const reportType = document.querySelector('#reportType');
        
        const reportTypeInput = document.querySelector('#reportTypeInput');
        const reportTypeInput2 = document.querySelector('#reportTypeInput2');


        reportTypeForm.addEventListener('submit',(e)=>{
            e.preventDefault();

            reportTypeInput.value  = reportType.value;
            reportTypeInput2.value  = reportType.value;
            
            reportTypeModal.hide();

            if( reportType.value?.toLowerCase() === 'cash'){
                expenseReportFormModal.show();
            }else{
                recipientReportFormModal.show();
            }
        })

        recipientReportForm.addEventListener('submit', async (e)=>{

            e.preventDefault();
            recipientReportFormModal.hide();
            reportLoading.show();

            try{

                const response = await  fetch('/inventory/recipient-report',{
                    method: "POST",
                    body: new FormData(recipientReportForm)
                })

                if(!response.ok){
                    throw new Error("Something went wrong, please try again!");
                }

                printBody.innerHTML = await  response.text();

            }catch (error){
                printBody.innerHTML = error.message;
            }finally {
                reportLoading.hide();
                generatedReportModal.show();
            }
        })

        expenseReportForm.addEventListener('submit', async (e)=>{

            e.preventDefault();
            expenseReportFormModal.hide();
            reportLoading.show();

            try{

                const response = await  fetch('/inventory/recipient-report',{
                    method: "POST",
                    body: new FormData(expenseReportForm)
                })

                if(!response.ok){
                    throw new Error("Something went wrong, please try again!");
                }

                printBody.innerHTML = await  response.text();

            }catch (error){
                printBody.innerHTML = error.message;
            }finally {
                reportLoading.hide();
                generatedReportModal.show();
            }
        })

        const option = {
            margin: 1,
            filename: 'report.pdf',
            image: {type: 'jpeg', quality: 0.98},
            html2canvas: {scale: 2},
            jsPDF: {unit: 'in', format: 'A4', orientation: 'landscape'}
        };

        reportForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            reportModal.hide();

            const formData = new FormData(reportForm);

            const response = await fetch('/inventory/report', {
                method: 'POST',
                body: formData,
                headers: {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            })

            printBody.innerHTML = await response.text();

            generatedReportModal.show();

        })

        function download() {
            html2pdf().set(option)
                .from(printBody)
                .save();
        }

        async function printPdf() {

            try {

                const blob = html2pdf().set(option).from(printBody).toPdf().output('blob').then((blob) => {

                    const reader = new FileReader();

                    reader.onload = () => {
                        const pdfWindow = window.open('');
                        const base64data = reader.result.split(',')[1]; // Extract base64 data

                        pdfWindow.document.write(`<iframe width="100%" height="100%" src="data:application/pdf;base64,${base64data}"></iframe>`);
                        pdfWindow.document.close();

                        pdfWindow.onload = () => {
                            pdfWindow.focus();
                        };

                    }
                    reader.readAsDataURL(blob);

                })

            } catch (error) {
                console.error('Error fetching PDF:', error);
            }
        }

    </script>

    <script>
        Apex.grid = {
            padding: {
                right: 0,
                left: 0
            }
        }

        Apex.dataLabels = {
            enabled: false
        }

        var colorPalette = ['#00D8B6', '#008FFB', '#FEB019', '#FF4560', '#775DD0']

        var spark1 = {
            chart: {
                id: 'sparkline1',
                group: 'sparklines',
                type: 'area',
                height: 160,
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                curve: 'straight'
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: 'New Item History',
                data: @json($newItemsCount)
            }],
            labels: @json($lineChartLabel),
            yaxis: {
                min: 0
            },
            xaxis: {
                type: 'datetime',
            },
            colors: ['#DCE6EC'],
            title: {
                text: '{{$items}}',
                offsetX: 30,
                style: {
                    fontSize: '24px',
                    cssClass: 'apexcharts-yaxis-title'
                }
            },
            subtitle: {
                text: 'New Item History',
                offsetX: 30,
                style: {
                    fontSize: '14px',
                    cssClass: 'apexcharts-yaxis-title'
                }
            }
        }

        new ApexCharts(document.querySelector("#spark1"), spark1).render();            

        @if (count($donatedItemHistory) > 0)
            var optionsBar = {
                chart: {
                    type: 'bar',
                    height: 380,
                    width: '100%',
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                    }
                },
                colors: colorPalette,
                series: [{
                    name: "Donation",
                    data: @json(array_map(fn($value)=>$value->total,$donatedItemHistory)),
                }],
                labels: @json(array_map(fn($value)=>$value->name,$donatedItemHistory)),
                xaxis: {
                    labels: {
                        show: true,
                        formatter: function (val) {
                            const array = val.split(" ");

                            if(array.length > 1 ){

                                const shortcut = array.reduce((prev,current) => {
                                    return prev + current.split("")[0];
                                }, "")

                                return `${array[0]} (${shortcut})`;
                            }

                            return array[0];
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#78909c'
                        },
                    }
                },
                title: {
                    text: 'Donation History',
                    align: 'left',
                    style: {
                        fontSize: '18px'
                    }
                },
                tooltip: {
                    x: {
                        formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                            return value
                        }
                    }
                }
            }

            var chartBar = new ApexCharts(document.querySelector('#bar'), optionsBar);
            
            chartBar.render();
        @endif


        var optionsBar2 = {
            chart: {
                type: 'bar',
                height: 380,
                width: '100%',
                stacked: true,
            },
            plotOptions: {
                bar: {
                    columnWidth: '45%',
                }
            },
            colors: colorPalette,
          series: [{
                name: "Stocks",
                data: @json(array_map(fn($value)=>$value->stock,$stocksPerCategory)),
            }],
            labels: @json(array_map(fn($value)=>$value['name'],$stocksPerCategoryLabel)),
            xaxis: {
                labels: {
                    show: true
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: '#78909c'
                    }
                }
            },
            title: {
                text: 'Stocks',
                align: 'left',
                style: {
                    fontSize: '18px'
                }
            }

        }

        var chartBar2 = new ApexCharts(document.querySelector('#bar2'), optionsBar2);
        chartBar2.render();

    </script>

<!-- Add these in your layout before </body> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    function saveAsPNG() {
        let element = document.getElementById("lowStockTableWrapper");
        html2canvas(element).then(canvas => {
            let link = document.createElement("a");
            link.download = "low_stock_items.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    }

    function saveAsPDF() {
        let element = document.getElementById("lowStockTableWrapper");
        html2canvas(element).then(canvas => {
            const { jsPDF } = window.jspdf;
            let pdf = new jsPDF("p", "mm", "a4");
            let imgData = canvas.toDataURL("image/png");

            let pageWidth = pdf.internal.pageSize.getWidth();
            let imgProps = pdf.getImageProperties(imgData);
            let pdfWidth = pageWidth - 20;
            let pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            pdf.addImage(imgData, "PNG", 10, 10, pdfWidth, pdfHeight);
            pdf.save("low_stock_items.pdf");
        });
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function fetchDonorLogs(page = 1) {
        $.ajax({
            url: "{{ route('donor.logs.fetch') }}?page=" + page,
            type: "GET",
            success: function(response) {
                let tbody = $("#donorLogsBody");
                tbody.empty();

                if (response.data.length === 0) {
                    tbody.append(`<tr><td colspan="5" class="text-muted">No donor logs available yet.</td></tr>`);
                } else {
                    response.data.forEach(log => {
                        tbody.append(`
                            <tr>
                                <td>${log.date}</td>
                                <td>${log.contributor_name}</td>
                                <td>${log.item}</td>
                                <td>${log.quantity}</td>
                                <td>${log.donation_type}</td>
                            </tr>
                        `);
                    });
                }

                // Render pagination
                $("#donorLogsPagination").html(response.pagination);
            },
            error: function() {
                $("#donorLogsBody").html(`<tr><td colspan="5" class="text-danger">Failed to load donor logs.</td></tr>`);
            }
        });
    }

    // Initial load
    $(document).ready(function() {
        fetchDonorLogs();

        // Handle pagination click
        $(document).on("click", "#donorLogsPagination a", function(e) {
            e.preventDefault();
            let page = $(this).attr("href").split("page=")[1];
            fetchDonorLogs(page);
        });
    });
</script>
@endsection