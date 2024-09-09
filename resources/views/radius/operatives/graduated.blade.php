@extends('layouts/layoutMaster')

@section('title', 'Graduated Operatives')
@section('head',
    '
    <meta name="csrf-token" content="{{ csrf_token() }}">')

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
    <div class="card container">
        <h1>Operatives Graduated ({{$staffGraduated->count()}})</h1>
        {{-- <div class="form-group d-flex align-items-center">
            <label for="date" class="mb-0 mr-2">Date:</label>
            <input type="datetime-local" name="date" id="date" class="form-control mr-2"
                value="{{ now()->format('Y-m-d\TH:i') }}" min="{{ now()->format('Y-m-d\TH:i') }}" style="max-width: 200px;">

            <button id="downloadCsv" class="btn btn-primary">Download CSV</button>
        </div> --}}

        <table class="table">
          <thead>
              <tr>
                  <th>Staff</th>
                  <th>Phone Number</th>
                  <th>Area</th>
                  <th>Age</th>
                  <th>Started</th>
                  <th>Worked For</th>
                  <th>Last Beat Location</th>
                  <th>Reason</th>

              </tr>
          </thead>
          <tbody id="staffTableBody">
              @php $currentShiftType = null; @endphp
              @foreach ($staffGraduated as $staff)




                  <tr>
                      <form id="attendanceForm-{{ $staff->id }}" action="{{ route('attendance.mark') }}" method="POST">
                          @csrf
                          <td><a href="{{ route('staff-view', ['id' => $staff->id]) }}">{{ $staff->first_name }} {{ $staff->last_name }}</a></td>
                          <td>{{ $staff->phone_number }}</td>
                          <td>{{ $staff->area }}</td>
                          <td>{{ \Carbon\Carbon::parse($staff->date_of_birth)->age }}</td>
                          <td>{{ \Carbon\Carbon::parse($staff->hire_date)->format('jS F, Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($staff->graduated)->diffForHumans(\Carbon\Carbon::parse($staff->hire_date)) }}</td>


                      </form>
                  </tr>
              @endforeach
          </tbody>
      </table>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#date').on('change', function() {
                let selectedDate = $(this).val();

                $.ajax({
                    url: '{{ route('attendance.fetch') }}', // Update with your route to fetch data
                    method: 'GET',
                    data: {
                        date: selectedDate
                    },
                    success: function(response) {
                        let staffTableBody = $('#staffTableBody');
                        staffTableBody.empty();

                        response.staffNotInShifts.forEach(function(staff) {
                            let row = `
                                <tr>
                                    <form id="attendanceForm-${staff.id}" action="{{ route('attendance.mark') }}" method="POST">
                                        @csrf
                                        <td><a href="{{ url('staff/view/${staff.id}') }}">${staff.first_name} ${staff.last_name}</a></td>
                                        <td>${staff.phone_number}</td>
                                        <td>${staff.area}</td>
                                        <td>${staff.age}</td>
                                        <td>${staff.employed}</td>
                                        <td>${staff.beat_branch_name}</td>
                                        <td>${staff.shift_start} / ${staff.shift_type_name}</td>
                                    </form>
                                </tr>
                            `;
                            staffTableBody.append(row);
                        });
                    }
                });
            });

            $('#downloadCsv').on('click', function() {
                let selectedDate = $('#date').val();
                window.location.href = '{{ route('attendance.downloadCsv') }}?date=' + selectedDate;
            });
        });
    </script>



@endsection
