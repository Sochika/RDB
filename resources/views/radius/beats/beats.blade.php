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

    @php
        // Assuming $beats is a collection of Beat models
        $filteredBeatsOn = $beats->filter(function ($beat) {
            // Define your condition here, for example, checking if the beat has more than 3 branches
            return $beat->status == 'on';
        });
        $filteredBeatsOff = $beats->filter(function ($beat) {
            // Define your condition here, for example, checking if the beat has more than 3 branches
            return $beat->status == 'off';
        });
    @endphp

    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Beats (<small class="mb-0"
                                    style="color: rgb(209, 176, 27)">Total</small>)</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $beats->count() }}</h4>
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
                            <span class="text-heading">Active</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $filteredBeatsOn->count() }}</h4>
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
                            <span class="text-heading">InActive </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $filteredBeatsOff->count() }}</h4>
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
                            <span class="text-heading">Pending </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">??</h4>
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
    <hr>
    <!-- Role cards -->

    <div class="row g-6">
        <div class="col-sm-12">
            <div class="card-body text-center ps-sm-0">
                {{-- <button data-bs-target="#addNewBeat" data-bs-toggle="modal" --}}

                {{-- <div class=" col-sm-3 col-xl-3"> --}}
                <a href="{{ route('beat.add') }}"><button type="button" class="btn btn-primary">
                        <span class="ti-xs ti ti-user me-2"></span>Add Beat
                    </button></a>
                {{-- </div> --}}
            </div>
        </div>
        @foreach ($beats as $beat)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    @php
                        $totalStaffCount = 0;
                    @endphp
                    <div class="card-body">
                        <div>
                            <a href="{{ route('beat.edit', ['id' => $beat->id]) }}" class="role-edit-modal">
                                <i class="ti ti-edit ti-md text-heading"></i>
                            </a>
                            {{-- Optional Edit Modal --}}
                            {{--
                      <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editBeatModal"
                         data-beat="{{ json_encode($beat) }}" class="role-edit-modal">
                          <i class="ti ti-edit ti-md text-heading"></i>
                      </a>
                      --}}
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addBranchModal"
                                data-beat="{{ json_encode($beat) }}" class="role-edit-modal">
                                <i class="ti ti-plus ti-md text-heading"></i>
                            </a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4"></div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="role-heading">
                                <h5 class="mb-1">{{ $beat->name }}</h5>
                                <span style="color: blue">{{ $beat->phone_number }}</span>
                                @foreach ($beat->beatBranches as $beatBranch)
                                    @php
                                        $branchStaffCount = $beatBranch->shifts->count();
                                        $totalStaffCount += $branchStaffCount;
                                    @endphp
                                    <ul>
                                        <li>
                                            <span
                                                style="color: rgb(5, 5, 5)">{{ $beatBranch->address . ' ' . $beatBranch->area }}</span>
                                            <small><br>{{ $beatBranch->shifts->count() }} Operative(s) </small>
                                            {{-- <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                          @foreach ($beatBranch->shifts->sortBy(function ($operative) {
        return $operative->shiftType->name;
    }) as $operative)
                                              <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                  title="{{ $operative->staff->first_name . ' ' . $operative->staff->last_name. ' ('.$operative->shiftType->name.')' }}" class="avatar pull-up">
                                                  <a href="{{ route('staff-view', ['id' => $operative->staff->id]) }}">
                                                      <img class="rounded-circle"
                                                           @if ($operative->staff->avatar)
                                                           src="{{ asset('images/' . $operative->staff->avatar) }}"
                                                           @else
                                                           src="{{ $operative->staff->gender == 'male' ? asset('assets/img/avatars/male.png') : asset('assets/img/avatars/female.png') }}"
                                                           @endif
                                                           alt="{{ $operative->staff->first_name . ' ' . $operative->staff->last_name }}">
                                                  </a>
                                              </li>
                                          @endforeach
                                      </ul> --}}
                                            @php
                                                // Grouping operatives by shift type
                                                $groupedShifts = $beatBranch->shifts
                                                    ->sortBy(function ($operative) {
                                                        return $operative->shiftType->name;
                                                    })
                                                    ->groupBy(function ($operative) {
                                                        return $operative->shiftType->name;
                                                    });
                                            @endphp

                                            @foreach ($groupedShifts as $shiftTypeName => $operatives)
                                                <h6 class="mt-3">{{ $shiftTypeName }}</h6>
                                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                                    @foreach ($operatives as $operative)
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-bs-placement="top"
                                                            title="{{ $operative->staff->first_name . ' ' . $operative->staff->last_name }}"
                                                            class="avatar pull-up">
                                                            <a href="{{ route('staff-view', ['id' => $operative->staff->id]) }}"
                                                                class="position-relative d-inline-block">
                                                                <img class="rounded-circle"
                                                                    @if ($operative->staff->avatar) src="{{ asset('images/' . $operative->staff->avatar) }}"
                                                             @else
                                                                src="{{ $operative->staff->gender == 'male' ? asset('assets/img/avatars/male.png') : asset('assets/img/avatars/female.png') }}" @endif
                                                                    alt="{{ $operative->staff->first_name . ' ' . $operative->staff->last_name }}">
                                                                <!-- Green dot to indicate online status -->
                                                                @if (array_key_exists($operative->staff->id, $onDuties) && $onDuties[$operative->staff->id] == $beatBranch->id)
                                                                    <span class="status-dot"
                                                                        style="
                                                        position: absolute;
                                                        bottom: -5px;
                                                        left: 50%;
                                                        transform: translateX(-50%);
                                                        width: 10px;
                                                        height: 10px;
                                                        background-color: green;
                                                        border-radius: 50%;
                                                        border: 2px solid white;">
                                                                    </span>
                                                                @else
                                                                    <span class="status-dot"
                                                                        style="
                                                    position: absolute;
                                                    bottom: -5px;
                                                    left: 50%;
                                                    transform: translateX(-50%);
                                                    width: 10px;
                                                    height: 10px;
                                                    background-color: red;
                                                    border-radius: 50%;
                                                    border: 2px solid white;">
                                                                    </span>
                                                                @endif

                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endforeach

                                        </li>
                                    </ul>
                                @endforeach
                                <h6 class="fw-normal mb-0 text-body">Total {{ $totalStaffCount }} operatives</h6>
                            </div>
                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#beatModal"
                                data-beat="{{ json_encode($beat) }}" class="role-edit-modal">
                                <i class="ti ti-eye ti-md text-heading"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        {{-- Optional Add New Beat Section --}}
        {{--
      <div class="col-xl-4 col-lg-6 col-md-6">
          <div class="card h-100">
              <div class="row h-100">
                  <div class="col-sm-5">
                      <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
                          <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
                      </div>
                  </div>
                  <div class="col-sm-7">
                      <div class="card-body text-sm-end text-center ps-sm-0">
                          <button data-bs-target="#addNewBeat" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Beats</button>
                          <p class="mb-0"> Add new role, <br> if it doesn't exist.</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      --}}

        {{-- Optional Beats List View --}}
        {{--
      <div class="col-12">
          <h4 class="mt-6 mb-1">Beats Lists View</h4>
          <p class="mb-0">Find all of your company’s operatives and their associate roles.</p>
      </div>
      --}}

        {{-- Optional Role Table --}}
        {{--
      <div class="col-12">
          <div class="card">
              <div class="card-datatable table-responsive">
                  <table class="datatables-users table border-top">
                      <thead>
                          <tr>
                              <th></th>
                              <th></th>
                              <th>User</th>
                              <th>Role</th>
                              <th>Plan</th>
                              <th>Billing</th>
                              <th>Status</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div>
      --}}
    </div>

    <!--/ Role cards -->

    <!-- Add Role Modal -->
    @include('radius/_modal/modal-view-close-operative')
    @include('radius/_modal/modal-add-new-beat')
    {{-- @include('radius/_modal/modal-edit-beat') --}}
    @include('radius/_modal/modal-add-new-beat-branch')

    <!-- / Add Role Modal -->.
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editBeatModal');
            const form = document.getElementById('addNewAddressForm');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const beat = JSON.parse(button.getAttribute('data-beat').replace(/&quot;/g, '"'));

                // Update form fields with the beat data
                form.querySelector('[name="companyName"]').value = beat.companyName || '';
                form.querySelector('[name="first_name"]').value = beat.first_name || '';
                form.querySelector('[name="last_name"]').value = beat.last_name || '';
                form.querySelector('[name="phone_number"]').value = beat.phone_number || '';
                form.querySelector('[name="email"]').value = beat.email || '';
                form.querySelector('[name="Address1"]').value = beat.Address1 || '';
                form.querySelector('[name="Address2"]').value = beat.Address2 || '';
                form.querySelector('[name="area"]').value = beat.area || '';
                form.querySelector('[name="landmark"]').value = beat.landmark || '';
                form.querySelector('[name="city"]').value = beat.city || '';
                form.querySelector('[name="state"]').value = beat.state || '';
                form.querySelector('[name="onboard_date"]').value = beat.onboard_date || '';

                // If you have other fields to update, add them here
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('beatModal');
            const modalContent = document.getElementById('modalContent');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const beat = JSON.parse(button.getAttribute('data-beat'));

                let content = '<h3>' + beat.name + '</h3>';

                beat.beat_branches.forEach(function(branch) {
                    content += '<h4>' + branch.name + '</h4>';
                    content += '<table class="table">';
                    content +=
                        '<thead><tr><th>Name</th><th>Number</th><th>Location</th><th>Current Beat</th><th>Shift</th><th>Off?</th></tr></thead><tbody>';

                    branch.staff.forEach(function(staff) {
                        content += '<tr><td>' + (staff.first_name || '') + ' ' + (staff
                            .last_name || '') + '</td>';
                        content += '<td>' + (staff.phone_number || '') + '</td>';
                        content += '<td>' + (staff.area || '') + '</td>';
                        content += '<td>' + (staff.beat ? staff.beat.name : '') + '</td>';
                        content += '<td>' + (staff.shifts ? staff.shifts.shift_end : '') +
                            '</td>';
                        content += '<td>' + (staff.shifts ? staff.shifts.shift_on : '') +
                            '</td></tr>';
                    });

                    content += '</tbody></table>';
                });

                modalContent.innerHTML = content;
            });
        });
    </script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#addBranchModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var beat = button.data('beat'); // Extract info from data-* attributes
                var modal = $(this);

                // Update the modal's content.
                modal.find('.address-title').text('Add New Beat Branch for ' + beat.name);
                // modal.find('[name="type"]').prop('checked', false); // Reset radio buttons
                modal.find('#companyName').val(beat.name);
                beatid
                modal.find('#beatid').val(beat.id);
                // modal.find('#modalAddressFirstName').val('');
                // modal.find('#modalAddressLastName').val('');
                // modal.find('#phone_number').val('');
                // modal.find('#email').val('');
                // modal.find('#modalAddressAddress1').val('');
                // modal.find('#modalAddressAddress2').val('');
                // modal.find('#modalAddressArea').val('');
                // modal.find('#modalAddressLandmark').val('');
                // modal.find('#modalAddressCity').val('');
                // modal.find('#selectpickerLiveSearch').val('none').selectpicker('refresh'); // Reset the state dropdown
                // modal.find('#onboard_date').val('');

                // If you need to fill any fields with data from beat object, you can do it here.
                // Example:
                // modal.find('#someField').val(beat.someProperty);
            });
        });
    </script>

@endsection
