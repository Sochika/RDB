@extends('layouts/layoutMaster')

@section('title', 'Recruits')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @livewireStyles
    {{-- @powerGridStyles --}}
    @livewireStyles
    <style>
        /* General styles for the rating container */
        .rating {
            display: inline-flex;
            direction: rtl;
            /* Reverse direction to handle star selection from left to right */
            font-size: 25px;
            /* Size of stars */
        }

        /* Hide radio buttons */
        .rating input {
            display: none;
        }

        /* Style for stars */
        .rating label {
            color: #ccc;
            /* Default star color (gray) */
            cursor: pointer;
            transition: color 0.2s;
            /* Smooth transition for color change */
        }

        /* Highlight stars when checked */
        .rating input:checked+label,
        .rating input:checked+label~label {
            color: gold;
            /* Color when star is selected (gold) */
        }

        /* Hover effect to preview star rating */
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
            /* Color of stars when hovered over */
        }

        /* Ensure the radio buttons and labels are aligned correctly */
        .rating input:checked~label {
            color: gold;
            /* Highlight all previous stars when a star is checked */
        }

        /* Optional: Adjust label spacing if needed */
        .rating label {
            margin: 0 2px;
            /* Add margin between stars */
        }

        /* CSS for smooth transition
            tr.sub-row {
                transition: height 0.3s ease;
                overflow: hidden;
                height: 0;
            }

            tr.sub-row.open {
                height: auto;
            } */
    </style>

    <style>
        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
    </style>


