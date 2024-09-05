@extends('layouts/layoutMaster')

@section('title', 'Leads')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @livewireStyles
    {{-- @powerGridStyles --}}
    @livewireStyles

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
                            <span class="text-heading">Leads</span><small style="color: rgb(179, 98, 24)" class="mb-0">
                                Total</small>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $leads->count() }}</h4>
                                {{-- <p class="text-success mb-0">(+29%)</p> --}}
                            </div>

                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-users ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Beats </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $leadOnboarded->count() }}</h4>
                                {{-- <p class="text-danger mb-0">(-14%)</p> --}}
                            </div>
                            {{-- <small class="mb-0">Last week analytics</small> --}}
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-user-check ti-26px"></i>
                            </span>
                        </div>
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
                                <h4 class="mb-0 me-2">{{ $leadsFailed }}</h4>
                                {{-- <p class="text-success mb-0">(+18%)</p> --}}
                            </div>
                            {{-- <small class="mb-0">Last week analytics </small> --}}
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="ti ti-user-plus ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Terminated </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $leadTerminated }}</h4>
                                {{-- <p class="text-success mb-0">(+42%)</p> --}}
                            </div>
                            {{-- <small class="mb-0">Last week analytics</small> --}}
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-user-search ti-26px"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class=" col-sm-3 col-xl-3">
        <a href="{{ route('lead.form') }}"><button type="button" class="btn btn-primary">
                <span class="ti-xs ti ti-user me-2"></span>Add Lead
            </button></a>
    </div>
    <p></p> --}}
    <!-- Users List Table -->









    {{-- <div class="card container">
        <div class="card mb-4">
            <div class="card-datatable table-responsive">
                <!-- Header with Logo -->
                <h1>Week's Leads</h1>
                <div id="pdfHeader" style="display: none">
                    <img src="{{ asset('assets/logo/login_logo.png') }}" alt="Logo" style="height: 50px;">

                    <h1>Week's Leads</h1>
                    <p>Date: <span id="reportWeek"></span></p>
                    <p>Presenter: {{ Auth::user()->name }}</p>
                </div>

                <div>
                    <button id="exportBtn" class="btn btn-primary mb-4">Export to PDF</button>
                    <input type="week" name="week" id="leadsWeek" class="form-control mb-4"
                        value="{{ now()->format('Y-\WW') }}" max="{{ now()->format('Y-\WW') }}">
                </div>

                <table class="table container" id="staffTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Beat</th>
                            <th>Contact Name</th>
                            <th>Phone Number</th>
                            <th> Area Of Lead</th>
                            <th> Lead Type</th>

                            <th> Note</th>
                            <th>Status</th>
                            @if (Auth::user()->level >= $level )
                            <th>By</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="staffTableBody">
                        @foreach ($weekLeads as $lead)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($lead->lead_date)->format('l') }} <br>
                                    {{ Carbon\Carbon::parse($lead->lead_date)->format('jS F') }}</td>
                                <td>{{ $lead->companyName }} </td>
                                <td>{{ $lead->contact_name }}</td>
                                <td>{{ $lead->phone_number }}</td>
                                <td>{{ $lead->area }}</td>
                                <td>{{ $lead->type }}</td>
                                <td>{{ $lead->note }}</td>
                                <td>{{ $lead->approve }}</td>
                                @if (Auth::user()->level >= $level )
                                <td>{{ $lead->user->name ?? ''  }}</td>
                            @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}




    <script>
        document.getElementById('leadsWeek').addEventListener('change', function() {
            let selectedWeek = this.value;

            // Send an AJAX request to the server
            fetch('/get-week-leads', {
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

                    data.weekLeads.forEach(lead => {
                        let row = `
                <tr>
                    <td>${new Date(lead.lead_date).toLocaleDateString('en-US', { weekday: 'long' })} <br>
                        ${new Date(lead.lead_date).toLocaleDateString('en-US', { day: 'numeric', month: 'long' })}
                    </td>
                    <td>${lead.companyName} </td>
                    <td>${lead.contact_name}</td>
                    <td>${lead.phone_number}</td>
                    <td>${lead.area}</td>
                    <td>${lead.type}</td>
                    <td>${lead.note}</td>
                    <td>${lead.approve}</td>
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
          const { jsPDF } = window.jspdf;

          document.getElementById('leadsWeek').addEventListener('change', function() {
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

              document.getElementById('reportWeek').textContent = `${formattedFirstDay} - ${formattedLastDay}`;
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
                  doc.text("Leads This Week", 70, 20);
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
                  doc.save('lead-this-week.pdf');
              };

              // Trigger change event to set initial reportWeek text
              document.getElementById('leadsWeek').dispatchEvent(new Event('change'));
          });
      });
  </script>





@endsection
