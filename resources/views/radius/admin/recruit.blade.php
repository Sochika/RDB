@extends('layouts/layoutMaster')

@section('title', 'Recruits')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
    @livewireStyles
    {{-- @powerGridStyles --}}
    @livewireStyles
    <style>
        /* General styles for the rating container */
        .rating {
            display: inline-flex;
            direction: rtl;
            /* Reverse direction to handle star selection from left to right */
            font-size: 25px;
            /* Size of stars */
        }

        /* Hide radio buttons */
        .rating input {
            display: none;
        }

        /* Style for stars */
        .rating label {
            color: #ccc;
            /* Default star color (gray) */
            cursor: pointer;
            transition: color 0.2s;
            /* Smooth transition for color change */
        }

        /* Highlight stars when checked */
        .rating input:checked+label,
        .rating input:checked+label~label {
            color: gold;
            /* Color when star is selected (gold) */
        }

        /* Hover effect to preview star rating */
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
            /* Color of stars when hovered over */
        }

        /* Ensure the radio buttons and labels are aligned correctly */
        .rating input:checked~label {
            color: gold;
            /* Highlight all previous stars when a star is checked */
        }

        /* Optional: Adjust label spacing if needed */
        .rating label {
            margin: 0 2px;
            /* Add margin between stars */
        }

        /* CSS for smooth transition
                                                    tr.sub-row {
                                                        transition: height 0.3s ease;
                                                        overflow: hidden;
                                                        height: 0;
                                                    }

                                                    tr.sub-row.open {
                                                        height: auto;
                                                    } */
    </style>

    <style>
        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        /* CSS for smooth transition with hidden rows */
        tr.sub-row {
            display: none;
            transition: all 0.3s ease;
        }
    </style>


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
                            <span class="text-heading">Recruits</span><small style="color: rgb(179, 98, 24)" class="mb-0">
                                Total</small>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruits->count() }}</h4>
                                {{-- <p class="text-success mb-0">(+29%)</p> --}}
                            </div>

                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-users ti-26px"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Operatives </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruitsApproved->count() }}</h4>
                                {{-- <p class="text-danger mb-0">(-14%)</p> --}}
                            </div>
                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-user-check ti-26px"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Failed </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruitsFailed }}</h4>
                                {{-- <p class="text-success mb-0">(+18%)</p> --}}
                            </div>
                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-user-plus ti-26px"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="text-heading">Guardated </span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{ $recruitsGraduated }}</h4>
                                {{-- <p class="text-success mb-0">(+42%)</p> --}}
                            </div>
                        </div>
                        <a href="{{ route('admin.allRecruits') }}">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="ti ti-user-search ti-26px"></i>
                                </span>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-sm-3 col-xl-3">
        <a href="{{ route('market.recruit') }}"><button type="button" class="btn btn-primary">
                <span class="ti-xs ti ti-user me-2"></span>Add Recruit
            </button></a>
    </div>
    <p></p>
    <!-- Users List Table -->









    <div class="card container">
        <div class="card mb-4">
            <div class="card-datatable table-responsive">
                <!-- Header with Logo -->
                <h1>Unattended Recruit</h1>
                <div id="pdfHeader" style="display: none">
                    <img src="{{ asset('assets/logo/login_logo.png') }}" alt="Logo" style="height: 50px;">

                    <h1>Unattended Recruit</h1>
                    <p>Date: <span id="reportWeek"></span></p>
                    <p>Presenter: {{ Auth::user()->name }}</p>
                </div>

                <div>
                    {{-- <button id="exportBtn" class="btn btn-primary mb-4">Export to PDF</button> --}}
                    {{-- <input type="week" name="week" id="recruitsWeek" class="form-control mb-4"
                        value="{{ now()->format('Y-\WW') }}" max="{{ now()->format('Y-\WW') }}"> --}}
                </div>

                <table class="table container" id="staffTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Recruit</th>
                            {{-- <th>Phone Number</th> --}}
                            <th> Area Of Recruit <br>/ Area Sourced</th>
                            <th>Brought By</th>

                            <th colspan="4"> Note</th>
                            <th>Status</th>
                            {{-- @if (Auth::user()->level >= $level) --}}
                            <th>Added on</th>
                            <th>Action</th>

                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody id="staffTableBody">
                        @foreach ($recruits as $recruit)
                            <tr>
                                <!-- Column for recruit date formatted as weekday and day/month -->
                                <td>
                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}
                                </td>

                                <!-- Column for recruit name, gender, and phone number -->
                                <td>
                                    <a href="#">
                                        {{ $recruit->first_name }} {{ $recruit->last_name }} <br>
                                        {{ $recruit->gender }} <br>
                                        {{ $recruit->phone_number }}
                                    </a>
                                </td>

                                <!-- Area comparison: display sourced_area if different -->
                                <td>
                                    @if ($recruit->area == $recruit->sourced_area)
                                        {{ $recruit->area }}
                                    @else
                                        {{ $recruit->area }} <br> {{ $recruit->sourced_area }}
                                    @endif
                                </td>

                                <!-- User who created the recruit record -->
                                <td>{{ $recruit->user->name ?? '' }}</td>

                                <!-- Empty columns as placeholders -->
                                <td colspan="4">{{ '' }}</td>

                                <!-- Approval status (Pending, Operative, or Rejected) -->
                                <td>
                                    {{ $recruit->approve == 1 ? 'Pending' : ($recruit->approve == 3 ? 'Operative' : 'Rejected') }}
                                </td>

                                <!-- Date when recruit record was created -->
                                <td>
                                    {{ Carbon\Carbon::parse($recruit->created_at)->format('d/m/Y') }}
                                </td>

                                <!-- Button to toggle visibility of the sub-row -->
                                <td>
                                    <button class="toggle-btn" data-target="sub-row-{{ $recruit->id }}">&#43;</button>
                                </td>
                            </tr>
                            @forelse ($recruit->notes as $note)
                                <button class="toggle-btn" data-target="sub-row-{{ $recruit->id }}">&#43;</button>
                                <tr id="sub-row-{{ $recruit->id }}" class="sub-row" style="display:none;">


                                    <form action="{{ route('recruit.save') }}" method="POST" class="card-body">
                                        @csrf
                                        <!-- Hidden input fields for recruit and note IDs -->
                                        <input type="hidden" name="note_id" value="{{ $note->id ?? null }}">
                                        <input type="hidden" name="recruit_id" value="{{ $recruit->id }}">

                                        <!-- Can Read rating section -->
                                        <td>
                                            <label for="read_{{ $recruit->id }}">Can Read:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "read_{$recruit->id}",
                                                'value' => json_decode($note->record ?? '{}')->read ?? null,
                                            ])
                                        </td>

                                        <!-- Can Write rating section -->
                                        <td>
                                            <label for="write_{{ $recruit->id }}">Can Write:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "write_{$recruit->id}",
                                                'value' => json_decode($note->record ?? '{}')->write ?? null,
                                            ])
                                        </td>

                                        <!-- Communication rating section -->
                                        <td>
                                            <label for="communication_{{ $recruit->id }}">Communication:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "communication_{$recruit->id}",
                                                'value' =>
                                                    json_decode($note->record ?? '{}')->communication ?? null,
                                            ])
                                        </td>

                                        <!-- Exposure rating section -->
                                        <td>
                                            <label for="exposure_{{ $recruit->id }}">Exposure:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "exposure_{$recruit->id}",
                                                'value' => json_decode($note->record ?? '{}')->exposure ?? null,
                                            ])
                                        </td>

                                        <!-- Additional Information text area -->
                                        <td colspan="4">
                                            <label for="additional_info_{{ $recruit->id }}">Additional
                                                Information:</label><br>
                                            <textarea class="form-control" name="additional_info_{{ $recruit->id }}" rows="1">{{ $note->note ?? '' }}</textarea>
                                        </td>

                                        <!-- Form Given switch -->
                                        <td>
                                            <span class="switch-label">Form Given:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_given"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_given) && json_decode($note->record ?? '{}')->form_given == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Guarantors Returned switch -->
                                        <td id="form_returned{{ $recruit->id }}">
                                            <span class="switch-label">Guarantors Returned:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_returned"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_returned) && json_decode($note->record ?? '{}')->form_returned == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Rejected switch -->
                                        <td id="rejected_{{ $recruit->id }}">
                                            <span class="switch-label">Rejected:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_rejected"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_rejected) && json_decode($note->record ?? '{}')->form_rejected == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Submit button -->
                                        <td>
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <button class="toggle-btn" data-target="sub-row-{{ $recruit->id }}">&#43;</button>
                                <tr id="sub-row-{{ $recruit->id }}" class="sub-row" style="display:none;">


                                    <form action="{{ route('recruit.save') }}" method="POST" class="card-body">
                                        @csrf
                                        <!-- Hidden input fields for recruit and note IDs -->
                                        <input type="hidden" name="note_id">
                                        <input type="hidden" name="recruit_id" value="{{ $recruit->id }}">

                                        <!-- Can Read rating section -->
                                        <td>
                                            <label for="read_{{ $recruit->id }}">Can Read:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "read_{$recruit->id}",
                                            ])
                                        </td>

                                        <!-- Can Write rating section -->
                                        <td>
                                            <label for="write_{{ $recruit->id }}">Can Write:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "write_{$recruit->id}",
                                            ])
                                        </td>

                                        <!-- Communication rating section -->
                                        <td>
                                            <label for="communication_{{ $recruit->id }}">Communication:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "communication_{$recruit->id}",
                                            ])
                                        </td>

                                        <!-- Exposure rating section -->
                                        <td>
                                            <label for="exposure_{{ $recruit->id }}">Exposure:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "exposure_{$recruit->id}",
                                            ])
                                        </td>

                                        <!-- Additional Information text area -->
                                        <td colspan="4">
                                            <label for="additional_info_{{ $recruit->id }}">Additional
                                                Information:</label><br>
                                            <textarea class="form-control" name="additional_info_{{ $recruit->id }}" rows="1"></textarea>
                                        </td>

                                        <!-- Form Given switch -->
                                        <td id="form_given_{{ $recruit->id }}">
                                            <span class="switch-label">Form Given:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_given"
                                                    value="1" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Guarantors Returned switch -->
                                        <td id="form_returned_{{ $recruit->id }}">
                                            <span class="switch-label">Guarantors Returned:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_returned"
                                                    value="1" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Rejected switch -->
                                        <td id="rejected_{{ $recruit->id }}">
                                            <span class="switch-label">Rejected:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_rejected"
                                                    value="1" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>


                                        <!-- Submit button -->
                                        <td>
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforelse

                            {{-- @foreach ($recruit->notes as $note)
                                <button class="toggle-btn" data-target="sub-row-{{ $recruit->id }}">&#43;</button>
                                <tr id="sub-row-{{ $recruit->id }}" class="sub-row" style="display:none;">


                                    <form action="{{ route('recruit.save') }}" method="POST" class="card-body">
                                        @csrf
                                        <!-- Hidden input fields for recruit and note IDs -->
                                        <input type="hidden" name="note_id" value="{{ $note->id ?? null }}">
                                        <input type="hidden" name="recruit_id" value="{{ $recruit->id }}">

                                        <!-- Can Read rating section -->
                                        <td>
                                            <label for="read_{{ $recruit->id }}">Can Read:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "read_{$recruit->id}",
                                                'value' => json_decode($note->record ?? '{}')->read ?? null,
                                            ])
                                        </td>

                                        <!-- Can Write rating section -->
                                        <td>
                                            <label for="write_{{ $recruit->id }}">Can Write:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "write_{$recruit->id}",
                                                'value' => json_decode($note->record ?? '{}')->write ?? null,
                                            ])
                                        </td>

                                        <!-- Communication rating section -->
                                        <td>
                                            <label for="communication_{{ $recruit->id }}">Communication:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "communication_{$recruit->id}",
                                                'value' =>
                                                    json_decode($note->record ?? '{}')->communication ?? null,
                                            ])
                                        </td>

                                        <!-- Exposure rating section -->
                                        <td>
                                            <label for="exposure_{{ $recruit->id }}">Exposure:</label><br>
                                            @include('radius.partials.rating', [
                                                'name' => "exposure_{$recruit->id}",
                                                'value' => json_decode($note->record ?? '{}')->exposure ?? null,
                                            ])
                                        </td>

                                        <!-- Additional Information text area -->
                                        <td colspan="4">
                                            <label for="additional_info_{{ $recruit->id }}">Additional
                                                Information:</label><br>
                                            <textarea class="form-control" name="additional_info_{{ $recruit->id }}" rows="1">{{ $note->note ?? '' }}</textarea>
                                        </td>

                                        <!-- Form Given switch -->
                                        <td>
                                            <span class="switch-label">Form Given:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_given"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_given) && json_decode($note->record ?? '{}')->form_given == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Guarantors Returned switch -->
                                        <td>
                                            <span class="switch-label">Guarantors Returned:</span><br>
                                            <label class="switch switch-primary">
                                                <input type="checkbox" class="switch-input" name="form_returned"
                                                    value="1" @if (isset(json_decode($note->record ?? '{}')->form_returned) && json_decode($note->record ?? '{}')->form_returned == 1) checked @endif />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on"><i class="ti ti-check"></i></span>
                                                    <span class="switch-off"><i class="ti ti-x"></i></span>
                                                </span>
                                            </label>
                                        </td>

                                        <!-- Submit button -->
                                        <td>
                                            <button class="btn btn-primary" type="submit">Save</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach --}}
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <script>


        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to all toggle buttons
            document.querySelectorAll('.toggle-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const targetId = button.getAttribute('data-target'); // Get the target row's ID
                    const targetRow = document.getElementById(targetId); // Select the row

                    // Check if the target row exists
                    if (targetRow) {
                        if (targetRow.style.display === 'none' || targetRow.style.display === '') {
                            // Show the sub-row
                            targetRow.style.display = 'table-row';
                            button.innerHTML = '&#8722;'; // Change to minus (-)
                        } else {
                            // Hide the sub-row
                            targetRow.style.display = 'none';
                            button.innerHTML = '&#43;'; // Change to plus (+)
                        }
                    } else {
                        console.error('Target row not found:', targetId);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Toggle visibility of sub-rows
            // document.querySelectorAll('.toggle-btn').forEach(function(button) {
            //     button.addEventListener('click', function() {
            //         const target = document.getElementById(button.dataset.target);
            //         if (target.style.display === 'none') {
            //             target.style.display = 'table-row'; // Show sub-row
            //             button.innerHTML = '&#8722;'; // Change to minus (-)
            //         } else {
            //             target.style.display = 'none'; // Hide sub-row
            //             button.innerHTML = '&#43;'; // Change to plus (+)
            //         }
            //     });
            // });

            // 2. Handle form submission via AJAX
            document.querySelectorAll('.card-body form').forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent form from refreshing the page

                    const formData = new FormData(form);
                    const url = form.getAttribute('action');

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Record saved successfully!');
                            } else if (data.errors) {
                                let errorMessages = '';
                                for (let field in data.errors) {
                                    errorMessages +=
                                        `${field}: ${data.errors[field].join(', ')}\n`;
                                }
                                alert(errorMessages); // Show the validation errors
                            } else {
                                alert('There was an error saving the record.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to submit form.');
                        });
                });
            });

            // 3. Handle star rating interaction
            document.querySelectorAll('.rating input').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const ratingContainer = radio.closest('.rating');
                    // Clear all other stars
                    ratingContainer.querySelectorAll('label').forEach(function(label) {
                        label.classList.remove('selected');
                    });
                    // Highlight selected star
                    for (let i = radio.value; i > 0; i--) {
                        document.getElementById(`${radio.name}_star${i}`).nextElementSibling
                            .classList.add('selected');
                    }
                });
            });
        });
    </script>

    <script>
           $(document).ready(function() {
            // When the Form Given switch is clicked
            $(document).on('click', 'input[name="form_given"]', function() {
                let recruitId = $(this).closest('td').attr('id').split('_')[1]; // Get the recruit ID

                // Show the Guarantors Returned switch and hide the Rejected switch
                $('#form_returned_' + recruitId).show();
                $('#rejected_' + recruitId).hide();
            });

            // When the Rejected switch is clicked
            $(document).on('click', 'input[name="form_rejected"]', function() {
                let recruitId = $(this).closest('td').attr('id').split('_')[1]; // Get the recruit ID

                // Hide the Form Given and Guarantors Returned switches
                $('#form_given_' + recruitId).closest('td').hide();
                $('#form_returned_' + recruitId).hide();
            });
        });
        // Script to toggle sub-rows
        // document.querySelectorAll('.toggle-btn').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const targetRow = document.getElementById(this.dataset.target);
        //         if (targetRow.style.display === 'none' || targetRow.style.display === '') {
        //             targetRow.style.display = 'table-row';
        //             this.innerHTML = '&#8722;'; // Minus sign
        //         } else {
        //             targetRow.style.display = 'none';
        //             this.innerHTML = '&#43;'; // Plus sign
        //         }
        //     });
        // });
        // document.getElementById('main-table').addEventListener('click', function(event) {
        //     // Check if the clicked element is a toggle button
        //     if (event.target.classList.contains('toggle-btn')) {
        //         const button = event.target;
        //         const targetRow = document.getElementById(button.dataset.target);

        //         // Toggle the row visibility
        //         if (targetRow.style.display === 'none' || targetRow.style.display === '') {
        //             targetRow.style.display = 'table-row';
        //             button.innerHTML = '&#8722;'; // Minus sign
        //         } else {
        //             targetRow.style.display = 'none';
        //             button.innerHTML = '&#43;'; // Plus sign
        //         }
        //     }
        // });
    </script>


    {{--
<script>
  document.getElementById('recruitsWeek').addEventListener('change', function() {
      let selectedWeek = this.value;

      // Send an AJAX request to the server
      fetch('/get-week-recruits', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                      'content')
              },
              body: JSON.stringify({
                  week: selectedWeek
              })
          })
          .then(response => response.json())
          .then(data => {
              // Update the table body with the new data
              let tableBody = document.getElementById('staffTableBody');
              tableBody.innerHTML = ''; // Clear the existing data

              data.weekRecruits.forEach(recruit => {
                  let row = `
          <tr>
              <td>${new Date(recruit.recruit_date).toLocaleDateString('en-US', { weekday: 'long' })} <br>
                  ${new Date(recruit.recruit_date).toLocaleDateString('en-US', { day: 'numeric', month: 'long' })}
              </td>
              <td><a href="/staff-view/${recruit.id}">${recruit.first_name} ${recruit.last_name}</a></td>
              <td>${recruit.phone_number}</td>
              <td>${recruit.area}</td>
              <td>${recruit.area_sourced}</td>
              <td>${recruit.gender}</td>
              <td>${recruit.note}</td>
              <td>${recruit.approve}</td>
          </tr>
      `;
                  tableBody.insertAdjacentHTML('beforeend', row);
              });

              // Update the PDF header with the selected week
              document.getElementById('reportWeek').textContent = selectedWeek;
          })
          .catch(error => console.error('Error:', error));
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.14/jspdf.plugin.autotable.min.js"></script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
      const {
          jsPDF
      } = window.jspdf;

      document.getElementById('recruitsWeek').addEventListener('change', function() {
          const weekValue = this.value;
          const [year, week] = weekValue.split('-W');

          // Calculate the first and last day of the week
          const firstDayOfWeek = new Date(year, 0, (week - 1) * 7 + 1);
          let lastDayOfWeek = new Date(year, 0, (week - 1) * 7 + 7);

          // Get today's date
          const today = new Date();

          // Ensure lastDayOfWeek is not beyond today's date
          if (lastDayOfWeek > today) {
              lastDayOfWeek = today;
          }

          const formattedFirstDay = firstDayOfWeek.toLocaleDateString();
          const formattedLastDay = lastDayOfWeek.toLocaleDateString();

          document.getElementById('reportWeek').textContent =
              `${formattedFirstDay} - ${formattedLastDay}`;
      });

      document.getElementById('exportBtn').addEventListener('click', function() {
          const doc = new jsPDF();

          // Load the logo
          const logo = new Image();
          logo.src = "{{ asset('assets/logo/login_logo.png') }}"; // Replace with your logo path

          // When the logo is loaded, add it to the PDF
          logo.onload = function() {
              doc.addImage(logo, 'PNG', 10, 10, 25, 15); // Adjust the size and position as needed

              // Add title, date range, and presenter
              doc.text("Recruit This Week", 70, 20);
              doc.text(`Date: ${document.getElementById('reportWeek').textContent}`, 70, 30);
              doc.text(`Presenter: {{ Auth::user()->name }}`, 70, 40);

              // Get the table content
              const table = document.getElementById('staffTable');
              const tableData = doc.autoTableHtmlToJson(table);

              // Generate the PDF table
              doc.autoTable({
                  head: [tableData.columns],
                  body: tableData.data,
                  startY: 50,
              });

              // Save the PDF
              doc.save('recruit-this-week.pdf');
          };

          // Trigger change event to set initial reportWeek text
          document.getElementById('recruitsWeek').dispatchEvent(new Event('change'));
      });
  });
</script> --}}


@endsection
