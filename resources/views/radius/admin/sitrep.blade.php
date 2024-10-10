@extends('layouts/layoutMaster')

@section('title', 'Sit Rep Report')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
    <style>
        @media print {
            #attendanceTable {
                /* Add PDF-specific styles */
                font-size: 12px;
            }
        }
    </style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/form-layouts.js'])
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-solid-success d-flex align-items-center alert-dismissible mb-0" role="alert">
            <span class="alert-icon rounded">
                <i class="ti ti-check"></i>
            </span>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </div>
    @elseif (session('error'))
        <div class="alert alert-solid-danger d-flex align-items-center alert-dismissible mb-0" role="alert">
            <span class="alert-icon rounded">
                <i class="ti ti-ban"></i>
            </span>
        @elseif (session('error'))
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </div>
    @endif


    <!-- Form with Tabs -->
    <div class="row">
        <div class="col">
            {{-- <h6 class="mt-6"> Form with Tabs </h6> --}}
            <div class="card mb-6">


                {{-- <div class="card"> --}}
                <div class="container">
                    <div class="body d-flex py-lg-3 py-md-2">
                        <div class="container-xxl">
                            <div class="row align-items-center">
                                <div class="border-0 mb-4">
                                    <div
                                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                        <h3 class="h4 mb-0">Attendance</h3>
                                        <div class="col-auto d-flex w-sm-100 mt-2 mt-sm-0">
                                            <!-- Month and Year Selector with restriction to only current and past months -->
                                            <input type="month" class="form-control" name="month_year" id="monthYearInput"
                                                value="{{ \Carbon\Carbon::now()->format('Y-m') }}"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m') }}">
                                        </div>

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
                                                        <span id="staffName"></span>
                                                    </div>
                                                    <div class="Half-day me-2">
                                                        <span></span>
                                                    </div>
                                                </div>
                                                <div class="atted-info d-flex mb-3 flex-wrap">
                                                    <div class="full-present me-2">
                                                        <i class="ti-check text-success me-1"></i>
                                                        <span>Full Day Present</span>
                                                    </div>
                                                    <div class="Half-day me-2">
                                                        <i class="ti ti-clock text-warning me-1"></i>
                                                        <span>Minutes</span>
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
                                                                <th style="padding-right: 55px;">Operatives</th>
                                                                @for ($day = 1; $day <= 31; $day++)
                                                                    <th class="day-cell">{{ $day }}</th>
                                                                @endfor
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $currentDate = \Carbon\Carbon::now();
                                                            @endphp

                                                            @foreach ($sitrep as $staff_id => $attendanceRecords)
                                                                <tr>
                                                                    <!-- Display the staff_id -->
                                                                    <td>
                                                                        <span
                                                                            class="fw-bold small">{{ $staff_id }}</span>
                                                                    </td>

                                                                    <!-- Loop through each day of the month -->
                                                                    @for ($day = 1; $day <= 31; $day++)
                                                                        @php
                                                                            // Create the date string in the format 'YYYY-MM-DD'
                                                                            $dateString = sprintf(
                                                                                '%04d-%02d-%02d',
                                                                                $year,
                                                                                $month,
                                                                                $day,
                                                                            );
                                                                            $date = \Carbon\Carbon::createFromFormat(
                                                                                'Y-m-d',
                                                                                $dateString,
                                                                            )->startOfDay();
                                                                        @endphp

                                                                        <td class="day-cell">
                                                                            @if ($date->greaterThan($currentDate))
                                                                                <!-- Future date, no mark -->
                                                                            @elseif (isset($attendanceRecords[$date->format('Y-m-d')]))
                                                                                @php
                                                                                    $attendance =
                                                                                        $attendanceRecords[
                                                                                            $date->format('Y-m-d')
                                                                                        ];
                                                                                @endphp
                                                                                <!-- Check if the staff was late or on time -->
                                                                                @if ($attendance['status'] == 'late')
                                                                                    <i class="ti ti-clock text-warning"></i>
                                                                                    <!-- Late -->
                                                                                    <small>{{ $attendance['minutes_of_lateness'] }}
                                                                                        mins</small>
                                                                                    <!-- Show lateness in minutes -->
                                                                                @else
                                                                                    <i class="ti ti-check text-success"></i>
                                                                                    <!-- On time -->
                                                                                @endif
                                                                            @else
                                                                                <i class="ti ti-close text-danger"></i>
                                                                                <!-- Absent -->
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
                {{-- </div> --}}
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            var element = document.getElementById('attendanceTable');
            var monthYearInput = document.getElementById('monthYearInput').value;

            // Format the filename using the selected month and year
            var filename = monthYearInput + '_attendance_report.pdf';

            // Configure the export options
            var opt = {
                margin: 0.5,
                filename: filename,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3
                }, // Higher scale for better quality
                jsPDF: {
                    unit: 'pt',
                    format: 'a3',
                    orientation: 'landscape'
                } // Landscape for wider tables
            };

            // Generate and download the PDF
            html2pdf().from(element).set(opt).save();
        });



        // Listen for changes in the #monthYearInput field
        document.getElementById('monthYearInput').addEventListener('change', function() {
            var monthYear = this.value; // Get the selected month and year (in 'YYYY-MM' format)

            // Send an AJAX request to fetch the data for the selected month and year
            fetch(`/admin/get-attendance-data?month_year=${monthYear}`)
                .then(response => response.json())
                .then(data => {
                    // Update the attendance table with the new data
                    updateAttendanceTable(data);
                })
                .catch(error => {
                    console.error('Error fetching attendance data:', error);
                });
        });

        // Function to update the attendance table
        function updateAttendanceTable(data) {
            const tableBody = document.querySelector('#attendanceTable tbody');
            tableBody.innerHTML = ''; // Clear the existing table content

            const currentDate = new Date(); // Get the current date

            // Loop through each staff and their attendance records
            for (const [staff_id, attendanceRecords] of Object.entries(data)) {
                const row = document.createElement('tr');

                // Create the staff ID cell
                const staffCell = document.createElement('td');
                staffCell.innerHTML = `<span class="fw-bold small">${staff_id}</span>`;
                row.appendChild(staffCell);

                // Loop through each day of the month
                for (let day = 1; day <= 31; day++) {
                    const dateString =
                        `${data.year}-${data.month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                    const date = new Date(dateString);
                    const dayCell = document.createElement('td');
                    dayCell.classList.add('day-cell');

                    // Check the attendance status
                    if (date > currentDate) {
                        // Future date, no mark
                    } else if (attendanceRecords[dateString]) {
                        const attendance = attendanceRecords[dateString];
                        if (attendance.status === 'late') {
                            dayCell.innerHTML =
                                `<i class="ti ti-clock text-warning"></i> <small>${attendance.minutes_of_lateness} mins</small>`;
                        } else {
                            dayCell.innerHTML = `<i class="ti ti-check text-success"></i>`;
                        }
                    } else {
                        dayCell.innerHTML = `<i class="ti ti-close text-danger"></i>`; // Absent
                    }

                    row.appendChild(dayCell);
                }

                tableBody.appendChild(row);
            }
        }
    </script>

@endsection
