<!-- Add New Staff Modal -->
<div class="modal fade" id="assignOperative" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Assign Beat</h4>
                    <p>Choose the best for operative.</p>
                </div>
                <form id="assignBeat" class="row g-6" action="{{ route('staff.assign') }}" method="POST">

                    @csrf
                    <input type="hidden" name="full_name" value="{{ $staff->first_name . ' ' . $staff->last_name }}">
                    <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                    <div class="col-sm-6">

                        <label class="form-label" for="chooseBeat">Choose Beat</label>
                        <select id="chooseBeat" name="beat_id" class="select2 form-select" aria-label="Choose Beat" required>
                            <option value=""> Choose Beat</option>
                            @foreach ($beats as $beat)
                                <option @if ($staff->beat_id == $beat->id) selected @endif value="{{ $beat->id }}">
                                    {{ $beat->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-6">

                        <label class="form-label beatBranch" for="chooseBeatBranch">Choose Location</label>
                        <select id="chooseBeatBranch" name="beat_branch_id" class="select2 form-select beatBranch"
                            aria-label="Choose Beat" required>
                            <option value="">Choose Branch</option>
                            @foreach ($beats as $beat)
                                <option @if ($staff->beat_id == $beat->id) selected @endif value="{{ $beat->id }}">
                                    {{ $beat->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="chooseShift">Choose Shift</label>
                        <select id="" name="shift_type_id" class="form-select" aria-label="Choose Shift" required>
                            <option value="">Choose Shift</option>
                            @foreach ($shiftypes as $shiftype)
                                <option value="{{ $shiftype->id }}">{{ $shiftype->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="setTime">Clockin Time</label>
                        <input type="datetime-local" name="shift_start" id="setTime" class="form-control" required>
                        {{-- <input type="datetime-local" name="" id=""> --}}
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label" for="setTime">ClockOut</label>
                        <input type="time" name="shift_end" id="setTime" class="form-control" readonly>
                    </div>
                    <div class="col-sm-6">
                        <div class="row row-bordered g-0">
                            <div class="col-xl-12 p-6">
                                <label class="switch switch-primary">
                                    <span class="switch-label">Permanent</span>
                                    <input type="checkbox" class="switch-input" name="main_assign" checked
                                        value="1" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>

                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-5">
                        <label class="form-label" for="setExpires">Shift Expire</label>
                        <input type="date" name="expires" id="setExpires" class="form-control" readonly>

                    </div>

                    <div class="col-sm-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
            <hr class="mx-4 my-2">
            @if (!$staff->beat == null)
                <div class="modal-body">
                    <p class="mb-0">Operative main beat</p>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex justify-content-center me-2 mt-3">
                            {{-- <sup class="h5 pricing-currency pt-1 mt-2 mb-0 me-1 text-primary">$</sup> --}}
                            <h5 class="display-8 mb-0 text-primary">{{ $staff->beat->name }}</h5>
                            <sub
                                class="h6 pricing-duration mt-auto mb-2 pb-1 text-body">/{{ $staff->shifts->shifttype->name ?? 'Day' }} <br>: {{ date('h:i A', strtotime($staff->shifts->shift_start ?? '--'))}}<br>: {{ date('d/m/y', strtotime($staff->shifts->start_date ?? '--'))}}</sub>
                        </div>


                        {{-- <button class="btn btn-label-danger mt-4">Cancel Assigment</button> --}}
                        <a href="javascript:;" class="btn btn-icon btn-text-danger cancel-assignment"
                            data-bs-toggle="tooltip" aria-label="Redeloy"
                            data-bs-original-title="Redeloy" data-shift-id="{{ $staff->shifts->id ?? 0 }}"
                            data-staff-id="{{ $staff->id ?? 0 }}">
                            <i class="ti-share ti-md"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-icon btn-text-danger delete-assignment"
                        data-bs-toggle="tooltip" aria-label="Delete Assignment"
                        data-bs-original-title="Delete Assignment" data-shift-id="{{ $staff->shifts->id ?? 0 }}"
                        data-staff-id="{{ $staff->id ?? 0 }}">
                        <i class="ti-trash ti-md"></i>
                    </a>


                    </div>
                </div>
            @endif
            @if ($staff->shiftsWithNoExpires()->count()>1)
                <div class="modal-body">
                    <p class="mb-0">Operative extra beat</p>

                    @foreach ($staff->shiftsWithNoExpires() as $shift)
                    {{-- @php
                    dd($staff->shiftsWithNoExpires());
                    @endphp --}}
                        @if ($shift->main_assign)
                            @continue
                        @endif
                        @if ($shift && $shift->beat)
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex justify-content-center me-2 mt-3">
                                    <h5 class="display-8 mb-0 text-primary">{{ $shift->beat->name }}</h5>
                                    <sub class="h6 pricing-duration mt-auto mb-2 pb-1 text-body">
                                        /{{ $shift->shiftType->name ?? 'Day' }} <br>: {{ date('h:i A', strtotime($shift->shift_start ?? '--'))}} <br>: {{ date('d/m/y', strtotime($shift->start_date ?? '--'))}}
                                    </sub>
                                    <a href="javascript:;" class="btn btn-icon btn-text-danger cancel-assignment"
                                    data-bs-toggle="tooltip" aria-label="Redeloy"
                                    data-bs-original-title="Redeloy" data-shift-id="{{ $shift->id }}"
                                    data-staff-id="0">
                                    <i class="ti ti-share ti-md"></i>
                                </a>
                                <a href="javascript:;" class="btn btn-icon btn-text-danger delete-assignment"
                                data-bs-toggle="tooltip" aria-label="Delete Assignment"
                                data-bs-original-title="Delete Assignment" data-shift-id="{{ $shift->id }}"
                                data-staff-id="0">
                                <i class="ti ti-trash ti-md"></i>
                            </a>
                                </div>



                            </div>
                        @else
                            <div class="alert alert-warning mt-3">Invalid shift data</div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Add New Staff Modal -->
