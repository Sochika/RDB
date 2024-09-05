@extends('layouts/layoutMaster')

@section('title', 'Operative')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-user-view.scss'])

@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/modal-edit-user.js', 'resources/assets/js/app-user-view.js', 'resources/assets/js/app-user-view-account.js', 'resources/assets/js/pages-profile.js'])
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
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-4" {{-- $staff->gender ? asset('images/' . $staff->gender) : --}}
                                @if ($staff->avatar) src="{{ asset('images/' . $staff->avatar) }}"
                            @else
                                src="{{ $staff->gender == 'male' ? asset('assets/img/avatars/male.png') : asset('assets/img/avatars/female.png') }}" @endif
                                height="120" width="120" alt="{{ $staff->first_name . ' ' . $staff->last_name }}" />
                            <div class="user-info text-center">
                                <h5>{{ $staff->first_name . ' ' . $staff->last_name }}</h5>
                                {{-- <span class="badge bg-label-danger">{{$staff->role->name}}</span> --}}
                                <span class="badge bg-label-danger">{{ $staff->role->name }} Operative</span> <br>
                                <span class="badge bg-label-info"><a
                                        href="tel:+234{{ $staff->phone_number }}">{{ $staff->phone_number }}</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">
                        <div class="d-flex align-items-center me-5 gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class='ti ti-checkbox ti-lg'></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">0</h5>
                                <span>Training Done</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-primary rounded">
                                    <i class='ti ti-briefcase ti-lg'></i>
                                </div>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $staff->shiftsWithNoExpires()->count() }}</h5>
                                <span>Posted</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            @if ($staff->user)
                                <li class="mb-2">
                                    <span class="h6">Username:</span>
                                    <span>{{ $staff->user->name }}</span>
                                </li>
                            @endif
                            <li class="mb-2">
                                <span class="h6">Contact:</span>
                                <span>{{ $staff->phone_number }}</span>
                            </li>
                            @if ($staff->email)
                                <li class="mb-2">
                                    <span class="h6">Email:</span>
                                    <span>{{ $staff->email ?? '' }}</span>
                                </li>
                            @endif
                            @if (!$staff->graduated)
                                <li class="mb-2">
                                    <span class="h6">Status:</span>
                                    <span>{{ $staff->beat_id == null || $staff->beat_branch_id == null ? 'Inactive' : 'Active' }}</span>
                                </li>
                            @endif
                            @if ($staff->graduated)
                                <li class="mb-2">
                                    <span class="h6">Status:</span>
                                    <span>Graduated</span>
                                </li>
                            @endif
                            <li class="mb-2">
                                <span class="h6">Role:</span>
                                <span>{{ $staff->role->name }}</span>
                            </li>



                            <li class="mb-2">
                                <span class="h6">Address:</span>
                                <span>{{ $staff->address . ' ' . $staff->area }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">City/State:</span>
                                <span>{{ $staff->city . ' ' . $staff->state }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-primary me-4" data-bs-target="#editStaff"
                                data-bs-toggle="modal">Edit</a>
                            <a href="javascript:;"
                                class="btn {{ $staff->graduated ? 'btn-label-info' : 'btn-label-danger' }} graduate-staff me-4"
                                data-user-id="{{ $staff->id }}">{{ $staff->graduated ? 'Graduated' : 'Graduate' }}</a>
                            @if (!isset($staff->graduated))

                                <a href="javascript:;"
                                    class="btn {{ $staff->beat_id == null || $staff->beat_branch_id == null ? 'btn-label-info' : 'btn-label-secondary' }} {{ $staff->graduated ? '' : 'assign-user' }}"
                                    data-bs-target="#assignOperative" data-bs-toggle="modal">
                                    @if ($staff->beat_id == null || $staff->beat_branch_id == null)
                                        Assign
                                    @else
                                        Re- Assign
                                    @endif
                                </a>
                            @endif
                            {{-- @if (!isset($staff->graduated))

                          <a href="#" class="btn btn-label-danger" onclick="confirmDelete(event)">
                            Delete
                        </a>
                            @endif

                            <form id="deleteForm" action="{{ route('staff.delete') }}" method="POST" style="display: none;">
                              @csrf
                             <input type="text" name="staff_id" value="{{$staff->id}}">
                             <input type="text" name="full_name" value="{{$staff->first_name}} {{$staff->last_name}}">
                          </form> --}}

                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->

        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 order-0 order-md-1">
            <!-- User Pills -->

            <!--/ User Pills -->

            @yield('operative-content')



        </div>
        <!--/ User Content -->
    </div>

    <!-- Modal -->
    @include('radius/_modal/modal-edit-staff')
    @include('radius/_modal/modal-assign-staff')
    {{-- @include('_partials/_modals/modal-upgrade-plan') --}}
    <!-- /Modal -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Hide "Choose Location" initially
            $('.beatBranch').parent().hide();

            // Populate "Choose Location" based on the selected Beat
            $('#chooseBeat').change(function() {
                var beatId = $(this).val();
                if (beatId) {
                    // Fetch locations based on the beatId (Assuming you have an endpoint to fetch locations)
                    $.ajax({
                        url: '{{ url('getBeatBranch') }}/' + beatId, // Adjust URL as necessary
                        type: 'GET',
                        success: function(locations) {
                            var locationSelect = $('#chooseBeatBranch');
                            locationSelect.empty();
                            locationSelect.append('<option value="">Choose Branch</option>');
                            $.each(locations, function(key, value) {
                                locationSelect.append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            $('.beatBranch').parent().show();
                        }
                    });
                } else {
                    $('.beatBranch').parent().hide();
                }
            });

            // Toggle "Shift Expire" visibility based on "Permanent" checkbox
            $('input[name="main_assign"]').change(function() {
                if ($(this).is(':checked')) {
                    $('#setExpires').parent().hide();
                } else {
                    $('#setExpires').parent().show();
                }
            });

            // Initial check for "Permanent" checkbox on page load
            if ($('input[name="main_assign"]').is(':checked')) {
                $('#setExpires').parent().hide();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelAssignmentLinks = document.querySelectorAll('.cancel-assignment');

            if (cancelAssignmentLinks) {
                cancelAssignmentLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        const shiftId = this.getAttribute('data-shift-id');
                        const staffId = this.getAttribute('data-staff-id');

                        Swal.fire({
                            title: 'Cancel Assignment',
                            html: `
                        <form id="cancelAssignmentForm">
                          <div class="row g-6">
                              <div class="col-sm-12">
                                <label for="comment" class="form-label">Comment</label>
                                <textarea id="comment" name="comment" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="rating" class="form-label">Rating</label>
                                <select id="rating" name="rating" class="form-select">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            </div>
                        </form>
                    `,
                            focusConfirm: false,
                            showCancelButton: true,
                            confirmButtonText: 'Submit',
                            customClass: {
                                confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                            },
                            buttonsStyling: false,
                            preConfirm: () => {
                                const comment = document.getElementById('comment')
                                    .value;
                                const date = document.getElementById('date').value;
                                const rating = document.getElementById('rating').value;

                                // if (!comment || !date || !rating) {
                                //     Swal.showValidationMessage('All fields are required');
                                //     return false;
                                // }

                                if (!rating) {
                                    Swal.showValidationMessage('Rating is required');
                                    return false;
                                }

                                return {
                                    comment: comment,
                                    date: date,
                                    rating: rating
                                };
                            }
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                const formData = {
                                    _token: '{{ csrf_token() }}',
                                    shift_id: shiftId,
                                    staff_id: staffId,
                                    comment: result.value.comment,
                                    date: result.value.date,
                                    rating: result.value.rating
                                };

                                $.ajax({
                                    url: '{{ route('shift.cancel') }}',
                                    type: 'POST',
                                    data: formData,
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Cancelled!',
                                                text: 'Assignment cancelled successfully.',
                                                customClass: {
                                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                                }
                                            }).then(function() {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Failed',
                                                text: 'Failed to cancel assignment.',
                                                customClass: {
                                                    confirmButton: 'btn btn-danger waves-effect waves-light'
                                                }
                                            });
                                        }
                                    }
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: 'Cancelled',
                                    text: 'Cancellation aborted!',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            }
                        });
                    });
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteAssignmentLinks = document.querySelectorAll('.delete-assignment');

            if (deleteAssignmentLinks) {
                deleteAssignmentLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        const shiftId = this.getAttribute('data-shift-id');
                        const staffId = this.getAttribute('data-staff-id');

                        Swal.fire({
                            title: 'Delete Assignment',
                            text: 'Are you sure you want to delete this assignment?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            customClass: {
                                confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                            },
                            buttonsStyling: false,
                            preConfirm: () => {
                                return {
                                    shift_id: shiftId,
                                    staff_id: staffId
                                };
                            }
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                const formData = {
                                    _token: '{{ csrf_token() }}',
                                    shift_id: result.value.shift_id,
                                    staff_id: result.value.staff_id
                                };

                                $.ajax({
                                    url: '{{ route('shift.delete') }}',
                                    type: 'POST',
                                    data: formData,
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Deleted!',
                                                text: 'Assignment deleted successfully.',
                                                customClass: {
                                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                                }
                                            }).then(function() {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Failed',
                                                text: 'Failed to delete assignment.',
                                                customClass: {
                                                    confirmButton: 'btn btn-danger waves-effect waves-light'
                                                }
                                            });
                                        }
                                    }
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: 'Cancelled',
                                    text: 'Deletion aborted!',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            }
                        });
                    });
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const suspendUser = document.querySelector('.graduate-staff');

        // Graduate Operative javascript
        if (suspendUser) {
            suspendUser.onclick = function() {
                const userId = suspendUser.getAttribute('data-user-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Graduate Operative!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                    },
                    buttonsStyling: false,
                    html: '<label for="graduation-date">Graduation Date:</label>' +
                        '<input type="date" id="graduation-date" class="swal2-input">',
                    preConfirm: () => {
                        const graduationDate = document.getElementById('graduation-date').value;
                        if (!graduationDate) {
                            Swal.showValidationMessage('Please select a graduation date');
                        }
                        return graduationDate;
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        const graduationDate = result.value;
                        // AJAX call to graduate staff
                        $.ajax({
                            url: '{{ route('staff.graduate') }}', // Adjust the route to your actual route
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                staff_id: userId,
                                graduation_date: graduationDate
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Graduated!',
                                        text: 'Operative has been graduated.',
                                        customClass: {
                                            confirmButton: 'btn btn-success waves-effect waves-light'
                                        }
                                    }).then(() => {
                                        location.reload(); // Reload the page after success
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Failed to graduate staff.',
                                        icon: 'error',
                                        customClass: {
                                            confirmButton: 'btn btn-success waves-effect waves-light'
                                        }
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Failed to graduate staff.',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect waves-light'
                                    }
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'Cancelled Graduation :)',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect waves-light'
                            }
                        });
                    }
                });
            };
        }
    </script>

{{-- <script>
  document.addEventListener('DOMContentLoaded', function () {
      let deleteButton = document.querySelector('#confirmDeleteButton');
      let rowId;

      // Capture the ID when the modal is triggered
      document.querySelectorAll('a[data-bs-toggle="modal"]').forEach(function (element) {
          element.addEventListener('click', function () {
              rowId = element.getAttribute('data-id');
          });
      });

      // Handle the delete action when the user confirms
      deleteButton.addEventListener('click', function () {
          // You can now emit the Livewire event or make an AJAX request to delete the record
          Livewire.emit('delete', rowId);

          // Optionally, close the modal
          let deleteModal = new bootstrap.Modal(document.getElementById('deleteOperativeModal'));
          deleteModal.hide();
      });
  });
</script> --}}

<script>
  function confirmDelete(event) {
      event.preventDefault();
      if (confirm("Are you sure you want to delete this operative?")) {
          document.getElementById('deleteForm').submit();
      }
  }
  </script>


@endsection