@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    {{-- @vite('resources/assets/js2/app-staff-list.js') --}}
    {{-- @livewireScripts --}}

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


    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Recruits</span><small style="color: rgb(179, 98, 24)" class="mb-0">
                                Total</small>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruits->count() }}</h4>
                                {{-- <p class="text-success mb-0">(+29%)</p> --}}
                            </div>

                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-users ti-26px"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Operatives </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruitsApproved->count() }}</h4>
                                {{-- <p class="text-danger mb-0">(-14%)</p> --}}
                            </div>
                            {{-- <small class="mb-0">Last week analytics</small> --}}
                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-user-check ti-26px"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Failed </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruitsFailed }}</h4>
                                {{-- <p class="text-success mb-0">(+18%)</p> --}}
                            </div>
                            {{-- <small class="mb-0">Last week analytics </small> --}}
                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-user-plus ti-26px"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Guardated </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruitsGraduated }}</h4>
                                {{-- <p class="text-success mb-0">(+42%)</p> --}}
                            </div>
                            {{-- <small class="mb-0">Last week analytics</small> --}}
                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-user-search ti-26px"></i>
                                </span>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-sm-3 col-xl-3">
        <a href="{{ route('market.recruit') }}"><button type="button" class="btn btn-primary">
                <span class="ti-xs ti ti-user me-2"></span>Add Recruit
            </button></a>
    </div>
    <p></p>
    <!-- Users List Table -->









    <div class="card container">
        <div class="card mb-4">
            <div class="card-datatable table-responsive">
                <!-- Header with Logo -->
                <h1>Unattended Recruit</h1>
                <div id="pdfHeader" style="display: none">
                    <img src="{{ asset('assets/logo/login_logo.png') }}" alt="Logo" style="height: 50px;">

                    <h1>Unattended Recruit</h1>
                    <p>Date: <span id="reportWeek"></span></p>
                    <p>Presenter: {{ Auth::user()->name }}</p>
                </div>

                <div>
                    <button id="exportBtn" class="btn btn-primary mb-4">Export to PDF</button>
                    {{-- <input type="week" name="week" id="recruitsWeek" class="form-control mb-4"
                        value="{{ now()->format('Y-\WW') }}" max="{{ now()->format('Y-\WW') }}"> --}}
                </div>

                <table class="table container" id="staffTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Recruit</th>
                            {{-- <th>Phone Number</th> --}}
                            <th> Area Of Recruit <br>/ Area Sourced</th>
                            <th>Brought By</th>

                            <th colspan="4"> Note</th>
                            <th>Status</th>
                            {{-- @if (Auth::user()->level >= $level) --}}
                            <th>Added on</th>
                            <th>Action</th>

                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody id="staffTableBody">
                        @foreach ($recruits as $recruit)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}</td>
                                <td>
                                    <a href="">{{ $recruit->first_name }}
                                        {{ $recruit->last_name }}<br>
                                        {{ $recruit->gender }}<br>
                                        {{ $recruit->phone_number }}
                                    </a>
                                </td>
                                @if ($recruit->area == $recruit->sourced_area)
                                    <td>{{ $recruit->area }}</td>
                                @else
                                    <td>{{ $recruit->area }} <br> {{ $recruit->sourced_area }}</td>
                                @endif
                                <td>{{ $recruit->user->name ?? '' }}</td>
                                <td colspan="4">{{ '' }}</td>
                                <td>{{ $recruit->approve == 1 ? 'Pending' : ($recruit->approve == 3 ? 'Operative' : 'Rejected') }}
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($recruit->created_at)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <button class="toggle-btn" data-target="sub-row-{{ $recruit->id }}">&#43;</button>
                                </td>
                            </tr>
                            @foreach ($recruit->notes as $note)
                                <tr id="sub-row-{{ $recruit->id }}" class="sub-row" style="display:none;">
                                    {{-- <td colspan="7"> --}}
                                    <form action="{{ route('recruit.save') }}" method="POST" class="card-body">
                                        @csrf

                                        <input type="hidden" name="note_id" value="{{ $note->id ?? null }}">
                                        <td>
                                            <label for="read_{{ $recruit->id }}">Can Read:</label>
                                            <br>
                                            <div class="rating">
                                                <input type="hidden" name="recruit_id" value="{{ $recruit->id }}">
                                                <input type="radio" id="read_star5_{{ $recruit->id }}"
                                                    name="read_{{ $recruit->id }}" value="5"
                                                    @if (isset(json_decode($note->record ?? '{}')->read) && json_decode($note->record ?? '{}')->read == 5) checked @endif />
                                                <label for="read_star5_{{ $recruit->id }}" title="5 stars">★</label>

                                                <input type="radio" id="read_star4_{{ $recruit->id }}"
                                                    name="read_{{ $recruit->id }}" value="4"
                                                    @if (isset(json_decode($note->record ?? '{}')->read) && json_decode($note->record ?? '{}')->read == 4) checked @endif />
                                                <label for="read_star4_{{ $recruit->id }}" title="4 stars">★</label>

                                                <input type="radio" id="read_star3_{{ $recruit->id }}"
                                                    name="read_{{ $recruit->id }}" value="3"
                                                    @if (isset(json_decode($note->record ?? '{}')->read) && json_decode($note->record ?? '{}')->read == 3) checked @endif />
                                                <label for="read_star3_{{ $recruit->id }}" title="3 stars">★</label>

                                                <input type="radio" id="read_star2_{{ $recruit->id }}"
                                                    name="read_{{ $recruit->id }}" value="2"
                                                    @if (isset(json_decode($note->record ?? '{}')->read) && json_decode($note->record ?? '{}')->read == 2) checked @endif />
                                                <label for="read_star2_{{ $recruit->id }}" title="2 stars">★</label>

                                                <input type="radio" id="read_star1_{{ $recruit->id }}"
                                                    name="read_{{ $recruit->id }}" value="1"
                                                    @if (isset(json_decode($note->record ?? '{}')->read) && json_decode($note->record ?? '{}')->read == 1) checked @endif />
                                                <label for="read_star1_{{ $recruit->id }}" title="1 star">★</label>
                                            </div>
                                        </td>
                                        <td>
                                            <label for="write_{{ $recruit->id }}">Can Write:</label>
                                            <br>
                                            <div class="rating">
                                                <input type="radio" id="write_star5_{{ $recruit->id }}"
                                                    name="write_{{ $recruit->id }}" value="5"
                                                    @if (isset(json_decode($note->record ?? '{}')->write) && json_decode($note->record ?? '{}')->write == 5) checked @endif />
                                                <label for="write_star5_{{ $recruit->id }}" title="5 stars">★</label>

                                                <input type="radio" id="write_star4_{{ $recruit->id }}"
                                                    name="write_{{ $recruit->id }}" value="4"
                                                    @if (isset(json_decode($note->record ?? '{}')->write) && json_decode($note->record ?? '{}')->write == 4) checked @endif />
                                                <label for="write_star4_{{ $recruit->id }}" title="4 stars">★</label>

                                                <input type="radio" id="write_star3_{{ $recruit->id }}"
                                                    name="write_{{ $recruit->id }}" value="3"
                                                    @if (isset(json_decode($note->record ?? '{}')->write) && json_decode($note->record ?? '{}')->write == 3) checked @endif />
                                                <label for="write_star3_{{ $recruit->id }}" title="3 stars">★</label>

                                                <input type="radio" id="write_star2_{{ $recruit->id }}"
                                                    name="write_{{ $recruit->id }}" value="2"
                                                    @if (isset(json_decode($note->record ?? '{}')->write) && json_decode($note->record ?? '{}')->write == 2) checked @endif />
                                                <label for="write_star2_{{ $recruit->id }}" title="2 stars">★</label>

                                                <input type="radio" id="write_star1_{{ $recruit->id }}"
                                                    name="write_{{ $recruit->id }}" value="1"
                                                    @if (isset(json_decode($note->record ?? '{}')->write) && json_decode($note->record ?? '{}')->write == 1) checked @endif />
                                                <label for="write_star1_{{ $recruit->id }}" title="1 star">★</label>
                                            </div>
                                        </td>

                                        <td>
                                            <label for="communication_{{ $recruit->id }}">Communication:</label>
                                            <br>
                                            <div class="rating">
                                                <input type="radio" id="communication_star5_{{ $recruit->id }}"
                                                    name="communication_{{ $recruit->id }}" value="5"
                                                    @if (isset(json_decode($note->record ?? '{}')->communication) && json_decode($note->record ?? '{}')->communication == 5) checked @endif />
                                                <label for="communication_star5_{{ $recruit->id }}"
                                                    title="5 stars">★</label>

                                                <input type="radio" id="communication_star4_{{ $recruit->id }}"
                                                    name="communication_{{ $recruit->id }}" value="4"
                                                    @if (isset(json_decode($note->record ?? '{}')->communication) && json_decode($note->record ?? '{}')->communication == 4) checked @endif />
                                                <label for="communication_star4_{{ $recruit->id }}"
                                                    title="4 stars">★</label>

                                                <input type="radio" id="communication_star3_{{ $recruit->id }}"
                                                    name="communication_{{ $recruit->id }}" value="3"
                                                    @if (isset(json_decode($note->record ?? '{}')->communication) && json_decode($note->record ?? '{}')->communication == 3) checked @endif />
                                                <label for="communication_star3_{{ $recruit->id }}"
                                                    title="3 stars">★</label>

                                                <input type="radio" id="communication_star2_{{ $recruit->id }}"
                                                    name="communication_{{ $recruit->id }}" value="2"
                                                    @if (isset(json_decode($note->record ?? '{}')->communication) && json_decode($note->record ?? '{}')->communication == 2) checked @endif />
                                                <label for="communication_star2_{{ $recruit->id }}"
                                                    title="2 stars">★</label>

                                                <input type="radio" id="communication_star1_{{ $recruit->id }}"
                                                    name="communication_{{ $recruit->id }}" value="1"
                                                    @if (isset(json_decode($note->record ?? '{}')->communication) && json_decode($note->record ?? '{}')->communication == 1) checked @endif />
                                                <label for="communication_star1_{{ $recruit->id }}"
                                                    title="1 star">★</label>
                                            </div>
                                        </td>


                                        <td>
                                            <label for="exposure_{{ $recruit->id }}">Exposure:</label>
                                            <br>
                                            <div class="rating">
                                                <input type="radio" id="exposure_star5_{{ $recruit->id }}"
                                                    name="exposure_{{ $recruit->id }}" value="5"
                                                    @if (isset(json_decode($note->record ?? '{}')->exposure) && json_decode($note->record ?? '{}')->exposure == 5) checked @endif />
                                                <label for="exposure_star5_{{ $recruit->id }}" title="5 stars">★</label>

                                                <input type="radio" id="exposure_star4_{{ $recruit->id }}"
                                                    name="exposure_{{ $recruit->id }}" value="4"
                                                    @if (isset(json_decode($note->record ?? '{}')->exposure) && json_decode($note->record ?? '{}')->exposure == 4) checked @endif />
                                                <label for="exposure_star4_{{ $recruit->id }}" title="4 stars">★</label>

                                                <input type="radio" id="exposure_star3_{{ $recruit->id }}"
                                                    name="exposure_{{ $recruit->id }}" value="3"
                                                    @if (isset(json_decode($note->record ?? '{}')->exposure) && json_decode($note->record ?? '{}')->exposure == 3) checked @endif />
                                                <label for="exposure_star3_{{ $recruit->id }}" title="3 stars">★</label>

                                                <input type="radio" id="exposure_star2_{{ $recruit->id }}"
                                                    name="exposure_{{ $recruit->id }}" value="2"
                                                    @if (isset(json_decode($note->record ?? '{}')->exposure) && json_decode($note->record ?? '{}')->exposure == 2) checked @endif />
                                                <label for="exposure_star2_{{ $recruit->id }}" title="2 stars">★</label>

                                                <input type="radio" id="exposure_star1_{{ $recruit->id }}"
                                                    name="exposure_{{ $recruit->id }}" value="1"
                                                    @if (isset(json_decode($note->record ?? '{}')->exposure) && json_decode($note->record ?? '{}')->exposure == 1) checked @endif />
                                                <label for="exposure_star1_{{ $recruit->id }}" title="1 star">★</label>
                                            </div>
                                        </td>

                                        <td colspan="4">
                                            <label for="additional_info_{{ $recruit->id }}">Additional
                                                Information:</label>
                                            <br>
                                            <textarea class="form-control" name="additional_info_{{ $recruit->id }}" rows="1">{{ $note->note ?? '' }}</textarea>
                                        </td>
                                        <td>

                                            <span class="switch-label">Form Given:</span>
                                            <br>
                                            <label class="switch switch-primary">

                                                <input type="checkbox" class="switch-input" name="form_given"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_given) && json_decode($note->record ?? '{}')->form_given == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ti ti-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </span>

                                            </label>



                                        </td>
                                        <td>

                                            <span class="switch-label">Guarantors Returned:</span>
                                            <br>
                                            <label class="switch switch-primary">

                                                <input type="checkbox" class="switch-input" name="form_returned"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_returned) && json_decode($note->record ?? '{}')->form_returned == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ti ti-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </span>

                                            </label>



                                        </td>


                                        <td>
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            {{-- <button class="btn btn-success" type="submit_all">Submit</button> --}}
                                        </td>
                                    </form>
                                    {{-- </td> --}}
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script>
        document.getElementById('recruitsWeek').addEventListener('change', function() {
            let selectedWeek = this.value;

            // Send an AJAX request to the server
            fetch('/get-week-recruits', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        week: selectedWeek
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Update the table body with the new data
                    let tableBody = document.getElementById('staffTableBody');
                    tableBody.innerHTML = ''; // Clear the existing data

                    data.weekRecruits.forEach(recruit => {
                        let row = `
                <tr>
                    <td>${new Date(recruit.recruit_date).toLocaleDateString('en-US', { weekday: 'long' })} <br>
                        ${new Date(recruit.recruit_date).toLocaleDateString('en-US', { day: 'numeric', month: 'long' })}
                    </td>
                    <td><a href="/staff-view/${recruit.id}">${recruit.first_name} ${recruit.last_name}</a></td>
                    <td>${recruit.phone_number}</td>
                    <td>${recruit.area}</td>
                    <td>${recruit.area_sourced}</td>
                    <td>${recruit.gender}</td>
                    <td>${recruit.note}</td>
                    <td>${recruit.approve}</td>
                </tr>
            `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });

                    // Update the PDF header with the selected week
                    document.getElementById('reportWeek').textContent = selectedWeek;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const {
                jsPDF
            } = window.jspdf;

            document.getElementById('recruitsWeek').addEventListener('change', function() {
                const weekValue = this.value;
                const [year, week] = weekValue.split('-W');

                // Calculate the first and last day of the week
                const firstDayOfWeek = new Date(year, 0, (week - 1) * 7 + 1);
                let lastDayOfWeek = new Date(year, 0, (week - 1) * 7 + 7);

                // Get today's date
                const today = new Date();

                // Ensure lastDayOfWeek is not beyond today's date
                if (lastDayOfWeek > today) {
                    lastDayOfWeek = today;
                }

                const formattedFirstDay = firstDayOfWeek.toLocaleDateString();
                const formattedLastDay = lastDayOfWeek.toLocaleDateString();

                document.getElementById('reportWeek').textContent =
                    `${formattedFirstDay} - ${formattedLastDay}`;
            });

            document.getElementById('exportBtn').addEventListener('click', function() {
                const doc = new jsPDF();

                // Load the logo
                const logo = new Image();
                logo.src = "{{ asset('assets/logo/login_logo.png') }}"; // Replace with your logo path

                // When the logo is loaded, add it to the PDF
                logo.onload = function() {
                    doc.addImage(logo, 'PNG', 10, 10, 25, 15); // Adjust the size and position as needed

                    // Add title, date range, and presenter
                    doc.text("Recruit This Week", 70, 20);
                    doc.text(`Date: ${document.getElementById('reportWeek').textContent}`, 70, 30);
                    doc.text(`Presenter: {{ Auth::user()->name }}`, 70, 40);

                    // Get the table content
                    const table = document.getElementById('staffTable');
                    const tableData = doc.autoTableHtmlToJson(table);

                    // Generate the PDF table
                    doc.autoTable({
                        head: [tableData.columns],
                        body: tableData.data,
                        startY: 50,
                    });

                    // Save the PDF
                    doc.save('recruit-this-week.pdf');
                };

                // Trigger change event to set initial reportWeek text
                document.getElementById('recruitsWeek').dispatchEvent(new Event('change'));
            });
        });
    </script>

    <script>
        // Script to toggle sub-rows
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', function() {
                const targetRow = document.getElementById(this.dataset.target);
                if (targetRow.style.display === 'none' || targetRow.style.display === '') {
                    targetRow.style.display = 'table-row';
                    this.innerHTML = '&#8722;'; // Minus sign
                } else {
                    targetRow.style.display = 'none';
                    this.innerHTML = '&#43;'; // Plus sign
                }
            });
        });
    </script>






@endsection
