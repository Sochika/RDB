@extends('radius/operatives/view-operative')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/themify-icons/themify-icons.css') }}">
@endsection
@section('operative-content')
    <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-md-row flex-wrap mb-6 row-gap-2">
            <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                        class="ti ti-user-check ti-sm me-1_5"></i>Attendances</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('staff-activity', ['id' => $staff->id]) }}"><i
                        class="ti ti-lock ti-sm me-1_5"></i>Work History</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('staff-guarantors', ['id' => $staff->id]) }}"><i
                        class="ti ti-lock ti-sm me-1_5"></i>Guarantors</a></li>
            {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/notifications')}}"><i class="ti ti-bell ti-sm me-1_5"></i>Notifications</a></li> --}}
            {{-- <li class="nav-item"><a class="nav-link" href="{{url('app/user/view/connections')}}"><i class="ti ti-link ti-sm me-1_5"></i>Connections</a></li> --}}
        </ul>
    </div>
    <div class="card">
        <div class="container">
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div
                                class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="h4 mb-0">Attendance</h3>
                                <div class="col-auto d-flex w-sm-100 mt-2 mt-sm-0">
                                    <button id="exportBtn" class="btn btn-primary mb-4">Export to PDF</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end -->
                    <div class="row clearfix g-3">
                        <div class="col-sm-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div id="attendanceTable">
                                        <div class="atted-info d-flex mb-3 flex-wrap">
                                            <div class="full-present me-2">
                                                <span id="staffName">{{ $staff->first_name }} {{ $staff->last_name }}</span>
                                            </div>
                                            <div class="Half-day me-2">
                                                <span>{{ $staff->shifts->shifttype->name ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="atted-info d-flex mb-3 flex-wrap">
                                            <div class="full-present me-2">
                                                <i class="ti-check text-success me-1"></i>
                                                <span>Full Day Present</span>
                                            </div>
                                            <div class="Half-day me-2">
                                                <i class="ti ti-clock text-warning me-1"></i>
                                                <span>Half Day Present</span>
                                            </div>
                                            <div class="absent me-2">
                                                <i class="ti-close text-danger me-1"></i>
                                                <span>Full Day Absence</span>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="padding-right: 55px;">Month/Day</th>
                                                        @for ($day = 1; $day <= 31; $day++)
                                                            <th class="day-cell">{{ $day }}</th>
                                                        @endfor
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $months = [
                                                            'January',
                                                            'February',
                                                            'March',
                                                            'April',
                                                            'May',
                                                            'June',
                                                            'July',
                                                            'August',
                                                            'September',
                                                            'October',
                                                            'November',
                                                            'December',
                                                        ];
                                                        $currentDate = \Carbon\Carbon::now();
                                                    @endphp

                                                    @foreach ($attendanceData as $month => $days)
                                                        <tr>
                                                            <td>
                                                                <span class="fw-bold small">{{ $month }}</span>
                                                            </td>
                                                            @for ($day = 1; $day <= 31; $day++)
                                                                @php
                                                                    $monthIndex = array_search($month, $months) + 1;
                                                                    $dateString = sprintf(
                                                                        '%02d-%02d',
                                                                        $day,
                                                                        $monthIndex,
                                                                    );
                                                                    $date = \Carbon\Carbon::createFromFormat(
                                                                        'd-m',
                                                                        $dateString,
                                                                    )->startOfDay();
                                                                @endphp
                                                                <td class="day-cell">
                                                                    @if ($date->greaterThan($currentDate))
                                                                        <!-- Future date, no mark -->
                                                                    @elseif (isset($days[$date->format('Y-m-d')]))
                                                                        @php
                                                                            $status = $days[$date->format('Y-m-d')];
                                                                        @endphp
                                                                        @if ($status['lateness'])
                                                                            <i class="ti ti-clock text-warning"></i>
                                                                        @else
                                                                            <i class="ti-check text-success"></i>
                                                                        @endif
                                                                    @else
                                                                        <i class="ti-close text-danger"></i>
                                                                    @endif
                                                                </td>
                                                            @endfor
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- End of attendanceTable div -->
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>
        </div>
    </div>
@endsection


<!-- Include jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<!-- Include html2canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
<!-- Include html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exportBtn = document.getElementById('exportBtn');
        const attendanceTable = document.getElementById('attendanceTable');
        const staffName = document.getElementById('staffName').innerText;

        exportBtn.addEventListener('click', function() {
            const options = {
                filename: `${staffName.replace(/\s/g, '_')}_Attendance_Report.pdf`,
                html2canvas: {
                    scale: 1.0, // Adjust scale to fit the content within the page width
                    scrollX: 0,
                    scrollY: 0
                },
                jsPDF: {
                    unit: 'pt', // Points are commonly used for PDF generation
                    format: [1122,
                        793
                    ], // A4 dimensions in landscape mode (width: 1122pt, height: 793pt)
                    orientation: 'landscape'
                },
                pagebreak: {
                    mode: ['avoid-all', 'css', 'legacy']
                }
            };

            html2pdf().from(attendanceTable).set(options).save();
        });
    });
</script>

<style>
    .day-cell {
        width: 70%;
    }
</style>
