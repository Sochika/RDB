@extends('layouts/layoutMaster')

@section('title', ' Operative - Forms')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
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

    <!-- Multi Column with Form Separator -->
    <div class="card mb-6">
        <h5 class="card-header">Recruit Details</h5>
        <form action="{{ route('recruit.store') }}" method="POST" class="card-body" id="addStaffForm"
            enctype="multipart/form-data">
            @csrf
            <div class="row g-6">
                <div class="col-md-4">
                    <label class="form-label" for="add-user-firstName">First Name</label>
                    <input type="text" class="form-control" id="add-user-firstName" placeholder="John" name="first_name"
                        aria-label="John Doe" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-middleNmae">Middle Name</label>
                    <input type="text" class="form-control" id="add-user-middleNmae" placeholder="Mike"
                        name="middle_name" aria-label="John Doe" />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-lastname">Last Name</label>
                    <input type="text" class="form-control" id="add-user-lastname" placeholder="Doe" name="last_name"
                        aria-label="John Doe" required />
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="add-user-contact">Phone Number</label>
                    <input type="text" id="add-user-contact" class="form-control" placeholder="0809 988 0000"
                        aria-label="08070000000" name="phone_number" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-email">Email</label>
                    <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                        aria-label="john.doe@example.com" name="email" />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-gender">Gender</label>
                    <select id="add-gender" name="gender" class="form-select" required>
                        <option value="binary">Select</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="add-user-area">Stouted Area</label>
                    <input type="text" id="add-user-area" class="form-control" placeholder="Rumumaosi"
                        aria-label="Rumumaosi" name="sourced_area" required />
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="add-user-area">Recruit Residental Area</label>
                    <input type="text" id="add-user-area" class="form-control" placeholder="Rumumaosi"
                        aria-label="Rumumaosi" name="area" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-city">City</label>
                    <input type="text" id="add-user-city" class="form-control" placeholder="Port Harcourt"
                        aria-label="PH" name="city" required />
                </div>
                <div class="col-md-4">
                    <label for="selectState" class="form-label">State</label>
                    <select id="selectState" class="form-select selectpicker w-100" name="state"
                        data-style="btn-default" data-live-search="true" required>
                        <option data-tokens="none">Select</option>
                        @foreach ($states as $state)
                            <option data-tokens="{{ $state->name }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="created_by" class="form-label">Brought by (Staff)</label>
                    <select id="created_by" class="form-select selectpicker w-100" name="created_by"
                        data-style="btn-default" data-live-search="true">
                        <option data-tokens="none">Select</option>
                        @foreach ($staffs as $staff)
                            <option data-tokens="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-city">External Referal</label>
                    <input type="text" id="add-user-referal" class="form-control" placeholder="Joe Doe"
                        aria-label="referral" name="referral" />
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="add-user-join-date">Contact Date</label>
                    <input type="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" id="add-user-join-date"
                        class="form-control" name="recruit_date" required />
                </div>

                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>

        </form>


    </div>


    <div class="modal" id="stoutedAreaModal" tabindex="-1" role="dialog" aria-labelledby="stoutedAreaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stoutedAreaModalLabel">Enter Stouted Area</h5>
                </div>
                <div class="modal-body">
                    <input type="text" id="stoutedAreaInput" class="form-control" placeholder="Enter Stouted Area" />
                </div>
                <div class="modal-footer">
                    <button type="button" id="backButton" class="btn btn-secondary">Back</button>
                    <button type="button" id="submitStoutedArea" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>


    {{-- <script>
      // Function to show the modal on page load
      window.onload = function() {
        const stoutedAreaModal = new bootstrap.Modal(document.getElementById('stoutedAreaModal'));
        stoutedAreaModal.show();

        // Focus the input field in the modal
        document.getElementById('stoutedAreaInput').focus();

        // Add event listener for the Enter key
        document.getElementById('stoutedAreaInput').addEventListener('keydown', function(event) {
          if (event.key === 'Enter') {
            event.preventDefault();
            document.getElementById('submitStoutedArea').click();
          }
        });

        // Handle the submit button click
        document.getElementById('submitStoutedArea').addEventListener('click', function() {
          const stoutedAreaValue = document.getElementById('stoutedAreaInput').value;
          if (stoutedAreaValue) {
            // Assign the input value to the sourced_area field
            document.getElementsByName('sourced_area')[0].value = stoutedAreaValue;
            // Hide the modal
            stoutedAreaModal.hide();
          }
        });

        document.getElementById('backButton').addEventListener('click', function() {
      window.history.back();
    });
      };
    </script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}



@endsection
