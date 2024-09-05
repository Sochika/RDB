@extends('layouts/layoutMaster')

@section('title', 'Settings')

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
                <div class="card-header px-0 pt-0">
                    <div class="nav-align-top">
                        <ul class="nav nav-tabs" role="tablist">

                            <li class="nav-item">
                                <button type="button" class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-roles" aria-controls="form-tabs-roles" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">Roles</span></button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-beats" aria-controls="form-tabs-beats" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">Beats</span></button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-shifts" aria-controls="form-tabs-shifts" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">Shifts</span></button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content p-0">

                        {{-- <div class="tab-pane fade active show" id="form-tabs-roles" role="tabpanel">
            <div>
                <form action="{{ route('settings.role') }}" method="POST">
                    @csrf
                    <div class="row g-6">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Jido" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="salary">Salary</label>
                            <input type="number" id="salary" name="salary" class="form-control" placeholder="20,000" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="level">Levels</label>
                            <input type="number" id="level" name="level" class="form-control" placeholder="1" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="description">Description</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder="the new staff" />
                        </div>
                    </div>
                    <div class="pt-6">
                        <button type="submit" class="btn btn-primary me-4">Submit</button>
                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                    </div>
                </form>
            </div>
            <hr>
            <div>
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Level</th>
                        <th>Description</th>
                        <th>Actions</th> <!-- Added Actions header -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ number_format($role->salary, 2) }}</td>
                            <td>{{ $role->level }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm me-2" id="edit-{{$role->id}}">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm" data-role-id="{{ $role->id }}" data-role-url="{{ route('roles.delete', ['id' => $role->id]) }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div> --}}

                        <div class="tab-pane fade active show" id="form-tabs-roles" role="tabpanel">
                            <div>
                                <form id="role-form" action="{{ route('settings.role') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="role_id" name="role_id" value="" />
                                    <div class="row g-6">
                                        <div class="col-md-6">
                                            <label class="form-label" for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Jido" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="salary">Salary</label>
                                            <input type="number" id="salary" name="salary" class="form-control"
                                                placeholder="20,000" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="level">Levels</label>
                                            <input type="number" id="level" name="level" class="form-control"
                                                placeholder="1" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="description">Description</label>
                                            <input type="text" id="description" name="description" class="form-control"
                                                placeholder="the new staff" />
                                        </div>
                                    </div>
                                    <div class="pt-6">
                                        <button type="submit" id="submit-button"
                                            class="btn btn-primary me-4">Submit</button>
                                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Salary</th>
                                            <th>Level</th>
                                            <th>Description</th>
                                            <th>Actions</th> <!-- Added Actions header -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ number_format($role->salary, 2) }}</td>
                                                <td>{{ $role->level }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-secondary btn-sm me-2 edit-role"
                                                        data-role-id="{{ $role->id }}"
                                                        data-role-name="{{ $role->name }}"
                                                        data-role-salary="{{ $role->salary }}"
                                                        data-role-level="{{ $role->level }}"
                                                        data-role-description="{{ $role->description }}">Edit</button>
                                                    <button type="button" class="btn btn-danger btn-sm delete-role"
                                                        data-role-id="{{ $role->id }}"
                                                        data-role-url="{{ route('roles.delete', ['id' => $role->id]) }}" disabled>Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="form-tabs-beats" role="tabpanel">
                            <form action="{{ route('settings.set') }}" method="POST">
                                @csrf
                                <div class="col-md-6">
                                    <label class="switch switch-success">
                                        <input type="checkbox" class="switch-input" name="view_off_beats" checked />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">Show Beats no longer with us</span>
                                    </label>
                                </div>

                                <p></p>
                                <div class="col-md-6">
                                    <label class="form-label" for="staffs_distance">Staffs Distances from Beats</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="10"
                                            name="staffs_distance" value="{{ $staff_radius->value ?? 0 }}"
                                            aria-label="Distances from Beat" aria-describedby="staffs_distance" />
                                        <span class="input-group-text" id="staffs_distance">Metre(s)</span>
                                    </div>
                                </div>
                                <div class="pt-6">
                                    <button type="submit" class="btn btn-primary me-4">Submit</button>
                                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="form-tabs-shifts" role="tabpanel">
                            <div>
                                <form id="shift-form" action="{{ route('settings.shift') }}" method="POST">
                                    @csrf
                                    <input type="hidden" id="shift_id" name="shift_id" value="" />
                                    <div class="row g-6">
                                        <div class="col-md-6">
                                            <label class="form-label" for="shift_name">Shift Name</label>
                                            <input type="text" id="shift_name" name="shift_name" class="form-control"
                                                placeholder="One On" />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="shift_hours">Hours</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="12"
                                                    name="shift_hours" aria-label="Hours of Shifts" id="shift_hours"
                                                    aria-describedby="shift_hours" />
                                                <span class="input-group-text" id="shift_hours">Hr(s)</span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="description">Description</label>
                                            <input type="text" id="description_shift" name="description"
                                                class="form-control" placeholder="the new shift" />
                                        </div>
                                    </div>
                                    <div class="pt-6">
                                        <button type="submit"  id="shift-submit-button"
                                            class="btn btn-primary me-4">Submit</button>
                                        <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Shift Name</th>
                                            <th>Shift Hours</th>
                                            <th>Description</th>
                                            <th>Actions</th> <!-- Added Actions header -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shift_types as $shift_type)
                                            <tr>
                                                <td>{{ $shift_type->name }}</td>
                                                <td>{{ $shift_type->hours }} Hr(s)</td>
                                                <td>{{ $shift_type->description }}</td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm me-2 edit-shift_type"
                                                        data-shift_type-id="{{ $shift_type->id }}"
                                                        data-shift_type-name="{{ $shift_type->name }}"
                                                        data-shift_type-hours="{{ $shift_type->hours }}"
                                                        data-shift_type-description="{{ $shift_type->description }}">Edit</button>

                                                    <button type="button" class="btn btn-danger btn-sm delete-shift_type"
                                                        data-shift_type-id="{{ $shift_type->id }}"
                                                        data-shift_type-url="{{ route('shift_type.delete', ['id' => $shift_type->id]) }}" disabled>Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
                    const viewOffBeatsCheckbox = document.getElementById('viewOffBeats');
                    if (viewOffBeatsCheckbox) {
                        viewOffBeatsCheckbox.addEventListener('change', function() {
                                const viewOffBeats = this.checked;
                                console.log('Checkbox state changed:', viewOffBeats);

                                //   // Get CSRF token from meta tag
                                //   const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                                //   // Example of an AJAX request using fetch API
                                //   fetch('/your-endpoint', {
                                //     method: 'POST',
                                //     headers: {
                                //       'Content-Type': 'application/json',
                                //       'X-CSRF-TOKEN': csrfToken,
                                //     },
                                //     body: JSON.stringify({ view_off_beats: viewOffBeats }),
                                //   })
                                //   .then(response => response.json())
                                //   .then(data => console.log(data))
                                //   .catch(error => console.error('Error:', error));
                                // });
                            } else {
                                console.error('Checkbox element not found');
                            }
                        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle Edit button click
            $('.edit-role').on('click', function() {
                var roleId = $(this).data('role-id');
                var roleName = $(this).data('role-name');
                var roleSalary = Math.floor($(this).data('role-salary'));
                var roleLevel = $(this).data('role-level');
                var roleDescription = $(this).data('role-description');

                // Populate the form fields
                $('#role_id').val(roleId);
                $('#name').val(roleName);
                $('#salary').val(roleSalary);
                $('#level').val(roleLevel);
                $('#description').val(roleDescription);

                // Change the form action to update the role
                $('#role-form').attr('action', '{{ route('settings.role') }}');
                $('#submit-button').text('Update'); // Change button text to "Update"
            });

            // Handle Delete button click (from previous code)
            $('.delete-role').on('click', function() {
                var roleId = $(this).data('role-id');
                var deleteUrl = $(this).data('role-url');

                if (confirm('Are you sure you want to delete this role?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            alert(result.message);
                            if (result.success) {
                                location.reload(); // Reload the page or handle the DOM update
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the role');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle Edit button click
            $('.edit-shift_type').on('click', function() {
                var shiftId = $(this).data('shift_type-id');
                var shiftName = $(this).data('shift_type-name');
                var shiftHours = $(this).data('shift_type-hours');
                var shiftDescription = $(this).data('shift_type-description');


                console.log('Shift ID:', shiftId);
                console.log('Shift Name:', shiftName);
                console.log('Shift Hours:', shiftHours);
                console.log('Shift Description:', shiftDescription);

                // Populate the form fields
                $('#shift_id').val(shiftId);
                $('#shift_name').val(shiftName);
                $('#shift_hours').val(shiftHours);
                $('#description_shift').val(shiftDescription);

                // Change the form action to update the shift
                $('#shift-form').attr('action', '{{ route('settings.shift') }}');
                $('#shift-submit-button').text('Update'); // Change button text to "Update"
            });

            // Handle Delete button click
            $('.delete-shift_type').on('click', function() {
                var shiftId = $(this).data('shift_type-id');
                var deleteUrl = $(this).data('shift_type-url');

                if (confirm('Are you sure you want to delete this shift type?')) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(result) {
                            alert(result.message);
                            if (result.success) {
                                location.reload(); // Reload the page or handle the DOM update
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the shift type');
                        }
                    });
                }
            });
        });
    </script>

@endsection
