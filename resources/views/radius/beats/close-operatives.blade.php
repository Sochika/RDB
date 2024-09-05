@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Operatives Beats')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('content')
<div class="card">
  <div class="modal fade" id="beatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
        <div class="modal-content">
            <div class="modal-body">

              {{$beat}}
                @isset($beat)
                    @foreach ($beat->beatBranches as $beatBranche)
                        <h3>{{ $beatBranche->name }}</h3>
                        <table>
                            <thead>
                                <th>Name</th>
                                <th>Number</th>
                                <th>location</th>
                                <th>Current Beat</th>
                                <th>Shift</th>
                                <th>Off?</th>
                            </thead>
                            <tbody>
                                @foreach ($beatBranche->getNearbyStaff((int) $staff_radius) as $staff)
                                    <tr>
                                        <td>{{ $staff->first_name ?? ''}} {{ $staff->last_name }}</td>
                                        <td>{{ $staff->phone_number ?? ''}}</td>
                                        <td>{{ $staff->area ?? '' }}</td>
                                        <td>{{ $staff->beat->name ?? ''}}</td>
                                        <td>{{ $staff->shifts->shift_end ?? ''}}</td>
                                        <td>{{ $staff->shifts->shift_on ?? ''}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endforeach
                @endisset


            </div>

        </div>
    </div>
  </div>
</div>
@endsection
