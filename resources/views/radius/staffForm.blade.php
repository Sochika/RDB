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
                    <label class="form-label" for="add-user-middleName">Middle Name</label>
                    <input type="text" class="form-control" id="add-user-middleName" placeholder="Mike"
                        name="middle_name" aria-label="John Doe" />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-lastname">Last Name</label>
                    <input type="text" class="form-control" id="add-user-lastname" placeholder="John Doe"
                        name="last_name" aria-label="John Doe" required />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="add-user-email">Email</label>
                    <input type="email" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
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
                        <option value="">Select</option>
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

                <!-- Button to add first guarantor -->
                <div class="pt-6">
                    <a href="javascript:;" class="btn btn-info me-4" id="addGuarantorBtn">Add Guarantor 1</a>
                </div>

                <!-- First Guarantor Form Section (Initially hidden) -->
                <div id="guarantorForm1" style="display: none; margin-top: 20px;">
                    <h5>Guarantor 1 Information</h5>
                    <div class="row g-6">
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-firstName">First Name</label>
                            <input type="text" class="form-control" id="guarantor1-firstName" name="guarantor1_fname"
                                placeholder="First Name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-middleName">Middle Name</label>
                            <input type="text" class="form-control" id="guarantor1-middleName"
                                name="guarantor1_mname" placeholder="Middle Name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-lastName">Last Name</label>
                            <input type="text" class="form-control" id="guarantor1-lastName" name="guarantor1_lname"
                                placeholder="Last Name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-phone">Phone</label>
                            <input type="text" class="form-control" id="guarantor1-phone" name="guarantor1_phone"
                                placeholder="0809 988 0000" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-email">Email</label>
                            <input type="email" class="form-control" id="guarantor1-email" name="guarantor1_email"
                                placeholder="email@example.com" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-address">Address</label>
                            <textarea class="form-control" id="guarantor1-address" name="guarantor1_address" placeholder="Guarantor Address"></textarea>
                        </div>
                        <!-- Guarantor 1 Avatar -->
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-avatar">Guarantor 1 Avatar</label>
                            <input type="file" class="form-control" id="guarantor1-avatar" name="guarantor1_avatar"
                                accept="image/*" />
                            <br>
                            <img id="guarantor1-avatar-preview" src="#" alt="Guarantor 1 Avatar Preview"
                                style="display: none;" height="150">
                        </div>
                        <!-- Guarantor 1 ID -->
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor1-ID">Guarantor 1 ID (Image or PDF)</label>
                            <input type="file" class="form-control" id="guarantor1-ID" name="guarantor1_ID"
                                accept="image/*,application/pdf" />
                            <br>
                            <div id="guarantor1-ID-preview" style="display: none;">
                                <img id="guarantor1-ID-img-preview" src="#" alt="Guarantor 1 ID Image Preview"
                                    style="display: none;" height="150">
                                <p id="guarantor1-ID-pdf-preview" style="display: none;">PDF File Selected</p>
                            </div>
                        </div>
                    </div>

                    <!-- Button to add second guarantor after the first one is filled -->
                    <div class="pt-6">
                        <a href="javascript:;" class="btn btn-info me-4" id="addGuarantorBtn2"
                            style="display: none;">Add Guarantor 2</a>
                    </div>
                </div>

                <!-- Second Guarantor Form Section (Initially hidden) -->
                <div id="guarantorForm2" style="display: none; margin-top: 20px;">
                    <h5>Guarantor 2 Information</h5>

                    <div class="row g-6">
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-firstName">First Name</label>
                            <input type="text" class="form-control" id="guarantor2-firstName" name="guarantor2_fname"
                                placeholder="First Name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-middleName">Middle Name</label>
                            <input type="text" class="form-control" id="guarantor2-middleName"
                                name="guarantor2_mname" placeholder="Middle Name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-lastName">Last Name</label>
                            <input type="text" class="form-control" id="guarantor2-lastName" name="guarantor2_lname"
                                placeholder="Last Name" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-phone">Phone</label>
                            <input type="text" class="form-control" id="guarantor2-phone" name="guarantor2_phone"
                                placeholder="0809 988 0000" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-email">Email</label>
                            <input type="email" class="form-control" id="guarantor2-email" name="guarantor2_email"
                                placeholder="email@example.com" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-address">Address</label>
                            <textarea class="form-control" id="guarantor2-address" name="guarantor2_address" placeholder="Guarantor Address"></textarea>
                        </div>
                        <!-- Guarantor 2 Avatar -->
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-avatar">Guarantor 2 Avatar</label>
                            <input type="file" class="form-control" id="guarantor2-avatar" name="guarantor2_avatar"
                                accept="image/*" />
                            <br>
                            <img id="guarantor2-avatar-preview" src="#" alt="Guarantor 2 Avatar Preview"
                                style="display: none;" height="150">
                        </div>
                        <!-- Guarantor 2 ID -->
                        <div class="col-md-4">
                            <label class="form-label" for="guarantor2-ID">Guarantor 2 ID (Image or PDF)</label>
                            <input type="file" class="form-control" id="guarantor2-ID" name="guarantor2_ID"
                                accept="image/*,application/pdf" />
                            <br>
                            <div id="guarantor2-ID-preview" style="display: none;">
                                <img id="guarantor2-ID-img-preview" src="#" alt="Guarantor 2 ID Image Preview"
                                    style="display: none;" height="150">
                                <p id="guarantor2-ID-pdf-preview" style="display: none;">PDF File Selected</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="btn btn-primary me-4">Submit</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
            </div>
        </form>
    </div>


    <!-- Modal -->
    {{-- @include('radius/_modal/modal-add-guarantor') --}}

    <!-- /Modal -->


    <script>
        document.getElementById('profile_image').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                    document.getElementById('deleteImageButton').style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelector('form').addEventListener('reset', function() {
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('deleteImageButton').style.display = 'none';
        });

        document.getElementById('deleteImageButton').addEventListener('click', function() {
            document.getElementById('profile_image').value = ''; // Clear the input field
            document.getElementById('imagePreview').style.display = 'none'; // Hide the preview
            document.getElementById('deleteImageButton').style.display = 'none'; // Hide the delete button
        });


        // Show Guarantor 1 form when the first button is clicked
        document.getElementById('addGuarantorBtn').addEventListener('click', function() {
            const guarantorForm1 = document.getElementById('guarantorForm1');
            guarantorForm1.style.display = 'block'; // Show the first guarantor form
            this.style.display = 'none'; // Hide the 'Add Guarantor 1' button

            // Show the 'Add Guarantor 2' button after Guarantor 1 form is displayed
            const addGuarantorBtn2 = document.getElementById('addGuarantorBtn2');
            addGuarantorBtn2.style.display = 'block';
        });

        // Show Guarantor 2 form when the second button is clicked
        document.getElementById('addGuarantorBtn2').addEventListener('click', function() {
            const guarantorForm2 = document.getElementById('guarantorForm2');
            guarantorForm2.style.display = 'block'; // Show the second guarantor form
            this.style.display = 'none'; // Hide the 'Add Guarantor 2' button
        });



        document.getElementById('guarantor1-avatar').addEventListener('change', function(event) {
            previewImage(event, 'guarantor1-avatar-preview');
        });

        document.getElementById('guarantor2-avatar').addEventListener('change', function(event) {
            previewImage(event, 'guarantor2-avatar-preview');
        });

        document.getElementById('guarantor1-ID').addEventListener('change', function(event) {
            previewFile(event, 'guarantor1-ID-preview', 'guarantor1-ID-img-preview', 'guarantor1-ID-pdf-preview');
        });

        document.getElementById('guarantor2-ID').addEventListener('change', function(event) {
            previewFile(event, 'guarantor2-ID-preview', 'guarantor2-ID-img-preview', 'guarantor2-ID-pdf-preview');
        });

        // Function to preview image
        function previewImage(event, imageElementId) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewElement = document.getElementById(imageElementId);
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Function to preview image or PDF for IDs
        function previewFile(event, previewContainerId, imgElementId, pdfElementId) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById(previewContainerId);
            const imgElement = document.getElementById(imgElementId);
            const pdfElement = document.getElementById(pdfElementId);

            if (file) {
                const reader = new FileReader();
                previewContainer.style.display = 'block';

                // Check if the file is an image
                if (file.type.startsWith('image/')) {
                    reader.onload = function(e) {
                        imgElement.src = e.target.result;
                        imgElement.style.display = 'block';
                        pdfElement.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
                // Check if the file is a PDF
                else if (file.type === 'application/pdf') {
                    imgElement.style.display = 'none';
                    pdfElement.style.display = 'block';
                }
            }
        }




        // document.addEventListener('DOMContentLoaded', function() {
        //     const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
        //     const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
        //     const addGuarantorBtn = document.getElementById('addGuarantorBtn');
        //     const guarantorInfo = document.getElementById('guarantorInfo');

        //     // Function to handle the file input
        //     function getBase64(file, callback) {
        //         const reader = new FileReader();
        //         reader.onload = function() {
        //             callback(reader.result);
        //         };
        //         reader.onerror = function(error) {
        //             console.log('Error: ', error);
        //         };
        //         if (file) {
        //             reader.readAsDataURL(file);
        //         } else {
        //             callback(null);
        //         }
        //     }

        //     // Function to populate guarantor information from localStorage
        //     function populateGuarantorFromLocalStorage() {
        //         const storedGuarantor = localStorage.getItem('guarantorData');
        //         if (storedGuarantor) {
        //             const guarantorData = JSON.parse(storedGuarantor);

        //             // Populate the display section with stored data
        //             document.getElementById('guarantorNameDisplay').innerText =
        //                 `${guarantorData.firstName} ${guarantorData.middleName} ${guarantorData.lastName}`;
        //             document.getElementById('guarantorPhoneDisplay').innerText = guarantorData.phoneNumber;
        //             document.getElementById('guarantorGenderDisplay').innerText = guarantorData.gender;
        //             document.getElementById('guarantorEmailDisplay').innerText = guarantorData.email;
        //             document.getElementById('guarantorAddressDisplay').innerText = guarantorData.address;

        //             // Display avatar if available
        //             if (guarantorData.avatar) {
        //                 document.getElementById('guarantorAvatarDisplay').src = guarantorData.avatar;
        //                 document.getElementById('guarantorAvatarDisplay').style.display = 'block';
        //             } else {
        //                 document.getElementById('guarantorAvatarDisplay').style.display = 'none';
        //             }

        //             // Display credential link or text if available
        //             if (guarantorData.credential) {
        //                 document.getElementById('guarantorCredentialDisplay').innerHTML =
        //                     `<a href="${guarantorData.credential}" download>Download Credential</a>`;
        //             } else {
        //                 document.getElementById('guarantorCredentialDisplay').innerHTML = '';
        //             }

        //             // Show the Guarantor Info section
        //             guarantorInfo.style.display = 'block';
        //             addGuarantorBtn.textContent = 'Guarantor Saved';
        //             guarantorSuccessMsg.style.display = 'block';
        //         }
        //     }

        //     // Call this function when the page loads
        //     populateGuarantorFromLocalStorage();

        //     // Handle saving guarantor data from the modal to the hidden fields and localStorage
        //     saveGuarantorBtn.addEventListener('click', function() {
        //         const guarantorFName = document.getElementById('guarantor_first_name').value;
        //         const guarantorMName = document.getElementById('guarantor_middle_name').value;
        //         const guarantorLName = document.getElementById('guarantor_last_name').value;
        //         const guarantorPhone = document.getElementById('guarantor_phone_number').value;
        //         const guarantorGender = document.getElementById('guarantor_gender').value;
        //         const guarantorEmail = document.getElementById('guarantor_email').value;
        //         const guarantorAddress = document.getElementById('addressGuarantor').value;
        //         const guarantorAvatarFile = document.getElementById('avatarGuarantor').files[
        //             0]; // Avatar file
        //         const credentialGuarantorFile = document.getElementById('credentialGuarantor').files[
        //             0]; // Credential file

        //         // Get avatar base64 and credential as a downloadable link
        //         getBase64(guarantorAvatarFile, function(avatarBase64) {
        //             const guarantorData = {
        //                 firstName: guarantorFName,
        //                 middleName: guarantorMName,
        //                 lastName: guarantorLName,
        //                 phoneNumber: guarantorPhone,
        //                 gender: guarantorGender,
        //                 email: guarantorEmail,
        //                 address: guarantorAddress,
        //                 avatar: avatarBase64,
        //                 credential: credentialGuarantorFile ? URL.createObjectURL(
        //                     credentialGuarantorFile) : ''
        //             };

        //             localStorage.setItem('guarantorData', JSON.stringify(guarantorData));

        //             // Update display section with guarantor information
        //             document.getElementById('guarantorNameDisplay').innerText =
        //                 `${guarantorFName} ${guarantorMName} ${guarantorLName}`;
        //             document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
        //             document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
        //             document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
        //             document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

        //             // Display avatar
        //             if (avatarBase64) {
        //                 document.getElementById('guarantorAvatarDisplay').src = avatarBase64;
        //                 document.getElementById('guarantorAvatarDisplay').style.display = 'block';
        //             } else {
        //                 document.getElementById('guarantorAvatarDisplay').style.display = 'none';
        //             }

        //             // Display credential
        //             if (credentialGuarantorFile) {
        //                 document.getElementById('guarantorCredentialDisplay').innerHTML =
        //                     `<a href="${URL.createObjectURL(credentialGuarantorFile)}" download>Download Credential</a>`;
        //             } else {
        //                 document.getElementById('guarantorCredentialDisplay').innerHTML = '';
        //             }

        //             // Show the Guarantor Info section
        //             guarantorInfo.style.display = 'block';

        //             // Show success message
        //             guarantorSuccessMsg.style.display = 'block';
        //         });
        //     });
        // });
    </script>


    {{--
    <script>
        //     document.addEventListener('DOMContentLoaded', function() {
        //         const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
        //         const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
        //         const addGuarantorBtn = document.getElementById('addGuarantorBtn');
        //         const guarantorInfo = document.getElementById('guarantorInfo');

        //         // Function to populate guarantor information from localStorage
        //         function populateGuarantorFromLocalStorage() {
        //             const storedGuarantor = localStorage.getItem('guarantorData');
        //             if (storedGuarantor) {
        //                 const guarantorData = JSON.parse(storedGuarantor);

        //                 // Populate the display section with stored data
        //                 document.getElementById('guarantorNameDisplay').innerText = guarantorData.firstName + ' ' +
        //                     guarantorData.middleName + ' ' + guarantorData.lastName;
        //                 document.getElementById('guarantorPhoneDisplay').innerText = guarantorData.phoneNumber;
        //                 document.getElementById('guarantorGenderDisplay').innerText = guarantorData.gender;
        //                 document.getElementById('guarantorEmailDisplay').innerText = guarantorData.email;
        //                 document.getElementById('guarantorAddressDisplay').innerText = guarantorData.address;

        //                 // Display avatar if available
        //                 if (guarantorData.avatar) {
        //                     document.getElementById('guarantorAvatarDisplay').src = guarantorData.avatar;
        //                     document.getElementById('guarantorAvatarDisplay').style.display = 'block';
        //                 }

        //                 // Display credential link or text if available
        //                 if (guarantorData.credential) {
        //                     document.getElementById('guarantorCredentialDisplay').innerHTML =
        //                         `<a href="${guarantorData.credential}" download>Download Credential</a>`;
        //                 }

        //                 // Show the Guarantor Info section
        //                 guarantorInfo.style.display = 'block';
        //                 addGuarantorBtn.textContent = 'Guarantor Saved';
        //             }
        //         }

        //         // Call this function when the page loads
        //         populateGuarantorFromLocalStorage();

        //         // Handle saving guarantor data from the modal to the hidden fields and localStorage
        //         saveGuarantorBtn.addEventListener('click', function() {
        //             const guarantorFName = document.getElementById('guarantor_first_name').value;
        //             const guarantorMName = document.getElementById('guarantor_middle_name').value;
        //             const guarantorLName = document.getElementById('guarantor_last_name').value;
        //             const guarantorPhone = document.getElementById('guarantor_phone_number').value;
        //             const guarantorGender = document.getElementById('guarantor_gender').value;
        //             const guarantorEmail = document.getElementById('guarantor_email').value;
        //             const guarantorAddress = document.getElementById('addressGuarantor').value;
        //             const guarantorAvatar = document.getElementById('avatarGuarantor')
        //                 .value; // Avatar file URL or base64
        //             const credentialGuarantor = document.getElementById('credentialGuarantor')
        //                 .value; // Credential file URL or text

        //             // Store the data in localStorage
        //             const guarantorData = {
        //                 firstName: guarantorFName,
        //                 middleName: guarantorMName,
        //                 lastName: guarantorLName,
        //                 phoneNumber: guarantorPhone,
        //                 gender: guarantorGender,
        //                 email: guarantorEmail,
        //                 address: guarantorAddress,
        //                 avatar: guarantorAvatar,
        //                 credential: credentialGuarantor
        //             };
        //             localStorage.setItem('guarantorData', JSON.stringify(guarantorData));

        //             // Reset the refresh count after saving data
        //             localStorage.setItem('refreshCount', '0');

        //             // Update display section with guarantor information
        //             document.getElementById('guarantorNameDisplay').innerText = guarantorFName + ' ' +
        //                 guarantorMName + ' ' + guarantorLName;
        //             document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
        //             document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
        //             document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
        //             document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

        //             // Display avatar
        //             if (guarantorAvatar) {
        //                 document.getElementById('guarantorAvatarDisplay').src = guarantorAvatar;
        //                 document.getElementById('guarantorAvatarDisplay').style.display = 'block';
        //             }

        //             // Display credential
        //             if (credentialGuarantor) {
        //                 document.getElementById('guarantorCredentialDisplay').innerHTML =
        //                     `<a href="${credentialGuarantor}" download>Download Credential</a>`;
        //             }

        //             // Show the Guarantor Info section
        //             guarantorInfo.style.display = 'block';

        //             // Show success message
        //             guarantorSuccessMsg.style.display = 'block';

        //             // Change the main button text to indicate a guarantor was saved
        //             addGuarantorBtn.textContent = 'Guarantor Saved';

        //             // Disable the save button after saving
        //             saveGuarantorBtn.disabled = true;

        //             // Optionally close the modal after saving (with a delay for user feedback)
        //             setTimeout(function() {
        //                 guarantorSuccessMsg.style.display = 'none';
        //             }, 5000); // Delay of 5 seconds
        //         });

        //         // Function to handle clearing data after two page refreshes
        //         function handleRefreshCount() {
        //             let refreshCount = localStorage.getItem('refreshCount');

        //             if (refreshCount) {
        //                 refreshCount = parseInt(refreshCount) + 1;
        //             } else {
        //                 refreshCount = 1;
        //             }

        //             // Update the refresh count in localStorage
        //             localStorage.setItem('refreshCount', refreshCount);

        //             // If the page has been refreshed twice, clear the guarantor data
        //             if (refreshCount >= 2) {
        //                 localStorage.removeItem('guarantorData');
        //                 localStorage.removeItem('refreshCount');
        //                 console.log('Guarantor data and refresh count cleared after two refreshes.');
        //             }
        //         }

        //         // Call the function to check and handle refresh count
        //         handleRefreshCount();
        //     });
        //
    </script> --}}
    {{-- <script>
    //     document.addEventListener('DOMContentLoaded', function() {
    //         const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
    //         const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
    //         const addGuarantorBtn = document.getElementById('addGuarantorBtn');

    //         // Handle saving guarantor data from the modal to the hidden fields in the main form
    //         saveGuarantorBtn.addEventListener('click', function() {
    //             const guarantorFName = document.getElementById('guarantor_first_name').value;
    //             const guarantorMName = document.getElementById('guarantor_middle_name').value;
    //             const guarantorLName = document.getElementById('guarantor_last_name').value;
    //             const guarantorPhone = document.getElementById('guarantor_phone_number').value;
    //             const guarantorGender = document.getElementById('guarantor_gender').value;
    //             const guarantorEmail = document.getElementById('guarantor_email').value;
    //             const guarantorAddress = document.getElementById('addressGuarantor').value;

    //             // Set hidden input values in the main form
    //             document.getElementById('guarantor_fname').value = guarantorFName;
    //             document.getElementById('guarantor_mname').value = guarantorMName;
    //             document.getElementById('guarantor_lname').value = guarantorLName;
    //             document.getElementById('guarantor_phone').value = guarantorPhone;
    //             document.getElementById('guarantor_address').value = guarantorAddress;

    //             // Update display section with guarantor information
    //             document.getElementById('guarantorNameDisplay').innerText = guarantorFName + ' ' +
    //                 guarantorMName + ' ' + guarantorLName;
    //             document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
    //             document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
    //             document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
    //             document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

    //             // Show the Guarantor Info section
    //             document.getElementById('guarantorInfo').style.display = 'block';

    //             // Optional: Show success message
    //             guarantorSuccessMsg.style.display = 'block';

    //             // Optional: Change the main button text to indicate a guarantor was saved
    //             addGuarantorBtn.textContent = 'Guarantor Saved';

    //             // Optional: Disable the save button after saving
    //             saveGuarantorBtn.disabled = true;

    //             // Optional: Close the modal after saving (with a delay for user feedback)
    //             setTimeout(function() {
    //                 const modalGuarantor = new bootstrap.Modal(document.getElementById(
    //                     'modalGuarantor'));
    //                 modalGuarantor.hide();
    //                 guarantorSuccessMsg.style.display =
    //                 'none'; // Hide the success message after modal closes
    //             }, 1000); // Delay of 1 second
    //         });
    //     });
    // </script>

    // {{-- <script>
    //     document.addEventListener('DOMContentLoaded', function() {
    //         const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
    //         const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
    //         const addGuarantorBtn = document.getElementById('addGuarantorBtn');

    //         saveGuarantorBtn.addEventListener('click', function() {
    //             const guarantorFName = document.getElementById('guarantor_first_name');
    //             const guarantorMName = document.getElementById('guarantor_middle_name');
    //             const guarantorLName = document.getElementById('guarantor_last_name');
    //             const guarantorPhone = document.getElementById('guarantor_phone_number');
    //             const guarantorGender = document.getElementById('guarantor_gender');
    //             const guarantorEmail = document.getElementById('guarantor_email');
    //             const guarantorAddress = document.getElementById('addressGuarantor');

    //             // Set hidden input values in the main form
    //             document.getElementById('guarantor_fname').value = guarantorFName;
    //             document.getElementById('guarantor_mname').value = guarantorMName;
    //             document.getElementById('guarantor_lname').value = guarantorLName;
    //             document.getElementById('guarantor_phone').value = guarantorPhone;
    //             document.getElementById('guarantor_address').value = guarantorAddress;

    //             // Update display section with guarantor information
    //             document.getElementById('guarantorNameDisplay').innerText = guarantorFName + ' ' +
    //                 guarantorMName + ' ' + guarantorLName;
    //             document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
    //             document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
    //             document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
    //             document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

    //             // Show the Guarantor Info section
    //             document.getElementById('guarantorInfo').style.display = 'block';

    //             // Optional: Show success message
    //             guarantorSuccessMsg.style.display = 'block';

    //             // Optional: Change the main button text to indicate a guarantor was saved
    //             addGuarantorBtn.textContent = 'Guarantor Saved';

    //             // Optional: Disable the save button after saving
    //             saveGuarantorBtn.disabled = true;

    //             // Optional: Close the modal after saving (with a delay for user feedback)
    //             setTimeout(function() {
    //                 const modalGuarantor = new bootstrap.Modal(document.getElementById(
    //                     'modalGuarantor'));
    //                 modalGuarantor.hide();
    //                 guarantorSuccessMsg.style.display =
    //                 'none'; // Hide the success message after modal closes
    //             }, 1000); // Delay of 1 second
    //         });
    //     });
    //     document.addEventListener('DOMContentLoaded', function() {
    //         const saveGuarantorBtn = document.getElementById('saveGuarantorBtn');
    //         const guarantorSuccessMsg = document.getElementById('guarantorSuccessMsg');
    //         const addGuarantorBtn = document.getElementById('addGuarantorBtn');
    //         const guarantorInfo = document.getElementById('guarantorInfo');

    //         // Handle saving guarantor data from the modal to the hidden fields in the main form
    //         saveGuarantorBtn.addEventListener('click', function() {
    //             const guarantorFName = document.getElementById('guarantor_first_name').value;
    //             const guarantorMName = document.getElementById('guarantor_middle_name').value;
    //             const guarantorLName = document.getElementById('guarantor_last_name').value;
    //             const guarantorPhone = document.getElementById('guarantor_phone_number').value;
    //             const guarantorGender = document.getElementById('guarantor_gender').value;
    //             const guarantorEmail = document.getElementById('guarantor_email').value;
    //             const guarantorAddress = document.getElementById('addressGuarantor').value;

    //             // Set hidden input values in the main form
    //             document.getElementById('guarantor_fname').value = guarantorFName;
    //             document.getElementById('guarantor_mname').value = guarantorMName;
    //             document.getElementById('guarantor_lname').value = guarantorLName;
    //             document.getElementById('guarantor_phone').value = guarantorPhone;
    //             document.getElementById('guarantor_address').value = guarantorAddress;

    //             // Update display section with guarantor information
    //             document.getElementById('guarantorNameDisplay').innerText = guarantorFName + ' ' +
    //                 guarantorMName + ' ' + guarantorLName;
    //             document.getElementById('guarantorPhoneDisplay').innerText = guarantorPhone;
    //             document.getElementById('guarantorGenderDisplay').innerText = guarantorGender;
    //             document.getElementById('guarantorEmailDisplay').innerText = guarantorEmail;
    //             document.getElementById('guarantorAddressDisplay').innerText = guarantorAddress;

    //             // Show the Guarantor Info section
    //             guarantorInfo.style.display = 'block';

    //             // Optional: Show success message
    //             guarantorSuccessMsg.style.display = 'block';

    //             // Optional: Change the main button text to indicate a guarantor was saved
    //             addGuarantorBtn.textContent = 'Guarantor Saved';

    //             // Optional: Disable the save button after saving
    //             saveGuarantorBtn.disabled = true;

    //             // Optional: Close the modal after saving (with a delay for user feedback)
    //             setTimeout(function() {
    //                 const modalGuarantor = new bootstrap.Modal(document.getElementById(
    //                     'modalGuarantor'));
    //                 modalGuarantor.hide();
    //                 guarantorSuccessMsg.style.display =
    //                 'none'; // Hide the success message after modal closes
    //             }, 1000); // Delay of 1 second
    //         });

    //         // Optional: Hide the guarantor info section when resetting the form
    //         document.getElementById('addStaffForm').addEventListener('reset', function() {
    //             guarantorInfo.style.display = 'none';
    //             document.getElementById('guarantor_fname').value = '';
    //             document.getElementById('guarantor_mname').value = '';
    //             document.getElementById('guarantor_lname').value = '';
    //             document.getElementById('guarantor_phone').value = '';
    //             document.getElementById('guarantor_address').value = '';
    //             document.getElementById('guarantorNameDisplay').innerText = '';
    //             document.getElementById('guarantorPhoneDisplay').innerText = '';
    //             document.getElementById('guarantorGenderDisplay').innerText = '';
    //             document.getElementById('guarantorEmailDisplay').innerText = '';
    //             document.getElementById('guarantorAddressDisplay').innerText = '';
    //             addGuarantorBtn.textContent = 'Add Guarantor';
    //             saveGuarantorBtn.disabled = false;
    //         });
    //     });
    // </script> --}}

@endsection
