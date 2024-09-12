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
        <h5 class="card-header">Operative Details</h5>
        <form action="{{ route('staff.store') }}" method="POST" class="card-body" id="addStaffForm"
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
                    <input type="text" class="form-control" id="add-user-lastname" placeholder="John Doe"
                        name="last_name" aria-label="John Doe" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-email">Email</label>
                    <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                        aria-label="john.doe@example.com" name="email" />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-contact">Contact</label>
                    <input type="text" id="add-user-contact" class="form-control" placeholder="0809 988 0000"
                        aria-label="08070000000" name="phone_number" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-gender">Gender</label>
                    <select id="add-gender" name="gender" class="form-select" required>
                        <option value="binary">Select</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select>
                </div>


                <div>
                    <label for="exampleFormControlTextarea1" class="form-label">Address</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"
                        placeholder="52, Fleming Avenue" required></textarea>
                </div>


                <div class="col-md-4">
                    <label class="form-label" for="add-user-area">Area</label>
                    <input type="text" id="add-user-area" class="form-control" placeholder="Rumumaosi"
                        aria-label="Rumumaosi" name="area" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-city">City</label>
                    <input type="text" id="add-user-city" class="form-control" placeholder="Port Harcourt"
                        aria-label="PH" name="city" required />
                </div>
                <div class="col-md-4">
                    <label for="selectpickerLiveSearch" class="form-label">State</label>
                    <select id="selectpickerLiveSearch" class="form-select selectpicker w-100" name="state"
                        data-style="btn-default" data-live-search="true" required>
                        <option data-tokens="none">Select</option>
                        @foreach ($states as $state)
                            <option data-tokens="{{ $state->name }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-date-birth">Date of Birth</label>
                    <input type="date" id="add-user-date-birth" class="form-control" name="date_of_birth" required />
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="add-user-join-date">Employment Date</label>
                    <input type="date" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" id="add-user-join-date"
                        class="form-control" name="hire_date" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-staff_no">Employment Number</label>
                    <input type="text" value="" id="add-user-staff_no" class="form-control" name="staff_no" />
                </div>

                {{-- <div class="col-md-4">
                    <label class="form-label" for="add-role">Staff Role</label>
                    <select id="add-role" name="role_id" class="form-select">
                        <option value="none">Select</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-md-4">
                    <label class="form-label" for="profile_image">Choose Image</label>
                    <input type="file" id="profile_image" class="form-control" name="avatar" accept="image/*" />
                    <br>
                    <img id="imagePreview" src="#" height="150" style="display: none;" alt="Image Preview">
                    <br>
                    <button type="button" id="deleteImageButton" style="display: none;">Delete Image</button>
                </div>

                <div class="pt-6">
                    <a href="javascript:;" class="btn btn-info me-4" id="addGuarantorBtn"
                        data-bs-target="#modalGuarantor" data-bs-toggle="modal">Guarantor</a>
                </div>

                <!-- Hidden Guarantor Fields -->
                <input type="hidden" name="guarantor_fname" id="guarantor_fname">
                <input type="hidden" name="guarantor_mname" id="guarantor_mname">
                <input type="hidden" name="guarantor_lname" id="guarantor_lname">
                <input type="hidden" name="guarantor_phone" id="guarantor_phone">
                <input type="hidden" name="guarantor_email" id="guarantor_email">
                <input type="hidden" name="guarantor_address" id="guarantor_address">
                <input type="hidden" name="guarantor_avatar" id="guarantor_avatar">
                <input type="hidden" name="guarantor_ID" id="guarantor_ID">



                <!-- Guarantor Info Display (This will be updated when the modal is saved) -->
                <div id="guarantorInfo" style="display: none;">
                    <h6 class="mt-4">Guarantor One</h6>
                    <p><strong>Name:</strong> <span id="guarantorNameDisplay"></span></p>
                    <p><strong>Phone:</strong> <span id="guarantorPhoneDisplay"></span></p>
                    <p><strong>Email:</strong> <span id="guarantorEmailDisplay"></span></p>
                    <p><strong>Gender:</strong> <span id="guarantorGenderDisplay"></span></p>
                    <p><strong>Address:</strong> <span id="guarantorAddressDisplay"></span></p>
                </div>

                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>

        </form>


    </div>


    <!-- Modal -->
    @include('radius/_modal/modal-add-guarantor')

    <!-- /Modal -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileImageInput = document.getElementById('profile_image');
            const imagePreview = document.getElementById('imagePreview');
            const deleteImageButton = document.getElementById('deleteImageButton');

            // Function to preview the uploaded image
            profileImageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        deleteImageButton.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Function to delete the selected image
            deleteImageButton.addEventListener('click', function() {
                profileImageInput.value = ''; // Clear the input
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
                deleteImageButton.style.display = 'none';
            });
        });
    </script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
      const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
      const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
      const addGuarantorBtn = document.getElementById('addGuarantorBtn');

      // Handle saving guarantor data from the modal to the hidden fields in the main form
      saveGuarantorBtn.addEventListener('click', function() {
          const guarantorFName = document.getElementById('guarantor_first_name').value;
          const guarantorMName = document.getElementById('guarantor_middle_name').value;
          const guarantorLName = document.getElementById('guarantor_last_name').value;
          const guarantorPhone = document.getElementById('guarantor_phone_number').value;
          const guarantorGender = document.getElementById('guarantor_gender').value;
          const guarantorEmail = document.getElementById('guarantor_email').value;
          const guarantorAddress = document.getElementById('addressGuarantor').value;

          // Set hidden input values in the main form
          document.getElementById('guarantor_fname').value = guarantorFName;
          document.getElementById('guarantor_mname').value = guarantorMName;
          document.getElementById('guarantor_lname').value = guarantorLName;
          document.getElementById('guarantor_phone').value = guarantorPhone;
          document.getElementById('guarantor_address').value = guarantorAddress;



          // Update display section with guarantor information
          document.getElementById('guarantorNameDisplay').innerText = guarantorFName + ' ' + guarantorMName + ' ' + guarantorLName;
          document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
          document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
          document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
          document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

          // Show the Guarantor Info section
          document.getElementById('guarantorInfo').style.display = 'block';

          // // Show success message
          // guarantorSuccessMsg.style.display = 'block';

          // // Change the main button text to indicate a guarantor was saved
          // addGuarantorBtn.textContent = 'Guarantor Saved';

          // // Disable the save button after saving
          // saveGuarantorBtn.disabled = true;

          // // Close the modal after saving (with a delay for user feedback)
          // setTimeout(function() {
          //     const modalGuarantor = new bootstrap.Modal(document.getElementById(
          //         'modalGuarantor'));
          //     modalGuarantor.hide();
          //     guarantorSuccessMsg.style.display =
          //     'none'; // Hide the success message after modal closes
          // }, 1000); // Delay of 1 second

          // Show the Guarantor Info section
          document.getElementById('guarantorInfo').style.display = 'block';

          // Close the modal after saving
          const modalGuarantor = new bootstrap.Modal(document.getElementById('modalGuarantor'));
          modalGuarantor.hide();
      });
  });
</script>



@endsection
