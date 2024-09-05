@extends('layouts/layoutMaster')

@section('title', 'Sit Rep')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-solid-success d-flex align-items-center alert-dismissible mb-0" role="alert">
            <span class="alert-icon rounded">
                <i class="ti ti-check"></i>
            </span>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-solid-danger d-flex align-items-center alert-dismissible mb-0" role="alert">
            <span class="alert-icon rounded">
                <i class="ti ti-ban"></i>
            </span>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div>

        <div class="card container">
            <h1>Mark Attendance</h1>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" id="attendanceDate" class="form-control"
                    value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
            </div>

            <div id="attendance-table">
                @include('radius.attendance.partials.staffs_table', ['staffsUnMarked' => $staffsUnMarked])
            </div>
        </div>



    </div>
    <br>

    <div class="card container">
        <h1><span id="today">Today</span>'s Sit Rep</h1>

        <div>
            <button id="exportBtn" class="btn btn-primary mb-4">Export to PDF</button>
            <input type="date" name="date" id="sitRepdate" class="form-control mb-4"
                value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
        </div>

        <div id="pdfHeader" style="display: none;">
            <img src="{{ asset('assets/logo/login_logo.png') }}" alt="Logo" style="width: 100px;" />
            <h1>Sit Rep Report</h1>
            <p>Date: <span id="reportDate"></span></p>
        </div>

        {{-- <table class="table" id="staffTable">
            <thead>
                <tr>
                    <th>Operative</th>
                    <th>Phone Number</th>
                    <th>Beat Location</th>
                    <th>Shift Time</th>
                    <th>Shift Type</th>
                    <th>Comment</th>
                    <th>Lateness (minutes)</th>
                    <th>Sit Rep</th>
                </tr>
            </thead>
            <tbody id="staffTableBody">
                @foreach ($staffsMarked as $staff)
                    <tr>
                        <form id="attendanceForm-{{ $staff->id }}" action="{{ route('attendance.mark') }}"
                            method="POST">
                            @csrf
                            <td><a href="{{ route('staff-view', ['id' => $staff->id]) }}">{{ $staff->first_name }}
                                    {{ $staff->last_name }}</a></td>
                            <td>{{ $staff->phone_number }}</td>
                            <td>{{ $staff->beat_branch_name }}</td>
                            <td>{{ $staff->shift_start }}</td>
                            <td>{{ $staff->shift_type_name }}</td>
                            <td>{{ $staff->comment }}</td>
                            <td>{{ $staff->status }}/{{ $staff->minutes_of_lateness }}</td>
                            <td>{{ $staff->seatRep }}</td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
        <table class="table" id="staffTable">
            <thead>
                <tr>
                    <th>Operative</th>
                    <th>Phone Number</th>
                    <th>Beat Location</th>
                    <th>Shift Time</th>
                    <th>Shift Type</th>
                    <th>Comment</th>
                    <th>Lateness (minutes)</th>
                    <th>Sit Rep</th>
                </tr>
            </thead>
            <tbody id="staffTableBody">
                @php $currentShiftType = null; @endphp
                @foreach ($staffsMarked as $staff)
                    @php
                        $shiftTypeName = $staff->shift_type_name ?? 'Stand By';
                    @endphp

                    @if ($currentShiftType !== $shiftTypeName)
                        @php $currentShiftType = $shiftTypeName; @endphp
                        <tr class="group-title">
                            <td colspan="8"><strong>{{ $currentShiftType }}</strong></td>
                        </tr>
                    @endif

                    <tr>
                        <form id="attendanceForm-{{ $staff->id }}" action="{{ route('attendance.mark') }}"
                            method="POST">
                            @csrf
                            <td><a href="{{ route('staff-view', ['id' => $staff->id]) }}">{{ $staff->first_name }}
                                    {{ $staff->last_name }}</a></td>
                            <td>{{ $staff->phone_number }}</td>
                            <td>{{ $staff->beat_branch_name }}</td>
                            <td>{{ $staff->shift_start }}</td>
                            <td>{{ $staff->shift_type_name ?? 'Not Assigned Yet' }}</td>
                            <td>{{ $staff->comment }}</td>
                            <td>{{ $staff->status }}/{{ $staff->minutes_of_lateness }}</td>
                            <td>{{ $staff->seatRep }}</td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>


    <script></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.querySelector('#attendanceDate');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const attendanceTable = document.getElementById('attendance-table');

            // Function to update the attendance table based on the selected date
            function updateAttendanceTable(selectedDate) {
                const url = "{{ route('attendance.filterByDate') }}";

                fetch(url + '?date=' + selectedDate, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        attendanceTable.innerHTML = data;
                        // Reinitialize checkboxes after table update
                        initializeCheckboxes();
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Event listener for date input change
            dateInput.addEventListener('change', function() {
                const selectedDate = this.value;
                updateAttendanceTable(selectedDate);
            });

            // Initialize checkboxes with event listeners
            function initializeCheckboxes() {
                const checkboxes = document.querySelectorAll('.switch-input');
                checkboxes.forEach(function(checkbox) {
                    checkbox.removeEventListener('change',
                    checkboxChangeHandler); // Remove any existing handler to avoid multiple bindings
                    checkbox.addEventListener('change', checkboxChangeHandler);
                });
            }

            // Event handler for checkbox change
            function checkboxChangeHandler(event) {
                const checkbox = event.target;
                const staffId = checkbox.getAttribute('data-staff-id');
                const commentInput = document.querySelector(`input[name="comment[${staffId}]"]`);
                const latenessInput = document.querySelector(`input[name="lateness[${staffId}]"]`);

                if (commentInput && latenessInput) {
                    const formData = {
                        staff_id: staffId,
                        date: dateInput.value,
                        comment: commentInput.value,
                        lateness: latenessInput.value,
                        present: checkbox.checked,
                        _token: csrfToken
                    };

                    fetch('{{ route('attendance.mark') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': formData._token,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(formData),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Attendance marked successfully for operative');
                                updateAttendanceTable(dateInput.value); // Reload the table only
                            } else {
                                alert('Failed to mark attendance for operative');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while marking attendance.');
                        });
                } else {
                    console.error('Comment or lateness input not found for staff ID ' + staffId);
                }
            }

            // Initial setup
            initializeCheckboxes();
        });
    </script>


    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- Include html2canvas library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const exportBtn = document.getElementById('exportBtn');
            const dateInput = document.getElementById('sitRepdate');
            const staffTableBody = document.getElementById('staffTableBody');
            const pdfHeader = document.getElementById('pdfHeader');
            const reportDate = document.getElementById('reportDate');
            const staffTable = document.getElementById('staffTable');
            const todaySpan = document.querySelector('#today');

            // Constants for page size and layout
            const PAGE_WIDTH = 11.69; // inches (A4 landscape)
            const PAGE_HEIGHT = 8.27; // inches
            const MARGIN = 0.2; // inches on all sides
            const AVAILABLE_WIDTH = PAGE_WIDTH - (MARGIN * 2); // Available width for content
            const AVAILABLE_HEIGHT = PAGE_HEIGHT - (MARGIN * 2); // Available height for content
            const FOOTER_MARGIN = 0.2; // Margin for the footer (page number)
            const ROW_HEIGHT = 0.3; // Approximate row height in inches

            function fetchTableData(date) {
                return fetch(`/callRepTable?date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear existing rows
                        staffTableBody.innerHTML = '';

                        // Populate table with new data
                        data.staffsMarked.forEach(staff => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                        <td><a href="/staff-view/${staff.id}">${staff.first_name} ${staff.last_name}</a></td>
                        <td>${staff.phone_number}</td>
                        <td>${staff.beat_branch_name}</td>
                        <td>${staff.shift_start}</td>
                        <td>${staff.shift_type_name}</td>
                        <td>${staff.comment}</td>
                        <td>${staff.status}/${staff.minutes_of_lateness}</td>
                        <td>${staff.seatRep}</td>
                    `;
                            staffTableBody.appendChild(row);
                        });
                    });
            }

            dateInput.addEventListener('change', function() {
                fetchTableData(this.value);
            });

            // Initial load
            fetchTableData(dateInput.value);

            exportBtn.addEventListener('click', function() {
                const date = dateInput.value;

                // Set the report date in the header
                reportDate.textContent = date;

                // Show the PDF content
                pdfHeader.style.display = 'block';

                // Generate PDF after data is fetched and displayed
                fetchTableData(date).then(() => {
                    // Create an instance of jsPDF with landscape orientation
                    const {
                        jsPDF
                    } = window.jspdf;
                    const pdf = new jsPDF('l', 'in', 'a4'); // 'l' for landscape

                    // Capture the header and table in parts
                    html2canvas(pdfHeader).then(headerCanvas => {
                        const headerData = headerCanvas.toDataURL('image/png');
                        html2canvas(staffTable).then(tableCanvas => {
                            const tableData = tableCanvas.toDataURL('image/png');

                            // Initialize page variables
                            let currentY = MARGIN;
                            let currentPage = 1;

                            // Define column widths (in inches)
                            const columnWidths = {
                                name: AVAILABLE_WIDTH *
                                    0.15, // 15% of available width
                                phone_number: AVAILABLE_WIDTH *
                                    0.15, // 15% of available width
                                beat_branch_name: AVAILABLE_WIDTH *
                                    0.25, // 25% of available width
                                shift_start: AVAILABLE_WIDTH *
                                    0.10, // 10% of available width
                                shift_type_name: AVAILABLE_WIDTH *
                                    0.10, // 10% of available width
                                comment: AVAILABLE_WIDTH *
                                    0.15, // 15% of available width
                                status_lateness: AVAILABLE_WIDTH *
                                    0.05, // 5% of available width
                                seatRep: AVAILABLE_WIDTH *
                                    0.05 // 5% of available width
                            };

                            // Helper function to add a new page
                            function addNewPage(pdf, headerData, pageCount) {
                                pdf.addPage();
                                currentY = MARGIN;
                                pdf.addImage(headerData, 'PNG', MARGIN, MARGIN,
                                    AVAILABLE_WIDTH, 1);
                                currentY += 1.2; // Adjust to position below header
                                currentPage++;
                                addPageNumber(pdf, currentPage, pageCount);
                            }

                            // Helper function to add page numbers
                            function addPageNumber(pdf, pageNumber, totalPages) {
                                pdf.setFontSize(10);
                                pdf.text(`Page ${pageNumber} of ${totalPages}`,
                                    PAGE_WIDTH / 2, PAGE_HEIGHT -
                                    FOOTER_MARGIN, {
                                        align: 'center'
                                    });
                            }

                            // Add header image to the first page
                            pdf.addImage(headerData, 'PNG', MARGIN, MARGIN,
                                AVAILABLE_WIDTH, 1);
                            currentY += 1.2; // Adjust to position below header

                            // Estimate total pages
                            const rows = staffTableBody.querySelectorAll('tr');
                            const rowsPerPage = Math.floor((AVAILABLE_HEIGHT - 1.2 -
                                FOOTER_MARGIN) / ROW_HEIGHT);
                            const totalPages = Math.ceil(rows.length / rowsPerPage);

                            // Add page number to the first page
                            addPageNumber(pdf, currentPage, totalPages);

                            // Divide the content into multiple pages if needed
                            rows.forEach((row, index) => {
                                if (currentY + ROW_HEIGHT >
                                    AVAILABLE_HEIGHT - FOOTER_MARGIN) {
                                    // If adding this row exceeds the available space, create a new page
                                    addNewPage(pdf, headerData, totalPages);
                                }

                                // Add the row data to the current page
                                const cells = row.querySelectorAll('td');
                                let currentX = MARGIN;

                                cells.forEach((cell, i) => {
                                    // Set width based on column index
                                    let width = 0;
                                    switch (i) {
                                        case 0:
                                            width = columnWidths
                                                .name;
                                            break;
                                        case 1:
                                            width = columnWidths
                                                .phone_number;
                                            break;
                                        case 2:
                                            width = columnWidths
                                                .beat_branch_name;
                                            break;
                                        case 3:
                                            width = columnWidths
                                                .shift_start;
                                            break;
                                        case 4:
                                            width = columnWidths
                                                .shift_type_name;
                                            break;
                                        case 5:
                                            width = columnWidths
                                                .comment;
                                            break;
                                        case 6:
                                            width = columnWidths
                                                .status_lateness;
                                            break;
                                        case 7:
                                            width = columnWidths
                                                .seatRep;
                                            break;
                                        default:
                                            width = (
                                                AVAILABLE_WIDTH /
                                                cells.length);
                                    }

                                    // Adjust width and height based on the content of the cell
                                    pdf.text(cell.innerText,
                                        currentX, currentY, {
                                            maxWidth: width
                                        });
                                    currentX += width;
                                });

                                // Draw a light, thin line below the row
                                pdf.setDrawColor(200, 200,
                                    200); // Set line color to a light gray
                                pdf.setLineWidth(
                                    0.01
                                ); // Set line width to a very thin line
                                pdf.line(MARGIN, currentY + (ROW_HEIGHT /
                                        2), PAGE_WIDTH - MARGIN,
                                    currentY +
                                    (ROW_HEIGHT / 2));

                                // Move to the next line
                                currentY += ROW_HEIGHT;
                            });

                            // Save the PDF
                            pdf.save(`Attendance_Report_${date}.pdf`);
                        });
                    }).catch(error => {
                        console.error('Error generating PDF:', error);
                    });
                });
            });
        });
    </script>


@endsection
