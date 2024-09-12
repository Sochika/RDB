@extends('layouts/layoutMaster')

@section('title', 'Operatives')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @livewireStyles
    @powerGridStyles
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
                            <span class="text-heading">Operatives</span><small style="color: rgb(179, 98, 24)"
                                class="mb-0"> Total</small>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $staffs->count() }}</h4>
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
                            <span class="text-heading">Active </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $operativesAssigned->count() }}</h4>
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
                                <h4 class="mb-0 me-2">{{ $staffs->count() - $operativesAssigned->count() }}</h4>
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
                            <span class="text-heading">Admin Staff </span>
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
    <div class=" col-sm-3 col-xl-3">
        <a href="{{ route('staff.onboarding') }}"><button type="button" class="btn btn-primary">
                <span class="ti-xs ti ti-user me-2"></span>Add Operative
            </button></a>
    </div>
    <p></p>
    <!-- Users List Table -->


 {{-- @livewire('staff-operatives')
  --}}




  {{-- @livewire('staff-operative') --}}
    <div class="card">

      <br>
      <div class="card mb-4">
        <div class="card-datatable table-responsive">
          <livewire:staff-operative/>
        </div>
      </div>
      {{-- <div class="w-full max-w-6xl">
      <livewire:staff-operative/>
      </div> --}}
        {{-- <livewire:staff-operatives/> --}}
        {{-- // resources/views/my-view.blade.php --}}

        {{-- @livewire('staff-operatives') --}}

        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddStaffLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddStaffLabel" class="offcanvas-title">Add Operative</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                <form action="{{ route('staff.store') }}" method="POST" class="add-new-user pt-0" id="addNewUserForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label class="form-label" for="add-user-firstName">First Name</label>
                        <input type="text" class="form-control" id="add-user-firstName" placeholder="John"
                            name="first_name" aria-label="John Doe" required />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-middleNmae">Middle Name</label>
                        <input type="text" class="form-control" id="add-user-middleNmae" placeholder="Mike"
                            name="middle_name" aria-label="John Doe" />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-lastname">Last Name</label>
                        <input type="text" class="form-control" id="add-user-lastname" placeholder="John Doe"
                            name="last_name" aria-label="John Doe" required />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" id="add-user-email" class="form-control"
                            placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email" />
                    </div>

                    <div class="mb-6">
                        <label class="form-label" for="add-user-contact">Contact</label>
                        <input type="text" id="add-user-contact" class="form-control phone-mask"
                            placeholder="0809 988 0000" aria-label="john.doe@example.com" name="phone_number" />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="binary">Select</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </div>

                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"
                            placeholder="52, Fleming Avenue"></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-area">Area</label>
                        <input type="text" id="add-user-area" class="form-control" placeholder="Rumumaosi"
                            aria-label="john.doe@example.com" name="area" required />
                    </div>
                    <div class="mb-6">
                        <label class="form-label" for="add-user-city">City</label>
                        <input type="text" id="add-user-city" class="form-control" placeholder="Port Harcourt"
                            aria-label="john.doe@example.com" name="city" />
                    </div>
                    <div class="mb-6">
                        <label for="selectpickerLiveSearch" class="form-label">State</label>
                        <select id="selectpickerLiveSearch" class="form-select selectpicker w-100" name="state"
                            data-style="btn-default" data-live-search="true">
                            <option data-tokens="none">Select</option>
                            @foreach ($states as $state)
                                <option data-tokens="{{ $state->name }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-6">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>

                        <input class="form-control" type="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                            id="date_of_birth" name="date_of_birth" required />

                    </div>
                    <div class="mb-6">
                        <label for="join-date" class="form-label">Date of Employment</label>

                        <input class="form-control" type="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                            id="join-date" name="hire_date" required />

                    </div>

                    <div class="mb-6">
                        <label for="formFilecredential" class="form-label">Upload credentials</label>
                        <input class="form-control" type="file" id="formFilecredential" multiple name="credentials">
                    </div>
                    <div class="mb-6">
                        <label for="profile_image">Choose Image</label>
                        <input type="file" class="form-control" name="avatar" id="profile_image">
                    </div>


                    <div class="mb-6">
                        <label class="form-label" for="user-role">Staff Role</label>
                        <select id="user-role" class="form-select" name="role_id">
                            <option value="none">Select</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach


                        </select>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="btn btn-primary me-4">Submit</button>
                        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>


                </form>
            </div>
        </div>
    </div>

    @livewireScripts
    @powerGridScripts
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

    {{-- <script>
      Livewire.on('staffDeleted', () => {
    alert('Staff member has been deleted successfully!');
    // You can also refresh the table or perform other actions here
});

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('redirect', event => {
        window.location.href = event.detail.url;
    });

    window.addEventListener('staffDeleted', event => {
        alert('Staff member has been deleted successfully!');
        // You can also refresh the table or perform other actions here
    });
});
</script>

    </script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('redirect', url => {
            window.location.href = url;
        });

        Livewire.on('staffDeleted', rowId => {
            Swal.fire(
                'Deleted!',
                'Operative has been deleted successfully.',
                'success'
            );
            Livewire.emit('refreshTable'); // Assuming you have a method to refresh the table
        });

        Livewire.on('confirmDelete', rowId => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('delete', rowId);
                }
            });
        });
    });
    </script> --}}
   {{-- <script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('triggerDelete', rowId => {
            // Use the native confirm dialog or a custom one like SweetAlert
            if (confirm('Are you sure you want to delete this staff member?')) {
                Livewire.emit('delete', rowId);
            }
        });
    });
</script> --}}

<script>
  document.addEventListener('livewire:load', function () {
      Livewire.on('triggerDelete', rowId => {
          // Show a confirmation dialog
          if (confirm('Are you sure you want to delete this staff member?')) {
              // Emit the delete event to Livewire
              Livewire.emit('delete', rowId);
          }
      });
  });
</script>




@endsection
