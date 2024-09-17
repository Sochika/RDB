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

                <hr>
                <!-- Button to add first guarantor -->
                <div class="pt-6" id="addGuarantorBtn1">
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
                    <div class="pt-6" id="addGuarantorBtn_2">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

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
            const addGuarantorBtn1 = document.getElementById('addGuarantorBtn1');
            guarantorForm1.style.display = 'block'; // Show the first guarantor form
            addGuarantorBtn1.style.display = 'none'; //  Hide the 'Add Guarantor 1' button
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
            const addGuarantorBtn2 = document.getElementById('addGuarantorBtn_2');
            addGuarantorBtn2.style.display = 'none';
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
                // else if (file.type === 'application/pdf') {
                //     imgElement.style.display = 'none';
                //     pdfCanvas.style.display = 'block';

                //     const fileURL = URL.createObjectURL(file);

                //     // Use PDF.js to render the PDF
                //     const loadingTask = pdfjsLib.getDocument(fileURL);
                //     loadingTask.promise.then(function(pdf) {
                //         // Fetch the first page
                //         pdf.getPage(1).then(function(page) {
                //             const scale = 1.5;
                //             const viewport = page.getViewport({
                //                 scale: scale
                //             });
                //             const context = pdfCanvas.getContext('2d');
                //             pdfCanvas.height = viewport.height;
                //             pdfCanvas.width = viewport.width;

                //             // Render PDF page into the canvas context
                //             const renderContext = {
                //                 canvasContext: context,
                //                 viewport: viewport
                //             };
                //             page.render(renderContext);
                //         });
                //     });
                // }
            }
        }
    </script>
    <script>
        // Function to set the default date and minimum date to 18 years earlier
        function setDOBRestrictions() {
            const dateInput = document.getElementById('add-user-date-birth');
            const today = new Date();

            // Subtract 18 years from the current date
            const minDOB = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

            // Format the date to YYYY-MM-DD
            const year = minDOB.getFullYear();
            const month = String(minDOB.getMonth() + 1).padStart(2, '0'); // Months are zero-based, add 1
            const day = String(minDOB.getDate()).padStart(2, '0');

            // Set the default value and minimum value in the input field
            const formattedDate = `${year}-${month}-${day}`;
            dateInput.value = formattedDate;
            dateInput.max = formattedDate; // Ensure user can't pick a date that makes them younger than 18
        }

        // Call the function when the page loads
        window.onload = setDOBRestrictions;
    </script>
@endsection
