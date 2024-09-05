@extends('layouts/layoutMaster')

@section('title', 'Recruits')

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
                                    data-bs-target="#form-tabs-myrecruit" aria-controls="form-tabs-myrecruit" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">My Recruits</span></button>
                            </li>

                            <li class="nav-item">
                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-alrecruit" aria-controls="form-tabs-alrecruit" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">All Recruits</span></button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-beats" aria-controls="form-tabs-beats" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">Operatives</span></button>
                            </li>

                            <li class="nav-item">
                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-failed" aria-controls="form-tabs-failed" role="tab"
                                    aria-selected="false"><span class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">Failed</span></button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#form-tabs-terminated" aria-controls="form-tabs-terminated"
                                    role="tab" aria-selected="false"><span
                                        class="ti ti-link ti-lg d-sm-none"></span><span
                                        class="d-none d-sm-block">Graduated</span></button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content p-0">



                        <div class="tab-pane fade active show" id="form-tabs-myrecruit" role="tabpanel">

                            <div>
                                <table class="table container" id="staffTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Recruit</th>
                                            <th>Phone Number</th>
                                            <th> Area Of Recruit</th>
                                            <th> Area Sourced</th>
                                            <th>Gender</th>
                                            <th> Note</th>
                                            <th>Status</th>
                                            @if (Auth::user()->level >= $level)
                                                <th>By</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="staffTableBody">
                                        @foreach ($myrecruits as $recruit)
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}</td>
                                                <td><a href="{{ route('staff-view', ['id' => $recruit->id]) }}">{{ $recruit->first_name }}
                                                        {{ $recruit->last_name }}</a></td>
                                                <td>{{ $recruit->phone_number }}</td>
                                                <td>{{ $recruit->area }}</td>
                                                <td>{{ $recruit->area }}</td>
                                                <td>{{ $recruit->gender }}</td>
                                                <td>{{ $recruit->note }}</td>
                                                <td>{{ $recruit->approve }}</td>
                                                @if (Auth::user()->level >= $level)
                                                    <td>{{ $recruit->user->name ?? '' }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="form-tabs-alrecruit" role="tabpanel">

                            <div>
                                <table class="table container" id="staffTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Recruit</th>
                                            <th>Phone Number</th>
                                            <th> Area Of Recruit</th>
                                            <th> Area Sourced</th>
                                            <th>Gender</th>
                                            <th> Note</th>
                                            <th>Status</th>
                                            {{-- @if (Auth::user()->level >= $level) --}}
                                            <th>By</th>
                                            {{-- @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody id="staffTableBody">
                                        @foreach ($recruits as $recruit)
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}</td>
                                                <td><a href="{{ route('staff-view', ['id' => $recruit->id]) }}">{{ $recruit->first_name }}
                                                        {{ $recruit->last_name }}</a></td>
                                                <td>{{ $recruit->phone_number }}</td>
                                                <td>{{ $recruit->area }}</td>
                                                <td>{{ $recruit->area }}</td>
                                                <td>{{ $recruit->gender }}</td>
                                                <td>{{ $recruit->note }}</td>
                                                <td>{{ $recruit->approve }}</td>
                                                {{-- @if (Auth::user()->level >= $level) --}}
                                                <td>{{ $recruit->user->name ?? '' }}</td>
                                                {{-- @endif --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="form-tabs-beats" role="tabpanel">
                            <div>
                                <table class="table container" id="staffTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Recruit</th>
                                            <th>Phone Number</th>
                                            <th> Area Of Recruit</th>
                                            <th> Area Sourced</th>
                                            <th>Gender</th>
                                            <th> Note</th>
                                            <th>Status</th>
                                            @if (Auth::user()->level >= $level)
                                                <th>By</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="staffTableBody">
                                        @foreach ($myrecruits as $recruit)
                                            <tr>
                                                <td>{{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}</td>
                                                <td><a href="{{ route('staff-view', ['id' => $recruit->id]) }}">{{ $recruit->first_name }}
                                                        {{ $recruit->last_name }}</a></td>
                                                <td>{{ $recruit->phone_number }}</td>
                                                <td>{{ $recruit->area }}</td>
                                                <td>{{ $recruit->area }}</td>
                                                <td>{{ $recruit->gender }}</td>
                                                <td>{{ $recruit->note }}</td>
                                                <td>{{ $recruit->approve }}</td>
                                                @if (Auth::user()->level >= $level)
                                                    <td>{{ $recruit->user->name ?? '' }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="form-tabs-failed" role="tabpanel">
                            <div>
                                <table class="table container" id="staffTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Recruit</th>
                                            <th>Phone Number</th>
                                            <th> Area Of Recruit</th>
                                            <th> Area Sourced</th>
                                            <th>Gender</th>
                                            <th> Note</th>
                                            <th>Status</th>
                                            @if (Auth::user()->level >= $level)
                                                <th>By</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="staffTableBody">
                                        {{-- @foreach ($myrecruits as $recruit)
                                     <tr>
                                <td>{{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}</td>
                                <td><a href="{{ route('staff-view', ['id' => $recruit->id]) }}">{{ $recruit->first_name }}
                                        {{ $recruit->last_name }}</a></td>
                                <td>{{ $recruit->phone_number }}</td>
                                <td>{{ $recruit->area }}</td>
                                <td>{{ $recruit->area }}</td>
                                <td>{{ $recruit->gender }}</td>
                                <td>{{ $recruit->note }}</td>
                                <td>{{ $recruit->approve }}</td>
                                @if (Auth::user()->level >= $level)
                                <td>{{ $recruit->user->name ?? ''  }}</td>
                            @endif
                            </tr>
                                @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="form-tabs-terminated" role="tabpanel">
                            <div>
                                <table class="table container" id="staffTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Recruit</th>
                                            <th>Phone Number</th>
                                            <th> Area Of Recruit</th>
                                            <th> Area Sourced</th>
                                            <th>Gender</th>
                                            <th> Note</th>
                                            <th>Status</th>
                                            @if (Auth::user()->level >= $level)
                                                <th>By</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody id="staffTableBody">
                                        {{-- @foreach ($myrecruits as $recruit)
                                   <tr>
                                <td>{{ Carbon\Carbon::parse($recruit->recruit_date)->format('l') }} <br>
                                    {{ Carbon\Carbon::parse($recruit->recruit_date)->format('jS F') }}</td>
                                <td><a href="{{ route('staff-view', ['id' => $recruit->id]) }}">{{ $recruit->first_name }}
                                        {{ $recruit->last_name }}</a></td>
                                <td>{{ $recruit->phone_number }}</td>
                                <td>{{ $recruit->area }}</td>
                                <td>{{ $recruit->area }}</td>
                                <td>{{ $recruit->gender }}</td>
                                <td>{{ $recruit->note }}</td>
                                <td>{{ $recruit->approve }}</td>
                                @if (Auth::user()->level >= $level)
                                <td>{{ $recruit->user->name ?? ''  }}</td>
                            @endif
                            </tr>
                              @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
