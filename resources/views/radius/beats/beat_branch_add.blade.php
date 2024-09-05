@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Beats')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/app-access-roles.js', 'resources/assets/js/modal-add-role.js'])
    {{-- <script>
      document.addEventListener('DOMContentLoaded', (event) => {
    const modal = document.getElementById('beatModal');

    modal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        const button = event.relatedTarget;

        // Extract info from data-beat attribute
        const beatData = button.getAttribute('data-beat');
        const beat = JSON.parse(beatData);

        // Update the modal's content
        const modalTitle = modal.querySelector('.modal-title');
        const modalBodyBeatName = modal.querySelector('#modal-beat-name');
        const modalBodyBeatPhone = modal.querySelector('#modal-beat-phone');
        const modalBodyBeatBranches = modal.querySelector('#modal-beat-branches');

        modalTitle.textContent = `Beat Details - ${beat.name}`;
        modalBodyBeatName.textContent = `Name: ${beat.name}`;
        modalBodyBeatPhone.textContent = `Phone: ${beat.phone_number}`;

        let branchesHtml = '';
        beat.beat_branches.forEach(branch => {
            branchesHtml += `<div>
                                <p>${branch.address} ${branch.area}</p>
                                <small>${branch.staff->count()} Operative(s)</small>
                             </div>`;
        });
        modalBodyBeatBranches.innerHTML = branchesHtml;
    });
});

    </script> --}}

@endsection

@section('content')
    <div class="row">
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

    {{-- @php
        // Assuming $beats is a collection of Beat models
        $filteredBeatsOn = $beats->filter(function ($beat) {
            // Define your condition here, for example, checking if the beat has more than 3 branches
            return $beat->status == 'on';
        });
        $filteredBeatsOff = $beats->filter(function ($beat) {
            // Define your condition here, for example, checking if the beat has more than 3 branches
            return $beat->status == 'off';
        });
    @endphp --}}

 <div class="card">
  <div class="text-center mb-6">
    <h4 class="address-title mb-2">Add New Beat</h4>
    <p class="address-subtitle">Add beat Details</p>
  </div>
  <form id="addNewAddressForm" class="row g-6" action="{{ route('beats.store') }}" method="POST">
    @csrf


    <div class="col-12">
      <label class="form-label" for="companyName">Company Name</label>
      <input type="text" id="companyName" name="companyName" class="form-control" placeholder="St. Odumo" value="" readonly/>
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label" for="modalAddressFirstName">Contact First Name</label>
      <input type="text" id="modalAddressFirstName" name="first_name" class="form-control" required placeholder="John" />
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label" for="modalAddressLastName">Contact Last Name</label>
      <input type="text" id="modalAddressLastName" name="last_name" class="form-control" required placeholder="Doe" />
    </div>

    <div class="col-12 col-md-6">
      <label class="form-label" for="phone_number">Contact Phone Number</label>
      <input type="text" id="phone_number" name="phone_number" class="form-control" required placeholder="08095000000" />
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label" for="email">Contact Email</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="johndeo@example.com" />
    </div>

    <div class="col-12 ">
      <label class="form-label" for="modalAddressAddress1">Address</label>
      <input type="text" id="modalAddressAddress1" name="Address1" class="form-control" required placeholder="12, Business Park" />
    </div>
    {{-- <div class="col-12">
      <label class="form-label" for="modalAddressAddress2">Address Line 2</label>
      <input type="text" id="modalAddressAddress2" name="Address2" class="form-control" placeholder="Mall Road" />
    </div> --}}
    <div class="col-12 col-md-6">
      <label class="form-label" for="modalAddressArea">Area</label>
      <input type="text" id="modalAddressArea" name="area" class="form-control" placeholder="Rumumaosi" required />
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label" for="modalAddressLandmark">Landmark</label>
      <input type="text" id="modalAddressLandmark" name="landmark" class="form-control" placeholder="Nr. First Bank" />
    </div>
    <div class="col-12 col-md-6">
      <label class="form-label" for="modalAddressCity">City</label>
      <input type="text" id="modalAddressCity" name="city" class="form-control" placeholder="Port Harcourt" />
    </div>
    <div class="col-md-6 mb-6">
      <label for="selectpickerLiveSearch" class="form-label">State</label>
      <select id="selectpickerLiveSearch" class="form-select selectpicker w-100" name="state" data-style="btn-default" data-live-search="true">
        <option data-tokens="none">Select</option>
        @foreach ($states as $state)
        <option data-tokens="{{ $state->name }}">{{ $state->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-12 col-md-6">
      <label class="form-label" for="onboard_date">OnBoard Date</label>
      <input type="date" id="onboard_date" name="onboard_date" class="form-control" placeholder="Port Harcourt" />
    </div>

    {{-- <div class="col-12">
      <label class="form-label" for="modalAddressCountry">Country</label>
      <select id="modalAddressCountry" name="modalAddressCountry" class="select2 form-select" data-allow-clear="true">
        <option value="">Select</option>
        <option value="Australia">Australia</option>

        <option value="United States">United States</option>
      </select>
    </div> --}}
    {{-- <div class="col-12">
      <div class="form-check form-switch">
        <input type="checkbox" class="form-check-input" id="billingAddress" />
        <label for="billingAddress" class="form-label">Use as a billing address?</label>
      </div>
    </div> --}}
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
  </form>
 </div>

    </div>

@endsection
