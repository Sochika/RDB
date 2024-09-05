{{-- <!-- Modal -->
<div class="modal fade" id="beatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
        <div class="modal-content">
            <div class="modal-body">

              {{$beats}}
                @isset($beat)
                    @foreach ($beat->beatBranches as $beatBranch)
                        <h3>{{ $beatBranch->name }}</h3>
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
                                @foreach ($beatBranch->getNearbyStaff((int) $staff_radius) as $staff)
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
</div> --}}

{{-- <div class="modal fade" id="beatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
      <div class="modal-content">
          <div class="modal-body">
              <div id="modalContent"></div>
          </div>
      </div>
  </div>
</div> --}}
<div class="modal-onboarding modal fade animate__animated" id="beatModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        {{-- <a class="text-muted close-label" href="javascript:void(0);" data-bs-dismiss="modal">Skip Intro</a> --}}
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-content">
        <div class="modal-body">
            <div id="modalContent"></div>
        </div>
    </div>
    </div>
  </div>
</div>
